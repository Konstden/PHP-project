<?php 
try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../classes/DatabaseTable.php';
    include __DIR__ . '/../controllers/JokeController.php';

    $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');

    $jokesController = new JokeController($jokesTable, $authorsTable);

    if (isset($_GET['edit'])) {
        $page = $jokesController->edit();
    } elseif (isset($_GET['delete'])) {
        $page = $jokesController->delete();
    } elseif (isset($_GET['list'])) {
        $page = $jokesController->list();
    } else {
        $page = $jokesController->home();
    }

    $title = $page['title'];
    $output = $page['output'];
} catch (PDOException $e) {
    $title = 'An error has occurred';
        $output = 'Database error: ' . $e->getMessage() . ' in '
        . $e->getFile() . ':' . $e->getLine();    
    }
    include __DIR__ . '/../templates/layout.php';