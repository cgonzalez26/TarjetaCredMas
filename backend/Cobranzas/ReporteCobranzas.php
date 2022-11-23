<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');

	include_once(  BASE . '/_global.php' );

	//session_start();

	#Control de Acceso al archivo
	//if(!isLogin())
	//{
		//go_url("/index.php");
	//}

	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	

	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
		
	
	
	if ($Pagina <= 0) $Pagina = 1;

	$NombreMod = 'Cobranzas'; // Nombre del modulo
	$NombreTipoRegistro = 'Cobranza';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Cobranzas'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array
						(
							'',
							'Cobranzas.dFechaCobranza',							
							'CuentasUsuarios.sNumeroCuenta',
							'Usuarios.sApellido',
							'Cobranzas.fImporte'							
						 );
	$arrListaEncabezados = array
							(
								'Empleado',
								'Fecha Cobro',								
								'Cuenta',
								'Descripcion',								
								'Importe'								
							);
								
	$Tabla = 'Cobranzas'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'Cobranzas.dFechaCobranza'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
		
	if(isset($_POST['buscar']))
	{	
		//$sNumeroCuenta = $_POST['sNroCuenta'];
		//$sNombre = $_POST['sNombre'];
		//$sApellido = $_POST['sApellido'];
		$dFechaDesde = $_POST['dFechaDesde'];
		$dFechaHasta = $_POST['dFechaHasta'];
		
		$condic = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; // variable que se usa en la paginacion 

	    //echo "Nombre ". $_POST['nombre_u'];
		if(!session_is_registered('dFechaDesde'))
		{
			//session_register('sNroCuenta');
			//session_register('sNombre');
			//session_register('sApellido');
			session_register('dFechaDesde');
			session_register('dFechaHasta');
		}
		
		//$_SESSION['sNroCuenta'] = $_POST['sNroCuenta'];
		//$_SESSION['sNombre'] = $_POST['sNombre'];
		//$_SESSION['sApellido'] = $_POST['sApellido'];
		$_SESSION['dFechaDesde '] = $_POST['dFechaDesde'];
		$_SESSION['dFechaHasta '] = $_POST['dFechaHasta'];

		unset($_SESSION['volver']);
	}
	else
	{
		//$sNumeroCuenta = $_SESSION['sNroCuenta'];
		//$sNombre = $_SESSION['sNombre'];
		//$sApellido = $_SESSION['sApellido'];
		$dFechaDesde = $_SESSION['dFechaDesde'];
		$dFechaHasta = $_SESSION['dFechaHasta'];
	}

	$sWhere = "";
	$aCond=Array();
	
	$dFechaDesde = dateToMySql($dFechaDesde);
	$dFechaHasta = dateToMySql($dFechaHasta);
	
	//if($sNumeroCuenta){$aCond[]=" CuentasUsuarios.sNumeroCuenta = '$sNumeroCuenta' ";}
	//if($sNombre){$aCond[]=" Usuarios.sNombre LIKE '%$sNombre%' ";}
	//if($sApellido){$aCond[]=" Usuarios.sApellido LIKE '%$sApellido%' ";}
	
	$aCond[] = " Cobranzas.sEstado = 'A'";
	
	if($dFechaDesde){ $aCond[] = "Cobranzas.dFechaCobranza >= '$dFechaDesde'"; }else{$aCond[] = "1=-1";} 
	if($dFechaHasta){ $aCond[] = "Cobranzas.dFechaCobranza <= '$dFechaHasta'"; }else{$aCond[] = "1=-1";}
	
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
	//echo $sCondiciones;
	
	$sqlDatos="Call usp_getCobranzas(\"$sCondiciones\");";
	$sqlDatos_sLim="Call usp_getCobranzas(\"$sCondiciones_sLim\");";
	//echo $sqlDatos;
	// Cuento la cantidad de registros sin LIMIT
	//$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	//$result = $oMysql->consultaSel($sqlDatos);
	$result = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	//$CantRegFiltro = sizeof($result_sLim);

	//$aParametros['optionsTipoDoc'] = $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre');
	
	$oXajax=new xajax();

	$oXajax->registerFunction("updateEstadoCobranza");
	$oXajax->registerFunction("habilitarCobranzas");
	$oXajax->registerFunction("setEstadoCuentaUsuarioByCobranza");		
	$oXajax->registerFunction("RecalcularLimites");		
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");	

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
?>
<body style="background-color:#FFFFFF;">
	<center>
	<div id='BODY'>
<?php 

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorReporteCobranzas.tpl",$aParametros);


if (count($result)==0){echo "<div style='width:700px;'><p style='text-align:left;'>No se encontraron registros</p></div>";}
$sCadena = "";
if ($result){	
	
	$sub_query = " WHERE Empleados.id = {$_SESSION['id_user']}";
	//$sub_query = " WHERE Empleados.id = 606";
	
	$user_online = $oMysql->consultaSel("CALL usp_getEmpleados(\"$sub_query\");",true);  
	//var_export("CALL usp_getEmpleados(\"$sub_query\");");die();
	if(!$user_online){
		$nombre_oficina = "-";
		$nombre_usuario = "-";
		$nombre_login = "";
	}else{
		$user_online = array_shift($user_online);
		$nombre_oficina = $user_online['sOficina'];
		$nombre_usuario = $user_online['sApellido'] . ", " . $user_online['sNombre'];
		$nombre_login = $user_online['sLogin'];
	}
  

  $CantReg = sizeof($result);
  
  $sCadena .= "<div style='width:700px;text-align:right;'>
  				<img src='../includes/images/print.gif' align='absmiddle'> <a href='javascript:_printReporteCobranzas();'>imprimir</a>
  			   </div>";  
  
  $sCadena .= "<div id='div_cobranzas'><div style='width:700px;'>
  	<p style='text-align:left;'>Usuario: <strong>$nombre_usuario ($nombre_login)</strong></p>
  	<p style='text-align:left;'>OFICINA: <strong>$nombre_oficina</strong></p>
  	<p style='text-align:left;'>Periodo: <strong>{$dFechaDesde}</strong> - <strong>{$dFechaHasta}</strong></p>
  	<p style='text-align:left;'>Se encontraron ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p></div>
	<!--<form id='formCobranzas' action='' method='POST' >-->
		<center>
  		<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#CCC' width='700' id='tableCobranzas'>
		<tr class='filaPrincipal'>
		<!-- Lista de encabezados de columna -->";
	
  	$CantEncabezados = count($arrListaEncabezados);
	for($i=0; $i<$CantEncabezados; $i++){
		$sCadena .= "<th style='height:25px'>";
		if($CampoOrden == $arrListaCampos[$i]){
			//var_export('entro');
			if ($TipoOrden == 'ASC') $NuevoTipoOrden = 'DESC'; else $NuevoTipoOrden = 'ASC';
		}
		else $NuevoTipoOrden = 'ASC';
		//var_export($TipoOrden.'----'.$NuevoTipoOrden);
		$sCadena .= "<a href=\"{$_SERVER['PHP_SELF']}?CampoOrden={$arrListaCampos[$i]}&TipoOrden={$NuevoTipoOrden}\">{$arrListaEncabezados[$i]}</a>";
		if($CampoOrden == $arrListaCampos[$i]){
			if ($TipoOrden == 'ASC') 
				$sCadena .= "&nbsp;<img src='../includes/images/asc16.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendente' title='Ordenado por {$arrListaEncabezados[$i]} Ascendente' align='absmiddle'/>"; 
			else 
				$sCadena .= "&nbsp;<img src='../includes/images/desc16.png' alt='Ordenado por {$arrListaEncabezados[$i]} Descendente' title='Ordenado por {$arrListaEncabezados[$i]} Descendente' align='absmiddle' />";
		}
		$sCadena .= "</th>\r\n";
	}
  
	///Opciones de Mod. y Elim.
	$sCadena .="</tr>";
    echo $sCadena;

	$CantMostrados = 0;
	$total_importe = 0;
	foreach ($result as $rs )
	{
		
	    $sub_query = " WHERE Empleados.id = {$rs['idEmpleado']}";
		$empleado = $oMysql->consultaSel("CALL usp_getEmpleados(\"$sub_query\");",true);
		
		if(!$empleado){
			$nombre_empleado = "-";
		}else{
			$empleado = array_shift($empleado);
			$nombre_empleado = $empleado['sApellido'] . ", " . $empleado['sNombre'];
		}
		
		//var_export($empleado);die();
		
		$sBotonera = '';	
		$CantMostrados ++;
		$PK = $rs['id'];
		$sClase='';
		switch ($rs['sEstado']){			
			case 'B': $sClase="class='rojo'"; break;//estado Baja			
		}
	
		$sUsuario = $rs['sApellido'].', '.$rs['sNombre'];
		$optionEditar = 0;
		$total_importe = $total_importe + $rs['fImporte'];
		
		
		
		
		?>														
		<tr id="Ajuste<?php echo $PK;?>">
			<!-- Valores -->
			<td width="" align="left" <?php echo $sClase;?>>&nbsp;<?=$nombre_empleado;?></td>
			<td width="" align="center" <?php echo $sClase;?>>&nbsp;<?=$rs['dFechaCobranza'];?></td>
			<td width="" align="center" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumeroCuenta'];?></td>
			<td width="" align="left" <?php echo $sClase;?>>&nbsp;<?=$sUsuario;?></td>
			<td width="" align="right" <?php echo $sClase;?>>&nbsp;<?=$rs['fImporte'];?></td>			
			<!-- Links para Mod. y Elim. -->
		</tr>
		<?
	}
	?>
	</tr>		
		<tr id="Ajuste_total">
			<!-- Valores -->
			<td width="" colspan="4" align="right">TOTAL</td>
			<td width="" align="right">&nbsp;<?=$total_importe;?></td>			
			<!-- Links para Mod. y Elim. -->
		</tr>
		
	</table>
	<!--<div style='font-size:10px;text-align:left;width:80%'>
		<span class='rojo'>Rojo-Solicitudes Rechazas. <span><br><span class='naranja'>Naranja-Solicitudes Anuladas <span><br><span class='azul'>Azul-Solicitudes de Alta<span>
	</div>-->
	</center>
	<!--</form>-->
	</div>
	<!-- Paginacion -->
	<?
	if (ceil($CantRegFiltro/$RegPorPag) > 1){
		echo "<p>P&aacute;gina $Pagina. Mostrando $CantMostrados de $CantRegFiltro $NombreTipoRegistroPlu.</p>\r\n";
	
		echo "<p>";
		if ($Pagina > 1) echo "<a href=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}&Pagina=". ($Pagina-1) ."\">Anterior</a>";
		if ($Pagina > 1 && $Pagina<ceil($CantRegFiltro/$RegPorPag)) echo " - ";
	
		if ($Pagina<ceil($CantRegFiltro/$RegPorPag)) echo "<a href=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}&Pagina=". ($Pagina+1) ."\">Siguiente</a>";
	
		echo " | P&aacute;ginas: ";
		$strPaginas = '';
		
		for($i=1;$i<=ceil($CantRegFiltro/$RegPorPag);$i++){
			if ($i == $Pagina) $strPaginas .= "<b>";
			else $strPaginas .= "<a href=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}&Pagina=". $i ."&nombre_u=".$nombre_u."&condic=".$condic1."\">";
			$strPaginas .= $i;
			if ($i == $Pagina) $strPaginas .= "</b> - ";
			else $strPaginas .= "</a> - ";
		}
		echo substr($strPaginas, 0, strlen($strPaginas) - 3);
	}
}


?>
<script>

	function _printReporteCobranzas(){
		document.getElementById('impresiones').innerHTML = document.getElementById('div_cobranzas').innerHTML;
		window.print();
	}	

</script>
</div>
<?php
	echo xhtmlFootPagina();
?>