<center>
<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div><br />
{OTROS_ESTILOS_FUNCIONES}
<form action="" method="POST" id="formAdminUsu"> 
<div id="marco" style="width:{ANCHO}; border:solid 1px #CCCCCC;">

		<div class="titulo" style="background:#ccc;border:solid 1px #666"> {TITULO} </div>
		<span class="espacio"></span>
		<table id='sucursales_dependiente' class="formulario" >
		     {PRIMEROS_FILTROS}
		     <tr {SUCURSAL}>
				<th class='borde' align="right">Sucursales :</th>
				<td   class='borde'>
				<select name='sucursal'  id='id_sucursal'  {CAMBIAR}>
						{OPCIONES_SUCURSALES}
			   		</select>
		   		<sup>*</sup>
				</td>
		 	</tr>
		 	
			<tr {DEPENDIENTE}>
				<th class='borde' align="right">Dependiente :</th>
				<td   class='borde'>
					<select name='dependiente'  id='id_dependiente'   {EVENTO}  >
						<option value='0'>Seleccionar Dependiente...</option>
			   		</select>
		   		<sup>*</sup>
		   		{SCRIPT_DEPENDIENTE}
				</td>
		 	</tr>
		 	<tr {USUARIO}>
				<th class='borde' align="right">Usuario :</th>
				<td   class='borde'>
					<select name='usuario'  id='id_usuario'   {EVENTO2}  >
						<option value='0'>Seleccionar Usuario...</option>
			   		</select>
		   	
		   		{SCRIPT_USUARIOS}
				</td>
		 	</tr>
		 	{OTROS_FILTROS}	
		</table>
		
		 <span class="espacio"></span>
		 <button onclick="{ACCION}" type="button" {BTN_ESTILO} id="btn_admin" >{ETIQUETA}</button>
</div>	
{OTROS_SCRIPT}

<input type="hidden" name="idPoliza" value="{ID_POL}" id="idPoliza">	
<input type="hidden" name="idPago" value="{ID_PAGO}" id="idPago">	
<input type="hidden" name="idCuota" value="{ID_CUOTA}" id="idCuota">	
<input type="hidden" name="idAux" value="{idAux}" id="idAux">	
</form>
</center>