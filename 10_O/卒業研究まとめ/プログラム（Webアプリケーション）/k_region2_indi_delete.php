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


$query2="delete Indi_tabuken from Indi_tabuken inner join User_tabuken on Indi_tabuken.date=User_tabuken.date where User_tabuken.userid='$uid' and User_tabuken.kind=2";
$stmt2 = $dbh->query($query2);

$query="delete from User_tabuken where userid='$uid' and kind=2";
$stmt = $dbh->query($query);

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
<p>user削除確認</p>
<br>
<p>地域創生2の学生</p>
<p>ID：<?php echo $uid ?>　<?php echo $na ?>さんのアカウントを削除しました。</p><br><br>


  <br>
  <p><a href="k_region2.php">地域創生演習2の学生一覧へ</a></p>
  <p><a href="k_home.php">ホームへ</a></p>

  </center>
  </body>
  </html>
