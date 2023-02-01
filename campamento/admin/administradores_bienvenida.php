<?php

require "funciones/conecta.php";
$con = conecta();
error_reporting(0);
$correo = $_REQUEST['correo'];



if($correo){
    $sql = "SELECT * FROM administradores WHERE correo = '".$correo."' ";
    $res = $con->query($sql);
    $row = $res->fetch_array();
    $nombre = $row["nombre"];
    $apellidos = $row["apellidos"];

}

session_start();

if(!isset($_SESSION['rol'])){
    header('location: ../index.php');
} else{
    if($_SESSION['rol'] == 3 ){
        header('location: ../index.php');  
    }
}

$sqlbanners = "SELECT * FROM banners WHERE  eliminado = 0";
$resbanners = $con->query($sqlbanners);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="shortcut icon" href="./img/logo.jpg" type="image/x-icon">
        <link rel="stylesheet" href="./css/estilos.css">
        <style>
            body{
                background-color: #fff;
            }
            #cuadro{
                margin-left: 15%;
                
                align: center;
                height: 500px;
                width: 900px;
                border-radius: 35px;
                background-color: #fff;
            }
            .slider {
                width: 100%;
                overflow: hidden;
            }
            .slider ul {
                display: flex;
                padding: 0;
                width: 400%;

                animation: cambio 25s infinite alternate;
            }
            .slider li{
                width: 100%;
                list-style: none;

            }

            .slider img{
                width: 630px;
                height: 220px;

            }

            @keyframes cambio {
                0% {margin-left: 0;}
                20% {margin-left: 0;}


                25% {margin-left: -100%;}
                45% {margin-left: -100%;}

                50% {margin-left: -200%;}
                70% {margin-left: -200%;}

                75% {margin-left: -300%;}
                100% {margin-left: -300%;}

            }

            #cuadro{
                margin: 30px;
                height: 350px;
                width: 250px; 
                border-radius: 15px;
                background-color: #FFE7BF;
                border-style: double;
                border-color: #000;
                float: left;
            }
            #img_p{
                margin-top: 20px;
                margin-left: 20px;

                width: 84%;
            }
            
        
            #general{
                margin-left: 15%;
            }
            #boton{
                height: 25px;
                width: 100px; 
                background-color: #F9D108;
                margin-left: 30%;
                border-radius: 15px;
            }
        </style>
        <script src="jquery-3.3.1.min.js"> </script>
        <script>
            
        </script>
    </head>
    <body>
        <header>
            <nav>
                    <a href="">Home</a>
                    <a href="administradores_lista.php">Administradores</a>
                    <a href="productos_lista.php">Productos</a>
                    <a href="banners_lista.php">Banners</a>
                    <a href="pedidos_lista.php">Pedidos</a>
                    <a href="../autentica.php?cerrar_sesion=1">Cerrar seción</a>
            </nav>

                <br><br><br>
                <h1 align="center">Bienvenid@</h1>
                <h1 align="center"><?php echo"$nombre $apellidos";?></h1> 
                    
            
            <div class="wave" style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,49.99 C150.00,150.00 349.21,-49.99 500.00,49.99 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: rgba(255, 236, 214, 00%);"></path></svg></div>
            
        </header>
        <div class="slider" >
            <ul>
                <?php
                while($rowbanners = $resbanners->fetch_array()){
                    $archivo_nn         = $rowbanners["archivo_nn"];            
                ?>    
                <li><img src="img/banners/<?php echo"$archivo_nn";?>" ></li>
            
                <?php
                }
                ?>
                
            </ul>

            <br><br>
            <h1 align="center" >Nuevos productos</h1>
            <br>
            <?php
            $sqlP = "SELECT * FROM productos WHERE  eliminado = 0 ORDER BY id DESC LIMIT 6";
            $resP = $con->query($sqlP);
            while($rowP = $resP->fetch_array()){
                $nombre         = $rowP["nombre"];
                $costo          = $rowP["costo"];
                $archivo_nn     = $rowP["archivo_nn"];
                
            ?>  
                <div id="general">
                <div id="cuadro" name="cuadro">
                <img id="img_p" src="img/productos/<?php echo"$archivo_nn"; ?>"><br><br>

                <h4 align="center"> <?php echo"$nombre"; ?> </h4>
                <h4 align="center">$<?php echo"$costo"; ?> </h4>
                <br>

                </div>
                </div> 
            <?php
            }
            ?>

        </div>
    </body>
</html>

<?php

?>