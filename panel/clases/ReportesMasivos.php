<?php
/***/
class ReportesMasivos {

	public function numeroRegistros($conn){
		$num = 0;
		$sql = "SELECT COUNT(*) AS num FROM asistencias";
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}

	/* Funciones data COMBOS: */	

	public function combo_profesiones($conn){
		$sql = "SELECT * FROM cat_profesiones";
		$sql.= " ORDER BY nombre";
		$r = mysqli_query($conn, $sql);
		$arreglo = array();

		if ($r) {
			while ($row = mysqli_fetch_assoc($r)) {
				array_push($arreglo, $row);
			}
		}

		return $arreglo;
	}

	public function combo_anios($conn){
		$sql = "SELECT DISTINCT anio FROM asistencias";
		$sql.= " ORDER BY anio DESC";
		$r = mysqli_query($conn, $sql);
		$arreglo = array();

		if ($r) {
			while ($row = mysqli_fetch_assoc($r)) {
				array_push($arreglo, $row);
			}
		}

		return $arreglo;
	}

	/* Funciones de reportes: */

	public function numeroRegistrosReporte($conn, $anio="", $mes="", $evento="", $sexo="", $profesion=""){
		$num = 0;
		$sql = "SELECT COUNT(*) AS num FROM asistencias a";
		$sql.= " WHERE";
		$sql.= " a.anio=".$anio;
		if ($mes!==""&&$evento==""){
		$sql.= " AND a.id_evento IN (SELECT e.id_evento FROM eventos e WHERE e.anio=".$anio." AND MONTH(e.fecha)=".$mes.")";
		}
		if ($evento!==""){
		$sql.= " AND a.id_evento=".$evento;
		}		
		if ($sexo!==""){
		$sql.= " AND a.sexo=".$sexo;
		}
		if ($profesion!==""){
		$sql.= " AND a.profesion=".$profesion;
		}
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}

	public function select_asistencias($conn, $anio="", $mes="", $evento="", $sexo="", $profesion=""){
		$salida = "1Error al obtener el registro";

		$sql = "SELECT a.*,";
		$sql.= " CASE WHEN a.sexo=1 THEN 'FEMENINO' WHEN a.sexo=2 THEN 'MASCULINO' END AS sexo_descripcion,";
		$sql.= " (SELECT cp.nombre FROM cat_profesiones cp WHERE cp.id_profesion=a.profesion) AS profesion_descripcion,";
		$sql.= " (SELECT ev.nombre FROM eventos ev WHERE ev.id_evento=a.id_evento) AS evento_descripcion";
		$sql.= " FROM asistencias a";
		$sql.= " WHERE";
		$sql.= " a.anio=".$anio;
		if ($mes!==""&&$evento==""){
		$sql.= " AND a.id_evento IN (SELECT e.id_evento FROM eventos e WHERE e.anio=".$anio." AND MONTH(e.fecha)=".$mes.")";
		}
		if ($evento!==""){
		$sql.= " AND a.id_evento=".$evento;
		}		
		if ($sexo!==""){
		$sql.= " AND a.sexo=".$sexo;
		}
		if ($profesion!==""){
		$sql.= " AND a.profesion=".$profesion;
		}
		$sql.= " ORDER BY a.id_folio ASC";
		$r = mysqli_query($conn, $sql);
		$salida = array();
		if ($r) {
			while($row = mysqli_fetch_assoc($r)){
				array_push($salida, $row);
			}
		}
		return $salida;
	}

	public function select_profesion($conn, $profesion){
		$datos = "1Error al obtener el registro.";
		$sql = "SELECT * FROM cat_profesiones WHERE id_profesion=".$profesion;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}

}

?>