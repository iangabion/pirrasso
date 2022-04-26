<?php

namespace App\Http\Controllers;

use App\Block;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;
use App\Client;

class BlockController extends Controller
{
    //

    public function block(Request $request){
        $block = new Block();
        $block->user_id = Auth::user()->id;
        $block->blocked_user_id = $request->blocked_user_id;
        $block->save();

        return $block;
    }
    public function remove_block($id){
        $block = Block::findorfail($id);
        $block->delete();
        return 'Unblocked';
    }

    public function get_blocked(){
        return Block::where('user_id', Auth::user()->id)->get();

        // dd(Auth::user());
    }

    public function im_blocked(){
        return Block::where('blocked_user_id', Auth::user()->id)->get('user_id');
    }
}
