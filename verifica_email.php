<?php
header('Content-Type: application/json');

// Lista de e-mails autorizados (armazenados como hashes para maior segurança)
$emails_autorizados = [
    hash('sha256', 'Macklinger1989@gmail.com'),
    hash('sha256', 'Portaldeloteriasmacpoint@gmail.com'),
    hash('sha256', 'Janyson62@gmail.com'),
    hash('sha256', 'Goldsenioread@gmail.com'),
];

// Simulação de um e-mail do usuário autenticado (substituir pela lógica real)
session_start();
$email_usuario = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Verifica se o e-mail do usuário autenticado está na lista
$autorizado = in_array(hash('sha256', $email_usuario), $emails_autorizados);

echo json_encode(['autorizado' => $autorizado]);
exit;


