<?php
    try {
        include __DIR__ . '/../includes/DatabaseConnection.php';
        include __DIR__ . '/../classes/DatabaseTable.php';

        $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new DatabaseTable($pdo, 'author', 'id');

        $result = $jokesTable->findAll();
        $jokes = [];
        echo '<br>';
        print_r($result);
        foreach($result as $joke) {
            $author = $authorsTable->findById($joke['authorid']);
            
            $jokes[] = [
                'id' => $joke['id'],
                'joketext' => $joke['joketext'],
                'jokedate' => $joke['jokedate'],
                'name' => $author['name'],
                'email' => $author['email']
            ];
        }

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