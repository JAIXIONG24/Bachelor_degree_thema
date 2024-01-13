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

$n = "";
if(isset($_SESSION['pass'])){
        $pass = $_SESSION['pass'];
        $key = '長い鍵';
$plain_text = $pass;
$c_t = openssl_encrypt($plain_text, 'AES-128-ECB', $key);
        try {
                $query="select * from User_tabuken where pass='$c_t'";
                $stmt = $dbh->query($query);
                $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($rec as $row) {
                        $id = $row['userid'];
                        $n = $row['username'];
                }
        }catch(PDOException $e){
        echo $e->getMessage();
        exit();
    }
}

$e='1';
$query="select * from User_tabuken where kind = 1 && graid like '_$e%' group by userid" ;
$stmt = $dbh->query($query);
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rec as $row ){
  $uid=$row['userid'];
  $da=$row['date'];

  $y=date("Y");
  $m=date("m");
  if($m<=3){
    $y=$y-1;
  }
  $y3=$y-3;
  $d3=$y3.$uid;

  if($d3==$da){
    $query2="update User_tabuken set access=2 where kind=1 && date like '%$uid'";
    $stmt2 = $dbh->query($query2);
  }
}

$q='2';
$query="select * from User_tabuken where kind = 1 && graid like '_$q%' group by userid" ;
$stmt = $dbh->query($query);
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rec as $row ){
  $uid=$row['userid'];
  $da=$row['date'];

  $y=date("Y");
  $m=date("m");
  if($m<=3){
    $y=$y-1;
  }
  $y2=$y-2;
  $d2=$y2.$uid;

  if($d2==$da){
    $query2="update User_tabuken set access=2 where kind=1 && date like '%$uid'";
    $stmt2 = $dbh->query($query2);
  }
}

$h='3';
$query="select * from User_tabuken where kind = 1 && graid like '_$h%' group by userid" ;
$stmt = $dbh->query($query);
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rec as $row ){
  $uid=$row['userid'];
  $da=$row['date'];

  $y=date("Y");
  $m=date("m");
  if($m<=3){
    $y=$y-1;
  }
  $y1=$y-1;
  $d1=$y1.$uid;

  if($d1==$da){
    $query2="update User_tabuken set access=2 where kind=1 && date like '%$uid'";
    $stmt2 = $dbh->query($query2);
  }
}

$w='4';
$query1="select * from User_tabuken where kind = 2 && graid like '_$w%' group by userid" ;
$stmt1 = $dbh->query($query1);
$rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

foreach($rec1 as $row1 ){
  $uid=$row1['userid'];
  $da=$row1['date'];

  $y=date("Y");
  $m=date("m");
  if($m<=3){
    $y=$y-1;
  }
  $y12=$y-2;
  $d12=$y12.$uid;

  if($d12==$da){
    $query2="update User_tabuken set access=2 where kind=2 && date like '%$uid'";
    $stmt2 = $dbh->query($query2);
  }
}

$w='5';
$query1="select * from User_tabuken where kind = 2 && graid like '_$w%' group by userid" ;
$stmt1 = $dbh->query($query1);
$rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

foreach($rec1 as $row1 ){
  $uid=$row1['userid'];
  $da=$row1['date'];

  $y=date("Y");
  $m=date("m");
  if($m<=3){
    $y=$y-1;
  }
  $y11=$y-1;
  $d11=$y11.$uid;

  if($d11==$da){
    $query2="update User_tabuken set access=2 where kind=2 && date like '%$uid'";
    $stmt2 = $dbh->query($query2);
  }
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


  <?php if(isset($_SESSION['username'])) : ?>
          <p>管理者、<?php echo $n ?>さん！</p>
          <br>

  <form action="#" method="POST"><!--検索ボタン-->
    <p>実習名
      <select name="praname">
    <?php
    $query2="select * from Pra_tabuken";//実習一覧の表示
    $stmt2 = $dbh->query($query2);
    $rec2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    foreach($rec2 as $row2 ){
      $praname=$row2['praname'];
    ?>
      <option value="<?php echo $praname;?>" <?php echo array_key_exists('praname', $_POST) && $_POST['praname'] == $praname ? 'selected' : ''; ?>><?php echo $praname;?></option>
      <?php
    }
     ?>
  </select>

    <input type="hidden" name="userid" value="<?php echo $id; ?>">
    <input type="hidden" name="username" value="<?php echo $n; ?>">
    <input type="submit" name="kensaku" value="検索" class="btn btn-outline-dark">
  </form>
  <br>

  <form action="k_shinki.php" method="POST"><!--管理者登録ボ タン-->
    <input type="hidden" name="userid" value="<?php echo $id; ?>">
    <input type="hidden" name="username" value="<?php echo $n; ?>">
  <input type="submit" name="jis" value="管理者登録・変更" class="btn btn-info">
  </form>
  <br>

  <form action="k_regist.php" method="POST"><!--実習先ボタン-->
    <input type="hidden" name="userid" value="<?php echo $id; ?>">
    <input type="hidden" name="username" value="<?php echo $n; ?>">
  <input type="submit" name="jis" value="実習先登録・変更" class="btn btn-info">
  </form>
  <br>


<form action="k_region1.php" method="POST"><!--地方創生1ボタ ン-->


    <input type="hidden" name="userid" value="<?php echo $id; ?>">
    <input type="hidden" name="username" value="<?php echo $n; ?>">
  <input type="submit" name="region1" value="地域創生１" class="btn btn-success">
  </form>

  <br>


  <form action="k_region2.php" method="POST"><!--地方創生2ボ タン-->

    <input type="hidden" name="userid" value="<?php echo $id; ?>">
    <input type="hidden" name="username" value="<?php echo $n; ?>">
  <input type="submit" name="region2" value="地域創生２" class="btn btn-success">
  </form>

<br>
  <form action="k_touroku.php" method="POST"><!--検索ボタン-->
    <input type="hidden" name="uid" value="<?php echo $r; ?>">
    <input type="hidden" name="na" value="<?php echo $na; ?>">
  <input type="submit" name="delete" value="&nbsp;&nbsp;一括 登録&nbsp;&nbsp;" class="btn btn-danger">
  </form>
  <br>
  <form action="k_update.php" method="POST"><!--検索ボタン-->
    <input type="hidden" name="uid" value="<?php echo $r; ?>">
    <input type="hidden" name="na" value="<?php echo $na; ?>">
  <input type="submit" name="delete" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;更新&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" class="btn btn-danger">
  </form>
  <br>

<p>過去の地域創生演習の学生</p>
<form action="k_past.php" method="POST">
  <select name="year">
    <?php
    $y=date("Y");
    $m=date("m");
    if($m<=3){
      $y=$y-1;
    }
    ?>
    <option value="<?php echo $y;?>"><?php echo $y;?></option>
    <option value="<?php echo $y-1;?>"><?php echo $y-1;?></option>
    <option value="<?php echo $y-2;?>"><?php echo $y-2;?></option>
    <option value="<?php echo $y-3;?>"><?php echo $y-3;?></option>
    <option value="<?php echo $y-4;?>"><?php echo $y-4;?></option>


</select>年度の

<select name="depart">
<option value="all">全学科</option>
  <option value="S">S</option>
  <option value="M">M</option>
  <option value="I">I</option>
</select>の学生&nbsp;&nbsp;&nbsp;

  <input type="submit" name="pastok" value="検索" class="btn btn-outline-dark">

</form>

  <br>

<?php
//検索
$pr=$_POST['praname'];
if($_POST['kensaku']){


  $query5="select * from Pra_tabuken where praname='$pr'";// 実習一覧の表示
  $stmt5 = $dbh->query($query5);
  $rec5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);

  foreach($rec5 as $row5 ){
    $pn=$row5['praname'];

    echo "$pn の実習学生一覧";
}



  echo "<table border='1' class='type1'>";//実習先学生一覧
  echo "<tr><th>学科・学年</th><th>学生id</th><th>学生名</th></tr>";

  $y=date("Y");
  $m=date("m");
  if($m<=3){
    $y=$y-1;
  }


//実習先学生一覧の表示
$query2="select distinct User_tabuken.userid,User_tabuken.username,User_tabuken.graid from User_tabuken left join Indi_tabuken on User_tabuken.date=Indi_tabuken.date left join Pra_tabuken on Indi_tabuken.praid=Pra_tabuken.praid where Pra_tabuken.praname='$pr' && User_tabuken.date like '$y%' group by userid";
$stmt2 = $dbh->query($query2);
$rec2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

   foreach($rec2 as $row2 ){
     $id=$row2['userid'];
     $n=$row2['username'];
     $gra=$row2['graid'];
         $gra = substr($gra, 0, 2);


     echo "<tr><td>$gra</td>";
     echo "<td>$id</td>";
     echo "<td>$n</td></tr>";


}
echo "</table>";
echo "<br>";

}
 ?>


   <p><a href="./t_logout.php?token=<?=h(generate_token())?>" >ロ グアウト</a></p>
  <?php else : ?>
   <p><a href="./t_login.php">ログイン</a></p>
  <?php endif;?>


     </center>
   </div>
</body>
</html>
