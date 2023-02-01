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
                width: 700px; 
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
            .btn{
                margin-left: 5%;
                height: 30px;
                width: 200px;
                border-radius: 25px;
                font-size: 16px;
                background-color: rgba(247, 193, 212, 50%);
                
            }
            .msg{
                margin-left: 5%;
                height: 120px;
                width: 600px;
                border-radius: 25px;
                font-size: 16px;
                background-color: rgba(247, 193, 212, 50%);
                
            }
            .boton{
                margin-left: 25%;
                font-size: 16px;
                height: 50px;
                width: 300px;
                border-radius: 25px;
                background-color: rgba(100, 149, 237, 80%);
            }
            #mensaje {
                height:25px;
                line-height:20px;
                color: #BD3062;
                font-size: 20px;
                width: 375px;
                text-align: center;
            }

        </style>

        <script src="jquery-3.3.1.min.js"> </script>
        <script>

            function validar(){
            
            var correo = $('#correo').val();
            var nombre = $('#nombre').val();
            var mensaje = $('#msg').val();

            if(correo.length > 0 && nombre.length > 0 && mensaje.length > 0){ 
 
                $.ajax({   
                    url: 'correo_envia.php?correo='+correo+'&nombre='+nombre+'&mensaje='+mensaje,      
                    success : function(res) { 
                                                
                        if(res == 0){       
                            $('#mensaje').html ('Hubo un error, intente mas tarde');
                            setTimeout("$('#mensaje').html('')", 5000);
                            return false;
                        }else{

                            window.location.href ='bienvenida.php?correo='+correo;
                        }
                        
    
                    }, error: function(){
                        alert('Error, archivo no encontrado...')
                    }
                });

            }else{
                $('#mensaje').html ('Faltan campos');
                setTimeout("$('#mensaje').html('')", 5000);
                return false;
            }
        }

        
        </script>
    </head>
    <body>
        <header>
        <nav>
                    <a href=" bienvenida.php?correo=<?php echo"$correo";?>" > Home </a>
                    <a href="productos.php?correo=<?php echo"$correo";?>" >Productos</a>
                    <a href="">Contacto</a>
                    <a href="carrito.php?correo=<?php echo"$correo";?>" >Carrito</a>

                    <a href="autentica.php?cerrar_sesion=1">Cerrar seción</a>
                    <img align="left" id="logo"src="img/logo.png" >

                    <br><br><br><br><br><br><br>
                    <h1 align="center">Contactanos</h1>
                    

        </nav>                                                   
        <div class="wave" style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,49.99 C150.00,150.00 349.21,-49.99 500.00,49.99 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path></svg></div>
            
        </header>
        

            <div id="cuadro">
                <br><br><br>
                <input type="hidden" name="correo" id="correo"  value="<?php echo"$correo"; ?>"/> <br><br>
                <input type="text" name="nombre" id="nombre"class="btn" placeholder="Nombre"/> <br>
                <br>
                <textarea name="msg" id="msg" cols="30" rows="10" class="msg" placeholder="Nos interesa tu opinión">
                    
                </textarea>
                <h3 id="mensaje"></h3><br>

                <input  onclick= "return validar();" type="submit" value="ENVIAR" class="boton"/>
                <br>  

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