<?php //------------------------------------------------------------------

// -----------------------------------------------------------------------
// Clase Gen�rica, Abstracta para conexi�n al Servidor MySQL
// -----------------------------------------------------------------------

//$GLOBALS['MYSQL_CONEXION_ID'] = false;


class mysql2 {
	
	
	private $error = '';
	private $sConsultaError = '';
	private $iErrorNo = 0;
	//----------------------------------------------------------------------------
	private  $defaultServerName = 'localhost';
	private  $defaultServerPort = 3306;
	private  $defaultServerLoginUser = 'Desarrollo';
	private  $defaultServerLoginPass = 'd3sarr0ll0';
	private  $defaultDBName = 'TarjetaCredMas';
	private  $defaultDBCharset = 'latin1';
	private  $conectionResArray = array();

	//------------------------------
	private $conectionResKey = '';
	private $iFilasAfectadas = 0;
	private $iCantidadColumnas = 0;
	private $iLastID = 0;
	//------------------------------
	private $serverName = null;
	private $serverPort = null;
	private $serverLoginUser = null;
	private $serverLoginPass = null;
	private $dbName;
	private $dbCharset;
	//---------------------------------------------------------------------------------------
	
	
	private function _updateConectionResKey() {
		
		$keys = array(
			$this->serverName,
			$this->serverPort,
			$this->serverLoginUser,
			$this->serverLoginPass,
			$this->dbName,
			$this->dbCharset);
			
		$this->conectionResKey = implode(',', $keys);
		
		
	}
	
	public function setServer( $name = null, $login = null, $pass = null, $port = null ) {
		
		
		$this->serverName = $name;
		$this->serverPort = ((integer) $port > 0 ) ? (integer) $port : 3306;
		$this->serverLoginUser = $login;
		$this->serverLoginPass = $pass;
			
		$this->_updateConectionResKey();
			
	}
	
	public function setDBName( $db ) { $this->dbName = $db;  $this->_updateConectionResKey(); }
	
	public function setDBCharset( $charset ) { 
		
		if( !is_string($charset) || strlen($charset) == 0 ) $charset = 'latin1';
		$this->dbCharset = $charset; 
		
		$this->_updateConectionResKey();
	}
	
	private function _ping() {
		
		
		@ $pingSuccess = mysqli_ping($this->conectionResArray[$this->conectionResKey] );
	
		if(!$pingSuccess) {
			
			$this->conectionResArray[$this->conectionResKey] = mysqli_connect( $this->serverName, $this->serverLoginUser, $this->serverLoginPass, $this->dbName, $this->serverPort );
			
		}
		
		
		
	}
	public function getErrorNo() { return $this->iErrorNo; }
	public function __construct() {
		
		
		
		$this->setServer( $this->defaultServerName,$this->defaultServerLoginUser, $this->defaultServerLoginPass, $this->defaultServerPort );
		$this->setDBName( $this->defaultDBName );
		
		if($this->defaultDBCharset)
		$this->setDBCharset($this->defaultDBCharset );
		
		$this->_ping();
	}
	
	
	
	
	//---------------------------------------------------------------------------------------
	
	
	

//	final protected function conectar() {
		
	//	extract( include( dirname(__FILE__) . '/../../../MySQL.inc.php' ) );
				
		//$GLOBALS['MYSQL_CONEXION_ID'] = mysqli_connect( $host, $user, $pass, $bd );
		
		//If( !$GLOBALS['MYSQL_CONEXION_ID'] ) { 
			
			//$this->error = 'No se pudo conectar al host MySQL - ';
		//	$this->error.= mysqli_error( $GLOBALS['MYSQL_CONEXION_ID'] );
		//	return false;
			
		//} Else return true;
//	}
	
	
	// M�todo para enviar una consulta gen�rica al servidor
	// Opcionalmente, podemos indicar que no esperamos resultados,
	// de esta forma la consulta se efect�a mucho m�s rapido
	
	final protected function consultaGenerica( $consultaSQL ) {
		
		// Si no estamos conectados, entonces llamamos al m�todo 'conectar',//_ping
		// sino, hacemos un ping con el servidor
		
		
		$this->_ping();
		//If( $GLOBALS['MYSQL_CONEXION_ID'] === false ) $this->conectar();
		//Else mysqli_ping( $GLOBALS['MYSQL_CONEXION_ID'] );
				
			
		// Obtenemos el identificador de resultado al realizar la consulta
		// Luego, si ocurri� un error, obtenemos el mensaje de error y
		// salimos. En caso de �xito, devolvemos el identificador
		// de resultado (que ser� usado en otros m�todos seg�n el tipo
		// de consulta
		$res_id =mysqli_query( $this->conectionResArray[$this->conectionResKey], $consultaSQL );
		
		
		//$res_id = mysqli_query( $GLOBALS['MYSQL_CONEXION_ID'], $consultaSQL );
		If( mysqli_errno( $this->conectionResArray[$this->conectionResKey] ) > 0 ) {
			
			If( in_array( mysqli_errno( $this->conectionResArray[$this->conectionResKey] ), array( 2006, 2014 ), true ) ) {
								
				$this->_ping();//$this->conectar();
				return $this->consultaGenerica( $consultaSQL );
			}
			
			$this->error = mysqli_error( $this->conectionResArray[$this->conectionResKey] );
			$this->sConsultaError = $consultaSQL;
			$this->iErrorNo = mysqli_errno( $this->conectionResArray[$this->conectionResKey] );
			
			//echo $this->error;
			
			return false;
		}
		
		return $res_id;
	}
	
	
	
	
	
	final public function getError() {
		
		return "<pre>
		ERROR:
		{$this->error}
		
		ERROR_NO: {$this->iErrorNo}
		
		CONSULTA:
		{$this->sConsultaError}</pre>";
	}
	
	// M�todo para realizar una consulta SELECT, DESCRIBE o SHOW.
	// Los par�metros son usados para especificar c�mo ser�n devueltos
	// los resultados. Si es �nico el resultado, entonces
	// s�lo se devuelve una fila �nica, caso contrario
	// se devuelve un array de filas (array de arrays). Si es necesario
	// que las claves de los arrays sean un campo en particular, 
	// y si se parsean los resutados (por ejemplo, convertir
	// un campo con nombre 'clave1[clave2]' en un subarray
	
	public function getNumeroError(){
		return $this->iErrorNo;
	}
	
	
	
	public function consultaSel( 
										$consultaSQL, 
										$unico = false, 
										$clave = false, 
										$parse_filas = true ) {
		
											
		// Obtenemos el identificador de consulta, mediante el 
		// m�todo anterior									
											
		$res_id = $this->consultaGenerica( $consultaSQL );
		
		
		// Si la operaci�n no fue exitosa, o no existen resultados,
		// si se esperaba un �nico resultado, devolvemos false, 
		// sino un array vac�o
		
		If( $res_id === false or mysqli_num_rows( $res_id ) == 0 ) 
		return ( $unico ) ? false : array();
		
		
		// Obtenemos la cantidad de columnas
		
		$cantidad_columnas = mysqli_num_fields( $res_id );
		
		
		// Si se espera un �nico resultado, obtenemos s�lo la primer
		// fila, y de acuerdo al par�metro 'parse_filas', parseamos
		// la fila obtenida. Si No se especific� una clave para 
		// la fila, de acuerdo si existen varias columnas
		// devolvemos el resultado
		
		If( $unico ) {
			
			$fila = mysqli_fetch_array( $res_id, MYSQL_ASSOC );
			
			If( $parse_filas ) 
			parse_str( http_build_query( $fila ), $fila );		
			
			If( $clave === false) 							
			return ( $cantidad_columnas == 1 )? (array_shift($fila)) : $fila;		
			
			Else
			return $fila[ $clave ];
		}
			
		
		// Creamos un array vac�o para ir ingresando en �l las filas
		// que se obtuvieron
		
		$filas = array();
		
		
		// Vamos obteniendo las filas del identificador de resultado
		
		While( $fila = mysqli_fetch_array( $res_id, MYSQL_ASSOC ) ) {
			
			
			// Parseamos las filas
						
			If( $parse_filas ) 
			parse_str( http_build_query( $fila ), $fila );		
						
			
			
			// Teniendo en cuenta si es una s�la columna o m�s, devolvemos
			// un valor escalar o un array, respectivamente.
			// Si no se especific� una clave, entonces agregamos directamente
			// la fila en el array de filas, sin especificar un �ndice.
					
			If( $clave === false) 
			$filas[] = ( ( $cantidad_columnas == 1 )? 
			( array_shift( $fila ) ) : $fila );
			
			
			// Caso contrario, obtenemos el valor de la clave en la fila
			// actual, y con esa clave, ingresamos en el array de filas
			// el valor obtenido
			
			Else  { 
								
				$clave_fila = $fila[ $clave ];
					
				unset( $fila[ $clave ] );
					
				$filas[ $clave_fila ] = ( ( count( $fila ) == 1 )? 
										( array_shift( $fila ) ) : $fila);
			}
			
		}
			
		
		mysqli_free_result( $res_id );
		
		
		// Devolvemos las filas
			
		return $filas;	
	}
		
	
	
	#metodos agregados por renelo ��!, don't touch me
	
	#metodo k devuelve el identificador de la consulta
	public function _query( $SQL = '' ) {											

		$rs = $this->consultaGenerica( $SQL );

		return $rs;
	}	
		
	public function getNumRows($result){
		return mysqli_num_rows( $result );
	}
	
	/*public function getMySQL_ASSOC($result){
		return mysqli_fetch_assoc($result);
	}*/	
	
	public function memoryFREE($result){
		mysqli_free_result( $result );
	}
		
	
	
	
	
	
	// M�todo para realizar consultas UPDATE, DELETE, etc., donde se espera
	// como resultado un n�mero de filas afectadas
	
	public function consultaAff( $consultaSQL ) {
		
		// Realizamos la consulta sin esperar ning�n valor
		
		If( false !== $this->consultaGenerica( $consultaSQL, false ) ) {
			
			// En caso de �xito, devolvemos las filas afectadas
			
			$afectados = mysqli_affected_rows( $this->conectionResArray[$this->conectionResKey] );

			return $afectados;
			
		}
		
		return false;
	}


	
	// M�todo an�logo al anterior, pero cuando se desea saber
	// si una fila (generalmente �nica) fue afectada o no
	
	public function consultaBool( $consultaSQL ) {
				
		// Devolvemos el valor devuelto por el m�todo anterior,
		// pero en tipo binario
		
		return (boolean) $this->consultaAff( $consultaSQL );
	}
		
	
	// M�todo para desconectarse de Servidor y Base de datos
	
	
	
	public function desconectar() {
		
		@ mysqli_close( $this->conectionResArray[$this->conectionResKey] );
		
		$this->conectionResArray[$this->conectionResKey] = false;
	}
	
		
	
	
	// M�todo destructivo de la clase
	
	final public function __destruct() {
		
		$this->conectionResArray[$this->conectionResKey] = false;	
	}

	
	
	// M�todo para comprobar la existencia de una fila en alguna tabla
	// Para tal fin, se pasan como par�metros el nombre de la tabla,
	// el campo y el valor a comprobar
	
	public function comprobarExistencia( $tabla, $campo, $valor, $condiciones_extra = '' ) {
		
		$consultaSQL = "SELECT $campo FROM $tabla WHERE $campo = '$valor'";
		If( $condiciones_extra ) $consultaSQL.= " AND $condiciones_extra";
		
		return (boolean) count( $this->consultaSel( $consultaSQL ) );
	}
			
	
	// M�todo para escapar cadenas, para que sea seguro insertarlas
	// en tablas MySQL. El par�metro cadenas es pasado por valor, 
	// y puede ser un valor escalar o un array.
	
	public function escaparCadena( &$cadenas ) {
		
		
		// Si es un array, iteramos recursivamente
		// llam�ndo nuevamente a la misma funci�n
		// para escapar cada valor escalar
		
		If( is_array( $cadenas ) )
		
			Foreach( $cadenas as $clave => $cadena ) 
			
				$cadenas[ $clave ] = $this->escaparCadena( $cadena );
									 	
					
		// Caso contrario, escapamos la cadena		
				
		Else $cadenas = htmlspecialchars( mysql_escape_string( $cadenas ) ); 
		
		return $cadenas;
	
	}

	public function escapeString( $cadenas, $htmlEntitiesEscape = true ) {
				
		If( is_array( $cadenas ) )
		
			Foreach( $cadenas as $clave => $cadena ) 
			
				$cadenas[ $clave ] = $this->escapeString( $cadena, $htmlEntitiesEscape );
									 	
					
		Else {
			
			if($htmlEntitiesEscape) {
				
				$cadenas = str_replace( '>', '&gt;', $cadenas );
				$cadenas = str_replace( '<', '&lt;', $cadenas );
				$cadenas = str_replace( '"', '&quot;', $cadenas );
				
				$cadenas = htmlspecialchars( $cadenas, HTML_ENTITIES );
			}
			
			$cadenas = mysql_escape_string( $cadenas ); 
		}
	
		return $cadenas;
	}
	
	public function getListaOpciones( $sTabla, $sClave, $sTexto, $mSel = '', $sCondiciones = '', $bOptionInicial = true, $sOrden = '' ) {
	
		$sConsulta = "SELECT $sClave AS CLAVE, $sTexto AS TEXTO FROM $sTabla";
		If( $sCondiciones ) $sConsulta.= " WHERE $sCondiciones";
		
		
		
		If( !$sOrden ) $sConsulta.= " ORDER BY $sTexto";
		Else $sConsulta.= " ORDER BY $sOrden";
	
		
		$aFilas = $this->consultaSel( $sConsulta, false, 'CLAVE' );
		$sOpciones = array_2_options( $aFilas, $mSel );

		If( $bOptionInicial ) 
		$sOpciones = "<option value='0'> " . ((is_string( $bOptionInicial ))?$bOptionInicial:'Seleccionar...') . " </option> <option value='0'></option>" . $sOpciones;
			
		
		return $sOpciones;	
		
	}

	
	
	public function getListaOpcionesCondicionado( $sIdPadre, $sIdHijo, $sTabla, $sClave, $sTexto, $sClaveForanea, $sCondiciones = '', $bOptionInicial = true, $mSel = 0 ) {
		
		$sCadena = $this->getListaOpcionesCondicionadoMultiple( array($sIdPadre => $sClaveForanea), $sIdHijo, $sTabla, $sClave, $sTexto, $sCondiciones, $bOptionInicial );
		
		If( $mSel ) $sCadena.= "<script type='text/javascript'> document.getElementById('$sIdHijo').value = '$mSel'; </script>";
		return $sCadena;
	}
	
	
	// El Par�metro $aIDsPadre debe ser un array de la forma ID_ELEMENTO_SELECT => CLAVE_SQL que representa
	
	
	public function getListaOpcionesCondicionadoMultiple( $aIDsPadre, $sIdHijo, $sTabla, $sClave, $sTexto, $sCondiciones = '', $bOptionInicial = true, $bDesactivar = false ) {  
		
		If( !is_array( $aIDsPadre ) ) $aIDsPadre = array( $aIDsPadre => $aIDsPadre );
		
		//----------------------------------------------------------------------------------------
		$sNombreVar = implode( '_', array_keys( $aIDsPadre ) ) . "_{$sIdHijo}_CondicionadoMultiple";
		//-------------------------------------------------------------------------------------------
		
		$sConsulta = "SELECT CONCAT_WS(','," . implode( ', ', $aIDsPadre ) . ") AS FORANEA, $sClave AS CLAVE, $sTexto AS TEXTO FROM $sTabla";
		If( $sCondiciones ) $sConsulta.= " WHERE $sCondiciones";
		$sConsulta.= " ORDER BY TEXTO";
		
		$aFilas = $this->consultaSel( $sConsulta );
		
		$aClavesForaneas = array();
		
		Foreach( $aFilas AS $aFila )
		$aClavesForaneas[ $aFila['FORANEA'] ][] = $aFila;
		
		$sCadena = "var {$sNombreVar} = new Array();\n";
		
		Foreach( $aClavesForaneas AS $sClaveForanea => $aFilas  ) {
		
			$aOptions = array();
			
			$aFila['TEXTO'] = str_replace( '"', "'", $aFila['TEXTO'] );
			
			Foreach( $aFilas AS $aFila ){
				
			
			$aOptions[] = "new Option(\"{$aFila['TEXTO']}\", \"{$aFila['CLAVE']}\")";
			}
					
			$sCadena.= "{$sNombreVar}['$sClaveForanea'] = new Array(\n" . implode( ",\n", $aOptions ) . ");\n";
		
		}	
			
		ob_start();
		
		$sTextoVacio = 'Seleccionar...';
		$sTextoDesactivado = 'Seleccionar...';
		$bOcultarPadre = false;
		$bOptionInicial = 'Seleccionar...';
		
		
		
		//------------------------------------------------------------------- ?>
		
			<script type='text/javascript'>
			
			<?php echo $sCadena; ?>		
						
			<?php echo array_2_javascript_array( array_keys( $aIDsPadre ), "{$sNombreVar}_IDS_PADRES" ); ?>
			
			selectOpcionesCondicionado( <?php echo "{$sNombreVar}_IDS_PADRES, '$sIdHijo', $sNombreVar, '$sTextoVacio', '$bOptionInicial', '$sTextoDesactivado', ". ( (integer) $bOcultarPadre ) . ", " .  ( (integer) $bDesactivar ) ; ?>);
				
			</script>
			
		<?php //------------------------------------------------------------------------
		
		
		return ob_get_clean();
	}
	
	
	
	public function getLastID() { return mysqli_insert_id( $this->conectionResArray[$this->conectionResKey] ); }
	
	
	
	public function consultaMultiple( $consultaSQL ) {
		
		// Si no estamos conectados, entonces llamamos al m�todo 'conectar',
		// sino, hacemos un ping con el servidor
		
		If( $this->conectionResArray[$this->conectionResKey] === false ) $this->_ping();//$this->conectar();
		Else mysqli_ping( $this->conectionResArray[$this->conectionResKey] );
				
			
		// Obtenemos el identificador de resultado al realizar la consulta
		// Luego, si ocurri� un error, obtenemos el mensaje de error y
		// salimos. En caso de �xito, devolvemos el identificador
		// de resultado (que ser� usado en otros m�todos seg�n el tipo
		// de consulta
		
		$res = mysqli_multi_query( $this->conectionResArray[$this->conectionResKey], $consultaSQL );
			
		
		If( mysqli_errno( $this->conectionResArray[$this->conectionResKey] ) > 0 ) {
			
			If(  in_array( mysqli_errno( $this->conectionResArray[$this->conectionResKey] ), array( 2006, 2014 ), true ) ) {
				
				$this->_ping();//$this->conectar();
				return $this->consultaMultiple( $consultaSQL );
			}
			
			$this->error = mysqli_error( $this->conectionResArray[$this->conectionResKey] );
			$this->sConsultaError = $consultaSQL;
			return false;
		}
		
		return $res;
		
	}
	
	public function getListaCheckBoxs( $sTabla, $sClave, $sTexto, $sNombreGrupo, $sCondiciones = '', $mSeleccionados = '',$sCabecera=false ) {
	
	
		$sConsulta = "SELECT $sClave AS CLAVE, $sTexto AS TEXTO FROM $sTabla";

		If( $sCondiciones ) $sConsulta.= " WHERE $sCondiciones";
		$sConsulta.= " ORDER BY $sTexto";
	
		$aFilas = $this->consultaSel( $sConsulta, false, 'CLAVE' );
	
		$i = 1;
		
		
		If( !is_array($mSeleccionados) ) $mSeleccionados = explode( ',', $mSeleccionados );
		
		if($sCabecera) $sOpciones="<div  class='intercalado'>$sCabecera</div>";
	    
		
		Foreach( $aFilas as $sClave => $sTexto ) {
		
			$sOpciones.= 
		
				"<div" . ( ( $i % 2 == 0 ) ? " class='intercalado'" : '' ) . 
				"><input type='checkbox' name='{$sNombreGrupo}[$sClave]'".
				((in_array( $sClave, $mSeleccionados ))?" checked='checked'":'') ."/> $sTexto </div>";
			
				$i++;
		}
					
	
			
		return $sOpciones;	
	}

	
	public function consultaInsertar( $aDatos, $sTabla ) {
		
		$this->escaparCadena( $aDatos );
		
		$sConsulta = "INSERT INTO $sTabla (" . implode( ',', array_keys( $aDatos ) ) . ") VALUES ('" . implode( "','", $aDatos ) . "')";
		return $this->consultaBool( $sConsulta );
	}
	
	
	public function consultaSelRegistro( $sTabla, $sClave, $sValor ) {
		
		$sConsulta = "SELECT * FROM $sTabla WHERE $sClave = '$sValor'";
		
		return $this->consultaSel( $sConsulta, true );
	}
	
	
	public function consultaUpdate( $aDatos, $sTabla, $sCondicion ) {
		
		
				
		$this->escaparCadena( $aDatos );
		
		Foreach( $aDatos AS $sColumna => $sValor ) $aDatosUpdate[] = "$sColumna = '$sValor'";
		
		$sConsulta = "UPDATE $sTabla SET " . implode( ',', $aDatosUpdate ) . " WHERE $sCondicion";
		
		return $this->consultaBool( $sConsulta );
	}
	
	
	public function getSelectMultiple( $sTabla, $sClave, $sTexto, $sNombre, $sCondiciones = '', $mSeleccionados = '' ) {
		
		$sConsulta = "SELECT $sClave AS CLAVE, $sTexto AS TEXTO FROM $sTabla";

		If( $sCondiciones ) $sConsulta.= " WHERE $sCondiciones";
		$sConsulta.= " ORDER BY $sTexto";
	
		$aFilas = $this->consultaSel( $sConsulta, false, 'CLAVE' );
	
		If( !is_array( $mSeleccionados ) ) $mSeleccionados = array();
			
		$sCadena = "<div class='selectMultiple'>";
		
		Foreach( $aFilas as $sClave => $sValor ) { //------------------- 
			
			$bSeleccionado = in_array( $sClave, $mSeleccionados );
			$sCadena.= "<a onclick='selectMultple(this)' ".( ($bSeleccionado)? "class='seleccionado'" : '' ) . "> $sValor </a><input type='hidden' name='{$sNombre}[]' value='$sClave' ".( (!$bSeleccionado) ? "disabled='disabled'" : '' ) ." />";
		}
		
		$sCadena.= "</div>";
		
		return $sCadena;
	}
	
	
	public function getListaOpcionesCondicionadosDesactivados( $sIDPadre, $sClaveForanea, $sIDHijo, $sTabla, $sClave, $sTexto, $sCondiciones = '' ) {
		
		$sConsulta = "SELECT $sClave AS CLAVE, $sTexto AS TEXTO FROM $sTabla";

		If( $sCondiciones ) $sConsulta.= " WHERE $sCondiciones";
		$sConsulta.= " ORDER BY $sTexto";
		
		$aOpciones = $this->consultaSel( $sConsulta, false, 'CLAVE' );
		
		$sConsulta = "SELECT $sClaveForanea AS FORANEA, GROUP_CONCAT( DISTINCT $sClave SEPARATOR ',' ) AS VALOR FROM $sTabla "; 
		If( $sCondiciones ) $sConsulta.= " WHERE $sCondiciones";
		$sConsulta.= " GROUP BY FORANEA";

		$aForaneas = $this->consultaSel( $sConsulta, false, 'FORANEA' );
		
		$sNombreVar = $sIDPadre;
				
		ob_start();
		
		
		//------------------------------------------------------------------- ?>
		
			<script type='text/javascript'><!--
			
			<?php echo array_2_javascript_array( $aOpciones, "{$sIDPadre}_OPTIONS" ); ?>		
			<?php echo array_2_javascript_array( array_keys( $aOpciones ), "{$sIDPadre}_CLAVES", true  ); ?>
			<?php echo array_2_javascript_array( $aForaneas, "{$sIDPadre}_FORANEAS" ); ?>		
						
			selectOpcionesCondicionadoDesactivados( <?php echo "{$sIDPadre}_OPTIONS, {$sIDPadre}_CLAVES, {$sIDPadre}_FORANEAS, '$sIDHijo', '$sIDPadre'" ; ?>);
				
			//--></script>
			
		<?php //------------------------------------------------------------------------
		
		return ob_get_clean();
		
	}
	
			

	public function operacionABM($aDatos) { 

	   extract($aDatos);
	   $aParametros=array($TABLA,
		               	  $CAMPOS,
		                  $VALORES,
		                  $OPERACION,
		                  $ID_USER,
		                  $ID_TIPOAUDIT,
		                  $DETALLE);
		                   
	   $sConsulta="call usp_abm_General(\"".implode( "\",\"", $aParametros ) ."\");";  
	   $result=$this->consultaSel($sConsulta);	
	   return $result;
	}
	//------------------------------------------------------------------
	
	
	public function startTransaction() { $this->consultaBool( "START TRANSACTION" ); }
	
	
	public function commit() { $this->consultaBool("COMMIT"); }

	public function addAuditoria($idUser,$idTipo,$sDetalle){
		
		$sConsulta="call usp_insertarAuditoria({$idUser},$idTipo,\"$sDetalle\");";
		$this->consultaSel($sConsulta);
	}
	public function getListaGrilla($objGrilla,$index,$sTabla, $sClave, $sTexto, $mSel = '', $sCondiciones = '', $bOptionInicial = true, $sOrden = '' ) {
		$sConsulta = "SELECT $sClave AS CLAVE, $sTexto AS TEXTO FROM $sTabla";
		If( $sCondiciones ) $sConsulta.= " WHERE $sCondiciones";		
		
		If( !$sOrden ) $sConsulta.= " ORDER BY $sTexto";
		Else $sConsulta.= " ORDER BY $sOrden";	
		
		$aFilas = $this->consultaSel( $sConsulta, false, 'CLAVE' );
		//var_export($aFilas);die();
	   $sOpciones="$objGrilla.getCombo($index).put('0','seleccionar..');";
	   foreach($aFilas AS $key=>$fila)
       $sOpciones.="$objGrilla.getCombo($index).put('{$key}','{$fila}');";
		/*$sOpciones = array_2_options( $aFilas, $mSel );

		If( $bOptionInicial ) 
		$sOpciones = "<option value='0'> " . ((is_string( $bOptionInicial ))?$bOptionInicial:'Seleccionar...') . " </option> <option value='0'></option>" . $sOpciones;
			*/
		return $sOpciones;	
	}
	
	
	public function selectMyGrid($nameGrid = 'mygrid',$index,$sTabla, $sClave, $sTexto, $mSel = '', $sCondiciones = '', $bOptionInicial = true, $sOrden = '' ) {
	
		$sConsulta = "SELECT $sClave AS CLAVE, $sTexto AS TEXTO FROM $sTabla";
		If( $sCondiciones ) $sConsulta.= " WHERE $sCondiciones";
		
		
		if( !$sOrden ) $sConsulta.= " ORDER BY $sTexto";
		else $sConsulta.= " ORDER BY $sOrden";	
		
		$aFilas = $this->consultaSel( $sConsulta, false, 'CLAVE' );

	   $sOpciones="$nameGrid.getCombo($index).put('0','seleccionar..');";
	   foreach($aFilas as $key=>$fila) $sOpciones.="$nameGrid.getCombo($index).put('{$key}','{$fila}');";
		
		return $sOpciones;	
		
	}
	
	public function selectMyGridArray($nameGrid = 'mygrid',$aFilas,$index,$mSel = '') {
		
	   $sOpciones="$nameGrid.getCombo($index).put('0','seleccionar..');";
	   foreach($aFilas as $key=>$fila) $sOpciones.="$nameGrid.getCombo($index).put('{$key}','{$fila}');";
	   return $sOpciones;	
	   
	}
	
	public function doABM($TABLA,$CAMPOS,$VALORES,$OPERACION,$ID_USER,$ID_TIPOAUDIT,$DETALLE) { 
		
	   $sConsulta="call usp_abm_General(\"$TABLA\",\"$CAMPOS\",\"$VALORES\",\"$OPERACION\",\"$ID_USER\",\"$ID_TIPOAUDIT\",\"$DETALLE\");";  
	   $result=$this->consultaSel($sConsulta,true);	
	   return $result;
	}
}



//---------------------------------------------------------------------- ?>