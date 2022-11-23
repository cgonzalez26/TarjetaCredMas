<?php

	define( 'BASE' , dirname( __FILE__ ) . '/../..');

	include_once(  BASE . '/_global.php' );

	$iduser = $_SESSION['id_user'];
	
	global $oMysql;

	if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) 
	{
 		header("Content-type: application/xhtml+xml"); 
	}
	else 
	{
 		header("Content-type: text/xml");
	}	
 	//header("Content-type: application/xhtml+xml"); 

	echo("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n");
	
	
	if(isset($_GET["!nativeeditor_status"]) && $_GET["!nativeeditor_status"] == 'inserted')
	{
			$_GET = stringToUpper($_GET);
			
			$dFechaRegistro = date("Y-m-d");
			
			$iduser = $_SESSION['id_user'];
			
			$set = "		
					dFechaRegistro,			
					sNombre,
					sDescripcion,
					sStoreProcedure,
					sEstado,
					idEmpleado
					";
			
			$values = "	
					'{$dFechaRegistro}',
					'{$_GET['sNombre']}',
					'{$_GET['sDescripcion']}',
					'{$_GET['sStoreProcedure']}',
					'{$_GET['sEstado']}',
					'{$iduser}'
					";

			$toauditory = "insercion de Variable Tipo de Ajuste ::: {$_GET['sNombre']}";
			
			$newId = $oMysql->consultaSel("CALL usp_InsertTable(\"VariablesTiposAjustes\",\"$set\",\"$values\",\"{$iduser}\",\"64\",\"$toauditory\");", true);			
			
			$action = "insert";
		
	}elseif (isset($_GET["!nativeeditor_status"]) && $_GET["!nativeeditor_status"] == 'deleted')
	{		
			$_GET = stringToUpper($_GET);
					
			$values = "VariablesTiposAjustes.id='{$_GET['gr_id']}'";

			$set = "VariablesTiposAjustes.sEstado='B'";

			$toauditory = "baja de Variables Tipos Ajustes ::: id = {$_GET['gr_id']}";

			$iduser = $_SESSION['id_user'];

			$newId = $oMysql->consultaSel("CALL usp_UpdateTable(\"TiposAjustes\",\"$set\",\"$values\",\"{$iduser}\",\"0\",\"$toauditory\");");
			
			$newId = $_GET["gr_id"];
			
			$action = "delete";	

	}else{
			$_GET['sNombre'] = strtoupper($_GET['sNombre']);
			$_GET['sDescripcion'] = strtoupper($_GET['sDescripcion']);
			$_GET['sEstado'] = strtoupper($_GET['sEstado']);
			$iduser = $_SESSION['id_user'];
							
			$values = "VariablesTiposAjustes.id='{$_GET['gr_id']}'";

			$set = "
					sNombre='{$_GET['sNombre']}',
					sDescripcion='{$_GET['sDescripcion']}',
					sStoreProcedure='{$_GET['sStoreProcedure']}',										
					sEstado='{$_GET['sEstado']}'	
					";		
	
			$toauditory = "actualizacion de datos de Variables Tipos de Ajustes ::: id = {$_GET['gr_id']}";

			
			$newId = $oMysql->consultaSel("CALL usp_UpdateTable(\"VariablesTiposAjustes\",\"$set\",\"$values\",\"{$iduser}\",\"65\",\"$toauditory\");");
			
			$newId = $_GET["gr_id"];
			
			$action = "update";

	}	
	
?>
<!-- response xml -->
<data>
	<?php 
	if($newId!=0){
		print("<action type='".$action."' sid='".$_GET["gr_id"]."' tid='".$newId."'/>");
		//print("<action type='insertCodigo' sid='".$_GET["gr_id"]."' tid='".$newId."' sCodigo='".$sCodigo."'/>");
	}else{
		print("<action type='error'>$smsError</action>");
	}
	?>
</data>

