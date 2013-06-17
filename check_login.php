<?php
error_reporting(E_ERROR | E_PARSE);
session_destroy();
session_start();

//if($_SESSION['logged_in'] == 1){  
//	echo "1You are already logged in!";
	//header("Location: index.php/#page2");
//}else{
	if(isset($_POST['user']) && isset($_POST['pass'])){		
		require_once('db.php');	
	
		$user = $_POST['user'];	

		try{
			$sql_check_user = $pdo_db->query ("SELECT username FROM users WHERE LOWER( username ) = LOWER( '$user' ) LIMIT 1");
			$num_rows = $sql_check_user->rowCount();
			$result = $sql_check_user->fetch(PDO::FETCH_BOTH);
		
		}catch(PDOException $ex){
			echo "0error: " . $ex;
		}

		if($num_rows != 1){
			echo "0User doesn't exist.";
		}else{
			$sql_get_user = $pdo_db->query ("SELECT * FROM users WHERE LOWER( username ) = LOWER( '$user' ) LIMIT 1");	
			$user_data = $sql_get_user->fetch(PDO::FETCH_BOTH);
			$provided_pass = $_POST['pass'];
			$hashed_pass = $user_data['password'];

			if(crypt($provided_pass, $hashed_pass) == $hashed_pass){
				$_SESSION['logged_in'] = 1;
				$_SESSION['user'] = $user;
				echo "1It logged you in";
				//header("Location: index.php/#page2");
			}else{
				echo "0Username or Password does not match.";			
			}	
		}
	}else{
		echo "0It did not even check your username or password";
	}
//}
?>
