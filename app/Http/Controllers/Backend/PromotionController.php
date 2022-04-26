<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Promotion;
class PromotionController extends Controller
{

    public function index()
    {
            $q = Promotion::where('is_approved', 1)->get();
            return $q;
    }
    public function pendingPromo(){
        $q = Promotion::where('is_approved', 0)->get();
        return $q;
    }


    public function approve(Request $request){
       return Promotion::where('id', $request->id)
                    ->update([
                        'is_approved' => 1
                    ]);
      
    }
    public function remove(Request $request){
        Promotion::where('id', $request->id)
                    ->delete();
        return 'Success';
    }

}