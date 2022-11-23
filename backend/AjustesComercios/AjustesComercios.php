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
							'Comercios.sRazonSocial', 
							'TiposAjustes.sNombre', 
							'AjustesUsuarios.fImporteTotal',
							'AjustesUsuarios.fImporteTotalInteres',
							'AjustesUsuarios.fImporteTotalIVA',
							'AjustesUsuarios.iCuotas',
							'AjustesUsuarios.dFecha',
							'Plan'
						 );
	$arrListaEncabezados = array
						(
							'Comercio',
							'Tipo Ajuste',
							'Importe',
							'Importe Interes',
							'Importe IVA',
							'Cuotas',
							'Fecha',
							'Plan',
						);
								
	$Tabla = 'AjustesComercios'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'AjustesComercios.dFecha'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
	if(isset($_POST['buscar']))
	{					
		if($_POST['sNumeroComercio'] != ""){
			$conditions[] = "Comercios.sNumero = '{$_POST['sNumeroComercio']}'";	
		}
		
		if($_POST['sNombreFantasia'] != ""){
			$conditions[] = "Comercios.sNombreFantasia LIKE '%{$_POST['sNombreFantasia']}%'";	
		}
		
		if($_POST['sRazonSocial'] != ""){
			$conditions[] = "Comercios.sRazonSocial LIKE '%{$_POST['sRazonSocial']}%'";	
		}
		
		
		if($_POST['idTipoAjuste'] != 0 && $_POST['idTipoAjuste'] != ""){
			$conditions[] = "TiposAjustes.idTipoUsuario = '{$_POST['idTipoAjuste']}'";
		}
		
		if($_POST['dFechaDesde'] != "" && $datos['dFechaDesde'] != "__/__/____"){			
			$conditions[] = "AjustesComercios.dFecha >= '".dateToMySql($_POST['dFechaDesde'])."'";
		}
		
		if($_POST['dFechaHasta'] != "" && $_POST['dFechaDesde'] != "__/__/____"){
			$conditions[] = "AjustesComercios.dFecha <= '".dateToMySql($_POST['dFechaHasta'])."'";
		}		
		
		
		session_add_var('ac_numero',$_POST['sNumeroComercio']);
		session_add_var('ac_nombre_fantasia',$_POST['sNombreFantasia']);
		session_add_var('ac_razon_social',$_POST['sRazonSocial']);
		session_add_var('ac_tipo_ajuste',$_POST['idTipoAjuste']);
		session_add_var('ac_fecha_desde',$_POST['dFechaDesde']);
		session_add_var('ac_fecha_hasta',$_POST['dFechaHasta']);
		
		session_add_var('pagging_ac',0);//reset to pagging
		
		$configure['sNumeroComercio'] 	= $_POST['sNumeroComercio'];
		$configure['sNombreFantasia'] 	= $_POST['sNombreFantasia'];
		$configure['sRazonSocial'] 		= $_POST['sRazonSocial'];
		$idtipoajuste  					= $_POST['idTipoUsuario'];
		$configure['dFechaDesde'] 		= $_POST['dFechaDesde'];
		$configure['dFechaHasta'] 		= $_POST['dFechaHasta'];
		
		$condic = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; //variable que se usa en la paginacion 

	    //echo "Nombre ". $_POST['nombre_u'];
		if(!session_is_registered('sNumero'))
		{
			session_register('sNumeroComercio');
			session_register('idTipoAjuste');
			session_register('sComercio');
			session_register('dFechaDesde');
			session_register('dFechaHasta');
		}
		
		$_SESSION['sNumeroComercio'] = $_POST['sNumeroComercio'];
		$_SESSION['sNombreFantasia'] = $_POST['sNombreFantasia'];
		$_SESSION['idTipoAjuste'] = $_POST['idTipoAjuste'];		
		$_SESSION['sRazonSocial'] = $_POST['sRazonSocial'];
		$_SESSION['dFechaDesde'] = $_POST['dFechaDesde'];
		$_SESSION['dFechaHasta'] = $_POST['dFechaHasta'];

		unset($_SESSION['volver']);
	}
	else
	{
		$sNumero 		 = session_get_var('ac_numero');
		$sNombreFantasia = session_get_var('ac_nombre_fantasia');
		$sRazonSocial    = session_get_var('ac_razon_social');
		$idtipoajuste	 = session_get_var('ac_tipo_ajuste');
		$fecha_desde	 = session_get_var('ac_fecha_desde');
		$fecha_hasta	 = session_get_var('ac_fecha_hasta');
		
		$conditions[] = " "; 
		
		if($sNumero != ""){
			$conditions[] = "Comercios.sNumero = '$sNumero'";	
		}
		
		if($sNombreFantasia != ""){
			$conditions[] = "Comercios.sNombreFantasia LIKE '%$sNombreFantasia'";	
		}
		
		if($sRazonSocial != ""){
			$conditions[] = "Comercios.sRazonSocial LIKE '%$sRazonSocial'";	
		}
		
		
		if($idtipoajuste != 0 && $idtipoajuste != ""){
			$conditions[] = "TiposAjustes.idTipoUsuario = '$idtipoajuste'";
		}
		
		if($fecha_desde != "" && $fecha_desde != "__/__/____"){			
			$conditions[] = "AjustesComercios.dFecha >= '".dateToMySql($fecha_desde)."'";
		}
		
		if($fecha_hasta != "" && $fecha_hasta != "__/__/____"){
			$conditions[] = "AjustesComercios.dFecha <= '".dateToMySql($fecha_hasta)."'";
		}
		
		$configure['sNumeroComercio'] 	= $sNumero;
		$configure['sNombreFantasia'] 	= $sNombreFantasia;
		$configure['sRazonSocial'] 		= $sRazonSocial;
		
		$configure['dFechaDesde'] 		= $fecha_desde;
		$configure['dFechaHasta'] 		= $fecha_hasta;		
	}

	
	$sWhere = "";
	$aCond=Array();
	
	$dFechaDesde = dateToMySql($dFechaDesde);
	$dFechaHasta = dateToMySql($dFechaHasta);
	
	
	$sCondiciones= " WHERE ".implode(' AND ',$conditions)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	
	$sCondicionesPlanes= " WHERE iPlanPromo = 0 ".implode(' AND ',$sCondiciones)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondicionesPromos= " WHERE iPlanPromo = 1 ".implode(' AND ',$aConditionsPromos)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	
	//var_export($sCondicionesPlanes);die();
	
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$conditions)."  ORDER BY $CampoOrden $TipoOrden";
		

	$sqlDatosPlanes="Call usp_getAjustesComercios(\"$sCondicionesPlanes\",\"0\");";
	$sqlDatosPromociones="Call usp_getAjustesComercios(\"$sCondicionesPromos\",\"1\");";
	
	$sqlDatos_sLim="Call usp_getAjustesComercios(\"$sCondiciones_sLim\");";
	
	//echo $sqlDatosPromociones;
	
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	
	// Ejecuto la consulta
	$resultPlanes = $oMysql->consultaSel($sqlDatosPlanes);
	$resultPromociones = $oMysql->consultaSel($sqlDatosPromociones);
	
	//var_export($resultPlanes);die();
	
	//echo count($res);
	$result = array_merge($resultPlanes , $resultPromociones);
	//echo count($res);
	
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);

	//$aParametros['optionsTipoDoc'] = $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre');
	
	$oXajax=new xajax();

	$oXajax->registerFunction("updateEstadoAjusteComercio");
	$oXajax->registerFunction("habilitarAjustesComercios");
				
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");
	

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
?>
<body style="background-color:#FFFFFF;">
	<center>
<?php 

$aParametros['OPTIONS_TIPOS_AJUSTES'] = $oMysql->getListaOpciones('TiposAjustes','id','sNombre', $idTipoAfinidad, "sEstadoAjuste = 'A' AND sDestino = 'US'");

echo parserTemplate(TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorAjustesComercios.tpl",$aParametros);	
?>

<p><img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo"> <a href="AdminAjustesComercios.php?action=new">Nuevo Ajuste 
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
		
		if($rs['sEstado'] == 'B')
		{
			$sBotonera='&nbsp;';
		}else{
			
			$oBtn = new aToolBar();
			$oBtn->setAnchoBotonera('auto');			
			$sBotonera='&nbsp;';
			
			/*<input type="button" name="advanced_search_cuenta" id="advanced_search_cuenta" value="busqueda avanzada" style="" onclick="displayWindow('BuscarUsuario.php',700,200);">*/
			
			$oBtn->addBoton("Cuotas{$rs['id']}","onclick","_createWindows('CuotasComercio.php?idAjusteComercio=".$rs['id']."&iPlanPromo{$rs['iPlanPromo']}','Cuotas')",'Cuotas','Detalle',true,true);
				
			$oBtn->addBoton("Editar{$rs['id']}","onclick","editar({$rs['id']},{$rs['iPlanPromo']})",'Editar','Editar',true,true);				
			$oBtn->addBoton("Eliminar{$rs['id']}","onclick","eliminar({$rs['id']})",'Eliminar','Eliminar',true,true);							
				
			$sBotonera = $oBtn->getBotoneraToolBar('');		
		}
		
		?>
		<br>
		<tr id="Ajuste<?php echo $PK;?>">
			<!-- Valores -->
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sRazonSocial'];?></td>
			<td width="15%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sTipoAjuste'];?></td>
			<td width="5%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['fImporteTotal'];?></td>
			<td width="5%" align="right" <?php echo $sClase;?>>&nbsp;<?=$rs['fImporteTotalInteres'];?></td>
			<td width="5%" align="right" <?php echo $sClase;?>>&nbsp;<?=$rs['fImporteTotalIVA'];?></td>
			<td width="5%" align="right" <?php echo $sClase;?>>&nbsp;<?=$rs['iCuotas'];?></td>
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['dFecha'];?></td>			
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sPlan'];?></td>		
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
		<span class='rojo'>Rojo-Solicitudes Rechazas. <span><br><span class='naranja'>Naranja-Solicitudes Anulad----as <span><br><span class='azul'>Azul-Solicitudes de Alta<span>
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
	
	
	function eliminar(idAjusteComercio)
	{
		if(confirm("¿Desea eliminar el elemento seleccionado?"))
		{
			xajax_updateEstadoAjusteComercio(idAjusteComercio,'B');
		}
	}
	
	/*function mostrarCuotas(idAjuste)
	{
		alert("mostrarCuotas");
		top.getBoxCuotasAjusteUsuario(idAjuste);
	}
	*/
	
	function editar(idAjuste, iPlanPromo)
	{
		window.location = "../AjustesComercios/AdminAjustesComercios.php?idAjusteComercio="+ idAjuste+"&iPlanPromo="+iPlanPromo+"&url_back=../AjustesComercios/AjustesComercios.php";
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
</script>
