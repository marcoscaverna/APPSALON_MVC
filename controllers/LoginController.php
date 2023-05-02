<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) { // Para mostrar la vista necesitamos instanciar el Router
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas))
            {
                //Verificamos que exista el usuario
                $usuario = Usuario::where('email', $auth->email);
                if($usuario)
                {
                    // Verificamos contraseña
                    if( $usuario->comprobarPasswordAndVerificar($auth->password) )
                    {
                        // Autenticar el usuario
                        // Lo hacemos con variables de sesión
                        session_start(); // Una vez que iniciamos sesión tenemos acceso la variable superglobal  $_SESSION
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . ' ' . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionamiento
                        if($usuario->admin === '1')
                        {
                            $_SESSION['admin'] = $usuario->admin ?? null; // El usuario es admin, le pasamos el valor admin a la supervariable de la session
                            header( 'Location: /admin');
                        } else {
                            header( 'Location: /cita');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout() {
        
        session_start();

        //Vaciamos el arreglo de sessión
        $_SESSION = [];
        // Y finalmente lo mandamos a casa
        header('Location: /');
    }

    public static function forgot(Router $router) {
        
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas))
            {
                //verificamos que el usuario exista
                $usuario = Usuario::where('email', $auth->email);
                if(!$usuario || !($usuario->confirmado === '1'))
                {
                    Usuario::setAlerta('error', 'El usuario no existe o no está confirmado.<br> Ingrese un correo válido o cree y confirme una cuenta nueva');
                } else {
                    Usuario::setAlerta('exito', 'Se ha enviado un mensaje a tu casilla de correo para recuperar la contraseña');
                    // Generamos un token nuevo
                    $usuario->generarToken();
                    $usuario->guardar();

                    //Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->recover();
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/forgot', [
            'alertas' => $alertas
        ]);
    }

    public static function recover(Router $router) {
        
        $alertas = [];
        $errorToken = false;
        $token = s($_GET['token']);

        //Buscar usuario por su token
        $usuario = Usuario::where('token', $token);
        //Devolver error si el token no existe
        if(empty($usuario))
        {
            Usuario::setAlerta('error', 'Token no válido o expirado');
            $errorToken = true;
        }

        // Leer el nuevo password y guardarlo
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $password = new Usuario($_POST);
            $alertas = $password->validarPass();

            if(empty($alertas))
            {
                //Borramos el password anterior
                $usuario->password = null;
                $password->hashPassword();

                $usuario->password = $password->password;
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado)
                {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recover', [
            'alertas' => $alertas,
            'errorToken' => $errorToken
        ]);
    }

    public static function crear(Router $router) {
        //Debemos realizar todo tipo de comprobaciones para ver que el nombre de usuario no este duplicado y demás
            // Instanciamos la clase usuario:
            $usuario = new Usuario;
            // Alertas vacias
            $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //Revisar que alertas esté vacío
            if(empty($alertas)) {
                //Revisar que el usuario no esté ya registrado o el email no esté en uso
                    //llamamos a la función de existe usuario y asignamos el resultado a una nueva variable
                $resultado = $usuario->existeUsuario();
                    //Chequeamos si la variable contiene registro
                if($resultado->num_rows > 0) {
                    //volvemos a crear la variable alertas para pasarle nuevos mensajes
                    $alertas = Usuario::getAlertas();
                } else {
                    //No está registrado

                        //Hashear pass
                    $usuario->hashPassword();

                        // Generar un token único
                    $usuario->generarToken();

                        // Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->sendConfirm();

                    $resultado = $usuario->guardar();
                    
                    if($resultado) {
                        header('Location: /mensaje');
                    }

                    // debuguear($email);
                }
            }
        }
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }

    public static function confirm(Router $router)
    {
        $alertas = [];

        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if(empty($usuario))
        {
            //guardamos alerta en el modelo (porque en el modelo? APRENDER ESTO)
            Usuario::setAlerta('error', 'El token de confirmación no es válido');
        } else {
            // Confirmamos usuario (modificamos el registro en la bd para que la colum confirmado sea true (o 1))
            $usuario->confirmado = 1;
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Has confirmado tu cuenta! Inicia sesión para continuar');
        }
        //obtener alertas desde el modelo
        $alertas = Usuario::getAlertas();
        //renderizar la vista
        $router->render('auth/confirm', [
            'alertas' => $alertas
        ]);
    }
}