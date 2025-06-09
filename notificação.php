<?php
define('FIREBASE_PROJECT_ID', 'mac-projeto-4e552');
define('FIREBASE_API_KEY', 'AIzaSyAO3As6jMMmENtzaK9zlDADbpS9UlNxx8o');
define('FIREBASE_COLLECTION', 'notificacoes');

$usuarios = [
  'usuario1@email.com',
  'usuario2@email.com',
  'usuario3@email.com'
];

function enviarNotificacao($email, $mensagem) {
    $data = [
        'email' => ['stringValue' => $email],
        'mensagem' => ['stringValue' => $mensagem],
        'timestamp' => ['timestampValue' => date('c')],
        'lida' => ['booleanValue' => false]
    ];

    $url = "https://firestore.googleapis.com/v1/projects/" . FIREBASE_PROJECT_ID . "/databases/(default)/documents/" . FIREBASE_COLLECTION . "?key=" . FIREBASE_API_KEY;

    $postData = json_encode(['fields' => $data]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensagem = trim($_POST['mensagem']);
    foreach ($usuarios as $email) {
        enviarNotificacao($email, $mensagem);
    }
    $status = "✅ Notificação enviada para todos os usuários!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Enviar Notificação</title>
  <style>
    body {
      background-color: #000;
      color: #fff;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
    }
    .container {
      width: 90%;
      max-width: 600px;
      background: #111;
      margin-top: 40px;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 12px #000;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
      font-weight: bold;
    }
    textarea {
      width: 100%;
      padding: 12px;
      border-radius: 6px;
      border: 1px solid #555;
      background: #222;
      color: #fff;
      box-sizing: border-box;
      font-size: 1rem;
      resize: vertical;
      min-height: 100px;
    }
    button {
      width: 100%;
      padding: 14px;
      margin-top: 20px;
      background: orange;
      color: white;
      border: 2px solid black;
      border-radius: 8px;
      font-size: 1.1rem;
      font-weight: bold;
      text-shadow: 1px 1px 0 black;
      cursor: pointer;
      transition: 0.3s;
    }
    button:hover {
      background: #e69500;
    }
    .status {
      text-align: center;
      margin-top: 20px;
      font-weight: bold;
      color: lime;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Enviar Notificação para Todos</h2>
    <form method="post">
      <label for="mensagem">Mensagem:</label>
      <textarea id="mensagem" name="mensagem" required placeholder="Digite a mensagem para todos os usuários..."></textarea>

      <button type="submit">Enviar Notificação</button>
    </form>

    <?php if ($status): ?>
      <div class="status"><?= htmlspecialchars($status) ?></div>
    <?php endif; ?>
  </div>
</body>
</html>

