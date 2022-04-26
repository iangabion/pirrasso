<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Client;
use Illuminate\Support\Facades\Auth;
class DeliveryAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
    
        $user = Client::where('id', $this->user_id)->first();

        return [
            'user' =>$user,
            'address' => $this->address,
            'phone' => $this->phone,
            'postal' => $this->postal_code,
            'street' => $this->street,
            'label_as' => $this->label_as,
        ];
    }
}
