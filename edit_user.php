<!DOCTYPE html>
<?php
session_start();
require_once './src/User.php';
require_once './src/Tweet.php';
require_once './src/connection.php';

if (!isset($_SESSION['loggedUserId'])) {
    header("Location: login.php");
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method="POST">
            New name:
            <input type="text" name="new_full_name">
            <button type="submit" name="submit" value="new_user_info">Edit</button>                
        </form>
        <br><hr>
        <form method="POST">
            New password:
            <input type="password" name="new_password"><br>
            Repead password:
            <input type="password" name="new_password_repeated">  
            <button type="submit" name="submit" value="new_password">Edit</button>
        </form>
        <br>
        <form method="POST">
            Delete user:
            <button type="submit" name="submit" value="delete_user">Delete</button>
        </form>

        <?php
        $oldUser = new User();
        $oldUser->loadFromDB($conn, $_SESSION['loggedUserId']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            switch ($_POST['submit']) {
                case 'new_user_info':
                    $oldUser->setFullName($_POST['new_full_name']);
                    echo "you've changed yor full name to: " . $_POST['new_full_name'];
                    $oldUser->saveToDB($conn);
                    break;

                case 'new_password':
                    $oldUser->setPassword($_POST['new_password'], $_POST['new_password_repeated']);
                    echo "you've set new password";
                    $oldUser->saveToDB($conn);
                    break;

                case 'delete_user':
                    $oldUser->deleteUser($conn);
                    echo "user deleted";
                    $oldUser->saveToDB($conn);
                    break;
            }
        }
        ?>
        <a href='index.php'>Main page </a>
    </body>
</html>

