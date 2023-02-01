<?php
require "funciones/conecta.php";
session_start();

if(!isset($_SESSION['rol'])){
    header('location: ../index.php');
} else{
    if($_SESSION['rol'] == 3 ){
        header('location: ../index.php');  
    }
}



$con = conecta();

$id = $_GET['id'];


if($id){
    $sql = "SELECT * FROM administradores WHERE id = '".$id."' ";
    $res = $con->query($sql);
    $row = $res->fetch_array();

    $nombre     =    $row["nombre"];
    $apellidos  =    $row["apellidos"];
    $correo     =    $row["correo"];
    $rol        =    $row["rol"];
    $eliminado  =    $row["eliminado"];
    $archivo    =    $row["archivo"];
    $archivo_nn =    $row["archivo_nn"];

    

    if($eliminado == 0){
        $mean_eliminado = " Vigente";
    }else{
        $mean_eliminado = " Eliminado";
    }

    if($rol == 1){
        $mean_rol = "Gerente";
    }else if($rol == 2){
        $mean_rol = "Ejecutivo";
    }


}else{
    echo 1;
}
?>


<html>
    <head>
        <title>Administradores</title>
        <link rel="shortcut icon" href="./img/logo.jpg" type="image/x-icon">
        <link rel="stylesheet" href="./css/estilos.css">

        <style>
            #contenedor{
                margin-left: 36%;
                height: 400px;
                width: 300px; 
                background-color: rgba(100, 149, 237, 50%);
                border-radius: 15px;
                align-items: center;
            }
            #im{
                height: 200px;
                width: 200px;
                margin-left: 50px;
                margin-top: 10px;
            }
            .texto {
                height:25px;
                line-height:25px;
                font-size: 16px;
                width: 375px;
                text-align: center;
            }  
            .boton{
                height: 25px;
                width: 200px;
            }
           
        </style>

        <script src="jquery-3.3.1.min.js"></script>

    </head>

    <body>
        <header>
            <nav>
                
                    <a href="administradores_bienvenida.php">Home</a>
                    <a href="administradores_lista.php">Administradores</a>
                    <a href="productos_lista.php">Productos</a>
                    <a href="banners_lista.php">Banners</a>
                    <a href="pedidos_lista.php">Pedidos</a>
                    <a href="../autentica.php?cerrar_sesion=1">Cerrar seción</a>
                <br><br>
                <a align="left" href="administradores_lista.php">Regresar</a>
                <br><br><br>
                <h1 align="center">Detalle</h1>
                <h5 align="center">Administradores</h5>
            </nav>

            
            <div class="wave" style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,49.99 C150.00,150.00 349.21,-49.99 500.00,49.99 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path></svg></div>  
        </header>
        <form  name="formato" id="formato">
            <div id="contenedor">
                <img id="im" src="img/administradores/<?php echo"$archivo_nn"; ?>" height="200" width="200">
                <h5 align="center" ><?php echo"$archivo"; ?></h5> <br>
                
                <label align="center" >Nombre:  <?php echo" $nombre ";?>  <?php echo"$apellidos"; ?></label> <br><br>
                <label align="center" >Correo:     <?php echo"$correo"; ?> </label><br><br>
                <label align="center" >Rol:     <?php echo"$mean_rol"; ?> </label><br><br>
                <label align="center" >Status:  <?php echo"$mean_eliminado"; ?></label> <br><br>
                
                 
            </div>
        </form>
    </body>
</html>


