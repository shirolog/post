<?php 
require('./connect.php');
session_start();
session_unset();
session_destroy();

setcookie('email', '', time() -1, '/');
setcookie('pass', '', time() - 1, '/');

header('Location: ./join/login.php');
exit();

?>

