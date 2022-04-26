<?php

namespace App\Http\Resources;
use App\Clients;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return parent::toArray($request);

        $user = Client::where('user_id', $this->id)->first();

        return [
            'user' => $user,
            'address' => $this->address,
            'phone' => $this->phone,
            'postal' => $this->postal_code,
            'street' => $this->street,
            'label_as' => $this->label_as,
        ];
    }
}
