<?php
/***/
class Registros {

	public function select($conn, $inicio="", $maximo="", $filtro="", $columna=""){
		$sql = "SELECT * FROM asistencias";
		if($filtro!==""){
			if ($columna=="folio") {
				$sql.= " WHERE id_folio=".$filtro." AND anio=".date("Y");
			} else if($columna=="nombre"){
				$sql.= " WHERE CONCAT_WS (' ', nombre, apellidos) LIKE UPPER('%".$filtro."%') AND anio=".date("Y");
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

	public function delete($conn, $id_folio){
		$sql = "DELETE FROM asistencias WHERE id_folio=".$id_folio;

		if (mysqli_query($conn, $sql)) {
			header("location:registros.php");
			}
		$msg = array("1Error al eliminar el registro.");

		return $msg;
	}

	public function obtener($conn, $id_folio){
		$datos = "1Error al obtener el registro.";
		$sql = "SELECT * FROM asistencias WHERE id_folio=".$id_folio;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}

	public function insert_update($conn, $id_folio, $anio, $id_evento, $nombre, $apellidos, $sexo, $profesion, $matricula, $email, $celular, $nota){
		$msg = array();

		if ($id_evento=="") {
			array_push($msg, "2El evento es requerido.");
		} else if($nombre==""){
			array_push($msg, "2El nombre es requerido.");
		} else if($apellidos==""){
			array_push($msg, "2El apellido es requerido.");
		} else if($sexo==""){
			array_push($msg, "2El sexo es requerido.");
		} else if($profesion==""){
			array_push($msg, "2La profesión es requerida.");
		} else {
			if ($id_folio=="") {
				$sql = "INSERT INTO asistencias VALUES(0,";
				$sql.= $anio.", ";
				$sql.= $id_evento.", ";
				$sql.= "UPPER('".$nombre."'), ";
				$sql.= "UPPER('".$apellidos."'), ";
				$sql.= $sexo.", ";
				$sql.= $profesion.", ";
				$sql.= "'".$matricula."', ";
				$sql.= "'".$email."', ";
				$sql.= "'".$celular."', ";
				$sql.= "'".$nota."')";
			}else{
				$sql = "UPDATE asistencias SET ";
				$sql.= "id_evento='".$id_evento."', ";
				$sql.= "nombre='".$nombre."', ";				
				$sql.= "apellidos='".$apellidos."', ";				
				$sql.= "sexo='".$sexo."', ";			
				$sql.= "profesion='".$profesion."', ";		
				$sql.= "matricula='".$matricula."', ";	
				$sql.= "email='".$email."', ";
				$sql.= "celular='".$celular."', ";
				$sql.= "nota='".$nota."' ";
				$sql.= "WHERE id_folio=".$id_folio;				
			}

			if (mysqli_query($conn, $sql)) {
				if ($id_folio=="") {
				array_push($msg, "0Guardado correcto. FOLIO: ".mysqli_insert_id($conn));
				}else{
				array_push($msg, "0Guardado correcto. FOLIO: ".$id_folio);
				}
			}else{
				
				if (mysqli_errno($conn)==1062){
					array_push($msg, "1No duplicar: Este registro ya existe. Considera registrarte a otro envento.");
				}
				else if(mysqli_errno($conn)==1040){
					array_push($msg, "2Demasiadas conexiones: La configuración del servidor de base de datos no soporta la cantidad de conexiones actuales.");
				}			
				else{
					array_push($msg, "1Error en el guardado. Recargar e intentar nuevamente. </br>Error ".mysqli_errno($conn).": ".mysqli_error($conn));					
				}

			}

			return $msg;
		}		

	}

	/* Funciones data COMBOS: */

	public function combo_eventos($conn, $anio, $mes){
		$sql = "SELECT * FROM eventos";
		$sql.= " WHERE anio=".$anio." AND MONTH(fecha)=".$mes." AND estatus=1";
	 /* $sql.= " AND hora<=(SELECT time_format(now(), '%H:%i:%s'))"; */
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


}

?>