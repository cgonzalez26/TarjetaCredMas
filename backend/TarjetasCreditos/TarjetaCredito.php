<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);		
	$idTarjeta = $_GET['id'];	
	
	if($idTarjeta){
		$sCondiciones= " WHERE Tarjetas.id = {$idTarjeta} ";
		$sqlDatos="Call usp_getTarjetas(\"$sCondiciones\");";
		$rs = $oMysql->consultaSel($sqlDatos,true);	
		
		$rsEmbozo = $oMysql->consultaSel("SELECT IFNULL(DATE_FORMAT(EstadosTarjetas.dFechaRegistro,'%d/%m/%Y'),'') as 'dFechaRegistro' FROM EstadosTarjetas WHERE EstadosTarjetas.idTarjeta='{$idTarjeta}' AND EstadosTarjetas.idTipoEstadoTarjeta=2 ORDER BY EstadosTarjetas.dFechaRegistro DESC LIMIT 0,1",true);
		$rsEntrega = $oMysql->consultaSel("SELECT IFNULL(DATE_FORMAT(EstadosTarjetas.dFechaRegistro,'%d/%m/%Y'),'') as 'dFechaRegistro' FROM EstadosTarjetas WHERE EstadosTarjetas.idTarjeta='{$idTarjeta}' AND EstadosTarjetas.idTipoEstadoTarjeta=4 ORDER BY EstadosTarjetas.dFechaRegistro DESC LIMIT 0,1",true);
		$rsEstado = $oMysql->consultaSel("SELECT IFNULL(DATE_FORMAT(EstadosTarjetas.dFechaRegistro,'%d/%m/%Y'),'') as 'dFechaRegistro' FROM EstadosTarjetas WHERE EstadosTarjetas.idTarjeta='{$idTarjeta}' AND EstadosTarjetas.idTipoEstadoTarjeta={$rs['idTipoEstadoTarjeta']} ORDER BY EstadosTarjetas.dFechaRegistro DESC LIMIT 0,1",true);
		if(!$rsEmbozo) $rsEmbozo = " - ";
		if(!$rsEntrega) $rsEntrega = " - ";
		if(!$rsEstado) $rsEstado = " - ";		
		
		$sCondicionesCuentas= " WHERE CuentasUsuarios.id = {$rs['idCuentaUsuario']} ";
		$sqlCuenta="Call usp_getCuentasUsuarios(\"$sCondicionesCuentas\");";
		$rsCuenta = $oMysql->consultaSel($sqlCuenta,true);	
		
		$rsDetalleCuentas = $oMysql->consultaSel("SELECT fRemanenteCompra,fRemanenteCredito,fRemanenteAdelanto,fRemanentePrestamo,fRemanenteSMS,fLimiteGlobal FROM DetallesCuentasUsuarios WHERE idCuentaUsuario='{$rs['idCuentaUsuario']}' ORDER BY DetallesCuentasUsuarios.id DESC",true);
		
		$aParametros['NUMERO_TARJETA'] = $rs['sNumeroTarjeta'];
		$aParametros['NUMERO_CUENTA'] = $rs['sNumeroCuenta'];
		$aParametros['NUMERO_TITULAR'] = $rs['sNumeroTarjeta'][13];
		$aParametros['NUMERO_VERSION'] = $rs['sNumeroTarjeta'][14];
		$aParametros['NUMERO_DIGITO_VERIFICADOR'] = $rs['sNumeroTarjeta'][15];
		$sUsuario = "";
		if($rs['iTipoPersona'] == 1)
			$sUsuario .= $rs['sApellido'].', '.$rs['sNombre'];
		else 	
			$sUsuario .= $rs['sRazonSocial'];
		$aParametros['TITULAR'] = $sUsuario;
		$aParametros['GRUPO_AFINIDAD'] = $rs['dFechaRegistro'];
		$aParametros['FECHA_ALTA'] = $rs['dFechaRegistro'];
		$aParametros['FECHA_INICIO_VIGENCIA'] = $rs['dVigenciaDesde'];
		$aParametros['FECHA_VTO_VIGENCIA'] = $rs['dVigenciaHasta'];
		$aParametros['ESTADO'] = $rs['sEstado'];
		$aParametros['FECHA_ESTADO'] = $rsEstado;
		$aParametros['FECHA_EMBOZO'] = $rsEmbozo;
		$aParametros['FECHA_ENTREGA'] = $rsEntrega;
		$aParametros['GRUPO_AFINIDAD'] = $rsCuenta['sGrupoAfinidad'];
		$aParametros['REMANENTE_COMPRA'] = "$ " . $rsDetalleCuentas['fRemanenteCompra'];
		$aParametros['REMANENTE_CREDITO'] = "$ " .$rsDetalleCuentas['fRemanenteCredito'];
		$aParametros['REMANENTE_FINANCIACION'] = "$ " .$rsDetalleCuentas['fRemanenteFinanciacion'];
		$aParametros['REMANENTE_ADELANTO'] = "$ " .$rsDetalleCuentas['fRemanenteAdelanto'];
		$aParametros['REMANENTE_PRESTAMO'] = "$ " .$rsDetalleCuentas['fRemanentePrestamo'];
		$aParametros['REMANENTE_SMS'] = "$ " .$rsDetalleCuentas['fRemanenteSMS'];
		$aParametros['REMANENTE_GLOBAL'] = "$ " .$rsDetalleCuentas['fLimiteGlobal'];
	}
	
	xhtmlHeaderPaginaGeneral($aParametros);		
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/TarjetasCreditos/VerTarjetaCredito.tpl",$aParametros);
?>