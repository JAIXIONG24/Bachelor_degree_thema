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

$na=$_POST['na'];

$uid=$_POST['uid'];
$pn=$_POST['praname'];
$pid=$_POST['praid'];
$t=$_POST['time'];

$query="select * from Pra_tabuken where praname='$pn'";//実習一覧の表示
$stmt = $dbh->query($query);
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rec as $row ){
  $pid=$row['praid'];
}




?>
<link rel="stylesheet" href="http://tbsv.japanwest.cloudapp.azure.com/apps/tabusalab2.css" type="text/css">



<html lang="ja">
<body>
	<center>
	<font size="5">
    <h1>地域創生演習実施履歴管理</h1>
	</font>
	<br>
<p>user実習内容登録確認</p>
<br>

<?php

if(empty($_POST['uid'] && $_POST['praname'] && $_POST['time'])){
  echo"全ての項目を入力してください。";


}else{

  echo"地域創生2の学生";
  echo"実習学生ID：".$uid."　".$na."さん";
  echo "<br>";


  $uid=$_POST['uid'];
  $t=$_POST['time'];

  echo "<table border='1' class='type2'>";//実習先一覧のテーブル
  echo "<tr><th>学生id</th><th>実習名</th><th>日付</th></tr>";

  echo "<tr><td>$uid</td>";
  echo "<td>$pn</td>";
  echo "<td>$t</td></tr>";

  echo "</table>";
  echo "<br>";

  ?>

   <form action="k_region2_indi_registkanryo.php" method="POST">
     <input type="hidden" name="uid" value="<?php echo $uid; ?>">
     <input type="hidden" name="praid" value="<?php echo $pid; ?>">
      <input type="hidden" name="praname" value="<?php echo $pn; ?>">
     <input type="hidden" name="time" value="<?php echo $t; ?>">

     <input type="hidden" name="na" value="<?php echo $na; ?>">

     <input type="hidden" name="userid" value="<?php echo $id; ?>">
     <input type="hidden" name="username" value="<?php echo $n; ?>">
   <input type="submit" name="kensaku" value="登録" class="btn btn-success">
 </form>


 <?php

 }

  ?>


<br>
<br>

<form action="k_region2_indi_regist.php" method="post"><!--管理者登録ボタン-->
  <input type="hidden" name="uid" value="<?php echo $uid; ?>">
  <input type="hidden" name="rireki" value="<?php echo $uid; ?>">

  <input type="hidden" name="na" value="<?php echo $na; ?>">

  <input type="hidden" name="userid" value="<?php echo $id; ?>">
  <input type="hidden" name="username" value="<?php echo $n; ?>">
<input type="submit" name="kensaku" value="戻る" class="btn btn-dark">
</form>

</center>
</body>
</html>
