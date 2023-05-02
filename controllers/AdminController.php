<?php
    
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router) {
        session_start();

        isAdmin();

        // Tomamos la fecha de GET y si no existe usamos la fecha actual del servidor
        $fecha = $_GET['fecha'] ?? $fecha = date('Y-m-d');
        // Necesitamos convertir la fecha a un arreglo de enteros para poder usar la función checkdate
        // que lo que hace es comprobar que una fecha sea válidad (evitando que una modificación en la barra de direcciones tire error)
        $fechas = explode('-', $fecha); // Creamos otra variable así podemos usar la de $fecha para el query más abajo:
        // El orden de checkdate es mes, dia, año
        if (!checkdate($fechas[1], $fechas[2], $fechas[0])) {
            header('Location: /404');
        }

        //Consultar la base de datos
            // Veniamos trabajando con modelos y activerecord, pero el problema es que acá necesitamos acceder a varias tablas al mismo tiempo
            // así que tenemos que hacer una consulta específica. Más adelante aprenderé a hacer un querie builder
            $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
            $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
            $consulta .= " FROM citas  ";
            $consulta .= " LEFT OUTER JOIN usuarios ";
            $consulta .= " ON citas.usuarioId=usuarios.id  ";
            $consulta .= " LEFT OUTER JOIN citasServicios ";
            $consulta .= " ON citasServicios.citaId=citas.id ";
            $consulta .= " LEFT OUTER JOIN servicios ";
            $consulta .= " ON servicios.id=citasServicios.servicioId ";
            $consulta .= " WHERE fecha =  '{$fecha}' ";

            $citas = AdminCita::SQL($consulta);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}