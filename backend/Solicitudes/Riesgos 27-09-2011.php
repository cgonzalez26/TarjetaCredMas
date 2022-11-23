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

	$NombreMod = 'Solicitudes'; // Nombre del modulo
	$NombreTipoRegistro = 'Solicitud';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Solicitudes'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('SolicitudesUsuarios.sNumero','SolicitudesUsuarios.dFechaPresentacion', 'InformesPersonales.sApellido','InformesPersonales.sDocumento','InformesPersonales.idProvincia','InformesPersonales.idLocalidad','SolicitudesUsuarios.idEstado');
	$arrListaEncabezados = array('Nro. Solicitud','Fecha Presentacion','Usuario','Documento','Localidad','Estado');
	$Tabla = 'SolicitudesUsuarios'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'SolicitudesUsuarios.dFechaPresentacion'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
		
	if(isset($_POST['buscar']))
	{	
		$sNumero = $_POST['sNumero'];
		$idTipoDocumento = $_POST['idTipoDocumento'];
		$sDocumento = $_POST['sDocumento'];
		$sApellido = $_POST['sApellido'];
		$sNombre = $_POST['sNombre'];
		$condic = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; //variable que se usa en la paginacion 

		//echo "Nombre ". $_POST['nombre_u'];
		if(!session_is_registered('sNumero'))
		{
			session_register('sNumero_Cuenta');
			session_register('idTipoDocumento_Cuenta');
			session_register('sDocumento_Cuenta');
			session_register('sApellido_Cuenta');
			session_register('sNombre_Cuenta');
			session_register('scondic_Cuenta');
		}
		$_SESSION['sNumero_Cuenta'] = $_POST['sNumero_Cuenta'];
		$_SESSION['idTipoDocumento_Cuenta'] = $_POST['idTipoDocumento_Cuenta'];		
		$_SESSION['sDocumento_Cuenta'] = $_POST['sDocumento_Cuenta'];
		$_SESSION['sApellido_Cuenta'] = $_POST['sApellido_Cuenta'];
		$_SESSION['sNombre_Cuenta'] = $_POST['sNombre_Cuenta'];
		$_SESSION['scondic_Cuenta'] = $_POST['condic_Cuenta'];
		unset($_SESSION['volver']);
	}
	else
	{
		$sNumero_Cuenta = $_SESSION['sNumero_Cuenta'];
		$idTipoDocumento = $_SESSION['idTipoDocumento_Cuenta'];
		$sDocumento_Cuenta = $_SESSION['sDocumento_Cuenta'];
		$sApellido_Cuenta = $_SESSION['sApellido_Cuenta'];
		$sNombre_Cuenta = $_SESSION['sNombre_Cuenta'];
		$condic_Cuenta = $_SESSION['scondic_Cuenta'];	
	}

	$sWhere = "";
	$aCond=Array();
	
	if($sNumero){$aCond[]=" SolicitudesUsuarios.sNumero = '$sNumero' ";}
	if($idTipoDocumento){$aCond[]=" InformesPersonales.idTipoDocumento = '$idTipoDocumento' ";}
	if($sDocumento){$aCond[]=" InformesPersonales.sDocumento = '$sDocumento' ";}
	if($sApellido){$aCond[]=" InformesPersonales.sApellido LIKE '%$sApellido%' ";}
	if($sNombre){$aCond[]=" InformesPersonales.sNombre LIKE '%$sNombre%' ";}
	$aCond[]="SolicitudesUsuarios.idTipoEstado = 1";
	 
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
	//echo $sCondiciones;
	
	$sqlDatos="Call usp_getSolicitudes(\"$sCondiciones\");";
	$sqlDatos_sLim="Call usp_getSolicitudes(\"$sCondiciones_sLim\");";
	
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);

	$aParametros['optionsTipoDoc'] = $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre');
	
	$oXajax=new xajax();
	
	$oXajax->registerFunction("updateEstadoSolicitud");
	$oXajax->registerFunction("updateDatosSolicitud");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
	
	$aParametros['FORM'] = "Riesgos.php";
	$aParametros['TITULO'] = "Solicitudes de Riesgos";
	$aParametros['URL_BACK'] = "Riesgos.php";
?>
<body style="background-color:#FFFFFF;">

	
<?php 
echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorSolicitudes.tpl",$aParametros);

if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result){	

  $sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p>
	<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='90%' >
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
				$sCadena .= "<img src='../includes/images/go-up.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendenrte' title='Ordenado por {$arrListaEncabezados[$i]} Ascendenrte'/></a>"; 
			else 
				$sCadena .= "<img src='../includes/images/go-down.png' alt='Ordenado por {$arrListaEncabezados[$i]} Descendente' title='Ordenado por {$arrListaEncabezados[$i]} Descendente'/></a>";
		}
		$sCadena .= "</th>\r\n";
	}
  
	///Opciones de Mod. y Elim.
	$sCadena .="<th colspan='2'>Acciones</th>";
		/*<th style='cursor:pointer;'><input type='checkbox' onchange='tildar_checkboxs( this.checked )' id='checkbox_principal' /> </th>
		</tr>";*/
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
			if($rs['idTipoEstado'] == 1){ //Pendiente de Aprobacion
				//$oBtn->addBoton("AgregarCuenta{$rs['id']}","onclick","agregarCuenta({$rs['id']})",'Eliminar','Agregar Cuenta de Usuario',true,true);	
				$oBtn->addBoton("Modificar{$rs['id']}","onclick","editarSolicitud({$rs['id']},3)",'Editar','Modificar',true,true);	
				//$oBtn->addBoton("Anular{$rs['id']}","onclick","anularSolicitud({$rs['id']})",'Eliminar','Anular',true,true);	
				//$oBtn->addBoton("Rechazar{$rs['id']}","onclick","rechazarSolicitud({$rs['id']})",'Down','Rechazar',true,true);	
			}
			$oBtn->addBoton("Historial{$rs['id']}","onclick","historialSolicitud({$rs['id']},'{$rs['sNumero']}')",'Historial','Historial',true,true);	
				
			$sBotonera = $oBtn->getBotoneraToolBar('');		
		}
		?>
		<tr id="empleado<?php echo $PK;?>">
			<!-- Valores -->
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumero'];?></td>
			<td width="15%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['dFechaPresentacion'];?></td>
			<td width="25%" align="left" <?php echo $sClase;?>>&nbsp;<?=$sUsuario;?></td>
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sDocumento'];?></td>	
			<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sLocalidad'];?></td>	
			<td width="15%" id="estado<?php echo$rs['sNumero']?>" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sEstadoSolicitud'];?></td>	
			<!-- Links para Mod. y Elim. -->
			<td colspan="2" align="center" width="5%">
				<?=$sBotonera;?>
			</td>
			<!--<td align="center" width="5%"><input type='checkbox' id='aSolicitud[]' name='aSolicitud[]' class="check_colicitud" value=''/> </td>-->
			
		</tr>
		<?
	}
	?>
	</table>
	<!--<div style='font-size:10px;text-align:left;width:80%'>
		<span class='rojo'>Rojo-Solicitudes Rechazas. <span><br><span class='naranja'>Naranja-Solicitudes Anuladas <span><br><span class='azul'>Azul-Solicitudes de Alta<span>
	</div>-->
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

function editarSolicitud(idSolicitud,optionEditar){
	window.location ="../Solicitudes/AdminSolicitudes.php?id="+ idSolicitud+"&optionEditar="+optionEditar+"&url_back=Riesgos.php";
}

function agregarCuenta(idSolicitud){
	window.location ="../Solicitudes/AdminSolicitudes.php?id="+ idSolicitud+"&optionEditar="+optionEditar;
}

function historialSolicitud(idSolicitud,sNumero){
	top.getBoxHistorialSolicitud(idSolicitud,sNumero);
}	

</script>
