<?php
session_start();
define( 'BASE' , dirname( __FILE__ ) . '/../..');

include_once(  BASE . '/_global.php' );

$idUser = $_SESSION['ID_USER'];
$TypeUser = $_SESSION['TYPE_USER'];	

	#Control de Acceso al archivo
	if(!isLogin()){go_url("/index.php");}
	
function imprimirHeaderExcel($dFechaCobro1,$dFechaCobro2,$dFechaCobro3){
	echo "<tr>";		
	echo "<td class=xl24 colspan=1 style='border: solid 1px #000;'> <b>Clientes</b> </td>";
	echo "<td class=xl24 colspan=1 style='border: solid 1px #000;'> <b>Monto</b> </td>";
	echo "<td class=xl24 colspan=1 style='border: solid 1px #000;'> <b>{$dFechaCobro1}</b> </td>";
	echo "<td class=xl24 colspan=1 style='border: solid 1px #000;'> <b>{$dFechaCobro2}</b> </td>";
	echo "<td class=xl24 colspan=1 style='border: solid 1px #000;'> <b>{$dFechaCobro3}</b> </td>";
	echo "</tr>";	
}

function imprimirClientesCobrosExcel($array){
	if(count($array)>0)
	{
		foreach ($array as $row){
			$fMontoPago1 = "";
			if($row['fMontoPago1'] != 0) 
				if((int)$row['fMontoPago1'] == $row['fMontoPago1'])
					$fMontoPago1 = number_format($row['fMontoPago1'], 0, '.', '');
				else
					$fMontoPago1 = number_format($row['fMontoPago1'], 2, '.', '');

			$fMontoPago2 = "";
			if($row['fMontoPago2'] != 0) 
				if((int)$row['fMontoPago2'] == $row['fMontoPago2'])
					$fMontoPago2 = number_format($row['fMontoPago2'], 0, '.', '');
				else
					$fMontoPago2 = number_format($row['fMontoPago2'], 2, '.', '');
			$fMontoPago3 = "";
			if($row['fMontoPago3'] != 0) 
				if((int)$row['fMontoPago3'] == $row['fMontoPago3'])
					$fMontoPago3 = number_format($row['fMontoPago3'], 0, '.', '');
				else
					$fMontoPago3 = number_format($row['fMontoPago3'], 2, '.', '');
			if((int)$row['fMonto'] == $row['fMonto'])
				$row['fMonto'] = number_format($row['fMonto'], 0, '.', '');
			else
				$row['fMonto'] = number_format($row['fMonto'], 2, '.', '');		
				
			echo "<tr>";		
			echo "<td class=xl24 colspan=1 style='border: solid 1px #000;'>".stripslashes($row['sCliente'])."</td>";
			echo "<td class=xl24 colspan=1 style='border: solid 1px #000;'>".stripslashes($row['fMonto'])."</td>";
			echo "<td class=xl24 colspan=1 style='border: solid 1px #000;'>".$fMontoPago1."</td>";						
			echo "<td class=xl24 colspan=1 style='border: solid 1px #000;'>".$fMontoPago2."</td>";
			echo "<td class=xl24 colspan=1 style='border: solid 1px #000;'>".$fMontoPago3."</td>";
			echo "</tr>";					
			
		}
	}
}
// EXCEL ------------------------------------------------	

$sTitulo="COBRANZA - " .$_POST['hdnCodigo'];
header( 'Content-disposition: attachment; filename="'.$sTitulo.'.xls"' );
header( 'Content-Type: application/ms-excel' );

$excel=new ExcelWriter();
echo $excel->GetHeader();

$dFecha=date('d/m/Y');

	echo "<tr><td class=xl24 colspan=5 style='border: solid 1px #000;'>CODIGO: ".$_POST['hdnCodigo']."</td></tr>";
	echo "<tr><td class=xl24 colspan=5 style='border: solid 1px #000;'></td></tr>";		
	/*************** DIARIOS **************/
	$arrayDiarios=array();
	$sConditions = "DetallesPlanillasCobranzas.idPlanillaCobranza='{$_POST['idCobranza']}' AND DetallesPlanillasCobranzas.idPlanPago='1'";
	
	$arrayDiarios=$oMysql->consultaSel("CALL usp_getDetallesPlanillasCobranzas(\"$sConditions\",\"\",\"\",\"\");");
	echo "<tr>";		
	echo "<td class=xl24 colspan=5 style='border: solid 1px #000;'> <b>DIARIOS</b> </td>";
	echo "</tr>";
	
	imprimirHeaderExcel($_POST['hdnFechaCobro1'],$_POST['hdnFechaCobro2'],$_POST['hdnFechaCobro3']);
	imprimirClientesCobrosExcel($arrayDiarios);

	/*************** SEMANALES **************/
	$arraySemanales=array();
	$sConditions = "DetallesPlanillasCobranzas.idPlanillaCobranza='{$_POST['idCobranza']}' AND DetallesPlanillasCobranzas.idPlanPago='2'";
	
	$arraySemanales=$oMysql->consultaSel("CALL usp_getDetallesPlanillasCobranzas(\"$sConditions\",\"\",\"\",\"\");");
	echo "<tr><td class=xl24 colspan=5 style='border: solid 1px #000;'></td></tr>";	
	echo "<tr>";		
	echo "<td class=xl24 colspan=5 style='border: solid 1px #000;'> <b>SEMANALES</b> </td>";
	echo "</tr>";	
	imprimirHeaderExcel($_POST['hdnFechaCobro1'],$_POST['hdnFechaCobro2'],$_POST['hdnFechaCobro3']);
	imprimirClientesCobrosExcel($arraySemanales);
	
	/*************** MENSUALES **************/
	$arrayAnuales=array();
	$sConditions = "DetallesPlanillasCobranzas.idPlanillaCobranza='{$_POST['idCobranza']}' AND DetallesPlanillasCobranzas.idPlanPago='3'";
	
	$arrayAnuales=$oMysql->consultaSel("CALL usp_getDetallesPlanillasCobranzas(\"$sConditions\",\"\",\"\",\"\");");
	echo "<tr><td class=xl24 colspan=5 style='border: solid 1px #000;'></td></tr>";	
	echo "<tr>";		
	echo "<td class=xl24 colspan=5 style='border: solid 1px #000;'> <b>MENSUALES</b> </td>";
	echo "</tr>";
	
	imprimirHeaderExcel($_POST['hdnFechaCobro1'],$_POST['hdnFechaCobro2'],$_POST['hdnFechaCobro3']);
	imprimirClientesCobrosExcel($arrayAnuales);	
	echo "</table>";
	
	//$fTotal=$oMysql->consultaSel("SELECT SUM(fMonto) FROM det_cobranzas WHERE det_cobranzas.idCobranza='{$_POST['idCobranza']}'",true);
	$total_diarios=$oMysql->consultaSel("SELECT IFNULL(SUM(fMonto),0) as 'total_diarios' FROM DetallesPlanillasCobranzas WHERE DetallesPlanillasCobranzas.idPlanillaCobranza='{$_POST['idCobranza']}' AND DetallesPlanillasCobranzas.idPlanPago='1'",true);
	$total_sem=$oMysql->consultaSel("SELECT IFNULL(SUM(fMonto),0) as 'total_sem' FROM DetallesPlanillasCobranzas WHERE DetallesPlanillasCobranzas.idPlanillaCobranza='{$_POST['idCobranza']}' AND DetallesPlanillasCobranzas.idPlanPago='2'",true);
	$total_mens=$oMysql->consultaSel("SELECT IFNULL(SUM(fMonto),0) as 'total_mens' FROM DetallesPlanillasCobranzas WHERE DetallesPlanillasCobranzas.idPlanillaCobranza='{$_POST['idCobranza']}' AND DetallesPlanillasCobranzas.idPlanPago='3'",true);

	//$fTotal = $total_diarios + $total_sem/6 + $total_mens/22;
	$fTotal = $total_diarios + $total_sem + $total_mens;
	$fTotal45 = (45*$fTotal)/100;
	$htmlTabla_totales = "";
	$htmlTabla_totales .="<table cellpadding='0' cellspacing='0' style='font-size:10px;font-family: Tahoma;border-collapse:collapse;'>
						  <tr><td colspan='3'></td></tr>";
	$htmlTabla_totales .= "<tr><td></td><td>Total Cobranza:</td><td>$&nbsp;".formatMoney($fTotal,0,'.','')."</td></tr>";
	$htmlTabla_totales .= "<tr><td></td><td>Total Corbanza(45%):</td><td>$&nbsp;".formatMoney($fTotal45,0,'.','')."</td></tr>";
	$htmlTabla_totales .= "</table>";
	echo $htmlTabla_totales;
echo $excel->GetFooter();
exit();	
?>		