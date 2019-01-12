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
if(isset($_GET["anio"])&&isset($_GET["sexo"])&&isset($_GET["tr"])){
	$anio = ""; $mes = ""; $nmes = ""; $evento = "";
	$sexo = ""; $nsexo = ($_GET["sexo"]=='1')?"Mujeres":"Hombres";
	$tr = (isset($_GET["tr"]))?$_GET["tr"]:"";

	if(isset($_GET["tr"])&&$tr=="1"){
		$anio = $_GET["anio"];
		$sexo = $_GET["sexo"];
		$salida = $nsexo."-registros-".$anio.".pdf";
	}
	else if(isset($_GET["tr"])&&$tr=="2"){
		$anio = $_GET["anio"];
		$mes = $_GET["mes"];
		$sexo = $_GET["sexo"];
		switch ($mes) {
			case 1: $nmes = "Enero"; $salida = $nsexo."-registros-".$anio."-".$nmes.".pdf"; break;
			case 2: $nmes = "Febrero"; $salida = $nsexo."-registros-".$anio."-".$nmes.".pdf"; break;
			case 3: $nmes = "Marzo"; $salida = $nsexo."-registros-".$anio."-".$nmes.".pdf"; break;
			case 4: $nmes = "Abril"; $salida = $nsexo."-registros-".$anio."-".$nmes.".pdf"; break;
			case 5: $nmes = "Mayo"; $salida = $nsexo."-registros-".$anio."-".$nmes.".pdf"; break;
			case 6: $nmes = "Junio"; $salida = $nsexo."-registros-".$anio."-".$nmes.".pdf"; break;
			case 7: $nmes = "Julio"; $salida = $nsexo."-registros-".$anio."-".$nmes.".pdf"; break;
			case 8: $nmes = "Agosto"; $salida = $nsexo."-registros-".$anio."-".$nmes.".pdf"; break;
			case 9: $nmes = "Septiembre"; $salida = $nsexo."-registros-".$anio."-".$nmes.".pdf"; break;
			case 10: $nmes = "Octubre"; $salida = $nsexo."-registros-".$anio."-".$nmes.".pdf"; break;
			case 11: $nmes = "Noviembre"; $salida = $nsexo."-registros-".$anio."-".$nmes.".pdf"; break;
			case 12: $nmes = "Diciembre"; $salida = $nsexo."-registros-".$anio."-".$nmes.".pdf"; break; 
		}		
	}
	else if(isset($_GET["tr"])&&$tr=="3"){
		$anio = $_GET["anio"];
		$mes = $_GET["mes"];
		$evento = $_GET["evento"];
		$sexo = $_GET["sexo"];
		switch ($mes) {
			case 1: $nmes = "Enero"; $salida = $nsexo."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 2: $nmes = "Febrero"; $salida = $nsexo."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 3: $nmes = "Marzo"; $salida = $nsexo."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 4: $nmes = "Abril"; $salida = $nsexo."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 5: $nmes = "Mayo"; $salida = $nsexo."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 6: $nmes = "Junio"; $salida = $nsexo."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 7: $nmes = "Julio"; $salida = $nsexo."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 8: $nmes = "Agosto"; $salida = $nsexo."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 9: $nmes = "Septiembre"; $salida = $nsexo."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 10: $nmes = "Octubre"; $salida = $nsexo."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 11: $nmes = "Noviembre"; $salida = $nsexo."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break;
			case 12: $nmes = "Diciembre"; $salida = $nsexo."-registros-".$anio."-".$nmes."-Evto_".$evento.".pdf"; break; 
		}		
	}
	ob_start();
	require_once "registros_sexo_rpt_page.php";
	$html = ob_get_clean();
	$html2pdf = new Html2Pdf('L', 'LETTER', 'es', 'UTF-8');
	$html2pdf->writeHTML($html);
	$html2pdf->output($salida,"D");
}
// Evitar cache de JS y otros
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>