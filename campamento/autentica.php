<?php
require "funciones/conecta.php";
$con = conecta();
$correo = $_REQUEST['correo'];

$sql = "SELECT rol FROM administradores WHERE eliminado = 0 AND correo = '".$correo."' ";
$res = $con->query($sql);
$row = $res->fetch_array();

    
    session_start();
    $rol = $row["rol"];
    $_SESSION['rol'] = $rol; 
    if(isset($_GET['cerrar_sesion'])){
    session_unset();
    session_destroy();
    header("Location: index.php?correo=$correo");
    }
    
    if(isset($_SESSION['rol'])){
        switch($_SESSION['rol']){
            case 1:
                header("Location: admin/administradores_bienvenida.php?correo=$correo");
            break;
            case 2:
                header("Location: admin/administradores_bienvenida.php?correo=$correo");
            break;
            case 3:
                header("Location: bienvenida.php?correo=$correo");

            break;
            default;
        }
    }
    ?>