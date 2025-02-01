<?php
require 'vendor/autoload.php';

use Firebase\Auth\Token\Exception\InvalidToken;
use Firebase\Auth\Token\Verifier;

header("Content-Type: application/json");

// Configurações do Firebase
$projeto_id = "mac-projeto-4e552"; // ID do seu projeto no Firebase
$verifier = new Verifier($projeto_id);

$json = file_get_contents("php://input");
$dados = json_decode($json, true);
$token = $dados["token"] ?? "";

if (!$token) {
    error_log("Token não fornecido.");
    echo json_encode(["autorizado" => false, "mensagem" => "Token não fornecido"]);
    exit;
}

try {
    $token_verificado = $verifier->verifyIdToken($token);
    $email = $token_verificado->claims()->get("email");

    error_log("Token recebido: " . $token);
    error_log("E-mail recebido do Firebase: " . $email);

    // Lista de e-mails autorizados no PHP
    $usuarios_autorizados = [
        "macklinger1989@gmail.com",
        "usuario2@gmail.com",
        "usuario3@gmail.com",
        "usuario4@gmail.com",
        "usuario5@gmail.com"
    ]; // Substitua pelos e-mails que podem acessar

    if (in_array($email, $usuarios_autorizados)) {
        error_log("Usuário autorizado: Sim");
        echo json_encode(["autorizado" => true]);
    } else {
        error_log("Usuário autorizado: Não");
        echo json_encode(["autorizado" => false, "mensagem" => "Usuário não autorizado"]);
    }
} catch (InvalidToken $e) {
    error_log("Token inválido: " . $e->getMessage());
    echo json_encode(["autorizado" => false, "mensagem" => "Token inválido"]);
} catch (\Exception $e) {
    error_log("Erro ao verificar token: " . $e->getMessage());
    echo json_encode(["autorizado" => false, "mensagem" => "Erro ao verificar token"]);
}
?>
