<?
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );
session_start();

#Control de Acceso al archivo
if(!isLogin()){go_url("/index.php");}

$aParametros = array();
$aParametros = getParametrosBasicos(1);

$idRegion = "";
$aParametros['ID_REGION'] = 0;
$aParametros['ID_SUCURSAL'] = 0;
$idProvincia = 8162;
$idLocalidad = 8163;
$iProductorInterno = 0;
$aParametros['iOtrosDatos'] = 0;

if($_GET['idSucursal']){
	$sCondiciones = " WHERE Sucursales.id = {$_GET['idSucursal']}";
	$sqlDatos="Call usp_getSucursales(\"$sCondiciones\");";
	
	
	$rs = $oMysql->consultaSel($sqlDatos,true);
	
	//var_export($rs); die();
	$aParametros['ID_SUCURSAL'] = $_GET['idSucursal'];
	$aParametros['ID_REGION'] = $rs['idRegion'];
	$aParametros['NUMERO_SUCURSAL'] = $rs['sNumeroSucursal'];
	$aParametros['APODO'] = $rs['sApodo'];
	$aParametros['NOMBRE'] = $rs['sNombre'];
	$aParametros['APELLIDO'] = $rs['sApellido'];
	$aParametros['DIRECCION'] = $rs['sDireccion'];
	$aParametros['FECHA_INICIO'] = $rs['dFechaInicio'];
	
	$idSucursal = $rs['idSucursal'];
	$idProvincia = $rs['idProvincia'];
	$idLocalidad = $rs['idLocalidad'];
	$iProductorInterno = $rs['iProductorInterno'];
	$aParametros['COMISION_VIEJA'] = $rs['fComisionVieja'];
	$aParametros['COMISION_NUEVA'] = $rs['fComisionNueva'];
	
	if($iProductorInterno == 0){ 
		$aParametros['MOSTRAR_OTROSDATOS'] = "display:none";
		$aParametros['SELECTED_NO'] = "selected=selected";
		$aParametros['SELECTED_SI'] = "";
	}else{
		$aParametros['MOSTRAR_OTROSDATOS'] = "display:inline";
		$aParametros['iOtrosDatos'] = 1;
		$aParametros['SELECTED_SI'] = "selected=selected";
		$aParametros['SELECTED_NO'] = "";
	}
}
	
if($_GET['action'] == 'new'){
	$aParametros['DISPLAY_NUEVO'] = "display:none";
	$aParametros['MOSTRAR_OTROSDATOS'] = "display:none";
	$aParametros['SELECTED_NO'] = "selected=selected";
	$aParametros['SELECTED_SI'] = "";
}else{	
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
}

$aParametros['OPTIONS_REGIONES'] = $oMysql->getListaOpciones('Regiones','id','sNombre',$aParametros['ID_REGION']);
$aParametros['optionsProvincias'] 	= $oMysql->getListaOpciones('Provincias','id','sNombre',$idProvincia);
$aParametros['optionsLocalidades'] 	= $oMysql->getListaOpcionesCondicionado( 'idProvincia', 'idLocalidad', 'Localidades', 'id', 'sNombre', 'idProvincia','','',$idLocalidad);

$oXajax=new xajax();

$oXajax->registerFunction("updateSucursal");
$oXajax->registerFunction("updateEstadoSucursal");

$oXajax->processRequest();
$oXajax->printJavascript("../includes/xajax/");


//$aParametros['DHTMLX_WINDOW']=1;
xhtmlHeaderPaginaGeneral($aParametros);	

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Sucursales/Sucursales.tpl",$aParametros);

?>