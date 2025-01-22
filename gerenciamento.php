

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <img id="capa" src="link-da-imagem-da-capa.jpg" alt="Capa" class="capa">
        <h1 class="titulo">GERENCIAMENTO</h1>
        <div class="quadro">
            <form method="POST" action="liberar_acesso.php">
                <label for="email">E-mail do Usuário:</label>
                <input type="email" id="email" name="email" required>
                <button type="submit">Liberar Acesso</button>
            </form>
        </div>
    </div>
</body>
</html>

