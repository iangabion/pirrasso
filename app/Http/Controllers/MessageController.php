<?php

namespace App\Http\Controllers;

use App\Message;
use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function readMessage($id){
        $message = Session::findOrFail($id)->messages()->update([
            'is_read' => 1
        ]);

        return 'success';
    }

    // public function deleteMessage(Request $request){

    // }


    public function deleteMessage(Request $request){
        // $message = Session::findOrFail($id)->messages()->delete();
        // return 'success';
        $id = Auth::user()->id ;
        $message = Message::where('session_id', $request->session_id)->get();
        // $message = '';
        foreach($message as $item) {
            if(!$item->message_status) {
                $message = Message::find($item->id);
                $message->update(['message_status' => $id]);
                echo 'Deleted in your side';
            }else {
                $message = Message::find($item->id);
                $message->delete();
                echo 'Deleted both side';
            }
        }
    //    if (!$message) {
    //     //    $this->deletes($request->session_id);
        
    //         dd($message,"sad2");
    //     //    return Message::where('session_id', $request->session_id)->delete(['session_id',$request->session_id]);
    //     //    return 'Deletes';
    //     }else{
           
    //         return Message::where('session_id', $request->session_id)->update(['message_status' => $id]);
    //         // dd("sad2");
    //     }
    }

    // public function countUnread($id){
    //     $message = Message::findOrFail($id)->messages()->get();
        
    //     return $message;
    // }
    

    public function count(){
        return Message::where('is_read', 1)->count();
    }

    public function deletes($session_id){
        return Message::where('session_id', $session_id)->delete(['session_id', $session_id]);
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
        //
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
    }
}
