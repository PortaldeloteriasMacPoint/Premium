

<?php
$arquivo = "usuarios.txt";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['plano'])) {
        function gerarSenhaUnica() {
            return substr(md5(rand()), 0, 12);
        }

        function calcularDataExpiracao($plano) {
            if ($plano == "mensal") {
                return strtotime("+30 days");
            } elseif ($plano == "premium") {
                return strtotime("+90 days");
            } elseif ($plano == "anual") {
                return strtotime("+365 days");
            }
        }

        $email = $_POST['email'];
        $plano = $_POST['plano'];

        $senhaGerada = gerarSenhaUnica();
        $dataExpiracao = calcularDataExpiracao($plano);

        // Salva no arquivo
        $usuarioInfo = "$email|$senhaGerada|" . date("Y-m-d H:i:s", $dataExpiracao) . "|ativo\n";
        file_put_contents($arquivo, $usuarioInfo, FILE_APPEND);

        echo json_encode(["email" => $email, "senha" => $senhaGerada, "expiracao" => date("Y-m-d H:i:s", $dataExpiracao)]);
        exit;
    }
}
?>


