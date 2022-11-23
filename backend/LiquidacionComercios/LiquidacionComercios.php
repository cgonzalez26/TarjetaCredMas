<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();

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

	$NombreMod = 'Comercios'; // Nombre del modulo
	$NombreTipoRegistro = 'Comercio';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Comercios'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array
						(
							'Comercios.sNumero', 
							'Comercios.sNombreFantasia', 
						 );
	$arrListaEncabezados = array
						(							
							'Numero',
							'Nombre Fantasia',
							'Razon Social',
						);
								
	$Tabla = 'Comercios'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'Comercios.dFechaAlta'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	$BuscarRango =0;
	
	if(isset($_POST['buscarRango']))
	{
		//echo "numero " + $_POST['sNumeroDesde'];
		if($_POST['sNumeroDesde'] != "" && ($_POST['sNumeroDesde'] != "__/__/____"))
		{			
			$conditions[] = " CONVERT(Comercios.sNumero,UNSIGNED) >= CONVERT('".$_POST['sNumeroDesde']."', UNSIGNED)";
			//$conditions[] = "Comercios.sNumero BETWEEN '".$_POST['sNumeroDesde']. "' AND '".$_POST['sNumeroHasta'] . "'";
			$BuscarRango =1;
		}
		
		if($_POST['sNumeroHasta'] != "" && ($_POST['sNumeroHasta'] != "__/__/____"))
		{			
			$conditions[] = " CONVERT(Comercios.sNumero,UNSIGNED) <= CONVERT('".$_POST['sNumeroHasta']."', UNSIGNED)";
			//$conditions[] = "Comercios.sNumero BETWEEN '".$_POST['sNumeroDesde']. "' AND '".$_POST['sNumeroHasta'] . "'";
			$BuscarRango =1;
		}		
		
		/*if($_POST['sNumeroHasta'] != "" && ($_POST['sNumeroHasta'] != "__/__/____"))
		{			
			$conditions[] = "Comercios.sNumero <= '".dateToMySql($_POST['sNumeroHasta'])."'";
		}*/	
	}
		
	if(isset($_POST['buscar']) && $BuscarRango == 0)
	{					
		if($_POST['sNumeroComercio'] != ""){
			$conditions[] = "Comercios.sNumero = '{$_POST['sNumeroComercio']}'";	
		}
		
		
		if($_POST['sNombreFantasia'] != ""){
			$conditions[] = "Comercios.sNombreFantasia LIKE '%{$_POST['sNombreFantasia']}%'";	
		}		
		
		
		session_add_var('ac_numero',$_POST['sNumeroComercio']);
		session_add_var('ac_nombre_fantasia',$_POST['sNombreFantasia']);
		
		session_add_var('pagging_ac',0);//reset to pagging
		
		$configure['sNumeroComercio'] 	= $_POST['sNumeroComercio'];
		$configure['sNombreFantasia'] 	= $_POST['sNombreFantasia'];

		
		$condic = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; //variable que se usa en la paginacion 

		if(!session_is_registered('sNumero'))
		{
			session_register('sNumeroComercio');
			session_register('sNombreFantasia');
		}
		
		$_SESSION['sNumeroComercio'] = $_POST['sNumeroComercio'];
		$_SESSION['sNombreFantasia'] = $_POST['sNombreFantasia'];

		unset($_SESSION['volver']);
	}
	/*else
	{
		$sNumero 		 = session_get_var('ac_numero');
		$sNombreFantasia = session_get_var('ac_nombre_fantasia');
		
		$conditions[] = "1 = 1"; 
		
		if($sNumero != ""){
			$conditions[] = "Comercios.sNumero = '$sNumero'";	
		}
		
		if($sNombreFantasia != ""){
			$conditions[] = "Comercios.sNombreFantasia LIKE '%$sNombreFantasia'";	
		}
		
		$configure['sNumeroComercio'] 	= $sNumero;
		$configure['sNombreFantasia'] 	= $sNombreFantasia;	
	}*/

	
	$sWhere = "";
	$aCond=Array();
		
	$sCondiciones= " WHERE ".implode(' AND ',$conditions)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$conditions)."  ORDER BY $CampoOrden $TipoOrden";
				
	$sqlDatos="Call usp_getComercios(\"$sCondiciones\");";
	$sqlDatos_sLim="Call usp_getComercios(\"$sCondiciones_sLim\");";
	
	//var_export($sqlDatos);
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);

	//$aParametros['optionsTipoDoc'] = $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre');
	$xajax = new xajax();
	//$xajax->registerFunction("liquidarComercios_");
	$xajax->registerFunction("_proccessLiquidacionesComercios");
	$xajax->processRequest();
	$xajax->printJavascript("../includes/xajax/");	
	
	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";	
?>
<body style="background-color:#FFFFFF;">
	<center>
<?php 

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorLiquidacionComercio.tpl",$aParametros);	
?>


<?php
if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result){	

  $sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p>
	<form id='formLiquidacionComercios' action='' method='POST' >
		<center>
  		<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='90%' id='tableLiquidacionComercios' name='tableLiquidacionComercios'>
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
		$sCadena .= "<a href=\"{$_SERVER['PHP_SELF']}?CampoOrden={$arrListaCampos[$i]}&TipoOrden={$NuevoTipoOrden}\">{$arrListaEncabezados[$i]}";
		if($CampoOrden == $arrListaCampos[$i]){
			if ($TipoOrden == 'ASC') 
				$sCadena .= "<img src='../includes/images/go-up.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendente' title='Ordenado por {$arrListaEncabezados[$i]} Ascendente'/></a>"; 
			else 
				$sCadena .= "<img src='../includes/images/go-down.png' alt='Ordenado por {$arrListaEncabezados[$i]} Descendente' title='Ordenado por {$arrListaEncabezados[$i]} Descendente'/></a>";
		}
		$sCadena .= "</th>\r\n";
	}
  
	///Opciones de Mod. y Elim.
	$sCadena .=
	"<th style='cursor:pointer;'><input type='checkbox' onchange='tildar_checkboxs( this.checked )' id='checkbox_principal' /> </th>
	</tr>";
	
				
	
    echo $sCadena;

	$CantMostrados = 0;
	foreach ($result as $rs )
	{			
		$sBotonera = '';	
		$CantMostrados ++;
		$PK = $rs['id'];
		$sClase='';
		switch ($rs['sEstado']){			
			case 'B': $sClase="class='rojo'"; break;//estado Baja			
		}
	
		$sUsuario = $rs['sApellido'].', '.$rs['sNombre'];
		$optionEditar = 0;
		
		/*if($rs['sEstado'] == 'B')
		{
			$sBotonera='&nbsp;';
		}else{
			
			$oBtn = new aToolBar();
			$oBtn->setAnchoBotonera('auto');			
			$sBotonera='&nbsp;';
			
			$oBtn->addBoton("Cuotas{$rs['id']}","onclick","displayWindow('CuotasComercio.php?idAjusteComercio=".$rs['id']."',450,500)",'Cuotas','Cuotas',true,true);		
			
			$oBtn->addBoton("Editar{$rs['id']}","onclick","editar({$rs['id']})",'Editar','Editar',true,true);				
			$oBtn->addBoton("Eliminar{$rs['id']}","onclick","eliminar({$rs['id']})",'Eliminar','Eliminar',true,true);							
			
				
			$sBotonera = $oBtn->getBotoneraToolBar('');		
		}*/
		
		?>
		<br>
		<tr id="Ajuste<?php echo $PK;?>">
			<!-- Valores -->
			<td width="40%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumero'];?></td>
			<td width="40%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNombreFantasia'];?></td>
			<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sRazonSocial'];?></td>
			<td align="center"><input type='checkbox' id='aComercios[]' name='aComercios[]' class="check_user" value='<?php echo $PK;?>'/> </td>
		</tr>
		<?
	}
	?>
	</tr>
	</table>
	<br> 
	<br>
	<table  class='formulario' style="width:300px">
		<tr>
			<th  colspan="2" class="cabecera"> Liquidar </th> 
		</tr>
		<tr>
			<td  align="right">Fecha Tope de Consumos :</td>
			<td>
				<input type="text" id="txtFechaTopeConsumos" name="txtFechaTopeConsumos" value="<? echo date('d/m/Y') ?>" style="width:80px"/>
			</td>
		</tr>
		<tr>
			<td align="right">Fecha de Liquidacion :</td>
			<td>
				<input type="text" id="txtFechaLiquidacion" name="txtFechaLiquidacion"  value="<? echo date('d/m/Y') ?>" style="width:80px"/>
			</td>
		</tr>	
		<tr>
			<td colspan="2" align="right" height="20px">
				<button type="button" name='btnLiquidar' style="width:100%" onclick="liquidarComercios();"> Liquidar </button>
			</td>
		</tr>	
	</table>
	</center>
	</form>
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

	InputMask('txtFechaTopeConsumos','99/99/9999');
	InputMask('txtFechaLiquidacion','99/99/9999');
	

	_messageBox = new DHTML_modalMessage();
	_messageBox.setShadowOffset(5);	
	
	function displayWindow(url_,ancho,alto) 
	{			
			_messageBox.setSource(url_);
			_messageBox.setCssClassMessageBox(false);
			_messageBox.setSize(ancho,alto);
			_messageBox.setShadowDivVisible(true);//Enable shadow for these boxes
			_messageBox.display();
	}
	
	function _closeWindow() { 
			//resetJsCache();
			_messageBox.close();	
	}	
	
	
	
	
	/*function eliminar(idAjusteComercio)
	{
		if(confirm("¿Desea eliminar el elemento seleccionado?"))
		{
			xajax_updateEstadoAjusteComercio(idAjusteComercio,'B');
		}
	}*/
	

	
	function liquidarComercios()
	{
		  var mensaje="¿Esta seguro de realizar la operacion?"; 
		  var el = document.getElementById('tableLiquidacionComercios');
		  var imputs= el.getElementsByTagName('input');
		  var band=0;
		  		  
		  for (var i=0; i<imputs.length; i++) 
		  {			
		    if (imputs[i].type=='checkbox')	
		    { 		    	
		    	if(!imputs[i].checked) 
		     	{
		         	band=0; 
		     	}
		     	else
		     	{ 
		     		band=1; break;
		     	}
		    }	
		  }
		  	
		  if(band==1)
		  {
		  	 if(confirm(mensaje))
		  	 {
		  		//xajax_liquidarComercios_(xajax.getFormValues('formLiquidacionComercios'));
		  		xajax__proccessLiquidacionesComercios(xajax.getFormValues('formLiquidacionComercios'));
		  	  }
		  }
		  else alert('Debe Elegir al menos un elemento.');	   
	}
</script>

<?php echo xhtmlFootPagina();?>