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
		$conditions .= "cobranzas.idCobrador= '$idCobrador'";
		
	if($sCodigo != "")	
		if($conditions != "")
			$conditions .= " AND cobranzas.sCodigo = '$sCodigo'";
		else 	
			$conditions .= "cobranzas.sCodigo = '$sCodigo'";		

	if($dFechaDesde != ""){
		$FechaDesde = dateFormatMysql($dFechaDesde);
		if($conditions != "")
			$conditions .=  " AND cobranzas.dFechaCobranza >= '{$FechaDesde}'";
		else 
			$conditions .=  " cobranzas.dFechaCobranza >= '{$FechaDesde}'";
	}
	if($dFechaHasta != ""){
		$FechaHasta = dateFormatMysql($dFechaHasta);
		if($conditions != "")
			$conditions .= " AND cobranzas.dFechaCobranza <= '{$FechaHasta}'";
		else
			$conditions .=  " cobranzas.dFechaCobranza <= '{$FechaHasta}'";
	}		
	$conditions .= " AND cobranzas.sEstado<>'B'";
	//$sConditions = "pedidos.idEstadoPedido = 3 AND pedidos.sEstado<>'B'";
	//$sOrder = "pedidos.dFecha";
	$array = $oMysql->consultaSel("CALL usp_getCobranzas(\"$conditions\",\"\",\"\",\"\");");
		
	if(count($array)>0)
	{
		foreach ($array as $row){
			
			/*$sConditionsProductos = "det_pedidos.idPedido = '{$row['id']}' and sEstado<>'B'";	
			$arrayProductos=$oMysql->consultaSel("CALL usp_getProductosPedidos(\"$sConditionsProductos\",\"\",\"\",\"\");");
			$valuesProductos = "";
			if(count($arrayProductos)>0)
			{
				$arrayProd= array();
				foreach ($arrayProductos as $rowProducto){	
					$arrayProd[] = $rowProducto['sDescripcion'];
				}
				$valuesProductos = implode(',',$arrayProd);
			}*/
			
			
			print("<row id='".$row['id']."'>");
		  	print("<cell><![CDATA[".stripslashes($row['sCodigo'])."]]></cell>");
		  	print("<cell><![CDATA[".stripslashes($row['dFechaCobranza1'])."]]></cell>");
			print("<cell><![CDATA[".stripslashes($row['sCobrador'])."]]></cell>");		
			//print("<cell><![CDATA[".stripslashes($valuesProductos)."]]></cell>");	
			print("<cell><![CDATA[".unhtmlspecialchars($row['sEstadoCobranza'])."]]></cell>");	
			print("</row>");			
			
		}
		
	}
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

	if(isset($_SESSION['ID_USER'])){ $id = $_SESSION['ID_USER'] ; }else{$id = 0;}
	if(($_GET['idCobrador'])||($_GET['sCodigo'])||($_GET['dFechaDesde'])||($_GET['dFechaHasta']))	
	getRowsFromDB($_GET['idCobrador'],$_GET['sCodigo'],$_GET['dFechaDesde'],$_GET['dFechaHasta']);
		
	//getRowsFromDB(0);	
?>

</rows>
<!-- close grid xml -->