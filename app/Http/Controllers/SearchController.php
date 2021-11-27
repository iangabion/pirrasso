<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Items;


class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($item = "")
    {
        $item = Items::where('title', 'like', "%" . $item . "%")->get();
        return ItemResource::collection($item);
    }
    public function searchchan(Request $request)
    {

        $item = Items::whereHas('subcategory', function($q) use($request){
            if($request->input('subcat_category')!=''){
                $q->where('id', $request->input('subcat_category'));
            }
            // else if($request->input('searchkey')===$request->input('subcat_category'))
            // {
            //     $q->where('id', $request->input('subcat_category'));
            // }
        });
        If ($request->input('searchkey') != ''){
            $keyword = $request->input('searchkey');
                $item->where(function($query)use($keyword){
                        $query  ->where('title', 'LIKE', "%$keyword%")
                                ->orWhere('description', 'LIKE', "%$keyword%")
                                ;
                });
        }
        else
        if($request->input('searchkey')===$request->input('subcat_category'))
        {
            $item = Items::whereHas('subcategory', function ($q) use($request){
                $q->where('id', $request->input('subcat_category'));
            });
        }
        ;
        // $item->where(   )

        return ItemResource::collection($item->get());
        // return ItemResource::collection($item);
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
    }
}
