<?
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$aParametros = array();
$aParametros = getParametrosBasicos(1);

$idSucursal = "";
$idTipoEmpleado = "";
$aParametros['ID_OBJETO'] = 0;
$aParametros['CHECKED'] = '';
$aParametros['ORDER'] = 0;
$idTipoObjeto = 1;
$aParametros['CLASS'] = 'idBtnDown';
$aParametros['IMAGE'] = 'page.gif';
$iOrder = 0;

if($_GET['idO']){
	$sCondiciones = " WHERE Objetos.id = {$_GET['idO']}";
	$sqlDatos="Call usp_getObjects(\"$sCondiciones\");";
	
	$rs = $oMysql->consultaSel($sqlDatos,true);
	
	//var_export($rs); die();
	$aParametros['ID_OBJETO'] = $_GET['idO'];
	$aParametros['NOMBRE'] = htmlspecialchars_decode($rs['sNombre']);
	$aParametros['CODIGO_OBJETO'] = $rs['sCodigoObjeto'];
	$aParametros['URL'] = $rs['sUrl'];
	$aParametros['ORDER'] = $rs['iOrder'];
	$aParametros['CLASS'] = $rs['sClass'];
	$aParametros['IMAGE'] = $rs['sImage'];
	$aParametros['VISIBLE'] = $rs['bItemVisible'];
	
	if($rs['bItemVisible'] == 1)$aParametros['CHECKED'] = 'checked=\'checked\'';
	
	$idTipoObjeto = $rs['idTipoObjeto'];
	$idUnidadNegocio = $rs['idUnidadNegocio'];		
	$idSucursal = $rs['idSucursal'];
	$iOrder = $rs['iOrder'];
}
	
if($_GET['action'] == 'new'){
	$aParametros['DISPLAY_NUEVO'] = "display:none";
}else{	
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
}

$aParametros['OPTIONS_TIPOSOBJETOS'] = $oMysql->getListaOpciones('TiposObjetos','id','sNombre',$idTipoObjeto);
$aParametros['OPTIONS_UNIDADESNEGOCIOS'] = $oMysql->getListaOpciones('UnidadesNegocios','id','sNombre',$idUnidadNegocio);
$aParametros['OPTIONS_OBJETOS'] = $oMysql->getListaOpciones('Objetos','id','sNombre',$iOrder);

$rsPermisos = $oMysql->consultaSel("SELECT TiposPermisos.id as 'id',TiposPermisos.sNombre as 'sNombre',	TiposPermisos.sCodigoTipoPermiso as 'sCodigoTipoPermiso' FROM TiposPermisos");

$sPermisos = stringPermitsObject($_GET['idO']);
$aPermisosActuales=explode(',',$sPermisos);
$sCheck='';
$sPermisos = "<table cellspaccing=0 cellpadding=0 border=0>";
foreach ($rsPermisos as $rs){
	if(in_array($rs['id'],$aPermisosActuales)) $sCheck='checked="1"';
    else $sCheck='';
    
	$sPermisos .= "<tr><td><input type='checkbox' id='chkTipoPermiso[]' name='chkTipoPermiso[]' value='{$rs['id']}' $sCheck /></td><td>{$rs['sNombre']}</td></tr>";	
}
$sPermisos .= "</table>";

$aParametros['PERMISOS'] = $sPermisos;

$oXajax=new xajax();

$oXajax->registerFunction("updateObjeto");
$oXajax->registerFunction("updateEstadoObjeto");

$oXajax->processRequest();
$oXajax->printJavascript("../includes/xajax/");

$aParametros['DHTMLX_WINDOW']=1;
$aParametros['DHTMLX_TREE']=1;
xhtmlHeaderPaginaGeneral($aParametros);	

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Objetos/Objetos.tpl",$aParametros);

?>