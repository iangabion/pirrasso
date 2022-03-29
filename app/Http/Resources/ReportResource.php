<?php

namespace App\Http\Resources;
use App\Http\Resources\ItemResource ;
use App\Http\Resources\ClientResource ;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Client ;
use App\Items ;

class ReportResource extends JsonResource
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

       $item = Items::findorfail($this->item_id);
       $user = Client::findorfail($this->user_id);

       return [
        'user'=> $user,
        'item'=> $item,
        'reason'=>$this->reason,
        'description'=>$this->description,
       ];
    }
}
