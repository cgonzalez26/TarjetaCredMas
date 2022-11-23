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

	$NombreMod = 'Canales'; // Nombre del modulo
	$NombreTipoRegistro = 'Canal';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Canales'; // Nombre tipo de registros en Plural
	$Masculino = true;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('Canales.sCodigo','Canales.sNombre');
	$arrListaEncabezados = array('Codigo','Canal de Venta');
	$Tabla = 'Canales'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'Canales.sCodigo'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
	//echo $_POST['sNombre'];	
	if(isset($_POST['buscar']))
	{	
		$sCodigo = $_POST['sCodigo'];
		$sNombre = $_POST['sNombre'];
		$condic = $_POST['condic']; // variable para manejar las condiciones

		//echo "Nombre ". $_POST['nombre_u'];
		if(!session_is_registered('sCodigo'))
		{
			session_register('sCodigo');
			session_register('sNombre');
		}
		$_SESSION['sCodigo'] = $_POST['sCodigo'];
		$_SESSION['sNombre'] = $_POST['sNombre'];
		$_SESSION['scondic'] = $_POST['condic'];
		unset($_SESSION['volver']);
	}
	else
	{
		$sCodigo = $_SESSION['sCodigo'];
		$sNombre = $_SESSION['sNombre'];
		$condic = $_SESSION['scondic'];	
	}

	$sWhere = "";
	$aCond=Array();
	
	if($sCodigo){$aCond[]=" Canales.sCodigo LIKE '%$sCodigo%' ";}
	if($sNombre){$aCond[]=" Canales.sNombre LIKE '%$sNombre%' ";}
	 
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
	
	$sqlDatos="Call usp_getCanales(\"$sCondiciones\");";
	$sqlDatos_sLim="Call usp_getCanales(\"$sCondiciones_sLim\");";
	
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);
	
	$oXajax=new xajax();
	
	$oXajax->registerFunction("updateEstadoCanal");
	$oXajax->registerFunction("updateDatosCanal");
	$oXajax->registerFunction("habilitarCanales");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	//$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
?>
<body style="background-color:#FFFFFF;">

	
<?php 
echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorCanales.tpl",$aParametros);
?>
<p><img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo"> <a href="AdminCanales.php?action=new"><? if($Masculino) echo 'Nuevo '; else echo 'Nueva '; echo $NombreTipoRegistro;?></a></p>

<?
if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result){	

  $sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p>
	<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='60%' id='tablaCanales'>
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
	$sCadena .="<th colspan='2'>Acciones</th>
		<th style='cursor:pointer;width:20px'><input type='checkbox' onchange='tildar_checkboxs( this.checked )' id='checkbox_principal' /> </th>
		</tr>";
    echo $sCadena;

	$CantMostrados = 0;
	foreach ($result as $rs ){
		$sBotonera = '';	
		$CantMostrados ++;
		$PK = $rs['id'];
		$sClase='';
		switch ($rs['sEstado']){
			case 'S': $sClase="class='naranja'"; break;//estado Suspendido
			case 'B': $sClase="class='rojo'"; break;//estado Baja
			case 'U': $sClase="class='azul'"; break;//estado cambio de Clave
		}
	
		$sUsuario = $rs['sApellido'].', '.$rs['sNombre'];
		$optionEditar = 0;
		if($rs['sEstado'] == 'B'){
			$sBotonera='&nbsp;';
		}else{
			
			$oBtn = new aToolBar();
			$oBtn->setAnchoBotonera('auto');			
			
			if($rs['sEstado'] == 'B'){ //Dada de Alta
				$oBtn->addBoton("Modificar{$rs['id']}","onclick","editarCanales({$rs['id']},2)",'Buscar16','Visualizar',true,true);	
			}		
			if($rs['sEstado'] == 'A'){ //Pendiente de Aprobacion
				$oBtn->addBoton("Modificar{$rs['id']}","onclick","editarCanales({$rs['id']},1)",'Editar','Modificar',true,true);	
				$oBtn->addBoton("Eliminar{$rs['id']}","onclick","eliminarCanal({$rs['id']})",'Eliminar','Eliminar',true,true);	
			}
				
			$sBotonera = $oBtn->getBotoneraToolBar('');		
		}
		?>
		<tr id="empleado<?php echo $PK;?>">
			<!-- Valores -->
			<td width="10%" align="center" <?php echo $sClase;?>>&nbsp;<?=$rs['sCodigo'];?></td>
			<td width="25%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNombre'];?></td>
			<!-- Links para Mod. y Elim. -->
			<td colspan="2" align="center" width="5%">
				<?=$sBotonera;?>
			</td>
			<td align="center" width="2%"><input type='checkbox' id='aCanales[]' name='aCanales[]' class="check_user" value='<?php echo $PK;?>'/> </td>
			
		</tr>
		<?
	}
	?>
	</tr>
	<tr>
	   <td colspan="5" align="right">
	   	   <div> 
	   	    	<button type="button" onclick="Habilitar();"> Habilitar </button> &nbsp;
	   	   </div>
	   </td>
	</tr> 
	</table>
	<div style='font-size:10px;text-align:left;width:60%'>
		<span class='rojo'>Rojo - Canales de Ventas de Baja. <span><br>
	</div>	

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

	function editarCanales(idCanal){
		window.location ="AdminCanales.php?id="+ idCanal;
	}
	
	function eliminarCanal(idCanal){
		if(confirm("¿Desea dar de Baja el Canal?")){
			xajax_updateEstadoCanal(idCanal,'B');
		}
	}
	
	function anularSolicitud(idSolicitud){
		top.getBoxCambiarEstadoSolicitud(idSolicitud,4);
	}

	function Habilitar()
	{
		  var mensaje="¿Esta seguro que desea Habilitar los Canales seleccionados?"; 
		  var el = document.getElementById('tablaCanales');
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
		       xajax_habilitarCanales(xajax.getFormValues('tablaCanales'));
		  }
		  else alert('Debe Elegir al menos un Canal a habilitar.');	   
	}


</script>
