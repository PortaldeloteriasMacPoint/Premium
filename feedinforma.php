<?php
$arquivo = "posts.html";

// Publicar nova postagem
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['titulo'])) {
    $titulo = $_POST['titulo'];
    $texto = nl2br($_POST['texto']);
    $imagem = $_POST['imagem'];
    $data = date('d/m/Y');
    $id = uniqid();

    $conteudo = "
<!-- ID:$id -->
<article class='post-card'>
  <div class='post-header'>
    <img class='icon' src='img/macpoint-icon.png' alt='Ícone' />
    <div>
      <div class='post-title'>📰 Mac Point Informa – $titulo</div>
      <div class='post-date'>$data</div>
    </div>
  </div>
  <div class='post-content'>$texto</div>
  <div class='post-media'><img src='$imagem' alt='Imagem'></div>
  <div class='post-actions'>
    <span class='like'><i class='fa-solid fa-heart'></i> <span class='count'>0</span></span>
    <span class='star'><i class='fa-solid fa-star'></i> <span class='count'>0</span></span>
    <span class='share'><i class='fa-solid fa-share-nodes'></i></span>
  </div>
</article>\n";

    file_put_contents($arquivo, $conteudo, FILE_APPEND);
    header("Location: feedinforma.php?ok=1");
    exit;
  }

  // Apagar postagem
  if (isset($_POST['apagar_id'])) {
    $idApagar = trim($_POST['apagar_id']);
    $conteudo = file_get_contents($arquivo);
    $padrao = "/<!-- ID:$idApagar -->(.*?)<\\/article>\\n/s";
    $novo = preg_replace($padrao, '', $conteudo);
    file_put_contents($arquivo, $novo);
    header("Location: feedinforma.php?apagado=1");
    exit;
  }
}

// Ler conteúdo atual
$publicacoes = file_exists($arquivo) ? file($arquivo) : [];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Publicar no Feed - Mac Point</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      background: #000;
      color: #fff;
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
    }
    form {
      background: #111;
      padding: 20px;
      border-radius: 12px;
      width: 100%;
      max-width: 600px;
      border: 2px solid #355E3B;
      margin-bottom: 30px;
    }
    label {
      display: block;
      margin-top: 15px;
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      background: #222;
      color: #fff;
      border: none;
      border-radius: 6px;
    }
    button {
      margin-top: 20px;
      background: #355E3B;
      color: #fff;
      padding: 12px;
      width: 100%;
      border: none;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
    }
    button:hover {
      background: #4CAF50;
    }
    .msg {
      background: green;
      padding: 12px;
      text-align: center;
      border-radius: 8px;
      margin-bottom: 15px;
    }
    .lista-publicacoes {
      max-width: 600px;
      width: 100%;
    }
    .item-post {
      border: 1px solid #355E3B;
      background: #111;
      padding: 12px;
      border-radius: 10px;
      margin-bottom: 15px;
      position: relative;
    }
    .item-post form {
      margin-top: 10px;
    }
    .id-post {
      font-size: 0.8rem;
      color: #aaa;
    }
    .btn-apagar {
      background: crimson;
      border: none;
      padding: 6px 10px;
      border-radius: 6px;
      color: #fff;
      cursor: pointer;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <?php if (isset($_GET['ok'])): ?>
    <div class="msg">✅ Publicado com sucesso!</div>
  <?php elseif (isset($_GET['apagado'])): ?>
    <div class="msg">🗑️ Publicação apagada!</div>
  <?php endif; ?>

  <form method="post">
    <h2>Mac Point Informa</h2>
    <label>Título</label>
    <input type="text" name="titulo" required>
    <label>Texto</label>
    <textarea name="texto" rows="4" required></textarea>
    <label>URL da imagem</label>
    <input type="url" name="imagem" required>
    <button type="submit">Publicar</button>
  </form>

  <div class="lista-publicacoes">
    <?php
    foreach ($publicacoes as $linha) {
      if (strpos($linha, '<article') !== false) {
        preg_match('/<!-- ID:(.*?) -->/', $linha, $id);
        $idPost = $id[1] ?? '';
        echo "<div class='item-post'>";
        echo "<div class='id-post'>ID: $idPost</div>";
        echo "<form method='post' onsubmit='return confirm(\"Apagar esta publicação?\")'>
                <input type='hidden' name='apagar_id' value='$idPost'>
                <button class='btn-apagar' type='submit'>🗑️ Apagar</button>
              </form>";
        echo "</div>";
      }
    }
    ?>
  </div>
</body>
</html>


