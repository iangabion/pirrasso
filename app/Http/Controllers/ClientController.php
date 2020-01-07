<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ClientResource;
use App\Http\Requests\StoreClientPost ;
use Auth ;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clients = Client::all();
        return  ClientResource::collection($clients) ;
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
    public function store(StoreClientPost $request)
    {

    
            $client = new Client();
            $client->first_name =  $request->input('first_name');
            $client->last_name =  $request->input('last_name');
            $client->email =  $request->input('email');
            $client->mobile =  $request->input('mobile');
            $client->username =  $request->input('username');
            $client->password = Hash::make($request->input('password'));


            if($request->profile_pic){
                $image = $request->profile_pic;  // your base64 encoded
                list($type, $image) = explode(';', $image);
                list(, $image)      = explode(',', $image);
                $data = base64_decode($image);
                $imageName = date("YmdHis"). '.' . 'jpeg';
                file_put_contents(public_path() . '/' . 'images/user_profile/' . $imageName, $data);

                $client->image = $imageName ;
            }
            $client->save();
            $accessToken = $client->createToken('authtoken')->accessToken ;
            return response(['user' => new ClientResource($client) , 'access_token' => $accessToken]);
    }

    public function login(Request $request) {
        $loginData = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        if($loginData){
            $client = Client::where('username',$request->username)->first();
            if ( ($client != null) && Hash::check($request->password, $client->password) ){
                $accessToken = $client->createToken('authToken')->accessToken;
                return response(['user' => new ClientResource($client) , 'accessToken' => $accessToken ]);
            }
            return response(['message'=> 'invalid credentials']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $client = Client::findorfail($id);
        return new ClientResource($client);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update_profile(Request $request)
    {
        //
        $client = Client::findorfail(Auth::user()->id);
        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }

    
}
