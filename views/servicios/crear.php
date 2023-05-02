<h1 class="nombre-pagina">Crear servicio</h1>
<p class="descripcion-pagina">Crear un nuevo servicio llenando el formulario</p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" action="/servicios/crear" method="POST">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" class="boton" value="Guardar Servicio">
</form>