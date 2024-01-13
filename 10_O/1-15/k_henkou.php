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

          <p>実習先変更</p>



<?php
$query1="select praid,praname,pratime,ST_X(praplace),ST_Y(praplace),prauser from Pra_tabuken where praid='$pid'";//実習一覧の表示
$stmt1 = $dbh->query($query1);
$rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);


foreach($rec1 as $row1 ){
  $pid=$row1['praid'];
  $pn=$row1['praname'];
  $pt=$row1['pratime'];
  $pp1=$row1['ST_X(praplace)'];
  $pp2=$row1['ST_Y(praplace)'];
  $pu=$row1['prauser'];

}

 ?>

          <form action="k_henkoukakunin.php" method="POST"><!--実習先登録ボタン-->

          <div class="cp_iptxt">
            <label>実習名</label>
            <input class="ef" type="text" name="praname" value="<?php echo $pn; ?>" placeholder="30文字以内">
          </div>

          <div class="cp_iptxt">
            <label>実習時間</label>
            <input class="ef" type="text" name="pratime" value="<?php echo $pt; ?>" placeholder="半角数字　小数点以下第2位まで可能">
          </div>

          <div class="cp_iptxt">
            <label>実習先位置　緯度</label>
            <input class="ef" type="text" name="praplace1" value="<?php echo $pp1; ?>" placeholder="半角数字">
          </div>

          <div class="cp_iptxt">
            <label>実習先位置　経度</label>
            <input class="ef" type="text" name="praplace2" value="<?php echo $pp2; ?>" placeholder="半角数字">
          </div>

          <div class="cp_iptxt">
            <label>担当教官</label>
            <input class="ef" type="text" name="prauser" value="<?php echo $pu; ?>" placeholder="例　弓削太郎　＊10文字以内">
          </div>

             <input type="hidden" name="praid" value="<?php echo $pid; ?>">

             <input type="hidden" name="userid" value="<?php echo $id; ?>">
             <input type="hidden" name="username" value="<?php echo $n; ?>">
           <input type="submit" name="kensaku" value="変更確認" class="btn btn-success">
           <input type="submit" name="delete" value="削除確認" class="btn btn-danger">
          </form>






<br>
<p><a href="k_regist.php">戻る</a></p>　

     </center>
</body>
</html>
