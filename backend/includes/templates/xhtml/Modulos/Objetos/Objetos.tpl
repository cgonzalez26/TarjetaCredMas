<body style="background-color:#FFFFFF">
<center>
	<div id='' style='width:75%;text-align:right;margin-right:10px;'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Objeto' border='0' hspace='4' align='absmiddle'> 
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>[F9] Guardar </a>
		&nbsp;&nbsp;			
		<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<img src='{IMAGES_DIR}/newOrder.png' title='Nueva sucursal' alt='Nuevo Objeto' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>Nuevo</a>
			&nbsp;&nbsp;			
		</div>
		<img src='{IMAGES_DIR}/back.png' title='Buscar sucursal' alt='Buscar Objeto' border='0' hspace='4' align='absmiddle'> 
		<a href="Objetos.php" style='text-decoration:none;font-weight:bold;'>Volver</a>
	</div>
	<form id="formObjetos" action="AdminObjetos.php" method="POST">
	<input type="hidden" id="idObjeto" name="idObjeto" value="{ID_OBJETO}" />
	<input type='hidden' name='permitObject' id='permitObject' value=''>
	
	<fieldset id='cuadroSucursal' style="height:385px;width:50%">
		<legend> Datos de Objeto:</legend>			
		<table id='TableObjeto' cellpadding="0" cellspacing="5" class="TableCustomer">
		<tr>
			<td valign="top">
			<table id='TableCustomer' cellpadding="0" cellspacing="5" class="TableCustomer">
			<tr>
				<th> Nombre: </th>
				<td class='borde'> 
					<input id="sNombre" name="sNombre" value='{NOMBRE}' type='text' tabindex="1" style='width:200px;'/> <sup>*</sup>
				</td>
			</tr>
			<tr>
				<th> Codigo Objeto: </th>
				<td class='borde'> 
					<input id="sCodigoObjeto" name="sCodigoObjeto" value='{CODIGO_OBJETO}' type='text' tabindex="2" style='width:200px;'/> <sup>*</sup>
				</td>
			</tr>
			<tr>	
				<th class='borde'> Tipo de Objeto: </th>
				<td> 
					<select name='idTipoObjeto' id='idTipoObjeto' style='width:200px;' tabindex="3">
					{OPTIONS_TIPOSOBJETOS}
					</select> <sup>*</sup>
				</td>
			</tr>
			<tr>
				<th>Unidad de Negocio:</th>
				<td> 
					<select name='idUnidadNegocio' id='idUnidadNegocio' style='width:200px;' tabindex="4">
					{OPTIONS_UNIDADESNEGOCIOS}
					</select> <sup>*</sup>
				</td>
			</tr>
			<tr>
				<th> Url:</th>
				<td class='borde'> 
					<input id="sUrl" name="sUrl" value='{URL}' type='text' tabindex="5" style='width:200px;'/>
				</td>			
			</tr>
			<tr>
				<th> Objeto Padre:</th>
				<td class='borde'> 
					<!--<input id="iOrder" name="iOrder" value='{ORDER}' type='text' tabindex="8" style='width:200px;'/> <sup>*</sup>-->
					<select id="iOrder" name="iOrder" tabindex="8" style='width:200px;'>
						{OPTIONS_OBJETOS}
					</select> 
				</td>			
			</tr>
			<tr>
				<th> Visible:</th>
				<td class='borde'> 
					<input type="checkbox" id="bItemVisible" name="bItemVisible" value="1" {CHECKED}/>
				</td>			
			</tr>
			<tr>
				<th> Class:</th>
				<td class='borde'> 
					<input id="sClass" name="sClass" value='{CLASS}' type='text' tabindex="6" style='width:200px;'/>
				</td>			
			</tr>
			<tr>
				<th> sImage:</th>
				<td class='borde'> 
					<input id="sImage" name="sImage" value='{IMAGE}' type='text' tabindex="7" style='width:200px;'/>
				</td>			
			</tr>
			</table>
			</td>
			<td>
				<div id="permisos" style="width:370px;height:320px;border:1px solid #CCC; overflow-y:auto;">{PERMISOS}</div>
			</td>
			</tr>
		</table>	
		
	</fieldset>
	</form>
<!--
{TAG_ADICIONALES}
-->


<input type='hidden' id="id_aseguradoID" name='asegurado[ID]' value='{asegurado_ID}' />

<script type='text/javascript'>		

	function getAllChecked(){
		var aPermisos = document.getElementsByName("chkTipoPermiso[]");
		var sIdLista = "";
		
		for(var i=0; i < aPermisos.length; i++){
			if (aPermisos[i].checked){
                sIdLista = sIdLista + aPermisos[i].value+',';
            }    
		}
		return sIdLista;
	}
		
	function saveDatos()
	{
		var Formu = document.forms['formObjetos'];
		if(validarDatosForm(Formu)){
			if(confirm('Esta seguro de realizar esta operacion?')){	
				Formu['permitObject'].value = getAllChecked();
				
				xajax_updateObjeto(xajax.getFormValues('formObjetos'));
			}	
		}
	}			
	
	function validarDatosForm() 
	{
		var Formu = document.forms['formObjetos'];
		var errores = '';
		 
		with (Formu){
			if( sNombre.value == "" )
			errores += "- El campo Nombre es requerido.\n";
			if( sCodigoObjeto.value == "" )
			errores += "- El campo Codigo Objeto es requerido.\n";
			if( idTipoObjeto.value == 0 )	
			errores += "- El campo Tipo de Objeto es requerido.\n";			
			if( idUnidadNegocio.value == 0 )
			errores += "- El campo Unidad de Negocio es requerido.\n";				
			/*if( sUrl.value == "" )
			errores += "- El campo Url es requerido.\n";			
			if( iOrder.value == "" )
			errores += "- El campo Order es requerido.\n";*/			
		}
		if( errores ) { alert(errores); return false; } 
		else return true;
	}
	
	
	function resetDatosForm() {
		var Formu = document.forms['formObjetos'];
		//Formu.reset();
		Formu.idObjeto.value = 0;
		Formu.idTipoObjeto.value = 0;
		Formu.idUnidadNegocio.value = 0;
		Formu.sNombre.value = "";
		Formu.sCodigoObjeto.value = "";
		Formu.sUrl.value = "";
		Formu.iOrder.value = "";
		Formu.bItemVisible.checked = false;
		Formu.sClass.value = "";
		Formu.sImage.value = "";
	}

</script>