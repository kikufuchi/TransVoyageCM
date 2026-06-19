<?php

class Router
{

    private $routes = [];

    public function addRouter($action, $controleur, $method)
    {
        $this->routes[$action] = [
            'controleur' => $controleur,
            'method' => $method
        ];
    }

    public function execRoute($action, $id = null)
    {
        if (isset($this->routes[$action])) {

            $route = $this->routes[$action];
            $file = 'Controllers/' . $route['controleur'] . '.php';
            if (file_exists($file)) {
                require_once $file;
                $controleurClass = new $route['controleur']();
                $methodClass = $route['method'];

                if ($id) {
                    var_dump($id);
                    $controleurClass->$methodClass($id);
                } else {
                    $controleurClass->$methodClass();
                }
            }
        } else {
            require_once 'Views/Error.php';
        }
    }
}
