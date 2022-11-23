<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();
	
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
	
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
	
	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
	
	$aParametros['ID_EMPLEADO'] = 0;
	
	$aParametros['ID_OFICINA'] = $_SESSION['ID_OFICINA'];
	$aParametros['ID_GRUPOPROMOTOR'] = 0;
	$idCanal = 0;
	
	if($_GET['id'])
	{		
		$sCondiciones = " WHERE Empleados.id = {$_GET['id']}";
		$sqlDatos="Call usp_getEmpleados(\"$sCondiciones\");";
		
		$rs = $oMysql->consultaSel($sqlDatos,true);		
		$aParametros['ID_EMPLEADO'] = $_GET['id'];
		$aParametros['EMPLEADO'] = $rs['sApellido'].', '.$rs['sNombre'];
		$array = $oMysql->consultaSel("SELECT id,idCanal FROM GruposPromotores WHERE GruposPromotores.idEmpleado={$_GET['id']}",true);
		$aParametros['ID_GRUPOPROMOTOR'] = $array['id'];
		$idCanal =  $array['idCanal'];
		$idEmpleado =  $_GET['id'];
	}
	
	if($_GET['action'] == 'new'){
		$aParametros['DISPLAY_NUEVO'] = "display:none";
	}else{	
		$aParametros['DISPLAY_NUEVO'] = "display:inline";
	}
		
	$sCondicionesCanal = " Canales.sEstado<>'B' AND Canales.idRegion ={$_SESSION['ID_REGION']}";
	$aParametros['optionsCanales'] = $oMysql->getListaOpciones('Canales','id','sNombre',$idCanal,$sCondicionesCanal);
	$aParametros['optionsEmpleados'] = $oMysql->getListaOpciones('Empleados','id',"CONCAT(sApellido,', ',sNombre)",$idEmpleado," Empleados.sEstado<>'B'");
	$oXajax=new xajax();

	$oXajax->registerFunction("updateDatosPromotores");	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");	
	
	
	xhtmlHeaderPaginaGeneral($aParametros);			
	
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Promotores/Promotores.tpl",$aParametros);
	
	echo xhtmlFootPagina();
?>