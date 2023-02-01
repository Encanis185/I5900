<?php
require "funciones/conecta.php";
$con = conecta();
$id = $_REQUEST['id'];
$correo = $_REQUEST['correo'];

if($correo){
     $sql =  "SELECT id FROM administradores WHERE correo = '".$correo."' "; 
     $res = $con->query($sql);
     $row = $res->fetch_array();
     $id_a        = $row["id"];

}

if($id){
     $sql =  "SELECT * FROM productos WHERE id = '".$id."' "; 
     $res = $con->query($sql);
     $row = $res->fetch_array();
     $id        = $row["id"];
     $costo     = $row["costo"];

}

$carrito = 'carrito_'.$id_a;

$sql = "INSERT INTO $carrito
          (id_producto, costo)
          VALUES('$id', '$costo')";
    $res = $con->query($sql);


    header("Location: productos.php?correo=$correo");
?>