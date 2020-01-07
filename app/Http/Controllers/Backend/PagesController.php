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
    
    public function seller()
    {
        // $user = Auth::user();
        $clients = Client::all();
    	return view('pages/sellers/show' , compact('clients'));
    }
}
