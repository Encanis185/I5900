<!DOCTYPE html>

<?php
error_reporting(0);
if(isset($_SESSION['rol'])){
    
    if($_SESSION['rol'] == 3 ){
        header('location:  bienvenida.php');  
    }
    if($_SESSION['rol'] == 2 ){
        header('location: admin/administradores_bienvenida.php');  
    }
    if($_SESSION['rol'] == 1 ){
        header('location: admin/administradores_bienvenida.php');  
    }
} else{
    
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="./img/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="css/estilos.css">
    <style>
    body{
        background-image: url('./img/fondo.png');
        background-repeat: no-repeat;
        background-size: cover;
    }
    #cuadro{
        margin-left: 32%;
        margin-top: 80px;
        align: center;
        height: 500px;
        width: 500px;
        border-radius: 35px;
        background-color:rgba(250, 222, 161, 75%);
    }
    .btn{
        margin-left: 20%;
        height: 50px;
        width: 300px;
        border-radius: 25px;
        font-size: 16px;
        background-color: rgba(247, 193, 212, 50%);
        
    }
    .boton{
        margin-left: 20%;
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
    <script src="jquery-3.3.1.min.js"></script>
    <script>
        
        function validar(){
            
            var correo= $('#correo').val();
            var pass= $('#pass').val();

            if(correo.length > 0 && pass.length > 0){ 
                $.ajax({   
                    url: 'login.php?correo='+correo+'&pass='+pass,      
                    success : function(res) { 
                                                
                        if(res == 0){       
                            $('#mensaje').html ('Información incorrecta');
                            setTimeout("$('#mensaje').html('')", 5000);
                            return false;
                        }else{

                            window.location.href ='autentica.php?correo='+correo;
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
    <div id="cuadro">
        <h1 align="center">Log in</h1>
        <h2 align="center">Bienvenido</h2>

            
        <div class="inputs">
            <br><br><br>
            
            <input type="email" name="correo" id="correo" class="btn" placeholder="Correo" /> <br><br>
            <input type="password" name="pass" id="pass"class="btn" placeholder="Password"/> <br>
            <h3 id="mensaje"></h3><br><br>

            <input  onclick= "return validar();" type="submit" value="LOG-IN" class="boton"/>
            <br>  
            <a href="alta.php" align="center" >Crear cuenta nueva</a>
  
        </div>
        

    </div>




</body>
</html>