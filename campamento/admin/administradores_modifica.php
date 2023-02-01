<?php

require "funciones/conecta.php";
$con = conecta();

  $nombre = $_REQUEST['nombre'];
  $apellidos = $_REQUEST['apellidos'];
  $correo = $_REQUEST['correo'];
  $rol = $_REQUEST['rol'];
  $ida     = $_REQUEST['ida'];
  $foto = $_REQUEST['archivo_n'];
  $archivo_n = $_FILES['archivo_n'];
  $archivo = $archivo_n['name'];


  if ( strlen( $archivo ) > 4 ){

  $file_tmp=$_FILES['archivo_n']['tmp_name'];
  $archivo_enc = md5_file($file_tmp);
  $archivo_t = $archivo_n['type'];

  $extension = explode('.', $archivo);
  $extension = array_pop ($extension);

  $archivo_nn = $archivo_enc.'.'.$extension;
  move_uploaded_file($archivo_n['tmp_name'], 'img/administradores/'.$archivo_nn);
  $sql = "UPDATE  administradores set archivo_n= '".$archivo_n."', archivo= '".$archivo."', archivo_nn= '".$archivo_nn."', foto= '".$foto."'
  WHERE id ='".$ida."'";
  $res = $con->query($sql);
}

  //echo $nombre;
  //echo $ida;
  $sql = "UPDATE  administradores set nombre= '".$nombre."', apellidos= '".$apellidos."', 
  correo= '".$correo."', rol= '".$rol."' 
  WHERE id ='".$ida."'";

  $res = $con->query($sql);
  header("Location: administradores_lista.php");


?>

