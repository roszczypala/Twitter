<?php

require_once 'connection.php';
require_once 'User.php';

$userId = isset($_GET['userId']) ? $_GET['userId'] : null;
if($userId){
    $user = new User();
    $user->loadFromDB($conn,$userId);
    var_dump($user);
}
