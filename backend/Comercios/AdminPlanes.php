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

					$template = "Planes.tpl";

					$aParametros['optionsTiposPlanes'] = $oMysql->getListaOpciones('TiposPlanes','id','sNombre',$idTipoPlan);

				break;
			case "edit":
				
					$template = "Planes.tpl";
				
					$idplanes = intval(_decode($_GET['_i']));
					
					if(!is_null($idplanes) && is_integer($idplanes) && $idplanes != 0){
						
						$idcomercio = intval(_decode($_GET['_ic']));
						
						if(!is_null($idcomercio) && is_integer($idcomercio) && $idcomercio != 0){
							
							$aParametros['_ic'] = _encode($idcomercio);
							
							$aParametros['_op'] = _encode('edit');
							
							$aParametros['_i'] = _encode($idplanes);
							
							$sCondiciones = " WHERE Planes.id = {$idplanes}";
			
							$sub_query = "Call usp_getPlanes(\"$sCondiciones\");";
			
							$planes = $oMysql->consultaSel($sub_query,true);
							
							$idTipoPlan = html_entity_decode($planes['idTipoPlan']);
							
							$aParametros['optionsTiposPlanes'] 	= $oMysql->getListaOpciones('TiposPlanes','id','sNombre',$idTipoPlan);
							$aParametros['sNombre'] 			= html_entity_decode($planes['sNombre']);
							$aParametros['dVigenciaDesde'] 		= html_entity_decode($planes['dVigenciaDesde']);
							$aParametros['dVigenciaHasta'] 		= html_entity_decode($planes['dVigenciaHasta']);
							$aParametros['iDiaCierre'] 			= html_entity_decode($planes['iDiaCierre']);
							$aParametros['iDiaCorridoPago'] 	= html_entity_decode($planes['iDiaCorridoPago']);
							$aParametros['fArancel'] 			= html_entity_decode($planes['fArancel']);
							$aParametros['fCostoFinanciero'] 	= html_entity_decode($planes['fCostoFinanciero']);
							$aParametros['iCantidadCuotas'] 	= html_entity_decode($planes['iCantidadCuota']);
							$aParametros['fInteresUsuario'] 	= html_entity_decode($planes['fInteresUsuario']);
							
						}else {
							$aParametros['message'] = "<span style='color:#FF0000;font-Family:Tahoma;font-size:11px;'>Codigo de Comercio Asociado incorrecto</span>";
						}
						


					}else{
						$aParametros['message'] = "<span style='color:#FF0000;font-Family:Tahoma;font-size:11px;'>Codigo de Plan incorrecto</span>";
					}
				
	

				break;
			case "wiew":
					$template = "VerPlanes.tpl";
				
					$idplan = intval(_decode($_GET['_i']));
					
					if(!is_null($idplan) && is_integer($idplan) && $idplan != 0){

						$idcomercio = intval(_decode($_GET['_ic']));

						$aParametros['_ic'] = _encode($idcomercio);
						
						$planes = new planes($idplan);

						$planes->set_datos();

						$aParametros['sNumeroComercio'] 	= html_entity_decode($planes->get_dato('sNumeroComercio'));
						$aParametros['sNombreComercio'] 	= html_entity_decode($planes->get_dato('sNombreComercio'));
						$aParametros['sNombreTipoPlan'] 	= html_entity_decode($planes->get_dato('sNombreTipoPlan'));
						$aParametros['sNombre'] 			= html_entity_decode($planes->get_dato('sNombre'));
						$aParametros['dVigenciaDesde'] 		= html_entity_decode($planes->get_dato('dVigenciaDesde'));
						$aParametros['dVigenciaHasta'] 		= html_entity_decode($planes->get_dato('dVigenciaHasta'));
						$aParametros['iDiaCierre'] 			= html_entity_decode($planes->get_dato('iDiaCierre'));
						$aParametros['iDiaCorridoPago'] 	= html_entity_decode($planes->get_dato('iDiaCorridoPago'));
						$aParametros['fArancel'] 			= html_entity_decode($planes->get_dato('fArancel'));
						$aParametros['fCostoFinanciero'] 	= html_entity_decode($planes->get_dato('fCostoFinanciero'));
						$aParametros['iCantidadCuotas'] 	= html_entity_decode($planes->get_dato('iCantidadCuota'));
						$aParametros['fInteresUsuario'] 	= html_entity_decode($planes->get_dato('fInteresUsuario'));

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
	
	$oXajax->registerFunction("sendFormPlanes");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	xhtmlHeaderPaginaGeneral($aParametros);	

	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Planes/$template",$aParametros);	

	echo xhtmlFootPagina();

?>