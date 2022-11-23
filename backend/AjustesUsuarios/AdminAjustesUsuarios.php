<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
	
	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
	
	//$idGrupoAfinidades = 0;
	//$idTipoAfinidad = 0;
	
	$idTipoAjuste = 0;
	$idTipoMoneda = 1;
	$idTasaIVA = 1;
	$fTasaIVA = 0;
	$bEditar = false;
	
	$sConsulta = "SELECT fTasa FROM TasasIVA WHERE id = ". $idTasaIVA; 
				
	$fTasaIVA = $oMysql->consultaSel($sConsulta, true);		
	$aParametros['TASA_IVA'] = $fTasaIVA;	
	
	$aParametros['CUOTAS'] = 1;
	
	$aParametros['ID_AJUSTE_USUARIO'] = 0;
	
	if($_GET['idAjusteUsuario'])
	{		
		$bEditar = true;
		$sCondiciones = " WHERE AjustesUsuarios.id = {$_GET['idAjusteUsuario']}";
		$sqlDatos="Call usp_getAjustesUsuarios(\"$sCondiciones\");";
		
		$rs = $oMysql->consultaSel($sqlDatos,true);
				
		$aParametros['ID_AJUSTE_USUARIO'] = $_GET['idAjusteUsuario'];
		$aParametros['ID_CUENTA_USUARIO'] = _encode($rs['idCuentaUsuario']);
		$aParametros['NUMERO_CUENTA'] = $rs['sNumeroCuenta'];
		$aParametros['FECHA_PROCESO'] = $rs['dFechaProceso'];
		$aParametros['TIPO_MONEDA'] = $rs['idTipoMoneda'];
		$aParametros['CUOTAS'] = $rs['iCuotas'];
		$aParametros['TIPO_AJSUTE'] = $rs['idTipoAjuste'];
		$aParametros['IMPORTE_TOTAL'] = $rs['fImporteTotal'];
		$aParametros['IMPORTE_TOTAL_INTERES'] = $rs['fImporteTotalInteres'];
		$aParametros['importe_total_interes'] = $rs['fImporteTotalInteres'];
		$aParametros['IMPORTE_TOTAL_IVA'] = $rs['fImporteTotalIVA'];
		$aParametros['importe_total_iva'] = $rs['fImporteTotalIVA'];
		$aParametros['IMPORTE_ANTERIOR'] = $rs['fImporteTotalIVA'];
		$aParametros['CODIGO'] = $rs['sCodigo'];
		$aParametros['USUARIO'] = $rs['sUsuario'];
		$aParametros['INTERES'] = $rs['fTasaInteresAjuste'];
		$aParametros['interes'] = $rs['fTasaInteresAjuste'];
		$aParametros['CLASE_AJUSTE'] = $rs['sClaseAjuste'];
		$aParametros['TASA_IVA'] = $rs['fTasa'];
		$aParametros['IMPORTE_TOTAL_FINAL'] = $rs['fTotalFinal'];
		$aParametros['importe_total_final'] = $rs['fTotalFinal'];
		$aParametros['DISCRIMINA_IVA'] = $rs['bDiscriminaIVA'];
		$aParametros['FECHA_HORA'] = $rs['dFecha'];
		
		$aParametros['NOMBRE_TASA_IVA'] = $rs['sTasaIVA'];
		$aParametros['NOMBRE_TIPO_AJUSTE'] = $rs['sTipoAjuste'];
		$aParametros['NOMBRE_TIPO_MONEDA'] = $rs['sTipoMoneda'];
		//echo  "discrimina  ".$rs['bDiscriminaIVA']."  tasa iva  ".$rs['fTasa'];
		
		$aParametros['ESTADO'] = $rs['sEstado'];
		
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
		
		$aParametros['datos_cuenta'] = $sString;
	}
	
	
	if($_GET['action'] == 'new')
	{
		$aParametros['DISPLAY_NUEVO'] = "display:none";
		$aParametros['DISPLAY_GUARDAR'] = "display:block";
	}
	else
	{	
		$aParametros['DISPLAY_NUEVO'] = "display:inline";
		$aParametros['DISPLAY_GUARDAR'] = "display:none";
	}

	
	$aParametros['OPTIONS_TIPOS_AJUSTES'] = $oMysql->getListaOpciones('TiposAjustes','id','sNombre', $idTipoAjuste, "sEstadoAjuste='A' AND sDestino = 'US'");
	$aParametros['OPTIONS_TIPOS_MONEDAS'] = $oMysql->getListaOpciones('TiposMonedas','id','sNombre', $idTipoMoneda);
	$aParametros['OPTIONS_TASAS_IVA'] = $oMysql->getListaOpciones('TasasIVA','id','sNombre', $idTasaIVA, "sEstado='A'");	
	
	if(!$aParametros['datos_cuenta'])
	{
		$aParametros['datos_cuenta'] = "<span style='color:#F00;font-size:11px;'>- ingrese numero de cuenta de usuario o identifiquelo desde busqueda avanzada</span>";
	}

	
	//echo  "dadasdada";
	
	
	
	
	$oXajax=new xajax();

	$oXajax->registerFunction("getDatosAjustes");
	//$oXajax->registerFunction("buscarDatosUsuario");	
	//$oXajax->registerFunction("getCuentaUsuario");		
	$oXajax->registerFunction("buscarDatosUsuarioPorCuentaAU");		
	$oXajax->registerFunction("updateEstadoAjusteUsuario");
	$oXajax->registerFunction("updateDatosAjustesUsuarios");
	$oXajax->registerFunction("getTasaIVA");
			
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");
	
	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		

	$id_s = $_SESSION['id_suc']; 
	$id_oficina = $_SESSION['ID_OFICINA'];
	
	$sSucursales = $oMysql->getListaOpciones( 'Sucursales', 'Sucursales.id', 'Sucursales.sNombre',$id_s);    
	$sSelectSucursales = "
							<tr>
								<th>
									Sucursal:
								</th>
								<td>	
									<select name='idSucursal' id='idSucursal' value='' style='width:200px;'>
									{$sSucursales}
									</select>
								</td>
							</tr>
						";
	
	$sOficinas =$oMysql->getListaOpcionesCondicionado( 'idSucursal','idOficina', 'Oficinas', 'Oficinas.id', 'Oficinas.sApodo', 'idSucursal',"Oficinas.sEstado = 'A'", '',$id_oficina);
	$sSelectOficinas = "
							<tr>
								<th>
									Oficina:
								</th>
								<td>	
									<select name='idOficina' id='idOficina' value='' style='width:200px;'>
									{$sOficinas}
									</select>
								</td>
							</tr>
						";
	
	$sEmpleados = 
		$oMysql->getListaOpcionesCondicionado( 'idOficina','idEmpleado', 'Empleados', 'Empleados.id', 'Empleados.sLogin', 'idOficina', "Empleados.sEstado = 'A'", '',$_SESSION['id_user']);
	$sSelectEmpleados = "
							<tr>
								<th>
									Empleado
								</th>
								<td>	
									<select name='idEmpleado' id='idEmpleado' value='{EMPLEADOS}' style='width:200px;'>
									{$sEmpleados}
									</select>
								</td>
							</tr>
						";
	
	$aParametros['OPTIONS_SUCURSALES'] = $sSelectSucursales;
	$aParametros['OPTIONS_OFICINAS'] = $sSelectOficinas;
	$aParametros['SELECT_EMPLEADOS'] = $sSelectEmpleados;
	
	if($bEditar){echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/AjustesUsuarios/AjustesUsuariosVista.tpl",$aParametros);}
	else {echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/AjustesUsuarios/AjustesUsuarios.tpl",$aParametros);	}
	
	echo xhtmlFootPagina();
?>