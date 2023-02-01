<?php
require "funciones/conecta.php";
$con = conecta();
$id = $_REQUEST['id'];

if($id){
     $sql = "UPDATE administradores
             SET eliminado = 1
             WHERE id =$id ";
     $res = $con->query($sql);
     $id = 1;
     header("Location: administradores_alta.php");
     header("Location: administradores_lista.php");


}else{
     $id = 0;
}

echo $id;

?>