<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();
		
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
			
	
	//Este procesomas genera un resumen con todas las cuotas futuras para cada cuenta es estado inhabilitado
	
			//global $oMysql;	
			
			$FechaActual =date('Y-m-d');
			list($añoActual,$mesActual,$diaActual)	=split("-",$FechaActual);
									
			$iEstadoInhabilitado = 10;	

			
			//------------ Obtener datos del calendario facturacion -------------------------$sub_query = 
			
			$sql =	
			"
					SELECT 
					  	CalendariosFacturaciones.*
				 	FROM 
						CalendariosFacturaciones
					WHERE
						CalendariosFacturaciones.idGrupoAfinidad = 2 AND
						MONTH(CalendariosFacturaciones.dPeriodo) = 4 AND
						YEAR(CalendariosFacturaciones.dPeriodo) = 2012					
				";	
				
				$Calendario = $oMysql->consultaSel($sql, true);	
			
			
			//--------------- Traer Cuentas de Usuarios con cantidad detalle 0 -------------------------
			
			$sub_query = 
				"
					SELECT 
					  	CuentasUsuarios.id as idCuentaUsuario,
					  	CuentasUsuarios.sNumeroCuenta,
					  	CuentasUsuarios.dFechaRegistro,
					    Tarjetas.id as idTarjeta,
					    AjustesUsuarios.fImporteTotal as fAjuste,
					    Cupones.fImporte as fConsumo,
					    Cobranzas.fImporte as fCobranza
				 	FROM 
					    CuentasUsuarios
						LEFT JOIN Tarjetas ON Tarjetas.idCuentaUsuario = CuentasUsuarios.id 
						left join AjustesUsuarios on CuentasUsuarios.id = AjustesUsuarios.idCuentaUsuario 
						left JOIN Cupones on Tarjetas.id = Cupones.idTarjeta 
						left JOIN Cobranzas on Cobranzas.idCuentaUsuario = CuentasUsuarios.id
					WHERE
					   	(
					       	SELECT COUNT(DetallesCuentasUsuarios.id) 
					        FROM DetallesCuentasUsuarios 
					        WHERE DetallesCuentasUsuarios.idCuentaUsuario = CuentasUsuarios.id
					    ) = 0
					ORDER BY CuentasUsuarios.id
				";
			
			$cuentasusuarios = $oMysql->consultaSel($sub_query);						
			
			foreach ($cuentasusuarios as $CuentaUsuario)
			{					
				$sub_query = 
				"
					SELECT 
					  	CuentasUsuarios.id as idCuentaUsuario,
					  	CuentasUsuarios.sNumeroCuenta,
					    Tarjetas.id as idTarjeta,
					    AjustesUsuarios.fImporteTotal as fAjuste,
					    Cupones.fImporte as fConsumo,
					    Cobranzas.fImporte as fCobranza
				 	FROM 
					    CuentasUsuarios
						LEFT JOIN Tarjetas ON Tarjetas.idCuentaUsuario = CuentasUsuarios.id 
						left join AjustesUsuarios on CuentasUsuarios.id = AjustesUsuarios.idCuentaUsuario 
						left JOIN Cupones on Tarjetas.id = Cupones.idTarjeta 
						left JOIN Cobranzas on Cobranzas.idCuentaUsuario = CuentasUsuarios.id
					WHERE
					   	(
					       	SELECT COUNT(DetallesCuentasUsuarios.id) 
					        FROM DetallesCuentasUsuarios 
					        WHERE DetallesCuentasUsuarios.idCuentaUsuario = CuentasUsuarios.id
					    ) = 0
					order by CuentasUsuarios.id
				";
			
				
				$sub_query =
				 		"
				 			select 
								LimitesEstandares.*
							from 
								CuentasLimites
							    left JOIN LimitesEstandares on CuentasLimites.idLimiteEstandar = LimitesEstandares.id
							where 
								CuentasLimites.idCuentaUsuario = {$CuentaUsuario['idCuentaUsuario']}
						";
				
				
				$limites = $oMysql->consultaSel($sub_query, true);	
				
				
				
				//--------------	Insertar el detalle ----------------------------------------------
				
				$setDetalle = 
					"
					idCuentaUsuario,
					idIVA,
					idModeloResumen,
					fAcumuladoConsumoCuota,
					fAcumuladoConsumoUnPago,
					fAcumuladoPrestamo,
					fImporteTotalPesos,
					fImporteTotalDolar,
					fImporteMinimoAnterior,
					fImporteMinimoActual,
					fInteresPunitorio,
					fInteresCompensatorio,fInteresFinanciacion,
					fLimiteCompra,
					fLimiteCredito,
					fLimiteFinanciacion,fLimiteAdelanto,fLimitePrestamo,fLimiteSMS,fLimiteGlobal,
					fRemanenteGlobal,
					fRemanenteCompra,
					fRemanenteCredito,
					fRemanenteAdelanto,
					fRemanentePrestamo,
					fRemanenteSMS,
					fSaldoAnterior,
					dFechaCierre,
					dFechaVencimiento,
					sEstado,
					iDiasMora,
					dPeriodo,
					fTasaPunitorioPeso,
					fTasaFinanciacionPeso,
					fTasaCompensatorioPeso,
					fTasaFinanciacionDolar,
					fTasaPunitorioDolar,
					fTasaCompensacionDolar,
					fAcumuladoAdelanto,
					fAcumuladoSMS,
					fAcumuladoCobranza,
					fAcumuladoCredito,
					fAcumuladoDebito,
					fAcumuladoAutorizacionCuota,
					fAcumuladoAutorizacionUnPago,
					fAcumuladoAutorizacionAdelanto,
					fAcumuladoAutorizacionSMS,
					iEmiteResumen,
					dFechaRegistro,
					dFechaMora
					";
				
				$valuesDetalle = 
					"
					'{$CuentaUsuario['idCuentaUsuario']}',
					1,
					1,
					0,
					0,
					0,
					0,
					0,
					0,
					0,
					0,
					0,
					0,
					'{$limites['iLimiteCompra']}',
					'{$limites['iLimiteCredito']}',
					'{$limites['iLimiteFinanciacion']}',
					'{$limites['iLimiteAdelanto']}',
					'{$limites['iLimitePrestamo']}',
					'{$limites['iLimiteSMS']}',
					'{$limites['iLimiteGlobal']}',
					'{$limites['iLimiteGlobal']}',
					'{$limites['iLimiteCompra']}',
					'{$limites['iLimiteCredito']}',
					'{$limites['iLimiteAdelanto']}',
					'{$limites['iLimitePrestamo']}',
					'{$limites['iLimiteSMS']}',
					0,					
					'{$Calendario['dFechaCierre']}',
					'{$Calendario['dFechaVencimiento']}',
					'NORMAL',
					0,
					'{$Calendario['dPeriodo']}',
					'{$Calendario['fTasaPunitorioPeso']}',
					'{$Calendario['fTasaFinanciacionPeso']}',
					'{$Calendario['fTasaCompensatorioPeso']}',
					'{$Calendario['fTasaFinanciacionDolar']}',
					'{$Calendario['fTasaPunitorioDolar']}',
					'{$Calendario['fTasaCompensacionDolar']}',
					0,
					0,
					0,
					0,
					0,
					0,
					0,
					0,
					0,
					0,
					'{$CuentaUsuario['dFechaRegistro']}',
					'{$Calendario['dFechaMora']}'
					";
				
				$ToAuditoryDetalle = "Insercion de Detalle  Cuenta de Usuario ::: Empleado ={$_SESSION['id_user']} ::: idCuentaUsuario ={$CuentaUsuario['idCuentaUsuario']}";
				$sql = "CALL usp_InsertTable(\"DetallesCuentasUsuarios\",\"$setDetalle\",\"$valuesDetalle\",\"{$_SESSION['id_user']}\",\"24\",\"$ToAuditoryDetalle\");";
			  	echo "$sql <br><br>";
				//$idDetalleCuenta = $oMysql->consultaSel($sql,true);
				
				//echo "idDetalle: $idDetalleCuenta"; 
			}
			
			echo "LA OPERACION SE REALIZO CORRECTAMENTE";


	
	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);	
?>