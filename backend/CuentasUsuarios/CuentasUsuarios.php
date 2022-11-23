<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );

	$idObjeto = 28;
	$arrayPermit = explode(',',$_SESSION['_PERMISOS_'][$idObjeto]['sPermisos']);

	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	

	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
	
	if(isset($_POST['buscar'])){
		 $_SESSION['paggging_cuenta_usuario']  = 1;
	}
		
			

	
	if(!isset($_SESSION['paggging_cuenta_usuario'])){
		$_SESSION['paggging_cuenta_usuario']  = 1;
	}
	
	$Pagina = (isset($_GET['Pagina'])) ? $_GET['Pagina'] : $_SESSION['paggging_cuenta_usuario'] ;
	
	if ($Pagina <= 0) $Pagina = 1;
	
	$_SESSION['paggging_cuenta_usuario'] = $Pagina;
	
	if($_SESSION['id_user'] == 296){
		//var_export($_SESSION['paggging_cuenta_usuario']);
	}
	
	//if(!session_get_var('pagging_users')){ session_add_var('pagging_users',0); }
	
	//$pagging = (isset($_GET['p'])) ? $_GET['p'] : session_get_var('pagging_users') ;
	
	//session_add_var('pagging_users',$pagging);
		
	

	$NombreMod = 'Cuentas'; // Nombre del modulo
	$NombreTipoRegistro = 'Cuenta';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Cuentas'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('CuentasUsuarios.sNumeroCuenta','CuentasUsuarios.dFechaRegistro', 'InformesPersonales.sApellido','InformesPersonales.sDocumento','InformesPersonales.idProvincia','InformesPersonales.idLocalidad','CuentasUsuarios.idEstado');
	$arrListaEncabezados = array('Nro. Cuenta','Fecha Alta','Titular','Documento','Localidad','Estado');
	$Tabla = 'CuentasUsuarios'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'CuentasUsuarios.dFechaRegistro'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
	$idRegionCuenta = 0;
	$idSucursalCuenta = 0;
		
	if(isset($_POST['buscar']))
	{	
		$sNumeroCuenta = $_POST['sNumeroCuenta'];
		$idTipoDocumentoCuenta = $_POST['idTipoDocumentoCuenta'];
		$sDocumentoCuenta = $_POST['sDocumentoCuenta'];
		$sApellidoCuenta = $_POST['sApellidoCuenta'];
		$sNombreCuenta = $_POST['sNombreCuenta'];
		$idRegionCuenta = $_POST['idRegionCuenta'];
		$idSucursalCuenta = $_POST['idSucursalCuenta'];
		$idEstadoCuenta = $_POST['idEstadoCuenta'];
		
		$condic = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; //variable que se usa en la paginacion 

	
		//echo "Nombre ". $_POST['nombre_u'];
		if(!session_is_registered('sNumeroCuenta'))
		{
			session_register('sNumeroCuenta');
			session_register('idTipoDocumentoCuenta');
			session_register('sDocumentoCuenta');
			session_register('sApellidoCuentaCuenta');
			session_register('sNombreCuentaCuenta');
			session_register('idRegionCuenta');
			session_register('idSucursalCuenta');	
			session_register('idEstadoCuenta');
		}
		$_SESSION['sNumeroCuenta'] = $_POST['sNumeroCuenta'];
		$_SESSION['idTipoDocumentoCuenta'] = $_POST['idTipoDocumentoCuenta'];		
		$_SESSION['sDocumentoCuenta'] = $_POST['sDocumentoCuenta'];
		$_SESSION['sApellidoCuenta'] = $_POST['sApellidoCuenta'];
		$_SESSION['sNombreCuenta'] = $_POST['sNombreCuenta'];
		$_SESSION['idRegionCuenta'] = $_POST['idRegionCuenta'];
		$_SESSION['idSucursalCuenta'] = $_POST['idSucursalCuenta'];
		$_SESSION['idEstadoCuenta'] = $_POST['idEstadoCuenta'];
		unset($_SESSION['volver']);
	}
	else
	{
		$sNumeroCuenta = $_SESSION['sNumeroCuenta'];
		$idTipoDocumentoCuenta = $_SESSION['idTipoDocumentoCuenta'];
		$sDocumentoCuenta = $_SESSION['sDocumentoCuenta'];
		$sApellidoCuenta = $_SESSION['sApellidoCuenta'];
		$sNombreCuenta = $_SESSION['sNombreCuenta'];
		$idRegionCuenta = $_SESSION['idRegionCuenta'];
		$idSucursalCuenta = $_SESSION['idSucursalCuenta'];
		$idEstadoCuenta = $_SESSION['idEstadoCuenta'];
	}

	$sWhere = "";
	$aCond=Array();
	
	if($sNumeroCuenta){$aCond[]=" CuentasUsuarios.sNumeroCuenta LIKE '".trim($sNumeroCuenta)."' ";}
	if($idTipoDocumentoCuenta){$aCond[]=" InformesPersonales.idTipoDocumento = '".trim($idTipoDocumentoCuenta)."' ";}
	if($sDocumentoCuenta){$aCond[]=" InformesPersonales.sDocumento = '".trim($sDocumentoCuenta)."' ";}
	if($sApellidoCuenta){$aCond[]=" InformesPersonales.sApellido LIKE '%".trim($sApellidoCuenta)."%' ";}
	if($sNombreCuenta){$aCond[]=" InformesPersonales.sNombre LIKE '%".trim($sNombreCuenta)."%' ";}
	
	$sEmpleadosRegion = "";
	$sEmpleadosSucursal = "";
	if($idRegionCuenta){
		$aEmpleadosRegion = $oMysql->consultaSel("SELECT Empleados.id FROM Empleados 
			LEFT JOIN Oficinas ON Oficinas.id= Empleados.idOficina LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal LEFT JOIN Regiones ON Regiones.id=Sucursales.idRegion
			WHERE Regiones.id = {$idRegionCuenta} ORDER BY Empleados.id DESC");

		$sEmpleadosRegion .= implode(",",$aEmpleadosRegion);		
		
	}
	if($idSucursalCuenta){
		$aEmpleadosSucursal = $oMysql->consultaSel("SELECT Empleados.id FROM Empleados 
			LEFT JOIN Oficinas ON Oficinas.id= Empleados.idOficina LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal 
			WHERE Sucursales.id = {$idSucursalCuenta} ORDER BY Empleados.id DESC");
		$sEmpleadosSucursal = implode(",",$aEmpleadosSucursal);		
		//echo $sEmpleadosSucursal;
	}
	if($sEmpleadosSucursal != ""){
		$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosSucursal})";
	}else{
		if($sEmpleadosRegion != ""){
			$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosRegion})";
		}
	}
	if($idEstadoCuenta){$aCond[]=" CuentasUsuarios.idTipoEstadoCuenta = '".trim($idEstadoCuenta)."' ";}
	 
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
	//echo $sCondiciones;
	
	$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondiciones\");";
	$sqlDatos_sLim="Call usp_getCuentasUsuarios(\"$sCondiciones_sLim\");";
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);

	$aParametros['optionsTipoDoc'] = $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre',$idTipoDocumentoCuenta);
	$aParametros['optionsRegiones'] = $oMysql->getListaOpciones("Regiones","id","sNombre",$idRegionCuenta);
	$aParametros['optionsSucursales'] = $oMysql->getListaOpcionesCondicionado( 'idRegionCuenta', 'idSucursalCuenta', 'Sucursales', 'id', 'sNombre', 'idRegion','','',$idSucursalCuenta);
	$aParametros['optionsEstadosCuentas'] = $oMysql->getListaOpciones( 'TiposEstadosCuentas', 'id', 'sNombre',$idEstadoCuenta);
	
	$oXajax=new xajax();
	
	$oXajax->registerFunction("updateEstadoCuentasUsuarios");
	$oXajax->registerFunction("updateDatosCuentasUsuarios");
	$oXajax->registerFunction("darBajaCuentaUsuario");
	$oXajax->registerFunction("darBajaLogicaCuentaUsuario");
	$oXajax->registerFunction("reactivarCuentaUsuario");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
?>
<body style="background-color:#FFFFFF;">

	<center>
<?php 
echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorCuentasUsuarios.tpl",$aParametros);

if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result){	

	 echo 
  "<div id='' class='div_menu_buttons' style='text-align:right !important;width:720px;'>
  	<img hspace='4' border='0' align='absmiddle' alt='' src='".IMAGES_DIR."/icons/excel16.png'>
  	<a id='' class='link_' title='exportar' alt='exportar' href='javascript:exportarXLS();'>exportar</a>	
  </div>";	
		
	
  $sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p>
   <form action='xlsCuentas.php' method='GET' name='form_table_object' id='form_table_object' style='display:inline;'>  
	<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='90%' id='tablaCuentasUsuarios'>
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
		<th style='cursor:pointer;'><input type='checkbox' onchange='tildar_checkboxs( this.checked )' id='checkbox_principal' /> </th>
		</tr>";
    echo $sCadena;

	$CantMostrados = 0;
	foreach ($result as $rs ){
		$sBotonera = '';	
		$CantMostrados++;
		$PK = $rs['id'];
		$sClase='';

		if($rs['idTipoEstadoCuenta'] ==12){
			$sClase="class='rojo'"; 
		}
		$sUsuario = "";
		if($rs['iTipoPersona'] == 2)					
			$sUsuario .= $rs['sRazonSocial'];				
		else
			$sUsuario .= $rs['sNombre']." ".$rs['sApellido'];		
		//$sUsuario = $rs['sApellido'].', '.$rs['sNombre'];
		$optionEditar = 0;
		$oBtn = new aToolBar();
		$oBtn->setAnchoBotonera('auto');	
		
		$sBotonera='&nbsp;';
			
		$param = base64_encode($rs['id']);
		$oBtn->addBoton("MostrarLimite{$rs['id']}","onclick","editarLimite('{$param}')",'Limite','Limites',true,true);		
		$oBtn->addBoton("Mostrar{$rs['id']}","onclick","editarCuenta({$rs['id']})",'Buscar16','Visualizar',true,true);		
		$oBtn->addBoton("Solicitud{$rs['id']}","onclick","editarSolicitud({$rs['idSolicitud']},2)",'Solicitud','Solicitud de la Cuenta',true,true);	
		$oBtn->addBoton("Historial{$rs['id']}","onclick","historialCuenta({$rs['id']},'{$rs['sNumeroCuenta']}')",'Historial','Historial de la Cuenta',true,true);				
		if(in_array(baja_logica,$arrayPermit)){
			if($rs['idTipoEstadoCuenta'] !=12){
				$oBtn->addBoton("DarBaja{$rs['id']}","onclick","darbajaCuenta({$rs['id']},'{$sUsuario}')",'Eliminar','Eliminar',true,true);				
			}else{
				$oBtn->addBoton("Reactivar{$rs['id']}","onclick","reactivarCuenta('{$param}','{$rs['sNumeroCuenta']}','{$sUsuario}')",'Reactivar','Reactivar',true,true);
			}
		}
		if(in_array(ELIMINAR,$arrayPermit)){				
					$oBtn->addBoton("EliminarDefinitivo{$rs['id']}","onclick","eliminarDefinitivo({$rs['id']},'{$sUsuario}')",'EliminarDefinitivo','Eliminar Definitivo',true,true);		
		}			 
		
		$oBtn->addBoton("Resumen{$rs['id']}","onclick","resumenCuenta({$rs['id']})",'Resumen','Mostrar Resumen',true,true);
		if(in_array(acceder_como_admin,$arrayPermit)){
			$oBtn->addBoton("Configurar{$rs['id']}","onclick","setearEstadoCuenta({$rs['id']},'{$rs['sNumeroCuenta']}',{$rs['idTipoEstadoCuenta']})",'Configurar','Cambiar Estado',true,true);		
		}
		
		$sBotonera = $oBtn->getBotoneraToolBar('');	
		
			
		?>
		<tr id="empleado<?php echo $PK;?>">
			<!-- Valores -->
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumeroCuenta'];?></td>
			<td width="15%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['dFechaRegistro'];?></td>
			<td width="25%" align="left" <?php echo $sClase;?>>&nbsp;<?=$sUsuario;?></td>
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sDocumento'];?></td>	
			<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sLocalidad'];?></td>	
			<td width="15%" id="estado<?php echo$rs['sNumero']?>" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sEstado'];?></td>	
			<!-- Links para Mod. y Elim. -->
			<td colspan="2" align="center" width="5%">
				<?=$sBotonera;?>
			</td>
			<td align="center"><input type='checkbox' id='aCuentas[]' name='aCuentas[]' class="check_user" value='<?php echo $PK;?>'/> </td>
		</tr>
		<?
	}
	if(in_array(acceder_como_admin,$arrayPermit)){
	?>
	<tr>
	   <td colspan="9" align="right">
	   	   <div> 
	   	    	<button type="button" onclick="generarResumen();"> Generar Resumen </button>
	   	   </div>
	   </td>
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
function eliminarDefinitivo(idCuenta,sTitular){
	var msje = "Esta seguro que desea Eliminar la Cuenta de "+sTitular+"?";
	var iDelete = 0;
	
	if(confirm(msje)){
		
		if(confirm("¿Elimina la  Solicitud?")){
			iDelete = 1;
		}else{
			iDelete = 0;
		}
		
		xajax_darBajaCuentaUsuario(idCuenta,iDelete);
	}
}

function darbajaCuenta(idCuenta,sTitular){
	var msje = "Esta seguro que desea Dar de Baja la Cuenta de "+sTitular+"?";
	var iDelete = 0;
	
	if(confirm(msje)){
		xajax_darBajaLogicaCuentaUsuario(idCuenta);
	}
}

function editarLimite(idCuenta){
	createWindows('../Limites/ReasignarLimites.php?id='+idCuenta,'Tarjeta',2,'LIM',800, 620);
}

function editarSolicitud(idSolicitud,optionEditar){
	window.location ="../Solicitudes/AdminSolicitudes.php?id="+ idSolicitud+"&optionEditar="+optionEditar+"&url_back=../CuentasUsuarios/CuentasUsuarios.php";
}

function editarCuenta(id){
	window.location ="AdminCuentasUsuarios.php?id="+ id;
}

function historialCuenta(idCuenta,sNumero){
	//top.getBoxHistorialCuenta(idCuenta,sNumero);
	createWindows("HistorialCuenta.php?id="+idCuenta+"&sNumero="+sNumero,'Tarjeta',1,'SOL',610, 300);
}	

function resumenCuenta(id){
	window.location ="Resumen.php?id="+ id;
}

function obtenerSeleccionados(){
	var el = document.getElementById('tablaCuentasUsuarios');
	var imputs= el.getElementsByTagName('input');
	var sCuentas = "";
  	for (var i=0; i<imputs.length; i++){
  	 	 if (imputs[i].type=='checkbox') 		    	
    		if(imputs[i].checked && imputs[i].className =="check_user"){ 
    			sCuentas += imputs[i].value+',';
    		}
  	} 
  	sCuentas =  sCuentas.substring(0,sCuentas.length-1); 
  	return sCuentas;
}

function generarResumen(){
  var el = document.getElementById('tablaCuentasUsuarios');
  var imputs= el.getElementsByTagName('input');
  var band=0;		  		  
  for (var i=0; i<imputs.length; i++){			
    if (imputs[i].type=='checkbox'){ 		    	
    	if(!imputs[i].checked){
         	band=0; 
     	}else{ 
     		band=1; break;
     	}
    }	
  }
  	
  if(band==1)
  {
  	 var sCuentas = obtenerSeleccionados();
  	 createWindows('GenerarResumenesPorCuenta.php?sCuentas='+sCuentas,'Tarjeta','1','1',520, 250);
  }		
  else alert('Debe Elegir al menos una Cuenta de Usuario para Generar Resumen.');	   
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
	recargar();
} 

function recargar(){
	window.location ="CuentasUsuarios.php";
}

function exportarXLS(){
	var form = document.forms['form_table_object'];
	form.submit();
}

function reactivarCuenta(id,sNumero,sTitular){
	createWindows('ReactivarCuenta.php?id='+id+'&sNumero='+sNumero,'Tarjeta',2,'LIM',420, 220);
}


function setearEstadoCuenta(id,sNumero,idTipoEstadoCuenta)
{	
	createWindows('CambiarEstadoCuenta.php?id='+id+"&sNumero="+sNumero+'&idTipoEstadoCuenta='+idTipoEstadoCuenta,'Tarjeta','1','SOL', 510, 320);
}

</script>
