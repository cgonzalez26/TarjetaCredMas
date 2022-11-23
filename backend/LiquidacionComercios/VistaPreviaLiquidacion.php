<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$aParametros = array();
	
	$aParametros = getParametrosBasicos(1);
	$aParametros['IMAGES_DIR'] = $aParametros['JS_DIR'] . '/images';
	
	$template = "ReciboLiquidacion.tpl";

	/*$mysql->setDBName("AccesosSistemas");
	$sConsulta = "SELECT CONCAT(Empleados.sApellido, ', ', Empleados.sNombre) as 'sEmpleado',
	Sucursales.sNombre as 'sSucursal',
    Oficinas.sApodo as sOficina
	FROM 
		Empleados 
	LEFT JOIN Oficinas ON Oficinas.id= Empleados.idOficina 
	LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal
	WHERE Empleados.id = {$_SESSION['id_user']}";
	
	$sDatosEmpleado = $mysql->query($sConsulta,true);
	
	$aParametros['OFICINA'] = $sDatosEmpleado[0]["sOficina"];
	$aParametros['SUCURSAL'] = $sDatosEmpleado[0]["sSucursal"];
	$aParametros['EMPLEADO'] = $sDatosEmpleado[0]["sEmpleado"];*/
		
	//$sCondiciones = "WHERE Cobranzas.id = 18";
	$sCondiciones = "WHERE Liquidaciones.id = {$_GET['idLiquidacion']}";
	$Liquidacion=$oMysql->consultaSel("Call usp_getLiquidaciones(\"$sCondiciones\");",true); 		
	
	$aParametros["Importe_Bruto"] = $Liquidacion["fImporteBruto"];
	$aParametros["Arancel"] = $Liquidacion["fImporteArancel"];
	$aParametros["IVA_Arancel"] = $Liquidacion["fIVA_Arancel"];
	$aParametros["Costo_Financiero"] = $Liquidacion["fImporteCostoFinanciero"];
	$aParametros["IVA_Costo_Financiero"] = $Liquidacion["fIVA_CostoFinanciero"];
	$aParametros["Retenciones_IVA"] = $Liquidacion["fImporteRetencionIVA"];
	$aParametros["Retenciones_Ganancias"] = $Liquidacion["fImporteRetencionGanancias"];
	$aParametros["Retenciones_Ing_Brutos"] =$Liquidacion["fImporteRetencionIngBrutos"];
	$aParametros["Ajustes"] =$Liquidacion["fAjuste"];
	$aParametros["IVA_Ajuste"] = $Liquidacion["fIVA_Ajuste"];
	$aParametros["Importe_Neto"] =$Liquidacion["fImporteNeto"];
	
	$aParametros["URL_BACK"] = "Liquidaciones.php";
		
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Liquidaciones/$template",$aParametros);	

	echo xhtmlFootPagina();

?>
