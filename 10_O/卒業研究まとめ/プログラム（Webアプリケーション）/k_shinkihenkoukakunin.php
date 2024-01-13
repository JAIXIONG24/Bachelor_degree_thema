<?php

// My SQL データベースの接続
require_once __DIR__ . '/header.php';
define('DB_DATABASE','tabusalab');
define('DB_USERNAME','root');
define('DB_PASSWORD','tabusalab');
define('PDO_DSN','mysql:dbhost=tbsv.japanwest.cloudapp.azure.com;dbname=tabusalab');

try{
    $dbh=new PDO(PDO_DSN , DB_USERNAME , DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $dbh->query('SET NAMES utf8'); //文字化けの解消
}catch(PDOException $e){
    echo $e->getMessage();
    exit();
}

$id=$_POST['userid'];
$n=$_POST['username'];


$uid=$_POST['usid'];
$un=$_POST['uname'];
$p=$_POST['pass'];


?>
<link rel="stylesheet" href="http://tbsv.japanwest.cloudapp.azure.com/apps/tabusalab2.css" type="text/css">

<!DOCTYPE html>

<html lang="ja">
<body>
	<center>
	<font size="5">
    <h1>地域創生演習実施履歴管理</h1>
	</font>


<?php
$key = '長い鍵';
$plain_text = $p;
$c_t = openssl_encrypt($plain_text, 'AES-128-ECB', $key);

$query="select count(*) as cum from User_tabuken where pass='$c_t'";
   $stmt = $dbh->query($query);
   $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
   foreach($rec as $row ){
     $c=$row['cum'];

   }

  $pa=strlen($p);
if($_POST['delete']){

  $uid=$_POST['usid'];
  $un=$_POST['uname'];
  $p=$_POST['pass'];


  echo "<p>管理者削除確認</p>";
  echo "<table border='1' class='type1'>";//実習先一覧のテーブル
  echo "<tr><th>管理者id</th><th>管理者名</th><th>管理者password</th></tr>";

  echo "<tr><td>$uid</td>";
  echo "<td>$un</td>";
  echo "<td>設定したパスワード</td></tr>";

  echo "</table>";
  echo "<br>";

?>
  <form action="k_shinkidelete.php" method="POST">
    <input type="hidden" name="usid" value="<?php echo $uid; ?>">
    <input type="hidden" name="uname" value="<?php echo $un; ?>">
  <input type="submit" name="delete" value="削除" class="btn btn-danger">
</form>

<?php


}else if(empty($_POST['uname'] && $_POST['pass'])){
  echo "<p>管理者変更確認</p>";
  echo"全ての項目を入力してください。";

}else{
  if($pa>=6){
      if($c==0){

  echo "<p>管理者変更確認</p>";
  echo "<br>";

  $un=$_POST['uname'];
  $p=$_POST['pass'];

  echo "<table border='1' class='type1'>";//実習先一覧のテーブル
  echo "<tr><th>管理者id</th><th>管理者名</th><th>管理者password</th></tr>";

  echo "<tr><td>$uid</td>";
  echo "<td>$un</td>";
  echo "<td>設定したパスワード</td></tr>";

  echo "</table>";
  echo "<br>";

 ?>

  <form action="k_shinkihenkoukanryo.php" method="post"><!--管理者登録ボタン-->
    <input type="hidden" name="usid" value="<?php echo $uid; ?>">
    <input type="hidden" name="uname" value="<?php echo $un; ?>">
    <input type="hidden" name="pass" value="<?php echo $p; ?>">

    <input type="hidden" name="userid" value="<?php echo $id; ?>">
    <input type="hidden" name="username" value="<?php echo $n; ?>">
  <input type="submit" name="kensaku" value="登録" class="btn btn-success">
</form>

<?php
}else{
  echo "<p>管理者変更確認</p>";
  echo "<br>";
  echo "そのパスワードは使えません。";
  echo "<br>";
  echo "パスワードを変更してください。";

}
}else{
  echo "<p>管理者変更確認</p>";
  echo "<br>";
  echo "パスワードが正しく入力されていません";
  echo "<br>";
   echo "パスワードは半角英数字の6桁以上で入力してください";

  echo "<br>";




}
}

?>

<br>
<br>
<form action="k_shinkihenkou.php" method="post"><!--管理者登録ボタン-->
  <input type="hidden" name="usid" value="<?php echo $uid; ?>">
  <input type="hidden" name="uname" value="<?php echo $un; ?>">
  <input type="hidden" name="pass" value="<?php echo $p; ?>">

  <input type="hidden" name="userid" value="<?php echo $id; ?>">
  <input type="hidden" name="username" value="<?php echo $n; ?>">
<input type="submit" name="kensaku" value="戻る" class="btn btn-dark">
</form>




   </center>
</body>
</html>
