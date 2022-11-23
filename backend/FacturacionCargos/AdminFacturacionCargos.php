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
		
	$idFacturacionCargos = 0;
	$idGrupoAfinidades = 0;
	$idTipoAjuste = 0;
	$idVariableTipoAjuste = 0;
	$idTipoEstadoCuenta = 0;
	
	$aParametros['ID_FACTURACION_CARGO'] = 0;

	if($_GET['idFacturacionCargos'])
	{		
		$sCondiciones = " WHERE FacturacionesCargos.id = {$_GET['idFacturacionCargos']}";
		$sqlDatos="Call usp_getFacturacionDeCargos(\"$sCondiciones\");";
		
		$rs = $oMysql->consultaSel($sqlDatos,true);
		
		//var_export($rs); die();
		
		$aParametros['ID_FACTURACION_CARGOS'] = $_GET['idFacturacionCargos'];
		$aParametros['FECHA_INICIO'] = $rs['dFechaInicio'];
		$aParametros['ID_GRUPO_AFINIDAD'] = $rs['idGrupoAfinidad'];
		$aParametros['ID_TIPO_AJUSTE'] = $rs['idTipoAjuste'];
		$aParametros['TIPO_FACTURACION'] = $rs['sTipoFacturacion'];
		$aParametros['ESTADO'] = $rs['sEstado'];
		$aParametros['ID_VARIABLE_TIPO_AJUSTE'] = $rs['idVariableTipoAjuste'];
		$aParametros['VALOR'] = $rs['fValor'];		
		$aParametros['OPTIONS_TIPO_ESTADO_CUENTAS'] = $rs['idTipoEstadoCuenta'];		
	}
	
	
	if($_GET['action'] == 'new')
	{
		$aParametros['DISPLAY_NUEVO'] = "display:none";
	}
	else
	{	
		$aParametros['DISPLAY_NUEVO'] = "display:inline";
	}

	$sSelectedMonto = "";
	$sSelectedPorcentaje = "";
	
	if($aParametros['TIPO_FACTURACION'] == 'monto')
	{
		$sSelectedMonto = 'Selected';		
	}
	else if($aParametros['TIPO_FACTURACION']== 'porcentaje')
	{
		$sSelectedPorcentaje = 'Selected';
	}

	$aParametros['OPTIONS_AFINIDADES'] = $oMysql->getListaOpciones('GruposAfinidades','id','sNombre',$aParametros['ID_GRUPO_AFINIDAD'], "sEstado = 'A'");
	$aParametros['OPTIONS_TIPOS_AJUSTES'] = $oMysql->getListaOpciones('TiposAjustes','id','sNombre',$aParametros['ID_TIPO_AJUSTE'], "sEstadoAjuste = 'A'");
	$aParametros['OPTIONS_VARIABLES_TIPOS_AJUSTES'] = $oMysql->getListaOpciones('VariablesTiposAjustes','id','sNombre',$aParametros['ID_VARIABLE_TIPO_AJUSTE'], "sEstado = 'A'");
	
	$select = ($option['sNombre'] = $selected) ? "selected" : "";
	$sOptions .= "<option value='{$option['CODE']}' $select>{$option['TEXT']}</option>";
	
	
	$sOpcionesEstado = "<option value=100>[TODOS]</option><option value='-1'>[NINGUNO]</option>";	
	
	if($rs['idTipoEstadoCuenta'] == 100)//Todos
	{
		$sOpcionesEstado = "<option value=100 selected >[TODOS]</option><option value='-1'>[NINGUNO]</option>";		
	}
	elseif($rs['idTipoEstadoCuenta']==-1)
	{
		$sOpcionesEstado = "<option value=100>[TODOS]</option><option value='-1' selected>[NINGUNO]</option>";		
	}
	
	$aParametros['OPTIONS_TIPO_ESTADO_CUENTAS2'] = $sOpcionesEstado;
	$aParametros['OPTIONS_TIPO_ESTADO_CUENTAS'] = $oMysql->getListaOpciones('TiposEstadosCuentas','id','sNombre', $rs['idTipoEstadoCuenta']);
	
	$sOpcionesTipoFacturacion = "
							<option value='0'>Seleccionar</option>
							<option value='0'></option>
							<option value='monto' ".$sSelectedMonto.">Monto</option>
							<option value='porcentaje' ".$sSelectedPorcentaje.">Porcentaje</option>
						";
	
	$aParametros['OPTIONS_TIPO_FACTURACION'] = $sOpcionesTipoFacturacion;
	
	//$aParametros['DHTMLX_WINDOW']=1;
	
	$oXajax=new xajax();

	$oXajax->registerFunction("updateDatosFacturacionDeCargos");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");	
	
	xhtmlHeaderPaginaGeneral($aParametros);		
		
		
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/FacturacionCargos/FacturacionCargos.tpl",$aParametros);	
	echo xhtmlFootPagina();
?>
