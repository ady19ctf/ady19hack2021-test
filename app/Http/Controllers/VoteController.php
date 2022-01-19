<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function vote(){
        $user_address = Auth::user()['address'];
        $user_name = Auth::user()['name'];
        $path=resource_path();

        // 以下のサーバ情報等は別に保管する予定。一時的にベタ書き。Cred情報は別の場所に保管。
        $admin_host='20.0.0.160';
        $port='7416';
        $ruser='';
        $rpass='';

        if (isset($_POST['vote_for_a'])) {
            $candidate_address='hogehoge';
            return view('/vote-result',['result'=>$user_name]);
        }
        elseif (isset($_POST['vote_for_b'])) {
            $candidate_address='hogehoge';
            // logger('test',['foo' => 'bar']);
            return view('/vote-result',['result'=>$user_address]);
        }
        elseif (isset($_POST['vote_for_c'])) {
            $candidate_address='hogehoge';
            logger('voting test', [$admin_host, $port, $ruser, $rpass, $user_address]);
            $python_code="python3 $path/python/show_asset.py $admin_host $port $ruser $rpass $user_address";
            exec($python_code, $output, $status);
            // logger('test',[$python_code,$status]);
            return view('/vote-result',['result'=>$output[0]]);
        }
        
        return view('/vote-result',['result'=>$user_address]);
    }

    public function sendAsset(){
        // APIを設定
    }
}