<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
        
        $idObjeto = 57;
        $arrayPermit = explode(',',$_SESSION['_PERMISOS_'][$idObjeto]['sPermisos']);	
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	
	
	
	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
		
	if ($Pagina <= 0) $Pagina = 1;

	$NombreMod = 'Ajustes'; // Nombre del modulo
	$NombreTipoRegistro = 'Ajuste';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Ajustes'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array
						(
							'CuentasUsuarios.sNumeroCuenta',
							'CuentasUsuarios.sApellido', 
							'CuentasUsuarios.sNombre', 
							'TiposAjustes.sNombre', 
							'AjustesUsuarios.fImporteTotal',
							'AjustesUsuarios.fImporteTotalInteres',
							'AjustesUsuarios.fImporteTotalIVA',
							'AjustesUsuarios.iCuotas',
							'AjustesUsuarios.dFecha'
						 );
	$arrListaEncabezados = array
							(
								'Nro. Cuenta',
								'Apellido',
								'Nombre',
								'Tipo Ajuste',
								'Importe',
								'Importe Interes',
								'Importe IVA',
								'Cuotas',
								'Fecha',
							);
								
	$Tabla = 'AjustesUsuarios'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'AjustesUsuarios.dFecha'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
		
	if(isset($_POST['buscar']))
	{	
		$sNumeroCuenta = $_POST['sNroCuenta'];
		$idTipoAjuste = $_POST['idTipoAjuste'];
		$sNombre = $_POST['sNombre'];
		$sApellido = $_POST['sApellido'];
		$dFechaDesde = $_POST['dFechaDesde'];
		$dFechaHasta = $_POST['dFechaHasta'];
		
		$condic = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; //variable que se usa en la paginacion 

	    //echo "Nombre ". $_POST['nombre_u'];
		if(!session_is_registered('sNumero'))
		{
			session_register('sNroCuenta');
			session_register('idTipoAjuste');
			session_register('sNombre');
			session_register('sApellido');
			session_register('dFechaDesde');
			session_register('dFechaHasta');
		}
		
		$_SESSION['sNroCuenta'] = $_POST['sNroCuenta'];
		$_SESSION['idTipoAjuste'] = $_POST['idTipoAjuste'];		
		$_SESSION['sNombre'] = $_POST['sNombre'];
		$_SESSION['sApellido'] = $_POST['sApellido'];
		$_SESSION['dFechaDesde '] = $_POST['dFechaHasta'];

		unset($_SESSION['volver']);
	}
	else
	{
		$sNumeroCuenta = $_SESSION['sNroCuenta'];
		$idTipoAjuste = $_SESSION['idTipoAjuste'];
		$sNombre = $_SESSION['sNombre'];
		$sApellido = $_SESSION['sApellido'];
		$dFechaDesde = $_SESSION['dFechaHasta'];
		$dFechaDesde = $_SESSION['dFechaDesde'];
	}

	$sWhere = "";
	$aCond=Array();
	
	$dFechaDesde = dateToMySql($dFechaDesde);
	$dFechaHasta = dateToMySql($dFechaHasta);
	
	if($sNumeroCuenta){$aCond[]=" CuentasUsuarios.sNumeroCuenta = '$sNumeroCuenta' ";}
	if($idTipoAjuste){$aCond[]=" TiposAjustes.id = '$idTipoAjuste' ";}
	if($sNombre){$aCond[]=" Usuarios.sNombre LIKE '%$sNombre%' ";}
	if($sApellido){$aCond[]=" Usuarios.sApellido LIKE '%$sApellido%' ";}
	if($dFechaDesde){$aCond[]=" AjustesUsuarios.dFecha >= ' $dFechaDesde '";}
	if($dFechaHasta){$aCond[]=" AjustesUsuarios.dFecha <= '$dFechaHasta' ";}
	
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
	//echo $sCondiciones;
	
	$sqlDatos="Call usp_getAjustesUsuarios(\"$sCondiciones\");";
	$sqlDatos_sLim="Call usp_getAjustesUsuarios(\"$sCondiciones_sLim\");";
	//echo $sqlDatos;
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);

	//$aParametros['optionsTipoDoc'] = $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre');
	
	$oXajax=new xajax();

	$oXajax->registerFunction("updateEstadoAjusteUsuario");
	$oXajax->registerFunction("habilitarAjustesUsuarios");
	$oXajax->registerFunction("eliminarDefinitivoObjeto");
	$oXajax->registerFunction("reactivarAjustesUsuarios");
					
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");
	
	/*$oXajax->registerFunction("updateEstadoCuentasUsuarios");
	$oXajax->registerFunction("updateDatosCuentasUsuarios");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");*/

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
?>
<body style="background-color:#FFFFFF;">

	<center>
<?php 

$aParametros['OPTIONS_TIPOS_AJUSTES'] = $oMysql->getListaOpciones('TiposAjustes','id','sNombre', $idTipoAfinidad, "sEstadoAjuste = 'A' AND sDestino = 'US'");
echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorAjustesUsuarios.tpl",$aParametros);
?>

<p><img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo"> <a href="AdminAjustesUsuarios.php?action=new">Nuevo Ajuste 
</a></p>

<?php
if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result){	

  $sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p>
	<form id='formAjustesUsuarios' action='' method='POST' >
		<center>
  		<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='90%' id='tableAjustes'>
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
		$oBtn = new aToolBar();
		$oBtn->setAnchoBotonera('auto');	
			
		if($rs['sEstado'] == 'B')
		{
			//$sBotonera='&nbsp;';
			$oBtn->addBoton("Reactivar{$rs['id']}","onclick","reactivar('{$rs['id']}')",'Reactivar','Reactivar',true,true);
		}else{
					
			$sBotonera='&nbsp;';
			
			/*<input type="button" name="advanced_search_cuenta" id="advanced_search_cuenta" value="busqueda avanzada" style="" onclick="displayWindow('BuscarUsuario.php',700,200);">*/
			
			$oBtn->addBoton("Cuotas{$rs['id']}","onclick","_createWindows('Cuotas.php?idAjuste=".$rs['id']."','Cuotas')",'Cuotas','Detalle',true,true);
				
			//$oBtn->addBoton("Cuotas{$rs['id']}","onclick","displayWindow('Cuotas.php?idAjuste=".$rs['id']."',450,500)",'Cuotas','Cuotas',true,true);			
			$oBtn->addBoton("Editar{$rs['id']}","onclick","editar({$rs['id']})",'Editar','Editar',true,true);				
			$oBtn->addBoton("Eliminar{$rs['id']}","onclick","eliminar({$rs['id']})",'Eliminar','Eliminar',true,true);							
			
		
		}
		if( in_array(ELIMINAR,$arrayPermit)) $oBtn->addBoton("EliminarDefinitivo{$rs['id']}","onclick","eliminarDefinitivo({$rs['id']})",'EliminarDefinitivo','Eliminar Definitivo',true,true);
		$sBotonera = $oBtn->getBotoneraToolBar('');
		?>
		<tr id="Ajuste<?php echo $PK;?>">
			<!-- Valores -->
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumeroCuenta'];?></td>
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sApellido'];?></td>
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNombre'];?></td>
			<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sTipoAjuste'];?></td>
			<td width="10%" align="right" <?php echo $sClase;?>>&nbsp;<?=$rs['fImporteTotal'];?></td>
			<td width="10%" align="right" <?php echo $sClase;?>>&nbsp;<?=$rs['fImporteTotalInteres'];?></td>
			<td width="10%" align="right" <?php echo $sClase;?>>&nbsp;<?=$rs['fImporteTotalIVA'];?></td>
			<td width="10%" align="right" <?php echo $sClase;?>>&nbsp;<?=$rs['iCuotas'];?></td>			
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['dFecha'];?></td>			
			<!-- Links para Mod. y Elim. -->
			<td colspan="2" align="center" width="5%">
				<?=$sBotonera;?>
			</td>
		</tr>
		<?
	}
	?>
	</tr>
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

	_messageBox = new DHTML_modalMessage();
	_messageBox.setShadowOffset(5);	
	
	/*function displayWindow(url_,ancho,alto) 
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
	}	*/
	
	var dhxWins1;
	function _createWindows(sUrl,sTitulo){
	 var idWind = "windowDetalle";
		
	    	//alert(idWind);
	     	
	    	dhxWins1 = new dhtmlXWindows();     	
		    dhxWins1.setImagePath("../includes/grillas/dhtmlxWindows/sources/imgs/");	  
		    _popup_ = dhxWins1.createWindow(idWind, 0, 0, 500, 400);
		    _popup_.setText(sTitulo);
		    _popup_.center();
		    _popup_.button("close").attachEvent("onClick", __closeWindows);
			_url_ = sUrl;
		    _popup_.attachURL(_url_);
		
	} 
	
	function __closeWindows(_x){		
		 	dhxWins1.window("windowDetalle").close(); 	
		  
	}	
	
	
	function eliminar(idAjusteUsuario)
	{
		if(confirm("¿Desea eliminar el elemento seleccionado?"))
		{
			xajax_updateEstadoAjusteUsuario(idAjusteUsuario,'B');
		}
	}
	
	/*function mostrarCuotas(idAjuste)
	{
		alert("mostrarCuotas");
		top.getBoxCuotasAjusteUsuario(idAjuste);
	}
	*/
	
	function editar(idAjuste)
	{
		window.location = "../AjustesUsuarios/AdminAjustesUsuarios.php?idAjusteUsuario="+ idAjuste+"&url_back=../AjustesUsuarios/AjustesUsuarios.php";
	}
	
	
	function Habilitar()
	{
		  var mensaje="¿Esta seguro de Habilitar los elementos seleccionados?"; 
		  var el = document.getElementById('tableAjustes');
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
		       xajax_habilitarAjustesUsuarios(xajax.getFormValues('formAjustesUsuarios'));
		  }
		  else alert('Debe Elegir al menos un elemento a habilitar.');	   
	}
	
	function eliminarDefinitivo(idAjuste){
		var msje = "Esta seguro que desea Eliminar el Ajuste de Usuario?";
		var sUrl = "AjustesUsuarios.php";
		if(confirm(msje)){
			xajax_eliminarDefinitivoObjeto(idAjuste,3,sUrl);
		}
	}
	
	function reactivar(idAjusteUsuario){
		if(confirm("Esta seguro de activar el Ajuste de Usuario?")){
			xajax_reactivarAjustesUsuarios(idAjusteUsuario);
		}
	}
</script>
