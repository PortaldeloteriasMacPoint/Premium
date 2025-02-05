

<?php
// Carregar as dependências
require 'vendor/autoload.php'; // Essa linha carrega todas as dependências do Composer

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

// Obter as credenciais do Firebase armazenadas como variável de ambiente no Render
$firebaseCredentials = getenv('FIREBASE_CREDENTIALS_JSON'); // Variável de ambiente

if ($firebaseCredentials === false) {
    die('As credenciais do Firebase não estão configuradas corretamente.');
}

// Converta o conteúdo da variável de ambiente de volta para um formato JSON
$serviceAccount = ServiceAccount::fromJson($firebaseCredentials);

// Conectando ao Firebase
$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->createDatabase();

// Função para gerar a senha com hash
function gerarSenha($length = 12) {
    return bin2hex(random_bytes($length));
}

// Dados do formulário (ajuste conforme seu formulário)
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$plano = $_POST['plano'] ?? '';
$validade_plano = $_POST['validade_plano'] ?? '';

// Gerar a senha
$senha = gerarSenha();

// Hash da senha
$senha_hash = password_hash($senha, PASSWORD_BCRYPT);

// Salvar no Firestore
$firestore = $firebase->createFirestore();
$document = $firestore->collection('users')->document($email);
$document->set([
    'nome' => $nome,
    'email' => $email,
    'senha' => $senha_hash,
    'plano' => $plano,
    'validade_plano' => $validade_plano,
    'status' => 'ativo'
]);

// Retornar a senha gerada
echo "Senha gerada: " . $senha;
?>

 
