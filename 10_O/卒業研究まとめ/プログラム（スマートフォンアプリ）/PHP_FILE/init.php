<?php

define('DB_DATABASE', 'tabusalab');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'tabusalab');
define('PDO_DSN', 'mysql:dbhost=tbsv.japanwest.cloudapp.azure.com;dbname=tabusalab');

try{
  $dbh = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  $dbh->query('SET NAMES utf8'); //文字化けの解消

  //echo"connection success...";

}catch(PDOException $e){
  echo $e->getMessage();
  exit();

}



 ?>
