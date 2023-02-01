<?php
require "funciones/conecta.php";
$con = conecta();

$correo = $_REQUEST['correo'];

$sql = "SELECT * FROM administradores WHERE eliminado = 0 AND correo = '".$correo."' ";

$res = $con->query($sql);
$fila= mysqli_num_rows($res);

if($fila == 0 && $correo != "@gmail.com"){
    echo 1;
}else{
    echo 0;
}
?>