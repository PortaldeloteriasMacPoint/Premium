<?php
    // Configurações dinâmicas
    $title = "Mark Point";
    $description = "Bem-vindo à plataforma Mark Point. Aqui você encontra tudo sobre loterias!";
    $carousel_images = [
        "https://via.placeholder.com/600x150/FF5733",
        "https://via.placeholder.com/600x150/33FF57",
        "https://via.placeholder.com/600x150/3357FF"
    ];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: black;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Barra superior */
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

        .top-bar h1 {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .menu-icon {
            font-size: 30px;
            color: white;
            cursor: pointer;
        }

        /* Menu lateral */
        .sidebar {
            position: fixed;
            top: 60px;
            left: -270px;
            width: 270px;
            height: calc(100% - 60px);
            background: #064635;
            color: white;
            padding-top: 10px;
            transition: left 0.3s ease-in-out;
            border-right: 3px solid #00FFAA;
            overflow-y: auto;
            z-index: 1001;
        }

        .sidebar.active {
            left: 0;
        }

        .menu-item {
            display: block;
            padding: 12px;
            background: black;
            border: 2px solid #00FFAA;
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin: 10px;
            text-align: center;
            border-radius: 8px;
            cursor: pointer;
        }

        .menu-item:hover {
            background: #2C6E49;
        }

        .content {
            width: 90%;
            max-width: 800px;
            margin-top: 80px;
            text-align: center;
            flex: 1;
            display: none;
        }

        .cover-photo {
            width: 100%;
            height: 180px;
            background: url('https://via.placeholder.com/800x200') no-repeat center/cover;
            margin-bottom: 15px;
        }

        .description {
            color: white;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .carousel-container {
            width: 100%;
            max-width: 600px;
            background: white;
            padding: 10px;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .carousel {
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .carousel-images {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carousel img {
            width: 100%;
            height: 150px;
        }

        .footer {
            width: 100%;
            background: #064635;
            color: white;
            text-align: center;
            padding: 10px;
            position: relative;
            bottom: 0;
            left: 0;
        }
    </style>
</head>
<body>

    <!-- Barra Superior -->
    <div class="top-bar">
        <span class="menu-icon" onclick="toggleMenu()">☰</span>
        <h1><?php echo $title; ?></h1>
    </div>

    <!-- Menu Lateral -->
    <div class="sidebar" id="sidebar">
        <h2>Menu</h2>
        <a href="inicio.php" class="menu-item">Início</a>
        <a href="modalidades.php" class="menu-item">Modalidades</a>
        <a href="simuladores.php" class="menu-item">Simuladores</a>
        <a href="desdobramento.php" class="menu-item">Desdobramento</a>
        <a href="tabelas.php" class="menu-item">Tabelas</a>
    </div>

    <!-- Conteúdo Principal -->
    <div class="content" id="protectedContent">
        <div class="cover-photo"></div>
        <p class="description"><?php echo $description; ?></p>

        <h2 class="carousel-title">Destaques do Mark Point</h2>

        <!-- Carrossel -->
        <div class="carousel-container">
            <div class="carousel">
                <div class="carousel-images" id="carousel-images">
                    <?php foreach ($carousel_images as $image): ?>
                        <img src="<?php echo $image; ?>" alt="Imagem">
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <p class="carousel-description">Acompanhe nossas principais atualizações e novidades sobre loterias!</p>
    </div>

    <!-- Rodapé -->
    <div class="footer">
        © 2025 Mark Point - Todos os direitos reservados.
    </div>

<script type="module">
    import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-auth.js";
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-app.js";

    const firebaseConfig = {
        apiKey: "AIzaSyAO3As6jMMmENtzaK9zlDADbpS9UlNxx8o",
        authDomain: "mac-projeto-4e552.firebaseapp.com",
        projectId: "mac-projeto-4e552",
        storageBucket: "mac-projeto-4e552.appspot.com",
        messagingSenderId: "537330451519",
        appId: "1:537330451519:web:5a1b4c921119b5ee98e48a"
    };

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);

    onAuthStateChanged(auth, user => {
        if (user) {
            document.getElementById("protectedContent").style.display = "block";
        } else {
            window.location.href = "index.html";
        }
    });

    function toggleMenu() {
        document.getElementById("sidebar").classList.toggle("active");
    }

    let index = 0;
    function autoSlide() {
        const images = document.getElementById("carousel-images");
        index = (index + 1) % 3;
        images.style.transform = `translateX(${-index * 100}%)`;
    }
    setInterval(autoSlide, 3000);
</script>

</body>
</html>

