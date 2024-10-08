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
        /*$mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');*/

        //Attachments
        /*$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');  */  //Optional name

        //Content
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Creacion de usuario correcta';
        $mail->Body = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Bienvenido a Pandaghini! 🐼</h1>
        </div>
        <div class="content">
            <h2>Hola, ' . htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8') . '!</h2>
            <p>Nos emociona darte la bienvenida a nuestra comunidad. Tu cuenta ha sido creada con éxito y ahora formas parte de <strong>Pandaghini</strong>, donde la creatividad y la innovación se encuentran en cada rincón.</p>
            <p>Gracias por unirte a esta gran aventura. ¡Estamos muy emocionados de que estés aquí! 🎉</p>
            <p><a href="http://localhost/PROYECTOPHP/mi-tienda-online/public/login.php" class="btn">Accede a tu cuenta</a></p>
        </div>
        <div class="footer">
            <p>Si tienes alguna duda o necesitas ayuda, no dudes en contactarnos. ¡Estamos aquí para ti!</p>
            <p>&copy; 2024 Pandaghini. Todos los derechos reservados.</p>
        </div>
    </div>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 10px 0;
            background-color: #ffce00;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            color: #000;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            color: #ff6f00;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f4f4f9;
            color: #888;
            border-radius: 0 0 10px 10px;
            font-size: 12px;
        }
        .btn {
            background-color: #ff6f00;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #e65c00;
        }
    </style>
</body>
</html>';

        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    header("Location: index.php");
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
        $mail->addAddress($email, $nombreUsuario);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Detalles de tu pedido en Pandaghini';
        
        // Cuerpo del correo
        $mail->Body = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>¡Gracias por tu pedido en Pandaghini!</h1>
                </div>
                <div class="content">
                    <h2>Hola, ' . htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8') . '!</h2>
                    <p>Hemos recibido tu pedido. A continuación, te proporcionamos los detalles:</p>
                    <p>' . nl2br(htmlspecialchars($detallesPedido, ENT_QUOTES, 'UTF-8')) . '</p>
                    <p><strong>Fecha de entrega estimada:</strong> 2 días</p>
                    <p>Si tienes alguna duda, no dudes en contactarnos. ¡Gracias por confiar en nosotros!</p>
                </div>
                <div class="footer">
                    <p>&copy; 2024 Pandaghini. Todos los derechos reservados.</p>
                </div>
            </div>
            <style>
                .container {
                    font-family: Arial, sans-serif;
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #ffffff;
                }
                .header {
                    background-color: #ffce00;
                    text-align: center;
                    padding: 10px 0;
                }
                .content {
                    padding: 20px;
                    background-color: #f4f4f9;
                }
                .footer {
                    text-align: center;
                    padding: 10px;
                    font-size: 12px;
                    color: #888;
                }
            </style>
        </body>
        </html>';

        $mail->send();
    } catch (Exception $e) {
        echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
    }
}

