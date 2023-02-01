<?php
require "funciones/conecta.php";
$con = conecta();
$correo = $_REQUEST['correo'];

session_start();

if(!isset($_SESSION['rol'])){
    header('location: ../index.php');
} else{
    if($_SESSION['rol'] != 3 ){
        header('location: ../index.php');  
    }
}

?>
<html>
    <head>
        
        <title>Productos</title>
        <link rel="shortcut icon" href="./img/logo.jpg" type="image/x-icon">
        <link rel="stylesheet" href="./css/estilos.css">
       
        

        <style>
            
            #titulo{
                margin-left: 5%;
                height: 50px;
                width: 958px;
                border-style: solid;
                border-width: thin;
                float: left;
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
            #logo{
                height: 100px;
                width: 125px;
            }
            #piep{
                height: 150px;
                width: 100%;
                background-color: #EDE8D0;
            }
            #pie{
                margin-top: 80%;
            }
            #redes{
                height: 50px;
                width: 50px;
                float: left;

            }
            #img_redes{
                margin-left: 43%;

            }

        </style>

        <script src="jquery-3.3.1.min.js"> </script>
        <script>


        
        </script>
    </head>
    <body>
        <header>
        <nav>
                    <a href="bienvenida.php?correo=<?php echo"$correo"; ?>">Home</a>
                    <a href="">Productos</a>
                    <a href="contacto.php?correo=<?php echo"$correo"; ?>">Contacto</a>
                    <a href="carrito.php?correo=<?php echo"$correo"; ?>">Carrito</a>

                    <a href="autentica.php?cerrar_sesion=1">Cerrar seción</a>
                    <img align="left" id="logo"src="img/logo.png" >

                    <br><br><br><br><br><br><br>
                    <h1 align="center">Listado</h1>
                    <h5 align="center">Productos</h5>
                    

        </nav>                                                   
        <div class="wave" style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,49.99 C150.00,150.00 349.21,-49.99 500.00,49.99 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path></svg></div>
            
        </header>
        <?php
            $sqlP = "SELECT * FROM productos WHERE  eliminado = 0 ";
            $resP = $con->query($sqlP);
            while($rowP = $resP->fetch_array()){
                $nombre         = $rowP["nombre"];
                $costo          = $rowP["costo"];
                $id_p          = $rowP["id"];

                $archivo_nn     = $rowP["archivo_nn"];
                
            ?>  
                
                <div id="cuadro" name="cuadro">
                <img id="img_p" src="admin/img/productos/<?php echo"$archivo_nn"; ?>"><br><br>

                <h4 align="center"> <?php echo"$nombre"; ?> </h4>
                <h4 align="center">$<?php echo"$costo"; ?> </h4>
                <br>
                <a href=<?php echo"'alta_carrito.php?id=$id_p&correo=$correo'"; ?>>    <input type="submit" value="Añadir carrito" id="boton"/>   </a>
                

                </div>
           
            <?php
            }
            ?>


            <div id="pie">
                <footer id="piep">
                <br><br>
                <h3 align="center">Copyright @ 2022 by Alejandra</h3>
                <br>
                <h3 align="center">-</h3>
                <div id="img_redes">
                <a href="https://www.facebook.com/groups/979028125593773/" target="_blank"><img id="redes" src="img/facebook.png" ></a>
                <a href="https://instagram.com/camping.expedition?igshid=YmMyMTA2M2Y=" target="_blank"><img id="redes" src="img/instagram.png" ></a>
                <a href="https://twitter.com/thingsabtshop_?t=HL2yv3yMrDhsXi5N1-zqVQ&s=09" target="_blank"><img id="redes" src="img/tw.png" ></a>
                <a href="https://www.youtube.com/@IbericaOverland" target="_blank"><img id="redes" src="img/youtube.png" ></a>
                </div>
                </footer>

            </div>
 

   
        
        


 
    </body>
</html>