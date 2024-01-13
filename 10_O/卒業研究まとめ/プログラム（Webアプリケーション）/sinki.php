<?php

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/functions.php';

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
?>

<html lang='ja'>
  <link rel="stylesheet" href="http://tbsv.japanwest.cloudapp.azure.com/apps/tabusalab.css" type="text/css">

  <style>
  .small{ font-size: 1.2em; }
  .big{ font-size: 1.7em; }
  </style>
<center>
  <?php

$uid=$_POST['u'];
$maj=$_POST['m'];
$gra=$_POST['g'];
$num=$_POST['nuu'];
$na=$_POST['naa'];
$pa=$_POST['p'];



if (isset($_POST["sinki"])) {




$gid="$maj".$gra.$num;
if($gra<=3){
  $k=1;
}else if($gra>=4){
  $k=2;
}

$a=1;
$y=date("Y");
$m=date("m");
if($m<=3){
  $y=$y-1;
}
$d=$y.$uid;


//$pa=password_hash($pa, PASSWORD_DEFAULT);
$key = '長い鍵';
$plain_text = $pa;

//openssl
$c_t = openssl_encrypt($plain_text, 'AES-128-ECB', $key);



$query="insert into User_tabuken(graid,userid,username,pass,kind,access,date)values('$gid','$uid','$na','$c_t',$k,$a,'$d')";


   $stmt = $dbh->query($query);
   ?><p class="big">
     <?php
      echo "登録しました";
      ?>

      <p>
      <a href="http://tbsv.japanwest.cloudapp.azure.com/apps/t_login.php"><button type="button" class="btn btn-outline-info">ログイン画面へ</button></a>
      </p>


      <?php
}
?>

<form action="#" method="post">
  <input type="hidden" name="u" value="<?php echo $uid;?>">
  <input type="hidden" name="p" value="<?php echo $pa;?>">
  <input type="hidden" name="m" value="<?php echo $maj;?>">
  <input type="hidden" name="g" value="<?php echo $gra;?>">
  <input type="hidden" name="naa" value="<?php echo $na;?>">
  <input type="hidden" name="nuu" value="<?php echo $num;?>">
    <input type="hidden" name="dddd" value="<?php echo $ba;?>">
  </p>
</form>

</center>

</body>
</html>
