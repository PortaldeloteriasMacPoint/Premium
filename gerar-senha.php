

<?php
// Impedir cache no navegador
ob_start(); // Inicia o buffer de saída para evitar problemas com envio de cabeçalhos depois

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Configuração do Firebase e o restante do código
$firestoreProject = "mac-projeto-4e552";
$firestoreUrl = "https://firestore.googleapis.com/v1/projects/$firestoreProject/databases/(default)/documents/users";
$apiKey = "AIzaSyAO3As6jMMmENtzaK9zlDADbpS9UlNxx8o";

// Variáveis para armazenar as respostas e mensagens
$senhaGerada = "";
$plano = "";
$nome = "";
$email = "";
$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
        $mensagem = "Senha gerada para $email: $senhaGerada";
    } else {
        $mensagem = "Erro ao salvar no Firestore.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Senha</title>

    <!-- Estilo Neon -->
    <style>
        body {
            background-color: #000;
            font-family: 'Arial', sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #0f0;
            text-align: center;
            font-size: 36px;
            margin-top: 50px;
            text-shadow: 0 0 10px #0f0, 0 0 20px #0f0, 0 0 30px #0f0;
        }

        form {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            border: 2px solid #0f0;
            background-color: #222;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.7);
        }

        label {
            display: block;
            margin: 10px 0;
            color: #fff;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: #111;
            color: #fff;
            border: 2px solid #0f0;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #ff7f00;
            color: #000;
            cursor: pointer;
            border: none;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #ff5500;
        }

        .result {
            text-align: center;
            color: #fff;
            font-size: 18px;
        }

        .result p {
            margin: 10px 0;
        }

        .result .success {
            color: #0f0;
        }

        .result .error {
            color: #f00;
        }
    </style>
</head>
<body>

    <h2>Gerar Senha e Cadastrar no Firebase</h2>

    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="plano">Plano:</label>
        <select id="plano" name="plano" required>
            <option value="mensal">Mensal</option>
            <option value="trimestral">Trimestral</option>
            <option value="anual">Anual</option>
        </select><br><br>

        <input type="submit" value="Gerar Senha">
    </form>

    <?php if ($mensagem): ?>
        <div class="result <?php echo ($result) ? 'success' : 'error'; ?>">
            <h3><?php echo $mensagem; ?></h3>
        </div>
    <?php endif; ?>

    <?php if ($senhaGerada): ?>
        <div class="result success">
            <h4>Detalhes gerados:</h4>
            <p><strong>Senha gerada:</strong> <?php echo $senhaGerada; ?></p>
            <p><strong>Plano:</strong> <?php echo ucfirst($plano); ?></p>
            <p><strong>Validade do plano:</strong> <?php echo $validade; ?></p>
        </div>
    <?php endif; ?>

</body>
</html>

<?php
// Finalize the output buffering
ob_end_flush();
?>

