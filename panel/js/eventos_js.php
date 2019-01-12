window.onload = function(){
	<?php if ($modo=="S"){ ?>
		document.getElementById("agregar").onclick = function (){
			window.open("eventos.php?modo=A", "_self");
		}
	<?php } else if($modo=="B"){ ?>
		document.getElementById("si-borrar").onclick = function (){
			var id_evento = <?php print $id_evento; ?>;
			window.open("eventos.php?modo=D&id_evento="+id_evento, "_self");
		}
		document.getElementById("no-borrar").onclick = function (){
			window.open("eventos.php", "_self");
		}		
	<?php } else { ?>
		document.getElementById("regresar").onclick = function (){
			window.open("eventos.php", "_self");
		}
	<?php } ?>		
}
function cambiaPagina(p){
	window.open("eventos.php?p="+p, "_self");
}