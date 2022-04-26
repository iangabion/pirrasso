<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Resources\ClientResource;
use App\Mail\ForgotPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PDO;

class ForgotPasswordController extends Controller
{
    public function checkEmail(Request $request){
        $client = Client::where('email',$request->email)->first();
        if(!$client){
            return response("Email not Found",204);
        }
        $this->sendCode($client);
        return response("success",200);
    }
    public function sendCode($client){
        $code = $this->generateCode($client->email);
        Mail::to($client->email)->send(new ForgotPassword($client,$code));
        return $code;
    }
    public function generateCode($email){
        $code = strtoupper(Str::random(2)).time();
        DB::table('password_resets')->where('email', $email)->delete();
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $code,
            'created_at' => Carbon::now(),
        ]);
        return $code;
    }
    public function reset_password($data, $password)
    {
        $customer=Client::where('email',$data->email)->first();
        $customer->password  =  bcrypt($password);
        $customer->save();
        DB::table('password_resets')->where('email', $data->email)->delete();
    }
    public function checkToken(Request $request)
    {
        $valid = DB::table('password_resets')->where(['token' => $request->token, 'email' => $request->email])->first();
        if(!$valid) return response("token not found",204);
        //get the time difference
        $timediff=Carbon::parse($valid->created_at)->diffInMinutes(Carbon::now());
        //check if the token is valid
        if($timediff > 15) return response("expired token",401);
        $this->reset_password($valid,$request->password);
        $client  = Client::where('email',$request->email)->first();
        $accessToken = $client->createToken('authToken')->accessToken;
        return response(['user' => new ClientResource($client),  'accessToken' => $accessToken],200);
    }
}
