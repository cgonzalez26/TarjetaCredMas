<td align='left' width= '200'>&nbsp;{sTitulo}</td>
<td align='left' width='200'>&nbsp;{sMembrete}</td>
<td align='center' width='100'>&nbsp;{dFechaRegistro}</td>
<td align='center' width='80' valign="center">&nbsp;
	<span id='div_circular_{id}'>
		<a href="javascript:cambiarEstadoCIRCULAR('{_i}',{iPublico});">{sPublico}</a>
	</span>
</td>
<td align='center' width=''>
	<a href='AdminCirculares.php?_i={_i}&_op={_rv}'><img src="{IMAGES_DIR}/reenviar24.png" title="Reenviar" alt="Reenviar" hspace="4" /></a>	
</td>
<td align='center' width=''>
	<a href='AdminCirculares.php?_i={_i}&_op={_rc}'><img src="{IMAGES_DIR}/icons/calendar24.png" title="Reporte" alt="Reporte" hspace="4" /></a>	
</td>
<td align='center' width=''>
	<a href="javascript:deleteCIRCULAR('{sTitulo}','{_i}');"><img src="{IMAGES_DIR}/delete24.png" title="Eliminar" alt="Eliminar" hspace="4" /></a>	
</td>
<!--<td align='center' width='' class='column_operations_right'>
	<a href='#'><img src="{IMAGES_DIR}/icons/delete24.png" title="" alt="" hspace="4" /></a>	
</td>-->