<?php
/***/
class Eventos {

	public function select($conn, $inicio="", $maximo="", $filtro="", $columna=""){
		$sql = "SELECT * FROM eventos";
		if($filtro!==""){
			if ($columna=="id_evento") {
				$sql.= " WHERE id_evento=".$filtro." AND anio=".date("Y");
			} else if($columna=="nombre"){
				$sql.= " WHERE nombre LIKE '%".$filtro."%' AND anio=".date("Y");
			}
		} else {$sql.= " WHERE anio=".date("Y");}
		$sql.= " ORDER BY id_evento";
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
		$sql = "SELECT COUNT(*) AS num FROM eventos WHERE anio=".date("Y");
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}	

	public function delete($conn, $id_evento){
		$sql = "DELETE FROM eventos WHERE id_evento=".$id_evento;

		if (mysqli_query($conn, $sql)) {
			header("location:eventos.php");
			}
		$msg = array("1Error al eliminar el registro.");

		return $msg;
	}

	public function obtener($conn, $id_evento){
		$datos = "1Error al obtener el registro.";
		$sql = "SELECT * FROM eventos WHERE id_evento=".$id_evento;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}

	public function insert_update($conn, $id_evento, $anio, $nombre, $lugar, $fecha, $hora, $estatus, $responsable, $descripcion){
		$msg = array();

		if ($nombre=="") {
			array_push($msg, "2El nombre del evento es requerido.");
		} else if($fecha==""){
			array_push($msg, "2La fecha del evento es requerida.");
		} else if($hora==""){
			array_push($msg, "2La hora del evento es requerida.");
		} else if($estatus==""){
			array_push($msg, "2El estatus es requerido.");
		} else {
			if ($id_evento=="") {
				$sql = "INSERT INTO eventos VALUES(0,";
				$sql.= "'".$anio."', ";
				$sql.= "'".$nombre."', ";
				$sql.= "'".$lugar."', ";
				$sql.= "'".$fecha."', ";
				$sql.= "'".$hora."', ";
				$sql.= "'".$estatus."', ";
				$sql.= "'".$responsable."', ";
				$sql.= "'".$descripcion."')";
			}else{
				$sql = "UPDATE eventos SET ";
				$sql.= "nombre='".$nombre."', ";
				$sql.= "lugar='".$lugar."', ";
				$sql.= "fecha='".$fecha."', ";
				$sql.= "hora='".$hora."', ";
				$sql.= "estatus='".$estatus."', ";
				$sql.= "responsable='".$responsable."', ";
				$sql.= "descripcion='".$descripcion."' ";				
				$sql.= "WHERE id_evento=".$id_evento;				
			}

			if (mysqli_query($conn, $sql)) {
				array_push($msg, "0Guardado correcto.");
			}else{
				
				if(mysqli_errno($conn)==1040){
					array_push($msg, "2Demasiadas conexiones: La configuración del servidor de base de datos no soporta la cantidad de conexiones actuales.");
				}			
				else{
					array_push($msg, "1Error en el guardado. Recargar e intentar nuevamente. </br>Error ".mysqli_errno($conn).": ".mysqli_error($conn));					
				}

			}

			return $msg;
		}		

	}

}

?>