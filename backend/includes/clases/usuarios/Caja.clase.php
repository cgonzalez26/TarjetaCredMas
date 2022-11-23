<?php //-------------------------------------------------------------------

class Caja {
	

	
	
	public static function getCajaActual( Operario $usuario ) {

		GLOBAL $oMysql;		
			
		$id_dep = $usuario->getIDDep();
		$consulta = "SELECT MAX(id_caja) FROM cajas WHERE id_dep = '$id_dep' AND estado='A'";
		$id_caja = $oMysql->consultaSel( $consulta, true );
		
		if($id_caja) return new Caja($id_caja);
		else return false;
	}
	//---------------------------------------------------------
	//metodo agregado conel fin de abrir una caja con un determinado dependiente
	public static function getCajaDependiente($id_dep ) {
		GLOBAL $oMysql;		 
		$consulta = "SELECT MAX(id_caja) FROM cajas WHERE id_dep = '$id_dep' AND estado='A'";
		$id_caja = $oMysql->consultaSel( $consulta, true );
		
		if($id_caja) return new Caja($id_caja);
		else return false;
	}
	
	public static function abrirCajaDependiente( $id_dep,$unix_timestamp,$dias=false)
	 {
		GLOBAL $oMysql;	
		
		$consulta = "SELECT MAX(UNIX_TIMESTAMP(fch)) AS Fecha FROM cajas WHERE id_dep = '$id_dep'";
		$ultima=$oMysql->consultaSel( $consulta, true );
		if($ultima) $ultima_unix_timestamp=$ultima; 
		else $ultima_unix_timestamp=time();
		
		if($unix_timestamp < time() )  $masundia=time() + 86400;
		else  $masundia=$ultima_unix_timestamp+86400;
	    
		
		
		if( $unix_timestamp > $masundia ) throw new Exception( "La caja no puede ser posterior a la fecha : ".date('d/m/Y',$masundia));
		
		else {
			
			
			
			if ($unix_timestamp==0) 
			{
				$totaldias=86400*$dias;
				$unix_timestamp=$ultima_unix_timestamp + $totaldias;
			}
			
			$consulta = "SELECT MAX(UNIX_TIMESTAMP(fch)) AS Fecha FROM cajas WHERE id_dep = '$id_dep'";
			$ultima_unix_timestamp = $oMysql->consultaSel( $consulta, true );
			
			if( $ultima_unix_timestamp && $unix_timestamp < $ultima_unix_timestamp ) throw new Exception("No puede abrir una caja anterior a una ya existente");
			
			else {
				
				$consulta = "SELECT COUNT(*) FROM cajas WHERE id_dep = '$id_dep' AND DATE_FORMAT(fch, '%d/%m/%Y') = DATE_FORMAT(FROM_UNIXTIME('$unix_timestamp'), '%d/%m/%Y')";
				$cant = $oMysql->consultaSel($consulta, true);
				
							
				if($cant > 0)  throw new Exception("Ya existe una caja en esa fecha");
				
				
				else {
					$sFecha=date('Y-m-d',$unix_timestamp); 
					//FROM_UNIXTIME('$unix_timestamp')
					$consulta = "INSERT INTO cajas (id_dep, fch, fch_ape, estado) VALUES ('$id_dep', '$sFecha', NOW(), 'A')";
					$oMysql->consultaBool($consulta);
			
					$id_caja = $oMysql->getLastID();
					
					if($id_caja) return new Caja($id_caja);
					else throw new Exception('No se pudo abrir la caja');
					
				}
			}
			
			
		}
		
		
		return false;
		
	}
	
	
	//-----------------------------------------------------------
	
	public static function getCaja( Operario $usuario, $unix_timestamp ) {
		
		
		GLOBAL $oMysql;		
			
		$id_dep = $usuario->getIDDep();
		$consulta = "SELECT id_caja FROM cajas WHERE id_dep = '$id_dep' AND DATE_FORMAT(fch, '%d/%m/%Y') =DATE_FORMAT(FROM_UNIXTIME('$unix_timestamp'), '%d/%m/%Y')";
		$id_caja = $oMysql->consultaSel( $consulta, true );
		
		if($id_caja) return new Caja($id_caja);
		else return false;		
	}
	
	
	
	public static function abrirCaja( Encargado $encargado, $unix_timestamp ) {
		
		$hoymasundia=time()+86400;
		if( $unix_timestamp > $hoymasundia ) throw new Exception( "La caja no puede ser posterior a la fecha" );
		
		else {
			
			
			GLOBAL $oMysql;	
			
			$id_dep = $encargado->getIDDep();
			
			$consulta = "SELECT MAX(UNIX_TIMESTAMP(fch)) AS Fecha FROM cajas WHERE id_dep = '$id_dep'";
			$ultima_unix_timestamp = $oMysql->consultaSel( $consulta, true );
			
			if( $ultima_unix_timestamp && $unix_timestamp < $ultima_unix_timestamp ) throw new Exception("No puede abrir una caja anterior a una ya existente");
			
			else {
				
				$consulta = "SELECT COUNT(*) FROM cajas WHERE id_dep = '$id_dep' AND DATE_FORMAT(fch, '%d/%m/%Y') = DATE_FORMAT(FROM_UNIXTIME('$unix_timestamp'), '%d/%m/%Y')";
				$cant = $oMysql->consultaSel($consulta, true);
				
							
				if($cant > 0)  throw new Exception("Ya existe una caja en esa fecha");
				
				
				else {
					
					$consulta = "INSERT INTO cajas (id_dep, fch, fch_ape, estado) VALUES ('$id_dep', FROM_UNIXTIME('$unix_timestamp'), NOW(), 'A')";
					$oMysql->consultaBool($consulta);
			
					$id_caja = $oMysql->getLastID();
					
					if($id_caja) return new Caja($id_caja);
					else throw new Exception('No se pudo abrir la caja');
					
				}
			}
			
			
		}
		
		
		return false;
		
	}
	
	
	
	
	//-----------------------------------------------------------

	
	private $id_caja;
	private $id_dep;
	private $fecha;
	private $fecha_cie;
	private $fecha_ape;
	private $cerrada;
	private $cerradaOperarios;
	private $saldo;
	
	
	public function __construct($id_caja) {
		
		if($id_caja) {
			
			$this->id_caja = $id_caja;	
			$this->_cargaDatos();
		}		
	}
	

	private function _cargaDatos() {
		
		GLOBAL $oMysql;
		$consulta = "SELECT id_dep, UNIX_TIMESTAMP(fch) AS fecha, UNIX_TIMESTAMP(fch_ape) AS fecha_ape, UNIX_TIMESTAMP(fch_cie) as fecha_cie, estado, estado_operarios, saldo FROM cajas WHERE id_caja = '{$this->id_caja}'";
			
		$fila = $oMysql->consultaSel( $consulta, true );
					
		
		$this->id_dep = $fila['id_dep'];
		$this->fecha = $fila['fecha'];
		$this->fecha_ape = $fila['fecha_ape'];
		$this->fecha_cie = $fila['fecha_cie'];
		$this->cerrada = $fila['estado'] == 'C';
		$this->cerradaOperarios = $fila['estado_operarios'] == 'C';
		$this->saldo = $fila['saldo'];
		
	}
	
	
	public function getID() { return $this->id_caja; }
	
	public function getIDDep() { return $this->id_dep; }
		
	//-----------------------------------------------------------
	
	public function agregarIngreso( $id_user, $importe, $id_tingre, $detalle ) {
		
		GLOBAL $oMysql;
		$oMysql->escaparCadena($detalle);
		//if detalle
		$sTabla="ingresos";
		$sSet="id_user, id_tingre, id_caja, detalle, importe";
		$sValues="'$id_user', '$id_tingre', '{$this->id_caja}', '$detalle', '$importe'";
		$sConsulta="Call usp_InsertTable(\"$sTabla\",\"$sSet\",\"$sValues\",\"{$_SESSION['id_user']}\",\"0\")";
		$idIngreso= $oMysql->consultaSel($sConsulta);
		$this->_cargaDatos();
		
		//$consulta = "INSERT INTO ingresos (id_user, id_tingre, id_caja, detalle, importe) VALUES ('$id_user', '$id_tingre', '{$this->id_caja}', '$detalle', '$importe');";
		//$exito = (boolean) $oMysql->consultaBool($consulta);	
		//return $oMysql->getLastID();
		
		return $idIngreso;
	}
	
	
	
	public function agregarEgreso( $id_user, $importe, $id_tegre, $detalle, $num_cbte ) {
		
		
		GLOBAL $oMysql;
		$oMysql->escaparCadena($detalle);
		
		
		$sTabla="egresos";
		$sSet="id_user, id_tegre, id_caja, detalle, importe";
		$sValues="'$id_user', '$id_tegre', '{$this->id_caja}', '$detalle', '$importe'";
		$sConsulta="Call usp_InsertTable(\"$sTabla\",\"$sSet\",\"$sValues\",\"{$_SESSION['id_user']}\",\"0\")";
		$idEgreso= $oMysql->consultaSel($sConsulta);
		$this->_cargaDatos();
		
		/*
		$consulta = "INSERT INTO egresos (id_user, id_tegre, id_caja, detalle, importe) VALUES ('$id_user', '$id_tegre', '{$this->id_caja}', '$detalle', '$importe');";	
		$exito = (boolean) $oMysql->consultaBool($consulta);
		$this->_cargaDatos();
		return $oMysql->getLastID();*/
		
		return $idEgreso;
	}
	
	
	public function getFecha() { return $this->fecha; }
	
	
	public function getSaldo() { return $this->getCerrada() ? $this->saldo : $this->getTotalIngresos() - $this->getTotalEgresos(); }	
	
	
	
	
	public function getCerrada() { return $this->cerrada; }
	
	public function getAbierta() { return !$this->getCerrada(); }
	
	
	public function getCerradaOperarios() { return $this->cerradaOperarios; }
	
	public function getAbiertaOperarios() { return !$this->getCerradaOperarios(); }
	
	//----------------------------------------------------------------------
	
	public function getCajaAnterior() {
		
		
		GLOBAL $oMysql;
		
		$consulta = "SELECT MAX(id_caja) FROM cajas WHERE id_dep = '{$this->id_dep}' AND id_caja < '{$this->id_caja}'";
		$id_caja = $oMysql->consultaSel($consulta, true);
		
		if($id_caja) return new Caja($id_caja);
		else return false;
		
	}
	
	
	
	//----------------------------------------------------------------------
	
	public function getIngresos() {
		
		GLOBAL $oMysql;
		$consulta="SELECT 
		                ingresos.importe, 
		                tipos_ingresos.tipo, 
		                ingresos.id_ingre, 
		                tipos_ingresos.id_tingre,
		                user.login as usuario  
		                FROM ingresos 
		                LEFT JOIN tipos_ingresos USING (id_tingre) 
		                left join user using(id_user)
		                WHERE id_caja = '{$this->id_caja}'";
		return $oMysql->consultaSel($consulta);
	}
	
	public function getEgresos() {
		
		GLOBAL $oMysql;
		$consulta="SELECT 
						egresos.importe, 
						tipos_egresos.tipo, 
						egresos.id_egre, 
						egresos.id_tegre,
						user.login as usuario  
						FROM egresos 
						LEFT JOIN tipos_egresos USING (id_tegre) 
						left join user using(id_user)
						WHERE id_caja = '{$this->id_caja}'";
		return $oMysql->consultaSel($consulta);
	}
	
	public function getIDCajaOperario( Operario $operario ) {
		
		GLOBAL $oMysql;
			
		$consulta = "SELECT id_caj_ope FROM cajas_operarios WHERE id_caja = '{$this->id_caja}' AND id_user = '".$operario->getID()."'";
		$id_caj_ope = $oMysql->consultaSel($consulta, true);
		
		if($id_caj_ope) return $id_caj_ope;
		else {
		
			
			$consulta = "INSERT INTO cajas_operarios (id_caja, id_user) VALUES ('{$this->id_caja}', '".$operario->getID()."')";
			$oMysql->consultaBool($consulta);
			
			return $oMysql->getLastID();
			
		}
		
			
	
	}
	
	
	public function cerrarOperarios() {
		
		if(!$this->getCerradaOperarios()) {
			
			GLOBAL $oMysql;
			
			$totalOperarios = 0;
			$idOperarios = $oMysql->consultaSel( "SELECT DISTINCT id_user FROM cajas_operarios WHERE id_caja = '{$this->id_caja}'" );
			
			foreach($idOperarios as $idOperario) {
				
				$operario = new Operario($idOperario);
				$cobros = $operario->getCobros(false,$this->id_caja);
								
				$totalOperario = 0;
				
				foreach($cobros as $cobro) { 
					
					$totalOperario += $cobro['IMPORTE_COBRADO']; 
					$id_caj_ope = $cobro['ID_CAJ_OPE'];
				}
				
				$oMysql->consultaBool( "UPDATE cajas_operarios SET importe = '{$totalOperario}' WHERE id_caj_ope = {$id_caj_ope}" );
				//$totalOperarios += $totalOperario;
				//$operario->getNombre();
				$user=$oMysql->consultaSel("select login from user where id_user={$idOperario}",true);
				$datos=date('d-m-Y H:i:s')."  ".$user;
				$this->agregarIngreso( $idOperario, $totalOperario, 7, $datos );
			}
			
			//$user=$oMysql->consultaSel("select login from user where id_user={$_SESSION['id_user']}");
            //$datos=date('d-m-Y H:i:s')."  ".$user; 
			//$this->agregarIngreso( $_SESSION['id_user'], $totalOperarios, 7, '' );
			$oMysql->consultaBool("UPDATE cajas SET estado_operarios = 'C' WHERE id_caja = '{$this->id_caja}'");
			
			$this->_cargaDatos();
		}		
	}
	
	
	public function cerrarCaja() {
		
		if($this->getCerradaOperarios()) {
			
			
			GLOBAL $oMysql;
			
			$saldo = ($this->getCajaAnterior() ? $this->getCajaAnterior()->getSaldo() : 0 )  + $this->getTotalIngresos() - $this->getTotalEgresos();
			
			
			$exito = (boolean) $oMysql->consultaBool("UPDATE cajas SET estado = 'C', fch_cie = NOW(), saldo = '$saldo' WHERE id_caja = '{$this->id_caja}'");
			$this->_cargaDatos();
			return $exito;
			
		}
	}
	
	
	public function getTotalEgresos() {
		
		GLOBAL $oMysql;
		return $oMysql->consultaSel("SELECT SUM(importe) FROM egresos WHERE id_caja = '{$this->id_caja}'", true);
	}
	
	public function getTotalIngresos() {
		
		GLOBAL $oMysql;
		return $oMysql->consultaSel("SELECT SUM(importe) FROM ingresos WHERE id_caja = '{$this->id_caja}'", true);
	}
	
	
	
	
	
}

//------------------------------------------------------------------------ ?>