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
            'category_id'               => $request->category['id'],
            'category_title'            => $request->category['name'],
            'client_email'              =>  $request->client['email'],
            'client_account_created'    =>  $request->client['created_at'],
            'client_first_name'         =>  $request->client['first_name'],
            'client_last_name'          =>  $request->client['last_name'],
            'client_mobile'             =>  $request->client['mobile'],
            'client_username'           =>  $request->client['username'],
            'reason'                    =>  $request->reason,
            'item_title'                =>  $request->title,
            'item_description'          => $request->description,
            'item_location'             => $request->location,
            'item_created'              => $request->created_at,
            'item_price'                => $request->price,
        );
        Mail::to($request->client['email'])->send(new DisapprovementNotice($data));
        return back()->with('success', 'Thanks for contacting us!');
    }

    public function approveEmail(Request $request)
    {
        $data = array(
            'category_id'               => $request->category['id'],
            'category_title'            => $request->category['name'],
            'client_email'              =>  $request->client['email'],
            'client_account_created'    =>  $request->client['created_at'],
            'client_first_name'         =>  $request->client['first_name'],
            'client_last_name'          =>  $request->client['last_name'],
            'client_mobile'             =>  $request->client['mobile'],
            'client_username'           =>  $request->client['username'],
            'item_title'                =>  $request->title,
            'item_description'          => $request->description,
            'item_location'             => $request->location,
            'item_created'              => $request->created_at,
            'item_price'                => $request->price,
        );
        Mail::to($request->client['email'])->send(new ApproveNotice($data));
        return back()->with('success', 'Thanks for contacting us!');
    }



}