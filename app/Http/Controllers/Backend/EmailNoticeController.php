<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DisapprovementNotice;
use App\Mail\ApproveNotice;

class EmailNoticeController extends Controller
{
    public function disapprovementEmail(Request $request)
    {
        $data = array(
            'category id'               =>  $request->category['id'],
            'category title'            =>  $request->category['name'],
            'client email'              =>  $request->owner['email'],
            'client full_name'          =>  $request->owner['full_name'],
            'client mobile'             =>  $request->owner['mobile'],
            'client username'           =>  $request->owner['username'],
            'reason'                    =>  $request->reason,
            'item title'                =>  $request->title,
            'item description'          =>  $request->description,
            'item location'             =>  $request->location,
            'item created'              =>  $request->created_at,
            'item price'                =>  $request->price,
            // 'client_email'              =>  $request->owner['email'],

        );
        Mail::to($request->owner['email'])->send(new DisapprovementNotice($data));
        return back()->with('success', 'Thanks for contacting us!');
    }

    public function approveEmail(Request $request)
    {
        $data = array(
            'category id'               =>  $request->category['id'],
            'category title'            =>  $request->category['name'],
            'client email'              =>  $request->client['email'],
            'client account created'    =>  $request->client['created_at'],
            'client full name'          =>  $request->client['full_name'],
            'client mobile'             =>  $request->client['mobile'],
            'client username'           =>  $request->client['username'],
            'item title'                =>  $request->title,
            'item description'          =>  $request->description,
            'item location'             =>  $request->location,
            'item created'              =>  $request->created_at,
            'item price'                =>  $request->price,
        );
        Mail::to($request->client['email'])->send(new ApproveNotice($data));
        return back()->with('success', 'Thanks for contacting us!');
    }
}