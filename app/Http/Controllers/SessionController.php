<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Session;
use App\Message;
use App\Items ;
use App\Client;
use Auth ;
use App\Http\Resources\SessionResource;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class SessionController extends Controller
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

    public function get_indi_messages($id) {
        $session = Session::findorfail($id);
        return  new SessionResource($session) ;
    }
    public function get_item_messages($id)
    {
        $session = Session::where('item_id', $id)->get();
        return SessionResource::collection($session) ;
    }

    public function get_item_messages2()
    {
        $session = Session::where('client_id', Auth::user()->id)->get();
        return SessionResource::collection($session) ;
    }

    public function get_user_messages() 
    {
        $id = Auth::user()->id ;
        // $message_status = Message::where('message_status', '!=' , 2)->orWhereNull('message_status');
        $session = Session::with('messages')->where('seller_id' , $id)->orWhere('buyer_id' , $id)->get();
                // ->where('session_status', '!=', $id)
                return SessionResource::collection($session);
        // $session2 = $session ->where('session_status', '!=', $id)->get();
        // return $session;
        // $session_stat = $session->session_status;  
                // return $session;
        // $session_stat = $session->where('session_status', '!=', $id)->get();
        // return SessionResource::collection($session_stat);

        // $session = Session::with('messages')->where('seller_id', $id)->where('seller_delete', 0);
        // $session2 = Session::with('messages')->where('buyer_id', $id)->where('buyer_delete', 0)->union($session);
        // $session3 = $session->{$session2}->get();
        // // $seller = $session->where('seller_delete', 0)->get();
        // return $session2->get();
        
    }

    // public function archive_message(Request $request){

    //     $id = Auth::user()->id;
    //     $session = Session::with('messages')->get();
    //     return $session;



    //     // if($session == $id){
    //     //     return $session->with('messages')->where('seller_id', $id)->update(['seller_delete'=> 1 ]);
    //     // }
    //     // else{
    //     //     return $session->where('buyer_id', $id)->update(['buyer_delete'=> 1 ]);
    //     // };
    //     // return  $session;

    //     // $id = Auth::user()->id;
    //     // $session1 = Session::all();
    //     // // $session2 = $session1->where('seller_id', $id)->where('id', $request->id)->update(['seller_delete' => 1]);
    //     // return $session1;


    //     // if ('seller_id' == $id) {
    //     // $session = Session::with('messages')->where('seller_id', $id)->where('seller_delete', 0)->where('item_id', $request->item_id);
    //     // }
    //     // if('seller_id' == $id){
    //     //     $session = Session::with('messages')->where('id', $request->id)
    //     //     ->update(['seller_delete' => 1]);
    //     //    return 'success';
            
    //     // }
    //     // elseif('buyer_id' == $id){
    //     //     $session1->update(['buyer_delete' => 1]);
    //     //     return 'success buyer';
    //     // }
    //     // return $session2;

    // }

    // public function update_session(){
    //     $id = Auth::user()->id;
    //     $session = Session::where('seller_id', $id)->update(['seller_delete' => 1]);
    //     // return $session;
    //     // ->where('seller_id', $id)->orWhere('buyer_id', $id)->

    //     // if($id == 'seller_id'){
    //     //     $session->update(['seller_delete', 1]);
    //     //     return 'success delete seller';
    //     // }
    //     return  new SessionResource($session) ;
    //     // elseif($id == 'buyer_id'){
    //     //     $session->update(['buyer_delete', 1]);
    //     //     return 'success delete buyer';
    //     // }
    // }


    public function store(Request $request)
    {
        //
        //  when the message is from seller 
            if($request->session_id) {
                $session_available = Session::findorfail($request->session_id);
                $this->manage_message($request->session_id , $request->message, $request->session_status);
                return new SessionResource($session_available ) ;
            }


            else {
                $messageData = $request->validate([
                    'seller_id' => 'required',
                    'item_id' => 'required',
                    'message' => 'required',
                    'session_id' => 'nullable',
                    'session_status' => 'nullable'
                ]);
                $session = new Session() ;
                $session->seller_id = $request->input('seller_id') ;
                $session->item_id = $request->input('item_id') ;
                $session->buyer_id = Auth::user()->id ;
                
                $session->sessions_name = $request->input('seller_id') . '_' . $request->input('item_id') . '_' . $request->input('buyer_id') ;

                if($session->save()){
                    $this->manage_message($session->id , $request->message, $request->session_status);
                }
                return  new SessionResource($session) ;
            }
    }

    public function count_item_messages($id)
    {
        $session = Session::where('item_id', $id)->get();
        return $session->where('is_read',0)->count() ;
    }

    public function manage_message($sessions_id , $messages, $session_status){
        $message = new Message();
        $message->session_id = $sessions_id ;
        $message->user_id = Auth::user()->id ;
        $message->message = $messages ;
        $message->session_status = $session_status;
        $message->save();
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
