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
    public function index()
    {
        $smtp = SmtpSetting::get();
        return $smtp;
    }

    public function search(Request $request)
    {
        $smtp = SmtpSetting::query();
        if ($request->searchkey != "") {
            $keyword = $request->searchkey;
            $smtp->where(function($query) use($keyword) {
                $query  ->where('mail_mailer', 'LIKE', "%$keyword%")
                        ->orWhere('mail_host', 'LIKE', "%$keyword%")
                        ->orWhere('mail_port', 'LIKE', "%$keyword%")
                        ->orWhere('mail_username', 'LIKE', "%$keyword%")
                        ->orWhere('mail_password', 'LIKE', "%$keyword%")
                        ->orWhere('mail_encryption', 'LIKE', "%$keyword%");
            });
        }
        return $smtp->get();
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
        $smtp->status_on        = 0;
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
    public function update(Request $request, $id)
    {
        $smtp = SmtpSetting::findorfail($id);
        $smtp->mail_mailer      = $request->mail_mailer;
        $smtp->mail_host        = $request->mail_host;
        $smtp->mail_port        = $request->mail_port;
        $smtp->mail_username    = $request->mail_username;
        $smtp->mail_password    = $request->mail_password;
        $smtp->mail_encryption  = $request->mail_encryption;
        $smtp->status_on        = 0;
        $smtp->save();
        return $smtp ;
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

    public function setDefault($id){
        SmtpSetting::where('status_on', 1)->update(['status_on' => 0]);
        SmtpSetting::where('id', $id)->update(['status_on' => 1]);

        return $id;
    }
}
