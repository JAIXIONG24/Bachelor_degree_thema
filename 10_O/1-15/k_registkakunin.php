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
        <br>
<p>実習先登録確認</p>
<br>

<?php

$pid=$_POST['praid'];
$pn=$_POST['praname'];
$pt=$_POST['pratime'];
$pp1=$_POST['praplace1'];
$pp2=$_POST['praplace2'];
$pu=$_POST['prauser'];

$query="select count(*) as sum from Pra_tabuken where praname='$pn'";
   $stmt = $dbh->query($query);
   $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
   foreach($rec as $row ){
     $cnt=$row['sum'];

   }


if(empty($_POST['praid'] && $_POST['praname'] && $_POST['pratime'] && $_POST['prauser'])){
    echo "正しく値が入力されていません";


}else{
  $pid = mb_convert_kana($pid, 'n','UTF-8');
  $pt = mb_convert_kana($pt, 'a','UTF-8');
  $pp1 = mb_convert_kana($pp1, 'a','UTF-8');
  $pp2 = mb_convert_kana($pp2, 'a','UTF-8');

  if(is_numeric($pid) && is_numeric($pt)){

  if($cnt==0){
  echo "<br>";

  $pn=$_POST['praname'];
  $pu=$_POST['prauser'];

  echo "<table border='1'>";//実習先一覧のテーブル
  echo "<tr><th>実習名</th><th>実習時間</th><th>実習場所　緯度</th><th>実習場所 　経度</th><th>実習担当者</th></tr>";


  echo "<tr><td>$pn</td>";
  echo "<td>$pt</td>";
  echo "<td>$pp1</td>";
  echo "<td>$pp2</td>";
  echo "<td>$pu</td></tr>";

  echo "</table>";
  echo "<br>";
 ?>

  <form action="k_registkanryo.php" method="POST">
    <input type="hidden" name="praid" value="<?php echo $pid; ?>">
    <input type="hidden" name="praname" value="<?php echo $pn; ?>">
    <input type="hidden" name="pratime" value="<?php echo $pt; ?>">
    <input type="hidden" name="praplace1" value="<?php echo $pp1; ?>">
    <input type="hidden" name="praplace2" value="<?php echo $pp2; ?>">
    <input type="hidden" name="prauser" value="<?php echo $pu; ?>">

    <input type="hidden" name="userid" value="<?php echo $id; ?>">
    <input type="hidden" name="username" value="<?php echo $n; ?>">
  <input type="submit" name="kensaku" value="登録" class="btn btn-success">
</form>

<?php
}else{
    echo "その実習名は登録されています。";
    echo "<br>";
    echo "実習名を変更してください。";

}
}else{
  echo "半角数字を入力してください。";


}
}


//ホスト名取得
$h = $_SERVER['HTTP_HOST'];

// リファラ値があれば、かつ外部サイトでなければaタグで戻るリンクを表示
if (!empty($_SERVER['HTTP_REFERER']) && (strpos($_SERVER['HTTP_REFERER'],$h) !== false)) {
  echo '<a href="' . $_SERVER['HTTP_REFERER'] . '">戻る</a>';
}



 ?>
 <br>



   </center>
</body>
</html>
