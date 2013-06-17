<?php
  session_start();	
	$_SESSION['logged_in'] = 0;
	//echo "0Logged Out";
	session_destroy();
	header("Location: http://localhost/map_app/index.html");
?>
