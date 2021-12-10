<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\SmtpSetting;
use Illuminate\Http\Request;

class SmtpSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $smtp = SmtpSetting::all();
    //     return $smtp;
    // }

    public function pagination(Request $request)
    {
        $purch = SmtpSetting::query();
        if($request->input('keyword') != ""){
            $keyword = $request->input('keyword');
            $purch->where(function($query) use($keyword){
                $query  ->where('mail_mailer', 'LIKE', "%$keyword%")
                        ->orwhere('mail_host', 'LIKE', "%$keyword%")
                        ->orwhere('mail_port', 'LIKE', "%$keyword%")
                        ->orwhere('mail_username', 'LIKE', "%$keyword%")
                        ->orwhere('mail_encryption', 'LIKE', "%$keyword%");
            });
        }
        return $purch->orderBy('created_at','desc')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'mail_mailer'     => ['required'],
            'mail_host'       => ['required'],
            'mail_port'       => ['required'],
            'mail_username'   => ['required'],
            'mail_password'   => ['required'],
            'mail_encryption' => ['required'],
        ]);

        $smtp = new SmtpSetting;
        $smtp->mail_mailer      = $request->mail_mailer;
        $smtp->mail_host        = $request->mail_host;
        $smtp->mail_port        = $request->mail_port;
        $smtp->mail_username    = $request->mail_username;
        $smtp->mail_password    = $request->mail_password;
        $smtp->mail_encryption  = $request->mail_encryption;
        $smtp->status_on = 0;
        $smtp->save();
        return response()->json($smtp);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SmtpSetting  $smtpSetting
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return SmtpSetting::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SmtpSetting  $smtpSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(SmtpSetting $smtpSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SmtpSetting  $smtpSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SmtpSetting $smtpSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SmtpSetting  $smtpSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $smtp_delete= SmtpSetting::find($id);
        $smtp_delete->delete();
        return response()->json($smtp_delete);
    }
}
