<?php

namespace App\Http\Controllers;

use App\Category;
use App\Status;
use Illuminate\Http\Request;
use App\Subcategory ;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\StatusResource;
use App\Http\Resources\ItemResource ;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::all();
        return CategoryResource::collection($categories) ;
    }

    public function statuses(){
        $status = Status::orderBy('name')->get();
        return StatusResource::collection($status) ;

    }

    public function category_items($id){
        $category = Category::findorfail($id);
        return  ItemResource::collection($category->items) ;
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

    public function add_subcat_icon(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'icon' => 'required',
        ]);
        if($validatedData) {
            $subcategory = Subcategory::findorfail($request->id);

            $image = $request->icon;  // your base64 encoded
            list($type, $image) = explode(';', $image);
            list(, $image)      = explode(',', $image);
            $data = base64_decode($image);
            $imageName = $subcategory->name. time() . '_subcat.jpeg';
            file_put_contents(public_path() . '/' . 'images/icons/' . $imageName, $data);

            $subcategory->icon = $imageName ;

            $subcategory->save();

            return $subcategory ;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
