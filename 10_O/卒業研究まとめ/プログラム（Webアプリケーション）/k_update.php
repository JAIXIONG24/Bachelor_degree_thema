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
    $dbh->query('SET NAMES utf8'); //文字化 けの解消
}catch(PDOException $e){
    echo $e->getMessage();
    exit();
}
$g=$_POST['g'];
$gr=$_POST['gr'];
$pr=$_POST['praname'];

$id=$_POST['userid'];
$n=$_POST['username'];
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

    <p>学生アカウント更新</p>

    <p><?php echo $y0?>年度のアカウントの更新を行う学生を選択してください</p>

    <form action="#" method="post"><!--検索 ボタン-->


    </select></p>

    <select name='g'>
      <option value='all' <?php echo array_key_exists('g', $_POST) && $_POST['g'] == 'all' ? 'selected' : ''; ?>>全学年</option>
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

      if($_POST['so']){
        if($g=='all' && $gr=='all'){

                $y=date("Y");
                $m=date("m");
                if($m<=3){
                  $y=$y-1;
                }
              $yy=$y-5;
              $date1 = substr($yy, 2, 2);
              $num1 = (int) $date1;

        echo "<br>";
        echo "<全学年全学科>";
        echo "<table border='1' class='type5'>";
        echo "<tr><th></th><th>学生id</th><th>学生名</th></tr>";

        $query0="select userid,username,date,count(userid) as ppp from User_tabuken where date like '$y%' && kind!=0 group by userid" ;
        $stmt0 = $dbh->query($query0);
        $rec0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
        foreach($rec0 as $row0 ){
          $userid=$row0['userid'];
          $username=$row0['username'];
          $da=$row0['date'];
          $count=$row0['ppp'];

          $count1=$count1+$count;
          $array1[$count1]=array($userid);

}


      $query="select distinct userid,username,MAX(date) as dat from User_tabuken where date not like '$y%' && graid not like '_5%' && kind != 0 group by userid " ;
      $stmt = $dbh->query($query);
      $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);


      foreach($rec as $row ){
        $uid=$row['userid'];
        $un=$row['username'];
        $date=$row['dat'];
        $date2 = substr($uid, 1, 2);


        $num2 = (int) $date2;


        if($num1>=$num2){
          $t=1;
        }
        for($i=0; $i<=$count1;$i++){
        if (in_array($uid, $array1[$i])){
          $t=1;

}
}
if($t!==1){
     echo "<form action='k_updatekakunin.php' method='POST'>";
    echo "<tr><td><input type='checkbox' name='us[]' value='$date'></td>";
        echo "<td>$uid</td>";
        echo "<td>$un</td>";


      }
      $t=0;
}


    echo "</table>";
      echo "<br>";

      echo "<input type='hidden' name='uid' value='$uid'>";
      echo "<input type='hidden' name='un' value='$un'>";

        echo "<input type='hidden' name='userid' value='$id'>";
        echo "<input type='hidden' name='date' value='$date'>";

        echo "<input type='submit' name='kakunin' value='登録確認' class='btn btn-success'>";
        echo "</form>";
      echo "<br>";
      echo "<br>";


    }else if($gr=='all'){
     if($g=='2'){
  echo "<".$g."学年>";
  echo "<table border='1' class='type5'>";
  echo "<tr><th></th><th>学生id</th><th>学生名</th></tr>";

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


  $query0="select userid,username,date,count(userid) as ppp from User_tabuken where date like '$y%' && kind!=0 group by userid" ;
  $stmt0 = $dbh->query($query0);
  $rec0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
  foreach($rec0 as $row0 ){
  $userid=$row0['userid'];
  $username=$row0['username'];
  $da=$row0['date'];
  $count=$row0['ppp'];

  $count1=$count1+$count;
  $array1[$count1]=array($userid);

  }


  $query="select distinct userid,username,MAX(date) as dat from User_tabuken where date not like '$y%' && date like '$y1%' && graid like '_$w%' && kind != 0 group by userid " ;
  $stmt = $dbh->query($query);
  $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);


  foreach($rec as $row ){
  $uid=$row['userid'];
  $un=$row['username'];
  $date=$row['dat'];

  for($i=0; $i<=$count1;$i++){
  if (in_array($uid, $array1[$i])){
  $t=1;

  }
  }
  if($t!==1){
  echo "<form action='k_updatekakunin.php' method='POST'>";
  echo "<tr><td><input type='checkbox' name='us[]' value='$date'></td>";
  echo "<td>$uid</td>";
  echo "<td>$un</td></tr>";
  }
  $t=0;
  }


  echo "</table>";
  echo "<br>";

  echo "<input type='hidden' name='uid' value='$uid'>";
  echo "<input type='hidden' name='un' value='$un'>";

  echo "<input type='hidden' name='userid' value='$id'>";
  echo "<input type='hidden' name='date' value='$date'>";

  echo "<input type='submit' name='kakunin' value='登録確認' class='btn btn-success'>";
  echo "</form>";
  echo "<br>";
  echo "<br>";

}else if($g=='3'){
  echo "<".$g."学年>";
  echo "<table border='1' class='type5'>";
  echo "<tr><th></th><th>学生id</th><th>学生名</th></tr>";


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
    $w2='1';
    $y1=$y1-1;
    $y2=$y1-1;

    $query0="select userid,username,date,count(userid) as ppp from User_tabuken where date like '$y%' && kind!=0 group by userid" ;
    $stmt0 = $dbh->query($query0);
    $rec0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    foreach($rec0 as $row0 ){
    $userid=$row0['userid'];
    $username=$row0['username'];
    $da=$row0['date'];
    $count=$row0['ppp'];

    $count1=$count1+$count;
    $array1[$count1]=array($userid);

    }


  $query="select distinct userid,username,MAX(date) as dat from User_tabuken where date not like '$y%'&& date like '$y1%' && graid like '_$w%' && kind != 0 || date not like '$y%' && date like '$y2%' && graid like '_$w2%' && kind != 0 group by userid " ;
    $stmt = $dbh->query($query);
    $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach($rec as $row ){
    $uid=$row['userid'];
    $un=$row['username'];
    $date=$row['dat'];

    for($i=0; $i<=$count1;$i++){
    if (in_array($uid, $array1[$i])){
    $t=1;

    }
    }
    if($t!==1){
    echo "<form action='k_updatekakunin.php' method='POST'>";
    echo "<tr><td><input type='checkbox' name='us[]' value='$date'></td>";
    echo "<td>$uid</td>";
    echo "<td>$un</td></tr>";
    }
    $t=0;
    }


    echo "</table>";
    echo "<br>";

    echo "<input type='hidden' name='uid' value='$uid'>";
    echo "<input type='hidden' name='un' value='$un'>";

    echo "<input type='hidden' name='userid' value='$id'>";
    echo "<input type='hidden' name='date' value='$date'>";

    echo "<input type='submit' name='kakunin' value='登録確認' class='btn btn-success'>";
    echo "</form>";
    echo "<br>";
    echo "<br>";


  }else if($g=='4'){
    echo "<".$g."学年>";
    echo "<table border='1' class='type5'>";
    echo "<tr><th></th><th>学生id</th><th>学生名</th></tr>";


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
      $w='3';
      $w2='2';
      $w3='1';
      $y1=$y1-1;
      $y2=$y1-1;
      $y3=$y2-1;



      $query0="select userid,username,date,count(userid) as ppp from User_tabuken where date like '$y%' && kind!=0 group by userid" ;
      $stmt0 = $dbh->query($query0);
      $rec0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
      foreach($rec0 as $row0 ){
      $userid=$row0['userid'];
      $username=$row0['username'];
      $da=$row0['date'];
      $count=$row0['ppp'];

      $count1=$count1+$count;
      $array1[$count1]=array($userid);

      }


    $query="select distinct userid,username,MAX(date) as dat from User_tabuken where date not like '$y%' && date like '$y1%' && graid like '_$w%' && kind != 0 || date not like '$y%' && date like '$y2%' && graid like '_$w2%' && kind != 0 || date not like '$y%' && date like '$y3%' && graid like '_$w3%' && kind != 0 group by userid " ;
      $stmt = $dbh->query($query);
      $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);


      foreach($rec as $row ){
      $uid=$row['userid'];
      $un=$row['username'];
      $date=$row['dat'];

      for($i=0; $i<=$count1;$i++){
      if (in_array($uid, $array1[$i])){
      $t=1;

      }
      }
      if($t!==1){
      echo "<form action='k_updatekakunin.php' method='POST'>";
    echo "<tr><td><input type='checkbox' name='us[]' value='$date'></td>";
      echo "<td>$uid</td>";
        echo "<td>$un</td></tr>";
      }
      $t=0;
      }


      echo "</table>";
      echo "<br>";

      echo "<input type='hidden' name='uid' value='$uid'>";
      echo "<input type='hidden' name='un' value='$un'>";

      echo "<input type='hidden' name='userid' value='$id'>";
      echo "<input type='hidden' name='date' value='$date'>";
      echo "<input type='submit' name='kakunin' value='登録確認' class='btn btn-success'>";
      echo "</form>";
      echo "<br>";
      echo "<br>";

}else if($g=='5'){
  echo "<".$g."学年>";
  echo "<table border='1' class='type5'>";
  echo "<tr><th></th><th>学生id</th><th>学生名</th></tr>";


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
    $w='4';
    $w2='3';
    $w3='2';
    $w4='1';
    $y1=$y1-1;
    $y2=$y1-1;
    $y3=$y2-1;
    $y4=$y3-1;



    $query0="select userid,username,date,count(userid) as ppp from User_tabuken where date like '$y%' && kind!=0 group by userid" ;
    $stmt0 = $dbh->query($query0);
    $rec0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    foreach($rec0 as $row0 ){
    $userid=$row0['userid'];
    $username=$row0['username'];
    $da=$row0['date'];
    $count=$row0['ppp'];

    $count1=$count1+$count;
    $array1[$count1]=array($userid);

    }


  $query="select distinct userid,username,MAX(date) as dat from User_tabuken where date not like '$y%' && date like '$y1%' && graid like '_$w%' && kind != 0 || date not like '$y%' && date like '$y2%' && graid like '_$w2%' && kind != 0 || date not like '$y%' && date like '$y3%' && graid like '_$w3%' && kind != 0 || date not like '$y%' && date like '$y4%' && graid like '_$w4%' && kind != 0  group by userid " ;
    $stmt = $dbh->query($query);
    $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach($rec as $row ){
    $uid=$row['userid'];
    $un=$row['username'];
    $date=$row['dat'];

    for($i=0; $i<=$count1;$i++){
    if (in_array($uid, $array1[$i])){
    $t=1;

    }
    }
    if($t!==1){
    echo "<form action='k_updatekakunin.php' method='POST'>";
    echo "<tr><td><input type='checkbox' name='us[]' value='$date'></td>";
    echo "<td>$uid</td>";
    echo "<td>$un</td></tr>";
    }
    $t=0;
    }


    echo "</table>";
    echo "<br>";

    echo "<input type='hidden' name='uid' value='$uid'>";
    echo "<input type='hidden' name='un' value='$un'>";

    echo "<input type='hidden' name='userid' value='$id'>";
  echo "<input type='hidden' name='date' value='$date'>";

    echo "<input type='submit' name='kakunin' value='登録確認' class='btn btn-success'>";
    echo "</form>";
    echo "<br>";
    echo "<br>";
}


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
                      $yy=$y-5;
                      $date1 = substr($yy, 2, 2);
                      $num1 = (int) $date1;



              $query0="select userid,username,date,count(userid) as ppp from User_tabuken where date like '$y%' && kind!=0 group by userid" ;
              $stmt0 = $dbh->query($query0);
              $rec0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
              foreach($rec0 as $row0 ){
                $userid=$row0['userid'];
                $username=$row0['username'];
                $da=$row0['date'];
                $count=$row0['ppp'];

                $count1=$count1+$count;
                $array1[$count1]=array($userid);

      }


            $query="select distinct userid,username,MAX(date) as dat from User_tabuken where date not like '$y%' && graid not like '_5%' && kind != 0 && graid like '$gr%' group by userid " ;
            $stmt = $dbh->query($query);
            $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);


            foreach($rec as $row ){
              $uid=$row['userid'];
              $un=$row['username'];
              $date=$row['dat'];
              $date2 = substr($uid, 1, 2);
              $num2 = (int) $date2;
              if($num1>=$num2){
                $t=1;
              }

              for($i=0; $i<=$count1;$i++){
              if (in_array($uid, $array1[$i])){
                $t=1;

      }
      }
      if($t!==1){
           echo "<form action='k_updatekakunin.php' method='POST'>";
          echo "<tr><td><input type='checkbox' name='us[]' value='$date'></td>";
              echo "<td>$uid</td>";
                echo "<td>$un</td></tr>";
            }
            $t=0;
      }


          echo "</table>";
            echo "<br>";

            echo "<input type='hidden' name='uid' value='$uid'>";
            echo "<input type='hidden' name='un' value='$un'>";

              echo "<input type='hidden' name='userid' value='$id'>";
            echo "<input type='hidden' name='date' value='$date'>";

              echo "<input type='submit' name='kakunin' value='登録確認' class='btn btn-success'>";
              echo "</form>";
            echo "<br>";
            echo "<br>";

  }else{
    if($g=='2'){
  echo "<".$g."学年　".$gr."科>";
  echo "<table border='1' class='type5'>";
  echo "<tr><th></th><th>学生id</th><th>学生名</th></tr>";

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


  $query0="select userid,username,date,count(userid) as ppp from User_tabuken where date like '$y%' && kind!=0 group by userid" ;
  $stmt0 = $dbh->query($query0);
  $rec0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
  foreach($rec0 as $row0 ){
  $userid=$row0['userid'];
  $username=$row0['username'];
  $da=$row0['date'];
  $count=$row0['ppp'];

  $count1=$count1+$count;
  $array1[$count1]=array($userid);

  }


  $query="select distinct userid,username,MAX(date) as dat from User_tabuken where date not like '$y%' && date like '$y1%' && graid like '_$w%' && kind != 0 && graid like '$gr%' group by userid " ;
  $stmt = $dbh->query($query);
  $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);


  foreach($rec as $row ){
  $uid=$row['userid'];
  $un=$row['username'];
  $date=$row['dat'];

  for($i=0; $i<=$count1;$i++){
  if (in_array($uid, $array1[$i])){
  $t=1;

  }
  }
  if($t!==1){
  echo "<form action='k_updatekakunin.php' method='POST'>";
  echo "<tr><td><input type='checkbox' name='us[]' value='$date'></td>";
  echo "<td>$uid</td>";
    echo "<td>$un</td></tr>";
  }
  $t=0;
  }


  echo "</table>";
  echo "<br>";

  echo "<input type='hidden' name='uid' value='$uid'>";
  echo "<input type='hidden' name='un' value='$un'>";

  echo "<input type='hidden' name='userid' value='$id'>";
  echo "<input type='hidden' name='date' value='$date'>";

  echo "<input type='submit' name='kakunin' value='登録確認' class='btn btn-success'>";
  echo "</form>";
  echo "<br>";
  echo "<br>";



  }else if($g=='3'){
echo "<".$g."学年　".$gr."科>";
    echo "<table border='1' class='type5'>";
    echo "<tr><th></th><th>学生id</th><th>学生名</th></tr>";


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
      $w2='1';
      $y1=$y1-1;
      $y2=$y1-1;


      $query0="select userid,username,date,count(userid) as ppp from User_tabuken where date like '$y%' && kind!=0 group by userid" ;
      $stmt0 = $dbh->query($query0);
      $rec0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
      foreach($rec0 as $row0 ){
      $userid=$row0['userid'];
      $username=$row0['username'];
      $da=$row0['date'];
      $count=$row0['ppp'];

      $count1=$count1+$count;
      $array1[$count1]=array($userid);

      }


      $query="select distinct userid,username,MAX(date) as dat from User_tabuken where date not like '$y%' && date like '$y1%' && graid like '_$w%' && kind != 0 && graid like '$gr%' || date not like '$y%' && date like '$y2%' && graid like '_$w2%' && kind != 0 && graid like '$gr%' group by userid " ;
      $stmt = $dbh->query($query);
      $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);


      foreach($rec as $row ){
      $uid=$row['userid'];
      $un=$row['username'];
      $date=$row['dat'];

      for($i=0; $i<=$count1;$i++){
      if (in_array($uid, $array1[$i])){
      $t=1;

      }
      }
      if($t!==1){
      echo "<form action='k_updatekakunin.php' method='POST'>";
      echo "<tr><td><input type='checkbox' name='us[]' value='$date'></td>";
      echo "<td>$uid</td>";
      echo "<td>$un</td></tr>";
      }
      $t=0;
      }


      echo "</table>";
      echo "<br>";

      echo "<input type='hidden' name='uid' value='$uid'>";
      echo "<input type='hidden' name='un' value='$un'>";

      echo "<input type='hidden' name='userid' value='$id'>";
      echo "<input type='hidden' name='date' value='$date'>";

      echo "<input type='submit' name='kakunin' value='登録確認' class='btn btn-success'>";
      echo "</form>";
      echo "<br>";
      echo "<br>";


    }else if($g=='4'){
    echo "<".$g."学年　".$gr."科>";
      echo "<table border='1' class='type5'>";
      echo "<tr><th></th><th>学生id</th><th>学生名</th></tr>";


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
        $w='3';
        $w2='2';
        $w3='1';
        $y1=$y1-1;
        $y2=$y1-1;
        $y3=$y2-1;


        $query0="select userid,username,date,count(userid) as ppp from User_tabuken where date like '$y%' && kind!=0 group by userid" ;
        $stmt0 = $dbh->query($query0);
        $rec0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
        foreach($rec0 as $row0 ){
        $userid=$row0['userid'];
        $username=$row0['username'];
        $da=$row0['date'];
        $count=$row0['ppp'];

        $count1=$count1+$count;
        $array1[$count1]=array($userid);

        }


    $query="select distinct userid,username,MAX(date) as dat from User_tabuken where date not like '$y%' && date like '$y1%' && graid like '_$w%' && kind != 0 && graid like '$gr%' || date not like '$y%' && date like '$y2%' && graid like '_$w2%' && kind != 0 && graid like '$gr%' || date not like '$y%' && date like '$y3%' && graid like '_$w3%' && kind != 0 && graid like '$gr%' group by userid " ;
        $stmt = $dbh->query($query);
        $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);


        foreach($rec as $row ){
        $uid=$row['userid'];
        $un=$row['username'];
        $date=$row['dat'];

        for($i=0; $i<=$count1;$i++){
        if (in_array($uid, $array1[$i])){
        $t=1;

        }
        }
        if($t!==1){
        echo "<form action='k_updatekakunin.php' method='POST'>";
        echo "<tr><td><input type='checkbox' name='us[]' value='$date'></td>";
        echo "<td>$uid</td>";
          echo "<td>$un</td></tr>";
        }
        $t=0;
        }


        echo "</table>";
        echo "<br>";

        echo "<input type='hidden' name='uid' value='$uid'>";
        echo "<input type='hidden' name='un' value='$un'>";

        echo "<input type='hidden' name='userid' value='$id'>";
        echo "<input type='hidden' name='date' value='$date'>";

        echo "<input type='submit' name='kakunin' value='登録確認' class='btn btn-success'>";
        echo "</form>";
        echo "<br>";
        echo "<br>";


  }else if($g=='5'){
  echo "<".$g."学年　".$gr."科>";
    echo "<table border='1' class='type5'>";
    echo "<tr><th></th><th>学生id</th><th>学生名</th></tr>";


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
      $w='4';
      $w2='3';
      $w3='2';
      $w4='1';
      $y1=$y1-1;
      $y2=$y1-1;
      $y3=$y2-1;
      $y4=$y3-1;


      $query0="select userid,username,date,count(userid) as ppp from User_tabuken where date like '$y%' && kind!=0 group by userid" ;
      $stmt0 = $dbh->query($query0);
      $rec0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
      foreach($rec0 as $row0 ){
      $userid=$row0['userid'];
      $username=$row0['username'];
      $da=$row0['date'];
      $count=$row0['ppp'];

      $count1=$count1+$count;
      $array1[$count1]=array($userid);

      }


  $query="select distinct userid,username,MAX(date) as dat from User_tabuken where date not like '$y%' && date like '$y1%' && graid like '_$w%' && kind != 0 && graid like '$gr%' || date not like '$y%' && date like '$y2%' && graid like '_$w2%' && kind != 0 && graid like '$gr%' || date not like '$y%' && date like '$y3%' && graid like '_$w3%' && kind != 0 && graid like '$gr%' || date not like '$y%' && date like '$y4%' && graid like '_$w4%' && kind != 0 && graid like '$gr%' group by userid " ;
      $stmt = $dbh->query($query);
      $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);


      foreach($rec as $row ){
      $uid=$row['userid'];
      $un=$row['username'];
      $date=$row['dat'];

      for($i=0; $i<=$count1;$i++){
      if (in_array($uid, $array1[$i])){
      $t=1;

      }
      }
      if($t!==1){
      echo "<form action='k_updatekakunin.php' method='POST'>";
      echo "<tr><td><input type='checkbox' name='us[]' value='$date'></td>";
      echo "<td>$uid</td>";
        echo "<td>$un</td></tr>";
      }
      $t=0;
      }


      echo "</table>";
      echo "<br>";

      echo "<input type='hidden' name='uid' value='$uid'>";
      echo "<input type='hidden' name='un' value='$un'>";

      echo "<input type='hidden' name='userid' value='$id'>";
      echo "<input type='hidden' name='date' value='$date'>";
      echo "<input type='submit' name='kakunin' value='登録確認' class='btn btn-success'>";
      echo "</form>";
      echo "<br>";
      echo "<br>";
}





  }

  }

?>
    <p><a href="k_home.php">ホームへ</a></p>

  </center>
  </body>
  </html>
