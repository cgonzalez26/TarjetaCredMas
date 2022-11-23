<?
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );


#Control de Acceso al archivo
if(!isLogin()){go_url("/index.php");}

$aParametros = array();
$aParametros = getParametrosBasicos(1);

$idOficina = '0';
$idTipoEmpleado = '0';
$idUnidadNegocio = '0';
$idSucursal = '0';
$idArea = '0';
$aParametros['ID_EMPLEADO'] = 0;
$aParametros['LOGIN'] = "";

if($_GET['idEmpleado']){
	$sCondiciones = " WHERE Empleados.id = {$_GET['idEmpleado']}";
	$sqlDatos="Call usp_getEmpleados(\"$sCondiciones\");";
	$rs = $oMysql->consultaSel($sqlDatos,true);	
	
	//var_export($rs); die();
	$aParametros['ID_EMPLEADO'] = $_GET['idEmpleado'];
	$aParametros['APELLIDO'] = $rs['sApellido'];
	$aParametros['NOMBRE'] = $rs['sNombre'];
	$aParametros['DIRECCION'] = htmlspecialchars_decode($rs['sDireccion']);
	$aParametros['MOVIL'] = $rs['sMovil'];
	$aParametros['MAIL'] = $rs['sMail'];
	$aParametros['LOGIN'] = $rs['sLogin'];
	$aParametros['MASKPASSWORD'] = "**********";
	$idOficina = $rs['idOficina'];
	$idTipoEmpleado = $rs['idTipoEmpleado'];
	$idSucursal = $rs['idSucursal'];
	$idArea = $rs['idArea'];
	
	$idTipoEmpleadoUnidadNegocio2 = $oMysql->consultaSel("SELECT EmpleadosUnidadesNegocios.idTipoEmpleadoUnidadNegocio FROM EmpleadosUnidadesNegocios WHERE EmpleadosUnidadesNegocios.idEmpleado={$_GET['idEmpleado']} AND EmpleadosUnidadesNegocios.idUnidadNegocio=2",true);
	$idTipoEmpleadoUnidadNegocio4 = $oMysql->consultaSel("SELECT EmpleadosUnidadesNegocios.idTipoEmpleadoUnidadNegocio FROM EmpleadosUnidadesNegocios WHERE EmpleadosUnidadesNegocios.idEmpleado={$_GET['idEmpleado']} AND EmpleadosUnidadesNegocios.idUnidadNegocio=4",true);
	//var_export($idTipoEmpleadoUnidadNegocio1.'---'.$idTipoEmpleadoUnidadNegocio2.'---'.$idTipoEmpleadoUnidadNegocio3);
}
	
if($_GET['action'] == 'new'){
	$aParametros['DISPLAY_NUEVO'] = "display:none";
}else{	
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
}
$aParametros['OPTIONS_AREAS'] = $oMysql->getListaOpciones('Areas','id','sNombre',$idArea);
$aParametros['OPTIONS_SUCURSALES'] = $oMysql->getListaOpciones('Sucursales','id','sNombre',$idSucursal);
$aParametros['OPTIONS_OFICINAS'] = $oMysql->getListaOpcionesCondicionado('idSucursal','idOficina','Oficinas','Oficinas.id','Oficinas.sApodo','Oficinas.idSucursal','','',$idOficina);
//$aParametros['OPTIONS_UNIDADESNEGOCIOS'] = $oMysql->getListaOpciones('UnidadesNegocios','id','sNombre',$idUnidadNegocio);

$aParametros['OPTIONS_TIPOSEMPLEADOS2'] = $oMysql->getListaOpciones('TiposEmpleados LEFT JOIN TiposEmpleadosUnidadesNegocios ON TiposEmpleadosUnidadesNegocios.idTipoEmpleado=TiposEmpleados.id','TiposEmpleadosUnidadesNegocios.id','TiposEmpleados.sNombre',$idTipoEmpleadoUnidadNegocio2,'TiposEmpleadosUnidadesNegocios.idUnidadNegocio=2');
$aParametros['OPTIONS_TIPOSEMPLEADOS4'] = $oMysql->getListaOpciones('TiposEmpleados LEFT JOIN TiposEmpleadosUnidadesNegocios ON TiposEmpleadosUnidadesNegocios.idTipoEmpleado=TiposEmpleados.id','TiposEmpleadosUnidadesNegocios.id','TiposEmpleados.sNombre',$idTipoEmpleadoUnidadNegocio3,'TiposEmpleadosUnidadesNegocios.idUnidadNegocio=4');

$aParametros['UNIDAD_NEGOCIO2'] = "Tarjeta";
$aParametros['UNIDAD_NEGOCIO4'] = "Accesos";

$oXajax=new xajax();

$oXajax->registerFunction("updateEmpleado");
$oXajax->registerFunction("habilitarUsuario");
$oXajax->registerFunction("suspenderUsuario");
$oXajax->registerFunction("solicitarCambioPassUsuario");
$oXajax->processRequest();
$oXajax->printJavascript("../includes/xajax/");


$aParametros['DHTMLX_WINDOW']=1;
xhtmlHeaderPaginaGeneral($aParametros);	

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Empleados/Empleados.tpl",$aParametros);

?>