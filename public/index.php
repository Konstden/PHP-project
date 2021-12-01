<?php 
try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../classes/DatabaseTable.php';
    include __DIR__ . '/../controllers/JokeController.php';

    $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');

    $jokesController = new JokeController($jokesTable, $authorsTable);

    $action = $_GET['action'] ?? 'home';
    echo $action;
    $page = $jokesController->$action();

    $title = $page['title'];
    $variables = $page['variables'];

    ob_start();
    include __DIR__ . '/../templates/' . $page['template'];
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occurred';
        $output = 'Database error: ' . $e->getMessage() . ' in '
        . $e->getFile() . ':' . $e->getLine();    
    }
    include __DIR__ . '/../templates/layout.php';