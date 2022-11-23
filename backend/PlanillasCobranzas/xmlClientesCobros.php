<?php

define( 'BASE' , dirname( __FILE__ ) . '/../..');

include_once(  BASE . '/_global.php' );

#Control de Acceso al archivo
#if(!isLogin()){go_url("../index.php");}

$idUser = $_SESSION['ID_USER'];

//include db connection settings
error_reporting(E_ALL ^ E_NOTICE);

if (!isset($_SESSION["idPlanillaCobranza_"])){
	session_register("idPlanillaCobranza_");    
}
$_SESSION['idPlanillaCobranza_'] = $_GET['idPlanillaCobranza']; 

function getRowsFromDB($parent_id,$idTipoPlan){
	
	GLOBAL $oMysql;
    //$sConditions = "det_cobranzas.idCobranza='$parent_id' AND det_cobranzas.idPlanPago='$idTipoPlan' ORDER BY det_cobranzas.idPlanPago,det_cobranzas.idProforma ASC";
    $sConditions = "DetallesPlanillasCobranzas.idPlanillaCobranza='$parent_id' AND DetallesPlanillasCobranzas.idPlanPago='$idTipoPlan'";
	
	$array=$oMysql->consultaSel("CALL usp_getDetallesPlanillasCobranzas(\"$sConditions\",\"\",\"\",\"\");");
	if(count($array)>0)
	{
		$i=1;
		$header=true;
		foreach ($array as $row){
			/*$sConditionsProductos = "det_pedidos.idPedido = '{$row['idProforma']}' and sEstado<>'B'";			
			$arrayProductos=$oMysql->consultaSel("CALL usp_getProductosPedidos(\"$sConditionsProductos\",\"\",\"\",\"\");");
			$valuesProductos = "";
			$fTotal=0;
			if(count($arrayProductos)>0)
			{
				$arrayProd= array();
				foreach ($arrayProductos as $rowProducto){	
					$arrayProd[] = $rowProducto['sDescripcion'];
				}
				$valuesProductos = implode(',',$arrayProd);
			}*/
			$fTotal=0;
			$fMontoPago1 = "";
			if($row['fMontoPago1'] != 0) 
				if((int)$row['fMontoPago1'] == $row['fMontoPago1'])
					$fMontoPago1 = number_format($row['fMontoPago1'], 0, '.', '');
				else
					$fMontoPago1 = number_format($row['fMontoPago1'], 2, '.', '');

			$fMontoPago2 = "";
			if($row['fMontoPago2'] != 0) 
				if((int)$row['fMontoPago2'] == $row['fMontoPago2'])
					$fMontoPago2 = number_format($row['fMontoPago2'], 0, '.', '');
				else
					$fMontoPago2 = number_format($row['fMontoPago2'], 2, '.', '');
			$fMontoPago3 = "";
			if($row['fMontoPago3'] != 0) 
				if((int)$row['fMontoPago3'] == $row['fMontoPago3'])
					$fMontoPago3 = number_format($row['fMontoPago3'], 0, '.', '');
				else
					$fMontoPago3 = number_format($row['fMontoPago3'], 2, '.', '');
		 	
			if((int)$row['fMonto'] == $row['fMonto'])
				$row['fMonto'] = number_format($row['fMonto'], 0, '.', '');
			else
				$row['fMonto'] = number_format($row['fMonto'], 2, '.', '');
			
			print("<row id='".$row['id']."'>");
		  	print("<cell><![CDATA[".stripslashes($row['sCliente'])."]]></cell>");
		  	print("<cell><![CDATA[".stripslashes($row['NotasPedidosNumero'])."]]></cell>");
		  	print("<cell><![CDATA[".$row['fMonto']."]]></cell>");		
		  	print("<cell><![CDATA[".$fMontoPago1."]]></cell>");	
			print("<cell><![CDATA[".$fMontoPago2."]]></cell>");	
			print("<cell><![CDATA[".$fMontoPago3."]]></cell>");	
			print("</row>");
		}
	}else{
		//print("<row id='0'><cell></cell><cell></cell><cell></cell><cell></cell><cell></cell><cell></cell></row>");
		echo count($array);
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
	//if(isset($_GET['idPlanillaCobranza']) && $_GET['idPlanillaCobranza'] != 0){
		getRowsFromDB($_GET['idPlanillaCobranza'],$_GET['tipoPlan']);
	//}
?>

</rows>
<!-- close grid xml -->