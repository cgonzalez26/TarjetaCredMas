<?php 
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$idUser = $_SESSION['id_user'];
$TypeUser = $_SESSION['id_tuser'];
$aParametros = array();
$aParametros = getParametrosBasicos(1);

$oXajax=new xajax();
$oXajax->registerFunction("updateEstadoSolicitud");
$oXajax->processRequest();
$oXajax->printJavascript( "../includes/xajax/");

$idSolicitud= $_GET['id'];
$idTipoEstado = $_GET['idTipoEstado'];
$sNumeroSolicitud = $_GET['sNumero'];
$operacion = $_GET['operacion'];
global $oMysql;

$sTitulo = "";
$selectEstado = "";
$EstadoTarjeta = "";

if($operacion == 1)
{ //cambio de estado de tarjeta
	$sTitulo .= "Cambiar de Estado de Solicitud";
	$optionsEstados = $oMysql->getListaOpciones( 'TiposEstadosSolicitudes', 'id', 'sNombre',$idTipoEstado);
	$selectEstado = "<tr><td>Estado: </td></tr><tr><td><select id='idTipoEstado' name='idTipoEstado' style='width:350px'>$optionsEstados</select>&nbsp;<sup>*</sup></td></tr>";
}
xhtmlHeaderPaginaGeneral($aParametros);	

?>
<body style="background-color:#ffffff;">
<center>
<!--<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div>-->

<form  method='POST' name='form' id='form'>
    <!--<div style="width:350px;height:30px;font-family:Tahoma;font-weight:bold;font-size:8pt;text-align:left;" id="divMessageUser"></div>-->	
	<input type="hidden" name="idSolicitud" id="idSolicitud" value="<?=$idSolicitud?>"> 
	<input type="hidden" name="idTipoEstadoActual" id="idTipoEstadoActual" value="<?=$idTipoEstado;?>"> 
	
	<?=$EstadoTarjeta;?>
	
	<table id="TablaMotivo" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
	<tr>
		<td align="center" style="font-weight:bold"><? echo $sTitulo;?></td>
	</tr>
	<tr>
		<td id="tdContent">	
			<table id="subTablaMotivo" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
			<tr><td style="height=10px"></td></tr>
			<tr><td>Nro. de Solicitud: &nbsp;<? echo $sNumeroSolicitud;?></td></tr>
			<? echo $selectEstado;?>
			<tr>
				<td>Ingrese el Motivo:</td>
			</tr>
			<tr><td><textarea id="sMotivo" name="sMotivo" style="width:350px;height:100px"></textarea></td></tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td><div style="width:350px;text-align:center;"><button  type="button" onclick="sendForm();" id="btnConfirmar" name="btnConfirmar"> Guardar </button> </div></td>
	</tr>
	</table>
    
</form>	
<script>
function sendForm(){
	var Formu = document.forms['form'];					
	if(!validarDatosForm(Formu))
	{		
		return;
	}
	xajax_updateEstadoSolicitud(xajax.getFormValues('form'));
}

function validarDatosForm(){
	var Formu = document.forms['form'];
	var errores = '';
	 
	with (Formu){
		if(idTipoEstado.value == 0)
			errores += "- El campo Estado es requerido.\n";			

		if(idTipoEstadoActual.value == idTipoEstado.value)			
			errores += "- Debe seleccionar otro Estado de Solicitud, verifique.\n";				
	}		
	if( errores ) { alert(errores); return false; } 
	else return true;
}
</script>