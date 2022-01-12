<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductReview;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    //

    public function store(Request $request){
        $review = new ProductReview;

        $review->solds_id = $request->solds_id;
        $review->buyer_id = $request->buyer_id;
        $review->seller_id = $request->seller_id;
        $review->items_id = $request->items_id;
        $review->rating = $request->rating;
        $review->is_read = 0;
        $review->review_description = $request->review_description;
        
        $review->save();
        return response()->json($review);
    }

    public function update_review($id,Request $request)
    {

        // $request->validate([
        //     'rating'=> ['required'],
        //     'review_description'=> ['required'],
           
        // ]);
            $review_update= ProductReview::find($id);
            // $review->solds_id = $request->solds_id;
            // $review->buyer_id = $request->buyer_id;
            // $review->seller_id = $request->seller_id;
            // $review->items_id = $request->items_id;
            $review_update->rating = $request->rating;
            $review_update->review_description = $request->review_description;
            $review_update->save();

            return $review_update;

       
    }

    public function destroy($id)
    {
       
        $review = ProductReview::find($id);
        $review->delete();
        return response()->json("Record deleted");
    }

    public function getUnread(){
        $review = ProductReview::where('seller_id', Auth::id())
                    ->where('is_read',0)
                    ->count();
        return $review;
    }

    public function updateRead(){
        return ProductReview::where('seller_id',Auth::id())
                 ->update(['is_read'=>1]);
    }
    

    
}
