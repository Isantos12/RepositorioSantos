<?php
ob_start();
?>  
<h3 style="font-size: 6rem; background-color: #EBCB57;"><i>Sobre mi</i></h3>


    
<div class="pdf" style="width: 100%; height: 1000px" >
<object data="web/pdf/Inmaculada S.N_CV2023.pdf" height="100%" width="100%"></object>
</div>





<?php
$vista = ob_get_clean();
require 'app/vistas/plantilla2.php';