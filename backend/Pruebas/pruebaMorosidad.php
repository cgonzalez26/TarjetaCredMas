<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	//session_start();
		
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
			
							
			
				//$idCuentaUsuario =5539;
				$sNumeroCuenta = $_GET['n']; 
				//echo "- idUsuario = "	. $idCuentaUsuario. "<br>"; 	
	
				$sub_query = " WHERE CuentasUsuarios.sNumeroCuenta = '{$sNumeroCuenta}' AND CuentasUsuarios.idTipoEstadoCuenta <> 12;";
			
				$cuentasusuarios = $oMysql->consultaSel("CALL usp_getCuentasUsuarios(\"$sub_query\");");		
							
				
					
				foreach ($cuentasusuarios as $cuentausuario)
				{
					echo "<br> - Cuenta Nro: ". $cuentausuario['sNumeroCuenta']. "<br>";
					echo "- Usuario: ". $cuentausuario['sApellido'] .', '. $cuentausuario['sNombre'] . "<br>";
					echo "- Estado Actual: ". $cuentausuario['sEstado']. "<br>";
					echo " -------------------------------------------------<br>";
									
					#obtengo datos, fecha Cierre, Vencimiento, Mora de periodo anterior  y actual
					$sub_query = " WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$cuentausuario['id']} ORDER BY DetallesCuentasUsuarios.id DESC LIMIT 0,2";
					$detallescuentasusuarios = $oMysql->consultaSel("CALL usp_getDetallesCuentasUsuarios(\"$sub_query\");");
					
					//echo "CALL usp_getDetallesCuentasUsuarios(\"$sub_query\");";
					$detallescuentausuario0 = $detallescuentasusuarios[0];#periodo actual
					$detallescuentausuario1 = $detallescuentasusuarios[1];#periodo anterior
					
					$detallescuentaushuario0['fAcumuladoCobranza'] = floatval($detallescuentausuario0['fAcumuladoCobranza']);
					$detallescuentausuario0['fSaldoAnterior'] = floatval($detallescuentausuario0['fSaldoAnterior']);
					
					#le agrego el importe minimo					
					
					$detallescuentausuario0['fAcumuladoCobranza'] = $detallescuentausuario0['fAcumuladoCobranza'] + 10;
					
					echo "- AcumuladoCobranza: " . $detallescuentausuario0['fAcumuladoCobranza'] . "<br>"; ;
					
					//var_export($detallescuentausuario1);die();
					if($detallescuentausuario0['fAcumuladoCobranza'] >= $detallescuentausuario0['fSaldoAnterior'])
					{
							$message = $break . "Acumulado Cobranzas({$detallescuentausuario0['fAcumuladoCobranza']}) es SUPERIOR a Saldo anterior(Importe Exigible-Saldo anterior({$detallescuentausuario0['fSaldoAnterior']})";
							
							if($detallescuentausuario0['iDiasMora'] < 91)
							{
								
								$message = $break . "Dias de Mora {$detallescuentausuario0['iDiasMora']} < 91, iniciado cambio de estado en cuenta y cantidad de dias mora";
								echo "- Estado NORMAL";
							}
							elseif($detallescuentausuario0['iDiasMora']>=91 && $detallescuentausuario0['iDiasMora']<120 )
							{

								$message = $break . "Dias de Mora {$detallescuentausuario0['iDiasMora']} >= 91 y <=120 , iniciado cambio de estado en cuenta y cantidad de dias mora";
								echo "- Estado NORAML";
							}							
					}
					else 
					{
					#las cobranzas son menores k importe exigible

							if($detallescuentausuario0['iDiasMora'] == 0)
							{			
									$dFechaVencimientoActual = dateToMySql($detallescuentausuario0['dFechaVencimiento']);									
									$dFechaVencimientoReal =  $oMysql->consultaSel("SELECT fnc_getFechaVencimientoAnterior(\"{$dFechaVencimientoActual}\",\"{$detallescuentausuario0['idCuentaUsuario']}\",\"2\");",true);
									
									$dFechaMoraActual = dateToMySql($detallescuentausuario0['dFechaMora']);									
									$dFechaCorridaMoraActual =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraActual}\",\"{$detallescuentausuario0['idCuentaUsuario']}\",\"2\");",true);
																
									//$diasMora = diasEntreFechas($detallescuentausuario0['dFechaVencimiento'],$detallescuentausuario0['dFechaMora']);
									echo " - Fecha Vencimiento Actual: " .$detallescuentausuario0['dFechaVencimiento']. "<br>"; ;
									echo " - Fecha Vencimiento Real: " .$dFechaVencimientoReal. "<br>"; ;
									echo " - Dias de mora anterior: " . $detallescuentausuario0['iDiasMora'] . "<br>";

									//$diasMora = diasEntreFechas($detallescuentausuario0['dFechaVencimiento'],$detallescuentausuario0['dFechaMora']);
									
									$diasMora = diasEntreFechas($dFechaVencimientoReal, $dFechaCorridaMoraActual);								
									$diasMora = $detallescuentausuario0['iDiasMora'] + $diasMora;
									
					
									echo "- Dias de mora Nuevo: " . $diasMora . "<br>"; 
										
									echo "- MOROSO 1 MES";							
							}
							else
							{
									$dFechaMoraActual = dateToMySql($detallescuentausuario0['dFechaMora']);									
									$dFechaCorridaMoraActual =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraActual}\",\"{$detallescuentausuario0['idCuentaUsuario']}\",\"2\");",true);
									
									$dFechaMoraAnterior = dateToMySql($detallescuentausuario1['dFechaMora']);									
									$dFechaCorridaMoraAnterior =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraAnterior}\",\"{$detallescuentausuario1['idCuentaUsuario']}\",\"2\");",true);
									
									echo " - Corrida Mora anterior: " .$dFechaCorridaMoraAnterior. "<br>"; ;
									echo " - Corrida Mora actual: " .$dFechaCorridaMoraActual. "<br>"; ;
									
									//$diasMora = diasEntreFechas($detallescuentausuario1['dFechaMora'],$detallescuentausuario0['dFechaMora']);
																		
									$diasMora = diasEntreFechas($dFechaCorridaMoraAnterior, $dFechaCorridaMoraActual);
									//$diasMora = diasEntreFechas('16/02/2012', '16/03/2012');
									
									echo " - Dias de mora anterior: " . $detallescuentausuario0['iDiasMora'] . "<br>";
									echo " - Dias entre fechas: " . $diasMora . "<br>"; 
									$diasMora = $detallescuentausuario0['iDiasMora'] + $diasMora;
									
									echo "- Dias de mora Nuevo: " . $diasMora . "<br>"; 
									
									if($diasMora>=1 && $diasMora < 31)
									{		
										echo "- MOROSO 1 MES";											
									}
									
									if($diasMora>=31 && $diasMora < 61)
									{
										echo "- MOROSO 2 MESES";
									}
									
									if($diasMora>=61 && $diasMora < 91)
									{
										
										echo "- MOROSO 3 MESES";
									}
									
									if($diasMora>=91 && $diasMora < 540)
									{
										echo "- INHABILITADA";												
									}
									
									if($diasMora>=541)
									{
										echo "- PREVISIONADA ";
									}									
							}						
					}
				}

	
	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);	
?>