<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');

	include_once(  BASE . '/_global.php' );
	
	include_once( CLASSES_DIR . '/_buttons.class.php' );	

	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
	
	$configure = array();
	
	$configure = getParametrosBasicos(1);

	
	$idTipoAjuste = 0;
	$idTipoMoneda = 1;
	$idTasaIVA = 1;
	$fTasaIVA = 0;
	$idPromocion = 0;
	$idPlan = 0;
	
	$sConsulta = "SELECT fTasa FROM TasasIVA WHERE id = ". $idTasaIVA; 

	$fTasaIVA = $oMysql->consultaSel($sConsulta, true);	


	$configure['TASA_IVA'] = $fTasaIVA;	
	$configure['CUOTAS'] = 1;
	$configure['ID_AJUSTE_USUARIO'] = 0;
	
	if($_GET['idAjusteComercio'])
	{ 
			$iPlanPromo = $_GET['iPlanPromo'];
			
			$op = _decode($_GET['_op']);					
						
			$sCondiciones = " WHERE AjustesComercios.id = {$_GET['idAjusteComercio']}";
			
			$sqlDatos="Call usp_getAjustesComercios(\"$sCondiciones\",\"$iPlanPromo\");";

			
			//echo $sqlDatos;
			
			$rs = $oMysql->consultaSel($sqlDatos,true);
							
			$configure['ID_AJUSTE_COMERCIO'] = $_GET['idAjusteComercio'];			
			$configure['TIPO_MONEDA'] = $rs['idTipoMoneda'];
			$configure['CUOTAS'] = $rs['iCuotas'];
			$configure['TIPO_AJSUTE'] = $rs['idTipoAjuste'];
			$configure['IMPORTE_TOTAL'] = $rs['fImporteTotal'];
			$configure['IMPORTE_TOTAL_INTERES'] = $rs['fImporteTotalInteres'];
			$configure['importe_total_interes'] = $rs['fImporteTotalInteres'];
			$configure['IMPORTE_TOTAL_IVA'] = $rs['fImporteTotalIVA'];
			$configure['importe_total_iva'] = $rs['fImporteTotalIVA'];					
			$configure['CODIGO'] = $rs['sCodigo'];
			$configure['USUARIO'] = $rs['sUsuario'];
			$configure['INTERES'] = $rs['fTasaInteresAjuste'];
			$configure['interes'] = $rs['fTasaInteresAjuste'];
			$configure['CLASE_AJUSTE'] = $rs['sClaseAjuste'];
			$configure['TASA_IVA'] = $rs['fTasa'];
			$configure['IMPORTE_TOTAL_FINAL'] = $rs['fTotalFinal'];
			$configure['importe_total_final'] = $rs['fTotalFinal'];
			$configure['DISCRIMINA_IVA'] = $rs['bDiscriminaIVA'];
			$configure['FECHA_HORA'] = $rs['dFecha'];
			
			$configure['NOMBRE_TASA_IVA'] = $rs['sTasaIVA'];
			$configure['NOMBRE_TIPO_AJUSTE'] = $rs['sTipoAjuste'];
			$configure['NOMBRE_TIPO_MONEDA'] = $rs['sTipoMoneda'];
			
			$configure['PLAN'] = $rs['sPlan'];
			$configure['TIPO_PLAN'] = $rs['iPlanPlomo'];
			
			$configure['ESTADO'] = $rs['sEstado'];				
				
			$idTipoAjuste = $rs['idTipoAjuste'];
			$idTipoMoneda = $rs['idTipoMoneda'];
			$idTasaIVA = $rs['idTasaIVA'];
		
			if($iPlanPromo == 0)$configure['TITULO_PLAN_PROMO'] = "Plan:";
			else $configure['TITULO_PLAN_PROMO'] = "Promocion:";
			
			$configure['NOMBRE_PLAN_PROMO'] = $rs['sPlan'];				
			
			//--------------------- Obtener datos de comercio -----------------------------
			
			$sCondicionesComercio = " WHERE Comercios.id = {$rs['idComercio']}";	
			$sqlDatosComercio = "Call usp_getComercios(\"$sCondicionesComercio\");";		
			$rsComercio = $oMysql->consultaSel($sqlDatosComercio,true);
		
			$sString = '';
			
			$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Razon Social: </label><label>'  .$rsComercio['sRazonSocial'] . '</label></div>';
			$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Nombre Fantasia: </label><label>' . $rsComercio['sNombreFantasia'] . '</label></div>';
			$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>C.U.I.T.: </label><label>' . $rsComercio['sCUIT'] . '</label></div>';					
			
			//echo 'stirng: '. $sString;
			
			$configure['datos_comercio'] = $sString;	

			$template = "AjustesComerciosVista.tpl";
						
	}
	else
	{
		$template = "AjustesComercios.tpl";
	}
	

	$configure['options_tipos_ajustes'] = $oMysql->getListaOpciones( 'TiposAjustes', 'id', 'sNombre',$idtipoajuste,"TiposAjustes.sDestino='CO' AND TiposAjustes.sEstadoAjuste='A'");
	$configure['OPTIONS_TIPOS_MONEDAS'] = 	$oMysql->getListaOpciones('TiposMonedas','id','sNombre', $idTipoMoneda);
	$configure['OPTIONS_TASAS_IVA'] 	= 	$oMysql->getListaOpciones('TasasIVA','id','sNombre', $idTasaIVA, "sEstado='A'");
	//$configure['OPTIONS_PROMOCIONES'] 	= 	$oMysql->getListaOpciones('PromocionesPlanes','id','sNombre', $idPromocion);
	//$configure['OPTIONS_PLANES'] 	= 	$oMysql->getListaOpciones('Planes','id','sNombre', $idplan, "sEstado = 'A'");
	
	$configure['message_default_comercio']  = "<span style='color:#F00;font-size:11px;'>- ingrese numero de comercio o identifique al comercio desde busqueda avanzada</span>";
	$configure['message_default_cuenta'] 	= "<span style='color:#F00;font-size:11px;'>- ingrese numero de cuenta de usuario o identifiquelo desde busqueda avanzada</span>";
	//$configure['message_default_planes'] 	= "<span style='color:#F00;font-size:11px;'>PROMOCIONES / PLANES asociado al comercio</span>";	
	
	$configure['datos_cuenta'] 		= "<span style='color:#F00;font-size:11px;'>- ingrese numero de cuenta de usuario o identifiquelo desde busqueda avanzada</span>";
	$configure['datos_planes'] 		= "<span style='color:#F00;font-size:11px;'>PROMOCIONES / PLANES asociado al comercio</span>";	
		
	if(!$configure['datos_comercio'])
	{
		$configure['datos_comercio'] = "<span style='color:#F00;font-size:11px;'>- ingrese numero de comercio o identifique al comercio desde busqueda avanzada</span>";
	}
	
	
	//********************************** AJAX ******************************************
	
	//************************  AJUSTES USUARIOS *********************************************
	
/*	function getTasaIVA_($idTasaIVA)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
			
		$sConsulta = "SELECT fTasa FROM TasasIVA WHERE id = ". $idTasaIVA; 
		
				
		$fTasaIVA = $oMysql->consultaSel($sConsulta, true);
		
		$oRespuesta->assign("fTasaIVA", "value", $fTasaIVA);
		
		return $oRespuesta;
	}
	
	
	function getDatosAjustes_($idAjuste)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$sCondiciones = "WHERE TiposAjustes.id = ". $idAjuste; 
		
		$sqlDatos="Call usp_getTiposAjustes(\"$sCondiciones\");";
		
		$result = $oMysql->consultaSel($sqlDatos,true);
		
		$fInteresAjuste = 0;
		
		if($result)
		{
			$fInteresAjuste = $result["fTasaInteresAjuste"];
			$sClaseAjuste = $result["sClaseAjuste"];
			$bDiscriminaIVA = $result["bDiscriminaIVA"];
			
			//$oRespuesta->alert($bDiscriminaIVA);
			
			$oRespuesta->assign("fInteres", "value", $fInteresAjuste);
			$oRespuesta->assign("lblInteres", "innerHTML", $fInteresAjuste);
			$oRespuesta->assign("sClaseAjuste", "value", $sClaseAjuste);
			$oRespuesta->assign("bDiscriminaIVA", "value", $bDiscriminaIVA);
		
			//$oRespuesta->alert("xajax_getDatosAjuste")
		}
		
		return $oRespuesta;
	}*/

	
	
	
	//************************* FIN AJUSTES AJAX **************************************************
	
	$xajax = new xajax();

	$xajax->registerFunction("getDatosAjustes");	
	$xajax->registerFunction("buscarDatosUsuarioPorCuentaAU");		
	$xajax->registerFunction("updateEstadoAjusteComercio");
	$xajax->registerFunction("updateDatosAjustesComercios");
	$xajax->registerFunction("getTasaIVA");

	$xajax->register( XAJAX_FUNCTION ,"buscarDatosComercioPorNumeroAC_Maxi");

	$xajax->processRequest();

	$xajax->printJavascript("../includes/xajax/");

	
	$configure['DHTMLX_WINDOW']=1;
	
	
	$HTML = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/AjustesComercios/$template",$configure);	

	//echo $template;	
	
	xhtmlHeaderPaginaGeneral($configure);
	
	echo xhtmlMainHeaderPagina($configure);
	
	//echo  $buttons->get_buttons();
	
	echo $HTML;

	echo xhtmlFootPagina();		
?>