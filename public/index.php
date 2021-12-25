<?php
    

try {
    include __DIR__ . '/../includes/autoload.php';

    $route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) ?? 'joke/home';
    
    echo $route;

    $entryPoint = new \Ninja\EntryPoint($route, $_SERVER['REQUEST_METHOD'], new \Ijdb\ijdbRoutes);
    $entryPoint->run();

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in '
    . $e->getFile() . ':' . $e->getLine();    
    include __DIR__ . '/../templates/layout.php';
}