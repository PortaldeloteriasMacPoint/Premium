
<?php
include 'db.php';

$email = $_POST['email'];

$sql = "UPDATE usuarios SET acesso_liberado=1 WHERE email='$email'";
if ($conn->query($sql) === TRUE) {
    echo "Acesso liberado com sucesso.";
} else {
    echo "Erro ao liberar acesso: " . $conn->error;
}

$conn->close();
?>
