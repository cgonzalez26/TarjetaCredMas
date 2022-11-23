<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');

	include_once(  BASE . '/_global.php' );

	error_reporting(E_ALL ^ E_NOTICE);

	if (!isset($_SESSION["idEmpleadoEdicion"])){
    	session_register("idEmpleadoEdicion");    
    }
	$_SESSION['idEmpleadoEdicion'] = $_GET['idEmpleadoEdicion'];    	
	
	function get_rows_from_DB($parent_id){
		
		global $oMysql;	
		
		$sub_query = " WHERE EmpleadosObservaciones.idEmpleado='{$parent_id}' AND EmpleadosObservaciones.sEstado='A'";
		
		$aObservaciones = $oMysql->consultaSel("CALL usp_getEmpleadosObservaciones(\"$sub_query\");");
		
		if(!$aObservaciones){

		}else{
			foreach ($aObservaciones as $aObservacion){								
				/*if($aObservacion['sEstado'] == "B"){
					$style = "background:#E3C8F4;";
				}*/				
				print("<row id='".$aObservacion['id']."' style=\"$style\">");
				print("<cell><![CDATA[".stripslashes($aObservacion['dFechaRegistro'])."]]></cell>");
				print("<cell format='%m/%d/%Y'><![CDATA[".stripslashes($aObservacion['dFechaEvento'])."]]></cell>");
				print("<cell><![CDATA[".stripslashes($aObservacion['sDescripcion'])."]]></cell>");
				print("<cell><![CDATA[".$aObservacion['idEmpleado']."]]></cell>");
				print("</row>");			
			}
		}
		
	}


if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
 		header("Content-type: application/xhtml+xml"); } else {
 		header("Content-type: text/xml");
}
echo("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n"); 
?>

<!-- start grid xml -->
<rows id="0">
	
<?php 
    $si = (isset($_GET['idEmpleadoEdicion']))?$_GET['idEmpleadoEdicion']:-1;
	get_rows_from_DB($si);
?>

</rows>
<!-- close grid xml -->