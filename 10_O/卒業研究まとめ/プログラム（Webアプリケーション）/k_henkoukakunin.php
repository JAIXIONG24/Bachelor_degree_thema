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


$pid=$_POST['praid'];
$pn=$_POST['praname'];
$pt=$_POST['pratime'];
$pp1=$_POST['praplace1'];
$pp2=$_POST['praplace2'];
$pu=$_POST['prauser'];

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

if($_POST['delete']){

  $pid=$_POST['praid'];
  $pn=$_POST['praname'];
  $pt=$_POST['pratime'];
  $pp1=$_POST['praplace1'];
  $pp2=$_POST['praplace2'];
  $pu=$_POST['prauser'];

  echo "実習先削除確認";
  echo "<br>";
  echo "<br>";

  echo "<table border='1'>";//実習先一覧のテーブル
  echo "<tr><th>実習id</th><th>実習名</th><th>実習時間</th><th>実習場所　緯度</th><th>実習場所　経度</th><th>実習担当者</th></tr>";

  echo "<tr><td>$pid</td>";
  echo "<td>$pn</td>";
  echo "<td>$pt</td>";
  echo "<td>$pp1</td>";
  echo "<td>$pp2</td>";
  echo "<td>$pu</td>";

  echo "</table>";
  echo "<br>";

?>
  <form action="k_deletekanryo.php" method="POST">
    <input type="hidden" name="praid" value="<?php echo $pid; ?>">
  <input type="submit" name="delete" value="削除" class="btn btn-danger">
</form>

<?php


}else if(empty($_POST['praname'] && $_POST['pratime'] && $_POST['praplace1'] && $_POST['praplace2'] && $_POST['prauser'])){
  echo"全ての項目を入力してください。";


}else{
  $pt = mb_convert_kana($pt, 'a','UTF-8');
  $pp1 = mb_convert_kana($pp1, 'a','UTF-8');
  $pp2 = mb_convert_kana($pp2, 'a','UTF-8');

  if(is_numeric($pt) && is_numeric($pp1) && is_numeric($pp2)){



  $pid=$_POST['praid'];
  $pn=$_POST['praname'];
  $pu=$_POST['prauser'];

  echo "実習先変更確認";
  echo "<br>";
  echo "<br>";


  echo "<table border='1'>";//実習先一覧のテーブル
  echo "<tr><th>実習id</th><th>実習名</th><th>実習時間</th><th>実習場所　緯度</th><th>実習場所　経度</th><th>実習担当者</th></tr>";

  echo "<tr><td>$pid</td>";
  echo "<td>$pn</td>";
  echo "<td>$pt</td>";
  echo "<td>$pp1</td>";
  echo "<td>$pp2</td>";
  echo "<td>$pu</td></tr>";

  echo "</table>";
  echo "<br>";
 ?>

  <form action="k_henkoukanryo.php" method="POST">
    <input type="hidden" name="praid" value="<?php echo $pid; ?>">
    <input type="hidden" name="praname" value="<?php echo $pn; ?>">
    <input type="hidden" name="pratime" value="<?php echo $pt; ?>">
    <input type="hidden" name="praplace1" value="<?php echo $pp1; ?>">
    <input type="hidden" name="praplace2" value="<?php echo $pp2; ?>">
    <input type="hidden" name="prauser" value="<?php echo $pu; ?>">

    <input type="hidden" name="userid" value="<?php echo $id; ?>">
    <input type="hidden" name="username" value="<?php echo $n; ?>">
  <input type="submit" name="kensaku" value="登録" class="btn btn-success">
</form>


<?php
}else{
  echo "半角数字を入力してください。";


}

}


 ?>

<br>
 <form action="k_henkou.php" method="POST">
   <input type="hidden" name="praid" value="<?php echo $pid; ?>">
   <input type="hidden" name="praname" value="<?php echo $pn; ?>">
   <input type="hidden" name="pratime" value="<?php echo $pt; ?>">
   <input type="hidden" name="praplace1" value="<?php echo $pp1; ?>">
   <input type="hidden" name="praplace2" value="<?php echo $pp2; ?>">
   <input type="hidden" name="prauser" value="<?php echo $pu; ?>">

   <input type="hidden" name="userid" value="<?php echo $id; ?>">
   <input type="hidden" name="username" value="<?php echo $n; ?>">
 <input type="submit" name="kensaku" value="戻る" class="btn btn-dark">
</form>


   </center>
</body>
</html>
