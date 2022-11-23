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
$optionEditar = $_GET['optionEditar'];
$sTitulo = "Registro del No Embozo de Tarjetas Creditos";

function registrarNoEmbozoTarjetasCreditos($form){
	GLOBAL $oMysql;	
	$oRespuesta = new xajaxResponse();
	$sTarjetas = $form['sTarjetas'];
	$aTarjetas = explode(",",$sTarjetas);
	
	foreach ($aTarjetas as $idTarjeta){
		$aTipoEstado =$oMysql->consultaSel("SELECT Tarjetas.idTipoEstadoTarjeta,TiposEstadosTarjetas.sNombre as 'sEstado',Tarjetas.sNumeroTarjeta FROM Tarjetas LEFT JOIN TiposEstadosTarjetas ON TiposEstadosTarjetas.id=Tarjetas.idTipoEstadoTarjeta WHERE Tarjetas.id={$idTarjeta}",true);
		
		$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
		$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','9',NOW(),'{$form['sMotivo']}'";
		$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=9";
		$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true); 

		$sql="UPDATE LotesTarjetas SET idTipoEstadoTarjeta=9 WHERE idTarjeta={$idTarjeta} AND idLoteEmbosaje={$form['idLoteEmbosaje']}";
		$id = $oMysql->consultaSel($sql,true);
		
		if($aTipoEstado['idTipoEstadoTarjeta'] == 19){ //Enviada a Reembozar
			
			$setTarjeta = "idTipoEstadoTarjeta=14";
		  	$conditionsTarjeta = "Tarjetas.id={$idTarjeta}";
		  	$ToAuditoryTarjeta = "Modificacion de Tarjetas de Creditos de Creditos ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta}";		
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Tarjetas\",\"$setTarjeta\",\"$conditionsTarjeta\",\"{$_SESSION['id_user']}\",\"27\",\"$ToAuditoryTarjeta\");",true);  
			
			$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
			$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','14',NOW(),''";
			$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=14";
			$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true); 			
		}
		//$oRespuesta->alert($idEstadotarjeta);
	}
	
	$cantidadTarjetasRegistradas = $oMysql->consultaSel("SELECT count(*) FROM LotesTarjetas WHERE idLoteEmbosaje={$form['idLoteEmbosaje']} AND idTipoEstadoTarjeta IN (2,9)",true);
	$cantidadTarjetasLote = $oMysql->consultaSel("SELECT count(*) FROM LotesTarjetas WHERE idLoteEmbosaje={$form['idLoteEmbosaje']}",true);
	
	if($cantidadTarjetasRegistradas<$cantidadTarjetasLote){//Registrar Lote Incompleto
		$aLote = $oMysql->consultaSel("SELECT * FROM LotesEmbosajes WHERE LotesEmbosajes.id={$form['idLoteEmbosaje']} AND LotesEmbosajes.idTipoEstadoLoteEmbosaje = 3");
		if(!$aLote){
			$set = "LotesEmbosajes.idTipoEstadoLoteEmbosaje = '3'";
			$conditions = "LotesEmbosajes.id = '{$form['idLoteEmbosaje']}'";
			$ToAuditory = "Update Estado Lotes de Embosajes ::: Empleado ={$_SESSION['id_user']} ::: idLoteEmbosaje={$form['idLoteEmbosaje']} ::: estado=3";		
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LotesEmbosajes\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"46\",\"$ToAuditory\");",true);  
				
			$setEstadoLote = "idLoteEmbosaje,idEmpleado,idTipoEstadoLoteEmbosaje,dFechaRegistro,sMotivo";
			$valuesEstadoLote = "'{$form['idLoteEmbosaje']}','{$_SESSION['id_user']}','3',NOW(),''";
			$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes Embosajes ::: Empleado ={$_SESSION['id_user']} ::: idLoteEmbosaje={$form['idLoteEmbosaje']} ::: estado=1";
			$idEstadoLoteEmbosaje=$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesEmbosajes\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"47\",\"$ToAuditoryEstadoLote\");",true);
		}
	}
	if($cantidadTarjetasRegistradas == $cantidadTarjetasLote){ //Registrar Lote Completo
		$set = "LotesEmbosajes.idTipoEstadoLoteEmbosaje = '2'";
		$conditions = "LotesEmbosajes.id = '{$form['idLoteEmbosaje']}'";
		$ToAuditory = "Update Estado Lotes de Embosajes ::: Empleado ={$_SESSION['id_user']} ::: idLoteEmbosaje={$form['idLoteEmbosaje']} ::: estado=2";		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LotesEmbosajes\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"46\",\"$ToAuditory\");",true);  
		//$oRespuesta->alert($idEstadoLoteEmbosaje);
			
		$setEstadoLote = "idLoteEmbosaje,idEmpleado,idTipoEstadoLoteEmbosaje,dFechaRegistro,sMotivo";
		$valuesEstadoLote = "'{$form['idLoteEmbosaje']}','{$_SESSION['id_user']}','2',NOW(),''";
		$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes Embosajes ::: Empleado ={$_SESSION['id_user']} ::: idLoteEmbosaje={$form['idLoteEmbosaje']} ::: estado=2";
		$idEstadoLoteEmbosaje=$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesEmbosajes\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"47\",\"$ToAuditoryEstadoLote\");",true);
	}

  	//$oRespuesta->script('closeMessage();');
  	$sMensaje = "La operacion se realizo correctamente";
  	$oRespuesta->assign("tdContent","innerHTML",$sMensaje);
	$oRespuesta->assign("btnConfirmar","style.display","none");
	//$oRespuesta->alert("La operacion se realizo correctamente");	
	return  $oRespuesta;
}
?>
<body style="background-color:#ffffff;">
<div id="BodyTree" style="padding-left:20px">
<center>
<!--<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div><br />-->

<form  method='POST' name='form' id='form'>
	<input type="hidden" id="sTarjetas"  name="sTarjetas" value="<? echo $sTarjetas;?>" />
	<input type="hidden" name="idLoteEmbosaje" id="idLoteEmbosaje" value="<?=$idLoteEmbosaje?>"> 
	<input type="hidden" name="optionEditar" id="optionEditar" value="<?=$optionEditar?>"> 
	
	<table id="TablaMotivo" cellspacing="5" cellpadding="0" width="100%" border="0" class="TableCustomer">
	<tr>
		<td align="center" style="font-weight:bold"><? echo $sTitulo;?></td>
	</tr>
	<tr>
		<td id="tdContent">Ingrese el Motivo: <br><textarea id="sMotivo" name="sMotivo" style="width:250px;height:120px"></textarea></td>
	</tr>
	<tr>
		<td><div style="width:350px;text-align:center;"><button  type="button" onclick="sendForm();" id="btnConfirmar" name="btnConfirmar"> Guardar </button> </div></td>
	</tr>
	</table>
    
</form>	
<script>
function sendForm(){
	var Formu = document.forms['form'];					
	
	//viewMessageLoad('divMessageUser');
	xajax_registrarNoEmbozoTarjetasCreditos(xajax.getFormValues('form'));
}

function registrarLote(idLote,optionEditar){
	//alert(idLote);
	/*if(confirm("Desea registrar el Lote de Embosaje?")){
		xajax_registrarLoteEmbosaje(idLote);
	}*/
	window.parent.frames[5].location.href = '../TarjetasCreditos/TarjetasPorLotes.php?id='+idLote+'&optionEditar='+optionEditar;
}
</script>