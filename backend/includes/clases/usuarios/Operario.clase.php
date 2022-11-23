<?php //------------------------------------------------------------------------

class Operario extends Usuario {
	
	
	
	public function __construct( $id_user = false ) { parent::__construct($id_user); }
		
	//-------------------------------------------------------------------------------
	
	public function getCobros( $unix_timestamp = false, $id_caja = false ) {
		
		GLOBAL $oMysql;
		
		
		if(!$id_caja) $cajaEncargado = Caja::getCaja( $this, $unix_timestamp ? $unix_timestamp : time() );
		else $cajaEncargado = new Caja($id_caja);
		
		if($cajaEncargado) {
			
			
			$vars =  array('ID_CAJ_OPE' => $cajaEncargado->getIDCajaOperario( $this ) );
			$consulta = parserTemplate( TEMPLATES_SQL . 'caja.operario.cobros.get.sql', $vars );
			
			
			$cobros = $oMysql->consultaSel( $consulta, false, 'ID_CUOTA' );
			
			
			
			Foreach( $cobros AS $idCuota => $aCuota ) {
			
				$sConsulta = "SELECT importe AS 'IMPORTE', formas_pagos.nombre AS 'FORMA_PAGO' FROM cuotas_detalles LEFT JOIN formas_pagos USING (id_forpag) WHERE id_cuota = '$idCuota'";
				$aFila = $oMysql->consultaSel( $sConsulta, false, 'FORMA_PAGO' );
				
						
				$dImporte=$aFila['Efectivo']+$aFila['Ticket']+$aFila['Tarjeta']+ $aFila['Descuento'];
				if ($dImporte > 0 ){
					
					$aCobros[$idCuota]=$cobros[$idCuota];
					$aCobros[$idCuota]['EFECTIVO'] = number_format( $aFila['Efectivo'], 2 );
					$aCobros[$idCuota]['TICKET'] = number_format(  $aFila['Ticket'], 2 );
					$aCobros[$idCuota]['TARJETA'] = number_format(  $aFila['Tarjeta'], 2 );
					$aCobros[$idCuota]['DESCUENTO'] = number_format(  $aFila['Descuento'], 2 );
					
				}
			
			}
			
			return $aCobros;
		
		}
	
		
		return array();
	}
		
	
	public function getCobros_Fecha($sFchDesde,$sFchHasta) {
		
		GLOBAL $oMysql;
			
			
			$sConsulta="Call usp_getCobrosUsuario_Fechas($this->id_user,\"$sFchDesde\",\"$sFchHasta\")";
			
			//var_export($sConsulta);die();
			
			$cobros = $oMysql->consultaSel( $sConsulta, false, 'ID_CUOTA' );
			
			
			
			Foreach( $cobros AS $idCuota => $aCuota ) {
			
				$sConsulta = "SELECT importe AS 'IMPORTE', formas_pagos.nombre AS 'FORMA_PAGO' FROM cuotas_detalles LEFT JOIN formas_pagos USING (id_forpag) WHERE id_cuota = '$idCuota'";
				$aFila = $oMysql->consultaSel( $sConsulta, false, 'FORMA_PAGO' );
				
				$dImporte=$aFila['Efectivo']+$aFila['Ticket']+$aFila['Tarjeta']+ $aFila['Descuento'];
				if ($dImporte > 0 ){
					
					$aCobros[$idCuota]=$cobros[$idCuota];
					$aCobros[$idCuota]['EFECTIVO'] = number_format( $aFila['Efectivo'], 2 );
					$aCobros[$idCuota]['TICKET'] = number_format(  $aFila['Ticket'], 2 );
					$aCobros[$idCuota]['TARJETA'] = number_format(  $aFila['Tarjeta'], 2 );
					$aCobros[$idCuota]['DESCUENTO'] = number_format(  $aFila['Descuento'], 2 );
					
				}
			
			}
			
			return $aCobros;
		
		
	
		
		return array();
	}
	
	
	
}

//--------------------------------------------------------------------------------