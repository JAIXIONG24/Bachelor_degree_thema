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

$usid=$_POST['usid'];
$un=$_POST['uname'];

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
          <p>管理者変更</p>

<?php
$query1="select * from User_tabuken where userid='$usid'";//実習一覧の表示
$stmt1 = $dbh->query($query1);
$rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);


foreach($rec1 as $row1 ){
  $usid=$row1['userid'];
  $un=$row1['username'];


}

 ?>

           <form action="k_shinkihenkoukakunin.php" method="POST"><!--実習先登録ボタン-->
             <p>管理者ID：<?php echo $usid; ?></p>

            <div class="cp_iptxt">
              <label >管理者NAME</label>
              <input class="ef" type="text" name="uname" value="<?php echo $un; ?>" placeholder="例　弓削太郎">
            </div>

            <div class="cp_iptxt">
              <label >管理者password</label>
              <input class="ef" type="password" name="pass" placeholder="半角英数字　6文字以上15字以内">
            </div>

            <input type="hidden" name="usid" value="<?php echo $usid; ?>">

             <input type="hidden" name="userid" value="<?php echo $id; ?>">
             <input type="hidden" name="username" value="<?php echo $n; ?>">
           <input type="submit" name="henkou" value="変更確認" class="btn btn-success">
           <input type="submit" name="delete" value="削除確認" class="btn btn-danger">
          </form>






<br>
<p><a href="k_shinki.php">戻る</a></p>　

     </center>
</body>
</html>
