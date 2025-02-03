<?php
// Função para gerar senha única
function gerarSenhaUnica() {
    return substr(md5(rand()), 0, 12); // Senha de 12 caracteres gerada de forma aleatória
}

// Função para calcular a data de expiração com base no plano
function calcularDataExpiracao($plano) {
    if ($plano == "mensal") {
        return strtotime("+30 days");
    } elseif ($plano == "premium") {
        return strtotime("+90 days");
    } elseif ($plano == "anual") {
        return strtotime("+365 days");
    }
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['gerarSenha'])) {
    $email = $_POST['email'];
    $senhaGerada = gerarSenhaUnica();
    $plano = $_POST['plano']; // Pega o plano (mensal, premium, anual)
    $dataExpiracao = calcularDataExpiracao($plano);

    // Salvar a senha no arquivo "usuarios.txt"
    $usuarioInfo = $email . "|" . $senhaGerada . "|" . date("Y-m-d H:i:s", $dataExpiracao) . "|ativo\n";
    file_put_contents("usuarios.txt", $usuarioInfo, FILE_APPEND);

    // Exibe a senha gerada
    echo "Senha gerada com sucesso para o e-mail: $email<br>";
    echo "Senha: $senhaGerada<br>";
    echo "Data de expiração: " . date("Y-m-d H:i:s", $dataExpiracao) . "<br>";
}
?>

<!-- Formulário HTML para gerar a senha -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Senha Exclusiva</title>
    <style>
        body { background-color: black; color: white; font-family: Arial, sans-serif; }
        .form-container { width: 300px; margin: 100px auto; padding: 20px; background-color: #2d2d2d; border-radius: 10px; text-align: center; }
        input[type="email"], input[type="text"], select { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #333; color: white; }
        button { padding: 10px 20px; background-color: #FFA500; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #ff7f00; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Gerar Senha Exclusiva</h2>
    <form action="gerar-senha.php" method="POST">
        <input type="email" name="email" placeholder="Digite o e-mail do usuário" required><br>
        <select name="plano" required>
            <option value="mensal">Plano Mensal</option>
            <option value="premium">Plano Premium</option>
            <option value="anual">Plano Anual</option>
        </select><br>
        <button type="submit" name="gerarSenha">Gerar Senha</button>
    </form>
</div>

</body>
</html>

    
