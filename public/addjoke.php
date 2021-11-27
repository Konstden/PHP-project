<?php
    if (isset($_POST['joketext'])) {
        try {
            include __DIR__ . '/../includes/DatabaseConnection.php';
            include __DIR__ . '/../includes/DatabaseFunctions.php';

            insertJoke($pdo,[
                'authorId' => 1, 
                'joketext' => $_POST['joketext'],
                'jokedate' => new DateTime()
            ]);

            header('location: joke.php');
        } catch (PDOException $e) {
            $title = 'An error has occurred';
            $output = 'Database error: ' . $e->getMessage() . ' in '
            . $e->getFile() . ':' . $e->getLine();    
        }

        $output = 'SUCCESS';
    } else {
        $title = "Add a new joke";
        
        ob_start();
        include __DIR__ . '/../templates/addjoke.php';
        $output = ob_get_clean();
    }

    include __DIR__ . '/../templates/layout.php';
?>
