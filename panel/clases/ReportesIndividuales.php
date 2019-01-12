<?php
/***/
class ReportesIndividuales {

	public function select($conn, $inicio="", $maximo="", $filtro="", $columna=""){
		$sql = "SELECT * FROM asistencias";
		if($filtro!==""){
			if ($columna=="folio") {
				$sql.= " WHERE id_folio=".$filtro." AND anio=".date("Y");
			} else if($columna=="nombre"){
				$sql.= " WHERE CONCAT_WS (' ', nombre, apellidos) LIKE UPPER('%".$filtro."%') AND anio=".date("Y");
			} else if($columna=="matricula"){
				$sql.= " WHERE matricula LIKE '%".$filtro."%' AND anio=".date("Y");
			}			
		} else {$sql.= " WHERE anio=".date("Y");}
		$sql.= " ORDER BY id_folio";
		if($inicio!=="" && $maximo!==""){
			$sql.= " LIMIT ".$inicio.", ".$maximo;
		}
		$r = mysqli_query($conn, $sql);
		$arreglo = array();

		if ($r) {
			while ($row = mysqli_fetch_assoc($r)) {
				array_push($arreglo, $row);
			}
		}

		return $arreglo;
	}

	public function numeroRegistros($conn){
		$num = 0;
		$sql = "SELECT COUNT(*) AS num FROM asistencias WHERE anio=".date("Y");
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}	

	/* Funciones de reportes: */

	public function numeroRegistrosReporte($conn, $id_folio){
		$num = 0;
		$sql = "SELECT COUNT(*) AS num FROM asistencias a";
		$sql.= " WHERE a.anio=".date("Y");
		$sql.= " AND id_folio=".$id_folio;		
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}

	public function select_asistencia($conn, $id_folio){
		$salida = "1Error al obtener el registro";

		mysqli_query($conn, "SET lc_time_names = 'es_ES';");

		$sql = "SELECT a.*,";
		$sql.= " (SELECT e.nombre FROM eventos e WHERE e.id_evento=a.id_evento) AS evento_descripcion,";
		$sql.= " (SELECT e.lugar FROM eventos e WHERE e.id_evento=a.id_evento) AS lugar_evento,";
		$sql.= " (SELECT e.responsable FROM eventos e WHERE e.id_evento=a.id_evento) AS responsable_evento,";
		$sql.= " (SELECT DATE_FORMAT(e.fecha,'%d de %M del %Y') AS fecha FROM eventos e WHERE e.id_evento=a.id_evento) AS fecha_evento,";
		$sql.= " CASE WHEN a.sexo=1 THEN 'FEMENINO' WHEN a.sexo=2 THEN 'MASCULINO' END AS sexo_descripcion,";
		$sql.= " (SELECT cp.nombre FROM cat_profesiones cp WHERE cp.id_profesion=a.profesion) AS profesion_descripcion";
		$sql.= " FROM asistencias a WHERE a.id_folio=".$id_folio;
		$sql.= " AND a.anio=".date("Y");
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$salida = mysqli_fetch_assoc($r);
		}
		return $salida;
	}

}

?>