<?php
// Caminhos dos arquivos
$resultadosFile = 'resultados.json';
$backupDir = 'backups/'; // Pasta onde os backups serão salvos

// Criar a pasta de backup se não existir
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// Verifica se o arquivo resultados.json existe
if (!file_exists($resultadosFile)) {
    file_put_contents($resultadosFile, json_encode([])); // Cria o arquivo vazio caso não exista
}

// Função para criar backup automaticamente
function criarBackup($resultadosFile, $backupDir) {
    $backupFile = $backupDir . "backup_" . date("Y-m-d_H-i-s") . ".json";
    if (copy($resultadosFile, $backupFile)) {
        return true;
    } else {
        return false;
    }
}

// Processa o formulário quando os dados forem enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados do formulário
    $modalidade = $_POST['modalidade'];
    $numeroSorteio = $_POST['numeroSorteio'];
    $resultado = $_POST['resultado'];

    // Carrega o arquivo JSON atual
    $resultados = json_decode(file_get_contents($resultadosFile), true);

    // Adiciona o novo resultado ao array
    $novoResultado = [
        'modalidade' => $modalidade,
        'numeroSorteio' => $numeroSorteio,
        'resultado' => $resultado
    ];
    $resultados[] = $novoResultado;

    // Salva os dados no arquivo JSON
    file_put_contents($resultadosFile, json_encode($resultados, JSON_PRETTY_PRINT));

    // Cria backup
    criarBackup($resultadosFile, $backupDir);
    echo "<p style='color: green;'>Resultado salvo com sucesso!</p>";
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
            text-align: center;
            background-color: #fff;
            color: #000;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #000;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #ff7f00; /* Laranja escuro */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #e67e00;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Adicionar Resultado</h1>
    <form method="POST">
        <label for="modalidade">Selecione a Modalidade:</label>
        <select name="modalidade" id="modalidade" required>
            <option value="Mega Sena">Mega Sena</option>
            <option value="Quina">Quina</option>
            <option value="Lotofácil">Lotofácil</option>
            <option value="Lotomania">Lotomania</option>
            <option value="Dupla Sena">Dupla Sena</option>
            <option value="Timemania">Timemania</option>
            <option value="Chispalotto">Chispalotto</option>
            <option value="Milionária">Milionária</option>
        </select>

        <label for="numeroSorteio">Número do Sorteio:</label>
        <input type="number" name="numeroSorteio" id="numeroSorteio" required>

        <label for="resultado">Resultado (Números Sorteados):</label>
        <input type="text" name="resultado" id="resultado" placeholder="Ex: 05, 12, 20, 30, 43, 56" required>

        <button type="submit">Salvar Resultado</button>
    </form>
</div>

</body>
</html>

