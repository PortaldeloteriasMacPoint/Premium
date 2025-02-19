

<?php
// Caminho do arquivo de links (dados)
define('LINKS_FILE', 'data/links.json');

// Função para carregar os dados dos links
function carregarLinks() {
    if (!file_exists(LINKS_FILE)) {
        file_put_contents(LINKS_FILE, json_encode([])); // Cria o arquivo com um array vazio
    }
    return json_decode(file_get_contents(LINKS_FILE), true);
}

// Função para salvar os dados dos links
function salvarLinks($links) {
    file_put_contents(LINKS_FILE, json_encode($links, JSON_PRETTY_PRINT));
}
?>

