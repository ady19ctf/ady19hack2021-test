<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class VoteController extends Controller
{
    public function vote(){
        $user_address = Auth::user()['address'];
        $user_name = Auth::user()['name'];

        if (isset($_POST['vote_for_a'])) {
            $candidate_address='hogehoge';
            return view('/vote-result',['result'=>$user_name]);
        }
        elseif (isset($_POST['vote_for_b'])) {
            $candidate_address='hogehoge';
            return view('/vote-result',['result'=>$user_address]);
        }
        elseif (isset($_POST['vote_for_c'])) {
            $candidate_address='hogehoge';
            return view('/vote-result',['result'=>$user_address]);
        }
        
        return view('/vote-result',['result'=>$user_address]);
    }

    public function sendAsset(){
        // APIを設定
    }
}