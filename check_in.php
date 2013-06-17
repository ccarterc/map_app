<?php

require_once('db.php');
//header('Cache-Control: max-age=28800');
session_start();
//session_destroy();
if($_SESSION['logged_in']==1){

  $user = $_SESSION['user'];
	//$role = $_SESSION['role']; 

	try{
		$sql_check_user = $pdo_db->query("SELECT username FROM users WHERE username = '$user' LIMIT 1");
		$num_rows = $sql_check_user->rowCount();
		//$result = $sql_check_user->fetch(PDO::FETCH_BOTH);
		//echo "num rows:".$num_rows."<br/>";
		//echo "user:".$user."<br/>";

		//echo $result;
		}catch(PDOException $ex){
			$message = "There was a strange error.  " . $ex;
			echo json_encode(array('status' => 0, 'message' => $message));
		}

		if($num_rows == 0){
			$message = "It seems you might not exist in reality... Welcome to the matrix, you have just experienced a glich.";
    		echo json_encode(array('status' =>0, 'message' => $message));
			//header("Location: index.html#page1");
		}else{			
			$feeling = addslashes(htmlentities($_POST['feeling'], ENT_QUOTES));
			$lat = (float)$_POST['my_lat'];
			$long = (float)$_POST['my_long'];
			$note = addslashes(htmlentities($_POST['note'], ENT_QUOTES));			

			$sql_get_user_id = $pdo_db->query("SELECT id FROM users WHERE username = '$user' LIMIT 1");
			$user_id_row = $sql_get_user_id->fetch(PDO::FETCH_BOTH);
			$user_id = intval($user_id_row['id']);

			try{
				$sql_update_check_in = $pdo_db->exec("INSERT INTO check_ins	(user_id, lat, my_long, feeling, note)	VALUES('$user_id', '$lat', '$long', '$feeling', '$note')");//never use long as the name of a column...
				$id = $pdo_db->lastInsertId();	

				//echo "last insert id:".$id."<br/>";
				//echo "checked in successfully"."<br/>";

				$feeling_response = $feeling . " type-" . gettype($feeling);
				$lat_response = $lat . " type-" . gettype($lat);
				$long_response = $long . " type-" . gettype($long);
				$jsonArray = array('status' => 1, 'feeling' => $feeling_response, 'my_lat' => $lat_response,'my_long' => $long_response);
				echo json_encode($jsonArray);
				//echo $jsonString;
				//echo "note:".$note.gettype($note)."<br/>";
				//echo "user id:".$user_id.gettype($user_id)."<br/>";
			}catch(PDOException $ex){
				//echo "error: ". $ex;
			}
		}		
}else{
    $message = "You arent really logged in are you...";
    echo json_encode(array('status' => 0, 'message' => $message));
    //header("Location: index.html#page1");
}

?>

