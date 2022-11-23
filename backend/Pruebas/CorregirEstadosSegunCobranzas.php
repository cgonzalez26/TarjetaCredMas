<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	//session_start();
		
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
			
	echo "CorregirEstadosSegunCobranzas.php <br>";	
	
				$estado_cuenta_normal = 1;
				$estado_cuenta_moroso_1_mes = 3;
				$estado_cuenta_moroso_2_mes = 4;
				$estado_cuenta_moroso_3_mes = 5;
				$estado_cuenta_inhabilitada = 10;
				$estado_cuenta_inhabilitada_con_cobranza = 13;
				$estado_cuenta_previsionada = 11;
				$estado_cuenta_previosionada_con_cobranza = 14;		
				
				
													
				$sub_query = 
				" WHERE CuentasUsuarios.idTipoEstadoCuenta in (3,4,5) ";
					

				$cuentasusuarios = $oMysql->consultaSel("CALL usp_getCuentasUsuarios(\"$sub_query\");");		
								
						
				$sMensaje = "";
				$sMensajeNuevoEstado = "";
				$idTipoEstadoNuevo = 0;
				
				$iCantidad = 0;
					
				foreach ($cuentasusuarios as $cuentausuario)
				{	
					//echo "entro <br>";
					$idCuentaUsuario = $cuentausuario['id'];
					$iCantidad += _setEstadoCuentaUsuarioByCobranza_($idCuentaUsuario);

				}//foreach 

				
				
				echo "Modificados " . $iCantidad;
				
	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);	
?>

<?
	
function insertar_($idCuentaUsuario, $idDetalleCuentaUsuario, $iDiasMora, $idTipoEstadoCuenta, $iDiasMoraAnterior, $idTipoEstadoCuentaAnterior, $porcentajePagado)
	{
		Global $oMysql;
		
		$porcentajePagado = round($porcentajePagado,2);
		
		$sConsulta = 
					"
						INSERT INTO 0_CuentasModificadasCobranzas
						(
							idCuentaUsuario, 
							idDetalleCuentaUsuario, 
							iDiasMora,							
							idTipoEstadoCuenta,
							iDiasMoraAnterior, 
							idTipoEstadoCuentaAnterior,
							fPorcentajePagado
						)
						VALUES 
						(
							$idCuentaUsuario, 
							'$idDetalleCuentaUsuario', 
							'$iDiasMora',
							'$idTipoEstadoCuenta',
							'$iDiasMoraAnterior',
							'$idTipoEstadoCuentaAnterior',
							'$porcentajePagado'
						)
					";
		//echo $sConsulta;
		$oMysql->consultaSel($sConsulta);
	}





	function _setEstadoCuentaUsuarioByCobranza_($idCuentaUsuario)
	{
		GLOBAL $oMysql;	
		
		$estado_NORMAL = 1;
		$estado_MOROSO_1_MES = 3;
		$estado_MOROSO_2_MESES = 4;
		$estado_MOROSO_3_MESES = 5;
		$estado_INHABILITADA = 10;
		$estado_INHABILITADA_CON_COBRANZAS = 13;
		$estado_PREVISIONADA = 11;
		$estado_PREVISIONADA_CON_COBRANZAS = 14;
		$estado_PRELEGALES = 15;
		$estado_GESTION_JUDICIAL = 16;
		
		$bModificarEstado = false;		
		$idTipoEstadoCuenta = 0;
		$idNuevoEstadoCuenta = 0;
		$iDiasMoraNuevo = 0;
		$bEstadoModificado = false;
		
		
		//-------------- Obtener cuenta usuario -------------------------------------
		$sCondicionCuentaUsuario = "WHERE CuentasUsuarios.id = {$idCuentaUsuario};";		
		$CuentaUsuario = $oMysql->consultaSel("CALL usp_getCuentasUsuarios(\"$sCondicionCuentaUsuario\");",true);			
		
		
		if($CuentaUsuario['idTipoEstadoCuenta'] == $estado_INHABILITADA || $CuentaUsuario['idTipoEstadoCuenta'] == $estado_PRELEGALES || $CuentaUsuario['idTipoEstadoCuenta'] == $estado_GESTION_JUDICIAL)
		{
			return 0;
		}
		
		
		//--------------- Obtener detalle cuenta usuario ----------------------------
		$sCondiciones = "WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$idCuentaUsuario}	ORDER BY DetallesCuentasUsuarios.id DESC LIMIT 0,2 ;";		
		$datosDetalle = $oMysql->consultaSel("CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");");
		
		//$oRespuesta->alert("CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");");
		
		if(!$datosDetalle)
		{
			return 0;		
		}
		
		
		if($CuentaUsuario)	
		{			
			//$diferencia = $datosDetalle[0]["fSaldoAnterior"] - $datosDetalle[0]['fAcumuladoCobranza'];
			//$idTipoEstadoCuenta = $CuentaUsuario['idTipoEstadoCuenta'];
			
			$PorcentajePagado = ($datosDetalle[0]['fAcumuladoCobranza'] * 100) / $datosDetalle[0]["fSaldoAnterior"];
				
			//CONSIDERAR DESPUES DE HACER LA COBRANZA SI EL % DE ACUMULADO DE COBRANZAS 
			//SE ENCUENTRA ENTRE EL 50% Y EL 80%, VOLVER AL ESTADO ANTERIOR
			//SI PAGO MAS DEL 80% VOLVER A NORMAL
			//EN CASO DE ESTAR EN ESTADO: INHABILITADO, PRELEGALES O GESTION JUDICIAL NOOO REALIZAR ESTA VALIDACION			
			
			$idEstadoCuentaActual = $CuentaUsuario['idTipoEstadoCuenta'];
			$idNuevoEstadoCuenta = 0;
				
			if($PorcentajePagado >= 50 && $PorcentajePagado <= 80)
			{
				//VOLVER LA CUENTA AL ESTADO ANTERIOR
				//$idNuevoEstadoCuenta = 3; //MOROSO 1 MES
				
				$dFechaVencimiento = dateToMySql($datosDetalle[0]['dFechaVencimiento']);									
				$dFechaVencimientoActual =  $oMysql->consultaSel("SELECT fnc_getFechaVencimientoAnterior(\"{$dFechaVencimiento}\",\"{$datosDetalle[0]['idCuentaUsuario']}\",\"{$CuentaUsuario['idGrupoAfinidad']}\");",true);
									
				$dFechaMoraActual = dateToMySql($datosDetalle[0]['dFechaMora']);									
				$dFechaCorridaMoraActual =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraActual}\",\"{$datosDetalle[0]['idCuentaUsuario']}\",\"{$CuentaUsuario['idGrupoAfinidad']}\");",true);
				
				$dFechaMoraAnterior = dateToMySql($datosDetalle[1]['dFechaMora']);									
				$dFechaCorridaMoraAnterior =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraAnterior}\",\"{$datosDetalle[1]['idCuentaUsuario']}\",\"{$CuentaUsuario['idGrupoAfinidad']}\");",true);
									
				
				
				
				if($idEstadoCuentaActual == $estado_MOROSO_1_MES)
				{
					$idNuevoEstadoCuenta = $estado_NORMAL; 
					$iDiasMoraNuevo = 0;	
					$bModificarEstado = true;
				}
				elseif ($idEstadoCuentaActual == $estado_MOROSO_2_MESES)
				{
					$idNuevoEstadoCuenta = $estado_MOROSO_1_MES;
					$iDiasMoraNuevo = $datosDetalle[0]['iDiasMora'] - getDias($dFechaCorridaMoraActual, $dFechaCorridaMoraAnterior);	
					$bModificarEstado = true;
				} 
				elseif($idEstadoCuentaActual == $estado_MOROSO_3_MESES)
				{
					$idNuevoEstadoCuenta = $estado_MOROSO_2_MESES;
					$iDiasMoraNuevo = $datosDetalle[0]['iDiasMora'] - getDias($dFechaCorridaMoraActual, $dFechaCorridaMoraAnterior);	
					$bModificarEstado = true;
				}		
			}
			else if($PorcentajePagado >= 80) //Si el porcentaje que pago supera el 80% de la deuda se cambia el estado a NORMAL Independientemente del estado anterior en el que se encontraba
			{
				$idNuevoEstadoCuenta = $estado_NORMAL; 
				$iDiasMoraNuevo = 0;	
				$bModificarEstado = true;
			}
			
		}
		
					
		if($bModificarEstado)
		{
			if($iDiasMoraNuevo > 0)
				$iDiasMoraNuevo -= 1; 
			
			$iDiasMoraAnterior = $datosDetalle[0]['iDiasMora'];
				//$oRespuesta->alert("entro a modificar cuenta de usuario");
				//var_export("entro a modificar cuenta de usuario");
				
			#--------------------- Actualizar los dias de mora y estado del usuario ----------------------------
				$set = "iDiasMora = '{$iDiasMoraNuevo}', idTipoEstadoCuenta = '{$idNuevoEstadoCuenta}'";
			    $conditions = "DetallesCuentasUsuarios.id = '{$datosDetalle[0]['id']}'";
			    	
				$ToAuditory = "Actualizacion Cuenta Usuario ::: Empleado ={$_SESSION['id_user']} - Dias de Mora: {$iDiasMoraNuevo} - Estado: {$idNuevoEstadoCuenta}";
				   
				$id = $oMysql->consultaSel("CALL usp_updateEstadoCuentaUsuario(\"$iDiasMoraNuevo\",\"$idNuevoEstadoCuenta\",\"$idCuentaUsuario\",\"{$datosDetalle[0]['id']}\",\"{$_SESSION['id_user']}\");",true);			
								 				
				#-------------------- Insertar en la tabla Morosidad ------------------------------- 
				$dFechaRegistro = date("Y-m-d h:i:s"); 
				
				 $set ="
			  	   		idCuentaUsuario,
			  	   		iDiasMoraActual,
			  	   		iDiasMoraNueva,
			  	   		fImportePagoMinimo,
			  	   		fImporteTotalResumenUsuario,
			  	   		fImporteTotalCobranzasUsuario,
			  	   		dFechaRegistro,
			  	   		idEmpleado,
			  	   		idEstadoCuentaActual,
			  	   		idEstadoCuentaNuevo";
			  	     	   		
				   $values = "
				   		'{$idCuentaUsuario}',
				   		'{$datosDetalle[0]['iDiasMora']}',
				   		'{$iDiasMoraNuevo}',
				   		'0',
				   		'{$datosDetalle[0]['fImporteTotalPesos']}',
					   	'{$datosDetalle[0]['fAcumuladoCobranza']}',
				   		'{$dFechaRegistro}',
				   		'{$_SESSION['id_user']}',
				   		'{$idEstadoCuentaActual}',
				   		'{$idNuevoEstadoCuenta}'		   		
				   	";
				   	 
				   
			   		$ToAuditory = "Insercion de Morosidad ::: Empleado ={$_SESSION['id_user']}";
			   
			   		$id = $oMysql->consultaSel("CALL usp_InsertTable(\"Morosidad\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"70\",\"$ToAuditory\");",true);   	
			   		
			   		insertar_($idCuentaUsuario, $datosDetalle[0]['id'], $iDiasMoraNuevo,$idNuevoEstadoCuenta, $iDiasMoraAnterior, $idEstadoCuentaActual,$PorcentajePagado);
			   		
			   		return 1;
		}
		else 
		{
			return 0;
		}
	}
?>