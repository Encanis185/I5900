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

    $sql = "SELECT * FROM productos WHERE id = '".$id."' ";
    $res = $con->query($sql);
    $row = $res->fetch_array();

    
    $codigo         = $row["codigo"];
    $nombre         = $row["nombre"];
    $descripcion    = $row["descripcion"];
    $costo          = $row["costo"];
    $stock          = $row["stock"];

    $eliminado  =    $row["eliminado"];
}else{
    echo 1;
}
?>


<html>
    <head>
        <title>Productos</title>
        <link rel="shortcut icon" href="./img/logo.jpg" type="image/x-icon">
        <link rel="stylesheet" href="./css/estilos.css">

        <style>
            #contenedor{
                margin-left: 35%;
                height: 50px;
                width: 480px; 
            }
            .boton{
                height: 25px;
                width: 375px;
                background-color: rgba(100, 149, 237, 50%);
                border-style: none;
                border-radius: 25px;
            }
            #mensaje {
                height:25px;
                line-height:20px;
                color: #F00;
                font-size: 16px;
                width: 375px;
                text-align: center;
            }
            #mensajec {
                height:25px;
                line-height:20px;
                color: #F00;
                font-size: 16px;
                width: 180px;
                text-align: center;
            }
        </style>

        <script src="jquery-3.3.1.min.js"></script>
        <script>

            function modificar(){

                var nombre =$('#nombre').val();
                var codigo =$('#codigo').val();
                var descripcion =$('#descripcion').val();
                var costo =$('#costo').val();
                var stock =$('#stock').val();
                var archivo_n =$('#archivo_n').val();
                var cadena= "nombre="+nombre+"&codigo="+codigo+"&descripcion="+descripcion+"&costo="+costo+"&stock="+stock+"&archivo_n="+archivo_n;
                
                if(nombre.length > 0 && descripcion.length > 0 && codigo.length > 0 && costo.length > 0 && stock.length > 0){ 

                
                    return true;

                }else{

                    $('#mensaje').html ('Faltan campos');
                    setTimeout("$('#mensaje').html('')", 5000);
                    return false; 
                }
            }
            
            
            function Codigo(){
                var codigo= $('#codigo').val();


                if(codigo){ 
                    $.ajax({   
                        url   : 'validarcodigo.php', 
                        type  : 'post',     
                        dataType : 'text',  
                        data : 'codigo='+codigo,  
                        
                        success : function(res) { 
                                                
                            if(res >= 1){       
                                $('#mensajec').html ('Codigo valido');
                            }else{
                                $('#mensajec').html ('Codigo invalido');
                                $('#codigo').val("");
                            }
                            setTimeout("$('#mensajec').html('')", 5000);   
    
                        }, error: function(){
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
                    <a href="administradores_lista.php">Administradores</a>
                    <a href="productos_lista.php">Productos</a>
                    <a href="banners_lista.php">Banners</a>
                    <a href="pedidos_lista.php">Pedidos</a>
                    <a href="../autentica.php?cerrar_sesion=1">Cerrar seción</a>
                <br><br>
                <a align="left" href="productos_lista.php">Regresar</a>

                <br><br><br>
                <h1 align="center">Edita</h1>
                <h5 align="center">Productos</h5>
            </nav>

            <div class="wave" style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,49.99 C150.00,150.00 349.21,-49.99 500.00,49.99 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path></svg></div>
            
        </header>
        <form  name="formato" id="formato" action="productos_modifica.php" method="POST" enctype="multipart/form-data">
            <div id="contenedor">
                
                <label>Nombre</label><br>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo"$nombre"; ?>"/> <br><br>
                <label>Descripcion</label><br>
                <input type="text" name="descripcion" id="descripcion" placeholder="Descripcion" value="<?php echo"$descripcion"; ?>"/> <br><br>
                <label>Codigo</label><br>
                <input onblur="Codigo();" type="text" id="codigo" name="codigo" placeholder="Codigo" value="<?php echo"$codigo"; ?>"><br>
                <h3 id="mensajec"></h3>
                <label>Costo</label><br>
                <input type="text" name="costo" id="costo" placeholder="Costo" value="<?php echo"$costo"; ?>"/> <br><br>
                <label>Stock</label><br>
                <input type="text" name="stock" id="stock" placeholder="Stock" value="<?php echo"$stock"; ?>"/> <br><br>                
                
                <label>Imagen</label><br>
                <input type="file" name="archivo_n" id="archivo_n" accept="image/*" /> <br><br>
                <input type="hidden" name="ida" id="ida" value="<?php echo"$id";?>">
                
                <input  onclick= "return modificar();" type="submit" value="Guardar cambios" class="boton"/>
                <h3 id="mensaje"></h3>
                
            </div>
        </form>
    </body>
</html>
