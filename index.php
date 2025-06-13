<?php

use App\SimulationRunner;

require_once 'vendor/autoload.php';

// Headers CORS pour permettre l'accès depuis toutes les origines
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');


// Gérer les requêtes preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'scenario') {

    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON input']);
        exit;
    }

    $simulator = new SimulationRunner();
    $result = $simulator->run($data);

    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route']) && $_GET['route'] === 'scenario') {

    // Charger le fichier de test automatiquement
    $data = json_decode(file_get_contents(__DIR__ . '/traffic_schedule.json'), true);

    if (!$data) {
        http_response_code(500);
        echo json_encode(['error' => 'traffic_schedule.json manquant ou invalide']);
        exit;
    }

    $simulator = new SimulationRunner();
    $result = $simulator->run($data);

    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
    exit;
}

define('RUNNING_FROM_CLI', php_sapi_name() === 'cli');

if (RUNNING_FROM_CLI) {
    $data = json_decode(file_get_contents(__DIR__ . '/traffic_schedule.json'), true);
    if (!$data) {
        fwrite(STDERR, "traffic_schedule.json manquant ou invalide\n");
        exit(1);
    }
    $simulator = new SimulationRunner();
    $result = $simulator->run($data);
    echo json_encode($result, JSON_PRETTY_PRINT) . "\n";
    exit(0);
}