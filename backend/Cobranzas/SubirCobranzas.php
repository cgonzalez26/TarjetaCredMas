<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );	
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
	echo xhtmlHeaderPagina($aParametros);

	if (isset($_POST['ok']) or $_POST['ok'] > 0 )
	{
		$formu=$_POST;
		subirCobranzas($formu);			
	}
	else
	{
?>
<br>
<center>
	<form action="SubirCobranzas.php" enctype="multipart/form-data" name="f1" id="FormuSubir" method="POST">
		<fieldset id='cuadro' style="height:100px;width:100px;border:1px solid #CCC;">
		<legend> Importar Cobranzas</legend>			
		<table>
				<tr>
					<th width="10%">Archivo:<th>
					<td width="30%"><input type="file" name="archivo"></td>
					<td width="60%" align="left"><button type="button" onclick="enviar(this.form.id)" style="margin-top:5px;">Enviar</button></td>
				</tr>
		</table>	
			
		<input type="hidden" value="1" name="ok">
		<input type="hidden" value="1" name="idUser">
	</form>
</center>	
	<script language="javascript">
	
	function enviar(id)
	{
		var formu=document.forms[id];		
		var mensaje='';
		
		if(formu['archivo'].value=='') 
			mensaje +='Debe Indicar un Archivo.\n';
		
		if (mensaje=='') 
		{
			if(confirm('Confirma la operacion.')) 
				formu.submit();
		}
		
	    else alert(mensaje);
	}
	
	</script>
	

<?php 

}//FIN DEL ELSE SI ES QUE NO MANDO NINGUN ARCHIVO
$aParametros['DHTMLX_WINDOW']=1;
xhtmlHeaderPaginaGeneral($aParametros);		

?>
</div>

</center>
<?php echo xhtmlFootPagina();?>