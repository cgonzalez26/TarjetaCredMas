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
	$Masculino = true;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('Comercios.sNumero','Comercios.sApellido','Comercios.sRazonSocial', 'Comercios.sNombreFantasia','Comercios.sCUIT','Comercios.sEstado');
	$arrListaEncabezados = array('Nro. Comercio','Responsable','Razon Social','Nombre Fantasia','CUIT','Estado');
	$Tabla = 'Comercios'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'Comercios.sNumero'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
		
	if(isset($_POST['buscar'])){

		$sNumero = $_POST['sNumero'];
		$sRazonSocial = $_POST['sRazonSocial'];
		$sNombreFantasia = $_POST['sNombreFantasia'];

		$condic = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; //variable que se usa en la paginacion 

		if(!session_is_registered('sNumero'))
		{
			session_register('sNumero');
			session_register('sRazonSocial');
			session_register('sNombreFantasia');

			session_register('scondic');
		}

		$_SESSION['sNumero'] 			= $_POST['sNumero'];
		$_SESSION['sRazonSocial'] 		= $_POST['sRazonSocial'];		
		$_SESSION['sNombreFantasia'] 	= $_POST['sNombreFantasia'];

		$_SESSION['scondic'] 			= $_POST['condic'];

		unset($_SESSION['volver']);
	}
	else
	{
		$sNumero 			= $_SESSION['sNumero'];
		$sRazonSocial 		= $_SESSION['sRazonSocial'];
		$sNombreFantasia 	= $_SESSION['sNombreFantasia'];
		
		$condic 			= $_SESSION['scondic'];	
		$condic1 			= $_SESSION['scondic'];	
	}

	$sWhere = "";
	$aCond=Array();
	
	if($sNumero){
		$aCond[]=" Comercios.sNumero = '$sNumero' ";
	}
	
	if($sRazonSocial){
		$aCond[]=" Comercios.sRazonSocial LIKE '$sRazonSocial%' ";
	}
	
	if($sNombreFantasia){
		$aCond[]=" Comercios.sNombreFantasia LIKE '$sNombreFantasia%' ";
	}

	 
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
	
	$sqlDatos="Call usp_getComercios(\"$sCondiciones\");";
	
	$sqlDatos_sLim="Call usp_getComercios(\"$sCondiciones_sLim\");";
	
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);
	
	$oXajax=new xajax();
	
	//$oXajax->configure('debug',true);
	
	$oXajax->register( XAJAX_FUNCTION ,"eliminarComercio");
	$oXajax->register( XAJAX_FUNCTION ,"activarComercio");
	
	//$oXajax->registerFunction("eliminarComercio");
	//$oXajax->registerFunction("activarComercio");
	
	$oXajax->processRequest();
	
	$oXajax->printJavascript("../includes/xajax/");
	
	//$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
	$aParametros['FORM'] = "Comercios.php";
	
	
?>
<body style="background-color:#FFFFFF;">

	
<?php 

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorComercios.tpl",$aParametros);
?>
<center>
<p>
	<img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo"> 
	<a href="AdminComercios.php?_op=<? echo _encode('new'); ?>"><? if($Masculino) echo 'Nuevo '; else echo 'Nueva '; echo $NombreTipoRegistro;?></a>
</p>
<p>
	<img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo"> 
	<a href="TiposPlanes.php">administrar tipos planes</a>
</p>
<?
if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result){	

  $sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p>
	<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='60%' >
		<tr class='filaPrincipal'>
		<!-- Lista de encabezados de columna -->";
	
  	$CantEncabezados = count($arrListaEncabezados);
	for($i=0; $i<$CantEncabezados; $i++){
		$sCadena .= "<th style='height:25px'>";
		if($CampoOrden == $arrListaCampos[$i]){
		
			if ($TipoOrden == 'ASC') $NuevoTipoOrden = 'DESC'; else $NuevoTipoOrden = 'ASC';
		}
		else $NuevoTipoOrden = 'ASC';
		
		$sCadena .= "<a href=\"{$_SERVER['PHP_SELF']}?CampoOrden={$arrListaCampos[$i]}&TipoOrden={$NuevoTipoOrden}\">{$arrListaEncabezados[$i]}";
		if($CampoOrden == $arrListaCampos[$i]){
			if ($TipoOrden == 'ASC') 
				$sCadena .= "<img src='../includes/images/go-up.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendenrte' title='Ordenado por {$arrListaEncabezados[$i]} Ascendenrte'/></a>"; 
			else 
				$sCadena .= "<img src='../includes/images/go-down.png' alt='Ordenado por {$arrListaEncabezados[$i]} Descendente' title='Ordenado por {$arrListaEncabezados[$i]} Descendente'/></a>";
		}
		$sCadena .= "</th>\r\n";
	}
  
	///Opciones de Mod. y Elim.
	$sCadena .="<th colspan='2'>Acciones</th>
		<th style='cursor:pointer;'><input type='checkbox' onchange='tildar_checkboxs( this.checked )' id='checkbox_principal' /> </th>
		</tr>";
    echo $sCadena;

	$CantMostrados = 0;
	foreach ($result as $rs ){
		$sBotonera = '';	
		$CantMostrados ++;
		$PK = _encode($rs['id']);
		$sClase='';
		switch ($rs['sEstado']){
			case 'S': $sClase="class='naranja'"; break;//estado Suspendido
			case 'B': $sClase="class='rojo'"; break;//estado Baja
			case 'U': $sClase="class='azul'"; break;//estado cambio de Clave
		}
		
		$idcomercio = _encode($rs['id']);
			
		$oBtn = new aToolBar();

		$oBtn->setAnchoBotonera('auto');
		
		//$oBtn->setIdBotonera($idcomercio);
		
		if($rs['sEstado'] == "B"){
			$oBtn->addBoton("comercio_wiew_{$idcomercio}","onclick","fichaComercio('$idcomercio')",'search24','Mostrar',true,true);		
			
			$oBtn->addBoton("comercio_act_{$idcomercio}","onclick","activarComercio('$idcomercio','{$rs['sNombreFantasia']}')",'Actualizar','Activar',true,true);		
		}else{
			
			
			$oBtn->addBoton("comercio_tiposplanes_{$idcomercio}","onclick","mostrarPromociones('$idcomercio')",'promociones24','Promociones',true,true);
			
			$oBtn->addBoton("comercio_tiposplanes_{$idcomercio}","onclick","mostrarPlanes('$idcomercio')",'tiposplanes24','Planes',true,true);
			
			$oBtn->addBoton("comercio_edi_{$idcomercio}","onclick","editarComercio('$idcomercio')",'editar24','Editar',true,true);		
			
			$oBtn->addBoton("comercio_del_{$idcomercio}","onclick","eliminarComercio('$idcomercio','{$rs['sNombreFantasia']}')",'delete24','Eliminar',true,true);		
		}

		$sBotonera = $oBtn->getBotoneraToolBar('');		

		?>
		<tr id="row_comercio_<?php echo $PK;?>" class="">
			<!-- row -->
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumero'];?></td>
			<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sApellido'];?>, <?=$rs['sNombre'];?></td>
			<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sRazonSocial'];?></td>
			<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNombreFantasia'];?></td>	
			<td width="10%" align="center" <?php echo $sClase;?>>&nbsp;<?=$rs['sCUIT'];?></td>	
			<td width="10%" align="center" <?php echo $sClase;?>>&nbsp;<?=$rs['sEstado'];?></td>	
			<!-- Links para Mod. y Elim. -->
			<td colspan="2" align="left" width="5%">
				<?=$sBotonera;?>
			</td>
			<td align="center" width="5%"><input type='checkbox' id='aComercio[]' name='aComercio[]' class="check_comercio" value='<?php echo $PK;?>'/> </td>
						
		</tr>
		<?
	}
	?>
	</table>

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

	function editarComercio(_i){
		window.location ="AdminComercios.php?_i="+ _i +"&_op=<?php echo _encode('edit');?>";
	}

	function eliminarComercio(_i,_comercio_){
		if(confirm("Esta seguro de eliminar el comercio: '"+ _comercio_ +"' ?")){
			xajax_eliminarComercio(_i);
		}
	}
	
	function fichaComercio(_i){
		window.location ="AdminComercios.php?_i="+ _i +"&_op=<?php echo _encode('wiew');?>";
	}
	
	function activarComercio(_i,_comercio_){
		if(confirm("Esta seguro de activar el comercio: '"+ _comercio_ +"' ?")){
			xajax_activarComercio(_i);
		}
	}
	
	function mostrarTiposPlanesComercio(_i){
		window.location ="TiposPlanes.php?_i="+ _i ;
	}
	
	function mostrarPlanes(_i){
		window.location ="Planes.php?_i=" + _i;
	}
	
	function mostrarPromociones(_i){
		window.location ="PromocionesPlanes.php?_i=" + _i;
	}

</script>