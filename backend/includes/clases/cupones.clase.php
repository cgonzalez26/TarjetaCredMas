<?
final class cupons {
	
	public $id = 0;
	public $datos = array();
	private $datos_details = array();
	private $operations = 'new';
	private $codigo_error = 0;
	
	
	public function __construct( $idplanes ){ $this->id = $idplanes; }
	
	public function get_id(){ return $this->id ;}
		
	public function set_datos(){
		global $oMysql;	

		$this->datos = $oMysql->consultaSel("CALL usp_getFichaCupones(\" WHERE Cupones.id = '{$this->get_id()}'\");",true);

	}
	
	public function get_datos(){

		if(sizeof($this->datos) == 0){ $this->set_datos(); }

		return $this->datos;

	}

	
	public function set_datos_details(){
		global $oMysql;	

		$this->datos_details = $oMysql->consultaSel("CALL usp_getDetallesCupones(\" WHERE DetallesCupones.idCupon = '{$this->get_id()}'\");");

	}
	
	public function get_datos_details(){

		if(sizeof($this->datos_details) == 0){ $this->set_datos_details(); }

		return $this->datos_details;

	}
	
	public function set_error_nro_query($numero = 0){
		$this->codigo_error = $numero;
	}
	
	public function get_error_nro_query(){
		return $this->codigo_error;
	}	
	
	static function _check_datos($datos,$operations){
		global $oMysql;

		$message = "";
		
		$break = chr(13);

		switch ($operations) {
			case 'new':
						
					if($datos['sNumeroCuenta'] == "" || $datos['_icu'] == ""){
						$message .= 'El campo Numero Cuenta Usuario es requerido.' . $break;
					}
					
					if($datos['sNumeroComercio'] == "" || $datos['_ico'] == ""){
						$message .= 'El campo Numero Comercio es requerido.' . $break;
					}
					
					//validacion de seleccion de plan
					if(!$datos['rp'] || $datos['_tp'] == "" || $datos['_ip'] == ""){
						$message .= 'Debe seleccionar una Promocion o Plan.' . $break;
					}
					
					//end
			
					if($datos['fImporte'] == "" || $datos['fImporte'] == "0" || $datos['fImporte'] == "0.00" || $datos['fImporte'] == "0.0"){
						$message .= 'El campo Importe es requerido y debe ser distinto de "0" ( cero ).' . $break;
					}		
					
					if($datos['sNumeroCupon'] == ""){
						$message .= 'El campo Numero Cupon es requerido.' . $break;
					}
					
					if($datos['idTipoMoneda'] == 0){
						$message .= 'El campo Tipo Moneda es requerido.' . $break;
					}
					
					if($datos['dFechaConsumo'] == ""){
						$message .= 'El campo Fecha Cupon es requerido.' . $break;
					}
					
					if($datos['dFechaPresentacion'] == ""){
						$message .= 'El campo Fecha Presentacion es requerido.' . $break;
					}
					
					$es_mayor = _compare_date_($datos['dFechaConsumo'],$datos['dFechaPresentacion']);
					
					if($es_mayor > 0){
						$message .= 'El campo Fecha Presentacion debe ser MAYOR a Fecha Cupon.' . $break;
					}
					/*if($datos['sNumeroTerminal'] == ""){
						$message .= 'El campo Numero Terminal es requerido.' . $break;
					}		
			
					if($datos['sObservacion'] == ""){
						$message .= 'El campo Observaciones es requerido.' . $break;
					}*/


				break;
			case 'edit':

					if($datos['sNumeroCuenta'] == "" || $datos['_icu'] == ""){
						$message .= 'El campo Numero Cuenta Usuario es requerido.' . $break;
					}
					
					if($datos['sNumeroComercio'] == "" || $datos['_ico'] == ""){
						$message .= 'El campo Numero Comercio es requerido.' . $break;
					}
					
					//validacion de seleccion de plan
					if(!$datos['rp'] || $datos['_tp'] == "" || $datos['_ip'] == ""){
						$message .= 'Debe seleccionar una Promocion o Plan.' . $break;
					}
					
					//end
			
					if($datos['fImporte'] == "" || $datos['fImporte'] == "0" || $datos['fImporte'] == "0.00" || $datos['fImporte'] == "0.0"){
						$message .= 'El campo Importe es requerido.' . $break;
					}		
					
					if($datos['sNumeroCupon'] == ""){
						$message .= 'El campo Numero Cupon es requerido.' . $break;
					}
					
					if($datos['idTipoMoneda'] == 0){
						$message .= 'El campo Tipo Moneda es requerido.' . $break;
					}
					
					if($datos['dFechaConsumo'] == ""){
						$message .= 'El campo Fecha Cupon es requerido.' . $break;
					}
					
					if($datos['dFechaPresentacion'] == ""){
						$message .= 'El campo Fecha Presentacion es requerido.' . $break;
					}
					
					$es_mayor = _compare_date_($datos['dFechaConsumo'],$datos['dFechaPresentacion']);
					
					if($es_mayor > 0){
						$message .= 'El campo Fecha Presentacion debe ser MAYOR a Fecha Cupon.' . $break;
					}
					
					/*if($datos['sNumeroTerminal'] == ""){
						$message .= 'El campo Numero Terminal es requerido.' . $break;
					}		
			
					if($datos['sObservacion'] == ""){
						$message .= 'El campo Observaciones es requerido.' . $break;
					}*/

				break;
			case 'pendiente-liquidacion-comercio':
					#en este caso, $datos es un integer, k indica el idcupon
					//var_export("CALL usp_getDetallesCuponesLiquidadosComercio(\"$datos\");");die();
					$detallescupones = $oMysql->consultaSel("CALL usp_getDetallesCuponesLiquidadosComercio(\"$datos\");");
					
					$liquidad_por_lo_menos_uno = false;
					
					foreach ($detallescupones as $cuotas) {
						if($cuotas['idLiquidacion'] != 0){
							$liquidad_por_lo_menos_uno = true;
						}
					}
					
					if($liquidad_por_lo_menos_uno){
						$message = 'El cupon ya fue liquidado o esta en proceso de liquidacion hacia el comercio correspondiente, por lo cual no se puede ejecutar su operacion' . $break;
					}
				break;
			case 'pendiente-liquidacion-usuario':
					#en este caso, $datos es un integer, k indica el idcupon
				
					$detallescupones = $oMysql->consultaSel("CALL usp_getDetallesCuponesFacturadosUsuarios(\"$datos\");");
					$liquidad_por_lo_menos_uno = false;
					
					foreach ($detallescupones as $cuotas) {
						//if($cuotas['idLiquidacion'] != 0){
						if($cuotas['iEstadoFacturacionUsuario'] != 0){
							$liquidad_por_lo_menos_uno = true;
						}
					}
					
					if($liquidad_por_lo_menos_uno){
						$message = 'El cupon esta en proceso de facturacion al usuario, por lo cual no se puede ejecutar su operacion' . $break;
					}
				break;
			case "reactivar":
					$message = "";
				break;								
		}
		
		return $message;
	}
	
	static function _check_erase_($id = 0){
		#determinar cuando no se puede dar de baja un usuario, mientras tanto
		
		$message = '';
		
		return $message;
	}
	

	
	public function add_dato($index,$value){ $this->datos[$index] = $value; }
	
	public function get_dato($index = ''){ return $this->datos[ $index ]; }

	public function insert($datos){
		global $oMysql;
		
		
		//$datos = _stringUpper_($datos);

		$datos = _parserCharacters_($datos);

		$estado = "N";#aki es estado = NORMAL
		
		if(!$datos['idEmpleado']) 
		        $idUser = $_SESSION['id_user'];
                else
			$idUser = $datos['idEmpleado'];
		
		$datos['dFechaConsumo'] = dateToMySql($datos['dFechaConsumo']);
		$datos['dFechaPresentacion'] = dateToMySql($datos['dFechaPresentacion']);
		
		$fecha_registro = 'NOW()';//date("Y-m-d");

		$op_planpromo = _decode($datos['_tp']);
		
		$idplanpromo = intval(_decode($datos['_ip']));
					
		switch ($op_planpromo) {
			case "promociones":
					$datos['idPlanPromo'] = $idplanpromo;
					$datos['idPlan'] = 0;
				break;
			case "planes":
					$datos['idPlan'] = $idplanpromo;
					$datos['idPlanPromo'] = 0;				
				break;							
			default:
					$datos['idPlan'] = -1;
					$datos['idPlanPromo'] = -1;
				break;
		}
		

		$set = "
				idComercio,
				idTarjeta,
				idPlan,
				idPlanPromo,
				idEmpleado,
				idTipoMoneda,
				idAutorizacion,
				dFechaConsumo,
				dFechaPresentacion,
				dFechaRegistro,
				sObservacion,
				sNumeroCupon,
				sNumeroTerminal,
				fImporte,
				sCuotas,
				sEstado,
				NotasPedidosId,				
				NotasPedidosCantidadCuotas,
				NotasPedidosImporteCuota,
				NotasPedidosFormaPago,
				NotasPedidosNumero,
				NotasPedidosFechaAlta,
				idCobrador
				";

		$values = "
					'{$datos['idComercio']}',
					'{$datos['idTarjeta']}',					
					'{$datos['idPlan']}',
					'{$datos['idPlanPromo']}',
					'$idUser',
					'{$datos['idTipoMoneda']}',
					'{$datos['idAutorizacion']}',
					'{$datos['dFechaConsumo']}',
					'{$datos['dFechaPresentacion']}',
					NOW(),
					'{$datos['sObservacion']}',
					'{$datos['sNumeroCupon']}',
					'{$datos['sNumeroTerminal']}',
					'{$datos['fImporte']}',
					'{$datos['iCantidadCuota']}',
					'$estado',
					'{$datos['NotasPedidosId']}',
					'{$datos['NotasPedidosCantidadCuotas']}',
					'{$datos['NotasPedidosImporteCuota']}',
					'{$datos['NotasPedidosFormaPago']}',
					'{$datos['NotasPedidosNumero']}',
					'{$datos['NotasPedidosFechaAlta']}',
					'{$datos['idCobrador']}'";

		$toauditory = "insercion de CUPONES ::: idEmpleado = {$_SESSION['id_user']}, Solicita IdEmpleado={$idUser},  Numero: {$datos['sNumeroCupon']}";
		
		$id = $oMysql->consultaSel("CALL usp_InsertTable(\"Cupones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"56\",\"$toauditory\");",true);
		
		$this->set_error_nro_query($oMysql->getErrorNo());

		$this->id = $id;
		
	}
	
	public function insertDetails($datos){		
		global $oMysql;		
		
		$set = "(
				idBin,
				idCupon,
				idSecuritizacion,
				idLiquidacion,
				idConvenio,
				sNumeroMovimiento,
				sDetalle,
				fImporte,
				dFechaFacturacionUsuario,
				iEstadoFacturacionUsuario,
				dFechaLiquidacionComercio,
				fCapital,
				fInteres,
				fIVA,
				iNumeroCuota
			   )";

		$idBIN = $oMysql->consultaSel("SELECT fcn_getidBINCuentaUsuario(\"{$datos['idCuentaUsuario']}\");",true);
		
		$idBIN = (!$idBIN) ? 0 : $idBIN ;
		
		$idCupon = $this->get_id();
		
		$op_planpromo = _decode($datos['_tp']);
		
		$idplanpromo = intval(_decode($datos['_ip']));
		
		$iDiferimiento = 0;
		$dia_cierre = 0;
		/* ver esta parte para obtener la fecha de cierre*/
		switch ($op_planpromo) {
			case "promociones":

					$apromociones = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$idplanpromo}\",\"promociones\");",true);

					if(!$apromociones){
						$dia_cierre 	= 0;
						$iDiferimiento 	= 0;
						$fInteresUsuario= 0;
						$fDescuentoUsuario=0;						
						$iCredito 		= 0;
						$iCompra 		= 0;
						
					}else{
						$dia_cierre 	= $apromociones['iDiaCierre'];
						$iDiferimiento 	= $apromociones['iDiferimientoUsuario'];
						$fInteresUsuario= $apromociones['fInteresUsuario'];
						$fDescuentoUsuario=$apromociones['fDescuentoUsuario'];
						$iCredito 		= $apromociones['iCredito'];
						$iCompra 		= $apromociones['iCompra'];
					}
					

				break;
			case "planes":

					$aplanes = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$idplanpromo}\",\"planes\");",true);
					
					if(!$aplanes){
						$dia_cierre 	= 0;
						$iDiferimiento 	= 0;
						$fInteresUsuario= 0;
						$fDescuentoUsuario=0;
						$iCredito 		= 0;
						$iCompra 		= 0;
					}else{
						$dia_cierre 	= $aplanes['iDiaCierre'];
						$iDiferimiento 	= 0 ;
						$fInteresUsuario= $aplanes['fInteresUsuario'];
						$fDescuentoUsuario=$aplanes['fDescuentoUsuario'];
						$iCredito 		= $aplanes['iCredito'];
						$iCompra 		= $aplanes['iCompra'];
					}

				break;
			default: $dia_cierre = 0;
		}		

		$dia_cierre = intval($dia_cierre);

		$array_fecha_presentacion = explode("/",$datos['dFechaPresentacion']);

		$dia_presentacion = intval($array_fecha_presentacion[0]);

		if($dia_presentacion < $dia_cierre){

			if( $dia_cierre < 10 ){ $dia_cierre = "0" . $dia_cierre ; }

			$fecha_liquidacion_comercio = $array_fecha_presentacion[2] . "-" . $array_fecha_presentacion[1] . "-" . $dia_cierre;

		}else{
			#obtengo mes y anio para buscar fecha de cierre asociado a cuenta de usuario
			$mes = $array_fecha_presentacion[1] + 1;
			
			$anyo = intval($array_fecha_presentacion[2]);
			
			$mktime = mktime(0,0,0,$mes,1,$anyo);
			
			$anyo_real = date("Y",$mktime);
			
			$mes_real = date("m",$mktime);
			
			if( $dia_cierre < 10 ){ $dia_cierre = "0" . $dia_cierre ; }
			
			$fecha_liquidacion_comercio = $anyo_real . "-" . $mes_real . "-" . $dia_cierre;
	
		}
		
		#calculo de monto de cuotas y su desglose
		$datos['fImporte'] = number_format((double)$datos['fImporte'],2,'.','');
		
		#TASA EFECTIVA MENSUAL -> PARA EL INTERES
		
		$tasa_efectiva_mensual = $fInteresUsuario / (12 * 100);
		$tasa_iva = 0.21;
		$cantidad_cuotas_planpromo = intval($datos['iCantidadCuota']);
		
		#IMPORTE EN PESOS DE CUOTA --> preguntar si es divido por la cantidad de cuotas, PORK DETERMINO SOBRE MONTO TOTAL
		
		$fCapital = $datos['fImporte'] / (1 + ($tasa_efectiva_mensual * $cantidad_cuotas_planpromo) + ($tasa_iva * $tasa_efectiva_mensual * $cantidad_cuotas_planpromo));
		
		//$fCapital = number_format($fCapital,2,'.','');
		
		$fInteres = $fCapital * $tasa_efectiva_mensual * $cantidad_cuotas_planpromo;
		//var_export($fInteres);die();
		//$fInteres = number_format($fInteres,2,'.','');
		
		$fIVA = $fInteres * $tasa_iva;
		
		//$fIVA = number_format($fIVA,2,'.','');
		
		$importe_cuota = $datos['fImporte'] / $datos['iCantidadCuota'];

		$importe_cuota = number_format((double)$importe_cuota,2,'.','');
		
		$fCapital = number_format((double)$fCapital/$cantidad_cuotas_planpromo,2,'.','');
		
		$fInteres = number_format((double)$fInteres/$cantidad_cuotas_planpromo,2,'.','');
		
		$fIVA = number_format((double)$fIVA/$cantidad_cuotas_planpromo,2,'.','');

		
					  #YYYY-mm-dd
		//$fecha_base = $oMysql->consultaSel("SELECT fcn_getUltimoPeriodoDetalleCuentaUsuario(\"{$datos['idCuentaUsuario']}\");",true);//$datos['dFechaConsumo'];
		$mes = $array_fecha_presentacion[1];			
		$anyo = intval($array_fecha_presentacion[2]);
		$mktime = mktime(0,0,0,intval($mes),1,intval($anyo));
		$anyo_real = intval(date("Y",$mktime));			
		$mes_real = intval(date("m",$mktime));
		
		$dCierre = $oMysql->consultaSel("SELECT fcn_getFechaCierreUsuario(\"$mes_real\",\"$anyo_real\",\"{$datos['idCuentaUsuario']}\");",true);
		$aFechaCierre = explode("-",$dCierre);
		$dFechaCierre = $aFechaCierre[2]."/".$aFechaCierre[1]."/".$aFechaCierre[0];
		$iDiferencia = DifComparaFechas($datos['dFechaPresentacion'],$dFechaCierre);
		if($iDiferencia <0){
			$fecha_base = $dCierre;
		}else{
			$array_fecha_presentacion[1] = $array_fecha_presentacion[1] +1;//pasa al siguiente mes
			$fecha_base = $array_fecha_presentacion[2] ."-".$array_fecha_presentacion[1]."-01";
		}	
		//$array_fecha_base = explode("/",$fecha_base);
		$array_fecha_base = explode("-",$fecha_base);
		$cantidad_cuotas = intval($datos['iCantidadCuota']);
		$ultima_fecha_cierre = "";#deberia tener seteado algo 

		for($k = 1;$k <= $cantidad_cuotas;$k++){
			
			#obtengo mees y anio para buscar fecha de cierre asociado a cuenta de usuario

			$mes = $array_fecha_base[1] + ($k - 1) + $iDiferimiento;
			
			
			$anyo = $array_fecha_base[0];
			
			$mktime = mktime(0,0,0,intval($mes),1,intval($anyo));
			
			$anyo_real = intval(date("Y",$mktime));
			
			$mes_real = intval(date("m",$mktime));
			
			#determino periodo de cuota
			$fecha_cierre_usuario = $oMysql->consultaSel("SELECT fcn_getFechaCierreUsuario(\"$mes_real\",\"$anyo_real\",\"{$datos['idCuentaUsuario']}\");",true);
			
			//var_export($fecha_cierre_usuario);die();
			//var_export("SELECT fcn_getFechaCierreUsuario(\"$mes_real\",\"$anyo_real\",\"{$datos['idCuentaUsuario']}\");");die();
			
			if($fecha_cierre_usuario == '0000-00-00' || $fecha_cierre_usuario == false || $fecha_cierre_usuario == '1899-12-29'){
				
				$array_uFechaCierre = explode("-",$ultima_fecha_cierre);
				
				$ultimo_dia_mes_real = intval(strftime("%d", mktime(0, 0, 0, $mes_real+1, 0, $anyo_real)));
				
				$array_uFechaCierre[2] = intval($array_uFechaCierre[2]);
				
				if($ultimo_dia_mes_real < $array_uFechaCierre[2]){
					$dia_real = $ultimo_dia_mes_real;
				}else{
					$dia_real = $array_uFechaCierre[2];
				}	
				
				
				$fecha_cierre_usuario = $anyo_real . "-" . $mes_real . "-" . $dia_real;
				
				/*if($k == 1){
					$fecha_cierre_cuota_1 = $fecha_cierre_usuario;
				}else{
					if($k == 2){
						$fecha_cierre_usuario = $fecha_cierre_cuota_1;
					}else{*/
	
						if($k > 1){
	
							
							/*$aDateCloseFechaHora = explode(" ",$fecha_cierre_usuario);
							$aDateClose = explode("-",$aDateCloseFechaHora[0]);
							
							$xm = intval($aDateClose[1]);
							$xm = $xm - 1;
							
							$fecha_cierre_usuario = $oMysql->consultaSel("SELECT fcn_getFechaCierreUsuario(\"$xm\",\"$anyo_real\",\"{$datos['idCuentaUsuario']}\");",true);		*/

							$aDateCloseFechaHora = explode(" ",$fecha_cierre_usuario);
							$aDateClose = explode("-",$aDateCloseFechaHora[0]);
	
							$xd = intval($aDateClose[2]);
							$xm = intval($aDateClose[1]);
							//$xm = $xm - 1;
							$xy = intval($aDateClose[0]);
	
							$xmktime = mktime(0,0,0,$xm,$xd,$xy);
	
							$xdate = date("Y-m-d",$xmktime);
							
							$fecha_cierre_usuario = $xdate;
						}
	
					//}
				//}				
				

				
				#no existe fecha de cierre
				$idSecuritizacion = 0;
				$idLiquidacion = 0;
				$idConvenio = 0;
				$sNumeroMovimiento = "";
				$sDetalle = "";
				$fimporte = $importe_cuota;
				$dFechaFacturacionUsuario = $fecha_cierre_usuario;
				$iEstadoFacturacionUsuario = 0;
				$dFechaLiquidacionComercio = $fecha_liquidacion_comercio;
				
				
				$iNumeroCuota = $k;

				$values .= "(
							'$idBin',
							'$idCupon',
							'$idSecuritizacion',
							'$idLiquidacion',
							'$idConvenio',
							'$sNumeroMovimiento',
							'$sDetalle',
							'$fimporte',
							'$dFechaFacturacionUsuario',
							'$iEstadoFacturacionUsuario',
							'$dFechaLiquidacionComercio',
							'$fCapital',
							'$fInteres',
							'$fIVA',
							'$iNumeroCuota'
						  ),";
				
				
			}else{
				#obtuve una fecha de cierre
				$ultima_fecha_cierre = $fecha_cierre_usuario ;
				
				/*if($k == 1){
					$fecha_cierre_cuota_1 = $fecha_cierre_usuario;
				}else{
					if($k == 2){
						$fecha_cierre_usuario = $fecha_cierre_cuota_1;
					}else{*/
	
						if($k > 1){
							$aDateCloseFechaHora = explode(" ",$fecha_cierre_usuario);
							$aDateClose = explode("-",$aDateCloseFechaHora[0]);
							
							$xm = intval($aDateClose[1]);
							//$xm = $xm - 1;
							
							$fecha_cierre_usuario = $oMysql->consultaSel("SELECT fcn_getFechaCierreUsuario(\"$xm\",\"$anyo_real\",\"{$datos['idCuentaUsuario']}\");",true);	
														
							/*$aDateCloseFechaHora = explode(" ",$fecha_cierre_usuario);
							$aDateClose = explode("-",$aDateCloseFechaHora[0]);
							
							
							
							$xd = intval($aDateClose[2]);
							$xm = intval($aDateClose[1]);
							$xm = $xm - 1;
							$xy = intval($aDateClose[0]);
	
							$xmktime = mktime(0,0,0,$xm,$xd,$xy);
	
							$xdate = date("Y-m-d",$xmktime);
							
							
							
							$fecha_cierre_usuario = $xdate;*/
						}
	
					//}
				//}				
				
				
				
				
				
				
				//$idBin = 0;
				$idSecuritizacion = 0;
				$idLiquidacion = 0;
				$idConvenio = 0;
				$sNumeroMovimiento = "";
				$sDetalle = "";
				$fimporte = $importe_cuota;
				$dFechaFacturacionUsuario = $fecha_cierre_usuario;
				$iEstadoFacturacionUsuario = 0;
				$dFechaLiquidacionComercio = $fecha_liquidacion_comercio;

				$iNumeroCuota = $k;
				
				$values .= "(
							'$idBin',
							'$idCupon',
							'$idSecuritizacion',
							'$idLiquidacion',
							'$idConvenio',
							'$sNumeroMovimiento',
							'$sDetalle',
							'$fimporte',
							'$dFechaFacturacionUsuario',
							'$iEstadoFacturacionUsuario',
							'$dFechaLiquidacionComercio',
							'$fCapital',
							'$fInteres',
							'$fIVA',
							'$iNumeroCuota'
						  ),";				
				
			}
			
		}

		
		$values = substr($values,0,-1);

		//var_export($values);die();


		$toauditory = "insercion de DETALLES CUPONES ::: id: {$this->get_id()}";

		$id = $oMysql->consultaSel("CALL usp_abm_General(\"DetallesCupones\",\"$set\",\"$values\",\"1\",\"{$_SESSION['id_user']}\",\"56\",\"$toauditory\");",true);

		$this->set_error_nro_query($oMysql->getErrorNo());
		
		#afecto los limites del usuario
		
		if($iCompra == 0){ $importe_cuota = 0; }
		
		if($iCredito == 0){ $importe_total = 0; }else{ $importe_total = $datos['fImporte']; }
		
		//$importe_cuota = $importe_cuota*2;//cuando la primera cuota ingresan 2 cuotas juntas
		$importe_cuota = $importe_cuota;
		
		$r = $oMysql->consultaSel("CALL usp_UpdateRemanentesCuentaUsuario(\"{$datos['idCuentaUsuario']}\",\"$importe_total\",\"$importe_cuota\",\"$cantidad_cuotas_planpromo\");",true);
		
		if( $fDescuentoUsuario != 0 ){
			#agregar ajuste a usuario
			
			$idTipoAjuste = 28;
			$idTasaIVA = 1;
			
			$fImporteDescuento = $datos['fImporte'] * ($fDescuentoUsuario / 100);
			
			$sCondiciones = "WHERE TiposAjustes.id = ". $idTipoAjuste; 
			
			$sqlDatos = "Call usp_getTiposAjustes(\"$sCondiciones\");";
			
			$ajustes = $oMysql->consultaSel($sqlDatos,true);

			$fTasaInteres 	= $ajustes['fTasaInteresAjuste'];

			$fIntereses 	= ($fImporteDescuento * ($fTasaInteres/100));

			$fImporteInteres= $fImporteDescuento + $fIntereses;	
			
			if($ajustes['bDiscriminaIVA'] == 1){ 

				$sConsulta = "SELECT fTasa FROM TasasIVA WHERE id = ". $idTasaIVA; 

				$fTasaIVA = $oMysql->consultaSel($sConsulta, true);

				//$fTasaIVA = $ajustes['fTasaIVA'];

			}else{

				$fTasaIVA = 0;

			}
	
			$fImporteIVA = ($fImporteInteres * ($fTasaIVA/100));
	
			$fImporteTotalInteres 	= $fIntereses;
			$fImporteTotalIVA 		= $fImporteIVA;		
			$fImporteTotalFinal 	= $fImporteDescuento + $fImporteTotalInteres + $fImporteIVA;
			
			#datos para enviar a la funcion
			$datos['idTipoAjuste'] 			= $idTipoAjuste;
			$datos['iCuotas'] 				= $datos['iCantidadCuota'];
			$datos['fImporteTotal'] 		= $fImporteDescuento;
			$datos['fImporteTotalInteres'] 	= $fImporteTotalInteres;
			$datos['fImporteTotalIVA'] 		= $fImporteTotalIVA ;
			$datos['idTasaIVA']				= $idTasaIVA;
			$datos['fImporteTotalFinal']	= $fImporteTotalFinal;
			
			$datos['iDiferimientoUsuario'] 	= $iDiferimiento;
			
			agregarAjusteDescuentoUsuario($datos);
			
		}

	}
	
	public function update($datos){
		global $oMysql;

		//$datos = _stringUpper_($datos);

		$datos = _parserCharacters_($datos);
		
		$datos['dFechaConsumo'] 		= dateToMySql($datos['dFechaConsumo']);
		$datos['dFechaPresentacion'] 	= dateToMySql($datos['dFechaPresentacion']);	
		
		$set = "
				idComercio='{$datos['idComercio']}',
				idTarjeta='{$datos['idTarjeta']}',
				idPlan='{$datos['idPlan']}',
				idPlanPromo='{$datos['idPlanPromo']}',
				idTipoMoneda='{$datos['idTipoMoneda']}',
				idAutorizacion='{$datos['idAutorizacion']}',
				dFechaConsumo='{$datos['dFechaConsumo']}',
				dFechaPresentacion='{$datos['dFechaPresentacion']}',
				sObservacion='{$datos['sObservacion']}',
				sNumeroCupon='{$datos['sNumeroCupon']}',
				sNumeroTerminal='{$datos['sNumeroTerminal']}',
				fImporte='{$datos['fImporte']}',
				sCuotas='{$datos['iCantidadCuota']}',
				idCobrador='{$datos['idCobrador']}'
			   ";

		$values = "Cupones.id='{$this->get_id()}'";

		$toauditory = "actualizacion de datos de CUPONES ::: id  = {$this->get_id()}";

		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Cupones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"57\",\"$toauditory\");",true);

		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());

	}
	
	public function delete(){
		global $oMysql;
		
		$set = "Cupones.sEstado='B'";

		$values = "Cupones.id='{$this->get_id()}'";

		$toauditory = "baja de CUPONES ::: id  = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];

		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Cupones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"58\",\"$toauditory\");",true);

		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());
		
	}
	
	public function activar(){
		global $oMysql;

		$set = "Cupones.sEstado='A'";

		$values = "Cupones.id='{$this->get_id()}'";

		$toauditory = "Activacion de CUPONES ::: id  = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];

		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Cupones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"58\",\"$toauditory\");",true);

		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());

	}

	public function marcarFRAUDE(){
		global $oMysql;

		$set = "Cupones.sEstado='F'";

		$values = "Cupones.id='{$this->get_id()}'";

		$toauditory = "Cupon marcado como FRAUDE::: id  = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];

		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Cupones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"58\",\"$toauditory\");",true);

		#esta linea ver si es fucional
		#$this->set_error_nro_query($oMysql->getErrorNo());
	}
	
	public function marcarOBSERVADO($observaciones = ''){
		global $oMysql;
		
		$break = chr(13);

		$set = "Cupones.sEstado='O', Cupones.sObservacion=CONCAT(Cupones.sObservacion,'$break Observacion tomada ".date("d/m/Y").": $observaciones')";

		$values = "Cupones.id='{$this->get_id()}'";

		$toauditory = "Cupon marcado como OBSERVADO ::: id = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];

		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Cupones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"58\",\"$toauditory\");",true);

		#esta linea ver si es fucional
		#$this->set_error_nro_query($oMysql->getErrorNo());
	}
	
	public function anular(){
		global $oMysql;

		$set = "Cupones.sEstado='A'";

		$values = "Cupones.id='{$this->get_id()}'";

		$toauditory = "Cupon anulado ::: id = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];

		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Cupones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"58\",\"$toauditory\");",true);
		
		#tareas de reverso para limites		

		$datos = $oMysql->consultaSel("CALL usp_getPromocionesPlanesCupones(\"{$this->get_id()}\");",true);
		
		$tipoplanpromo = $datos['tipoplanpromo'];
		$importe_total = (-1) * $datos['importe_total'];
		
		$importe_cuota = number_format((double)$datos['importe_cuota'],2,'.','');
		$importe_cuota = (-1) * $importe_cuota;
		
		$cantidad_cuotas_planpromo = intval($datos['sCuotas']);
		
		switch ($tipoplanpromo) {
			case "promociones":

					$apromociones = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$datos['idPlanPromo']}\",\"promociones\");",true);

					if(!$apromociones){
						$dia_cierre 	= 0;
						$iDiferimiento 	= 0;
						$iCredito 		= 0;
						$iCompra 		= 0;
					}else{
						$dia_cierre 	= $apromociones['iDiaCierre'];
						$iDiferimiento 	= $apromociones['iDiferimientoUsuario'];
						$iCredito 		= $apromociones['iCredito'];
						$iCompra 		= $apromociones['iCompra'];
					}
					

				break;
			case "planes":

					$aplanes = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$datos['idPlan']}\",\"planes\");",true);

					if(!$aplanes){
						$dia_cierre 	= 0;
						$iDiferimiento 	= 0;
						$iCredito 		= 0;
						$iCompra 		= 0;
					}else{
						$dia_cierre 	= $aplanes['iDiaCierre'];
						$iDiferimiento 	= 0 ;
						$iCredito 		= $aplanes['iCredito'];
						$iCompra 		= $aplanes['iCompra'];
					}

				break;
			default: $dia_cierre = 0;
		}		
		
		if($iCompra == 0){ $importe_cuota = 0; }
		
		if($iCredito == 0){ $importe_total = 0; }else{ $importe_total = $importe_total;}
		//if($iCredito == 0){ $importe_total = 0; }else{ $importe_total = $datos['fImporte']; }
		//var_export("CALL usp_UpdateRemantensCuentaUsuario(\"{$datos['idCuentaUsuario']}\",\"$importe_total\",\"$importe_cuota\");");die();
		$r = $oMysql->consultaSel("CALL usp_UpdateRemanentesCuentaUsuario(\"{$datos['idCuentaUsuario']}\",\"$importe_total\",\"$importe_cuota\",\"$cantidad_cuotas_planpromo\");",true);		
		
	}
	
	public function marcarACTIVADO(){
		global $oMysql;
		
		$break = chr(13);

		$set = "Cupones.sEstado='N', Cupones.sObservacion=CONCAT(Cupones.sObservacion,'$break se reactivo cupon ".date("d/m/Y h:i:s")."')";

		$values = "Cupones.id='{$this->get_id()}'";

		$toauditory = "Cupon se REACTIVA ::: id = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];

		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Cupones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"58\",\"$toauditory\");",true);

		#esta linea ver si es fucional
		#$this->set_error_nro_query($oMysql->getErrorNo());
	}	
	
	public function habilitar(){
		global $oMysql;

		$set = "Cupones.sEstado='N'";

		$values = "Cupones.id='{$this->get_id()}'";

		$toauditory = "Cupon Habilitado ::: id = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];

		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Cupones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"58\",\"$toauditory\");",true);
		
		#tareas de reverso para limites		

		$datos = $oMysql->consultaSel("CALL usp_getPromocionesPlanesCupones(\"{$this->get_id()}\");",true);
		
		$tipoplanpromo = $datos['tipoplanpromo'];
		$importe_total = $datos['importe_total'];
		
		$importe_cuota = number_format($datos['importe_cuota'],2,'.','');
		$importe_cuota = $importe_cuota;
		
		$cantidad_cuotas_planpromo = intval($datos['sCuotas']);
		
		switch ($tipoplanpromo) {
			case "promociones":

					$apromociones = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$datos['idPlanPromo']}\",\"promociones\");",true);

					if(!$apromociones){
						$dia_cierre 	= 0;
						$iDiferimiento 	= 0;
						$iCredito 		= 0;
						$iCompra 		= 0;
					}else{
						$dia_cierre 	= $apromociones['iDiaCierre'];
						$iDiferimiento 	= $apromociones['iDiferimientoUsuario'];
						$iCredito 		= $apromociones['iCredito'];
						$iCompra 		= $apromociones['iCompra'];
					}
					

				break;
			case "planes":

					$aplanes = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$datos['idPlan']}\",\"planes\");",true);

					if(!$aplanes){
						$dia_cierre 	= 0;
						$iDiferimiento 	= 0;
						$iCredito 		= 0;
						$iCompra 		= 0;
					}else{
						$dia_cierre 	= $aplanes['iDiaCierre'];
						$iDiferimiento 	= 0 ;
						$iCredito 		= $aplanes['iCredito'];
						$iCompra 		= $aplanes['iCompra'];
					}

				break;
			default: $dia_cierre = 0;
		}		
		
		if($iCompra == 0){ $importe_cuota = 0; }
		
		if($iCredito == 0){ $importe_total = 0; }else{ $importe_total = $importe_total;}
		//var_export("CALL usp_UpdateRemantensCuentaUsuario(\"{$datos['idCuentaUsuario']}\",\"$importe_total\",\"$importe_cuota\");");die();
		$r = $oMysql->consultaSel("CALL usp_UpdateRemanentesCuentaUsuario(\"{$datos['idCuentaUsuario']}\",\"$importe_total\",\"$importe_cuota\",\"$cantidad_cuotas_planpromo\");",true);		
		
	}
}
?>