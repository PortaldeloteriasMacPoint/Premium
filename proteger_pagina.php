

<?php
include 'db.php';

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.html");
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT acesso_liberado FROM usuarios WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['acesso_liberado'] != 1) {
        echo "Acesso negado. Aguarde a liberação.";
        exit();
    }
} else {
    echo "Usuário não encontrado.";
    exit();
}

$conn->close();
?>
