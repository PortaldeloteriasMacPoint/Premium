<?php
    // Exemplo de variável PHP que pode ser dinâmica
    $title = " ✨🗣️ Mac Point";
    $description = "Bem-vindo à plataforma "Portal de Loterias- Mac Point" . Aqui você encontra tudo sobre loterias!";
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
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Layout Responsivo */
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

        /* Título na borda superior */
        .top-bar h1 {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        /* Ícone do menu */
        .menu-icon {
            font-size: 30px;
            color: white;
            cursor: pointer;
        }

        /* Menu Lateral */
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

        .sidebar h2 {
            text-align: center;
            margin-bottom: 15px;
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
            cursor: pointer;
            text-align: center;
            border-radius: 8px;
        }

        .menu-item:hover {
            background: #2C6E49;
        }

        /* Submenu */
        .submenu {
            display: none;
            background: white;
            padding: 5px;
            margin: 5px 10px;
            border-radius: 5px;
        }

        .submenu a {
            display: block;
            padding: 8px;
            color: black;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }

        .submenu a:last-child {
            border-bottom: none;
        }

        .submenu a:hover {
            background: #ddd;
        }

        /* Conteúdo Principal */
        .content {
            width: 90%;
            max-width: 800px;
            margin-top: 80px;
            text-align: center;
            flex: 1;
        }

        /* Foto de Capa */
        .cover-photo {
            width: 100%;
            height: 180px;
            background: url('https://via.placeholder.com/800x200') no-repeat center/cover;
            margin-bottom: 15px;
        }

        /* Descrição */
        .description {
            color: white;
            font-size: 18px;
            margin-bottom: 20px;
        }

        /* Título antes do carrossel */
        .carousel-title {
            color: white;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Carrossel */
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

        /* Descrição após o carrossel */
        .carousel-description {
            color: white;
            font-size: 16px;
            margin-top: 10px;
        }

        /* Rodapé fixo no final */
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

    <!-- Borda Superior -->
    <div class="top-bar">
        <span class="menu-icon" onclick="toggleMenu()">☰</span>
        <h1><?php echo $title; ?></h1>
    </div>

    <!-- Menu Lateral -->
    <div class="sidebar" id="sidebar">
        <h2> Menu</h2>
        <a href="inicio.php" class="menu-item">Início</a>
        <a href="modalidades.php" class="menu-item">Modalidades</a>
        <a href="#" class="menu-item" onclick="toggleSubmenu()">Análise Estatística ▼</a>
        <div class="submenu" id="submenu">
            <a href="grupo_soma.php">Grupo de Soma</a>
            <a href="grupo_bichos.php">Grupo dos Bichos</a>
            <a href="fibonacci.php">Fibonacci</a>
            <a href="numero_espinhos.php">Número de Espinhos</a>
        </div>
        <a href="simuladores.php" class="menu-item">Simuladores</a>
        <a href="desdobramento.php" class="menu-item">Desdobramento</a>
        <a href="tabelas.php" class="menu-item">Tabelas</a>
    </div>

    <!-- Conteúdo Principal -->
    <div class="content">
        <div class="cover-photo"></div>
        <p class="description"><?php echo $description; ?></p>

        <!-- Título do Carrossel -->
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

        <!-- Descrição após o Carrossel -->
        <p class="carousel-description">Acompanhe nossas principais atualizações e novidades sobre loterias!</p>
    </div>

    <!-- Rodapé -->
    <div class="footer">
        © Copyright  2025 - O Portal de Loterias Mac Point é uma plataforma independente,não possui vínculo a Caixa Econômica Federal / Todos os direitos reservados.
    </div>

    <script>
        function toggleMenu() {
            var sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("active");
        }

        function toggleSubmenu() {
            var submenu = document.getElementById("submenu");
            submenu.style.display = submenu.style.display === "block" ? "none" : "block";
        }

        document.addEventListener("click", function (event) {
            var sidebar = document.getElementById("sidebar");
            var menuIcon = document.querySelector(".menu-icon");

            if (!sidebar.contains(event.target) && !menuIcon.contains(event.target)) {
                sidebar.classList.remove("active");
            }
        });

        // Carrossel Automático
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

