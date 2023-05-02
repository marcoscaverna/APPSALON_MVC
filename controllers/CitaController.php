<?php

namespace Controllers;

use MVC\Router;

class CitaController
{

    public static function index( Router $router )
    {
        session_start();

        //revisamos si está autenticado antes de renderizar la vista
        isAuth();

        $nombre = $_SESSION['nombre'];
        $id = $_SESSION['id'];
        $horarios = [ '07:30', '08:00', '08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30',];

        $router->render('/cita/index', [
            'nombre' => $nombre,
            'id' => $id,
            'horarios' => $horarios
        ]);
    }
}