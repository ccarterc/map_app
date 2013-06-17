<?php
//error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION['logged_in'] == 1){  
	header("Location: index.php");
}
?>

<html>
<head>
	<title>Colby App Time</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<style>
		#login_box_div{
			display:block;
			width:200px;
			margin-left:auto;
			margin-right:auto;
			text-align:right;
			margin-top:10px;
		}

	</style>
	<link href="jquery.mobile-1.3.1.min.css" type="text/css" rel="stylesheet">
	<script type="application/javascript" src="jquery-1.9.1.min.js"></script>
	<script type="application/javascript" src="jquery.mobile-1.3.1.min.js"></script>
	<script>
	$(document).ready(function(){
		$('login_form').submit(function(){
			event.preventDefault();
			$.ajax({
				type: 'post',
				url: 'check_login.php',
				data: 'json',
				success: function(data){
					if(data){
						$('#error_message').text("It didn't work.");												
					}					
				}
			});
			return false;
		});
	});
	</script>
</head>
<body>
	<div id="login_box_div">
		Welcome to Map_App V .02 Alpha by Colby<br/><br/>
		<form action="login.php" method="post" name="login_form" id="login_form">
			User:<input type="text" name="user" /><br/>
			Password:<input type="password" name="pass" /><br/>			
			<input type="submit" value="Submit">					
		</form>	
		<div id="error_message"></div>
		<a href="register.php">Register!</a>
	</div>
</body>
</html>

