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
$na=$_POST['na'];

$pn=$_POST['praname'];
$t=$_POST['time'];
$t1=$_POST['time1'];


$query2="delete from Indi_tabuken where time='$t1' and date like '%$uid%'";
$stmt2 = $dbh->query($query2);


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
<br>
<p>地域創生1の学生</p>
<p>ID：<?php echo $uid ?>　<?php echo $na ?>さんの実習登録内容を削除しました。</p>
<br>

<form action="k_region1_indi.php" method="post"><!--管理者登録ボタン-->
  <input type="hidden" name="uid" value="<?php echo $uid; ?>">
  <input type="hidden" name="rireki" value="<?php echo $uid; ?>">

  <input type="hidden" name="na" value="<?php echo $na; ?>">

  <input type="hidden" name="userid" value="<?php echo $id; ?>">
  <input type="hidden" name="username" value="<?php echo $n; ?>">
<input type="submit" name="kensaku" value="地域創生1のID：<?php echo $uid ?>　<?php echo $na ?>さんの履歴へ戻る" class="btn btn-outline-dark">
</form>


  <br>
  <p><a href="k_home.php">ホームへ</a></p>　

  </center>
  </body>
  </html>
