<?php
require "funciones/conecta.php";
$con = conecta();

$codigo = $_REQUEST['codigo'];

$sql = "SELECT * FROM productos WHERE eliminado = 0 AND codigo = '".$codigo."' ";

$res = $con->query($sql);
$fila= mysqli_num_rows($res);

if($fila == 0){
    echo 1;
}else{
    echo 0;
}
?>