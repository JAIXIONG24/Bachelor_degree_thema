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
  <p>user実習内容登録</p>
<br>

  <?php
  echo "登録されている実習先";
  echo "<table border='1'>";//実習先一覧のテーブル
  echo "<tr><th>実習名</th><th>実習時間</th><th>担当</th></tr>";

  		$query1="select * from Pra_tabuken";//実習一覧の表示
  		$stmt1 = $dbh->query($query1);
  		$rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

  		foreach($rec1 as $row1 ){
  			$pid=$row1['praid'];
  			$pn=$row1['praname'];

        $pt=$row1['pratime'];
        $pu=$row1['prauser'];

  			echo "<tr><td>$pn</td>";
        echo "<td>$pt</td>";
  			echo "<td>$pu</td></tr>";
  		}
  echo "</table>";

$t=date("Y/m/d");

   ?>

   <br>
   <br>



  <form action="k_region1_indi_registkakunin.php" method="POST"><!--実習先登録ボタン-->
    <p>地域創生1の学生</p>
    <p>実習学生ID：<?php echo $uid ?>　<?php echo $na ?>さん</p>
    <br>

        <p>実習名：
          <select name="praname">

        <?php
        $query2="select * from Pra_tabuken";//実習一覧の表示
        $stmt2 = $dbh->query($query2);
        $rec2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach($rec2 as $row2 ){
          $praname=$row2['praname'];


        ?>

          <option value="<?php echo $praname;?>"><?php echo $praname;?></option>
          <?php
        }
         ?>
    </select>

    <p>日付：<input type="date" name="time" value="<?php echo $t; ?>"></p>

    <input type="hidden" name="uid" value="<?php echo $uid; ?>">
    <input type="hidden" name="na" value="<?php echo $na; ?>">

    <input type="hidden" name="userid" value="<?php echo $id; ?>">
    <input type="hidden" name="username" value="<?php echo $n; ?>">
  <input type="submit" name="kakunin" value="登録確認" class="btn btn-success">
</form>



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
