<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
  //アプリから登録したデーターを受け取り

  $p = $_POST["praid"];
//   $paraname =$_POST["paraname"];
//   $pratime =$_POST["pratime"];
//   $praplace =$_POST["praplace"];
//   $prauser = $_POST["prauser"];



	require_once 'init.php';

  //MySqlにデーターを登録する
  $query ="SELECT praid, praname, pratime, ST_X(praplace), ST_Y(praplace), prauser FROM Pra_tabuken WHERE praid='$p'";
  $stmt = $dbh->query($query);
  //データーが登録できるかどうか調べる
  $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $temp_array  = array();


  

  if($rec){

    //入力したuseridとパスワードがあった場合、DBのデーターをtemp_Arrayに入れる

    foreach($rec as $row){
        $temp_array['praid'] = $row['praid'];
        $temp_array['praplace_x'] = $row['ST_X(praplace)'];
        $temp_array['praplace_y'] = $row['ST_Y(praplace)'];
        $temp_array['praname'] = $row['praname'];
        $temp_array['pratime'] = $row['pratime'];
        $temp_array['prauser'] = $row['prauser'];
        
        
        $a = $temp_array['praplace_x'];
        $b = $temp_array['praplace_y'];
        $c = $temp_array['praid'];
        
       
      }
    
      //アプリから入力したuseridとパスワードを認証する
       if ($c==$p) {
           // if ($temp_array['userid'] == $userid && 	$temp_array['pass'] == $pass) {
          // 認証が成功する場合
    
          $result['success'] = "1";
          $result['praname'] = $temp_array['praname'];
          $result['praplace_x'] = $a;
          $result['praplace_y'] = $b;
          $result['praid'] =   $temp_array['praid'];
          $result['message'] = "success";
    
    
        }else{
           // ログインできない場合
          $result['success'] = "0";
          $result['message'] = "error";
    
        }

  }else{

    $result['success'] = "2";
    $result['message'] = "This server don't have this praid";

  }

//Jsonデーターを保存して出力する
echo json_encode($result);
mysqli_close($dbh);


}

?>
