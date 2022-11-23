<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();
		
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
			
	//$sDocumento =  _decode($_GET['sd']);
	$idCuentaUsuario = $_GET['sd'];
	
	$fImporte = floatval($_GET['fi']);
	
		
		$dFechaRegistro =  date("Y-m-d h:i:s"); //date("Y-m-d h:i:s"); 
		$dFechaPresentacion = $dFechaRegistro;				
		$dFechaCobranza = date("Y-m-d");
			
		$fecha = getdate();
				
		$sNumeroRecibo =$oMysql->consultaSel("select fnc_getNroReciboCobranza(\"{$_SESSION['ID_OFICINA']}\");",true);
		$aNumero = explode('-', $sNumeroRecibo);		
		$sCodigoBarra = $aNumero[0]. $aNumero[1].number_pad($fecha['mday'],2).number_pad($fecha['mon'],2).$fecha['year'].number_pad($fecha['hours'],2).number_pad($fecha['minutes'],2).number_pad($fecha['seconds'],2);

		      
	  	   $set ="
	  	   		idCuentaUsuario,
	  	   		idListadoCobranza,
	  	   		idEmpleado,
	  	   		idTipoMoneda,
	  	   		dFechaCobranza,
	  	   		dFechaPresentacion,
	  	   		dFechaRegistro,
	  	   		fImporte,
	  	   		sEstado,
	  	   		iEstadoFacturacionUsuario,
	  	   		idOficina,
	  	   		sNroRecibo,
	  	   		sCodigoBarra
	  	   		";
	  	     	   		
		   $values = "
		   		'{$idCuentaUsuario}',
		   		'0',
		   		'{$_SESSION['id_user']}',
		   		'1',
		   		'{$dFechaCobranza}',
			   	'{$dFechaPresentacion}',
		   		'{$dFechaRegistro}',
		   		'{$fImporte}',
		   		'A',
		   		'0',
				   	'{$_SESSION['ID_OFICINA']}',
				   	'{$sNumeroRecibo}', 			   	
				   	'{$sCodigoBarra}'
		   	";
		   	 
		  //$oRespuesta->alert($set. " " . $values);
		   
		  $ToAuditory = "Insercion de Cobranzas ::: Empleado ={$_SESSION['id_user']}";
		   
		  //$id = $oMysql->consultaSel("CALL usp_InsertTable(\"Cobranzas\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"67\",\"$ToAuditory\");",true);   
		$id = 1;
		  #Actualizar Acumulado de Cobranza en la cuenta de usuario		   
		 // $oMysql->consultaSel("CALL usp_updateCobranzaCuentaUsuario(\"{$idCuentaUsuario}\",\"{$fImporte}\");",true);
	    
		 
		 
		if($id > 0)
		{	
			//RecalcularLimites_CA($idCuentaUsuario);	
			setEstadoCuentaUsuarioByCobranza_CA_Prueba($idCuentaUsuario);
		}


	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);	
?>





<?
	function setEstadoCuentaUsuarioByCobranza_CA_Prueba($idCuentaUsuario)
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
			return;
		}
		
		
		//--------------- Obtener detalle cuenta usuario ----------------------------
		$sCondiciones = "WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$idCuentaUsuario}	ORDER BY DetallesCuentasUsuarios.id DESC LIMIT 0,2 ;";		
		$datosDetalle = $oMysql->consultaSel("CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");");
		
		
		if(!$datosDetalle)
		{
			return;			
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
			
			
			echo "Acumulado cobranza: " . round($datosDetalle[0]['fAcumuladoCobranza'],2) . "<br>";
			echo "Porcentaje pagado: " . round($PorcentajePagado) . "<br><br>";
			
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
									
				$idEstadoCuentaActual = $CuentaUsuario['idTipoEstadoCuenta'];
				$idNuevoEstadoCuenta = 0;
				
				
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
				
			#--------------------- Actualizar los dias de mora y estado del usuario ----------------------------
				$set = "iDiasMora = '{$iDiasMoraNuevo}', idTipoEstadoCuenta = '{$idNuevoEstadoCuenta}'";
			    $conditions = "DetallesCuentasUsuarios.id = '{$datosDetalle[0]['id']}'";
			    	
				$ToAuditory = "Actualizacion Cuenta Usuario ::: Empleado ={$_SESSION['id_user']} - Dias de Mora: {$iDiasMoraNuevo} - Estado: {$idNuevoEstadoCuenta}";
				   
				//$id = $oMysql->consultaSel("CALL usp_updateEstadoCuentaUsuario(\"$iDiasMoraNuevo\",\"$idNuevoEstadoCuenta\",\"$idCuentaUsuario\",\"{$datosDetalle[0]['id']}\",\"{$_SESSION['id_user']}\");",true);			
				 
				echo  "CALL usp_updateEstadoCuentaUsuario(\"$iDiasMoraNuevo\",\"$idNuevoEstadoCuenta\",\"$idCuentaUsuario\",\"{$datosDetalle[0]['id']}\",\"{$_SESSION['id_user']}\");";
							
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
			   
			   		//$id = $oMysql->consultaSel("CALL usp_InsertTable(\"Morosidad\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"70\",\"$ToAuditory\");",true);   	
		}
		
		return;
	}
?>