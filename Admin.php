

<?php
session_start();

// Verifica se o usuário é o administrador
if ($_SESSION['user']->email != 'admin@example.com') {
    header("Location: verifica_acesso.php");
    exit;
}

// Lista de e-mails autorizados (pode ser lida de um arquivo ou banco de dados)
$autorizados = [
    'mikeponte@gmail.com',
    'usuario@dominio.com'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_autorizado = $_POST['email'];

    // Adiciona ou remove e-mail da lista de autorizados
    if (isset($_POST['autorizar'])) {
        $autorizados[] = $email_autorizado;
        echo "E-mail autorizado com sucesso!";
    } elseif (isset($_POST['remover'])) {
        $key = array_search($email_autorizado, $autorizados);
        if ($key !== false) {
            unset($autorizados[$key]);
            echo "E-mail removido da lista de autorizados.";
        }
    }
}
?>

<form method="POST">
    E-mail para autorizar: <input type="email" name="email" required><br>
    <button type="submit" name="autorizar">Autorizar</button>
    <button type="submit" name="remover">Remover</button>
</form>


