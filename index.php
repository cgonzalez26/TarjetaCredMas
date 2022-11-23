<?//------------------------------------------------------------------
//phpinfo();
include_once('_global.php');



$errores = array();

if($_POST['Confirmar']) {
	//if($_POST['Nick'] != 'cflores') go_url("/Restringido.html");
	if(!ereg(USER_NICK_FILTER, $_POST['Nick'])) $errores['Nick'] = 'El Nombre de Usuario no es válido';
	else if(!ereg(USER_PASS_FILTER, $_POST['Pass'])) $errores['Pass'] = 'La contraseña no es válida';
	else {		

		//$mysql = new MySQL();
		$_POST['Nick'] = strtoupper($_POST['Nick']);
		//$nick = $mysql->escapeString( $_POST['Nick'] );
		//$pass = md5( $mysql->escapeString( $_POST['Pass'] ) );
		$nick = $oMysql->escapeString( $_POST['Nick'] );
		$pass = md5( $oMysql->escapeString( $_POST['Pass'] ) );
	
		
		/*$datos = $mysql->selectRow("SELECT id,idOficina,sPassword,sEstado,sLogin,idTipoEmpleado,idArea,CONCAT(Empleados.sApellido, ', ', Empleados.sNombre) as 'sEmpleado' FROM Empleados WHERE sLogin = '$nick'");				*/
		$datos = $oMysql->consultaSel("SELECT id,idOficina,sPassword,sEstado,sLogin,idTipoEmpleado,idArea,CONCAT(Empleados.sApellido, ', ', Empleados.sNombre) as 'sEmpleado' FROM Empleados WHERE sLogin = '$nick'",true);			
		
		if(!$datos) $errores['Nick'] = 'La Cuenta no existe';
		
		else if( $datos['sPassword'] != $pass ) $errores['Pass'] = 'La contraseña es incorrecta';
			
			else if($datos['sEstado'] != 'A') $errores['Nick'] = 'Su Cuenta tiene conflicto. Contacte con el admin';	
		
			else{
				unset($_POST);						
							
				$_SESSION['id_user'] = $datos['id'];
				$_SESSION['ID_OFICINA'] = $datos['idOficina'];
				$array = $oMysql->consultaSel("SELECT Regiones.id,Regiones.sNumero,Oficinas.idSucursal,Sucursales.sNombre as sSucursal,Oficinas.sApodo as sOficina, Oficinas.iProduccion, Oficinas.idProductor  FROM Regiones LEFT JOIN Sucursales ON Sucursales.idRegion=Regiones.id LEFT JOIN Oficinas ON Oficinas.idSucursal=Sucursales.id LEFT JOIN Empleados ON Empleados.idOficina=Oficinas.id WHERE Empleados.id={$datos['id']}",true);
				$_SESSION['ID_REGION'] = $array['id'];
				$_SESSION['NUMERO_REGION'] = $array['sNumero'];
				$_SESSION['ID_TIPOEMPLEADO'] = $datos['idTipoEmpleado'];
				$_SESSION['login'] = $datos['sLogin'];
				$_SESSION['id_suc'] = $array['idSucursal'];
				$_SESSION['sSucursal'] = $array['sSucursal'];
				$_SESSION['sOficina'] = $array['sOficina'];
				$_SESSION['sEmpleado'] = $datos['sEmpleado'];
				$_SESSION['iProduccion'] = $array['iProduccion'];
				$_SESSION['idProductorLiderar'] = $array['idProductor'];
				
				$sConsulta = "call usp_getAllPermitsUser({$datos['id']})";
				
				$aPermisos = $oMysql->consultaSel($sConsulta,false,'idObjeto');
				
				//$_SESSION['_PERMISOS_'] = $aPermisos;//
				$_SESSION['_PERMISOS_'] = $aPermisos;
				
				//getArrayPermitsUser(65);
										
				//$mysql->query(" CALL usp_SessionEmpleado('{$datos['id']}','{$datos['idOficina']}','0','{$datos['idTipoEmpleado']}','{$array['id']}','{$datos['sLogin']}','{$array['sNumero']}','0'); ");	
				
				go_url( '/backend/administrator/' );
			}	
	}
	
}

if(!empty($errores)){foreach ($errores as $error){$sErrores = "<li> - ".$error."</li>";}}

$aParametrosBasicos['ERRORES'] = $sErrores;

$xhtmlFormLogin = parserTemplate(TEMPLATES_XHTML_DIR . '/Pages/login.tpl',$aParametrosBasicos);


$aParametrosBasicos = getParametrosBasicos(0);

// echo xhtmlHeaderPagina($aParametrosBasicos);

//echo xhtmlMainHeaderPagina($aParametrosBasicos);

echo $xhtmlFormLogin;

echo xhtmlFootPagina($aParametrosBasicos);



//-------------------------------------------------------------------- ?>