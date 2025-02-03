

<?php
// Função para gerar senha aleatória
function gerarSenha($tamanho = 10) {
    return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $tamanho);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $plano = $_POST["plano"];
    $senha = gerarSenha(); // Gera senha automática
    $dataExpiracao = date("Y-m-d", strtotime("+30 days")); // Expira em 30 dias
    $status = "ativo"; // Status inicial

    // Salva no arquivo usuarios.txt
    $dados = "$email|$senha|$dataExpiracao|$status\n";
    file_put_contents("usuarios.txt", $dados, FILE_APPEND);

    echo "<p style='color:green; font-weight:bold;'>Usuário cadastrado com sucesso!</p>";
    echo "<p><b>Nome:</b> $nome</p>";
    echo "<p><b>E-mail:</b> $email</p>";
    echo "<p><b>Plano:</b> $plano</p>";
    echo "<p><b>Senha Gerada:</b> <span style='color:red;'>$senha</span></p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Senha</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #000; color: #fff; text-align: center; }
        .container { width: 300px; margin: auto; background: #222; padding: 20px; border-radius: 10px; }
        input, select { width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 5px; background: #333; color: white; }
        button { background: orange; border: none; padding: 10px; border-radius: 5px; cursor: pointer; }
        button:hover { background: darkorange; }
    </style>
</head>
<body>

<div class="container">
    <h2>Gerar Senha</h2>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <select name="plano" required>
            <option value="mensal">Mensal</option>
            <option value="premium">Premium</option>
            <option value="anual">Anual</option>
        </select>
        <button type="submit">Gerar Senha</button>
    </form>
</div>

</body>
</html>


