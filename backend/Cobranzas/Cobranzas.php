<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
	
	$idObjeto = 63;
    $arrayPermit = explode(',',$_SESSION['_PERMISOS_'][$idObjeto]['sPermisos']);
		
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
							'Cobranzas.sNroRecibo',
							'Cobranzas.dFechaPresentacion',
							'Cobranzas.dFechaCobranza',							
							'CuentasUsuarios.sNumeroCuenta',
							'Usuarios.sApellido', 
							'Usuarios.sNombre', 							
							'Cobranzas.fImporte'							
						 );
	$arrListaEncabezados = array
							(
								'Nro Recibo',
								'Fecha Presentacion',
								'Fecha Cobranza',								
								'Cuenta',
								'Apellido',
								'Nombre',
								'Importe'								
							);
								
	$Tabla = 'Cobranzas'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'Cobranzas.dFechaPresentacion'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
		
	if(isset($_POST['buscar']))
	{	
		$sNumeroCuenta 	= $_POST['sNroCuenta'];
		$sNombre 		= $_POST['sNombre'];
		$sApellido 		= $_POST['sApellido'];
		$dFechaDesde 	= $_POST['dFechaDesde'];
		$dFechaHasta 	= $_POST['dFechaHasta'];
		$PrimReg = 0 ;
		
		//$condic = $_POST['condic']; // variable para manejar las condiciones
		//$condic1 = $_POST['condic']; // variable que se usa en la paginacion 

	    //echo "Nombre ". $_POST['nombre_u'];
		if(!session_is_registered('sNumero'))
		{
			session_register('sNroCuenta');
			session_register('sNombre');
			session_register('sApellido');
			session_register('dFechaDesde');
			session_register('dFechaHasta');
		}
		
		$_SESSION['sNroCuenta'] 	= $_POST['sNroCuenta'];
		$_SESSION['sNombre'] 		= $_POST['sNombre'];
		$_SESSION['sApellido'] 		= $_POST['sApellido'];
		$_SESSION['dFechaDesde'] 	= $_POST['dFechaDesde'];
		$_SESSION['dFechaHasta'] 	= $_POST['dFechaHasta'];

		unset($_SESSION['volver']);
	}
	else
	{
		$sNumeroCuenta 	= $_SESSION['sNroCuenta'];
		$sNombre 		= $_SESSION['sNombre'];
		$sApellido 		= $_SESSION['sApellido'];
		$dFechaDesde 	= $_SESSION['dFechaDesde'];
		$dFechaHasta 	= $_SESSION['dFechaHasta'];
		//var_export($_SESSION);
	}

	$sWhere = "";
	$aCond=Array();
	
	$dFechaDesde = dateToMySql($dFechaDesde);
	$dFechaHasta = dateToMySql($dFechaHasta);
	
	if($sNumeroCuenta){	
		$aCond[]=" CuentasUsuarios.sNumeroCuenta = '$sNumeroCuenta' ";	
	}
	
	if($sNombre){
		$aCond[]=" InformesPersonales.sNombre LIKE '%$sNombre%' ";
	}
	
	if($sApellido){
		$aCond[]=" InformesPersonales.sApellido LIKE '%$sApellido%' ";
	}
	
	if($dFechaDesde){
		$aCond[]=" Cobranzas.dFechaCobranza >= ' $dFechaDesde '";
	}
	
	if($dFechaHasta){
		$aCond[]=" Cobranzas.dFechaCobranza <= '$dFechaHasta' ";
	}

	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	//var_export($sCondiciones);
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";

	//echo $sCondiciones;

	$sqlDatos="Call usp_getCobranzas(\"$sCondiciones\");";

	$sqlDatos_sLim="Call usp_getCobranzas(\"$sCondiciones_sLim\");";
	/*if($_SESSION['id_user'] == 296){
		echo $sqlDatos;
	}*/
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);

	//$aParametros['optionsTipoDoc'] = $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre');
	
	$oXajax=new xajax();

	$oXajax->registerFunction("updateEstadoCobranza");
	$oXajax->registerFunction("habilitarCobranzas");
	$oXajax->registerFunction("setEstadoCuentaUsuarioByCobranza");		
	$oXajax->registerFunction("RecalcularLimites");		
	$oXajax->registerFunction("eliminarDefinitivoObjeto");
	$oXajax->registerFunction("reactivarCobranza");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");	

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
?>
<body style="background-color:#FFFFFF;">
	<center>
<?php 

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorCobranzas.tpl",$aParametros);

if(in_array(AGREGAR,$arrayPermit)){	
?>
<p><img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo"> <a href="AdminCobranzas.php?action=new">Nueva Cobranza
</a></p>
<?php
}

if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result){	

  $sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p>
	<form id='formCobranzas' action='' method='POST' >
		<center>
  		<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='90%' id='tableCobranzas'>
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
			$oBtn->addBoton("Reactivar{$rs['id']}","onclick","reactivar('{$rs['id']}','{$rs['sNroRecibo']}')",'Reactivar','Reactivar',true,true);
		}else{
			$sBotonera='&nbsp;';
								
 			$oBtn->addBoton("Imprimir{$rs['id']}","onclick","Imprimir({$rs['id']})",'Imprimir','Imprimir',true,true);
			$oBtn->addBoton("Editar{$rs['id']}","onclick","editar({$rs['id']})",'Editar','Editar',true,true);				
		  if( in_array(baja_logica,$arrayPermit)) $oBtn->addBoton("Eliminar{$rs['id']}","onclick","eliminar({$rs['id']},'{$rs['sNroRecibo']}')",'Eliminar','Eliminar',true,true);
			/*$oBtn->addBoton("Editar{$rs['id']}","onclick","editar({$rs['id']})",'Editar','Editar',true,true);*/				
		}
	    	
		if( in_array(ELIMINAR,$arrayPermit)) $oBtn->addBoton("EliminarDefinitivo{$rs['id']}","onclick","eliminarDefinitivo({$rs['id']})",'EliminarDefinitivo','Eliminar Definitivo',true,true);
		$sBotonera = $oBtn->getBotoneraToolBar('');		
		?>														
		<tr id="Ajuste<?php echo $PK;?>">
			<!-- Valores -->
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNroRecibo'];?></td>
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['dFechaPresentacion'];?></td>
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['dFechaCobranza'];?></td>
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumeroCuenta'];?></td>
			<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sApellido'];?></td>
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNombre'];?></td>
			<td width="10%" align="right" <?php echo $sClase;?>>&nbsp;<?=$rs['fImporte'];?></td>			
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
	
	
	function eliminar(idCobranza,sNroRecibo)
	{
		if(confirm("¿Desea eliminar la Cobranza seleccionada "+sNroRecibo+"?"))
		{
			xajax_updateEstadoCobranza(idCobranza,'B');
		}
	}
	
	/*function mostrarCuotas(idAjuste)
	{
		alert("mostrarCuotas");
		top.getBoxCuotasAjusteUsuario(idAjuste);
	}
	*/
	
	function editar(idCobranza)
	{
		window.location = "../Cobranzas/AdminCobranzas.php?idCobranza="+ idCobranza+"&url_back=../Cobranzas/Cobranzas.php";
		//xajax_setEstadoCuentaUsuarioByCobranza(2);
		//xajax_RecalcularLimites(2);
	}
	
	
	function Habilitar()
	{
		  var mensaje="¿Esta seguro de Habilitar los elementos seleccionados?"; 
		  var el = document.getElementById('tableCobranzas');
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
		       xajax_habilitarCobranzas(xajax.getFormValues('formCobranzas'));
		  }
		  else alert('Debe Elegir al menos un elemento a habilitar.');	   
	}
	
	
 	function Imprimir(idCobranza)
	{
		window.location = "../Cobranzas/VistaPreviaCobranza.php?idCobranza="+idCobranza;
	}

	function eliminarDefinitivo(idCobranza){
		var msje = "Esta seguro que desea Eliminar la Cobranza?";
		var sUrl = "Cobranzas.php";
		if(confirm(msje)){
			xajax_eliminarDefinitivoObjeto(idCobranza,1,sUrl);
		}
	}
	
	function reactivar(idCobranza,sNroRecibo){
		if(confirm("Desea activar la Cobranza "+sNroRecibo+"?")){
			//xajax_updateEstadoCobranza(idCobranza,'A');
			xajax_reactivarCobranza(idCobranza);
		}
	}
</script>
