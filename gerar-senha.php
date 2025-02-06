<?php
// Configuração do caminho das credenciais no ambiente Render
putenv('GOOGLE_APPLICATION_CREDENTIALS=/etc/secrets/google-credentials.json');

// Importação manual das classes necessárias
require_once 'google-cloud-php/Firestore/src/FirestoreClient.php';
require_once 'google-cloud-php/Core/src/ExponentialBackoff.php';
require_once 'google-cloud-php/Core/src/ArrayTrait.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"] ?? '';
    $email = $_POST["email"] ?? '';
    $plano = $_POST["plano"] ?? 'Mensal';

    if (empty($nome) || empty($email)) {
        echo "Erro: Nome e e-mail são obrigatórios.";
        exit;
    }

    // Geração da senha aleatória
    $senhaGerada = substr(md5(uniqid(mt_rand(), true)), 0, 8);
    $senhaHash = password_hash($senhaGerada, PASSWORD_DEFAULT);

    // Definir a validade do plano
    $diasPlano = ["Mensal" => 30, "Trimestral" => 90, "Anual" => 365];
    $validade = new DateTime();
    $validade->modify("+{$diasPlano[$plano]} days");
    $validadeFormatada = $validade->format('Y-m-d H:i:s');

    try {
        // Inicializa o Firestore sem o autoload do Composer
        $firestore = new Google\Cloud\Firestore\FirestoreClient([
            'projectId' => 'mac-projeto-4e552',
        ]);

        // Criar documento no Firestore
        $docRef = $firestore->collection('users')->document($email);
        $docRef->set([
            'nome' => $nome,
            'email' => $email,
            'senha' => $senhaHash,
            'plano' => $plano,
            'validade' => $validadeFormatada,
            'status' => 'ativo'
        ]);

        $mensagem = "Usuário cadastrado com sucesso!\n";
        $mensagem .= "Senha gerada: $senhaGerada\n";
        $mensagem .= "Plano: $plano\n";
        $mensagem .= "Validade: $validadeFormatada";
    } catch (Exception $e) {
        $mensagem = "Erro ao salvar no Firestore: " . $e->getMessage();
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
            background-color: #004d00;
            border: 2px solid #00ff00;
            width: 50%;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }
        input, select {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            background-color: black;
            color: white;
            border: 1px solid #00ff00;
            border-radius: 5px;
        }
        button {
            background-color: orange;
            color: black;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #ff9900;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Gerar Senha e Cadastrar no Firestore</h2>
        <form method="POST">
            <label>Nome:</label>
            <input type="text" name="nome" required>
            
            <label>E-mail:</label>
            <input type="email" name="email" required>
            
            <label>Plano:</label>
            <select name="plano">
                <option value="Mensal">Mensal</option>
                <option value="Trimestral">Trimestral</option>
                <option value="Anual">Anual</option>
            </select>
            
            <button type="submit">Gerar Senha</button>
        </form>
        <?php if (isset($mensagem)) echo "<p>$mensagem</p>"; ?>
    </div>
</body>
</html>


