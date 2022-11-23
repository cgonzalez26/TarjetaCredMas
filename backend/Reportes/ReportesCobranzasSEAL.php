<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
	
	//include_once( CLASSES_DIR . '/_table.class.php' );
	
	include_once( CLASSES_DIR . '/_buttons.class.php' );
	
	//session_start();
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$configure = array();

	$configure = getParametrosBasicos(1);
	
	#COBRANZAS SEAL
	$idempleado = $_SESSION['id_user'];
	
	$mysql_se = $mysql;
		
	//$mysql_se = new MySql();
	//$mysql_se->setServer('192.168.2.6','griva','griva');
	
	#obtengo datos de usuarios
	$sub_query = " WHERE  user.id_user = {$idempleado}";
	
	$SQL = "CALL usp_getDatosUsuario(\"$sub_query\")";
	
	$usuario = $oMysql->consultaSel($SQL);
	
	if(!$usuario){
		
	}else{
		$usuario = array_shift($usuario);
	}
	

	
	
	
	#obtengo caja general de la dependiente del usuario
	$id_dep = $usuario['id_dep'];
	
	$SQL = "SELECT MAX(id_caja) FROM cajas WHERE id_dep = '$id_dep' AND estado='A'";
	
	$id_caja = $mysql_se->query( $SQL );
	
	$id_caja = array_shift($id_caja);
	
	if($id_caja){
		
		$SQL = "
				SELECT 
					id_dep, 
					UNIX_TIMESTAMP(fch) AS fecha, 
					UNIX_TIMESTAMP(fch_ape) AS fecha_ape, 
					UNIX_TIMESTAMP(fch_cie) as fecha_cie, 
					estado, 
					estado_operarios, 
					saldo 
				FROM 
					cajas 
				WHERE 
					id_caja = '{$id_caja}'";
			
		$caja = $mysql_se->query( $SQL );		
		
		if(!$caja){
			
		}else{
			$caja = array_shift($caja);
		}
		
		$usuario['usuario']=convertir_especiales_html($usuario['usuario']);
		
		$html = "
					<div> 
						Fecha: &nbsp;<strong> ". date('d/m/Y', $caja['fecha']) ." </strong> 
					</div>	
					<div>
						Caja de: <strong> ". $usuario['usuario'] ." </strong> 
					</div>
					<div> 
						Sucursal:&nbsp;<strong>". $usuario['suc_nombre'] ."</strong> &nbsp;&nbsp;&nbsp;&nbsp; 
						Dependiente: <strong>". $usuario['dep_apodo'] ."</strong>
					</div>
							
					<!--<div id='div_cerrada' ". $style_caja_cerrada ." class='cerrada'>
						La caja está cerrada
					</div>-->		
		";
		
		$configure['datos_operador'] = $html;		
		
		$html = "";
		
		
		$SQL = "
				SELECT 
					id_caj_ope 
				FROM 
					cajas_operarios 
				WHERE 
					id_caja = '$id_caja' 
					AND id_user = '$idempleado'
			   ";
		
		$id_caja_operario = $mysql_se->query( $SQL );
		//$id_caja_operario = 128263;
		if(!$id_caja_operario){
			
		}else{
			$id_caja_operario = array_shift($id_caja_operario);
			//$id_caja_operario = 128263;
			$SQL = "
					SELECT 
						pagos.id_pago AS 'ID_PAGO',			
						pagos.num_recibo AS 'NUM_RECIBO',
						IFNULL(pagos.num_recibo_viejo, ' - ') AS 'NUM_RECIBO_VIEJO',
						DATE_FORMAT(pagos.fch_cobro,'%d/%m/%Y') AS 'FECHA',
						DATE_FORMAT(cuotas.fch_vto,'%d/%m/%Y') AS 'FECHA_VTO',
						cuotas.id_cuota AS 'ID_CUOTA',
						/*SUM( cuotas_detalles.importe ) AS 'IMPORTE',
						SUM( IF( formas_pagos.signo > 0, 1, 0 ) * cuotas_detalles.importe ) AS 'IMPORTE_COBRADO',*/
						SUM(if(formas_pagos.id_forpag in (1,2,3),1,0) * cuotas_detalles.importe) AS 'IMPORTE',
						SUM(IF( formas_pagos.signo > 0, 1, -1) * cuotas_detalles.importe ) AS 'IMPORTE_COBRADO',
						IF( polizas.num_poliza > 0, polizas.num_poliza, '') as 'NUM_POLIZA', 
						CONCAT( titulares.ape, ', ', titulares.nom ) as 'ASEGURADO',
						'$id_caja_operario' AS 'ID_CAJ_OPE',
						IFNULL(vehiculos.dominio,'---') AS 'DOMINIO'
									
						
					FROM pagos_polizas
								
						LEFT JOIN pagos ON pagos.id_pago = pagos_polizas.id_pago
						LEFT JOIN cuotas ON cuotas.id_pago = pagos.id_pago
						LEFT JOIN cuotas_detalles ON cuotas_detalles.id_cuota = cuotas.id_cuota
						LEFT JOIN formas_pagos ON formas_pagos.id_forpag = cuotas_detalles.id_forpag	
						LEFT JOIN polizas ON pagos_polizas.id_pol = polizas.id_pol
						LEFT JOIN titulares ON polizas.id_titu = titulares.id_titu
						LEFT JOIN polizas_detalles ON polizas.id_pol = polizas_detalles.id_pol
						LEFT JOIN vehiculos ON vehiculos.id_vehi = polizas_detalles.id_vehi
								
					WHERE 
					
						pagos_polizas.id_caj_ope = '$id_caja_operario'
						AND pagos.estado is null
						
					GROUP BY cuotas_detalles.id_cuota 
					ORDER BY pagos.fch_cobro DESC		
				   ";
			
			$cobros = $oMysql->consultaSel( $SQL );
			
			$cobranzas = array();
			
			$cobranzas = setINDEX($cobros, 'ID_CUOTA');
			
			/*foreach ($cobros as $cobro){
				
				$index = $cobro['ID_CUOTA'];
				
				unset($cobro['ID_CUOTA']);
				
				$cobranzas[$index] = ( ( count( $cobro ) == 1 )? ( array_shift( $cobro ) ) : $cobro);
							
			}*/
			
			$aCobros = array();
			foreach( $cobranzas AS $idCuota => $aCuota ) {
			
				$SQL = "SELECT importe AS 'IMPORTE', formas_pagos.nombre AS 'FORMA_PAGO' FROM cuotas_detalles LEFT JOIN formas_pagos USING (id_forpag) WHERE id_cuota = '$idCuota'";
				
				$aFila = $mysql_se->query( $SQL );
				
				$aFila = setINDEX($aFila , 'FORMA_PAGO');
					
				$dImporte = $aFila['Efectivo']+$aFila['Ticket']+$aFila['Tarjeta']+ $aFila['Descuento'];
		
				if ($dImporte > 0 ){
					
					$aCobros[$idCuota]=$cobranzas[$idCuota];
					$aCobros[$idCuota]['EFECTIVO'] = number_format((double) $aFila['Efectivo'], 2 );
					$aCobros[$idCuota]['TICKET'] = number_format((double)  $aFila['Ticket'], 2 );
					$aCobros[$idCuota]['TARJETA'] = number_format((double)  $aFila['Tarjeta'], 2 );
					$aCobros[$idCuota]['DESCUENTO'] = number_format((double)  $aFila['Descuento'], 2 );
					
				}
			
			}
			//var_export($dImporte);die();	
			$fSumaEfectivo 	= 0;
			$fSumaTarjeta 	= 0;
			$fSumaTicket 	= 0;
			$fSumaDescuento = 0;
			$fSumaCobrado 	= 0;
			$fSumaSRecibo 	= 0;		
			$prefix = "&nbsp;";
			Foreach( $aCobros as $aFila ) {
				
				@ extract( $aFila );
			
				$html .= "<tr>";
				$html .= "<td align='center'> $NUM_RECIBO </td>";			
				$html .= "<td align='center'> $NUM_POLIZA </td>";
				$html .= "<td align='left'> $ASEGURADO </td>";
				$html .= "<td align='center'> $DOMINIO </td>";
				$html .= "<td align='right'> $prefix $EFECTIVO </td>";
				$html .= "<td align='right'> $prefix $TARJETA </td>";
				$html .= "<td align='right'> $prefix $TICKET </td>";
				//$html .= "<td align='right'> $prefix $DESCUENTO </td>";
				$html .= "<td align='right'> $prefix $IMPORTE</td>";
				$html .= "<td align='right'> $prefix $IMPORTE_COBRADO </td>";
				$html .= "</tr>";
						
				$fSumaEfectivo 	+= $EFECTIVO;
				$fSumaTarjeta 	+= $TARJETA;
				$fSumaTicket 	+= $TICKET;
				$fSumaDescuento += $DESCUENTO;
				$fSumaCobrado 	+= $IMPORTE_COBRADO;
				$fSumaSRecibo 	+= $IMPORTE;
			}
			
			$fSumaEfectivo	= number_format((double) $fSumaEfectivo, 2 );
			$fSumaTarjeta 	= number_format((double) $fSumaTarjeta, 2 );
			$fSumaTicket 	= number_format((double) $fSumaTicket, 2 );
			$fSumaDescuento = number_format((double) $fSumaDescuento, 2 );
			$fSumaCobrado 	= number_format((double) $fSumaCobrado, 2 );
			$fSumaSRecibo 	= number_format((double) $fSumaSRecibo, 2 );
			
			$html .= "<tr>";
			$html .= "<td colspan='4' align='right'><strong>TOTALES</strong></td>";
			$html .= "<td align='right'> $prefix $fSumaEfectivo </td>";
			$html .= "<td align='right'> $prefix $fSumaTarjeta </td>";
			$html .= "<td align='right'> $prefix $fSumaTicket </td>";
			//$html .= "<td align='right'> $prefix $fSumaDescuento </td>";
			$html .= "<td align='right'> $prefix $fSumaSRecibo</td>";
			$html .= "<th align='right'> $prefix $fSumaCobrado </th>";
			$html .= "</tr>";
			
			$configure['cobranzas_operador_seal'] = $html;			
			
			
		}
		
		
	
		
		
		
	}
	
	
	function setINDEX($datos,$index){
		$x = array();
		
		foreach ($datos as $dato){
			
			$value = $dato[$index];
			
			unset($dato[$index]);
			
			$x[$value] = ( ( count( $dato ) == 1 )? ( array_shift( $dato ) ) : $dato );
						
		}	
		
		return $x ;	
	}


	#COBRANZAS
	
	
	$html = "";
	
	$caja_year = date("Y");
	$caja_month= date("m");
	$caja_day  = date("d");
	$idempleado = $_SESSION['id_user'];
	
	$sub_query = " WHERE Cobranzas.idEmpleado = '{$idempleado}' AND YEAR(Cobranzas.dFechaCobranza) = $caja_year AND MONTH(Cobranzas.dFechaCobranza) = $caja_month AND DAY(Cobranzas.dFechaCobranza) = $caja_day AND Cobranzas.sEstado = 'A' " ;
	//var_export("CALL usp_getCobranzas(\"$sub_query\");");die();
	$cobranzas = $oMysql->consultaSel("CALL usp_getCobranzas(\"$sub_query\");");
	$prefix = "&nbsp;";
	if(!$cobranzas){
		$html .= "<tr>";
			$html .= "<td class='' align='left' colspan='5'>- no se encontraron cobranzas</td>";
		$html .= "</tr>";

		$configure['cobranzas_operador_tarjeta'] = $html;	
	}else{
		
		//$cantidad_cobranzas = sizeof($cobranzas);
		
		foreach ($cobranzas as $cobranza){

			$sUsuario = $cobranza['sApellido'].', '.$cobranza['sNombre'];

			$html .= "<tr>";
				$html .= "<td align='center'>{$cobranza['sNumeroCuenta']}</td>";
				$html .= "<td align='left'>{$cobranza['sApellido']}, {$cobranza['sNombre']}</td>";
				$html .= "<td align='center'>{$cobranza['sNroRecibo']}</td>";
				$html .= "<td align='center'>{$cobranza['dFechaCobranza']}</td>";
				$html .= "<td class='' align='right'> $prefix {$cobranza['fImporte']}</td>";
			$html .= "</tr>";

			$total_importe = $total_importe + $cobranza['fImporte'] ;
		}
		
		$total_importe 	= number_format((double) $total_importe, 2 );
		
		
		
		$html .= "<tr>";
			$html .= "<td align='center' colspan='4'></td>";
			$html .= "<td class='column_operations_right' align='right'> $prefix $total_importe</td>";
		$html .= "</tr>";
		
		$configure['cobranzas_operador_tarjeta'] = $html;
	
	}
	
	
	$buttons = new _buttons_('R');	
	
	$buttons->add_button('href','javascript:_printCobranzas();','imprimir','print');

	$buttons->set_width('100%;');
	
	$botonera = $buttons->get_buttons();	
	
	$configure['buttons'] = $botonera ;	
	
	
	//$oXajax=new xajax();
		
	//$oXajax->register( XAJAX_FUNCTION ,"reportesTarjetasCheck");
	
	//$oXajax->register( XAJAX_FUNCTION ,"procesarPolizasTACheck");

	//$oXajax->processRequest();
	
	//$oXajax->printJavascript("../includes/xajax/");	
	
	//$total = $total_importe + $fSumaSRecibo;//$_GET['_sr'];
	$total = $total_importe + $fSumaCobrado;//$_GET['_sr'];
	
	$total 	= number_format((double) $total, 2 );
	
	$configure['importe_global'] = $total;
	
	$configure['prefix'] = $prefix;

	$tableHTML = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Reportes/ReportesCobranzasSEAL.tpl",$configure);	
	
	$configure['IMAGES_DIR'] = IMAGES_DIR;
	

	xhtmlHeaderPaginaGeneral($configure);
	
	echo xhtmlMainHeaderPagina($configure);
	
	echo $tableHTML;

	echo xhtmlFootPagina();

?>