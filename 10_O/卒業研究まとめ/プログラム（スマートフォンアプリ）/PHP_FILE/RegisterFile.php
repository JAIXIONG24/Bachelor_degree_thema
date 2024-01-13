<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
  //アプリから登録したデーターを受け取り
	$username = $_POST["username"];
	$pass = $_POST["pass"];
	$userid = $_POST["userid"];
	$de = $_POST["gakka"];
	$gra =$_POST["gakunen"];
	$seat =$_POST["seat"];



	$graid="$de".$gra.$seat;
	if($gra<=3){
	  $kind=1;
	}else if($gra>=4){
	  $kind=2;
	}

	$access=1;
	$y=date("Y");
	$m=date("m");
	if($m<=3){
	  $y = $y - 1;
	}
	$date=$y.$userid;
//パスワードを暗号する
    $key = '長い鍵';
	$plain_text =$pass;

	$c_t =openssl_encrypt($plain_text, 'AES-128-ECB', $key);


	require_once 'init.php';

	/*
	*
	*/
	$query ="SELECT * FROM User_tabuken WHERE date='$date'";
    $stmt1 = $dbh->query($query);
	$rec1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

	if(strlen($userid)==6){
		if(strlen($pass)>=6){
			if($rec1){
				$result["success"] = "2";
				$result["message"] = "このユーザーIDが登録できない。";
			}else{
	
				//MySqlにデーターを登録する
				$query = " insert into User_tabuken(graid,userid,username,pass,kind,access,date) values('$graid','$userid','$username','$c_t','$kind','$access','$date')";
				$stmt = $dbh->query($query);
				//データーが登録できるかどうか調べる
				if($stmt){
		  
					$result["success"] = "1";
					$result["message"] = "success";
		  
					// echo json_encode($result);
					// mysqli_close($dbh);
		  
			   }else{
					$result["success"] = "0";
					$result["message"] = "error";

				}
	
	
			}

		}else{
			$result["success"] = "3";
			$result["message"] = "パスワードが６桁以上してください。";
			
		}
		

	}else{
		$result["success"] = "4";
		$result["message"] = "ユーザーIDを６桁にして下さい。";

	}


	
	// if($rec1)
	// {
	// 	// $result["success"] = "2";
	// 	// $result["message"] = "success";

	// }else{

	// 	/*
	// 	*
	// 	*/

	// 	//MySqlにデーターを登録する
	//     $query = " insert into User_tabuken(graid,userid,username,pass,kind,access,date) values('$graid','$userid','$username','$c_t','$kind','$access','$date')";
	//     $stmt = $dbh->query($query);
	//     //データーが登録できるかどうか調べる
	//     if($stmt){
  
	// 	    $result["success"] = "1";
	// 	    $result["message"] = "success";
  
	// 	    // echo json_encode($result);
	// 	    // mysqli_close($dbh);
  
	//    }else{
	// 	    $result["success"] = "0";
	// 	    $result["message"] = "error";
  
		    
  
	//     }


	// }

	echo json_encode($result);
	mysqli_close($dbh);


}

?>
