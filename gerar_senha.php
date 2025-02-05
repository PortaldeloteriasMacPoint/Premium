<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Senha - Portal Premium</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .container {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            text-align: left;
        }
        label, input, select, button {
            display: block;
            margin-bottom: 10px;
            width: 100%;
        }
        input, select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #333;
            background: #333;
            color: white;
        }
        button {
            background: green;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: darkgreen;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Gerar Senha para Usuário</h2>
    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="plano">Plano:</label>
        <select id="plano" name="plano" required>
            <option value="mensal">Mensal</option>
            <option value="trimestral">Trimestral</option>
            <option value="anual">Anual</option>
        </select>

        <button type="submit" name="gerar">Gerar Senha</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gerar'])) {
        require __DIR__ . '/vendor/autoload.php';

        use Kreait\Firebase\Factory;
        use Kreait\Firebase\ServiceAccount;

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/seu-arquivo-chave.json'); 
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->createFirestore();
        $firestore = $firebase->database();

        // Gerar senha aleatória
        $senha = bin2hex(random_bytes(5));
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Capturar dados do formulário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $plano = $_POST['plano'];

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
            'nome' => $nome,
            'email' => $email,
            'senha' => $senha_hash,
            'expiracao' => $data_expiracao,
            'bloqueado' => false
        ]);

        echo "<p><strong>Senha gerada:</strong> $senha</p>";
    }
    ?>
</div>

</body>
</html>


