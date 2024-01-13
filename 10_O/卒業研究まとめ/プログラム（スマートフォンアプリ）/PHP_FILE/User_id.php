<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
  //アプリから登録したデーターを受け取り

	$userid = $_POST["userid"];

	$y=date("Y");
	$m=date("m");
	if($m<=3){
	  $y = $y - 1;
	}
	$date=$y.$userid;

	require_once 'init.php';

	/*
	*
	*/
	$query ="SELECT * FROM User_tabuken WHERE date='$date'";
    $stmt1 = $dbh->query($query);
    $rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    
    if($rec1){
        $result["success"] = "0";
        $result["message"] = "error";
        
    }else{

        $result["success"] = "1";
        $result["message"] = "success";

    }

	echo json_encode($result);
	mysqli_close($dbh);


}

?>
