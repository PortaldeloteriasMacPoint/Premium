

<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifica se o usuário está autenticado via Firebase
    try {
        $user = $auth->signInWithEmailAndPassword($email, $password);
        $_SESSION['user'] = $user;

        // Chama a função de verificação de autorização do PHP
        header("Location: verifica_acesso.php");
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<form method="POST">
    E-mail: <input type="email" name="email" required><br>
    Senha: <input type="password" name="password" required><br>
    <button type="submit">Entrar</button>
</form>


