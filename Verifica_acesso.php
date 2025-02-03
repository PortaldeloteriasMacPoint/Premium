

<?php
$arquivo = "usuarios.txt";

function verificarAcesso($email, $senha) {
    global $arquivo;
    $usuarios = file($arquivo);

    foreach ($usuarios as $linha) {
        $dados = explode("|", trim($linha));
        if ($dados[0] == $email && $dados[1] == $senha) {
            if ($dados[3] == "bloqueado") {
                return "acesso_negado";
            } else {
                return "acesso_permitido";
            }
        }
    }
    return "usuario_nao_encontrado";
}

// Teste de acesso
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $resultado = verificarAcesso($email, $senha);

    echo json_encode(["status" => $resultado]);
    exit;
}
?>


