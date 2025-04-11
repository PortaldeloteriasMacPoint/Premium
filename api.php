<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$arquivo = 'mega_sena_resultados.json';
if (file_exists($arquivo)) {
    echo file_get_contents($arquivo);
} else {
    echo json_encode(['erro' => 'Arquivo não encontrado']);
}
?>

