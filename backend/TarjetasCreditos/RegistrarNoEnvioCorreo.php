<?php 
session_start();
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$idUser = $_SESSION['id_user'];
$TypeUser = $_SESSION['id_tuser'];
$aParametros = array();
$aParametros = getParametrosBasicos(1);

$oXajax=new xajax();
$oXajax->registerFunction("registrarNoEmbozoTarjetasCreditos");
$oXajax->processRequest();
$oXajax->printJavascript( "../includes/xajax/");

$sTarjetas = $_GET['sTarjetas'];
$idLoteEmbosaje = $_GET['id'];
$sTitulo = "Registro del No Embozo de Tarjetas Creditos";

function registrarNoEmbozoTarjetasCreditos($form){
	GLOBAL $oMysql;	
	$oRespuesta = new xajaxResponse();
	$sTarjetas = $form['sTarjetas'];
	$aTarjetas = explode(",",$sTarjetas);
	
	/*$set = "LotesEmbosajes.idTipoEstadoLoteEmbosaje = '3'";
	$conditions = "LotesEmbosajes.id = '{$form['idLoteEmbosaje']}'";
	$ToAuditory = "Update Estado Lotes de Embosajes ::: Empleado ={$_SESSION['id_user']} ::: idLoteEmbosaje={$form['idLoteEmbosaje']} ::: estado=2";		
	$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LotesEmbosajes\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"46\",\"$ToAuditory\");",true);  
		
	$setEstadoLote = "idLoteEmbosaje,idEmpleado,idTipoEstadoLoteEmbosaje,dFechaRegistro,sMotivo";
	$valuesEstadoLote = "'{$form['idLoteEmbosaje']}','{$_SESSION['id_user']}','3',NOW(),''";
	$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes Embosajes ::: Empleado ={$_SESSION['id_user']} ::: idLoteEmbosaje={$idLoteEmbosaje} ::: estado=1";
	$idEstadoLoteEmbosaje =$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesEmbosajes\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"47\",\"$ToAuditoryEstadoLote\");",true); 
	*/
	//$oRespuesta->alert($idEstadoLoteEmbosaje);
	
	foreach ($aTarjetas as $idTarjeta){
		/*$setTarjeta = "Tarjetas.idTipoEstadoTarjeta = '9'";
    	$conditionsTarjeta = "Tarjetas.id = '{$idTarjeta}'";
		$ToAuditoryTarjeta = "Update Estado Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=2";		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Tarjetas\",\"$setTarjeta\",\"$conditionsTarjeta\",\"{$_SESSION['id_user']}\",\"42\",\"$ToAuditoryTarjeta\");",true);    		
		*/
		$sql="UPDATE LotesTarjetas SET idTipoEstadoTarjeta=9 WHERE idTarjeta={$idTarjeta} AND idLoteEmbosaje={$form['idLoteEmbosaje']}";
		$id = $oMysql->consultaSel($sql,true);
		
		$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
		$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','9',NOW(),'{$form['sMotivo']}'";
		$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=9";
		$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true); 
		//$oRespuesta->alert($idEstadotarjeta);
	}
	$oRespuesta->alert("La operacion se realizo correctamente");
	$oRespuesta->script('closeMessage();');
  	//$oRespuesta->redirect("TarjetasPorLotes.php");
  	$oRespuesta->script("window.parent.frames[5].location.href = '../TarjetasCreditos/TarjetasPorLotes.php?id=".$form['idLoteEmbosaje'].";");
	return  $oRespuesta;
}
?>
<body style="background-color:#ffffff;">
<div id="BodyTree" style="padding-left:20px">
<center>
<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div><br />

<form  method='POST' name='form' id='form'>
	<input type="hidden" id="sTarjetas"  name="sTarjetas" value="<? echo $sTarjetas;?>" />
	<input type="hidden" name="idLoteEmbosaje" id="idLoteEmbosaje" value="<?=$idLoteEmbosaje?>"> 
	
	<table id="TablaMotivo" cellspacing="5" cellpadding="0" width="100%" border="0" class="TableCustomer">
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
	xajax_registrarNoEmbozoTarjetasCreditos(xajax.getFormValues('form'));
}

</script>