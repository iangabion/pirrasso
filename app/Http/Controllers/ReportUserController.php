<?php

namespace App\Http\Controllers;
use App\ReportUser;
use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;

class ReportUserController extends Controller
{
    //

    public function report_user(Request $request){

        $report = new ReportUser;
        $report->user_id = Auth::user()->id;
        $report->reported_user_id = $request->reported_user_id;
        $report->reason = $request->reason;
        $report->save();
        return $report;
    }

    public function edit_report(Request $request, $id){
        $report = ReportUser::find($id);
        $report->user_id = Auth::user()->id;
        $report->reported_user_id = $request->reported_user_id;
        $report->reason = $request->reason;
        $report->save();
        return $report();
    }
    public function delete_report($id){
        $report = ReportUser::find($id);
        $report->destroy();
        return 'Report Deleted';
    }

    public function view_report(){
        $report = ReportUser::where('user_id', Auth::user()->id)
                ->orWhere('reported_user_id', Auth::user()->id)->get();
        return $report;
    }
    public function addreport(){
        $report = Client::where('id', Auth::user()->id)->increment('is_report');
        return 'Success';
    }
    public function removereport(){
        $report = Client::where('id', Auth::user()->id)->decrement('is_report');
        return 'Success';
    }
}
