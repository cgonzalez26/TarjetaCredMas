 <center>
<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div><br />
<form action="" method="POST" id="formAdminUsu"> 
<div id="marco" style="width:{ANCHO}; border:solid 1px #CCCCCC;">
        <div style="color:red;font-family:Tahoma;font-size:8pt;">{MENSAJE}</div>  
		<div class="titulo" style="background:#ccc;border:solid 1px #666"> {TITULO} </div>
		<span class="espacio"></span>
		<table id='sucursales_dependiente' class="formulario" >
		     
		     <tr>
				<th class='borde' align="right" style="font-family:Tahoma;">Usuario :</th>
				<td   class='borde'>
				<input name="user" type="text" class="text" size="16" maxlength="32" style='height: 21px; padding: 3px 0 0 2px;'><sup>*</sup>
				</td>
		 	</tr>
			<tr>
				<th class='borde' align="right" style="font-family:Tahoma;">Clave :</th>
				<td   class='borde'>
				<input name="pass" type="password" class="text" size="16" maxlength="32" style='height: 21px; padding: 3px 0 0 2px;'>
		   		<sup>*</sup>
				</td>
		 	</tr>
		</table>
		
		 <span class="espacio"></span>
		 <button onclick="{ACCION}" type="button" style="font-family:Tahoma;" id="btn_admin" >{ETIQUETA}</button>
		 <input type="hidden" name="iTipo" value="{TIPO}" id="iTipo" />	
</div>	
</form>
</center>