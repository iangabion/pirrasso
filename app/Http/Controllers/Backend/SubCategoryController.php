<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Photos;
use Illuminate\Http\Request;
use App\Subcategory;
class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // if($request->icon){
        //     $image = $request->icon;  // your base64 encoded
        //     list($type, $image) = explode(';', $image);
        //     list(, $image)      = explode(',', $image);
        //     $data = base64_decode($image);
        //     $imageName = $request->name . Time() . '_subcat.jpeg';
        //     file_put_contents(public_path() . '/' . 'images/icons/' . $imageName, $data);
        // }
        $sub = Subcategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            // 'icon' => $imageName
        ]);

        // $photo = Photos::create([
        //     'imageable_id' => $sub->id,
        //     'imageable_type' => 'App\Subcategory',
        //     'filename' => $imageName
        // ]);
        return $sub;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sub = Subcategory::findorfail($id);
        return $sub ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $sub = Subcategory::findorfail($id);
        $sub->name = $request->name ;
        if($request->icon){
            try {
                $image = $request->icon;  // your base64 encoded
                list($type, $image) = explode(';', $image);
                list(, $image)      = explode(',', $image);
                $data = base64_decode($image);
                $imageName = $request->name . Time() . '_subcat.jpeg';
                file_put_contents(public_path() . '/' . 'images/icons/' . $imageName, $data);
                $sub->icon =  $imageName;
            } catch (\Throwable $th) {}
        }
        $sub->category_id = $request->category_id ;
        $sub->save();
        return $sub;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $sub = Subcategory::findorfail($id);
        $sub->delete();
        return $sub ;
    }
}
