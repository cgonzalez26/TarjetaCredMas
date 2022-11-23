<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	


	
	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
		
	if ($Pagina <= 0) $Pagina = 1;

	$NombreMod = 'ChequesComercios'; // Nombre del modulo
	$NombreTipoRegistro = 'Cheques';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'ChequesComercios'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	
	
	$arrListaCampos = array
						(
							'Comercios.sNumero',
							'Liquidaciones.sNumero',
							'TransaccionesLiquidacionesComercios.iNumeroTransaccion',
							'T ransaccionesLiquidacionesComercios.dFechaEmision',
							'TransaccionesLiquidacionesComercios.fImporte', 
							'TransaccionesLiquidacionesComercios.sEmisor',
							'TransaccionesLiquidacionesComercios.sReceptor'										
						 );
	$arrListaEncabezados = array
						(
							'Nro. Comercio',
							'Nro. Liquidacion',
							'Nro. Transaccion',
							'Fecha Emision',
							'Importe',
							'Emisor',
							'Receptor'				
						);
								
	$Tabla = 'TransaccionesLiquidacionesComercios'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'TransaccionesLiquidacionesComercios.dFechaRegistro'; // Campo de orden predeterminado
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
				
		if($_POST['sNumeroLiquidacion'] != ""){
			$conditions[] = "Liquidaciones.sNumero = '{$_POST['sNumeroLiquidacion']}'";	
		}
		
		/*if($_POST['iNroCheque'] != ""){
			$conditions[] = "ChequesComercios.iNroCheque = '{$_POST['iNroCheque']}'";	
		}*/
		
		if($_POST['dFechaDesde'] != "" && $datos['dFechaDesde'] != "__/__/____"){			
			$conditions[] = "TransaccionesLiquidacionesComercios.dFechaEmision >= '".dateToMySql($_POST['dFechaDesde'])."'";
		}
		
		if($_POST['dFechaHasta'] != "" && $_POST['dFechaDesde'] != "__/__/____"){
			$conditions[] = "TransaccionesLiquidacionesComercios.dFechaEmision <= '".dateToMySql($_POST['dFechaHasta'])."'";
		}		
		
		
		session_add_var('ac_numero',$_POST['sNumeroComercio']);
		session_add_var('ac_nombre_fantasia',$_POST['sNombreFantasia']);
		session_add_var('ac_razon_social',$_POST['sRazonSocial']);
		session_add_var('ac_fecha_desde',$_POST['dFechaDesde']);
		session_add_var('ac_fecha_hasta',$_POST['dFechaHasta']);
		session_add_var('ac_numero_liquidacion',$_POST['sNumeroLiquidacion']);
		
		session_add_var('pagging_ac',0);//reset to pagging
		
		$configure['sNumeroComercio'] 	= $_POST['sNumeroComercio'];
		$configure['sNombreFantasia'] 	= $_POST['sNombreFantasia'];
		$configure['sRazonSocial'] 		= $_POST['sRazonSocial'];
		$idtipoajuste  					= $_POST['sNumeroLiquidacion'];
		$configure['dFechaDesde'] 		= $_POST['dFechaDesde'];
		$configure['dFechaHasta'] 		= $_POST['dFechaHasta'];
		
		$condic = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; //variable que se usa en la paginacion 

	    //echo "Nombre ". $_POST['nombre_u'];
		if(!session_is_registered('sNumero'))
		{
			session_register('sNumeroComercio');
			session_register('sNumeroLiquidacion');
			session_register('sComercio');
			session_register('dFechaDesde');
			session_register('dFechaHasta');
		}
		
		$_SESSION['sNumeroComercio'] = $_POST['sNumeroComercio'];
		$_SESSION['sNombreFantasia'] = $_POST['sNombreFantasia'];
		$_SESSION['sNumeroLiquidacion'] = $_POST['sNumeroLiquidacion'];		
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
		$idtipoajuste	 = session_get_var('ac_numero_liquidacion');
		$fecha_desde	 = session_get_var('ac_fecha_desde');
		$fecha_hasta	 = session_get_var('ac_fecha_hasta');
		
		$conditions[] = "1 = 1"; 
		
		if($sNumero != ""){
			$conditions[] = "Comercios.sNumero = '$sNumero'";	
		}
		
		if($sNombreFantasia != ""){
			$conditions[] = "Comercios.sNombreFantasia LIKE '%$sNombreFantasia%'";	
		}
		
		if($sRazonSocial != ""){
			$conditions[] = "Comercios.sRazonSocial LIKE '%$sRazonSocial'";	
		}
		
		
		if($idtipoajuste != 0 && $idtipoajuste != ""){
			$conditions[] = "Liquidaciones.sNumero = '$sNumeroLiquidacion'";
		}
		
		if($fecha_desde != "" && $fecha_desde != "__/__/____"){			
			$conditions[] = "TransaccionesLiquidacionesComercios.dFechaEmision >= '".dateToMySql($fecha_desde)."'";
		}
		
		if($fecha_hasta != "" && $fecha_hasta != "__/__/____"){
			$conditions[] = "TransaccionesLiquidacionesComercios.dFechaEmision <= '".dateToMySql($fecha_hasta)."'";
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
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$conditions)."  ORDER BY $CampoOrden $TipoOrden";
		
		
	$sqlDatos="Call usp_getTransaccionesLiquidacionesComercios(\"$sCondiciones\");";
	$sqlDatos_sLim="Call usp_getTransaccionesLiquidacionesComercios(\"$sCondiciones_sLim\");";
	
	//echo $sqlDatos;
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);

	
	/*$oXajax=new xajax();

	$oXajax->registerFunction("updateEstadoLiquidaciones");
	$oXajax->registerFunction("habilitarLiquidaciones");
				
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");*/
	

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
?>
<body style="background-color:#FFFFFF;">
	<center>
<?php 

echo parserTemplate(TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorValoresPagoComercios.tpl",$aParametros);	
?>

</a></p>

<?php
if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result)
{	

  $sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p>
	<form id='formLiquidaciones' action='' method='POST' >
		<center>
  		<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='90%' id='tableLiquidaciones'>
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
		}
		else
		{
			$oBtn = new aToolBar();
			$oBtn->setAnchoBotonera('auto');			
			$sBotonera='&nbsp;';
					
			$oBtn->addBoton("Ver{$rs['id']}","onclick","_createWindowsDatos('DatosValoresDePago.php?id=".$rs['id']."','Datos Valor de Pago')",'Editar','Ver',true,true);		
			//$oBtn->addBoton("Ver{$rs['id']}","onclick","VerDatosValoresDePago({$rs['id']})",'Editar','Ver',true,true);		
			$oBtn->addBoton("Eliminar{$rs['id']}","onclick","_createWindows('Anulacion', {$rs['id']}, {$rs['sNumeroComercio']}, {$rs['iNumeroTransaccion']}, {$rs['sNumeroLiquidacion']}, {$rs['fImporte']})",'Eliminar','Eliminar',true,true);										
			
				
			$sBotonera = $oBtn->getBotoneraToolBar('');		
		}	
					
		?>
		<br>						
		
		<tr id="Liquidacion<?php echo $PK;?>">
			<!-- Valores -->
			<td width="5%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumeroComercio'];?></td>
			<td width="5%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumeroLiquidacion'];?></td>
			<td width="5%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['iNumeroTransaccion'];?></td>
			<td width="5%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['dFechaEmision'];?></td>
			<td width="5%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['fImporte'];?></td>
			<td width="5%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sEmisor'];?></td>
			<td width="5%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sReceptor'];?></td>
			<!-- Links para Mod. y Elim. -->
			<td colspan="16" align="center" width="5%">
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
	
	
	function eliminar(idAjusteComercio)
	{
		if(confirm("¿Desea eliminar el elemento seleccionado?"))
		{
			//xajax_updateEstadoAjusteComercio(idAjusteComercio,'B');
		}
	}
	
	/*function mostrarCuotas(idAjuste)
	{
		alert("mostrarCuotas");
		top.getBoxCuotasAjusteUsuario(idAjuste);
	}
	*/
	
	//function editar(idAjuste)
	//{
		//window.location = "../AdminLiquidaciones/AdminLiquidaciones.php?idAjusteComercio="+ idAjuste+"&url_back=../AjustesComercios/AjustesComercios.php";
	//}
	
	
	function Habilitar()
	{
		  var mensaje="¿Esta seguro de Habilitar los elementos seleccionados?"; 
		  var el = document.getElementById('tableLiquidaciones');
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
		  	       xajax_habilitarAjustesUsuarios(xajax.getFormValues('formLiquidaciones'));		  	 
		  }
		  else alert('Debe Elegir al menos un elemento a habilitar.');	  
		  
	}
	
	
	var dhxWins1;
	function _createWindows(sTitulo, id, sNroComercio, iNroTransaccion, sNroLiquidacion, fImporte)
	{
	 	var idWind = "windowDetalle";
		
	 	sUrl = "AnulacionValorDePago.php?id="+id+"&sNroComercio=" + sNroComercio+ "&iNroTransaccion="+iNroTransaccion+"&sNroLiquidacion="+sNroLiquidacion+"&fImporte="+fImporte;	
	 	
	    dhxWins1 = new dhtmlXWindows();     	
		dhxWins1.setImagePath("../includes/grillas/dhtmlxWindows/sources/imgs/");	  
		_popup_ = dhxWins1.createWindow(idWind, 0, 0, 300, 300);
		_popup_.setText(sTitulo);
		_popup_.center();
		_popup_.button("close").attachEvent("onClick", __closeWindows);
		_url_ = sUrl;
		_popup_.attachURL(_url_);		
	} 
	
	
	function __closeWindows(_x)
	{		
		 	dhxWins1.window("windowDetalle").close(); 			  
	}	
	
	
	function _createWindowsDatos(sUrl,sTitulo)
	{
		 var idWind = "windowDatos";
			     	
    	dhxWins1 = new dhtmlXWindows();     	
	    dhxWins1.setImagePath("../includes/grillas/dhtmlxWindows/sources/imgs/");	  
	    _popup_ = dhxWins1.createWindow(idWind, 0, 0, 300, 300);
	    _popup_.setText(sTitulo);
	    _popup_.center();
	    _popup_.button("close").attachEvent("onClick", __closeWindowsDatos);
		_url_ = sUrl;
	    _popup_.attachURL(_url_);	
	} 
	
	
	function __closeWindowsDatos(_x)
	{		
		 	dhxWins1.window("windowDatos").close(); 		  
	}	
	
	
	function VerDatosValoresDePago(idValorDePago)
	{
		window.location = "../ValoresDePagoComercios/DatosValoresDePago.php?id="+idValorDePago;
	}
	
</script>
