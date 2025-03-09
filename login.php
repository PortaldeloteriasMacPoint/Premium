<?php
session_start(); // Iniciar a sessão para verificar o status do login

// Definir a URL de redirecionamento em caso de login bem-sucedido
$loginRedirect = "mac.php";

// Verificar se o usuário já está logado
if (isset($_SESSION['acesso_autorizado']) && $_SESSION['acesso_autorizado'] == "true") {
    header("Location: $loginRedirect");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $senha = trim($_POST["senha"]);
    $mensagem = '';

    if ($email === "" || $senha === "") {
        $mensagem = "Preencha todos os campos!";
        $mensagemClass = "erro";
    } else {
        // URL da API Firebase para autenticação
        $firebaseAuthUrl = "https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key=AIzaSyAO3As6jMMmENtzaK9zlDADbpS9UlNxx8o";

        // Dados enviados para a API do Firebase
        $postData = json_encode([
            "email" => $email,
            "password" => $senha,
            "returnSecureToken" => true
        ]);

        // Inicializar cURL
        $ch = curl_init($firebaseAuthUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        // Executar a requisição cURL
        $response = curl_exec($ch);
        curl_close($ch);

        // Processar a resposta da API
        $decodedResponse = json_decode($response, true);

        if (isset($decodedResponse["idToken"])) {
            // Login bem-sucedido
            $_SESSION["acesso_autorizado"] = "true";
            header("Location: $loginRedirect");
            exit;
        } else {
            $mensagem = "Erro no login! Verifique os dados.";
            $mensagemClass = "erro";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 100%;
            max-width: 350px;
        }
        h2 {
            color: black;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: #fff;
            color: black;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background: #218838;
        }
        .mensagem {
            margin-top: 15px;
            padding: 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        .sucesso {
            background: lightgreen;
            color: black;
        }
        .erro {
            background: red;
            color: white;
        }
        .cadastro-link {
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }
        .cadastro-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="E-mail" required />
            <input type="password" name="senha" placeholder="Senha" required />
            <button type="submit">Entrar</button>
        </form>

        <?php if (!empty($mensagem)): ?>
            <p class="mensagem <?= $mensagemClass; ?>"><?= $mensagem; ?></p>
        <?php endif; ?>

        <p><a href="loginacesso.php" class="cadastro-link">Não tem cadastro? Cadastre-se.</a></p>
    </div>

</body>
</html>


