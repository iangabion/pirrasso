<?php

namespace App\Http\Controllers;

use App\Category;
use App\Status;
use Illuminate\Http\Request;
use App\Subcategory ;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\StatusResource;
use App\Http\Resources\ItemResource ;
use App\Items;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = Category::with('items', 'subcategories')->orderBy('id', 'asc')->get();
        return $categories;
    }

    public function get_items($id){
        {

                $subcategory = Subcategory::findorfail($id)->items()->get();
                return ItemResource::collection($subcategory);
        }
    }

    public function get_all(){
        $items = Items::where('stock', '>=', 1)->where('is_approved', 1)->orderBy('created_at', 'desc')->get();
        return  ItemResource::collection($items) ;
    }

    public function get_all_unapproved(){
        $items = Items::where('is_approved', 0)->orderBy('created_at', 'desc')->get();
        return  ItemResource::collection($items) ;
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
    public function update_catPos(Request $request){

        $postCat = $this->validate($request, [
            'categories' => 'required|array',
        ]);

        foreach ($postCat['categories'] as $key=> $category){
            $postCa = Category::find($category['id']);
            $postCa->position = $key + 1;
            $postCa->save();
        }

        return response()->json($postCa);

    }
    public function update_subCatPos(Request $request){

        $postSubCat = $this->validate($request, [
            'subCategories' => 'required|array'
        ]);

        foreach ($postSubCat['subCategories'] as $key=> $subCategory){
            $postSubCat = Subcategory::find($subCategory['id']);
            $postSubCat->sub_position = $key + 1;
            $postSubCat->save();
        }
        return response()->json($postSubCat);
    }
    public function getSubCat($id)
    {
        //
        $category = Category::
            findOrFail($id)
            ->with('subcategories')
            ->get()
            ;
        return $category ;
    }

    public function getAll(){
        $subcategory = Subcategory::get();
        return $subcategory;
    }

    // get subcat image
    public function get_sub_image(){
        $sub = Subcategory::with('photos')->get();
        // $sub = Subcategory::find(1);
        return $sub;
    }

    //get category image
    public function get_catgry_image(){
        return Category::get();
    }

    public function get_category($id){
        $cat = Items::whereHas('subcategory', function($q) use($id){
            $q->where('id', $id);
        })->get();
        return ItemResource::collection($cat);
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
