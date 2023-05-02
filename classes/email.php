<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email; 
        $this->nombre = $nombre; 
        $this->token = $token; 
    }

    public function sendConfirm()
    {
        //Crear el objeto de email
            //Estos datos los busco en la página de mailtrap, en la parte de "integraciones" de mi inbox
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '7c2ef87ca7ca1e';
        $mail->Password = '3230b97d0b7f41';

        $mail->setFrom('cuentas@salon.com'); //la cuenta de correo remitente
        $mail->addAddress('cuentas@salon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta'; // El "asunto" del correo electrónico

            //Seteamos para que el mail sea HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

            // COntruimos el contenido del mail en una variable 
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "!</strong> Has creado tu cuenta en App Salón.</p>";
        $contenido .= "<p>Solo debes confirmarla presionando el siguiente enlace:</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirm?token="
        . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .= "</html>";

            //Una vez construida la variable de contenido, la asigno al atributo Body del objeto #mail
        $mail->Body = $contenido;

        //Envaimos el mail
        $mail->send();
    }

    public function recover()
    {
                //Crear el objeto de email
            //Estos datos los busco en la página de mailtrap, en la parte de "integraciones" de mi inbox
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '7c2ef87ca7ca1e';
            $mail->Password = '3230b97d0b7f41';
    
            $mail->setFrom('cuentas@salon.com'); //la cuenta de correo remitente
            $mail->addAddress('cuentas@salon.com', 'AppSalon.com');
            $mail->Subject = 'Restablecer contraseña'; // El "asunto" del correo electrónico
    
                //Seteamos para que el mail sea HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
    
                // COntruimos el contenido del mail en una variable 
            $contenido = "<html>";
            $contenido .= "<p><strong>Hola " . $this->nombre . "!</strong> Has solicitado reestablecer tu contraseña.</p>";
            $contenido .= "<p>Para hacerlo, presiona en el siguiente enlace: <a href='http://localhost:3000/recover?token="
            . $this->token . "'>Reestablecer contraseña</a></p>";
            $contenido .= "<p>Si tu no hiciste esta solicitud, puedes ignorar este mensaje</p>";
            $contenido .= "</html>";
    
                //Una vez construida la variable de contenido, la asigno al atributo Body del objeto #mail
            $mail->Body = $contenido;
    
            //Envaimos el mail
            $mail->send();
    }
}