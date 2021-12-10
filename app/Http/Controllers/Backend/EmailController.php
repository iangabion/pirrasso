<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $data = array(
            'message' =>  $request->message,
        );
        Mail::to('test.receiver@gmail.com')->send(new Email($data));
        return $data;
    }
}
