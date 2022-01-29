<?php

namespace App\Http\Controllers;

use App\Client;
use App\FcmToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ItemResource;
use App\Http\Requests\StoreClientPost ;
use App\Mail\CodeVerification;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Mail;
use App\Items;

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
        $clients = Client::paginate(10);
        // return  ClientResource::collection($clients) ;
        return $clients;
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
        $client->full_name =  $request->input('full_name');
        $client->email =  $request->input('email');
        $client->gender = $request->input('gender');
        $client->birthday = $request->input('birthday');
        $client->bio = $request->input('bio');
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
        $client->verification_code = $this->generateRandomNumber();
        $client->save();
        $client->fcm_tokens()->create([
            'token'=> $request->input('fcm_token')
        ]);
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

    public function generateRandomNumber($length = 6) {

    $random = "";
    srand((double) microtime() * 1000000);

    $data = "123456123456789071234567890890";
    // $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz"; // if you need alphabatic also

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
            $client->full_name = $request->full_name;
            $client->social_id = $request->id;
            $client->is_verified = 1;
            $client->account_type = 'facebook';
            $client->image = $request->image;
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
        $accessToken = $client->createToken('authToken')->accessToken;

        if(!$client->fcm_tokens()->where('token',$request->input('fcm_token'))->exists()){
            $client->fcm_tokens()->create([
                'token'=> $request->input('fcm_token')
            ]);
        }

        return response(['user' => new ClientResource($client) , 'accessToken' => $accessToken ]);
    }

    public function appleLogin(Request $request){
        $client =  Client::where('social_id',$request->id)->first();
        if(!$client){
            $client = new Client();
            $client->social_id = $request->id;
            $client->is_verified = 1;
            $client->account_type = 'apple';
            $client->save();
        }
        if(!$client->fcm_tokens()->where('token',$request->input('fcm_token'))->exists()){
            $client->fcm_tokens()->create([
                'token'=> $request->input('fcm_token')
            ]);
        }
        $accessToken = $client->createToken('authToken')->accessToken;
        return response(['user' => new ClientResource($client) , 'accessToken' => $accessToken ]);
    }

    public function login(Request $request) {
        $loginData = $request->validate([
            'email_mobile' => 'required',
            'password' => 'required'
        ]);
        if($loginData){
            $client = Client::where('email',$request->email_mobile)
            ->orWhere('mobile',$request->email_mobile)->first();
            if ( ($client != null) && Hash::check($request->password, $client->password) ){
                $accessToken = $client->createToken('authToken')->accessToken;
                $client->save();
                if(!$client->fcm_tokens()->where('token',$request->input('fcm_token'))->exists()){
                    $client->fcm_tokens()->create([
                        'token'=> $request->input('fcm_token')
                    ]);
                }
                return response(['user' => new ClientResource($client) , 'accessToken' => $accessToken ]);
            }
            return response(['message'=> 'invalid credentials']);
        }
    }

    public function logout(Request $request){
        // return $request->fcm_token;
        FcmToken::where('token',$request->fcm_token)->delete();
        $client = Auth::user()->token();
        $client->revoke();
        return "success";
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
            'full_name' => 'nullable',
            'gender' => 'nullable',
            'birthday' => 'nullable',
            'bio' => 'nullable',
            'email' => 'nullable|email|unique:clients,email,'.$id,
            'mobile' => 'nullable',
            'username' => 'nullable|unique:clients,username,'.$id,
           
            'profile_pic' => 'nullable'
        ]);

        if($updateData) {
        $client = Client::findorfail($id);
        $client->full_name =  $request->input('full_name');
        $client->email =  $request->input('email');
        $client->gender = $request->input('gender');
        $client->birthday = $request->input('birthday');
        $client->bio = $request->input('bio');
        $client->mobile =  $request->input('mobile');
        $client->username =  $request->input('username');
        $client->password = Hash::make($request->input('password'));
        $client->is_verified =  1;
    
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
        // $this->sendVerificationCode($client);
        // $accessToken = $client->createToken('authtoken')->accessToken ;
        // return response(['user' => $client , 'access_token' => $accessToken]);
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

    public function change_number(Request $request){
        $user = Client::find(Auth::id());
        $user->mobile = '63' + $request->input('new');
        $user->save();

        return $user;
        
    }

}
