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

    $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');

    $route = $_GET['route'] ?? 'joke/home';

    if ($route = strtolower($route)) {
        if ($route == 'joke/list') {
            include __DIR__ . '/../controllers/JokeController.php';
            $controller = new JokeController($jokesTable, $authorsTable);
            $page = $controller->list();
        
        } else if ($route == 'joke/home') {
            include __DIR__ . '/../controllers/JokeController.php';
            $controller = new JokeController($jokesTable, $authorsTable);
            $page = $controller->home();

        } else if ($route == 'joke/delete') {
            include __DIR__ . '/../controllers/JokeController.php';
            $controller = new JokeController($jokesTable, $authorsTable);
            $page = $controller->delete();
            
        } else if ($route == 'joke/edit') {
            include __DIR__ . '/../controllers/JokeController.php';
            $controller = new JokeController($jokesTable, $authorsTable);
            $page = $controller->edit();

        } else if ($route == 'register') {
            $controller = new RegisterController($jokesTable, $authorsTable);
            $page = $controller->showForm();
            include __DIR__ . '/../controllers/RegisterController.php';
        
        }
    } else {
        http_response_code(301);
        header('location: index.php?' . strtolower($route));
    }
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