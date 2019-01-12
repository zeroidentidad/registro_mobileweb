window.onload = function(){
	<?php if ($modo=="S"){ ?>
			document.getElementById("anual").onclick = function (){
				var vanio = <?php print date("Y"); ?>;
				window.open("./reportes/eventos_lista_rpt.php?mes&anio="+vanio, "_self");
			}
			document.getElementById("mensual").onclick = function (){
				var vaniom = <?php print date("Y"); ?>;
				var vmes = $('#mes').val();
				if(vmes==""){
					alert ("VALOR MES REQUERIDO :(");
				}else{
					window.open("./reportes/eventos_lista_rpt.php?mes="+vmes+"&anio="+vaniom, "_self");	
				}
			}			
	<?php } ?>			
}
function cambiaPagina(p){
	window.open("eventos_reportes.php?p="+p, "_self");
}