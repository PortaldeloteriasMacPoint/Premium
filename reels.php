<?php
header('Content-Type: application/json');

$videos = [
    "musica" => [
        ["id" => "hTWKbfoikeg", "title" => "Nirvana - Smells Like Teen Spirit"],
        ["id" => "YjygaDPCtXE", "title" => "Rock Nacional"],
        ["id" => "z9LiPuVRyU8", "title" => "Acústico"]
    ],
    "filmes" => [
        ["id" => "K4TOrB7at0Y", "title" => "Filme Aventura"],
        ["id" => "eY52Zsg-KVI", "title" => "Trailer Marvel"]
    ],
    "loterias" => [
        ["id" => "UceaB4D0jpo", "title" => "Como ganhar na Mega"],
        ["id" => "sNPnbI1arSE", "title" => "Dicas de Loteria"]
    ],
    "humor" => [
        ["id" => "tgbNymZ7vqY", "title" => "Vídeo Engraçado"],
        ["id" => "lXMskKTw3Bc", "title" => "Comédia Stand-up"]
    ],
    "animes" => [
        ["id" => "5kR4xTNB5F4", "title" => "Abertura Naruto"],
        ["id" => "lszJP-YoaF8", "title" => "One Piece EP.1000"]
    ],
    "novidades" => [
        ["id" => "kXYiU_JCYtU", "title" => "Novo lançamento musical"],
        ["id" => "3JZ_D3ELwOQ", "title" => "Novo trailer"]
    ],
    "favoritos" => [] // Firebase atualiza
];

echo json_encode($videos);
?>
