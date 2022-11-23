<?
		
	include_once( '_global.php' );
	
	$xhtmlBody = "";
	$aParametros = getParametrosBasicos(0);	
	//$aParametros['MESSAGE'] = $message;

	$message = "";
	$HexColor = "#FF0000;";
	$Operation = false;
	
	if($_POST['Confirmar']){
		
			$id = unserialize( base64_decode($_POST['id']));
			
			$id = $mysql->escapeString( $id );
			$checksum = $_POST['checksum'];
			$Password = $_POST['sPassword'];
			
			$datos = $mysql->selectRow("SELECT id, sMail, sCheckSum FROM Usuarios WHERE Usuarios.id = '$id'");
			
			if(!$datos) $errores['Nick'] = 'Lo siento pero no es posible cambiar su contrase&ntilde;a. Por favor intentelo mas tarde o contacte con el administrador - Error 1';
			else if( strtoupper($datos['sCheckSum']) != strtoupper($checksum) ) $errores['sMail'] = 'Lo siento pero no es posible cambiar su contrase&ntilde;a. Por favor intentelo mas tarde o contacte con el administrador - Error 2';
			else{			
				
				#Actualizo 
				$Set = "Usuarios.sEstado = 'AUTORIZADO', Usuarios.sPassword = '".md5($Password)."', Usuarios.sCheckSum = ''";
				$sConditions = "Usuarios.id = '{$datos['id']}'";
				$ToAuditory = "Cambio de Password a pedido del usuarios :::{$datos['id']}" ;
				
				$mysql->query("CALL ABM_Tables(\"Usuarios\",\"$Set\",\"\",\"$sConditions\",\"2\",\"0\",\"79\",\"$ToAuditory\");");
				unset($_POST);
				$errores['Bueno'] = "- En hora buena tu password a sido modificado";
			}
			
			if(!empty($errores)){
				foreach ($errores as $error){$sErrores .= "<li> - ".$error."</li>";}
				$message = "<div style='color:$HexColor;'>$sErrores</div>";
			}
			$aParametros['MESSAGE'] = $message;
			$Operation = true;
			$xhtmlBody = xhtmlFormChangePass($aParametros);
				
	}

	



	if($_GET && !$Operation){
		
		if($_GET['id'] && $_GET['checksum']){
			$id = unserialize( base64_decode( $_GET['id'] ));	
			$datos = $mysql->selectRow("SELECT id, sMail, sCheckSum FROM Usuarios WHERE Usuarios.id = '$id'");
			
			if(!$datos) header('Location:' . BASE_URL);
			else if($datos['sCheckSum'] != $_GET['checksum']) header('Location:' . BASE_URL);
			else {
				$aParametros['id'] = $_GET['id'];
				$aParametros['checksum'] = $datos['sCheckSum'];
				$xhtmlBody = xhtmlFormChangePass($aParametros);
			}
		}else{
			header('Location:' . BASE_URL);
			exit();
		}
		
		
		
	}

echo xhtmlHeaderPagina($aParametros);

echo xhtmlMainHeaderPagina($aParametros);

echo $xhtmlBody;

echo xhtmlFootPagina();

?>