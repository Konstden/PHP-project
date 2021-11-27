<?php
    try {
        include __DIR__ . '/../includes/DatabaseConnection.php';
        include __DIR__ . '/../includes/DatabaseFunctions.php';

        $result = delete($pdo, 'joke', 'id',  $_POST['id']); 

        header('location: joke.php');
    } catch (PDOException $e) {
        $title = 'An error has occurred';
        $output = "Database error: " .  $e->getMessage() . ' in ' .
        $e->getFile() . ':' . $e->getLine();
    }
    include __DIR__ . '/../templates/layout.php';

?>