<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Items ;
use App\Sold ;
use App\TwilioSwitch;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Items::all();
        return $items;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $request;
        // return Items::where('id', $request->id)
        // ->where('is_active', 0)
        // ->update(['is_active' => 1]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $item = Items::findorfail($id);
        $item->delete();
        return 'deleted' ;
    }

    public function sold_count(){
        return $sold = Sold::all();

    }

    public function getweekly()
    {
        $category = Items::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->paginate(10) ;
        return $category;
    }
    public function getdaily()
    {
        $category = Items::whereDay('created_at', now()->day)->paginate(10);
        return $category;
    }
    public function expirationDate(){
        $items = Items::where( 'updated_at', '>=', Carbon::today()->subDays(60))
                ->get();
                return $items;

    }

    public function activate(Request $request){
        return Items::where('id', $request->id)
                        // ->where('is_active', 0)
                        ->update(['is_active' => 1]);
    }

    public function deactivate(Request $request){
        return Items::where('id', $request->id)
                        // ->where('is_active', 0)
                        ->update(['is_active' => 0]);
    }

    public function getToApprovedItems(){
        $items = Items::with('category','client','photos')->where('is_approved', 0)->get();
        // return ItemResource::collection($items);
        return $items;
    }

    public function approvedItem($id){
        return Items::where('id', $id)
                        // ->where('is_active', 0)
                        ->update(['is_approved' => 1]);
    }

    public function bulkApprove(Request $request) {
  
        $items = Items::whereIn('id', $request->all())->update(['is_approved' => 1]);
        return $items;

        // return Items::get('client_id');

    }

    public function bulkDelete(Request $request) {
        // dd('delete');
        $items = Items::whereIn('id', $request->all());
        return $items->delete();

        // return Items::get('client_id');

    }

    public function bulksend(Request $request){
        // $switch = TwilioSwitch::find(1)->pluck('switch')->first();
      
            $items = Items::with('client')->whereIn('id', $request->all())->get(['client_id']);

            // $item = $items->get(['client.mobile']);
            return $items;
        
    
    }

    // public function bulkApprove(Request $request) {
  
    //     $items = Items::whereIn('id', $request->all())->update(['is_approved' => 1]);
    //     return $items;

    // }

    public function deleteApprovedItem($id)
    {
        $smtp_delete= Items::find($id);
        $smtp_delete->delete();
        return response()->json($smtp_delete);
    }

    public function stock_count()
    {
        $stock = Items::sum('stock');
        $sold = Items::sum('is_sold');
        $result = $stock-$sold;
        return $result;
    }
    public function getMonthlyItem(Request $request)
    {
        $y = Carbon::createFromFormat('Y', $request->date)->format('Y');
        $dates = [];
        for($i=1; $i<=12; $i++){
            $dates[] = [
                [
                    Carbon::createFromFormat('Y-m-d', $y.'-'.$i.'-1')->toDateString(),
                    Carbon::createFromFormat('Y-m-d', $y.'-'.$i.'-16')->toDateString()
                ],
                [
                    Carbon::createFromFormat('Y-m-d', $y.'-'.$i.'-16')->toDateString(),
                    Carbon::createFromFormat('Y-m-d', $y.'-'.$i.'-16')->endOfMonth()->addDays(1)->toDateString()
                ],
            ];
        };
        $results= [];
        foreach ($dates as $key => $date) {
            $results[] = [
                Items::whereBetween('created_at',$date[0])->count(),
                Items::whereBetween('created_at',$date[1])->count(),
                Items::whereBetween('created_at',[$date[0][0],$date[1][1]])->count(),
            ];  
        }
        return $results;
    }
}
