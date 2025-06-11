<?php

require_once __DIR__ . '/../routes/api.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Utils\Router;
use App\Utils\Response;
 
Response::cors();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$router = new Router();
registerRoutes($router);

try {
    $router->dispatch();
} catch (Exception $e) {
    Response::error('Erreur interne du serveur', 500, [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}