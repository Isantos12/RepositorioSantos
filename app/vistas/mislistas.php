<?php
ob_start();
?>

    <h3 style="font-size: 6rem; background-color: #EBCB57;"><i>Mis Playlists</i></h3>
        <?php foreach ($listas as $li) :
            if(isset($_SESSION['email']) && $_SESSION['idUsuario'] == $li->getIdUsuario()) :?>
        <div class="cajaMisListas">
        <?php foreach ($fotos as $f) { ?>
                <?php if($li->getidLista() == $f->getidLista()){ ?>
                        <div><img src="<?= $f->getFoto()?>" width="200px" height="200px" alt="alt"/></div>
                <?php } ?> 
            <?php } ?> 
            <div class="detalles">
                <div class="detalleMis"><h2><?= $li->getTitulo() ?></h2></div>
                <div class="detalleMis"><h4><?= $li->getFechaDelEvento() ?></h4></div>
                <div class="detalleMis"><?= $li->getDescripcion() ?></div>
            </div>
                
            <?php endif;?>
        </div><br>
        <?php endforeach;?>
                
<?php
$vista = ob_get_clean();
require 'app/vistas/plantilla2.php';