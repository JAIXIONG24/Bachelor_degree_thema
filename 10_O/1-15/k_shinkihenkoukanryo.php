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


$y=date("Y");
$d=$y.$uid;

$pp=password_hash($pa, PASSWORD_DEFAULT);

$query="update User_tabuken set username='$un',pass='$pp',date='$d' where userid='$uid'";//実習一覧の表示
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
<p>管理者変更</p>
<p>管理者ID：<?php echo $uid ?>　<?php echo $un ?>さんを変更しました。</p>
<br>

<p><a href="k_shinki.php">管理者登録・削除画面へ</a></p>　
<br>
<p><a href="k_home.php">ホームへ</a></p>　
     </center>
</body>
</html>
