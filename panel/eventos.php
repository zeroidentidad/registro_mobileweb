<?php
require "util/sesion.php";
require "util/conn.php";
require "util/variables_globales.php";
require "clases/Eventos.php";

$evento_ = new Eventos();
$num = $evento_->numeroRegistros($conn);

require "util/variables_paginacion.php";

/*Modo de pagina ($_GET["modo"]):
S - Consulta (select)
A - Agregar (insert)
B - Baja (pantalla de confirmacion antes de eliminar)
C - Cambio (update)
D - Baja definitiva (delete)
*/

/** Variables de agregar **/
$id_evento = "";
$anio = "";
$nombre = "";
$lugar = "";
$fecha = "";
$hora = "";
$estatus = "";
$responsable = "";
$descripcion = "";

$filtro="";
$columna="";

// Validaciones modos:
if (isset($_GET["modo"])) {
	$modo = $_GET["modo"];
} else {
	$modo = "S";
}

// Delete definitivo
if ($modo=="D") {
	$id_evento = $_GET["id_evento"];
	$msg = $evento_->delete($conn, $id_evento);
}

// Deteccion insert-update por isset
if (isset($_POST["nombre"])){
	
	$id_evento = (isset($_POST["id_evento"]))?$_POST["id_evento"]:"";
	$anio = $_POST["anio"];
	$nombre = $_POST["nombre"];
	$lugar = $_POST["lugar"];
	$fecha = $_POST["fecha"];
	$hora = $_POST["hora"];
	$estatus = $_POST["estatus"];
	$responsable = $_POST["responsable"];
	$descripcion = $_POST["descripcion"];

	$msg = $evento_->insert_update($conn, $id_evento, $anio, $nombre, $lugar, $fecha, $hora, $estatus, $responsable, $descripcion);

}

// Modo consulta general tabla paginada
if ($modo=="S") {
	$datos = $evento_->select($conn, $inicio_p, $TAMANO_PAGINA, "", "");
}

if (isset($_POST['buscar'])){
	$filtro = $_POST["buscarpor"];
	$columna = $_POST["columna"];
	$datos = $evento_->select($conn, $inicio_p, $TAMANO_PAGINA, $filtro, $columna);
}

// Modo cambio en registro
if ($modo=="C" || $modo=="B") {
	$id_evento = (isset($_GET["id_evento"]))?$_GET["id_evento"]:$id_evento;
	$datos = $evento_->obtener($conn, $id_evento);
	//paso datos del GET
	$nombre = $datos["nombre"];
	$lugar = $datos["lugar"];
	$fecha = $datos["fecha"];
	$hora = $datos["hora"];
	$estatus = $datos["estatus"];
	$responsable = $datos["responsable"];
	$descripcion = addslashes(htmlentities($datos["descripcion"]));
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
	<script src="./js/ckeditor5/ckeditor.js"></script>
	<!-- JS-CSS JAFS -->
	<link rel="stylesheet" href="./css/estilos.css">	
	<script type="text/javascript"><?php require "./js/eventos_js.php"; ?></script>
</head>

<body>
	<?php require "menu-nav.php" ?>

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav mt-5">
				<?php if($modo=="S"){ ?>
					<div class="form-group">
					<label for="agregar"></label>
					<input type="button" name="agregar" value="NUEVO EVENTO" class="btn btn-info" role="button" id="agregar">
					</div>
					<form method="post" action="eventos.php">
						<div class="form-group">
						<input class="text-left" type="text" id="buscarpor" name="buscarpor" value='<?php print $filtro ?>' placeholder="Buscar nombre..." />
						</div>
						<!-- -->
						<div class="form-group"> 
						<select class="dropdown" id="columna" name="columna">
							<option value="">-SELECCIONAR-</option>
							<option <?php if($columna=='nombre') print 'selected'; ?> value="nombre">NOMBRE</option>
							<option <?php if($columna=='id_evento') print 'selected'; ?> value="id_evento">NUMERO</option>
						</select>
						</div>
					    <!-- --> <!-- cuando se requiera agregar filtros -->
						<div class="form-group">
						<input type="submit" id="buscar" name="buscar" value="BUSCAR" class="btn btn-outline-secondary" role="button" />
						</div>
					</form>
				<?php } ?>				
			</div>
			<div class="col-sm-8 text-center">
				<h2>Eventos <?php print "(".$num.")"; ?></h2>
				<?php
				require "util/mensajes.php";
				if($modo=="A" || $modo=="C" || $modo=="B"){
				?>
				<form class="text-left" action="eventos.php" method="post">
					<div class="form-group">
						<label for="nombre"><b>* N O M B R E :</b></label>
						<input type="text" name="nombre" id="nombre" class="form-control" required placeholder="El nombre del evento"
						value="<?php print $nombre; ?>" <?php if($modo=="B") print 'disabled'; ?> maxlength="349" />
					</div>
					<div class="form-group">
						<label for="lugar"><b>* L U G A R :</b></label>
						<input type="text" name="lugar" id="lugar" class="form-control" required placeholder="Lugar donde se llevara a cabo" value="<?php print $lugar; ?>" <?php if($modo=="B") print 'disabled'; ?> maxlength="349" />
					</div>
					<div class="form-group">
						<label for="fecha"><b>* F E C H A :</b></label>
						<input type="date" name="fecha" id="fecha" class="form-control" required placeholder="Fecha" value="<?php print $fecha; ?>" <?php if($modo=="B") print 'disabled'; ?>
						/>
					</div>					
					<div class="form-group">
						<label for="hora"><b>* H O R A :</b></label>
						<input type="time" name="hora" id="hora" class="form-control" required placeholder="La hora establecida"
						value="<?php print $hora; ?>" <?php if($modo=="B") print 'disabled'; ?>
						/>
					</div>
					<div class="form-group">
						<label for="estatus"><b>* E S T A T U S :</b></label><br>
						<select class="dropdown" id="estatus" name="estatus" required>
						<option value="">-SELECCIONAR-</option>
						<option <?php if($estatus==1) print 'selected'; ?> value="1">ACTIVO</option>
						<option <?php if($estatus==2) print 'selected'; ?> value="2">INACTIVO</option>
						</select>
					</div>					
					<div class="form-group">
						<label for="responsable"><b>R E S P O N S A B L E :</b></label>
						<input type="text" name="responsable" id="responsable" class="form-control" placeholder="Nombre de quien esta a cargo el evento" value="<?php print $responsable; ?>" <?php if($modo=="B") print 'disabled'; ?> maxlength="99" />
					</div>
					<div class="form-group">
						<label for="descripcion"><b>D E S C R I P C I Ó N :</b></label>
						<textarea name="descripcion" id="descripcion" <?php if($modo=="B") print 'disabled'; ?> rows="10" maxlength="999" > <?php print $descripcion; ?> </textarea>
					</div>									

					<!-- Campos ocultos necesarios: -->
					<input type="hidden" name="id_evento" id="id_evento" value="<?php print $id_evento; ?>" />
					<input type="hidden" name="anio" id="anio" value="<?php print date("Y"); ?>"/>
					<!-- -------------------------- -->

					<div class="form-group">
						<?php if($modo=="A" || $modo=="C"){ ?>
						<label for="enviar"></label>
						<input type="submit" name="enviar" id="enviar" class="btn btn-success" role="button" value="ENVIAR" />
						<label for="regresar"></label>
						<input type="button" name="regresar" id="regresar" class="btn btn-info" role="button" value="REGRESAR" />
						<?php } 

						if($modo=="B"){
						?>
						<label for="si-borrar">¿Desea borrar el registro?</label>
						<input type="button" name="si-borrar" id="si-borrar" class="btn btn-danger" role="button" value="SI" />
						<input type="button" name="no-borrar" id="no-borrar" class="btn btn-danger" role="button" value="NO" />
						<p>Una vez borrado el registro NO se podra recuperar.</p>
						<?php } ?>
					</div><br>								
				</form>
				<?php }

				if ($modo=="S") {
					print '<div class="table-responsive">';
					print '<table class="table table-striped" with="100%">';
					print '<tr>';
					print '<th>Num. Evento</th>';
					print '<th>Evento</th>';
					print '<th>Modificar</th>';
					print '<th>Borrar</th>';
					print '</tr>';
					for ($i=0; $i < count($datos); $i++) { 
					print '<tr>';
					print '<td>'.$datos[$i]["id_evento"].'</td>';
					print '<td>'.$datos[$i]["nombre"].'</td>';
					print '<td><a class="btn btn-info" href="eventos.php?modo=C&id_evento='.$datos[$i]["id_evento"].'">M</a></td>';
					print '<td><a class="btn btn-warning" href="eventos.php?modo=B&id_evento='.$datos[$i]["id_evento"].'">B</a></td>';
					print '</tr>';
					}
					print '</table>';
					print '</div>';

					/**** PAGINACION TABLA ****/
					require "util/paginar_tabla_html.php";
					
				}

				?>
			</div>
			<div class="col-sm-2 sidenav"></div>
		</div>
	</div>

	<?php require "footer.php";?>
</body>
</html>
 <script>
    ClassicEditor
        .create( document.querySelector( '#descripcion' ) )
        .catch( error => {
            console.error( error );
        } );
</script>