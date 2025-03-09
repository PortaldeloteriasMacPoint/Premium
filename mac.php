<?php  
    session_start(); // Inicia a sessão para segurança extra  
?>  
<!DOCTYPE html>  
<html lang="pt">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>MAC POINT PREMIUM</title>  

    <!-- Importação da Fonte Caveat -->
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&display=swap" rel="stylesheet">  

    <style>  
        * {  
            margin: 0;  
            padding: 0;  
            box-sizing: border-box;  
            font-family: Arial, sans-serif;  
            user-select: none; /* Impede seleção do texto (evita cópias) */  
        }  

        body {  
            display: flex;  
            flex-direction: column;  
            align-items: center;  
            background-color: black;  
            overflow-x: hidden;  
            min-height: 100vh;  
        }  

        /* Borda Superior */
        .top-bar {  
            width: 100%;  
            height: 60px;  
            background: linear-gradient(to bottom, #064635, #2C6E49);  
            border-bottom: 3px solid #00FFAA;  
            display: flex;  
            align-items: center;  
            justify-content: space-between;  
            padding: 0 15px;  
            position: fixed;  
            top: 0;  
            left: 0;  
            z-index: 1000;  
        }  

        /* Título com contorno branco e fonte Caveat */
        .top-bar h1 {  
            color: white;  
            font-size: 26px;  
            font-family: 'Caveat', cursive;  
            font-weight: bold;  
            text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.8);  
        }  

        /* Ícone do menu hambúrguer com contorno */
        .menu-icon {  
            font-size: 30px;  
            color: white;  
            cursor: pointer;  
            border: 2px solid white;  
            padding: 5px;  
            border-radius: 5px;  
        }  

        /* Segurança contra inspeção */
        body {
            -webkit-user-select: none;  
            -moz-user-select: none;  
            -ms-user-select: none;  
            user-select: none;  
        }  
    </style>  
</head>  
<body>  
    <div class="top-bar">  
        <span class="menu-icon" onclick="toggleMenu()">☰</span>  
        <h1>MAC POINT PREMIUM</h1>  
    </div>  

    <script>  
        // Bloqueio do clique direito (evita cópia de código)
        document.addEventListener('contextmenu', event => event.preventDefault());

        // Bloqueio do atalho F12 (evita inspeção do código)
        document.addEventListener('keydown', function(event) {  
            if (event.key === "F12" || (event.ctrlKey && event.shiftKey && event.key === "I")) {  
                event.preventDefault();  
            }  
        });

        // Firebase Authentication (Login obrigatório para acessar)
        const firebaseConfig = {
            apiKey: "AIzaSyAO3As6...",
            authDomain: "mac-projeto-4e552.firebaseapp.com",
            projectId: "mac-projeto-4e552",
            storageBucket: "mac-projeto-4e552.appspot.com",
            messagingSenderId: "537330451519",
            appId: "1:537330451519:web:5a1b4c921119b5ee98e48a"
        };

        firebase.initializeApp(firebaseConfig);

        firebase.auth().onAuthStateChanged(user => {
            if (!user) {
                window.location.href = "login.html"; // Redireciona para login se não estiver autenticado
            }
        });

        // Evita cache de versões antigas
        if ('serviceWorker' in navigator) {
            caches.keys().then(names => {
                for (let name of names) {
                    caches.delete(name);
                }
            });
        }
    </script>  
</body>  
</html>


