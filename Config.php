<?php
// Caminho do arquivo de usuários (dados)
define('USUARIOS_FILE', 'data/usuarios.json');

// Função para carregar os dados dos usuários
function carregarUsuarios() {
    return json_decode(file_get_contents(USUARIOS_FILE), true);
}

// Função para salvar os dados dos usuários
function salvarUsuarios($usuarios) {
    file_put_contents(USUARIOS_FILE, json_encode($usuarios, JSON_PRETTY_PRINT));
}
?>

