<?

	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
	

	$idUser = $_SESSION['ID_USER'];

		
	$aParametros = array();
	
	//--------------Datos de Configuracion de la lista de usuarios---------------------//
	$aParametros = getParametrosBasicos(1);	
	
	//---------------------------------------------------

	
	
	$ListUsers = new ListObject($aParametros);

	$Menu = new Menu($idUser);
	$Menu->setSector('Usuarios');

# ::: a partir de aqui se muestra el html de la PAG

echo xhtmlHeaderPagina($aParametros);
echo xhtmlMainHeaderPagina($aParametros);

echo "
<center>
<form action='pruebas.php' method='POST' name='form' id='form' class='FormGeneric' enctype='multipart/form-data' style='display:inline;'>
<table id='Formulario' class='Formulario' cellpadding='6' cellspacing='6'>
<tr>
	<th>Login *</th>
	<td><input type='text' name='sLogin' id='sLogin' value='' size='40'></td>	
	<th>Password *</th>
	<td><input type='text' name='sPassword' id='sPassword' value='' size='40'></td>		
</tr>
<tr>
	<th>&nbsp;</th>
	<td><div id='LoginValid'></div></td>	
	<th>Repita *</th>
	<td><input type='text' name='sPasswordTwo' id='sPasswordTwo' value='' size='40'></td>		
</tr>
<tr>
	<th>Sucursal</th>
	<td><select name='idSucursal' id='idSucursal'><option value='0'>[-Seleccionar-]</value></select></td>	
	<th>Oficina</th>
	<td><div id='tdOficina'><select name='idOficina' id='idOficina'><option value='0'>[-Seleccionar-]</value></select></div></td>	
</tr>
<tr>
	<th>Nombre</th>
	<td><input type='text' name='sNombre' id='sNombre' value='' size='40'></td>	
	<th>Apellido</th>
	<td><input type='text' name='sApellido' id='sApellido' value='' size='40'></td>		
</tr>
<tr>
	<th>Direccion</th>
	<td><input type='text' name='sDireccion' id='sDireccion' value='' size='40'></td>		
	<th>Email</th>
	<td><input type='text' name='sMail' id='sMail' value='' size='40'></td>			
</tr>
<tr>
	<th>Movil</th>
	<td><input type='text' name='sCodigoPostal' id='sCodigoPostal' value='' size='40'></td>	
	<th>Estado</th>
	<td><select name='sEstado'><option value='AUTORIZADO'>Autorizado</option><option value='DENEGADO'>Denegado</option></select></td>		
</tr>
<tr>
	<th valign='top' style='border-top:0px solid #000;'>Permisos</th>
	<td colspan='3' style='border-top:1px solid #CCC;'>
		<div style=\"height: 25px;\">
		<input id=\"key[]\" type=\"checkbox\" value=\"1\" name=\"key[]\"/>
		<span class=\"LetraTipoPermisos\">Administrador</span>
		</div>
		<div style=\"height: 25px;\">
		<input id=\"key[]\" type=\"checkbox\" value=\"2\" name=\"key[]\"/>
		<span class=\"LetraTipoPermisos\">Supervisor</span>
		</div>
		<div style=\"height: 25px;\">
		<input id=\"key[]\" type=\"checkbox\" value=\"3\" name=\"key[]\"/>
		<span class=\"LetraTipoPermisos\">Encargado</span>
		</div>				
	</td>
</tr>
<tr>	
	<td colspan='4'>&nbsp;
		<input type='hidden' name='Operation' id='Operation' value='New'>
		<input type='hidden' name='id' id='id' value=''>
	</td>
</tr>
<tr>
	<td colspan='4' align='center' style='text-align:center !important;'><input type='submit' name='Aceptar' id='Aceptar' value='Aceptar' style='width:120px;height:25px;' onclick=\"javascript: return checkDatosUser();\">&nbsp;&nbsp;<input type='reset' name='Cancelar' id='Cancelar' value='Cancelar' style='width:120px;height:25px;' onclick=\"javascript:document.location.href='pruebas.php'\"></td>
</tr>
</table>
</form>
</center>
";



echo xhtmlFootPagina();

?>