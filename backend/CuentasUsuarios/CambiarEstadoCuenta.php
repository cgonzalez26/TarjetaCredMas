<?php 
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$idUser = $_SESSION['id_user'];
$TypeUser = $_SESSION['id_tuser'];
$aParametros = array();
$aParametros = getParametrosBasicos(1);

$oXajax=new xajax();
$oXajax->registerFunction("updateEstadoCuentaUsuario");
$oXajax->processRequest();
$oXajax->printJavascript( "../includes/xajax/");

$idCuentaUsuario = $_GET['id'];
$idTipoEstadoCuenta = $_GET['idTipoEstadoCuenta'];
$sNumero = $_GET['sNumero'];

$operacion = $_GET['operacion'];
global $oMysql;

$sTitulo = "";
$selectEstado = "";
$EstadoTarjeta = "";
//if($operacion == 1){ //cambio de estado de cuenta
	$sTitulo .= "Cambiar de Estado de Cuenta";
	$sCondicion = " TiposEstadosCuentas.id<>12";
	$optionsEstados = $oMysql->getListaOpciones( 'TiposEstadosCuentas', 'id', 'sNombre',$idTipoEstadoCuenta,$sCondicion);
	$selectEstado = "<tr><td>Estado: </td></tr><tr><td><select id='idTipoEstadoCuenta' name='idTipoEstadoCuenta' style='width:350px'>$optionsEstados</select>&nbsp;<sup>*</sup></td></tr>";
//}else{
//}
xhtmlHeaderPaginaGeneral($aParametros);		
?>
<body style="background-color:#ffffff;">
<center>
<!--<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div>-->

<form  method='POST' name='form' id='form'>
    <!--<div style="width:350px;height:30px;font-family:Tahoma;font-weight:bold;font-size:8pt;text-align:left;" id="divMessageUser"></div>-->
    <input type="hidden" name="idCuentaUsuario" id="idCuentaUsuario" value="<?=$idCuentaUsuario?>">
	<input type="hidden" name="idTipoEstadoCuentaActual" id="idTipoEstadoCuentaActual" value="<?=$idTipoEstadoCuenta?>"> 
	
	<table id="TablaMotivo" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
	<tr>
		<td align="center" style="font-weight:bold"><? echo $sTitulo;?></td>
	</tr>
	<tr>
		<td id="tdContent">
			<table id="subTablaMotivo" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
			<tr><td style="height=10px"></td></tr>
			<tr><td>Nro. de Cuenta: &nbsp;<? echo $sNumero;?></td></tr>
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
	xajax_updateEstadoCuentaUsuario(xajax.getFormValues('form'));			
}

function validarDatosForm(){
	var Formu = document.forms['form'];
	var errores = '';
	 
	with (Formu){
		if(idTipoEstadoCuenta.value == 0)
			errores += "- El campo Estado es requerido.\n";	
			
		if(idTipoEstadoCuentaActual.value == idTipoEstadoCuenta.value)			
			errores += "- Debe seleccionar otro Estado de Cuenta, verifique.\n";	
	}		
	if( errores ) { alert(errores); return false; } 
	else return true;
}
</script>