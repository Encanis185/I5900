<?php
require "funciones/conecta.php";
$con = conecta();
$correo = $_REQUEST['correo'];
$total = 0;
$cadena = 'pedido=';
if($correo){
    $sql = "SELECT * FROM administradores WHERE correo = '".$correo."' ";
    $res = $con->query($sql);
    $row = $res->fetch_array();
    $id = $row["id"];
    $carrito = 'carrito_'.$id;

    $sql2 = "SELECT * FROM $carrito";
    $res2 = $con->query($sql2);



    
}

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
        
        <title>Contactanos</title>
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
                margin-left: 23%;
                height: 400px;
                width: 600px; 
                border-radius: 15px;
                background-color: #FFE7BF;
                border-style: double;
                border-color: #000;
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
                margin-top: 10%;
            }
            #redes{
                height: 50px;
                width: 50px;
                float: left;

            }
            #img_redes{
                margin-left: 43%;

            }
            
            .boton{
                
                font-size: 16px;
                height: 25px;
                width: 250px;
                border-radius: 25px;
                background-color: rgba(100, 149, 237, 80%);
                float: left;
            }
            .celda{
                height: 50px;
                width: 150px;
                float: left;
            }
            #ida{
                width: 50px;
            }
            .r{
                height: 50px;
                width: 130px;

                float: left;
            }
            

        </style>
        <script src="jquery-3.3.1.min.js"> </script>
        <script>
        
            

        
        </script>
    </head>
    <body>
        <header>
        <nav>
                    <a href=" bienvenida.php?correo=<?php echo"$correo";?>" > Home </a>
                    <a href="productos.php?correo=<?php echo"$correo";?>" >Productos</a>
                    <a href="contacto.php?correo=<?php echo"$correo";?>">Contacto</a>
                    <a href="" >Carrito</a>

                    <a href="autentica.php?cerrar_sesion=1">Cerrar seción</a>
                    <img align="left" id="logo"src="img/logo.png" >

                    <br><br><br><br><br><br><br>
                    <h1 align="center">Carrito</h1>
                    

        </nav>                                                   
        <div class="wave" style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,49.99 C150.00,150.00 349.21,-49.99 500.00,49.99 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path></svg></div>
            
        </header>

            <div id="cuadro">

            <?php
while($row2 = $res2->fetch_array()){
    $id_producto    = $row2["id_producto"];
    $id    = $row2["id"];
    $costo    = $row2["costo"];
    $total = $total + $costo;
    $cadena = $cadena.'_'.$id_producto;

    $sql1 = "SELECT nombre FROM productos where id= '".$id_producto."' ";
    $res1 = $con->query($sql1);
    $row1 = $res1->fetch_array();
    $nombre = $row1["nombre"]; 
    
    
?>  
                    <br><br>
                    <div class="celda" id="ida">
                    <p class="texto" align="center"> <?php echo"$id"; ?> </p>
                    </div> 
                    <div class="r">   
                        <p class="texto"><?php echo"$nombre "; ?></p>
                    </div>
                    <div class="r">
                        <p class="texto">$<?php echo"$costo "; ?> </p>
                    </div>
                    <div class="celda" id="btn">
                    <a href=<?php echo"'elimina_carrito.php?id=$id&correo=$correo'"; ?>>    <input type="submit" value="Eliminar " id="boton"/>   </a>
                    </div>
                    <br>

<?php
}

?>
                    <br>
                    <div class="r">
                        <p class="texto">Total: $<?php echo"$total "; ?></p>
                    </div>
                    <br>
                    <div class="celda" id="boton">
                    <a href=<?php echo"'compra_carrito.php?cadena=$cadena&correo=$correo&total=$total'"; ?>>    <input type="submit" value="Realizar Compra " class="boton"/>   </a>

                    </div>
            </div>


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