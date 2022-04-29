<?php

namespace App\Http\Controllers;
use App\Cart;
use Illuminate\Support\Facades\Auth ;
use App\Http\Resources\CartResource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function index(){
        $cart = Cart::where('user_id', Auth::user()->id)->with('item_cart')->get();
        return CartResource::collection($cart);
    }

    public function add_cart(Request $request){
        $cart = new Cart();
        $cart->user_id = Auth::user()->id;
        $cart->item_id = $request->item_id;
        $cart->quantity = $request->quantity;
        $cart->save();

        return new CartResource($cart);
    }
    public function edit_cart(Request $request, $id){
        $cart = Cart::findorfail($id);
        $cart->user_id = Auth::user()->id;
        $cart->item_id = $request->item_id;
        $cart->quantity = $request->quantity;
        $cart->save();
        return new CartResource($cart);
    }

    public function delete_cart($id){
        $cart = Cart::find($id)->delete();
        return 'Success';
        
    }
}
