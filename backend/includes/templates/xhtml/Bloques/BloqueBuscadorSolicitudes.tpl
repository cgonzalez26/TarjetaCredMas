<center>
<script>
function quitarEspacios(sCadena,id){
	//var eRegular = /(^\s*)|(\s*$)|[ ]/g;
	//return sCadena.toString().replace(/\s+/, "");
	var eRegular = "/\s/g";
	sCadena =sCadena.replace(/\s/g,"");
	document.getElementById(id).value = sCadena;
}
</script>
	<form action="{FORM}" method="POST" id="formBuscadorSolicitudes" >

		<table  class='formulario'  style="width:600px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> 
		  	<th colspan="4" class="cabecera"> {TITULO} </th> 
		  </tr>
		  <tr>
			 <th width="30" height="30" align="right" style="width:130px">Nro. Solicitud: &nbsp;</th>
			 <td height="30"><input type="text" name="sNumero" id="sNumero" value='{sNumero}' onKeyUp="quitarEspacios(this.value,this.id)"></td> 
			 <th align="right">Estado:</th>
			 <td><select id="idEstadoSolicitudes" name="idEstadoSolicitudes" >{OPTIONS_ESTADOS}</select></td>
		  </tr>
		  <tr>
		  	<th align="right">Tipo Documento:</th>
		  	<th><select id="idTipoDocumento" name="idTipoDocumento" class="FormTextBox">
					{optionsTipoDoc}
				</select>
			</th>
		  	<th align="right">Nro. Documento:</th>
		  	<th><input type="text" name="sDocumento" id="sDocumento" value='{sDocumentoTitu}'></th>
		  </tr>
		  <tr>
		  	<th align="right">Apellido del Titular:</th>
		  	<th><input type="text" name="sApellido" id="sApellido" value='{sApellidoTitu}'></th>
		  	<th align="right">Nombres del Titular:</th>
		  	<th><input type="text" name="sNombre" id="sNombre" value='{sNombreTitu}'></th>
		  </tr>
		  <tr>			
			 <td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		 </tr>
		</table>
	</form>
