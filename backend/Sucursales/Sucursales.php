<?
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );
//session_start();

#Control de Acceso al archivo
//if(!isLogin()){go_url("/index.php");}
$idObjeto = 28;
$arrayPermit = explode(',',$_SESSION['_PERMISOS_'][$idObjeto]['sPermisos']);

$aParametros = array();
$aParametros = getParametrosBasicos(1);	

/* Opciones configurables */
$Pagina = intval(cd_paramGlobal('Pagina'));
$CampoOrden = cd_paramGlobal('CampoOrden');
$TipoOrden = cd_paramGlobal('TipoOrden');

if ($Pagina <= 0) $Pagina = 1;

$NombreMod = 'Sucursales';									// Nombre del modulo
$NombreTipoRegistro = 'Sucursal';					// Nombre tipo de registro
$NombreTipoRegistroPlu = 'sucursales';			// Nombre tipo de registros en Plural
$Masculino = false;												// Genero del tipo de registro (true: masculino - false: femenino)
//$arrListaCampos = array('Sucursales.sNombre', 'Zonas.sNombre', 'Sucursales.sDireccion');
$arrListaCampos = array('Sucursales.sNumeroSucursal','Sucursales.sNombre', 'Regiones.sNombre', 'Sucursales.idProvincia');
$arrListaEncabezados = array('Numero','Sucursal', 'Region', 'Provincia');
$Tabla = 'Sucursales';											// Tabla sobre la cual trabajaremos
$PK = 'id';												// Nombre del campo Clave Principal
$CampoOrdenPre = 'Sucursales.sNombre';											// Campo de orden predeterminado
$TipoOrdenPre = 'ASC';										// Tipo de orden predeterminado
$RegPorPag = 15;	
													// Cantidad de registros por página
if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;

$PrimReg = ($Pagina - 1) * $RegPorPag;

$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";

if(isset($_POST['buscar']))
{
		
	$sNombreSucursal= $_POST['sNombreSucursal'];
	$idRegionSucursal= $_POST['idRegionSucursal'];
	
	if(!session_is_registered('sNombreSucursal'))
	{
		session_register('sNombreSucursal');
		session_register('idRegionSucursal');
	}
	
	$_SESSION['sNombreSucursal'] = $_POST['sNombreSucursal'];
	$_SESSION['idRegionSucursal'] = $_POST['idRegionSucursal'];
	unset($_SESSION['volver']);
}
else {
	$sNombreSucursal = $_SESSION['sNombreSucursal'];
	$idRegionSucursal = $_SESSION['idRegionSucursal'];
}
	$sWhere = "";
	
	$aCond=Array();
	
	if($sNombreSucursal) $aCond[]=" Sucursales.sNombre LIKE '%$sNombreSucursal%' ";	
	if($idRegionSucursal) $aCond[]=" Sucursales.idRegion = {$idRegionSucursal} ";
	
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
	
$sqlDatos="Call usp_getSucursales(\"$sCondiciones\");";
$sqlDatos_sLim="Call usp_getSucursales(\"$sCondiciones_sLim\");";

// Cuento la cantidad de registros sin LIMIT
$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
// Ejecuto la consulta
$result = $oMysql->consultaSel($sqlDatos);
$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);

$CantRegFiltro = sizeof($result_sLim);

$aParametros['optionsRegiones'] = $oMysql->getListaOpciones("Regiones","id","sNombre");

$oXajax=new xajax();

$oXajax->registerFunction("updateEstadoSucursal");
$oXajax->registerFunction("habilitarSucursales");
$oXajax->processRequest();
$oXajax->printJavascript("../includes/xajax/");

//$aParametros['DHTMLX_WINDOW']=1;
xhtmlHeaderPaginaGeneral($aParametros);	

?>
<body style="background-color:#FFFFFF;">
<div id="BodyUser">
	
<?php 
//include("buscador.php");
echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorSucursal.tpl",$aParametros);

?>
<p><img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo"> <a href="AdminSucursales.php?action=new"><? if($Masculino) echo 'Nuevo '; else echo 'Nueva '; echo $NombreTipoRegistro;?></a></p>

<?

if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result)
{	

  $sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p>
	<form id='formSucursales' action='' method='POST' >
	<center>
	<table class='tablePoliza' align='center' style='width:80% !important;' cellpadding='3' cellspacing='0' border='1' bordercolor='#000000' width='98%' id='tablaSucursal'>
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
			if($TipoOrden == 'ASC') $sCadena .= " &nabla;"; else $sCadena .= " &Delta;";
		}
		$sCadena .= "</th>\r\n";
	}
	///Opciones de Mod. y Elim.
	$sCadena .="<th colspan='2'>Acciones</th>
		<th style='cursor:pointer;'><input type='checkbox' onchange='tildar_checkboxs( this.checked )' id='checkbox_principal' /> </th>
		</tr>";
    echo $sCadena;

	$CantMostrados = 0;
	
	foreach ($result as $rs)
	{	
		$sBotonera = '';	
		$CantMostrados ++;
		$PK = $rs['id'];
		$sClase='';		
		if ($rs['sEstado'] == 'B')
		{
			$sClase="class='rojo'";//estado Baja
		}
	
		$sUsuario=$rs['sNombre'].' '.$rs['sApellido'];
		
		if($rs['sEstado'] == 'B')
		{
			$sBotonera='&nbsp;';
		}
		else
		{
			$oBtn = new aToolBar();
			$oBtn->setAnchoBotonera('auto');
			$oBtn->addBoton("Modificar{$rs['id']}","onclick","editarSucursal({$rs['id']})",'Editar','Modificar',true,true);	
			$oBtn->addBoton("Eliminar{$rs['id']}","onclick","eliminarSucursal({$rs['id']})",'Eliminar','Eliminar',true,true);	
			
			//if(in_array($idUser,array(1,296)));
			//	$oBtn->addBoton("Configurar{$rs['id']}","onclick","SetearPermisos({$rs['id']},'{$sUsuario}')",'Configurar','Permisos',true,true);	
			
			$sBotonera = $oBtn->getBotoneraToolBar('');		
		}
		?>
		<tr id="empleado<?php echo $PK;?>">
			<!-- Valores -->			
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumeroSucursal']?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNombre']?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sRegion']?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sProvincia']?></td>	
					
			<!-- Links para Mod. y Elim. -->
			<td colspan="2" align="center">
			<?=$sBotonera;?>
			</td>
			<td align="center"><input type='checkbox' id='aSucursal[]' name='aSucursal[]' class="check_user" value='<?php echo $PK;?>'/> </td>
		</tr>
		<?
	}
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
		<span class='rojo'>Rojo-Sucursales de Baja. <span><br>
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
function editarSucursal(idSucursal){
	window.location ="AdminSucursales.php?idSucursal="+ idSucursal+"&action=editar";	
}

function eliminarSucursal(idSucursal){
	if(confirm("¿Desea eliminar la sucursal?"))
	{
		xajax_updateEstadoSucursal(idSucursal,'B');
	}
}


function Habilitar(){
	  var mensaje="¿Esta seguro de Habilitar a el/las Sucursal/es seleccionada/s?"; 
	  var el = document.getElementById('tablaSucursal');
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
	       xajax_habilitarSucursales(xajax.getFormValues('formSucursales'));
	  }
	  else alert('Debe Elegir al menos una Sucursal a habilitar.');	   
}
</script>
<?php echo xhtmlFootPagina();?>
