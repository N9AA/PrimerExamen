<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'sandbox.smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->Username = 'c7bbbc9b496232';
$mail->Password = '4a4f3056005b46';
$mail->Port = 2525;

$mail->setFrom('web@ejemplo.com', 'Mi sitio web');
$mail->addAddress('arratiaalejandranoelia@gmail.com');

$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");
$asunto = trim($_POST["asunto"] ?? "");
$mensaje = trim($_POST["mensaje"] ?? "");

if ($nombre === "" || $asunto === "" || $mensaje === "") {
    exit("Complete los campos obligatorios.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("El email no es válido.");
}

$mail->addReplyTo($email, $nombre);

$mail->isHTML(true);
$mail->Subject = $asunto;
$mail->Body = "
<h2>Nuevo mensaje de contacto</h2>

<p><strong>Nombre:</strong> " . htmlspecialchars($nombre) . "</p>
<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
<p><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($mensaje)) . "</p>
";

try {
    $mail->send();
    echo "Mensaje enviado correctamente.";
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje.";
}

?>