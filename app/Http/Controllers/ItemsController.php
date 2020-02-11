<?php

namespace App\Http\Controllers;

use App\Items;
use App\Photos;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Resources\SoldResource;
use Auth ;
use App\Sold;


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
        $items = Items::all();
        return  ItemResource::collection($items) ;
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
    {
        // return $request->images ;
        $validatedData = $request->validate([
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'location' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'stock' => 'required',
            'status_id' => 'required',
            'category_id' => 'nullable',
            'images' => 'nullable',
            'show_number' => 'nullable',
        ]);

        if($validatedData) {
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
            $item->client_id = Auth::user()->id;

            $item->save();
            if($item && $request->images) {
                $this->process_images($request->images ,$item);
            }
            return new ItemResource($item);
        }
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
    public function edit(Items $items)
    {
        //
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
    public function destroy(Items $items)
    {
        //
    }

    public function process_images($images , $item){

        if($images){
            $i=0;
            foreach($images as $img) {

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
