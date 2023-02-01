<html>
    <head>
        <title>Banners</title>
        <link rel="shortcut icon" href="./img/logo.jpg" type="image/x-icon">

        <link rel="stylesheet" href="./css/estilos.css">

        <style>
            #contenedor{
                margin-left: 35%;
                height: 60px;
                width: 400px; 
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

            function validar(){

                var nombre =$('#nombre').val();
                
                var archivo_n =$('#archivo_n').val();
                
                if(nombre.length > 0 && archivo_n.length > 0){ 

                
                    return true;

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
                    <a href="administradores_bienvenida.php">Home</a>
                    <a href="administradores_lista.php">Administradores</a>
                    <a href="productos_lista.php">Productos</a>
                    <a href="banners_lista.php">Banners</a>
                    <a href="pedidos_lista.php">Pedidos</a>
                    <a href="../autentica.php?cerrar_sesion=1">Cerrar seción</a>
                    <br><br>
                <a align="left" href="banners_lista.php">Regresar</a>

                <br><br><br>
                <h1 align="center">Alta</h1>
                <h5 align="center">Banners</h5>
            </nav>

            <div class="wave" style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,49.99 C150.00,150.00 349.21,-49.99 500.00,49.99 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path></svg></div>
                
        </header>

        <form  name="formato" id="formato" action="banners_salva.php" method="POST" enctype="multipart/form-data" >
            <div id="contenedor">
                
                <label>Nombre</label><br>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre"/> <br><br>
                
                <label>Imagen</label><br>
                <input type="file" name="archivo_n" id="archivo_n" accept="image/*" /> <br><br>
                <input  onclick= "return validar();" type="submit" value="Guardar" class="boton"/>
                <h3 id="mensaje"></h3>
                
            </div>
        </form>
    </body>
</html>



