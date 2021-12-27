<?php

namespace App\Http\Controllers;

use App\AppImages;
use App\Photos;
use Illuminate\Http\Request;

class PhotosController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Photos  $photos
     * @return \Illuminate\Http\Response
     */
    public function show(Photos $photos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Photos  $photos
     * @return \Illuminate\Http\Response
     */
    public function edit(Photos $photos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photos  $photos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photos $photos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photos  $photos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photos $photos)
    {
        //
    }
    
    public function get_allPhoto(){
        $photo = Photos::get();

        return $photo;
    }

    public function get_appImages(){
        $app = AppImages::get();

        return $app;
    }

    public function add_photo4Logo(Request $request){

        if(\File::exists(public_path('images/app_images/logo.jpeg'))){
            \File::delete('images/app_images/logo.jpeg');
        }else{
            dd('File does not exists.');
        };
      
        if($request->image){
            $image = $request->image;  // your base64 encoded
            list($type, $image) = explode(';', $image);
            list(, $image)      = explode(',', $image);
            $data = base64_decode($image);
            $imageName = 'logo.jpeg';
            file_put_contents(public_path() . '/' . 'images/app_images/' . $imageName, $data);
        }

    }
}
