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
		
			//$sCodigo=$oMysql->consultaSel("select usp_getTasasIVA();",true);
			
			//$dFechaRegistro = date("Y-m-d");
			
			$iduser = $_SESSION['id_user'];
			
			$set = "					
					sNombre,					
					fTasa,
					sDescripcion,
					sEstado
					";
			
			$values = "		
					'{$_GET['sNombre']}',					
					'{$_GET['fTasa']}',
					'{$_GET['sDescripcion']}',
					'{$_GET['sEstado']}'					
					";

			$toauditory = "insercion de Tasa IVA ::: {$_GET['sNombre']}";
			
			$newId = $oMysql->consultaSel("CALL usp_InsertTable(\"TasasIVA\",\"$set\",\"$values\",\"{$iduser}\",\"62\",\"$toauditory\");", true);			
			
			$action = "insert";
		
	}elseif (isset($_GET["!nativeeditor_status"]) && $_GET["!nativeeditor_status"] == 'deleted')
	{
		
			$_GET = stringToUpper($_GET);

			$values = "TiposAjustes.id='{$_GET['gr_id']}'";

			$set = "TiposAjustes.sEstado='B'";

			$toauditory = "baja de Ajustes ::: id = {$_GET['gr_id']}";

			$iduser = $_SESSION['id_user'];

			$newId = $oMysql->consultaSel("CALL usp_UpdateTable(\"TiposAjustes\",\"$set\",\"$values\",\"{$iduser}\",\"0\",\"$toauditory\");");
			
			$newId = $_GET["gr_id"];
			
			$action = "delete";	

	}else{		
			$_GET = stringToUpper($_GET);
		
			$iduser = $_SESSION['id_user'];			
				
			$values = "TasasIVA.id='{$_GET['gr_id']}'";

			$set = "
					sNombre='{$_GET['sNombre']}',
					sDescripcion='{$_GET['sDescripcion']}',
					fTasa='{$_GET['fTasa']}',
					sEstado='{$_GET['sEstado']}'
					";		
	
			$toauditory = "actualizacion de Tasa IVA ::: id = {$_GET['gr_id']}";

			$newId = $oMysql->consultaSel("CALL usp_UpdateTable(\"TasasIVA\",\"$set\",\"$values\",\"{$iduser}\",\"63\",\"$toauditory\");");
			
			$newId = $_GET["gr_id"];
			
			$action = "update";
	}		
?>
<!-- response xml -->

<data>
	<?php 
	if($newId!=0){
		print("<action type='".$action."' sid='".$_GET["gr_id"]."' tid='".$newId."' id='".$sCodigo."'/>");
		//print("<action type='insertCodigo' sid='".$_GET["gr_id"]."' tid='".$newId."' sCodigo='".$sCodigo."'/>");
	}else{
		print("<action type='error'>$smsError</action>");
	}
	?>
</data>