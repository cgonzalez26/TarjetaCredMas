<?php
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$sSelect = " select CuentasUsuarios.id from CuentasUsuarios left join DetallesCuentasUsuarios ON DetallesCuentasUsuarios.idCuentaUsuario=CuentasUsuarios.id
             where idTipoEstadoCuenta = 1 and DetallesCuentasUsuarios.dPeriodo ='2011-09-01 00:00:00' ";//limit 150,180;
$aCuentas = $oMysql->consultaSel($sSelect);
//$aCuentas = explode(",",$sCuentas);


$idd = count($aCuentas);
$sTablaFinal = "";
$i = 0;
foreach ($aCuentas as $idCuentaUsuario){	
	$aParametros = array();
	$aParametros['TABLA_DATOS'] ='';
	$aParametros['IMPORTE_TOTAL'] ='';
	$aParametros['CODIGO_BARRA'] ='';
	
	//inicio el buffer de salida 
	ob_start(); 
	
	
	//limpio el buffer de salida 
	ob_clean(); 
	
	
	
	//limpio el buffer de salida y lo deshabilito 
	ob_end_clean(); 
	
	
	if($i <= $idd){//150
			$aPeriodo = explode("-",$dPeriodo);
			$dPeriodoFormat = $aPeriodo[1]."-".$aPeriodo[0];
			$archivo = "../includes/Files/Datos/DR_2_".$idCuentaUsuario."_09-2011.xml"; 
			$sTabla ="";
			$sTitular = "";
			if (file_exists($archivo)) 	{
				$oXml = simplexml_load_file($archivo);
			}else{
				$msje = "No existe xml";
			}
			
			$sDomicilio = html_entity_decode($oXml->sDomicilio);
			$aParametros['ID_CUENTA'] = $idCuentaUsuario;
			$idGrupoAfinidad = $oXml->idGrupoAfinidad;				
			$aParametros['TITULAR'] = $oXml->sTitular;
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
			
			$sTabla .= "<table id='TablaDatos' cellpadding='0' cellspacing='0' width='100%' style='font-family:Arial;font-size:10px;' >
						<tr><td style='width:170px;height:30px;padding-left:10px;'>&nbsp;</td><td style='width:160px;'>&nbsp;</td><td style='width:70px;'>&nbsp;</td><td style='width:40px;'>&nbsp;</td><td style='width:40px;'>&nbsp;</td><td style='width:55px;' align='right'>&nbsp;</td></tr>";
			
			
			$sTabla .= "<tr><td style='font-size:9px'>SALDO ANTERIOR</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align='right'>".number_format((double)$oXml->fSaldoAnterior,2,'.','')."</td></tr>";
			foreach ($oXml->detalle as $aDetalle) {
				
				$sNumeroCupon = $aDetalle->sNumeroCupon;				
				$sNumeroCuota =$aDetalle->sNumeroCuota."/".$aDetalle->sCantidadCuota;
				if($aDetalle->sNumeroCupon == "") $sNumeroCupon="&nbsp;";
				if($aDetalle->sNumeroCuota == "") $sNumeroCuota="&nbsp;";
				
				$signo = "";				
				if($aDetalle->tipoOperacion == "4" || $aDetalle->tipoOperacion == "2") $signo = "-";
				
				$sTabla .= "<tr>
						<td style='padding-peft:3px;font-size:9px'>{$aDetalle->sDescripcion}</td>
						<td style='padding-peft:3px;font-size:9px'>{$aDetalle->sSucursal}</td>
						<td>{$aDetalle->dFechaOperacion}</td>
						<td>{$sNumeroCuota}</td>
						<td>{$sNumeroCupon}</td>
						<td align='right'>".$signo.number_format((double)$aDetalle->fImporte,2,'.','')."</td>
						</tr>";			
				
			}		
			$sTabla .= "</table>";
			$aParametros['TABLA_DATOS'] = $sTabla;
			$aParametros['IMPORTE_TOTAL'] = "$ ".$oXml->fTotalResumen;
			if($oXml->fTotalResumen < 0)
				$oXml->fTotalResumen = 0;
			$sCodigo = generarCodigoBarraBSE($oXml->sNumeroCuentaUsuario,$oXml->fTotalResumen,$oXml->dFechaVencimiento);
			$aParametros['CODIGO_BARRA'] = $sCodigo;
			
			echo  parserTemplate( INCLUDES_DIR . "/Files/Modelos/MR_1.tpl",$aParametros);
			echo "<div  id='saltopagina' style='display:block;page-break-before:always;' /></div>";
			$i++;
	}
	ob_end_flush(); 
}

/*
$html =
    '<html>
    <head>
    <style type="text/css">
	body{
	margin-top:5px;
	margin-left:30px;
	margin-right:5px;
	margin-bottom:5px;
	}
	
	</style>
    
    </head>
    <body>
  
	
    '.$sCUERPO_GENERAL.'
    
	</body>
	</html>';
    

//echo $html;die();
    
$sNombreArchivo='Resumenes-'.date('d-m-y').'.pdf';

$dompdf = new DOMPDF();
$dompdf->set_paper('a4');
$dompdf->load_html($html);

$dompdf->render();
$dompdf->stream($sNombreArchivo,array()); // si es una sola pagina se descarga y no se comprime
$pdf = $dompdf->output();

/*

$sUrl="Resumenes/{$sNombreArchivo}";
$sFile=file_put_contents($sUrl, $pdf);


$nom_arxiu=$sNombreArchivo;

$fptr = fopen($sUrl, "rb");
$dump = fread($fptr, filesize($sUrl));
fclose($fptr);
//Comprime al máximo nivel, 9
$gzbackupData = gzencode($dump,9);

$fptr = fopen($sUrl.".gz", "wb");
fwrite($fptr, $gzbackupData);
fclose($fptr);

header('Content-Type: application/force-download');
header('Content-disposition: attachment; filename='.$sUrl.'.gz');
header("Content-Transfer-Encoding: binary");
$fp=fopen($sUrl.".gz", "r");
fpassthru($fp);
exit();	*/

?>