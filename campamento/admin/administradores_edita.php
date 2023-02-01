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
                var apellidos =$('#apellidos').val();
                var correo =$('#correo').val();
                var rol =$('#rol').val();
                
                if(nombre.length > 0 && apellidos.length > 0 && correo.length > 0  && rol != "0" && correo != "@gmail.com"){ 
               
                    return true;

                }else{


                    $('#mensaje').html ('Faltan campos');
                    return false; 
                }
            }
            
            
            function Correo(){
                var correo= $('#correo').val();


                if(correo){ 
                    $.ajax({   
                        url   : 'validarc.php', 
                        type  : 'post',     
                        dataType : 'text',  
                        data : 'correo='+correo,  
                        
                        success : function(res) { 
                                                
                            if(res >= 1){       
                                $('#mensajec').html ('Correo valido');
                            }else{
                                $('#mensajec').html ('Correo invalido');
                                $('#correo').val("@gmail.com");
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
                <a align="left" href="administradores_lista.php">Regresar</a>

                <br><br><br>
                <h1 align="center">Edita</h1>
                <h5 align="center">Administradores</h5>
            </nav>

            <div class="wave" style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,49.99 C150.00,150.00 349.21,-49.99 500.00,49.99 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path></svg></div>
            
        </header>
        <form  name="formato" id="formato" action="administradores_modifica.php" method="POST" enctype="multipart/form-data">
            <div id="contenedor">
                
                <label>Nombre</label><br>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo"$nombre"; ?>"/> <br><br>
                <label>Apellidos</label><br>
                <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" value="<?php echo"$apellidos"; ?>"/> <br><br>
                <label>Correo</label><br>
                <input onblur="Correo();" type="email" id="correo" name="correo" value="<?php echo"$correo"; ?>"><br>
                <h3 id="mensajec"></h3>
                <label>Rol</label><br>
                <select name="rol" id="rol">
                    <option value="0" selected>Selecciona </option>
                    <option value="1">Gerente</option>
                    <option value="2">Ejecutivo</option>
                </select>
                <br><br>
                <label>Imagen</label><br>
                <input type="file" name="archivo_n" id="archivo_n" accept="image/*" /> <br><br>

                <input type="hidden" name="ida" id="ida" value="<?php echo"$id";?>">
                
                <input  onclick= "return modificar();" type="submit" value="Guardar cambios" class="boton"/>
                <h3 id="mensaje"></h3>
                
            </div>
        </form>
    </body>
</html>
