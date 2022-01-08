<?php

namespace App\Http\Controllers;

use App\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    //
    public function index(){
        return Promotion::get();
    }

    public function store(Request $request){
        $ads = new Promotion;
        $ads->title = $request->title;
        $ads->link = $request->link;
        if($request->ads_pic){
            $image = $request->ads_pic;  // your base64 encoded
            // list($type, $image) = explode(';', $image);
            // list(, $image)      = explode(',', $image);
            $data = base64_decode($image);
            $imageName = date("YmdHis"). '.' . 'jpeg';
            file_put_contents(public_path() . '/' . 'images/promotion/' . $imageName, $data);

            $ads->image = $imageName ;
        }
        $ads->save();
        return $ads;

    }

    public function update(Request $request, $id){
        $ads = Promotion::find($id);
        $ads->title = $request->title;
        $ads->link = $request->link;
        $ads->save();
        return $ads;
    }
    public function destroy($id){
        $ads = Promotion::find($id);
        $ads->delete();
        return response()->json("Ads Deleted");
    }
    
}
