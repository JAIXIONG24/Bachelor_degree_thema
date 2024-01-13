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


?>
<link rel="stylesheet" href="http://tbsv.japanwest.cloudapp.azure.com/apps/tabusalab2.css" type="text/css">


<!DOCTYPE html>

<html lang="ja">
<head>

</head>
<body>
<div >
      <center>
      <font size="5">
  <h1>地域創生演習実施履歴管理</h1>
      </font>

<?php
$depart=$_POST['depart'];
$year=$_POST['year'];
  $oo=0;
if($depart=="all"){

  echo "＜".$year."年度の全学科＞";
  echo "<br>";
  echo "<br>";
  echo "地方創生1の学生";
  echo "<br>";

  echo "<table border='1' class='type3'>";//実習先学生一覧
  echo "<tr><th>学科・学年</th><th>学生id</th><th>学生名</th><th>累計時間</th></tr>";


$query="select distinct User_tabuken.userid, User_tabuken.username, User_tabuken.date, User_tabuken.graid from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where kind = 1 && User_tabuken.date like '$year%' group by userid";
  $stmt = $dbh->query($query);
  $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach($rec as $row ){
    $uid=$row['userid'];
    $un=$row['username'];
    $date=$row['date'];
    $graid=$row['graid'];


  $graid = substr($graid, 0, 2);


    $query1="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where date='$date' && kind=1  group by praid";
    $stmt1 = $dbh->query($query1);
    $rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

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

  }
  }
  $ruikei=array();
    echo "<tr><td>$graid</td>";
    echo "<td>$uid</td>";
    echo "<td>$un</td>";
    echo "<td>$oo</td></tr>";
    $oo=0;

  }

  echo "</table>";





  echo "<br>";
  echo "<br>";
  echo "地方創生2の学生";
  echo "<br>";

  echo "<table border='1' class='type3'>";//実習先学生一覧
  echo "<tr><th>学科・学年</th><th>学生id</th><th>学生名</th><th>累計時間</th></tr>";


$query="select distinct User_tabuken.userid, User_tabuken.username, User_tabuken.date, User_tabuken.graid from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where kind = 2 && User_tabuken.date like '$year%' group by userid";
  $stmt = $dbh->query($query);
  $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach($rec as $row ){

    $uid=$row['userid'];
    $un=$row['username'];
    $date=$row['date'];
      $graid=$row['graid'];

      $graid = substr($graid, 0, 2);


    $query1="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where date='$date' && kind=2  group by praid";
    $stmt1 = $dbh->query($query1);
    $rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

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

  }

  }
  $ruikei=array();
    echo "<tr><td>$graid</td>";
    echo "<td>$uid</td>";
    echo "<td>$un</td>";
    echo "<td>$oo</td></tr>";
    $oo=0;

  }

  echo "</table>";


}else{

  echo "＜".$year."年度の".$depart."科＞";
  echo "<br>";
  echo "<br>";
  echo "地方創生1の学生";
  echo "<br>";

  echo "<table border='1' class='type3'>";//実習先学生一覧
  echo "<tr><th>学科・学年</th><th>学生id</th><th>学生名</th><th>累計時間</th></tr>";


  $query="select distinct User_tabuken.userid, User_tabuken.username, User_tabuken.date, User_tabuken.graid from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where kind = 1 && User_tabuken.date like '$year%'  && User_tabuken.graid like '$depart%' group by userid";
  $stmt = $dbh->query($query);
  $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach($rec as $row ){
    $uid=$row['userid'];
    $un=$row['username'];
    $date=$row['date'];
    $graid=$row['graid'];

    $graid = substr($graid, 0, 2);


    $query1="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where date='$date' && kind=1  group by praid";
    $stmt1 = $dbh->query($query1);
    $rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

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

  }
  }
  $ruikei=array();
  echo "<tr><td>$graid</td>";
    echo "<td>$uid</td>";
    echo "<td>$un</td>";
    echo "<td>$oo</td></tr>";
    $oo=0;

  }

  echo "</table>";





  echo "<br>";
  echo "<br>";
  echo "地方創生2の学生";
  echo "<br>";

  echo "<table border='1' class='type3'>";//実習先学生一覧
  echo "<tr><th>学科・学年</th><th>学生id</th><th>学生名</th><th>累計時間</th></tr>";


  $query="select distinct User_tabuken.userid, User_tabuken.username, User_tabuken.date, User_tabuken.graid from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where kind = 2 && User_tabuken.date like '$year%' && User_tabuken.graid like '$depart%' group by userid";
  $stmt = $dbh->query($query);
  $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach($rec as $row ){
    $uid=$row['userid'];
    $un=$row['username'];
    $date=$row['date'];
    $graid=$row['graid'];

    $graid = substr($graid, 0, 2);


    $query1="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where date='$date' && kind=2  group by praid";
    $stmt1 = $dbh->query($query1);
    $rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

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

  }

  }
  $ruikei=array();
  echo "<tr><td>$graid</td>";
    echo "<td>$uid</td>";
    echo "<td>$un</td>";
    echo "<td>$oo</td></tr>";
    $oo=0;

  }

  echo "</table>";



}

?>
<form action="k_past.php" method="POST"><!--検索ボタン-->
  <input type="hidden" name="depart" value="<?php echo $depart; ?>">
  <input type="hidden" name="year" value="<?php echo $year; ?>">

</form>
   <br>
   <p><a href="k_home.php">ホームへ</a></p>
     </center>
   </div>
</body>
</html>
