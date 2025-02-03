Aqui está o código do verificar_acesso.php:

<?php
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $senha = trim($_POST["senha"]);
    
    if (file_exists("usuarios.txt")) {
        $usuarios = file("usuarios.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($usuarios as $usuario) {
            list($email_salvo, $senha_salva, $expiracao, $status) = explode("|", $usuario);
            
            if ($email === $email_salvo && $senha === $senha_salva) {
                if ($status === "bloqueado") {
                    echo json_encode(["status" => "acesso_negado"]);
                    exit;
                }
                
                if (!empty($expiracao) && strtotime($expiracao) < time()) {
                    echo json_encode(["status" => "acesso_expirado"]);
                    exit;
                }
                
                echo json_encode(["status" => "acesso_permitido"]);
                exit;
            }
        }
    }

    echo json_encode(["status" => "acesso_negado"]);
}
?>

