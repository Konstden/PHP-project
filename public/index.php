<?php
function loadTemplate($templateFileName, $variables = []) {
    extract($variables);

    ob_start();
    include __DIR__ . '/../templates/' . $templateFileName;

    return ob_get_clean();
}
try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../classes/DatabaseTable.php';
    include __DIR__ . '/../controllers/JokeController.php';

    $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');

    $jokesController = new JokeController($jokesTable, $authorsTable);

    $action = $_GET['action'] ?? 'home';

    if ($action == strtolower($action)) {
        $page = $jokeController->$action();
    } else {
        http_response_code(301); 
        header('location: index.php?action=' . strtolower($action));
    }
    echo $action;
    $page = $jokesController->$action();

    $title = $page['title'];

    if (isset($page['variables'])) {
        $output = loadTemplate($page['template'], $page['variables']);
    } else {
        $output = loadTemplate($page['template']);
    }
} catch (PDOException $e) {
    $title = 'An error has occurred';
        $output = 'Database error: ' . $e->getMessage() . ' in '
        . $e->getFile() . ':' . $e->getLine();    
    }
    include __DIR__ . '/../templates/layout.php';