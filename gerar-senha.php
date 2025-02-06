

<?php
// Configuração do Firestore usando credenciais do ambiente
putenv('GOOGLE_APPLICATION_CREDENTIALS=/path/to/your/firebase_credentials.json'); // Certifique-se de que a variável de ambiente esteja configurada corretamente no Render

use Google\Cloud\Firestore\FirestoreClient;

// Dados do formulário (nome, e-mail, plano)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $plano = $_POST['plano'];

    // Gerar uma senha aleatória
    $senhaGerada = bin2hex(random_bytes(4));  // Exemplo de senha gerada

    // Criar hash da senha para segurança
    $senhaHash = password_hash($senhaGerada, PASSWORD_BCRYPT);

    // Definir validade do plano
    $validade = date('Y-m-d H:i:s', strtotime("+30 days"));
    if ($plano == 'trimestral') {
        $validade = date('Y-m-d H:i:s', strtotime("+90 days"));
    } elseif ($plano == 'anual') {
        $validade = date('Y-m-d H:i:s', strtotime("+365 days"));
    }

    // Instanciar o cliente Firestore
    $firestore = new FirestoreClient();

    // Referência à coleção de usuários no Firestore
    $usersRef = $firestore->collection('users');

    // Criar dados para salvar no Firestore
    $data = [
        'nome' => $nome,
        'email' => $email,
        'senha' => $senhaHash,
        'plano' => $plano,
        'validade' => $validade,
        'status' => 'ativo',
    ];

    // Salvar os dados no Firestore
    try {
        $usersRef->add($data);
        echo "Senha gerada para $email: $senhaGerada";
        echo "<br>Plano: $plano";
        echo "<br>Validade do plano: $validade";
    } catch (Exception $e) {
        echo "Erro ao salvar no Firestore: " . $e->getMessage();
    }
} else {
    echo "Método inválido!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Senha e Cadastrar no Firestore</title>
    <style>
        body {
            background-color: #000;
            font-family: Arial, sans-serif;
            color: white;
        }
        .form-container {
            background-color: #006400;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #00FF00;
            width: 300px;
            margin: 50px auto;
            text-align: center;
        }
        input[type="text"], input[type="email"], input[type="submit"] {
            background-color: #000;
            color: white;
            border: 1px solid #00FF00;
            padding: 10px;
            margin-bottom: 10px;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: orange;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #FF8C00;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Gerar Senha e Cadastrar no Firestore</h2>
    <form method="POST" action="">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <select name="plano" required>
            <option value="mensal">Mensal</option>
            <option value="trimestral">Trimestral</option>
            <option value="anual">Anual</option>
        </select>
        <input type="submit" value="Gerar Senha">
    </form>
</div>

</body>
</html>

