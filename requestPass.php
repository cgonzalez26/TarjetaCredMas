<?

define( 'BASE' , dirname( __FILE__ ) . '/../..');//define la constante BASE para tener el directorio de trabajo
	
include_once( '_global.php' );

	$message = "";
	$HexColor = "#FF0000;";
	if($_POST){
		if($_POST['sMail'] != '' && $_POST['sLogin'] != ''){
			
			$mail = $mysql->escapeString( $_POST['sMail'] );
			$nick = $mysql->escapeString( $_POST['sLogin'] );
						
			$datos = $mysql->selectRow("SELECT id, sNombre, sApellido, sMail FROM Usuarios WHERE UPPER(sLogin) = UPPER('$nick')");
			
			if(!$datos) $errores['Nick'] = 'No se encontraron registros con los datos proporcionados';
			else if( strtoupper($datos['sMail']) != strtoupper($mail) ) $errores['sMail'] = 'El mail proporcionado no coincide con el que te registrate';
			else{
				$newPass = stringRandom32();
				
				$checkSum = stringRandom32();				
				$checkSum = crypt($checkSum,"Hola mundo") ;
				$id = base64_encode( serialize( $datos['id'] ) ) ;
				#Actualizo ESTADO y PASS
				$Set = "Usuarios.sEstado = 'DENEGADO', Usuarios.sPassword = '".md5($newPass)."', sCheckSum='$checkSum'";
				$sConditions = "Usuarios.id = '{$datos['id']}'";
				$ToAuditory = "Solicitud de cambio de Password. Datos que se ingreso para su solitud fueron Usuario: $nick ::: Email: $email";
				
				$mysql->query("CALL ABM_Tables(\"Usuarios\",\"$Set\",\"\",\"$sConditions\",\"2\",\"0\",\"79\",\"$ToAuditory\");");
				$body = "
						<table cellpadding='0' cellspacing='0' style='font-family:Verdana;font-size:11px;'>
							<tr>
								<td><strong>Hola {$datos['sApellido']}, {$datos['sNombre']}</strong><td>
							</tr>
							<tr>
								<td>
									Tu haz solicitado un cambio de Clave. Para continuar con el proceso por favor haz click en el siguiente enlace <br /><br />
									
									<a href='".BASE_URL."/changePass.php?id=$id&checksum=$checkSum' style='color:#B00E1E;font-size:18px;font-weight:bold;'>Cambiar Clave</a> 
									
									<br /><br />
									Si no podés hacer clic en el enlace de arriba, podés continuar cortando y pegando (o escribiendo) la siguiente dirección en el navegador:
									
									<br /><br />
									
									".BASE_URL."/changePass.php?id=$id&checksum=$checkSum
									
									
								<td>
							</tr>							
						</table>				
						";			
				$array['To'] = $datos['sMail'];
				/*$array['From'] = "infomail@grupoaldazabal.com.ar";
				$array['Subject'] = "CrediMotos - Solicitud de Cambios de Clave";*/
				$array['From'] = "crisgonzalez26@gmail.com";
				$array['Subject'] = "Tarjeta - Solicitud de Cambios de Clave";
				$array['Message'] = $body;					
				//$ok = sendMailNew($array);
				if($ok == '_OK_'){
					$errores['Message'] = 'Se ha enviado un Email a su casilla de correo con instrucciones para realizar el cambio de Password';
					$HexColor = "#000";
				}else{
					$errores['Message'] = 'Sucedio un error al enviar el Email. Por favor vuelve a intentarlo de nuevo mas o tarde o contacta con el administrador';
				}
				unset($_POST);
								
			}
			
			if(!empty($errores)){
				foreach ($errores as $error){$sErrores .= "<li> - ".$error."</li>";}
				$message = "<div style='color:$HexColor;'>$sErrores</div>";
			}			
			
			
			
		}else{
			$message = "<div style='color:#FF0000;'><li> - lo siento pero sucedio un error en el envio de los datos que proporcionaste</li></div>";
		}
				
	}
	

	
$aParametros = getParametrosBasicos(0);
$aParametros['sMail'] = $_POST['sMail'];
$aParametros['sLogin'] = $_POST['sLogin'];
$aParametros['MESSAGE'] = $message;

echo xhtmlHeaderPagina($aParametros);

//echo xhtmlMainHeaderPagina($aParametros);

echo xhtmlFormRequestPassword($aParametros); 

echo xhtmlFootPagina();

?>