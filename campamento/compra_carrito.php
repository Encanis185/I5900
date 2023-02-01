<?php
require "funciones/conecta.php";
$con = conecta();
$cadena = $_REQUEST['cadena'];
$total = $_REQUEST['total'];
$correo = $_REQUEST['correo'];



if($correo){
     $sql = "SELECT * FROM administradores WHERE correo = '".$correo."' ";
     $res = $con->query($sql);
     $row = $res->fetch_array();
     $id = $row["id"];
     $carrito = 'carrito_'.$id;

     $sql = "INSERT INTO pedidos_r
          (id_cliente, cadena, total)
          VALUES('$id', '$cadena', '$total')";
     $res = $con->query($sql);

     $sql ="DELETE $carrito FROM $carrito";
     $res = $con->query($sql);
     header("Location: carrito.php?correo=$correo");

}


?>