<?php
header('Content-Type: application/json');

$videos = [
  "musicas" => [
    [
      ["id" => "hTWKbfoikeg", "liked" => false, "favorite" => false],
      ["id" => "YjygaDPCtXE", "liked" => false, "favorite" => false],
      ["id" => "gzMf4JmxSdY", "liked" => false, "favorite" => false]
    ],
    [
      ["id" => "fregObNcHC8", "liked" => false, "favorite" => false],
      ["id" => "z9LiPuVRyU8", "liked" => false, "favorite" => false]
    ]
  ],
  "filmes" => [
    [
      ["id" => "K4TOrB7at0Y", "liked" => false, "favorite" => false]
    ]
  ],
  "loterias" => [
    [
      ["id" => "UceaB4D0jpo", "liked" => false, "favorite" => false]
    ]
  ]
];

echo json_encode($videos);
?>



  
