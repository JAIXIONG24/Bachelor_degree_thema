<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/functions.php';


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
<html>
<link rel="stylesheet" href="http://tbsv.japanwest.cloudapp.azure.com/apps/tabusalab3.css" type="text/css">
<body>

        <center>
        <font size="3">
                <h1>地域創生演習実施履歴</h1>
<br>




<?php
echo "その実習履歴はありません";
?>
<br>
<br>
<a href="http://tbsv.japanwest.cloudapp.azure.com/apps/u_home.php">検索画面へ戻 る<br></a></p>




</font>
</center>

</body>
</html>
