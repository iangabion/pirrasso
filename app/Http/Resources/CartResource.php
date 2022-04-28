<?php

namespace App\Http\Resources;
use App\Client;
use App\Items;
use App\Photos;
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
        $users = Client::where('id', $this->user_id)->first();
        $items = Items::where('id', $this->item_id)->first();
        $photos = Photos::where('items_id', $this->item_id)->get();

        return [
            'user' => $users,
            'cart' => $items,
            'quantity' => $this->quantity,
            'images' => $photos,
        ];
    }
}
