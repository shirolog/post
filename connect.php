<?php

try {
    $dbname = 'mysql:host=localhost;dbname=mini_bbs';
    $user_name = 'root';
    $password = '';

    $conn = new PDO($dbname, $user_name, $password);

} catch (PDOException $e) {
    echo 'Connection failed! ' . $e->getMessage();
}
?>
