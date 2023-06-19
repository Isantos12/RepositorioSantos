<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="css/cssPlantilla2/normalize.css" as="style">
    <link rel="stylesheet" href="web/css/cssPlantilla2/normalize.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Krub:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="preload" href="web/css/cssPlantilla2/style.css" as="style">
    <link href="web/css/cssPlantilla2/style.css" rel="stylesheet">
    <link rel="icon" type="image/jpg" href="web/img/imgPagina/logoBlanco.png" />
    <title>Around The World</title>
</head>

<body id="cuerpo">
    <header id="header">
        <div id="background2">
            
            <div class="cajaTitulo">
            <img src="web/img/imgPagina/logoBlanco.png" style="width: 100px; height:100px; position: absolute; top: 20px;" alt="" srcset="">
                <h1>Skysound 
                </h1>
               
                <?php MensajeFlash::imprimirMensajes() ?>
            </div>

            <div class="cajalogin">
                <?php if (isset($_SESSION['email'])): ?>
                    <h3>
                        <?= $_SESSION['email'] ?>
                    </h3>
                    <a href="index.php?action=logout"> Cerrar sesion</a>
                <?php else: ?>
                    <form action="index.php?action=login" method="post" id="formulariologin">
                            <input type="text" name="email" placeholder="email" class="form-control"><br>
                            <input type="password" name="password" placeholder="password" class="form-control"><br>
                            <button type="submit" value="login" class="btnForm">Iniciar Sesion</button><br>
                            <a href="index.php?action=registrar">¿No tienes cuenta?. <span>Registrate ahora.</span></a>
                    </form>
                </div>
            <?php endif; ?>
        </div>
        </div>

        <!--Aqui empeiza la barra de navegacion  -->
        <div class="nav-bg">
            <nav class="navegacion-principal contenedor">
                <a href="index.php?action=inicio">Inicio</a>
                <?php if (isset($_SESSION['email'])): ?>
                    <?php if ($_SESSION['rol'] == "user"): ?>
                        <a href="index.php?action=inicioMisListas">Mis Playlist</a>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['email']) && $_SESSION['rol'] == "admin"): ?>
                    <a href="index.php?action=admin_area">Admin Area</a>
                <?php endif; ?>
                <a href="index.php?action=sobreMi">Sobre Mi</a>
            </nav>
        </div>





    </header>
    <!-- Fin a la barra de navegacion -->

    <!-- Contido de la imagen principal de la pagina -->
    <section id="hero" class="cuerpoPrincipal">
        <div class="contenido-cuerpoPrincipal">
            <h2>Around <span> The world</span></h2>
            <div class="ubicacion">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin" width="88"
                    height="88" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFC107" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <circle cx="12" cy="11" r="3" />
                    <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 0 1 -2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0z" />
                </svg>
                <p>Alcazar De San Juan , Ciudad Real</p>
            </div>
        </div>
    </section>
    <!-- Fin de la seccion de la imagen principal de la pagina -->

    <!-- Inicio de la pagina Principal -->
    <main class="contenedor sombra">
        
        <?php MensajeFlash::imprimirMensajes() ?>
        <?php print $vista; ?>
    </main>
    <footer class="footer">
        <p>Todos los derechos reservados. Inmaculada Santos</p>
    </footer>



</body>

</html>