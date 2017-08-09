<?php

session_start();

header("Content-Type:text/html;charset='UTF-8'");

?>

<!DOCTYPE HTML>

<html>

    <head>

		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

		<link rel="stylesheet" href="css/style.css" type="text/css">

		

		<title>Тестовый сайт</title>				

	</head>

	<body>

		<div id="container">

		<h2>Контент сайта</h2>

		<p>
			<strong><a href="auth.php">Авторизация</a></strong>

		</p>
		<?
		if($_SESSION['user']) {
			$user = $_SESSION['user']->response[0];
			//print_r($user);
		}
		?>
		<p><?php echo $user->first_name;?></p>
		<p><?php echo $user->last_name;?></p>
		</div>

	</body>

</html><?php



?>