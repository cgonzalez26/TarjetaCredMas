<?php
ini_set("memory_limit","1024M");
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$aParam=array();
global $oMysql,$mysql;

include_once( CLASSES_DIR . '/excel.php' );
include_once( CLASSES_DIR . '/write_excel/Worksheet.php' );
include_once( CLASSES_DIR . '/write_excel/Workbook.php' );

	
	$aPeriodo = explode("-",$_GET['dPeriodo']);
	$sMes = "";
	switch($aPeriodo[1]){
		case "1":$sMes .="Enero";break;
		case "2":$sMes .="Febrero";break;
		case "3":$sMes .="Marzo";break;
		case "4":$sMes .="Abril";break;
		case "5":$sMes .="Mayo";break;
		case "6":$sMes .="Junio";break;
		case "7":$sMes .="Julio";break;
		case "8":$sMes .="Agosto";break;
		case "9":$sMes .="Septiembre";break;
		case "10":$sMes .="Octubre";break;		
		case "11":$sMes .="Noviembre";break;		
		case "12":$sMes .="Diciembre";break;		
	}
	$sTituloFecha = $sMes.'-'.$aPeriodo[0];
	
	$nomExcel = 'xlsResumenesCuentas_'. date('d-m-Y') ;
	
	/*$mysql_accesos = new MySql();
	//$mysql_accesos->setServer('localhost','dbgrupo','0tr3b0r');
	$mysql_accesos->setDBName('AccesosSistemas');		*/

	//if($_GET['cmd_search']){
		
		$conditions = array();
		
		$conditions[] = "Empleados.sEstado='A'";
		
		if($_GET['idGrupoAfinidad'] && $_GET['idGrupoAfinidad']!=4)$aCond[]="  CuentasUsuarios.idGrupoAfinidad ='{$_GET['idGrupoAfinidad']}' ";
		
		$sTituloRegion = "";$sTituloSucursal = "";$sTituloOficina = "";
		if($_GET['idRegion'] != 0){
			$sEmpleadosRegion = "";
			$sEmpleadosSucursal = "";
			$aEmpleadosRegion = $oMysql->consultaSel("SELECT Empleados.id FROM Empleados 
				LEFT JOIN Oficinas ON Empleados.idOficina = Oficinas.id
				LEFT JOIN Sucursales ON Oficinas.idSucursal = Sucursales.id
				LEFT JOIN Regiones ON Sucursales.idRegion = Regiones.id
				WHERE Regiones.id = {$_GET['idRegion']} 
				ORDER BY Empleados.id DESC");
			$sEmpleadosRegion .= implode(",",$aEmpleadosRegion);		
			
			$sRegion = $oMysql->consultaSel("SELECT Regiones.sNombre FROM Regiones WHERE Regiones.id={$_GET['idRegion']}",true);
			$sTituloRegion .="Region: ".$sRegion;
		}
		$sSucursal = "";
		if($_GET['idSucursal'] != 0){
			$aEmpleadosSucursal = $oMysql->consultaSel("SELECT Empleados.id 
			FROM Empleados 
			LEFT JOIN Oficinas ON Empleados.idOficina = Oficinas.id
			LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal
			WHERE Sucursales.id = {$_GET['idSucursal']} 
			ORDER BY Empleados.id DESC");
			
			$sEmpleadosSucursal = implode(",",$aEmpleadosSucursal);		

			$sSucursal = $oMysql->consultaSel("SELECT Sucursales.sNombre FROM Sucursales WHERE Sucursales.id={$_GET['idSucursal']}",true);
			$sTituloSucursal .= "Sucursal: ".$sSucursal;
		}
		$sOficina = "";
		if($_GET['idOficina'] != 0){
			$aEmpleadosOficina = $oMysql->consultaSel("SELECT Empleados.id FROM Empleados 
					WHERE Empleados.idOficina = {$_GET['idOficina']} ORDER BY Empleados.id DESC");
			$sEmpleadosOficina = implode(",",$aEmpleadosOficina);	
			
			$sOficina = $oMysql->consultaSel("SELECT Oficinas.sApodo FROM Oficinas WHERE Oficinas.id={$_GET['idOficina']}",true);
			$sTituloOficina .= "Oficina: ".$sOficina;
		}
		
		$sBase= "";
		if($sRegion != "")
			$sBase .= $sRegion;
		if($sSucursal != "")	
			$sBase .= $sSucursal;
		if($sOficina != "")
			$sBase .= $sOficina;
				
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
		if($_GET['fImporte'])$aCond[]="  DetallesCuentasUsuarios.fImporteTotalPesos >= {$_GET['fImporte']} ";
		
		if($_GET['dPeriodo'])$aCond[]="  DetallesCuentasUsuarios.dPeriodo ='{$_GET['dPeriodo']}' ";
		
		if($_GET['dFechaDesde']){
			$dFechaDesdeReporteResumen = $_GET['dFechaDesde'];
		}		
		if($_GET['dFechaHasta']){
			$dFechaHastaReporteResumen = $_GET['dFechaHasta'];
		}
		
		$sCondiciones= " WHERE ".implode(' AND ',$aCond)." ORDER BY InformesPersonales.sApellido ASC";
		$sqlDatos="Call usp_getReporteResumenesCuentas(\"$sCondiciones\",\"$dFechaDesdeReporteResumen\",\"$dFechaHastaReporteResumen\");";
		$aFilas = $oMysql->consultaSel($sqlDatos);
		
		//var_export("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");die();
		//$mysql_accesos->disconnect();
		

  function HeaderingExcel($filename) {
      header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=$filename" );
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
      header("Pragma: public");
      }

  // HTTP headers
  HeaderingExcel($nomExcel);

  
  $workbook = new Workbook("-");
  
  $worksheet1 =& $workbook->add_worksheet('Hoja1');

  // Format for the headings
  $formatot =& $workbook->add_format();
  $formatot->set_size(11);
  $formatot->set_align('center');
  $formatot->set_color('black');
  $formatot->set_pattern();
  $formatot->set_fg_color('gray');
  
  $worksheet1->write_string(0,0,"",$formatot);
  $worksheet1->write_string(0,1,"",$formatot);
  $worksheet1->write_string(0,2,"Periodo Calendario:".$sTituloFecha,$formatot);
  $worksheet1->write_string(0,3,"",$formatot);
  $worksheet1->write_string(0,4,$sTituloRegion,$formatot);
  $worksheet1->write_string(0,5,"",$formatot);
  $worksheet1->write_string(0,6,$sTituloSucursal,$formatot);
  $worksheet1->write_string(0,7,"",$formatot);
  $worksheet1->write_string(0,8,"$sTituloOficina",$formatot);
  
  $worksheet1->write_string(2,0,"Nro.Reg.",$formatot);
  $worksheet1->write_string(2,1,"Nro.Cuenta",$formatot);
  $worksheet1->write_string(2,2,"Titular",$formatot);
  $worksheet1->write_string(2,3,"Estado",$formatot);
  $worksheet1->write_string(2,4,"Fch Cierre",$formatot);
  $worksheet1->write_string(2,5,"Fch Vto",$formatot);
  $worksheet1->write_string(2,6,"Saldo Ant.",$formatot);
  $worksheet1->write_string(2,7,"Consumos",$formatot);
  $worksheet1->write_string(2,8,"Bonificacion",$formatot);
  $worksheet1->write_string(2,9,"Int.Fin.",$formatot);
  $worksheet1->write_string(2,10,"Int.Pun.",$formatot);
  $worksheet1->write_string(2,11,"Gastos Admin.",$formatot);
  $worksheet1->write_string(2,12,"Seg.Vida",$formatot);
  $worksheet1->write_string(2,13,"Ajustes Deb.",$formatot);
  $worksheet1->write_string(2,14,"Ajustes Cred.",$formatot);
  $worksheet1->write_string(2,15,"Total Iva Deb.",$formatot);
  $worksheet1->write_string(2,16,"Total Iva Cred.",$formatot);
  $worksheet1->write_string(2,17,"Cobranzas",$formatot);
  $worksheet1->write_string(2,18,"Total a Pagar",$formatot);
 
  $iFilaExcel=2;  	
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
	$fCantidadCuentasNoBajas = 0;
	$i = 0;
  foreach ($aFilas as $rs){
  	$i++;
	$sUsuario = "";
	if($rs['iTipoPersona'] == 2){					
		$sUsuario .= $rs['sRazonSocial'];				
	}else{
		$sUsuario .= $rs['sTitular'];		
	}
	$param = base64_encode($rs['id']);
			
			
	$dFechaCierreSiguiente = $oMysql->consultaSel("SELECT CalendariosFacturaciones.dFechaCierre FROM CalendariosFacturaciones WHERE idGrupoAfinidad={$_GET['idGrupoAfinidad']} AND dPeriodo=DATE_ADD('{$_GET['dPeriodo']}',interval 1 MONTH)",true);

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
	$fCantidadCuentasNoBajas = 0;
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
	  
 	  $iFilaExcel++;
 	  $worksheet1->write_number($iFilaExcel,0,$i);
	  $worksheet1->write_string($iFilaExcel,1,$rs['sNumeroCuenta']);
	  $worksheet1->write_string($iFilaExcel,2,$sUsuario);
	  $worksheet1->write_string($iFilaExcel,3,$rs['sEstado']);
	  $worksheet1->write_string($iFilaExcel,4,$rs['dFechaCierre']);
	  $worksheet1->write_string($iFilaExcel,5,$rs['dFechaVencimiento']);
	  $worksheet1->write_number($iFilaExcel,6,number_format((double)$fSaldoAnterior,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,7,number_format((double)$fAcumuladoConsumoUnPago,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,8,number_format((double)$fAjusteBonif,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,9,number_format((double)$fInteresFinanciacion,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,10,number_format((double)$fInteresPunitorio,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,11,number_format((double)$fAjusteCargo,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,12,number_format((double)$fAjusteSeguro,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,13,number_format((double)$fAjusteDeb,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,14,number_format((double)$fAjusteCred,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,15,number_format((double)$fAcumuladoIVAAjusteDebito,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,16,number_format((double)$rs['fAcumuladoIVAAjusteCredito'],2,'.',''));
	  $worksheet1->write_number($iFilaExcel,17,number_format((double)$fCobranzas,2,'.',''));
 	  $worksheet1->write_number($iFilaExcel,18,number_format((double)$fImporteTotalPesos,2,'.',''));
 	  
 	  $fTotalConsumos +=$fAcumuladoConsumoUnPago;
		$fTotalBonificaciones +=$fAjusteBonif;
		$fTotalIntFin +=$fInteresFinanciacion;
		$fTotalIntPun +=$fInteresPunitorio;
		$fTotalGastosAdmin +=$fAjusteCargo;
		$fTotalSegVida +=$fAjusteSeguro;
		$fTotalAjustesDeb +=$fAjusteDeb;
		$fTotalAjustesCred +=$fAjusteCred;
		$fTotalIvaDeb +=$fAcumuladoIVAAjusteDebito;
		$fTotalIvaCred +=$rs['fAcumuladoIVAAjusteCredito'];
		$fTotalCobranzas +=$fCobranzas;
		$fTotalPagar +=$fImporteTotalPesos;
		 $fTotalAcumuladoCobranzas += $fAcumuladoCobranzas; 
		//if($rs['idTipoEstadoCuenta'] != 12) $fCantidadCuentasNoBajas++;
		if($rs['sEstado'] == 'DADO DE BAJA') $fCantidadCuentasNoBajas++;
  } 
  $iFilaExcel++;
   $worksheet1->write_string($iFilaExcel,0,'');
	  $worksheet1->write_string($iFilaExcel,1,'');
	  $worksheet1->write_string($iFilaExcel,2,'');
	  $worksheet1->write_string($iFilaExcel,3,'');
	  $worksheet1->write_string($iFilaExcel,4,'');
	  $worksheet1->write_string($iFilaExcel,5,'');
	  $worksheet1->write_string($iFilaExcel,6,'TOTALES');
	  $worksheet1->write_number($iFilaExcel,7,number_format((double)$fTotalConsumos,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,8,number_format((double)$fTotalBonificaciones,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,9,number_format((double)$fTotalIntFin,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,10,number_format((double)$fTotalIntPun,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,11,number_format((double)$fTotalGastosAdmin,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,12,number_format((double)$fTotalSegVida,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,13,number_format((double)$fTotalAjustesDeb,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,14,number_format((double)$fTotalAjustesCred,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,15,number_format((double)$fTotalIvaDeb,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,16,number_format((double)$fTotalIvaCred,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,17,number_format((double)$fTotalCobranzas,2,'.',''));
 	  $worksheet1->write_number($iFilaExcel,18,number_format((double)$fTotalPagar,2,'.',''));

  $iFilaExcel++;
  $iFilaExcel++; 
  $worksheet1->write_string($iFilaExcel,0,'');
	  $worksheet1->write_string($iFilaExcel,1,'');
	  $worksheet1->write_string($iFilaExcel,2,'');
	  $worksheet1->write_string($iFilaExcel,3,'');
	  $worksheet1->write_string($iFilaExcel,4,'');
	  $worksheet1->write_string($iFilaExcel,5,'');
	  $worksheet1->write_string($iFilaExcel,6,'');
	  $worksheet1->write_string($iFilaExcel,7,'BASE IMP '.$sBase);

  $iFilaExcel++; 
  $fComision = $fCantidadCuentasNoBajas * 15;
  $worksheet1->write_string($iFilaExcel,0,'');
	  $worksheet1->write_string($iFilaExcel,1,'');
	  $worksheet1->write_string($iFilaExcel,2,'');
	  $worksheet1->write_string($iFilaExcel,3,'');
	  $worksheet1->write_string($iFilaExcel,4,'');
	  $worksheet1->write_string($iFilaExcel,5,'');
	  $worksheet1->write_string($iFilaExcel,6,'');
	  $worksheet1->write_string($iFilaExcel,7,'COMIS $ 15 C/U ');
	  $worksheet1->write_number($iFilaExcel,8,number_format($fComision,2,'.',''));	  

  $iFilaExcel++; 
  $fTotalGastos = $fTotalGastosAdmin + $fTotalAjustesDeb+$fTotalAjustesCred;//los creditos son negativos entonces lo ultimo es una resta
  $worksheet1->write_string($iFilaExcel,0,'');
	  $worksheet1->write_string($iFilaExcel,1,'');
	  $worksheet1->write_string($iFilaExcel,2,'');
	  $worksheet1->write_string($iFilaExcel,3,'');
	  $worksheet1->write_string($iFilaExcel,4,'');
	  $worksheet1->write_string($iFilaExcel,5,'');
	  $worksheet1->write_string($iFilaExcel,6,'');
	  $worksheet1->write_string($iFilaExcel,7,'GTOS ');
	  $worksheet1->write_number($iFilaExcel,8,number_format($fTotalGastos,2,'.',''));	  
  $iFilaExcel++; 
  
  $fTotalInteres = $fTotalIntFin+$fTotalIntPun;
  $worksheet1->write_string($iFilaExcel,0,'');
	  $worksheet1->write_string($iFilaExcel,1,'');
	  $worksheet1->write_string($iFilaExcel,2,'');
	  $worksheet1->write_string($iFilaExcel,3,'');
	  $worksheet1->write_string($iFilaExcel,4,'');
	  $worksheet1->write_string($iFilaExcel,5,'');
	  $worksheet1->write_string($iFilaExcel,6,'');
	  $worksheet1->write_string($iFilaExcel,7,'INTERES ');
	  $worksheet1->write_number($iFilaExcel,8,number_format($fTotalInteres,2,'.',''));
	  	  
  $workbook->close();
?>				