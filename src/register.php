<?php
session_start();

require_once 'User.php';
require_once 'connection.php';

if(isset($_SESSION['loggedUserId'])) {
	header("Location: index.php");
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email = strlen(trim($_POST['email'])) > 0 ? trim($_POST['email']) : null;
	$password = strlen(trim($_POST['password'])) > 0 ? trim($_POST['password']) : null;
	$retypedPassword = strlen(trim($_POST['retypedPassword'])) > 0 ? trim($_POST['retypedPassword']) : null;
	$fullName = strlen(trim($_POST['fullName'])) > 0 ? trim($_POST['fullName']) : null;
	
	$user = User::getUserByEmail($conn, $email);
	
	if($email && $password && $retypedPassword && $fullName && $password == $retypedPassword && !$user) {
		
		$newUser = new User();
		$newUser->setEmail($email);
		$newUser->setPassword($password, $retypedPassword);
		$newUser->setFullName($fullName);
		$newUser->activate();
		if($newUser->saveToDB($conn)) {
			echo 'Registration successfull<br />';
		} else {
			echo 'Error during the registration<br />';
		}
	} else {
		if(!$email) {
			echo 'Incorrect email<br />';
		}
		if(!$password) {
			echo 'Incorrect password<br />';
		}
		if(!$retypedPassword || $password != $retypedPassword) {
			echo 'Incorrect retyped password<br />';
		}
		if(!$fullName) {
			echo 'Incorrect full name<br />';
		}
		if($user) {
			echo 'User email exists<br />';
		}
	}
}
?>

<html>
	<head>
		<meta charset="utf-8" />
	</head>
	<body>
		<form method="POST">
			<fieldset>
				<label>
					Email:
					<input type="text" name="email" />
				</label>
				<br />
				<label>
					Password:
					<input type="password" name="password" />
				</label>
				<br />
				<label>
					Retyped password:
					<input type="password" name="retypedPassword" />
				</label>
				<br />
				<label>
					Full name:
					<input type="text" name="fullName" />
				</label>
				<br />
				<input type="submit" value="Register" />
			</fieldset>
		</form>
	
	</body>
</html>