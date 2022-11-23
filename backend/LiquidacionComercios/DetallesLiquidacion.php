<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();

	#Control de Acceso al archivo
	//if(!isLogin())
	//{
		//go_url("/index.php");
	//}
			
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);		
	
		
		
	$idliquidacion = $_GET['idLiquidacion'];	
	$sNroLiquidacion = $_GET['sNumeroLiquidacion'];
	
	#obtengo datos de la liquidaciones(cabecera)
	#__________________________________________
	
	$sub_query = " WHERE Liquidaciones.id = $idliquidacion";
	
	$SQL = "Call usp_getLiquidaciones(\"$sub_query\");";
	
	$liquidaciones = $oMysql->consultaSel( $SQL , true);	
	
	//var_export($liquidaciones);die();
	
	#DEBO CONSIDERAR CASOS DE PLANES Y PROMOCIONES
	#PLANES
	#_____________________________________________
	$liquidaciones_planes = 0;
	$liquidaciones_promociones = 1;
	
	$sCondiciones = "WHERE DetallesLiquidaciones.idLiquidacion=$idliquidacion AND iPlanPromo=$liquidaciones_planes";
		
	$sqlDatos="Call usp_getDetallesLiquidacionesPlanes(\"$sCondiciones\");";
	
	$datos = array();

	$datos = $oMysql->consultaSel($sqlDatos);	
	//var_export($datos);die();
	//$i = 1;
	$hay_datos = false;
	if(!$datos){
		
	}else{
		$hay_datos = true;
		foreach ($datos as $rs)
		{		
			$sFila .= 
			"<tr>
				<td width='80%'>".$rs['sPlan']."</td>				
				<td width='20%' align='right'>".$rs['fImporteNeto']."</td>			
			";		
			
			if($rs['idTransaccion'] == 0){
	
				$sFila .="<td align='center'><input type='checkbox' id='chk[]' name='chk[]' class='check_user' value='".$rs['id']."' /></td>";	
	
			}else{
	
				$sFila .="<td align='center'>&nbsp;</td>";
	
			}
	
			$sFila .="</tr>";	
			
			//$i+=1;
		}		
	}
	
	
	
	
	
	#PROMOCIONES
	#_____________________________________________
	
	$datos = array();
	
	$sub_query = " WHERE DetallesLiquidaciones.idLiquidacion=$idliquidacion AND iPlanPromo=$liquidaciones_promociones";
		
	$SQL = "Call usp_getDetallesLiquidacionesPromociones(\"$sub_query\");";

	$datos = $oMysql->consultaSel( $SQL );	
	
	if(!$datos){
		
	}else{
		$hay_datos = true;
		foreach ($datos as $rs) {
			$sFila .= 
			"<tr>
				<td width='80%'>".$rs['sPlan']."</td>
				<td width='20%' align='right'>".$rs['fImporteNeto']."</td>";
			
			if($rs['idTransaccion'] == 0){
	
				$sFila .="<td align='center'><input type='checkbox' id='chk[]' name='chk[]' class='check_user' value='".$rs['id']."' /></td>";	
	
			}else{
	
				$sFila .="<td align='center'>&nbsp;</td>";
	
			}
			
			
			$sFila .="</tr>";		
			
			$i+=1;		
		}	
	}
	
	$liquidaciones['button_emitir_comprobante'] = "<button type='button' onclick='_emitir_comprobante_pago();'> Emitir Comprobantes de Pagos </button>";
	
	if(!$hay_datos){
		$liquidaciones['button_emitir_comprobante'] = "";
		$sFila = "<tr><td colspan='11'>No se encontraron registros</td></tr>";
	}

	
	$liquidaciones['tableRows'] = $sFila;
	$liquidaciones['_op'] = _encode('new');
	$liquidaciones['_ic'] = _encode($liquidaciones['idComercio']);
	
	#datos para setear form convenio de pago con comercio
	$idBanco = $liquidaciones['idBanco'];
	
	$liquidaciones['optionsBancos'] = $oMysql->getListaOpciones('Bancos','id','sNombre',$idBanco);
	
	$ultimo_numero_transaccion = $oMysql->consultaSel("SELECT fcn_getUltimoNumeroTransaccionesLiquidacionesComercios(2);",true);
	//var_export($ultimo_numero_transaccion);die();
	$liquidaciones['sNroCheque'] 		= $ultimo_numero_transaccion;
	$liquidaciones['dFechaEmision'] 	= date("d/m/Y");
	$liquidaciones['dFechaPago'] 		= date("d/m/Y");
	$liquidaciones['sNombreComercio'] 	= $liquidaciones['sRazonSocial'];
	$liquidaciones['sNombreFormaPago'] 	= "CHEQUE";
	$liquidaciones['sReceptor'] 		= $liquidaciones['sTitularComercio'];
	$liquidaciones['sCBUDestino'] 		= $liquidaciones['sCBU'];
	$liquidaciones['fImporte'] 			= number_format((double)$liquidaciones['fImporteNeto2'],2,',','');
	
	$oXajax=new xajax();
	
	$oXajax->registerFunction("issuance_payment_values");
	
	$oXajax->processRequest();
	
	$oXajax->printJavascript("../includes/xajax/");
		

	xhtmlHeaderPaginaGeneral($aParametros);	
	
	echo xhtmlMainHeaderPagina($aParametros);
	
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Comercios/DetallesLiquidaciones.tpl",$liquidaciones);
	
	echo xhtmlFootPagina();

	
?>