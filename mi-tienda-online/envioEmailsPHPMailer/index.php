<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function enviarEmail($email, $nombreUsuario)
{
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'cuentaproyectophp@gmail.com';                     //SMTP username
        $mail->Password = 'w i m v l c d y o u y d k u v s';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('cuentaproyectophp@gmail.com', 'Pandaghini');
        $mail->addAddress($email, 'Gabriel');     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Creacion de usuario correcta';
        $mail->Body = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: hsl(0, 0%, 15%);
            color: hsl(0, 0%, 100%);
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: hsl(0, 67%, 20%);
            padding: 20px;
            border-radius: 10px;
            border: 2px solid hsl(2, 86%, 50%);
        }
        .header {
            text-align: center;
            padding: 10px 0;
        }
        .header h1 {
            color: hsl(0, 0%, 100%);
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            color: hsl(0, 0%, 100%);
        }
        .content p {
            color: hsl(0, 0%, 100%);
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: hsl(0, 0%, 15%);
            color: hsl(0, 0%, 100%);
            border-radius: 0 0 10px 10px;
            font-size: 12px;
        }
        .footer p{
            
            color: hsl(0, 0%, 100%);
            
        }
        .btn {
            background-color: hsl(2, 86%, 50%);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: hsl(2, 80%, 40%);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Bienvenido a Panborghini! 🐼</h1>
            <img src="cid:logo" alt="Logo Pandaghini" style="width: 150px; height: auto;">
        </div>
        <div class="content">
            <h2>Hola, ' . htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8') . '!</h2>
            <p>Nos emociona darte la bienvenida a nuestra comunidad. Tu cuenta ha sido creada con éxito y ahora formas parte de <strong>Panborghini</strong>, la mayor red de venta de agua online del mundo</p>
            <p>Gracias por unirte a esta gran aventura. ¡Estamos muy emocionados de que estés aquí! 🎉</p>
            <p><a href="http://localhost/PROYECTOPHP/mi-tienda-online/public/login.php" class="btn">Accede a tu cuenta</a></p>
        </div>
        <div class="footer">
            <p>Si tienes alguna duda o necesitas ayuda, no dudes en contactarnos. ¡Estamos aquí para ti!</p>
            <p>&copy; 2024 Panborghini. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>';

        // Añadir la imagen como adjunto
        $mail->addEmbeddedImage('../assets/images/logo3.png', 'logo'); // Cambia la ruta según sea necesario

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    header("Location: login.php");
    exit();
}

function enviarDatosPedido($email, $detallesPedido)
{
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'cuentaproyectophp@gmail.com';
        $mail->Password = 'w i m v l c d y o u y d k u v s'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Recipiente
        $mail->setFrom('cuentaproyectophp@gmail.com', 'Pandaghini');
        $mail->addAddress($email, 'Gabriel');

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Detalles de tu pedido en Pandaghini';

        $mail->Body = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; background-color: hsl(0, 0%, 15%);">
    <table width="100%" bgcolor="hsl(0, 0%, 15%)" style="border-collapse: collapse;">
        <tr>
            <td align="center">
                <table width="600" style="margin: 20px auto; background-color: hsl(0, 67%, 20%); border: 2px solid hsl(2, 86%, 50%); border-radius: 10px; overflow: hidden;">
                    <tr>
                        <td style="background-color: hsl(0, 67%, 20%); text-align: center; padding: 10px;">
                            <h1 style="color: hsl(0, 0%, 100%); margin: 0;">¡Gracias por tu pedido en Panborghini! 🐼</h1>
                            <img src="cid:logo" alt="Logo Pandaghini" style="width: 150px; height: auto;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px; background-color:  hsl(0, 67%, 20%); border: 2px solid hsl(2, 86%, 50%);">
                            <h2 style="color: hsl(0, 0%, 100%);">Hola, CLIENTE DE PANBORGHINI!</h2>
                            <p style="color: hsl(0, 0%, 100%);">Hemos recibido tu pedido. A continuación, te proporcionamos los detalles:</p>
                            <pre style="color: hsl(0, 0%, 100%);">' . htmlspecialchars($detallesPedido, ENT_QUOTES, 'UTF-8') . '</pre>
                            <p style="color: hsl(0, 0%, 100%);"><strong>Fecha de entrega estimada:</strong> 2 días</p>
                            <p style="color: hsl(0, 0%, 100%);">Si tienes alguna duda, no dudes en contactarnos. ¡Gracias por confiar en nosotros!</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; padding: 10px; background-color: hsl(0, 0%, 15%); font-size: 12px; color: hsl(0, 0%, 100%);">
                            <p>&copy; 2024 Panborghini. Todos los derechos reservados.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

        // Añadir la imagen como adjunto
        $mail->addEmbeddedImage('../assets/images/logo3.png', 'logo'); // Cambia la ruta según sea necesario

        $mail->send();
    } catch (Exception $e) {
        echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
    }
}

