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

	$sConsulta = "SELECT fTasa FROM TasasIVA WHERE id = ". $idTasaIVA; 

	$fTasaIVA = $oMysql->consultaSel($sConsulta, true);	


	$configure['TASA_IVA'] = $fTasaIVA;	

	$configure['CUOTAS'] = 1;

	$configure['ID_AJUSTE_USUARIO'] = 0;
	
	if($_GET['_op']){ 
		
		$op = _decode($_GET['_op']);
		
		switch ($op) {
			case "new":
					$template = "AjustesComercios.tpl";
				break;
			case "wiew":
					$template = "AjustesComerciosVista.tpl";			
				break;		
			case "edit":
					
					$sCondiciones = " WHERE AjustesUsuarios.id = {$_GET['idAjusteUsuario']}";
					
					$sqlDatos="Call usp_getAjustesUsuarios(\"$sCondiciones\");";
					
					$rs = $oMysql->consultaSel($sqlDatos,true);
							
					$configure['ID_AJUSTE_USUARIO'] = $_GET['idAjusteUsuario'];
					$configure['ID_CUENTA_USUARIO'] = _encode($rs['idCuentaUsuario']);
					$configure['NUMERO_CUENTA'] = $rs['sNumeroCuenta'];
					$configure['FECHA_PROCESO'] = $rs['dFechaProceso'];
					$configure['TIPO_MONEDA'] = $rs['idTipoMoneda'];
					$configure['CUOTAS'] = $rs['iCuotas'];
					$configure['TIPO_AJSUTE'] = $rs['idTipoAjuste'];
					$configure['IMPORTE_TOTAL'] = $rs['fImporteTotal'];
					$configure['IMPORTE_TOTAL_INTERES'] = $rs['fImporteTotalInteres'];
					$configure['importe_total_interes'] = $rs['fImporteTotalInteres'];
					$configure['IMPORTE_TOTAL_IVA'] = $rs['fImporteTotalIVA'];
					$configure['importe_total_iva'] = $rs['fImporteTotalIVA'];
					$configure['IMPORTE_ANTERIOR'] = $rs['fImporteTotalIVA'];
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
					//echo  "discrimina  ".$rs['bDiscriminaIVA']."  tasa iva  ".$rs['fTasa'];
					
					$configure['ESTADO'] = $rs['sEstado'];
					
					$idTipoAjuste = $rs['idTipoAjuste'];
					$idTipoMoneda = $rs['idTipoMoneda'];
					$idTasaIVA = $rs['idTasaIVA'];
					
					
					//--------------------- Obtener datos de tarjeta -----------------------------
					
					$sCondicionesTarjeta = " WHERE Tarjetas.idCuentaUsuario = {$rs['idCuentaUsuario']}";	
					$sqlDatosTarjeta = "Call usp_getTarjetas(\"$sCondicionesTarjeta\");";		
					$rsTarjeta = $oMysql->consultaSel($sqlDatosTarjeta,true);
					
					switch ($rsTarjeta['idTipoTarjeta']) 
					{
						case 1:
							$cartel_tipo_tarjeta = "TITULAR";
							break;
						case 2:
							$cartel_tipo_tarjeta = "ADICIONAL";
							break;			
						default:
							break;
					}
							
						
					$sString = '';
						
					$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left;\'>Usuario: </label><label>' . $rsTarjeta["sApellido"].', '.$rsTarjeta["sNombre"] . '</label></div>';
					$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tarjeta: </label><label>' . $rsTarjeta["sNumeroTarjeta"] . '</label></div>';
					$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tipo Tarjeta: </label><label>' . $cartel_tipo_tarjeta . '</label></div>';
					$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>version: </label><label>' . $rsTarjeta["iVersion"] . '</label></div>';
					
					//echo $sString;
					
					$configure['datos_cuenta'] = $sString;				
				break;
			default:
					$template = "AjustesComercios.tpl";
				break;
		}
		
		

	}else{
		$template = "AjustesComercios.tpl";
	}
	
	
	/*if($_GET['action'] == 'new')
	{
		$configure['DISPLAY_NUEVO'] = "display:none";
		$configure['DISPLAY_GUARDAR'] = "display:block";
	}
	else
	{	
		$configure['DISPLAY_NUEVO'] = "display:inline";
		$configure['DISPLAY_GUARDAR'] = "display:none";
	}*/

	
	$configure['options_tipos_ajustes'] = $oMysql->getListaOpciones( 'TiposAjustes', 'id', 'sNombre',$idtipoajuste,"TiposAjustes.sDestino='CO' AND TiposAjustes.sEstadoAjuste='A'");
	$configure['OPTIONS_TIPOS_MONEDAS'] = 	$oMysql->getListaOpciones('TiposMonedas','id','sNombre', $idTipoMoneda);
	$configure['OPTIONS_TASAS_IVA'] 	= 	$oMysql->getListaOpciones('TasasIVA','id','sNombre', $idTasaIVA, "sEstado='A'");

	$configure['message_default_comercio']  = "<span style='color:#F00;font-size:11px;'>- ingrese numero de comercio o identifique al comercio desde busqueda avanzada</span>";
	$configure['message_default_cuenta'] 	= "<span style='color:#F00;font-size:11px;'>- ingrese numero de cuenta de usuario o identifiquelo desde busqueda avanzada</span>";
	//$configure['message_default_planes'] 	= "<span style='color:#F00;font-size:11px;'>PROMOCIONES / PLANES asociado al comercio</span>";	
	
	$configure['datos_comercio']	= "<span style='color:#F00;font-size:11px;'>- ingrese numero de comercio o identifique al comercio desde busqueda avanzada</span>";
	$configure['datos_cuenta'] 		= "<span style='color:#F00;font-size:11px;'>- ingrese numero de cuenta de usuario o identifiquelo desde busqueda avanzada</span>";
	$configure['datos_planes'] 		= "<span style='color:#F00;font-size:11px;'>PROMOCIONES / PLANES asociado al comercio</span>";	
	
	
	
	//********************************** AJAX ******************************************
	
	//************************  AJUSTES USUARIOS *********************************************
	
	function getTasaIVA_($idTasaIVA)
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
	}

	
	
	
	//************************* FIN AJUSTES AJAX **************************************************
	
	$xajax = new xajax();

	$xajax->registerFunction("getDatosAjustes");
	//$oXajax->registerFunction("buscarDatosUsuario");	
	//$oXajax->registerFunction("getCuentaUsuario");		
	$xajax->registerFunction("buscarDatosUsuarioPorCuentaAU");		
	$xajax->registerFunction("updateEstadoAjusteComercio");
	$xajax->registerFunction("updateDatosAjustesComercios");
	$xajax->registerFunction("getTasaIVA");

	$xajax->register( XAJAX_FUNCTION ,"buscarDatosComercioPorNumeroAC");

	$xajax->processRequest();

	$xajax->printJavascript("../includes/xajax/");

	
	$configure['DHTMLX_WINDOW']=1;
	
	
	/*$buttons = new _buttons_('R');
	
	$buttons->add_button('href','javascript:void(0);','[F9] guardar','save');

	$buttons->set_width('800px;');*/
	
	$HTML = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/AjustesComercios/$template",$configure);	

	xhtmlHeaderPaginaGeneral($configure);
	
	echo xhtmlMainHeaderPagina($configure);
	
	//echo  $buttons->get_buttons();
	
	echo $HTML;

	echo xhtmlFootPagina();	
	
	
	
?>