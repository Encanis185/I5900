<?php
//    Nconstante   valor de la constante
define("HOST", 'localhost'); // LOCALHOST O 127.0.0.0
define("BD",'cliente');
define("USER_BD",'root'); // USUARIO root SUELE SER EL PREDETERMINADO   //AQUÍ ES DONDE SE DEFINEN LAS CONSTANTES
define("PASS_BD",''); 

function conecta(){
    $con = new mysqli(HOST, USER_BD, PASS_BD, BD); 
    return $con;
}

?>