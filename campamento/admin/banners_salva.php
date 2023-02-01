<?php

require "funciones/conecta.php";
$con = conecta();


  $nombre = $_REQUEST['nombre'];
 

  $archivo_n = $_FILES['archivo_n'];
  $archivo = $archivo_n['name'];
  $file_tmp=$_FILES['archivo_n']['tmp_name'];
  $archivo_enc = md5_file($file_tmp);
  $archivo_t = $archivo_n['type'];

  $extension = explode('.', $archivo);
  $extension = array_pop ($extension);
 



    $archivo_nn = $archivo_enc.'.'.$extension;
  
    move_uploaded_file($archivo_n['tmp_name'], 'img/banners/'.$archivo_nn);
  
    $sql = "INSERT INTO banners
          (nombre, archivo_n, archivo, archivo_nn)
          VALUES('$nombre', '$archivo_n','$archivo', '$archivo_nn')";

    $res = $con->query($sql);
    header("Location: banners_lista.php");



?>