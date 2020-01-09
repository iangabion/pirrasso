<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Client;


class PagesController extends Controller
{
    //
    public function home()
    {
        // $user = Auth::user();
    	return view('pages/dashboard/show');
    }

    public function category()
    {
        // $user = Auth::user();
        $category = Category::orderBy('created_at' , 'desc')->get();
    	return view('pages/category/show', compact('category'));
    }
    
    // seller part
    // list
    public function seller()
    {
        $clients = Client::paginate(12);
    	return view('pages/sellers/show' , compact('clients'));
    }
    // view
    public function view_seller($id)
    {
        $client = Client::find($id) ;
    	return view('pages/sellers/view' , compact('client'));
    }
}
