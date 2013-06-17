<?php
//error_reporting(E_ERROR | E_PARSE);
require_once('db.php');

if(isset($_POST['user']) && isset($_POST['pass'])){  	
	if($_POST['user'] == "" || $_POST['user'] == null || $_POST['pass'] == "" || $_POST['pass'] == null){
		$message = "Cmon, you gotta try harder than that. :)";
		echo json_encode(array('status' => 0, 'message' => $message));
		exit();
	}
	
	$user = $_POST['user'];

	$sql_check_user = $pdo_db->prepare("SELECT username FROM users WHERE username = :user LIMIT 1");		
	$sql_check_user->bindParam(':user', $user);
	$sql_check_user->execute();	
	$num_rows = $sql_check_user->rowCount();	

	if($num_rows == 0){	
		$pass = $_POST['pass'];	
		$hashed_pw = better_crypt($pass);


		$sql_create_user = $pdo_db->prepare("INSERT INTO users (username, password) VALUES(:user, :hashed_pw)");
		$sql_create_user->bindParam(':user', $user);
		$sql_create_user->bindParam(':hashed_pw', $hashed_pw);
		$sql_create_user->execute();
		//header("Location: login.php");
		$message = 'Successful Registration';
		echo json_encode(array('status' => 1, 'message' => $message));		
	}else{
		$message = 'Doh!  User already exists!';
		echo json_encode(array('status' => 0, 'message' => $message));
		exit();
	}		
}else{
	$message = 'Enter info to register';
	echo json_encode(array('status' => 0, 'message' => $message));
}

function better_crypt($input)
  {
  	$rounds = 12;
    $salt = "";
    $salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
    for($i=0; $i < 22; $i++) {
      $salt .= $salt_chars[array_rand($salt_chars)];
    }
    return crypt($input, sprintf('$2y$%02d$', $rounds) . $salt);
}
?>
