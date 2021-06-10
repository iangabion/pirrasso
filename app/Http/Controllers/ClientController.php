<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ItemResource;
use App\Http\Requests\StoreClientPost ;
use App\Mail\CodeVerification;
use Auth ;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Mail;

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
        $client->fcm_token = $request->input('fcm_token');


        if($request->profile_pic){
            $image = $request->profile_pic;  // your base64 encoded
            list($type, $image) = explode(';', $image);
            list(, $image)      = explode(',', $image);
            $data = base64_decode($image);
            $imageName = date("YmdHis"). '.' . 'jpeg';
            file_put_contents(public_path() . '/' . 'images/user_profile/' . $imageName, $data);

            $client->image = $imageName ;
        }
        $client->verification_code = $this->generateRandomNumber();
        $client->save();
        $this->sendVerificationCode($client);
        $accessToken = $client->createToken('authtoken')->accessToken ;
        return response(['user' => new ClientResource($client) , 'access_token' => $accessToken]);
    }

    public function sendVerificationCode($client) {
        FacadesMail::to($client->email)->send(new CodeVerification($client->id));
        return 'okay' ;
    }

    public function checkVerificationCode(Request $request) {
        $client = Client::findorfail($request->id);

        if($client->verification_code == $request->verification_code){
            $client->is_verified = 1 ;
            $client->save();
            return new ClientResource($client);
        }

        return response(['message'=> 'invalid verification code']);
    }

    public function resendVerificationCode(Request $request){
        $client = Client::findorfail($request->id);
        if($client->is_verified == 1){
            return response(['message'=> 'your account is already verified']);
        }

        $client->verification_code = $this->generateRandomNumber();
        $client->save();
        $this->sendVerificationCode($client);
        return response(['message'=> 'verification code sent']);
    }

    public function generateRandomNumber($length = 8) {

    $random = "";
    srand((double) microtime() * 1000000);

    $data = "123456123456789071234567890890";
    $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz"; // if you need alphabatic also

    for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
    }

    return $random;

    }

    public function facebookLogin(Request $request){
        if(!$request->id)return response(['message'=> 'invalid credentials']);

        $client = Client::where('social_id',$request->id)->first();
        if(!$client){
            $client = New Client();
            $client->first_name = $request->first_name;
            $client->last_name = $request->last_name;
            $client->social_id = $request->id;
            $client->is_verified = 1;
            $client->save();
        }
        if($client->social_profile()->count()){
            $client->social_profile()->update([
                'image' => $request->picture,
            ]);
        }else{
            $client->social_profile()->create([
                'image' => $request->picture,
            ]);
        }
        $client = Client::with('social_profile')->where('social_id',$request->id)->first();
        $accessToken = $client->createToken('authToken')->accessToken;
        $client->fcm_token = $request->input('fcm_token');
        return response(['user' => $client , 'accessToken' => $accessToken ]);
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
                $client->fcm_token = $request->input('fcm_token');
                $client->save();
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
    public function show()
    {
        //
        $client = Client::findorfail(Auth::user()->id);
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
        $id = Auth::user()->id ;
        $updateData = $request->validate([
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'email' => 'nullable|email|unique:clients,email,'.$id,
            'mobile' => 'nullable',
            'username' => 'nullable|unique:clients,username,'.$id,
            'password' => 'nullable',
            'profile_pic' => 'nullable'
        ]);

        if($updateData) {
        $client = Client::findorfail($id);
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

    public function favorites($id)
    {
        $client = Client::findorfail(Auth::user()->id);
        $client->items_fav()->attach($id);
        return 'succesfully added to favorites' ;
    }

    public function remove_favorites($id)
    {
        $client = Client::findorfail(Auth::user()->id);
        $client->items_fav()->detach($id);
        return 'succesfully removed to favorites' ;
    }

    public function get_favorites()
    {
        $favorites = Client::findorfail(Auth::user()->id);
        return ItemResource::collection($favorites->items_fav);
    }


}
