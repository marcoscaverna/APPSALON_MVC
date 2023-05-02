<h1 class="nombre-pagina" >Reestablecer contraseña</h1>

<p class="descripcion-pagina">Ingresa tu nueva contraseña a continuación</p>

<?php
    include_once __DIR__ . "/../templates/alertas.php"
?>

<!-- <?php if($errorToken) return; ?> DETENEMOS LA CARGA DEL RESTO DEL HTML CON EL RETURN -->
    <form class="formulario" method="POST">
        <div class="campo">
            <label for="password">Contraseña: </label>
            <input 
                type="password"
                id="password"
                name="password"
                placeholder="Escribe tu nueva contraseña"
                />
        </div>
        <input type="submit" class="boton" value="Guardar contraseña">

    </form>

    <div class="acciones">
        <a href=""></a>
    </div>
