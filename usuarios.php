

<?php
// Verifica se o arquivo existe
$arquivo = "usuarios.txt";

if (file_exists($arquivo)) {
    $usuarios = file($arquivo, FILE_IGNORE_NEW_LINES);
} else {
    $usuarios = [];
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Usuários Cadastrados</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #000; color: #fff; text-align: center; }
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #fff; }
        th { background-color: #333; }
    </style>
</head>
<body>

<h2>Usuários Cadastrados</h2>

<table>
    <tr>
        <th>E-mail</th>
        <th>Senha</th>
        <th>Expiração</th>
        <th>Status</th>
    </tr>
    <?php foreach ($usuarios as $usuario) {
        list($email, $senha, $expiracao, $status) = explode("|", $usuario);
        echo "<tr>
                <td>$email</td>
                <td>$senha</td>
                <td>$expiracao</td>
                <td>$status</td>
              </tr>";
    } ?>
</table>

</body>
</html>

