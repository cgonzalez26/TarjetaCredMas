<?
final class tiposplanes {
	
	public $id = 0;
	public $datos = array();
	private $operations = 'new';
	private $codigo_error = 0;
	
	
	public function __construct( $idcomercio ){ $this->id = $idcomercio; }
	
	public function get_id(){ return $this->id ;}
		
	public function set_datos(){
		global $oMysql;	

		$this->datos = $oMysql->consultaSel("CALL usp_getTiposPlanes(\" WHERE TiposPlanes.id = '{$this->get_id()}'\");",true);

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

				if($datos['sNombre'] == ''){
					$message .= 'El campo Nombre es requerido.' . $break ;
				}
				
				if($datos['iFinanciable'] == ''){
					$message .= 'El campo Financiable es requerido.' . $break ;
				}
				
				if($datos['iCompra'] == ''){
					$message .= 'El campo Compra es requerido.' . $break ;
				}
				
				if($datos['iCredito'] == ''){
					$message .= 'El campo Credito es requerido.' . $break ;
				}

				break;
			case 'edit':
				if($datos['sNombre'] == ''){
					$message .= 'El campo Nombre es requerido.' . $break ;
				}
				
				if($datos['iFinanciable'] == ''){
					$message .= 'El campo Financiable es requerido.' . $break ;
				}
				
				if($datos['iCompra'] == ''){
					$message .= 'El campo Compra es requerido.' . $break ;
				}
				
				if($datos['iCredito'] == ''){
					$message .= 'El campo Credito es requerido.' . $break ;
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

		$set = "
				idTipoMovimiento,
				sNombre,
				iAutorizable,
				iFinanciable,
				iCompra,
				iCredito,
				sEstado
				";

		$values = "
					'0',
					'{$datos['sNombre']}',
					'{$datos['sAutorizable']}',
					'{$datos['iFinanciable']}',
					'{$datos['iCompra']}',
					'{$datos['iCredito']}',
					'$estado'
					";
		
		   
		$toauditory = "insercion de TIPOS PLANES ::: Nombre: {$datos['sNombre']}";
		
		$id = $oMysql->consultaSel("CALL usp_InsertTable(\"TiposPlanes\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"39\",\"$toauditory\");",true);
		
		$this->set_error_nro_query($oMysql->getErrorNo());

		$this->id = $id;
		
	}
	
	public function update($datos){
		global $oMysql;



		$datos = _stringUpper_($datos);

		$datos = _parserCharacters_($datos);
		
		$set = "
				sNombre='{$datos['sNombre']}',
				iAutorizable='{$datos['sAutorizable']}',
				iFinanciable='{$datos['iFinanciable']}',
				iCompra='{$datos['iCompra']}',
				iCredito='{$datos['iCredito']}'
			   ";

		$values = "TiposPlanes.id='{$this->get_id()}'";

		$toauditory = "actualizacion de datos de TIPOS PLANES ::: id  = {$this->get_id()}";
		//var_export("CALL usp_UpdateTable(\"TiposPlanes\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"40\",\"$toauditory\");");die();
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"TiposPlanes\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"40\",\"$toauditory\");",true);
		
		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());
		
	}
	
	public function delete(){
		global $oMysql;
		
		$set = "TiposPlanes.sEstado='B'";

		$values = "TiposPlanes.id='{$this->get_id()}'";

		$toauditory = "baja de Tipos Planes ::: id  = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"TiposPlanes\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"40\",\"$toauditory\");",true);
		
		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());
		
	}
	
	public function activar(){
		global $oMysql;
		
		$set = "TiposPlanes.sEstado='A'";

		$values = "TiposPlanes.id='{$this->get_id()}'";

		$toauditory = "Activacion de Tipos Planes ::: id  = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"TiposPlanes\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"40\",\"$toauditory\");",true);
		
		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());
		
	}	
	
}
?>