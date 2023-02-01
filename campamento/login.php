<?php
require "funciones/conecta.php";
$con = conecta();
$correo = $_REQUEST['correo'];
$pass = $_REQUEST['pass'];
$pass_enc = md5($pass);
  
  $sql = "SELECT pass, rol FROM administradores WHERE eliminado = 0 AND correo = '".$correo."' ";

  $res = $con->query($sql);
  $row = $res->fetch_array();
  $fila= mysqli_num_rows($res);

  
  if($fila >= 1 ){
    $contrasena = $row["pass"];
    $rol         = $row["rol"];
    if($pass_enc == $contrasena){
      
      echo 2;	    
      
    }else{
      echo 0;
    }

  }else{
   // $fallo = 1;
   // header("Location: administradores_login.php?fallo=$fallo");
   echo 0;
}

?>
