<?php

namespace Model;

class Usuario extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];


    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct( $args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    //Mensajes de validación para la creación de cuentas
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del usuario es obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El apellido del usuario es obligatorio';
        }
        if(!$this->telefono) {
            self::$alertas['error'][] = 'El telefono del usuario es obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El e-mail del usuario es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña del usuario es obligatoria';
        }
        if(strlen($this->password) < 8) {
            self::$alertas['error'][] = 'La contraseña debe tener al menos 8 caracteres';
        }

        return self::$alertas;
    }

    //Función para revisar si el usuario ya existe o no
    public function existeUsuario() {
        //CONSULTAMOS EN LA TABLA POR UN REGISTRO DONDE EL EMAIL COINCIDA CON EL DEL OBJETO ACTIVERECORD
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows > 0) {
            self::$alertas['error'][] = 'El usuario ya está registrado o el email está en uso';
        }
        
        return $resultado;
    }

    //Hasheado de password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    public function generarToken() {
        $this->token = uniqid();
    }
    public function comprobarPasswordAndVerificar($password)
    {
        $resultado = password_verify($password, $this->password);

        if(!$resultado || !$this->confirmado)
        {
            self::$alertas['error'][] = 'La contraseña es incorrecta o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }
    }

    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'Ingresa tu correo electrónico';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'Ingresa tu password';
        }

        return self::$alertas;
    }

    public function validarEmail()
    {
        if(!$this->email)
        {
            $alertas['error'][] = 'Ingresa tu correo electrónico';
        }
        return self::$alertas;
    }

    public function validarPass()
    {
        if(!$this->password || strlen($this->password) < 8)
        {
            self::$alertas['error'][] = 'Debes crear una contraseña con al menos 8 caracteres';
        }
        return self::$alertas;
    }

}