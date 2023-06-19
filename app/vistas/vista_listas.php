<?php
ob_start();
?>
<div class="contenedorMisListas">

    <?php foreach ($listas as $l) { ?>
        <div class="playlist-grid">
            <?php foreach ($fotos as $f) { ?>
                <?php if ($l->getidLista() == $f->getidLista()) { ?>

                    <div class="imagen-playlist">
                        <img src="<?= $f->getFoto() ?>" width="200px" height="200px" alt="alt" />
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="info-tabla-wrapper">
                <div class="info-playlist">
                    <div class="titulo">
                        <h2>
                            Titulo Playlist: <span style="font-size: 4rem;">
                                <?= $l->getTitulo() ?>
                            </span>
                        </h2>
                    </div>
                    <div class="titulo">
                        <h4>Fecha del Evento <br>
                            <?= $l->getFechaDelEvento() ?>
                        </h4>
                    </div>
                    <div class="titulo">Descripcion <br>
                        <?= $l->getDescripcion() ?>
                    </div>
                </div>

                <div class="tabla">

                    <table class="tablaCanciones" id="tablaCanciones">

                        <tr>

                            <th>Titulo</th>

                            <th>Momento</th>

                            <th>Notas</th>

                            <th>Archivo</th>

                            <th>Opciones</th>

                        </tr>

                        <?php foreach ($canciones as $c) { ?>
                            <?php if ($l->getidLista() == $c->getidLista()) { ?>
                                <tr>

                                    <td>
                                        <?= $c->getTitulo() ?>
                                    </td>

                                    <td>
                                        <?= $c->getMomento() ?>
                                    </td>

                                    <td>
                                        <?= wordwrap($c->getNotas(), 13, "<br>", true) ?>
                                    </td>


                                    <td>
                                        <audio id="m" src="<?= $c->getRuta() ?>" controls="" controlslist="nodownload"></audio>
                                        <!--<br>
                <?= $c->getRuta() ?>
            -->
                                    </td>

                                    <td>
                                        <a href="#" class="borrar-cancion" data-cancion-id="<?= $c->getIdCancion() ?>">Borrar</a>

                                    </td>

                                </tr>
                            <?php } ?>
                        <?php } ?>

                    </table>

                </div>
            </div>
        </div>
    <?php } ?>

    <?php if (isset($_SESSION['email']) && isset($_SESSION['rol']) && ($_SESSION['idUsuario'] == $l->getIdUsuario() || $_SESSION['rol'] == 'admin')) { ?>
        <div class="cajaInsertarCancion">
            <!-- Formulario para añadir mensajes por AJAX-->
            <br><br>
            <div style="padding: 10px;">
                <h3>Añadir cancion por Ajax</h3>
                <input type="text" name="titulo" id="titulo" placeholder="Título de la cancion" class="form-control">
                <input type="text" name="momento" id="momento" placeholder="Momento de la cancion" class="form-control">
                <input type="text" name="notas" id="notas" placeholder="Notas a tener en cuenta" class="form-control">
                <input type="file" name="cancion" id="cancion">

                <button type="button" id="botonInsertarCancion" value="Insertar Cancion" class="btn btn-primary">Insertar
                    Cancion</button>
            </div>
        </div>
    <?php } ?>

</div>

<script type="text/javascript">
    $(document).ready(function () {
    $('#botonInsertarCancion').click(function () {
        var urlParams = new URLSearchParams(window.location.search);
        var idLista = urlParams.get('id');

        var titulo = $('#titulo').val();
        var momento = $('#momento').val();
        var notas = $('#notas').val();
        var cancion = $('#cancion').prop('files')[0];

        var formData = new FormData();
        formData.append('idLista', idLista);
        formData.append('titulo', titulo);
        formData.append('momento', momento);
        formData.append('notas', notas);
        formData.append('cancion', cancion);

        $.ajax({
            url: 'index.php?action=anadir_cancion_2',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.resultado) {
                    location.reload();
                } else {
                    alert('Error al insertar la canción: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.log(error, status, xhr);
                alert('Error en la llamada AJAX: ' + error);
            }
        });
    });

    $('.borrar-cancion').click(function (e) {
        e.preventDefault();

        var cancionId = $(this).data('cancion-id');

        $.ajax({
            url: 'index.php?action=borrar_cancion_Ajax',
            type: 'POST',
            data: { cancionId: cancionId },
            success: function (response) {
                if (response.resultado) {
                    location.reload();
                } else {
                    console.log(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    });
});

</script>

<?php
$vista = ob_get_clean();
require 'app/vistas/plantilla2.php';
