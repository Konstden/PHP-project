<?php
    $pdo = new PDO('mysql:host=localhost; dbname=ijdb', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>