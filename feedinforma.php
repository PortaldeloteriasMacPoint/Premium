<?php
$arquivo = "feedmacpoint.html";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $titulo = $_POST['titulo'];
  $texto = nl2br($_POST['texto']);
  $imagem = $_POST['imagem'];
  $data = date('d/m/Y');

  $conteudo = "
  <article class='post-card'>
    <div class='post-header'>
      <img class='icon' src='img/macpoint-icon.png' alt='Ícone' />
      <div>
        <div class='post-title'>📰 Mac Point Informa – $titulo</div>
        <div class='post-date'>$data</div>
      </div>
    </div>
    <div class='post-content'>$texto</div>
    <div class='post-media'>
      <img src='$imagem' alt='Imagem'>
    </div>
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
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Publicar no Feed</title>
  <style>
    body { background:#000; color:#fff; font-family:sans-serif; display:flex; justify-content:center; padding:20px; }
    form { background:#111; padding:20px; border-radius:10px; width:100%; max-width:500px; border:2px solid #355E3B; }
    label { display:block; margin-top:15px; }
    input, textarea { width:100%; padding:8px; margin-top:5px; background:#222; color:#fff; border:none; border-radius:5px; }
    button { margin-top:20px; background:#355E3B; color:#fff; padding:10px; border:none; border-radius:8px; cursor:pointer; width:100%; }
    button:hover { background:#4CAF50; }
    .ok { background:green; padding:10px; border-radius:8px; margin-bottom:10px; text-align:center; }
  </style>
</head>
<body>
  <form method="post">
    <?php if (isset($_GET['ok'])): ?>
      <div class="ok">✅ Publicado com sucesso!</div>
    <?php endif; ?>
    <h2>Mac Point Informa</h2>
    <label>Título</label>
    <input type="text" name="titulo" required>
    <label>Texto</label>
    <textarea name="texto" rows="5" required></textarea>
    <label>URL da Imagem</label>
    <input type="url" name="imagem" required>
    <button type="submit">Publicar</button>
  </form>
</body>
</html>

