<?php
require "funciones/conecta.php";
$con = conecta();
$correo = $_REQUEST['correo'];
$nombre = $_REQUEST['nombre'];
$mensaje = $_REQUEST['mensaje'];
$subject = "Mensaje del servidor ";
$to = 'chavezgomezitzelalejandra@gmail.com';
$headers = 'From: itzdra.chamez@gmail.com' . "\r\n" .
'Reply-To: itzdra.chamez@gmail.com' . "\r\n" .
'X-Mailer: PHP/' . phpversion(); 
$message = "Mensaje: $mensaje De: $nombre";

if (mail($to, $subject, $content, $headers))
{
	echo "Success !!!";
} 
else 
{
   	echo "ERROR";
}
?>

