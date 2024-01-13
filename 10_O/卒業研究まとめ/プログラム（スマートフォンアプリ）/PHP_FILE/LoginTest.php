<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){

  // アプリから入力したデーターを受け取り
  $userid = $_POST["user_id"];
  $pass = $_POST["pass"];


  //サーバーに接続するファイルに処理する

  require_once 'init.php';


  //MYsqlに入力したuseriとパスワードが存在するかどうか調べる
  $query ="SELECT * FROM User_tabuken WHERE userid='$userid'";
  $stmt1 = $dbh->query($query);
  $rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

  $temp_array  = array();



  if($rec1){

    //入力したuseridとパスワードがあった場合、DBのデーターをtemp_Arrayに入れる

    foreach($rec1 as $row){
        $temp_array['graid'] = $row['graid'];
        $temp_array['userid'] = $row['userid'];
        $temp_array['username'] = $row['username'];
        $temp_array['pass'] = $row['pass'];
        $temp_array['kind'] = $row['kind'];
        $temp_array['access'] = $row['access'];
        $temp_array['date'] = $row['date'];
        
        $a = $temp_array['username'];
        $b = $temp_array['userid'];
    
        
    
      }

        $key = '長い鍵';
        $plain_text =$pass;
    
        $c_t =openssl_encrypt($plain_text, 'AES-128-ECB', $key);
    
    
      //アプリから入力したuseridとパスワードを認証する
       if ($temp_array['userid']==$userid && $temp_array['pass']==$c_t) {
           // if ($temp_array['userid'] == $userid && 	$temp_array['pass'] == $pass) {
          // 認証が成功する場合
    
          $result['success'] = "1";
          $result['username'] = $a;
          $result['userid'] = $b;
          $result['message'] = "success";
    
    
        }else{
           // ログインできない場合
          $result['success'] = "0";
          $result['message'] = "error";
    
        }

    
  }else{
    $result['success'] = "2";
    $result['message'] = "no this username";


  }

//Jsonデーターを保存して出力する
echo json_encode($result);
mysqli_close($dbh);


}

?>
