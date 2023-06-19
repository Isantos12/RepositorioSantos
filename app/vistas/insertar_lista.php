<?php 
ob_start();
?>   
<h1>Insertar Nuevo Lista</h1>
        <form action="index.php?action=insertar_lista" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <input class="form-control" type="text" name="titulo" placeholder="titulo"><br>
        </div>
        <div class="mb-3">
            <textarea class="form-control" name="descripcion" placeholder="descripcion"></textarea><br>
        </div>
        <div class="mb-3">
            <input class="form-control" type="date" name="fechaDelEvento" placeholder="Fecha del Evento"><br>
        </div>
        <div class="mb-3">
            <input class="form-control" type="file" name="foto" required><br>
        </div>
        <div class="col-auto">
            <input class="btn btn-primary mb-3" class="form-control" type="submit" value="insertar">
        </div>
        </form>


<?php
$vista =  ob_get_clean(); 

require 'app/vistas/plantilla2.php';
