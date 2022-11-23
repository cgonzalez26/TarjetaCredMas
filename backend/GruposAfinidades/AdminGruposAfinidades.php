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
		$aParametros['ID_BIN'] = $rs['idBin'];
		$aParametros['NOMBRE'] = $rs['sNombre'];
		$aParametros['CUOTAS_RENOVACION'] = $rs['iCuotasRenovacion'];
		$aParametros['COSTO_RENOVACION'] = $rs['fCostoRenovacion'];
		$aParametros['NUMERO_MODELO_RESUMEN'] = $rs['iNumeroModeloResumen'];
		$aParametros['TASA_SOBRE_MARGEN'] = $rs['fTasaSobreMargen'];
		$aParametros['TASA_COEFICIENTE_FINANCIACION'] = $rs['fTasaCoeficienteFinanciacion'];
		
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
	//$oXajax->registerFunction("_morosidadUsuarios");
	$oXajax->registerFunction("proccessMorosidadUsuarios");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");	
	
	xhtmlHeaderPaginaGeneral($aParametros);		
	
	/*$sScript = "<script type='text/javascript'>";
	$sFila = 
	"<table width='800px' border='1px' cellspacing='5px' class='TablaGeneral'>
		<tr>
			<th class='borde'>Periodo</th>
			<th class='borde'>Vencimiento</th>
			<th class='borde'>Cierre</th>		
			<th class='borde'>% Compra Peso</th>
			<th class='borde'>% Credito Peso</th>
			<th class='borde'>% Financiacion Peso</th>
			<th class='borde'>% Adelanto Peso</th>
			<th class='borde'>% Sobre Margen</th>
		</tr>";
				
		for ($i=1; $i<= 12; $i++) 
		{//<input type='text' id='dPeriodo".$i."' name='dPeriodo".$i."' size='6px' readonly='true'/>
			$sScript .= "InputMask('dPeriodo".$i."','99/9999'); InputMask('dFechaVencimiento".$i."','99/99/9999');InputMask('dFechaCierre".$i."','99/99/9999');";
			$sFila .= 
			"<tr>
				<td class='borde' id='tdPeriodo".$i."'></td>		
				<td class='borde'>
					<input type='text' id='dFechaVencimiento".$i."' name='dFechaVencimiento".$i."' onblur='validarFechaVencimiento(this.value, $i)'/>
				</td>		
				<td class='borde'><input type='text' id='dFechaCierre".$i."' name='dFechaCierre".$i."' onblur='validarFechaCierre(this.value, $i)'/></td>		
				<td class='borde'><input type='text' id='fPorcentajeCompraPeso".$i."' name='fPorcentajeCompraPeso".$i."' onblur='this.value=numero_parse_flotante(this.value)'/></td>
				<td class='borde'><input type='text' id='fPorcentajeCreditoPeso".$i."' name='fPorcentajeCreditoPeso".$i."' onblur='this.value=numero_parse_flotante(this.value)'/></td>
				<td class='borde'><input type='text' id='fPorcentajeFinanciacionPeso".$i."' name='fPorcentajeFinanciacionPeso".$i."' onblur='this.value=numero_parse_flotante(this.value)'/></td>
				<td class='borde'><input type='text' id='fPorcentajeAdelantoPeso".$i."' name='fPorcentajeAdelantoPeso".$i."' onblur='this.value=numero_parse_flotante(this.value)'/></td>
				<td class='borde'><input type='text' id='fPorcentajeSobreMargen".$i."' name='fPorcentajeSobreMargen".$i."' onblur='this.value=numero_parse_flotante(this.value)'/></td>
			</tr>";
		}
				
	$sFila .= "</table>";
	$sScript .= "</script>";*/
	
	//if($_GET['x']){
		$aParametros['btn_morosidad'] = "
			<img src='".IMAGES_DIR."/newOrder.png' title='Nuevo' alt='Nuevo' border='0' hspace='4' align='absmiddle'> 
			<a href='#' onclick='javascript:proccessMorosidadUsuarios(\""._encode($_GET['idGrupoAfinidad'])."\");' style='text-decoration:none;font-weight:bold'>Morosidad Usuarios</a>
			&nbsp;&nbsp;
		";

	//}
		
	$aParametros['TABLA_PERIODOS'] = $sFila . $sScript;	
		
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/GruposAfinidades/GruposAfinidades.tpl",$aParametros);	
	echo xhtmlFootPagina();
?>
