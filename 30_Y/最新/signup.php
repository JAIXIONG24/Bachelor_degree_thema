
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



?>


<html lang='ja'>
  <link rel="stylesheet" href="http://tbsv.japanwest.cloudapp.azure.com/apps/tabusalab.css" type="text/css">


  <head>
           <title>出席管理</title>
  </head>
  <body>



  <script src="https://code.jquery.com/jquery-2.1.0.min.js" ></script>

  <div id="formWrapper">

  <div id="form">
  <div class="logo">
    <font color="#8a8a8a">
  <h1>新規登録</h1>


  </div>
          <div class="form-item">
              <form action='signok.php' method='POST'>

              <p>ユーザー名<input type='text' name='userid' class="form-style" placeholder="例 　i16000" autocomplete="off" />
              </p>
          </div>
          <div class="form-item">

              <p>パスワード<input type="password" name="pass" placeholder="半角 英数字6文字以上15文字以内" class="form-style" />
                  <p><input type="password" name="pass2" placeholder="もう一度入力してください" class="form-style" />
              <!-- <div class="pw-view"><i class="fa fa-eye"></i></div> -->
            </p>
          </div>

          <div class="form-item">
          <p>学科:
            <select name="major"class="form-style">
              <option value="S">S</option>
              <option value="M">M</option>
              <option value="I">I</option>
            </select>
          </p>
        </div>

        <div class="form-item">
        <p>学年:
          <select name="grade"class="form-style">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </p>
        </div>

        <div class="form-item">
          <p>出席番号<input type='text' name='number' class="form-style" placeholder="1桁の場合は2桁で入力" autocomplete="off" />
          </P>
        </div>

        <div class="form-item">
            <p>名前<input type='text' name='name' class="form-style" placeholder="例　弓削太郎" autocomplete="off" />
            </p>
        </div>

          <div class="form-item">
          <p class="pull-left"><a href="#"></a></p>
          <input type="submit" name="signup"class="login pull-right" value="新規登録">
          <div class="clear-fix"></div>
          </div>




</form>

 <p><a href="./t_login.php">ログイン</a></p>
 </form>
</div>
</div>

</body>
</html>
<?php


 ?>





</body>
</html>
