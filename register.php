<?php
session_start();
require_once 'src/User.php';
require_once 'src/connection.php';
if(isset($_SESSION['loggedUserId'])) {
	header("Location: index.php");
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //czyszczenie z htmlentities, albo raczej próba :)
    
	$email = strlen(trim($_POST['email'])) > 0 ? trim(htmlspecialchars($_POST['email'])) : null;
	$password = strlen(trim($_POST['password'])) > 0 ? htmlspecialchars($_POST['password']) : null;
	$retypedPassword = strlen(trim($_POST['retypedPassword'])) > 0 ? htmlspecialchars($_POST['retypedPassword']) : null;
	$fullName = strlen(trim($_POST['fullName'])) > 0 ? trim(htmlspecialchars($_POST['fullName'])) : null;
	
	$user = User::getUserByEmail($conn, $email);
	//dodałam validację maila
	if(filter_var($email, FILTER_VALIDATE_EMAIL) && $password && $retypedPassword && $fullName && $password == $retypedPassword && !$user) {
		
		$newUser = new User();
		$newUser->setEmail($email);
		$newUser->setPassword($password, $retypedPassword);
		$newUser->setFullName($fullName);
		$newUser->activate();
		if($newUser->saveToDB($conn)) {
			echo 'Registration successfull<br />';
                        header("Location: index.php");
		} else {
			echo 'Error during the registration<br />';
		}
	} else {
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
        <title></title>
        <meta charset="utf-8" />
    </head>
    <body>
        <form method="POST" action="#">
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