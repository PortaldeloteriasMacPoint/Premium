<?php
require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/seu-arquivo-chave.json'); 
$firebase = (new Factory)->withServiceAccount($serviceAccount)->createFirestore();
$firestore = $firebase->database();

// Gerar uma senha aleatória de 10 caracteres
$senha = bin2hex(random_bytes(5));
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Capturar dados do formulário
$email = $_POST['email'];
$plano = $_POST['plano']; // Mensal, Trimestral ou Anual

// Definir data de expiração
$data_atual = new DateTime();
if ($plano == "mensal") {
    $data_atual->modify('+30 days');
} elseif ($plano == "trimestral") {
    $data_atual->modify('+90 days');
} else {
    $data_atual->modify('+365 days');
}
$data_expiracao = $data_atual->format('Y-m-d');

// Salvar no Firestore
$firestore->collection('usuarios')->document($email)->set([
    'email' => $email,
    'senha' => $senha_hash,
    'expiracao' => $data_expiracao,
    'bloqueado' => false
]);

echo "Senha gerada com sucesso: $senha";
?>
