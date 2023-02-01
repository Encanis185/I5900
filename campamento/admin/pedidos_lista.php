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
$sql = "SELECT * FROM pedidos_r";
$res = $con->query($sql);
?>
<html>
    <head>
        
        <title>Pedidos</title>
        <link rel="shortcut icon" href="./img/logo.jpg" type="image/x-icon">
        <link rel="stylesheet" href="./css/estilos.css">
       
        

        <style>
            #dgeneral{
                margin-left: 5%;
                height: 50px;
                width: 1200px; 
            }
            #titulo{
                margin-left: 5%;
                height: 50px;
                width: 958px;
                border-style: solid;
                border-width: thin;
                float: left;
            }
            .celda{
                height: 50px;
                width: 430px;

                float: left;
            }
            .r{
                height: 50px;
                width: 130px;

                float: left;
            }
            #btn{
                height: 30px;
                width: 100px;
            }
            #ida{
                width: 50px;
            }
            .boton{
                height: 30px;
                width: 100px;
            }
        </style>

        <script src="jquery-3.3.1.min.js"> </script>
        <script>


        
        </script>
    </head>
    <body>
        <header>
        <nav>
                    <a href="administradores_bienvenida.php">Home</a>
                    <a href="administradores_lista.php">Administradores</a>
                    <a href="productos_lista.php">Productos</a>
                    <a href="banners_lista.php">Banners</a>

                    <a href="">Pedidos</a>
                    <a href="../autentica.php?cerrar_sesion=1">Cerrar seción</a>
                    <br><br>

                    <br><br><br>
                    <h1 align="center">Listado</h1>
                    <h5 align="center">Pedidos</h5>
                    

        </nav>                                                   
        <div class="wave" style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,49.99 C150.00,150.00 349.21,-49.99 500.00,49.99 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path></svg></div>
            
        </header>


   
        
        
<?php
while($row = $res->fetch_array()){
    $id         = $row["id"];
    $id_cliente         = $row["id_cliente"];
    $total     = $row["total"];

    

    
?>    

   
        <div id="dgeneral">
                
                    <div class="r" >
                    <p class="texto" align="center">Id pedido: </p>
                    </div>
                    <div class="celda" id="ida">
                    <p class="texto" align="center"><?php echo"$id"; ?> </p>
                    </div>
                    <div class="r" >
                    <p class="texto" align="center">Id cliente:</p>
                    </div>
                    <div class="celda" id="ida">
                    <p class="texto" align="center"><?php echo"$id_cliente"; ?> </p>
                    </div>
                    
                    <div class="r">   
                        <p class="texto">Pago total: $<?php echo"$total "; ?>
                    </div>
                    
            </div>


<?php    
}
?>  
    </body>
</html>