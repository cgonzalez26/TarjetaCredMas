<?php

define( 'BASE' , dirname( __FILE__ ) . '/../..');

include_once(  BASE . '/_global.php' );

#Control de Acceso al archivo
#if(!isLogin()){go_url("../index.php");}

$idUser = $_SESSION['ID_USER'];

//include db connection settings
error_reporting(E_ALL ^ E_NOTICE);


function getRowsFromDB($idCobrador,$sCodigo,$dFechaDesde,$dFechaHasta){
	
	GLOBAL $oMysql;
	$conditions = "";		
	if($idCobrador != 0)
		$conditions .= "PlanillasCobranzas.idCobrador= '$idCobrador'";
		
	if($sCodigo != "")	
		if($conditions != "")
			$conditions .= " AND PlanillasCobranzas.sCodigo = '$sCodigo'";
		else 	
			$conditions .= "PlanillasCobranzas.sCodigo = '$sCodigo'";		

	if($dFechaDesde != ""){
		$FechaDesde = dateFormatMysql($dFechaDesde);
		if($conditions != "")
			$conditions .=  " AND PlanillasCobranzas.dFechaRegistro >= '{$FechaDesde}'";
		else 
			$conditions .=  " PlanillasCobranzas.dFechaRegistro >= '{$FechaDesde}'";
	}
	if($dFechaHasta != ""){
		$FechaHasta = dateFormatMysql($dFechaHasta);
		if($conditions != "")
			$conditions .= " AND PlanillasCobranzas.dFechaRegistro <= '{$FechaHasta} 24:00:00'";
		else
			$conditions .=  " PlanillasCobranzas.dFechaRegistro <= '{$FechaHasta} 24:00:00'";
	}		
	$conditions .= " AND PlanillasCobranzas.sEstado<>'B'";
	//var_export($conditions);
	//$sConditions = "pedidos.idEstadoPedido = 3 AND pedidos.sEstado<>'B'";
	//$sOrder = "pedidos.dFecha";
	$array = $oMysql->consultaSel("CALL usp_getPlanillasCobranzas(\"$conditions\",\"\",\"\",\"\");");
	//var_export(count($array));
	if(count($array)>0)
	{
		foreach ($array as $row){
			print("<row id='".$row['id']."'>");
		  	print("<cell><![CDATA[".stripslashes($row['sCodigo'])."]]></cell>");
		  	print("<cell><![CDATA[".stripslashes($row['dFechaCobranza1'])."]]></cell>");
			print("<cell><![CDATA[".stripslashes($row['sCobrador'])."]]></cell>");		
			print("<cell><![CDATA[".stripslashes($row['sEstadoCobranza'])."]]></cell>");	
			print("</row>");			
			
		}		
	}/*else{
		print("<row id='0'><cell></cell><cell></cell><cell></cell><cell></cell></row>");
	}*/
}

//include XML Header (as response will be in xml format)
if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
 		header("Content-type: application/xhtml+xml"); } else {
 		header("Content-type: text/xml");
}

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n"; 

?>

<!-- start grid xml -->
<rows id="0">
	
<?php	

	//if(isset($_SESSION['ID_USER'])){ $id = $_SESSION['ID_USER'] ; }else{$id = 0;}
	//if(($_GET['idCobrador'])||($_GET['sCodigo'])||($_GET['dFechaDesde'])||($_GET['dFechaHasta']))	
	getRowsFromDB($_GET['idCobrador'],$_GET['sCodigo'],$_GET['dFechaDesde'],$_GET['dFechaHasta']);
		
	//getRowsFromDB(0);	
?>

</rows>
<!-- close grid xml -->