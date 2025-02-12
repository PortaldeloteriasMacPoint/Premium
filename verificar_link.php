<?php
$file_path = "/mnt/data/links.json";
$token = $_GET['auth'] ?? '';

if (!$token || !file_exists($file_path)) {
    header("Location: bloqueado.html");
    exit();
}

// Carregar os links armazenados
$links = json_decode(file_get_contents($file_path), true);

// Validar token e tempo de expiração
if (!isset($links[$token]) || $links[$token]['expires'] < time()) {
    header("Location: bloqueado.html");
    exit();
}

// Se o token for válido, continuar para a página protegida
echo "Acesso permitido!";
?>

