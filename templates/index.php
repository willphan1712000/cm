<?php
$g = SystemConfig::globalVariables();
$conn = Database::connection();
SESSION_START();
if (isset($_SESSION['username'])) {
	header("Location: /stats");
} else {
	if (isset($_POST['submit'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		if ($username == '' && $password == '') {
			$msg = '<p class="alert">Username and Password are empty</p>';
		}
		else {
			if ($username == '' || $password == '')
			$msg = '<p class="alert">Username or Password is empty</p>';
			else {
				if ($username == 'Allinclicks' && $password == '123456') {
					header("Location: /stats");
					$_SESSION['username'] = $_POST['username'];
					$_SESSION['last_time_admin'] = time();
				}
				else {
					$msg = '<p class="alert">Username or Password is incorrect</p>';
				}
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$g['title'];?> Log in</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
	<div class="login_parent">
		<div class="login_container">
			<div class="login_design">
				<div class="login_design__logo">
					<img src="img/code.png" draggable="false">
					<h3><?=$g['title'];?></h3>
				</div>
			</div>
			<div class="login_box">
				<div class="header">
					<h3>ALLINCLICKS</h3>
				</div>
				<div class="msg"><?=$msg;?></div>
				<div class="login">
					<form action="" method="POST">
						<input type="text" name="username" placeholder="Username" value="<?=$username;?>">
						<input type="password" name="password" placeholder="Password">
						<button type="submit" name="submit">Log In</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>var type = "login";</script>
</body>
</html>