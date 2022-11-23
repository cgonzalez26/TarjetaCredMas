<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	
	function add_row(){
		global $newId;
		GLOBAL $oMysql;
		$set = "idPedido,sDescripcion,iCantidad,fPrecio,sEstado,fSubTotal";
		$values = "'{$_SESSION['idPedido_']}','{$_GET['sDescripcion']}','{$_GET['iCantidad']}','{$_GET['fPrecio']}','A','{$_GET['fSubTotal']}'";
		$ToAuditory = "Insercion de Productos en Pedido::: (idPedido,sNombre) <=> ({$_SESSION['idPedido_']}','{$_GET['sNombre']}')";
		//$newId = $oMysql->consultaSel("CALL usp_InsertTable(\"det_pedidos\",\"$set\",\"$values\");",true);
		$newId = $oMysql->consultaSel("CALL usp_InsertTable(\"DetallesPlanillasCobranzas\",\"$set\",\"$values\",\"{$_SESSION['ID_USER']}\",\"0\",\"$ToAuditory\");",true);
		$action = "insert";
		return $action;
	}
	
	function update_row(){
		GLOBAL $oMysql;
		$set = "fMontoPago1='{$_GET['fMontoPago1']}',fMontoPago2='{$_GET['fMontoPago2']}',fMontoPago3='{$_GET['fMontoPago3']}'";
		$sConditions = "DetallesPlanillasCobranzas.id = '{$_GET["gr_id"]}'";
		
		$sql = "UPDATE DetallesPlanillasCobranzas SET {$set} WHERE {$sConditions}";
		$newId = $oMysql->consultaSel($sql,true);
		
		$newId = $_GET["gr_id"];
		$action = "update";				
		return $action;
	}
	
	function delete_row(){
		GLOBAL $oMysql;
		$sConditions = "DetallesPlanillasCobranzas.id = '{$_GET['gr_id']}'";
		$ToAuditry = "Baja de Detalles Planillas Cobranzas::: {$_GET['gr_id']}";
		$set = "DetallesPlanillasCobranzas.sEstado='B'";
		$newId = $oMysql->consultaSel("CALL usp_UpdateTable(\"DetallesPlanillasCobranzas\",\"$set\",\"$sConditions\",\"{$_SESSION['ID_USER']}\",\"0\",\"$ToAuditry\");");
		//$newId = $_GET["gr_id"];
		$action = "delete";
		return $action;
	}
	

//include XML Header (as response will be in xml format)
//header("Content-type: text/xml");
header("Content-type: application/xhtml+xml"); 
//encoding may differ in your case
echo('<?xml version="1.0" encoding="iso-8859-1"?>'); 

$mode = $_GET["!nativeeditor_status"]; //get request mode
$rowId = $_GET["gr_id"]; //id or row which was updated 
$newId = $_GET["gr_id"]; //will be used for insert operation

switch($mode){
	case "inserted":
		//row adding request
		if(isset($_SESSION['idDetallesPlanillasCobranzas_']))
			$action = add_row();
	break;
	case "deleted":
		//row deleting request
		$action = delete_row();
	break;
	default:
		//row updating request
		$action = update_row();
	break;
}

?>
<data>
	<?php 
	if($newId != 0 && !is_null($newId)){
		print("<action type='".$action."' sid='".$_GET["gr_id"]."' tid='".$newId."'/>");
	}else{
		print("<action type='error'>$smsError</action>");
	}
	?>
</data>