<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ClientResource ;
use App\Client ;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $client = Client::find($this->user_id);
        return [
            'session_id'=> $this->session_id,
            'message_id'=> $this->id,
            'message' => $this->message,
            'sender_id' => $client->id,
            'sender' => $client->fullname,
            'sender_image' => $client->image,
            'is_read' => $this->is_read,
            'send_at' => $this->created_at ,
            'updated_at' => $this->updated_at ,
        ];
    }
}
