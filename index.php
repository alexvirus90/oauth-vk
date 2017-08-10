<?php
		session_start();
		header("Content-Type:text/html;charset='UTF-8'");
?>

<!DOCTYPE HTML>
<html>
<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<script src="jquery-3.2.1.min.js"></script>
		<link rel="stylesheet" href="css/style.css" type="text/css">
		<title>API VK</title>
</head>
<body>
		<div id="container">
				<h1>Контент сайта</h1>
				<div>
						<a href="auth.php" class="auth">АВТОРИЗАЦИЯ</a>
				</div>

				<?php
						if($_SESSION['user']) {
								$user = $_SESSION['user']->response[0];
						}
				?>
				<p>
						<?php
								echo $user->last_name;
								echo ' ';
								echo $user-> first_name;
						?>
				</p>
				<p>
						<h3>Список друзей</h3>
				</p>
				<p>
						<?php
								if($_SESSION['user']) {
										$friends = $_SESSION['friends'];

										foreach ($friends as $friend) {
                        foreach ($friend as $value) {
                            echo $value->last_name;
                            echo ' ';
                            echo $value-> first_name;
                            echo '<br>';
												}
										}
								}
						?>
				</p>
		</div>
</body>
</html>