

<?php
// Impedir cache no navegador
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

        <button type="submit">Gerar Senha</button>
    </form>

    <?php if ($mensagem): ?>
        <h3><?php echo $mensagem; ?></h3>
    <?php endif; ?>

    <?php if ($senhaGerada): ?>
        <h4>Detalhes gerados:</h4>
        <p><strong>Senha gerada:</strong> <?php echo $senhaGerada; ?></p>
        <p><strong>Plano:</strong> <?php echo ucfirst($plano); ?></p>
        <p><strong>Validade do plano:</strong> <?php echo $validade; ?></p>
    <?php endif; ?>
</body>
</html>

