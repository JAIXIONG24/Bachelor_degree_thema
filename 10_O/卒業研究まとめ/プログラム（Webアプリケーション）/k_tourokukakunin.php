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

    <p>実習内容一括登録確認</p>

<br>
<?php
echo "<table border='1' class='type6'>";
echo "<tr><th>日付</th><td>$t</td></tr>";
echo "<tr><th>実習先</th><td>$pr</td></tr>";

echo "</table>";
echo "<br>";





if (isset($_POST['us']) && is_array($_POST['us'])) {
  if(empty($_POST['time'])){
    echo "日付を選択してください";
    echo "<br>";
    echo "<br>";
  }else{
  echo "<table border='1' class='type5'>";
  echo "<tr><th>学生id</th><th>学生名</th></tr>";

  for($i=0; $i<count($_POST["us"]); $i++){
    $us=$_POST['us'][$i];

    $y=date("Y");
    $m=date("m");
    if($m<=3){
      $y=$y-1;
    }
  $query="select * from User_tabuken where userid='$us' && date like '$y%' && access=1 group by userid" ;
  $stmt = $dbh->query($query);
  $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach($rec as $row ){
    $uid=$row['userid'];
    $un=$row['username'];

        echo "<tr><td>$uid</td>";
        echo "<td>$un</td></tr>";

        echo "<form action='k_tourokukanryo.php' method='post'>";
        echo "<input type='hidden' name='uid[]' value='$uid'>";

      }

}
echo "</table>";
echo "<br>";

echo "<input type='hidden' name='time' value='$t'>";
echo "<input type='hidden' name='praname' value='$pr'>";

echo "<input type='hidden' name='userid' value='$id'>";
echo "<input type='hidden' name='username' value='$n'>";
echo "<input type='submit' name='henkou' value='登録' class='btn btn-success'>";
echo "</form>";

echo "<br>";
echo "<br>";


}



}else{
  echo "学生を選択してください";
  echo "<br>";
  echo "<br>";

}



//ホスト名取得
$h = $_SERVER['HTTP_HOST'];

// リファラ値があれば、かつ外部サイトでなければaタグで戻るリンクを表示
if (!empty($_SERVER['HTTP_REFERER']) && (strpos($_SERVER['HTTP_REFERER'],$h) !== false)) {
  echo '<a href="' . $_SERVER['HTTP_REFERER'] . '">戻る</a>';
}



 ?>


  </center>
  </body>
  </html>
