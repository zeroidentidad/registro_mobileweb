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
if(isset($_GET["anio"])){
	$anio = $_GET["anio"];
	$mes = $_GET["mes"];
	if (isset($_GET["mes"])&&$_GET["mes"]!==""){
		switch ($mes) {
		    case 1: $salida = $anio."-Enero-lista.pdf"; break;
		    case 2: $salida = $anio."-Febrero-lista.pdf"; break;
		    case 3: $salida = $anio."-Marzo-lista.pdf"; break;
		    case 4: $salida = $anio."-Abril-lista.pdf"; break;
		    case 5: $salida = $anio."-Mayo-lista.pdf"; break;
		    case 6: $salida = $anio."-Junio-lista.pdf"; break;
		    case 7: $salida = $anio."-Julio-lista.pdf"; break;
		    case 8: $salida = $anio."-Agosto-lista.pdf"; break;
		    case 9: $salida = $anio."-Septiembre-lista.pdf"; break;
		    case 10: $salida = $anio."-Octubre-lista.pdf"; break;
		    case 11: $salida = $anio."-Noviembre-lista.pdf"; break;
		    case 12: $salida = $anio."-Diciembre-lista.pdf"; break;
		    default: $salida = $anio."-lista.pdf"; break; 
		}
	} else{
		$salida = $anio."-lista.pdf";
	}
	ob_start();
	require_once "eventos_lista_rpt_page.php";
	$html = ob_get_clean();
	$html2pdf = new Html2Pdf('P', 'LETTER', 'es', 'UTF-8');
	$html2pdf->writeHTML($html);
	$html2pdf->output($salida,"D");
}
// Evitar cache de JS y otros
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>