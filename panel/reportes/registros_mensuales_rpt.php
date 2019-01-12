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
if(isset($_GET["anio"])&&isset($_GET["mes"])){
	$anio = $_GET["anio"];
	$mes = $_GET["mes"];
	$nmes = "";
	switch ($mes) {
		case 1: $nmes = "Enero"; $salida = "registros-".$anio."-".$nmes.".pdf"; break;
		case 2: $nmes = "Febrero"; $salida = "registros-".$anio."-".$nmes.".pdf"; break;
		case 3: $nmes = "Marzo"; $salida = "registros-".$anio."-".$nmes.".pdf"; break;
		case 4: $nmes = "Abril"; $salida = "registros-".$anio."-".$nmes.".pdf"; break;
		case 5: $nmes = "Mayo"; $salida = "registros-".$anio."-".$nmes.".pdf"; break;
		case 6: $nmes = "Junio"; $salida = "registros-".$anio."-".$nmes.".pdf"; break;
		case 7: $nmes = "Julio"; $salida = "registros-".$anio."-".$nmes.".pdf"; break;
		case 8: $nmes = "Agosto"; $salida = "registros-".$anio."-".$nmes.".pdf"; break;
		case 9: $nmes = "Septiembre"; $salida = "registros-".$anio."-".$nmes.".pdf"; break;
		case 10: $nmes = "Octubre"; $salida = "registros-".$anio."-".$nmes.".pdf"; break;
		case 11: $nmes = "Noviembre"; $salida = "registros-".$anio."-".$nmes.".pdf"; break;
		case 12: $nmes = "Diciembre"; $salida = "registros-".$anio."-".$nmes.".pdf"; break; 
	}
	ob_start();
	require_once "registros_mensuales_rpt_page.php";
	$html = ob_get_clean();
	$html2pdf = new Html2Pdf('L', 'LETTER', 'es', 'UTF-8');
	$html2pdf->writeHTML($html);
	$html2pdf->output($salida,"D");
}
// Evitar cache de JS y otros
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>