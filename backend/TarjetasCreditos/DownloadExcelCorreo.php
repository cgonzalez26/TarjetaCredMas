<?php
define( 'BASE' , dirname( __FILE__ ) . '/../..');

include_once(  BASE . '/_global.php' );
$aParam=array();
global $oMysql;
$idLote = $_GET['id'];

$aCond[]=" LotesCorreosTarjetas.idLoteCorreo = {$idLote}";
$CampoOrden = "id";	 
$sCondiciones= " LEFT JOIN LotesCorreosTarjetas ON LotesCorreosTarjetas.idTarjeta = Tarjetas.id WHERE " . implode(' AND ',$aCond)."  ORDER BY $CampoOrden DESC";
$sConsulta="Call usp_getTarjetas(\"$sCondiciones\");";	

$aFilas = $oMysql->consultaSel($sConsulta);

$rsLote = $oMysql->consultaSel("SELECT sNumeroPedido, DATE_FORMAT(dFechaRegistro, '%d/%m/%Y') as 'dFechaRegistro' FROM LotesCorreos WHERE id={$idLote}",true);

$nomExcel ='LoteCorreo'.'_'.date('d-m-Y').'_'.$idLote;

header("Content-Type: application/vnd.ms-excel"); 
header( 'Content-Disposition: attachment; filename="'.$nomExcel.'.xls"' );
header('Cache-Control: private, must-revalidate'); 
header('Pragma: private'); // allow private caching 

$excel=new ExcelWriter();
echo $excel->GetHeader();

echo "<tr>";
echo "<td width=120><b>NroTarjeta</b></td>";
echo "<td width=180><b>Titular</b></td>";
echo "<td width=150><b>Domicilio</b></td>";
echo "<td width=110><b>Barrio</b></td>";
echo "<td width=80><b>Localidad</b></td>";
echo "<td width=80><b>Provincia</b></td>";
echo "<td width=80><b>C.P.</b></td>";
echo "</tr>";	

foreach ($aFilas as $rs){
	$sUsuario = "";
	if($rs['iTipoPersona'] == 1)
		$sUsuario .= $rs['sApellido'].', '.$rs['sNombre'];
	else 	
		$sUsuario .= $rs['sRazonSocial'];		
 	
 	$sDomicilio = "";
 	$sCondicion=" WHERE CuentasUsuarios.id = {$rs['idCuentaUsuario']}";
	$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondicion\");";		
	$rsCuenta = $oMysql->consultaSel($sqlDatos,true);
	if($rsCuenta){
		if($rsCuenta['sCalle'] !="")$sDomicilio .= "Calle:".$rsCuenta['sCalle'];
		
		if(($rsCuenta['sNumeroCalle'] != "")&&($rsCuenta['sNumeroCalle'] != "0")){
			if($sDomicilio != "") $sDomicilio .= " ";			
			$sDomicilio .= "Nro:".$rsCuenta['sNumeroCalle'];				
		}
		if(($rsCuenta['sBlock'] != "")&&($rsCuenta['sBlock'] != "0")){
			if($sDomicilio != "") $sDomicilio .= " ";			
			$sDomicilio .= "Block:".$rsCuenta['sBlock'];
		}
		
		if(($rsCuenta['sPiso'] != "")&&($rsCuenta['sPiso'] != "0")){
			if($sDomicilio != "") $sDomicilio .= " ";
			$sDomicilio .= "Piso:".$rsCuenta['sPiso'];
		}
		
		if(($rsCuenta['sDepartamento'] != "")&&($rsCuenta['sDepartamento'] != "0")){
			if($sDomicilio != "") $sDomicilio .= " ";
			$sDomicilio .= "Dpto:".$rsCuenta['sDepartamento'];			
		}
		
		if(($rsCuenta['sManzana'] != "")&&($rsCuenta['sManzana'] != "0")){
			if($sDomicilio != "") $sDomicilio .= " ";
			$sDomicilio .= "Mza:".$rsCuenta['sManzana'];
		}
		if(($rsCuenta['sLote'] != "")&&($rsCuenta['sLote'] != "0")){
			if($sDomicilio != "") $sDomicilio .= " ";
			$sDomicilio .= "Lote:".$rsCuenta['sLote'];	
		}
	}
	$rsCuenta['sBarrio']= strtoupper($rsCuenta['sBarrio']);
	$rsCuenta['sLocalidad']=strtoupper($rsCuenta['sLocalidad']);
	$rsCuenta['sProvincia']=strtoupper($rsCuenta['sProvincia']);
	$sDomicilio = html_entity_decode($sDomicilio);
	$rsCuenta['sBarrio'] = html_entity_decode($rsCuenta['sBarrio']);
	echo "<tr>";
	echo "<td class=xl24 style='border: solid 1px #000; '> {$rs['sNumeroTarjeta']}</td>";
	echo "<td class=xl24 style='border: solid 1px #000; '> {$sUsuario} </td>";
	echo "<td class=xl24 style='border: solid 1px #000; '> {$sDomicilio} </td>";
	echo "<td class=xl24 style='border: solid 1px #000; '> {$rsCuenta['sBarrio']} </td>";
	echo "<td class=xl24 style='border: solid 1px #000; '> {$rsCuenta['sLocalidad']} </td>";
	echo "<td class=xl24 style='border: solid 1px #000; '> {$rsCuenta['sProvincia']} </td>";
	echo "<td class=xl24 style='text-align:right;border: solid 1px #000; '> {$rsCuenta['sCodigoPostal']} </td>";
	echo "</tr>";                                  
} 

echo $excel->GetFooter();
exit();	
?>				