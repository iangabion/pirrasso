<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category ;
use App\Http\Resources\ItemResource;
use App\Items;
use App\Subcategory;
use App\Photos;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = Items::get();
        $subcat = Subcategory::with('photos')->get();
        $category = Category::with('items')->orderBy('position' , 'asc')->get();
        $category = collect($category)->map(function ($cat) use ($subcat, $item) {
            if($cat->id===1){
                return [
                    'id' => $cat->id ,
                    'name'=> $cat->name ,
                    'count'=> $item->count(),
                    'subcat'=> $subcat->count(),
                    'position' => $cat->id,
                    'icon' => $cat->icon,
                    'items' => $cat->items,
                ];
            }else{
                return [
                    'id' => $cat->id ,
                    'name'=> $cat->name ,
                    'count'=> $cat->items->count(),
                    'subcat'=> $cat->subcategories->count(),
                    'position' => $cat->id,
                    'icon' => $cat->icon,
                    'items' => $cat->items,
                    'all_subcategories' => $subcat->count(),
                    'all_items' => $item->count()
                ];
            }
        })
        ;
        return $category->all();
    }

    public function get_items($id)
    {
        $category = Category::findorfail($id)->items()->paginate(10) ;
        return  ItemResource::collection($category) ;
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
        //
        $validatedData = $request->validate([
            'name' => 'required|unique:categories,name',
        ]);

            if($request->icon){
                $image = $request->icon;  // your base64 encoded
                list($type, $image) = explode(';', $image);
                list(, $image)      = explode(',', $image);
                $data = base64_decode($image);
                $imageName = $request->name . Time() . '_category.jpeg';
                file_put_contents(public_path() . '/' . 'images/icons/' . $imageName, $data);
            }

            $category = Category::create([
                'name' => $request->name,
                'position'=> 0,
                'icon' => $imageName
            ]);
            // $photo = Photos::create([
            //     'imageable_id' => $category->id,
            //     'imageable_type' => 'App\Category',
            //     'filename' => $imageName
            // ]);

            return $category;
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
        //
            $category = Category::with(['subcategories' => function($q){
                $q->orderBy('sub_position', 'asc')->with('photos');
            }])
            ->findorfail($id);
            return $category ;
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
        //
        $category = Category::findorfail($id);

        if($request->icon){
            try {
                $image = $request->icon;  // your base64 encoded
                list($type, $image) = explode(';', $image);
                list(, $image)      = explode(',', $image);
                $data = base64_decode($image);
                $imageName = $request->name . Time() . '_category.jpeg';
                file_put_contents(public_path() . '/' . 'images/icons/' . $imageName, $data);
                $category->icon =  $imageName;
            } catch (\Throwable $th) {}
        }

        $category->name = $request->name ;
        $category->save();
        return $category ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findorfail($id);
        $category->delete();
        return $category ;
    }
}
