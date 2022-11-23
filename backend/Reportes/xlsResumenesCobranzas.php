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
	
	$nomExcel = 'xlsResumenesConCobranzas_'. date('d-m-Y') ;
	
	/*$mysql_accesos = new MySql();
	$mysql_accesos->setServer('localhost','dbgrupo','0tr3b0r');
	$mysql_accesos->setDBName('AccesosSistemas');*/

	//if($_GET['cmd_search']){
		
		$conditions = array();
		
		$conditions[] = "Empleados.sEstado='A'";
		
		if($_GET['idGrupoAfinidad'])$aCond[]="  CuentasUsuarios.idGrupoAfinidad ='{$_GET['idGrupoAfinidad']}' ";
		
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
		if($_GET['idOficina'] != 0){
			$aEmpleadosOficina = $oMysql->consultaSel("SELECT Empleados.id FROM Empleados 
					WHERE Empleados.idOficina = {$_GET['idOficina']} ORDER BY Empleados.id DESC");
			$sEmpleadosOficina = implode(",",$aEmpleadosOficina);	
			
			$sOficina = $oMysql->consultaSel("SELECT Oficinas.sApodo FROM Oficinas WHERE Oficinas.id={$_GET['idOficina']}",true);
			$sTituloOficina .= "Oficina: ".$sOficina;
		}
		if($sRegion != "")
			$sBase .= $sRegion;
		if($sSucursal != "")	
			$sBase .= $sSucursal;
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
		if($_GET['fImporte'])$aCond[]="  DetallesCuentasUsuarios.fImporteTotalPesos > {$_GET['fImporte']} ";
		
		if($_GET['dPeriodo'])$aCond[]="  DetallesCuentasUsuarios.dPeriodo ='{$_GET['dPeriodo']}' ";
		
		if($_GET['dFechaDesde']){
			$dFechaDesdeReporteResumen = $_GET['dFechaDesde'];
		}		
		if($_GET['dFechaHasta']){
			$dFechaHastaReporteResumen = $_GET['dFechaHasta'];
		}
		
		$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY InformesPersonales.sApellido ASC";
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
  $worksheet1->write_string(2,19,"Acumulado Cobranzas",$formatot);
 
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
	$fTotalInteres = 0;
	$fTotalAcumuladoCobranzas = 0;
	$i = 0;
	//$fCantidadCuentasNoBajas = 0;
  foreach ($aFilas as $rs){
  	  $i++;
	  $sUsuario = "";
	  if($rs['iTipoPersona'] == 2){					
			$sUsuario .= $rs['sRazonSocial'];				
	  }else{
			$sUsuario .= $rs['sTitular'];		
	  }
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
	  if (file_exists($archivo)){
		$oXml= simplexml_load_file($archivo);
	  }else{
		$oRespuesta->alert("No se puede leer xml");
	  } 
	     
	  $aDatos = array();
	  $aDatos = $oMysql->consultaSel("CALL usp_getDatosResumenContable(\"{$rs['id']}\",\"{$rs['dFechaCierreSinFormat']}\")",true);
		  
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
	  $worksheet1->write_number($iFilaExcel,6,number_format($fSaldoAnterior,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,7,number_format($fAcumuladoConsumoUnPago,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,8,number_format($fAjusteBonif,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,9,number_format($rs['fInteresFinanciacion'],2,'.',''));
	  $worksheet1->write_number($iFilaExcel,10,number_format($rs['fInteresPunitorio'],2,'.',''));
	  $worksheet1->write_number($iFilaExcel,11,number_format($fAjusteCargo,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,12,number_format($fAjusteSeguro,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,13,number_format($fAjusteDeb,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,14,number_format($fAjusteCred,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,15,number_format($rs['fAcumuladoIVAAjusteDebito'],2,'.',''));
	  $worksheet1->write_number($iFilaExcel,16,number_format($rs['fAcumuladoIVAAjusteCredito'],2,'.',''));
	  $worksheet1->write_number($iFilaExcel,17,number_format($fCobranzas,2,'.',''));	  
 	  $worksheet1->write_number($iFilaExcel,18,number_format($fImporteTotalPesos,2,'.',''));
 	  $worksheet1->write_number($iFilaExcel,19,number_format($aDatos['fAcumuladoCobranzas'],2,'.',''));
 	  
 	  $fTotalConsumos +=$fAcumuladoConsumoUnPago;
		$fTotalBonificaciones +=$fAjusteBonif;
		$fTotalIntFin +=$rs['fInteresFinanciacion'];
		$fTotalIntPun +=$rs['fInteresPunitorio'];
		$fTotalGastosAdmin +=$fAjusteCargo;
		$fTotalSegVida +=$fAjusteSeguro;
		$fTotalAjustesDeb +=$fAjusteDeb;
		$fTotalAjustesCred +=$fAjusteCred;
		$fTotalIvaDeb +=$rs['fAcumuladoIVAAjusteDebito'];
		$fTotalIvaCred +=$rs['fAcumuladoIVAAjusteCredito'];;
		$fTotalCobranzas +=$fCobranzas;		
		$fTotalPagar +=$fImporteTotalPesos;
		$fTotalAcumuladoCobranzas += $aDatos['fAcumuladoCobranzas'];
		//if($rs['idTipoEstadoCuenta'] != 12) $fCantidadCuentasNoBajas++;
  } 
  $iFilaExcel++;
   $worksheet1->write_string($iFilaExcel,0,'');
	  $worksheet1->write_string($iFilaExcel,1,'');
	  $worksheet1->write_string($iFilaExcel,2,'');
	  $worksheet1->write_string($iFilaExcel,3,'');
	  $worksheet1->write_string($iFilaExcel,4,'');
	  $worksheet1->write_string($iFilaExcel,5,'');
	  $worksheet1->write_string($iFilaExcel,6,'TOTALES');
	  $worksheet1->write_number($iFilaExcel,7,number_format($fTotalConsumos,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,8,number_format($fTotalBonificaciones,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,9,number_format($fTotalIntFin,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,10,number_format($fTotalIntPun,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,11,number_format($fTotalGastosAdmin,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,12,number_format($fTotalSegVida,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,13,number_format($fTotalAjustesDeb,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,14,number_format($fTotalAjustesCred,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,15,number_format($fTotalIvaDeb,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,16,number_format($fTotalIvaCred,2,'.',''));
	  $worksheet1->write_number($iFilaExcel,17,number_format($fTotalCobranzas,2,'.',''));	  
 	  $worksheet1->write_number($iFilaExcel,18,number_format($fTotalPagar,2,'.',''));
 	  $worksheet1->write_number($iFilaExcel,19,number_format($fTotalAcumuladoCobranzas,2,'.',''));
 	  
 
  $workbook->close();
?>				