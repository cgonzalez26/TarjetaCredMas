<?php
	ini_set("memory_limit","1024M");
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
	
	include_once( CLASSES_DIR . '/_table.class.php' );	
	include_once( CLASSES_DIR . '/_buttons.class.php' );
	
	//session_start();
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
		
	$mysql_accesos = new MySql();			
	//$mysql_accesos->setServer('localhost','dbgrupo','0tr3b0r');
	$mysql_accesos->setDBName('AccesosSistemas');				
	

	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
		
	if ($Pagina <= 0) $Pagina = 1;

	$NombreMod = 'DetallesCuentasUsuarios'; // Nombre del modulo
	$NombreTipoRegistro = 'DetalleCuentaUsuario';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Cuentas de Usuarios'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('','CuentasUsuarios.sNumeroCuenta', 'sTitular','sEstado','dFechaCierre','dFechaVencimiento','fSaldoAnterior','fAcumuladoConsumoUnPago','','fInteresFinanciacion','fInteresPunitorio','','','','','','','fAcumuladoIVAAjusteDebito','fAcumuladoIVAAjusteCredito','sCobranzas','fImporteTotalPesos');
	$arrListaEncabezados = array('Nro.Reg.','Nro. Cuenta','Titular','Estado','Fch Cierre','Fch Vto','Saldo Ant.','Consumos','Bonificacion','Int.Fin.','Int.Pun.','Gastos Admin.','Seg.Vida','Ajustes Deb','Ajustes Deb IVA','Ajustes Cred','Ajustes Cred IVA','Total Iva Deb','Total Iva Cred','Cobranzas','Total a Pagar');
	$Tabla = 'DetallesCuentasUsuarios'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'InformesPersonales.sApellido'; // Campo de orden predeterminado
	//$CampoOrdenPre = 'CuentasUsuarios.sNumeroCuenta'; // Campo de orden predeterminado
	$TipoOrdenPre = 'ASC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
	$dPeriodoResumen = 0;
	$idGrupoAfinidadResumen = 0;
	$idRegionResumen = 0;		
	$fImporteResumen = 0;
	if(isset($_POST['buscar']))
	{	
		if($_POST['fImporteResumen'] == "") $_POST['fImporteResumen'] = 0;
		$idRegionResumen = $_POST['idRegionResumen'];
		$idSucursalResumen = $_POST['idSucursalResumen'];
		$idOficinaResumen = $_POST['idOficinaResumen'];
		$dPeriodoResumen = $_POST['dPeriodoResumen'];
		$idGrupoAfinidadResumen = $_POST['idGrupoAfinidadResumen'];
		$dFechaDesdeResumen = $_POST['dFechaDesdeResumen'];
		$dFechaHastaResumen = $_POST['dFechaHastaResumen'];
		$dFechaDesdeResumenFormat = $_POST['dFechaDesdeResumenFormat'];
		$dFechaHastaResumenFormat = $_POST['dFechaHastaResumenFormat'];
		$fImporteResumen = $_POST['fImporteResumen'];
		
		if(!session_is_registered('dPeriodoResumen'))
		{
			session_register('idRegionResumen');
			session_register('idSucursalResumen');
			session_register('idOficinaResumen');
			session_register('dPeriodoResumen');
			session_register('idGrupoAfinidadResumen');
			session_register('dFechaDesdeResumen');
			session_register('dFechaHastaResumen');
			session_register('dFechaDesdeResumenFormat');
			session_register('dFechaHastaResumenFormat');
			session_register('fImporteResumen');
		}
		$_SESSION['idRegionResumen'] = $_POST['idRegionResumen'];
		$_SESSION['idSucursalResumen'] = $_POST['idSucursalResumen'];
		$_SESSION['idOficinaResumen'] = $_POST['idOficinaResumen'];
		$_SESSION['dPeriodoResumen'] = $_POST['dPeriodoResumen'];		
		$_SESSION['idGrupoAfinidadResumen'] = $_POST['idGrupoAfinidadResumen'];
		$_SESSION['dFechaDesdeResumen'] = $_POST['dFechaDesdeResumen'];
		$_SESSION['dFechaHastaResumen'] = $_POST['dFechaHastaResumen'];
		$_SESSION['dFechaDesdeResumenFormat'] = $_POST['dFechaDesdeResumenFormat'];
		$_SESSION['dFechaHastaResumenFormat'] = $_POST['dFechaHastaResumenFormat'];
		$_SESSION['fImporteResumen'] = $_POST['fImporteResumen'];
		unset($_SESSION['volver']);
	}
	else
	{
		if(!isset($_GET['inicio'])){
			$idRegionResumen = $_SESSION['idRegionResumen'];
			$idSucursalResumen = $_SESSION['idSucursalResumen'];
			$idOficinaResumen = $_SESSION['idOficinaResumen'];
			$dPeriodoResumen = $_SESSION['dPeriodoResumen'];
			$idGrupoAfinidadResumen = $_SESSION['idGrupoAfinidadResumen'];
			$dFechaDesdeResumen = $_SESSION['dFechaDesdeResumen'];
			$dFechaHastaResumen = $_SESSION['dFechaHastaResumen'];
			$dFechaDesdeResumenFormat = $_SESSION['dFechaDesdeResumenFormat'];
			$dFechaHastaResumenFormat = $_SESSION['dFechaHastaResumenFormat'];			
			$fImporteResumen = $_SESSION['fImporteResumen'];
		}
	}
	if($idGrupoAfinidadResumen != 4)
		if($idGrupoAfinidadResumen)$aCond[]="  CuentasUsuarios.idGrupoAfinidad ='{$idGrupoAfinidadResumen}' ";
	if($dPeriodoResumen)$aCond[]="  DetallesCuentasUsuarios.dPeriodo ='{$dPeriodoResumen}' ";
	if($fImporteResumen)$aCond[]="  DetallesCuentasUsuarios.fImporteTotalPesos >= '{$fImporteResumen}' ";
	//else $aCond[]="  DetallesCuentasUsuarios.fImporteTotalPesos > 0";
	
	$sEmpleadosRegion = "";
	$sEmpleadosSucursal = "";
	$sEmpleadosOficina = "";
	if($idRegionResumen){
		$aEmpleadosRegion = $mysql_accesos->selectRows("SELECT Empleados.id FROM Empleados 
			LEFT JOIN Oficinas ON Empleados.idOficina=Oficinas.id LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal LEFT JOIN Regiones ON Sucursales.idRegion=Regiones.id
			WHERE Regiones.id = {$idRegionResumen}");
		$sEmpleadosRegion .= implode(",",$aEmpleadosRegion);		
		
		$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosRegion})";
	}
	if($idSucursalResumen){
		$aEmpleadosSucursal = $mysql_accesos->selectRows("SELECT Empleados.id FROM Empleados 
			LEFT JOIN Oficinas ON Empleados.idOficina=Oficinas.id LEFT JOIN Sucursales ON Oficinas.idSucursal=Sucursales.id
			WHERE Sucursales.id = {$idSucursalResumen}");
		//echo $idSucursalCuenta;
		$sEmpleadosSucursal = implode(",",$aEmpleadosSucursal);		
		//echo $sEmpleadosSucursal;
	}
	if($idOficinaResumen){
		$aEmpleadosOficina = $mysql_accesos->selectRows("SELECT Empleados.id FROM Empleados WHERE Empleados.idOficina = {$idOficinaResumen}");
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
	
	/*if($_SESSION['id_user']  == 296 ){
			 echo "entro";
			// die;
		}*/
	if(isset($_POST['buscar']) || $Pagina >1 || $_GET['orden']){
		//$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
		$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";

		//$sqlDatos="Call usp_getReporteResumenesCuentas(\"$sCondiciones\",\"$dFechaDesdeResumen\",\"$dFechaHastaResumen\");";
		$sqlDatos_sLim="Call usp_getReporteResumenesCuentas(\"$sCondiciones_sLim\",\"$dFechaDesdeResumen\",\"$dFechaHastaResumen\");";
		//echo $sqlDatos_sLim;
		
		/*if($_SESSION['id_user']  == 296 ){
			 echo $sqlDatos_sLim;
			// die;
		}*/
		$result = $oMysql->consultaSel($sqlDatos_sLim);
		//$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
		
		$aParametros['FECHA_DESDE_SINFORMAT'] = $dFechaDesdeResumen;
		$aParametros['FECHA_HASTA_SINFORMAT'] = $dFechaHastaResumen;		
		$aParametros['FECHA_DESDE'] = $dFechaDesdeResumenFormat;
		$aParametros['FECHA_HASTA'] = $dFechaHastaResumenFormat;
		$aParametros['IMPORTE'] = $fImporteResumen;
		
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
		if($idGrupoAfinidad == 4) $idGrupoAfinidad = 3;
		$aFechaCierre = $oMysql->consultaSel("SELECT dFechaCierre,DATE_FORMAT(dFechaCierre,'%d/%m/%Y') as 'dFechaCierreFormat' FROM CalendariosFacturaciones WHERE idGrupoAfinidad={$idGrupoAfinidad} AND dPeriodo='{$dPeriodo}'",true);
		$aFechaCierreAnterior = $oMysql->consultaSel("SELECT dFechaCierre,DATE_FORMAT(dFechaCierre,'%d/%m/%Y') as 'dFechaCierreFormat' FROM CalendariosFacturaciones WHERE idGrupoAfinidad={$idGrupoAfinidad} AND dPeriodo=DATE_ADD('{$dPeriodo}',interval -1 MONTH)",true);
		
		$oRespuesta->assign("lblFechaDesdeResumen","innerHTML",$aFechaCierreAnterior['dFechaCierreFormat']);
		$oRespuesta->assign("lblFechaHastaResumen","innerHTML",$aFechaCierre['dFechaCierreFormat']);		
		$oRespuesta->assign("dFechaDesdeResumenFormat","value",$aFechaCierreAnterior['dFechaCierreFormat']);
		$oRespuesta->assign("dFechaHastaResumenFormat","value",$aFechaCierre['dFechaCierreFormat']);		
		$oRespuesta->assign("dFechaDesdeResumen","value",$aFechaCierreAnterior['dFechaCierre']);
		$oRespuesta->assign("dFechaHastaResumen","value",$aFechaCierre['dFechaCierre']);
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
		
		if($idGrupoAfinidad == 4) $idGrupoAfinidad = 3;
		$where = (is_null($idGrupoAfinidad)) ? "" : "CalendariosFacturaciones.idGrupoAfinidad = '$idGrupoAfinidad'" ;	
		
		$aDatos = $oMysql->consultaSel("CALL usp_getSelect(\"CalendariosFacturaciones\",\"dPeriodo\",\"DATE_FORMAT(dPeriodo, '%m/%Y')\",\"$where\");");
		
		if(count($aDatos)>0){		
			$options = arrayToOptionsPeriodos(($oMysql->consultaSel("CALL usp_getSelect(\"CalendariosFacturaciones\",\"dPeriodo\",\"DATE_FORMAT(dPeriodo, '%m/%Y')\",\"$where\");")),$dPeriodo);		
			$selects = "<select name='dPeriodoResumen' id='dPeriodoResumen' onchange='mostrarFechas(this.value)' style='width:150px;'><option value='0'>Selecccionar...</option>
					<option value='0'></option>".$options."</select>";		
				
		}else{
			$selects = '<select id="dPeriodoResumen" style="width:150px;" name="dPeriodoResumen" disabled="">
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
	$aParametros['optionsGrupos'] = $oMysql->getListaOpciones("GruposAfinidades","id","sNombre",$idGrupoAfinidadResumen,$sCondicion);
	$selected = "";
	if($idGrupoAfinidadResumen == 4) $selected .= "selected";	
	$aParametros['optionsGrupos'] .= "<option style='text-align:left;' title='TODOS' value='4' $selected>TODOS</option>";	

	//$aParametros['optionsPeriodos'] = arrayToOptionsPeriodosAnioActual($dPeriodoReporteResumen);
	/*$aParametros['optionsPeriodos'] = $oMysql->getListaOpcionesCondicionadoFormat("idGrupoAfinidadResumen","dPeriodoResumen","CalendariosFacturaciones","dPeriodo","DATE_FORMAT(dPeriodo, '%m/%Y')", 'idGrupoAfinidad','','',$dPeriodoResumen,"DATE_FORMAT(dPeriodo, '%Y/%m')","ASC");*/
	$aParametros['options_regiones'] =	$mysql_accesos->getListaOpciones( 'Regiones', 'id', 'sNombre', $idRegionResumen);
	$aParametros['options_sucursales'] = $mysql_accesos->getListaOpcionesCondicionado( 'idRegionResumen', 'idSucursalResumen', 'Sucursales', 'Sucursales.id', 'Sucursales.sNombre', 'idRegion','Sucursales.sEstado = \'A\'', '',$idSucursalResumen);
	$aParametros['options_oficinas'] = $mysql_accesos->getListaOpcionesCondicionado( 'idSucursalResumen', 'idOficinaResumen','Oficinas', 'Oficinas.id','Oficinas.sApodo','idSucursal','Oficinas.sEstado = \'A\'', '',$idOficinaResumen);

	if(isset($_POST['buscar'])){			
		$aParametros['SCRIPT'] = "xajax_cargarOptionsPeriodos(".$idGrupoAfinidadResumen.",'".$dPeriodoResumen."');";
	}
	
	$mysql_accesos->disconnect();
	
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
			$fTotalAcumuladoCobranzas = 0;
			$fTotalAjustesDebIVA = 0;
			$fTotalAjustesCredIVA = 0;
			
			foreach ($result as $rs ){
				
			   //if($rs['sEstado'] != 'DADO DE BAJA'){
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
				
				
				/*$dFechaCierreSiguiente = $oMysql->consultaSel("SELECT CalendariosFacturaciones.dFechaCierre FROM CalendariosFacturaciones WHERE idGrupoAfinidad={$idGrupoAfinidadResumen} AND dPeriodo=DATE_ADD('{$dPeriodoResumen}',interval 1 MONTH)",true);

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
				$fAcumuladoCobranzas = $fAcumuladoCobranzas + $fAcumuladoAjusteCreditoCobranzas;*/
				  
				$fAjusteBonif = 0;
				$fAjusteCargo = 0;
				$fAjusteSeguro = 0;
				$fAjusteDeb = 0;
				$fAjusteDebIVA = 0;
				$fAjusteCred = 0;
				$fAjusteCredIVA = 0;
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
					  	  
					  $aFechaCierre = explode("/", (string)$oXml->dFechaCierre);
					  $dFechaCierre = strtotime($aFechaCierre[0]."-".$aFechaCierre[1]."-".$aFechaCierre[2]." 00:00:00");
					  
					  foreach ($oXml->detalle as $row){
					  		$aFecha = explode("/", (string)$row->dFechaOperacion);
							$dFechaRegistro = strtotime($aFecha[0]."-".$aFecha[1]."-".$aFecha[2]." 00:00:00");
					
							//if(((string)$row->dFechaOperacion == "") || ($dFechaRegistro < $dFechaCierre)){
											
						  	if($row->tipoOperacion == 2 || $row->tipoOperacion == 3){
						  		$aTipoAjuste = $oMysql->consultaSel("SELECT AjustesUsuarios.idTipoAjuste,TiposAjustes.bDiscriminaIVA 
						  			FROM AjustesUsuarios 
						  			INNER JOIN DetallesAjustesUsuarios ON AjustesUsuarios.id = DetallesAjustesUsuarios.idAjusteUsuario 
						  			INNER JOIN TiposAjustes ON AjustesUsuarios.idTipoAjuste = TiposAjustes.id
						  			WHERE DetallesAjustesUsuarios.id = {$row->idDetalle}",true);
						  	}
						  	
						  	if($row->tipoOperacion == 1){
						  		$fAcumuladoConsumoUnPago += (float)$row->fImporte;
						  	}
						  	
					  		if($row->tipoOperacion == 2){
						  		if($aTipoAjuste['idTipoAjuste'] == 28){
						  			$fAjusteBonif += (float)$row->fImporte;
						  		}else{
						  			if($aTipoAjuste['bDiscriminaIVA'] == 0)						  		
							  			$fAjusteCred += (float)$row->fImporte;	
							  		else 
							  			$fAjusteCredIVA += (float)$row->fImporte;	
						  		}
						  	}
						  	
						  	if($row->tipoOperacion == 3){
						  		//if($idTipoAjuste != 27 && $idTipoAjuste != 31 && $idTipoAjuste != 29 && $idTipoAjuste != 30)
						  		if($aTipoAjuste['idTipoAjuste'] != 27 && $aTipoAjuste['idTipoAjuste'] != 29 && $aTipoAjuste['idTipoAjuste'] != 30 && $aTipoAjuste['idTipoAjuste'] != 31){
						  			if($aTipoAjuste['bDiscriminaIVA'] == 0)
						  				$fAjusteDeb += (float)$row->fImporte;
						  			else	
						  		 		$fAjusteDebIVA += (float)$row->fImporte;
						  		}
														
						  		if($aTipoAjuste['idTipoAjuste'] == 27)	
						  			$fAjusteCargo += (float)$row->fImporte;
						  			
						  		if($aTipoAjuste['idTipoAjuste'] == 31)		
						  			$fAjusteSeguro += (float)$row->fImporte;	
						  	}
						  	
						  	if($row->tipoOperacion == 4 && $dFechaRegistro < $dFechaCierre){
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
							//}
					  }
				  }else{
				  	  $aDatos = $oMysql->consultaSel("CALL usp_getDatosResumenContable(\"{$rs['id']}\",\"{$rs['dFechaCierreSinFormat']}\",\"{$rs['dPeriodo']}\",\"{$rs['idGrupoAfinidad']}\")",true);
				 	  //$fAcumuladoCobranzas = $aDatos['fAcumuladoCobranzas'];
				  	  $fAjusteBonif = $aDatos['fAjusteBonif'];
					  $fAjusteCargo = $aDatos['fAjusteCargo'];
					  $fAjusteSeguro = $aDatos['fAjusteSeguro'];
					  $fAjusteDeb = $aDatos['fAjusteDeb'];
					  $fAjusteDebIVA = $aDatos['fAjusteDebIVA'];
					  $fAjusteCred = $aDatos['fAjusteCred'];
					  $fAjusteCredIVA = $aDatos['fAjusteCredIVA'];
					  $fSaldoAnterior = $rs['fSaldoAnterior'];
				   	  if($rs['sEstado'] != 'DADO DE BAJA'){//si la cuenta no esta de baja
					  	 //$fAcumuladoConsumoUnPago = $rs['fAcumuladoConsumoUnPago'];
					  	 $fAcumuladoConsumoUnPago = $aDatos['fTotalCupones'];
				   	  }else{ 
					  	 $fAcumuladoConsumoUnPago = 0;
				   	  }
					  //$fAcumuladoConsumoUnPago = $rs['fAcumuladoConsumoUnPago'];
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
				  if($fAjusteCredIVA != 0)$fAjusteCredIVA = "-".$fAjusteCredIVA;
				  if($fCobranzas != 0)$fCobranzas = "-".$fCobranzas;	 
				  if($rs['fAcumuladoIVAAjusteCredito'] != 0){ 
				  		$rs['fAcumuladoIVAAjusteCredito']  = "-".$rs['fAcumuladoIVAAjusteCredito']; 
				  		$fImporteTotalPesos = $fImporteTotalPesos + $rs['fAcumuladoIVAAjusteCredito'];
				  }
				  $sCadena .="
					<tr id='empleado{$PK}'>
						<!-- Valores -->
						<td width='5%' align='left' {$sClase}>&nbsp;{$CantMostrados}</td>
						<td width='10%' align='left' {$sClase}>&nbsp;{$rs['sNumeroCuenta']}</td>
						<td width='25%' align='left' {$sClase}>&nbsp;{$sUsuario}</td>
						<td width='10%' align='left' {$sClase}>&nbsp;{$rs['sEstado']}</td>	
						<td width='10%' align='left' {$sClase}>&nbsp;{$rs['dFechaCierre']}</td>	
						<td width='10%' align='left' {$sClase}>&nbsp;{$rs['dFechaVencimiento']}</td>	
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($fSaldoAnterior,2,'.','')."</td>	
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($fAcumuladoConsumoUnPago,2,'.','')."</td>	
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($fAjusteBonif,2,'.','')."</td>						
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($fInteresFinanciacion,2,'.','')."</td>	
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($fInteresPunitorio,2,'.','')."</td>	
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($fAjusteCargo,2,'.','')."</td>		
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($fAjusteSeguro,2,'.','')."</td>											
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($fAjusteDeb,2,'.','')."</td>
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($fAjusteDebIVA,2,'.','')."</td>
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($fAjusteCred,2,'.','')."</td>
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($fAjusteCredIVA,2,'.','')."</td>
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($fAcumuladoIVAAjusteDebito,2,'.','')."</td>	
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($rs['fAcumuladoIVAAjusteCredito'],2,'.','')."</td>	
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($fCobranzas,2,'.','')."</td>
						<td width='10%' align='left' {$sClase}>&nbsp;".number_format($fImporteTotalPesos,2,'.','')."</td>																		
						<!-- Links para Mod. y Elim. -->
					</tr>";
					$fTotalConsumos +=$fAcumuladoConsumoUnPago;
					$fTotalBonificaciones +=$fAjusteBonif;
					$fTotalIntFin +=$fInteresFinanciacion;
					$fTotalIntPun +=$fInteresPunitorio;
					$fTotalGastosAdmin +=$fAjusteCargo;
					$fTotalSegVida +=$fAjusteSeguro;
					$fTotalAjustesDeb +=$fAjusteDeb;
					$fTotalAjustesDebIVA +=$fAjusteDebIVA;
					$fTotalAjustesCred +=$fAjusteCred;
					$fTotalAjustesCredIVA +=$fAjusteCredIVA;
					$fTotalIvaDeb +=$fAcumuladoIVAAjusteDebito;
					$fTotalIvaCred +=$rs['fAcumuladoIVAAjusteCredito'];
					$fTotalCobranzas +=$fCobranzas;		
					$fTotalPagar +=$fImporteTotalPesos;
				
				}
				$sCadena .= "<tr>
					<td colspan='7' align='right'>&nbsp;TOTALES:</td>
					<td>".number_format($fTotalConsumos,2,'.','')."</td>
					<td>".number_format($fTotalBonificaciones,2,'.','')."</td>
					<td>".number_format($fTotalIntFin,2,'.','')."</td>
					<td>".number_format($fTotalIntPun,2,'.','')."</td>
					<td>".number_format($fTotalGastosAdmin,2,'.','')."</td>
					<td>".number_format($fTotalSegVida,2,'.','')."</td>
					<td>".number_format($fTotalAjustesDeb,2,'.','')."</td>
					<td>".number_format($fTotalAjustesDebIVA,2,'.','')."</td>
					<td>".number_format($fTotalAjustesCred,2,'.','')."</td>
					<td>".number_format($fTotalAjustesCredIVA,2,'.','')."</td>
					<td>".number_format($fTotalIvaDeb,2,'.','')."</td>
					<td>".number_format($fTotalIvaCred,2,'.','')."</td>
					<td>".number_format($fTotalCobranzas,2,'.','')."</td>
					<td>".number_format($fTotalPagar,2,'.','')."</td>
				</tr>
				</table>";
			}
			
			//echo $tableHTML;
		//}
		
	}
	$aParametros['tableDatos'] = $sCadena;

	$tableHTML = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Reportes/ReportesResumenesConCobranzas.tpl",$aParametros);		
		
	xhtmlHeaderPaginaGeneral($aParametros);
	
	echo xhtmlMainHeaderPagina($aParametros);
	
	echo "<center>".$tableHTML;

	
		
		
	echo xhtmlFootPagina();
?>