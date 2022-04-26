<?php

namespace App\Http\Resources;
use App\Client;
use App\Items;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $users = Client::where('id', $this->id)->first();
        $items = Items::where('id', $this->id)->first();

        return [
            'user' => $users,
            'items' => $items,
            'quantity' => $this->quantity,
        ];
    }
}
