<?php
require "funciones/conecta.php";
$con = conecta();
$id = $_REQUEST['id'];

if($id){
     $sql = "UPDATE banners
             SET eliminado = 1
             WHERE id =$id ";
     $res = $con->query($sql);
     $id = 1;


}else{
     $id = 0;
}

echo $id;

?>