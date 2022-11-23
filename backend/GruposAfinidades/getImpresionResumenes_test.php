<?php
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$aParametros = array();
$aParametros = getParametrosBasicos(1);	
	
//$sSelect = " select id from CuentasUsuarios where idTipoEstadoCuenta = 1;";
//$aCuentas = $oMysql->consultaSel($sSelect);
$aCuentas = explode(",",$_POST['sCuentas']);
$idGrupoAfinidad = $_SESSION['idGrupoAfinidadImpresion'];
$dPeriodo = $_SESSION['dPeriodoImpresion'];

//echo $_POST['sCuentas'];
$sTablaFinal = "";
$sTabla = "";
foreach ($aCuentas as $idCuentaUsuario){			
	//$sNumeroCuenta = $oMysql->consultaSel("SELECT sNumeroCuenta FROM CuentasUsuarios WHERE id={$idCuentaUsuario}",true);

	$aParametros['TABLA_DATOS'] ='';
	$aParametros['IMPORTE_TOTAL'] ='';
	$aParametros['CODIGO_BARRA'] ='';
	
	$aPeriodo = explode("-",$dPeriodo);
	$dPeriodoFormat = $aPeriodo[1]."-".$aPeriodo[0];
	$mesAnterior = $aPeriodo[1]-1;
	$dPeriodoAnterior = $aPeriodo[0]."-".$mesAnterior."-01 00:00:00";
		
	$archivo = "../includes/Files/Datos/".$dPeriodoFormat."/DR_".$idGrupoAfinidad."_".$idCuentaUsuario."_".$dPeriodoFormat.".xml"; 
	//$archivo = "../includes/Files/Datos/DR_".$idCuentaUsuario."_".$dPeriodoFormat.".xml"; 
	$sTabla ="";
	$sTitular = "";
	if (file_exists($archivo)){
		$oXml = simplexml_load_file($archivo);
	}else{
		$archivo1 = "../includes/Files/".$dPeriodoFormat."/DR_3_".$idCuentaUsuario."_".$dPeriodoFormat.".xml"; 
		if (file_exists($archivo1)){
			$oXml = simplexml_load_file($archivo1);
		}else{			
			$archivo2 = "../includes/Files/".$dPeriodoFormat."/DR_2_".$idCuentaUsuario."_".$dPeriodoFormat.".xml"; 
			if (file_exists($archivo2))
				$oXml = simplexml_load_file($archivo2);
			else
				$msje = "No existe xml";			
		}
			
	}
	
	//echo $archivo;
	//$sDomicilio = html_entity_decode($oXml->sDomicilio);
	$sDomicilio = utf8_decode($oXml->sDomicilio);
	
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
	$aParametros['LIMITE_ADELANTO'] = $oXml->fLimiteAdelanto;
	
	$sCondicionCalendario = " WHERE CalendariosFacturaciones.idGrupoAfinidad={$idGrupoAfinidad} AND CalendariosFacturaciones.dPeriodo='{$dPeriodoAnterior}'";
	$aDatosPeriodoAnterior = $oMysql->consultaSel("CALL usp_getCalendarioFacturacion(\"$sCondicionCalendario\")",true);
	if(sizeof($aDatosPeriodoAnterior)>0){
		$aParametros['FECHA_CIERRE_ANTERIOR'] = $aDatosPeriodoAnterior['dFechaCierre'];
		$aParametros['FECHA_VTO_ANTERIOR'] = $aDatosPeriodoAnterior['dFechaVencimiento'];
	}else{
		$aParametros['FECHA_CIERRE_ANTERIOR'] ="-";
		$aParametros['FECHA_VTO_ANTERIOR'] ="-";
	}
	
	//rules='all' border='1'
	$sHeaderTabla = "<tr><td>Compras Financiadas</td><td>Sucursal</td><td>Fecha</td><td>Nro.Cuota</td><td>Nro.Cupon</td><td align='right'>Importe</td></tr>";
	$sTabla = "<table id='TablaDatos' cellpadding='0' cellspacing='0' width='100%' style='font-family:Arial;font-size:10px;' >
				{$sHeaderTabla}
				<tr><td style='width:170px;height:10px;padding-left:10px;'>&nbsp;</td><td style='width:160px;'>&nbsp;</td><td style='width:70px;'>&nbsp;</td><td style='width:40px;'>&nbsp;</td><td style='width:40px;'>&nbsp;</td><td style='width:55px;' align='right'>&nbsp;</td></tr>";
	//$fTotal = 0;	
	$sFilaSaldo = "";
	$sFilaSaldo .= "<tr><td style='font-size:9px'>SALDO ANTERIOR</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align='right'>".number_format((double)$oXml->fSaldoAnterior,2,'.','')."</td></tr>";
	/*foreach ($oXml->detalle as $aDetalle) {
		
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
				<td align='right'>".$signo.number_format($aDetalle->fImporte,2,'.','')."</td>
				</tr>";			
		//$fTotal += $aDetalle->fImporte;
	}		
	$sTabla .= "</table>";
	$aParametros['TABLA_DATOS'] = $sTabla;*/
	
	
	
	
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
					SELECT distinct
			            Sucursales.sLeyenda
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
		
		/*if($rsSucursales)
		{
			$idSucursal = $rsSucursales[0]['idSucursal'];
			$idProvincia = $rsSucursales[0]['idProvincia'];
			$idRegion = $rsSucursales[0]['idRegion'];
			
			//echo "idRegion: " . $idRegion;
			//echo "idProvincia: " . $idProvincia;
			
			if($idRegion == 4) // NEA
			{
				$aParametros['LEYENDA'] = "F.A.P. Cta. 17304";
			}
			else if($idProvincia == 8196 || $idProvincia == 8039) //8196=Tucuman, 8039=Santiago del Estero
			{
				$aParametros['LEYENDA'] = "F.A.P. Cta. 17304";
			}
		}*/
		
		//-------------------------------------------------------------------------------------------------------------------------------------------
	
	
	
	
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
			$iCantidadPagina=2; 
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
	/*if($nuevaPagina)
		$sFilas1 .= "<tr><td colspan='6'>Pagina 1/2</td></tr>";*/
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
	//echo $sCodigo;
	$aParametros['CODIGO_BARRA'] = $sCodigo;
	
	$aParametros['MOSTRAR_NUMERO_VERIFICACION'] = "style='display:none'";
	$idTipoEstadoTarjeta = $oMysql->consultaSel("SELECT idTipoEstadoTarjeta FROM Tarjetas WHERE Tarjetas.idCuentaUsuario={$idCuentaUsuario} ORDER BY dFechaRegistro DESC LIMIT 0,1",true);
	if($idTipoEstadoTarjeta != 5){ //Tarjeta que no estan en Pendiende de Habilitacion
		$sNumeroValidacion = $oMysql->consultaSel("SELECT sNumeroValidacion FROM CuentasUsuarios WHERE CuentasUsuarios.id={$idCuentaUsuario}",true);
		$aParametros['MOSTRAR_NUMERO_VERIFICACION'] = "style='display:inline'";
		$aParametros['NUMERO_VERIFICACION'] = $sNumeroValidacion;
	}
		
	$sTablaFinal.= parserTemplate( INCLUDES_DIR . "/Files/Modelos/MR_1.tpl",$aParametros);
	$sTablaFinal.="<div  id='saltopagina' style='display:block;page-break-before:always;' /></div>";
	
	$sTabla2 = "";
	if($nuevaPagina){
		$aParametros['PAGINA'] = "Pagina 2/".$iCantidadPagina;
		//$sFilas2 .= "<tr><td colspan='6'>Pagina 2/2</td></tr>";
		
		$sTabla2 = $sTabla . $sFilas2. "</table>";
		$aParametros['TABLA_DATOS'] = $sTabla2;
		$sTablaFinal.= "<p></p>".parserTemplate( INCLUDES_DIR . "/Files/Modelos/MR_1.tpl",$aParametros);
		$sTablaFinal.="<div  id='saltopagina' style='display:block;page-break-before:always;' /></div>";
	}
}




//$sCUERPO_GENERAL=$sTablaFinal;

//echo $sCUERPO_GENERAL;
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

	
xhtmlHeaderPaginaGeneral($aParametros);	
?>
<body style="background-color:#FFFFFF;">
<div id="BODY">
<center>
	<input type="button" id="btnImprimir" name="btnImprimir" value="Imprimir Resumenes" onclick="window.print()" style="width:200px;height:50px" />
	<input type="button" id="btnVolver" name="btnVolver" value="Volver" onclick="window.location ='ImpresionResumenes.php'" style="width:100px;height:50px" />
</center>
</div>
<?
//echo $sTablaFinal;
$aParametros['ToPrint']= $sTablaFinal;
echo xhtmlFootPagina($aParametros);
?>