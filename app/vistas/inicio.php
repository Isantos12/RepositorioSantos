<?php
ob_start();
?>  
<h3 style="font-size: 6rem; background-color: #EBCB57;"><i>Playlists</i></h3>

    <?php if(isset($_SESSION['email'])) { ?>
        <a href="index.php?action=insertar_lista" class="btn btn-info">Insertar Nuevo Lista</a>
    <?php } ?>
    <?php foreach ($listas as $a): ?>
    <div class="servicio">
        <?php foreach ($fotos as $f) { ?>
                <?php if($a->getidLista() == $f->getidLista()){ ?>
                    <div class="iconos">
                        <div class="cajaImagen">
                            <img src="<?= $f->getFoto()?>" width="197px" height="197px" alt="alt"/>
                        </div>
                    </div>
                <?php } ?> 
            <?php } ?>
        <div class="cajadatos">                  
            <div class="titulo"><a href="index.php?action=vista_listas&id=<?= $a->getidLista() ?>"><h3><?= $a->getTitulo() ?></h3></a></div>
            <p><?= $a->getFechaDelEvento() ?><br><?= $a->getDescripcion() ?></p>

            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == "admin"): ?>
                <p>Creador de la lista: <?= $a->nombre_usuario ?></p>
            <?php endif; ?>

            
        </div>
        <?php if ((isset($_SESSION['email']) && $_SESSION['idUsuario'] == $a->getIdUsuario()) || (isset($_SESSION['rol']) && $_SESSION['rol'] == "admin")) : ?>

            
            <div class="cajabotones">
                <div class="tituloCajaBotones">
                    <h2>Opciones Playlist</h2>
                </div>
                <div class="borrar"><a href="index.php?action=borrar_lista&id=<?= $a->getidLista() ?>"><img src="web/img/eliminar.png" alt="lapizEditar"></a></div>
                <div class="editar"><a href="index.php?action=modificar_lista&id=<?= $a->getidLista() ?>"><img src="web/img/lapiz.png" alt="lapizEditar"></a></div>
            </div>
        <?php endif; ?>
    </div><br>
    <?php endforeach; ?>
    






<?php
$vista = ob_get_clean();
require 'app/vistas/plantilla2.php';
