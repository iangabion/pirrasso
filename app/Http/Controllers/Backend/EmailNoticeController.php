<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DisapprovementNotice;

class EmailNoticeController extends Controller
{
    public function disapprovementEmail(Request $request)
    {
        $data = array(
            'email'      =>  $request->client['email'],
            'reason'      =>  $request->reason,
            'title'      =>  $request->title,
        );
        // dd($data);
        Mail::to($request->client['email'])->send(new DisapprovementNotice($data));
        return back()->with('success', 'Thanks for contacting us!');
    }



}