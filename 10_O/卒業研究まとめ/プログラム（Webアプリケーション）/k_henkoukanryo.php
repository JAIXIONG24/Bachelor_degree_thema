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

$query="update Pra_tabuken set praname='$pn',pratime=$pt,praplace=ST_GeomFromText('POINT($pp1 $pp2)'),prauser='$pu' where praid='$pid'";
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
<p>実習先変更確認</p>
<br>
<p>実習先を変更しました。</p>
<br>

<p><a href="k_regist.php">実習先登録・変更ページへ</a></p>
<br>
<p><a href="k_home.php">ホームへ</a></p>　
     </center>
</body>
</html>
