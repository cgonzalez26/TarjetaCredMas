<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();

	#Control de Acceso al archivo
	//if(!isLogin())
	//{
		//go_url("/index.php");
	//}
	$idObjeto = 28;
	$arrayPermit = explode(',',$_SESSION['_PERMISOS_'][$idObjeto]['sPermisos']);
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	
	
	$sTabla = "";
	$fSaldoAnterior = 0;
	if($_GET['id']){	
		global $oMysql;
		$dPeriodo = "";
		$dPeriodo = "2011-09-00 00:00:00";
		$dPeriodoActual = date("2011-09-01 00:00:00");
		if($_GET['idPeriodo']){
			//$dPeriodo = $_GET['idPeriodo'];
			$idPeriodo = $_GET['idPeriodo'];
			$sql = "SELECT CalendariosFacturaciones.dPeriodo FROM CalendariosFacturaciones 
				WHERE CalendariosFacturaciones.id = '{$_GET['idPeriodo']}'";
			$dPeriodo = $oMysql->consultaSel($sql,true);
			//echo $idPeriodo;
		}else{	
			$sql = "SELECT DetallesCuentasUsuarios.dPeriodo FROM DetallesCuentasUsuarios 
				WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$_GET['id']} ORDER BY dFechaRegistro DESC LIMIT 0,1";			
			$dPeriodoActual = $oMysql->consultaSel($sql,true);			
			//echo $sql;
			$sql = "SELECT CalendariosFacturaciones.id FROM CalendariosFacturaciones 
				WHERE CalendariosFacturaciones.dPeriodo = '{$dPeriodoActual}'";
			$idPeriodo = $oMysql->consultaSel($sql,true);			
			$dPeriodo = $dPeriodoActual;
			//echo $idPeriodo."----".$dPeriodoActual;
		}	
		$sCondicion = " WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$_GET['id']} AND dPeriodo ='{$dPeriodo}'";
		$sql="Call usp_getDetallesCuentasUsuarios(\"$sCondicion\");";		
		//echo $sql;
		$rsDetalle= $oMysql->consultaSel($sql,true);
		
		if($rsDetalle){
			$dFechaInicio = "";
			$aParametros['ID_CUENTA'] = $_GET['id'];
			
			if($rsDetalle['iEmiteResumen'] == 0){  //No tiene Resumen todavia
				$dPeriodo = $rsDetalle['dPeriodo_sinFormat'];
				
				$aParametros['FECHA_CIERRE'] = $rsDetalle['dFechaCierre']; 
				$aParametros['FECHA_VTO'] = $rsDetalle['dFechaVencimiento'];
				$aParametros['LIMITE_CREDITO'] = $rsDetalle['fLimiteCredito'];
				$aParametros['REMANENTE_CREDITO'] = $rsDetalle['fRemanenteCredito'];
				$aParametros['LIMITE_COMPRA'] = $rsDetalle['fLimiteCompra'];
				$aParametros['REMANENTE_COMPRA'] = $rsDetalle['fRemanenteCompra'];
				$aParametros['LIMITE_ADELANTO'] = $rsDetalle['fLimiteAdelanto'];
				$aParametros['REMANENTE_ADELANTO'] = $rsDetalle['fRemanenteAdelanto'];
				$aParametros['DIAS_MORA'] = $rsDetalle['iDiasMora']; 
				
				$fSaldoAnterior =  $rsDetalle['fSaldoAnterior']; 
				
				$sqlResumen = "call usp_getResumenPorCuenta(\"{$_GET['id']}\",\"{$dPeriodo}\");";
				$rsResumen = $oMysql->consultaSel($sqlResumen);								
				
				$sCondicion = " WHERE CuentasUsuarios.id = {$_GET['id']}";
				$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondicion\");";		
				$rs = $oMysql->consultaSel($sqlDatos,true);
		
				if($rs){	
					$idGrupoAfinidad = $rs['idGrupoAfinidad'];	
					$sTitular = "";
					if($rs['iTipoPersona'] == 2)					
						$sTitular .= $rs['sRazonSocial'];				
					else
						$sTitular .= $rs['sNombre']." ".$rs['sApellido'];			
					
					$aParametros['TITULAR']	= $sTitular;
					$aParametros['NUMERO_CUENTA'] = $rs['sNumeroCuenta'];
					$aParametros['SALDO_ANTERIOR'] = 0;
					$aParametros['FECHA_INICIO'] = $rs['dFechaRegistro'];
					$aParametros['ESTADO'] = $rs['sEstado'];
					
					$sCondicionCalendario = " WHERE CalendariosFacturaciones.idGrupoAfinidad={$idGrupoAfinidad} AND CalendariosFacturaciones.dPeriodo=DATE_ADD('{$dPeriodo}',interval 1 MONTH)";
					$sqlCalendario = "Call usp_getCalendarioFacturacion(\"$sCondicionCalendario\");";
					$rsCalendario = $oMysql->consultaSel($sqlCalendario,true);
					
					
					
					$aParametros['FECHA_CIERRE_PROX'] = $rsCalendario['dFechaCierre'];
					$aParametros['FECHA_VTO_PROX'] = $rsCalendario['dFechaVencimiento'];
					
					
					
					
				
					
					
					
				}
			}else{//tiene Resumen
				
				//echo "tiene resumen";
				$sCondicion = " WHERE CuentasUsuarios.id = {$_GET['id']}";
				$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondicion\");";		
				$rs = $oMysql->consultaSel($sqlDatos,true);
				if($rs){
					$idGrupoAfinidad = $rs['idGrupoAfinidad'];
				}
				$dPeriodoFormat = date("m-Y");
				$archivo = "../includes/Files/Datos/".$dPeriodoFormat."/DR_".$idGrupoAfinidad."_".$_GET['id']."_".$dPeriodoFormat.".xml";
				//$archivo = "../includes/Files/Datos/DR_".$_GET['id']."_".$dPeriodoFormat.".xml";
				$sTitular = "";$sNumeroCuenta = "";
				if (file_exists($archivo)){
					$oXml= simplexml_load_file($archivo);
				}else{
					$msje = "No existe xml";
				}							
				
				$idGrupoAfinidad = $oXml->idGrupoAfinidad;				
				$aParametros['TITULAR'] = $oXml->sTitular;
				$aParametros['NUMERO_CUENTA'] = $oXml->sNumeroCuentaUsuario;
				$aParametros['SALDO_ANTERIOR'] =  $oXml->fSaldoAnterior;
				$aParametros['FECHA_CIERRE'] = $oXml->dFechaCierre;
				$aParametros['FECHA_VTO'] = $oXml->dFechaVencimiento;
				$aParametros['FECHA_CIERRE_PROX'] = $oXml->dFechaCierreSiguiente;
				$aParametros['FECHA_VTO_PROX'] = $oXml->dFechaVencimientoSiguiente;
				$aParametros['FECHA_INICIO'] = $oXml->dFechaInicio;
				$aParametros['LIMITE_CREDITO'] = $oXml->fLimiteCredito;
				$aParametros['REMANENTE_CREDITO'] = $oXml->fRemanenteCredito;
				$aParametros['LIMITE_COMPRA'] = $oXml->fLimiteCompra;
				$aParametros['REMANENTE_COMPRA'] = $oXml->fRemanenteCompra;
				$aParametros['LIMITE_ADELANTO'] = $oXml->fLimiteAdelanto;
				$aParametros['REMANENTE_ADELANTO'] = $oXml->fRemanenteAdelanto;
				$rsResumen = Array();
				$i=0;
				foreach ($oXml->detalle as $row){
					$rsResumen[$i]['idDetalle'] = $row->idDetalle;
					$rsResumen[$i]['tipoOperacion'] = $row->tipoOperacion;
					$rsResumen[$i]['Concepto'] = $row->sDescripcion;
					$rsResumen[$i]['idComercio'] = $row->idComercio;
					$rsResumen[$i]['sSucursal'] = $row->sSucursal;
					$rsResumen[$i]['Fecha'] = $row->dFechaOperacion;
					$rsResumen[$i]['iNumeroCuota'] = $row->sNumeroCuota;
					$rsResumen[$i]['sCuotas'] = $row->sCantidadCuota;
					$rsResumen[$i]['sNumeroCupon'] = $row->sNumeroCupon;
					$rsResumen[$i]['Importe'] = $row->fImporte;
					$i++;
				}
			}
		}
		//}
		$aParametros['ID_GRUPO_AFINIDAD'] = $idGrupoAfinidad;
		$dFechaInicio = $oMysql->consultaSel("SELECT dPeriodo FROM DetallesCuentasUsuarios WHERE idCuentaUsuario={$_GET['id']} ORDER BY dPeriodo ASC LIMIT 0,1",true);
		
		/*$sCondicionCalendario = " CalendariosFacturaciones.idGrupoAfinidad={$idGrupoAfinidad} AND YEAR(CalendariosFacturaciones.dPeriodo)<=YEAR('{$dPeriodoActual}') 
							AND MONTH(CalendariosFacturaciones.dPeriodo)<=MONTH('{$dPeriodoActual}') AND MONTH(CalendariosFacturaciones.dPeriodo)>=MONTH('{$dFechaInicio}')";
		$aParametros['optionsCalendario'] =$oMysql->getListaOpciones("CalendariosFacturaciones","id","DATE_FORMAT(dPeriodo, '%m/%Y')",$idPeriodo,$sCondicionCalendario,true,'CalendariosFacturaciones.dPeriodo DESC');*/
		//$sCondicionCalendario = "DetallesCuentasUsuarios.idCuentaUsuario={$_GET['id']} AND CalendariosFacturaciones.idGrupoAfinidad={$idGrupoAfinidad}";
		$sCondicionCalendario = "DetallesCuentasUsuarios.idCuentaUsuario={$_GET['id']}";
		
		$aParametros['optionsCalendario'] =$oMysql->getListaOpciones("DetallesCuentasUsuarios","DetallesCuentasUsuarios.dPeriodo","DATE_FORMAT(DetallesCuentasUsuarios.dPeriodo, '%m/%Y')",$dPeriodo,$sCondicionCalendario,true,'DetallesCuentasUsuarios.dPeriodo DESC');
		
		$sTabla .= "<table id='TablaDatos' cellpadding='0' cellspacing='0' class='TablaGeneral' width='100%' border='1'>
					<tr><td>Compras Financiadas</td><td>Sucursal</td><td>Fecha</td><td>Nro.Cuota</td><td>Nro.Cupon</td><td>Importe</td></tr>";
		$fTotal = 0;
		$sTabla .= "<tr><td>SALDO ANTERIOR</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align='right'>".number_format((double)$fSaldoAnterior,2,'.','')."</td></tr>";
		$fTotal += $fSaldoAnterior;
		
		foreach ($rsResumen as $row) {
			$sSucursal = "";
			if($row['idEmpleado'] != ""){
				$sCondiciones = " WHERE Empleados.id={$row['idEmpleado']}";
				$sqlDatos = "Call usp_getEmpleados(\"$sCondiciones\");";
				//$rsEmpleado = $mysql->selectRow($sqlDatos,true);
				$rsEmpleado = $oMysql->consultaSel($sqlDatos,true);
				$sSucursal .= $rsEmpleado['sSucursal'];
			}else{
				if($row['sSucursal'] == "") $row['sSucursal'] = "&nbsp;";
				$sSucursal .= $row['sSucursal'];
			}
			$sConcepto = $row['Concepto'];
			$dFechaOperacion = $row['Fecha'];
			$sNumeroCupon = $row['sNumeroCupon'];
			if($row['sCuotas'] != 0)
				$sNumeroCuota = $row['iNumeroCuota']."/".$row['sCuotas'];
			else 
				$sNumeroCuota="&nbsp;";
					
			if($sNumeroCupon == "") $sNumeroCupon="&nbsp;";
			
			$signo = "";$styleRow = "";
			if($row['tipoOperacion'] ==2 || $row['tipoOperacion'] ==4){
				$signo = "- ";
				$styleRow = "style='color:red'";
			}
			$sTabla .= "<tr>					
					<td width='140' $styleRow>{$sConcepto}</td>
					<td width='100' $styleRow>{$sSucursal}</td>	
					<td width='100' $styleRow>{$dFechaOperacion}</td>				
					<td width='60' $styleRow>{$sNumeroCuota}</td>
					<td width='60' $styleRow>{$sNumeroCupon}</td>
					<td width='70' $styleRow align='right'>".$signo . number_format((double)$row['Importe'],2,'.','')."</td>
					</tr>";			
			if($row['tipoOperacion'] ==2 || $row['tipoOperacion'] ==4) //tipoOperacion=2->Ajustes de Tipo Credito y  tipoOperacion=4 ->Cobranza Restan el Total
				$fTotal -= $row['Importe'];
			else	
				$fTotal += $row['Importe'];
		}		
		//$sTabla .= "<tr><td colspan='2' align='right'>Total:</td><td>".number_format($fTotal,2,'.','')."</td></tr>";
		$sTabla .= "</table>";
		$aParametros['TABLA_DATOS'] = $sTabla;
		$aParametros['IMPORTE_TOTAL'] = "$ ".number_format((double)$fTotal,2,'.','');
		
		
		
	}
	
	function cambiarResumen($idCuentaUsuario, $dPeriodo, $bPeriodoActualSeleccionado){
		GLOBAL $oMysql;	
		GLOBAL $arrayPermit;
		$oRespuesta = new xajaxResponse();
								
		if($bPeriodoActualSeleccionado)
		{
			$oRespuesta->assign("iDiasMora","style.display","block");
			$oRespuesta->assign("sEstado","style.display","block");	
		}
		else 
		{
			$oRespuesta->assign("iDiasMora","style.display","none");
			$oRespuesta->assign("sEstado","style.display","none");	
		}
		
		$aPeriodo = explode("-", $dPeriodo);
		$dPeriodoFormat = $aPeriodo[1]."-".$aPeriodo[0];
		/*$sql = "SELECT CalendariosFacturaciones.dPeriodo as 'dPeriodo',DATE_FORMAT(CalendariosFacturaciones.dPeriodo,'%m-%Y') as 'dPeriodoFormat' FROM CalendariosFacturaciones 
				WHERE CalendariosFacturaciones.id = '{$idPeriodo}'";
		$rsPeriodo = $oMysql->consultaSel($sql,true);
		$dPeriodo = $rsPeriodo['dPeriodo'];
		$dPeriodoFormat = $rsPeriodo['dPeriodoFormat'];*/
		
		$sCondicion = " WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$idCuentaUsuario} AND dPeriodo ='{$dPeriodo}'";
		$sql="Call usp_getDetallesCuentasUsuarios(\"$sCondicion\");";		
		
		$rsDetalle= $oMysql->consultaSel($sql,true);		
		if($rsDetalle){
		
			if($rsDetalle['iEmiteResumen'] == 0){  //No tiene Resumen todavia
				$dPeriodo = $rsDetalle['dPeriodo_sinFormat'];
				$fTotalResumen = $oMysql->consultaSel("SELECT fcn_getSaldoActual(\"$idCuentaUsuario\",\"$dPeriodo\")",true);
					
				$oRespuesta->assign("tdFechaCierre","innerHTML",$rsDetalle['dFechaCierre']);
				$oRespuesta->assign("tdFechaVto","innerHTML",$rsDetalle['dFechaVencimiento']);				
				$oRespuesta->assign("tdLimiteCredito","innerHTML",$rsDetalle['fLimiteCredito']);
				$oRespuesta->assign("tdRemanenteCredito","innerHTML",$rsDetalle['fRemanenteCredito']);
				$oRespuesta->assign("tdLimiteCompra","innerHTML",$rsDetalle['fLimiteCompra']);
				$oRespuesta->assign("tdRemanenteCompra","innerHTML",$rsDetalle['fRemanenteCompra']);
				$oRespuesta->assign("tdLimiteAdelanto","innerHTML",$rsDetalle['fLimiteAdelanto']);
				$oRespuesta->assign("tdRemanenteAdelanto","innerHTML",$rsDetalle['fRemanenteAdelanto']);
				$oRespuesta->assign("tdImporteTotal","innerHTML",number_format((double)$fTotalResumen,2,'.',''));
				
				$fSaldoAnterior =  $rsDetalle['fSaldoAnterior']; 
				
				$sCondicion = " WHERE CuentasUsuarios.id = {$idCuentaUsuario}";
				$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondicion\");";		
				$rs = $oMysql->consultaSel($sqlDatos,true);
		
				if($rs){	
					$sTitular = "";
					if($rs['iTipoPersona'] == 2)					
						$sTitular .= $rs['sRazonSocial'];				
					else
						$sTitular .= $rs['sNombre']." ".$rs['sApellido'];			
						
					$idGrupoAfinidad = $rs['idGrupoAfinidad'];	
					$dFechaInicio = $rs['dFechaRegistro_sinFormat'];
					$oRespuesta->assign("tdTitular","innerHTML",$sTitular);
					$oRespuesta->assign("tdNumeroCuenta","innerHTML",$rs['sNumeroCuenta']);
					$oRespuesta->assign("tdFechaInicio","innerHTML", $rs['dFechaRegistro']);
					$aParametros['SALDO_ANTERIOR'] = 0;
					
					
					$sCondicionCalendario = " WHERE CalendariosFacturaciones.idGrupoAfinidad={$idGrupoAfinidad} AND CalendariosFacturaciones.dPeriodo=DATE_ADD('{$dPeriodo}',interval 1 MONTH)";
					$sqlCalendario = "Call usp_getCalendarioFacturacion(\"$sCondicionCalendario\");";
					$rsCalendario = $oMysql->consultaSel($sqlCalendario,true);
					
					$oRespuesta->assign("tdFechaCierreProx","innerHTML",$rsCalendario['dFechaCierre']);
					$oRespuesta->assign("tdFechaVtoProx","innerHTML",$rsCalendario['dFechaVencimiento']);
					
					$sqlResumen = "call usp_getResumenPorCuenta(\"{$idCuentaUsuario}\",\"{$dPeriodo}\");";
					$rsResumen = $oMysql->consultaSel($sqlResumen);
				}	
					
				
				
				$oRespuesta->assign("eliminaResumen","style.display","none");
				$oRespuesta->assign("imprimirResumen","style.display","none");	
				
			}else{//tiene Resumen
				$sCondicion = " WHERE CuentasUsuarios.id = {$idCuentaUsuario}";
				$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondicion\");";		
				$rs = $oMysql->consultaSel($sqlDatos,true);
				
				$dFechaInicio = $rs['dFechaRegistro_sinFormat'];
				if($rs){
					$idGrupoAfinidad = $rs['idGrupoAfinidad'];
				}
				$archivo = "../includes/Files/Datos/".$dPeriodoFormat."/DR_".$idGrupoAfinidad."_".$idCuentaUsuario."_".$dPeriodoFormat.".xml";				
				//$archivo = "../includes/Files/Datos/DR_".$idCuentaUsuario."_".$dPeriodoFormat.".xml";				
				$sTitular = "";$sNumeroCuenta = "";
				$sTitular = "";
				if (file_exists($archivo)){
					$oXml= simplexml_load_file($archivo);
				}else{
					$archivo = "../includes/Files/Datos/".$dPeriodoFormat."/DR_2_".$idCuentaUsuario."_".$dPeriodoFormat.".xml";					
					//$archivo = "../includes/Files/Datos/DR_".$idCuentaUsuario."_".$dPeriodoFormat.".xml";					
					if(!file_exists($archivo))  $oRespuesta->alert("No se puede leer xml");
					else $oXml= simplexml_load_file($archivo); 
				}
				
				
				$msje = "";
				$oRespuesta->assign("tdTitular","innerHTML",(string)$oXml->sTitular);						
				$oRespuesta->assign("tdNumeroCuenta","innerHTML",(string)$oXml->sNumeroCuentaUsuario);
				//$aParametros['SALDO_ANTERIOR'] =  $fSaldoAnterior;

				$oRespuesta->assign("tdFechaCierre","innerHTML",(string)$oXml->dFechaCierre);
				$oRespuesta->assign("tdFechaVto","innerHTML",(string)$oXml->dFechaVencimiento);				
				$oRespuesta->assign("tdLimiteCredito","innerHTML",(string)$oXml->fLimiteCredito);
				$oRespuesta->assign("tdRemanenteCredito","innerHTML",(string)$oXml->fRemanenteCredito);
				$oRespuesta->assign("tdLimiteCompra","innerHTML",(string)$oXml->fLimiteCompra);
				$oRespuesta->assign("tdRemanenteCompra","innerHTML",(string)$oXml->fRemanenteCompra);
				$oRespuesta->assign("tdLimiteAdelanto","innerHTML",(string)$oXml->fLimiteAdelanto);
				$oRespuesta->assign("tdRemanenteAdelanto","innerHTML",(string)$oXml->fRemanenteAdelanto);
				$oRespuesta->assign("tdFechaCierreProx","innerHTML",(string)$oXml->dFechaCierreSiguiente);
				$oRespuesta->assign("tdFechaVtoProx","innerHTML", (string)$oXml->dFechaVencimientoSiguiente);
				$oRespuesta->assign("tdImporteTotal","innerHTML", (string)$oXml->fTotalResumen);
				//$oRespuesta->alert((string)$oXml->fTotalResumen);
				$fSaldoAnterior = $oXml->fSaldoAnterior;
				$aFechaCierre = explode("/", (string)$oXml->dFechaCierre);
				$dFechaCierre = strtotime($aFechaCierre[0]."-".$aFechaCierre[1]."-".$aFechaCierre[2]." 00:00:00");
				$rsResumen = Array();
				$i=0;
				$fTotal = 0;
				$fTotal += $fSaldoAnterior;
				foreach ($oXml->detalle as $row){
					$aFecha = explode("/", (string)$row->dFechaOperacion);
					$dFechaRegistro = strtotime($aFecha[0]."-".$aFecha[1]."-".$aFecha[2]." 00:00:00");
					
					$iEnPeriodo = 1;
					if($row->tipoOperacion == '4')
						if(((string)$row->dFechaOperacion != "") && ($dFechaCierre <= $dFechaRegistro )){
							$iEnPeriodo = 0;
						}
					
					if($iEnPeriodo ==1){				
						$rsResumen[$i]['idDetalle'] = (string)$row->idDetalle;
						$rsResumen[$i]['tipoOperacion'] = (string)$row->tipoOperacion;
						$rsResumen[$i]['Concepto'] = (string)$row->sDescripcion;
						$rsResumen[$i]['idComercio'] = (string)$row->idComercio;
						$rsResumen[$i]['sSucursal'] = (string)$row->sSucursal;
						$rsResumen[$i]['Fecha'] = (string)$row->dFechaOperacion;
						$rsResumen[$i]['iNumeroCuota'] = (string)$row->sNumeroCuota;
						$rsResumen[$i]['sCuotas'] = (string)$row->sCantidadCuota;
						$rsResumen[$i]['sNumeroCupon'] = (string)$row->sNumeroCupon;
						$rsResumen[$i]['Importe'] = (string)$row->fImporte;
						$i++;
						if((string)$row->tipoOperacion =='2' || (string)$row->tipoOperacion =='4') //tipoOperacion=2->Ajustes de Tipo Credito y  tipoOperacion=4 ->Cobranza Restan el Total
							$fTotal -= (string)$row->fImporte;
						else	
							$fTotal += (string)$row->fImporte;
					}
				}
				if(in_array(acceder_como_admin,$arrayPermit)){
					$oRespuesta->assign("eliminaResumen","style.display","inline");
					$oRespuesta->assign("imprimirResumen","style.display","inline");					
				}
			}
			$sTabla = "";
			$sTabla = getTablaResumen($fSaldoAnterior,$rsResumen);
			$oRespuesta->assign("tdTablaResumen","innerHTML",$sTabla);
		}
		return  $oRespuesta;
	}
		
	function getTablaResumen($fSaldoAnterior,$rsResumen){		
		$sTabla .= "<table id='TablaDatos' cellpadding='0' cellspacing='0' class='TablaGeneral' width='100%' border='1'>
					<tr><td>Compras Financiadas</td><td>Sucursal</td><td>Fecha</td><td>Nro.Cuota</td><td>Nro.Cupon</td><td>Importe</td></tr>";
		
		$sTabla .= "<tr><td>SALDO ANTERIOR</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align='right'>".number_format((double)$fSaldoAnterior,2,'.','')."</td></tr>";
		
		foreach ($rsResumen as $row) {
			$sSucursal = "";
			if($row['sSucursal'] == "")
				$sSucursal .= "&nbsp;";
			else
				$sSucursal .= $row['sSucursal'];
			
			$dFechaOperacion = "";	
			if($row['Fecha'] == "")
				$dFechaOperacion .= "&nbsp;";
			else
				$dFechaOperacion .= $row['Fecha'];	
			
			if($row['sCuotas'] != 0)
				$sNumeroCuota = $row['iNumeroCuota']."/".$row['sCuotas'];
			else 
				$sNumeroCuota="&nbsp;";

			$sConcepto = $row['Concepto'];
			$sNumeroCupon = $row['sNumeroCupon'];			
					
			if($sNumeroCupon == "") $sNumeroCupon="&nbsp;";
			
			$signo = "";$styleRow = "";
			if($row['tipoOperacion'] ==2 || $row['tipoOperacion'] ==4){
				$signo = "- ";
				$styleRow = "style='color:red'";
			}
			if($row['Importe']>0){
				$sTabla .= "<tr>					
					<td $styleRow>{$sConcepto}</td>
					<td $styleRow>{$sSucursal}</td>	
					<td $styleRow>{$dFechaOperacion}</td>				
					<td $styleRow>{$sNumeroCuota}</td>
					<td $styleRow>{$sNumeroCupon}</td>
					<td $styleRow align='right'>".$signo . number_format((double)$row['Importe'],2,'.','')."</td>
					</tr>";			
			}
		}		
		//$sTabla .= "<tr><td colspan='2' align='right'>Total:</td><td>".number_format($fTotal,2,'.','')."</td></tr>";
		$sTabla .= "</table>";
		return $sTabla;
	}
	
	function eliminarResumen($idGrupoAfinidad,$idCuentaUsuario,$dPeriodo){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();

		$aPeriodo = explode("/",$dPeriodo);
		$dPeriodo = $aPeriodo[1]."-".$aPeriodo[0]."-01 00:00:00";
		$sqlDatos = "CALL usp_eliminarResumen(\"{$idCuentaUsuario}\",\"{$dPeriodo}\")";
		
		$rs = $oMysql->consultaSel($sqlDatos,true);
		$msje = "";
		//$oRespuesta->alert($rs);
		if($rs == 'OK'){
			$msje .= "La operacion se pudo realizar exitosamente";
			$dPeriodoFormat = $aPeriodo[0]."-".$aPeriodo[1];
			
			$name_file="../includes/Files/Datos/".$dPeriodoFormat."/DR_".$idGrupoAfinidad."_".$idCuentaUsuario."_".$dPeriodoFormat.".xml";
			
			if (!unlink($name_file)){ 
				$msje .= "\n No se pudo borrar el archivo :".$name_file; 
			} 			
		}else{ 
			$msje .= "No se pudo eliminar el Resumen";
		}
		$oRespuesta->alert($msje);
		$oRespuesta->redirect("Resumen.php?id=".$idCuentaUsuario);
		return  $oRespuesta;		
	}
	
	function imprimirResumen($idCuentaUsuario,$idGrupoAfinidad,$dPeriodo){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		$iTieneresumen = 0;
		
		$sTablaFinal = "";
			
		$aPeriodo = explode("/",$dPeriodo);
		$dPeriodoFormat = $aPeriodo[0]."-".$aPeriodo[1];
		$mesAnterior = $aPeriodo[0]-1;
		$dPeriodoAnterior = $aPeriodo[1]."-".$mesAnterior."-01 00:00:00";
		
		//if($_SESSION['id_user']==296) $oRespuesta->alert($idCuentaUsuario.'-'.$idGrupoAfinidad.'-'.$dPeriodo.'-'.$dPeriodoAnterior);
		
		//$archivo = "../includes/Files/Datos/DR_".$idCuentaUsuario."_".$dPeriodoFormat.".xml"; 
		$archivo="../includes/Files/Datos/".$dPeriodoFormat."/DR_".$idGrupoAfinidad."_".$idCuentaUsuario."_".$dPeriodoFormat.".xml";
		//$oRespuesta->alert($archivo);
		//if($_SESSION['id_user']==296) $oRespuesta->alert($archivo);
		$sTabla ="";
		$sTitular = "";
		//$oRespuesta->alert($archivo);
		if (file_exists($archivo)) 	{
			$oXml= simplexml_load_file($archivo);
		}else{
			$archivo="../includes/Files/Datos/".$dPeriodoFormat."/DR_2_".$idCuentaUsuario."_".$dPeriodoFormat.".xml";
			if(file_exists($archivo1))
				$oXml = simplexml_load_file($archivo1);
			else
				$msje = "No existe xml";
		}
		
		$sDomicilio = html_entity_decode($oXml->sDomicilio);
		$sTitular = html_entity_decode($oXml->sTitular);	
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
		$aParametros['LIMITE_ADELANTO'] = $oXml->fLimiteAdelanto;
		
		$aFechaInicio = explode('/',$oXml->dFechaInicio);
		$dFechaInicio = $aFechaInicio[2]."-".$aFechaInicio[1]."-".$aFechaInicio[0]." 00:00:00";
		
		
		
			//------------------------ 19/05/2012 (Maxi) Obtener id de region y provincia para filtrar leyenda 'F.A.P. Cta. 17304' -------------------------
		$sqlDatos="Call usp_getSucursales(\"$sCondiciones\");";
		$CantReg = $oMysql->consultaSel($sqlDatos,true); 
		
		$sqlProvincia  = "
		SELECT 
			SolicitudesUsuarios.idProvinciaResumen
		FROM 
			SolicitudesUsuarios
		LEFT JOIN CuentasUsuarios on SolicitudesUsuarios.id = CuentasUsuarios.idSolicitud
		WHERE
			CuentasUsuarios.id = $idCuentaUsuario
		";
		
		$idProvincia = $oMysql->consultaSel($sqlProvincia, true);
		
		$sSqlSucursales = "
		SELECT distinct Sucursales.sLeyenda
		FROM 
			Sucursales
		LEFT JOIN Regiones ON Sucursales.idRegion = Regiones.id 
		WHERE
		Sucursales.idProvincia = $idProvincia and Sucursales.idRegion <> 0;
		"; 
		
		//echo $rsProvincia['idProvinciaResumen']; die();
		//echo $sSqlSucursales;die();
		//echo $sqlProvincia;die();
		
		$sLeyenda = $oMysql->consultaSel($sSqlSucursales,true);
		
		//echo "leyenda: " . htmlentities($sLeyenda);die();
		
		$aParametros['LEYENDA'] = htmlentities($sLeyenda);
		
		
		//-------------------------------------------------------------------------------------------------------------------------------------------
		
		
		
		
		$sCondicionCalendario = " WHERE CalendariosFacturaciones.idGrupoAfinidad={$idGrupoAfinidad} AND CalendariosFacturaciones.dPeriodo='{$dPeriodoAnterior}'";
		$aDatosPeriodoAnterior = $oMysql->consultaSel("CALL usp_getCalendarioFacturacion(\"$sCondicionCalendario\")",true);
		if(sizeof($aDatosPeriodoAnterior)>0){
			$aParametros['FECHA_CIERRE_ANTERIOR'] = $aDatosPeriodoAnterior['dFechaCierre'];
			$aParametros['FECHA_VTO_ANTERIOR'] = $aDatosPeriodoAnterior['dFechaVencimiento'];
		}else{
			$aParametros['FECHA_CIERRE_ANTERIOR'] ="-";
			$aParametros['FECHA_VTO_ANTERIOR'] ="-";
		}
		
		//$aParametros['optionsCalendario'] =$oMysql->getListaOpciones("CalendariosFacturaciones","id","DATE_FORMAT(dPeriodo, '%m/%Y')",'',$sCondicionCalendario,true,'CalendariosFacturaciones.dPeriodo DESC');
		
		//rules='all' border='1'
		$sHeaderTabla = "<tr><td>Compras Financiadas</td><td>Sucursal</td><td>Fecha</td><td>Nro.Cuota</td><td>Nro.Cupon</td><td align='right'>Importe</td></tr>";
		$sTabla .= "<table id='TablaDatos' cellpadding='0' cellspacing='0' width='100%' style='font-family:Arial;font-size:10px;' >
					{$sHeaderTabla}
					<tr><td style='width:170px;height:10px;padding-left:10px;'>&nbsp;</td><td style='width:160px;'>&nbsp;</td><td style='width:70px;'>&nbsp;</td><td style='width:40px;'>&nbsp;</td><td style='width:40px;'>&nbsp;</td><td style='width:55px;' align='right'>&nbsp;</td></tr>";
		//$fTotal = 0;
		$sFilaSaldo = "";
		$sFilaSaldo .= "<tr><td style='font-size:9px'>SALDO ANTERIOR</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align='right'>".number_format((double)$oXml->fSaldoAnterior,2,'.','')."</td></tr>";

		$nuevaPagina = false;
		$sFilas1 = "";
		$sFilas2 = "";
		$i =0;
		$iCantidadPagina = 1;
		foreach ($oXml->detalle as $aDetalle) {
			$i++;
			$sNumeroCupon = $aDetalle->sNumeroCupon;				
			$sNumeroCuota =$aDetalle->sNumeroCuota."/".$aDetalle->sCantidadCuota;
			if($aDetalle->sNumeroCupon == "") $sNumeroCupon="&nbsp;";
			if($aDetalle->sNumeroCuota == "") $sNumeroCuota="&nbsp;";
			
			$signo = "";				
			if($aDetalle->tipoOperacion == "4" || $aDetalle->tipoOperacion == "2") $signo = "-";
		
			if($i > 30){
				$sFilas2 .= "<tr>
					<td style='padding-peft:3px;font-size:9px'>{$aDetalle->sDescripcion}</td>
					<td style='padding-peft:3px;font-size:9px'>{$aDetalle->sSucursal}</td>
					<td>{$aDetalle->dFechaOperacion}</td>
					<td>{$sNumeroCuota}</td>
					<td>{$sNumeroCupon}</td>
					<td align='right'>".$signo.number_format((double)$aDetalle->fImporte,2,'.','')."</td>
					</tr>";
				$nuevaPagina = true;	  
				$iCantidadPagina++;
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
		
		//if($nuevaPagina)$sFilas1 .= "<tr><td colspan='6'>Pagina 1/2</td></tr>";
		$aParametros['PAGINA'] = "Pagina 1/".$iCantidadPagina;
		$sFilas1 .= "<tr><td colspan='3' style='border-bottom:1px solid #000;border-top:1px solid #000'>&nbsp;</td>
					<td align='right' colspan='2' style='border-bottom:1px solid #000;border-top:1px solid #000'>SALDO ACTUAL $</td>
					<td align='right' style='border-bottom:1px solid #000;border-top:1px solid #000'>".number_format((double)$oXml->fTotalResumen,2,'.','')."</td></tr>";	
		
		$sTabla1 = $sTabla . $sFilaSaldo . $sFilas1. "</table>";
		$aParametros['TABLA_DATOS'] = $sTabla1;
		
		$aParametros['IMPORTE_TOTAL'] = "$ ".$oXml->fTotalResumen;
		if($oXml->fTotalResumen < 0)
			$oXml->fTotalResumen = 0;
		$sCodigo = generarCodigoBarra($oXml->sNumeroCuentaUsuario,$oXml->fTotalResumen,$oXml->dFechaVencimiento);
		//$sCodigo = generarCodigoBarraBSE($oXml->sNumeroCuentaUsuario,$oXml->fTotalResumen,$oXml->dFechaVencimiento);
		$aParametros['CODIGO_BARRA'] = $sCodigo;
		
		$aParametros['MOSTRAR_NUMERO_VERIFICACION'] = "style='display:none'";
		$idTipoEstadoTarjeta = $oMysql->consultaSel("SELECT idTipoEstadoTarjeta FROM Tarjetas WHERE Tarjetas.idCuentaUsuario={$idCuentaUsuario} ORDER BY dFechaRegistro DESC LIMIT 0,1",true);
		if($idTipoEstadoTarjeta != 5){ //Tarjeta que no estan en Pendiende de Habilitacion
			$sNumeroValidacion = $oMysql->consultaSel("SELECT sNumeroValidacion FROM CuentasUsuarios WHERE CuentasUsuarios.id={$idCuentaUsuario}",true);
			$aParametros['MOSTRAR_NUMERO_VERIFICACION'] = "style='display:inline'";
			$aParametros['NUMERO_VERIFICACION'] = $sNumeroValidacion;
		}
		
		$sTablaFinal.= parserTemplate( INCLUDES_DIR . "/Files/Modelos/MR_1.tpl",$aParametros);
		
		$sTabla2 = "";
		if($nuevaPagina){
			$aParametros['PAGINA'] = "Pagina 2/".$iCantidadPagina;
			//$sFilas2 .= "<tr><td colspan='6'>Pagina 2/2</td></tr>";
			
			$sTabla2 = $sTabla . $sFilas2. "</table>";
			$aParametros['TABLA_DATOS'] = $sTabla2;
			$sTablaFinal.= "<table cellpadding='0' cellspacing='0' width='100%'><tr><td style='height:10px'></td></tr></table>".parserTemplate( INCLUDES_DIR . "/Files/Modelos/MR_1.tpl",$aParametros);
			$sTablaFinal.="<div  id='saltopagina' style='display:block;page-break-before:always;' /></div>";
		}
			
		$oRespuesta->assign("impresiones","innerHTML",$sTablaFinal);		
		$oRespuesta->script("window.print();");
		return  $oRespuesta;
	}
	
	$oXajax=new xajax();	
	$oXajax->setCharEncoding('ISO-8859-1');
    $oXajax->configure('decodeUTF8Input',true);
	$oXajax->registerFunction("cambiarResumen");
	$oXajax->registerFunction("eliminarResumen");
	$oXajax->registerFunction("imprimirResumen");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");
	
	xhtmlHeaderPaginaGeneral($aParametros);	
	
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/CuentasUsuarios/ResumenCuentaUsuario.tpl",$aParametros);	

	echo xhtmlFootPagina();
?>	