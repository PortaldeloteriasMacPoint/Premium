<?php
header("Content-Type: application/json");
$file_path = "/mnt/data/links.json";

if (file_exists($file_path)) {
    echo file_get_contents($file_path);
} else {
    echo json_encode(["status" => "Nenhum link encontrado."]);
}
?>


---
