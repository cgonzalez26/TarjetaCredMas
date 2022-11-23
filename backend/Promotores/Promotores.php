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
	
	//var_export($cant); die();
	
	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
		
	if ($Pagina <= 0) $Pagina = 1;

	$NombreMod = 'Promotores'; // Nombre del modulo
	$NombreTipoRegistro = 'Promotor';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Promotores'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('Empleados.sApellido','Oficinas.sApodo','Empleados.sMail');
	$arrListaEncabezados = array('Empleado','Oficina','E-mail');
	$Tabla = 'Empleados'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'Empleados.sApellido'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;
	
	$sApellidoPromotor = "";
	$sNombrePromotor = "";	
	
	if(isset($_POST['buscar']))
	{	
		$sApellidoPromotor = $_POST['sApellidoPromotor'];
		$sNombrePromotor = $_POST['sNombrePromotor'];
		$idSucursalPromotor = $_POST['idSucursalPromotor'];
		$idOficinaPromotor = $_POST['idOficinaPromotor'];
		
		if(!session_is_registered('sApellidoPromotor'))
		{
			session_register('sApellidoPromotor');
			session_register('sNombrePromotor');
			session_register('idSucursalPromotor');
			session_register('idOficinaPromotor');
		}
		$_SESSION['sApellidoPromotor'] = $_POST['sApellidoPromotor'];
		$_SESSION['sNombrePromotor'] = $_POST['sNombrePromotor'];
		$_SESSION['idSucursalPromotor'] = $_POST['idSucursalPromotor'];
		$_SESSION['idOficinaPromotor'] = $_POST['idOficinaPromotor'];
		
		unset($_SESSION['volver']);
	
	}else{
		$sApellidoPromotor = $_SESSION['sApellidoPromotor'];
		$sNombrePromotor = $_SESSION['sNombrePromotor'];
		$idSucursalPromotor =  $_SESSION['idSucursalPromotor'];
		$idOficinaPromotor =  $_SESSION['idOficinaPromotor'];
	}

	$sWhere = "";
	$aCond=Array();
	
	if($sApellidoPromotor){$aCond[]=" Empleados.sApellido LIKE '%$sApellidoPromotor%' ";}
	if($sNombrePromotor){$aCond[]=" Empleados.sNombre LIKE '%$sNombrePromotor%' ";}
	if($idSucursalPromotor){$aCond[]=" Oficinas.idSucursal = '$idSucursalPromotor' ";}
	if($idOficinaPromotor){$aCond[]=" Empleados.idOficina = '$idOficinaPromotor' ";}
	
	$sqlCuenta = "SELECT COUNT(Empleados.id) FROM $Tabla LEFT JOIN EmpleadosUnidadesNegocios ON EmpleadosUnidadesNegocios.idEmpleado=Empleados.id WHERE EmpleadosUnidadesNegocios.idTipoEmpleadoUnidadNegocio = 25 AND EmpleadosUnidadesNegocios.idUnidadNegocio = 2 AND Empleados.sEstado <> 'B'";
	 
	if(count($aCond)>0){
		$aCond[]= " EmpleadosUnidadesNegocios.idTipoEmpleadoUnidadNegocio = 25";
		$aCond[]= " EmpleadosUnidadesNegocios.idUnidadNegocio = 2";
		$aCond[]= " Empleados.sEstado <> 'B'";
		
		$sCondiciones= " LEFT JOIN EmpleadosUnidadesNegocios ON EmpleadosUnidadesNegocios.idEmpleado=Empleados.id WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
		$sCondiciones_sLim=" LEFT JOIN EmpleadosUnidadesNegocios ON EmpleadosUnidadesNegocios.idEmpleado=Empleados.id WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
		$sqlDatos="Call usp_getEmpleados(\"$sCondiciones\");";
		$sqlDatos_sLim="Call usp_getEmpleados(\"$sCondiciones_sLim\");";
		
		// Cuento la cantidad de registros sin LIMIT
		$CantReg = $oMysql->consultaSel($sqlCuenta);
		
		// Ejecuto la consulta
		$result = $oMysql->consultaSel($sqlDatos);
		$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		$CantRegFiltro = sizeof($result_sLim);
	}	
	
	$sCondicionCanal = " Canales.sEstado<>'B' AND Canales.idRegion ={$_SESSION['ID_REGION']}";
	$aParametros['optionsCanales'] = $oMysql->getListaOpciones('Canales','id','sNombre',0,$sCondicionCanal);
	$sCondicionSucursal = " Sucursales.idRegion ={$_SESSION['ID_REGION']}";
	$aParametros['optionsSucursales'] = $oMysql->getListaOpciones('Sucursales','id','sNombre','',$sCondicionSucursal);
	$aParametros['optionsOficinas'] = $oMysql->getListaOpcionesCondicionado('idSucursalPromotor','idOficinaPromotor','Oficinas','id','sApodo','idSucursal','','','');
	
	$oXajax=new xajax();
	
	$oXajax->registerFunction("updateEstadoPromotores");
	$oXajax->registerFunction("updateDatosPromotores");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
?>
<body style="background-color:#FFFFFF;">

	<center>
<?php 
echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorPromotores.tpl",$aParametros);

if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if (count($result)>0){	
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
				$sCadena .= "<img src='../includes/images/go-up.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendente' title='Ordenado por {$arrListaEncabezados[$i]} Ascendente'/></a>"; 
			else 
				$sCadena .= "<img src='../includes/images/go-down.png' alt='Ordenado por {$arrListaEncabezados[$i]} Descendente' title='Ordenado por {$arrListaEncabezados[$i]} Descendente'/></a>";
		}
		$sCadena .= "</th>\r\n";
	}
  
	///Opciones de Mod. y Elim.
	$sCadena .="<th colspan='2'>Acciones</th></tr>";
    echo $sCadena;
    
    $CantMostrados = 0;
	
	foreach ($result as $rs)
	{	
		$sBotonera = '';	
		$CantMostrados ++;
		$PK = $rs['id'];
		$sClase='';		
	
		$sUsuario=$rs['sApellido'].', '.$rs['sNombre'];
		
		$oBtn = new aToolBar();
		$oBtn->setAnchoBotonera('auto');
		$oBtn->addBoton("Modificar{$rs['id']}","onclick","editarPromotor({$rs['id']})",'Editar','Modificar',true,true);	
		
		//if(in_array($idUser,array(1,296)));
		//	$oBtn->addBoton("Configurar{$rs['id']}","onclick","SetearPermisos({$rs['id']},'{$sUsuario}')",'Configurar','Permisos',true,true);	
		
		$sBotonera = $oBtn->getBotoneraToolBar('');		
		?>
		<tr id="empleado<?php echo $PK;?>">
			<!-- Valores -->			
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$sUsuario?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sOficina']?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sMail']?></td>	
			<!-- Links para Mod. y Elim. -->
			<td colspan="2" align="center">
			<?=$sBotonera;?>
			</td>
		</tr>
		<?
	}
}
?>
<script>
function editarPromotor(id){
	window.location ="AdminPromotores.php?id="+ id;	
}
</script>
