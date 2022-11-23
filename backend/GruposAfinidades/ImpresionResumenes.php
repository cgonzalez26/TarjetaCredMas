<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();
	

	#Control de Acceso al archivo
	//if(!isLogin())
	//{
		//go_url("/index.php");
	//}
	//$mysql->setDBName("AccesosSistemas");//Cambio de Base de Datos
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	
	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
		
	if ($Pagina <= 0) $Pagina = 1;

	$NombreMod = 'Cuentas'; // Nombre del modulo
	$NombreTipoRegistro = 'Cuenta';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Cuentas'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('CuentasUsuarios.sNumeroCuenta','CuentasUsuarios.dFechaRegistro', 'InformesPersonales.sApellido','InformesPersonales.sDocumento','InformesPersonales.idProvincia','InformesPersonales.idLocalidad','CuentasUsuarios.idEstado');
	$arrListaEncabezados = array('Nro. Cuenta','Fecha Alta','Titular','Documento','Localidad','Estado');
	$Tabla = 'CuentasUsuarios'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'CuentasUsuarios.dFechaRegistro'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 150; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
	$idGrupoAfinidadImpresion = 0;
	$dPeriodoImpresion = '';
	$idRegionImpresion = 0;
	$idSucursalImpresion = 0;
	$idProvinciaImpresion = 0;
	
	if(isset($_POST['buscar']))
	{	
		$idGrupoAfinidadImpresion = $_POST['idGrupoAfinidadImpresion'];
		$dPeriodoImpresion = $_POST['dPeriodoImpresion'];
		$idRegionImpresion = $_POST['idRegionImpresion'];
		$idSucursalImpresion = $_POST['idSucursalImpresion'];
		$idProvinciaImpresion = $_POST['idProvinciaImpresion'];
		
		if(!session_is_registered('idGrupoAfinidadImpresion'))
		{
			session_register('idGrupoAfinidadImpresion');
			session_register('idPeriodoImpresion');
			session_register('idRegionImpresion');
			session_register('idSucursalImpresion');
			session_register('idProvinciaImpresion');
		}
	
		$_SESSION['idGrupoAfinidadImpresion'] = $_POST['idGrupoAfinidadImpresion'];	
		$_SESSION['dPeriodoImpresion'] = $_POST['dPeriodoImpresion'];
		$_SESSION['idRegionImpresion'] = $_POST['idRegionImpresion'];
		$_SESSION['idSucursalImpresion'] = $_POST['idSucursalImpresion'];
		$_SESSION['idProvinciaImpresion'] = $_POST['idProvinciaImpresion'];
		unset($_SESSION['volver']);
	}
	else
	{
		$idGrupoAfinidadImpresion = $_SESSION['idGrupoAfinidadImpresion'];
		$dPeriodoImpresion = $_SESSION['dPeriodoImpresion'];	
		$idRegionImpresion = $_SESSION['idRegionImpresion'];	
		$idSucursalImpresion = $_SESSION['idSucursalImpresion'];	
		$idProvinciaImpresion = $_SESSION['idProvinciaImpresion'];
	}

	$sWhere = "";
	$aCond=Array();
	if($idGrupoAfinidadImpresion != 4)
		if($idGrupoAfinidadImpresion)$aCond[]="  CuentasUsuarios.idGrupoAfinidad ='{$idGrupoAfinidadImpresion}' ";		
		//if($idGrupoAfinidadImpresion){$aCond[]=" CuentasUsuarios.idGrupoAfinidad= {$idGrupoAfinidadImpresion} ";}
		
	if($dPeriodoImpresion){	
		$CuentasDelPeriodo = $oMysql->consultaSel("SELECT CuentasUsuarios.id FROM CuentasUsuarios LEFT JOIN DetallesCuentasUsuarios ON CuentasUsuarios.id = DetallesCuentasUsuarios.idCuentaUsuario
				WHERE DetallesCuentasUsuarios.dPeriodo ='{$dPeriodoImpresion}' AND DetallesCuentasUsuarios.iEmiteResumen=1");		
		$sCuentas = implode(",",$CuentasDelPeriodo);
		$aCond[]=" CuentasUsuarios.id IN ({$sCuentas})";
	}
	
	$sEmpleadosRegion = "";
	$sEmpleadosSucursal =  "";
	if($idRegionImpresion){
		$aEmpleados = $oMysql->consultaSel("SELECT Empleados.id FROM Empleados 
			LEFT JOIN Oficinas ON Oficinas.id= Empleados.idOficina LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal LEFT JOIN Regiones ON Regiones.id=Sucursales.idRegion
			WHERE Regiones.id = {$idRegionImpresion} ORDER BY Empleados.id DESC",true);
		$sEmpleadosRegion .= implode(",",$aEmpleados);
		//$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosRegion})";
	}
	if($idSucursalImpresion){
		$aEmpleados = $oMysql->consultaSel("SELECT Empleados.id FROM Empleados 
			LEFT JOIN Oficinas ON Oficinas.id= Empleados.idOficina LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal 
			WHERE Sucursales.id = {$idSucursalImpresion} ORDER BY Empleados.id DESC",true);
		$sEmpleadosSucursal .= implode(",",$aEmpleados);
		//$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosSucursal})";
	}
	
	if($idRegionImpresion > 0 and $idSucursalImpresion > 0){
		$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosSucursal})";
	}elseif ($idRegionImpresion > 0 and $idSucursalImpresion == 0){
		$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosRegion})";
	}
	if($idProvinciaImpresion > 0)
		$aCond[]=" SolicitudesUsuarios.idProvinciaResumen = {$idProvinciaImpresion}";
		
	/*if($sEmpleadosRegion != "")
		if($sEmpleadosSucursal != "")
			$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosSucursal})";
		/*else
			$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosRegion})";*/
			
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
	//echo $sCondiciones;
	
	$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondiciones\");";
	$sqlDatos_sLim="Call usp_getCuentasUsuarios(\"$sCondiciones_sLim\");";
	//if($_SESSION['id_user']==296)echo $sqlDatos_sLim;
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
	//echo $sqlDatos;	
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);

	$oXajax=new xajax();
	$oXajax->setCharEncoding('ISO-8859-1');
    $oXajax->configure('decodeUTF8Input',true);
	$oXajax->registerFunction("imprimirResumenes");
	$oXajax->registerFunction("cargarOptionsPeriodos");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	//$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);	
	
	function imprimirResumenes($sCuentas,$idGrupoAfinidad,$dPeriodo){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$iTieneresumen = 0;
		//$oRespuesta->alert($dPeriodo);
		$aCuentas = explode(",",$sCuentas);
		$sTablaFinal = "";
		foreach ($aCuentas as $idCuentaUsuario){			
			//$sNumeroCuenta = $oMysql->consultaSel("SELECT sNumeroCuenta FROM CuentasUsuarios WHERE id={$idCuentaUsuario}",true);
			
			$aPeriodo = explode("-",$dPeriodo);
			$dPeriodoFormat = $aPeriodo[1]."-".$aPeriodo[0];
			$archivo = "../includes/Files/Datos/".$dPeriodoFormat."/DR_".$idGrupoAfinidad."_".$idCuentaUsuario."_".$dPeriodoFormat.".xml"; 
			$sTabla ="";
			$sTitular = "";
			if (file_exists($archivo)) 	{
				$oXml= simplexml_load_file($archivo);
			}else{
				$msje = "No existe xml";
			}

			$sDomicilio = html_entity_decode($oXml->sDomicilio);			
			$sTitular = html_entity_decode($oXml->sTitular);	
			//$oRespuesta->alert($sDomicilio);
			$aParametros['ID_CUENTA'] = $idCuentaUsuario;
			$idGrupoAfinidad = $oXml->idGrupoAfinidad;				
			$aParametros['TITULAR'] = $sTitular;
			$aParametros['NUMERO_CUENTA'] = $oXml->sNumeroCuentaUsuario;
			$aParametros['SALDO_ANTERIOR'] =  $oXml->fSaldoAnterior;
			$aParametros['FECHA_CIERRE'] = $oXml->dFechaCierre;
			$aParametros['FECHA_VTO'] =$oXml->dFechaVencimiento;
			$aParametros['FECHA_CIERRE_PROX'] = $oXml->dFechaCierreSiguiente;
			$aParametros['FECHA_VTO_PROX'] = $oXml->dFechaVencimientoSiguiente;
			$aParametros['FECHA_INICIO'] = $oXml->dFechaInicio;
			$aParametros['LIMITE_CREDITO'] = $oXml->fLimiteCredito;
			$aParametros['REMANENTE_CREDITO'] = $oXml->fRemanenteCredito;
			$aParametros['LIMITE_COMPRA'] = $oXml->fLimiteCompra;
			$aParametros['REMANENTE_COMPRA'] = $oXml->fRemanenteCompra;
			$aParametros['DOMICILIO'] = $sDomicilio;
			
			/*$aFechaInicio = explode('/',$oXml->dFechaInicio);
			$dFechaInicio = $aFechaInicio[2]."-".$aFechaInicio[1]."-".$aFechaInicio[0]." 00:00:00";
			$sCondicionCalendario = " CalendariosFacturaciones.idGrupoAfinidad={$idGrupoAfinidad} AND YEAR(CalendariosFacturaciones.dPeriodo)=YEAR('{$dPeriodo}') 
								AND MONTH(CalendariosFacturaciones.dPeriodo)<=MONTH('{$dPeriodo}') AND MONTH(CalendariosFacturaciones.dPeriodo)>=MONTH('{$dFechaInicio}')";
			
			$aParametros['optionsCalendario'] =$oMysql->getListaOpciones("CalendariosFacturaciones","id","DATE_FORMAT(dPeriodo, '%m/%Y')",'',$sCondicionCalendario,true,'CalendariosFacturaciones.dPeriodo DESC');*/
			
			//rules='all' border='1'
			$sTabla .= "<table id='TablaDatos' cellpadding='0' cellspacing='0' width='100%' style='font-family:Arial;font-size:10px;' >
						<tr><td style='width:170px;height:30px;padding-left:10px;'>&nbsp;</td><td style='width:160px;'>&nbsp;</td><td style='width:70px;'>&nbsp;</td><td style='width:40px;'>&nbsp;</td><td style='width:40px;'>&nbsp;</td><td style='width:55px;' align='right'>&nbsp;</td></tr>";
			//$fTotal = 0;
			
			$sTabla .= "<tr><td>SALDO ANTERIOR</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align='right'>".number_format((double)$oXml->fSaldoAnterior,2,'.','')."</td></tr>";
			/*foreach ($oXml->detalle as $aDetalle) {
				
				$sNumeroCupon = $aDetalle->sNumeroCupon;				
				$sNumeroCuota =$aDetalle->sNumeroCuota."/".$aDetalle->sCantidadCuota;
				if($aDetalle->sNumeroCupon == "") $sNumeroCupon="&nbsp;";
				if($aDetalle->sNumeroCuota == "") $sNumeroCuota="&nbsp;";
				
				$signo = "";
				if($aDetalle->tipoOperacion == "4" || $aDetalle->tipoOperacion == "2") $signo = "-";
				//if($aDetalle->tipoOperacion == "4") $signo = "-";
				$sTabla .= "<tr>
						<td style='padding-peft:3px;font-size:9px'>{$aDetalle->sDescripcion}</td>
						<td style='padding-peft:3px;font-size:9px'>{$aDetalle->sSucursal}</td>
						<td>{$aDetalle->dFechaOperacion}</td>
						<td>{$sNumeroCuota}</td>
						<td>{$sNumeroCupon}</td>
						<td align='right'>".$signo.number_format($aDetalle->fImporte,2,'.','')."</td>
						</tr>";			
				//$fTotal += $aDetalle->fImporte;
			}		
			$sTabla .= "</table>";
			$aParametros['TABLA_DATOS'] = $sTabla;*/
			$nuevaPagina = false;
			$sFilas1 = "";
			$sFilas2 = "";
			$i =0;
			foreach ($oXml->detalle as $aDetalle) {
				$i++;
				$sNumeroCupon = $aDetalle->sNumeroCupon;				
				$sNumeroCuota =$aDetalle->sNumeroCuota."/".$aDetalle->sCantidadCuota;
				if($aDetalle->sNumeroCupon == "") $sNumeroCupon="&nbsp;";
				if($aDetalle->sNumeroCuota == "") $sNumeroCuota="&nbsp;";
				
				$signo = "";				
				if($aDetalle->tipoOperacion == "4" || $aDetalle->tipoOperacion == "2") $signo = "-";
			
				if($i > 13){
					$sFilas2 = "<tr>
						<td style='padding-peft:3px;font-size:9px'>{$aDetalle->sDescripcion}</td>
						<td style='padding-peft:3px;font-size:9px'>{$aDetalle->sSucursal}</td>
						<td>{$aDetalle->dFechaOperacion}</td>
						<td>{$sNumeroCuota}</td>
						<td>{$sNumeroCupon}</td>
						<td align='right'>".$signo.number_format((double)$aDetalle->fImporte,2,'.','')."</td>
						</tr>";
					$nuevaPagina = true;	  
				}else{
					$sFilas1 .= "<tr>
						<td style='padding-peft:3px;font-size:9px'>{$aDetalle->sDescripcion}</td>
						<td style='padding-peft:3px;font-size:9px'>{$aDetalle->sSucursal}</td>
						<td>{$aDetalle->dFechaOperacion}</td>
						<td>{$sNumeroCuota}</td>
						<td>{$sNumeroCupon}</td>
						<td align='right'>".$signo.number_format((double)$aDetalle->fImporte,2,'.','')."</td>
						</tr>";			
				}
			}
				//$fTotal += $aDetalle->fImporte;
			if($nuevaPagina)
				$sFilas1 .= "<tr><td colspan='6'>Pagina 1/2</td></tr>";
			$sTabla1 .= $sTabla . $sFilas1. "</table>";
			$aParametros['TABLA_DATOS'] = $sTabla1;
			
			$aParametros['IMPORTE_TOTAL'] = "$ ".$oXml->fTotalResumen;
			if($oXml->fTotalResumen < 0)
				$oXml->fTotalResumen = 0;
			$sCodigo = generarCodigoBarra($oXml->sNumeroCuentaUsuario,$oXml->fTotalResumen,$oXml->dFechaVencimiento);
			$aParametros['CODIGO_BARRA'] = $sCodigo;
			
			$sTablaFinal.= parserTemplate( INCLUDES_DIR . "/Files/Modelos/MR_1.tpl",$aParametros);
			$sTablaFinal.="<div  id='saltopagina' style='display:block;page-break-before:always;' /></div>";
			$sTabla2 = "";
			if($nuevaPagina){
				$sFilas2 .= "<tr><td colspan='6'>Pagina 2/2</td></tr>";
				$sTabla2 .= $sTabla . $sFilas2. "</table>";
				$aParametros['TABLA_DATOS'] = $sTabla2;
				$sTablaFinal.= parserTemplate( INCLUDES_DIR . "/Files/Modelos/MR_1.tpl",$aParametros);
				$sTablaFinal.="<div  id='saltopagina' style='display:block;page-break-before:always;' /></div>";
			}
		}
		$oRespuesta->assign("impresiones","innerHTML",$sTablaFinal);		
		$oRespuesta->script("window.print();");
		return  $oRespuesta;
	}
	
	/*function arrayToOptionsPeriodosAnioActual($dPeriodo){
		global $oMysql;
		$sOptions = "";	
		$select="";
		$anioActual = date("Y");				
		$anioAnterior = date("Y")-1;		
		
		$sOptions .= "<option value='0' selected='selected'>Seleccionar..</option>";
		for($i = 1; $i <= 12; $i++){
			$mes= (string)$i;
			if(strlen($mes) == 1) $mes = "0".(string)$i;
			else $mes = (string)$i;
			
			$text = $mes."/".$anioAnterior;
			$value = $anioAnterior."-".$mes."-01 00:00:00";
			$select = "";
			if($value == $dPeriodo) $select = "selected";
			
			$sOptions .= "<option value='{$value}' $select>{$text}</option>";
		}		

		for($i = 1; $i <= 12; $i++){
			$mes= (string)$i;
			if(strlen($mes) == 1) $mes = "0".(string)$i;
			else $mes = (string)$i;
			
			$text = $mes."/".$anioActual;
			$value = $anioActual."-".$mes."-01 00:00:00";
			$select = "";
			if($value == $dPeriodo) $select = "selected";
			
			$sOptions .= "<option value='{$value}' $select>{$text}</option>";
		}		
		return $sOptions;
	}*/
	
	function cargarOptionsPeriodos($idGrupoAfinidad,$dPeriodo){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();		
		
		if($idGrupoAfinidad == 4) $idGrupoAfinidad = 1;
		$where = (is_null($idGrupoAfinidad)) ? "" : "CalendariosFacturaciones.idGrupoAfinidad = '$idGrupoAfinidad'" ;	
		
		$aDatos = $oMysql->consultaSel("CALL usp_getSelect(\"CalendariosFacturaciones\",\"dPeriodo\",\"DATE_FORMAT(dPeriodo, '%m/%Y')\",\"$where\");");
		if(count($aDatos)>0){	
			$options = arrayToOptionsPeriodos(($oMysql->consultaSel("CALL usp_getSelect(\"CalendariosFacturaciones\",\"dPeriodo\",\"DATE_FORMAT(dPeriodo, '%m/%Y')\",\"$where\");")),$dPeriodo);		
			$selects = "<select name='dPeriodoImpresion' id='dPeriodoImpresion' style='width:150px;'><option value='0'>Selecccionar...</option>
					<option value='0'></option>".$options."</select>";		
		}else{
			$selects = '<select id="dPeriodoImpresion" style="width:150px;" name="dPeriodoImpresion" disabled="">
				<option value="0">Seleccionar...</option>
				</select>';
		}
		$oRespuesta->assign('tdPeriodos','innerHTML',$selects);
		return  $oRespuesta;	
	}
	
	$sCondicion = " sEstado='A'";
	$aParametros['optionsGrupos'] = $oMysql->getListaOpciones("GruposAfinidades","id","sNombre",$idGrupoAfinidadImpresion,$sCondicion);
	$selected = "";
	if($idGrupoAfinidadImpresion == 4) $selected .= "selected";	
	$aParametros['optionsGrupos'] .= "<option style='text-align:left;' title='TODOS' value='4' $selected>TODOS</option>";	
	
	//$aParametros['optionsPeriodos'] = arrayToOptionsPeriodosAnioActual($dPeriodoImpresion);
	//$aParametros['optionsPeriodos'] = $oMysql->getListaOpcionesCondicionadoFormat("idGrupoAfinidadImpresion","dPeriodoImpresion","CalendariosFacturaciones","dPeriodo","DATE_FORMAT(dPeriodo, '%m/%Y')", 'idGrupoAfinidad','','',$dPeriodoImpresion,"DATE_FORMAT(dPeriodo, '%Y/%m')","ASC");
	$aParametros['optionsRegiones'] = $oMysql->getListaOpciones("Regiones","id","sNombre",$idRegionImpresion);
	$aParametros['optionsSucursales'] = $oMysql->getListaOpcionesCondicionado( 'idRegionImpresion', 'idSucursalImpresion', 'Sucursales', 'id', 'sNombre', 'idRegion','','',$idSucursalImpresion);
	$aParametros['optionsProvincias'] = $oMysql->getListaOpciones("Provincias","id","sNombre",$idProvinciaImpresion);
	
	//if(isset($_POST['buscar'])){			
	if($idGrupoAfinidadImpresion){
		$aParametros['SCRIPT'] = "xajax_cargarOptionsPeriodos(".$idGrupoAfinidadImpresion.",'".$dPeriodoImpresion."');";
	}
	
	$aParametros['ID_GRUPO_AFINIDAD'] = $idGrupoAfinidadImpresion;
	$aParametros['PERIODO'] = $dPeriodoImpresion;
?>

<body style="background-color:#FFFFFF;">
<div id="BODY">
<center>
<?php 		
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorImpresionResumen.tpl",$aParametros);

	if (count($result)==0){echo "Ningun registro encontrado";}
	$sCadena = "";
	if ($result){	

    /*$sCadena .= "<p>Hay ".$CantReg." ";
    if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
    else $sCadena .= $NombreTipoRegistro;

    $sCadena .= " en la base de datos.</p>*/
	$sCadena .= "
		<form action='getImpresionResumenes_test.php' method='POST' id='formImpresion'>
		<input type='hidden' id='sCuentas' name='sCuentas' value='' />
		<input type='hidden' id='hdnIdGrupoAfinidad' name='hdnIdGrupoAfinidad' value=0 />
		<input type='hidden' id='hdndPeriodo' name='hdndPeriodo' value='' />
		
		<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='90%' id='tablaCuentas' >
		<tr class='filaPrincipal'>
		<!-- Lista de encabezados de columna -->";
	
  	$CantEncabezados = count($arrListaEncabezados);
	for($i=0; $i<$CantEncabezados; $i++){
		$sCadena .= "<th style='height:25px'>";
		if($CampoOrden == $arrListaCampos[$i]){
			//var_export('entro');
			if ($TipoOrden == 'ASC') $NuevoTipoOrden = 'DESC'; else $NuevoTipoOrden = 'ASC';
		}
		else $NuevoTipoOrden = 'ASC';
		//var_export($TipoOrden.'----'.$NuevoTipoOrden);
		$sCadena .= "<a href=\"{$_SERVER['PHP_SELF']}?CampoOrden={$arrListaCampos[$i]}&TipoOrden={$NuevoTipoOrden}\">{$arrListaEncabezados[$i]}";
		if($CampoOrden == $arrListaCampos[$i]){
			if ($TipoOrden == 'ASC') 
				$sCadena .= "<img src='../includes/images/go-up.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendente' title='Ordenado por {$arrListaEncabezados[$i]} Ascendente'/></a>"; 
			else 
				$sCadena .= "<img src='../includes/images/go-down.png' alt='Ordenado por {$arrListaEncabezados[$i]} Descendente' title='Ordenado por {$arrListaEncabezados[$i]} Descendente'/></a>";
		}
		$sCadena .= "</th>\r\n";
	}
  
	///Opciones de Mod. y Elim.
	$sCadena .="<th style='cursor:pointer;width:20px'><input type='checkbox' onclick='tildar_checkboxs( this.checked )' id='checkbox_principal' /> </th></tr>";
    echo $sCadena;

	$CantMostrados = 0;
	foreach ($result as $rs ){
		$sBotonera = '';	
		$CantMostrados ++;
		$PK = $rs['id'];
		$sClase='';
		switch ($rs['sEstado']){
			case 'S': $sClase="class='naranja'"; break;//estado Suspendido
			case 'B': $sClase="class='rojo'"; break;//estado Baja
			case 'U': $sClase="class='azul'"; break;//estado cambio de Clave
		}
	
		$sUsuario = $rs['sApellido'].', '.$rs['sNombre'];
		$optionEditar = 0;
		?>
		<tr id="empleado<?php echo $PK;?>">
			<!-- Valores -->
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumeroCuenta'];?></td>
			<td width="15%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['dFechaRegistro'];?></td>
			<td width="25%" align="left" <?php echo $sClase;?>>&nbsp;<?=convertir_especiales_html($sUsuario);?></td>
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sDocumento'];?></td>	
			<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=convertir_especiales_html($rs['sLocalidad']);?></td>	
			<td width="15%" id="estado<?php echo$rs['sNumero']?>" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sEstado'];?></td>	
			<!-- Links para Mod. y Elim. -->
			<td align="center" width="2%"><input type='checkbox' id='aCuentaUsuario[]' name='aCuentaUsuario[]' class="check_user" value='<?php echo $PK;?>'/> </td>
		</tr>
		<?
	}
	?>	
	<!--<div style='font-size:10px;text-align:left;width:80%'>
		<span class='rojo'>Rojo-Solicitudes Rechazas. <span><br><span class='naranja'>Naranja-Solicitudes Anuladas <span><br><span class='azul'>Azul-Solicitudes de Alta<span>
	</div>-->
	</center>
	<!--</form>-->
	<!-- Paginacion -->
	<?
	if (ceil($CantRegFiltro/$RegPorPag) > 1){
		echo "<p>P&aacute;gina $Pagina. Mostrando $CantMostrados de $CantRegFiltro $NombreTipoRegistroPlu.</p>\r\n";
	
		echo "<p>";
		if ($Pagina > 1) echo "<a href=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}&Pagina=". ($Pagina-1) ."\">Anterior</a>";
		if ($Pagina > 1 && $Pagina<ceil($CantRegFiltro/$RegPorPag)) echo " - ";
	
		if ($Pagina<ceil($CantRegFiltro/$RegPorPag)) echo "<a href=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}&Pagina=". ($Pagina+1) ."\">Siguiente</a>";
	
		echo " | P&aacute;ginas: ";
		$strPaginas = '';
		
		for($i=1;$i<=ceil($CantRegFiltro/$RegPorPag);$i++){
			if ($i == $Pagina) $strPaginas .= "<b>";
			else $strPaginas .= "<a href=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}&Pagina=". $i ."&nombre_u=".$nombre_u."&condic=".$condic1."\">";
			$strPaginas .= $i;
			if ($i == $Pagina) $strPaginas .= "</b> - ";
			else $strPaginas .= "</a> - ";
		}
		echo substr($strPaginas, 0, strlen($strPaginas) - 3);
	}
	?>
		</tr>
		<tr>
		   <td colspan="7" align="right">
		   	   <div> 
		   	    	<button type="button" onclick="generarResumen();"> Imprimir Resumen </button> &nbsp;

		   	   		<button type="button" onclick="generarExcelDirecciones();"> Imprimir Direcciones </button> &nbsp;
		   	    </div>
		   </td>
		</tr> 
	</table>
	

	</form>

<?
	if (ceil($CantRegFiltro/$RegPorPag) > 1)
	{
		echo "<p>P&aacute;gina $Pagina. Mostrando $CantMostrados de $CantRegFiltro $NombreTipoRegistroPlu.</p>\r\n";
	
		echo "<p>";
		if ($Pagina > 1) echo "<a href=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}&Pagina=". ($Pagina-1) ."\">Anterior</a>";
		if ($Pagina > 1 && $Pagina<ceil($CantRegFiltro/$RegPorPag)) echo " - ";
	
		if ($Pagina<ceil($CantRegFiltro/$RegPorPag)) echo "<a href=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}&Pagina=". ($Pagina+1) ."\">Siguiente</a>";
	
		echo " | P&aacute;ginas: ";
		$strPaginas = '';
		
		for($i=1;$i<=ceil($CantRegFiltro/$RegPorPag);$i++){
			if ($i == $Pagina) $strPaginas .= "<b>";
			else $strPaginas .= "<a href=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}&Pagina=". $i ."&nombre_u=".$nombre_u."&condic=".$condic1."\">";
			$strPaginas .= $i;
			if ($i == $Pagina) $strPaginas .= "</b> - ";
			else $strPaginas .= "</a> - ";
		}
		echo substr($strPaginas, 0, strlen($strPaginas) - 3);
	}
}	
?>
	</center>
<script>
	function obtenerCuentasSeleccionadas(){
		var el = document.getElementById('tablaCuentas');
		var imputs= el.getElementsByTagName('input');
		var sTarjetas = "";
	  	for (var i=0; i<imputs.length; i++){
	  	 	 if (imputs[i].type=='checkbox') 		    	
	    		if(imputs[i].checked && imputs[i].className =="check_user"){ 
	    			sTarjetas += imputs[i].value+',';
	    		}
	  	} 
	  	sTarjetasCreditos =  sTarjetas.substring(0,sTarjetas.length-1); 
	  	return sTarjetasCreditos;
	}

	function generarResumen(){
	  var mensaje="Esta seguro de Reimprimir los Resumenes seleccionados?"; 
	  var el = document.getElementById('tablaCuentas');
	  var imputs= el.getElementsByTagName('input');
	  var band=0;		  		  
	  for (var i=0; i<imputs.length; i++){			
	    if (imputs[i].type=='checkbox'){ 		    	
	    	if(!imputs[i].checked){
	         	band=0; 
	     	}else{ 
	     		band=1; break;
	     	}
	    }	
	  }
	  	
	  if(band==1)
	  {
	  	 if(confirm(mensaje)){
	  	 	var sCuentas = obtenerCuentasSeleccionadas();
	  	 	//var idGrupoAfinidad = document.getElementById("hdnIdGrupoAfinidad").value;
	  	 	//var dPeriodo = document.getElementById("hdndPeriodo").value;
	  	 	//alert(sCuentas+"    "+idGrupoAfinidad+"      "+dPeriodo);
	  	 	document.getElementById('sCuentas').value = sCuentas;
	  	 	//document.getElementById("hdnIdGrupoAfinidad").value = document.getElementById("idGrupoAfinidadImpresion").value;
	  	 	//document.getElementById("hdndPeriodo").value = document.getElementById("dPeriodoImpresion").value;
	  	 	document.getElementById('formImpresion').submit();
	  	 	//xajax_imprimirResumenes(sCuentas,idGrupoAfinidad,dPeriodo);
	  	 }
	  }		
   	  else alert('Debe Elegir al menos una Cuenta de Usuario para  Reimprimir Resumen.');	   
	}
	function generarExcelDirecciones()
	{
		var idGrupoAfinidad = document.getElementById("idGrupoAfinidadImpresion").value;
		var dPeriodo = document.getElementById("dPeriodoImpresion").value;
		var idRegion = document.getElementById("idRegionImpresion").value;
		var idSucursal = document.getElementById("idSucursalImpresion").value;
		
		window.location = "./xlsResumenes.php?idGrupoAfinidad="+idGrupoAfinidad+"&dPeriodo="+dPeriodo+"&idRegion="+idRegion+"&idSucursal="+idSucursal;
	}
</script>

<?php echo xhtmlFootPagina();?>