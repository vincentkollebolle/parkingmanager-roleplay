<?php

namespace App\Utils;

use App\Utils\Response;

class Router 
{
    private $routes = [];
    
    public function get($path, $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }
    
    public function post($path, $handler)
    {
        $this->routes['POST'][$path] = $handler;
    }
    
    public function put($path, $handler)
    {
        $this->routes['PUT'][$path] = $handler;
    }
    

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptName !== '/' && strpos($requestUri, $scriptName) === 0) {
            $path = substr($requestUri, strlen($scriptName));
        } else {
            $path = $requestUri;
        }

        $path = '/' . ltrim($path, '/');
        $path = rtrim($path, '/');
        if ($path === '') {
            $path = '/';
        }

        if (!isset($this->routes[$method][$path])) {
            Response::error('Route non trouvée', 404);
            return;
        }

        $handler = $this->routes[$method][$path];

        if (is_array($handler)) {
            $controller = $handler[0];
            $method = $handler[1];
            $controller->$method();
        } elseif (is_callable($handler)) {
            $handler();
        }
    }
}