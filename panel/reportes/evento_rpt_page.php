<?php
require "../util/conn.php";
require "../clases/EventosReportes.php";

$evento = new EventosReportes();
//
$evento_array = $evento->select_evento($conn, $id_evento);

// Evitar cache de JS y otros
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>
<style>
	*{margin:0; padding: 0;}
	table.page_header {width: 100%; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
    table.page_footer {width: 100%; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}
    h1 {color: #000000}
    h2 {color: #000000}
    h3 {color: #000055}
    div.nivel,p{
		padding-left: 0mm;
		font-size: 18px;
		text-align: justify;
		line-height: 20pt;
    }
</style>
		<!-- pageset="old" heredar de la pag anterior conf estilos, diseño-->	
		<page backtop="16mm" backbottom="14mm" backleft="10mm" backright="10mm" style="font-size: 12pt" backimg="">

			<page_header>
				<table class="page_header">
					<tr>
						<td style="width: 100%; text-align: center;">
							<h3><?php print "Evento no. ".$evento_array["id_evento"] ?></h3>
						</td>
					</tr>
				</table>
			</page_header>
			<page_footer>
				<table class="page_footer">
					<tr>
						<td style="width: 33%; text-align: left;">
							Fecha: <?php print date("d")." / ".date("m")." / ". date("Y"); ?>
						</td>
						<td style="width: 34%; text-align: center;">
							Página [[page_cu]] de [[page_nb]]
						</td>
						<td style="width: 33%; text-align: right;">
							<a>softcun.co.nf</a>
						</td>												
					</tr>
				</table>				
			</page_footer>
	<?php
			$t = $evento_array["id_evento"];

			print '<bookmark title="'.$evento_array["nombre"].'" level="0"></bookmark>';
			print '<br>';
			print '<br><h2 style="text-align:center;"><u>Detalles de:</u></h2>';
			print '<br><br>';
			print '<bookmark title="'.$t.'" level="1"></bookmark>';

			print "<div>";
			print '<h1 style="text-align:center;"><strong>'.$evento_array["nombre"].'</strong></h1>';
			print '<br>';
			print '<p style="text-align:justify;">Fecha y hora del evento: <strong>'.$evento_array["fechadf"].'</strong> a las <strong>'.$evento_array["horatf"].'</strong>.</p>';
			print '<p style="text-align:justify;">Lugar donde se realizar&aacute;: <strong>'.$evento_array["lugar"].'</strong>.</p>';
			print '<p style="text-align:justify;">Responsable de la organizaci&oacute;n: <strong>'.$evento_array["responsable"].'</strong>.</p>';
			print '<br>';
			print '<p style="text-align:justify;">Descripci&oacute;n:</p>';
			print '<br>';
			print "</div>";

			print "<div class='nivel'>";
			print html_entity_decode($evento_array["descripcion"]);
			print "</div>";				

		print '</page>';
	?>