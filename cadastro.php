<?php
// Inicia a sessão PHP
session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <!-- Inclusão do Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-auth.js"></script>
    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyAO3As6jMMmENtzaK9zlDADbpS9UlNxx8o",
            authDomain: "mac-projeto-4e552.firebaseapp.com",
            projectId: "mac-projeto-4e552",
            storageBucket: "mac-projeto-4e552.appspot.com",
            messagingSenderId: "537330451519",
            appId: "1:537330451519:web:5a1b4c921119b5ee98e48a"
        };

        // Inicializa o Firebase
        const app = firebase.initializeApp(firebaseConfig);
        const auth = firebase.auth();

        // Função de cadastro
        function register() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            auth.createUserWithEmailAndPassword(email, password)
                .then((userCredential) => {
                    const user = userCredential.user;
                    window.location.href = 'login.php'; // Redireciona para o login após cadastro
                })
                .catch((error) => {
                    const errorCode = error.code;
                    const errorMessage = error.message;
                    alert("Erro de cadastro: " + errorMessage);
                });
        }
    </script>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            color: white;
            font-size: 2rem;
        }

        form {
            background-color: #333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: none;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div>
        <h1>Cadastro</h1>
        <form id="registerForm" onsubmit="event.preventDefault(); register();">
            <input type="email" id="email" placeholder="Email" required><br>
            <input type="password" id="password" placeholder="Senha" required><br>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
