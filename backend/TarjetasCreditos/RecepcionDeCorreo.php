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

	$NombreMod = 'LotesCorreos'; // Nombre del modulo
	$NombreTipoRegistro = 'LoteCorreo';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'LotesCorreos'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('LotesCorreos.sNumeroPedido','LotesCorreos.dFechaRegistro','Correos.sNombre','LotesCorreos.idTipoEstadoLoteCorreo');
	$arrListaEncabezados = array('Nro. Lote','Fecha Alta','Correo','Estado');
	$Tabla = 'LotesCorreos'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'LotesCorreos.dFechaRegistro'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 500; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
		
	if(isset($_POST['buscar'])){	
		$sNumeroPedidoCorreo = $_POST['sNumeroPedidoCorreo'];
		$idTipoEstadoLoteCorreo = $_POST['idTipoEstadoLoteCorreo'];
		if(!session_is_registered('sNumeroPedidoCorreo'))
		{
			session_register('sNumeroPedidoCorreo');
			session_register('idTipoEstadoLoteCorreo');
		}
		$_SESSION['sNumeroPedidoCorreo'] = $_POST['sNumeroPedidoCorreo'];
		$_SESSION['idTipoEstadoLoteCorreo'] = $_POST['idTipoEstadoLoteCorreo'];
	}else{
		$sNumeroPedidoCorreo= $_SESSION['sNumeroPedidoCorreo'];
		$idTipoEstadoLoteCorreo = $_SESSION['idTipoEstadoLoteCorreo'];
	}
	$sWhere = "";
	$aCond=Array();
	
	if($sNumeroPedidoCorreo){$aCond[]=" LotesCorreos.sNumeroPedido LIKE '".trim($sNumeroPedidoCorreo)."' ";}
	if($idTipoEstadoLoteCorreo){$aCond[]=" LotesCorreos.idTipoEstadoLoteCorreo = '".$idTipoEstadoLoteCorreo."' ";}
	 
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
	//echo $sCondiciones;
	
	$sqlDatos="Call usp_getLotesCorreos(\"$sCondiciones\");";
	$sqlDatos_sLim="Call usp_getLotesCorreos(\"$sCondiciones_sLim\");";
	//echo $sqlDatos;
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);
	
	$oXajax=new xajax();
	
	$oXajax->registerFunction("recibirLotesCorreos");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	$aParametros['DHTMLX_WINDOW']=1;	
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
	$aParametros['optionsTipoeEstadoeLotesCorreos'] = $oMysql->getListaOpciones("TiposEstadosLotesCorreos","id","sNombre");
?>
<body style="background-color:#FFFFFF;">

	<center>
	<h3>Recibir Tarjetas de Creditos de Correos Postales</h3>
<?php 
echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorLotesCorreos.tpl",$aParametros);

if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result){	

  $sCadena .= "
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
			$sBotonera='&nbsp;';
			
			if($rs['idTipoEstadoLoteCorreo'] == 2){ //Registrado
				$oBtn->addBoton("Mostrar{$rs['id']}","onclick","editarLoteCorreo({$rs['id']},2)",'Buscar16','Visualizar',true,true);	
			}
			if($rs['idTipoEstadoLoteCorreo'] == 1){ //Enviado a Embozar
				$oBtn->addBoton("Modificar{$rs['id']}","onclick","editarLoteCorreo({$rs['id']},1)",'Editar','Modificar',true,true);				
			}	
			
			if($rs['idTipoEstadoLoteCorreo'] == 3){ //Incompleto
				$oBtn->addBoton("Modificar{$rs['id']}","onclick","editarLoteCorreo({$rs['id']},1)",'Editar','Modificar',true,true);				
			}
						
			$oBtn->addBoton("Excel{$rs['id']}","onclick","generarExcelLote({$rs['id']},1)",'Excel16','Excel',true,true);
			$oBtn->addBoton("Historial{$rs['id']}","onclick","historialLoteCorreo({$rs['id']},'{$rs['sNumeroPedido']}')",'Historial','Historial de la Lote Correo',true,true);					
			$sBotonera = $oBtn->getBotoneraToolBar('');		
		}
		?>
		<tr id="empleado<?php echo $PK;?>">
			<!-- Valores -->
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumeroPedido'];?></td>
			<td width="15%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['dFechaRegistro'];?></td>
			<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sCorreo'];?></td>
			<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sEstado'];?></td>	
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
function editarLoteCorreo(idLote,optionEditar){
	window.location ="./TarjetasPorLotesCorreos.php?id="+ idLote+"&optionEditar="+optionEditar+"&url_back=../TarjetasCreditos/RecepciondeCorreo.php";
}

function historialLoteCorreo(idlote,sNumero){
	createWindows('HistorialLoteCorreo.php?id='+idlote+'&sNumero='+sNumero,'Tarjeta','1','1');
}	

function embozarTarjetasCreditos(){
	  var mensaje="¿Esta seguro que desea Enviar las Tarjetas de Creditos seleccionadas?"; 
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
	  	 if(confirm(mensaje))
	       xajax_embozarTarjetasCreditos(xajax.getFormValues('tablaTarjetas'));
	  }
	  else alert('Debe Elegir al menos una Tarjeta de Credito a enviar.');	   
}

function generarExcelLote(idLote){
	window.location ="./DownloadExcelCorreo.php?id="+idLote;
	//window.location ="./test1.php";
}

function doOnLoad() {
    dhxWins = new dhtmlXWindows();
    dhxWins.enableAutoViewport(false);
    dhxWins.attachViewportTo("dhtmlx_wins_body_content");
    dhxWins.setImagePath("../../codebase/imgs/");
}

var dhxWins;
function createWindows(sUrl,sTitulo,idProyecto_,tipo_){
    var idWind = "window_"+idProyecto_+"_"+tipo_;
	//if(!dhxWins.window(idWind)){
     	dhxWins = new dhtmlXWindows();     	
	    dhxWins.setImagePath("../includes/grillas/dhtmlxWindows/sources/imgs/");	  
	    _popup_ = dhxWins.createWindow(idWind, 250, 50, 620, 250);
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
</script>