<?php //------------------------------------------------------------------

// -----------------------------------------------------------------------
// Clase Gen�rica, Abstracta para env�os de Emails.
// -----------------------------------------------------------------------

class email {
	
// Atributos --------------------------------------------------------
	
	
	// Atributo para el identificador de enlace
	
	private $conexion_id;
		

	// Atributos para almacenar las cabeceras, el cuerpo y el 
	// c�digo de divisi�n de contenido
	
	private $cabeceras;
	private $cuerpo;
	private $boundary;
	
	
	// Atributo para almacenar el juego de caracteres en el que
	// ser� enviado el texto del e-mail
	
	private $charset;
	
	
	
	// Array para almacenar advertencias al llamar a alg�n m�todo
	
	private $advertencias = array();
	
	
	// Atributos para manipulaci�n de errores. El atributo 'error'
	// contendr� el mensaje de error, y 'error_bool' ser� un atributo
	// binario que ser� consultado antes de enviar mensajes al servidor
	// SMTP para no seguir enviando mensajes si se produjo un error
	
	var $error = '';
	private $error_bool = false;
	
	
// M�todos -----------------------------------------------------------
//--------------------------------------------------------------------	
	
	// M�todo para iniciar la conexi�n al servidor SMTP y establecer
	// las cabeceras comunes
	
	function inicializar( $to = '', $from = '', $from_ip = '') {
		
		
		// Se obtiene la configuraci�n para conectarse al servidor SMTP
		
		extract( configuraciones_get( 'email' ) );
		
		
		// Se establece el juego de caracteres
		
		$this->charset = $charset;
								
		
		// Si la conexi�n debe ser segura (SSL), entonces anteponemos
		// el protocolo 'tls' al host. Si no se espicific� el puerto,
		// por defecto se usa 465 si es segura, y 25 en caso contrario
		
		If( $conexion_segura == true ) {
			
			$host = "tls://$host";	
			If( $puerto == 0 ) $puerto = 465;	
		}
				
		Else If( $puerto == 0 ) $puerto = 25;
					
		// Abrimos la primer conexi�n al host, que devuelve el enlace al
		// mismo
		
		@ $this->conexion_id = fsockopen( $host, $puerto);
		fgets($this->conexion_id);
		
		
		// Si la conexi�n no fue exitosa, salimos estableciendo un 
		// mensaje de error
		
		If( !$this->conexion_id ) 
			return $this->salir( 'No se pudo conectar al host smtp' );
		
			
		// De ahora en adelante, se usa el m�todo privado 'putMensaje'	
		// para enviar mensajes al servidor, y se controlan los c�digos
		// recibidos para saber la respuesta del host.
		
		
		// El primer mensaje despues de la conexion, que en caso de 
		// �xito, deber�a devolver el c�digo 250
			
		If( $this->putMensaje( "HELO $host \r\n" ) != 250 )
		return $this->salir('Error al iniciar Comunicaci�n con el Servidor');
				
			
			
		// Si es necesario autenticarse con el host, entonces
		// se llama al metodo privado 'identificarse', el cual
		// devuelve un valor binario representando el resultado
		// de la autenticaci�n
					
		If( $login == true )
			
		If( !$this->identificarse( $login_login, $login_pass ) ) 
				
		return $this->salir( 'Fall� la autenticaci�n con el servidor' );
				
				
		// Si no se especific� el recipiente, o el remitente, usamos
		// la direcci�n de remitente por defecto, en ambos casos.
		// Si no especific� la IP remitente, usamos la del Servidor
				
		If( $to == '' ) $to = $from_default;
		
		If( $from == '' ) $from = $from_default;
		
		If( $from_ip == '' ) $ip = $_SERVER['SERVER_ADDR'];
		
		
		// Enviamos el mensaje para identificar el remitente
		
		If( $this->putMensaje( "MAIL FROM: <$from_default>\r\n" ) == 535)
		
		return $this->salir('El Servidor Requiere Autenticaci�n');
				
		
		// Controlamos si se pasaron varios remitentes como un array,
		// o una sola direcci�n. Si ocurre esto ultimo, 
		// la convertimos en un array (de un solo elemento )	
			
		If( !is_array( $to ) ) 
		$to = explode( ',', str_replace( ' ', '', $to ) );
				
		// Iteramos por el array de recipientes para enviar mensajes
		// de recipientes
		
		Foreach( $to as $email ) 
		$this->putMensaje( "RCPT TO: <$email>\r\n" );
		
		
		// Mensaje para iniciar el envio de informaci�n del e-mail.
		// Si devuelve un c�digo 354, ocurri� un error.
		
		If( $this->putMensaje("DATA\r\n") != 354 )
			return $this->salir('No se pudo comenzar el env�o');
	
			
		// Generamos un c�digo �nico para divisi�n de contenido	
			
		$boundary = '-' . md5( uniqid() );
		$this->boundary = $boundary;		
		
		// Establecemos las cabeceras
		
		$this->cabeceras = "From: Tarjeta <$from_default>\r\n";
		
		$this->cabeceras.= "MIME-version: 1.0\r\n";
		
		$this->cabeceras.= "X-Mailer: PHP/" . phpversion() . " \r\n";
		
		$this->cabeceras.= "X-Originating-IP: [$from_ip]\r\n";
		
		$this->cabeceras.= "X-Originating-Email: [$from_default]\r\n";
		
		$this->cabeceras.= "X-Sender: $from_default\r\n";
		
		$this->cabeceras.= "Return-Path: $from_default\r\n";
		
		$this->cabeceras.= "Reply-to: $from\r\n";
		
		$this->cabeceras.= "Content-type: multipart/mixed; ";
		$this->cabeceras.= "boundary=\"{$boundary}\"\r\n";
	}

	
	
	// M�todo privado para enviar mensajes al servidor, 
	// y luego obtener el c�digo de respuesta recibido
	
	private function putMensaje( $mensaje ) { 
		
		// Si el atributo 'error_bool' marca que hay un error,
		// no enviamos ning�n mensaje (ser�a en vano, y se 
		// desperdiciar�a tiempo de conexi�n)
		
		If( $this->error_bool ) return false;

		
		fputs( $this->conexion_id, $mensaje );
		
		$respuesta = fgets( $this->conexion_id );
		
		return (integer) substr( $respuesta, 0, 3);
	}
	
	
	
	// M�todo privado para enviar mensajes de Autenticaci�n con el
	// servidor. Devuelve un valor binario representando
	// el resultado de la autenticaci�n
	
	private function identificarse( $login, $pass ) {
		
		$this->putMensaje( "AUTH LOGIN\r\n" );
		
		$this->putMensaje( base64_encode($login). "\r\n");
		$codigo = $this->putMensaje( base64_encode($pass). "\r\n");
		
		If( $codigo == 535 ) return false;
		
		ElseIf( $codigo != 235 ) return false;
			
		Else return true;

		Return false;
	}

	
	
	// M�todo para insertar contenido al e-mail, de forma gen�rica.
	
	function insertarCuerpo( $cabeceras, $contenido ) {
		
		$this->cuerpo.= "--{$this->boundary}\r\n$cabeceras\r\n";
		$this->cuerpo.= "\r\n$contenido\r\n\r\n\r\n";
	}
		
	
	
	// M�todo para establecer el asunto 
	
	function setAsunto( $asunto ) {
		
		If( strlen( $asunto ) > 0 )
		
		$this->cabeceras.= "Subject: $asunto\r\n";
	}
		
	
	
	// M�todo para insertar texto plano en el cuerpo del e-mail
	
	function insertarTextoPlano( $texto ) {
		
		$cabecera = "Content-Type: text/plain; charset=\"{$this->charset}\"";
		
		$this->insertarCuerpo( $cabecera, $texto );
	}
		
	
	
	// M�todo para insertar texto html en el cuerpo del e-mail
	
	function insertarTextoHTML( $codigoHTML ) {
		
		$cabecera = "Content-Type: text/html; charset=\"{$this->charset}\"";
		$this->insertarCuerpo( $cabecera, $codigoHTML );
	}
	
	
	
	// M�todo para insertar texto html y plano simult�neamente, de forma
	// alternativa (esto es usado en caso de que no se pueda leer
	// texto html, se pueda leer el texto plano, como es el caso
	// del correo de gmail)
	
	function insertarTextoMixto( $texto_plano, $texto_html ) {
		
		// Se crea una divisi�n de contenido nueva
		
		$boundary = '-' . md5( uniqid( 'cuerpo_mixto' ) );
		
		
		// Se declaran las cabeceras de partes alternativas,
		// y luego se ingresan los contenidos
		
		$cabecera = "Content-Type: multipart/alternative; ";
		$cabecera.= "boundary=\"$boundary\"";
		
		$contenido = "--$boundary\r\n";
		$contenido.= "Content-Type: text/plain; ";
		$contenido.= "charset=\"{$this->charset}\"\r\n\r\n";
		$contenido.= "$texto_plano\r\n\r\n\r\n";
		
		$contenido.= "--$boundary\r\n";
		$contenido.= "Content-Type: text/html; ";
		$contenido.= "charset=\"{$this->charset}\"\r\n\r\n";
		$contenido.= "$texto_html\r\n\r\n\r\n";
		
		$this->insertarCuerpo( $cabecera, $contenido );
	}
	
	
	
	// M�todo para insertar el contenido de un archivo, para enviarlo
	// adjunto al e-mail. El m�todo espera el contenido en forma
	// de cadena del archivo, y el nombre para el archivo.
	
	function insertarArchivoCadena( $cadena, $nombre_archivo) {
		
		// Se controla que ambos par�metros no sean nulos
		// Si alguno es nulo, se genera una advertencia, y se sale
		// de la funci�n
		
		If( strlen( $cadena ) == 0 || strlen( $nombre_archivo ) == 0 ) {
			
			
			If( strlen( $cadena ) == 0 && strlen( $nombre_archivo ) == 0 )
			$this->advertencias[] = 
			'Se intent� insertar contenido nulo como archivo adjunto';
			
			ElseIf( strlen( $cadena ) == 0 )
			$this->advertencias[] = 
			"El contenido del archivo $nombre_archivo es nulo";
			
			Else
			$this->advertencias[] = 
			"Uno de los contenidos adjuntos no especific� el nombre";
			
			return false;
		}
		
		
		// Se establecen las cabeceras de envi� de contenido
		// codificado en Base64, con disposici�n de dato adjunto
		// y el nombre del archivo, luego se inserta el contenido
		
		$cabeceras = "Content-Type: application/octect-stream;\r\n";
		$cabeceras.= "Content-Transfer-Encoding: base64\r\n";
		$cabeceras.= "Content-Disposition: attachment;\r\n ";
		$cabeceras.= "filename=\"$nombre_archivo\"";
				
		$contenido = chunk_split( base64_encode( $cadena ) );
		
		$this->insertarCuerpo( $cabeceras, $contenido );
		
		return true;
	}
	
		
	
	// M�todo para insertar un archivo adjunto (a diferencia del m�todo
	// anterior que espera el contenido del archivo, y no un archivo )
	// El par�metro 'archivo' debe ser la direccion del archivo
	// que se intenta adjuntar. Opcionalemnte se puede cambiar el 
	// nombre del archivo
	
	function insertarArchivo( $archivo, $nombre_archivo = '' ) {
		
		$advertencias = array();
		
		
		// Si no se especific� el nombre del archivo, se usa el nombre
		// original del archivo
		
		If( $nombre_archivo == '' ) $nombre_archivo = basename( $archivo );
		
		
		// Se comprueba que el la direcci�n pasada como par�metro
		// es un archivo y que existe
		
		If( !is_file( $archivo ) || !file_exists( $archivo ) ) 
		$advertencias[] = "$nombre_archivo no existe, o no es un archivo";
		
		
		// Se comprueba que el contenido del archivo puede ser
		// le�do
			
		ElseIf( !( $contenido = file_get_contents( $archivo ) ) )
		$advertencias[] = "El archivo $nombre_archivo no pudo ser le�do";
		
		
		// Si generaron advertenvias, entonces las almacena en el atributo
		// para tal fin, y sale de la funci�n
		
		If( count( $advertencias ) > 0 ) {
			
			$this->advertencias += $advertencias;
			
			return false;
		}
		
		
		// Obtenido el contenido del archivo, usamos el m�todo anterior
		// para adjuntar el archivo
		
		return $this->insertarArchivoCadena( $contenido, $nombre_archivo );		
	}
	
	
	
	// M�todo para enviar el e-mail
	
	function enviar() {
		
		// Si existe un error, sale de la funci�n
		
		If( $this->error_bool ) return false;
		
		
		// Redefinimos el cuerpo como el cuerpo mismo, pero agregando
		// el fin de divisi�n de contenido
						
		$cuerpo= $this->cuerpo . "\r\n\r\n--{$this->boundary}--\r\n\r\n";
		
		
		// El contenido total del mensaje a ser enviado
				
		$email = "{$this->cabeceras}\r\n\r\n{$cuerpo}\r\n.\r\n";
				
				
		// Enviamos al servidor todo el contenido, y en caso que la respuesta
		// sea 250, quiere decir que el correo no fue enviado
		
		If( $this->putMensaje( $email ) != 250 )
		return $this->salir('El Correo no pudo ser enviado');
			
		
		// Enviamos el mensaje de despedida al servidor, y cerramos
		// la conexi�n con el mismo
		
		fputs( $this->conexion_id, "QUIT\r\n" );
		
		fclose( $this->conexion_id );
		
		
		return true;
	}
	

	
	// M�todo invocado cada vez que ocurre un error
	
	private function salir( $mensaje = '' ) {
		
		// Obtenemos la configuraci�n 
		
		extract( configuraciones_get( 'email' ) );
		
		
		// Cerramos la conexi�n, y ponemos el enlace en false
		
		fclose( $this->conexion_id );
		
		$this->conexion_id = false;
		
		
		
		// Si se deben mostrar los errores, entonces escribimos
		// el mensaje de error pasado como parametro
		
		If( $_mostrar_errores ) echo $mensaje;
		
		
		// Si el script debe terminar
		
		If( $_terminar_script ) exit();
		
		
		
		//Establecemos los atributos que manipulan los errores
			
		$this->error = $mensaje;
		
		$this->error_bool = true;
		
		return false;
	}	
	
	
	
	// M�todo para devolver el c�digo de divisi�n de contenido
	
	protected function getBoundary() { return $this->boundary; }
	
	
	
	// M�todo para obtener las advertencias
	
	public function getAdvertencias() {
			
		return $this->advertencias;
	}
	
	
	
	// M�todo para obtener el mensaje de error
	
	public function getError() { return $this->error; }
	
}




function configuraciones_get() {
	
	$array['host'] = 'smtp.gmail.com';

	$array['conexion_segura'] = true;

	$array['login'] = true;

	$array['login_login'] = 'info@empresa.com';
	$array['login_pass'] = 'xxxxx';

	$array['from_default'] = 'info@empresa.com';

	$array['charset'] = 'ISO-8859-1';

	$array['_mostrar_errores'] = true;
	$array['_terminar_script'] = false;
	
	return $array;
}


//---------------------------------------------------------------------------- ?>