<?php
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modificar Lista</title>
</head>
<body>
<h1>Actualizar Lista</h1>
<form action="index.php?action=modificar_lista&id=<?= $id ?>" method="post">
    <div class="mb-3">
        <label for="pass" class="form-label">Titulo</label>
        <input type="text" class="form-control" name="titulo" value="<?= $listas->getTitulo() ?>">
    </div>
    <div class="mb-3">
        <label for="pass" class="form-label">Fecha del Evento</label>
        <input type="date" class="form-control" name="fechaDelEvento" value="<?= $listas->getFechaDelEvento() ?>">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Descripcion</label>
        <textarea class="form-control" name="descripcion"><?= $listas->getDescripcion() ?></textarea>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-3" name="Enviar">Enviar</button>
    </div>
    <h3>Insertar Foto</h3>
    <div class="mb-3">
        <input type="file" id="input_file" style="display: none">
    </div>
</form>
<div id="fotosMensaje">
    <button id="addImagen" class="btn btn-primary" <?= ($fotos ? 'disabled' : '') ?>>Añadir foto</button>
    <?php foreach ($fotos as $foto): ?>
        <div>
            <div class="imagen" id="<?= $foto->getIdFoto() ?>" foto-id="<?= $foto->getIdFoto() ?>">
                <img src="<?= $foto->getFoto() ?>" style="height: 100px; width: 130px; cursor: pointer;">
            </div>
            <div style="width: 2px; height: 2px;" class="borrar_ajax" data-id="<?= $foto->getIdFoto() ?>">
                <img src="web/img/eliminar.png" style="width: 30px;" alt="" srcset="">
            </div>
        </div>
        <br>
    <?php endforeach; ?>
</div>

<script type="text/javascript">
    document.getElementById('addImagen').addEventListener("click", function (e) {
    document.getElementById("input_file").click(); // Hacemos clic sobre el input type=file oculto
});

document.getElementById('input_file').addEventListener("change", function () {
    const url = 'index.php?action=modificarfoto_lista&id=<?= $id ?>';
    let data = new FormData();
    data.append('foto', document.getElementById('input_file').files[0]);
    fetch(url, { method: "POST", body: data, credentials: 'same-origin' })
        .then(respuesta => {
            return respuesta.json();
        })
        .then(json => {
            let fotoNueva = document.createElement("img");
            fotoNueva.setAttribute('src', json.foto);
            fotoNueva.style = "height:100px; widht:100px";

            let fotosMensaje = document.getElementById('fotosMensaje');

            // Eliminar la imagen antigua (si existe)
            let imagenAntigua = fotosMensaje.querySelector('img');
            if (imagenAntigua) {
                fotosMensaje.removeChild(imagenAntigua);
            }

            // Agregar la nueva imagen al contenedor
            fotosMensaje.prepend(fotoNueva);

            // Deshabilitar el botón "Añadir foto"
            document.getElementById('addImagen').setAttribute('disabled', 'disabled');
        })
        .catch(error => {
            console.error(error);
        });
});


    let enlaces_borrar = document.getElementsByClassName("borrar_ajax");
    for (let i = 0; i < enlaces_borrar.length; i++) {
        enlaces_borrar[i].addEventListener("click", borrar_foto_ajax);
    }

    function borrar_foto_ajax() {

        const url = "index.php?action=borrar_foto_ajax&idfoto=" + this.getAttribute("data-id");
        fetch(url)
            .then((respuesta) => respuesta.json())
            .then((json) => {
                if (json.borrado) {
                    this.parentElement.remove();

                    // Habilitar el botón "Añadir foto" si no hay más fotos
                    let fotos = document.getElementsByClassName("imagen");
                    if (fotos.length === 0) {
                        document.getElementById('addImagen').removeAttribute('disabled');
                    }
                } else {
                    alert("Error al borrar el mensaje");
                }
            })
            .catch((error) => {
                console.error("Error: " + error);
            });
    };
</script>
</body>
</html>

<?php
$vista = ob_get_clean();

require 'app/vistas/plantilla2.php';
