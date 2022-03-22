<?php

namespace App\Http\Resources;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MessageResource ;
use App\Http\Resources\PhotoResource ;
use App\Client ;
use App\Message;
use App\ProductReview;

class SessionResource extends JsonResource
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
        $id = Auth::user()->id;
        $buyer = Client::with('fcm_tokens')->findorfail($this->buyer_id); 
        $seller = Client::with('fcm_tokens')->findorfail($this->seller_id);
        $message = Message::where('session_id', $this->id )->where('is_read', 0)->get();
        $message2 = Message::where('session_id', $this->id )->where('message_status', '!=', $id)->orWhereNull('message_status')->get();
        // $product_review = ProductReview::get();

        // $message1 = Message::where('session_id', $this->id )->orderBy('created_at')->get();
        // $product_review1 = ProductReview::where('seller_id', $this->seller_id)->where('is_read', 0)->orderBy('created_at')->get();
     
        return [
            'session_id'=> $this->id,
            'session_name'=> $this->sessions_name,
            'item_id' => $this->item->id,
            'item_name' => $this->item->title,
            'item_price' => $this->item->price,
            'users' => [$buyer , $seller],
            'photo' =>isset($this->item->photos[0]) ? new PhotoResource($this->item->photos[0]) : '' , 
            // 'messages' => $this->messages ? MessageResource::collection($this->messages) : ''  ,
            // 'product_review' => $product_review,
            'messages' => count($message),
            'messages_content' => $message2,
            // 'notification' => count($message) + count($product_review),
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id ,
            'buyer_social_profile' => $buyer->social_profile ,
            'seller_social_profile' => $seller->social_profile ,
            // 'seller_fcm_token' => $seller->fcm_tokens ,
            // 'buyer_fcm_token' => $buyer->fcm_tokens ,
        ];
    }
}
