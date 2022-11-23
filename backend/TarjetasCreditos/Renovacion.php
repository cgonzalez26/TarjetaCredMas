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

	$NombreMod = 'Tarjetas'; // Nombre del modulo
	$NombreTipoRegistro = 'Tarjeta';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Tarjetas'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('Tarjetas.sNumeroTarjeta','Usuarios.dFechaRegistro', 'Usuarios.sApellido','Usuarios.sDocumento','DomiciliosUsuarios.idProvincia','DomiciliosUsuarios.idLocalidad');
	$arrListaEncabezados = array('Nro. Tarjeta','Fecha Alta','Titular','Documento','Localidad');
	$Tabla = 'Tarjetas'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'Tarjetas.dFechaRegistro'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
		
	if(isset($_POST['buscar']))
	{	
		$sNumeroCuentaTarjeta = $_POST['sNumeroCuentaTarjeta'];
		$idTipoDocumentoTarjeta = $_POST['idTipoDocumentoTarjeta'];
		$sDocumentoTarjeta = $_POST['sDocumentoTarjeta'];
		$sApellidoTarjeta = $_POST['sApellidoTarjeta'];
		$sNombreTarjeta = $_POST['sNombreTarjeta'];
		$condic = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; //variable que se usa en la paginacion 

		//echo "Nombre ". $_POST['nombre_u'];
		if(!session_is_registered('sNumeroCuentaTarjeta'))
		{
			session_register('sNumeroCuentaTarjeta');
			session_register('idTipoDocumentoTarjeta');
			session_register('sDocumentoTarjeta');
			session_register('sApellidoTarjeta');
			session_register('sNombreTarjeta');
		}
		$_SESSION['sNumeroCuentaTarjeta'] = $_POST['sNumeroCuentaTarjeta'];
		$_SESSION['idTipoDocumentoTarjeta'] = $_POST['idTipoDocumentoTarjeta'];		
		$_SESSION['sDocumentoTarjeta'] = $_POST['sDocumentoTarjeta'];
		$_SESSION['sApellidoTarjeta'] = $_POST['sApellidoTarjeta'];
		$_SESSION['sNombreTarjeta '] = $_POST['sNombreTarjeta'];
		unset($_SESSION['volver']);
	}
	else
	{
		$sNumeroCuentaTarjeta = $_SESSION['sNumeroCuentaTarjeta'];
		$idTipoDocumentoTarjeta = $_SESSION['idTipoDocumentoTarjeta'];
		$sDocumentoTarjeta = $_SESSION['sDocumentoTarjeta'];
		$sApellidoTarjeta = $_SESSION['sApellidoTarjeta'];
		$sNombreTarjeta = $_SESSION['sNombreTarjeta'];
	}

	$sWhere = "";
	$aCond=Array();
	
	if($sNumeroCuentaTarjeta){$aCond[]=" CuentasUsuarios.sNumeroCuenta = '$sNumeroCuentaTarjeta' ";}
	if($idTipoDocumentoTarjeta){$aCond[]=" Usuarios.idTipoDocumento = '$idTipoDocumentoTarjeta' ";}
	if($sDocumentoTarjeta){$aCond[]=" Usuarios.sDocumento = '$sDocumentoTarjeta' ";}
	if($sApellidoTarjeta){$aCond[]=" Usuarios.sApellido LIKE '%$sApellidoTarjeta%' ";}
	if($sNombreTarjeta){$aCond[]=" Usuarios.sNombre LIKE '%$sNombreTarjeta%' ";}
	$aCond[]=" Tarjetas.dVigenciaHasta <= NOW()";
	 
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
	//echo $sCondiciones;
	
	$sqlDatos="Call usp_getTarjetas(\"$sCondiciones\");";
	$sqlDatos_sLim="Call usp_getTarjetas(\"$sCondiciones_sLim\");";
	//echo $sqlDatos;
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);

	$aParametros['optionsTipoDoc'] = $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre');
	
	$oXajax=new xajax();
	
	$oXajax->registerFunction("renovarTarjetasCreditos");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
	
$aParametros['FORM_BACK'] = "Renovacion.php";
?>
<body style="background-color:#FFFFFF;">

	<center>
<?php 
echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorTarjetasCreditos.tpl",$aParametros);

if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result){	

  $sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</p>
  	<form action='Renovacion.php' id='formTarjetas' method='POST'>
  	<input type='hidden' id='URL_BAK' name='URL_BAK' value='Renovacion.php' />
  	
	<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='90%' id='tablaTarjetas'>
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
	$sCadena .="<th colspan='2'>Acciones</th><th style='cursor:pointer;width:20px'><input type='checkbox' onchange='tildar_checkboxs( this.checked )' id='checkbox_principal' /> </th></tr>";
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
			$sBotonera='&nbsp;';
			/*if(($rs['idTipoEstado'] == 3)||($rs['idTipoEstado'] == 4))//Anulada o Rechaza
				$oBtn->addBoton("Pendiente{$rs['id']}","onclick","pendienteSolicitud({$rs['id']})",'Up','Pendiente de Aprobacion',true,true);	
			
			if($rs['idTipoEstado'] == 2){ //Dada de Alta
				$oBtn->addBoton("Modificar{$rs['id']}","onclick","editarSolicitud({$rs['id']},2)",'Buscar16','Visualizar',true,true);	
			}		
			if($rs['idTipoEstado'] == 1){ //Pendiente de Aprobacion
				$oBtn->addBoton("Modificar{$rs['id']}","onclick","editarSolicitud({$rs['id']},1)",'Editar','Modificar',true,true);	
				//$oBtn->addBoton("Eliminar{$rs['id']}","onclick","eliminarSolicitud({$rs['id']})",'Eliminar','Eliminar',true,true);	
				$oBtn->addBoton("Anular{$rs['id']}","onclick","anularSolicitud({$rs['id']})",'Eliminar','Anular',true,true);	
				$oBtn->addBoton("Rechazar{$rs['id']}","onclick","rechazarSolicitud({$rs['id']})",'Down','Rechazar',true,true);	
			}*/
			$oBtn->addBoton("Historial{$rs['id']}","onclick","historialTarjeta({$rs['id']},'{$rs['sNumeroTarjeta']}')",'Historial','Historial de la Tarjeta',true,true);	
				
			$sBotonera = $oBtn->getBotoneraToolBar('');		
		}
		?>
		<tr id="empleado<?php echo $PK;?>">
			<!-- Valores -->
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumeroTarjeta'];?></td>
			<td width="15%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['dFechaRegistro'];?></td>
			<td width="25%" align="left" <?php echo $sClase;?>>&nbsp;<?=$sUsuario;?></td>
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sDocumento'];?></td>	
			<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sLocalidad'];?></td>				
			<!-- Links para Mod. y Elim. -->
			<td colspan="2" align="center" width="5%">
				<?=$sBotonera;?>
			</td>
			<td align="center" width="2%"><input type='checkbox' id='aTarjetas[]' name='aTarjetas[]' class="check_user" value='<?php echo $PK;?>'/> </td>
		</tr>
		<?
	}
	?>
	<tr>
	   <td colspan="8" align="right">
	   	   <div> 
	   	    	<button type="button" onclick="renovarTarjetasCreditos();"> Renovar </button> &nbsp;
	   	   </div>
	   </td>
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
function editarSolicitud(idSolicitud,optionEditar){
	window.location ="../Solicitudes/AdminSolicitudes.php?id="+ idSolicitud+"&optionEditar="+optionEditar+"&url_back=../CuentasUsuarios/CuentasUsuarios.php";
}

function editarCuenta(id){
	window.location ="AdminCuentasUsuarios.php?id="+ id;
}

function historialTarjeta(idTarjeta,sNumero){
	top.getBoxHistorialTarjeta(idTarjeta,sNumero);
}	


function renovarTarjetasCreditos(){
	  var mensaje="Esta seguro que desea Renovar las Tarjetas de Creditos seleccionadas?"; 
	  var el = document.getElementById('tablaTarjetas');
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
	  	 var sTarjetas = "";
	  	 for (var i=0; i<imputs.length; i++){
	  	 	 if (imputs[i].type=='checkbox') 		    	
	    		if(imputs[i].checked && imputs[i].className =="check_user"){ 
	    			sTarjetas += imputs[i].value+',';
	    		}
	  	 } 
	  	 sTarjetas =  sTarjetas.substring(0,sTarjetas.length-1); 
	  	 //top.getBoxEmbozarTarjetasCreditos(sTarjetas,2);//operacion=2 Reembozo
	  	 if(confirm(mensaje))
	     	xajax_renovarTarjetasCreditos(sTarjetas,xajax.getFormValues('formTarjetas'));
	  }
	  else alert('Debe Elegir al menos un Tarjeta de Credito a Renovar.');	   
}
</script>
