<?php
include(__DIR__ . '/config.php');

// Gera um token exclusivo
$token = bin2hex(random_bytes(16)); // Gera um token aleatório
$validade = 30; // Duração em dias

// URL da página premium
$url_pagina_premium = "https://portaldeloteriasmacpoint.github.io/Mac-Point--Premium/pagepremium.html";

// Carrega links existentes
$links = carregarLinks();

// Adiciona o novo link com validade
$links[] = [
    'token' => $token,
    'data_expiracao' => date('Y-m-d H:i:s', strtotime("+$validade days")),
];

// Salva os links
salvarLinks($links);

// Gera o link completo para envio
$link_exclusivo = "http://seu-servidor/validar-link.php?token=$token";

// Exibe o link gerado
echo "Link gerado com sucesso: <a href='$link_exclusivo'>$link_exclusivo</a>";
echo "<br>Acesse a página premium: <a href='$url_pagina_premium'>$url_pagina_premium</a>";
?>

