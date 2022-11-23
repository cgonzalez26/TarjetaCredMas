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

	$NombreMod = 'Tipos Planes'; // Nombre del modulo
	$NombreTipoRegistro = 'Tipo Plan';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Tipos Planes'; // Nombre tipo de registros en Plural
	$Masculino = true;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('TiposPlanes.sNombre','TiposPlanes.sAutorizable','TiposPlanes.iFinanciable', 'TiposPlanes.sEstado');
	$arrListaEncabezados = array('Tipo Plan','Autorizable','Financiable','Estado');
	$Tabla = 'TiposPlanes'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'TiposPlanes.sNombre'; // Campo de orden predeterminado
	$TipoOrdenPre = 'ASC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
		
	if(isset($_POST['buscar'])){

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
	}

	$sWhere = "";
	$aCond=Array();
	
	$aCond[]=" TiposPlanes.sEstado = 'A'";
	
	if($sNombre){
		$aCond[]=" TiposPlanes.sNombre LIKE '$sNombre%' ";
	}
	 
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
	
	$sqlDatos="Call usp_getTiposPlanes(\"$sCondiciones\");";
	//var_export($sqlDatos);die();
	$sqlDatos_sLim="Call usp_getTiposPlanes(\"$sCondiciones_sLim\");";
	
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);
	
	$oXajax=new xajax();
	
	//$oXajax->configure('debug',true);
	
	$oXajax->register( XAJAX_FUNCTION ,"eliminarTiposPlanes");
	$oXajax->register( XAJAX_FUNCTION ,"activarTiposPlanes");
	
	$oXajax->processRequest();
	
	$oXajax->printJavascript("../includes/xajax/");
	
	//$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
	$aParametros['FORM'] = "TiposPlanes.php";
?>
<body style="background-color:#FFFFFF;">
<center>

<div style="width:600px;">
	<div id='' style='width:600px;text-align:right;'>
		<a href="Comercios.php" style='text-decoration:none;font-weight:bold;'>
			<img src='<? echo IMAGES_DIR; ?>/back.png' title='Regresar' alt='Regresar' border='0' hspace='4' align='absmiddle'> Volver
		</a>
	</div>
</div>
<br />
<center>
	
<?php 

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorTiposPlanes.tpl",$aParametros);
?>
<center>
<p><img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo"> <a href="AdminTiposPlanes.php?_op=<? echo _encode('new'); ?>"><? if($Masculino) echo 'Nuevo '; else echo 'Nueva '; echo $NombreTipoRegistro;?></a></p>

<?
if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result){	

  $sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p>
	<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='600' >
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

			//$oBtn->addBoton("tiposplanes_wiew_{$idcomercio}","onclick","fichaTiposPlanes('$idcomercio')",'search24','Mostrar',true,true);

			$oBtn->addBoton("tiposplanes_act_{$idcomercio}","onclick","activarTiposPlanes('$idcomercio','{$rs['sNombre']}')",'Actualizar','Activar',true,true);

		}else{
			
			
			
			$oBtn->addBoton("tiposplanes_edi_{$idcomercio}","onclick","editarTiposPlanes('$idcomercio')",'editar24','Editar',true,true);		
			
			$oBtn->addBoton("tiposplanes_del_{$idcomercio}","onclick","eliminarTiposPlanes('$idcomercio','{$rs['sNombre']}')",'delete24','Eliminar',true,true);		
		}

		$sBotonera = $oBtn->getBotoneraToolBar('');		

		?>
		<tr id="row_comercio_<?php echo $PK;?>" class="">
			<!-- row -->
			<td width="200" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNombre'];?></td>
			<td width="140" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sAutorizable'];?></td>
			<td width="140" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['iFinanciable'];?></td>	
			<td width="70" align="center" <?php echo $sClase;?>>&nbsp;<?=$rs['sEstado'];?></td>	
			<!-- Links para Mod. y Elim. -->
			<td colspan="2" align="left" width="50">
				<?=$sBotonera;?>
			</td>
			<td align="center" width="5%"><input type='checkbox' id='aTiposPlanes[]' name='aTiposPlanes[]' class="check_tiposplanes" value='<?php echo $PK;?>'/> </td>
						
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

	function editarTiposPlanes(_i){
		window.location ="AdminTiposPlanes.php?_i="+ _i +"&_op=<?php echo _encode('edit');?>";
	}

	function eliminarTiposPlanes(_i,_tipo_plan_){
		if(confirm("Esta seguro de eliminar el Tipo Plan: '"+ _tipo_plan_ +"' ?")){
			xajax_eliminarTiposPlanes(_i);
		}
	}
	
	function fichaTiposPlanes(_i){
		window.location ="AdminTiposPlanes.php?_i="+ _i +"&_op=<?php echo _encode('wiew');?>";
	}
	
	function activarTiposPlanes(_i,_tipo_plan_){
		if(confirm("Esta seguro de activar el Tipo Plan: '"+ _tipo_plan_ +"' ?")){
			xajax_activarTiposPlanes(_i);
		}
	}
	
	function mostrarTiposPlanes(_i){
		window.location ="TiposPlanes.php?_i="+ _i ;
	}

</script>