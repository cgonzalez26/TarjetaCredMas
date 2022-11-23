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
	
	$idTipoMoneda = 1;
	$bEditar = false;
	$idEmpleado = $_SESSION['id_user'];	
	$aParametros['FECHA_PRESENTACION'] = date('d/m/Y');
	$aParametros['FECHA_COBRANZA'] = $aParametros['FECHA_PRESENTACION'];
	$aParametros['fecha_hora'] = date('d/m/Y h:i');
	
	if($_GET['idCobranza'])
	{		
		$bEditar = true;
		$sCondiciones = " WHERE Cobranzas.id = {$_GET['idCobranza']}";
		$sqlDatos="Call usp_getCobranzas(\"$sCondiciones\");";
		
		$rs = $oMysql->consultaSel($sqlDatos,true);
			
		$aParametros['ID_COBRANZA'] = $_GET['idCobranza'];
		$aParametros['ID_CUENTA_USUARIO'] = _encode($rs['idCuentaUsuario']);
		$aParametros['FECHA_COBRANZA'] = $rs['dFechaCobranza'];
		$aParametros['FECHA_PRESENTACION'] = $rs['dFechaPresentacion'];
		$aParametros['IMPORTE'] = $rs['fImporte'];
		$aParametros['ESTADO'] = $rs['bEstado'];
		$aParametros['EStADO_FACTURACION_USUARIO'] = $rs['iEstadoFacturacionUsuario'];	
		$aParametros['TIPO_MONEDA'] = $rs['idTipoMoneda'];
		$aParametros['ID_EMPLEADO'] = $rs['idEmpleado'];	
		$aParametros['ESTADO'] = $rs['sEstado'];
		$aParametros['NOMBRE_MONEDA'] = $rs['sTipoMoneda'];
		$aParametros['fecha_hora']  = $rs['dFechaRegistro'];
		
		$idEmpleado = $rs['idEmpleado'];	

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
		//$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tarjeta: </label><label>' . $rsTarjeta["sNumeroTarjeta"] . '</label></div>';
		$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tipo Tarjeta: </label><label>' . $cartel_tipo_tarjeta . '</label></div>';
		$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>version: </label><label>' . $rsTarjeta["iVersion"] . '</label></div>';

		$aParametros['NUMERO_CUENTA'] = $rsTarjeta["sNumeroCuenta"];
		
		
		$sCondiciones = "WHERE idCuentaUsuario = {$idCuentaUsuario} AND DetallesCuentasUsuarios.iEmiteResumen=1 order by DetallesCuentasUsuarios.id DESC LIMIT 0,1 ";
		$sqlDatos = "CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");";	
		$result = $oMysql->consultaSel($sqlDatos,true);
		
		//echo "CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");";	
		
		if($result)
		{
			$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'></label><label>______________</label></div>';
			$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Ultimo Resumen: </label><label>' .  $result["dFechaCierre"] . '</label></div>';
			$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Importe: </label><label>' .  $result["fSaldoAnterior"] . '</label></div>';
		}	
		
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

	
	$aParametros['OPTIONS_TIPOS_MONEDAS'] = $oMysql->getListaOpciones('TiposMonedas','id','sNombre', $idTipoMoneda);
	//$aParametros['FECHA_PRESENTACION'] = $aParametros['FECHA_PRESENTACION'];
	//$aParametros['FECHA_COBRANZA'] = $aParametros['FECHA_COBRANZA'];
	//$aParametros['fecha_hora'] = date('d/m/Y h:i');
	
	//----------------------------------- Obtener datos de empeado ----------------------------------------------

	$sConsulta = "SELECT CONCAT(Empleados.sApellido, ', ', Empleados.sNombre) as 'sEmpleado',
	Sucursales.sNombre as 'sSucursal',
    Oficinas.sApodo as sOficina
	FROM 
		Empleados 
	LEFT JOIN Oficinas ON Oficinas.id= Empleados.idOficina 
	LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal
	WHERE Empleados.id = {$idEmpleado}";
	
	$sDatosEmpleado = $oMysql->consultaSel($sConsulta,true);
	
	$aParametros['oficina'] = $sDatosEmpleado[0]["sOficina"];
	$aParametros['empleado'] = $sDatosEmpleado[0]["sEmpleado"];
	$aParametros['sucursal'] = $sDatosEmpleado[0]["sSucursal"];
	//------------------------------------------------------------------------------------------------------------
	
	
	if(!$aParametros['datos_cuenta'])
	{
		$aParametros['datos_cuenta'] 	= "<span style='color:#F00;font-size:11px;'>- ingrese numero de cuenta de usuario o identifiquelo desde busqueda avanzada</span>";
	}

	//echo  "dadasdada";
	
	
	$oXajax=new xajax();

	$oXajax->registerFunction("updateDatosCobranzas");	
	$oXajax->registerFunction("buscarDatosUsuario");	
	$oXajax->registerFunction("getCuentaUsuario");		
	$oXajax->registerFunction("reasignarFechasDeFacturacion");					
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");
	
	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		

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
		$oMysql->getListaOpcionesCondicionado
			( 'idOficina','idEmpleado', 'Empleados', 'Empleados.id', 'Empleados.sLogin', 'idOficina', "Empleados.sEstado = 'A'", '',$_SESSION['id_user']);
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
		
	if($bEditar){echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Cobranzas/CobranzasVista.tpl",$aParametros);	}
	else{echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Cobranzas/Cobranzas.tpl",$aParametros);	}
	
	
	echo xhtmlFootPagina();
	//echo "</div><div id='impresionesCobranza'>{ToPrint}</div></body></html>";
?>

