<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('user.vote.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // return view('auth.VoteResult');
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



// ********************************************************************************* //
// ここから下がコピペ

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
        return view('vote-check',['candidate'=>$_POST['candidate']]);
        // return view('user.vote.check',['candidate'=>$_POST['candidate']]);
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

    public function vote(){
        logger('in vote func');
        $hosts = array('test-chain00', 'test-chain01');
        $user_address = Auth::user()['address'];
        $path=resource_path();
        logger('own wallet host',[$this->hosts]);
        $own_wallet=$this->getOwnWalletHost($this->hosts, $user_address);
        logger('own wallet host',[$own_wallet]);

        $admin_host=$this->getAPIFactor("{$own_wallet}-ip");
        $port=$this->getAPIFactor("{$own_wallet}-port");
        $ruser=$this->getAPIFactor("{$own_wallet}-user");
        $rpass=$this->getAPIFactor("{$own_wallet}-pass");
        logger('JSON RPC INFO', [$ruser,$rpass]);

        $candi_address='1URXJTtrc9gzWV9bWcmJnrAV6A8hQP88o4f4Xb';
        $asset_name='asset2';

        $python_code="python3 $path/python/vote_asset.py $admin_host $port $ruser $rpass $user_address $candi_address $asset_name";
        exec($python_code, $output, $status);
        
        return view('/vote-result',['result'=>$output[0]]);
    }

    public function showresult(){
        logger('in showresult func');
        // 立候補者のアドレス一覧を取得
        // データベースにアクセスし、ユーザの種別が候補者のユーザのアドレスを取得する。ユーザ名も併せて。
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
            $sql = 'select * from users where typeId=1';
            foreach ($pdo->query($sql) as $row) {
                $user_name=$row['name'];
                $user_address=$row['address'];
                print($user_name);
                print("<br>");
                print($user_address);
                print("<br>");

                // 候補者サーバのホスト名はenvファイルに記載前提
                $candidate_wallet=env('CANDIDATE_SERVER');
                print($candidate_wallet);
                if($candidate_wallet==''){
                    $candidate_wallet=$this->getOwnWalletHost($this->hosts, $user_address);
                }

                print($candidate_wallet);
                print("<br>");

                $candidate_asset=$this->getAssetValue($candidate_wallet, $user_address);
                print($candidate_asset);
                print("<br>");

                
            }
        }catch (PDOException $e){
            print('Error:'.$e->getMessage());
            die();
        }

        // 立候補者の各アドレスの得票数（アセット数）を取得


        // 各アセット数でソート

        // ソート結果のグラフに描画

        // ソートした配列をViewに渡す。

        return view('/selection-result');
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
