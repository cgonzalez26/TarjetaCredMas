<?php //------------------------------------------------------------------------

class CajaOperario {
	
		
	private $cobros = array();
	
	private $cerrada = false;
	private $id_user;
	private $id_user_cie;
	private $id_caj_ope;
	
	private $fecha_ape;
	private $fecha_cie;
	private $fecha_caja;
	
	
	public function __construct( $id_caja = false ) {  
		
		if($id_caja) {
			
			GLOBAL $oMysql;
			
			$consulta = "SELECT id_user, id_user_cie, IF(importe IS NULL, 0,1 ) AS 'cerrada', UNIX_TIMESTAMP(fch_cie) AS 'fch_cie', UNIX_TIMESTAMP(fch_ape) AS 'fch_ape', UNIX_TIMESTAMP(fch_caja) AS 'fch_caja',importe FROM cajas_operarios WHERE id_caj_ope ='{$id_caja}'";
			$datos = $oMysql->consultaSel( $consulta, true );
			
			if($datos) {
				
				$this->cerrada = $datos['cerrada'];
				$this->id_user = $datos['id_user'];
				$this->id_user_cie = $datos['id_user_cie'];
				$this->id_caj_ope = $id_caja;
				$this->fecha_ape = $datos['fch_ape'];
				$this->fecha_cie = $datos['fch_cie'];
				$this->fecha_caja = $datos['fch_caja'];
				
				$this->cobros = $oMysql->consultaSel( parser_archivo( TEMPLATES_SQL . 'caja.operario.cobros.get.sql', array( 'ID_CAJA' => $this->id_caj_ope ) ), false, 'ID_CAJA');
				
								
				Foreach( $this->cobros AS $idCuota => $aCuota ) {
			
					$sConsulta = "SELECT 
			
						importe AS 'IMPORTE',
						formas_pagos.nombre AS 'FORMA_PAGO'
				
					FROM cuotas_detalles LEFT JOIN formas_pagos USING (id_forpag) WHERE id_cuota = '$idCuota'";
			
			
					$aFila = $oMysql->consultaSel( $sConsulta, false, 'FORMA_PAGO' );
						
					$this->cobros[$idCuota]['Efectivo'] = number_format( $aFila['Efectivo'], 2 );
					$this->cobros[$idCuota]['Ticket'] = number_format(  $aFila['Ticket'], 2 );
					$this->cobros[$idCuota]['Tarjeta'] = number_format(  $aFila['Tarjeta'], 2 );
					$this->cobros[$idCuota]['Descuento'] = number_format(  $aFila['Descuento'], 2 );
			
				}
			
			} else echo $oMysql->getError();
			
		}
	}
	
	//--------------------------------------------------------------------------------
	
	
	public function getIDCaja() { return $this->id_caj_ope; }
	
	
	public function getTotalCobrado() {
		
		
		$importe = 0;
		Foreach( $this->cobros as $fila ) $importe += $fila['IMPORTE_COBRADO'];
		
		return $importe;
	}
	
	public function getFecha() { return $this->fecha_caja; }
		
	
	public function getCobros() { return $this->cobros; }
	
	//--------------------------------------------------------------------------------
	
	public function estaCerrada() { return $this->cerrada; }
}

//-------------------------------------------------------------------------------- ?>