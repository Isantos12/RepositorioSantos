<?php ob_start(); ?>

<h3 style="font-size: 6rem; background-color: #EBCB57;"><i>Zona Admin</i></h3>

<!-- Dentro de la sección correspondiente en la vista admin_area.php -->
<div class="cajaAdmin">
    <table id="tablaUsuarios">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td>
                        <?php echo $usuario->getId(); ?>
                    </td>
                    <td>
                        <?php echo $usuario->getNombre(); ?>
                    </td>
                    <td>
                        <?php echo $usuario->getEmail(); ?>
                    </td>
                    <td>
                        <?php echo $usuario->getRol(); ?>
                    </td>
                    <td>
                        <!-- Opciones: Editar y Eliminar -->
                        <a href="#modalEditarUsuario" class="editar-usuario" data-id="<?php echo $usuario->getId(); ?>">Editar</a>
                        <a href="#" class="eliminar-usuario" data-id="<?php echo $usuario->getId(); ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="modalEditarUsuario" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Editar Usuario</h3>
        <form id="formularioEditarUsuario">
            <!-- Campos de edición -->
            <input type="hidden" name="idUsuario" value="">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="">

            <label for="email">Email:</label>
            <input type="email" name="email" value="">

            <label for="rol">Rol:</label>
            <input type="text" name="rol" value="">

            <button type="submit">Guardar cambios</button>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    var tablaUsuarios = $('#tablaUsuarios');

    tablaUsuarios.on('click', '.eliminar-usuario', function(e) {
        e.preventDefault();
        var idUsuario = $(this).data('id');

        if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
            $.ajax({
                url: 'index.php?action=borrar_usuario_Ajax',
                method: 'POST',
                data: { idUsuario: idUsuario },
                dataType: 'json',
                success: function(response) {
                    alert(response.mensaje);
                    // Cargar de nuevo la tabla de usuarios
                    tablaUsuarios.load('index.php?action=admin_area #tablaUsuarios');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });

    // Resto del código...

    // Variables para el modal y el formulario de edición de usuario
    var modalEditarUsuario = $('#modalEditarUsuario');
    var formularioEditarUsuario = $('#formularioEditarUsuario');
    var closeModal = $('.close');

    tablaUsuarios.on('click', '.editar-usuario', function(e) {
        e.preventDefault();
        var idUsuario = $(this).data('id');

        // Limpiar los valores del formulario de edición
        formularioEditarUsuario[0].reset();

        // Actualizar el valor del campo idUsuario oculto
        formularioEditarUsuario.find('input[name="idUsuario"]').val(idUsuario);

        // Obtener los datos del usuario mediante una petición AJAX
        $.ajax({
            url: 'index.php?action=obtener_usuario_Ajax',
            method: 'POST',
            data: { idUsuario: idUsuario },
            dataType: 'json',
            success: function(response) {
                if (response.hasOwnProperty('usuario')) {
                    var usuario = response.usuario;
                    // Actualizar los valores en el formulario de edición
                    formularioEditarUsuario.find('input[name="nombre"]').val(usuario.nombre);
                    formularioEditarUsuario.find('input[name="email"]').val(usuario.email);
                    formularioEditarUsuario.find('input[name="rol"]').val(usuario.rol);
                    // Mostrar el modal de edición de usuario
                    modalEditarUsuario.show();
                } else {
                    console.error('No se pudo obtener los datos del usuario');
                    alert('No se pudo obtener los datos del usuario');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Ocurrió un error al obtener los datos del usuario');
            }
        });
    });

    closeModal.click(function() {
        modalEditarUsuario.hide();
    });

    $(window).click(function(event) {
        if (event.target == modalEditarUsuario[0]) {
            modalEditarUsuario.hide();
        }
    });

    formularioEditarUsuario.submit(function(e) {
        e.preventDefault();

        // Obtener los valores del formulario de edición
        var idUsuario = formularioEditarUsuario.find('input[name="idUsuario"]').val();
        var nombre = formularioEditarUsuario.find('input[name="nombre"]').val();
        var email = formularioEditarUsuario.find('input[name="email"]').val();
        var rol = formularioEditarUsuario.find('input[name="rol"]').val();

        // Realizar la petición AJAX para editar el usuario
        $.ajax({
            url: 'index.php?action=editar_usuario_Ajax',
            method: 'POST',
            data: {
                idUsuario: idUsuario,
                nombre: nombre,
                email: email,
                rol: rol
            },
            dataType: 'json',
            success: function(response) {
                if (response.hasOwnProperty('mensaje')) {

                    // Cargar de nuevo la tabla de usuarios
                    tablaUsuarios.load('index.php?action=admin_area #tablaUsuarios');
                    // Cerrar el modal
                    modalEditarUsuario.hide();
                } else if (response.hasOwnProperty('error')) {
                    console.error(response.error);
                    alert('No se pudo editar el usuario');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Ocurrió un error al editar el usuario');
            }
        });
    });
});
</script>

<?php
$vista = ob_get_clean();
require 'app/vistas/plantilla2.php';
