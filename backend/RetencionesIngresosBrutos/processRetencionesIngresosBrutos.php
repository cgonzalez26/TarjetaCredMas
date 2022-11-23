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
		
			$sCodigo=$oMysql->consultaSel("select fnc_getCodigoRetencionesIngresosBrutos();",true);
			
			$dFechaRegistro = date("Y-m-d");
			
			$iduser = $_SESSION['id_user'];
			
			$set = "
					sCodigo,					
					sDescripcion,
					fPorcentajeRetencion,
					fImporteMinimoRetencion,
					sEstadoRetencion,
					idEmpleado,
					dFechaRegistro
					";
			
			$values = "		
					'{$sCodigo}',
					'{$_GET['sDescripcion']}',
					'{$_GET['fPorcentajeRetencion']}',					
					'{$_GET['fImporteMinimoRetencion']}',
					'{$_GET['sEstadoRetencion']}',
					'{$iduser}',
					'{$dFechaRegistro}'
					";

			$toauditory = "insercion de Porcentajes de Retencion Ingresos Brutos ::: {$_GET['sNombre']}";
			
			$newId = $oMysql->consultaSel("CALL usp_InsertTable(\"RetencionesIngresosBrutos\",\"$set\",\"$values\",\"{$iduser}\",\"37\",\"$toauditory\");", true);			
			
			$action = "insert";
		
	}elseif (isset($_GET["!nativeeditor_status"]) && $_GET["!nativeeditor_status"] == 'deleted')
	{
		
			$_GET = stringToUpper($_GET);

			$values = "RetencionesIngresosBrutos.id='{$_GET['gr_id']}'";

			$set = "RetencionesIngresosBrutos.sEstadoRetencion='B'";

			$toauditory = "baja de Retenciones Ingresos Brutos ::: id = {$_GET['gr_id']}";

			$iduser = $_SESSION['id_user'];

			$newId = $oMysql->consultaSel("CALL usp_UpdateTable(\"RetencionesIngresosBrutos\",\"$set\",\"$values\",\"{$iduser}\",\"0\",\"$toauditory\");");
			
			$newId = $_GET["gr_id"];
			
			$action = "delete";	

	}else{
		
			$_GET = stringToUpper($_GET);
		
			$iduser = $_SESSION['id_user'];
			
				
			$values = "RetencionesIngresosBrutos.id='{$_GET['gr_id']}'";

			$set = "
					sDescripcion='{$_GET['sDescripcion']}',
					fPorcentajeRetencion='{$_GET['fPorcentajeRetencion']}',
					fImporteMinimoRetencion='{$_GET['fImporteMinimoRetencion']}',
					sEstadoRetencion='{$_GET['sEstadoRetencion']}'					
					";		
	
			$toauditory = "actualizacion de datos de Retenciones Ingresos Brutos ::: id = {$_GET['gr_id']}";

			
			$newId = $oMysql->consultaSel("CALL usp_UpdateTable(\"RetencionesIngresosBrutos\",\"$set\",\"$values\",\"{$iduser}\",\"38\",\"$toauditory\");");
			
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

