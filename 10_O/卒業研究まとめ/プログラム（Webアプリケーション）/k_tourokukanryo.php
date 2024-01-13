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
$t=$_POST['time'];

$t1=date("12:00:00");

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

    <p>実習内容一括登録完了しました</p>
<br>
<?php
if (isset($_POST['uid']) && is_array($_POST['uid'])) {

  for($i=0; $i<count($_POST["uid"]); $i++){
    $uid=$_POST['uid'][$i];

    $query1="select * from Pra_tabuken where praname='$pr'" ;
    $stmt1 = $dbh->query($query1);
    $rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    foreach($rec1 as $row1 ){
      $pid=$row1['praid'];

      $y=date("Y");
      $m=date("m");
      if($m<=3){
        $y=$y-1;
      }
      $d=$y.$uid;
      $tt=$t." ".$t1;


      $query="insert into Indi_tabuken(date,praid,time) values('$d',$pid,'$tt')";//実習一覧の表示
      $stmt = $dbh->query($query);



    }

  }

}

 ?>

   <p><a href="k_touroku.php">一括登録ページへ</a></p>
   <p><a href="k_home.php">ホームへ</a></p>

   </center>
   </body>
   </html>
