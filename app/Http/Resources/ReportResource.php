<?php

namespace App\Http\Resources;
use App\Http\Resources\ItemResource ;
use App\Http\Resources\ClientResource ;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Client ;
use App\Items ;
use App\Report ;
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
        // $client = Client::where('client_id', Auth::id()); 
        $report = Report::where('item_id', $this->id)->get();
        $items = Items::with('itemReport')->get();
        // $reviews = ProductReview::where('items_id', $this->id)->get();
        // $reviews = Client::join('product_reviews','clients.id','=','product_reviews.buyer_id')->where('')->get();
        // $reviews2 = ProductReviewResource::collection($reviews);
        return [
            'id'=> $this->id,
            'item' => $items,
            'description'=> $this->description,
            'number_of_report'=>  $this->report_status,
            'report'=> $report

            // 'rating'=>$this->rating,
            // 'review_description' => $this->review_description,

        ];
    }
}
