<?php
require "funciones/conecta.php";
$con = conecta();
$id_p = $_REQUEST['id'];
$correo = $_REQUEST['correo'];



if($correo){
     $sql = "SELECT * FROM administradores WHERE correo = '".$correo."' ";
     $res = $con->query($sql);
     $row = $res->fetch_array();
     $id = $row["id"];
     $carrito = 'carrito_'.$id;

     $sql ="DELETE $carrito FROM $carrito WHERE id = '".$id_p."' ";
     $res = $con->query($sql);
     header("Location: carrito.php?correo=$correo");

}


?>