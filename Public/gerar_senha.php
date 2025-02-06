<?php
// Configuração do Firebase
$firestoreProject = "mac-projeto-4e552";
$firestoreUrl = "https://firestore.googleapis.com/v1/projects/$firestoreProject/databases/(default)/documents/users";
$apiKey = "AIzaSyAO3As6jMMmENtzaK9zlDADbpS9UlNxx8o";

// Dados do usuário (enviados pelo formulário)
$email = $_POST['email'];
$nome = $_POST['nome'];
$plano = $_POST['plano'];

// Gerar uma senha aleatória
$senhaGerada = bin2hex(random_bytes(4));  // Exemplo: "a1b2c3d4"

// Criar hash da senha
$senhaHash = password_hash($senhaGerada, PASSWORD_BCRYPT);

// Definir validade do plano
$validade = date('Y-m-d H:i:s', strtotime("+30 days"));
if ($plano == 'trimestral') $validade = date('Y-m-d H:i:s', strtotime("+90 days"));
if ($plano == 'anual') $validade = date('Y-m-d H:i:s', strtotime("+365 days"));

// Criar JSON com os dados do usuário
$data = [
    "fields" => [
        "nome" => ["stringValue" => $nome],
        "email" => ["stringValue" => $email],
        "senha" => ["stringValue" => $senhaHash],
        "plano" => ["stringValue" => $plano],
        "validade" => ["stringValue" => $validade],
        "status" => ["stringValue" => "ativo"]
    ]
];

// Enviar para o Firestore via API REST
$options = [
    "http" => [
        "header"  => "Content-Type: application/json",
        "method"  => "POST",
        "content" => json_encode($data)
    ]
];

$context  = stream_context_create($options);
$result = file_get_contents("$firestoreUrl?key=$apiKey", false, $context);

if ($result) {
    echo "Senha gerada para $email: $senhaGerada";
} else {
    echo "Erro ao salvar no Firestore.";
}
?>
