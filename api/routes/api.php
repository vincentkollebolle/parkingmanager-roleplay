<?php

use App\Utils\Router;
use App\Controller\ApiController;

function registerRoutes(Router $router) {

    $apiController = new ApiController();

    $router->get('/', [$apiController, 'home']);
    $router->get('/health', [$apiController, 'health']);
}