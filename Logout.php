

<?php
session_start();

// Destrói a sessão, efetivamente desconectando o usuário
session_destroy();

header("Location: login.php");
exit;
?>


