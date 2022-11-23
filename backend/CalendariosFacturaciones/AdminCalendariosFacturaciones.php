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
	$aParametros['ID_GRUPO_AFINIDAD'] = 0;

	if($_GET['idGrupoAfinidad'])
	{		
		$sCondiciones = " WHERE GruposAfinidades.id = {$_GET['idGrupoAfinidad']}";
		$sqlDatos="Call usp_getGruposAfinidades(\"$sCondiciones\");";
		
		$rs = $oMysql->consultaSel($sqlDatos,true);
		
		//var_export($rs); die();
		
		$aParametros['ID_GRUPO_AFINIDAD'] = $_GET['idGrupoAfinidad'];
		//$aParametros['ID_TIPO_AFINIDAD'] = $rs['idTipoAfinidad'];
		$aParametros['ID_BIN'] = $rs['idBin'];
		$aParametros['NOMBRE'] = $rs['sNombre'];
		/*$aParametros['PORCENTAJE_COMPRA_PESO'] = $rs['fPorcentajeCompraPeso'];
		$aParametros['PORCENTAJE_CREDITO_PESO'] = $rs['fPorcentajeCreditoPeso'];
		$aParametros['PORCENTAJE_FINANCIACION_PESO'] = $rs['fPorcentajeFinanciacionPeso'];
		$aParametros['PORCENTAJE_ADELANTO_PESO'] = $rs['fPorcentajeAdelanoPeso'];		
		$aParametros['PORCENTAJE_PRESTAMO'] = $rs['fPorcentajePrestamo']; 
		$aParametros['FECHA_CIERRE'] = $rs['dFechaCierre'];
		$aParametros['FECHA_VENCIMIENTO'] = $rs['dFechaVencimiento'];
		$aParametros['PORCENTAJE_SOBRE_MARGEN'] = $rs['fPorcentajeSobreMargen'];*/
		$aParametros['COSTO_RENOVACION'] = $rs['fCostoRenovacion'];
		$aParametros['CUOTAS_RENOVACION'] = $rs['iCuotasRenovacion'];
		/*$aParametros['DIAS_MOROSO'] = $rs['iDiasMoroso'];
		$aParametros['DIAS_INHABILITADO'] = $rs['iDiasInhabilitado'];
		$aParametros['DIAS_PREVISIONADO'] = $rs['iDiasPrevisionado'];
		$aParametros['PORCENTAJE_COMPRA_DOLAR'] = $rs['fPorcentajeCompraDolar'];*/
		$aParametros['NUMERO_MODELO_RESUMEN'] = $rs['iNumeroModeloResumen'];
		$aParametros['ESTADO'] = $rs['sEstado'];
		
		$idGrupoAfinidades = $rs['idGrupoAfinidad'];
		$idBin = $rs["idBin"];
		$idTipoAfinidad = $rs['idTipoAfinidad'];
		//echo "idTipoAfinidad: ". $rs['idTipoAfinidad'];	
	}
	
	
	if($_GET['action'] == 'new')
	{
		$aParametros['DISPLAY_NUEVO'] = "display:none";
	}
	else
	{	
		$aParametros['DISPLAY_NUEVO'] = "display:inline";
	}

	$aParametros['OPTIONS_AFINIDADES'] = $oMysql->getListaOpciones('TiposAfinidades','id','sNombre',$idTipoAfinidad);
	$aParametros['OPTIONS_MULTIBIN'] = $oMysql->getListaOpciones('MultiBin','id','sBin',$idBin);
	
	//$aParametros['DHTMLX_WINDOW']=1;

	$oXajax=new xajax();

	$oXajax->registerFunction("updateDatosGrupoAfinidad");
	$oXajax->registerFunction("updateDatosCalendarioFacturacion");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");	
	
	
	xhtmlHeaderPaginaGeneral($aParametros);		
			
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/GruposAfinidades/GruposAfinidades.tpl",$aParametros);	
	echo xhtmlFootPagina();
?>
