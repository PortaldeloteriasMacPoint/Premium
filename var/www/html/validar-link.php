<?php
include(__DIR__ . '/config.php');

// Verifica se o token foi passado
if (!isset($_GET['token'])) {
    die("Token não fornecido. Acesso negado.");
}

// Carrega os links existentes
$links = carregarLinks();
$token = $_GET['token'];
$link_encontrado = false;

// Verifica se o link é válido
foreach ($links as $link) {
    if ($link['token'] === $token) {
        // Verifica a data de expiração
        if (strtotime($link['data_expiracao']) > time()) {
            $link_encontrado = true;
            // Acesso permitido
            echo "Acesso autorizado. Bem-vindo à página protegida!";
            // Aqui você pode incluir o conteúdo da sua página (ex: pageprem.html)
            include('pageprem.html');
            break;
        } else {
            die("O link expirou. Acesso negado.");
        }
    }
}

if (!$link_encontrado) {
    die("Link inválido. Acesso negado.");
}
?>


