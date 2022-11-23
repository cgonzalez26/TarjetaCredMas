<?php

define( 'BASE' , dirname( __FILE__ ) . '/../..');

include_once(  BASE . '/_global.php' );

#Control de Acceso al archivo
#if(!isLogin()){go_url("../index.php");}

$idUser = $_SESSION['ID_USER'];

//include db connection settings
error_reporting(E_ALL ^ E_NOTICE);

if (!isset($_SESSION["idProforma_"])){
	session_register("idProforma_");    
}
$_SESSION['idProforma_'] = $_GET['idProforma']; 

function getRowsFromDB($parent_id){
	
	GLOBAL $oMysql;
    $sConditions = "cuotas.idProforma='{$parent_id}' ORDER BY cuotas.dFechaCobro DESC";
	//$sOrder = "cuotas.dFechaCobro";
	$array=$oMysql->consultaSel("CALL usp_getProformasPagos(\"$sConditions\",\"\",\"\",\"\");");
	if(count($array)>0)
	{
		foreach ($array as $row){
			print("<row id='".$row['id']."'>");
		  	print("<cell><![CDATA[".$row['iNumCuota']."]]></cell>");
		  	print("<cell><![CDATA[".$row['dFechaCobro']."]]></cell>");		
		  	print("<cell><![CDATA[".$row['fMontoPago']."]]></cell>");				  	
			print("</row>");
		}
	}else{
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
	if(isset($_GET['idProforma']) && $_GET['idProforma'] != 0){
		getRowsFromDB($_GET['idProforma']);
	}
?>

</rows>
<!-- close grid xml -->