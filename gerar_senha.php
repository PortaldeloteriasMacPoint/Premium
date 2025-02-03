<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $usuarioInfo = "$email|$senhaGerada|" . date("Y-m-d H:i:s", $dataExpiracao) . "|ativo\n";
    file_put_contents("usuarios.txt", $usuarioInfo, FILE_APPEND);

    // Retorna os dados sem abrir nova página
    echo json_encode(["email" => $email, "senha" => $senhaGerada, "expiracao" => date("Y-m-d H:i:s", $dataExpiracao)]);
    exit; // Encerra o script para evitar carregar o HTML abaixo
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Senha Exclusiva</title>
    <style>
        body { background-color: black; color: white; font-family: Arial, sans-serif; }
        .form-container { width: 300px; margin: 100px auto; padding: 20px; background-color: #2d2d2d; border-radius: 10px; text-align: center; }
        input, select { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #333; color: white; }
        button { padding: 10px 20px; background-color: #FFA500; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #ff7f00; }
        #resultado { margin-top: 10px; padding: 10px; background-color: #444; border-radius: 5px; display: none; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Gerar Senha Exclusiva</h2>
    <form id="formSenha">
        <input type="email" id="email" name="email" placeholder="Digite o e-mail do usuário" required><br>
        <select id="plano" name="plano" required>
            <option value="mensal">Plano Mensal</option>
            <option value="premium">Plano Premium</option>
            <option value="anual">Plano Anual</option>
        </select><br>
        <button type="submit">Gerar Senha</button>
    </form>

    <div id="resultado"></div>
</div>

<script>
document.getElementById("formSenha").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita recarregar a página

    var formData = new FormData(this);

    fetch(window.location.href, { // Envia para o mesmo arquivo
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.senha) {
            document.getElementById("resultado").innerHTML = 
                "<p><strong>Email:</strong> " + data.email + "</p>" +
                "<p><strong>Senha:</strong> " + data.senha + "</p>" +
                "<p><strong>Expira em:</strong> " + data.expiracao + "</p>";
            document.getElementById("resultado").style.display = "block";
        } else {
            document.getElementById("resultado").innerHTML = "<p>Erro ao gerar senha.</p>";
        }
    })
    .catch(error => console.error("Erro:", error));
});
</script>

</body>
</html>

