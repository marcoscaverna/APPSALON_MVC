<h1 class="nombre-pagina">Crear nueva cita</h1>

<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
?>

<div  id="app">

    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Información cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input
                    id="nombre"
                    type="text"
                    placeholder="Tu nombre"
                    value="<?php echo $nombre; ?>"
                    disabled
                />
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input
                    id="fecha"
                    type="date"
                    min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                />
            </div>

            <!-- <div class="campo">
                <label for="hora">Hora</label>
                <input
                    id="hora"
                    type="time"
                 />
            </div> -->
            <div class="campo" >
                <label for="hora">Hora</label>
                <select name="hora" id="hora"/>
                    <option selected>--Seleccione--</option>
                    <?php foreach($horarios as $horario) { ?>
                        <option value="<?php echo s($horario); ?>"><?php echo s($horario); ?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h1>Resumen</h1>
        <p class="text-center">Verifica que la información sea correcta</p>
    </div>

    <div class="paginacion">
        <button
            id="anterior"
            class="boton"
        />&laquo; Anterior</button>
        <button
            id="siguiente"
            class="boton"
        />Siguiente &raquo;</button>
    </div>
</div>

    <!-- CARGA DE SCRIPT PARA PAGINAS ESPECÍFICAS -->
<?php
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
?>


