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
$arrListaCampos = array
				(
					'Sucursales.sNumeroSucursal',
					'Sucursales.sNombre',
					'Regiones.sNombre',
					'Sucursales.idProvincia'
				);
$arrListaEncabezados = array
					(
						'Sucursal', 
						'Region', 
						'Provincia',
						'Leyenda'
						);
$Tabla = 'Sucursales';									// Tabla sobre la cual trabajaremos
$PK = 'id';												// Nombre del campo Clave Principal
$CampoOrdenPre = 'Sucursales.sNombre';											// Campo de orden predeterminado
$TipoOrdenPre = 'ASC';									// Tipo de orden predeterminado
$RegPorPag = 100;	
													// Cantidad de registros por página
if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;

$PrimReg = ($Pagina - 1) * $RegPorPag;

$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";

if(isset($_POST['buscar']))
{
		
	$sNombreSucursal= $_POST['sNombreSucursal'];
	$idRegionSucursal= $_POST['idRegionSucursal'];
	$idProvinciaSucursal= $_POST['idProvinciaSucursal'];
	
	if(!session_is_registered('sNombreSucursal'))
	{
		session_register('sNombreSucursal');
		session_register('idRegionSucursal');
		session_register('idProvinciaSucursal');
	}
	
	$_SESSION['sNombreSucursal'] = $_POST['sNombreSucursal'];
	$_SESSION['idRegionSucursal'] = $_POST['idRegionSucursal'];
	$_SESSION['idProvinciaSucursal'] = $_POST['idProvinciaSucursal'];
	unset($_SESSION['volver']);
}
else {
	$sNombreSucursal = $_SESSION['sNombreSucursal'];
	$idRegionSucursal = $_SESSION['idRegionSucursal'];
	$idProvinciaSucursal = $_SESSION['idProvinciaSucursal'];
}
	$sWhere = "";
	
	$aCond=Array();
	
	if($sNombreSucursal) $aCond[]=" Sucursales.sNombre LIKE '%$sNombreSucursal%' ";	
	if($idRegionSucursal) $aCond[]=" Sucursales.idRegion = {$idRegionSucursal} ";
	if($idProvinciaSucursal) $aCond[]=" Sucursales.idProvincia = {$idProvinciaSucursal} ";
	
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
	
$sqlDatos="Call usp_getSucursales(\"$sCondiciones\");";
//$sqlDatos_sLim="Call usp_getSucursales(\"$sCondiciones_sLim\");";

// Cuento la cantidad de registros sin LIMIT
$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
// Ejecuto la consulta
$result = $oMysql->consultaSel($sqlDatos);
$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);

$CantRegFiltro = sizeof($result_sLim);

$aParametros['optionsRegiones'] = $oMysql->getListaOpciones("Regiones","id","sNombre");
$aParametros['optionsProvincias'] = $oMysql->getListaOpcionesCondicionado('idRegionSucursal', 'idProvinciaSucursal', 'Provincias', 'Provincias.id', 'Provincias.sNombre', 'idRegion', '', '',0);

$oXajax=new xajax();
$oXajax->setCharEncoding('ISO-8859-1');
$oXajax->configure('decodeUTF8Input',true);
$oXajax->registerFunction("guardarLeyendaSucursales");
$oXajax->processRequest();
$oXajax->printJavascript("../includes/xajax/");

//$aParametros['DHTMLX_WINDOW']=1;
xhtmlHeaderPaginaGeneral($aParametros);	

?>
<body style="background-color:#FFFFFF;">
<div id="BodyUser">
	
<?php 
//include("buscador.php");
echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorSucursalLeyenda.tpl",$aParametros);

if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result)
{	

  $sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p>
	<form id='formSucursalesLeyenda' action='' method='POST' >
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
	$sCadena .="<th style='cursor:pointer;'><input type='checkbox' onchange='tildar_checkboxs( this.checked )' id='checkbox_principal' /> </th>
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
		$sLeyenda = utf8_decode($rs['sLeyenda']);
		
		?>
		<tr id="empleado<?php echo $PK;?>">
			<!-- Valores -->			
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNombre']?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sRegion']?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sProvincia']?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sLeyenda']?></td>		
					
			<!-- Links para Mod. y Elim. -->
			<td align="center"><input type='checkbox' id='aSucursal[]' name='aSucursal[]' class="check_user" value='<?php echo $PK;?>'/> </td>
		</tr>
		<?
	}
	?>
	</tr>
	<tr>
	   <td colspan="7" align="right">	   	   
	   	   <div> 
	   	   		Leyenda: <input type="text" id="sLeyenda" name="sLeyenda" value=""}>
	   	    	<button type="button" onclick="guardar();"> Guardar </button> &nbsp;
	   	   </div>
	   </td>
	</tr> 
</table>
<div style='font-size:10px;text-align:left;width:80%'>
		<span class='rojo'>Rojo-Sucursales de Baja. <span><br>
</div>	
</form>

<?
	/*if (ceil($CantRegFiltro/$RegPorPag) > 1)
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
	}*/
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


function guardar()
{
	  var mensaje="¿Esta seguro de Guardar los cambios?"; 
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
	       xajax_guardarLeyendaSucursales(xajax.getFormValues('formSucursalesLeyenda'));
	  }
	  else alert('Debe Elegir al menos una Sucursal a habilitar.');	   
}
</script>
<?php echo xhtmlFootPagina();?>
