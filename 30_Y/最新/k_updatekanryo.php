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
$pr=$_POST['praname'];

$id=$_POST['userid'];
$n=$_POST['username'];
$date=$_POST['date'];
  $oo=0;





    $y=date("Y");
    $m=date("m");
    if($m<=3){
      $y=$y-1;
    }
  $y0=$y;
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

    <p><?php echo $y0?>年度の学生アカウントの登録を完了しました</p>
<br>
<?php
if (isset($_POST['uid']) && is_array($_POST['uid'])) {

  for($i=0; $i<count($_POST["uid"]); $i++){
    $uid=$_POST['uid'][$i];


      $query1="select * from User_tabuken where date='$uid'" ;
      $stmt1 = $dbh->query($query1);
      $rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    foreach($rec1 as $row1 ){
      $userid=$row1['userid'];
      $graid=$row1['graid'];
      $username=$row1['username'];
      $pass=$row1['pass'];
      $kind=$row1['kind'];
      $date=$row1['date'];



      $y=date("Y");
      $m=date("m");
      if($m<=3){
        $y=$y-1;
      }
      $y2=$y;
      $date1 = substr($userid, 1, 2);
        $date2 = substr($y2, 2, 2);

      $num1 = (int) $date1;
      $gra0=$date2-$date1;
      $gra=$gra0+1;

      $gra1 = substr($graid, 0, 1);
      $gra2 = substr($graid, 2, 1);
      $gra3 = substr($graid, 3, 1);



      $gra=$gra1.$gra.$gra2.$gra3;

      $y1=$y;
      $d=$y1.$userid;


if($gra==1 ||$gra==2||$gra==3){
  $k=1;
}else{
  $k=2;
}

      $query="insert into User_tabuken(graid,userid,username,pass,kind,access,date) values('$gra','$userid','$username','$pass',$k,1,'$d')";//実習一覧の表示
      $stmt = $dbh->query($query);



    }

  }

}

 ?>


   <p><a href="k_home.php">ホーム</a></p>

   </center>
   </body>
   </html>
