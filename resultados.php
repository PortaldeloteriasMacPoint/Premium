<?php
// Função para salvar dados no arquivo JSON
function salvarResultado($modalidade, $numero_sorteio, $resultado) {
    $arquivo = 'resultados.json';
    
    // Verifica se o arquivo existe e carrega o conteúdo
    if (file_exists($arquivo)) {
        $dados = file_get_contents($arquivo);
        $resultados = json_decode($dados, true);
    } else {
        // Se o arquivo não existe, cria um array vazio
        $resultados = [];
    }

    // Novo resultado a ser adicionado
    $novoResultado = [
        'modalidade' => $modalidade,
        'numero_sorteio' => $numero_sorteio,
        'resultado' => $resultado,
    ];

    // Adiciona o novo resultado
    $resultados[] = $novoResultado;

    // Salva os dados de volta no arquivo JSON
    if (file_put_contents($arquivo, json_encode($resultados, JSON_PRETTY_PRINT))) {
        return true;  // Sucesso
    } else {
        return false; // Falha ao salvar
    }
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $modalidade = $_POST['modalidade'];
    $numero_sorteio = $_POST['numero_sorteio'];
    $resultado = $_POST['resultado'];

    // Tenta salvar o novo resultado
    $sucesso = salvarResultado($modalidade, $numero_sorteio, $resultado);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Resultados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        h2 {
            text-align: center;
            color: #2f6b58;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input, select, button {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #ff6600;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #e65c00;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Painel de Resultados</h2>

        <?php if (isset($sucesso) && $sucesso): ?>
            <div class="success">Resultado salvo com sucesso!</div>
        <?php elseif (isset($sucesso) && !$sucesso): ?>
            <div class="error">Erro ao salvar o resultado!</div>
        <?php endif; ?>

        <!-- Formulário para adicionar resultado -->
        <form method="POST">
            <label for="modalidade">Escolha a Modalidade:</label>
            <select name="modalidade" required>
                <option value="Mega-Sena">Mega-Sena</option>
                <option value="Quina">Quina</option>
                <option value="Lotofácil">Lotofácil</option>
                <option value="Lotomania">Lotomania</option>
                <option value="Dupla Sena">Dupla Sena</option>
                <option value="Timemania">Timemania</option>
                <option value="Chispalotto">Chispalotto</option>
                <option value="Milionária">Milionária</option>
            </select>

            <label for="numero_sorteio">Número do Sorteio:</label>
            <input type="number" name="numero_sorteio" required>

            <label for="resultado">Resultado:</label>
            <input type="text" name="resultado" required placeholder="Ex: 01, 02, 03, 04, 05, 06">

            <button type="submit">Salvar Resultado</button>
        </form>
    </div>
</body>
</html>

