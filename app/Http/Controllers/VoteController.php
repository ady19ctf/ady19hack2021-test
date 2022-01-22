<?php

namespace App\Http\Controllers;
require '../vendor/autoload.php';

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Aws\SecretsManager\SecretsManagerClient; 
use Aws\Exception\AwsException;



class VoteController extends Controller
{
    public function view(){
        logger('in view func');
        $hosts = array('test-chain00', 'test-chain01');
        $user_address = Auth::user()['address'];
        $path=resource_path();

        $own_wallet=$this->getOwnWalletHost($hosts, $user_address);
        logger('own wallet host',[$own_wallet]);

        $admin_host=$this->getAPIFactor("{$own_wallet}-ip");
        $port=$this->getAPIFactor("{$own_wallet}-port");
        $ruser=$this->getAPIFactor("{$own_wallet}-user");
        $rpass=$this->getAPIFactor("{$own_wallet}-pass");
        logger('JSON RPC INFO', [$ruser,$rpass]);

        $python_code="python3 $path/python/show_asset.py $admin_host $port $ruser $rpass $user_address";
        exec($python_code, $output, $status);

        return view('/statement',['result'=>$output[0]]);
    }

    public function check(){
        return view('/vote-check',['candidate'=>$_POST['candidate']]);
    }

    public function vote(){
        logger('in vote func');
        $hosts = array('test-chain00', 'test-chain01');
        $user_address = Auth::user()['address'];
        $path=resource_path();
        logger('own wallet host',[$hosts]);
        $own_wallet=$this->getOwnWalletHost($hosts, $user_address);
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