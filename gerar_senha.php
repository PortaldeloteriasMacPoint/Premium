
<?php
// Configuração do Firestore
require 'vendor/autoload.php';

use Google\Cloud\Firestore\FirestoreClient;

// Configurações do Firebase
$firestore = new FirestoreClient([
    'projectId' => 'mac-projeto-4e552',
]);

// Função para gerar senha aleatória
function gerarSenha($tamanho = 10) {
    // Gera uma senha de tamanho desejado (padrão 10 caracteres)
    return bin2hex(random_bytes($tamanho / 2));
}

// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"] ?? '';
    $email = $_POST["email"] ?? '';
    $plano = $_POST["plano"] ?? '';

    if (!empty($nome) && !empty($email) && !empty($plano)) {
        // Gera a senha
        $senha = gerarSenha(); 
        // Gera o hash da senha para segurança
        $senhaHash = password_hash($senha, PASSWORD_BCRYPT); 

        // Calcula validade do plano
        $diasPlano = [
            "mensal" => 30,
            "trimestral" => 90,
            "anual" => 365
        ];
        $validade = date('Y-m-d', strtotime("+{$diasPlano[$plano]} days"));

        // Salvar no Firestore com hash da senha
        $firestore->collection('users')->document($email)->set([
            'nome' => $nome,
            'email' => $email,
            'senha' => $senhaHash, // Armazena a senha com hash
            'plano' => $plano,
            'validade' => $validade,
            'status' => 'ativo'
        ]);

        // Exibe a senha gerada na tela para o usuário copiar
        echo "Usuário cadastrado com sucesso! A senha gerada é: <strong>$senha</strong><br>";
    } else {
        echo "Erro: Preencha todos os campos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Usuários</title>
</head>
<body>
    <h2>Gerar Senha e Cadastrar Usuário</h2>
    <form action="" method="post">
        Nome: <input type="text" name="nome" required><br>
        E-mail: <input type="email" name="email" required><br>
        Plano:
        <select name="plano" required>
            <option value="mensal">Mensal</option>
            <option value="trimestral">Trimestral</option>
            <option value="anual">Anual</option>
        </select><br>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
