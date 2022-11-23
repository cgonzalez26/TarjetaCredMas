<?
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );


#Control de Acceso al archivo
if(!isLogin()){go_url("/index.php");}

$aParametros = array();
$aParametros = getParametrosBasicos(1);

$idSucursal = "";
$idTipoEmpleado = "";
$aParametros['ID_OFICINA'] = 0;
$idProductor = 0;
$aParametros['CHECKED_PRODUCCION_PROPIA'] = '';
$idProvincia = 0;
$idLocalidad = 0;

if($_GET['idOficina']){
	$sCondiciones = " WHERE Oficinas.id = {$_GET['idOficina']}";
	$sqlDatos="Call usp_getOficinas(\"$sCondiciones\");";
	
	$rs = $oMysql->consultaSel($sqlDatos,true);
	
	//var_export($rs); die();
	$aParametros['ID_OFICINA'] = $_GET['idOficina'];
	$aParametros['APODO'] = html_entity_decode($rs['sApodo']);
	$aParametros['DIRECCION'] =  html_entity_decode($rs['sDireccion']);
	$aParametros['FECHA_INICIO'] = $rs['dFechaInicio'];
	
	$idSucursal = $rs['idSucursal'];
	$idProductor = $rs['idProductor'];
	if($rs['iNumeroDependiente'] == 0) $rs['iNumeroDependiente'] = "";
	$aParametros['NUMERO_DEPENDIENTE'] = $rs['iNumeroDependiente'];
	$aParametros['TELEFONO'] = $rs['sTelefono'];
	$idProvincia = $rs['idProvincia'];
	$idLocalidad = $rs['idLocalidad'];
	$aParametros['CP'] = $rs['sCodigoPostal'];
	$aParametros['CELULAR1'] = $rs['sCelular1'];
	$aParametros['CELULAR2'] = $rs['sCelular2'];
	
	if($rs['iProduccion'] == 1)$aParametros['CHECKED_PRODUCCION_PROPIA'] = 'checked=\'checked\'';
}

	
if($_GET['action'] == 'new'){
	$aParametros['DISPLAY_NUEVO'] = "display:none";
}else{	
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
}

$aParametros['OPTIONS_SUCURSALES'] = $oMysql->getListaOpciones('Sucursales','id','sNombre',$idSucursal);
$aParametros['OPTIONS_PROVINCIAS'] = $oMysql->getListaOpciones( 'Provincias', 'id', 'sNombre', $idProvincia, '', 'Seleccionar...' );
$aParametros['SCRIPT_LOCALIDADES'] = $oMysql->getListaOpcionesCondicionado( 'idProvincia', 'idLocalidad', 'Localidades', 'id', 'sNombre', 'idProvincia', '', '', $idLocalidad );	

$oXajax=new xajax();
$oXajax->setCharEncoding('ISO-8859-1');
$oXajax->configure('decodeUTF8Input',true);
$oXajax->registerFunction("updateOficina");
$oXajax->registerFunction("updateEstadoOficina");

$oXajax->processRequest();
$oXajax->printJavascript("../includes/xajax/");

$aParametros['DHTMLX_WINDOW']=1;
xhtmlHeaderPaginaGeneral($aParametros);	

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Oficinas/Oficinas.tpl",$aParametros);
?>