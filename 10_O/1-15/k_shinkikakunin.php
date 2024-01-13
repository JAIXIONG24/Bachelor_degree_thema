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
<p>管理者登録確認</p>
<br>

<?php

$uid=$_POST['usid'];
$un=$_POST['uname'];
$p=$_POST['pass'];

$query="select count(*) as num from User_tabuken where pass='$p'";
   $stmt = $dbh->query($query);
   $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
   foreach($rec as $row ){
     $c=$row['num'];

   }

   $uid = mb_convert_kana($uid, 'a','UTF-8');

$query="select count(*) as sum from User_tabuken where userid='$uid'";
   $stmt = $dbh->query($query);
   $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
   foreach($rec as $row ){
     $cnt=$row['sum'];

   }

  $id=strlen($uid);
  $pa=strlen($p);

if(empty($_POST['usid'] && $_POST['uname'] && $_POST['pass'])){
echo"全ての項目を入力してください。";

}else{
  if($id==6 && $pa>=6){
  if($cnt==0){
    if($c==0){

  echo "<br>";

  $un=$_POST['uname'];
  $p=$_POST['pass'];

  echo "<table border='1' class='type1'>";//実習先一覧のテーブル
  echo "<tr><th>管理者id</th><th>管理者名</th><th>管理者password</th></tr>";

  echo "<tr><td>$uid</td>";
  echo "<td>$un</td>";
  echo "<td>設定したパスワード</td></tr>";

  echo "</table>";
  echo "<br>";

 ?>

  <form action="k_shinkikanryo.php" method="post"><!--管理者登録ボタン-->
    <input type="hidden" name="usid" value="<?php echo $uid; ?>">
    <input type="hidden" name="uname" value="<?php echo $un; ?>">
    <input type="hidden" name="pass" value="<?php echo $p; ?>">

    <input type="hidden" name="userid" value="<?php echo $id; ?>">
    <input type="hidden" name="username" value="<?php echo $n; ?>">
  <input type="submit" name="kensaku" value="登録" class="btn btn-success">
</form>
<?php

}else{
  echo "そのパスワードは使えません。";
  echo "<br>";
  echo "パスワードを変更してください。";

}
}else{
  echo "その管理者idは登録されています。";
  echo "<br>";
  echo "管理者idを変更してください。";


}

}else{
  echo "ユーザIDまたはパスワードが正しく入力されていません";
  echo "<br>";
   echo "ユーザIDは例のように、パスワードは半角英数字の6桁以上で入力してください";

  echo "<br>";

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
