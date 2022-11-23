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
		
			
			$sCodigo=$oMysql->consultaSel("select fnc_getCodigoRetencionGanancias();",true);
			//$sCodigo=$oMysql->consultaSel("select fnc_getCodigoAjuste();",true);
			
			$dFechaRegistro = date("Y-m-d");
			
			$iduser = $_SESSION['id_user'];
			
			$set = "
					sCodigo,					
					sDescripcion,
					fPorcentajeRetencion,
					fImporteMinimoRetencion,
					fImporteMinimoExcluido,
					sEstadoRetencion,
					idEmpleado,
					dFechaRegistro
					";
			
			$values = "		
					'{$sCodigo}',
					'{$_GET['sDescripcion']}',
					'{$_GET['fPorcentajeRetencion']}',					
					'{$_GET['fImporteMinimoRetencion']}',
					'{$_GET['fImporteMinimoExcluido']}',
					'{$_GET['sEstadoRetencion']}',
					'{$iduser}',
					'{$dFechaRegistro}'
					";

			$toauditory = "insercion de Retenciones de Ganancias ::: {$_GET['sNombre']}";
			
			$newId = $oMysql->consultaSel("CALL usp_InsertTable(\"RetencionesGanancias\",\"$set\",\"$values\",\"{$iduser}\",\"33\",\"$toauditory\");", true);			
			
			$action = "insert";
		
	}elseif (isset($_GET["!nativeeditor_status"]) && $_GET["!nativeeditor_status"] == 'deleted')
	{
		
			$_GET = stringToUpper($_GET);

			$values = "RetencionesGanancias.id='{$_GET['gr_id']}'";

			$set = "RetencionesGanancias.sEstadoRetencion='B'";

			$toauditory = "baja de Ajustes ::: id = {$_GET['gr_id']}";

			$iduser = $_SESSION['id_user'];

			$newId = $oMysql->consultaSel("CALL usp_UpdateTable(\"RetencionesGanancias\",\"$set\",\"$values\",\"{$iduser}\",\"0\",\"$toauditory\");");
			
			$newId = $_GET["gr_id"];
			
			$action = "delete";	

	}else{
		
			$_GET = stringToUpper($_GET);
		
			$iduser = $_SESSION['id_user'];
			
				
			$values = "RetencionesGanancias.id='{$_GET['gr_id']}'";

			$set = "
					sDescripcion='{$_GET['sDescripcion']}',
					fPorcentajeRetencion='{$_GET['fPorcentajeRetencion']}',
					fImporteMinimoRetencion='{$_GET['fImporteMinimoRetencion']}',
					fImporteMinimoExcluido='{$_GET['fImporteMinimoExcluido']}',
					sEstadoRetencion='{$_GET['sEstadoRetencion']}'					
					";		
	
			$toauditory = "actualizacion de datos de Retenciones de Ganancias ::: id = {$_GET['gr_id']}";

			

			$newId = $oMysql->consultaSel("CALL usp_UpdateTable(\"RetencionesGanancias\",\"$set\",\"$values\",\"{$iduser}\",\"34\",\"$toauditory\");");
			
			$newId = $_GET["gr_id"];
			
			$action = "update";

	}	
	
?>
<!-- response xml -->
<data>
	<?php 
	if($newId!=0){
		print("<action type='".$action."' sid='".$_GET["gr_id"]."' tid='".$newId."' sCodigo='".$sCodigo."'/>");
		//print("<action type='insertCodigo' sid='".$_GET["gr_id"]."' tid='".$newId."' sCodigo='".$sCodigo."'/>");
	}else{
		print("<action type='error'>$smsError</action>");
	}
	?>
</data>

