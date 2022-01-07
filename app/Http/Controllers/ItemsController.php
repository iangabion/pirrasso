<?php

namespace App\Http\Controllers;

use App\Items;
use App\Photos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Resources\SoldResource;
use Illuminate\Support\Facades\Auth ;
use App\Sold;
use App\Client;
use App\Apartment ;
use App\Http\Resources\PhotoResource;
use App\Vehicle ;


class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Items::where('stock','>',0)->orderBy('created_at', 'desc')->paginate(8);
        return  ItemResource::collection($items) ;
    }

    public function all_items(){
        $items = Items::with('reviews')->where('stock','>',0)->orderBy('items.created_at', 'desc')->get();
        return $items;
        return  ItemResource::collection($items) ;
    }

    public function getStarRating(Request $request) {
        // return round($this->rating()->avg('rating'),1);
        // $starcountsum = Items::with('reviews')->sum('product_reviews.rating');
        // $average = $starcountsum/$this->reviews()->count();
        // return $average; 

        // $starcountsum = Items::join('product_reviews', 'items.id', '=', 'product_reviews.items_id')
        //                     ->groupBy('items_id')
        //                     ->selectRaw('avg(rating) as sumrate, items_id')
        //                     // ->where('product_reviews.items_id', $request->id)
        //                     ->get();

        $starcountsum = Items::with('reviews')->get();
        // $starcountsum = $this->all_items();
        // return $starcountsum->with($this->all_items());
        return $starcountsum;

        // Items::with('reviews')->where('id',$id)->selectRaw('SUM(rating)/COUNT(items_id) AS avg_rating')->first()->avg_rating();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getsold_items()
    {
        $sold = Sold::where('seller_id', Auth::user()->id)->get();
        return SoldResource::collection($sold);
    }
    public function getbought_items()
    {
        $sold = Sold::where('buyer_id', Auth::user()->id)->get();
        return SoldResource::collection($sold);
    }

    public function sold(Request $request)
    {
        $validatedData = $request->validate([
            'buyer_id' => 'required',
            'seller_id' => 'required',
            'item_id' => 'required',
        ]);

        $sold = new Sold();
        $sold->seller_id =  $request->input('seller_id');
        $sold->item_id =  $request->input('item_id');   
        $sold->buyer_id =  $request->input('buyer_id');
        $sold->quantity =  $request->input('quantity');
        $sold->save();
        return $sold;
    }

    public function changeStatus(Request $request)
    {
        $sold = Sold::findorfail($request->id);
        $sold->status_id = $request->status_id;
        $sold->save();

        return $sold;
    }

    public function unsold($id)
    {
        $sold = Sold::findorfail($id);
        $sold->delete();
        return response('unsold',200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    // {
    //     // return $request->images ;
    //     $validatedData = $request->validate([
    //         'title' => 'required',
    //         'price' => 'required',
    //         'description' => 'nullable',
    //         'location' => 'nullable',
    //         'latitude' => 'nullable|numeric',
    //         'longitude' => 'nullable|numeric',
    //         'stock' => 'required',
    //         'status_id' => 'required',
    //         'category_id' => 'nullable',
    //         'subcategory_id' => 'nullable',
    //         'images' => 'nullable',
    //         'show_number' => 'nullable',
    //         'apartment' => 'nullable',
    //         'vehicles' => 'nullable',

    //          // added Fields
    //          'is_urgent' => 'nullable',
    //          'is_displayed' => 'nullable',

    //     ]);
    //     if($validatedData) {
    //         $item = new Items();
    //         $item->title =  $request->input('title');
    //         $item->price =  $request->input('price');
    //         $item->description =  $request->input('description');
    //         $item->location =  $request->input('location');
    //         $item->latitude =  $request->input('latitude');
    //         $item->longitude =  $request->input('longitude');
    //         $item->stock =  $request->input('stock');
    //         $item->show_number =  $request->input('show_number');
    //         $item->status_id =  $request->input('status_id');
    //         $item->category_id =  $request->input('category_id');
    //         $item->subcategory_id =  $request->input('subcategory_id');
    //         $item->client_id = Auth::user()->id;
    //         $item->save();


    //         $photo = new Photos();
    //         $image = $request->input('images');  // your base64 encoded
    //         list($type, $image) = explode(';', $image);
    //         list(, $image)      = explode(',', $image);
    //         $data = base64_decode($image);
    //         $imageName = $photo->filename. time() . '_subcat.jpeg';
    //         file_put_contents(public_path() . '/' . 'images/' . $imageName, $data);
    //         $photo->filename = $imageName ;
    //         $photo->save();

    //         // added Fields



    //         if($item ) {
    //             if($request->input('vehicles')){
    //                 $this->add_vehicles($item ,  $request->input('vehicles'));
    //             }
    //             if($request->input('apartment')){
    //                 $this->add_apartments($item ,  $request->input('apartment'));
    //             }
    //         }
    //         // return new ItemResource($item);
    //         return "success";
    //     }
    // }

// old up
// new down

    {
        // $validatedData = $request->validate([
        //             'title' => 'required',
        //             'price' => 'required',
        //             'description' => 'nullable',
        //             'location' => 'nullable',
        //             'latitude' => 'nullable|numeric',
        //             'longitude' => 'nullable|numeric',
        //             'stock' => 'required',
        //             'status_id' => 'required',
        //             'category_id' => 'nullable',
        //             'subcategory_id' => 'nullable',
        //             'images' => 'nullable',
        //             'show_number' => 'nullable',
        //             'apartment' => 'nullable',
        //             'vehicles' => 'nullable',
        //              // added Fields
        //              'is_urgent' => 'nullable',
        //              'is_displayed' => 'nullable',
        //         ]);

             $item = new Items();
                $item->title =  $request->input('title');
                $item->price =  $request->input('price');
                $item->description =  $request->input('description');
                $item->location =  $request->input('location');
                $item->latitude =  $request->input('latitude');
                $item->longitude =  $request->input('longitude');
                $item->stock =  $request->input('stock');
                $item->show_number =  $request->input('show_number');
                $item->status_id =  $request->input('status_id');
                $item->category_id =  $request->input('category_id');
                $item->subcategory_id =  $request->input('subcategory_id');
                $item->client_id = Auth::user()->id;
                $item->save();
            
                $photo = new Photos();
                $photo->items_id = $item->id;
                //
                    if($request->input('images')){
                      $image = $request->input('images');  // your base64 encoded
                        list($type, $image) = explode(';', $image);
                        list(, $image)      = explode(',', $image);
                        $data = base64_decode($image);
                        $imageName = time() . '.jpeg';
                        file_put_contents(public_path() . '/' . 'images/' . $imageName, $data);
                        $photo->filename = $imageName ;
                    };
                $photo->imageable_id = 0;
                $item->photos()->save($photo);

                if($item ) {
                                if($request->input('vehicles')){
                                    $this->add_vehicles($item ,  $request->input('vehicles'));
                                }
                                if($request->input('apartment')){
                                    $this->add_apartments($item ,  $request->input('apartment'));
                                }
                }
            // return "success";
            return new ItemResource($item);
    }

    public function add_photos(Request $request){
        $item = Items::findorfail($request->id);
        if($request->input('images')){
            $this->process_images($request->images ,$item);
        }
        return new PhotoResource($item) ;
    }

    public function add_apartments($item , $data){

        $apartments =  Apartment::findOrNew(isset($data['id']) ?$data['id'] : ''  );
        $apartments->item_id = $item->id ;
        $apartments->type = isset($data['type'] ) ?$data['type'] :null ;
        $apartments->types_type = isset( $data['types_type']) ? $data['types_type'] : null ;
        $apartments->is_selling = isset($data['is_selling']) ? $data['is_selling'] : null ;
        $apartments->room_count = isset($data['room_count'] ) ? $data['room_count'] : null;
        $apartments->is_far_from_city = isset($data['is_far_from_city']) ? $data['is_far_from_city'] : null ;
        $apartments->height = isset($data['height']) ? $data['height'] : null ;
        $apartments->width = isset($data['width']) ? $data['width'] : null ;
        $apartments->save() ;

    }

    public function add_vehicles($item , $data) {
        $vehicle  =  Vehicle::findOrNew(isset($data['id']) ?$data['id'] : ''  );
        $vehicle->item_id = $item->id ;
        $vehicle->type =isset($data['type'] ) ?$data['type'] :null;
        $vehicle->types_type = isset($data['types_type']) ? $data['types_type'] : null ;
        $vehicle->is_selling = isset($data['is_selling']) ? $data['is_selling'] :null;
        $vehicle->fuel = isset($data['fuel']) ? $data['fuel'] : null ;
        $vehicle->kilometer = isset($data['kilometer']) ? $data['kilometer'] : null ;
        $vehicle->can_offroad = isset($data['can_offroad']) ? $data['can_offroad'] : null ;
        $vehicle->save();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Items::findorfail($id);
        return new ItemResource($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'location' => 'required',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'stock' => 'required',
            'status_id' => 'required',
            'category_id' => 'nullable',
            'subcategory_id' => 'nullable',
            'images' => 'nullable',
            'show_number' => 'nullable',
        ]);

        if($validatedData) {
            $item = Items::findorfail($request->id);
            $item->title =  $request->input('title');
            $item->price =  $request->input('price');
            $item->description =  $request->input('description');
            $item->location =  $request->input('location');
            $item->latitude =  $request->input('latitude');
            $item->longitude =  $request->input('longitude');
            $item->stock =  $request->input('stock');
            $item->show_number =  $request->input('show_number');
            $item->status_id =  $request->input('status_id');
            $item->category_id =  $request->input('category_id');
            $item->subcategory_id =  $request->input('subcategory_id');
            $item->client_id = Auth::user()->id;

            $item->save();
            if($item ) {
                if($request->input('vehicles')){
                    $this->add_vehicles($item ,  $request->input('vehicles'));
                }
                if($request->input('apartment')){
                    $this->add_apartments($item ,  $request->input('apartment'));
                }
            }
            return new ItemResource($item);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Items $items)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $item = Items::findorfail($id);
        $item->delete();
        return 'deleted' ;
    }

    public function process_images($images , $item){
        if($images ){
            $i=0;
            foreach($images as $img) {
                if($img !=null){
                $photo = new Photos();
                $i +=1;

                $image = $img;  // your base64 encoded
                list($type, $image) = explode(';', $image);
                list(, $image)      = explode(',', $image);
                $data = base64_decode($image);
                $imageName = date("YmdHis").$i . '_'.$item->id . '.jpeg';
                file_put_contents(public_path() . '/' . 'images/items/' . $imageName, $data);

                $photo->filename = $imageName ;
                $photo->items_id = $item->id ;
                $photo->save();
            }
            }
        }


    }
    public function search(Request $request){
        $items = Items::query();
        if($request->input('searchkey') != ""){
            $keyword = $request-> input('searchkey');
            $items->where(function($query) use($keyword){
                $query  ->where('title', 'LIKE', "%$keyword%")
                        ->orWhere('description', 'LIKE', "%$keyword%");
            });
        };
        return $items->get();
    }

    public function storeDraft(Request $request)
    {
     
        $validatedData = $request->validate([
          
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'location' => 'required',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'stock' => 'required',
            'status_id' => 'required',
            'category_id' => 'nullable',
            'subcategory_id' => 'nullable',
            'images' => 'nullable',
            'show_number' => 'nullable',
        ]);

        if($validatedData) {
            $item = new Items;
            $item->title =  $request->input('title');
            $item->price =  $request->input('price');
            $item->description =  $request->input('description');
            $item->location =  $request->input('location');
            $item->latitude =  $request->input('latitude');
            $item->longitude =  $request->input('longitude');
            $item->stock =  $request->input('stock');
            $item->show_number =  $request->input('show_number');
            $item->status_id =  $request->input('status_id');
            $item->category_id =  $request->input('category_id');
            $item->subcategory_id =  $request->input('subcategory_id');
            $item->client_id = Auth::user()->id;

            $item->save();
            if($item ) {
                if($request->input('vehicles')){
                    $this->add_vehicles($item ,  $request->input('vehicles'));
                }
                if($request->input('apartment')){
                    $this->add_apartments($item ,  $request->input('apartment'));
                }
            }
            return new ItemResource($item);
        }
    }

    public function getDrafts(){
        return Items::where('client_id', Auth::id())
            ->where('status_id', 2)
            ->get();
    }

    public function editDraft(Request $request, $id)
    {
      
     
        $validatedData = $request->validate([
      
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'location' => 'required',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'stock' => 'required',
            'status_id' => 'required',
            'category_id' => 'nullable',
            'subcategory_id' => 'nullable',
            'images' => 'nullable',
            'show_number' => 'nullable',
        ]);

        if($validatedData) {
            $item = Items::findorfail($request->id);
            $item->title =  $request->input('title');
            $item->price =  $request->input('price');
            $item->description =  $request->input('description');
            $item->location =  $request->input('location');
            $item->latitude =  $request->input('latitude');
            $item->longitude =  $request->input('longitude');
            $item->stock =  $request->input('stock');
            $item->show_number =  $request->input('show_number');
            $item->status_id =  $request->input('status_id');
            $item->category_id =  $request->input('category_id');
            $item->subcategory_id =  $request->input('subcategory_id');
            $item->is_approved =  2;
            $item->client_id = Auth::user()->id;

            $item->save();
            // if($item ) {
            //     if($request->input('vehicles')){
            //         $this->add_vehicles($item ,  $request->input('vehicles'));
            //     }
            //     if($request->input('apartment')){
            //         $this->add_apartments($item ,  $request->input('apartment'));
            //     }
            // }
            return new ItemResource($item);
        }
     
    }

    public function deleteDrafts($id)
    {
        //
        $item = Items::findorfail($id);
        $item->delete();
        return 'deleted' ;
    }
}
