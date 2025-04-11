<?php
// Cabeçalhos para permitir requisições de qualquer origem e aceitar métodos comuns
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Nome do arquivo JSON com os dados
$arquivo = 'mega_sena_resultados.json';

// Verifica se o arquivo existe e retorna o conteúdo
if (file_exists($arquivo)) {
    echo file_get_contents($arquivo);
} else {
    echo json_encode(['erro' => 'Arquivo não encontrado']);
}
?>

