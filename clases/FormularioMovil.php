<?php

class FormularioMovil {

	public function insertar($conn, $id_folio, $anio, $id_evento, $nombre, $apellidos, $sexo, $profesion, $matricula, $email, $celular, $nota){
		$msg = array();

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
				array_push($msg, "0Resgistrado correctamente. Tu FOLIO es: ".mysqli_insert_id($conn)." </br>[Importante: anotarlo para identificar tus documentos]");
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

	/* Funciones data COMBOS: */

	public function combo_eventos($conn, $anio, $fecha){
		$sql = "SELECT * FROM eventos";
		/*$sql.= " WHERE anio=".$anio." AND MONTH(fecha)=".$fecha." AND estatus=1";*/
		$sql.= " WHERE anio=".$anio." AND fecha='".$fecha."' AND estatus=1";
		$sql.= " AND hora<=(SELECT time_format(now(), '%H:%i:%s'))";
		//$sql.= " AND hora<=(SELECT time_format(DATE_SUB(now(), INTERVAL 6 HOUR), '%H:%i:%s'))"; // cuando difs horaria en serv web
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