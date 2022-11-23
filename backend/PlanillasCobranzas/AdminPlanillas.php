<?php 
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	
	$idUser = $_SESSION['ID_USER'];
	$TypeUser = $_SESSION['TYPE_USER'];	

	#Control de Acceso al archivo
	if(!isLogin()){go_url("/index.php");}
	
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
	
	$oXajax = new xajax();
	
	$oXajax->setCharEncoding('ISO-8859-1');
	$oXajax->configure('decodeUTF8Input',true);

	$oXajax->register( XAJAX_FUNCTION , 'CargarDatosCobranza');
	$oXajax->register( XAJAX_FUNCTION , 'updatePlanillaCobranza');	
	$oXajax->register( XAJAX_FUNCTION , 'buscarCliente');	
	$oXajax->register( XAJAX_FUNCTION , 'generarPanilla');
	$oXajax->register( XAJAX_FUNCTION , 'generarPanillaUnaFecha');
	$oXajax->register( XAJAX_FUNCTION , 'impactarPagos');
	$oXajax->register( XAJAX_FUNCTION , 'impactarPagosUnaFecha');	
	$oXajax->register( XAJAX_FUNCTION , 'finalizarPlanes');
	$oXajax->register( XAJAX_FUNCTION , 'imprimirPlanilla');
	$oXajax->register( XAJAX_FUNCTION , 'calcularTopeDeEstregas');
	$oXajax->register( XAJAX_FUNCTION , 'eliminarCobranza');
	$oXajax->register( XAJAX_FUNCTION , 'generarPanilla');
	$oXajax->register( XAJAX_FUNCTION , 'generarPanillaUnaFecha');
		
	$oXajax->processRequest();					
	$oXajax->printJavascript( "../includes/xajax/");

	$aParametros['STYLE_CERRARMES'] = "display:none";
	if($_SESSION['TYPE_USER'] ==1)
		$aParametros['STYLE_CERRARMES'] = "display:inline";
	
	$sCondicion = "Empleados.sEstado='A'";
	$aParametros['OPCIONES_COBRADORES'] = $oMysql->getListaOpciones("Empleados","Empleados.id","CONCAT(Empleados.sApellido,',',Empleados.sNombre)",'',$sCondicion,'Seleccionar..','');		
	$aParametros['ID_PLANILLA'] = 0;	
	$aParametros['ANCHO_GRILLA']='100%';
	
	$aParametros['DHTMLX_CALENDAR'] = 1;
	$aParametros['DHTMLX_GRID'] = 1;
	$aParametros['DHTMLX_GRID_FILTER'] = 1;
	$aParametros['DHTMLX_MENU'] = 1;
	$aParametros['DHTMLX_GRID_PROCESOR'] = 1;
	$aParametros['DHTMLX_WINDOW'] = 1;
	//$aParametros['WINDOW_PROTO'] = 1;
	$aParametros['HOY'] = date("d/m/Y");
		
	xhtmlHeaderPaginaGeneral($aParametros);	
	
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/PlanillasCobranzas/PlanillasCobranzas.tpl",$aParametros);
	//echo xhtmlHeaderPagina($aParametros);
	
	//xhtmlHeaderGrillas($aOpciones);
	//xhtmlTablaABM($aOpciones,'AdminCobranzas');
	
	echo xhtmlFootPagina();
?>