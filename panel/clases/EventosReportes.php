<?php
/***/
class EventosReportes {

	public function select($conn, $inicio="", $maximo=""){
		$sql = "SELECT * FROM eventos  WHERE anio=".date("Y")." ORDER BY fecha DESC";
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
		$sql = "SELECT COUNT(*) AS num FROM eventos";
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}	

	/* Funciones de reportes: */

	public function numeroRegistrosReporte($conn, $anio, $mes){
		$num = 0;
		$sql = "SELECT COUNT(*) AS num FROM eventos e";
		$sql.= " WHERE e.anio=".$anio;
		if($mes!==""){
		$sql.= " AND MONTH(e.fecha)=".$mes;
		}		
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}

	public function select_eventos($conn, $anio, $mes){
		$datos = "1Error al obtener los eventos";
		$sql = "SELECT e.*,";
		$sql.= " DATE_FORMAT(e.fecha,'%d/%m/%Y') AS fechadf,";
		$sql.= " TIME_FORMAT(e.hora, '%r') AS horatf";
		$sql.= " FROM eventos e WHERE e.anio=".$anio;
		if($mes!==""){
		$sql.= " AND MONTH(e.fecha)=".$mes;
		}
		$sql.= " ORDER BY e.fecha";
		$r = mysqli_query($conn, $sql);
		$salida = array();
		if ($r) {
			while($row = mysqli_fetch_assoc($r)){
				array_push($salida, $row);
			}
		}
		return $salida;
	}

	public function select_evento($conn, $id_evento){
		$salida = "1Error al obtener el evento";
		$sql = "SELECT e.*,";
		$sql.= " DATE_FORMAT(e.fecha,'%d/%m/%Y') AS fechadf,";
		$sql.= " TIME_FORMAT(e.hora, '%r') AS horatf";
		$sql.= " FROM eventos e WHERE e.id_evento=".$id_evento;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$salida = mysqli_fetch_assoc($r);
		}
		return $salida;
	}

}

?>