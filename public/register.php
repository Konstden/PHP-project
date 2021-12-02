<?php
try {
    $controllerName = $_GET['controller'] ?? 'joke';
    
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../classes/DatabaseTable.php';
    
    $jokesTable = new DatabaseTable($pdo, 'jokes', 'id');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');
    
    $action = $_GET['action'] ?? 'home';
    
    
    if ($action == strlower($action) && 
    $controllerName == strlower($controllerName)) {
        $className = ucfirst($controllerName) . 'Controller';
        
        include __DIR__ . '/../controllers/' . $className . '.php';
        
        $controller = new $className($jokesTable, $authorsTable);
        $page = $controller->$action();
    } else {
        http_response_code(301); 
        header('location: index.php?controller=' .
        strtolower($controllerName)) . '&action=' . 
        strtolower($action));
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
}