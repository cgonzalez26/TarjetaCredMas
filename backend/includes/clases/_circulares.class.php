<?
final class _circulares {
	
	public $id = 0;
	public $datos = array();	
	private $operations = 'new';
	private $codigo_error = 0;
	
	
	public function __construct( $id ){ $this->id = $id; }
	
	public function get_id(){ return $this->id ;}
		
	public function set_datos(){
		global $oMysql;	

		//var_export("sp_getCirculares(\" WHERE Circulares.id = '{$this->get_id()}'\");");
		$this->datos = $oMysql->consultaSel("CALL usp_getCirculares(\" WHERE Circulares.id = '{$this->get_id()}'\");",true);		

	}
	
	public function get_datos(){

		if(sizeof($this->datos) == 0){ $this->set_datos(); }

		return $this->datos;

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
				
					$contactos = $datos['contactos'];
					
					if(sizeof($contactos) == 0){
						$message .= 'El campo "Para" es requerido.' . $break;
					}
						
					if($datos['sTitulo'] == ""){
						$message .= 'El campo Titulo es requerido.' . $break;
					}
					
					if($datos['sMembrete'] == ""){
						$message .= 'El campo Membrete es requerido.' . $break;
					}
					
					if($datos['sDescripcion'] == ""){
						$message .= 'El campo Descripcion es requerido.' . $break;
					}
					


				break;
			case 'edit':



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
		
		//htmlspecialchars		
		
		//$descripcion = htmlentities($datos['sDescripcion']);
		
		//$descripcion = $datos['sDescripcion'];
		
		$descripcion = $oMysql->escaparCadena($datos['sDescripcion']);
		
		$datos = _addslashes_($datos);
		
		//$descripcion = str_replace("/","\\/",$descripcion);
		
		$estado = 0;#aki es estado = NORMAL
		
		$idUser = $_SESSION['id_user'];
		
		//$datos['dFecha'] = dateToMySql($datos['dFecha']);
					
		$fecha_registro = date("Y-m-d h:i:s");
		
		$iPublico = 1;
		
		//$datos['sDescripcion'] =str_replace("\"","'",$datos['sDescripcion']);
		//var_export($datos['sDescripcion']);die();
		
		if(isset($datos['iPublico'])){
			$iPublico = 0;
		}


		$set = "
				idUsuario,
				dFechaRegistro,
				sTitulo,
				sMembrete,
				sDescripcion,
				iEstado,
				iPublico
				";

		$values = "
					'{$_SESSION['id_user']}',
					NOW(),
					'{$datos['sTitulo']}',
					'{$datos['sMembrete']}' ,
					'$descripcion',
					'0',
					'$iPublico'
					 ";

		$toauditory = "insercion de CIRCULARES ::: Titulo: {$datos['sTitulo']}";
		
		$SQLInsert = "INSERT INTO Circulares (idUsuario,dFechaRegistro,sTitulo,sMembrete,sDescripcion,iEstado,iPublico) VALUES ('{$_SESSION['id_user']}',NOW(),'{$datos['sTitulo']}','{$datos['sMembrete']}' ,'$descripcion','0','$iPublico')";		
		$oMysql->consultaAff($SQLInsert);
		$id = $oMysql->getLastID();		
		
		//$SQL = "CALL usp_InsertTable(\"Circulares\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");";
		//var_export($SQL);die();
		//$id = $oMysql->consultaSel( $SQL ,true);

		//var_export("id: " . $id ." ". $SQL);die();
		
		$this->set_error_nro_query($oMysql->getErrorNo());

		$this->id = $id;
		
		$this->insertCircularesUsers($datos['contactos']);
		
		
	}
	
	public function insertCircularesUsers($tipos_empleados_unidades_negocios){
		global $oMysql;
		
		if(!$tipos_empleados_unidades_negocios){
			$sub_query = " 1=-1";
		}else{
			
			if($tipos_empleados_unidades_negocios[0] == 'Todos'){
				unset($tipos_empleados_unidades_negocios[0]);
			}
			
			$sub_query = implode(",",$tipos_empleados_unidades_negocios);
		}
		
		$sub_query = " EmpleadosUnidadesNegocios.idTipoEmpleadoUnidadNegocio IN ($sub_query)";
		
		$SQL = "CALL usp_getEmpleadosPorTiposEmpleadosUnidadesNegocios(\"$sub_query\");";
		
		$empleados = $oMysql->consultaSel($SQL);
		
		if(!$empleados){
		
		}else{
			$values = "";
			
			foreach ($empleados as $idempleado) {
				$values .= "('{$this->id}','$idempleado','0',''),";
				//$SQLInsert = "INSERT INTO CircularesUsuarios (idCircular,idUsuario,iLeido,dFechaLeido) VALUES ('{$this->id}','$idempleado','0','')";		
				//$oMysql->consultaAff($SQLInsert);				
			}
			
			
			$values = substr($values,0,-1);
			
			$set = "(
					idCircular,
					idUsuario,
					iLeido,
					dFechaLeido
					)
					";
	
			$toauditory = "insercion de Empleados CIRCULARES ::: Circular : {$this->get_id()}";
	
			$SQL = "CALL usp_abm_General(\"CircularesUsuarios\",\"$set\",\"$values\",\"1\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");";
				
			$id = $oMysql->consultaSel( $SQL ,true);		
		}
		
	
		
	}

	
	public function update($datos){
		global $oMysql;

		//$datos = _stringUpper_($datos);

		$datos = _parserCharacters_($datos);
		
		//$datos['dFechaConsumo'] 		= dateToMySql($datos['dFechaConsumo']);
		
		
		$set = "

			   ";

		$values = "Circulares.id='{$this->get_id()}'";

		$toauditory = "actualizacion de datos de CIRCULARES ::: id  = {$this->get_id()}";

		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Circulares\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");",true);

		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());

	}
	
	public function delete(){
		global $oMysql;
		
		$set = "Circulares.iEstado=1";

		$values = "Circulares.id='{$this->get_id()}'";

		$toauditory = "baja de CIRCULARES ::: id  = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];
		//var_export("CALL usp_UpdateTable(\"Circulares\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");");die();
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Circulares\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");",true);

		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());
		
	}
	
	public function markREAD(){
		global $oMysql;

		$set = "CircularesUsuarios.iLeido=1,CircularesUsuarios.dFechaLeido=NOW()";

		$values = "CircularesUsuarios.idCircular='{$this->get_id()}' AND CircularesUsuarios.idUsuario='{$_SESSION['id_user']}'";

		$toauditory = "Lectura de CIRCULAR ::: id  = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];
		//var_export("CALL usp_UpdateTable(\"CircularesUsuarios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");");die();
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"CircularesUsuarios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");",true);

		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());

	}
	
	public function changePulic($publico){
		global $oMysql;
		
		$set = "Circulares.iPublico=$publico";

		$values = "Circulares.id='{$this->get_id()}'";

		$toauditory = "Cambio estado publico de CIRCULARES ::: id  = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];

		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Circulares\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");",true);

		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());
		
	}

}
?>