<?php
// Função para validar login
function validarLogin($email, $senha) {
    $usuarios = file("usuarios.txt");
    foreach ($usuarios as $usuario) {
        list($userEmail, $userSenha, $dataExpiracao, $status) = explode("|", trim($usuario));
        
        if ($userEmail == $email && $userSenha == $senha && $status == "ativo") {
            // Verificar expiração da senha
            if (strtotime($dataExpiracao) > time()) {
                return true; // Login válido
            } else {
                return "Senha expirada";
            }
        }
    }
    return "E-mail ou senha incorretos";
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $resultado = validarLogin($email, $senha);
    if ($resultado === true) {
        echo "Acesso permitido!";
        // Redirecionar para o conteúdo premium ou atualizar acesso
        header("Location: pagepremium.html");
    } else {
        echo "Erro: $resultado";
    }
}
?>
