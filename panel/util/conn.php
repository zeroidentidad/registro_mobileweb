<?php
$_host = "172.30.213.218"; //localhost
$_usuario = "remoto"; //root
$_clave = "x1234567"; //
$_db = "dbregistros"; //dbregistros
$_puertos = "3306";
$conn = mysqli_connect($_host, $_usuario, $_clave, $_db, $_puertos) or die("ADVERTENCIA: No hay conexión a la base de datos.");
mysqli_set_charset($conn,"utf8");
?>