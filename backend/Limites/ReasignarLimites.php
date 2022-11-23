<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	//session_start();
	
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
	
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
	//$mysql->setDBName("AccesosSistemas");
	
	$_GET['id'] = base64_decode($_GET['id']);
	if($_GET['id'])
	{		
		$sCondiciones = " WHERE CuentasUsuarios.id = {$_GET['id']} ORDER BY CuentasUsuarios.id DESC LIMIT 0,1";
		$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondiciones\");";		
		$rsCuenta = $oMysql->consultaSel($sqlDatos,true);
		
		$sCondicionesDetalles = " WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$_GET['id']} ORDER BY DetallesCuentasUsuarios.id DESC LIMIT 0,1";
		$sql = "CALL usp_getDetallesCuentasUsuarios(\"$sCondicionesDetalles\")";
		$rsDetalle = $oMysql->consultaSel($sql, true);
		
		$rsLimiteActual = $oMysql->consultaSel("SELECT CuentasLimites.idEmpleado,LimitesEstandares.sDescripcion as 'sDescripcion', IFNULL(DATE_FORMAT(CuentasLimites.dFechaRegistro,'%d/%m/%Y  %H:%i'),'') as 'dFechaRegistro',CuentasLimites.idLimiteEstandar FROM CuentasLimites LEFT JOIN LimitesEstandares ON LimitesEstandares.id = CuentasLimites.idLimiteEstandar	WHERE CuentasLimites.idCuentaUsuario={$_GET['id']} ORDER BY CuentasLimites.id DESC LIMIT 0,1",true);
		
		$sCondiciones = " WHERE LimitesEstandares.id = {$rsLimiteActual['idLimiteEstandar']}";
		$sqlDatos="Call usp_getLimites(\"$sCondiciones\");";		
		$rs = $oMysql->consultaSel($sqlDatos,true);
		
		$rsCuentasLimites = $oMysql->consultaSel("SELECT CuentasLimites.idEmpleado,LimitesEstandares.sDescripcion as 'sDescripcion', IFNULL(DATE_FORMAT(CuentasLimites.dFechaRegistro,'%d/%m/%Y  %H:%i'),'') as 'dFechaRegistro'
						FROM CuentasLimites
						LEFT JOIN LimitesEstandares ON LimitesEstandares.id = CuentasLimites.idLimiteEstandar
						WHERE CuentasLimites.idCuentaUsuario={$_GET['id']} ORDER BY CuentasLimites.dFechaRegistro DESC");
		
		$sUsuario = "";
		if($rsCuenta['iTipoPersona'] == 1){
			$sUsuario .= $rsCuenta['sApellido'].', '.$rsCuenta['sNombre'];
		}else{
			$sUsuario .= $rsCuenta['sRazonSocial'];			
		}			
		$idTarjetaCredito = $oMysql->consultaSel("SELECT Tarjetas.id FROM Tarjetas WHERE idCuentaUsuario='{$_GET['id']}' AND iVersion=0", true);
		
		$aParametros['NUMERO_CUENTA'] = $rsCuenta['sNumeroCuenta'];
		$aParametros['TITULAR'] = $sUsuario;
		$aParametros['ID_CUENTA_USUARIO'] = $_GET['id'];
		$aParametros['ID_DETALLE_CUENTA'] = $rsDetalle['id'];		
		$aParametros['ID_TARJETA'] = $idTarjetaCredito;
		
		$aParametros['ID_LIMITE'] = $rsLimiteActual['idLimiteEstandar'];
		$aParametros['FECHA_LIMITE'] = $rsLimiteActual['dFechaRegistro'];
		
		$aParametros['DESCRIPCION'] = html_entity_decode($rs['sDescripcion']);
		$aParametros['LIMITE_COMPRA'] = $rs['iLimiteCompra'];
		$aParametros['LIMITE_CREDITO'] = $rs['iLimiteCredito'];
		$aParametros['LIMITE_PORCENTAJE_FINANCIACION'] = $rs['iLimitePorcentajeFinanciacion'];
		$aParametros['LIMITE_FINANCIACION'] = $rs['iLimiteFinanciacion'];
		$aParametros['LIMITE_PORCENTAJE_PRESTAMO'] = $rs['iLimitePorcentajePrestamo'];
		$aParametros['LIMITE_PRESTAMO'] = $rs['iLimitePrestamo'];
		$aParametros['LIMITE_PORCENTAJE_ADELANTO'] = $rs['iLimitePorcentajeAdelanto'];
		$aParametros['LIMITE_ADELANTO'] = $rs['iLimiteAdelanto'];
		$aParametros['LIMITE_PORCENTAJE_SMS'] = $rs['iLimitePorcentajeSMS'];
		$aParametros['LIMITE_SMS'] = $rs['iLimiteSMS'];
		$aParametros['LIMITE_GLOBAL'] = $rs['iLimiteGlobal'];
		
		$aParametros['REMANENTE_CUOTAS'] = number_format((double)$rsDetalle['fRemanenteCredito'],2,'.','');
		$aParametros['REMANENTE_COMPRA'] = number_format((double)$rsDetalle['fRemanenteCompra'],2,'.','');
		$aParametros['REMANENTE_ADELANTO'] = number_format((double)$rsDetalle['fRemanenteAdelanto'],2,'.','');
		$aParametros['REMANENTE_PRESTAMO'] = number_format((double)$rsDetalle['fRemanentePrestamo'],2,'.','');
		$aParametros['REMANENTE_SMS'] = number_format((double)$rsDetalle['fRemanenteSMS'],2,'.','');
		$aParametros['REMANENTE_GLOBAL'] = number_format((double)$rsDetalle['fRemanenteGlobal'],2,'.','');
		$aPeriodo = explode("/",$rsDetalle['dPeriodo']);
		
		$aParametros['PERIODO'] = $aPeriodo[1]."/".$aPeriodo[2];
		
		if($rs['iLimiteCredito']>0){
			$sCondicionLimites = " LimitesEstandares.sEstado<>'B' AND LimitesEstandares.iLimiteCredito >= {$rs['iLimiteCredito']}";			
		}else{
			$sCondicionLimites = " LimitesEstandares.sEstado<>'B'";
		}
		
		$aParametros['optionsLimites'] = $oMysql->getListaOpciones( 'LimitesEstandares', 'id', 'sDescripcion',$rsLimiteActual['idLimiteEstandar'],$sCondicionLimites,'',' LimitesEstandares.iLimiteCredito DESC');
		
		
		$sCadena .= "<table class='TablaGeneral' cellpadding='0' cellspacing='0' border='1' bordercolor='#000000' width='100%' style='font-size:11px'>
			<tr class='filaPrincipal'>
				<th style='height:25px;text-align:left'>Limite</th>
				<th style='height:25px;text-align:left'>Fecha de Registro</th>
				<th style='height:25px;text-align:left'>Operador</th>
				<th style='height:25px;text-align:left'>Oficina</th>
				<th style='height:25px;text-align:left'>Sucursal</th>
				<th style='height:25px;text-align:left'>Region</th>
			</tr>";
		
		$sEmpleado = " - ";
		foreach ($rsCuentasLimites as $rs ){	
			$rsEmpleado = $oMysql->consultaSel("SELECT CONCAT(Empleados.sApellido,', ', Empleados.sNombre) as 'sEmpleado',Oficinas.sApodo as 'sOficina',Sucursales.sNombre as 'sSucursal',Regiones.sNombre as 'sRegion'
								FROM Empleados 
								LEFT JOIN Oficinas ON Oficinas.id=Empleados.idOficina
								LEFT JOIN Sucursales ON Sucursales.id=Oficinas.idSucursal
								LEFT JOIN Regiones ON Regiones.id=Sucursales.idRegion
								WHERE Empleados.id={$rs['idEmpleado']}",true);
			$sCadena .= "
			<tr>
				<td width='25%' align='left'>&nbsp;{$rs['sDescripcion']}</td>
				<td width='15%' align='left'>&nbsp;{$rs['dFechaRegistro']}</td>
				<td width='15%' align='left'>&nbsp;".html_entity_decode($rsEmpleado['sEmpleado'])."</td>
				<td width='15%' align='left'>&nbsp;".html_entity_decode($rsEmpleado['sOficina'])."</td>
				<td width='10%' align='left'>&nbsp;".html_entity_decode($rsEmpleado['sSucursal'])."</td>
				<td width='10%' align='left'>&nbsp;{$rsEmpleado['sRegion']}</td>
			</tr>	
			";				
		}
		$sCadena .="</tr></table>";
		$aParametros['HISTORIAL'] = $sCadena;
	}
	
	function mostrarLimites($form){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$sCondiciones1 = " WHERE LimitesEstandares.id = '{$form['idLimiteActual']}'";
		$sqlDatos="Call usp_getLimites(\"$sCondiciones1\");";
		$rsActual = $oMysql->consultaSel($sqlDatos,true);
		
		$sCondiciones2 = " WHERE LimitesEstandares.id = {$form['idLimite']}";
		$sqlDatos="Call usp_getLimites(\"$sCondiciones2\");";
		$rs = $oMysql->consultaSel($sqlDatos,true);
		
		$sCondicionesDetalles = " WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$form['idCuentaUsuario']} ORDER BY DetallesCuentasUsuarios.id DESC LIMIT 0,1";
		$sql = "CALL usp_getDetallesCuentasUsuarios(\"$sCondicionesDetalles\")";
		$rsDetalle = $oMysql->consultaSel($sql, true);
		
		$oRespuesta->assign("lbliLimiteCompra","innerHTML","$ ".$rs['iLimiteCompra']);
		$oRespuesta->assign("hdnLimiteCompra","value",$rs['iLimiteCompra']);
		$oRespuesta->assign("lbliLimiteCredito","innerHTML","$ ".$rs['iLimiteCredito']);
		$oRespuesta->assign("hdnLimiteCredito","value",$rs['iLimiteCredito']);
		$oRespuesta->assign("lbliLimitePorcentajeFinanciacion","innerHTML","".$rs['iLimitePorcentajeFinanciacion']);		
		$oRespuesta->assign("lblLimiteFinanciacion","innerHTML","$ ".$rs['iLimiteFinanciacion']);
		$oRespuesta->assign("hdnLimiteFinanciacion","value",$rs['iLimiteFinanciacion']);
		$oRespuesta->assign("lbliLimitePorcentajePrestamo","innerHTML","".$rs['iLimitePorcentajePrestamo']);
		$oRespuesta->assign("lblLimitePrestamo","innerHTML","$ ".$rs['iLimitePrestamo']);
		$oRespuesta->assign("hdnLimitePrestamo","value",$rs['iLimitePrestamo']);
		$oRespuesta->assign("lbliLimitePorcentajeAdelanto","innerHTML","".$rs['iLimitePorcentajeAdelanto']);
		$oRespuesta->assign("lblLimiteAdelanto","innerHTML","$ ".$rs['iLimiteAdelanto']);
		$oRespuesta->assign("hdnLimiteAdelanto","value",$rs['iLimiteAdelanto']);
		$oRespuesta->assign("lbliLimitePorcentajeSMS","innerHTML","".$rs['iLimitePorcentajeSMS']);
		$oRespuesta->assign("lblLimiteSMS","innerHTML","$ ".$rs['iLimiteSMS']);
		$oRespuesta->assign("hdnLimiteSMS","value",$rs['iLimiteSMS']);
		$oRespuesta->assign("lbliLimiteGlobal","innerHTML","$ ".$rs['iLimiteGlobal']);
		$oRespuesta->assign("hdnLimiteGlobal","value",$rs['iLimiteGlobal']);
		
		$fRemanenteCuota = $rsDetalle['fRemanenteCredito'] + ($rs['iLimiteCredito']-$rsActual['iLimiteCredito']);
		$fRemanenteCompra = $rsDetalle['fRemanenteCompra'] + ($rs['iLimiteCompra']-$rsActual['iLimiteCompra']);
		$fRemanenteAdelanto = $rsDetalle['fRemanenteAdelanto'] + ($rs['iLimiteAdelanto']-$rsActual['iLimiteAdelanto']);
		$fRemanentePrestamo = $rsDetalle['fRemanentePrestamo'] + ($rs['iLimitePrestamo']-$rsActual['iLimitePrestamo']);
		$fRemanenteSMS = $rsDetalle['fRemanenteSMS'] + ($rs['iLimiteSMS']-$rsActual['iLimiteSMS']);
		$fRemanenteGlobal = $rsDetalle['fRemanenteGlobal'] + ($rs['iLimiteGlobal']-$rsActual['iLimiteGlobal']);
		
		//$oRespuesta->alert($fRemanenteCuota.' - '.$fRemanenteCompra.' - '.$rs['iLimiteCredito'].' - '.$rsActual['iLimiteCredito'] );
		
		$oRespuesta->assign("lblRemanenteCuota","innerHTML",number_format((double)$fRemanenteCuota,2,'.',''));
		$oRespuesta->assign("hdnRemanenteCuota","value",$fRemanenteCuota);
		$oRespuesta->assign("lblRemanenteCompra","innerHTML",number_format((double)$fRemanenteCompra,2,'.',''));
		$oRespuesta->assign("hdnRemanenteCompra","value",$fRemanenteCompra);
		$oRespuesta->assign("lblRemanenteAdelanto","innerHTML",number_format((double)$fRemanenteAdelanto,2,'.',''));
		$oRespuesta->assign("hdnRemanenteAdelanto","value",$fRemanenteAdelanto);
		$oRespuesta->assign("lblRemanentePrestamo","innerHTML",number_format((double)$fRemanentePrestamo,2,'.',''));
		$oRespuesta->assign("hdnRemanentePrestamo","value",$fRemanentePrestamo);
		$oRespuesta->assign("lblRemanenteSMS","innerHTML",number_format((double)$fRemanenteSMS,2,'.',''));
		$oRespuesta->assign("hdnRemanenteSMS","value",$fRemanenteSMS);
		$oRespuesta->assign("lblRemanenteGlobal","innerHTML",number_format((double)$fRemanenteGlobal,2,'.',''));
		$oRespuesta->assign("hdnRemanenteGlobal","value",$fRemanenteGlobal);
		return  $oRespuesta;
	}
	
	function updateDatosCuentasLimites($form){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		//var_export($form);die();
		
		$setLimite = "idLimiteEstandar,idEmpleado,idCuentaUsuario,dFechaRegistro";
	    $valuesLimite = "{$form['idLimite']},{$_SESSION['id_user']},{$form['idCuentaUsuario']},NOW()";	    
	    $idCuentaLimite= $oMysql->consultaSel("CALL usp_InsertValues(\"CuentasLimites\",\"$setLimite\",\"$valuesLimite\");",true); 	    
	   
	    $msje= "";
	    if(!$idCuentaLimite){
	    	$msje= "La operacion no se pudo realizar correctamente";
	    }else{
	    	 //$oRespuesta->alert($form['idDetalleCuentaUsuario']);
	    	 $set = "fLimiteCompra={$form['hdnLimiteCompra']},
	    		fLimiteCredito={$form['hdnLimiteCredito']},
	    		fLimiteFinanciacion={$form['hdnLimiteFinanciacion']},
	    		fLimiteAdelanto={$form['hdnLimiteAdelanto']},
	    		fLimitePrestamo={$form['hdnLimitePrestamo']},
	    		
	    		fLimiteGlobal={$form['hdnLimiteGlobal']},
	    		fRemanenteCredito={$form['hdnRemanenteCuota']},
	    		fRemanenteCompra={$form['hdnRemanenteCompra']},
	    		fRemanenteAdelanto={$form['hdnRemanenteAdelanto']},
	    		fRemanentePrestamo={$form['hdnRemanentePrestamo']},
	    		
	    		fRemanenteGlobal={$form['hdnRemanenteGlobal']}"; //fLimiteSMS={$form['hdnLimiteSMS']}, //fRemanenteSMS={$form['hdnRemanenteSMS']},
	    	 
	    	 
		    $conditions = "DetallesCuentasUsuarios.id = '{$form['idDetalleCuentaUsuario']}'";
			$ToAuditory = "Modificacion de DetallesCuentasUsuarios ::: Empleado ={$_SESSION['id_user']} ::: idCuentaUsuario={$form['idCuentaUsuario']}";		
			$sConsulta="CALL usp_UpdateTable(\"DetallesCuentasUsuarios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"25\",\"$ToAuditory\");";
			
			//echo $sConsulta;
			
			$id = $oMysql->consultaSel($sConsulta,true);  
		    /*if(!$id){
		    	$msje= "La operacion no se pudo realizar correctamente";	
		    }else{*/
		    	$msje= "La operacion se realizo correctamente";
		    //} 
	    }
	    $oRespuesta->alert($msje);
	    $oRespuesta->redirect("ReasignarLimites.php?id=".base64_encode($form['idCuentaUsuario']));
		return  $oRespuesta;
	}
	
	$oXajax=new xajax();
	$oXajax->registerFunction("mostrarLimites");
	$oXajax->registerFunction("updateDatosCuentasLimites");	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");	
	
	xhtmlHeaderPaginaGeneral($aParametros);	

	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Limites/ModificarLimites.tpl",$aParametros);
	
	echo xhtmlFootPagina();	
?>