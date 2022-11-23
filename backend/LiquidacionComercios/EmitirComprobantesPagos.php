<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );

	session_start();
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$configure = array();

	$configure = getParametrosBasicos(1);
	
	$idBanco = 0;


	if($_GET['_op']){
		
		$op = _decode($_GET['_op']);
		
		switch ($op) {
			case "new":
					$idliquidacion = intval(_decode($_GET['_i']));
					
					if($idliquidacion != 0){
						
						$sub_query = " WHERE Liquidaciones.id = $idliquidacion";
						
						$SQL = "CALL usp_getLiquidaciones(\"$sub_query\");";
						
						$liquidaciones = $oMysql->consultaSel( $SQL ,true);
						
						if(!$liquidaciones){
							
						}else{
							
							switch ($liquidaciones['idFormaPago']){
								case 2:
									$template = "EmitirComprobantesPagosCheques.tpl";
									
									$configure['_i'] = _encode($liquidaciones['id']);
									$configure['_ic'] = _encode($liquidaciones['idComercio']);
									$configure['_fp'] = _encode("cheques");
									
									$idBanco = $liquidaciones['idBanco'];
									
									$configure['optionsBancos'] = $oMysql->getListaOpciones('Bancos','id','sNombre',$idBanco);
									
									$configure['dFechaEmision'] = date("d/m/Y");
									$configure['dFechaPago'] 	= date("d/m/Y");
									$configure['sNombreComercio'] 	= $liquidaciones['sRazonSocial'];
									
									$configure['sNroCheque'] 	= $oMysql->consultaSel("SELECT fcn_getUltimoNumeroTransaccionesLiquidacionesComercios(0);",true);
									$configure['sNombreFormaPago'] 	= "CHEQUE";
									$configure['sReceptor'] 	= $liquidaciones['sTitularComercio'];
									$configure['sCBUDestino'] 	= $liquidaciones['sCBU'];
									$configure['fImporte'] 		= number_format((double)$liquidaciones['fImporteNeto2'],2,',','');
									
									break;
								case 3:
								
										$template = "EmitirPagaresTranferenciaBancaria.tpl";
									break;				
								default:
									break;
							}
						}
						
					}else{
						
					}				
				break;
			case "wiew":
				
				break;		
			default:
				break;
		}
		
		



	}

	
	//$template = "EmitirPagaresCheques.tpl";
	 
	$oXajax=new xajax();
	
	//$oXajax->registerFunction("issuance_payment_values");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");
	
	

	xhtmlHeaderPaginaGeneral($configure);
	
	echo xhtmlMainHeaderPagina($configure);

	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Comercios/$template",$configure);	

	echo xhtmlFootPagina();

?>