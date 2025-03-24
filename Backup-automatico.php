<?php
// Caminhos dos arquivos
$resultadosFile = "resultados.json";
$backupDir = "backups/"; // Pasta onde os backups serão salvos

// Criar a pasta de backup se não existir
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// Arquivo para armazenar o tempo do último backup
$ultimoBackupFile = $backupDir . "ultimo_backup.txt";

// Tempo mínimo entre backups (30 minutos)
$tempoBackup = 30 * 60; // 30 minutos em segundos

// Verifica se o arquivo de tempo do último backup existe
$ultimoBackup = 0;
if (file_exists($ultimoBackupFile)) {
    $ultimoBackup = (int) file_get_contents($ultimoBackupFile);
}

// Se já passaram 30 minutos desde o último backup, cria um novo
if (time() - $ultimoBackup >= $tempoBackup) {
    // Cria um nome de arquivo com data e hora
    $backupFile = $backupDir . "backup_" . date("Y-m-d_H-i-s") . ".json";
    
    // Faz a cópia do arquivo atual
    if (copy($resultadosFile, $backupFile)) {
        // Atualiza o tempo do último backup
        file_put_contents($ultimoBackupFile, time());
        echo "Backup criado com sucesso: $backupFile";
    } else {
        echo "Erro ao criar backup.";
    }
} else {
    echo "Aguarde pelo menos 30 minutos para o próximo backup.";
}
?>


