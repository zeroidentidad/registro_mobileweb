<?php
require "util/sesion.php";
require "util/conn.php";
require "util/variables_globales.php";
require "clases/EventosReportes.php";

$reporte_evento_ = new EventosReportes();
$num = $reporte_evento_->numeroRegistros($conn);

require "util/variables_paginacion.php";

/*Modo de pagina ($_GET["modo"]):
S - Consulta (select)
*/

// Validaciones modos:
if (isset($_GET["modo"])) {
	$modo = $_GET["modo"];
} else {
	$modo = "S";
}

// Modo consulta general tabla paginada
if ($modo=="S") {
	$datos = $reporte_evento_->select($conn, $inicio_p, $TAMANO_PAGINA);
}

 // Evitar cache de JS y otros
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Eventos</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="./js/librerias_ui/popper.min.js"></script>
	<!--<script src="./js/librerias_ui/jquery-3.3.1.min.js"></script>-->	<!-- cuando se requiera AJAX -->
	<script src="./js/librerias_ui/jquery-3.3.1.slim.min.js"></script>	
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<script src="./js/librerias_ui/bootstrap.min.js"></script>
	<!-- JS-CSS JAFS -->
	<link rel="stylesheet" href="./css/estilos.css">	
	<script type="text/javascript"><?php require "./js/eventos_reportes_js.php"; ?></script>
</head>

<body>
	<?php require "menu-nav.php" ?>

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav mt-5">
				<?php if($modo=="S"){ ?>
					<div class="form-group">
					<label for="anual"></label>
					<input type="button" name="anual" value="LISTA ANUAL" class="btn btn-info" role="button" id="anual">
					</div>
					<!-- -->
					<div class="form-group">
						<label for="mes"><b>MES:</b></label>
						<select class="dropdown" id="mes" name="mes">
							<option value="">-SELECCIONAR-</option>
							<option value="1">ENERO</option>
							<option value="2">FEBRERO</option>
							<option value="3">MARZO</option>
							<option value="4">ABRIL</option>
							<option value="5">MAYO</option>
							<option value="6">JUNIO</option>
							<option value="7">JULIO</option>
							<option value="8">AGOSTO</option>
							<option value="9">SEPTIEMBRE</option>
							<option value="10">OCTUBRE</option>
							<option value="11">NOVIEMBRE</option>
							<option value="12">DICIEMBRE</option>
						</select>
					</div>
					<!-- --> <!-- cuando se requiera agregar filtros -->					
					<div class="form-group">					
					<label for="mensual"></label>
					<input type="button" name="mensual" value="LISTA MENSUAL" class="btn btn-info" role="button" id="mensual">
					</div>					
				<?php } ?>				
			</div>
			<div class="col-sm-8 text-center">
				<h2>Reportes de eventos <?php print "(".$num.")"; ?></h2>
				<?php require "util/mensajes.php"; ?>
				<div class="table-responsive">
				<?php

				if ($modo=="S") {
					print '<table class="table table-striped" with="100%">';
					print '<tr>';
					print '<th>Num. Evento</th>';
					print '<th>Evento</th>';
					print '<th>Fecha</th>';
					print '<th>Imprimir datos</th>';
					print '</tr>';
					for ($i=0; $i < count($datos); $i++) { 
					print '<tr>';
					print '<td>'.$datos[$i]["id_evento"].'</td>';
					print '<td>'.$datos[$i]["nombre"].'</td>';
					print '<td>'.$datos[$i]["fecha"].'</td>';
					print '<td><a class="btn btn-outline-secondary" href="reportes/evento_rpt.php?id_evento='.$datos[$i]["id_evento"]/*.'&anio='.$datos[$i]["anio"]*/.'">PDF</a></td>';
					print '</tr>';
					}
					print '</table>';
					print '</div>';

					/**** PAGINACION TABLA ****/
					require "util/paginar_tabla_html.php";
					
				}

				?>
			</div>
		</div>
	</div>

	<?php require "footer.php";?>
</body>
</html>