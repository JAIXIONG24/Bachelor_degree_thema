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
$pr=$_POST['praname'];

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



    <p>実習内容一括登録</p>
  <br>
    <p>一括登録を行う日付と学生、実習先を選択してください</p>

    <form action="#" method="post"><!--検索ボタン-->
      <p>日付：<input type="date" name="time" value="<?php if(!empty($_POST['time'])) echo $_POST['time']; ?>"></p>

学生：
    <select name='g'>
    <option value='all' <?php echo array_key_exists('g', $_POST) && $_POST['g'] == 'all' ? 'selected' : ''; ?>>全学年</option>
    <option value='1' <?php echo array_key_exists('g', $_POST) && $_POST['g'] == '1' ? 'selected' : ''; ?>>1学年</option>
    <option value='2' <?php echo array_key_exists('g', $_POST) && $_POST['g'] == '2' ? 'selected' : ''; ?>>2学年</option>
    <option value='3' <?php echo array_key_exists('g', $_POST) && $_POST['g'] == '3' ? 'selected' : ''; ?>>3学年</option>
    <option value='4' <?php echo array_key_exists('g', $_POST) && $_POST['g'] == '4' ? 'selected' : ''; ?>>4学年</option>
    <option value='5' <?php echo array_key_exists('g', $_POST) && $_POST['g'] == '5' ? 'selected' : ''; ?>>5学年</option>
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
    $t=$_POST['time'];

    if($_POST['so']){
      if($g=='all' && $gr=='all'){
        echo "<br>";

      echo "<全学年全学科>";
      echo "<table border='1' class='type5'>";
      echo "<tr><th></th><th>学生id</th><th>学生名</th></tr>";

      $y=date("Y");
      $m=date("m");
      if($m<=3){
        $y=$y-1;
      }
    $query="select * from User_tabuken where date like '$y%' && access=1 group by userid" ;
    $stmt = $dbh->query($query);
    $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($rec as $row ){
      $uid=$row['userid'];
      $un=$row['username'];

  echo "<form action='k_tourokukakunin.php' method='POST'>";
  echo "<tr><td><input type='checkbox' name='us[]' value='$uid'></td>";
      echo "<td>$uid</td>";
      echo "<td>$un</td></tr>";
    }
  echo "</table>";
    echo "<br>";
    echo "<br>";



    ?>
    <p>実習先：
    <select name="praname">
    <?php
    $query2="select * from Pra_tabuken";//実習一覧の表示
    $stmt2 = $dbh->query($query2);
    $rec2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    foreach($rec2 as $row2 ){
      $praname=$row2['praname'];
    ?>
      <option value="<?php echo $praname;?>"><?php echo $praname;?></option>
      <?php
    }
     ?>
    </select></p>
    <?php
    echo "<br>";

    echo "<input type='hidden' name='time' value='$t'>";
    echo "<input type='hidden' name='uid' value='$uid'>";
    echo "<input type='hidden' name='un' value='$un'>";

      echo "<input type='hidden' name='userid' value='$id'>";
      echo "<input type='hidden' name='username' value='$n'>";

      echo "<input type='submit' name='kakunin' value='登録確認' class='btn btn-success'>";
      echo "</form>";
    echo "<br>";
    echo "<br>";



  }else if($gr=='all'){
    echo "<br>";

    echo "<".$g."学年>";
    echo "<table border='1' class='type5'>";
    echo "<tr><th></th><th>学生id</th><th>学生名</th></tr>";

    $y=date("Y");
    $m=date("m");
    if($m<=3){
      $y=$y-1;
    }
  $query="select * from User_tabuken where graid like '_$g%' && date like '$y%' && access=1 group by userid" ;
  $stmt = $dbh->query($query);
  $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach($rec as $row ){
    $uid=$row['userid'];
    $un=$row['username'];

echo "<form action='k_tourokukakunin.php' method='POST'>";
echo "<tr><td><input type='checkbox' name='us[]' value='$uid'></td>";
    echo "<td>$uid</td>";
    echo "<td>$un</td></tr>";


  }
  echo "</table>";
  echo "<br>";
  echo "<br>";


  ?>
  <p>実習先：
  <select name="praname">
  <?php
  $query2="select * from Pra_tabuken";//実習一覧の表示
  $stmt2 = $dbh->query($query2);
  $rec2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

  foreach($rec2 as $row2 ){
    $praname=$row2['praname'];
  ?>
    <option value="<?php echo $praname;?>"><?php echo $praname;?></option>
    <?php
  }
   ?>
  </select></p>
  <?php
  echo "<br>";

  echo "<input type='hidden' name='time' value='$t'>";
  echo "<input type='hidden' name='uid' value='$uid'>";
  echo "<input type='hidden' name='un' value='$un'>";

    echo "<input type='hidden' name='userid' value='$id'>";
    echo "<input type='hidden' name='username' value='$n'>";

    echo "<input type='submit' name='kakunin' value='登録確認' class='btn btn-success'>";
    echo "</form>";
  echo "<br>";
  echo "<br>";


  }else if($g=='all'){
    echo "<br>";

    echo "＜".$gr."科＞";
    echo "<table border='1' class='type5'>";
    echo "<tr><th></th><th>学生id</th><th>学生名</th></tr>";
    $y=date("Y");
    $m=date("m");
    if($m<=3){
      $y=$y-1;
    }
  $query="select * from User_tabuken where graid like '$gr%' && date like '$y%' && access=1 group by userid" ;
  $stmt = $dbh->query($query);
  $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach($rec as $row ){
    $uid=$row['userid'];
    $un=$row['username'];

echo "<form action='k_tourokukakunin.php' method='POST'>";
echo "<tr><td><input type='checkbox' name='us[]' value='$uid'></td>";
    echo "<td>$uid</td>";
    echo "<td>$un</td></tr>";

  }
    echo "</table>";
  echo "<br>";
  echo "<br>";


  ?>
  <p>実習先：
  <select name="praname">
  <?php
  $query2="select * from Pra_tabuken";//実習一覧の表示
  $stmt2 = $dbh->query($query2);
  $rec2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

  foreach($rec2 as $row2 ){
    $praname=$row2['praname'];
  ?>
    <option value="<?php echo $praname;?>"><?php echo $praname;?></option>
    <?php
  }
   ?>
  </select></p>
  <?php
  echo "<br>";

  echo "<input type='hidden' name='time' value='$t'>";
  echo "<input type='hidden' name='uid' value='$uid'>";
  echo "<input type='hidden' name='un' value='$un'>";

    echo "<input type='hidden' name='userid' value='$id'>";
    echo "<input type='hidden' name='username' value='$n'>";

    echo "<input type='submit' name='kakunin' value='登録確認' class='btn btn-success'>";
    echo "</form>";
  echo "<br>";
  echo "<br>";


}else{
  echo "<br>";

  echo "<".$g."学年　".$gr."科>";
  echo "<table border='1' class='type5'>";
  echo "<tr><th></th><th>学生id</th><th>学生名</th></tr>";

  $y=date("Y");
  $m=date("m");
  if($m<=3){
    $y=$y-1;
  }
$query="select * from User_tabuken where graid like '$gr%' && date like '$y%' && graid like '_$g%' && access=1 group by userid" ;
$stmt = $dbh->query($query);
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rec as $row ){
  $uid=$row['userid'];
  $un=$row['username'];

echo "<form action='k_tourokukakunin.php' method='POST'>";
echo "<tr><td><input type='checkbox' name='us[]' value='$uid'></td>";
  echo "<td>$uid</td>";
  echo "<td>$un</td></tr>";
}
  echo "</table>";
echo "<br>";
echo "<br>";


?>
<p>実習先：
<select name="praname">
<?php
$query2="select * from Pra_tabuken";//実習一覧の表示
$stmt2 = $dbh->query($query2);
$rec2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

foreach($rec2 as $row2 ){
  $praname=$row2['praname'];
?>
  <option value="<?php echo $praname;?>"><?php echo $praname;?></option>
  <?php
}
 ?>
</select></p>
<?php
echo "<br>";

echo "<input type='hidden' name='time' value='$t'>";
echo "<input type='hidden' name='uid' value='$uid'>";
echo "<input type='hidden' name='un' value='$un'>";

  echo "<input type='hidden' name='userid' value='$id'>";
  echo "<input type='hidden' name='username' value='$n'>";

  echo "<input type='submit' name='kakunin' value='登録確認' class='btn btn-success'>";
  echo "</form>";
echo "<br>";
echo "<br>";

}

}
 ?>

    <p><a href="k_home.php">ホームへ</a></p>

  </center>
  </body>
  </html>
