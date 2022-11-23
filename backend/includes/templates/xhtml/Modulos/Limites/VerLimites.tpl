<center>
	<div id='' style='width:65%;text-align:right;margin-right:10px;'>
		<a href="Limites.php" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='Buscar Limites' alt='Buscar Limites' border='0' hspace='4' align='absmiddle'> Volver</a>
	</div>
	<form id="formLimite" action="AdminLimites.php" method="POST">
		
		<fieldset id='cuadroOficina' style="height:350px;width:300px">
			<legend> Datos del Limite</legend>			
			<table id='TablaCanal' cellpadding="0" cellspacing="5" class="TablaGeneral" width="650px">
			<tr>
				<th style="width:150px"> Codigo: </th>
				<td> 
					<span id="lblCodigo">{CODIGO}</span>
				</td>
			</tr>
			<tr>
				<th> Descripcion: </th>
				<td><span id="lblDescripcion">{DESCRIPCION}</span></td>
			</tr>
			<tr>
				<th> Limite de Compra:</th>
				<td> <span id="lblLimiteCompra">{LIMITE_COMPRA}</span></td>
			</tr>
			<tr>
				<th> Limite de Credito:</th>
				<td><span id="lblLimiteCredito">{LIMITE_CREDITO}</span></td>
			</tr>
			<tr>	
				<th> Limite de Financiacion:</th>
				<td> <span id="lblLimitePorcentajeFinanciacion">{LIMITE_PORCENTAJE_FINANCIACION}</span> % &nbsp;&nbsp;<span id="lblLimiteFinanciacion">{LIMITE_FINANCIACION}</span></td>
			</tr>
			<tr>
				<th> Limite de Prestamo:</th>
				<td> <span id="lblLimitePorcentajePrestamo">{LIMITE_PORCENTAJE_PRESTAMO}</span> % &nbsp;&nbsp;<span id="lblLimitePrestamo">{LIMITE_PRESTAMO}</span></td>
			</tr>
			<tr>	
				<th> Limite de Adelanto:</th>
				<td> <span id="lblLimitePorcentajeAdelanto">{LIMITE_PORCENTAJE_ADELANTO}</span> % &nbsp;&nbsp;<span id="lblLimiteAdelanto">{LIMITE_ADELANTO}</span></td>
			</tr>	
			<!--<tr>	
				<th> Limite de SMS:</th>
				<td> <span id="lblLimitePorcentajeSMS">{LIMITE_PORCENTAJE_SMS}</span> % &nbsp;&nbsp;<span id="lblLimiteSMS">{LIMITE_SMS}</span></td>
			</tr>-->
			<tr>
				<th> Limite de Global:</th>
				<td>  <span id="lblLimiteGlobal">{LIMITE_GLOBAL}</span></td>
			</tr>
			</table>
		</fieldset>
	</form>
</center>

