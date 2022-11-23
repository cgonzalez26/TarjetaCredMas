<?php //------------------------------------------------------------------

/*@ include_once( dirname(__FILE__) . './TemplateParser.class.php' );*/
@ include_once( dirname(__FILE__) . '/./../functions/arrays.php' );
@ include_once( dirname(__FILE__) . '/./../functions/strings.php' );



define('MYSQL_NULL_VALUE', uniqid( 'MYSQL_NULL_VALUE' ));


final class MySQL {
	
	
	//----------------------------------------------------


	private static $defaultServerName = 'localhost';
	private static $defaultServerPort = 3306;
	private static $defaultServerLoginUser = 'Desarrollo';
	private static $defaultServerLoginPass = 'd3sarr0ll0';
	private static $defaultDBName = 'systemglobal_java';
	/*private static $defaultServerName = '192.168.2.8';
	private static $defaultServerPort = 3306;
	private static $defaultServerLoginUser = 'griva';
	private static $defaultServerLoginPass = 'grivasi';
	private static $defaultDBName ='grivasoluciones';*/
	
	
	private static $defaultDBCharset = 'latin1';
	
	private static $conectionResArray = array();
		
	private static $templatesDir = '.';
	private static $templatesExtension = 'sql';
		
	private static $debugMode = true;
	
	
	
	
	public static function setTemplatesDir( $templatesDir ) { self::$templatesDir = $templatesDir; }
	
	public static function setTemplatesExtension( $extension ) { self::$templatesExtension = $extension; }
		
	
	
	protected static function __setArrayKey( $rows, $key ) {
		
		$newRows = array();

		foreach( $rows as $row ) {
				
			$keyData = $row[ $key ];
			unset( $row[ $key ] );

			$newRows[ $keyData ] = count( $row ) > 1 ? $row : array_shift($row);
				
		}
			
		return $newRows;
	}
	
	
	
	protected static function __controlColumnsValues( $values,  $avoidControlColumns = null ) {
		
		$newValues = array();
		
		if($avoidControlColumns && !is_array($avoidControlColumns)) $avoidControlColumns = array($avoidControlColumns);
		else if( !is_array($avoidControlColumns) ) $avoidControlColumns = array();
		
		foreach($values as $key => $value) 
			
			if(in_array( $key, $avoidControlColumns )) $newValues[ $key ] = $value;
			else $newValues[ $key ] = $value == MYSQL_NULL_VALUE ? 'NULL' : "'$value'";
			
		return $newValues;
	}
	
	
	
	
	public static function convertArrayToSet( $array, $avoidControlColumns = null ) {
		
		if(!$array) return "''";
		
		$array = self::__controlColumnsValues( $array, $avoidControlColumns );
		return implode(',', $array);
	}
	
	
	public static function getConditionsDatesIntervalMatch( $date11, $date12, $date21, $date22 ) {
		
		
		$date11 = "TIMESTAMP($date11)";
		$date12 = "TIMESTAMP($date12)";
		$date21 = "TIMESTAMP($date21)";
		$date22 = "TIMESTAMP($date22)";
		
		return "(( $date11 BETWEEN $date21 AND $date22 ) OR ( $date12 BETWEEN $date21 AND $date22 ) OR ( $date21 BETWEEN $date11 AND $date12 ) OR ( $date22 BETWEEN $date11 AND $date12 ))";
	}
	
	//------------------------------
		
	private $conectionResKey = '';
		
	private $sError = '';
	private $sErrorConsulta = '';
	private $sErrorNo = 0;
	
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
	
	
	public function __construct() {
		
		
		
		$this->setServer( self::$defaultServerName, self::$defaultServerLoginUser, self::$defaultServerLoginPass, self::$defaultServerPort );
		$this->setDBName( self::$defaultDBName );
		
		if(self::$defaultDBCharset)
		$this->setDBCharset( self::$defaultDBCharset );
		
				
		$this->_ping();
	}
	
	
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
	
	//---------------------------------------------------------------------------------------
	
	
	public function setServer( $name = null, $login = null, $pass = null, $port = null ) {
		
		
		$this->serverName = $name;
		$this->serverPort = ((integer) $port > 0 ) ? (integer) $port : 3306;
		$this->serverLoginUser = $login;
		$this->serverLoginPass = $pass;
			
		$this->_updateConectionResKey();
			
	}
	
	
	public function setServerLogin( $login = null, $pass = null ) { $this->setServer( $this->serverName, $login, $pass, $this->serverPort ); }
	
	public function getServerLogin() { return $this->serverLoginUser; }
	
	public function getServerName() { return $this->serverName; }
	
	
	
	public function setDBName( $db ) { $this->dbName = $db;  $this->_updateConectionResKey(); }
		
	public function getDBName() { return $this->dbName; }
	
	
	public function getDBCharset() { return $this->dbCharset; }
	
	
	public function setDBCharset( $charset ) { 
		
		if( !is_string($charset) || strlen($charset) == 0 ) $charset = 'latin1';
		$this->dbCharset = $charset; 
		
		$this->_updateConectionResKey();
	}
	
	
	//------------------------------------------------------------------------------------------
	
	
	private function _ping() {
		
		
		@ $pingSuccess = mysqli_ping( self::$conectionResArray[$this->conectionResKey] );
		
		if(!$pingSuccess) {
			
			@ self::$conectionResArray[$this->conectionResKey] = mysqli_connect( $this->serverName, $this->serverLoginUser, $this->serverLoginPass, $this->dbName, $this->serverPort );
			
		}
		
		
		
	}
	
	
	public function disconnect() {
		
		If( is_resource( self::$conectionResArray[$this->conectionResKey] ) ) 
			mysqli_close( self::$conectionResArray[$this->conectionResKey] );
	}
	
		
	//--------------------------------------------------------------------------------------
	
		
	private function _setError( $sConsulta ) {
		
		$this->sErrorNo = mysqli_errno( self::$conectionResArray[$this->conectionResKey] );
		$this->sError = mysqli_error( self::$conectionResArray[$this->conectionResKey] );
		$this->sErrorConsulta = $sConsulta;
		
		
		if(self::$debugMode) {
			
			$lineasConsulta = explode( "\n", $this->getErrorQuery() );
			foreach($lineasConsulta as $index => $linea)
				$lineasConsulta[ $index ] = " <span style='color: #F00'> $index </span> \t $linea";
			
			$cadena = 
					"<div style='border: solid 2px #CCC; background-color: #EEE; padding: 10px; text-align: left; font-size: 11pt'> 
					<strong> Error (".$this->getErrorNo()."): </strong><br /> <br /> <pre style='background-color: #FAFAFA'>" . $this->getError() . " </pre> <br /> <br /> <br />
					<strong> Query: </strong><br /> <br /> <pre style='background-color: #FAFAFA'>" . implode("\n", $lineasConsulta) . " </pre></div>";
					
			echo $cadena;
			
		}
	}
	
		
	public function getErrorNo() { return $this->sErrorNo; }
		
	public function getError() { return $this->sError; }
	
	public function getErrorQuery() { return $this->sErrorConsulta; }
	
		
	//--------------------------------------------------------------------------------------------------------
	
	private function  _getResult( $resResultado ) {
				
		If( mysqli_error( self::$conectionResArray[$this->conectionResKey] ) ) {
			
			$this->_setError( $sConsulta ); 
			return false;
		}
		
		
			
		$this->iFilasAfectadas = mysqli_affected_rows( self::$conectionResArray[$this->conectionResKey] );
		$this->iLastID = mysqli_insert_id( self::$conectionResArray[$this->conectionResKey] );
		$this->iCantidadColumnas = mysqli_field_count( self::$conectionResArray[$this->conectionResKey] );
		
		If( is_bool( $resResultado ) ) return $resResultado;
		
		$aFilas = array();
		While( $aFila = mysqli_fetch_assoc( $resResultado ) ) $aFilas[] = ( $this->iCantidadColumnas == 1 ) ? array_shift( $aFila ) : $aFila;
		
		
		
		If($this->iCantidadColumnas > 1 && is_array( $aFilas ) ) 	{
			
			$resultados = array();
			
			foreach($aFilas as $index => $fila)
				$resultados[$index] = array_extend_keys_html( $fila );
				
		} else $resultados = $aFilas;
			
		
				
		return $resultados;
	}
	
	
	//-------------------------------------------------------------------------------------------------------
	
	
	public function multiQuery( $mConsultas ) {
		
		If( is_array( $mConsultas ) ) $sConsultas = implode( ";", array_filter( $mConsultas ) );
		Else $sConsultas = $mConsultas;
		
		
		$this->_ping();
		@ mysqli_multi_query( self::$conectionResArray[$this->conectionResKey], $sConsultas );
		
		If( mysqli_error( self::$conectionResArray[$this->conectionResKey] ) ) {
			$this->_setError( $sConsultas ); 
			return false;
		}
		
		$aResResultados = array();
		
		do {
		
			if ($res = mysqli_store_result(self::$conectionResArray[$this->conectionResKey])) {
				
				$aResResultados[] = $this->_getResult($res);
				mysqli_free_result($res);
			}
		
		} while (mysqli_next_result(self::$conectionResArray[$this->conectionResKey]));
		
		return $aResResultados;
	}
		
	
	public function query( $sConsulta ) { 
		
		$this->_ping();
		
		@ $resQuery = mysqli_query( self::$conectionResArray[$this->conectionResKey], $sConsulta );
		
		If( mysqli_error( self::$conectionResArray[$this->conectionResKey] ) ) {
			
			$this->_setError( $sConsulta ); 
			return false;
		
		} else return $this->_getResult( $resQuery );
		
	}
	
	//--------------------------------------------------------------------------------------------------
	
	
	public function selectRows( $sConsulta, $arrayKey = null ) {
		
		$array = array();
		$rows = $this->query( $sConsulta );
		
		if( !is_array($rows) ) $rows = array();
			
		if($arrayKey) $rows = self::__setArrayKey( $rows, $arrayKey );
								
		return $rows;
		
	}
	
		
	public function selectRow( $consulta ) { 		
		
		$rows = $this->selectRows( $consulta );
		
		if( !is_array($rows) ) return array();
		else if( count($rows)  > 0 ) return array_shift($rows);
		else return array();
		
	} 
	
		
	public function selectValue( $consulta, $key = '' ) { 
		
		
		$row = $this->selectRow( $consulta );
		
		if( !is_array($row )) return $row;
		else if( count( $row ) > 0 ) return $key == '' ? array_shift( $row ) : $row[ $key ];
		else return false;
		
	}
	
	
	public function exists( $table, $field, $values ) {
		
		if( is_array($values) ) $values = implode( "','", $values );
				
		$consulta = "SELECT COUNT(*) FROM $table WHERE $field IN ('$values')";
		return (boolean) $this->selectValue( $consulta );
	}
	
		
	//---------------------------------------------------------------------------------
	
	
	private function _getQueryTemplate($template, $vars = null, $htmlEntitiesEscape = false) {
		
		if(!is_array($vars)) $vars = array();
		
		$templateParser = new TemplateParser( $template,  self::$templatesDir, self::$templatesExtension );
		$templateParser->addVariables( $vars );
		
		//echo $templateParser->getString();echo "<br />/*-----------------------------*/<br />;
		return $templateParser->getString();
	}
	
	
	public function multiQueryTemplate( $template, $vars = null ) {
			
		
		return $this->multiQuery( $this->_getQueryTemplate( $template, $vars ) );
	}
	
	
	public function selectRowsTemplate( $template, $vars = null, $arrayKey = null ) {
				
		return $this->selectRows( $this->_getQueryTemplate( $template, $vars ), $arrayKey );
		
	}
	
		
	public function selectRowTemplate( $template, $vars = null ) { 
		
		
		return $this->selectRow( $this->_getQueryTemplate( $template, $vars ) );
		
	} 
	
		
	public function selectValueTemplate( $template, $vars = null, $key = '' ) { 
				
		return $this->selectValue( $this->_getQueryTemplate( $template, $vars ), $key );
		
	}
	
	
	
	
	public function queryTemplate( $template, $vars = null, $returnLastID = false, $htmlEntitiesEscape = true ) {
		
				
		$query = $this->_getQueryTemplate( $template, $vars, $htmlEntitiesEscape );
		
		$this->query( $query );
		
		$success = (boolean) $this->getAffectedRows();
		
		if($success && $returnLastID) return $this->getLastInsertID();
		else return $success;
	}
	
	//---------------------------------------------------------------------------------
		
	
	public function getLastInsertID() { return $this->iLastID; }
	
	
	public function getAffectedRows() { return $this->iFilasAfectadas; }
	
	
	public function getFoundRows() { return $this->selectValue('SELECT FOUND_ROWS()'); }
	
	//--------------------------------------------------------------------------------
	
	
	public function insertRow( $table, $data, $returnLastID = false, $htmlEntitiesEscape = true, $avoidControlColumns = null )	{
		
		if(!is_array($data)) return false;
		
		if($avoidControlColumns === true) $avoidControlColumns = array_keys( $data );
				
		
		$data = $this->escapeString($data, $htmlEntitiesEscape);
		
		$data = array_intersect_key( $data, $this->getTableColumns( $table ) );
		
		$sColumnas = implode( ',', array_keys( $data ) );
		$sValores = implode( ',', array_values( self::__controlColumnsValues( $data, $avoidControlColumns ) ) );
		
		$sConsulta = "INSERT INTO $table ($sColumnas) VALUES ($sValores)";
		
		$this->query( $sConsulta );
		
		$success = (boolean) $this->getAffectedRows();
		
		if($success && $returnLastID) return $this->getLastInsertID();
		else return $success;
	}
	
	
	public function insertRows( $table, $columnsArray, $dataArray, $htmlEntitiesEscape = true, $avoidControlColumns = null ) {
		
		
		if($avoidControlColumns === true) $avoidControlColumns = $columnsArray;
		
		
		$dataArray = $this->escapeString($dataArray, $htmlEntitiesEscape);
		
		$columns = is_array( $columnsArray ) ? implode(',', $columnsArray) : $columnsArray;
		
		
		$valuesArray = array();
		foreach($dataArray as $data) $valuesArray[] = is_array( $data ) ? implode( ",", self::__controlColumnsValues( $data, $avoidControlColumns ) ) : $data;
		
		if(count($valuesArray) == 0) return 0;
		
		$values = implode( "),(", $valuesArray );
		
		$consulta = "INSERT INTO $table ($columns) VALUES ($values)";
		
		$this->query( $consulta );
		
		
		return (boolean) $this->getAffectedRows();
	}
		
	
	public function insertRowsCross( $table, $variableData, $constantData, $htmlEntitiesEscape = true, $avoidControlColumns = null  ) {
		
		 $insertData = array();
		 $insertColumns = array();
		 
		 foreach($variableData as $columnName => $valuesArray) 
		 			 	
		 	if(is_array( $valuesArray )) {
		 	
		 		$insertColumns[] = $columnName;
		 		
		 		foreach($valuesArray as $rowIndex => $value) {
		 			
		 			if(!is_array($insertData[ $rowIndex ])) $insertData[ $rowIndex ] = array();
		 			$insertData[ $rowIndex ][] = $value;
		 			
		 		}
		 	}
		 	
		 foreach($constantData as $columnName => $value) {
		 	
		 	$insertColumns[] = $columnName;
		 	
		 	foreach( $insertData as $rowIndex => $data )
		 		$insertData[ $rowIndex ][] = $value;
		 }
		 
		 
		$this->insertRows( $table, $insertColumns, $insertData, $htmlEntitiesEscape, $avoidControlColumns );
		 		
	}
	
	
	public function updateRows( $table, $data, $conditions = null, $htmlEntitiesEscape = true, $avoidControlColumns = null ) {
		
		if(!is_array($data)) return false;
		
		if($avoidControlColumns === true) $avoidControlColumns = array_keys( $data );
				
		$data = $this->escapeString($data, $htmlEntitiesEscape);
		$data = array_intersect_key( $data, $this->getTableColumns( $table ) );
		$data = self::__controlColumnsValues( $data, $avoidControlColumns );
		
		$query = "UPDATE $table SET " . array2string( $data, 'return "$key = $value";', ', ' );
		
		if($conditions) {
			
			if(is_array( $conditions )) $conditions = implode( ' AND ', $conditions );
			$query.= " WHERE $conditions";
			
		}
		
		
		$this->query( $query );
		
		return $this->getAffectedRows();
	}
	
	
	
	
	
	//----------------------------------------------------------------------------------
	
	
	public function getTableColumns( $table, $onlyColumnsNames = false ) {
		
		$rows = $this->selectRows( "DESCRIBE $table", 'Field' );
		
		if(!$onlyColumnsNames) return $rows;
		else return array_keys( $rows );
		
	}
	
	
	//----------------------------------------------------------------------------------
	
	
	public function getBackupQuery( $tables = false ) {
		
		if( !is_array( $tables ) ) {
			
			if( is_string( $tables ) ) $tables = array( $tables );
			else $tables = $this->query( "SHOW TABLES" );
		}
		
		$querys = array();
								
		Foreach( $tables as $table ) {
			
			$query = '';
			
			$query.= "DROP TABLE IF EXISTS $table;\r\n\r\n";
			$query.= $this->selectValue( "SHOW CREATE TABLE $table", 'Create_Table' ) . "\r\n\r\n";
			
			$rows = $this->selectRows( "SELECT * FROM $table" );
			
			$query.= "INSERT INTO $table VALUES\r\n";
			$valores = array();
			
			
			
			Foreach( $rows AS $row )
			$valores[] = "('" . implode( "','", $row ) .  "')";
			
			$query.= implode( ",\r\n", $valores ) . ";";
			
			$querys[] = $query;
		}
		
		
		echo implode( "\r\n\r\n\r\n", $querys );
	}
		
	
	//----------------------------------------------------------------------------------
	
	
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
	
		
		$aFilas = $this->selectRows( $sConsulta,'CLAVE' );
		
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
	
	
	// El Parámetro $aIDsPadre debe ser un array de la forma ID_ELEMENTO_SELECT => CLAVE_SQL que representa
	
	
	public function getListaOpcionesCondicionadoMultiple( $aIDsPadre, $sIdHijo, $sTabla, $sClave, $sTexto, $sCondiciones = '', $bOptionInicial = true, $bDesactivar = false ) {  
		
		If( !is_array( $aIDsPadre ) ) $aIDsPadre = array( $aIDsPadre => $aIDsPadre );
		
		//----------------------------------------------------------------------------------------
		$sNombreVar = implode( '_', array_keys( $aIDsPadre ) ) . "_{$sIdHijo}_CondicionadoMultiple";
		//-------------------------------------------------------------------------------------------
		
		$sConsulta = "SELECT CONCAT_WS(','," . implode( ', ', $aIDsPadre ) . ") AS FORANEA, $sClave AS CLAVE, $sTexto AS TEXTO FROM $sTabla";
		If( $sCondiciones ) $sConsulta.= " WHERE $sCondiciones";
		$sConsulta.= " ORDER BY TEXTO";
		
		$aFilas = $this->selectRows( $sConsulta );
		
		$aClavesForaneas = array();
		
		Foreach( $aFilas AS $aFila )
		$aClavesForaneas[ $aFila['FORANEA'] ][] = $aFila;
		
		$sCadena = "var {$sNombreVar} = new Array();\n";
		
		Foreach( $aClavesForaneas AS $sClaveForanea => $aFilas  ) {
		
			$aOptions = array();
			
			$aFila['TEXTO'] = str_replace( '"', "'", $aFila['TEXTO'] );
			
			Foreach( $aFilas AS $aFila )
			$aOptions[] = "new Option(\"{$aFila['TEXTO']}\", \"{$aFila['CLAVE']}\")";
					
			$sCadena.= "{$sNombreVar}['$sClaveForanea'] = new Array(\n" . implode( ",\n", $aOptions ) . ");\n";
		
		}	
			
		ob_start();
		
		$sTextoVacio = 'Seleccionar...';
		$sTextoDesactivado = 'Seleccionar...';
		$bOcultarPadre = false;
		$bOptionInicial = 'Seleccionar...';
		
		
		
		//------------------------------------------------------------------- ?>
		
			<script type='text/javascript'><!--
			
			<?php echo $sCadena; ?>		
						
			<?php echo array_2_javascript_array( array_keys( $aIDsPadre ), "{$sNombreVar}_IDS_PADRES" ); ?>
			
			selectOpcionesCondicionado( <?php echo "{$sNombreVar}_IDS_PADRES, '$sIdHijo', $sNombreVar, '$sTextoVacio', '$bOptionInicial', '$sTextoDesactivado', ". ( (integer) $bOcultarPadre ) . ", " .  ( (integer) $bDesactivar ) ; ?>);
				
			//--></script>
			
		<?php //------------------------------------------------------------------------
		
		
		return ob_get_clean();
	}
	
	public function getListaCheckBoxs( $sTabla, $sClave, $sTexto, $sNombreGrupo, $sCondiciones = '', $mSeleccionados = '' ) {
	
	
		$sConsulta = "SELECT $sClave AS CLAVE, $sTexto AS TEXTO FROM $sTabla";

		If( $sCondiciones ) $sConsulta.= " WHERE $sCondiciones";
		$sConsulta.= " ORDER BY $sTexto";
	    $aArray= Array('CLAVE');
		 
		$aFilas = $this->selectRows( $sConsulta,'CLAVE');
		// $this->consultaSel( $sConsulta, false, 'CLAVE' );
		            
	    //var_export($aFilas);die();
	    
	        
		$i = 1;
		
		
		If( !is_array($mSeleccionados) ) $mSeleccionados = explode( ',', $mSeleccionados );
	
		Foreach( $aFilas as $sClave => $sTexto ) {
		
			$sOpciones.= 
		
				"<div" . ( ( $i % 2 == 0 ) ? " class='intercalado'" : '' ) . 
				"><input type='checkbox' name='{$sNombreGrupo}[$sClave]'".
				((in_array( $sClave, $mSeleccionados ))?" checked='checked'":'') ."/> $sTexto </div>";
			
				$i++;
		}
		
		return $sOpciones;	
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
	   $result=$this->query($sConsulta);	
	   return $result;
	}
	
}


//---------------------------------------------------------------------- ?>