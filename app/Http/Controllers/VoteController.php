<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Aws\SecretsManager\SecretsManagerClient; 
use Aws\Exception\AwsException;

class VoteController extends Controller
{
    public $hosts;
    function __construct(){
        $this->hosts=array('test-chain00', 'test-chain01');
    }


    public function view(){
        logger('in view func');
        $user_address = Auth::user()['address'];

        $own_wallet=$this->getOwnWalletHost($this->hosts, $user_address);
        logger('own wallet host',[$own_wallet]);

        $asset_value=$this->getAssetValue($own_wallet, $user_address);
        return view('/statement',['result'=>$asset_value]);
    }


    public function check(){
        // $_POST['candidate']は"user-id,username"の形式になっている。複数の変数を別ページに渡すため
        $identifier_array=explode(",",$_POST['candidate']);
        $user_id=$identifier_array[0];
        $user_name=$identifier_array[1];

        return view('/vote-check',compact('user_id', 'user_name'));
    }

    public function getAssetValue($own_wallet, $user_address){
        logger('in getAssetValue func');
        $path=resource_path();
        $admin_host=$this->getAPIFactor("{$own_wallet}-ip");
        $port=$this->getAPIFactor("{$own_wallet}-port");
        $ruser=$this->getAPIFactor("{$own_wallet}-user");
        $rpass=$this->getAPIFactor("{$own_wallet}-pass");
        logger('JSON RPC INFO', [$ruser,$rpass]);

        $python_code="python3 $path/python/show_asset.py $admin_host $port $ruser $rpass $user_address";
        exec($python_code, $output, $status);

        return $output[0];
    }
    

    public function createVote(){
        $candidate_data_array=$this->getCandateData();

// 下の部分は将来的にgetCandateDataに含ませる------
        $candidate_data_with_realname=[];
        $database=env('DB_DATABASE', 'forge');
        $host=env('DB_HOST');
        $charset="utf8mb4";
        $database_user=env('DB_USERNAME', 'forge');
        $database_pass=env('DB_PASSWORD', '');

        foreach($candidate_data_array as $candidate_data){
            // var_dump($candidate_data);
            try{
                $pdo=new \PDO(
                    "mysql:dbname=$database;host=$host;charset=$charset",
                    $database_user,
                    $database_pass
                );
                
                $sql = "SELECT * FROM `candidates` WHERE `user-id` = '".$candidate_data['name']."'";

                foreach ($pdo->query($sql) as $row) {
                    $tmp_array=array('real_name'=>$row['name']);
                    // var_dump($tmp_array);
                    // print('<br>');
                    array_push($candidate_data_with_realname,array_merge($candidate_data,$tmp_array));
                    // var_dump($candidate_data_with_realname);
                    // print('<br>');
                }
            }catch (PDOException $e){
                print('Error:'.$e->getMessage());
                die();
            }
        }
//--------------------------------------------

        // 引数として渡す配列は立候補者の氏名を最終要素に付与する必要がある。
        return view('/vote')->with('candidate_data_with_realname',$candidate_data_with_realname);
    }


    public function vote(){
        logger('in vote func');
        $hosts = array('test-chain00', 'test-chain01');
        $user_address = Auth::user()['address'];
        $user_id=Auth::user()['name'];
        $path=resource_path();
        logger('own wallet host',[$this->hosts]);
        $own_wallet=$this->getOwnWalletHost($this->hosts, $user_address);
        logger('own wallet host',[$own_wallet]);

        $admin_host=$this->getAPIFactor("{$own_wallet}-ip");
        $port=$this->getAPIFactor("{$own_wallet}-port");
        $ruser=$this->getAPIFactor("{$own_wallet}-user");
        $rpass=$this->getAPIFactor("{$own_wallet}-pass");
        logger('JSON RPC INFO', [$ruser,$rpass]);



        $database=env('DB_DATABASE', 'forge');
        $host=env('DB_HOST');
        $charset="utf8mb4";
        $database_user=env('DB_USERNAME', 'forge');
        $database_pass=env('DB_PASSWORD', '');
        $candidate_name=$_POST['candidate'];
        try{
            $pdo=new \PDO(
                "mysql:dbname=$database;host=$host;charset=$charset",
                $database_user,
                $database_pass
            );
            $sql = "select * from users where name='$candidate_name'";
            foreach ($pdo->query($sql) as $row) {
                $candidate_address=$row['address'];
            }
        }catch (PDOException $e){
            print('Error:'.$e->getMessage());
            die();
        }


        $asset_name='asset2';
        // 投票処理に失敗したらデータベースのフラグ処理は行わない
        try{
            $python_code="python3 $path/python/vote_asset.py $admin_host $port $ruser $rpass $user_address $candidate_address $asset_name";
            exec($python_code, $output, $status);
            $pdo=new \PDO(
                "mysql:dbname=$database;host=$host;charset=$charset",
                $database_user,
                $database_pass
            );
            $sql = "update users set voted_flag='True' where name='$user_id'";
            $pdo->query($sql);
        }catch (PDOException $e){
            print('Error:'.$e->getMessage());
            die();
        }

        return view('/vote-result',['result'=>$output[0]]);
    }

    public function monitorVote(){
        $candidate_data_array=[];

        $database=env('DB_DATABASE', 'forge');
        $host=env('DB_HOST');
        $charset="utf8mb4";
        $database_user=env('DB_USERNAME', 'forge');
        $database_pass=env('DB_PASSWORD', '');
        try{
            $pdo=new \PDO(
                "mysql:dbname=$database;host=$host;charset=$charset",
                $database_user,
                $database_pass
            );
            $sql = "select * from users where voted_flag='True'";
            foreach ($pdo->query($sql) as $row) {
                $candidate_data=array('user-id'=>$row['name'],'email'=>$row['email'],'address'=>$row['address']);
                array_push($candidate_data_array,$candidate_data);
            }
        }catch (PDOException $e){
            print('Error:'.$e->getMessage());
            die();
        }

        return view('/vote-monitor')->with('candidate_data_array',$candidate_data_array);
    }


    public function showResult(){
        logger('in showresult func');
        $candidate_data_array=$this->getCandateData();

        $candidate_data_with_realname=[];
        $database=env('DB_DATABASE', 'forge');
        $host=env('DB_HOST');
        $charset="utf8mb4";
        $database_user=env('DB_USERNAME', 'forge');
        $database_pass=env('DB_PASSWORD', '');
        foreach($candidate_data_array as $candidate_data){
            // var_dump($candidate_data);
            try{
                $pdo=new \PDO(
                    "mysql:dbname=$database;host=$host;charset=$charset",
                    $database_user,
                    $database_pass
                );
                
                $sql = "SELECT * FROM `candidates` WHERE `user-id` = '".$candidate_data['name']."'";

                foreach ($pdo->query($sql) as $row) {
                    $tmp_array=array('real_name'=>$row['name']);
                    // var_dump($tmp_array);
                    // print('<br>');
                    array_push($candidate_data_with_realname,array_merge($candidate_data,$tmp_array));
                    // var_dump($candidate_data_with_realname);
                    // print('<br>');
                }
            }catch (PDOException $e){
                print('Error:'.$e->getMessage());
                die();
            }
        }

        // var_dump($candidate_data_array);
        foreach ($candidate_data_with_realname as $candidate => $candidate_data) {
            $vote_array[] = $candidate_data['vote'];
        }
        array_multisort($vote_array, SORT_DESC, $candidate_data_with_realname);
        // print("<br>");
        // print("<br>");
        // var_dump($candidate_data_array);
        return view('/selection-result')->with('candidate_data_with_realname',$candidate_data_with_realname);
    }


    public function getCandateData(){
        // 立候補者のアドレス一覧を取得
        // データベースにアクセスし、ユーザの種別が候補者のユーザのアドレスを取得する。ユーザ名も併せて。
        // 立候補者ユーザ情報のarrayのarrayを戻り値とする。2次元配列。
        $database=env('DB_DATABASE', 'forge');
        $host=env('DB_HOST');
        $charset="utf8mb4";
        $database_user=env('DB_USERNAME', 'forge');
        $database_pass=env('DB_PASSWORD', '');
        $candidate_data_array=array();

        try{
            $pdo=new \PDO(
                "mysql:dbname=$database;host=$host;charset=$charset",
                $database_user,
                $database_pass
            );
            $sql = 'select * from users where typeId=1';
            foreach ($pdo->query($sql) as $row) {
                $user_name=$row['name'];
                $user_address=$row['address'];
                // 候補者サーバのホスト名はenvファイルに記載前提
                $candidate_wallet=env('CANDIDATE_SERVER');
                // print($candidate_wallet);
                if($candidate_wallet==''){
                    $candidate_wallet=$this->getOwnWalletHost($this->hosts, $user_address);
                }
                $candidate_asset=$this->getAssetValue($candidate_wallet, $user_address);
                $candidate_data=array('name'=>$user_name, 'address'=>$user_address, 'vote'=>$candidate_asset);
                // $candidate_data=array($user_name, $user_address, $candidate_asset);
                array_push($candidate_data_array,$candidate_data);
            }
        }catch (PDOException $e){
            print('Error:'.$e->getMessage());
            die();
        }

        return $candidate_data_array;
    }


    public function getAPIFactor($key){
        logger('in getAPIFactor func');
        $client = new SecretsManagerClient([
            'version' => '2017-10-17',
            'region' => 'ap-northeast-1',
        ]);
        $secretName = env('SECRET_NAME'); //written in .env file
        $result = $client->getSecretValue([
            'SecretId' => $secretName,
        ]);
        try {
            $result = $client->getSecretValue([
                'SecretId' => $secretName,
            ]);
        } catch (AwsException $e) {
            $error = $e->getAwsErrorCode();
            if ($error == 'DecryptionFailureException') {
                // Secrets Manager can't decrypt the protected secret text using the provided AWS KMS key.
                // Handle the exception here, and/or rethrow as needed.
                throw $e;
            }
            if ($error == 'InternalServiceErrorException') {
                // An error occurred on the server side.
                // Handle the exception here, and/or rethrow as needed.
                throw $e;
            }
            if ($error == 'InvalidParameterException') {
                // You provided an invalid value for a parameter.
                // Handle the exception here, and/or rethrow as needed.
                throw $e;
            }
            if ($error == 'InvalidRequestException') {
                // You provided a parameter value that is not valid for the current state of the resource.
                // Handle the exception here, and/or rethrow as needed.
                throw $e;
            }
            if ($error == 'ResourceNotFoundException') {
                // We can't find the resource that you asked for.
                // Handle the exception here, and/or rethrow as needed.
                throw $e;
            }
        }

        // Decrypts secret using the associated KMS CMK.
        // Depending on whether the secret is a string or binary, one of these fields will be populated.
        if (isset($result['SecretString'])) {
            $secret = $result['SecretString'];
        } else {
            $secret = base64_decode($result['SecretBinary']);
        }
        $secret = json_decode($secret,true)[$key];
        
        return $secret;
    }

    
    // 該当のホストが見つからない場合のエラー処理を入れる必要あり。
    public function getOwnWalletHost($hosts, $user_address){
        logger('in getOwnWalletHost func');
        $path=resource_path();
        $get_address_flg=FALSE;
        $own_wallet='';

        foreach($hosts as $host){
            $addresses='';
            $admin_host=$this->getAPIFactor("{$host}-ip");
            $port=$this->getAPIFactor("{$host}-port");
            $ruser=$this->getAPIFactor("{$host}-user");
            $rpass=$this->getAPIFactor("{$host}-pass");
            logger('connecting chain server', [$admin_host,$port]);
    
            $python_code="python3 $path/python/get_addresses.py $admin_host $port $ruser $rpass";
            exec($python_code, $addresses, $status);
            logger('address result', [$status, $addresses]);
            
            //文字列型の配列をPHPの配列型に変換。いずれ正規表現で。
            $addresses=str_replace(' \'', '', $addresses);
            $addresses=str_replace('\'', '', $addresses);
            $addresses=str_replace('[', '', $addresses);
            $addresses=str_replace(']', '', $addresses);
            $addresses=explode(",", $addresses[0]);
    
            $is_this_host=in_array($user_address, $addresses);
            if($is_this_host){
                logger('address is in', [$host]);
                $get_address_flg=TRUE;
                $own_wallet=$host;
                break;
            }else{
                logger('address is not in', [$host]);            
            }
        }
        if($get_address_flg==FALSE){
            logger("address {$user_address} cannot be found...");
        }

        return $own_wallet;
    }
}