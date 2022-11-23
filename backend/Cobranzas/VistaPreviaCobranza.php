<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$aParametros = array();

	$aParametros = getParametrosBasicos(1);
	$aParametros['IMAGES_DIR'] = $aParametros['JS_DIR'] . '/images';
	
	$template = "ReciboCobranza.tpl";
		
	$sCondiciones = "WHERE Cobranzas.id = {$_GET['idCobranza']}";
	$Cobranza=$oMysql->consultaSel("Call usp_getCobranzas(\"$sCondiciones\");",true); 
	
	$sConsulta = "SELECT CONCAT(Empleados.sApellido, ', ', Empleados.sNombre) as 'sEmpleado',
	Sucursales.sNombre as 'sSucursal',
    Oficinas.sApodo as sOficina
	FROM 
		Empleados 
	LEFT JOIN Oficinas ON Oficinas.id= Empleados.idOficina 
	LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal
	WHERE Empleados.id = {$Cobranza['idEmpleado']}";
	
	$sDatosEmpleado = $oMysql->consultaSel($sConsulta,true);
	
	$aParametros['OFICINA'] = $sDatosEmpleado[0]["sOficina"];
	$aParametros['SUCURSAL'] = $sDatosEmpleado[0]["sSucursal"];
	$aParametros['EMPLEADO'] = convertir_especiales_html($sDatosEmpleado[0]["sEmpleado"]);
	
	$V=new EnLetras(); 		
 		
	$sCantidad = $V->ValorEnLetras($Cobranza["fImporte"],"").'.-';
	//num2letras($Cobranza["fImporte"]);
	
	if($Cobranza["iTipoPersona"] == 1)
	{
		$sCliente = $Cobranza["sApellido"] .' ,'. $Cobranza["sNombre"];
	}
	else 
	{
		$sCliente = $Cobranza["sRazonSocial"];
	}
	
	
	$aParametros["FECHA_REGISTRO"] = $Cobranza["dFechaRegistro"];
	$aParametros["NUM_CUENTA"] = $Cobranza["sNumeroCuenta"];
	$aParametros["NUM_RECIBO"] = $Cobranza["sNroRecibo"];
	$aParametros["IMPORTE"] = $Cobranza["fImporte"];
	$aParametros["CLIENTE"] = $sCliente;
	$aParametros["CANTIDAD"] = 'Pesos ' .$sCantidad;
	$aParametros["URL_BACK"] = "Cobranzas.php";
	$aParametros["CODIGO_BARRA"] =$Cobranza["sCodigoBarra"];

	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Cobranzas/$template",$aParametros);	

	echo xhtmlFootPagina();
?>