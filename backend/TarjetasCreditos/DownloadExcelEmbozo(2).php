<?php
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$aParam=array();
global $oMysql;
$idLote = $_GET['id'];

include_once( CLASSES_DIR . '/excel.php' );
include_once( CLASSES_DIR . '/write_excel/Worksheet.php' );
include_once( CLASSES_DIR . '/write_excel/Workbook.php' );


$aCond[]=" LotesTarjetas.idLoteEmbosaje = {$idLote}";
$CampoOrden = "id";	 
$sCondiciones= " LEFT JOIN LotesTarjetas ON LotesTarjetas.idTarjeta = Tarjetas.id WHERE " . implode(' AND ',$aCond)."  ORDER BY $CampoOrden DESC";
	
$sConsulta="Call usp_getTarjetas(\"$sCondiciones\");";
	
$aFilas = $oMysql->consultaSel($sConsulta);

$nomExcel ='LoteEmbozo'.'_'.date('d-m-Y').'_'.$idLote.'.xls';

/*
$xls = new Excel(); 
$xls->addRow(Array("Nro.Tarjeta","Titular","Fecha Inicio","Fecha Vencimiento","CVC","Track1","Track2")); //EXCEL

foreach ($aFilas as $rs){
	$sUsuario = "";
	if($rs['iTipoPersona'] == 1)
		$sUsuario .= $rs['sApellido'].' '.$rs['sNombre'];
	else 	
		$sUsuario .= $rs['sRazonSocial'];
	$aVigenciaDesde = explode("/",$rs['dVigenciaDesde']);
 	$aVigenciaHasta = explode("/",$rs['dVigenciaHasta']);
 	$sFechaDesde = $aVigenciaDesde[1]."/".$aVigenciaDesde[2];
 	$sFechaHasta = $aVigenciaHasta[1]."/".$aVigenciaHasta[2];
 	$rs['sNumeroTarjeta'] = trim($rs['sNumeroTarjeta']);
 	$sNumeroTarjetaConSeparador = substr($rs['sNumeroTarjeta'],0,4)." ".substr($rs['sNumeroTarjeta'],4,4)." ".substr($rs['sNumeroTarjeta'],8,4)." ".substr($rs['sNumeroTarjeta'],12,4);
 	
 	if(strlen($sUsuario)>=26){
 		$sUsuarioTrack1 = substr($sUsuario,0,25)." "; //cortamos el nombre a 26 caracteres
 	}else{
 		$sUsuarioTrack1 = str_pad($sUsuario,26," ",STR_PAD_RIGHT); //rellenamos el nombre a 26 caracteres	
 	}
 	
 	
 	
 	$dFechaVto = substr($aVigenciaHasta[2],2,3).$aVigenciaHasta[1];
 	
 	$track1 = "B{$rs['sNumeroTarjeta']}^{$sUsuarioTrack1}^{$dFechaVto}"; 	
 	$track2 = "{$rs['sNumeroTarjeta']}={$dFechaVto}";
 	
 	$xls->addRow(Array("$sNumeroTarjetaConSeparador","$sUsuario","$sFechaDesde","$sFechaHasta","{$rs['sCodigoSeguridad']}","$track1","$track2"));
	
} 
$xls->download("$nomExcel");
exit();	*/


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
  
  $worksheet1 =& $workbook->add_worksheet('');

  // Format for the headings
  $formatot =& $workbook->add_format();
  $formatot->set_size(11);
  $formatot->set_align('center');
  $formatot->set_color('black');
  $formatot->set_pattern();
  $formatot->set_fg_color('gray');
  
  $worksheet1->write_string(0,0,"Nro.Tarjeta",$formatot);
  $worksheet1->write_string(0,1,"Titular",$formatot);
  $worksheet1->write_string(0,2,"Fecha Inicio",$formatot);
  $worksheet1->write_string(0,3,"Fecha Vencimiento",$formatot);
  $worksheet1->write_string(0,4,"CVC",$formatot);
  $worksheet1->write_string(0,5,"Track1",$formatot);
  $worksheet1->write_string(0,6,"Track2",$formatot);
 
  $iFilaExcel=0;
  foreach ($aFilas as $rs){
	$sUsuario = "";
	if($rs['iTipoPersona'] == 1)
		$sUsuario .= $rs['sApellido'].' '.$rs['sNombre'];
	else 	
		$sUsuario .= $rs['sRazonSocial'];
	$aVigenciaDesde = explode("/",$rs['dVigenciaDesde']);
 	$aVigenciaHasta = explode("/",$rs['dVigenciaHasta']);
 	$sFechaDesde = $aVigenciaDesde[1]."/".$aVigenciaDesde[2];
 	$sFechaHasta = $aVigenciaHasta[1]."/".$aVigenciaHasta[2];
 	$rs['sNumeroTarjeta'] = trim($rs['sNumeroTarjeta']);
 	$sNumeroTarjetaConSeparador = substr($rs['sNumeroTarjeta'],0,4)." ".substr($rs['sNumeroTarjeta'],4,4)." ".substr($rs['sNumeroTarjeta'],8,4)." ".substr($rs['sNumeroTarjeta'],12,4);
 	
 	if(strlen($sUsuario)>=26){
 		$sUsuarioTrack1 = substr($sUsuario,0,25)." "; //cortamos el nombre a 26 caracteres
 	}else{
 		$sUsuarioTrack1 = str_pad($sUsuario,26," ",STR_PAD_RIGHT); //rellenamos el nombre a 26 caracteres	
 	}

 	$dFechaVto = substr($aVigenciaHasta[2],2,3).$aVigenciaHasta[1];
 	
 	$track1 = "B".$rs['sNumeroTarjeta']."^".$sUsuarioTrack1."^".$dFechaVto; 	
 	$track2 = "{$rs['sNumeroTarjeta']}={$dFechaVto}";
	
 	  $iFilaExcel++;
 	  $worksheet1->write_string($iFilaExcel,0,$sNumeroTarjetaConSeparador);
	  $worksheet1->write_string($iFilaExcel,1,$sUsuario);
	  $worksheet1->write_string($iFilaExcel,2,$sFechaDesde);
	  $worksheet1->write_string($iFilaExcel,3,$sFechaHasta);
	  $worksheet1->write_string($iFilaExcel,4,$rs['sCodigoSeguridad']);
	  $worksheet1->write_string($iFilaExcel,5,$track1);
	  $worksheet1->write_string($iFilaExcel,6,$track2);
 	
  } 
  $workbook->close();
?>				