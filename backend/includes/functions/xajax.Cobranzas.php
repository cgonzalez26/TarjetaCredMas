<?php	
	/************************** Funciones para las Planillas de Cobranzas ****************************/
	function generarPanilla($form){
		global $oMysql;
		$oRespuesta = new xajaxResponse();	

		$dFechaCobro = $form['dFechaInicio'];
		$oRespuesta->alert($dFechaCobro);
		$sCondicion = "Cupones.idCobrador='{$form['idCobrador']}' and Cupones.sEstado='N'";
		$aClientes= $oMysql->consultaSel("CALL usp_getClientesCobros(\"$sCondicion\",\"\",\"\",\"\",\"$dFechaCobro\");");
		/*if(count($aClientes)>0){
			$iDiarios=0;
			if(isset($form['chkDiarios']))$iDiarios=1;
			$iSemanales=0;
			if(isset($form['chkSemanales']))$iSemanales=1;
			$iMensuales=0;
			if(isset($form['chkMensuales']))$iMensuales=1;
	
			$arrayFecha = explode("/",$dFechaCobro);
			$diaCobro1 = mktime(0, 0, 0, $arrayFecha[1], $arrayFecha[0],$arrayFecha[2]);
			
			$diaSemana = date("w",$diaCobro1);
			if($diaSemana == 0) //=0 es Domingo
				$diaCobro1 = mktime(0, 0, 0, $arrayFecha[1], $arrayFecha[0]+1,$arrayFecha[2]);

			$segundoDiaCobro = 	date("d",$diaCobro1)+1;
			$diaCobro2 = mktime(0,0,0,date("m",$diaCobro1),$segundoDiaCobro,date("Y",$diaCobro1));
			$diaSemana = date("w",$diaCobro2);
			if($diaSemana == 0) //=0 es Domingo
				$diaCobro2 = mktime(0,0,0,date("m",$diaCobro1),$segundoDiaCobro+1,date("Y",$diaCobro1));
			
			$tercerDiaCobro = date("d",$diaCobro2)+1;
			$diaCobro3 = mktime(0,0,0,date("m",$diaCobro2),$tercerDiaCobro,date("Y",$diaCobro2));
			$diaSemana = date("w",$diaCobro3);
			if($diaSemana == 0) //=0 es Domingo
				$diaCobro3 = mktime(0,0,0,date("m",$diaCobro2),$tercerDiaCobro+1,date("Y",$diaCobro2));	
			$diaCobro1_format = date("Y-m-d", $diaCobro1);	
			$diaCobro2_format = date("Y-m-d", $diaCobro2);
			$diaCobro3_format = date("Y-m-d", $diaCobro3);
			//$oRespuesta->alert($diaCobro1_format."   ".$diaCobro2_format."   ".$diaCobro3_format);
			
			$setCobranza = "idCobrador,iDiarios,iSemanales,iMensuales,fTotalDiarios,fTotalSemanales,fTotalMensuales,idEstadoCobranza,fDeuda,idUsuario,dFechaCobranza1,dFechaCobranza2,dFechaCobranza3,dFechaRegistro";
			$valuesCobranza = "'{$form['idCobrador']}','{$iDiarios}','{$iSemanales}','{$iMensuales}',0,0,0,1,0,'{$_SESSION['ID_USER']}','{$diaCobro1_format}','{$diaCobro2_format}','{$diaCobro3_format}',NOW()";
			$ToAuditry = "Insercion de Planilla de Cobranza :::ID_ USER:'{$_SESSION['ID_USER']}'";
			$idCobranza = $oMysql->consultaSel("CALL usp_InsertTable(\"PlanillasCobranzas\",\"$setCobranza\",\"$valuesCobranza\",\"{$_SESSION['ID_USER']}\",\"0\",\"$ToAuditory\");",true);					
			$oRespuesta->alert("CALL usp_InsertTable(\"PlanillasCobranzas\",\"$setCobranza\",\"$valuesCobranza\",\"{$_SESSION['ID_USER']}\",\"0\",\"$ToAuditory\");");
			
			$setDetalle = "(idCupon,idPlanillaCobranza,idPlanPago,dFechaCobro,fMonto,fMontoPago1,fMontoPago2,fMontoPago3)";
			$valuesDetalle = "";
			$array=array();			
			foreach ($aClientes as $aItem ){			
				$array[] = "('{$aItem['id']}','{$idCobranza}','{$aItem['idPlanPago']}','$diaCobro1_format','{$aItem['fMonto']}',0,0,0)";
			}				
			$valuesDetalle = implode(',',$array);
			$sqlDetalle = "INSERT INTO DetallesPlanillasCobranzas {$setDetalle} VALUES {$valuesDetalle}";
			$oMysql->startTransaction();
			$oMysql->consultaAff($sqlDetalle);
			$oMysql->commit();
			
			$iCodigo = 1000 + $idCobranza;
			$sqlCobranza = "UPDATE PlanillasCobranzas SET PlanillasCobranzas.sCodigo='{$iCodigo}' WHERE PlanillasCobranzas.id ='{$idCobranza}'";
			$oMysql->startTransaction();
			$oMysql->consultaAff($sqlCobranza);
			$oMysql->commit();
		}*/
		$oRespuesta->alert("La Planilla de Cobranza se genero correctamente");
		$diaCobro1_format_html = date("d/m/Y", $diaCobro1);
		$diaCobro2_format_html = date("d/m/Y", $diaCobro2);		
		$diaCobro3_format_html = date("d/m/Y", $diaCobro3);
		
		$sCobrador = $oMysql->consultaSel("SELECT CONCAT(Empleados.sApellido,', ',Empleados.sNombre) as 'sCobrador' FROM Empleados WHERE id='{$form['idCobrador']}'",true);
		$oRespuesta->assign("hdnCobrador","value",$sCobrador);
  	    $oRespuesta->assign("hdnResponsable","value",$_SESSION['ID_USER']);
  	    $oRespuesta->alert("Se pudo generar las Planillas correctamente.");
		//idEstadoCobranza=1 ->pendiente
		//$oRespuesta->script("setDatosDetalleCobranza({$idCobranza},'{$diaCobro1_format_html}','{$diaCobro2_format_html}','{$diaCobro3_format_html}',{$iCodigo},1)");
		return $oRespuesta;
	}
	
	function CargarDatosCobranza($idCobranza){
		global $oMysql;
		$oRespuesta = new xajaxResponse();	
		$sConditions = "PlanillasCobranzas.id = '$idCobranza'";	   
   
  	    $aCobranza= $oMysql->consultaSel("CALL usp_getPlanillasCobranzas(\"$sConditions\",\"\",\"\",\"\");",true);
  	    $sCodigo = $aCobranza['sCodigo'];
  	    $dFechaCobranza1 = $aCobranza['dFechaCobranza1'];
  	    $dFechaCobranza2 = $aCobranza['dFechaCobranza2'];
  	    $dFechaCobranza3 = $aCobranza['dFechaCobranza3'];
  	    
  	    $oRespuesta->assign("hdnCobrador","value",$aCobranza['sCobrador']);
  	    $oRespuesta->assign("hdnIdCobrador","value",$aCobranza['idCobrador']); 
  	    $oRespuesta->assign("hdnResponsable","value",$aCobranza['idUsuario']);
  	    
  	    $oRespuesta->script("setDatosDetalleCobranza({$idCobranza},'{$dFechaCobranza1}','{$dFechaCobranza2}','{$dFechaCobranza3}',{$sCodigo},{$aCobranza['idEstadoCobranza']})");
		return $oRespuesta;
	}
	
	function imprimirPlanilla($form){
		global $oMysql;
		$oRespuesta = new xajaxResponse();
		$hoy = date("d/m/Y");
		$sCobrador = $form["hdnCobrador"];		
		$sResponsable = $oMysql->consultaSel("SELECT CONCAT(usuarios.sApellido,', ',usuarios.sNombre) as 'sResponsable' FROM usuarios WHERE usuarios.id = '{$form["hdnResponsable"]}'" ,true);
		
		$html = "";
		$html .="<table cellpadding='0' cellspacing='0' style='font-size:12px;font-family: Tahoma;border-collapse:collapse;border:1px solid #000000'>
				<tr>
					<td style='border-bottom:1px solid #000000'>CODIGO: ".$form['hdnCodigo']."</td>
					<td style='border-bottom:1px solid #000000;padding-left:100px'>Fecha: ".$hoy."</td>
				</tr>
				<tr>
					<td style='border-bottom:1px solid #000000'>Responsable: ".$sResponsable."</td>
					<td style='border-bottom:1px solid #000000;padding-left:100px'>Cobrador: ".$sCobrador."</td>
				</tr>";		
		/*************** DIARIOS **************/
		$arrayDiarios=array();
		$sConditions_diarios = "det_cobranzas.idCobranza='{$form['idCobranza']}' AND det_cobranzas.idPlanPago='1' ORDER BY datosentrega.sApellido,datosentrega.sNombre ASC";
		
		$arrayDiarios=$oMysql->consultaSel("CALL usp_getDetalleCobranzas(\"$sConditions_diarios\",\"\",\"\",\"\");");
		$htmlTabla1 = ""; $htmlTabla2 ="";
		$cantFilas = count($arrayDiarios);
		
		$html .= "<tr><td colspan='2' style='border:1px solid #000000'> &nbsp;<b>DIARIOS</b> </td></tr>";
				
		$ini = round($cantFilas/2);

		$htmlTabla1 .="<table cellpadding='0' cellspacing='0' style='font-size:10px;font-family: Tahoma;border-collapse:collapse;'>";
		$htmlTabla1 .= imprimirHeader($form['hdnFechaCobro1'],$form['hdnFechaCobro2'],$form['hdnFechaCobro3']);
		
		$imprimirSolaFecha = true;
		if(($form['hdnFechaCobro2'] !="")&&($form['hdnFechaCobro3'] !="")){
			$imprimirSolaFecha = false;
		}
		$htmlTabla1 .= imprimirClientesCobros($arrayDiarios,$ini,0,$imprimirSolaFecha);
		$htmlTabla1 .= "</table>";
		
		$htmlTabla2 .="<table cellpadding='0' cellspacing='0' style='font-size:10px;font-family: Tahoma;border-collapse:collapse;'>";
		$htmlTabla2 .= imprimirHeader($form['hdnFechaCobro1'],$form['hdnFechaCobro2'],$form['hdnFechaCobro3']);
		$htmlTabla2 .= imprimirClientesCobros($arrayDiarios,$cantFilas-1,$ini+1,$imprimirSolaFecha);
		$htmlTabla2 .= "</table>";
		
		$html .= "<tr>
					<td valign='top' align='left'>".$htmlTabla1."</td><td valign='top' align='left'>".$htmlTabla2."</td>
				 </tr>";
		
		/*************** SEMANALES **************/
		$arraySemanales=array();
		$sConditions_sem = "det_cobranzas.idCobranza='{$form['idCobranza']}' AND det_cobranzas.idPlanPago='2' ORDER BY datosentrega.sApellido,datosentrega.sNombre ASC";
		
		$arraySemanales=$oMysql->consultaSel("CALL usp_getDetalleCobranzas(\"$sConditions_sem\",\"\",\"\",\"\");");
		$html .= "<tr><td colspan=2 style='height:40px;border: solid 1px #000;'>&nbsp;</td></tr>";	
		$html .= "<tr><td colspan=2 style='border:1px solid #000000'> &nbsp;<b>SEMANALES</b> </td></tr>";	
		$htmlTabla1_sem = ""; $htmlTabla2_sem ="";
		$cantFilas_sem = count($arraySemanales);
		$ini_sem = round($cantFilas_sem/2);
		
		$htmlTabla1_sem .="<table cellpadding='0' cellspacing='0' style='font-size:10px;font-family: Tahoma;border-collapse:collapse;'>";
		$htmlTabla1_sem .= imprimirHeader($form['hdnFechaCobro1'],$form['hdnFechaCobro2'],$form['hdnFechaCobro3']);
		$htmlTabla1_sem .= imprimirClientesCobros($arraySemanales,$ini_sem,0,$imprimirSolaFecha);
		$htmlTabla1_sem .= "</table>";
		
		
		$htmlTabla2_sem .="<table cellpadding='0' cellspacing='0' style='font-size:10px;font-family: Tahoma;border-collapse:collapse;'>";
		$htmlTabla2_sem .= imprimirHeader($form['hdnFechaCobro1'],$form['hdnFechaCobro2'],$form['hdnFechaCobro3']);
		$htmlTabla2_sem .= imprimirClientesCobros($arraySemanales,$cantFilas_sem-1,$ini_sem+1,$imprimirSolaFecha);
		$htmlTabla2_sem .= "</table>";
		
		$html .= "<tr>
					<td valign='top' align='left'>".$htmlTabla1_sem."</td><td valign='top' align='left'>".$htmlTabla2_sem."</td>
				 </tr>";
		
		/*************** MENSUALES **************/
		$arrayAnuales=array();
		$sConditions_mens = "det_cobranzas.idCobranza='{$form['idCobranza']}' AND det_cobranzas.idPlanPago='3' ORDER BY datosentrega.sApellido,datosentrega.sNombre ASC";
		
		$arrayAnuales=$oMysql->consultaSel("CALL usp_getDetalleCobranzas(\"$sConditions_mens\",\"\",\"\",\"\");");
		$html .= "<tr><td colspan=2 style='height:30px;border: solid 1px #000;'>&nbsp;</td></tr>";	
		$html .= "<tr><td colspan=2 style='border:1px solid #000000'> &nbsp;<b>MENSUALES</b> </td></tr>";
		
		$cantFilas_mens = count($arrayAnuales);
		$htmlTabla_mens = "";
		$htmlTabla_mens .="<table cellpadding='0' cellspacing='0' style='font-size:10px;font-family: Tahoma;border-collapse:collapse;'>";
		$htmlTabla_mens .= imprimirHeader($form['hdnFechaCobro1'],$form['hdnFechaCobro2'],$form['hdnFechaCobro3']);
		$htmlTabla_mens .= imprimirClientesCobros($arrayAnuales,$cantFilas_mens-1,0,$imprimirSolaFecha);
		$htmlTabla_mens .= "</table>";
		
		$total_diarios=$oMysql->consultaSel("SELECT IFNULL(SUM(fMonto),0) as 'total_diarios' FROM det_cobranzas WHERE det_cobranzas.idCobranza='{$form['idCobranza']}' AND det_cobranzas.idPlanPago='1'",true);
		$total_sem=$oMysql->consultaSel("SELECT IFNULL(SUM(fMonto),0) as 'total_sem' FROM det_cobranzas WHERE det_cobranzas.idCobranza='{$form['idCobranza']}' AND det_cobranzas.idPlanPago='2'",true);
		$total_mens=$oMysql->consultaSel("SELECT IFNULL(SUM(fMonto),0) as 'total_mens' FROM det_cobranzas WHERE det_cobranzas.idCobranza='{$form['idCobranza']}' AND det_cobranzas.idPlanPago='3'",true);

		$fTotal = $total_diarios + $total_sem/6 + $total_mens/22;
		$fTotal45 = (45*$fTotal)/100;
		$htmlTabla_totales = "";
		$htmlTabla_totales .="<table cellpadding='0' cellspacing='0' style='font-size:10px;font-family: Tahoma;border-collapse:collapse;'>";
		$htmlTabla_totales .= "<tr><td>Total Cobranza:</td><td>$&nbsp;".formatMoney($fTotal,0,'.','')."</td></tr>";
		$htmlTabla_totales .= "<tr><td>Total Corbanza(45%):</td><td>$&nbsp;".formatMoney($fTotal45,0,'.','')."</td></tr>";
		$htmlTabla_totales .= "</table>";		
		
		$html .= "<tr>
					<td valign='top' align='left'>".$htmlTabla_mens."</td><td align='center' style='padding-top:10px'>".$htmlTabla_totales."</td>
				 </tr>";
		
		$html .= "</table>";
		//$oRespuesta->alert($html);
		$oRespuesta->assign("impresiones","innerHTML",$html);
		$oRespuesta->script("window.print();");
		return $oRespuesta;
	}
	
	
	function imprimirHeader($dFechaCobro1,$dFechaCobro2,$dFechaCobro3){
		$fecha1 = explode("/",$dFechaCobro1);
		$fecha1[2] = substr($fecha1[2],2,2);
		$dFechaCobro1 = $fecha1[0]."/".$fecha1[1]."/".$fecha1[2];
		
		$htmlFecha2 ="";
		if($dFechaCobro2 != ""){	
			$fecha2 = explode("/",$dFechaCobro2);
			$fecha2[2] = substr($fecha2[2],2,2);
			$dFechaCobro2 = $fecha2[0]."/".$fecha2[1]."/".$fecha2[2];
			$htmlFecha2.="<td style='border:1px solid #000000;height:18px'> {$dFechaCobro2}</td>";
		}else{
			$dFechaCobro2 ="&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		$htmlFecha3 ="";
		if($dFechaCobro3 != ""){
			$fecha3 = explode("/",$dFechaCobro3);
			$fecha3[2] = substr($fecha3[2],2,2);
			$dFechaCobro3 = $fecha3[0]."/".$fecha3[1]."/".$fecha3[2];
			$htmlFecha3.="<td style='border:1px solid #000000;height:18px'> {$dFechaCobro3}</td>";
		}else{
			$dFechaCobro3 ="&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		$htmlHeader = "";
		$signo = "$";
		$htmlHeader .= "<tr>
			<td style='border:1px solid #000000;width:350px;height:18px'> &nbsp;<b>CLIENTES</b> </td>
			<td style='border:1px solid #000000;width:35px;height:18px' align='center'> <b>$</b> </td>
			<td style='border:1px solid #000000;height:18px'> {$dFechaCobro1}</td>
			$htmlFecha2
			$htmlFecha3
			<td style='border:1px solid #000000;height:18px'> <b>".$signo."Total</b> </td>
			</tr>";	
		return $htmlHeader;
	}

	function imprimirClientesCobros($array,$cantidadFilas,$inicio,$imprimirSolaFecha){
		global $oMysql;
		$htmlCobros = "";
		if(count($array)>0)
		{
			//foreach ($array as $row){
			for($i=$inicio; $i <= $cantidadFilas; $i++){
				$row = $array[$i];			
				$fMontoPago1 = "&nbsp;";
				if($row['fMontoPago1'] != 0) 
					if((int)$row['fMontoPago1'] == $row['fMontoPago1'])
						$fMontoPago1 = number_format($row['fMontoPago1'], 0, '.', '');
					else
						$fMontoPago1 = number_format($row['fMontoPago1'], 2, '.', '');
				
				$htmlPago2="";$htmlPago3="";
				if(!$imprimirSolaFecha){		
					$fMontoPago2 = "&nbsp;";
					if($row['fMontoPago2'] != 0) 
						if((int)$row['fMontoPago2'] == $row['fMontoPago2'])
							$fMontoPago2 = number_format($row['fMontoPago2'], 0, '.', '');
						else
							$fMontoPago2 = number_format($row['fMontoPago2'], 2, '.', '');
					$htmlPago2="<td style='border:1px solid #000;height:16px' align='center'>".$fMontoPago2."</td>";		
					$fMontoPago3 = "&nbsp;";
					if($row['fMontoPago3'] != 0) 
						if((int)$row['fMontoPago3'] == $row['fMontoPago3'])
							$fMontoPago3 = number_format($row['fMontoPago3'], 0, '.', '');
						else
							$fMontoPago3 = number_format($row['fMontoPago3'], 2, '.', '');
					$htmlPago3="<td style='border:1px solid #000;height:16px' align='center'>".$fMontoPago3."</td>";		
				}		
				if((int)$row['fMonto'] == $row['fMonto'])
					$row['fMonto'] = number_format($row['fMonto'], 0, '.', '');
				else
					$row['fMonto'] = number_format($row['fMonto'], 2, '.', '');		
				
				$fTotalPagado = $oMysql->consultaSel("SELECT SUM(fMontoPago) as 'fMontoPago' FROM Cobranzas WHERE Cobranzas.idCupon = ".$row['idCupon'] ,true);
				/*if($fTotalPagado == 0) 
					$fTotalPagado = "";	
				else */
				$fTotalPagado = $fTotalPagado+$row['fAdelanto'];
						
				$fTotalPagado = formatMoney($fTotalPagado,0);
				$row['fMonto'] = formatMoney($row['fMonto']);
				
				//$sDescripcion = $oMysql->consultaSel("SELECT SUBSTRING(sDescripcion,1,20) as 'sDescripcion' FROM DetallesPlanillasCobranzas WHERE det_pedidos.idPedido = '{$row['idProforma']}' LIMIT 0,1",true);
				
				$nombreCompleto = explode(", ",$row['sCliente']);
				$nombre = explode(" ",$nombreCompleto[1]);
				$inicialSegundo = substr($nombre[1],0,1);
				$sCliente = $nombreCompleto[0]. ", ".$nombre[0]." ".$inicialSegundo;
				
				$htmlCobros .= "<tr>		
				<td style='border:1px solid #000;height:16px'>&nbsp;".stripslashes($sCliente)."&nbsp;&nbsp;(".$sDescripcion.")</td>
				<td style='border:1px solid #000;height:16px' align='center'>".stripslashes($row['fMonto'])."</td>
				<td style='border:1px solid #000;height:16px' align='center'>".$fMontoPago1."</td>			
				$htmlPago2
				$htmlPago3
				<td style='border:1px solid #000;height:16px' align='center'>".$fTotalPagado."</td>
				</tr>";
				
			}
		}
		return $htmlCobros;
	}


function generarPanillaUnaFecha($form){
		global $oMysql;
		$oRespuesta = new xajaxResponse();	
		
		$dFechaCobro = $form['dFechaInicio'];
		//$sCondicion = "datospedidosentregados.idCobrador='{$form['idCobrador']}'";
		$sCondicion = "Cupones.idCobrador=='{$form['idCobrador']}' and Cupones.sEstado='N'";
		$aClientes= $oMysql->consultaSel("CALL usp_getClientesCobros(\"$sCondicion\",\"\",\"\",\"\",\"$dFechaCobro\");");
		if(count($aClientes)>0){
			$iDiarios=0;
			if(isset($form['chkDiarios']))$iDiarios=1;
			$iSemanales=0;
			if(isset($form['chkSemanales']))$iSemanales=1;
			$iMensuales=0;
			if(isset($form['chkMensuales']))$iMensuales=1;
	
			$arrayFecha = explode("/",$dFechaCobro);
			$diaCobro1 = mktime(0, 0, 0, $arrayFecha[1], $arrayFecha[0],$arrayFecha[2]);
			
			$diaSemana = date("w",$diaCobro1);
			if($diaSemana == 0) //=0 es Domingo
				$diaCobro1 = mktime(0, 0, 0, $arrayFecha[1], $arrayFecha[0]+1,$arrayFecha[2]);

			$diaCobro1_format = date("Y-m-d", $diaCobro1);	
			
			$setCobranza = "idCobrador,iDiarios,iSemanales,iMensuales,fTotalDiarios,fTotalSemanales,fTotalMensuales,idEstadoCobranza,fDeuda,idUsuario,dFechaCobranza1,dFechaRegistro";
			$valuesCobranza = "'{$form['idCobrador']}','{$iDiarios}','{$iSemanales}','{$iMensuales}',0,0,0,1,0,'{$_SESSION['ID_USER']}','{$diaCobro1_format}',NOW()";
			$ToAuditry = "Insercion de Planilla de Cobranza :::ID_ USER:'{$_SESSION['ID_USER']}'";
			$idCobranza = $oMysql->consultaSel("CALL usp_InsertTable(\"PlanillasCobranzas\",\"$setCobranza\",\"$valuesCobranza\",\"{$_SESSION['ID_USER']}\",\"0\",\"$ToAuditory\");",true);					
			
			$setDetalle = "(idCupon,idPlanillaCobranza,idPlanPago,dFechaCobro,fMonto,fMontoPago1,fMontoPago2,fMontoPago3)";
			$valuesDetalle = "";
			$array=array();			
			foreach ($aClientes as $aItem ){			
				$array[] = "('{$aItem['id']}','{$idCobranza}','{$aItem['idPlanPago']}','$diaCobro1_format','{$aItem['fMonto']}',0,0,0)";
			}				
			$valuesDetalle = implode(',',$array);
			$sqlDetalle = "INSERT INTO DetallesPlanillasCobranzas {$setDetalle} VALUES {$valuesDetalle}";
			$oMysql->startTransaction();
			$oMysql->consultaAff($sqlDetalle);
			$oMysql->commit();
			
			$iCodigo = 1000 + $idCobranza;
			$sqlCobranza = "UPDATE PlanillasCobranzas SET PlanillasCobranzas.sCodigo='{$iCodigo}' WHERE PlanillasCobranzas.id ='{$idCobranza}'";
			$oMysql->startTransaction();
			$oMysql->consultaAff($sqlCobranza);
			$oMysql->commit();
		}
		$oRespuesta->alert("La Planilla de Cobranza se genero correctamente");
		$diaCobro1_format_html = date("d/m/Y", $diaCobro1);
		$diaCobro2_format_html = date("d/m/Y", $diaCobro2);		
		$diaCobro3_format_html = date("d/m/Y", $diaCobro3);
		
		$sCobrador = $oMysql->consultaSel("SELECT CONCAT(Empleados.sApellido,', ',Empleados.sNombre) as 'sCobrador' FROM Empleados WHERE id='{$form['idCobrador']}'",true);
		$oRespuesta->assign("hdnCobrador","value",$sCobrador);
  	    $oRespuesta->assign("hdnResponsable","value",$_SESSION['ID_USER']);
  	    
		//idEstadoCobranza=1 ->pendiente
		$oRespuesta->script("setDatosDetalleCobranza({$idCobranza},'{$diaCobro1_format_html}','','',{$iCodigo},1)");
		return $oRespuesta;
	}
	
	

?>	
	