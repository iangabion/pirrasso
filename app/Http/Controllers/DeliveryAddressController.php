<?php

namespace App\Http\Controllers;

use App\DeliveryAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth ;
use App\Http\Resources\DeliveryAddressResource;
use Illuminate\Http\Request;

class DeliveryAddressController extends Controller
{
    //

    public function get_myAddress(){
        $address = DeliveryAddress::where('user_id', Auth::user()->id)->get();
        return DeliveryAddressResource::collection($address);
    }

    public function add_myAddress(Request $request){
        $address = new DeliveryAddress();
        $address->user_id = Auth::user()->id;
        $address->address = $request->address;
        $address->phone = $request->phone;
        $address->postal_code = $request->postal_code;
        $address->street = $request->street;
        $address->label_as = $request->label_as;
        $address->save();

        return DeliveryAddress::collection($address);
    }

    public function edit_myAddress(Request $request, $id){
        $address = DeliveryAddress::findorfail($id);
        $address->user_id = $request->user_id;
        $address->address = $request->address;
        $address->phone = $request->phone;
        $address->postal_code = $request->postal_code;
        $address->street = $request->street;
        $address->label_as = $request->label_as;
        $address->save();
        return DeliveryAddress::collection($address);
    }

    public function delete_myAddress($id){
        $address = DeliveryAddress::findorfail($id)->delete();
        return 'Success';
    }
}
