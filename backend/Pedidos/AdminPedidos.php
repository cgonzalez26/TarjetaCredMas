<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );

	session_start();
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$aParametros = array();

	$aParametros = getParametrosBasicos(1);


	if($_GET['_op']){

		$op = _decode($_GET['_op']);
		$idcomercio = intval(_decode($_GET['_op']));
		$aParametros['url_back'] = "Pedidos.php";
		
		switch ($op) {
			case "new":
					$sNumeroComercio = "101000001";
					$aParametros['_op'] = _encode('new');
					
					$aParametros['datos_comercio']	= "<span style='color:#F00;font-size:11px;'>- seleccione un Comercio</span>";
					$aParametros['datos_cuenta'] 	= "<span style='color:#F00;font-size:11px;'>- ingrese numero de cuenta de usuario o identifiquelo desde busqueda avanzada</span>";
					$aParametros['datos_planes'] 	= "<span style='color:#F00;font-size:11px;'>PROMOCIONES / PLANES asociado al comercio</span>";
					
					$aParametros['message_default_comercio']= "<span style='color:#F00;font-size:11px;'>- ingrese numero de comercio o identifique al comercio desde busqueda avanzada</span>";
					$aParametros['message_default_cuenta'] 	= "<span style='color:#F00;font-size:11px;'>- ingrese numero de cuenta de usuario o identifiquelo desde busqueda avanzada</span>";
					$aParametros['message_default_planes'] 	= "<span style='color:#F00;font-size:11px;'>PROMOCIONES / PLANES asociado al comercio</span>";
					
					$aParametros['dFechaPresentacion'] 	= date("d/m/Y");
					$aParametros['dFechaConsumo'] 	= date("d/m/Y");
					
					$aParametros['optionsTiposMonedas'] = $oMysql->getListaOpciones( 'TiposMonedas', 'id', 'sNombre',1);
					$aParametros['optionsCobradores'] = $oMysql->getListaOpciones( 'Empleados', 'id', 'CONCAT(sApellido,\', \',sNombre)',0,'');
					$aParametros['DHTMLX_WINDOW'] = 1;
					
					//$template = "Cupones.tpl";
					$aParametros['options_comercios'] = $oMysql->getListaOpciones( 'Comercios', 'Comercios.sNumero', 'Comercios.sRazonSocial',$sNumeroComercio);  
					$aParametros['sNumeroTerminal'] = "01";
					$sNumero = $oMysql->consultaSel("SELECT IFNULL(sNumeroCupon,'1000') FROM Cupones ORDER BY id DESC",true);
					$iNumero = (int)$sNumero + 1;
					$aParametros['sNumeroCupon'] = (string)$iNumero;
					
					$script = "buscarDatosComercioPorNumero();";
					$aParametros['SCRIPT'] = $script;
					$template = "Pedidos.tpl";
				break;
			case "edit":				
					//$template = "Cupones.tpl";
					$template = "Pedidos.tpl";
					$aParametros['_op'] = _encode('edit');
					
					
					
				break;
			case "wiew":
					$template = "VerCupones.tpl";
					
					$idcupon = intval(_decode($_GET['_i']));
					
					if(is_integer($idcupon) && $idcupon != 0){

						$cupones = new cupons($idcupon);

						$cupones->set_datos();
						//var_export($cupones);die();
						
						$aParametros['sNumeroCupon'] = html_entity_decode($cupones->get_dato('sNumeroCupon'));
						$aParametros['sNumeroCuenta'] = html_entity_decode($cupones->get_dato('sNumeroCuenta'));
						
						$iversion = $cupones->get_dato('sNumeroTarjeta');
						
						$iversion = substr ($iversion, strlen($iversion) - 2,1);						
						
						$table_usuario .= '<div style=\'display:block;\'><label style=\'width:120px;float:left;\'>Usuario: </label><label>' .html_entity_decode($cupones->get_dato('sNombreUsuario')). '</label></div>';
						$table_usuario .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tarjeta: </label><label>' .html_entity_decode($cupones->get_dato('sNumeroTarjeta')). '</label></div>';
						$table_usuario .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tipo Tarjeta: </label><label>' .html_entity_decode($cupones->get_dato('sNombreTipoTarjeta')). '</label></div>';
						$table_usuario .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>version: </label><label>' .html_entity_decode($iversion). '</label></div>';						
						
						$aParametros['datos_cuenta'] = $table_usuario;
						
						$table_comercio .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Razon Social: </label><label>' .html_entity_decode($cupones->get_dato('sRazonSocial')). '</label></div>';
						$table_comercio .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Nombre Fantasia: </label><label>' .html_entity_decode($cupones->get_dato('sNombreFantasia')). '</label></div>';
						$table_comercio .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>C.U.I.T.: </label><label>' .html_entity_decode($cupones->get_dato('sCUIT')). '</label></div>';
						
						if($cupones->get_dato('idPlanPromo') != 0){
							$sub_query = " WHERE PromocionesPlanes.id = '{$cupones->get_dato('idPlanPromo')}'";
							
							$promociones = $oMysql->consultaSel("CALL usp_getPromocionesPlanes(\"$sub_query\");");
							
							$table_planpromo = "<center><div style='width:530px;font-family:Tahoma;font-size:18px;text-align:left;font-weight:bold;'>Promociones</div><center></br /><table width='530' cellspacing='0' cellpadding='0' align='center' class='table_object' id='table_object'>";
							$table_planpromo .= "<tr>
										<th width='30'>.</th>
										<th width='200'>Tipo Promocion</th>
										<th width='200'>Promocion</th>
										<th width='100'>Cuotas</th>
									  </tr>";
							
							if(!$promociones){
									$table_planpromo .= "<tr>
												<td colspan='4' align='left'>&nbsp;no existen promociones</td>
											  </tr>";				
							}else{
								
								#campo hidden _itp en el formulario alta cupones indica si se selecciona promocion o plan
								#'promociones' | 'planes'   --> las alternativas posibles
								foreach ($promociones as $promocion) {
									
									$table_planpromo .= "<tr>
												<td width='30'>[X]</td>
												<td width='200'>{$promocion['sNombreTipoPlan']}</td>
												<td width='200'>{$promocion['sNombre']}</td>
												<td width='100'>{$promocion['iCantidadCuota']}</td>
											  </tr>";			
								}			
							}
							
							$table_planpromo .= "</table>";

						}elseif($cupones->get_dato('idPlan') != 0){

							$sub_query = " WHERE Planes.id = '{$cupones->get_dato('idPlan')}'";

							$planes = $oMysql->consultaSel("CALL usp_getPlanes(\"$sub_query\");");
								
							$table_planpromo = "<center><div style='width:530px;font-family:Tahoma;font-size:18px;text-align:left;font-weight:bold;'>Planes</div><center></br /><table width='530' cellspacing='0' cellpadding='0' align='center' class='table_object' id='table_object'>";
							$table_planpromo .= "<tr>
										<th width='30'>.</th>
										<th width='200'>Tipo Plan</th>
										<th width='200'>Plan</th>
										<th width='100'>Cuotas</th>
									  </tr>";
							
							if(!$planes){
									$table_planpromo .= "<tr>
												<td colspan='4' align='left'>&nbsp;no existen planes</td>
											  </tr>";				
							}else{
								
								#campo hidden _itp en el formulario alta cupones indica si se selecciona promocion o plan
								#'promociones' | 'planes'   --> las alternativas posibles
								foreach ($planes as $plan) {
									
									$table_planpromo .= "<tr>
												<td width='30'>[x]</td>
												<td width='200'>{$plan['sNombreTipoPlan']}</td>
												<td width='200'>{$plan['sNombre']}</td>
												<td width='100'>{$plan['iCantidadCuota']}</td>
											  </tr>";			
								}			
							}
							
							$table_planpromo .= "</table>";	
						}

						$aParametros['datos_planes'] = html_entity_decode($table_planpromo);

						$aParametros['datos_comercio']		= $table_comercio;
						$aParametros['iCantidadCuota'] 		= html_entity_decode($cupones->get_dato('sCuotas'));
						$aParametros['sNumeroComercio'] 	= html_entity_decode($cupones->get_dato('sNumero'));
						$aParametros['dFechaConsumo'] 		= html_entity_decode($cupones->get_dato('dFechaConsumo'));
						$aParametros['dFechaPresentacion'] 	= html_entity_decode($cupones->get_dato('dFechaPresentacion'));
						$aParametros['sNumeroTerminal'] 	= html_entity_decode($cupones->get_dato('sNumeroTerminal'));
						$aParametros['sObservacion'] 		= html_entity_decode($cupones->get_dato('sObservacion'));
						$aParametros['fImporte'] 			= html_entity_decode($cupones->get_dato('fImporte'));
						$aParametros['sNombreTipoMoneda'] 	= html_entity_decode($cupones->get_dato('sNombreTipoMoneda'));
						
						
					}else{
						$aParametros['message'] = "<span style='color:#FF0000;font-Family:Tahoma;font-size:11px;'>Codigo de Cupon Incorrecto</span>";
					}
					
				break;
			case "wiew-details":
					$idcupon = intval(_decode($_GET['_i']));

					$template = "DetallesCupones.tpl";
					
					if(is_integer($idcupon) && $idcupon != 0){
						
						$cupones = new cupons($idcupon);
						
						$cupones->set_datos();
						
				
						$planpromo = $oMysql->consultaSel("CALL usp_getDatosPlanesPromocionesAsociadosCupones(\"$idcupon\");",true);
						
						$op_planpromo = $planpromo['tipoPlanPromo'];
						$idplanpromo  = $planpromo['idPlanPromo'];
						
						switch ($op_planpromo) {
							case "promociones":
				
									$apromociones = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$idplanpromo}\",\"promociones\");",true);
				
									if(!$apromociones){
										$dia_cierre 	= 0;
										$iDiferimiento 	= 0;
										$iCredito 		= 0;
										$iCompra 		= 0;
									}else{
										$dia_cierre 	= $apromociones['iDiaCierre'];
										$iDiferimiento 	= $apromociones['iDiferimientoUsuario'];
										$nombreplanpromo= $apromociones['sNombre'];
										$cantidad_cuotas= $apromociones['iCantidadCuota'];
										$iCredito 		= $apromociones['iCredito'];
										$iCompra 		= $apromociones['iCompra'];
									}
									
				
								break;
							case "planes":
				
									$aplanes = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$idplanpromo}\",\"planes\");",true);
				
									if(!$aplanes){
										$dia_cierre 	= 0;
										$iDiferimiento 	= 0;
										$iCredito 		= 0;
										$iCompra 		= 0;
									}else{
										$dia_cierre 	= $aplanes['iDiaCierre'];
										$iDiferimiento 	= 0;
										$nombreplanpromo= $aplanes['sNombre'];
										$cantidad_cuotas= $aplanes['iCantidadCuota'];
										$iCredito 		= $aplanes['iCredito'];
										$iCompra 		= $aplanes['iCompra'];
									}

								break;
							default: $dia_cierre = 0;
						}						
						
						$idCuentaUsuario = $oMysql->consultaSel("SELECT fcn_getIdCuentaUsuarioCupones(\"$idcupon\");",true);
						
						$idCuentaUsuario = _encode($idCuentaUsuario);
						
						$idcupones = _encode($idcupon);
						
						$sub_query = " WHERE DetallesCupones.idCupon = $idcupon";
						//var_export("CALL usp_getDetallesCupones(\"$sub_query\");");die();
						$detalles = $oMysql->consultaSel("CALL usp_getDetallesCupones(\"$sub_query\");");
						
						
						//<img src='".$aParametros['IMAGES_DIR']."/tiposplanes24.png' alt='' title='' hspace='4' align='absmiddle' /><a href=\"javascript:retornarEstadosCuotas();\">Establecer Estados Cuotas</a>	
						//<img src='".$aParametros['IMAGES_DIR']."/tiposplanes24.png' alt='' title='' hspace='4' align='absmiddle' />
						$table = "<form action='#' name='form_detalles_cupones' id='form_detalles_cupones' method='post'>";						
						$table .= "<input type='hidden' name='_icu' id='_icu' value='$idCuentaUsuario'>";
						$table .= "<input type='hidden' name='_ic' id='_ic' value='$idcupones'>";
						$table .= "<center><div style='width:700px;text-align:left;'>
											<fieldset style='border-left:0px solid #CCC;border-top:1px solid #CCC;border-right:0px solid #CCC;border-bottom:1px solid #CCC;'>
											<legend style='border:0px solid #ccc;'>Cancelacion Anticipada</legend>	
											Cantidad de Cuotas: <input type='text' name='iCantidadCuotas' id='iCantidadCuotas' value='0' style='width:50px;'>
											<!--<a href=\"javascript:adelantarCuotas();\">Cancelacion Anticipada</a>-->
											<input type='button' name='cmd_aceptar' id='cmd_aceptar' value='adelantar' onclick=\"javascript:adelantarCuotas();\"> 
											<label style='display:block;font-family:tahoma;font-size:10px;color:#CCC;'>solo cuotas no facturadas se podran adelantar</label>
											</fieldset>
										   </div>
								   </center><br />";
						$table .= "</form>";
						

						$table .= "<center><div style='width:700px;text-align:left;'>";
						$table .= "<label style='display:block;'>Usuario: ".$cupones->get_dato('sApellidoUsuario').",".$cupones->get_dato('sNombreUsuario')."</label>";
						$table .= "<label style='display:block;'>Nro. Cuenta: ".$cupones->get_dato('sNumeroCuenta')."</label>";
						$table .= "<label style='display:block;'>Nro. Tarjeta: ".$cupones->get_dato('sNumeroTarjeta')."</label>";
						$table .= "<label style='display:block;'>Version: ".$cupones->get_dato('iVersionTarjeta')."</label>";
						$table .= "<label style='display:block;'>Nro. y Razon Social Comercio: ".$cupones->get_dato('sNumero')."-".$cupones->get_dato('sRazonSocial')."</label>";
						$table .= "<label style='display:block;'>Nombre Fantasia Comercio: ".$cupones->get_dato('sNombreFantasia')."</label>";
						
						$table .= "<label style='display:block;'>Promo/Plan: $nombreplanpromo</label>";
						$table .= "<label style='display:block;'>Cant. Cuotas: $cantidad_cuotas</label>";
						$table .= "<label style='display:block;'>Diferimiento: $iDiferimiento</label>";
						$table .= "</div></center><br />";
						$table .= "<table width='700' cellspacing='0' cellpadding='0' align='center' class='table_object' id='table_object'>";
						$table .= "<tr>
									<th width='100'>Nro. Cuota</th>
									<th width='100'>Importe Total</th>
									<th width='100'>Capital</th>
									<th width='100'>Interes</th>
									<th width='100'>IVA</th>
									<th width='100'>Fecha Fact.</th>
									<th width='100'>Estado Fact.</th>									
								  </tr>";
						//<th width='30'>&nbsp;</th>
						
						if(!$detalles){
								$table .= "<tr>
											<td colspan='5' align='left'>&nbsp;no se encontraron detalles</td>
										  </tr>";				
						}else{
							
							#campo hidden _itp en el formulario alta cupones indica si se selecciona promocion o plan
							#'promociones' | 'planes'   --> las alternativas posibles
							$contador_cuotas = 0;
							foreach ($detalles as $detalle) {
								

								
								$iddetalle = _encode($detalle['id']);
								
								if($detalle['iEstadoFacturacionUsuario'] == 0){
									$sFacturadoUsuario = "NO";
									$input_checkbox = "<input type='checkbox' name='dc[]' id='dc_{$iddetalle}' value='{$iddetalle}'>";
									$style_row_detail = "";
									$contador_cuotas = $contador_cuotas + 1;
								}else{
									$sFacturadoUsuario = "SI";
									$input_checkbox = "&nbsp;";
									$style_row_detail = "color:#F00;";
								}
								
								$importe_cuota = $detalle['fImporte'];
								
								$table .= "<tr style='$style_row_detail'>											
											<td width='100'>{$detalle['iNumeroCuota']}</td>
											<td width='100'>{$detalle['fImporte']}</td>
											<td width='100'>{$detalle['fCapital']}</td>
											<td width='100'>{$detalle['fInteres']}</td>
											<td width='100'>{$detalle['fIVA']}</td>
											<td width='100'>{$detalle['dFechaFacturacionUsuario']}</td>
											<td width='100'>$sFacturadoUsuario</td>											
										  </tr>";
								//<td width='30'>$input_checkbox</td>
							}			
						}

						$table .= "</table>";
						
						
						$aParametros['fImporte'] = $importe_cuota ;
						$aParametros['contador_cuotas'] = $contador_cuotas ;
						$aParametros['table_detalles_cupones'] = $table;

					}else{
						$aParametros['table_detalles_cupones'] = "<span style='color:#FF0000;font-Family:Tahoma;font-size:11px;'>Codigo de Cupon Incorrecto</span>";
					}
				
	
				break;	
			case "wiew-only-cuotas":
					$idcupon = intval(_decode($_GET['_i']));

					$template = "DetallesCupones.tpl";
					
					if(is_integer($idcupon) && $idcupon != 0){
						
						$cupones = new cupons($idcupon);
						
						$cupones->set_datos();
						
				
						$planpromo = $oMysql->consultaSel("CALL usp_getDatosPlanesPromocionesAsociadosCupones(\"$idcupon\");",true);
						
						$op_planpromo = $planpromo['tipoPlanPromo'];
						$idplanpromo  = $planpromo['idPlanPromo'];
						
						switch ($op_planpromo) {
							case "promociones":
				
									$apromociones = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$idplanpromo}\",\"promociones\");",true);
				
									if(!$apromociones){
										$dia_cierre 	= 0;
										$iDiferimiento 	= 0;
										$iCredito 		= 0;
										$iCompra 		= 0;
									}else{
										$dia_cierre 	= $apromociones['iDiaCierre'];
										$iDiferimiento 	= $apromociones['iDiferimientoUsuario'];
										$nombreplanpromo= $apromociones['sNombre'];
										$cantidad_cuotas= $apromociones['iCantidadCuota'];
										$iCredito 		= $apromociones['iCredito'];
										$iCompra 		= $apromociones['iCompra'];
									}
									
				
								break;
							case "planes":
				
									$aplanes = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$idplanpromo}\",\"planes\");",true);
				
									if(!$aplanes){
										$dia_cierre 	= 0;
										$iDiferimiento 	= 0;
										$iCredito 		= 0;
										$iCompra 		= 0;
									}else{
										$dia_cierre 	= $aplanes['iDiaCierre'];
										$iDiferimiento 	= 0;
										$nombreplanpromo= $aplanes['sNombre'];
										$cantidad_cuotas= $aplanes['iCantidadCuota'];
										$iCredito 		= $aplanes['iCredito'];
										$iCompra 		= $aplanes['iCompra'];
									}

								break;
							default: $dia_cierre = 0;
						}						
						
						$idCuentaUsuario = $oMysql->consultaSel("SELECT fcn_getIdCuentaUsuarioCupones(\"$idcupon\");",true);
						
						$idCuentaUsuario = _encode($idCuentaUsuario);
						
						$idcupones = _encode($idcupon);
						
						$sub_query = " WHERE DetallesCupones.idCupon = $idcupon";
						//var_export("CALL usp_getDetallesCupones(\"$sub_query\");");die();
						$detalles = $oMysql->consultaSel("CALL usp_getDetallesCupones(\"$sub_query\");");						

						$table .= "<center><div style='width:700px;text-align:left;'>";
						$table .= "<label style='display:block;'>Usuario: ".$cupones->get_dato('sApellidoUsuario').",".$cupones->get_dato('sNombreUsuario')."</label>";
						$table .= "<label style='display:block;'>Nro. Cuenta: ".$cupones->get_dato('sNumeroCuenta')."</label>";
						$table .= "<label style='display:block;'>Nro. Tarjeta: ".$cupones->get_dato('sNumeroTarjeta')."</label>";
						$table .= "<label style='display:block;'>Version: ".$cupones->get_dato('iVersionTarjeta')."</label>";
						$table .= "<label style='display:block;'>Nro. y Razon Social Comercio: ".$cupones->get_dato('sNumero')."-".$cupones->get_dato('sRazonSocial')."</label>";
						$table .= "<label style='display:block;'>Nombre Fantasia Comercio: ".$cupones->get_dato('sNombreFantasia')."</label>";
						
						$table .= "<label style='display:block;'>Promo/Plan: $nombreplanpromo</label>";
						$table .= "<label style='display:block;'>Cant. Cuotas: $cantidad_cuotas</label>";
						$table .= "<label style='display:block;'>Diferimiento: $iDiferimiento</label>";
						$table .= "</div></center><br />";
						$table .= "<table width='700' cellspacing='0' cellpadding='0' align='center' class='table_object' id='table_object'>";
						$table .= "<tr>
									<th width='100'>Nro. Cuota</th>
									<th width='100'>Importe Total</th>
									<th width='100'>Capital</th>
									<th width='100'>Interes</th>
									<th width='100'>IVA</th>
									<th width='100'>Fecha Fact.</th>
									<th width='100'>Estado Fact.</th>									
								  </tr>";
						//<th width='30'>&nbsp;</th>
						
						if(!$detalles){
								$table .= "<tr>
											<td colspan='5' align='left'>&nbsp;no se encontraron detalles</td>
										  </tr>";				
						}else{
							
							#campo hidden _itp en el formulario alta cupones indica si se selecciona promocion o plan
							#'promociones' | 'planes'   --> las alternativas posibles
							$contador_cuotas = 0;
							foreach ($detalles as $detalle) {
								

								
								$iddetalle = _encode($detalle['id']);
								
								if($detalle['iEstadoFacturacionUsuario'] == 0){
									$sFacturadoUsuario = "NO";
									$input_checkbox = "<input type='checkbox' name='dc[]' id='dc_{$iddetalle}' value='{$iddetalle}'>";
									$style_row_detail = "";
									$contador_cuotas = $contador_cuotas + 1;
								}else{
									$sFacturadoUsuario = "SI";
									$input_checkbox = "&nbsp;";
									$style_row_detail = "color:#F00;";
								}
								
								$importe_cuota = $detalle['fImporte'];
								
								$table .= "<tr style='$style_row_detail'>											
											<td width='100'>{$detalle['iNumeroCuota']}</td>
											<td width='100'>{$detalle['fImporte']}</td>
											<td width='100'>{$detalle['fCapital']}</td>
											<td width='100'>{$detalle['fInteres']}</td>
											<td width='100'>{$detalle['fIVA']}</td>
											<td width='100'>{$detalle['dFechaFacturacionUsuario']}</td>
											<td width='100'>$sFacturadoUsuario</td>											
										  </tr>";
								//<td width='30'>$input_checkbox</td>
							}			
						}

						$table .= "</table>";
						
						
						$aParametros['fImporte'] = $importe_cuota ;
						$aParametros['contador_cuotas'] = $contador_cuotas ;
						$aParametros['table_detalles_cupones'] = $table;

					}else{
						$aParametros['table_detalles_cupones'] = "<span style='color:#FF0000;font-Family:Tahoma;font-size:11px;'>Codigo de Cupon Incorrecto</span>";
					}
				
	
				break;
			default:
				break;
		}
	}

	 
	$oXajax=new xajax();
	
	$oXajax->registerFunction("buscarDatosUsuarioPorCuenta");
	$oXajax->registerFunction("buscarDatosComercioPorNumero");
	//$oXajax->registerFunction("buscarDatosUsuario");
	//$oXajax->registerFunction("buscarDatosComercio");
	$oXajax->registerFunction("buscarDatosPromocionesPlanesComercio");
	$oXajax->registerFunction("sendFormCupones__");
	$oXajax->registerFunction("adelantarCuotas");
	$oXajax->registerFunction("buscarDatosUsuarioPorCuentaTF");
	$oXajax->registerFunction("getPedidos");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");
	
	//-------------------------------- Cargo los select para seleccionar usuario --------------------------------------
	$id_s=$_SESSION['id_suc'];
	$id_oficina = $_SESSION['ID_OFICINA'];
	
	$sSucursales = $oMysql->getListaOpciones( 'Sucursales', 'Sucursales.id', 'Sucursales.sNombre',$id_s);    
	$sOficinas =$oMysql->getListaOpcionesCondicionado( 'idSucursal','idOficina', 'Oficinas', 'Oficinas.id', 'Oficinas.sApodo', 'idSucursal',"Oficinas.sEstado = 'A'", '',$id_oficina);
	
	$sEmpleados = 
		$oMysql->getListaOpcionesCondicionado
			( 'idOficina','idEmpleado', 'Empleados', 'Empleados.id', 'Empleados.sLogin', 'idOficina', "Empleados.sEstado = 'A'", '',$_SESSION['id_user']);
	$sSelectEmpleados = "	
						<table cellspacing='0' cellpadding='0' width='100%' align='center' border='0' class='TablaGeneral'>
							<tr>
								<th>
									Sucursal:
								</th>
								<td>	
									<select name='idSucursal' id='idSucursal' value='' style='width:200px;'>
									{$sSucursales}
									</select>
								</td>
								<th>
									Oficina:
								</th>
								<td>	
									<select name='idOficina' id='idOficina' value='' style='width:200px;'>
									{$sOficinas}
									</select>
								</td>							
								<th>
									Empleado
								</th>
								<td>	
									<select name='idEmpleado' id='idEmpleado' value='{EMPLEADOS}' style='width:200px;'>
									{$sEmpleados}
									</select>
								</td>
							</tr>
						</table>	
						";
	$aParametros['SELECT_EMPLEADOS'] = $sSelectEmpleados;
	//-------------------------------------------------------------------------------------------------------------------------
	
	xhtmlHeaderPaginaGeneral($aParametros);
	
	echo xhtmlMainHeaderPagina($aParametros);

	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Cupones/$template",$aParametros);	

	echo xhtmlFootPagina();

?>