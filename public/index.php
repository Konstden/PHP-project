<?php



try {
    // include __DIR__ . '/../classes/EntryPoint.php';
    // include __DIR__ . '/../includes/autoload.php';
    // include __DIR__ . '/ijdbRoutes.php';
    include __DIR__ . '/../includes/autoload.php';

    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
    $entryPoint = new \Ninja\EntryPoint($route, new Ijdb\ijdbRoutes);
    $entryPoint->run();

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in '
    . $e->getFile() . ':' . $e->getLine();    
    include __DIR__ . '/../templates/layout.php';
}