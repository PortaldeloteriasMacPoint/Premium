<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/' && $requestMethod === 'GET') {
    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Back-end funcionando corretamente!']);
    exit;
}

if ($requestUri === '/api/rota' && $requestMethod === 'GET') {
    echo json_encode(['status' => 'sucesso', 'dados' => 'Esta é uma resposta do endpoint /api/rota']);
    exit;
}

http_response_code(404);
echo json_encode(['status' => 'erro', 'mensagem' => 'Rota não encontrada']);
?>

