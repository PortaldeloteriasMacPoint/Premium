

<?php
session_start();

// Verifica se o usuário está autenticado via Firebase
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['user']->email;

// Lista de e-mails autorizados (pode ser uma lista fixa ou lida de um arquivo)
$autorizados = [
    'mikeponte@gmail.com',
    'usuario@dominio.com'
];

// Verifica se o e-mail do usuário autenticado está na lista de autorizados
if (in_array($user_email, $autorizados)) {
    echo "Acesso Liberado! Você tem permissão para acessar o conteúdo.";
    // Coloque aqui o conteúdo restrito que só quem tem permissão vai acessar
} else {
    echo "Acesso Negado! Você não tem permissão para acessar este conteúdo.";
    // Pode redirecionar ou mostrar uma mensagem de erro
}
?>


