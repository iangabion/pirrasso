<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth ;

class ClientResource extends JsonResource
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
        return [
            'id'=> $this->id,
            'first name'=> $this->first_name,
            'last name'=> $this->last_name,
            'full_name' =>$this->full_name,
            'mobile'=> $this->mobile,
            'email'=> $this->email,
            'username'=> $this->username,
            'password'=> $this->password,
            'profile_pic'=>$this->image ,
            'fcm_token'=>$this->fcm_token ,
            'is_validated' => $this->is_verified == 0 ? 0 : 1,
        ];
    }
}
