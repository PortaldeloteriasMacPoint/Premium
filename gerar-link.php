<?php
include(__DIR__ . '/config.php');

// Gerar um token único
$token = bin2hex(random_bytes(16));  // Gera um token de 32 caracteres hexadecimais

// Exemplo de usuário (aqui você pode pegar do banco ou de outro lugar)
$usuario = [
    'id' => 1,
    'nome' => 'Usuário A',
    'authToken' => $token,
    'expiracao' => date('Y-m-d\TH:i:s', strtotime('+30 days')),  // Token expira em 30 dias
    'status' => 'ativo'  // O status pode ser 'ativo' ou 'bloqueado'
];

// Carrega os usuários existentes
$usuarios = carregarUsuarios();

// Adiciona o novo usuário com o token
$usuarios[] = $usuario;

// Salva os dados novamente no arquivo JSON
salvarUsuarios($usuarios);

// Gera o link
$link = "https://portaldeloteriasmacpoint.github.io/Mac-Point--Premium/pagepremium.html /?token=$token";

// Exibe o link gerado
echo "Link gerado com sucesso: <a href='$link' target='_blank'>$link</a>";
?>

