<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Firebase API Key
    $apiKey = "AIzaSyAO3As6..."; // Substitua pela sua API Key do Firebase

    // Dados para o Firebase
    $data = json_encode([
        "email" => $email,
        "password" => $senha,
        "returnSecureToken" => true
    ]);

    $url = "https://identitytoolkit.googleapis.com/v1/accounts:signUp?key=$apiKey";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result["idToken"])) {
        echo "<script>alert('Conta criada com sucesso!'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Erro: " . $result["error"]["message"] . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <h2>Cadastro</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Cadastrar</button>
    </form>
    <p><a href="login.php">Já tem uma conta? Faça login</a></p>
</body>
</html>


