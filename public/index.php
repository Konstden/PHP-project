<?php
    $routes = [
        'joke/list' => [
            'POST' => [
                'controller' => $jokeController,
                'action' => 'saveEdit'
            ],
            'GET' => [
                'controller' => $jokeController,
                'action' => 'edit'
            ]
        ], 
        'home' => [
            'GET' => [
                'controller' => $jokeController,
                'action' => 'home'
            ]
        ]
    ];




try {
    include __DIR__ . '/../includes/autoload.php';

    // $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
    

    $route = $_GET['route'] ?? 'joke/home';
    $controller = $routes[$route][$_SERVER['REQUEST_METHOD']]['controller'];
    $action = $routes[$route][$_SERVER['REQUEST_METHOD']]['action'];
    
    $entryPoint = new \Ninja\EntryPoint($route, new \Ijdb\ijdbRoutes);
    $entryPoint->run();

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in '
    . $e->getFile() . ':' . $e->getLine();    
    include __DIR__ . '/../templates/layout.php';
}