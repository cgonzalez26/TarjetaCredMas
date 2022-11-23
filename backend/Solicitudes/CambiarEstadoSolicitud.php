<?php 
session_start();
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$idUser = $_SESSION['id_user'];
$TypeUser = $_SESSION['id_tuser'];
$aParametros = array();
$aParametros = getParametrosBasicos(1);

$oXajax=new xajax();
$oXajax->registerFunction("updateEstadoSolicitud1");
$oXajax->registerFunction("funcion");
$oXajax->processRequest();
$oXajax->printJavascript( "../includes/xajax/");

xhtmlHeaderPaginaGeneral($aParametros);	

$idSolicitud = $_GET['id'];
$idTipoEstado = $_GET['idEstado'];
$sTitulo = "";
$mostrarGuardar = "";
$mostrarCerrar = "style='display:none'";

	switch($idTipoEstado){
	   case 1:
		{$sTitulo .= "Solicitud Pendiente de Aprobacion";break;}
	   case 3:
		{$sTitulo .= "Rechazo de Solicitudes";break;}
	   case 4:
		{$sTitulo .= "Anulacion de Solicitudes";break;}
	}
	$cuerpo = "Ingrese el Motivo:<br><textarea id='sMotivo' name='sMotivo' style='width:250px;height:120px'></textarea>";
	
	/*if($_POST['btnGuardar']){
		$form['sMotivo'] = convertir_especiales_html($_POST['sMotivo']);
		
	    //$oRespuesta->alert($form['idSolicitud']. " " . " Estado " . $form['idEstado']);	       
	    $set = "SolicitudesUsuarios.idTipoEstado = '{$_POST['idTipoEstado']}'";
	    $conditions = "SolicitudesUsuarios.id = '{$_POST['idSolicitud']}'";
		$ToAuditory = "Update Estado Solicitudes ::: User ={$_SESSION['id_user']} ::: idSolicitud={$_POST['idSolicitud']} ::: estado={$_POST['idTipoEstado']}";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"SolicitudesUsuarios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"9\",\"$ToAuditory\");",true);   
		
		$setEstado = "idSolicitud,idEmpleado,idTipoEstadoSolicitud,dFechaRegistro,sMotivo";
		$valuesEstado = "'{$_POST['idSolicitud']}','{$_SESSION['id_user']}','{$_POST['idTipoEstado']}',NOW(),'{$form['sMotivo']}'";
		$ToAuditoryEstado = "Insercion Historial de Estados Solicitudes ::: User ={$_SESSION['id_user']} ::: idSolicitud={$_POST['idSolicitud']} ::: estado={$_POST['idTipoEstado']}";
		$idEstado = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosSolicitudes\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"9\",\"$ToAuditoryEstado\");",true);   
		
		$cuerpo = "La operacion se realizo correctamente";
		$mostrarGuardar = "style='display:none'";
		$mostrarCerrar = "style='display:inline'";
	}*/
	
	function updateEstadoSolicitud1($form){
	    GLOBAL $oMysql;
	    $oRespuesta = new xajaxResponse();   
	    
		$form['sMotivo'] = convertir_especiales_html($form['sMotivo']);
		
	    //$oRespuesta->alert($form['idSolicitud']. " " . " Estado " . $form['idEstado']);	       
	    $set = "SolicitudesUsuarios.idTipoEstado = '{$form['idTipoEstado']}'";
	    $conditions = "SolicitudesUsuarios.id = '{$form['idSolicitud']}'";
		$ToAuditory = "Update Estado Solicitudes ::: User ={$_SESSION['id_user']} ::: idSolicitud={$form['idSolicitud']} ::: estado={$form['idTipoEstado']}";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"SolicitudesUsuarios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"9\",\"$ToAuditory\");",true);   
		
		$setEstado = "idSolicitud,idEmpleado,idTipoEstadoSolicitud,dFechaRegistro,sMotivo";
		$valuesEstado = "'{$form['idSolicitud']}','{$_SESSION['id_user']}','{$form['idTipoEstado']}',NOW(),'{$form['sMotivo']}'";
		$ToAuditoryEstado = "Insercion Historial de Estados Solicitudes ::: User ={$_SESSION['id_user']} ::: idSolicitud={$form['idSolicitud']} ::: estado={$form['idTipoEstado']}";
		$idEstado = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosSolicitudes\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"9\",\"$ToAuditoryEstado\");",true);   
		 
		$oRespuesta->alert("La operacion se realizo correctamente");
    	
	    //$oRespuesta->script('closeMessage();');
	    $oRespuesta->script('cerrarVentana();');
	    $oRespuesta->script("window.parent.frames[5].location.href = '../Solicitudes/Solicitudes.php';");
		return $oRespuesta;
	}
	
	function funcion($form){
		 GLOBAL $oMysql;
	    $oRespuesta = new xajaxResponse();  
	    $oRespuesta->alert("entro");
	    return $oRespuesta; 
	    
	}
?>
<body style="background-color:#ffffff;">
<div id="BodyTree" style="padding-left:20px">
<center>
<!--<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div><br />-->

<form method='POST' id='formEstado' action="CambiarEstadoSolicitud.php">
    <!--<div style="width:350px;height:30px;font-family:Tahoma;font-weight:bold;font-size:8pt;text-align:left;" id="divMessageUser"></div>-->
	
	<input type="hidden" name="idSolicitud" id="idSolicitud" value="<?=$idSolicitud;?>"> 
	<input type="hidden" name="idTipoEstado" id="idTipoEstado" value="<?=$idTipoEstado;?>"> 
	
	<table id="TablaMotivo" cellspacing="5" cellpadding="0" width="480" border="0" class="TableCustomer">
	<tr>
		<td align="center" style="font-weight:bold"><? echo $sTitulo;?></td>
	</tr>
	<tr><td><?=$cuerpo;?></td></tr>	
	<tr>
		<td><div style="width:350px;text-align:center;"><button  type="button" onclick="sendFormEstado();" id="btnGuardar" <?=$mostrarGuardar?> > Guardar </button>&nbsp;
		<input type="button" id="btnCerrar" name="btnCerrar" onclick="javascript:closeMessage();" value="Cerrar" <?=$mostrarCerrar?> /></div></td>
	</tr>
	</table>
    
</form>	
<script>
function sendFormEstado(){
	xajax_updateEstadoSolicitud1(xajax.getFormValues('formEstado'));
	/*var formu = document.getElementById('formEstado');
	formu.submit();*/
}
function cerrarVentana(){
		parent.recargar(this);
	}

</script>