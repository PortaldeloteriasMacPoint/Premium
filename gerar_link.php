

<?php
// Função para gerar um token único
function gerarToken($email) {
    return md5($email . uniqid(rand(), true));
}

// Função para gerar o link com token e data de expiração
function gerarLink($email, $dias_validade = 30) {
    $token = gerarToken($email);
    $data_expiracao = new DateTime();
    $data_expiracao->add(new DateInterval("P$dias_validade"D)); // Adiciona 30 dias

    // Formata a data para o formato Y-m-d H:i:s
    $data_expiracao_formatada = $data_expiracao->format('Y-m-d H:i:s');

    // Gera o link de acesso
    $link = "https://seusite.com/pagina_protegida.php?token=$token&expiracao=$data_expiracao_formatada";

    // Salva o token e a data de expiração em um arquivo de texto
    file_put_contents('tokens.txt', "$token|$email|$data_expiracao_formatada\n", FILE_APPEND);

    return $link;
}

// Verifica se um e-mail foi enviado pelo formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email_usuario = trim($_POST['email']);
    if (!empty($email_usuario)) {
        $link = gerarLink($email_usuario);
        echo "Link gerado para <strong>$email_usuario</strong>:<br>";
        echo "<a href='$link'>$link</a>";
    } else {
        echo "Digite um e-mail válido!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerador de Links de Acesso</title>
</head>
<body>
    <h2>Gerar Link de Acesso</h2>
    <form method="POST">
        <label for="email">E-mail do usuário:</label>
        <input type="email" name="email" required>
        <button type="submit">Gerar Link</button>
    </form>
</body>
</html>

