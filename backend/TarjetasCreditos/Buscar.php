<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
		
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
	if($_SESSION['id_user'] == 296){
	$arrListaCampos = array('items','Tarjetas.sNumeroTarjeta','Tarjetas.idTipotarjeta','sNumeroPedidoEmbozaje','sNumeroPedidoCorreo','Tarjetas.dVigenciaDesde','Tarjetas.dVigenciaHasta', 'Usuarios.sApellido','Usuarios.sDocumento','Localidades.sNombre','TiposEstadosTarjetas.sNombre');
	$arrListaEncabezados = array('Items','Nro. Tarjeta','Tipo','Nro.Lote Embozaje','Nro.Lote Correo','Fecha Alta','Fecha Vto.','Titular','Documento','Localidad','Estado');
	
	}else{
	$arrListaCampos = array('Tarjetas.sNumeroTarjeta','Tarjetas.idTipotarjeta','sNumeroPedidoEmbozaje','sNumeroPedidoCorreo','Tarjetas.dVigenciaDesde','Tarjetas.dVigenciaHasta', 'Usuarios.sApellido','Usuarios.sDocumento','Localidades.sNombre','TiposEstadosTarjetas.sNombre');
	$arrListaEncabezados = array('Nro. Tarjeta','Tipo','Nro.Lote Embozaje','Nro.Lote Correo','Fecha Alta','Fecha Vto.','Titular','Documento','Localidad','Estado');
	}
	$Tabla = 'Tarjetas'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'Tarjetas.dFechaRegistro'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 1000; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
	$idTipoDocumentoTarjeta = 0;
	$idTipoEstadoTarjeta = 0;	
	if(isset($_POST['buscar']))
	{	
		$sNumeroCuentaTarjeta = $_POST['sNumeroCuentaTarjeta'];
		$sNumeroTarjeta = $_POST['sNumeroTarjeta'];
		$idTipoDocumentoTarjeta = $_POST['idTipoDocumentoTarjeta'];
		$sDocumentoTarjeta = $_POST['sDocumentoTarjeta'];
		$sApellidoTarjeta = $_POST['sApellidoTarjeta'];
		$sNombreTarjeta = $_POST['sNombreTarjeta'];
		$idTipoEstadoTarjeta = $_POST['idTipoEstadoTarjeta'];
		
		$condic = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; //variable que se usa en la paginacion 

		//echo "Nombre ". $_POST['nombre_u'];
		if(!session_is_registered('sNumeroCuentaTarjeta'))
		{
			session_register('sNumeroCuentaTarjeta');
			session_register('sNumeroTarjeta');
			session_register('idTipoDocumentoTarjeta');
			session_register('sDocumentoTarjeta');
			session_register('sApellidoTarjeta');
			session_register('sNombreTarjeta');
			session_register('idTipoEstadoTarjeta');
		}
		$_SESSION['sNumeroCuentaTarjeta'] = $_POST['sNumeroCuentaTarjeta'];
		$_SESSION['sNumeroTarjeta'] = $_POST['sNumeroTarjeta'];
		$_SESSION['idTipoDocumentoTarjeta'] = $_POST['idTipoDocumentoTarjeta'];		
		$_SESSION['sDocumentoTarjeta'] = $_POST['sDocumentoTarjeta'];
		$_SESSION['sApellidoTarjeta'] = $_POST['sApellidoTarjeta'];
		$_SESSION['sNombreTarjeta'] = $_POST['sNombreTarjeta'];
		$_SESSION['idTipoEstadoTarjeta'] = $_POST['idTipoEstadoTarjeta'];
		unset($_SESSION['volver']);
	}
	else
	{
		$sNumeroCuentaTarjeta = $_SESSION['sNumeroCuentaTarjeta'];
		$sNumeroTarjeta = $_SESSION['sNumeroTarjeta'];
		$idTipoDocumentoTarjeta = $_SESSION['idTipoDocumentoTarjeta'];
		$sDocumentoTarjeta = $_SESSION['sDocumentoTarjeta'];
		$sApellidoTarjeta = $_SESSION['sApellidoTarjeta'];
		$sNombreTarjeta = $_SESSION['sNombreTarjeta'];
		$idTipoEstadoTarjeta = $_SESSION['idTipoEstadoTarjeta'];
	}

	$sWhere = "";
	$aCond=Array();
	
	if($sNumeroCuentaTarjeta){$aCond[]=" CuentasUsuarios.sNumeroCuenta LIKE '".trim($sNumeroCuentaTarjeta)."' ";}
	if($sNumeroTarjeta){$aCond[]=" Tarjetas.sNumeroTarjeta LIKE '".trim($sNumeroTarjeta)."' ";}
	if($idTipoDocumentoTarjeta){$aCond[]=" Usuarios.idTipoDocumento = '".trim($idTipoDocumentoTarjeta)."' ";}
	if($sDocumentoTarjeta){$aCond[]=" Usuarios.sDocumento = '".trim($sDocumentoTarjeta)."' ";}
	if($sApellidoTarjeta){$aCond[]=" Usuarios.sApellido LIKE '%".trim($sApellidoTarjeta)."%' ";}
	if($sNombreTarjeta){$aCond[]=" Usuarios.sNombre LIKE '%".trim($sNombreTarjeta)."%' ";}
	if($idTipoEstadoTarjeta){$aCond[]=" Tarjetas.idTipoEstadoTarjeta = '".trim($idTipoEstadoTarjeta)."' ";}
	 
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
	$sqlDatos="Call usp_getTarjetas(\"$sCondiciones\");";
	//$sqlDatos_sLim="Call usp_getTarjetas(\"$sCondiciones_sLim\");";
	$sqlDatos_sLim="SELECT count(Tarjetas.id)
        FROM
  			Tarjetas
        LEFT JOIN CuentasUsuarios ON CuentasUsuarios.id= Tarjetas.idCuentaUsuario   
        LEFT JOIN Usuarios ON Usuarios.id= Tarjetas.idUsuario
        LEFT JOIN SolicitudesUsuarios ON SolicitudesUsuarios.id = CuentasUsuarios.idSolicitud
        LEFT JOIN InformesPersonales ON InformesPersonales.idSolicitudUsuario = SolicitudesUsuarios.id
        LEFT JOIN Localidades ON Localidades.id = InformesPersonales.idLocalidad  
        LEFT JOIN TiposEstadosTarjetas ON TiposEstadosTarjetas.id = Tarjetas.idTipoEstadoTarjeta
        LEFT JOIN TiposTarjetas ON TiposTarjetas.id = Tarjetas.idTipoTarjeta ".$sCondiciones_sLim;
	//echo $sqlDatos;
	//echo $sqlDatos_sLim;
	
	//Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$CantRegFiltro = $oMysql->consultaSel($sqlDatos_sLim,true);
		
	//var_export($result); 
	//$CantRegFiltro = sizeof($result_sLim);

	
	$oXajax=new xajax();
	
	$oXajax->registerFunction("updateEstadoCuentasUsuarios");
	$oXajax->registerFunction("updateDatosCuentasUsuarios");
	//$oXajax->registerFunction("nuevaVersionTarjetasCreditos");
	//$oXajax->registerFunction("renovarTarjetasCreditos");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
	
	$aParametros['optionsTipoDoc'] = $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre',$idTipoDocumentoTarjeta);
	$aParametros['optionsTipoEstadoTarjeta'] = $oMysql->getListaOpciones("TiposEstadosTarjetas","id","sNombre",$idTipoEstadoTarjeta);
	$aParametros['FORM_BACK'] = "Buscar.php";	
	
	$aParametros['sNumeroCuentaTarjeta'] = trim($sNumeroCuentaTarjeta);
	$aParametros['sNumeroTarjeta'] = trim($sNumeroTarjeta);
	$aParametros['sDocumentoTarjeta'] = trim($sDocumentoTarjeta);
	$aParametros['sApellidoTarjeta'] = trim($sApellidoTarjeta);
	$aParametros['sNombreTarjeta'] = trim($sNombreTarjeta);
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
  	<form action='Buscar.php' id='formTarjetas' method='POST'>
  	<input type='hidden' id='URL_BAK' name='URL_BAK' value='Buscar.php' />
  	
	<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='90%' id='tablaTarjetas' >
		<tr class='filaPrincipal'>
		<!-- Lista de encabezados de columna -->";
	
  	$CantEncabezados = count($arrListaEncabezados);
	for($i=0; $i<$CantEncabezados; $i++){
		$sCadena .= "<th style='height:25px'>";
		if($CampoOrden == $arrListaCampos[$i]){
			if ($TipoOrden == 'ASC') $NuevoTipoOrden = 'DESC'; else $NuevoTipoOrden = 'ASC';
		}
		else $NuevoTipoOrden = 'ASC';
		
		if($arrListaCampos[$i] !="items" && $arrListaCampos[$i] != "sNumeroPedidoEmbozaje" && $arrListaCampos[$i] !="sNumeroPedidoCorreo"){
			$sCadena .= "<a href=\"{$_SERVER['PHP_SELF']}?CampoOrden={$arrListaCampos[$i]}&TipoOrden={$NuevoTipoOrden}\">{$arrListaEncabezados[$i]}";
			if($CampoOrden == $arrListaCampos[$i]){
				if ($TipoOrden == 'ASC') 
					$sCadena .= "<img src='../includes/images/go-up.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendente' title='Ordenado por {$arrListaEncabezados[$i]} Ascendente'/></a>"; 
				else 
					$sCadena .= "<img src='../includes/images/go-down.png' alt='Ordenado por {$arrListaEncabezados[$i]} Descendente' title='Ordenado por {$arrListaEncabezados[$i]} Descendente'/></a>";
			}
		}else{
			$sCadena .= $arrListaEncabezados[$i];
		}
		$sCadena .= "</th>\r\n";
	}
  
	///Opciones de Mod. y Elim.
	$sCadena .="<th colspan='2'>Acciones</th>
	<th style='cursor:pointer;width:20px'><input type='checkbox' onclick='tildar_checkboxs( this.checked )' id='checkbox_principal' /> </th></tr>";
    echo $sCadena;

	$CantMostrados = 0;
	foreach ($result as $rs ){
		$sBotonera = '';	
		$CantMostrados ++;
		$PK = $rs['id'];
	
		$sUsuario = $rs['sApellido'].', '.$rs['sNombre'];
		$optionEditar = 0;
		if($rs['sEstado'] == 'B'){
			$sBotonera='&nbsp;';
		}else{
			
			$oBtn = new aToolBar();
			$oBtn->setAnchoBotonera('auto');			
			$sBotonera='&nbsp;';
			$oBtn->addBoton("Mostrar{$rs['id']}","onclick","mostrarTarjetaCredito({$rs['id']})",'Buscar16','Visualizar',true,true);	
			if($rs['idTipoTarjeta'] == 2 &&($rs['idTipoEstadoTarjeta'] == 8)){ //Tarjeta Adicional
				$oBtn->addBoton("Baja{$rs['id']}","onclick","darBajaTarjetaCredito({$rs['id']},'{$rs['sNumeroTarjeta']}')",'Eliminar','Dar de Baja',true,true);	
			}
			$oBtn->addBoton("Historial{$rs['id']}","onclick","historialTarjeta({$rs['id']},'{$rs['sNumeroTarjeta']}')",'Historial','Historial de la Tarjeta',true,true);				
			$oBtn->addBoton("Configurar{$rs['id']}","onclick","setearEstadoTarjeta({$rs['id']},{$rs['idTipoEstadoTarjeta']},{$rs['sNumeroTarjeta']})",'Configurar','Cambiar Estado',true,true);	
			$sBotonera = $oBtn->getBotoneraToolBar('');		
		}
		
		$aLotesEmbosajes = $oMysql->consultaSel("SELECT LotesEmbosajes.id,LotesEmbosajes.sNumeroPedido FROM LotesTarjetas LEFT JOIN LotesEmbosajes ON LotesEmbosajes.id = LotesTarjetas.idLoteEmbosaje WHERE LotesTarjetas.idTarjeta={$PK}");
		$aLotesCorreos = $oMysql->consultaSel("SELECT LotesCorreos.id,LotesCorreos.sNumeroPedido FROM LotesCorreosTarjetas LEFT JOIN LotesCorreos ON LotesCorreos.id = LotesCorreosTarjetas.idLoteCorreo WHERE LotesCorreosTarjetas.idTarjeta={$PK}");
		$sNumeroPedidoEmbosaje = "&nbsp;";
		$aPedidosEmbosajes = array();
		if(count($aLotesEmbosajes)>0){
			foreach($aLotesEmbosajes as $aLoteEmbosaje)
				$aPedidosEmbosajes[] = "<a href='javascript:historialLoteEmbosaje({$aLoteEmbosaje['id']},{$aLoteEmbosaje['sNumeroPedido']})'>{$aLoteEmbosaje['sNumeroPedido']}</a>";
			$sNumeroPedidoEmbosaje = implode("&nbsp;",$aPedidosEmbosajes);
		}
		$sNumeroPedidoCorreo = "&nbsp;";
		$aPedidosCorreos = array();
		if(count($aLotesCorreos)>0){
			foreach($aLotesCorreos as $aLoteCorreo)
				$aPedidosCorreos[] = "<a href='javascript:historialLoteCorreo({$aLoteCorreo['id']},{$aLoteCorreo['sNumeroPedido']})'>{$aLoteCorreo['sNumeroPedido']}</a>";
			$sNumeroPedidoCorreo .= implode("&nbsp;",$aPedidosCorreos);	
		}
		?>
		<tr id="empleado<?php echo $PK;?>">
			<!-- Valores -->
			<?
			if($_SESSION['id_user'] == 296)
				echo "<td width='10%' align='center'>&nbsp;$CantMostrados</td>";
			?>
			<td width="10%" align="center">&nbsp;<?=$rs['sNumeroTarjeta'];?></td>
			<td width="5%" align="center">&nbsp;<?=$rs['sTipoTarjeta'];?></td>
			<td width="10%" align="left"><?=$sNumeroPedidoEmbosaje;?></td>			
			<td width="10%" align="left">&nbsp;<?=$sNumeroPedidoCorreo;?></td>						
			<td width="5%" align="center">&nbsp;<?=$rs['dVigenciaDesde'];?></td>
			<td width="5%" align="center">&nbsp;<?=$rs['dVigenciaHasta'];?></td>
			<td width="20%" align="left">&nbsp;<?=convertir_especiales_html($sUsuario);?></td>
			<td width="5%" align="center">&nbsp;<?=$rs['sDocumento'];?></td>	
			<td width="10%" align="left">&nbsp;<?=convertir_especiales_html($rs['sLocalidad']);?></td>				
			<td width="15%" align="left">&nbsp;<?=$rs['sEstado'];?></td>	
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
	   <td colspan="13" align="right">
	   	   <div> 
	   	    	<button type="button" onclick="embozarTarjetasCreditos();"> Enviar a Embozar </button> &nbsp;
	   	    	<button type="button" onclick="enviarACorreoTarjetasCreditos();"> Enviar a Correo </button> &nbsp;
	   	    	<button type="button" onclick="reembozarTarjetasCreditos();"> Reembozar </button> &nbsp;
	   	    	<button type="button" onclick="nuevaVersionTarjetasCreditos();"> Nueva Version </button> &nbsp;
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
function validarCheck(){
	var el = document.getElementById('tablaTarjetas');
	var imputs= el.getElementsByTagName('input');
	var band=0;
	  		  
	for (var i=0; i<imputs.length; i++){			
	   if (imputs[i].type=='checkbox'){ 		    	
	   	  if(imputs[i].checked){
	   		 return true; break;
	   	  }
	   }	
	}
	return false; 
}

function obtenerTarjetasSeleccionadas(){
	var el = document.getElementById('tablaTarjetas');
	var imputs= el.getElementsByTagName('input');
	var sTarjetas = "";
  	for (var i=0; i<imputs.length; i++){
  	 	 if (imputs[i].type=='checkbox') 		    	
    		if(imputs[i].checked && imputs[i].className =="check_user"){ 
    			sTarjetas += imputs[i].value+',';
    		}
  	} 
  	sTarjetasCreditos =  sTarjetas.substring(0,sTarjetas.length-1); 
  	return sTarjetasCreditos;
}

function historialTarjeta(idTarjeta,sNumero){
	createWindows('HistorialTarjetaCredito.php?id='+idTarjeta+'&sNumero='+sNumero,'Tarjeta','1','1');
}	

function embozarTarjetasCreditos(){
	var mensaje="¿Esta seguro que desea Embozar las Tarjetas de Creditos seleccionadas?"; 
	if(validarCheck()){
	  	 var sTarjetas = obtenerTarjetasSeleccionadas();
	  	 createWindows('EnviarAEmbozar.php?sTarjetas='+sTarjetas+'&operacion=1','Tarjeta','1','1');
	}
	else alert('Debe Elegir al menos un Tarjeta de Credito a Embozar.');	   
}

function enviarACorreoTarjetasCreditos(){
	  var mensaje="Esta seguro que desea Enviar a Correo Postal las Tarjetas de Creditos seleccionadas?"; 
	  if(validarCheck()){
	  	 var sTarjetas = obtenerTarjetasSeleccionadas(); 
	     createWindows('EnviarLoteACorreo.php?sTarjetas='+sTarjetas,'Tarjeta','1','2');
	      
	  }
	  else alert('Debe Elegir al menos un Tarjeta de Credito para Enviar al Correo.');	   
}

function reembozarTarjetasCreditos(){
	var mensaje="¿Esta seguro que desea Reembozar las Tarjetas de Creditos seleccionadas?"; 
	if(validarCheck()){	  	
	  	 var sTarjetas = obtenerTarjetasSeleccionadas();	  	 
	  	 createWindows('EnviarAEmbozar.php?sTarjetas='+sTarjetas+'&operacion=2','Tarjeta','1','3');
	}
	else alert('Debe Elegir al menos un Tarjeta de Credito a Reembozar.');	   
}

function nuevaVersionTarjetasCreditos(){
	var mensaje="Esta seguro que desea Generar una Nueva Version de las Tarjetas de Creditos seleccionadas?"; 
	if(validarCheck()){
		 var sTarjetas = obtenerTarjetasSeleccionadas();
	  	 //top.getBoxEmbozarTarjetasCreditos(sTarjetas,2);//operacion=2 Reembozo
	  	 //if(confirm(mensaje))
	     //	xajax_nuevaVersionTarjetasCreditos(sTarjetas,xajax.getFormValues('formTarjetas'));1
	     createWindows('NuevaVersionTarjeta.php?sTarjetas='+sTarjetas+'&operacion=2','Tarjeta','1','4');
	}
	else alert('Debe Elegir al menos un Tarjeta de Credito para Generar una Nueva Version.');	   
}


function renovarTarjetasCreditos(){
	  var mensaje="Esta seguro que desea Renovar las Tarjetas de Creditos seleccionadas?"; 
	  if(validarCheck()){
	  	 var sTarjetas = obtenerTarjetasSeleccionadas();
	  	 //if(confirm(mensaje))
	     //	xajax_renovarTarjetasCreditos(sTarjetas,xajax.getFormValues('formTarjetas'));
	     createWindows('RenovacionTarjetasCreditos.php?sTarjetas='+sTarjetas,'Tarjeta','1','5');
	  }
	  else alert('Debe Elegir al menos un Tarjeta de Credito a Renovar.');	   
}

function historialLoteEmbosaje(idlote,sNumero){
	createWindows('HistorialLoteEmbosaje.php?id='+idlote+'&sNumero='+sNumero,'Tarjeta','1','1');
}	

function historialLoteCorreo(idlote,sNumero){
	createWindows('HistorialLoteCorreo.php?id='+idlote+'&sNumero='+sNumero,'Tarjeta','1','1');
}	

function darBajaTarjetaCredito(id,sNumero){
	createWindows('CambiarEstadoTarjeta.php?id='+id+'&idTipoEstado=15&sNumero='+sNumero+'&operacion=0','Tarjeta','1','1');
}

function mostrarTarjetaCredito(id){
	window.location ="./TarjetaCredito.php?id="+ id;
}

function setearEstadoTarjeta(id,idTipoEstado,sNumero){	 
	createWindows('CambiarEstadoTarjeta.php?id='+id+"&idTipoEstado="+idTipoEstado+"&operacion=1&sNumero="+sNumero,'Tarjeta','1','SOL');
}

function doOnLoad() {
    dhxWins1 = new dhtmlXWindows();
    dhxWins1.enableAutoViewport(false);
    dhxWins1.attachViewportTo("dhtmlx_wins_body_content");
    dhxWins1.setImagePath("../../codebase/imgs/");
}
var dhxWins1;
function createWindows(sUrl,sTitulo,idProyecto_,tipo_){
    var idWind = "window_"+idProyecto_+"_"+tipo_;
	//if(!dhxWins.window(idWind)){
     	dhxWins1 = new dhtmlXWindows();     	
	    dhxWins1.setImagePath("../includes/grillas/dhtmlxWindows/sources/imgs/");	  
	    _popup_ = dhxWins1.createWindow(idWind, 250, 50, 610, 320);
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
	//parent.dhxWins.close(); // close a window
}  	

function recargar(){
	window.location ="Buscar.php";
}
</script>
