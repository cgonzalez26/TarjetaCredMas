<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );

	session_start();
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$aParametros = array();

	$aParametros = getParametrosBasicos(1);
	
	
	$idCondicionDGR = 0;
	$idCondicionAFIP = 0;
	$idCondicionComercio = 0;	
	$idRubro = 0;
	$idSubRubro = 0;
	$idTipoComercio = 0;
	$idRetencionGanancia = 0;
	$idRetencionIVA = 0;
	$idRetencionDGR = 0;
	$idBanco = 0;
	$idFormaPago = 0;
	

	if($_GET['_op']){

		$op = _decode($_GET['_op']);
		$idcomercio = intval(_decode($_GET['_op']));

		switch ($op) {
			case "new":
				
					$aParametros['_op'] = _encode('new');
					
					$template = "Comercios.tpl";
					
					
					$aParametros['optionsCondicionesDGR'] 		= $oMysql->getListaOpciones('CondicionesDGR','id','sNombre', $idCondicionDGR);
					$aParametros['optionsCondicionesAFIP'] 		= $oMysql->getListaOpciones( 'CondicionesAFIP', 'id', 'sNombre',$idCondicionAFIP);
					$aParametros['optionsCondicionesComercios'] = $oMysql->getListaOpciones( 'CondicionesComercio', 'id', 'sNombre',$idCondicionComercio);
					
					$aParametros['optionsRubros'] 				= $oMysql->getListaOpciones('Rubros','id','sNombre',$idRubro);
					$aParametros['optionsSubRubros'] 			= $oMysql->getListaOpcionesCondicionado( 'idRubro', 'idSubRubro', 'SubRubros', 'id', 'sNombre', 'idRubro','','',$idSubRubro);
					//$aParametros['optionsTiposComercios'] 		= $oMysql->getListaOpciones('TiposComercios','id','sNombre',$idTipoComercio);
					
					$aParametros['optionsRetencionesGanancias'] = $oMysql->getListaOpciones('RetencionesGanancias','id','sDescripcion',$idRetencionGanancia);
					$aParametros['optionsRetencionesIVA'] 		= $oMysql->getListaOpciones('RetencionesIVA','id','sDescripcion',$idRetencionIVA);
					$aParametros['optionsRetencionesDGR'] 		= $oMysql->getListaOpciones('RetencionesIngresosBrutos','id','sDescripcion',$idRetencionDGR);
					
					$aParametros['optionsBancos'] 				= $oMysql->getListaOpciones('Bancos','id','sNombre',$idBanco);
					$aParametros['optionsFormasPagos'] 				= $oMysql->getListaOpciones('FormasPagos','id','sNombre',$idFormaPago);
					

				break;
			case "edit":
				
					$template = "Comercios.tpl";
				
					$idcomercio = intval(_decode($_GET['_i']));
					
					if(!is_null($idcomercio) && is_integer($idcomercio) && $idcomercio != 0){
						
						$aParametros['_op'] = _encode('edit');
						
						$aParametros['_i'] = _encode($idcomercio);
						
						$sCondiciones = " WHERE Comercios.id = {$idcomercio}";
		
						$sub_query = "Call usp_getComercios(\"$sCondiciones\");";
		
						$comercio = $oMysql->consultaSel($sub_query,true);
						
						
						$idCondicionDGR 		= $comercio['idTipoCondicionDGR'];
						$idCondicionAFIP 		= $comercio['idTipoCondicionAFIP'];
						$idCondicionComercio	= $comercio['idCondicionComercio'];
						$idRubro 				= $comercio['idRubro'];
						$idSubRubro 			= $comercio['idSubRubro'];
						$idTipoComercio 		= $comercio['idTipoComercio'];
						
						$idRetencionGanancia	= $comercio['idRetencionGanancia'];
						$idRetencionIVA			= $comercio['idRetencionIVA'];
						$idRetencionDGR			= $comercio['idRetencionDGR'];
						
						$idBanco				= $comercio['idBanco'];
						$idFormaPago			= $comercio['idFormaPago'];
						
						$aParametros['sNombreFantasia'] 	= html_entity_decode($comercio['sNombreFantasia']);
						$aParametros['sRazonSocial'] 		= html_entity_decode($comercio['sRazonSocial']);
						$aParametros['sCUIT'] 				= html_entity_decode($comercio['sCUIT']);
						$aParametros['sFormaJuridica'] 		= html_entity_decode($comercio['sFormaJuridica']);
						$aParametros['dFechaInicioActividad'] = html_entity_decode($comercio['dFechaInicioActividad']);
						$aParametros['sSector'] 			= html_entity_decode($comercio['sSector']);
						$aParametros['sIngresoBrutoDGR'] 	= html_entity_decode($comercio['sIngresoBrutoDGR']);
						$aParametros['sNumero'] 			= html_entity_decode($comercio['sNumero']);
						$aParametros['dFechaAlta'] 			= html_entity_decode($comercio['dFechaAlta']);
						$aParametros['sEstado'] 			= html_entity_decode($comercio['sEstado']);
						$aParametros['sDomicilioComercial'] = html_entity_decode($comercio['sDomicilioComercial']);
						$aParametros['sDomicilioSolicitarComprobante'] = html_entity_decode($comercio['sDomicilioSolicitarComprobante']);
						$aParametros['sNombre'] 			= html_entity_decode($comercio['sNombre']);
						$aParametros['sApellido'] 			= html_entity_decode($comercio['sApellido']);
						$aParametros['sTelefono'] 			= html_entity_decode($comercio['sTelefono']);
						$aParametros['sMail']				= html_entity_decode($comercio['sMail']);
						$aParametros['sFax'] 				= html_entity_decode($comercio['sFax']);
						$aParametros['sCBU'] 				= html_entity_decode($comercio['sCBU']);

						$aParametros['optionsCondicionesDGR'] 		= $oMysql->getListaOpciones('CondicionesDGR','id','sNombre', $idCondicionDGR);
						$aParametros['optionsCondicionesAFIP'] 		= $oMysql->getListaOpciones( 'CondicionesAFIP', 'id', 'sNombre',$idCondicionAFIP);
						$aParametros['optionsCondicionesComercios'] = $oMysql->getListaOpciones( 'CondicionesComercio', 'id', 'sNombre',$idCondicionComercio);

						$aParametros['optionsRubros'] 				= $oMysql->getListaOpciones('Rubros','id','sNombre',$idRubro);
						$aParametros['optionsSubRubros'] 			= $oMysql->getListaOpcionesCondicionado( 'idRubro', 'idSubRubro', 'SubRubros', 'id', 'sNombre', 'idRubro','','',$idSubRubro);
						//$aParametros['optionsTiposComercios'] 		= $oMysql->getListaOpciones('TiposComercios','id','sNombre',$idTipoComercio);
						
						
						$aParametros['optionsRetencionesGanancias'] = $oMysql->getListaOpciones('RetencionesGanancias','id','sDescripcion',$idRetencionGanancia);
						$aParametros['optionsRetencionesIVA'] 		= $oMysql->getListaOpciones('RetencionesIVA','id','sDescripcion',$idRetencionIVA);
						$aParametros['optionsRetencionesDGR'] 		= $oMysql->getListaOpciones('RetencionesIngresosBrutos','id','sDescripcion',$idRetencionDGR);
						
						$aParametros['optionsBancos'] 				= $oMysql->getListaOpciones('Bancos','id','sNombre',$idBanco);
						$aParametros['optionsFormasPagos'] 			= $oMysql->getListaOpciones('FormasPagos','id','sNombre',$idFormaPago);						

					}else{
						$aParametros['message'] = "<span style='color:#FF0000;font-Family:Tahoma;font-size:11px;'>Codigo de comercio incorrecto</span>";
					}
				
	

				break;
			case "wiew":
					$template = "VerComercios.tpl";
				
					$idcomercio = intval(_decode($_GET['_i']));
					
					if(!is_null($idcomercio) && is_integer($idcomercio) && $idcomercio != 0){
						
						$comercio = new comercios($idcomercio);
						
						$comercio->set_datos();
						//var_export($comercio);die();
						
						$aParametros['sNombreCondicionDGR'] 			= html_entity_decode($comercio->get_dato('sNombreCondicionDGR'));
						$aParametros['sNombreCondicionAFIP'] 			= html_entity_decode($comercio->get_dato('sNombreCondicionAFIP'));
						$aParametros['sNombreCondicionComercio'] 		= html_entity_decode($comercio->get_dato('sNombreCondicionComercio'));						
						$aParametros['sNombreRubro'] 					= html_entity_decode($comercio->get_dato('sNombreRubro'));
						$aParametros['sNombreSubRubro'] 				= html_entity_decode($comercio->get_dato('sNombreSubRubro'));
						$aParametros['sNombreTipoComercio'] 			= html_entity_decode($comercio->get_dato('sNombreTipoComercio'));						
						$aParametros['sNombreFantasia'] 				= html_entity_decode($comercio->get_dato('sNombreFantasia'));
						$aParametros['sRazonSocial'] 					= html_entity_decode($comercio->get_dato('sRazonSocial'));
						$aParametros['sCUIT'] 							= html_entity_decode($comercio->get_dato('sCUIT'));
						$aParametros['sFormaJuridica'] 					= html_entity_decode($comercio->get_dato('sFormaJuridica'));
						$aParametros['dFechaInicioActividad'] 			= html_entity_decode($comercio->get_dato('dFechaInicioActividad'));
						$aParametros['sSector'] 						= html_entity_decode($comercio->get_dato('sSector'));
						$aParametros['sIngresoBrutoDGR'] 				= html_entity_decode($comercio->get_dato('sIngresoBrutoDGR'));
						$aParametros['sNumero'] 						= html_entity_decode($comercio->get_dato('sNumero'));
						$aParametros['dFechaAlta'] 						= html_entity_decode($comercio->get_dato('dFechaAlta'));
						$aParametros['sEstado'] 						= html_entity_decode($comercio->get_dato('sEstado'));
						$aParametros['sDomicilioComercial'] 			= html_entity_decode($comercio->get_dato('sDomicilioComercial'));
						$aParametros['sDomicilioSolicitarComprobante'] 	= html_entity_decode($comercio->get_dato('sDomicilioSolicitarComprobante'));
						$aParametros['sNombre'] 						= html_entity_decode($comercio->get_dato('sNombre'));
						$aParametros['sApellido'] 						= html_entity_decode($comercio->get_dato('sApellido'));
						$aParametros['sTelefono'] 						= html_entity_decode($comercio->get_dato('sTelefono'));
						$aParametros['sMail'] 							= html_entity_decode($comercio->get_dato('sMail'));
						$aParametros['sFax'] 							= html_entity_decode($comercio->get_dato('sFax'));
						$aParametros['sNumero'] 						= html_entity_decode($comercio->get_dato('sNumero'));
						
						$aParametros['sNombreRetencionGanancia']		= html_entity_decode($comercio->get_dato('sNombreRetencionGanancia'));
						$aParametros['sNombreRetencionIVA']				= html_entity_decode($comercio->get_dato('sNombreRetencionIVA'));
						$aParametros['sNombreRetencionDGR']				= html_entity_decode($comercio->get_dato('sNombreRetencionDGR'));
						
						$aParametros['sNombreBanco']					= html_entity_decode($comercio->get_dato('sNombreBanco'));
						$aParametros['sNombreFormaPago']				= html_entity_decode($comercio->get_dato('sNombreFormaPago'));
						$aParametros['sCBU']							= html_entity_decode($comercio->get_dato('sCBU'));

						
					}else{
						$aParametros['message'] = "<span style='color:#FF0000;font-Family:Tahoma;font-size:11px;'>Codigo de comercio incorrecto</span>";
					}
				break;		
			default:
				break;
		}
	}







	//$aParametros['READONLY_CAMPO'] = "readonly='readonly'";
	//$aParametros['DISABLED_CAMPO'] = "disabled='disabled'";
	
	 
	$oXajax=new xajax();
	
	$oXajax->registerFunction("sendFormComercio");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	xhtmlHeaderPaginaGeneral($aParametros);	

	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Comercios/$template",$aParametros);	

	echo xhtmlFootPagina();

?>