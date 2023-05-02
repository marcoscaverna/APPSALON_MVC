<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\ServicioController;
use Controllers\APIController;
use Controllers\CitaController;
use MVC\Router;
use Controllers\LoginController;
use Controllers\AdminController;

$router = new Router();


// INICIAR SESIÓN
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

// RECUPERAR PASSWORD
$router->get('/forgot', [LoginController::class, 'forgot']);
$router->post('/forgot', [LoginController::class, 'forgot']);
$router->get('/recover', [LoginController::class, 'recover']);
$router->post('/recover', [LoginController::class, 'recover']);

//CONFIRMAR CUENTA
$router->get('/confirm', [LoginController::class, 'confirm']);

$router->get('/mensaje', [LoginController::class, 'mensaje']);

// CREAR CUENTA
$router->get('/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/crear-cuenta', [LoginController::class, 'crear']);

// ÁREA PRIVADA
$router->get('/cita', [ CitaController::class, 'index']);
$router->get('/admin', [ AdminController::class, 'index']);

// API DE CITAS
$router->get('/api/servicios', [APIController::class, 'index']);
$router->post('/api/citas', [APIController::class, 'guardar']);
$router->post('/api/eliminar', [APIController::class, 'eliminar']);

// CRUD DE SERVICIOS
$router->get('/servicios', [ServicioController::class, 'index']);
$router->get('/servicios/crear', [ServicioController::class, 'crear']); //Muestra formulario
$router->post('/servicios/crear', [ServicioController::class, 'crear']); //Manda formulario
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']); //Muestra formulario
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']); //Manda formulario
$router->post('/servicios/eliminar', [ServicioController::class, 'eliminar']); //Manda formulario




// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();