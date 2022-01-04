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
