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

$na=$_POST['na'];

$uid=$_POST['uid'];
$pn=$_POST['praname'];
$t=$_POST['time'];
$pt=$_POST['pratime'];

$r=$_POST['rireki'];

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

<?php
if($_POST['delete']){

?>
  <p>地域創生1の学生</p>
  <p>ID：<?php echo $uid ?>　<?php echo $na ?>さんのアカウントを削除しますか？</p>

<form action="k_region1_indi_delete.php" method="POST">
  <input type="hidden" name="uid" value="<?php echo $uid; ?>">
  <input type="hidden" name="na" value="<?php echo $na; ?>">
  <input type="hidden" name="time1" value="<?php echo $t; ?>">


   <input type="hidden" name="userid" value="<?php echo $id; ?>">
   <input type="hidden" name="username" value="<?php echo $n; ?>">
 <input type="submit" name="delete" value="削除" class="btn btn-danger">
</form>

<?php

}else{
  $query2="select * from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where userid='$uid' and kind=1 and time='$t'";
  $stmt2 = $dbh->query($query2);
  $rec2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

  foreach($rec2 as $row2 ){
    $uid=$row2['userid'];
    $t=$row2['time'];
    $pt=$row2['pratime'];
}

?>
<p>user実習登録内容変更</p>

<form action="k_region1_henkoukakunin.php" method="POST"><!--実習先登録ボタン-->
  <p>地域創生1の学生</p>
  <p>ID：<?php echo $uid ?>　<?php echo $na ?>さん</p>
  <br>
  <p>実習名：<?php echo $pn; ?></p>
  <p>日付：<input type="date" name="time" value="<?php echo $t; ?>"></p>

  <input type="hidden" name="na" value="<?php echo $na; ?>">

 <input type="hidden" name="uid" value="<?php echo $uid; ?>">
 <input type="hidden" name="praname" value="<?php echo $pn; ?>">
 <input type='hidden' name='pratime' value="<?php echo $pt; ?>">
 <input type="hidden" name="time1" value="<?php echo $t; ?>">

  <input type="hidden" name="userid" value="<?php echo $id; ?>">
  <input type="hidden" name="username" value="<?php echo $n; ?>">
<input type="submit" name="henkou" value="変更確認" class="btn btn-success">
<input type="submit" name="delete" value="削除確認" class="btn btn-danger">
</form>
<?php


}

 ?>


<br>
<br>

<form action="k_region1_indi.php" method="post"><!--管理者登録ボタン-->
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
