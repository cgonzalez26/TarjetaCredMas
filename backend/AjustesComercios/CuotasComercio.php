<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();

	#Control de Acceso al archivo
	//if(!isLogin())
	//{
		//go_url("/index.php");
	//}
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);		

	xhtmlHeaderPaginaGeneral($aParametros);		
	
	$idAjuste = $_GET['idAjusteComercio'];		
	$iPlanPromo = $_GET['iPlanPromo'];		
	
	
	
	#obtengo datos de la liquidaciones(cabecera)
	#___________________________________________________
	
	$sub_query = " WHERE AjustesComercios.id = $idAjuste";
	
	$SQL = "Call usp_getAjustesComercios(\"$sub_query\",\"$iPlanPromo\");";
	
	$Ajustes = $oMysql->consultaSel( $SQL , true);	
	//--------------------------------------------------
	
	
	$sCondiciones = "WHERE DetallesAjustesComercios.idAjusteComercio=".$idAjuste;
	
	$sqlDatos="Call usp_getDetallesAjustesComerios(\"$sCondiciones\");";
	//$CantReg = $oMysql->consultaSel($sqlCuenta,true); 

	$result = $oMysql->consultaSel($sqlDatos);

	
	$sFila = 
	"	<table border='0' style='font-size:12px;'>
		<tr><td>COMERCIO: {$Ajustes['sRazonSocial']}</td></tr>
		<tr><td>Fecha Asiento: {$Ajustes['dFecha']}</td></tr>
		<tr><td>Codigo: {$Ajustes['sCodigo']}</td></tr>
		</table>
		<br><br>
		<center>
		<div style='height:300px; overflow:auto;'>			
		<table width='400px'   class='TablaCalendario'>
		<tr class='filaPrincipal'>
			<th class='borde' style='height:10px'>Cuota</th>			
			<th class='borde' style='height:10px'>Importe</th>
			<th class='borde' style='height:10px'>Interes</th>
			<th class='borde' style='height:10px'>IVA</th>		
			<th class='borde' style='height:15px'>Fecha Liquidacion.</th>
		</tr>";
	
	$sScript = "<script type='text/javascript'>";		
	//$sCerrar = "<br><div style='text-align:right;'><a href='javascript:_closeWindow();'>[X]</a></div><br />";
	$sCerrar = "";
	
	$i = 1;
	foreach ($result as $rs )
	{
		if($rs['dFechaFacturacionComercio'] == '00/00/0000')
		{
			$Fecha = "__/__/____";			
		}
		else 
		{
			$Fecha = $rs['dFechaFacturacionComercio'];
		}
		
		$sScript .= "InputMask('dFechaFacturacion".$i."','99/99/9999');";
		
		$sFila .= 
		"<tr>
			<td id='tdPeriodo".$i."'>
				<input class='textTabla' type='text' style='width:50px' id='iCuota".$i."' name='iCuota".$i."' readonly />".$rs['iNumeroCuota']."					
				<input class='textTabla' type='hidden' name='idCalendario".$i."'  id='idCalendario".$i."' value='0'>
			</td>
			<td ><input class='textTabla' type='text' style='width:80px' id='fImporte".$i."' name='fImporte".$i."' onblur='this.value=numero_parse_flotante(this.value)' value='".$rs['fImporteCuota']."' readonly />
			</td>				
			<td ><input class='textTabla' type='text' style='width:80px'  id='fImporteInteres".$i."' name='fImporteInteres".$i."' 
				onblur='this.value=numero_parse_flotante(this.value)' value='".$rs['fImporteInteres']."' readonly/>
			</td>
			<td ><input class='textTabla' type='text' style='width:80px' id='fImporteIVA".$i."' name='fImporteIVA".$i."' onblur='this.value=numero_parse_flotante(this.value)' value='".$rs['fImporteIVA']."' readonly/>
			</td>			
			<td ><input class='textTabla' type='text' style='width:100px' id='dFechaFacturacion".$i."' readonly 
			name='dFechaFacturacion".$i."' onblur='this.value=validarFecha(this.value)' value='".$Fecha."'/>
			</td>
		</tr>";
		
		$i+=1;
	}
					
	
	$sFila .= "</table></div></center>";
	$sScript .= "</script>";
	
	echo $sCerrar . $sFila . $sScript . "</div>";	
?>