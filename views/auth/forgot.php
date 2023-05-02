<h1 class="nombre-pagina">¿Olvidaste tu contraseña?</h1>
<p class="descripcion-pagina">Reestablece tu contraseña indicando tu e-mail</p>

<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" method="POST" action="/forgot">
    <div class="campo">
        <label for="email">Tu e-mail</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="Tu e-mail"
        />
    </div>
    <input class="boton" type="submit" value="Enviar instrucciones">

</form>

<p class="cartel-explicativo" >Recibirás un mensaje en tu casilla de correo con las indicaciones para reestablecer tu contraseña</p>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una</a>
</div>