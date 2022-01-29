<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SMSNotification;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;
use App\User;
use App\Items;
use App\TwilioSwitch;
Use Illuminate\Support\Facades\Auth;
use Exception;

class SmsController extends Controller
{
   

    public function get_admin(){
        return TwilioSwitch::where('id', 1)->get('switch');

    //   return $user->get();
    }

    public function enable_disable(Request $request){
        $twilio = TwilioSwitch::find(1);

        $twilio->switch = $request->input('switch');
        $twilio->save();
        return "success";
    }

    public function sms_sender(Request $request){
        $switch = TwilioSwitch::find(1)->pluck('switch')->first();
        if ($switch==1){
            $items = Items::where('id', $request->input('id') )->get('title');
            $receiverNumber = '+' . $request->input('number');
            $message = "This is a message from BonPlan. Your " . $items . " item has been Approved.";
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
        }else{
            return "sms is currently disabled";
        }
       
    }
    public function send_sms_test(Request $request){
        // $user = Auth::user();
        // $admin = User::find($user)->first();
        // return $admin;
        $receiverNumber = $request->input('new');
        $message = "This is a Twilio Test. Please Contact Qonvex Technology for your Request. -Bon Plan Devs";
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
