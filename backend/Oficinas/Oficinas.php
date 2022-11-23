<?
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

#Control de Acceso al archivo
if(!isLogin()){go_url("/index.php");}

$aParametros = array();
$aParametros = getParametrosBasicos(1);	

/* Opciones configurables */
$Pagina = intval(cd_paramGlobal('Pagina'));
$CampoOrden = cd_paramGlobal('CampoOrden');
$TipoOrden = cd_paramGlobal('TipoOrden');

if ($Pagina <= 0) $Pagina = 1;

$NombreMod = 'Oficinas';									// Nombre del modulo
$NombreTipoRegistro = 'oficina';					// Nombre tipo de registro
$NombreTipoRegistroPlu = 'oficinas';			// Nombre tipo de registros en Plural
$Masculino = false;												// Genero del tipo de registro (true: masculino - false: femenino)
$arrListaCampos = array('Sucursales.sNombre','Oficinas.sDireccion', 'Oficinas.sApodo' );
$arrListaEncabezados = array('Sucursal', 'Direccion', 'Apodo');
$Tabla = 'Oficinas'; // Tabla sobre la cual trabajaremos
$PK = 'id';	// Nombre del campo Clave Principal
$CampoOrdenPre = 'Oficinas.sApodo'; // Campo de orden predeterminado
$TipoOrdenPre = 'ASC';	// Tipo de orden predeterminado
$RegPorPag = 15; // Cantidad de registros por página

if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
$PrimReg = ($Pagina - 1) * $RegPorPag;

$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";

if(isset($_POST['buscar']))
{
	$idSucursal = $_POST['idSucursal'];
	$nombre_u = $_POST['nombre_u'];
	$sEstado = $_POST['sEstado'];
	
	$condic = $_POST['condic']; // variable para manejar las condiciones
	$condic1 = $_POST['condic']; //variable que se usa en la paginacion 
		
	//echo $condic;
	
	if(!session_is_registered('snombre_u'))
	{
		session_register('idSucursalOficinas');
		session_register('snombre_u');
		session_register('sEstadoOficina');
		session_register('scondic');
		
	}
	
	$_SESSION['idSucursalOficinas'] = $_POST['idSucursal'];	
	$_SESSION['snombre_u'] = $_POST['nombre_u'];	
	$_SESSION['sEstadoOficina'] = $_POST['sEstado'];	
	$_SESSION['scondic'] = $_POST['condic'];
	unset($_SESSION['volver']);
}
else
{
	$idSucursal = $_SESSION['idSucursalOficinas'];
	$nombre_u = $_SESSION['snombre_u'];
	$sEstado = $_SESSION['sEstadoOficina'];
	$condic = $_SESSION['scondic'];	
	$condic1 = $_SESSION['scondic'];	
}
	$sWhere = "";
	
	$aCond=Array();
	
	if($idSucursal)
	{
		$aCond[]=" Oficinas.idSucursal = '$idSucursal' ";
	}
	
	if($nombre_u){
		$aCond[]=" $condic LIKE '%$nombre_u%' ";
	}	
	
	if($sEstado)
	{		
		if($sEstado != "-1")	
			$aCond[]=" Oficinas.sEstado = '$sEstado' ";
	}	
	
//var_export($aCond); 
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
	
	session_register('nombre_u');
	session_register('condic');
	
	$nombre_u = $_GET['nombre_u'];
	$condic = $_GET['condic'];


$sqlDatos="Call usp_getOficinas(\"$sCondiciones\");";
$sqlDatos_sLim="Call usp_getOficinas(\"$sCondiciones_sLim\");";


// Cuento la cantidad de registros sin LIMIT
$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
// Ejecuto la consulta
$result = $oMysql->consultaSel($sqlDatos);
$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);

//var_export($result); 
$CantRegFiltro = sizeof($result_sLim);

//echo $sCondiciones ."  cant reg: --- ". $CantRegFiltro;

$oXajax=new xajax();
$oXajax->setCharEncoding('ISO-8859-1');
$oXajax->configure('decodeUTF8Input',true);
$oXajax->registerFunction("updateEstadoOficina");
$oXajax->registerFunction("habilitarOficinas");
$oXajax->processRequest();
$oXajax->printJavascript("../includes/xajax/");

$aParametros['DHTMLX_WINDOW']=1;
xhtmlHeaderPaginaGeneral($aParametros);	
?>
<body style="background-color:#FFFFFF;">
<div id="BodyUser">
	
<?php 


	//--------------------- Obtengo Sucursales ---------------------------------------------------------------
		
	$sSucursales = $oMysql->getListaOpciones( 'Sucursales', 'Sucursales.id', 'Sucursales.sNombre',$id_s);    	
	$aParametros['OPTIONS_SUCURSALES'] = $sSucursales;		
	//---------------------------------------------------------------------------------------------------------

	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorOficinas.tpl", $aParametros);

?>
<p>
	<img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo">
		 <a href="AdminOficinas.php?action=new"><? if($Masculino) echo 'Nuevo '; else echo 'Nueva '; echo $NombreTipoRegistro;?>
		 </a>
</p>

<?
if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result)
{	

  $sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p>
	<form id='formOficinas' action='' method='POST' >
	<center>
	<table class='tablePoliza' align='center' style='width:80% !important;' cellpadding='3' cellspacing='0' border='1' bordercolor='#000000' width='98%' id='tablaOficinas'>
		<tr class='filaPrincipal'>
		<!-- Lista de encabezados de columna -->";
	
	$CantEncabezados = count($arrListaEncabezados);
	for($i=0; $i<$CantEncabezados; $i++)
	{
		$sCadena .= "<th>";
		if($CampoOrden == $arrListaCampos[$i]){
			if ($TipoOrden == 'ASC') $NuevoTipoOrden = 'DESC'; else $NuevoTipoOrden = 'ASC';
		}
		else $NuevoTipoOrden = 'ASC';
		$sCadena .= "<a href=\"{$_SERVER['PHP_SELF']}?CampoOrden={$arrListaCampos[$i]}&TipoOrden={$NuevoTipoOrden}\">{$arrListaEncabezados[$i]}</a>";
		if($CampoOrden == $arrListaCampos[$i]){
			if ($TipoOrden == 'ASC') $sCadena .= " &nabla;"; else $sCadena .= " &Delta;";
		}
		$sCadena .= "</th>\r\n";
	}
	///Opciones de Mod. y Elim.
	$sCadena .="<th colspan='2'>Acciones</th>
		<th style='cursor:pointer;'><input type='checkbox' onchange='tildar_checkboxs( this.checked )' id='checkbox_principal' /> </th>
		</tr>";
    echo $sCadena;

	$CantMostrados = 0;
	
	foreach ($result as $rs )
	{
		//echo "entro en foreach";
		
		$sBotonera = '';	
		$CantMostrados ++;
		$PK = $rs['id'];
		$sClase='';
		//$rs['sSucursal'] = htmlspecialchars_decode($rs['sSucursal']);		
		$rs['sSucursal'] = html_entity_decode($rs['sSucursal']);		
		$rs['sDireccion'] = html_entity_decode($rs['sDireccion']);		
		//$rs['sDireccion'] = htmlspecialchars_decode($rs['sDireccion']);		
		//$rs['sApodo'] = html_entity_decode($rs['sApodo']);
		$rs['sApodo'] = htmlspecialchars_decode($rs['sApodo']);		
		$rs['sApellido'] = html_entity_decode($rs['sApellido']);		
		//$rs['sApellido'] = htmlspecialchars_decode($rs['sApellido']);		
		$rs['sNombre'] = html_entity_decode($rs['sNombre']);		
		//$rs['sNombre'] = htmlspecialchars_decode($rs['sNombre']);		
		
		switch ($rs['sEstado'])
		{
			case 'B': $sClase="class='rojo'"; break;//estado Baja
		}
		
		$sUsuario = $rs['sApellido'];
		
		if($rs['sNombre'] != '')
			$sUsuario = $sUsuario.', '.$rs['sNombre'];
		
		if($rs['sEstado'] == 'B')
		{
			$sBotonera='&nbsp;';
		}
		else
		{			
			$oBtn = new aToolBar();
			$oBtn->setAnchoBotonera('auto');
			$oBtn->addBoton("Modificar{$rs['id']}","onclick","editarOficina({$rs['id']})",'Editar','Modificar',true,true);	
			$oBtn->addBoton("Eliminar{$rs['id']}","onclick","eliminarOficina({$rs['id']})",'Eliminar','Eliminar',true,true);	
			
			//if(in_array($idUser,array(1,296)));
			//	$oBtn->addBoton("Configurar{$rs['id']}","onclick","SetearPermisos({$rs['id']},'{$sUsuario}')",'Configurar','Permisos',true,true);	
			
			$sBotonera = $oBtn->getBotoneraToolBar('');
			
		}
		
		
		?>
		<tr id="empleado<?php echo $PK;?>">
			<!-- Valores -->
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sSucursal']?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sDireccion']?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sApodo']?></td>	
			<!-- Links para Mod. y Elim. -->
			<td colspan="2" align="center">
			<?=$sBotonera;?>
			</td>
			<td align="center"><input type='checkbox' id='aOficina[]' name='aOficina[]' class="check_user" value='<?php echo $PK;?>'/> </td>
		</tr>
		<?
	}
	
	//echo "salio del foreach";

	?>
	</tr>
	<tr>
	   <td colspan="7" align="right">
	   	   <div> 
	   	    	<button type="button" onclick="Habilitar();"> Habilitar </button> &nbsp;
	   	   </div>
	   </td>
	</tr> 
</table>
<div style='font-size:10px;text-align:left;width:80%'>
		<span class='rojo'>Rojo-Oficinas de Baja. <span><br>
</div>	
</form>

<?
	if (ceil($CantRegFiltro/$RegPorPag) > 1)
	{
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


function editarOficina(idOficina){
	window.location ="AdminOficinas.php?idOficina="+ idOficina;	
}

function eliminarOficina(idOficina){
	if(confirm("¿Desea eliminar la oficina?"))
	{
		xajax_updateEstadoOficina(idOficina,'B');
	}
}

function Habilitar(){
	  var mensaje="¿Esta seguro de Habilitar a el/las Oficina/s seleccionada/s?"; 
	  var el = document.getElementById('tablaOficinas');
	  var imputs= el.getElementsByTagName('input');
	  var band=0;
	  for (var i=0; i<imputs.length; i++) 
	  {
	    if (imputs[i].type=='checkbox')	
	     if(!imputs[i].checked) 
	     {
	         band=0;
	     }
	     else{ band=1; break;}
	  }	
	  if(band==1)
	  {
	  	 if(confirm(mensaje))
	       xajax_habilitarOficinas(xajax.getFormValues('formOficinas'));
	  }
	  else alert('Debe Elegir al menos una Oficina a habilitar.');	   
}

</script>
<?php echo xhtmlFootPagina();?>
