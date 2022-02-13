<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoteStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //index関数の中にベダ書きしたが、お作法的には別にしたほうが良いのだろうか。。。
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
                // 投票済みのユーザだけ抽出するため、statusは'Voted'の文字列を直接入れてしまう。
                $candidate_data=array('user-id'=>$row['name'],'email'=>$row['email'],'address'=>$row['address'], 'status'=>'Voted');
                array_push($candidate_data_array,$candidate_data);
            }
        }catch (PDOException $e){
            print('Error:'.$e->getMessage());
            die();
        }

        return view('admin.VoteStatus.index')->with('candidate_data_array',$candidate_data_array);
        // return view('admin.VoteStatus.index');
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

        return view('admin.VoteStatus.index')->with('candidate_data_array',$candidate_data_array);
    }


}
