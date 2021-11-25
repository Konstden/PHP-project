<?php
    try {
        include __DIR__ . '/../includes/DatabaseConnection.php';
        include __DIR__ . '/../includes/DatabaseFunctions.php'; 
        
        $sql = 'SELECT `joke`.`id`, `joketext`, `jokedate`, `name`, `email`
        FROM `joke` INNER JOIN `author`
        ON `authorid` = `author`.`id`';

        $jokes = $pdo->query($sql); 
        $title = 'Joke List';

        $totaljokes = totalJokes($pdo);
        
        ob_start();
        include __DIR__ . '/../templates/joke.php';
        $output = ob_get_clean();
        
        
    } catch (PDOException $e) {
        $title = 'An error has occurred';
        $output = "Database error: " .  $e->getMessage() . ' in ' .
        $e->getFile() . ':' . $e->getLine();
        
    }

    include __DIR__ . "/../templates/layout.php";

?>