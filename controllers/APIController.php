<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use MVC\Router;
use Model\Servicio;

class APIController
{
    public static function index()
    {
        $servicios = Servicio::all();
        $serviciosJson = json_encode($servicios);
        echo $serviciosJson;
    }

    public static function guardar()
    {
        //Almacena la cita y devuelve el Id de la misma (Lo usamos después para guardar los servicios asociados a la cita en la otra tabla)
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];


        // Almacena los registros de cita y servicios asociados
        $arrayServicios = explode(',', $_POST['servicios']); //Debemos convertir en array, porque es una string (PORQUE?)
        foreach($arrayServicios as $idServicio) //Iteramos sobre los servicios y creamos un registro para cada uno con la Id de la cita
        {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar() {
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location: ' . $_SERVER['HTTP_REFERER']); //Esto nos manda a la página de donde veníamos
        }
    }
}

