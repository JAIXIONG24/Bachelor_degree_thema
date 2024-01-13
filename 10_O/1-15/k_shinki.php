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

  <p>管理者登録・変更・削除</p>
	<br>

<?php
echo "<現在登録されている管理者>";
echo "<table border='1' class='type1'>";//実習先一覧のテーブル
echo "<tr><th>管理者id</th><th>管理者名</th><th></th></tr>";

		$query1="select * from User_tabuken where access=0";//実習一覧の表示
		$stmt1 = $dbh->query($query1);
		$rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

		foreach($rec1 as $row1 ){
			$usid=$row1['userid'];
			$un=$row1['username'];
      $p=$row1['pass'];

			echo "<tr><td>$usid</td>";
			echo "<td>$un</td>";

      echo "<td>";
      echo "<form action='k_shinkihenkou.php' method='post'>";
      echo "<input type='hidden' name='usid' value='$usid'>";
      echo "<input type='hidden' name='uname' value='$un'>";
      echo "<input type='hidden' name='pass' value='$p'>";

      echo "<input type='hidden' name='userid' value='$id'>";
      echo "<input type='hidden' name='username' value='$n'>";

      echo "<input type='submit' name='henkou' value='変更' class='btn btn-secondary'>";
      echo "</form>";
      echo "</td></tr>";

		}
echo "</table>";
 ?>

  <br>
  <br>
<p>管理者登録</p>

<form action="k_shinkikakunin.php" method="post" ><!--管理者登録ボタン-->
  <div class="cp_iptxt">
    <label>管理者id</label> <br>
    <input class="ef" type="text" name="usid" placeholder="例　i16000">
  </div>

  <div class="cp_iptxt">
    <label>管理者NAME</label> <br>
    <input class="ef" type="text" name="uname" placeholder="例　弓削太郎">
  </div>

  <div class="cp_iptxt">
    <label>管理者password</label> <br>
    <input class="ef" type="password" name="pass" placeholder="半角英数字　6文字以上15字以内">
  </div>

    <input type="hidden" name="userid" value="<?php echo $id; ?>">
    <input type="hidden" name="username" value="<?php echo $n; ?>">
    <input type="submit" name="kensaku" value="登録確認" class="btn btn-success">
</form>
<br>
<p><a href="k_home.php">ホームへ</a></p>　

  </center>
</body>
</html>
