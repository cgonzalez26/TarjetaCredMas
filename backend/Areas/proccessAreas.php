<?php

	define( 'BASE' , dirname( __FILE__ ) . '/../..');

	include_once(  BASE . '/_global.php' );

	$iduser = $_SESSION['id_user'];
	
	global $oMysql;

if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
 		header("Content-type: application/xhtml+xml"); } else {
 		header("Content-type: text/xml");
}	
 	//header("Content-type: application/xhtml+xml"); 

	echo("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n");
	
	
	if(isset($_GET["!nativeeditor_status"]) && $_GET["!nativeeditor_status"] == 'inserted'){
		
			$_GET = stringToUpper($_GET);
		
			$set = "sNombre,sNumero,sEstado";
			
			$values = "'{$_GET['sNombre']}','{$_GET['sNumero']}','{$_GET['sEstado']}'";

			$toauditory = "insercion de Area ::: {$_GET['sNombre']}, '{$_GET['sNumero']}'";
			
			$iduser = $_SESSION['id_user'];

			$newId = $oMysql->consultaSel("CALL usp_InsertTable(\"Areas\",\"$set\",\"$values\",\"{$iduser}\",\"0\",\"$toauditory\");");

			$action = "insert";
		
	}elseif (isset($_GET["!nativeeditor_status"]) && $_GET["!nativeeditor_status"] == 'deleted'){
		
			$_GET = stringToUpper($_GET);

			$values = "Areas.id='{$_GET['gr_id']}'";

			$set = "Areas.sEstado='B'";

			$toauditory = "baja de Area ::: id = {$_GET['gr_id']}";

			$iduser = $_SESSION['id_user'];

			$newId = $oMysql->consultaSel("CALL usp_UpdateTable(\"Areas\",\"$set\",\"$values\",\"{$iduser}\",\"0\",\"$toauditory\");");
			
			$newId = $_GET["gr_id"];
			
			$action = "delete";	

	}else{
		
			$_GET = stringToUpper($_GET);
		
			$values = "Areas.id='{$_GET['gr_id']}'";

			$set = "sNombre='{$_GET['sNombre']}',sNumero='{$_GET['sNumero']}',sEstado='{$_GET['sEstado']}'";

			$toauditory = "actualizacion de datos de Area ::: id = {$_GET['gr_id']} \n Se modificaron los siguientes datos: \n sNombre='{$_GET['sNombre']}' \n sNumero='{$_GET['sNumero']}' \n sEstado='{$_GET['sEstado']}'";

			$iduser = $_SESSION['id_user'];

			$newId = $oMysql->consultaSel("CALL usp_UpdateTable(\"Areas\",\"$set\",\"$values\",\"{$iduser}\",\"0\",\"$toauditory\");");
			
			$newId = $_GET["gr_id"];
			
			$action = "update";

	}	
	
?>
<!-- response xml -->
<data>
	<?php 
	if($newId!=0){
		print("<action type='".$action."' sid='".$_GET["gr_id"]."' tid='".$newId."'/>");
	}else{
		print("<action type='error'>$smsError</action>");
	}
	?>
</data>

