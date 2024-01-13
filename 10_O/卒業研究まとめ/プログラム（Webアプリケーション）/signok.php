<?php

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/functions.php';
require_unlogined_session();
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

<style>
.small{ font-size: 1.2em; }
.big{ font-size: 1.7em; }
</style>

<center>
  <link rel="stylesheet" href="http://tbsv.japanwest.cloudapp.azure.com/apps/tabusalab.css" type="text/css">
  <?php

$uid=$_POST['userid'];
$maj=$_POST['major'];
$gra=$_POST['grade'];
$num=$_POST['number'];
$na=$_POST['name'];
$pa=$_POST['pass'];
$pa2=$_POST['pass2'];

$str_uid=strlen($uid);
$str_pa=strlen($pa);

$key = '長い鍵';
$plain_text = $pa;
$c_t = openssl_encrypt($plain_text, 'AES-128-ECB', $key);

$query="select count(*) as num from User_tabuken where pass='$c_t'";


   $stmt = $dbh->query($query);
   $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
   foreach($rec as $row ){
     $cnt=$row['num'];

   }

   $y=date("Y");
   $m=date("m");
   if($m<=3){
     $y=$y-1;
   }
   $d=$y.$uid;




   $query1="select count(*) as dcnt from User_tabuken where date='$d'";


      $stmt1 = $dbh->query($query1);
      $rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
      foreach($rec1 as $row1 ){
        $datecnt=$row1['dcnt'];

}


if (isset($_POST["signup"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["userid"]&&$_POST["pass"] &&$_POST["major"]&&$_POST["grade"] &&$_POST["number"]&&$_POST["name"] &&$_POST["pass2"] )) {  // 値が空のとき

        $errorMessage = '正しくデータが入力されていません';
        echo "<br>";
        echo "<br>";
        ?>

        <p class="big">
          <?php
        echo $errorMessage;
?></p>
<p>
<a href="http://tbsv.japanwest.cloudapp.azure.com/apps/signup.php"><button type="button" class="btn btn-outline-info">戻る</button></a>
</p>
<?php
    }else{
if($pa!==$pa2){
  ?><p class="big">
    <?php
  echo 'パスワードが一致しません';
  ?>
  <p>
  <a href="http://tbsv.japanwest.cloudapp.azure.com/apps/signup.php"><button type="button" class="btn btn-outline-info">戻る</button></a>
  </p>
    <?php


}else{

      if($str_uid==6 &&$str_pa>=6 ){

        if($datecnt==0){

        if($cnt==0) {

          ?><p class="big">
            <?php
echo "新規登録内容";
        echo "<table border='1'class='type06'>";
        echo "<tr><th>ユーザID</th><th>パスワード</th><th>学科</th><th>学年</th><th>出席番号</th><th>名前</th></tr>";

      echo "<tr><td>$uid</td>";
      echo "<td>設定したパスワード</td>";
      echo "<td>$maj</td>";
      echo "<td>$gra</td>";
      echo "<td>$num</td>";
      echo "<td>$na</td></tr>";

echo"</table>";
echo "<br>";
?>


      <form action="sinki.php" method="post">
        <input type='submit' name='sinki' value='新規登録' class="btn btn-outline-success">

          <input type="hidden" name="u" value="<?php echo $uid;?>">
          <input type="hidden" name="p" value="<?php echo $pa;?>">
          <input type="hidden" name="m" value="<?php echo $maj;?>">
          <input type="hidden" name="g" value="<?php echo $gra;?>">
          <input type="hidden" name="naa" value="<?php echo $na;?>">
          <input type="hidden" name="nuu" value="<?php echo $num;?>">

          </p>
      </form>
<p>
<a href="http://tbsv.japanwest.cloudapp.azure.com/apps/signup.php"><button type="button" class="btn btn-outline-info">戻る</button></a>
</p>



<?php
}else{
  ?><p class="big">
    <?php
  echo "そのパスワードは使えません。";
  echo "<br>";
  echo "パスワードを変更してください。";
?>
<p>
<a href="http://tbsv.japanwest.cloudapp.azure.com/apps/signup.php"><button type="button" class="btn btn-outline-info">戻る</button></a>
</p>
  <?php
}


}else{
  ?><p class="big">
    <?php
echo "そのユーザIDは登録済みです";
echo "<br>";
?>
<p>
<a href="http://tbsv.japanwest.cloudapp.azure.com/apps/signup.php"><button type="button" class="btn btn-outline-info">戻る</button></a>
</p>
  <?php


}



}else{
  ?><p class="small">
    <?php
  echo "ユーザIDまたはパスワードが正しく入力されていません";
  echo "<br>";
   echo "ユーザIDは例のように、パスワードは半角英数字の6桁以上で入力してください";
   ?>
   <p>
   <a href="http://tbsv.japanwest.cloudapp.azure.com/apps/signup.php"><button type="button" class="btn btn-outline-info">戻る</button></a>
   </p>
   <?php
}
}
}
}

?>



</center>

</body>
</html>
