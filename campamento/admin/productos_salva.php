<?php

require "funciones/conecta.php";
$con = conecta();


  $nombre = $_REQUEST['nombre'];
  $descripcion = $_REQUEST['descripcion'];
  $codigo = $_REQUEST['codigo'];
  $costo = $_REQUEST['costo'];
  $stock = $_REQUEST['stock'];
  $foto = $_FILES['archivo_n'];

  $archivo_n = $_FILES['archivo_n'];
  $archivo = $archivo_n['name'];
  $file_tmp=$_FILES['archivo_n']['tmp_name'];
  $archivo_enc = md5_file($file_tmp);
  $archivo_t = $archivo_n['type'];

  $extension = explode('.', $archivo);
  $extension = array_pop ($extension);
 

  $tipos = array("image/jpg","image/jpeg", "image/img" );

  if(!in_array($archivo_t, $tipos)){
    header("Location: productos_lista.php");
  }else{

    $archivo_nn = $archivo_enc.'.'.$extension;
  
    move_uploaded_file($archivo_n['tmp_name'], 'img/productos/'.$archivo_nn);
  
    $sql = "INSERT INTO productos
          (nombre, descripcion, costo, codigo, stock, archivo_n, archivo, archivo_nn, foto)
          VALUES('$nombre', '$descripcion', '$costo', '$codigo', '$stock', '$archivo_n','$archivo', '$archivo_nn', '$foto')";

    $res = $con->query($sql);
    header("Location: productos_lista.php");

  }

?>