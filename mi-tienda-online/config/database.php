<?php
    /*$cadenaConexion="mysql:dbname=php_database; host=localhost";*/
    $cadenaConexion="mysql:dbname=tienda; host=localhost";
    $usuario="root";
    $clave="";
    $bd= new PDO($cadenaConexion, $usuario, $clave);
?>