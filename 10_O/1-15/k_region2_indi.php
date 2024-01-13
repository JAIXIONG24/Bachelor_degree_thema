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
$r=$_POST['rireki'];

$y1=date("Y");
$y2=date("Y", strtotime('-1 year'));
$y3=date("Y", strtotime('-2 year'));

$r = mb_convert_kana($r, 'a','UTF-8');


$query="select count(*) as sum from User_tabuken where userid like '$r' and kind=2";
   $stmt = $dbh->query($query);
   $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
   foreach($rec as $row ){
     $cnt=$row['sum'];

   }

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

  $query5="select * from User_tabuken where userid like '$uid' and kind=2";
     $stmt5 = $dbh->query($query5);
     $rec5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
     foreach($rec5 as $row5 ){
       $na=$row5['username'];
     }
  ?>
  <p>地域創生2の学生</p>
  <p>ID：<?php echo $uid ?>　<?php echo $na ?>さんの実習履歴</p>

<form action="k_region2_henkou.php" method="POST"><!--検索ボタン-->
  <input type="hidden" name="uid" value="<?php echo $uid; ?>">
  <input type="hidden" name="na" value="<?php echo $na; ?>">
<input type="submit" name="delete" value="アカウント削除" class="btn btn-danger">
</form>
<br>

<form action="k_region2_indi_regist.php" method="POST"><!--検索ボタン-->
  <input type="hidden" name="uid" value="<?php echo $uid; ?>">
  <input type="hidden" name="na" value="<?php echo $na; ?>">
<input type="submit" name="regist" value="実習登録" class="btn btn-success">
</form>
<br>

  <?php
  $query1="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where userid='$uid' && kind=2 group by praid";

$stmt1 = $dbh->query($query1);
$rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

echo "<br>";
echo "<table border='1' class='type1'>";
echo "<tr><th>実習内容</th><th>実習累計時間</th>";

foreach($rec1 as $row1 ){
  $praid=$row1['praid'];
  $count=$row1['ppp'];


$query2="select * from Pra_tabuken where praid=$praid";

$stmt2 = $dbh->query($query2);
$rec2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);


foreach($rec2 as $row2 ){
$pratime=$row2['pratime'];
$pn=$row2['praname'];
$ruikei[$praid]=$count*$pratime;
$oo=array_sum($ruikei);


echo "<tr><td>$pn</td>";
echo "<td>$ruikei[$praid]</td></tr>";
}

}


if(isset($oo)){
  echo"</table>";
echo "累計　$oo"."時間";
}else{
echo"</table>";
echo "累計　0時間";
}
echo "<br>";
echo "<br>";

if(isset($oo)){

  echo "<実習の詳細>";
  echo "<table border='1' class='type2'>";
  echo "<tr><th>日付</th><th>実習内容</th><th>実習時間</th><th></th></tr>";


       $query2="select * from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where userid='$uid' and kind=2 ";
       $stmt2 = $dbh->query($query2);
       $rec2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

       foreach($rec2 as $row2 ){
         $t=$row2['time'];
         $pn=$row2['praname'];
         $pt=$row2['pratime'];

         $ti=date('Y年m月d日', strtotime($t));

        echo "<tr><td>$ti</td>";
        echo "<td>$pn</td>";
        echo "<td>$pt</td>";
        echo "<td>";
        echo "<form action='k_region2_henkou.php' method='post'>";
        echo "<input type='hidden' name='uid' value='$uid'>";
        echo "<input type='hidden' name='time' value='$t'>";
        echo "<input type='hidden' name='praname' value='$pn'>";
        echo "<input type='hidden' name='pratime' value='$pt'>";

        echo "<input type='hidden' name='na' value='$na'>";

        echo "<input type='hidden' name='userid' value='$id'>";
        echo "<input type='hidden' name='username' value='$n'>";

        echo "<input type='submit' name='henkou' value='変更' class='btn btn-secondary'>";
        echo "</form>";
        echo "</td></tr>";

       }
       echo"</table>";

}else{
   echo "実習履歴はありません。";
   echo"<br>";







}
?>

<br>
<p><a href="k_region2.php">戻る</a></p>

</center>
</body>
</html>
