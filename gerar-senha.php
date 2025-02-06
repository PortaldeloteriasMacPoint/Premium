<?php
// Caminho correto para as bibliotecas do Firestore no Composer
require_once 'vendor/google/cloud-firestore/FirestoreClient.php';

use Google\Cloud\Firestore\FirestoreClient;

// Configurar variável de ambiente para o Firestore
putenv('GOOGLE_APPLICATION_CREDENTIALS=/etc/secrets/google-credentials.json');

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Criar instância do Firestore
        $firestore = new FirestoreClient([
            'projectId' => 'mac-projeto-4e552'
        ]);

        // Coletar dados do formulário
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $plano = $_POST['plano'] ?? '';

        if (empty($nome) || empty($email) || empty($plano)) {
            $mensagem = "Preencha todos os campos!";
        } else {
            // Gerar senha aleatória
            $senha = bin2hex(random_bytes(4));
            $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
            $validade = time() + (30 * 24 * 60 * 60);
            $status = "ativo";

            // Salvar no Firestore
            $docRef = $firestore->collection('usuarios')->document($email);
            $docRef->set([
                'nome' => $nome,
                'email' => $email,
                'plano' => $plano,
                'senha' => $senhaHash,
                'validade' => $validade,
                'status' => $status
            ]);

            $mensagem = "Usuário cadastrado com sucesso! Senha: " . $senha;
        }
    } catch (Exception $e) {
        $mensagem = "Erro ao conectar ao Firestore: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Senha - Portal Premium</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        .container {
            background-color: #004d00;
            border: 2px solid #00ff00;
            padding: 20px;
            width: 50%;
            margin: auto;
            border-radius: 10px;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: none;
        }
        input {
            background-color: black;
            color: white;
            border: 1px solid #00ff00;
        }
        button {
            background-color: #00ff00;
            color: black;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #00cc00;
        }
        .mensagem {
            margin-top: 10px;
            font-weight: bold;
            color: #ff0000;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Gerar Senha de Acesso</h2>
    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="plano">Plano:</label>
        <select id="plano" name="plano" required>
            <option value="Mensal">Mensal</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Anual">Anual</option>
        </select>

        <button type="submit">Gerar Senha</button>
    </form>

    <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
</div>

</body>
</html>


