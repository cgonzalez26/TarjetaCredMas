<?php

	define( 'BASE' , dirname( __FILE__ ) . '/../..');

	include_once(  BASE . '/_global.php' );

	$iduser = $_SESSION['id_user'];
	
	global $oMysql;
	$hoy = date('d/m/Y');

if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
 		header("Content-type: application/xhtml+xml"); } else {
 		header("Content-type: text/xml");
}	
 	//header("Content-type: application/xhtml+xml"); 

	echo("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n");
	
	
	if(isset($_GET["!nativeeditor_status"]) && $_GET["!nativeeditor_status"] == 'inserted'){
		
			$_GET = stringToUpper($_GET);

	 		$_GET['dFechaEvento'] = dateToMySql($_GET['dFechaEvento']);
	 		 
			$set = "dFechaRegistro,dFechaEvento,sDescripcion,sEstado,idEmpleado";
			
			$values = "NOW(),'{$_GET['dFechaEvento']}','{$_GET['sDescripcion']}','A','{$_SESSION['idEmpleadoEdicion']}'";

			$toauditory = "Insercion de Observaciones a Empleado ::: Usuario:'{$_SESSION['id_user']}'";
			
			$iduser = $_SESSION['id_user'];

			$newId = $oMysql->consultaSel("CALL usp_InsertTable(\"EmpleadosObservaciones\",\"$set\",\"$values\",\"{$iduser}\",\"0\",\"$toauditory\");");
			
			$action = "insert";
		
	}elseif (isset($_GET["!nativeeditor_status"]) && $_GET["!nativeeditor_status"] == 'deleted'){
		
			$_GET = stringToUpper($_GET);

			$values = "EmpleadosObservaciones.id='{$_GET['gr_id']}'";

			$set = "EmpleadosObservaciones.sEstado='B'";

			$toauditory = "Baja de Observaciones ::: id = {$_GET['gr_id']}";

			$iduser = $_SESSION['id_user'];

			$newId = $oMysql->consultaSel("CALL usp_UpdateTable(\"EmpleadosObservaciones\",\"$set\",\"$values\",\"{$iduser}\",\"0\",\"$toauditory\");");
			
			$newId = $_GET["gr_id"];
			
			$action = "delete";	

	}else{
		
			$_GET = stringToUpper($_GET);
			$_GET['dFechaEvento'] = dateToMySql($_GET['dFechaEvento']);
			
			$values = "EmpleadosObservaciones.id='{$_GET['gr_id']}'";

			$set = "dFechaEvento='{$_GET['dFechaEvento']}',sDescripcion='{$_GET['sDescripcion']}'";

			$toauditory = "Actualizacion de Datos de Observaciones ::: id = {$_GET['gr_id']} \n";

			$iduser = $_SESSION['id_user'];

			$newId = $oMysql->consultaSel("CALL usp_UpdateTable(\"EmpleadosObservaciones\",\"$set\",\"$values\",\"{$iduser}\",\"0\",\"$toauditory\");");
			/*$oMysql->startTransaction();
			$oMysql->consultaAff("CALL usp_UpdateTable(\"EmpleadosObservaciones\",\"$set\",\"$values\",\"{$iduser}\",\"0\",\"$toauditory\");");
			$oMysql->commit();*/
			
			$newId = $_GET["gr_id"];
			
			$action = "update";

	}	
	
?>
<!-- response xml -->
<data>
	<?php 
	if($newId!=0){
		print("<action type='".$action."' sid='".$_GET["gr_id"]."' tid='".$newId."' hoy='{$hoy}' />");
	}else{
		print("<action type='error'>$smsError</action>");
	}
	?>
</data>

