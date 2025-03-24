<?php
header('Content-Type: application/json');

$arquivo = 'resultados.json';
$backup = 'backup_resultados_' . date('Y-m-d_H-i-s') . '.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = file_get_contents($arquivo);
    $dados = json_decode($jsonData, true) ?? [];
    
    $modalidade = $_POST['modalidade'] ?? '';
    $sorteio = $_POST['sorteio'] ?? '';
    $resultado = $_POST['resultado'] ?? '';
    
    if ($modalidade && $sorteio && $resultado) {
        $dados[$modalidade] = [
            'sorteio' => $sorteio,
            'resultado' => explode(',', str_replace(' ', '', $resultado))
        ];
        
        // Salvar backup antes de atualizar
        copy($arquivo, $backup);
        
        file_put_contents($arquivo, json_encode($dados, JSON_PRETTY_PRINT));
        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Resultado salvo com sucesso!']);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Todos os campos são obrigatórios!']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($arquivo)) {
        echo file_get_contents($arquivo);
    } else {
        echo json_encode([]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .container { max-width: 400px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0px 0px 10px #ccc; }
        input, button { width: 100%; padding: 10px; margin: 5px 0; }
        button { background: #28a745; color: #fff; border: none; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Adicionar Resultado</h2>
        <form id="formResultado">
            <input type="text" id="modalidade" placeholder="Modalidade (Ex: Mega-Sena)" required>
            <input type="text" id="sorteio" placeholder="Número do Sorteio" required>
            <input type="text" id="resultado" placeholder="Resultado (Ex: 05,12,20,30,43,56)" required>
            <button type="submit">Salvar</button>
        </form>
        <p id="mensagem"></p>
    </div>
    <script>
        document.getElementById('formResultado').addEventListener('submit', function(event) {
            event.preventDefault();
            let modalidade = document.getElementById('modalidade').value;
            let sorteio = document.getElementById('sorteio').value;
            let resultado = document.getElementById('resultado').value;
            
            fetch('', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `modalidade=${modalidade}&sorteio=${sorteio}&resultado=${resultado}`
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('mensagem').innerText = data.mensagem;
            })
            .catch(error => console.error('Erro:', error));
        });
    </script>
</body>
</html>

