<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Client ;
use Auth ;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clients = Client::orderBy('created_at' , 'desc')->get();
        $clients = collect($clients)->map(function ($client) {
            return [
                'id' => $client->id ,
                'fullname' => $client->first_name .' '. $client->last_name,
                'email'=>$client->email ,
                'mobile'=>$client->mobile,
                'username'=>$client->username ,
                'profile_pic' => $client->image,
                'social_id' => $client->social_id,
                'total_items'=>'0'
            ];
        });
        return $clients;
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
        $validatedData = $request->validate([
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email|unique:clients,email',
            'mobile' => 'required|min:3',
            'username' => 'required|min:3|unique:clients,username',
            'password' => 'required|min:4',
            'profile_picture' => 'nullable'
        ]);

        if($validatedData) {
            $client = new Client();
            $client->first_name = $request->first_name ;
            $client->last_name = $request->last_name ;
            $client->email = $request->email ;
            $client->mobile = $request->mobile ;
            $client->username = $request->username ;
            $client->password = Hash::make($request->password) ;

            if($request->profile_picture){
                $image = $request->profile_picture;  // your base64 encoded
                list($type, $image) = explode(';', $image);
                list(, $image)      = explode(',', $image);
                $data = base64_decode($image);
                $imageName = date("YmdHis"). '.' . 'jpeg';
                file_put_contents(public_path() . '/' . 'images/user_profile/' . $imageName, $data);
                $client->image = $imageName ;
            }
            $client->save();
            return $client;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showClient($id)
    {
        $client = Client::with('items.photos','items.category')->find($id);
        return $client->paginate(10);
    }

    public function show($id)
    {
        $client = Client::with('items.photos','items.category')->find($id);
        return $client;
    }

    // public function show(Request $request){
    //     $clients = Client::query();
    //     $clients->with('items.photos','items.category');
    //     $keyword = $request->input('keyword');
    //     $clients->where(function($query) use($keyword){
    //         $query  ->where('username', 'LIKE', "%$keyword%");
    //     });
    //     return $clients->orderBy('created_at', 'desc')->paginate(10);
    // }

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
        $client = Client::findorfail($id);
        $client->delete();
        return 'successfully deleted' ;
    }

    public function out()
    {
        Auth::logout();
        return redirect('/login');
    }
}
