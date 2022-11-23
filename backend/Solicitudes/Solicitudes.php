<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );

	#Control de Acceso al archivo
	//if(!isLogin())
	//{
		//go_url("/index.php");
	//}
	$idObjeto = 23;
	$arrayPermit = explode(',',$_SESSION['_PERMISOS_'][$idObjeto]['sPermisos']);	
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
	$arrListaCampos = array('SolicitudesUsuarios.sNumero','SolicitudesUsuarios.dFechaPresentacion', 'InformesPersonales.sApellido','InformesPersonales.sDocumento','InformesPersonales.idLocalidad','TiposEstadosSolicitudes.sNombre');
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
	$idEstadoSolicitudes = 0;	
	if(isset($_POST['buscar']))
	{	
		$sNumero = $_POST['sNumero'];
		$idTipoDocumento = $_POST['idTipoDocumento'];
		$sDocumento = $_POST['sDocumento'];
		$sApellido = $_POST['sApellido'];
		$sNombre = $_POST['sNombre'];
		$idEstadoSolicitudes = $_POST['idEstadoSolicitudes'];
		
		$condic = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; //variable que se usa en la paginacion 

		//echo "Nombre ". $_POST['nombre_u'];
		if(!session_is_registered('sNumero'))
		{
			session_register('sNumero');
			session_register('idTipoDocumento');
			session_register('sDocumento');
			session_register('sApellido');
			session_register('sNombre');
			session_register('idEstadoSolicitudes');
			session_register('scondic');			
		}
		$_SESSION['sNumero'] = $_POST['sNumero'];
		$_SESSION['idTipoDocumento'] = $_POST['idTipoDocumento'];		
		$_SESSION['sDocumento'] = $_POST['sDocumento'];
		$_SESSION['sApellido'] = $_POST['sApellido'];
		$_SESSION['sNombre'] = $_POST['sNombre'];
		$_SESSION['idTipoDocumento'] = $_POST['idTipoDocumento'];
		$_SESSION['scondic'] = $_POST['condic'];
		unset($_SESSION['volver']);
	}
	else
	{
		$sNumero = $_SESSION['sNumero'];
		$idTipoDocumento = $_SESSION['idTipoDocumento'];
		$sDocumento = $_SESSION['sDocumento'];
		$sApellido = $_SESSION['sApellido'];
		$sNombre = $_SESSION['sNombre'];
		$idEstadoSolicitudes = $_SESSION['idEstadoSolicitudes'];
		$condic = $_SESSION['scondic'];	
		$condic1 = $_SESSION['scondic'];	
	}
	
	$sWhere = "";
	$aCond=Array();
	
	if($sNumero){$aCond[]=" SolicitudesUsuarios.sNumero LIKE '".trim($sNumero)."' ";}
	if($idTipoDocumento){$aCond[]=" InformesPersonales.idTipoDocumento = '".trim($idTipoDocumento)."' ";}
	if($sDocumento){$aCond[]=" InformesPersonales.sDocumento = '".trim($sDocumento)."' ";}
	if($sApellido){$aCond[]=" InformesPersonales.sApellido LIKE '%".trim($sApellido)."%' ";}
	if($sNombre){$aCond[]=" InformesPersonales.sNombre LIKE '%".trim($sNombre)."%' ";}
	if($idEstadoSolicitudes){$aCond[]=" SolicitudesUsuarios.idTipoEstado = ".trim($idEstadoSolicitudes)." ";}
	
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
	//echo $sCondiciones;
	
	$sqlDatos="Call usp_getSolicitudes(\"$sCondiciones\");";
	//$sqlDatos_sLim="Call usp_getSolicitudes(\"$sCondiciones_sLim\");";
	$sqlDatos_sLim=	"SELECT COUNT(SolicitudesUsuarios.id)
		FROM SolicitudesUsuarios
		LEFT JOIN InformesPersonales ON InformesPersonales.idSolicitudUsuario = SolicitudesUsuarios.id {$sCondiciones_sLim}";  
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	
	$CantRegFiltro = $oMysql->consultaSel($sqlDatos_sLim,true);
	
	$aParametros['optionsTipoDoc'] = $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre',$idTipoDocumento);
	
	$oXajax=new xajax();
	
	$oXajax->registerFunction("updateEstadoSolicitud");
	$oXajax->registerFunction("updateDatosSolicitud");

	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
	$aParametros['FORM'] = "Solicitudes.php";
	$aParametros['TITULO'] = "Solicitudes";
	
	$aParametros['OPTIONS_ESTADOS'] = $oMysql->getListaOpciones( 'TiposEstadosSolicitudes', 'id', 'sNombre',$idEstadoSolicitudes);

?>
<body style="background-color:#FFFFFF;">
	
<?php 

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorSolicitudes.tpl",$aParametros);

//if(in_array(AGREGAR,$arrayPermit)){		
?>
<p><img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo"> <a href="AdminSolicitudes.php?optionEditar=1&url_back=Solicitudes.php"><? if($Masculino) echo 'Nuevo '; else echo 'Nueva '; echo $NombreTipoRegistro;?></a></p>
<?
//}

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
	$sCadena .="<th colspan='2'>Acciones</th></tr>";
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
			
			if(($rs['idTipoEstado'] == 3)||($rs['idTipoEstado'] == 4))//Anulada o Rechaza
				$oBtn->addBoton("Pendiente{$rs['id']}","onclick","pendienteSolicitud({$rs['id']},'{$rs['sNumero']}')",'Up','Pendiente de Aprobacion',true,true);	
			
			if($rs['idTipoEstado'] == 2 ){ //Dada de Alta
				$oBtn->addBoton("Modificar{$rs['id']}","onclick","editarSolicitud({$rs['id']},2)",'Buscar16','Visualizar',true,true);
			}		
			if($rs['idTipoEstado'] == 1 || $rs['idTipoEstado'] == 2){ //Pendiente de Aprobacion
				if(in_array(MODIFICAR,$arrayPermit)){
					$oBtn->addBoton("Modificar{$rs['id']}","onclick","editarSolicitud({$rs['id']},4)",'Editar','Modificar',true,true);	
				}
				//$oBtn->addBoton("Eliminar{$rs['id']}","onclick","eliminarSolicitud({$rs['id']})",'Eliminar','Eliminar',true,true);	
				$oBtn->addBoton("Anular{$rs['id']}","onclick","anularSolicitud({$rs['id']},'{$rs['sNumero']}')",'Eliminar','Anular',true,true);	
				$oBtn->addBoton("Rechazar{$rs['id']}","onclick","rechazarSolicitud({$rs['id']},'{$rs['sNumero']}')",'Down','Rechazar',true,true);	
			}
			
			$oBtn->addBoton("Historial{$rs['id']}","onclick","historialSolicitud({$rs['id']},'{$rs['sNumero']}')",'Historial','Historial',true,true);	
			if(in_array(MODIFICAR,$arrayPermit)){
			$oBtn->addBoton("Configurar{$rs['id']}","onclick","setearEstadoSolicitud({$rs['id']},{$rs['idTipoEstado']},'{$rs['sNumero']}')",'Configurar','Cambiar Estado',true,true);		
			}
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
			
		</tr>
		<?
	}
	?>
	</table>
	<!--<div style='font-size:10px;text-align:left;width:80%'>
		<span class='rojo'>Rojo-Solicitudes Rechazas. <span><br><span class='naranja'>Naranja-Solicitudes Anuladas <span><br><span class='azul'>Azul-Solicitudes de Alta<span>
	</div>-->
	
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
</center>
<script>
function doOnLoad() {
    dhxWins = new dhtmlXWindows();
    dhxWins.enableAutoViewport(false);
    dhxWins.attachViewportTo("dhtmlx_wins_body_content");
    dhxWins.setImagePath("../../codebase/imgs/");
}
function editarSolicitud(idSolicitud,optionEditar){
	window.location ="AdminSolicitudes.php?id="+ idSolicitud+"&optionEditar="+optionEditar+"&url_back=Solicitudes.php";
}

function eliminarSolicitud(idSolicitud){
	if(confirm("¿Desea dar de Baja la Solicitud?")){
		xajax_updateEstadoSolicitud(idSolicitud,'B');
	}
}

function anularSolicitud(idSolicitud,sNumero){
	//top.getBoxCambiarEstadoSolicitud(idSolicitud,4);
	createWindows('CambiarEstadoSolicitud.php?id='+idSolicitud+'&idEstado=4','Tarjeta',2,'SOL', 510, 320);
}

function rechazarSolicitud(idSolicitud,sNumero){
	//top.getBoxCambiarEstadoSolicitud(idSolicitud,3);
	createWindows('CambiarEstadoSolicitud.php?id='+idSolicitud+'&idEstado=3','Tarjeta',3,'SOL', 510, 320);
}

function pendienteSolicitud(idSolicitud,sNumero){
	//top.getBoxCambiarEstadoSolicitud(idSolicitud,1);
	createWindows('CambiarEstadoSolicitud.php?id='+idSolicitud+'&idEstado=1','Tarjeta',2,'SOL', 510, 320);
}

function historialSolicitud(idSolicitud,sNumero){
	createWindows('HistorialSolicitud.php?id='+idSolicitud+'&sNumero='+sNumero,'Tarjeta',1,'SOL',610, 300);
}	

var dhxWins;
function createWindows(sUrl,sTitulo,idProyecto_,tipo_,width,height){
    var idWind = "window_"+idProyecto_+"_"+tipo_;
	//if(!dhxWins.window(idWind)){
     	dhxWins = new dhtmlXWindows();     	
	    dhxWins.setImagePath("../includes/grillas/dhtmlxWindows/sources/imgs/");	  
	    _popup_ = dhxWins.createWindow(idWind, 250, 50, width, height);
	    _popup_.setText(sTitulo);
	    ///_popup_.center();
	    _popup_.button("close").attachEvent("onClick", closeWindows);
		_url_ = sUrl;
	    _popup_.attachURL(_url_);
	//}
} 

function closeWindows(_popup_){
	_popup_.close();
}  	

function recargar(){
	window.location ="Solicitudes.php";
}	   	


function setearEstadoSolicitud(id,idTipoEstado,sNumero)
{	
	createWindows('CambiarEstadoSolicitudVarios.php?id='+id+"&idTipoEstado="+idTipoEstado+"&operacion=1&sNumero="+sNumero,'Tarjeta','1','SOL', 510, 320);
}
</script>
