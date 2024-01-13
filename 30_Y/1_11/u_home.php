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
      $d=$row['date'];

                }
        }catch(PDOException $e){
        echo $e->getMessage();
        exit();
    }
}


?>

<html>
<link rel="stylesheet" href="http://tbsv.japanwest.cloudapp.azure.com/apps/tabusalab3.css" type="text/css">
<body>

        <center>
        <font size="3">
                <h1>地域創生演習実施履歴</h1>
<br>







<?php



$query1="select * from User_tabuken where date='$d'";
$stmt1 = $dbh->query($query1);
$rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

foreach($rec1 as $row1 ){
  $id=$row1['userid'];
  $n =$row1['username'];
  $k =$row1['kind'];

?>

        <p>ID:<?php echo $id;
?>  <br>


<p>
     地方創生<?php echo $k;




}


 if(isset($_SESSION['username'])) : ?>
  <p>ようこそ、<?php echo $n ?>さん！</p>




  <form action="#" method="POST">
      <p>実習名
        <select name="rireki">
                   <option value="0"<?php echo array_key_exists('rireki', $_POST) && $_POST['rireki'] == $praname ? 'selected' : ''; ?>><?php echo '全て';?></option>
      <?php
      $query0="select * from Pra_tabuken";//実習一覧の表示
      $stmt0 = $dbh->query($query0);
      $rec0= $stmt0->fetchAll(PDO::FETCH_ASSOC);

      foreach($rec0 as $row0 ){
        $praname=$row0['praname'];
      ?>
      <option value="<?php echo $praname;?>"<?php echo array_key_exists('rireki', $_POST) && $_POST['rireki'] == $praname ? 'selected' : ''; ?>><?php echo $praname;?></option>
      <?php
      }

       ?>

    </select>

  <input type="submit" name="rirekikensaku" value="検索" class="btn btn-outline-dark">

  </form>


<form action="#" method="post">
  <input type="hidden" name="userid" value="<?php echo $id; ?>">
  <input type="hidden" name="username" value="<?php echo $n; ?>">

  </p>
</form>

<form action="u_home2.php" method="post">
  <input type="hidden" name="eid" value="<?php echo $id; ?>">
  <input type="hidden" name="ec_t" value="<?php echo $c_t; ?>">
  <input type="hidden" name="eee" value="<?php echo $d; ?>">


</form>


<?php

$rireki=$_POST['rireki'];

if(empty($rireki)){
echo "<1年生~現在の出席履歴>";
  echo "<table border='1'>";
  echo "<tr><th>日付</th><th>実習内容</th><th>実習時間</th></tr>";

    $query2="select * from Indi_tabuken A left join Pra_tabuken B on A.praid=B.praid where A.date like'%$id' group by time";//ログイン付けたらwhereでユーザーid で探す
     $stmt2 = $dbh->query($query2);
     $rec2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);


     foreach($rec2 as $row2 ){

       $t=$row2['time'];
       $pn=$row2['praname'];
       $pt=$row2['pratime'];

       $ti=date('Y年m月d日', strtotime($t));

      echo "<tr><td>$ti</td>";

      echo "<td>$pn</td>";

      echo "<td>$pt</td></tr>";




     }echo"</table>";

     echo "<br>";
     echo "<br>";
     $query3="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where userid='$id' && kind=$k group by praid";

   $stmt3 = $dbh->query($query3);
   $rec3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

echo "<地方創生$k の出席履歴>";
   echo "<table border='1' class='type06'>";

   echo "<tr><th>実習内容</th><th>実習累計時間</th></tr>";

   foreach($rec3 as $row3 ){

     $praid=$row3['praid'];
     $count=$row3['ppp'];


   $query4="select * from Pra_tabuken where praid=$praid";

   $stmt4 = $dbh->query($query4);
   $rec4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);

   foreach($rec4 as $row4 ){

   $pratime=$row4['pratime'];
   $pn=$row4['praname'];
   $ruikei[$praid]=$count*$pratime;

   $oo=array_sum($ruikei);



   echo "<tr><td>$pn</td>";
   echo "<td>$ruikei[$praid]</td></tr>";



   }
   }
   if(isset($oo)){
     echo"</table>";
   echo "累計$oo 時間";
 }else{
   echo"</table>";

 echo "累計0時間";
 echo "<br>";
  echo "<br>";
 echo "実習履歴はありません";

 }






}else{
  
if($rireki=='0'){
  echo "<1年生~現在の出席履歴>";
    echo "<table border='1'>";
    echo "<tr><th>日付</th><th>実習内容</th><th>実習時間</th></tr>";

      $query2="select * from Indi_tabuken A left join Pra_tabuken B on A.praid=B.praid where A.date like'%$id' group by time";//ログイン付けたらwhereでユーザーid で探す
       $stmt2 = $dbh->query($query2);
       $rec2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);


       foreach($rec2 as $row2 ){

         $t=$row2['time'];
         $pn=$row2['praname'];
         $pt=$row2['pratime'];

         $ti=date('Y年m月d日', strtotime($t));

        echo "<tr><td>$ti</td>";

        echo "<td>$pn</td>";

        echo "<td>$pt</td></tr>";




       }echo"</table>";

       echo "<br>";
       echo "<br>";
       $query3="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where userid='$id' && kind=$k group by praid";

     $stmt3 = $dbh->query($query3);
     $rec3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

  echo "<地方創生$k の出席履歴>";
     echo "<table border='1' class='type06'>";

     echo "<tr><th>実習内容</th><th>実習累計時間</th></tr>";

     foreach($rec3 as $row3 ){

       $praid=$row3['praid'];
       $count=$row3['ppp'];


     $query4="select * from Pra_tabuken where praid=$praid";

     $stmt4 = $dbh->query($query4);
     $rec4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);

     foreach($rec4 as $row4 ){

     $pratime=$row4['pratime'];
     $pn=$row4['praname'];
     $ruikei[$praid]=$count*$pratime;

     $oo=array_sum($ruikei);



     echo "<tr><td>$pn</td>";
     echo "<td>$ruikei[$praid]</td></tr>";



     }
     }
     if(isset($oo)){
       echo"</table>";
     echo "累計$oo 時間";
   }else{
     echo"</table>";

   echo "累計0時間";
   echo "<br>";
    echo "<br>";
   echo "実習履歴はありません";

   }






}else{
echo "<1年生~現在の出席履歴>";
  echo "<table border='1'>";
  echo "<tr><th>日付</th><th>実習内容</th><th>実習時間</th></tr>";

  $query2="select * from Indi_tabuken A left join Pra_tabuken B on A.praid=B.praid where A.date like '%$id' and B.praname like '$rireki' group by time";//ログイン付けたらwhereでユー ザーidで探す
   $stmt2 = $dbh->query($query2);
   $rec2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);


   foreach($rec2 as $row2 ){

     $t=$row2['time'];
     $pn=$row2['praname'];
     $pt=$row2['pratime'];
     $pid=$row2['praid'];


     $ti=date('Y年m月d日', strtotime($t));

  echo "<tr><td>$ti</td>";
    echo "<td>$pn</td>";

    echo "<td>$pt</td></tr>";


  }

  echo"</table>";
echo "<br>";



echo "<地方創生$k の出席履歴>";
echo "<table border='1' class='type06'>";
echo "<tr><th>実習内容</th><th>実習累計時間</th></tr>";


if(empty($pid)){
  header ('Location: ./u_home2.php');
  exit;




}





 $query3="select praid,count(*) as ppp from User_tabuken natural join Indi_tabuken where userid='$id' && kind=$k && praid=$pid group by praid";

$stmt3 = $dbh->query($query3);
$rec3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

foreach($rec3 as $row3 ){

$pratime=$row4['pratime'];
 $praid=$row3['praid'];

 $count=$row3['ppp'];



$query4="select * from Pra_tabuken where praid=$praid";

$stmt4 = $dbh->query($query4);
$rec4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);


foreach($rec4 as $row4 ){

$pratime=$row4['pratime'];
$pn=$row4['praname'];
$ruikei[$praid]=$count*$pratime;


$oo=array_sum($ruikei);

echo "<tr><td>$pn</td>";
echo "<td>$ruikei[$praid]</td></tr>";



}
}
if(isset($oo)){
  echo"</table>";
echo "累計$oo 時間";
}else{
echo"</table>";
echo "累計0時間";
echo "<br>";
echo "<br>";
 echo "実習履歴はありません";

}
}

}

?>
<br>



 <br>

 <p><a href="./t_logout.php?token=<?=h(generate_token())?>"> ログアウト</a></p>
<?php else : ?>
 <p><a href="./t_login.php">ログイン</a></p>
<?php endif;?>

        </font>
</center>

</body>
</html>
