<?php
// Certifique-se de que não há espaços em branco antes deste PHP

// Carregar a chave privada do ambiente do Render
$firebaseCredentials = json_decode($_ENV['GOOGLE_APPLICATION_CREDENTIALS'], true);

// Verifica se a credencial está acessível
if (!$firebaseCredentials) {
    die("Erro: Credenciais do Firestore não foram encontradas.");
}

$projectId = 'mac-projeto-4e552';
$collection = 'users';

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebendo os dados do formulário
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $plano = $_POST['plano'] ?? 'Mensal';

    // Gerar senha aleatória (8 caracteres)
    $senha = substr(md5(uniqid(mt_rand(), true)), 0, 8);
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Definir validade do plano
    $diasPlano = $plano === 'Mensal' ? 30 : ($plano === 'Trimestral' ? 90 : 365);
    $dataExpiracao = date('Y-m-d H:i:s', strtotime("+$diasPlano days"));

    // Criar dados para salvar no Firestore
    $dadosUsuario = [
        'fields' => [
            'nome' => ['stringValue' => $nome],
            'email' => ['stringValue' => $email],
            'senha' => ['stringValue' => $senhaHash],
            'plano' => ['stringValue' => $plano],
            'validade' => ['stringValue' => $dataExpiracao],
            'status' => ['stringValue' => 'ativo']
        ]
    ];

    // URL da API do Firestore
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection";

    // Configuração do cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $firebaseCredentials['private_key']
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dadosUsuario));

    // Executa a requisição
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Verifica se deu certo
    if ($httpCode == 200 || $httpCode == 201) {
        $mensagem = "Usuário cadastrado com sucesso!<br>Senha gerada: <strong>$senha</strong>";
    } else {
        $mensagem = "Erro ao salvar no Firestore.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Senha e Cadastrar</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container {
            background-color: #003300;
            border: 2px solid #00ff00;
            padding: 20px;
            width: 300px;
            margin: auto;
            margin-top: 50px;
            border-radius: 10px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: black;
            color: white;
            border: 1px solid #00ff00;
            border-radius: 5px;
        }
        button {
            background-color: orange;
            color: black;
            padding: 10px;
            margin-top: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            border-radius: 5px;
        }
        button:hover {
            background-color: darkorange;
        }
        .mensagem {
            margin-top: 10px;
            color: #00ff00;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Gerar Senha e Cadastrar</h2>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <select name="plano">
            <option value="Mensal">Mensal</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Anual">Anual</option>
        </select>
        <button type="submit">Gerar Senha</button>
    </form>
    <?php if (!empty($mensagem)): ?>
        <div class="mensagem"><?= $mensagem ?></div>
    <?php endif; ?>
</div>

</body>
</html>


