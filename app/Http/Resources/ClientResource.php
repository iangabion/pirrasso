<?php

namespace App\Http\Resources;

use App\Block;
use App\Client;
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
        // $client = Client::first('full_name');
        $blocked = Block::where('user_id', $this->id)->get();
        $im_blocked = Block::where('blocked_user_id', $this->id)->get();
        return [
            'id'=> $this->id,
            // 'full_name'=> $client,
            'full_name'=> $this->full_name,
            'mobile'=> $this->mobile,
            'bio'=> $this->bio,
            'birthday'=> $this->birthday,
            'gender'=> $this->gender,
            'email'=> $this->email,
            'username'=> $this->username,
            'social_id'=> $this->social_id,
            'password'=> $this->password,
            'profile_pic'=>$this->image ,
            'fcm_token'=>$this->fcm_tokens ,
            'is_validated' => $this->is_verified == 0 ? 0 : 1,
            'social_profile'=>$this->social_profile ,
            'total_report'=>$this->is_report,
            'blocked_user'=>$blocked,
            'im_blocked'=>$im_blocked,
            
        ];
    }
}
