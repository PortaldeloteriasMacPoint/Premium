

<?php
$arquivo = "usuarios.txt";

// Atualizar status do usuário
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $emailParaBloquear = $_POST['email'];
    $linhas = file($arquivo);
    $novoConteudo = "";

    foreach ($linhas as $linha) {
        $dados = explode("|", trim($linha));
        if ($dados[0] == $emailParaBloquear) {
            $dados[3] = "bloqueado"; // Mudar status
        }
        $novoConteudo .= implode("|", $dados) . "\n";
    }

    file_put_contents($arquivo, $novoConteudo);
    echo "Usuário bloqueado com sucesso!";
}

// Exibir usuários
$usuarios = file($arquivo);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #222; color: white; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid white; text-align: left; }
        th { background-color: #444; }
        button { background-color: red; color: white; border: none; padding: 5px 10px; cursor: pointer; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Gerenciar Usuários</h2>
    <table>
        <tr>
            <th>Email</th>
            <th>Senha</th>
            <th>Expiração</th>
            <th>Status</th>
            <th>Ação</th>
        </tr>
        <?php foreach ($usuarios as $linha): 
            $dados = explode("|", trim($linha));
        ?>
        <tr>
            <td><?= $dados[0] ?></td>
            <td><?= $dados[1] ?></td>
            <td><?= $dados[2] ?></td>
            <td><?= $dados[3] ?></td>
            <td>
                <?php if ($dados[3] == "ativo"): ?>
                    <form method="POST">
                        <input type="hidden" name="email" value="<?= $dados[0] ?>">
                        <button type="submit">Bloquear</button>
                    </form>
                <?php else: ?>
                    <span style="color: red;">Bloqueado</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>


