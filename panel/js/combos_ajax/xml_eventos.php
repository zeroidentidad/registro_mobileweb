<?php
require "../../util/conn.php";
$anio = (isset($_GET["anio"]))?$_GET["anio"]:"";
$mes = (isset($_GET["mes"]))?$_GET["mes"]:"";
$sql = "SELECT * FROM eventos e WHERE e.anio=".$anio." AND MONTH(e.fecha)=".$mes;
$sql.= " ORDER BY e.nombre";
$r = mysqli_query($conn, $sql);
// Generar XML:
print header("Content-type:text/xml");
print "<?xml version='1.0' encoding='UTF-8'?>";
print "<eventos>";
while ($datos = mysqli_fetch_object($r)){
	$id_evento = $datos->id_evento;
	$nombre = $datos->nombre;
 // crear nodo
	print "<evento>";
	print "<id_evento>".$id_evento."</id_evento>";
	print "<nombre>".$nombre."</nombre>";
	print "</evento>";	
}
print "</eventos>";
mysqli_close($conn);
?>