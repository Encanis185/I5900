<?php

require "funciones/conecta.php";
$con = conecta();

  $ida     = $_REQUEST['ida'];

  $nombre = $_REQUEST['nombre'];
  $descripcion = $_REQUEST['descripcion'];
  $codigo = $_REQUEST['codigo'];
  $costo = $_REQUEST['costo'];
  $stock = $_REQUEST['stock'];
  
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
  move_uploaded_file($archivo_n['tmp_name'], 'img/productos/'.$archivo_nn);
  $sql = "UPDATE  productos set archivo_n= '".$archivo_n."', archivo= '".$archivo."', archivo_nn= '".$archivo_nn."', foto= '".$foto."'
  WHERE id ='".$ida."'";
  $res = $con->query($sql);
}

  //echo $nombre;
  //echo $ida;
  $sql = "UPDATE  productos set nombre= '".$nombre."', descripcion= '".$descripcion."', 
  costo= '".$costo."', codigo= '".$codigo."', stock= '".$stock."' 
  WHERE id ='".$ida."'";

  $res = $con->query($sql);
  header("Location: productos_lista.php");


?>

