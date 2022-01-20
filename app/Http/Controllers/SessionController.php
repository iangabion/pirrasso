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
        $session = Session::with('messages')->where('seller_id', $id)->orWhere('buyer_id' , $id)->get();
        return SessionResource::collection($session) ;
        // return $session ;
    }
    public function store(Request $request)
    {
        //
        
            if($request->session_id) {
                $session_available = Session::findorfail($request->session_id);
                $this->manage_message($request->session_id , $request->message);
                return new SessionResource($session_available ) ;
            }
            else {
                $messageData = $request->validate([
                    'seller_id' => 'required',
                    'item_id' => 'required',
                    'message' => 'required',
                    'session_id' => 'nullable'
                ]);
                $session = new Session() ;
                $session->seller_id = $request->input('seller_id') ;
                $session->item_id = $request->input('item_id') ;
                $session->buyer_id = Auth::user()->id ;
                $session->sessions_name = $request->input('seller_id') . '_' . $request->input('item_id') . '_' . $request->input('buyer_id') ;

                if($session->save()){
                    $this->manage_message($session->id , $request->message);
                }
                return  new SessionResource($session) ;
            }
    }

    public function count_item_messages($id)
    {
        $session = Session::where('item_id', $id)->get();
        return $session->where('is_read',0)->count() ;
    }

    public function manage_message($sessions_id , $messages){
        $message = new Message();
        $message->session_id = $sessions_id ;
        $message->user_id = Auth::user()->id ;
        $message->message = $messages ;
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
