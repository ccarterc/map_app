<?php
header('Content-Type: text/html; charset=utf-8');
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
			echo "error: " . $ex;
		}

		if($num_rows == 0){
			echo "That user name does not exist!";
		}else{
			$sql_get_user_id = $pdo_db->query("SELECT id FROM users WHERE username = '$user' LIMIT 1");
			$user_id_row = $sql_get_user_id->fetch(PDO::FETCH_BOTH);
			$user_id = intval($user_id_row['id']);			

			$sql_get_checkins = $pdo_db->query("SELECT * FROM check_ins WHERE user_id = '$user_id' LIMIT 50");
			$checkins_array = $sql_get_checkins->fetchAll();		

			echo json_encode($checkins_array);

			/*$i = 0;
			$jsonString = '{';
			while($checkins_row = $sql_get_checkins->fetch(PDO::FETCH_BOTH)){
				$feeling = $checkins_row->['feeling'];
				$lat = $checkins_row->['lat'];
				$long = $checkins_row->['my_long'];
				$note = $checkins_row->['note'];	

				$jsonString .= '"feeling":'.$feeling.', "my_lat":'.$lat.', "my_long":'.$long;
				$i++;
			}				
			$jsonString .= '}';
			echo json_encode($jsonString);			
			*/
		}


}else{
    header("Location: login.php");
}

?>

