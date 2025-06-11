<?php

namespace App\Controller;

use App\Utils\Response;


class ApiController 
{
    public function home()
    {
        $data = [
            'name' => 'Parking Manager API',
            'version' => '1.0.0',
            'status' => 'active',
            'timestamp' => date('Y-m-d H:i:s'),
            'endpoints' => [
                'GET /' => 'Informations sur l\'API',
            ]
        ];
        
        Response::success($data, 'API Parking Manager opérationnelle');
    }

    public function health()
    {
        $data = [
            'status' => 'healthy',
            'timestamp' => date('Y-m-d H:i:s'),
            'memory_usage' => memory_get_usage(true),
            'php_version' => PHP_VERSION,
            'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'
        ];
        
        Response::success($data, 'Service en ligne');
    }
}
