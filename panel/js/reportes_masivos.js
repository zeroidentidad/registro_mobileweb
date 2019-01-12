window.onload = function(){
	document.getElementById("rpt_anual").onclick = function (){
		var vanio = $('#anio').val();
		if(vanio!=""){ window.open("./reportes/registros_anuales_rpt.php?anio="+vanio, "_self"); } else { alert("\nSELECCIONAR AÑO :("); }	
	}
	document.getElementById("rpt_mensual").onclick = function (){
		var vanio = $('#anio').val();
		var vmes = $('#mes').val();
		if(vanio!=""&&vmes!=""){ window.open("./reportes/registros_mensuales_rpt.php?anio="+vanio+"&mes="+vmes, "_self"); } else { alert("\nSELECCIONAR AÑO + MES :("); }
	}
	document.getElementById("rpt_evento").onclick = function (){
		var vanio = $('#anio').val();
		var vmes = $('#mes').val();
		var vevento = $('#evento').val();
		if(vanio!=""&&vmes!=""&&vevento!=""){ window.open("./reportes/registros_eventos_rpt.php?anio="+vanio+"&mes="+vmes+"&evento="+vevento, "_self"); } else { alert("\nSELECCIONAR AÑO + MES + EVENTO :("); }
	}
	/* RPTs por SEXO: */	
	document.getElementById("sexo_anual").onclick = function (){
		var vanio = $('#anio').val();
		var vsexo = $('#sexo').val();
		if(vanio!=""&&vsexo!=""){ window.open("./reportes/registros_sexo_rpt.php?anio="+vanio+"&sexo="+vsexo+"&tr=1", "_self"); } else { alert("\nSELECCIONAR AÑO + SEXO :("); }
	}
	document.getElementById("sexo_mensual").onclick = function (){
		var vanio = $('#anio').val();
		var vmes = $('#mes').val();
		var vsexo = $('#sexo').val();
		if(vanio!=""&&vmes!=""&&vsexo!=""){ window.open("./reportes/registros_sexo_rpt.php?anio="+vanio+"&mes="+vmes+"&sexo="+vsexo+"&tr=2", "_self"); } else { alert("\nSELECCIONAR AÑO + MES + SEXO :("); }
	}
	document.getElementById("sexo_evento").onclick = function (){
		var vanio = $('#anio').val();
		var vmes = $('#mes').val();
		var vevento = $('#evento').val();
		var vsexo = $('#sexo').val();
		if(vanio!=""&&vmes!=""&&vevento!=""&&vsexo!=""){ window.open("./reportes/registros_sexo_rpt.php?anio="+vanio+"&mes="+vmes+"&evento="+vevento+"&sexo="+vsexo+"&tr=3", "_self"); } else { alert("\nSELECCIONAR AÑO + MES + EVENTO + SEXO :("); }
	}				
	/* RPTs por PROFESION: */
	document.getElementById("prof_anual").onclick = function (){
		var vanio = $('#anio').val();
		var vprofesion = $('#profesion').val();
		if(vanio!=""&&vprofesion!=""){ window.open("./reportes/registros_profesion_rpt.php?anio="+vanio+"&profesion="+vprofesion+"&tr=1", "_self"); } else { alert("\nSELECCIONAR AÑO + PROFESIÓN :("); }
	}
	document.getElementById("prof_mensual").onclick = function (){
		var vanio = $('#anio').val();
		var vmes = $('#mes').val();
		var vprofesion = $('#profesion').val();
		if(vanio!=""&&vmes!=""&&vprofesion!=""){ window.open("./reportes/registros_profesion_rpt.php?anio="+vanio+"&mes="+vmes+"&profesion="+vprofesion+"&tr=2", "_self"); } else { alert("\nSELECCIONAR AÑO + MES + PROFESIÓN :("); }
	}
	document.getElementById("prof_evento").onclick = function (){
		var vanio = $('#anio').val();
		var vmes = $('#mes').val();
		var vevento = $('#evento').val();
		var vprofesion = $('#profesion').val();
		if(vanio!=""&&vmes!=""&&vevento!=""&&vprofesion!=""){ window.open("./reportes/registros_profesion_rpt.php?anio="+vanio+"&mes="+vmes+"&evento="+vevento+"&profesion="+vprofesion+"&tr=3", "_self"); } else { alert("\nSELECCIONAR AÑO + MES + EVENTO + PROFESIÓN :("); }
	}	

	/*Func Ajax manual en ComboBox "mes": */
	document.getElementById("mes").onchange = function(){
		var vanioc = $('#anio').val();
		var vmesc = $('#mes').val();
		cargarEventos(vanioc, vmesc);
	}		

}

function cargarEventos(vanioc, vmesc){
	if (vmesc.length==0) { return; }

	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	} else {
		// IE 5 - 6
		xmlhttp = new ActiveXObject("Microsoft.HMLHTTP");
		alert("Tu navegador no soporta XMLHTTP");
	}
	xmlhttp.onreadystatechange = function(){
		// Capturar estado 4 con 200
		if (xmlhttp.readyState==4) {
			if(xmlhttp.status==200){
				procesaXML(xmlhttp.responseXML);
			} else {
				alert("Error en lectura. Error: "+xmlhttp.status);
			}
		}
	}
	// GET o POST, url, true => Asincrono false => Sincrono
	xmlhttp.open("GET","./js/combos_ajax/xml_eventos.php?anio="+vanioc+"&mes="+vmesc,true);
	// Ejecutar lectura:
	xmlhttp.send();
}
function procesaXML(objetoXML){
	var nodo = objetoXML.documentElement.getElementsByTagName("evento");
	var combo_evento = document.getElementById("evento");
	// Limpiar combo:
	while(combo_evento.length) combo_evento.remove(0);
	//
	var option = document.createElement("option");
	option.innerHTML="-SELECCIONAR-";
	option.setAttribute("value","");
	combo_evento.appendChild(option);

	// Agregar valores del objeto:
	for (var i = 0; i < nodo.length; i++){ 
		id = nodo[i].getElementsByTagName("id_evento");
		idEvento = id[0].firstChild.nodeValue;
		//
		nombre = nodo[i].getElementsByTagName("nombre");
		nombreEvento = nombre[0].firstChild.nodeValue;
		//
		var option = document.createElement("option");
		option.innerHTML = nombreEvento;
		option.setAttribute("value",idEvento);
		combo_evento.appendChild(option);	
	}	
}