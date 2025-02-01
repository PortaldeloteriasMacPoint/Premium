

<?php
// Caminho do arquivo de e-mails autorizados
$arquivoAutorizados = 'autorizados.txt';

// Função para ler os e-mails do arquivo
function getEmailsAutorizados() {
    global $arquivoAutorizados;
    if (file_exists($arquivoAutorizados)) {
        return file($arquivoAutorizados, FILE_IGNORE_NEW_LINES);
    }
    return [];
}

// Função para adicionar e-mail ao arquivo
function adicionarEmail($email) {
    global $arquivoAutorizados;
    $emails = getEmailsAutorizados();
    if (!in_array($email, $emails)) {
        file_put_contents($arquivoAutorizados, $email . PHP_EOL, FILE_APPEND);
    }
}

// Função para remover e-mail do arquivo
function removerEmail($email) {
    global $arquivoAutorizados;
    $emails = getEmailsAutorizados();
    $emails = array_filter($emails, function($e) use ($email) {
        return $e !== $email;
    });
    file_put_contents($arquivoAutorizados, implode(PHP_EOL, $emails) . PHP_EOL);
}

// Verifica se o formulário de adicionar ou remover foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['adicionar'])) {
        $emailAdicionar = $_POST['emailAdicionar'] ?? '';
        if (filter_var($emailAdicionar, FILTER_VALIDATE_EMAIL)) {
            adicionarEmail($emailAdicionar);
        }
    } elseif (isset($_POST['remover'])) {
        $emailRemover = $_POST['emailRemover'] ?? '';
        if (filter_var($emailRemover, FILTER_VALIDATE_EMAIL)) {
            removerEmail($emailRemover);
        }
    }
}

// Obtém a lista de e-mails autorizados
$emailsAutorizados = getEmailsAutorizados();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Usuários Autorizados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        h1 {
            color: #444;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #f8f8f8;
            padding: 10px;
            margin: 5px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<header>
    <h1>Gerenciamento de Usuários Autorizados</h1>
</header>

<div class="container">
    <h2>Adicionar Novo E-mail</h2>
    <form method="post" action="">
        <label for="emailAdicionar">Digite o e-mail para autorizar:</label>
        <input type="email" name="emailAdicionar" id="emailAdicionar" required placeholder="email@dominio.com">
        <input type="submit" name="adicionar" value="Adicionar E-mail">
    </form>

    <h2>Remover E-mail</h2>
    <form method="post" action="">
        <label for="emailRemover">Digite o e-mail para remover:</label>
        <input type="email" name="emailRemover" id="emailRemover" required placeholder="email@dominio.com">
        <input type="submit" name="remover" value="Remover E-mail">
    </form>

    <h3>E-mails Autorizados:</h3>
    <ul>
        <?php
        // Exibe a lista de e-mails autorizados
        foreach ($emailsAutorizados as $email) {
            echo "<li>$email</li>";
        }
        ?>
    </ul>
</div>

</body>
</html>

