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
$g=$_POST['g'];
$gr=$_POST['gr'];

$id=$_POST['userid'];
$n=$_POST['username'];
  $oo=0;


?>
<link rel="stylesheet" href="http://tbsv.japanwest.cloudapp.azure.com/apps/tabusalab2.css" type="text/css">

<!DOCTYPE html>

<html lang="ja">
<body>
        <center>
        <font size="5">
    <h1>地域創生演習実施履歴管理</h1>
        </font>


          <p>地域創生1の学生一覧</p>

      <br>

<form action="#" method="post"><!--検索ボタン-->
<select name='g'>
<option value='all' <?php echo array_key_exists('g', $_POST) && $_POST['g'] == 'all' ? 'selected' : ''; ?>>全学年</option>
<option value='1' <?php echo array_key_exists('g', $_POST) && $_POST['g'] == '1' ? 'selected' : ''; ?>>1学年</option>
<option value='2' <?php echo array_key_exists('g', $_POST) && $_POST['g'] == '2' ? 'selected' : ''; ?>>2学年</option>
<option value='3' <?php echo array_key_exists('g', $_POST) && $_POST['g'] == '3' ? 'selected' : ''; ?>>3学年</option>
</select>

<select name='gr'>
<option value='all' <?php echo array_key_exists('gr', $_POST) && $_POST['gr'] == 'all' ? 'selected' : ''; ?>>全学科</option>
<option value='S' <?php echo array_key_exists('gr', $_POST) && $_POST['gr'] == 'S' ? 'selected' : ''; ?>>S</option>
<option value='M' <?php echo array_key_exists('gr', $_POST) && $_POST['gr'] == 'M' ? 'selected' : ''; ?>>M</option>
<option value='I' <?php echo array_key_exists('gr', $_POST) && $_POST['gr'] == 'I' ? 'selected' : ''; ?>>I</option>
</select>
<input type="submit" name="so" value="選択" class="btn btn-outline-dark">
</form>
<br>



<?php

if($_POST['so']){
if($g=='all' && $gr=='all'){
  echo "<全学年全学科>";
  echo "<table border='1' class='type3'>";//実習先学生一覧
  echo "<tr><th>学生id</th><th>学生名</th><th>累計時間</th><th></th></tr>";

$query="select distinct User_tabuken.userid, User_tabuken.username from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where kind = 1 && access=1 group by userid" ;
$stmt = $dbh->query($query);
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rec as $row ){
  $uid=$row['userid'];
  $un=$row['username'];

  $query1="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where userid='$uid' && kind=1 && access=1 group by praid";
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


  echo "<tr><td>$uid</td>";
  echo "<td>$un</td>";
  echo "<td>$oo</td>";
  $oo=0;


  echo "<td>";
  echo "<form action='k_region1_indi.php' method='post'>";
  echo "<input type='hidden' name='uid' value='$uid'>";
  echo "<input type='hidden' name='userid' value='$id'>";
  echo "<input type='hidden' name='username' value='$n'>";

  echo "<input type='submit' name='henkou' value='変更' class='btn btn-secondary'>";
  echo "</form>";
  echo "</td></tr>";


}

echo "</table>";
}else if($gr=='all'){
  if($g=='1'){
  echo "<".$g."学年>";
  echo "<table border='1' class='type3'>";//実習先学生一覧
  echo "<tr><th>学生id</th><th>学生名</th><th>累計時間</th><th></th></tr>";

  $y=date("Y");
  $m=date("m");
  if($m<=3){
    $y=$y-1;
  }

$query="select distinct User_tabuken.userid, User_tabuken.username from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where kind = 1 && User_tabuken.graid like '_$g%' && access=1 && User_tabuken.date like '$y%' group by userid" ;
$stmt = $dbh->query($query);
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rec as $row ){
  $uid=$row['userid'];
  $un=$row['username'];

  $query1="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where userid='$uid' && kind=1 && access=1 group by praid";
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


  echo "<tr><td>$uid</td>";
  echo "<td>$un</td>";
  echo "<td>$oo</td>";
  $oo=0;


  echo "<td>";
  echo "<form action='k_region1_indi.php' method='post'>";
  echo "<input type='hidden' name='uid' value='$uid'>";
  echo "<input type='hidden' name='userid' value='$id'>";
  echo "<input type='hidden' name='username' value='$n'>";

  echo "<input type='submit' name='henkou' value='変更' class='btn btn-secondary'>";
  echo "</form>";
  echo "</td></tr>";


}

echo "</table>";
}else if($g=='2'){
  echo "<".$g."学年>";
  echo "<table border='1' class='type3'>";//実習先学生一覧
  echo "<tr><th>学生id</th><th>学生名</th><th>累計時間</th><th></th></tr>";

  $y=date("Y");
  $m=date("m");
  if($m<=3){
    $y=$y-1;
  }
  $y1=date("Y");
  $m=date("m");
  if($m<=3){
    $y1=$y1-1;
  }
  $w='1';
  $y1=$y1-1;

$query="select distinct User_tabuken.userid, User_tabuken.username from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where kind = 1 && User_tabuken.graid like '_$g%' && access=1 && User_tabuken.date like '$y%' || graid like '_$w%' && User_tabuken.date like '$y1%' group by userid" ;
$stmt = $dbh->query($query);
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rec as $row ){
  $uid=$row['userid'];
  $un=$row['username'];

  $query1="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where userid='$uid' && kind=1 && access=1 group by praid";
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


  echo "<tr><td>$uid</td>";
  echo "<td>$un</td>";
  echo "<td>$oo</td>";
  $oo=0;


  echo "<td>";
  echo "<form action='k_region1_indi.php' method='post'>";
  echo "<input type='hidden' name='uid' value='$uid'>";
  echo "<input type='hidden' name='userid' value='$id'>";
  echo "<input type='hidden' name='username' value='$n'>";

  echo "<input type='submit' name='henkou' value='変更' class='btn btn-secondary'>";
  echo "</form>";
  echo "</td></tr>";


}

echo "</table>";

}else if($g=='3'){
  echo "<".$g."学年>";
  echo "<table border='1' class='type3'>";//実習先学生一覧
  echo "<tr><th>学生id</th><th>学生名</th><th>累計時間</th><th></th></tr>";

  $y=date("Y");
  $m=date("m");
  if($m<=3){
    $y=$y-1;
  }
  $y1=date("Y");
  $m=date("m");
  if($m<=3){
    $y1=$y1-1;
  }
  $w='2';
  $y1=$y1-1;

  $y2=date("Y");
  $m=date("m");
  if($m<=3){
    $y2=$y2-1;
  }
  $c='1';
  $y2=$y2-2;

  $query="select distinct User_tabuken.userid, User_tabuken.username from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where kind = 1 && User_tabuken.graid like '_$g%' && access=1 && User_tabuken.date like '$y%'  || graid like '_$w%' && User_tabuken.date like '$y1%' || graid like '_$c%' && User_tabuken.date like '$y2%' group by userid" ;
  $stmt = $dbh->query($query);
  $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach($rec as $row ){
  $uid=$row['userid'];
  $un=$row['username'];

  $query1="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where userid='$uid' && kind=1 && access=1 group by praid";
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


  echo "<tr><td>$uid</td>";
  echo "<td>$un</td>";
  echo "<td>$oo</td>";
  $oo=0;


  echo "<td>";
  echo "<form action='k_region1_indi.php' method='post'>";
  echo "<input type='hidden' name='uid' value='$uid'>";
  echo "<input type='hidden' name='userid' value='$id'>";
  echo "<input type='hidden' name='username' value='$n'>";

  echo "<input type='submit' name='henkou' value='変更' class='btn btn-secondary'>";
  echo "</form>";
  echo "</td></tr>";


  }

  echo "</table>";
}
}else if($g=='all'){
  echo "＜".$gr."科＞";
  echo "<table border='1' class='type3'>";//実習先学生一覧
  echo "<tr><th>学生id</th><th>学生名</th><th>累計時間</th><th></th></tr>";

$query="select distinct User_tabuken.userid, User_tabuken.username from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where kind = 1 && User_tabuken.graid like '$gr%' && access=1 group by userid" ;
$stmt = $dbh->query($query);
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rec as $row ){
  $uid=$row['userid'];
  $un=$row['username'];

  $query1="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where userid='$uid' && kind=1 && access=1 group by praid";
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


  echo "<tr><td>$uid</td>";
  echo "<td>$un</td>";
  echo "<td>$oo</td>";
  $oo=0;


  echo "<td>";
  echo "<form action='k_region1_indi.php' method='post'>";
  echo "<input type='hidden' name='uid' value='$uid'>";
  echo "<input type='hidden' name='userid' value='$id'>";
  echo "<input type='hidden' name='username' value='$n'>";

  echo "<input type='submit' name='henkou' value='変更' class='btn btn-secondary'>";
  echo "</form>";
  echo "</td></tr>";


}

echo "</table>";

}else{
  if($g=='1'){
  echo "<".$g."学年　".$gr."科>";
  echo "<table border='1' class='type3'>";//実習先学生一覧
  echo "<tr><th>学生id</th><th>学生名</th><th>累計時間</th><th></th></tr>";

  $y=date("Y");
  $m=date("m");
  if($m<=3){
    $y=$y-1;
  }

$query="select distinct User_tabuken.userid, User_tabuken.username from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where kind = 1 && User_tabuken.graid like '$gr%' && User_tabuken.graid like '_$g%' && access=1 && User_tabuken.date like '$y%' group by userid" ;
$stmt = $dbh->query($query);
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rec as $row ){
  $uid=$row['userid'];
  $un=$row['username'];

  $query1="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where userid='$uid' && kind=1 && access=1 group by praid";
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


  echo "<tr><td>$uid</td>";
  echo "<td>$un</td>";
  echo "<td>$oo</td>";
  $oo=0;


  echo "<td>";
  echo "<form action='k_region1_indi.php' method='post'>";
  echo "<input type='hidden' name='uid' value='$uid'>";
  echo "<input type='hidden' name='userid' value='$id'>";
  echo "<input type='hidden' name='username' value='$n'>";

  echo "<input type='submit' name='henkou' value='変更' class='btn btn-secondary'>";
  echo "</form>";
  echo "</td></tr>";


}

echo "</table>";

}else if($g=='2'){
  echo "<".$g."学年　".$gr."科>";
  echo "<table border='1' class='type3'>";//実習先学生一覧
  echo "<tr><th>学生id</th><th>学生名</th><th>累計時間</th><th></th></tr>";

  $y=date("Y");
  $m=date("m");
  if($m<=3){
    $y=$y-1;
  }
  $y1=date("Y");
  $m=date("m");
  if($m<=3){
    $y1=$y1-1;
  }
  $w='1';
  $y1=$y1-1;

$query="select distinct User_tabuken.userid, User_tabuken.username from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where kind = 1 && User_tabuken.graid like '$gr%' && User_tabuken.graid like '_$g%' && access=1 && User_tabuken.date like '$y%' || graid like '_$w%' && User_tabuken.date like '$y1%' group by userid" ;
$stmt = $dbh->query($query);
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rec as $row ){
  $uid=$row['userid'];
  $un=$row['username'];

  $query1="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where userid='$uid' && kind=1 && access=1 group by praid";
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


  echo "<tr><td>$uid</td>";
  echo "<td>$un</td>";
  echo "<td>$oo</td>";
  $oo=0;


  echo "<td>";
  echo "<form action='k_region1_indi.php' method='post'>";
  echo "<input type='hidden' name='uid' value='$uid'>";
  echo "<input type='hidden' name='userid' value='$id'>";
  echo "<input type='hidden' name='username' value='$n'>";

  echo "<input type='submit' name='henkou' value='変更' class='btn btn-secondary'>";
  echo "</form>";
  echo "</td></tr>";


}

echo "</table>";

}else if($g=='3'){
  echo "<".$g."学年　".$gr."科>";
  echo "<table border='1' class='type3'>";//実習先学生一覧
  echo "<tr><th>学生id</th><th>学生名</th><th>累計時間</th><th></th></tr>";

  $y=date("Y");
  $m=date("m");
  if($m<=3){
    $y=$y-1;
  }
  $y1=date("Y");
  $m=date("m");
  if($m<=3){
    $y1=$y1-1;
  }
  $w='2';
  $y1=$y1-1;

  $y2=date("Y");
  $m=date("m");
  if($m<=3){
    $y2=$y2-1;
  }
  $c='1';
  $y2=$y2-2;

$query="select distinct User_tabuken.userid, User_tabuken.username from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where kind = 1 && User_tabuken.graid like '$gr%' && User_tabuken.graid like '_$g%' && access=1 && User_tabuken.date like '$y%' || graid like '_$w%' && User_tabuken.date like '$y1%' || graid like '_$c%' && User_tabuken.date like '$y2%' group by userid" ;
$stmt = $dbh->query($query);
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rec as $row ){
  $uid=$row['userid'];
  $un=$row['username'];

  $query1="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where userid='$uid' && kind=1 && access=1 group by praid";
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


  echo "<tr><td>$uid</td>";
  echo "<td>$un</td>";
  echo "<td>$oo</td>";
  $oo=0;


  echo "<td>";
  echo "<form action='k_region1_indi.php' method='post'>";
  echo "<input type='hidden' name='uid' value='$uid'>";
  echo "<input type='hidden' name='userid' value='$id'>";
  echo "<input type='hidden' name='username' value='$n'>";

  echo "<input type='submit' name='henkou' value='変更' class='btn btn-secondary'>";
  echo "</form>";
  echo "</td></tr>";


}

echo "</table>";


}
}
}else{
  echo "<全学年全学科>";
  echo "<table border='1' class='type3'>";//実習先学生一覧
  echo "<tr><th>学生id</th><th>学生名</th><th>累計時間</th><th></th></tr>";

$query="select distinct User_tabuken.userid, User_tabuken.username from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where kind = 1 && access=1 group by userid" ;
$stmt = $dbh->query($query);
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rec as $row ){
  $uid=$row['userid'];
  $un=$row['username'];

  $query1="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where userid='$uid' && kind=1 && access=1 group by praid";
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

  echo "<tr><td>$uid</td>";
  echo "<td>$un</td>";
  echo "<td>$oo</td>";
  $oo=0;


  echo "<td>";
  echo "<form action='k_region1_indi.php' method='post'>";
  echo "<input type='hidden' name='uid' value='$uid'>";
  echo "<input type='hidden' name='userid' value='$id'>";
  echo "<input type='hidden' name='username' value='$n'>";

  echo "<input type='submit' name='henkou' value='変更' class='btn btn-secondary'>";
  echo "</form>";
  echo "</td></tr>";


}

echo "</table>";
}
?>

<br>
<p><a href="k_home.php">ホームへ</a></p>

</center>
</body>
</html>
