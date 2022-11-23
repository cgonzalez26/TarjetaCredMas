<?php 
//session_start();
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$idUser = $_SESSION['id_user'];
$TypeUser = $_SESSION['id_tuser'];
$aParametros = array();
$aParametros = getParametrosBasicos(1);

$oXajax=new xajax();
$oXajax->registerFunction("registrarDevolucionTarjetasCreditos");
$oXajax->processRequest();
$oXajax->printJavascript( "../includes/xajax/");

$sTarjetas = $_GET['sTarjetas'];
$idLoteCorreo = $_GET['id'];
$optionEditar = $_GET['optionEditar'];
$sTitulo = "Registro de Devoluciones de Tarjetas Creditos";

function registrarDevolucionTarjetasCreditos($form){
	GLOBAL $oMysql;	
	$oRespuesta = new xajaxResponse();
	$sTarjetas = $form['sTarjetas'];
	$aTarjetas = explode(",",$sTarjetas);
	
	foreach ($aTarjetas as $idTarjeta){
		$setTarjeta = "Tarjetas.idTipoEstadoTarjeta = '6'";
    	$conditionsTarjeta = "Tarjetas.id = '{$idTarjeta}'";
		$ToAuditoryTarjeta = "Update Estado Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=2";		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Tarjetas\",\"$setTarjeta\",\"$conditionsTarjeta\",\"{$_SESSION['id_user']}\",\"42\",\"$ToAuditoryTarjeta\");",true);    		
		
		$sql="UPDATE LotesCorreosTarjetas SET idTipoEstadoTarjeta=6 WHERE idTarjeta={$idTarjeta} AND idLoteCorreo={$form['idLoteCorreo']}";
		$id = $oMysql->consultaSel($sql,true);
		
		$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
		$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','6',NOW(),'{$form['sMotivo']}'";
		$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=6";
		$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true); 
		//$oRespuesta->alert($idEstadotarjeta);
	}
	
	$cantidadTarjetasRegistradas = $oMysql->consultaSel("SELECT count(*) FROM LotesCorreosTarjetas WHERE idLoteCorreo={$form['idLoteCorreo']} AND idTipoEstadoTarjeta IN (5,6,7)",true);
	$cantidadTarjetasLote = $oMysql->consultaSel("SELECT count(*) FROM LotesCorreosTarjetas WHERE idLoteCorreo={$form['idLoteCorreo']}",true);
	
	if($cantidadTarjetasRegistradas<$cantidadTarjetasLote){//Registrar Lote Incompleto
		$aLote = $oMysql->consultaSel("SELECT * FROM LotesCorreos WHERE LotesCorreos.id={$form['idLoteCorreo']} AND LotesCorreos.idTipoEstadoLoteCorreo = 3");
		if(!$aLote){
			$set = "LotesCorreos.idTipoEstadoLoteCorreo = '3'";
			$conditions = "LotesCorreos.id = '{$form['idLoteCorreo']}'";
			$ToAuditory = "Modificacion Estado Lotes de Correos Postales ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$form['idLoteCorreo']} ::: estado=3";		
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LotesCorreos\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"51\",\"$ToAuditory\");",true);  
				
			$setEstadoLote = "idLoteCorreo,idEmpleado,idTipoEstadoLoteCorreo,dFechaRegistro,sMotivo";
			$valuesEstadoLote = "'{$form['idLoteCorreo']}','{$_SESSION['id_user']}','3',NOW(),''";
			$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes Correos Postales ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$form['idLoteCorreo']} ::: estado=1";
			$idEstadoLote=$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesCorreos\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"52\",\"$ToAuditoryEstadoLote\");",true);
		}
	}
	if($cantidadTarjetasRegistradas == $cantidadTarjetasLote){ //Registrar Lote Completo
		$set = "LotesCorreos.idTipoEstadoLoteCorreo = '2'";
		$conditions = "LotesCorreos.id = '{$form['idLoteCorreo']}'";
		$ToAuditory = "Modificacion Estado Lotes de Correos Postales ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$form['idLoteCorreo']} ::: estado=2";		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LotesCorreos\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"51\",\"$ToAuditory\");",true);  
		
		$setEstadoLote = "idLoteCorreo,idEmpleado,idTipoEstadoLoteCorreo,dFechaRegistro,sMotivo";
		$valuesEstadoLote = "'{$form['idLoteCorreo']}','{$_SESSION['id_user']}','2',NOW(),''";
		$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes de Correos Postales ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$form['idLoteCorreo']} ::: estado=2";
		$idEstadoLote=$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesCorreos\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"52\",\"$ToAuditoryEstadoLote\");",true);
	}
	
	$oRespuesta->script("window.parent.frames[5].location.href = '../TarjetasCreditos/TarjetasPorLotes.php?id=".$form['idLoteCorreo']."&optionEditar=".$form['optionEditar']."';");
  	$oRespuesta->script('closeMessage();');
  	//$oRespuesta->alert($form['idLoteCorreo']);
	$oRespuesta->alert("La operacion se realizo correctamente");	

	return  $oRespuesta;
}
?>
<body style="background-color:#ffffff;">
<div id="BodyTree" style="padding-left:20px">
<center>
<!--<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div><br />-->

<form  method='POST' name='form' id='form'>
	<input type="hidden" id="sTarjetas"  name="sTarjetas" value="<? echo $sTarjetas;?>" />
	<input type="hidden" name="idLoteCorreo" id="idLoteCorreo" value="<?=$idLoteCorreo?>"> 
	<input type="hidden" name="optionEditar" id="optionEditar" value="<?=$optionEditar?>"> 
	
	<table id="TablaMotivo" cellspacing="5" cellpadding="0" width="98%" border="0" class="TableCustomer">
	<tr>
		<td align="center" style="font-weight:bold"><? echo $sTitulo;?></td>
	</tr>
	<tr>
		<td>Ingrese el Motivo:</td>
	</tr>
	<tr><td><textarea id="sMotivo" name="sMotivo" style="width:250px;height:120px"></textarea></td></tr>
	<tr>
		<td><div style="width:350px;text-align:center;"><button  type="button" onclick="sendForm();"> Guardar </button> </div></td>
	</tr>
	</table>
    
</form>	
<script>
function sendForm(){
	var Formu = document.forms['form'];					
	
	//viewMessageLoad('divMessageUser');
	xajax_registrarDevolucionTarjetasCreditos(xajax.getFormValues('form'));
}

</script>