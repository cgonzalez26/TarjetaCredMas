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
	
	$idGrupoAfinidades = 0;
	$idTipoAfinidad = 0;
	$idBin = 0;
	$aParametros['ID_CANAL'] = 0;
	$idRegion = 0;
	
	if($_GET['id'])
	{		
		$sCondiciones = " WHERE Canales.id = {$_GET['id']}";
		$sqlDatos="Call usp_getCanales(\"$sCondiciones\");";
		
		$rs = $oMysql->consultaSel($sqlDatos,true);
		
		//var_export($rs); die();
		
		$aParametros['ID_CANAL'] = $_GET['id'];
		$aParametros['NOMBRE'] = $rs['sNombre'];
		$aParametros['CODIGO'] = $rs['sCodigo'];
		$aParametros['ESTADO'] = $rs['sEstado'];
		$idRegion = $rs['idRegion'];
		$idCanal = $rs['id'];
		$sNombre = $rs['sNombre'];
		$sCodigo = $rs['sCodigo'];
		//echo "idTipoAfinidad: ". $rs['idTipoAfinidad'];	
	}else{
		$sqlDatos = "SELECT sCodigo FROM Canales ORDER BY id DESC LIMIT 0,1";
		$sCodigo = $oMysql->consultaSel($sqlDatos,true);
		$sCodigo = (int)$sCodigo +1;
		$aParametros['CODIGO'] = $sCodigo;
	}
	if($_GET['action'] == 'new'){
		$aParametros['DISPLAY_NUEVO'] = "display:none";
	}else{	
		$aParametros['DISPLAY_NUEVO'] = "display:inline";
	}

	$aParametros['optionsRegiones'] = $oMysql->getListaOpciones('Regiones','id','sNombre',$idRegion);	

	$oXajax=new xajax();
	$oXajax->registerFunction("updateDatosCanales");	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");			
	xhtmlHeaderPaginaGeneral($aParametros);		
	
		
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Canales/Canales.tpl",$aParametros);	
	echo xhtmlFootPagina();
?>
