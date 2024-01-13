<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/functions.php';
require_unlogined_session();
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


if($_POST['userid'] && $_POST['pass']){
  $userid=$_POST['userid'];
  $pass=$_POST['pass'];

        $query="select * from User_tabuken where userid='$userid' ";
        $stmt = $dbh->query($query);
        $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);




        foreach ($rec as $row) {
                $id = $row['userid'];
                $n = $row['username'];
                $p = $row['pass'];
    $k =$row['kind'];
    $a =$row['access'];

    $key = '長い鍵';
    $plain_text = $pass;
    $c_t = openssl_encrypt($plain_text, 'AES-128-ECB', $key);
    //$p_t = openssl_decrypt($p, 'AES-128-ECB', $key);


if ($id == $userid && $p==$c_t) {



     session_regenerate_id(true);
     //ユーザ名をセット
     $_SESSION['username'] = $n;
     $_SESSION['userid'] = $id;
     $_SESSION['pass']=$pass;

     // ログイン後に/に遷移
if($a==1){
 header ('Location: ./u_home.php');
 exit;
}elseif($a==0){

       header ('Location: ./k_home.php');
       exit;
}

 }

}

}
?>

<html lang='ja'>
  <link rel="stylesheet" href="http://tbsv.japanwest.cloudapp.azure.com/apps/tabusalab.css" type="text/css">
  <head>
           <title>出席管理</title>
  </head>
  <body>



  <div class="clouds">

  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="762px"
  height="331px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud big front slowest">
  <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
  c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
  C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
  S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
  </svg>
  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="762px"
  height="331px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud distant smaller">
  <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
  c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
  C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
  S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
  </svg>

  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="762px"
  height="331px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud small slow">
  <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
  c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
  C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
  S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
  </svg>

  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="762px"
  height="331px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud distant super-slow massive">
  <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
  c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
  C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
  S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
  </svg>

  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="762px"
  height="331px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud slower">
  <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
  c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
  C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
  S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
  </svg>

  </div>








  <script src="https://code.jquery.com/jquery-2.1.0.min.js" ></script>
  <body>
  <div id="formWrapper">

  <div id="form">
  <div class="logo">
    <font color="#8a8a8a">
<h1>Log In</h1>


  </div>
          <div class="form-item">
              <form action='t_login.php' method='POST'>

              <input type="text" name="userid" class="form-style" placeholder="UserID" autocomplete="off" />
          </div>
          <div class="form-item">

              <input type="password" name="pass" placeholder="Password" class="form-style" />
              <!-- <div class="pw-view"><i class="fa fa-eye"></i></div> -->

          </div>
          <div class="form-item">
          <p class="pull-left"><a href="#"></a></p>
          <input type="submit" class="login pull-right" value="Log In">
          <div class="clear-fix"></div>
          </div>

  <a href="http://tbsv.japanwest.cloudapp.azure.com/apps/signup.php">新規登録<br></a></p>

        </form>
  </div>
  </div>

  </body>
  </html>


  </center>

  </body>
</html>
