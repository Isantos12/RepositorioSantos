<!DOCTYPE html>
<html lang="en" style="height: 100%;">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="css/cssPlantilla2/normalize.css" as="style">
    <link rel="stylesheet" href="web/css/cssPlantilla2/normalize.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Krub:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="preload" href="web/css/cssPlantilla2/style.css" as="style">
    <link href="web/css/cssPlantilla2/style.css" rel="stylesheet">
    <link rel="icon" type="image/jpg" href="web/img/imgPagina/logoBlanco.png" />
    <title>Around The World</title>

    <style>
        #email_check{
                color:blue;
                display: none;
            }
            #email_error{

                color:red;
                display:none;
            }
            #preloader{
                display:none; 
                height: 20px; 
                width: 20px

            }
        .caja {
            margin-top: 5%;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .formRegister {
            width: 50%;
        }

        .cajaYatienesCuenta {
            background-color: azure;
            border: 2px dotted blueviolet;
            border-radius: 60%;
            display: flex;
            margin: 5px;
            padding: 10px;
            align-items: center;
            justify-content: center;
        }

        .border {
            border: 20px solid #f973d2;
        }
    </style>
</head>

<body id="cuerpo">
    <header id="header">
        <div id="background2">
            <div class="cajaTitulo">
            <img src="web/img/imgPagina/logoBlanco.png" style="width: 100px; height:100px; position: absolute; top: 10px;" alt="" srcset="">
                <a href="index.php?action=inicio" style="text-decoration: none; color:black">
                
                    <h1>Skysound </h1>
                </a>
                <?php MensajeFlash::imprimirMensajes() ?>
            </div>
            <div class="cajaYatienesCuenta">
                <a href="index.php?action=inicio" style="text-decoration: none">
                    <h2 style="color: blueviolet;">¡Ya tengo cuenta! <br>Vuelta a Inicio</h2>
                </a>

            </div>
        </div>
        </div>
        <!--Aqui empeiza la barra de navegacion  -->
        <div class="border"></div>

    </header>

    <!-- Inicio de la pagina Principal -->
    <main class="contenedor sombra" style="margin-top: 2%;height: 500px;">

        <div class="caja">
            <div class="formRegister">
                <h1>Crear Cuenta</h1>
                <form action="index.php?action=registrar" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input class="form-control" type="text" name="email" placeholder="email" value="<?= $email ?>"
                            id="email">
                        <i class="fa-solid fa-check" id="email_check">Email no repetido</i>
                        <i class="fa-solid fa-xmark" id="email_error">Email repetido</i>
                        <div id="preloader" class="spinner-border" role="status"></div>
                    </div>

                    <div class="mb-3">
                        <input class="form-control" type="password" name="password" placeholder="password"
                            value="<?= $password ?>">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="text" name="nombre" placeholder="nombre"
                            value="<?= $nombre ?>">
                    </div>
                    <div class="mb-3">
                        <input class="btn btn-primary mb-3" type="submit" value="registrar">
                    </div>
                </form>
            </div>

        </div>

    </main>

    <footer class="footer">
        <p>Todos los derechos reservados. Inmaculada Santos</p>
    </footer>


    <script type="text/javascript">

        document.getElementById('email').addEventListener("change", () => {
            //Inicialimazos variables
            let data = new FormData();
            data.append("email", document.getElementById("email").value);
            let url = "index.php?action=comprobar_email";
            let init = {
                method: 'POST',
                body: data
            };

            //Mostramos el preloader y ocultamos el tick y la cruz
            document.getElementById("preloader").style.display = "inline-block";
            document.getElementById("email_check").style.display = "none";
            document.getElementById("email_error").style.display = "none";

            //Iniciamos la conexión AJAX
            fetch(url, init)
                .then((respuesta) => {
                    return respuesta.json();
                })
                .then((json) => {
                    //Ocultamos el preloader
                    document.getElementById("preloader").style.display = "none";
                    /* aquí manejamos el json*/
                    console.log(json);
                    if (json.repetido) {
                        document.getElementById("email_error").style.display = "inline";

                    } else {
                        document.getElementById("email_check").style.display = "inline";
                    }
                })
                .catch((error) => {
                    //Ocultamos el preloader
                    document.getElementById("preloader").style.display = "none";
                    //Mostramos el error por la consola
                    console.error(error);   //Captura errores de conexión de red
                });
        });

    </script>


</body>

</html>