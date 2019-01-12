<?php
/*require __DIR__.'/vendor/autoload.php';*/
require '../vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
//L = Horizontal apaisado P = Vertical portrait
/* Guia de formatos estaticos : 
github.com/tecnickcom/TCPDF/blob/master/include/tcpdf_static.php*/
/* Guia de diseño de paginas del pdf :
github.com/spipu/html2pdf/blob/master/doc/page.md
*/
if(isset($_GET["anio"])&&isset($_GET["profesion"])&&isset($_GET["tr"])){
	$anio = ""; $mes = ""; $nmes = ""; $evento = ""; $profesion = "";
	$tr = (isset($_GET["tr"]))?$_GET["tr"]:"";

	if(isset($_GET["tr"])&&$tr=="1"){
		$anio = $_GET["anio"];
		$profesion = $_GET["profesion"];
		$salida = $profesion."-registros-".$anio.".pdf";
	}
	else if(isset($_GET["tr"])&&$tr=="2"){
		$anio = $_GET["anio"];
		$mes = $_GET["mes"];
		$profesion = $_GET["profesion"];
		switch ($mes) {
			case 1: $nmes = "Enero"; $salida = $profesion."-registros-".$anio."-".$nmes.".pdf"; break;
			case 2: $nmes = "Febrero"; $salida = $profesion."-registros-".$anio."-".$nmes.".pdf"; break;
			case 3: $nmes = "Marzo"; $salida = $profesion."-registros-".$anio."-".$nmes.".pdf"; break;
			case 4: $nmes = "Abril"; $salida = $profesion."-registros-".$anio."-".$nmes.".pdf"; break;
			case 5: $nmes = "Mayo"; $salida = $profesion."-registros-".$anio."-".$nmes.".pdf"; break;
			case 6: $nmes = "Junio"; $salida = $profesion."-registros-".$anio."-".$nmes.".pdf"; break;
			case 7: $nmes = "Julio"; $salida = $profesion."-registros-".$anio."-".$nmes.".pdf"; break;
			case 8: $nmes = "Agosto"; $salida = $profesion."-registros-".$anio."-".$nmes.".pdf"; break;
			case 9: $nmes = "Septiembre"; $salida = $profesion."-registros-".$anio."-".$nmes.".pdf"; break;
			case 10: $nmes = "Octubre"; $salida = $profesion."-registros-".$anio."-".$nmes.".pdf"; break;
			case 11: $nmes = "Noviembre"; $salida = $profesion."-registros-".$anio."-".$nmes.".pdf"; break;
			case 12: $nmes = "Diciembre"; $salida = $profesion."-registros-".$anio."-".$nmes.".pdf"; break; 
		}		
	}
	else if(isset($_GET["tr"])&&$tr=="3"){
		$anio = $_GET["anio"];
		$mes = $_GET["mes"];
		$evento = $_GET["evento"];
		$profesion = $_GET["profesion"];
		switch ($mes) {
			case 1: $nmes = "Enero"; $salida = $profesion."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 2: $nmes = "Febrero"; $salida = $profesion."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 3: $nmes = "Marzo"; $salida = $profesion."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 4: $nmes = "Abril"; $salida = $profesion."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 5: $nmes = "Mayo"; $salida = $profesion."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 6: $nmes = "Junio"; $salida = $profesion."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 7: $nmes = "Julio"; $salida = $profesion."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 8: $nmes = "Agosto"; $salida = $profesion."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 9: $nmes = "Septiembre"; $salida = $profesion."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 10: $nmes = "Octubre"; $salida = $profesion."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 11: $nmes = "Noviembre"; $salida = $profesion."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 12: $nmes = "Diciembre"; $salida = $profesion."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break; 
		}		
	}
	ob_start();
	require_once "registros_profesion_rpt_page.php";
	$html = ob_get_clean();
	$html2pdf = new Html2Pdf('L', 'LETTER', 'es', 'UTF-8');
	$html2pdf->writeHTML($html);
	$html2pdf->output($salida,"D");
}
// Evitar cache de JS y otros
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>