<?php
// Arquivo: resultados.php
// Painel para inserção de resultados e salvamento no JSON

// Carregar resultados atuais
$arquivo_json = 'resultados.json';
$backup_json = 'backup-resultados.json';

if (!file_exists($arquivo_json)) {
    file_put_contents($arquivo_json, json_encode([]));
}

$resultados = json_decode(file_get_contents($arquivo_json), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modalidade = $_POST['modalidade'] ?? '';
    $sorteio = $_POST['sorteio'] ?? '';
    $resultado = $_POST['resultado'] ?? '';
    $time_coracao = $_POST['time_coracao'] ?? '';
    $dupla_sena = $_POST['dupla_sena'] ?? '';

    if ($modalidade && $sorteio && $resultado) {
        $novo_resultado = [
            'sorteio' => $sorteio,
            'resultado' => $resultado,
        ];

        if ($modalidade === 'Timemania') {
            $novo_resultado['time_coracao'] = $time_coracao;
        } elseif ($modalidade === 'Dupla Sena') {
            $novo_resultado['segundo_sorteio'] = $dupla_sena;
        }

        $resultados[$modalidade][] = $novo_resultado;

        file_put_contents($arquivo_json, json_encode($resultados, JSON_PRETTY_PRINT));
        file_put_contents($backup_json, json_encode($resultados, JSON_PRETTY_PRINT)); // Criar backup
    }
}

// Criar backup automático a cada 30 minutos
$backup_dir = 'backups';
if (!file_exists($backup_dir)) {
    mkdir($backup_dir, 0777, true);
}

$backup_file = $backup_dir . '/backup_' . date('Y-m-d_H-i-s') . '.json';
copy($arquivo_json, $backup_file);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        input, select, button {
            margin: 10px;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2>Painel Administrativo - Inserir Resultados</h2>
    <form method="POST">
        <label>Modalidade:</label>
        <select name="modalidade">
            <option value="Mega Sena">Mega Sena</option>
            <option value="Quina">Quina</option>
            <option value="Lotomania">Lotomania</option>
            <option value="Lotofácil">Lotofácil</option>
            <option value="Dupla Sena">Dupla Sena</option>
            <option value="Timemania">Timemania</option>
            <option value="Loteca">Loteca</option>
            <option value="Milionária">+Milionária</option>
            <option value="Chispalotto">Chispalotto</option>
        </select>
        <br>
        <label>Número do Sorteio:</label>
        <input type="text" name="sorteio" required>
        <br>
        <label>Resultado:</label>
        <input type="text" name="resultado" required>
        <br>
        <label>Time do Coração (Timemania):</label>
        <input type="text" name="time_coracao">
        <br>
        <label>Segundo Sorteio (Dupla Sena):</label>
        <input type="text" name="dupla_sena">
        <br>
        <button type="submit">Salvar Resultado</button>
    </form>
</body>
</html>


