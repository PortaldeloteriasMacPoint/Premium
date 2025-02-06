

<?php
// Definir cabeçalhos para evitar cache
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Carregar a chave privada do ambiente do Render
$googleCredentialsPath = getenv("GOOGLE_APPLICATION_CREDENTIALS");
if (!$googleCredentialsPath || !file_exists($googleCredentialsPath)) {
    die("Erro: Credenciais do Firestore não encontradas.");
}

$credentials = json_decode(file_get_contents($googleCredentialsPath), true);
$firestoreProject = $credentials['project_id'];

// API Firestore
$firestoreUrl = "https://firestore.googleapis.com/v1/projects/$firestoreProject/databases/(default)/documents/users";

// Verifica se os dados foram enviados pelo formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $plano = $_POST['plano'] ?? 'mensal';

    // Verifica se os campos estão preenchidos
    if (empty($nome) || empty($email)) {
        $mensagem = "Erro: Todos os campos são obrigatórios.";
    } else {
        // Gerar uma senha aleatória
        $senhaGerada = bin2hex(random_bytes(4));

        // Criar hash da senha
        $senhaHash = password_hash($senhaGerada, PASSWORD_BCRYPT);

        // Definir validade do plano
        $validade = date('Y-m-d H:i:s', strtotime("+30 days"));
        if ($plano == 'trimestral') $validade = date('Y-m-d H:i:s', strtotime("+90 days"));
        if ($plano == 'anual') $validade = date('Y-m-d H:i:s', strtotime("+365 days"));

        // Criar JSON para Firestore
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

        // Enviar para Firestore via API REST
        $options = [
            "http" => [
                "header"  => "Content-Type: application/json",
                "method"  => "POST",
                "content" => json_encode($data)
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($firestoreUrl, false, $context);

        if ($result) {
            $mensagem = "Usuário cadastrado com sucesso!<br>Senha gerada: <strong>$senhaGerada</strong>";
        } else {
            $mensagem = "Erro ao salvar no Firestore.";
        }
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
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container {
            background-color: #004d00;
            padding: 20px;
            width: 40%;
            margin: auto;
            border-radius: 10px;
            border: 2px solid #00ff00;
            margin-top: 50px;
        }
        input, select {
            background-color: black;
            color: white;
            border: 1px solid #00ff00;
            padding: 10px;
            width: 80%;
            margin: 10px 0;
            border-radius: 5px;
        }
        button {
            background-color: orange;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: darkorange;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Gerar Senha e Cadastrar no Firestore</h2>
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome" required><br>
            <input type="email" name="email" placeholder="E-mail" required><br>
            <select name="plano">
                <option value="mensal">Mensal</option>
                <option value="trimestral">Trimestral</option>
                <option value="anual">Anual</option>
            </select><br>
            <button type="submit">Gerar Senha</button>
        </form>
        <p><?= $mensagem ?? '' ?></p>
    </div>

</body>
</html>


