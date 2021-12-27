<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SMSNotification;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;
use App\User;
use App\Items;
Use Illuminate\Support\Facades\Auth;
use Exception;

class SmsController extends Controller
{
    // public function toNexmo($notifiable){
    //     return (new NexmoMessage)
    //     ->content('Your SMS message content');
    // }

    public function index(){
        // $basic  = new \Nexmo\Client\Credentials\Basic('key', 'secret');
        // $client = new \Nexmo\Client($basic);
        // $message = $client->message()->send([
        //     'to' => '9181600*****',
        //     'from' => 'Nexmo',
        //     'text' => 'A text message sent using the Nexmo SMS API'
        // ]);
        // dd('message send successfully');
//
        // try {
        //     $basic  = new \Nexmo\Client\Credentials\Basic(getenv("NEXMO_KEY"), getenv("NEXMO_SECRET"));
        //     $client = new \Nexmo\Client($basic);
        //     $receiverNumber = "91846XXXXX";
        //     $message = "This is testing from ItSolutionStuff.com";
        //     $message = $client->message()->send([
        //         'to' => $receiverNumber,
        //         'from' => 'Vonage APIs',
        //         'text' => $message
        //     ]);
        //     dd('SMS Sent Successfully.');
        // } catch (Exception $e) {
        //     dd("Error: ". $e->getMessage());
        // }
    }

    public function sms_sender(Request $request){
        $items = Items::where('id', $request->input('id') )->get('title');
        $receiverNumber = '+' . $request->input('number');
        $message = "This is testing from Qonvex.com. Your " . $items . " item has been Approved!";
        try {
            $account_sid = 'ACfb0e0ca8f0786a4b8c937db4eb8d8daa';
            $auth_token = 'e70d8db712c8e1b6abb13e50255a4eaf';
            $twilio_number = '+16203191424';
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);
            return('SMS Sent Successfully.');
        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }
    }
    public function send_sms_test(Request $request){
        // $user = Auth::user();
        // $admin = User::find($user)->first();
        // return $admin;
        $receiverNumber = '+' . $request->input('new');
        $message = "Test from Qonvex devs";
        try {
            $account_sid = 'ACfb0e0ca8f0786a4b8c937db4eb8d8daa';
            $auth_token = 'e70d8db712c8e1b6abb13e50255a4eaf';
            $twilio_number = '+16203191424';
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);
            return('SMS Sent Successfully.');
        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }
        return $receiverNumber;
    }

   
}
