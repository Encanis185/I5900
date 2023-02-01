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
$sql = "SELECT * FROM administradores WHERE  eliminado = 0";
$res = $con->query($sql);
?>
<html>
    <head>
        
        <title>Administradores</title>
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
                width: 330px;

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
            #btn{
                height: 30px;
                width: 100px;
            }
            
            .boton{
                height: 30px;
                width: 100px;
            }
        </style>

        <script src="jquery-3.3.1.min.js"> </script>
        <script>


        function eliminar(idr, registro){
            console.log(idr);
            console.log(registro);

        let confirmacion = confirm("Desea eliminar este registro?"); 

        if(confirmacion ==true){ 
                $.ajax({  
                    url: 'administradores_elimina.php?id='+idr,  
                    type: 'post',    
                    dataType: 'text',   
                    data: 'id='+idr,  
                
                    success : function(eliminado) { 
                                            
                        if(eliminado == 1){   
                        console.log("Registro eliminado");
                                event.preventDefault();
                                $("#registro").hide();
                                
                        }else{
                            console.log("No se pudo eliminar el registro");
                        }
                        location.href = 'administradores_lista.php';

                    }, 
                    error: function(){
                        alert('Error, archivo no encontrado...')
                    }
                });
           
        } 
        }
        </script>
    </head>
    <body>
        <header>
        <nav>
                    <a href="administradores_bienvenida.php">Home</a>
                    <a href="">Administradores</a>
                    <a href="productos_lista.php">Productos</a>
                    <a href="banners_lista.php">Banners</a>
                    <a href="pedidos_lista.php">Pedidos</a>
                    <a href="../autentica.php?cerrar_sesion=1">Cerrar seción</a>
                    <br><br>
                    <a href="administradores_alta.php">Dar de alta</a>

                    <br><br><br>
                    <h1 align="center">Listado</h1>
                    

        </nav>                                                   
        <div class="wave" style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,49.99 C150.00,150.00 349.21,-49.99 500.00,49.99 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path></svg></div>
            
        </header>


   
        
        
<?php
while($row = $res->fetch_array()){
    $id         = $row["id"];
    $nombre     = $row["nombre"];
    $apellido   = $row["apellidos"];
    $correo     = $row["correo"];
    $rol        = $row["rol"];

    if($rol == 1){
        $srol = "Gerente";
    }else{
        $srol = "Ejecutivo";
    }
    
?>    
  
   
        <div id="dgeneral">
                
                    <div class="celda" id="ida">
                    <p class="texto" align="center"> <?php echo"$id"; ?> </p>
                    </div> 
                    <div class="celda">   
                        <p class="texto"><?php echo"$nombre "; ?><?php echo"$apellido"; ?>   </p>
                    </div>
                    <div class="celda">
                        <p class="texto"><?php echo"$correo "; ?> </p>
                    </div>
                    <div class="r">
                        <p class="texto"><?php echo"$srol "; ?> </p>
                    </div>
                    <div class="celda" id="btn">
                        <a href="javascript:void(0);" onClick="eliminar(<?php echo"'$id', 'registro$id'"; ?>);">    <input type="submit" value="Eliminar" class="boton"/>   </a>
                    </div>
                    <div class="celda" id="btn">
                        <a href=<?php echo"'administradores_detalle.php?id=$id'"; ?>>    <input type="submit" value="Ver detalle" class="boton"/>   </a>
                    </div>
                    <div class="celda" id="btn">
                        <a href=<?php echo"'administradores_edita.php?id=$id'"; ?>>  <input type="submit" value="Editar" class="boton"/> </a>
                    </div>
            </div>


<?php    
}
?>  
    </body>
</html>