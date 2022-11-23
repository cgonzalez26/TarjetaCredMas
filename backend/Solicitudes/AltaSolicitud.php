<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();

	#Control de Acceso al archivo
	//if(!isLogin())
	//{
		//go_url("/index.php");
	//}
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	
	
	$sCondicionGrupos = " GruposAfinidades.sEstado<>'B'";
	$aParametros['optionsGruposAfinidades'] = $oMysql->getListaOpciones( 'GruposAfinidades', 'id', 'sNombre','',$sCondicionGrupos);
	$sCondicionLimites = " LimitesEstandares.sEstado<>'B'";
	$aParametros['optionsLimites'] = $oMysql->getListaOpciones( 'LimitesEstandares', 'id', 'sDescripcion','',$sCondicionLimites);
	
	if($_GET['id']){
		$aParametros['ID_SOLICITUD'] = $_GET['id'];
		$aParametros['ID_BIN'] = $_GET['idBIN'];
		$aParametros['NUMERO_SOLICITUD'] = $_GET['sNumero'];
	}	
	 
	$oXajax=new xajax();
	$oXajax->registerFunction("mostrarLimite");
	$oXajax->registerFunction("mostrarCalendarioPorGrupoAfinidad");
	$oXajax->registerFunction("altaSolicitud");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	xhtmlHeaderPaginaGeneral($aParametros);		
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Solicitudes/AltaSolicitud.tpl",$aParametros);	
	echo xhtmlFootPagina();
?>