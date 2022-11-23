<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
		
	global $oMysql,$mysql;
	
	$nomExcel = 'xlsCuentas_'. date('d-m-Y') ;
	
		
	header("Content-Type: application/vnd.ms-excel"); 
	header( 'Content-Disposition: attachment; filename="'.$nomExcel.'.xls"' );
	header('Cache-Control: private, must-revalidate'); 
	header('Pragma: private'); // allow private caching 
	
	$excel=new ExcelWriter();
	
	echo $excel->GetHeader();

	$CampoOrden = 'CuentasUsuarios.dFechaRegistro'; // Campo de orden predeterminado
	$TipoOrden = 'DESC';	// Tipo de orden predeterminado
	
	$sNumeroCuenta = $_SESSION['sNumeroCuenta'];
	$idTipoDocumentoCuenta = $_SESSION['idTipoDocumentoCuenta'];
	$sDocumentoCuenta = $_SESSION['sDocumentoCuenta'];
	$sApellidoCuenta = $_SESSION['sApellidoCuenta'];
	$sNombreCuenta = $_SESSION['sNombreCuenta'];
	$idRegionCuenta = $_SESSION['idRegionCuenta'];
	$idSucursalCuenta = $_SESSION['idSucursalCuenta'];
	$idEstadoCuenta = $_SESSION['idEstadoCuenta'];	
	
	
	$aCond=Array();
	
	if($sNumeroCuenta){$aCond[]=" CuentasUsuarios.sNumeroCuenta LIKE '".trim($sNumeroCuenta)."' ";}
	if($idTipoDocumentoCuenta){$aCond[]=" InformesPersonales.idTipoDocumento = '".trim($idTipoDocumentoCuenta)."' ";}
	if($sDocumentoCuenta){$aCond[]=" InformesPersonales.sDocumento = '".trim($sDocumentoCuenta)."' ";}
	if($sApellidoCuenta){$aCond[]=" InformesPersonales.sApellido LIKE '%".trim($sApellidoCuenta)."%' ";}
	if($sNombreCuenta){$aCond[]=" InformesPersonales.sNombre LIKE '%".trim($sNombreCuenta)."%' ";}
	
	$sEmpleadosRegion = "";
	$sEmpleadosSucursal = "";
	
	if($idRegionCuenta)
	{
		$aEmpleadosRegion = $mysql->selectRows("SELECT Empleados.id FROM Empleados 
			LEFT JOIN Oficinas ON Oficinas.id= Empleados.idOficina LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal LEFT JOIN Regiones ON Regiones.id=Sucursales.idRegion
			WHERE Regiones.id = {$idRegionCuenta} ORDER BY Empleados.id DESC");
		$sEmpleadosRegion .= implode(",",$aEmpleadosRegion);		
	}
	
	if($idSucursalCuenta)
	{
		$aEmpleadosSucursal = $mysql->selectRows("SELECT Empleados.id FROM Empleados 
			LEFT JOIN Oficinas ON Oficinas.id= Empleados.idOficina LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal 
			WHERE Sucursales.id = {$idSucursalCuenta} ORDER BY Empleados.id DESC");
		//echo $idSucursalCuenta;
		$sEmpleadosSucursal = implode(",",$aEmpleadosSucursal);		
		//echo $sEmpleadosSucursal;
	}
	
	if($sEmpleadosSucursal != "")
	{
		$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosSucursal})";
	}
	else
	{
		if($sEmpleadosRegion != "")
		{
			$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosRegion})";
		}
	}
	 
	if($idEstadoCuenta){$aCond[]=" CuentasUsuarios.idTipoEstadoCuenta = '".trim($idEstadoCuenta)."' ";}
	
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
	
	
	$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondiciones\");";
	
	$Cuentas = $oMysql->consultaSel($sqlDatos);
		
	
	
	
	
	
	echo "<tr>";
	echo "<td width=120><b>Nro.Cuenta</b></td>";
	echo "<td width=180><b>Fecha Alta</b></td>";
	echo "<td width=110><b>Titular</b></td>";
	echo "<td width=80><b>Documento</b></td>";
	echo "<td width=80><b>Localidad</b></td>";
	echo "<td width=150><b>Domicilio</b></td>";
	echo "<td width=150><b>Estado</b></td>";
	echo "<td width=150><b>Telefono Contacto</b></td>";
	echo "<td width=150><b>Tel. Particular Fijo</b></td>";
	echo "<td width=150><b>Tel. Particular Celular</b></td>";
	echo "<td width=100><b>Total a Pagar</b></td>";
	echo "</tr>";
	
	//$consumos_seleccionados = $_GET['aCupones'];
	
	if(!$Cuentas)
	{
		echo "<tr>";
		echo "<td class=xl24 style='border: solid 1px #000;' colspan='5'> - no registros </td>";
		echo "</tr>";
	}
	else
	{			
		
		/*
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumeroCuenta'];?></td>
			<td width="15%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['dFechaRegistro'];?></td>
			<td width="25%" align="left" <?php echo $sClase;?>>&nbsp;<?=$sUsuario;?></td>
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sDocumento'];?></td>	
			<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sLocalidad'];?></td>	
			<td width="15%" id="estado<?php echo$rs['sNumero']?>" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sEstado'];?></td>		
		*/
		
		foreach ($Cuentas as $Cuenta)
		{			
			$sUsuario = "";
			
			$idCuentaUsuario = $Cuenta['id'];
			
			//----------------- Armar domicilio -----------------------------------------------------
			$sDomicilio = "Calle:".$Cuenta['sCalle'].", Nro:".$Cuenta['sNumeroCalle'];
			
			if(($Cuenta['sBlock'] != "") && ($Cuenta['sBlock'] != "0")) $sDomicilio .=', Block: '.$Cuenta['sBlock'];
			
			if(($Cuenta['sPiso'] != "") && ($Cuenta['sPiso'] != "0")) $sDomicilio .= ', Piso:'.$Cuenta['sPiso'];
			
			if(($Cuenta['sDepartamento'] != "") && ($Cuenta['sDepartamento'] != "0")) $sDomicilio .= ', Dpto:'.$Cuenta['sDepartamento'];			
			
			if($Cuenta['sBarrio'] != "") $sDomicilio .= ', Barrio:'.$Cuenta['sBarrio'];	
	
			if($Cuenta['sManzana'] != "") $sDomicilio .= ', Mza: '.$Cuenta['sManzana'];
			if($Cuenta['sLote'] != "") $sDomicilio .= ', Lote: '.$Cuenta['sLote'];
			
			$sDomicilio .= '<br>'.$Cuenta['sProvincia'].', '.$Cuenta['sLocalidad'].', '.$Cuenta['sCodigoPostal'];
			$sDomicilio = convertir_especiales_html($sDomicilio);
			
			//--------------------- Obtener detalles cuentas Usuarios ------------------------------
				
			$sCondicionesDetalle = "WHERE idCuentaUsuario = {$idCuentaUsuario}  order by DetallesCuentasUsuarios.id DESC LIMIT 0,1 ";
			$sqlDatos = "CALL usp_getDetallesCuentasUsuarios(\"$sCondicionesDetalle\");";	
			$DetalleCuentaUsuario = $oMysql->consultaSel($sqlDatos,true);
					
			$dPeriodo = dateToMySql($DetalleCuentaUsuario['dPeriodo']);
			$dFechaCierre = dateToMySql($DetalleCuentaUsuario['dFechaCierre']);
			$fSaldoAnterior = $DetalleCuentaUsuario['fSaldoAnterior'];
						
			//--------------------- Obtener importe a pagar ----------------------------------------			
						
			#Obtener el saldo deudor del usuario para sumarle al importe a pagar
			$sqlDatos = "SELECT fcn_getSaldoDeudor(\"$idCuentaUsuario\",\"$dFechaCierre\");";	
			$fSaldoDeudor = $oMysql->consultaSel($sqlDatos, true);
			
			$sqlDatos = "CALL usp_getResumenPorCuenta(\"$idCuentaUsuario\",\"$dPeriodo\");";	
			$Resumen = $oMysql->consultaSel($sqlDatos);
			
			$fTotalPagar = 0;	
			
			//$fSaldoAnterior = round($fSaldoAnterior);
			
			if($fSaldoAnterior <= 0)
			{
				foreach ($Resumen as $Dato) 
				{
					if($Dato['tipoOperacion'] ==2 || $Dato['tipoOperacion'] ==4) //tipoOperacion=2->Ajustes de Tipo Credito y  tipoOperacion=4 ->Cobranza Restan el Total
						$fTotalPagar -= $Dato['Importe'];
					else	
						$fTotalPagar += $Dato['Importe'];
				}
				$sMensaje="<tr>
							  <td class='subTitulo' height='30' align='left' colspan='4' style='color:red;font-weight:bold;font-size:8pt;font-family:Verdana;'>
							 	EL SALDO A PAGAR ES 0 (CERO) POR LO TANTO SE SUGIERE COBRAR EL SALDO ACTUAL. <BR> SINO SE QUIERE ABONAR EL TOTAL, PUEDE HACER UN PAGO A CUENTA MENOR MODIFICANDO EL IMPORTE A PAGAR
							  </td>
						   </tr>";
				$aParametros['MENSAJE']=$sMensaje;
				$fSeguroDeVida = $fSaldoDeudor * 0.1/100;
				$fTotalPagar += $fSaldoAnterior + 7 + $fSeguroDeVida;		
			}
			else 
			{
				$fTotalPagar = $fSaldoAnterior;
			}
					
			//$fTotalPagar=round($fTotalPagar);		 
				
			//--------------------------------------------------------------------------------------
			
			
			
			if($Cuenta['iTipoPersona'] == 2)					
				$sUsuario .= $Cuenta['sRazonSocial'];				
			else
				$sUsuario .= $Cuenta['sApellido'] .", ". $Cuenta['sNombre'];	
			
			//if(in_array(_encode($consumo['id']),$consumos_seleccionados))
			{
				echo "<tr>";				
				echo "<td class=xl24 style='border: solid 1px #000; '> {$Cuenta['sNumeroCuenta']}</td>";
				echo "<td class=xl24 style='border: solid 1px #000; '> {$Cuenta['dFechaRegistro']} </td>";
				echo "<td class=xl24 style='border: solid 1px #000; '> {$sUsuario} </td>";
				echo "<td class=xl24 style='border: solid 1px #000; '> {$Cuenta['sDocumento']} </td>";
				echo "<td class=xl24 style='border: solid 1px #000; '> {$Cuenta['sLocalidad']}</td>";
				echo "<td class=xl24 style='border: solid 1px #000; '> {$sDomicilio}</td>";
				echo "<td class=xl24 style='border: solid 1px #000; '> {$Cuenta['sEstado']} </td>";								
				echo "<td class=xl24 style='border: solid 1px #000; '> {$Cuenta['sTelefonoContacto']} </td>";	
				echo "<td class=xl24 style='border: solid 1px #000; '> {$Cuenta['sTelefonoParticularCelular']} </td>";	
				echo "<td class=xl24 style='border: solid 1px #000; '> {$Cuenta['sTelefonoParticularFijo']} </td>";	
				echo "<td class=xl24 style='border: solid 1px #000; '> {$fTotalPagar} </td>";	
				echo "</tr>";													
			}
		}	
		
	}
	

	echo $excel->GetFooter();

	exit();	
?>				