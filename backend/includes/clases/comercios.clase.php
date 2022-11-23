<?
final class comercios {
	
	public $id = 0;
	public $datos = array();
	private $operations = 'new';
	private $codigo_error = 0;
	
	
	public function __construct( $idcomercio ){ $this->id = $idcomercio; }
	
	public function get_id(){ return $this->id ;}
		
	public function set_datos(){
		global $oMysql;	

		$this->datos = $oMysql->consultaSel("CALL usp_getFichaComercio(\" WHERE Comercios.id = '{$this->get_id()}'\");",true);

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

				if($datos['idRetencionGanancia'] == 0){
					$message .= 'El campo Retencion Ganancia es requerido.' . $break ;
				}
				
				if($datos['idCondicionDGR'] == 0){
					$message .= 'El campo Condicion D.G.R. es requerido.' . $break ;
				}
				
				if($datos['idCondicionAFIP'] == 0){
					$message .= 'El campo Condicion AFIP es requerido.' . $break ;
				}
				
				if($datos['idCondicionComercio'] == 0){
					$message .= 'El campo Condicion Comercio es requerido.' . $break ;
				}
				
				if($datos['idRetencionIVA'] == 0){
					$message .= 'El campo Retencion I.V.A. es requerido.' . $break ;
				}
				
				if($datos['idRubro'] == 0){
					$message .= 'El campo Rubro es requerido.' . $break ;
				}
		
				if($datos['idSubRubro'] == 0){
					$message .= 'El campo SubRubro es requerido.' . $break ;
				}
				
				/*if($datos['idTipoComercio'] == 0){
					$message .= 'El campo Tipo Comercio es requerido.' . $break ;
				}*/
				
				if($datos['idRetencionDGR'] == 0){
					$message .= 'El campo Retenciones D.G.R. es requerido.' . $break ;
				}
				
				if ($datos['sNombreFantasia'] == ""){
					$message .= 'El campo Nombre de Fantasia es requerido.' . $break ;
				}
		
				if ($datos['sRazonSocial'] == ""){
					$message .= 'El campo Razon Social es requerido.' . $break ;
				}
				
				/*if ($datos['sCUIT'] == ""){
					$message .= 'El campo CUIT es requerido.' . $break ;
				}else{

					$existeCuit = $oMysql->consultaSel("SELECT fcn_getExisteComercio(\"{$datos['sCUIT']}\");", true);

					if($existeCuit){
						$message .= 'El campo CUIT ya existe en nuestra base de datos ' . $break ;
					}else{
						$chekCuit = _cuitCheck_($datos['sCUIT']);
						
						if(!$chekCuit){
							$message .= 'El campo CUIT es invalido.' . $break ;
						}
					}

				}*/
				
				if ($datos['sFormaJuridica'] == ""){
					$message .= 'El campo Forma Juridica es requerido.' . $break ;
				}
				
				if ($datos['dFechaInicioActividad'] == ""){
					$message .= 'El campo Fecha Inicio Actividad es requerido.' . $break ;
				}
				
				if ($datos['sIngresoBrutoDGR'] == ""){
					$message .= 'El campo Ingresos Brutos D.G.R. es requerido.' . $break ;
				}
				
				if ($datos['sDomicilioComercial'] == ""){
					$message .= 'El campo Domicilio Comercial es requerido.' . $break ;
				}
				
				if ($datos['sDomicilioSolicitarComprobante'] == ""){
					$message .= 'El campo Domicilio Solicitar Comprobante es requerido.' . $break ;
				}
				
				if ($datos['sNombre'] == ""){
					$message .= 'El campo Nombre de Responsable es requerido.' . $break ;
				}
				
				if ($datos['sApellido'] == ""){
					$message .= 'El campo Apellido de Responsable es requerido.' . $break ;
				}
				
				if ($datos['sTelefono'] == ""){
					$message .= 'El campo Telefono de Responsable es requerido.' . $break ;
				}
				
				if ($datos['sMail'] == ""){
					$message .= 'El campo Email de Responsable es requerido.' . $break ;
				}
				
				if ($datos['sFax'] == ""){
					$message .= 'El campo Fax de Responsable es requerido.' . $break ;
				}
							
					

				break;
			case 'edit':
				if($datos['idRetencionGanancia'] == 0){
					$message .= 'El campo Retencion Ganancia es requerido.' . $break ;
				}
				
				if($datos['idCondicionDGR'] == 0){
					$message .= 'El campo Condicion D.G.R. es requerido.' . $break ;
				}
				
				if($datos['idCondicionAFIP'] == 0){
					$message .= 'El campo Condicion AFIP es requerido.' . $break ;
				}
				
				if($datos['idCondicionComercio'] == 0){
					$message .= 'El campo Condicion Comercio es requerido.' . $break ;
				}
				
				if($datos['idRetencionIVA'] == 0){
					$message .= 'El campo Retencion I.V.A. es requerido.' . $break ;
				}
				
				if($datos['idRubro'] == 0){
					$message .= 'El campo Rubro es requerido.' . $break ;
				}
		
				if($datos['idSubRubro'] == 0){
					$message .= 'El campo SubRubro es requerido.' . $break ;
				}
				
				/*if($datos['idTipoComercio'] == 0){
					$message .= 'El campo Tipo Comercio es requerido.' . $break ;
				}*/
				
				if($datos['idRetencionDGR'] == 0){
					$message .= 'El campo Retenciones D.G.R. es requerido.' . $break ;
				}
				
				if ($datos['sNombreFantasia'] == ""){
					$message .= 'El campo Nombre de Fantasia es requerido.' . $break ;
				}
		
				if ($datos['sRazonSocial'] == ""){
					$message .= 'El campo Razon Social es requerido.' . $break ;
				}
				
				/*if ($datos['sCUIT'] == ""){
					$message .= 'El campo CUIT es requerido.' . $break ;
				}else{

					$existeCuit = $oMysql->consultaSel("SELECT fcn_getExisteComercio(\"{$datos['sCUIT']}\");", true);
					$idcomercio = intval(_decode($datos['_i']));
					
					if($existeCuit != $idcomercio){
						$message .= 'El campo CUIT ya existe en nuestra base de datos ' . $break ;
					}else{
						$chekCuit = _cuitCheck_($datos['sCUIT']);
						
						if(!$chekCuit){
							$message .= 'El campo CUIT es invalido.' . $break ;
						}						
					}

				}*/
				
				if ($datos['sFormaJuridica'] == ""){
					$message .= 'El campo Forma Juridica es requerido.' . $break ;
				}
				
				if ($datos['dFechaInicioActividad'] == ""){
					$message .= 'El campo Fecha Inicio Actividad es requerido.' . $break ;
				}
				
				if ($datos['sIngresoBrutoDGR'] == ""){
					$message .= 'El campo Ingresos Brutos D.G.R. es requerido.' . $break ;
				}
				
				if ($datos['sDomicilioComercial'] == ""){
					$message .= 'El campo Domicilio Comercial es requerido.' . $break ;
				}
				
				if ($datos['sDomicilioSolicitarComprobante'] == ""){
					$message .= 'El campo Domicilio Solicitar Comprobante es requerido.' . $break ;
				}
				
				if ($datos['sNombre'] == ""){
					$message .= 'El campo Nombre de Responsable es requerido.' . $break ;
				}
				
				if ($datos['sApellido'] == ""){
					$message .= 'El campo Apellido de Responsable es requerido.' . $break ;
				}
				
				if ($datos['sTelefono'] == ""){
					$message .= 'El campo Telefono de Responsable es requerido.' . $break ;
				}
				
				if ($datos['sMail'] == ""){
					$message .= 'El campo Email de Responsable es requerido.' . $break ;
				}
				
				if ($datos['sFax'] == ""){
					$message .= 'El campo Fax de Responsable es requerido.' . $break ;
				}
				break;		
				
			case "payment_issue":
					
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
		
		$email = $datos['sMail'];
		
		$datos = _stringUpper_($datos);
		
		$datos['sMail'] = $email ;

		$datos = _parserCharacters_($datos);
		

		$idSolicitudComercio = 0;
		$estado = "A";
		$numeroRegion = "10";
		$numeroSucursal = "10";
		$numeroComercio = $oMysql->consultaSel("SELECT fcn_getNuevoNumeroComercio(\"$numeroRegion\",\"$numeroSucursal\");",true);
		$hoy = date("Y-m-d h:i:s");
		
		$datos['dFechaInicioActividad'] = dateToMySql($datos['dFechaInicioActividad']); 

		$set = "
				idSolicitudComercio,				
				idTipoCondicionDGR,
				idTipoCondicionAFIP,
				idCondicionComercio,				
				idSubRubro,				
				sNombreFantasia,
				sRazonSocial,
				sCUIT,
				sFormaJuridica,
				dFechaInicioActividad,
				sSector,
				sIngresoBrutoDGR,
				sEstado,
				sNumero,
				dFechaAlta,
				sDomicilioComercial,
				sDomicilioSolicitarComprobante,
				sNombre,
				sApellido,
				sTelefono,
				sMail,
				sFax,
				idRetencionGanancia,
				idRetencionIVA,
				idRetencionDGR,
				idBanco,
				sCBU,
				idFormaPago
				";

		$values = "
					'$idSolicitudComercio',					
					'{$datos['idCondicionDGR']}',
					'{$datos['idCondicionAFIP']}',
					'{$datos['idCondicionComercio']}',					
					'{$datos['idSubRubro']}',							
					'{$datos['sNombreFantasia']}',
					'{$datos['sRazonSocial']}',
					'{$datos['sCUIT']}',
					'{$datos['sFormaJuridica']}',
					'{$datos['dFechaInicioActividad']}',
					'{$datos['sSector']}',
					'{$datos['sIngresoBrutoDGR']}',
					'$estado',
					'$numeroComercio',
					'$hoy',
					'{$datos['sDomicilioComercial']}',
					'{$datos['sDomicilioSolicitarComprobante']}',
					'{$datos['sNombre']}',
					'{$datos['sApellido']}',
					'{$datos['sTelefono']}',
					'{$datos['sMail']}',
					'{$datos['sFax']}',
					'{$datos['idRetencionGanancia']}',
					'{$datos['idRetencionIVA']}',
					'{$datos['idRetencionDGR']}',
					'{$datos['idBanco']}',
					'{$datos['sCBU']}',
					'{$datos['idFormaPago']}'
					";
		
		   
		$toauditory = "insercion de COMERCIO ::: Razon Social: {$datos['sRazonSocial']}, CUIT: {$datos['sCUIT']}";
		//var_export("CALL usp_InsertTable(\"Comercios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"20\",\"$toauditory\");");die();
		$id = $oMysql->consultaSel("CALL usp_InsertTable(\"Comercios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"20\",\"$toauditory\");",true);
		
		$this->set_error_nro_query($oMysql->getErrorNo());

		$this->id = $id;
		
	}
	
	public function update($datos){
		global $oMysql;

		$email = $datos['sMail'];

		$datos = _stringUpper_($datos);

		$datos['sMail'] = $email ;

		$datos = _parserCharacters_($datos);
		
		$datos['dFechaInicioActividad'] = dateToMySql($datos['dFechaInicioActividad']); 
		
		$set = "
				idTipoCondicionDGR='{$datos['idCondicionDGR']}',
				idTipoCondicionAFIP='{$datos['idCondicionAFIP']}',
				idCondicionComercio='{$datos['idCondicionComercio']}',
				idSubRubro='{$datos['idSubRubro']}',				
				sNombreFantasia='{$datos['sNombreFantasia']}',
				sRazonSocial='{$datos['sRazonSocial']}',
				sCUIT='{$datos['sCUIT']}',
				sFormaJuridica='{$datos['sFormaJuridica']}',
				dFechaInicioActividad='{$datos['dFechaInicioActividad']}',
				sSector='{$datos['sSector']}',
				sIngresoBrutoDGR='{$datos['sIngresoBrutoDGR']}',
				sDomicilioComercial='{$datos['sDomicilioComercial']}',
				sDomicilioSolicitarComprobante='{$datos['sDomicilioSolicitarComprobante']}',
				sNombre='{$datos['sNombre']}',
				sApellido='{$datos['sApellido']}',
				sTelefono='{$datos['sTelefono']}',
				sMail='{$datos['sMail']}',
				sFax='{$datos['sFax']}',
				idRetencionGanancia='{$datos['idRetencionGanancia']}',
				idRetencionIVA='{$datos['idRetencionIVA']}',
				idRetencionDGR='{$datos['idRetencionDGR']}',
				idBanco='{$datos['idBanco']}',
				sCBU='{$datos['sCBU']}',
				idFormaPago='{$datos['idFormaPago']}'
			   ";

		$values = "Comercios.id='{$this->get_id()}'";

		$toauditory = "actualizacion de datos de COMERCIO ::: id  = {$this->get_id()}";

		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Comercios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"21\",\"$toauditory\");",true);
		
		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());
		
	}
	
	public function delete(){
		global $oMysql;
		
		$set = "Comercios.sEstado='B'";

		$values = "Comercios.id='{$this->get_id()}'";

		$toauditory = "baja de comercio ::: id  = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Comercios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"21\",\"$toauditory\");",true);
		
		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());
		
	}
	
	public function activar(){
		global $oMysql;
		
		$set = "Comercios.sEstado='A'";

		$values = "Comercios.id='{$this->get_id()}'";

		$toauditory = "Activacion de comercio ::: id  = {$this->get_id()}";

		$iduser = $_SESSION['id_user'];
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Comercios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"21\",\"$toauditory\");",true);
		
		#esta linea ver si es fucional
		$this->set_error_nro_query($oMysql->getErrorNo());
		
	}

	public function issuance_payment_values($datos){

		global $oMysql;

		$set = "
				idEmpleado,
				idBanco,
				iNumeroTransaccion,
				dFechaEntrega,
				dFechaDebito,
				dFechaEmision,
				dFechaPago,
				dFechaRegistro,
				fImporte,
				sObservaciones,
				iConciliado,
				sEmisor,
				sReceptor,
				sEstado,
				sCBUCuentaDestino,
				sCBUCuentaEmisora,
				idLiquidacion,
				iGlobalLiquidacion,
				idFormaPago
			   ";				

		
		$values = "
				'{$datos['idEmpleado']}',
				'{$datos['idBanco']}',
				'{$datos['iNumeroTransaccion']}',
				'{$datos['dFechaEntrega']}',
				'{$datos['dFechaDebito']}',
				'{$datos['dFechaEmision']}',
				'{$datos['dFechaPago']}',
				'{$datos['dFechaRegistro']}',
				'{$datos['fImporte']}',
				'{$datos['sObservaciones']}',
				'{$datos['iConciliado']}',
				'{$datos['sEmisor']}',
				'{$datos['sReceptor']}',
				'{$datos['sEstado']}',
				'{$datos['sCBUCuentaDestino']}',
				'{$datos['sCBUCuentaEmisora']}',
				'{$datos['idLiquidacion']}',
				'{$datos['iGlobalLiquidacion']}',
				'{$datos['idFormaPago']}'
				  ";
		
		$toauditory = "insert en TABLE TransaccionesLiquidacionesComercios ::: Emision de Comprobante de Pago, idLiquidacion : {$datos['idLiquidacion']}, GLOBAL : {$datos['iGlobalLiquidacion']} ";
		
		$id = $oMysql->consultaSel("CALL usp_InsertTable(\"TransaccionesLiquidacionesComercios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");",true);

		$this->set_error_nro_query($oMysql->getErrorNo());

		if($datos['iGlobalLiquidacion'] == 0){#toy liquidando detalles

			$set = "idTransaccion=$id";

			$values = "DetallesLiquidaciones.id='{$datos['idDetalleLiquidacion']}'";
	
			$toauditory = "actualizacion en detalle de Liquidacion, se emitio valor de pago de comercio::: idDetalleLiquidacion  = {$datos['idDetalleLiquidacion']}";
	
			$iduser = $_SESSION['id_user'];
			
			$i = $oMysql->consultaSel("CALL usp_UpdateTable(\"DetallesLiquidaciones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");",true);
			
		}else{
			
			$set = "Liquidaciones.idTransaccion=$id";
	
			$values = "Liquidaciones.id='{$datos['idLiquidacion']}'";
	
			$toauditory = "actualizacion de Liquidacion, se emitio valor de pago de comercio::: id  = {$datos['idLiquidacion']}";
	
			$iduser = $_SESSION['id_user'];
			
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Liquidaciones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");",true);						
		}
	
		
	}
	
}
?>