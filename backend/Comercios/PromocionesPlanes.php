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

	$NombreMod = 'Promociones'; // Nombre del modulo
	$NombreTipoRegistro = 'Promocion';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Promociones'; // Nombre tipo de registros en Plural
	$Masculino = true;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('TiposPlanes.sNombre','PromocionesPlanes.sNombre','PromocionesPlanes.dVigenciDesde', 'PromocionesPlanes.dVigenciaHasta', 'PromocionesPlanes.iCantidadCuota','PromocionesPlanes.sEstado');
	$arrListaEncabezados = array('Tipo Plan','Promocion','Vigencia Desde','Vigencia Hasta','Cuota','Estado');
	$Tabla = 'PromocionesPlanes'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'PromocionesPlanes.sNombre'; // Campo de orden predeterminado
	$TipoOrdenPre = 'ASC';	// Tipo de orden predeterminado
	$RegPorPag = 50; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
		
	/*if(isset($_POST['buscar'])){

		$sNombre = $_POST['sNombre'];

		$condic = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; //variable que se usa en la paginacion 

		if(!session_is_registered('sNombre'))
		{
			session_register('sNombre');

			session_register('scondic');
		}

		$_SESSION['sNombre'] 			= $_POST['sNombre'];

		$_SESSION['scondic'] 			= $_POST['condic'];

		unset($_SESSION['volver']);
	}
	else
	{
		$sNombre 			= $_SESSION['sNombre'];
		
		$condic 			= $_SESSION['scondic'];	
		$condic1 			= $_SESSION['scondic'];	
	}*/

	$sWhere = "";
	$aCond=Array();
	
	//if($sNombre){
		//$aCond[]=" Planes.sNombre LIKE '$sNombre%' ";
		$idcomercio = intval(_decode($_GET['_i']));
		//var_export($idcomercio);die();
		$aCond[]=" PromocionesPlanes.idComercio = '$idcomercio' ";
		
		$idcomercio = _encode($idcomercio);
	//}

	 
	//$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
	
	//$sqlDatos="Call usp_getPlanes(\"$sCondiciones\");";
	
	$sqlDatos_sLim="Call usp_getPromocionesPlanes(\"$sCondiciones_sLim\");";
	//var_export($sqlDatos_sLim);die();
	// Cuento la cantidad de registros sin LIMIT
	//$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	//$result = $oMysql->consultaSel($sqlDatos);
	$result = $oMysql->consultaSel($sqlDatos_sLim);
	
	//$CantRegFiltro = sizeof($result_sLim);
	$CantRegFiltro = sizeof($result);
	
	$oXajax=new xajax();

	//$oXajax->configure('debug',true);
	
	$oXajax->register( XAJAX_FUNCTION ,"eliminarPromocionesPlanes");
	$oXajax->register( XAJAX_FUNCTION ,"activarPromocionesPlanes");
	
	//$oXajax->registerFunction("eliminarComercio");
	//$oXajax->registerFunction("activarComercio");
	
	$oXajax->processRequest();
	
	$oXajax->printJavascript("../includes/xajax/");
	
	//$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
	$aParametros['FORM'] = "PromocionesPlanes.php";

	

?>
<body style="background-color:#FFFFFF;">

<center>
	<div style="width:700px;text-align:right;">
		<a href="Comercios.php" style='text-decoration:none;font-weight:bold;'>
			<img src='<? echo IMAGES_DIR; ?>/back.png' title='regresar' alt='regresar' border='0' hspace='4' align='absmiddle'> Volver
		</a>
	</div>
</center>

<?php 

//echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorPlanes.tpl",$aParametros);

?>

<center>
<p><img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo"><a href="AdminPromocionesPlanes.php?_op=<? echo _encode('new'); ?>&_ic=<? echo $idcomercio; ?>"><? if($Masculino) echo 'Nuevo '; else echo 'Nueva '; echo $NombreTipoRegistro;?></a></p>

<?
if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result){	

  $sCadena .= "<p>Hay ".$CantRegFiltro." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p>
	<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='700' >
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
				$sCadena .= "<img src='../includes/images/go-up.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendente' title='Ordenado por {$arrListaEncabezados[$i]} Ascendente'/></a>"; 
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
	
	//$idplan = _encode($rs['id']);
	
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
		
		$idpromocionesplanes = _encode($rs['id']);
		
			
		$oBtn = new aToolBar();

		$oBtn->setAnchoBotonera('auto');
		
		//$oBtn->setIdBotonera($idcomercio);
		
		if($rs['sEstado'] == "B"){
			$oBtn->addBoton("PromocionesPlanes_wiew_{$idpromocionesplanes}","onclick","fichaPromocionesPlanes('$idpromocionesplanes','$idcomercio')",'search24','Mostrar',true,true);

			$oBtn->addBoton("PromocionesPlanes_act_{$idpromocionesplanes}","onclick","activarPromocionesPlanes('$idpromocionesplanes','{$rs['sNombre']}')",'Actualizar','Activar',true,true);

		}else{

			//$oBtn->addBoton("planes_planes_{$idcomercio}","onclick","mostrarPlanes('$idcomercio')",'tiposplanes24','tipos planes',true,true);

			$oBtn->addBoton("PromocionesPlanes_edi_{$idpromocionesplanes}","onclick","editarPromocionesPlanes('$idpromocionesplanes','$idcomercio')",'editar24','Editar',true,true);

			$oBtn->addBoton("PromocionesPlanes_del_{$idpromocionesplanes}","onclick","eliminarPromocionesPlanes('$idpromocionesplanes','{$rs['sNombre']}')",'delete24','Eliminar',true,true);

		}

		$sBotonera = $oBtn->getBotoneraToolBar('');		

		?>
		<tr id="row_comercio_<?php echo $PK;?>" class="">
			<!-- row -->
			<td width="190" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNombreTipoPlan'];?></td>
			<td width="190" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNombre'];?></td>
			<td width="100" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['dVigenciaDesde'];?></td>
			<td width="100" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['dVigenciaHasta'];?></td>
			<td width="80" align="center" <?php echo $sClase;?>>&nbsp;<?=$rs['iCantidadCuota'];?></td>	
			<td width="60" align="center" <?php echo $sClase;?>>&nbsp;<?=$rs['sEstado'];?></td>	
			<!-- Links para Mod. y Elim. -->
			<td colspan="2" align="left" width="50">
				<?=$sBotonera;?>
			</td>
			<td align="center" width="10"><input type='checkbox' id='aComercio[]' name='aComercio[]' class="check_comercio" value='<?php echo $PK;?>'/> </td>
						
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

	function editarPromocionesPlanes(_i,_ic){
		window.location ="AdminPromocionesPlanes.php?_i="+ _i +"&_op=<?php echo _encode('edit');?>&_ic=" + _ic;
	}

	function eliminarPromocionesPlanes(_i,_promocion_){
		if(confirm("Esta seguro de eliminar la Promocion: '"+ _promocion_ +"' ?")){
			xajax_eliminarPromocionesPlanes(_i);
		}
	}
	
	function fichaPromocionesPlanes(_i,_ic){
		window.location ="AdminPromocionesPlanes.php?_i="+ _i +"&_op=<?php echo _encode('wiew');?>&_ic=" + _ic;
	}
	
	function activarPromocionesPlanes(_i,_promocion_){
		if(confirm("Esta seguro de activar la Promocion: '"+ _promocion_ +"' ?")){
			xajax_activarPromocionesPlanes(_i);
		}
	}
	

</script>