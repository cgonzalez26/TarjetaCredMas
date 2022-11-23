<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );

	session_start();
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$aParametros = array();

	$aParametros = getParametrosBasicos(1);
	
	$idCondicionLaboral = 0;
	$idCondicionDGR = 0;
	$idCondicionAFIP = 0;
	$idCondicionComercio = 0;
	$idExencionesRetenciones = 0;
	$idRubro = 0;
	$idSubRubro = 0;
	$idTipoComercio = 0;
	$idRetencion = 0;

	if($_GET['_op']){

		$op = _decode($_GET['_op']);
		$idcomercio = intval(_decode($_GET['_op']));

		switch ($op) {
			case "new":
				
					$aParametros['_op'] = _encode('new');
					
					$template = "TiposPlanes.tpl";

					$aParametros['optionsAutorizable'] = "<option value='1'>SI</option><option value='0'>NO</option>";

				break;
			case "edit":
				
					$template = "TiposPlanes.tpl";
				
					$idtiposplanes = intval(_decode($_GET['_i']));
					
					if(!is_null($idtiposplanes) && is_integer($idtiposplanes) && $idtiposplanes != 0){
						
						$aParametros['_op'] = _encode('edit');
						
						$aParametros['_i'] = _encode($idtiposplanes);
						
						$sCondiciones = " WHERE TiposPlanes.id = {$idtiposplanes}";
		
						$sub_query = "Call usp_getTiposPlanes(\"$sCondiciones\");";
		
						$tiposplanes = $oMysql->consultaSel($sub_query,true);
						
						
						
						$aParametros['sNombre'] 	= html_entity_decode($tiposplanes['sNombre']);
						
						switch ($tiposplanes['sAutorizable']) {
							case "1":
									$aParametros['optionsAutorizable'] = "<option value='1' selected>SI</option><option value='0'>NO</option>";
								break;
							case "0":
									$aParametros['optionsAutorizable'] = "<option value='1'>SI</option><option value='0' selected>NO</option>";
								break;
							default:
								break;
						}
						
						$aParametros['iFinanciable']	= html_entity_decode($tiposplanes['iFinanciable']);
						$aParametros['iCompra'] 		= html_entity_decode($tiposplanes['iCompra']);
						$aParametros['iCredito'] 		= html_entity_decode($tiposplanes['iCredito']);


					}else{
						$aParametros['message'] = "<span style='color:#FF0000;font-Family:Tahoma;font-size:11px;'>Codigo de Tipo de Plan incorrecto</span>";
					}
				
	

				break;
			case "wiew":
					$template = "VerComercios.tpl";
				
					$idcomercio = intval(_decode($_GET['_i']));
					
					if(!is_null($idcomercio) && is_integer($idcomercio) && $idcomercio != 0){
						
						$comercio = new comercios($idcomercio);
						
						$comercio->set_datos();
						
						$aParametros['sNombreCondicionLaboral'] 		= html_entity_decode($comercio->get_dato('sNombreCondicionLaboral'));
						$aParametros['sNombreCondicionDGR'] 			= html_entity_decode($comercio->get_dato('sNombreCondicionDGR'));
						$aParametros['sNombreCondicionAFIP'] 			= html_entity_decode($comercio->get_dato('sNombreCondicionAFIP'));
						$aParametros['sNombreCondicionComercio'] 		= html_entity_decode($comercio->get_dato('sNombreCondicionComercio'));
						$aParametros['sNombreExencionRetencion'] 		= html_entity_decode($comercio->get_dato('sNombreExencionRetencion'));
						$aParametros['sNombreRubro'] 					= html_entity_decode($comercio->get_dato('sNombreRubro'));
						$aParametros['sNombreSubRubro'] 				= html_entity_decode($comercio->get_dato('sNombreSubRubro'));
						$aParametros['sNombreTipoComercio'] 			= html_entity_decode($comercio->get_dato('sNombreTipoComercio'));
						$aParametros['sDescripcionRetencion'] 			= html_entity_decode($comercio->get_dato('sDescripcionRetencion'));
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
						$aParametros['sNumero'] 							= html_entity_decode($comercio->get_dato('sNumero'));

						
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
	
	$oXajax->registerFunction("sendFormTiposPlanes");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	xhtmlHeaderPaginaGeneral($aParametros);	

	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/TiposPlanes/$template",$aParametros);	

	echo xhtmlFootPagina();

?>