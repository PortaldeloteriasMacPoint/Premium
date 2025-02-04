require 'firestore.php';

$firestore = new FirestoreDB();

// Criando um usuário
$firestore->addUser('usuario@email.com', '123456', 'Mensal');

// Buscando um usuário
$user = $firestore->getUser('usuario@email.com');
print_r($user);
