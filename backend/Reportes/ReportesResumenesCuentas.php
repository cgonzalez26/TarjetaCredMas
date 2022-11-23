<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
	
	include_once( CLASSES_DIR . '/_table.class.php' );	
	include_once( CLASSES_DIR . '/_buttons.class.php' );
	
	//session_start();
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
		
	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
		
	if ($Pagina <= 0) $Pagina = 1;

	$NombreMod = 'DetallesCuentasUsuarios'; // Nombre del modulo
	$NombreTipoRegistro = 'DetalleCuentaUsuario';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Cuentas de Usuarios'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('','CuentasUsuarios.sNumeroCuenta', 'sTitular','sEstado','dFechaCierre','dFechaVencimiento','fSaldoAnterior','fAcumuladoConsumoUnPago','','','fInteresFinanciacion','fInteresPunitorio','','','fAcumuladoDebito','fAcumuladoIVAAjusteDebito','fAcumuladoCredito','fAcumuladoIVAAjusteCredito','fAcumuladoCobranzas','fImporteTotalPesos');
	$arrListaEncabezados = array('Nro.Reg.','Nro. Cuenta','Titular','Estado','Fch Cierre','Fch Vto','Saldo Ant.','Consumos','Bonific.','Int.Fin.','Int.Pun.','Gastos Admin.','Seg.Vida','Ajustes Deb','Ajustes Deb IVA','Ajustes Cred','Ajustes Cred IVA','Cobranzas','Total a Pagar');
	$Tabla = 'DetallesCuentasUsuarios'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'InformesPersonales.sApellido'; // Campo de orden predeterminado
	$TipoOrdenPre = 'ASC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
	$dPeriodoReporteResumen = 0;
	$idGrupoAfinidadReporteResumen = 0;
	$idRegionReporteResumen = 0;
	$fImporteReporteResumen = 0;
	
	if(isset($_POST['buscar']))
	{	
		if($_POST['fImporteReporteResumen'] == "") $_POST['fImporteReporteResumen'] = "0";
		$idRegionReporteResumen = $_POST['idRegionReporteResumen'];
		$idSucursalReporteResumen = $_POST['idSucursalReporteResumen'];
		$idOficinaReporteResumen = $_POST['idOficinaReporteResumen'];
		$dPeriodoReporteResumen = $_POST['dPeriodoReporteResumen'];
		$idGrupoAfinidadReporteResumen = $_POST['idGrupoAfinidadReporteResumen'];
		$dFechaDesdeReporteResumen = $_POST['dFechaDesdeReporteResumen'];
		$dFechaHastaReporteResumen = $_POST['dFechaHastaReporteResumen'];
		$dFechaDesdeReporteResumenFormat = $_POST['dFechaDesdeReporteResumenFormat'];
		$dFechaHastaReporteResumenFormat = $_POST['dFechaHastaReporteResumenFormat'];
		$fImporteReporteResumen = $_POST['fImporteReporteResumen'];
		
		if(!session_is_registered('dPeriodoReporteResumen'))
		{
			session_register('idRegionReporteResumen');
			session_register('idSucursalReporteResumen');
			session_register('idOficinaReporteResumen');
			session_register('dPeriodoReporteResumen');
			session_register('idGrupoAfinidadReporteResumen');
			session_register('dFechaDesdeReporteResumen');
			session_register('dFechaHastaReporteResumen');
			session_register('dFechaDesdeReporteResumenFormat');
			session_register('dFechaHastaReporteResumenFormat');
			session_register('fImporteReporteResumen');
		}
		$_SESSION['idRegionReporteResumen'] = $_POST['idRegionReporteResumen'];
		$_SESSION['idSucursalReporteResumen'] = $_POST['idSucursalReporteResumen'];
		$_SESSION['idOficinaReporteResumen'] = $_POST['idOficinaReporteResumen'];
		$_SESSION['dPeriodoReporteResumen'] = $_POST['dPeriodoReporteResumen'];		
		$_SESSION['idGrupoAfinidadReporteResumen'] = $_POST['idGrupoAfinidadReporteResumen'];
		$_SESSION['dFechaDesdeReporteResumen'] = $_POST['dFechaDesdeReporteResumen'];
		$_SESSION['dFechaHastaReporteResumen'] = $_POST['dFechaHastaReporteResumen'];
		$_SESSION['fImporteReporteResumen'] = $_POST['fImporteReporteResumen'];
		$_SESSION['dFechaDesdeReporteResumenFormat'] = $_POST['dFechaDesdeReporteResumenFormat'];
		$_SESSION['dFechaHastaReporteResumenFormat'] = $_POST['dFechaHastaReporteResumenFormat'];
		unset($_SESSION['volver']);
	}
	else
	{
		if(!isset($_GET['inicio'])){
			$idRegionReporteResumen = $_SESSION['idRegionReporteResumen'];
			$idSucursalReporteResumen = $_SESSION['idSucursalReporteResumen'];
			$idOficinaReporteResumen = $_SESSION['idOficinaReporteResumen'];
			$dPeriodoReporteResumen = $_SESSION['dPeriodoReporteResumen'];
			$idGrupoAfinidadReporteResumen = $_SESSION['idGrupoAfinidadReporteResumen'];
			$dFechaDesdeReporteResumen = $_SESSION['dFechaDesdeReporteResumen'];
			$dFechaHastaReporteResumen = $_SESSION['dFechaHastaReporteResumen'];
			$dFechaDesdeReporteResumenFormat = $_SESSION['dFechaDesdeReporteResumenFormat'];
			$dFechaHastaReporteResumenFormat = $_SESSION['dFechaHastaReporteResumenFormat'];			
			$fImporteReporteResumen = $_SESSION['fImporteReporteResumen'];
		}
	}
	if($idGrupoAfinidadReporteResumen != 4)
		if($idGrupoAfinidadReporteResumen)$aCond[]="  CuentasUsuarios.idGrupoAfinidad ='{$idGrupoAfinidadReporteResumen}' ";
	if($dPeriodoReporteResumen)$aCond[]="  DetallesCuentasUsuarios.dPeriodo ='{$dPeriodoReporteResumen}' ";
	if($fImporteReporteResumen)$aCond[]="  DetallesCuentasUsuarios.fImporteTotalPesos > '{$fImporteReporteResumen}' ";
	
	$sEmpleadosRegion = "";
	$sEmpleadosSucursal = "";
	$sEmpleadosOficina = "";
	if($idRegionReporteResumen){
		$aEmpleadosRegion = $oMysql->consultaSel("SELECT Empleados.id FROM Empleados 
			LEFT JOIN Oficinas ON Oficinas.id= Empleados.idOficina LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal LEFT JOIN Regiones ON Regiones.id=Sucursales.idRegion
			WHERE Regiones.id = {$idRegionReporteResumen} ORDER BY Empleados.id DESC");
		$sEmpleadosRegion .= implode(",",$aEmpleadosRegion);		
		
		$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosRegion})";
	}
	if($idSucursalReporteResumen){
		$aEmpleadosSucursal = $oMysql->consultaSel("SELECT Empleados.id FROM Empleados 
			LEFT JOIN Oficinas ON Oficinas.id= Empleados.idOficina LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal 
			WHERE Sucursales.id = {$idSucursalReporteResumen} ORDER BY Empleados.id DESC");
		$sEmpleadosSucursal = implode(",",$aEmpleadosSucursal);		
	}
	if($idOficinaReporteResumen){
		$aEmpleadosOficina = $oMysql->consultaSel("SELECT Empleados.id FROM Empleados WHERE Empleados.idOficina = {$idOficinaReporteResumen} ORDER BY Empleados.id DESC");
		$sEmpleadosOficina = implode(",",$aEmpleadosOficina);	
		//echo $sEmpleadosOficina;		
	}
	if($sEmpleadosOficina != ""){
		$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosOficina})";
	}else{
		if($sEmpleadosSucursal != ""){
			$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosSucursal})";
		}else{
			if($sEmpleadosRegion != ""){
				$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosRegion})";
			}
		}
	}
	
	if(isset($_POST['buscar']) || $Pagina >1 || $_GET['orden']){
		$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
		$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";

		$sqlDatos="Call usp_getReporteResumenesCuentas(\"$sCondiciones\",\"$dFechaDesdeReporteResumen\",\"$dFechaHastaReporteResumen\");";
		$sqlDatos_sLim="Call usp_getReporteResumenesCuentas(\"$sCondiciones_sLim\",\"$dFechaDesdeReporteResumen\",\"$dFechaHastaReporteResumen\");";
		
		if($_SESSION['id_user']  == 296 ){
			 //var_export($sqlDatos);die;
		}
		$result = $oMysql->consultaSel($sqlDatos_sLim);
		//$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
		
		$aParametros['FECHA_DESDE_SINFORMAT'] = $dFechaDesdeReporteResumen;
		$aParametros['FECHA_HASTA_SINFORMAT'] = $dFechaHastaReporteResumen;		
		$aParametros['FECHA_DESDE'] = $dFechaDesdeReporteResumenFormat;
		$aParametros['FECHA_HASTA'] = $dFechaHastaReporteResumenFormat;
		$aParametros['IMPORTE'] = $fImporteReporteResumen;
		
		$CantRegFiltro = sizeof($result_sLim);		
		$CantRegFiltro = sizeof($result);		
		///var_export($result); die();
		#botonera	
		if($CantRegFiltro <>0){
			$buttons = new _buttons_('R');		
			$buttons->add_button('href',"javascript:exportarXLS();",'Exportar a Excel','excel');
			$buttons->set_width('800px;');
			$aParametros['buttons'] = $buttons->get_buttons();
		}
		
	}
	
	
	
	function mostrarFechasPeriodo($idGrupoAfinidad,$dPeriodo){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		if($idGrupoAfinidad == 4) $idGrupoAfinidad = 1;
		$aFechaCierre = $oMysql->consultaSel("SELECT dFechaCierre,DATE_FORMAT(dFechaCierre,'%d/%m/%Y') as 'dFechaCierreFormat' FROM CalendariosFacturaciones WHERE idGrupoAfinidad={$idGrupoAfinidad} AND dPeriodo='{$dPeriodo}'",true);
		$aFechaCierreAnterior = $oMysql->consultaSel("SELECT dFechaCierre,DATE_FORMAT(dFechaCierre,'%d/%m/%Y') as 'dFechaCierreFormat' FROM CalendariosFacturaciones WHERE idGrupoAfinidad={$idGrupoAfinidad} AND dPeriodo=DATE_ADD('{$dPeriodo}',interval -1 MONTH)",true);
		
		$oRespuesta->assign("lblFechaDesdeReporteResumen","innerHTML",$aFechaCierreAnterior['dFechaCierreFormat']);
		$oRespuesta->assign("lblFechaHastaReporteResumen","innerHTML",$aFechaCierre['dFechaCierreFormat']);		
		$oRespuesta->assign("dFechaDesdeReporteResumenFormat","value",$aFechaCierreAnterior['dFechaCierreFormat']);
		$oRespuesta->assign("dFechaHastaReporteResumenFormat","value",$aFechaCierre['dFechaCierreFormat']);		
		$oRespuesta->assign("dFechaDesdeReporteResumen","value",$aFechaCierreAnterior['dFechaCierre']);
		$oRespuesta->assign("dFechaHastaReporteResumen","value",$aFechaCierre['dFechaCierre']);
		return  $oRespuesta;
	}

	function arrayToOptionsPeriodosAnioActual($dPeriodo){
		$sOptions = "";	
		$select="";
		$anioActual = date("Y");
		$sOptions .= "<option value='0' selected='selected'>Seleccionar..</option>";
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
	}
	
	function cargarOptionsPeriodos($idGrupoAfinidad,$dPeriodo){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();		
		
		if($idGrupoAfinidad == 4) $idGrupoAfinidad = 1;
		$where = (is_null($idGrupoAfinidad)) ? "" : "CalendariosFacturaciones.idGrupoAfinidad = '$idGrupoAfinidad'" ;	
		
		$aDatos = $oMysql->consultaSel("CALL usp_getSelect(\"CalendariosFacturaciones\",\"dPeriodo\",\"DATE_FORMAT(dPeriodo, '%m/%Y')\",\"$where\");");
		
		if(count($aDatos)>0){		
			$options = arrayToOptionsPeriodos(($oMysql->consultaSel("CALL usp_getSelect(\"CalendariosFacturaciones\",\"dPeriodo\",\"DATE_FORMAT(dPeriodo, '%m/%Y')\",\"$where\");")),$dPeriodo);		
			$selects = "<select name='dPeriodoReporteResumen' id='dPeriodoReporteResumen' onchange='mostrarFechas(this.value)' style='width:150px;'><option value='0'>Selecccionar...</option>
					<option value='0'></option>".$options."</select>";		
				
		}else{
			$selects = '<select id="dPeriodoReporteResumen" style="width:150px;" name="dPeriodoResumen" disabled="">
				<option value="0">Seleccionar...</option>
				</select>';
		}
		$oRespuesta->assign('tdPeriodos','innerHTML',$selects);
		return  $oRespuesta;	
	}
	
	$oXajax=new xajax();
	$oXajax->register( XAJAX_FUNCTION ,"reporteResumenesCuentas");
	$oXajax->register( XAJAX_FUNCTION ,"mostrarFechasPeriodo");
	$oXajax->register( XAJAX_FUNCTION ,"cargarOptionsPeriodos");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");	
	
	$sCondicion = " sEstado='A'";
	$aParametros['optionsGrupos'] = $oMysql->getListaOpciones("GruposAfinidades","id","sNombre",$idGrupoAfinidadReporteResumen,$sCondicion);
	$selected = "";
	if($idGrupoAfinidadReporteResumen == 4) $selected .= "selected";	
	$aParametros['optionsGrupos'] .= "<option style='text-align:left;' title='TODOS' value='4' $selected>TODOS</option>";				
				
	//$aParametros['optionsPeriodos'] = arrayToOptionsPeriodosAnioActual($dPeriodoReporteResumen);
	/*$aParametros['optionsPeriodos'] = $oMysql->getListaOpcionesCondicionadoFormat("idGrupoAfinidadReporteResumen","dPeriodoReporteResumen","CalendariosFacturaciones","dPeriodo","DATE_FORMAT(dPeriodo, '%m/%Y')", 'idGrupoAfinidad','','',$dPeriodoReporteResumen,"DATE_FORMAT(dPeriodo, '%Y/%m')","ASC");*/
	$aParametros['options_regiones'] =	$oMysql->getListaOpciones( 'Regiones', 'id', 'sNombre', $idRegionReporteResumen);
	$aParametros['options_sucursales'] = $oMysql->getListaOpcionesCondicionado( 'idRegionReporteResumen', 'idSucursalReporteResumen', 'Sucursales', 'Sucursales.id', 'Sucursales.sNombre', 'idRegion','Sucursales.sEstado = \'A\'', '',$idSucursalReporteResumen);
	$aParametros['options_oficinas'] = $oMysql->getListaOpcionesCondicionado( 'idSucursalReporteResumen', 'idOficinaReporteResumen','Oficinas', 'Oficinas.id','Oficinas.sApodo','idSucursal','Oficinas.sEstado = \'A\'', '',$idOficinaReporteResumen);

	if(isset($_POST['buscar'])){			
		$aParametros['javascript_adicional'] = "xajax_cargarOptionsPeriodos(".$idGrupoAfinidadReporteResumen.",'".$dPeriodoReporteResumen."');";
	}
	
	$aParametros['IMAGES_DIR'] = IMAGES_DIR;
	
	if(isset($_POST['buscar']) || $Pagina >1 || $_GET['orden']){
		$sCadena = "";
		
		if (count($result)==0){
			$sCadena .= "
			<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='0' bordercolor='#000000' width='95%' id='tablaCuentasUsuarios'>
				<tr>
				<td align='center'>Ningun registro encontrado</td>
				</tr>
			</table>";
		}
		
		if ($result){	
		
		  $sCadena .= "
			<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='95%' id='tablaCuentasUsuarios'>
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
				$sCadena .= "<a href=\"{$_SERVER['PHP_SELF']}?CampoOrden={$arrListaCampos[$i]}&TipoOrden={$NuevoTipoOrden}&orden=1\">{$arrListaEncabezados[$i]}";
				if($CampoOrden == $arrListaCampos[$i]){
					if ($TipoOrden == 'ASC') 
						$sCadena .= "<img src='../includes/images/go-up.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendente' title='Ordenado por {$arrListaEncabezados[$i]} Ascendente'/></a>"; 
					else 
						$sCadena .= "<img src='../includes/images/go-down.png' alt='Ordenado por {$arrListaEncabezados[$i]} Descendente' title='Ordenado por {$arrListaEncabezados[$i]} Descendente'/></a>";
				}
				$sCadena .= "</th>\r\n";
			}
		  
			///Opciones de Mod. y Elim.
			$sCadena .="</tr>";
		    //echo $sCadena;
		
			$CantMostrados = $PrimReg;
			$fTotalConsumos = 0;
			$fTotalBonificaciones = 0;
			$fTotalIntFin = 0;
			$fTotalIntPun = 0;
			$fTotalGastosAdmin = 0;
			$fTotalSegVida = 0;
			$fTotalAjustesDeb = 0;
			$fTotalAjustesCred = 0;
			$fTotalIvaDeb = 0;
			$fTotalIvaCred = 0;
			$fTotalCobranzas = 0;
			$fTotalPagar = 0;
			
			foreach ($result as $rs ){
				$sBotonera = '';
					
				$CantMostrados++;
				$PK = $rs['id'];
				$sClase='';
		
				//if($rs['idTipoEstadoCuenta'] ==12){
				if($rs['sEstado'] == 'DADO DE BAJA'){
					$sClase="class='rojo'"; 
				}
				$sUsuario = "";
				if($rs['iTipoPersona'] == 2)					
					$sUsuario .= $rs['sRazonSocial'];				
				else
					$sUsuario .= $rs['sTitular'];		
					
				$param = base64_encode($rs['id']);				
				
				$dFechaCierreSiguiente = $oMysql->consultaSel("SELECT CalendariosFacturaciones.dFechaCierre FROM CalendariosFacturaciones WHERE idGrupoAfinidad={$idGrupoAfinidadResumen} AND dPeriodo=DATE_ADD('{$dPeriodoResumen}',interval 1 MONTH)",true);

				$fAcumuladoAjusteCreditoCobranzas = $oMysql->consultaSel("SELECT IFNULL(SUM(DetallesAjustesUsuarios.fImporteIVA),0)
					    FROM DetallesAjustesUsuarios
					    INNER JOIN AjustesUsuarios ON DetallesAjustesUsuarios.idAjusteUsuario=AjustesUsuarios.id
					    WHERE DetallesAjustesUsuarios.dFechaFacturacionUsuario = DATE_FORMAT('{$dFechaCierreSiguiente}','%Y-%m-%d 00:00:00')
					    AND AjustesUsuarios.idCuentaUsuario = {$rs['id']}
					    AND AjustesUsuarios.idTipoAjuste = 26
					    AND AjustesUsuarios.sEstado='A'",true);				
				$fAcumuladoCobranzas = $oMysql->consultaSel("SELECT IFNULL(SUM(Cobranzas.fImporte),0) 
						FROM Cobranzas 
						WHERE Cobranzas.idCuentaUsuario = {$rs['id']}
						AND Cobranzas.sEstado = 'A' 
						AND (Cobranzas.dFechaRegistro BETWEEN '{$rs['dFechaCierreSinFormat']}' AND '{$dFechaCierreSiguiente}')",true);
				$fAcumuladoCobranzas = $fAcumuladoCobranzas + $fAcumuladoAjusteCreditoCobranzas;
				  
				$fAjusteBonif = 0;
				$fAjusteCargo = 0;
				$fAjusteSeguro = 0;
				$fAjusteDeb = 0;
				$fAjusteCred = 0;
				$fTotal = 0;
				$fCobranzas = 0;
				  
				$dPeriodoFormat = $rs['dPeriodoFormat'];
		  	    $idGrupoAfinidad = $rs['idGrupoAfinidad'];
			    $idCuentaUsuario = $rs['id'];
			    $archivo = "../includes/Files/Datos/".$dPeriodoFormat."/DR_".$idGrupoAfinidad."_".$idCuentaUsuario."_".$dPeriodoFormat.".xml";		
			    $fInteresFinanciacion = 0;		
				$fInteresPunitorio = 0;
				$fAcumuladoIVAAjusteDebito = 0;
			     
		    	$existeXml = true;
			    if (!file_exists($archivo)){
					$archivo = "../includes/Files/Datos/".$dPeriodoFormat."/DR_2_".$idCuentaUsuario."_".$dPeriodoFormat.".xml";					
					if(!file_exists($archivo)){
						$existeXml = false;
					}
				}
				
				if($existeXml){
					  $oXml= simplexml_load_file($archivo);
					
					  $fSaldoAnterior = (float)$oXml->fSaldoAnterior;
					  $fImporteTotalPesos = (float)$oXml->fTotalResumen;
					  $fAcumuladoConsumoUnPago = 0;
					  	  
					  foreach ($oXml->detalle as $row){
					  	
						  	if($row->tipoOperacion == 2 || $row->tipoOperacion == 3){
						  		$idTipoAjuste = $oMysql->consultaSel("SELECT AjustesUsuarios.idTipoAjuste FROM AjustesUsuarios INNER JOIN DetallesAjustesUsuarios ON AjustesUsuarios.id=DetallesAjustesUsuarios.idAjusteUsuario WHERE DetallesAjustesUsuarios.id={$row->idDetalle}",true);
						  	}
						  	
						  	if($row->tipoOperacion == 1){
						  		$fAcumuladoConsumoUnPago += (float)$row->fImporte;
						  	}
						  	
					  		if($row->tipoOperacion == 2){
						  		if($idTipoAjuste == 28)
						  			$fAjusteBonif += (float)$row->fImporte;
						  		else
						  			$fAjusteCred += (float)$row->fImporte;	
						  	}
						  	
						  	if($row->tipoOperacion == 3){
						  		if($idTipoAjuste != 27 && $idTipoAjuste != 31 && $idTipoAjuste != 29 && $idTipoAjuste != 30)
						  			$fAjusteDeb += (float)$row->fImporte;
					
						  		if($idTipoAjuste == 27)	
						  			$fAjusteCargo += (float)$row->fImporte;
						  			
						  		if($idTipoAjuste == 31)		
						  			$fAjusteSeguro += (float)$row->fImporte;	
						  	}
						  	
						  	if($row->tipoOperacion == 4){
						  		$fCobranzas += (float)$row->fImporte;
						  	}	
						  	if($row->sDescripcion == 'INTERES DE FINANCIACION'){
						  		$fInteresFinanciacion += (float)$row->fImporte; 	
						  	}
						  	if($row->sDescripcion == 'INTERES PUNITORIO'){
						  		$fInteresPunitorio += (float)$row->fImporte; 	
						  	}						  	  	
						  	
						  	if($row->tipoOperacion == 5){
						  		$fAcumuladoIVAAjusteDebito += (float)$row->fImporte;
						  	}	  	
					  }
				  }else{
				  	  $aDatos = $oMysql->consultaSel("CALL usp_getDatosResumenContable(\"{$rs['id']}\",\"{$rs['dFechaCierreSinFormat']}\",\"{$rs['dPeriodo']}\",\"{$rs['idGrupoAfinidad']}\")",true);
				 	  $fAcumuladoCobranzas = $aDatos['fAcumuladoCobranzas'];
				  	  $fAjusteBonif = $aDatos['fAjusteBonif'];
					  $fAjusteCargo = $aDatos['fAjusteCargo'];
					  $fAjusteSeguro = $aDatos['fAjusteSeguro'];
					  $fAjusteDeb = $aDatos['fAjusteDeb'];
					  $fAjusteCred = $aDatos['fAjusteCred'];
					  $fSaldoAnterior = $rs['fSaldoAnterior'];
					  if($rs['sEstado'] != 'DADO DE BAJA'){//si la cuenta no esta de baja
					  	 //$fAcumuladoConsumoUnPago = $rs['fAcumuladoConsumoUnPago'];
					  	 $fAcumuladoConsumoUnPago = $aDatos['fTotalCupones'];					  	 
				   	  }else{ 
					  	 $fAcumuladoConsumoUnPago = 0;
				   	  }
					  $fCobranzas = $aDatos['fCobranza'];
					  $fInteresFinanciacion = $rs['fInteresFinanciacion'];
			  		  $fInteresPunitorio = $rs['fInteresPunitorio'];	
					  if($rs['iEmiteResumen'] == 1){
					  	$fImporteTotalPesos = $rs['fImporteTotalPesos'];
					  }else{
					  	$fImporteTotalPesos =  $oMysql->consultaSel("SELECT fcn_getSaldoActual(\"{$rs['id']}\",\"{$rs['dPeriodo']}\")",true); 
					  	$fInteresFinanciacion = 0;
			  			$fInteresPunitorio = 0;
					  }
					  $fAcumuladoIVAAjusteDebito = $rs['fAcumuladoIVAAjusteDebito'];
				  }
				
				if($fAjusteBonif != 0)$fAjusteBonif = "-".$fAjusteBonif;
			    if($fAjusteCred != 0)$fAjusteCred = "-".$fAjusteCred;
				if($fCobranzas != 0)$fCobranzas = "-".$fCobranzas;	 
				if($rs['fAcumuladoIVAAjusteCredito'] != 0) $rs['fAcumuladoIVAAjusteCredito']  = "-".$rs['fAcumuladoIVAAjusteCredito']; 
				
				$sCadena .="
				<tr id='empleado{$PK}'>
					<!-- Valores -->
					<td width='5%' align='left' {$sClase}>&nbsp;{$CantMostrados}</td>
					<td width='10%' align='left' {$sClase}>&nbsp;{$rs['sNumeroCuenta']}</td>
					<td width='25%' align='left' {$sClase}>&nbsp;{$sUsuario}</td>
					<td width='10%' align='left' {$sClase}>&nbsp;{$rs['sEstado']}</td>	
					<td width='10%' align='left' {$sClase}>&nbsp;{$rs['dFechaCierre']}</td>	
					<td width='10%' align='left' {$sClase}>&nbsp;{$rs['dFechaVencimiento']}</td>	
					<td width='10%' align='left' {$sClase}>&nbsp;".number_format((double)$rs['fSaldoAnterior'],2,'.','')."</td>	
					<td width='10%' align='left' {$sClase}>&nbsp;".number_format((double)$fAcumuladoConsumoUnPago,2,'.','')."</td>	
					<td width='10%' align='left' {$sClase}>&nbsp;".number_format((double)$fAjusteBonif,2,'.','')."</td>						
					<td width='10%' align='left' {$sClase}>&nbsp;".number_format((double)$fInteresFinanciacion,2,'.','')."</td>	
					<td width='10%' align='left' {$sClase}>&nbsp;".number_format((double)$fInteresPunitorio,2,'.','')."</td>	
					<td width='10%' align='left' {$sClase}>&nbsp;".number_format((double)$fAjusteCargo,2,'.','')."</td>		
					<td width='10%' align='left' {$sClase}>&nbsp;".number_format((double)$fAjusteSeguro,2,'.','')."</td>											
					<td width='10%' align='left' {$sClase}>&nbsp;".number_format((double)$fAjusteDeb,2,'.','')."</td>
					<td width='10%' align='left' {$sClase}>&nbsp;".number_format((double)$fAcumuladoIVAAjusteDebito,2,'.','')."</td>	
					<td width='10%' align='left' {$sClase}>&nbsp;".number_format((double)$fAjusteCred,2,'.','')."</td>
					<td width='10%' align='left' {$sClase}>&nbsp;".number_format((double)$rs['fAcumuladoIVAAjusteCredito'],2,'.','')."</td>	
					
					<td width='10%' align='left' {$sClase}>&nbsp;".number_format((double)$fCobranzas,2,'.','')."</td>
					<td width='10%' align='left' {$sClase}>&nbsp;".number_format((double)$fImporteTotalPesos,2,'.','')."</td>												
					<!-- Links para Mod. y Elim. -->
				</tr>";
				
				$fTotalConsumos +=$fAcumuladoConsumoUnPago;
				$fTotalBonificaciones +=$fAjusteBonif;
				$fTotalIntFin +=$fInteresFinanciacion;
				$fTotalIntPun +=$fInteresPunitorio;
				$fTotalGastosAdmin +=$fAjusteCargo;
				$fTotalSegVida +=$fAjusteSeguro;
				$fTotalAjustesDeb +=$fAjusteDeb;
				$fTotalAjustesCred +=$fAjusteCred;
				$fTotalIvaDeb +=$fAcumuladoIVAAjusteDebito;
				$fTotalIvaCred +=$rs['fAcumuladoIVAAjusteCredito'];;
				$fTotalCobranzas +=$fCobranzas;
				$fTotalPagar +=$fImporteTotalPesos;				
			}
			$sCadena .= "<tr>
				<td colspan='7' align='right'>&nbsp;TOTALES:</td>
				<td>".number_format((double)$fTotalConsumos,2,'.','')."</td>
				<td>".number_format((double)$fTotalBonificaciones,2,'.','')."</td>				
				<td>".number_format((double)$fTotalIntFin,2,'.','')."</td>
				<td>".number_format((double)$fTotalIntPun,2,'.','')."</td>				
				<td>".number_format((double)$fTotalGastosAdmin,2,'.','')."</td>
				<td>".number_format((double)$fTotalSegVida,2,'.','')."</td>				
				<td>".number_format((double)$fTotalAjustesDeb,2,'.','')."</td>
				<td>".number_format((double)$fTotalIvaDeb,2,'.','')."</td>				
				<td>".number_format((double)$fTotalAjustesCred,2,'.','')."</td>
				<td>".number_format((double)$fTotalIvaCred,2,'.','')."</td>				
				<td>".number_format((double)$fTotalCobranzas,2,'.','')."</td>
				<td>".number_format((double)$fTotalPagar,2,'.','')."</td>
			</tr>
			</table>";
			//echo $tableHTML;
		}
		/*if (ceil($CantRegFiltro/$RegPorPag) > 1){
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
		}*/
		
		
	}
	$aParametros['tableDatos'] = $sCadena;

	$tableHTML = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Reportes/ReportesResumenesCuentas.tpl",$aParametros);		
		
	xhtmlHeaderPaginaGeneral($aParametros);
	
	echo xhtmlMainHeaderPagina($aParametros);
	
	echo "<center>".$tableHTML;

	
		
		
	echo xhtmlFootPagina();
?>