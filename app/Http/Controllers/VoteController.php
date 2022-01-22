<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    
    public function view(){
        $user_address = Auth::user()['address'];
        $path=resource_path();
        
        // 以下のサーバ情報等は別に保管する予定。一時的にベタ書き。Cred情報は別の場所に保管。
        $admin_host='20.0.0.160';
        $port='7416';
        $ruser='multichainrpc';
        $rpass='';

        $python_code="python3 $path/python/show_asset.py $admin_host $port $ruser $rpass $user_address";
        exec($python_code, $output, $status);
        // logger('test',[$output[0],$status]);


        return view('/statement',['result'=>$output[0]]);
    }

    public function check(){
        // logger('test',[$_POST]);
        return view('/vote-check',['candidate'=>$_POST['candidate']]);
    }

    public function vote(){
        $user_address = Auth::user()['address'];
        $user_name = Auth::user()['name'];
        $path=resource_path();

        // 以下のサーバ情報等は別に保管する予定。一時的にベタ書き。Cred情報は別の場所に保管。
        $admin_host='20.0.0.160';
        $port='7416';
        $ruser='multichainrpc';
        $rpass='';

        $candi_address='1URXJTtrc9gzWV9bWcmJnrAV6A8hQP88o4f4Xb';
        $asset_name='asset2';

        $python_code="python3 $path/python/vote_asset.py $admin_host $port $ruser $rpass $user_address $candi_address $asset_name";
        exec($python_code, $output, $status);
        
        return view('/vote-result',['result'=>$output[0]]);
    }

    public function sendAsset(){
        // APIを設定
    }
}