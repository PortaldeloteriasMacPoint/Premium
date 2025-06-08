
<?php
// Inicia o PHP e define o caminho do "banco de notificações"
$arquivo = 'banco_notificacoes.json';
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([]));
}

$dados = json_decode(file_get_contents($arquivo), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensagem = trim($_POST['mensagem']);
    $destino = $_POST['destino'];
    $timestamp = time();
    $novaNotificacao = [
        'mensagem' => $mensagem,
        'lida' => false,
        'timestamp' => $timestamp
    ];

    if ($destino === 'todos') {
        foreach ($dados as $usuario => &$notificacoes) {
            $notificacoes['globais'][] = $novaNotificacao;
        }
    } else {
        if (!isset($dados[$destino])) {
            $dados[$destino] = ['globais' => [], 'individuais' => []];
        }
        $dados[$destino]['individuais'][] = $novaNotificacao;
    }

    file_put_contents($arquivo, json_encode($dados, JSON_PRETTY_PRINT));
    $mensagemSucesso = "Notificação enviada com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Enviar Notificação</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      background-color: black;
      color: white;
      font-family: sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .form-container {
      max-width: 400px;
      width: 90%;
      padding: 20px;
      background-color: #111;
      border-radius: 10px;
      text-align: center;
    }

    textarea, select, button {
      width: 100%;
      margin: 10px 0;
      padding: 12px;
      font-size: 16px;
      border: 1px solid #444;
      border-radius: 6px;
    }

    button {
      background-color: orange;
      color: white;
      font-weight: bold;
      border: 2px solid black;
      cursor: pointer;
      text-shadow: 1px 1px 1px black;
    }

    .success {
      margin-top: 10px;
      color: #0f0;
      font-weight: bold;
    }

    h2 {
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Enviar Notificação</h2>
    <form method="POST">
      <textarea name="mensagem" placeholder="Digite a notificação..." required></textarea>
      <select name="destino" required>
        <option value="">-- Selecionar Destino --</option>
        <option value="todos">Todos os usuários</option>
        <option value="usuario1@example.com">usuario1@example.com</option>
        <option value="usuario2@example.com">usuario2@example.com</option>
        <!-- Adicione mais usuários conforme necessário -->
      </select>
      <button type="submit">Enviar</button>
    </form>

    <?php if (isset($mensagemSucesso)): ?>
      <div class="success"><?= $mensagemSucesso ?></div>
    <?php endif; ?>
  </div>

</body>
</html>


