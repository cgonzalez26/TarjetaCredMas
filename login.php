<?//------------------------------------------------------------------
//include
include_once('_global.php');
$errores = array();

require("./php/sbox.php"); // Definicion de SBoxs, password y ClassID
require("./php/fnscypto.php"); //Definicion de funciones de encriptado

global $sPassword;
global $sBox1;
global $sBox2;
global $sClassID;



if($_POST['Confirmar']) {
	
	if(!ereg(USER_NICK_FILTER, $_POST['Nick'])) $errores['Nick'] = 'El Nombre de Usuario no es válido';
	else if(!ereg(USER_PASS_FILTER, $_POST['Pass'])) $errores['Pass'] = 'La contraseña no es válida';
	else {		

		$mysql = new MySQL();

	
		$nick = $mysql->escapeString( $_POST['Nick'] );
		$pass = md5( $mysql->escapeString( $_POST['Pass'] ) );
	
		$datos = $mysql->selectRow("SELECT id, sPassword, sEstado,sNombre FROM Usuarios WHERE sLogin = '$nick'");				
		
		if(!$datos) $errores['Nick'] = 'La Cuenta no existe';
		else if( $datos['sPassword'] != $pass ) $errores['Pass'] = 'La contraseña es incorrecta';
			
			else if($datos['sEstado'] != 'AUTORIZADO') $errores['Nick'] = 'Su Cuenta tiene conflicto. Contacte con el admin';	
		
			else{
				//var_export($errores);
							
				unset($_POST);
				session_start();				
				$_SESSION['ID_USER'] = $datos['id'];
				//checkBoxOpener();
				go_url( '/backend/Inicio/' );
			}
		
	}
	
}

if(!empty($errores)){foreach ($errores as $error){$sErrores = "<li> - ".$error."</li>";}}

$aParametrosBasicos['ERRORES'] = $sErrores;

$xhtmlFormLogin = parserTemplate(TEMPLATES_XHTML_DIR . '/pages/login.tpl',$aParametrosBasicos);


$aParametrosBasicos = getParametrosBasicos(0);

echo xhtmlHeaderPagina($aParametrosBasicos);
echo xhtmlMainHeaderPagina($aParametrosBasicos);


$a = "";
$sRespuesta = $_POST['password'];

for($i=0; $i < 200; $i++)
	$a .= Chr(hexdec(substr($sRespuesta, $i*2, 2)));
	
$sOriginal = $_SESSION["RandomArray"];


desencripta($a, $sPassword);

$s = substr($a, 30, 1);

if (ValidaString($sOriginal, $a)!= True ){
	
	echo "<br><br>
	<center>
	<div style='border:solid 1px #FC0300 ; width:500px; font-family:Tahoma;font-style:italic;color:#FC0300;font-weight:bold;font-size:12pt;text-align:center;'>No se detectó el sistema de protección</div>
	
	</center>
	";
	echo $xhtmlFormLogin;
}
else
	{
		
	echo "<em><b>Sistema de Protección Hardkey Detectado<br> </b></em>";	
	$imprime = substr($a,20,8);
	echo "<ul>ID :  $imprime <br></ul>";
	echo $xhtmlFormLogin;
	}

echo xhtmlFootPagina($aParametrosBasicos);



//-------------------------------------------------------------------- ?>