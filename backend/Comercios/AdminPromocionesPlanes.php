<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );

	session_start();
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$aParametros = array();

	$aParametros = getParametrosBasicos(1);
	
	$idTipoPlan = 0;

	if($_GET['_op']){

		$op = _decode($_GET['_op']);
		

		switch ($op) {
			case "new":

					$aParametros['_op'] = _encode('new');
					
					$idcomercio = intval(_decode($_GET['_ic']));
					
					$aParametros['_ic'] = _encode($idcomercio);

					$template = "PromocionesPlanes.tpl";

					$aParametros['optionsTiposPlanes'] = $oMysql->getListaOpciones('TiposPlanes','id','sNombre',$idTipoPlan);

				break;
			case "edit":
				
					$template = "PromocionesPlanes.tpl";
				
					$idpromocionesplanes = intval(_decode($_GET['_i']));
					
					if(!is_null($idpromocionesplanes) && is_integer($idpromocionesplanes) && $idpromocionesplanes != 0){
						
						$idcomercio = intval(_decode($_GET['_ic']));
						
						if(!is_null($idcomercio) && is_integer($idcomercio) && $idcomercio != 0){
							
							$aParametros['_ic'] = _encode($idcomercio);
							
							$aParametros['_op'] = _encode('edit');
							
							$aParametros['_i'] = _encode($idpromocionesplanes);
							
							$sCondiciones = " WHERE PromocionesPlanes.id = {$idpromocionesplanes}";
			
							$sub_query = "Call usp_getPromocionesPlanes(\"$sCondiciones\");";
			
							$promocionesplanes = $oMysql->consultaSel($sub_query,true);
							
							$idTipoPlan = html_entity_decode($promocionesplanes['idTipoPlan']);
							
							$aParametros['optionsTiposPlanes'] 	= $oMysql->getListaOpciones('TiposPlanes','id','sNombre',$idTipoPlan);
							$aParametros['sNombre'] 			= html_entity_decode($promocionesplanes['sNombre']);
							$aParametros['dVigenciaDesde'] 		= html_entity_decode($promocionesplanes['dVigenciaDesde']);
							$aParametros['dVigenciaHasta'] 		= html_entity_decode($promocionesplanes['dVigenciaHasta']);
							$aParametros['iDiaCierre'] 			= html_entity_decode($promocionesplanes['iDiaCierre']);
							$aParametros['iDiaCorridoPago'] 	= html_entity_decode($promocionesplanes['iDiaCorridoPago']);
							$aParametros['fArancel'] 			= html_entity_decode($promocionesplanes['fArancel']);
							$aParametros['fCostoFinanciero'] 	= html_entity_decode($promocionesplanes['fCostoFinanciero']);
							$aParametros['iCantidadCuotas'] 	= html_entity_decode($promocionesplanes['iCantidadCuota']);
							$aParametros['fInteresUsuario'] 	= html_entity_decode($promocionesplanes['fInteresUsuario']);
							$aParametros['fDescuentoUsuario'] 	= html_entity_decode($promocionesplanes['fDescuentoUsuario']);
							$aParametros['iDiferimientoUsuario'] 	= html_entity_decode($promocionesplanes['iDiferimientoUsuario']);
							
						}else {
							$aParametros['message'] = "<span style='color:#FF0000;font-Family:Tahoma;font-size:11px;'>Codigo de Comercio Asociado incorrecto</span>";
						}
						


					}else{
						$aParametros['message'] = "<span style='color:#FF0000;font-Family:Tahoma;font-size:11px;'>Codigo de Promocion incorrecto</span>";
					}
				
	

				break;
			case "wiew":
					$template = "VerPromocionesPlanes.tpl";
				
					$idpromocionesplanes = intval(_decode($_GET['_i']));
					
					if(!is_null($idpromocionesplanes) && is_integer($idpromocionesplanes) && $idpromocionesplanes != 0){

						$idcomercio = intval(_decode($_GET['_ic']));

						$aParametros['_ic'] = _encode($idcomercio);
						
						$promocionesplanes = new promociones($idpromocionesplanes);

						$promocionesplanes->set_datos();

						$aParametros['sNumeroComercio'] 	= html_entity_decode($promocionesplanes->get_dato('sNumeroComercio'));
						$aParametros['sNombreComercio'] 	= html_entity_decode($promocionesplanes->get_dato('sNombreComercio'));
						$aParametros['sNombreTipoPlan'] 	= html_entity_decode($promocionesplanes->get_dato('sNombreTipoPlan'));
						$aParametros['sNombre'] 			= html_entity_decode($promocionesplanes->get_dato('sNombre'));
						$aParametros['dVigenciaDesde'] 		= html_entity_decode($promocionesplanes->get_dato('dVigenciaDesde'));
						$aParametros['dVigenciaHasta'] 		= html_entity_decode($promocionesplanes->get_dato('dVigenciaHasta'));
						$aParametros['iDiaCierre'] 			= html_entity_decode($promocionesplanes->get_dato('iDiaCierre'));
						$aParametros['iDiaCorridoPago'] 	= html_entity_decode($promocionesplanes->get_dato('iDiaCorridoPago'));
						$aParametros['fArancel'] 			= html_entity_decode($promocionesplanes->get_dato('fArancel'));
						$aParametros['fCostoFinanciero'] 	= html_entity_decode($promocionesplanes->get_dato('fCostoFinanciero'));
						$aParametros['iCantidadCuotas'] 	= html_entity_decode($promocionesplanes->get_dato('iCantidadCuota'));
						$aParametros['fInteresUsuario'] 	= html_entity_decode($promocionesplanes->get_dato('fInteresUsuario'));
						
						$aParametros['fDescuentoUsuario'] 	= html_entity_decode($promocionesplanes->get_dato('fDescuentoUsuario'));
						$aParametros['iDiferimientoUsuario'] 	= html_entity_decode($promocionesplanes->get_dato('iDiferimientoUsuario'));

					}else{
						$aParametros['message'] = "<span style='color:#FF0000;font-Family:Tahoma;font-size:11px;'>Codigo de Promocion incorrecto</span>";
					}
				break;		
			default:
				break;
		}
	}







	//$aParametros['READONLY_CAMPO'] = "readonly='readonly'";
	//$aParametros['DISABLED_CAMPO'] = "disabled='disabled'";
	
	 
	$oXajax=new xajax();
	
	$oXajax->registerFunction("sendFormPromocionesPlanes");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	xhtmlHeaderPaginaGeneral($aParametros);	

	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/PromocionesPlanes/$template",$aParametros);	

	echo xhtmlFootPagina();

?>