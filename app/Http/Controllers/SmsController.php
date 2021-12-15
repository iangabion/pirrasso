<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SMSNotification;
use Illuminate\Notifications\Notification;

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

    public function sendMessage(){

        // Notification::send(new SMSNotification());

        // Nexmo::message()->send([
        //     'to' => '09355634803',
        //     'from' => '09355634803',
        //     'message' => 'This is laravel test'
        // ]);
    }

   
}
