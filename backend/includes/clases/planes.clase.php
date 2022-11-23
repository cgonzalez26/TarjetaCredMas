<?
final class planes {
	
	public $id = 0;
	public $datos = array();
	private $operations = 'new';
	private $codigo_error = 0;
	
	
	public function __construct( $idplanes ){ $this->id = $idplanes; }
	
	public function get_id(){ return $this->id ;}
		
	public function set_datos(){
		global $oMysql;	

		$this->datos = $oMysql->consultaSel("CALL usp_getFichaPlanes(\" WHERE Planes.id = '{$this->get_id()}'\");",true);

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
				
				if($datos['idTipoPlan'] == 0){
					$message .= 'El campo Tipo Plan es requerido.' . $break ;
				}

				if($datos['sNombre'] == ''){
					$message .= 'El campo Nombre es requerido.' . $break ;
				}
				
				if($datos['dVigenciaDesde'] == ''){
					$message .= 'El campo Vigencia Desde es requerido.' . $break ;
				}
				
				if($datos['dVigenciaHasta'] == ''){
					$message .= 'El campo Vigencia Hasta es requerido.' . $break ;
				}
				
				if($datos['iDiaCierre'] == '' ){
					$message .= 'El campo Dia Cierre es requerido.' . $break ;
				}
				
				if($datos['iDiaCorridoPago'] == ''){
					$message .= 'El campo Dia Corrido de Pago es requerido.' . $break ;
				}
				
				if($datos['fArancel'] == ''){
					$message .= 'El campo Arancel es requerido.' . $break ;
				}
				
				if($datos['fCostoFinanciero'] == ''){
					$message .= 'El campo Costo Financiero es requerido.' . $break ;
				}
				
				if($datos['iCantidadCuotas'] == ''){
					$message .= 'El campo Cantidad Cuotas es requerido.' . $break ;
				}
				
				if($datos['fInteresUsuario'] == ''){
					$message .= 'El campo interes Usuario es requerido.' . $break ;
				}
				
				$datos['idComercio'] = intval(_decode($datos['_ic']));

				if($datos['idComercio'] == 0 && !is_integer($datos['idComercio'])){
					$message .= 'El codigo de Comercio es incorrecto.' . $break;
				}else{
					$checkPlanes = $oMysql->consultaSel("SELECT fcn_checkExistenciaPlanComercio(\"{$datos['idTipoPlan']}\",\"{$datos['iCantidadCuotas']}\",\"{$datos['idComercio']}\");",true);
					//var_export($checkPlanes);die();
					if($checkPlanes != 0){
						$message .= 'Existe Plan con igual Tipo Plan y Cantidad de Cuotas Especificados.' . $break;
					}
				}
				
				

				break;
			case 'edit':

				if($datos['idTipoPlan'] == 0){
					$message .= 'El campo Tipo Plan es requerido.' . $break ;
				}

				if($datos['sNombre'] == ''){
					$message .= 'El campo Nombre es requerido.' . $break ;
				}
				
				if($datos['dVigenciaDesde'] == ''){
					$message .= 'El campo Vigencia Desde es requerido.' . $break ;
				}
				
				if($datos['dVigenciaHasta'] == ''){
					$message .= 'El campo Vigencia Hasta es requerido.' . $break ;
				}
				
				if($datos['iDiaCierre'] == '' ){
					$message .= 'El campo Dia Cierre es requerido.' . $break ;
				}
				
				if($datos['iDiaCorridoPago'] == ''){
					$message .= 'El campo Dia Corrido de Pago es requerido.' . $break ;
				}
				
				if($datos['fArancel'] == ''){
					$message .= 'El campo Arancel es requerido.' . $break ;
				}
				
				if($datos['fCostoFinanciero'] == ''){
					$message .= 'El campo Costo Financiero es requerido.' . $break ;
				}
				
				if($datos['iCantidadCuotas'] == ''){
					$message .= 'El campo Cantidad Cuotas es requerido.' . $break ;
				}
				
				if($datos['fInteresUsuario'] == ''){
					$message .= 'El campo interes Usuario es requerido.' . $break ;
				}
				
				$datos['idComercio'] = intval(_decode($datos['_ic']));

				if($datos['idComercio'] == 0 && !is_integer($datos['idComercio'])){
					$message .= 'El codigo de Comercio es incorrecto.' . $break;
				}else{
					$checkPlanes = $oMysql->consultaSel("SELECT fcn_checkExistenciaPlanComercio(\"{$datos['idTipoPlan']}\",\"{$datos['iCantidadCuotas']}\",\"{$datos['idComercio']}\");",true);

					$idPlan = intval(_decode($datos['_i']));

					if($checkPlanes != 0 ){

						if($checkPlanes != $idPlan){
							$message .= 'Existe Plan con igual Tipo Plan y Cantidad de Cuotas Especificados.' . $break;	
						}

					}
				}
				

				break;		
		}
		
		return $message;
	}
	
	static function _check_erase_($id = 0){
		#determinar cuando no se puede dar de baja un usuario, mientras tanto
		
		$message = '';
		
		return $message;
	}
	
	public function get_datos(){

		if(sizeof($this->datos) == 0){ $this->set_datos(); }

		return $this->datos;

	}
	
	public function add_dato($index,$value){ $this->datos[$index] = $value; }
	
	public function get_dato($index = ''){ return $this->datos[ $index ]; }

	public function insert($datos){
		global $oMysql;
		
		
		$datos = _stringUpper_($datos);

		$datos = _parserCharacters_($datos);

		$estado = "A";
		
		$idUser = $_SESSION['id_user'];
		
		$datos['dVigenciaDesde'] = dateToMySql($datos['dVigenciaDesde']);
		$datos['dVigenciaHasta'] = dateToMySql($datos['dVigenciaHasta']);

		$set = "
				idComercio,
				idTipoPlan,
				idEmpleado,
				sNombre,
				iDiaCierre,
				iDiaCorridoPago,
				fArancel,
				dVigenciaDesde,
				dVigenciaHasta,
				fCostoFinanciero,
				iCantidadCuota,
				fInteresUsuario,
				sEstado
				";

		$values = "
					'{$datos['idComercio']}',
					'{$datos['idTipoPlan']}',
					'$idUser',
					'{$datos['sNombre']}',
					'{$datos['iDiaCierre']}',
					'{$datos['iDiaCorridoPago']}',
					'{$datos['fArancel']}',
					'{$datos['dVigenciaDesde']}',
					'{$datos['dVigenciaHasta']}',
					'{$datos['fCostoFinanciero']}',
					'{$datos['iCantidadCuotas']}',
					'{$datos['fInteresUsuario']}',
					'$estado'
					";

		$toauditory = "insercion de PLANES ::: Nombre: {$datos['sNombre']}";
		
		$id = $oMysql->consultaSel("CALL usp_InsertTable(\"Planes\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"43\",\"$toauditory\");",true);
		
		$this->set_error_nro_query($oMysql->getErrorNo());

		$this->id = $id;
		
	}
	
	public function update($datos){
		global $oMysql;

		$datos = _stringUpper_($datos);

		$datos = _parserCharacters_($datos);
		
		$datos['dVigenciaDesde'] = dateToMySql($datos['dVigenciaDesde']);
		$datos['dVigenciaHasta'] = dateToMySql($datos['dVigenciaHasta']);		
		
		$set = "
				idTipoPlan='{$datos['idTipoPlan']}',
				sNombre='{$datos['sNombre']}',
				iDiaCierre='{$datos['iDiaCierre']}',
				iDiaCorridoPago='{$datos['iDiaCorridoPago']}',
				fArancel='{$datos['fArancel']}',
				dVigenciaDesde='{$datos['dVigenciaDesde']}',
				dVigenciaHasta='{$datos['dVigenciaHasta']}',
				fCostoFinanciero='{$datos['fCostoFinanciero']}',
				iCantidadCuota='{$datos['iCantidadCuotas']}',
				fInteresUsuario='{$datos['fInteresUsuario']}'
			   ";

		$values = "Planes.id='{$this->get_id()}'";

		$toauditory = "actualizacion de datos de PLANES ::: id  = {$this->get_id()}";
		//var_export("CALL usp_UpdateTable(\"Planes\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"44\",\"$toauditory\");");die();
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Planes\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"44\",\"$toauditory\");",true);
		
		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());
		
	}
	
	public function delete(){
		global $oMysql;
		
		$set = "Planes.sEstado='B'";

		$values = "Planes.id='{$this->get_id()}'";

		$toauditory = "baja de Planes ::: id  = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Planes\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"44\",\"$toauditory\");",true);
		
		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());
		
	}
	
	public function activar(){
		global $oMysql;
		
		$set = "Planes.sEstado='A'";

		$values = "Planes.id='{$this->get_id()}'";

		$toauditory = "Activacion de Planes ::: id  = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Planes\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"44\",\"$toauditory\");",true);
		
		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());
		
	}	
	
}
?>