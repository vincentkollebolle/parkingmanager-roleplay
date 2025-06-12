<?php
require_once 'src/SimulationRunner.php';

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
