<?php
require 'vendor/autoload.php';

use Google\Cloud\Firestore\FirestoreClient;

// Configura a chave do Firebase
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . ($_ENV['GOOGLE_APPLICATION_CREDENTIALS'] ?? '/caminho/para/seu/json.json'));

$firestore = new FirestoreClient();

function gerarSenha($tamanho = 12) {
    return bin2hex(random_bytes($tamanho / 2));
}

$mensagem = "";
$senhaGerada = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? null;
    $email = $_POST['email'] ?? null;
    $plano = $_POST['plano'] ?? null;

    $validadeDias = match ($plano) {
        'mensal' => 30,
        'trimestral' => 90,
        'anual' => 365,
        default => null
    };

    if ($nome && $email && $plano && $validadeDias) {
        $senha = gerarSenha();
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $dataExpiracao = date('Y-m-d', strtotime("+$validadeDias days"));

        $dadosUsuario = [
            'nome' => $nome,
            'email' => $email,
            'senha' => $senhaHash,
            'plano' => $plano,
            'validade' => $validadeDias,
            'dataExpiracao' => $dataExpiracao,
            'status' => 'ativo',
        ];

        try {
            $firestore->collection('users')->document($email)->set($dadosUsuario);
            $mensagem = "Usuário registrado com sucesso!";
            $senhaGerada = $senha;
        } catch (Exception $e) {
            $mensagem = "Erro ao salvar no Firestore: " . $e->getMessage();
        }
    } else {
        $mensagem = "Preencha todos os campos corretamente!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Senha</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .container {
            width: 300px;
            margin: auto;
            background: #006400;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #00ff00;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }
        button {
            background: #00ff00;
            border: none;
            cursor: pointer;
        }
        .mensagem {
            margin-top: 10px;
            color: yellow;
        }
    </style>
</head>
<body>

    <h1>Gerar Senha para Usuário</h1>
    <div class="container">
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome do Usuário" required>
            <input type="email" name="email" placeholder="E-mail do Usuário" required>
            <select name="plano" required>
                <option value="">Selecione um Plano</option>
                <option value="mensal">Mensal (30 dias)</option>
                <option value="trimestral">Trimestral (90 dias)</option>
                <option value="anual">Anual (365 dias)</option>
            </select>
            <button type="submit">Gerar Senha</button>
        </form>

        <?php if ($mensagem): ?>
            <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
        <?php endif; ?>

        <?php if ($senhaGerada): ?>
            <p class="mensagem">Senha gerada: <strong><?= htmlspecialchars($senhaGerada) ?></strong></p>
        <?php endif; ?>
    </div>

</body>
</html>


