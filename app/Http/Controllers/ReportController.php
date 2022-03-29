<?php

namespace App\Http\Controllers;
use App\Http\Resources\ItemResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Report;
use App\Items;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    //
    public function reportItem(Request $request){
        $report = new Report();

        $report->user_id = Auth::user()->id;
        $report->item_id = $request->item_id;
        $report->reason = $request->reason;
        $report->description = $request->description;
        $report->save();
        return new ReportResource($report) ;
    }

    public function editReport(Request $request, $id){
        $report = Report::find($id);
        $report->item_id = $request->item;
        $report->user_id = Auth::user()->id;
        $report->reason = $request->reason;
        $report->description = $request->description;
        $report->save();
        return $report;
    }

    public function deleteReport($id){
        $report = Report::find($id)->delete();
        return $report;
    }


    // public function index(Request $request){
    //     $report = Report::with('report2')->get();
    //     return $report;
    // }

    public function test(Request $request){
        
        // $report = Report::select('item_id', Report::raw('count(*) as total'))->groupBy('item_id')->pluck('item_id','reason');
        $report = Items::where('id', $request->id)->increment('report_status');
    // $report2 = Report::whereHas($report)->get('item_id');
    //    foreach($report as $item) {
    //        if($item <= 10){
    //            $items = Items::find($id);
    //            $items->update(['report_status' => 1 ]);
    //         echo 'hi';
    //        }else{
    //         echo 'he';
    //        }
    //    }
    return $report;
    }

    public function addreport(Request $request)
    {
        $habit = Items::where('id', $request->id);
        $habit->increment('report_status');
        return 'success';
       
    }
    public function removereport(Request $request)
    {
        $habit = Items::where('id', $request->id);
        $habit->decrement('report_status');
        return 'success';
       
    }
}


