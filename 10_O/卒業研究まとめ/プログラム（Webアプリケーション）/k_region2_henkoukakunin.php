<?php
require_once __DIR__ . '/header.php';
// My SQL データベースの接続
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

$uid=$_POST['uid'];
$r=$_POST['usid'];

$na=$_POST['na'];

$pn=$_POST['praname'];
$t1=$_POST['time1'];
$t=$_POST['time'];
$pt=$_POST['pratime'];

?>
<link rel="stylesheet" href="http://tbsv.japanwest.cloudapp.azure.com/apps/tabusalab2.css" type="text/css">

<!DOCTYPE html>

<html lang="ja">
<body>
	<center>
	<font size="5">
    <h1>地域創生演習実施履歴管理</h1>
	</font>
	<br>

<br>

<?php
if($_POST['delete']){

  echo "user実習登録内容削除確認";
  echo "<br>";
  echo "<br>";

  echo"地域創生2の学生";
  echo"実習学生ID：".$uid."　".$na."さん";
  echo "<br>";

  echo "<table border='1' class='type2'>";//実習先一覧のテーブル
  echo "<tr><th>日付</th><th>実習内容</th><th>実習時間</th></tr>";

  echo "<tr><td>$t</td>";
  echo "<td>$pn</td>";
  echo "<td>$pt</td></tr>";

  echo "</table>";
  echo "<br>";

  ?>

   <form action="k_region2_henkoudelete.php" method="post"><!--管理者登録ボタン-->
     <input type="hidden" name="uid" value="<?php echo $uid; ?>">
     <input type="hidden" name="uname" value="<?php echo $un; ?>">
     <input type="hidden" name="pass" value="<?php echo $p; ?>">

     <input type="hidden" name="na" value="<?php echo $na; ?>">

     <input type="hidden" name="praname" value="<?php echo $pn; ?>">
     <input type="hidden" name="time" value="<?php echo $t; ?>">
    <input type='hidden' name='pratime' value="<?php echo $pt; ?>">

     <input type="hidden" name="userid" value="<?php echo $id; ?>">
     <input type="hidden" name="username" value="<?php echo $n; ?>">
   <input type="submit" name="kensaku" value="削除" class="btn btn-danger">
 </form>
 <?php

}else if(empty($_POST['time'])){
  echo"全ての項目を入力してください。";

}else{
  echo "user実習登録内容変更確認";
  echo "<br>";
  echo "<br>";

  echo"地域創生2の学生";
  echo"実習学生ID：".$uid."　".$na."さん";
  echo "<br>";

  echo "<table border='1' class='type2'>";//実習先一覧のテーブル
  echo "<tr><th>日付</th><th>実習内容</th><th>実習時間</th></tr>";

  echo "<tr><td>$t</td>";
  echo "<td>$pn</td>";
  echo "<td>$pt</td></tr>";

  echo "</table>";
  echo "<br>";

  ?>

   <form action="k_region2_henkoukanryo.php" method="post"><!--管理者登録ボタン-->
     <input type="hidden" name="uid" value="<?php echo $uid; ?>">
     <input type="hidden" name="uname" value="<?php echo $un; ?>">
     <input type="hidden" name="pass" value="<?php echo $p; ?>">

     <input type="hidden" name="na" value="<?php echo $na; ?>">

     <input type="hidden" name="praname" value="<?php echo $pn; ?>">
     <input type="hidden" name="time" value="<?php echo $t; ?>">
    <input type='hidden' name='pratime' value="<?php echo $pt; ?>">
    <input type="hidden" name="time1" value="<?php echo $t1; ?>">

     <input type="hidden" name="userid" value="<?php echo $id; ?>">
     <input type="hidden" name="username" value="<?php echo $n; ?>">
   <input type="submit" name="kensaku" value="登録" class="btn btn-success">
 </form>

 <?php
}
echo "<br>";
 ?>

<br>
 <br>
 <form action="k_region2_henkou.php" method="post"><!--管理者登録ボタン-->
   <input type="hidden" name="uid" value="<?php echo $uid; ?>">
   <input type="hidden" name="rireki" value="<?php echo $r; ?>">

   <input type="hidden" name="na" value="<?php echo $na; ?>">

   <input type="hidden" name="praname" value="<?php echo $pn; ?>">
   <input type="hidden" name="time" value="<?php echo $t; ?>">
  <input type='hidden' name='pratime' value="<?php echo $pt; ?>">


   <input type="hidden" name="userid" value="<?php echo $id; ?>">
   <input type="hidden" name="username" value="<?php echo $n; ?>">
 <input type="submit" name="kensaku" value="戻る" class="btn btn-dark">
 </form>
