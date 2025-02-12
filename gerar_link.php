<?php
header("Content-Type: text/plain");

// Caminho persistente para armazenar os links
$file_path = "/mnt/data/links.json";

// Criar o arquivo se não existir
if (!file_exists($file_path)) {
    file_put_contents($file_path, json_encode([]));
}

// Carregar os links existentes
$links = json_decode(file_get_contents($file_path), true);

// Gerar um novo token
$token = bin2hex(random_bytes(16));
$expiration = time() + (30 * 24 * 60 * 60); // Expira em 30 dias

// Criar novo link
$new_link = [
    "token" => $token,
    "expires" => $expiration
];

// Salvar o link
$links[$token] = $new_link;
file_put_contents($file_path, json_encode($links, JSON_PRETTY_PRINT));

// Exibir o link gerado
echo "https://portaldeloteriasmacpoint.github.io/Mac-Point--Premium/login.html?auth=$token";
?>


---
