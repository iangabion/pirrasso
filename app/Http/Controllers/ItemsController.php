<?php

namespace App\Http\Controllers;

use App\Items;
use App\Photos;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;


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
            'status' => 'required',
            'description' => 'required',
            'location' => 'required',
            'user_id' => 'required',
            'category_id' => 'nullable',
            'images' => 'required'
        ]);

        if($validatedData) {
            $item = new Items();
            $item->title =  $request->input('title');
            $item->price =  $request->input('price');
            $item->status =  $request->input('status');
            $item->description =  $request->input('description');
            $item->location =  $request->input('location');
            $item->client_id =  $request->input('user_id');
            $item->category_id =  $request->input('category_id');

            $item->save();
            if($item) {
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
