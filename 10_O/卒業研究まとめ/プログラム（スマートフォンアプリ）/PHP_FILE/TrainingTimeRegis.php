<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
  //アプリから登録したデーターを受け取り
  date_default_timezone_set('Asia/Tokyo');

	$userid = $_POST["userid"];
	$praid = $_POST["graid"];
	$time = date("Y-m-d\TH:i:s");
	
	$y=date("Y");
	$m=date("m");
	if($m<=3){
	  $y = $y - 1;
	}

	$date =$y.$userid;
	
    
	require_once 'init.php';

	if($userid != ""&&$praid !=""){

		//MySqlにデーターを登録する
	    $query = " insert into Indi_tabuken(date, praid, time) values('$date','$praid','$time')";
        $stmt = $dbh->query($query);
         //データーが登録できるかどうか調べる
	    if($stmt){

		    $result["success"] = "1";
		    $result["message"] = "success";


	    }else{
		    $result["success"] = "0";
		    $result["message"] = "error";
   
	    }

	}else{
		$result["success"] = "2";
		$result["message"] = "error";

	}

	echo json_encode($result);
	mysqli_close($dbh);


  

}

?>
