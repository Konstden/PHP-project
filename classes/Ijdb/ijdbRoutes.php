<?php
namespace Ijdb;


class ijdbRoutes {
    public function callAction($route) { 
        include __DIR__ . '/../../includes/DatabaseConnection.php';
        
        
        $jokesTable = new \Ninja\DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new \Ninja\DatabaseTable($pdo, 'author', 'id');
        
        $routes = [
            'joke/edit' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'saveEdit'
                ],
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'edit'
                ]
            ],
            'joke/delete' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'delete'
                ]
            ],
            'joke/list' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'list'
                ]
            ],
            'joke/home' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'home'
                ]
            ]
        ];
    
        $method = $_SERVER['REQUESTED_METHOD'];
        $controller = $routes[$route][$method]['controller'];
        $action = $routes[$route][$method]['action'];
        
        return $controller->$action();
        
        if ($route == 'joke/list') {
            
            $controller = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->list();
            
        } else if ($route == 'joke/home') {
            
            echo $route;
            $controller = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->home();

        } else if ($route == 'joke/delete') {
            
            $controller = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->delete();
            
        } else if ($route == 'joke/edit') {
            
            $controller = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->edit();
            
        } else if ($route == 'register') {
            $controller = new \Ijdb\Controllers\Register($jokesTable, $authorsTable);
            $page = $controller->showForm();
            
            
        }
        return $page;
    }
}