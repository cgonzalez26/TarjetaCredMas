<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	//session_start();
		
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
			
				$estado_cuenta_normal = 1;
				$estado_cuenta_moroso_1_mes = 3;
				$estado_cuenta_moroso_2_mes = 4;
				$estado_cuenta_moroso_3_mes = 5;
				$estado_cuenta_inhabilitada = 10;
				$estado_cuenta_inhabilitada_con_cobranza = 13;
				$estado_cuenta_previsionada = 11;
				$estado_cuenta_previosionada_con_cobranza = 14;		
				
				
				if(!$_GET['n'])
				{
					//$oMysql->consultaSel("DELETE FROM 0_CorregirDiasMora");
				}
				
				//$idCuentaUsuario =5539;
				$sNumeroCuenta = $_GET['n']; 
				//echo "- idUsuario = "	. $idCuentaUsuario. "<br>"; 	
									
				if($sNumeroCuenta)
					$sub_query = " WHERE CuentasUsuarios.sNumeroCuenta = '{$sNumeroCuenta}' AND CuentasUsuarios.idTipoEstadoCuenta <> 12;";
				else 	
					$sub_query = 
					" WHERE CuentasUsuarios.idTipoEstadoCuenta <> 12 AND 
					(
							CuentasUsuarios.idTipoEstadoCuenta = $estado_cuenta_moroso_2_mes OR
							CuentasUsuarios.idTipoEstadoCuenta = $estado_cuenta_moroso_3_mes OR
							CuentasUsuarios.idTipoEstadoCuenta = $estado_cuenta_moroso_1_mes
					);";
					
					/*CuentasUsuarios.idTipoEstadoCuenta = $estado_cuenta_moroso_2_mes OR
						CuentasUsuarios.idTipoEstadoCuenta = $estado_cuenta_moroso_3_mes OR*/
				$cuentasusuarios = $oMysql->consultaSel("CALL usp_getCuentasUsuarios(\"$sub_query\");");		
								
						
				$sMensaje = "";
				$sMensajeNuevoEstado = "";
				$idTipoEstadoNuevo = 0;
					
				foreach ($cuentasusuarios as $cuentausuario)
				{	
					$sMensaje .= "<br>--------------------------------------------------<br>";
					$sMensaje .= "<br> - Cuenta Nro: ". $cuentausuario['sNumeroCuenta']. "<br>";
					$sMensaje .="- Usuario: ". $cuentausuario['sApellido'] .', '. $cuentausuario['sNombre'] . "<br>";
					$sMensaje .="- Estado Actual: ". $cuentausuario['sEstado']. "<br>";
									
					#obtengo datos, fecha Cierre, Vencimiento, Mora de periodo anterior  y actual
					
					
					$iCantidad = 
						$oMysql->consultaSel("SELECT count(DetallesCuentasUsuarios.id) FROM DetallesCuentasUsuarios WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$cuentausuario['id']};",true);
										
					$limit = $iCantidad -1;
					$sub_query = " WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$cuentausuario['id']} ORDER BY DetallesCuentasUsuarios.id ASC";
					$detallescuentasusuarios = $oMysql->consultaSel("CALL usp_getDetallesCuentasUsuarios(\"$sub_query\");");
					
					$iDiasMorasAcumulados = 0;
					
					foreach ($detallescuentasusuarios as $detalle)
					{
						$sMensaje .= "<br>--------------------<br>";
						$dFechaVencimientoActual = dateToMySql($detalle['dFechaVencimiento']);									
						$dFechaVencimientoReal =  $oMysql->consultaSel("SELECT fnc_getFechaVencimientoAnterior(\"{$dFechaVencimientoActual}\",\"{$detalle['idCuentaUsuario']}\",\"2\");",true);
						
						$dFechaMoraActual = dateToMySql($detalle['dFechaMora']);									
						$dFechaCorridaMoraActual =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraActual}\",\"{$detalle['idCuentaUsuario']}\",\"2\");",true);
						
						$dFechaMoraAnterior = dateToMySql($detalle['dFechaMora']);														   
					    
					    
					    $sMensaje .= "-Periodo: " . $detalle['dPeriodo'] . "<br>";
					    $sMensaje .= "-Fecha mora: " . $dFechaCorridaMoraActual . "<br>";
					    $sMensaje .= "-Fecha mora anterior: " . $dFechaCorridaMoraAnterior . "<br>";
					    $sMensaje .= "-Fecha vencimiento: " .$dFechaVencimientoReal . "<br>";
					    
					    $detalle['fAcumuladoCobranza'] = $detalle['fAcumuladoCobranza'] + 10;
					
						$sMensaje .= "- AcumuladoCobranza: " . $detalle['fAcumuladoCobranza'] . "<br>"; ;
						$sMensaje .= "- SaldoAnterior :" . $detalle['fSaldoAnterior'] . "<br>";
						$sMensaje .= "- DiasMora :" . $iDiasMorasAcumulados . "<br>";
						
						//var_export($detallescuentausuario1);die();
						if($detalle['fAcumuladoCobranza'] >= $detalle['fSaldoAnterior'])
						{
								if($iDiasMorasAcumulados < 91)
								{
																		
									$sMensaje .= "- Dias de mora Nuevo: " . $iDiasMorasAcumulados . "<br>"; 
									$sMensaje .= "- Estado NORMAL <br>";
									$iDiasMorasAcumulados = 0;									
								}
								elseif($iDiasMorasAcumulados>=91 && $iDiasMorasAcumulados<120 )
								{
									$sMensaje .= "- Dias de mora Nuevo: " . $iDiasMorasAcumulados . "<br>"; 
									$sMensaje .= "- Estado NORMAL <br>";
									$iDiasMorasAcumulados = 0;									
								}	
								
								$idTipoEstadoNuevo = $estado_cuenta_normal;						
						}
						else 
						{
						#las cobranzas son menores k importe exigible
	
								if($iDiasMorasAcumulados == 0)
								{			
						
										//$diasMora = diasEntreFechas($detallescuentausuario0['dFechaVencimiento'],$detallescuentausuario0['dFechaMora']);
	
										//$diasMora = diasEntreFechas($detallescuentausuario0['dFechaVencimiento'],$detallescuentausuario0['dFechaMora']);
										
										$diasMora = diasEntreFechas($dFechaVencimientoReal, $dFechaCorridaMoraActual);								
										$iDiasMorasAcumulados = $iDiasMorasAcumulados + $diasMora;
										
						
										$sMensaje .= "- Dias de mora Nuevo: " . $iDiasMorasAcumulados . "<br>"; 
											
										$sMensaje .= "MOROSO 1 MES";	
										$sMensajeNuevoEstado = "MOROSO 1 MES";	
										$idTipoEstadoNuevo = $estado_cuenta_moroso_1_mes;				
								}
								else
								{	
										
										//$diasMora = diasEntreFechas($detallescuentausuario1['dFechaMora'],$detallescuentausuario0['dFechaMora']);
																			
										$diasMora = diasEntreFechas($dFechaCorridaMoraAnterior, $dFechaCorridaMoraActual);
										//$diasMora = diasEntreFechas('16/02/2012', '16/03/2012');
										
										$sMensaje .= " - Dias entre fechas: " . $diasMora . "<br>"; 
										$iDiasMorasAcumulados = $iDiasMorasAcumulados + $diasMora;
										
										$sMensaje .= "- Dias de mora Nuevo: " . $iDiasMorasAcumulados . "<br>"; 
										
										if($iDiasMorasAcumulados>=1 && $iDiasMorasAcumulados < 31)
										{		
											$sMensaje .= "MOROSO 1 MES";	
											$sMensajeNuevoEstado = "MOROSO 1 MES";	
											$idTipoEstadoNuevo = $estado_cuenta_moroso_1_mes;									
										}
										
										if($iDiasMorasAcumulados>=31 && $iDiasMorasAcumulados < 61)
										{
											$sMensaje .= "MOROSO 2 MESES";
											$sMensajeNuevoEstado = "- MOROSO 2 MESES";
											$idTipoEstadoNuevo = $estado_cuenta_moroso_2_mes;
										}
										
										if($iDiasMorasAcumulados>=61 && $iDiasMorasAcumulados < 91)
										{
											
											$sMensaje .= "MOROSO 3 MESES";
											$sMensajeNuevoEstado = "MOROSO 3 MESES";
											$idTipoEstadoNuevo = $estado_cuenta_moroso_3_mes;
										}
										
										if($iDiasMorasAcumulados>=91 && $iDiasMorasAcumulados < 540)
										{
											$sMensaje .= "INHABILITADA";	
											$sMensajeNuevoEstado = "INHABILITADA";	
											$idTipoEstadoNuevo = $estado_cuenta_inhabilitada;										
										}
										
										if($iDiasMorasAcumulados>=541)
										{
											$sMensaje .= "PREVISIONADA";
											$sMensajeNuevoEstado = "PREVISIONADA";
											$idTipoEstadoNuevo = $estado_cuenta_previsionada;
										}									
								}
							}
							
							 $dFechaCorridaMoraAnterior =  $dFechaCorridaMoraActual;
					
					}//foreach ($detallescuentasusuarios as $detalle)	
					
					$sConsulta = "
									SELECT DetallesCuentasUsuarios.id, DetallesCuentasUsuarios.iDiasMora, DetallesCuentasUsuarios.dPeriodo
								 	FROM DetallesCuentasUsuarios 
								 	WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$cuentausuario['id']} and DetallesCuentasUsuarios.dPeriodo = '2012-03-01 00:00:00'
								 ";
								 	
					
					$ultimoDetalle = 
					$oMysql->consultaSel($sConsulta,true);
					
					$sMensaje .= "<br>- DiasMoraActual: {$ultimoDetalle['iDiasMora']} ::: DiasMoraAcumulado: {$iDiasMorasAcumulados}  <br>";
					$sMensaje .= "<br>- idDetalle: {$ultimoDetalle['id']}";
					$sMensajeCuentas = "";
					
					if($ultimoDetalle['iDiasMora'] != $iDiasMorasAcumulados)
					{
						echo "<br>- CuentaUsuario: {$cuentausuario['sNumeroCuenta']} 
						::::: DiasMoraActual: {$ultimoDetalle['iDiasMora']} / DiasMoraNuevo: {$iDiasMorasAcumulados} 
						::::: EstadoActual: {$cuentausuario['sEstado']}/ NuevoEstado: {$sMensajeNuevoEstado}
						::::: IdTipoEstadoNuevo: {$idTipoEstadoNuevo}<br>";
						
						if(!$_GET['n'])
						{
							/*Insertar
							(
								$cuentausuario['id'],
								$cuentausuario['sNumeroCuenta'],
								$cuentausuario['idTipoEstadoCuenta'],
								$idTipoEstadoNuevo,
								$cuentausuario['sEstado'],								
								$sMensajeNuevoEstado,								
								$ultimoDetalle['iDiasMora'],
								$iDiasMorasAcumulados,								
								$ultimoDetalle['id'],
								$ultimoDetalle['dPeriodo']
							);*/
						}
					}
					
					
				}//foreach 

				echo $sMensaje;
				
	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);	
?>

<?
	function Insertar($idCuentaUsuario, $sNumeroCuenta, $idTipoEstadoActual, $idTipoEstadoNuevo, $sEstadoActual, $sEstadoNuevo, $iDiasMoraActual, $iDiasMoraNuevo, $idDetalle, $dPeriodo)
	{
		Global $oMysql;
		
		//$dPeriodo = dateToMySql($dPeriodo);
		
		$sConsulta = 
					"
						INSERT INTO 0_CorregirDiasMora
						(
							idCuentaUsuario, 
							sNumeroCuenta, 							
							idTipoEstadoActual,
							idTipoEstadoNuevo, 
							sEstadoActual,
							sEstadoNuevo, 
							iDiasMoraActual, 							
							iDiasMoraNuevo, 							
							idDetalleCuentaUsuario, 
							dPeriodo
						)
						VALUES 
						(
							$idCuentaUsuario, 
							'$sNumeroCuenta', 
							 $idTipoEstadoActual,
							 $idTipoEstadoNuevo,
							 '$sEstadoActual',
							 '$sEstadoNuevo',
							 $iDiasMoraActual, 
							 $iDiasMoraNuevo, 							 
							 $idDetalle, 
							 '$dPeriodo'
						)
					";
		//echo $sConsulta;
		$oMysql->consultaSel($sConsulta);
	}
?>