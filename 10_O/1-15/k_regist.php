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

?>
<link rel="stylesheet" href="http://tbsv.japanwest.cloudapp.azure.com/apps/tabusalab2.css" type="text/css">

<!DOCTYPE html>

<html lang="ja">
<body>
	<center>
	<font size="5">
    <h1>地域創生演習実施履歴管理</h1>
	</font>
  <p>実習先登録・変更・削除</p>
  <br>

<?php
echo "<現在登録されている実習先>";
echo "<table border='1'>";//実習先一覧の
echo "<tr><th>実習名</th><th>実習時間</th><th>実習場所　緯度</th><th>実習場所　経度</th><th>担当者</th><th></th></tr>";

              $query1="select praid,praname,pratime,ST_X(praplace),ST_Y(praplace),prauser from Pra_tabuken";//実習一覧の表示
              $stmt1 = $dbh->query($query1);
              $rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

              foreach($rec1 as $row1 ){
      $pid=$row1['praid'];
                      $pn=$row1['praname'];
                      $pt=$row1['pratime'];
                      $pp1=$row1['ST_X(praplace)'];
                      $pp2=$row1['ST_Y(praplace)'];
                      $pu=$row1['prauser'];

                      echo "<tr><td>$pn</td>";
                      echo "<td>$pt</td>";
                      echo "<td>$pp1</td>";
      echo "<td>$pp2</td>";
      echo "<td>$pu</td>";

      echo "<td>";
      echo "<form action='k_henkou.php' method='post'>";
      echo "<input type='hidden' name='praid' value='$pid'>";
      echo "<input type='hidden' name='praname' value='$pn'>";
      echo "<input type='hidden' name='pratime' value='$pt'>";
      echo "<input type='hidden' name='praplace' value='$pp1'>";
      echo "<input type='hidden' name='praplace' value='$pp2'>";
      echo "<input type='hidden' name='prauser' value='$pu'>";

      echo "<input type='hidden' name='userid' value='$id'>";
      echo "<input type='hidden' name='username' value='$n'>";

      echo "<input type='submit' name='henkou' value='変更' class='btn btn-secondary'>";
      echo "</form>";
      echo "</td></tr>";
              }

echo "</table>";
echo "<br>";

$praid=mt_rand(1,999);




 ?>
 <br>
 <br>
<p>実習先登録</p>

  <form action="k_registkakunin.php" method="POST"><!--実習先登録ボタン-->


  <div class="cp_iptxt">
    <label>実習名</label> <br>
    <input class="ef" type="text" name="praname" placeholder="30文字以内">
  </div>

  <div class="cp_iptxt">
    <label>実習時間</label> <br>
    <input class="ef" type="text" name="pratime" placeholder="半角数字　小数点以下第2位まで可能">
  </div>

  <div class="cp_iptxt">
    <label>実習先位置　緯度</label> <br>
    <input class="ef" type="text" name="praplace1" placeholder="半角数字">
  </div>

  <div class="cp_iptxt">
    <label>実習先位置　経度</label> <br>
    <input class="ef" type="text" name="praplace2" placeholder="半角数字">
  </div>

  <div class="cp_iptxt">
    <label>担当教官</label> <br>
    <input class="ef" type="text" name="prauser" placeholder="例　弓削太郎　＊10文字以内">
  </div>

    <input type="hidden" name="userid" value="<?php echo $id; ?>">
    <input type="hidden" name="username" value="<?php echo $n; ?>">
    <input type="hidden" name="praid" value="<?php echo $praid; ?>">
  <input type="submit" name="kakunin" value="登録確認" class="btn btn-success">
</form>

<br>
<p><a href="k_home.php">ホームへ</a></p>　


     </center>
</body>
</html>
