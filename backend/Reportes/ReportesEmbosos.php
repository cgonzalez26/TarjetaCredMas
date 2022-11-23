<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	//session_start();
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	
	
	$idLoteEmbosaje = $_GET['id'];
	$optionEditar = $_GET['optionEditar'];
	
	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
		
	if ($Pagina <= 0) $Pagina = 1;

	$NombreMod = 'Tarjetas'; // Nombre del modulo
	$NombreTipoRegistro = 'Tarjeta';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Tarjetas'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('Tarjetas.sNumeroTarjeta','Tarjetas.dVigenciaDesde', 'Usuarios.sApellido','Usuarios.sDocumento','Localidades.sNombre','TiposEstadosTarjetas.sNombre');
	$arrListaEncabezados = array('Nro. Tarjeta','Fecha Alta','Titular','Documento','Localidad','Estado');
	$Tabla = 'Tarjetas'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'Usuarios.sApellido'; // Campo de orden predeterminado
	$TipoOrdenPre = 'ASC';	// Tipo de orden predeterminado
	$RegPorPag = 1000; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
		
	$aCond[]=" LEFT JOIN LotesTarjetas ON LotesTarjetas.idTarjeta = Tarjetas.id WHERE LotesTarjetas.idLoteEmbosaje = {$idLoteEmbosaje}";
	 
	$sCondiciones= implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim = implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
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
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	//$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	//$CantRegFiltro = sizeof($result_sLim);
	$CantRegFiltro = $oMysql->consultaSel($sqlDatos_sLim,true);
	
	$aParametros['optionsTipoDoc'] = $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre');
	
	$oXajax=new xajax();
	
	$oXajax->registerFunction("registrarEmbozoTarjetasCreditos");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
	
	function registrarEmbozoTarjetasCreditos($form){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		$aTarjetas = $form['aTarjetas'];
		
		foreach ($aTarjetas as $idTarjeta){
			$setTarjeta = "Tarjetas.idTipoEstadoTarjeta = '2'";
	    	$conditionsTarjeta = "Tarjetas.id = '{$idTarjeta}'";
			$ToAuditoryTarjeta = "Update Estado Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=2";		
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Tarjetas\",\"$setTarjeta\",\"$conditionsTarjeta\",\"{$_SESSION['id_user']}\",\"42\",\"$ToAuditoryTarjeta\");",true);    		
			
			$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
			$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','2',NOW(),''";
			$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=2";
			$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true); 
			
			$sql="UPDATE LotesTarjetas SET idTipoEstadoTarjeta=2 WHERE idTarjeta={$idTarjeta} AND idLoteEmbosaje={$form['idLoteEmbosaje']}";
			$id = $oMysql->consultaSel($sql,true);
			//$oRespuesta->alert($idEstadotarjeta);
		}
		//$oRespuesta->script("registrarLote({$form['idLoteEmbosaje']});");
		$cantidadTarjetasRegistradas = $oMysql->consultaSel("SELECT count(*) FROM LotesTarjetas WHERE idLoteEmbosaje={$form['idLoteEmbosaje']} AND idTipoEstadoTarjeta IN (2,9)",true);
		$cantidadTarjetasLote = $oMysql->consultaSel("SELECT count(*) FROM LotesTarjetas WHERE idLoteEmbosaje={$form['idLoteEmbosaje']}",true);
		
		if($cantidadTarjetasRegistradas<$cantidadTarjetasLote){
			$aLote = $oMysql->consultaSel("SELECT * FROM LotesEmbosajes WHERE LotesEmbosajes.id={$form['idLoteEmbosaje']} AND LotesEmbosajes.idTipoEstadoLoteEmbosaje = 3");
			if(!$aLote){
				$set = "LotesEmbosajes.idTipoEstadoLoteEmbosaje = '3'";
				$conditions = "LotesEmbosajes.id = '{$form['idLoteEmbosaje']}'";
				$ToAuditory = "Update Estado Lotes de Embosajes ::: Empleado ={$_SESSION['id_user']} ::: idLoteEmbosaje={$form['idLoteEmbosaje']} ::: estado=3";		
				$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LotesEmbosajes\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"46\",\"$ToAuditory\");",true);  
					
				$setEstadoLote = "idLoteEmbosaje,idEmpleado,idTipoEstadoLoteEmbosaje,dFechaRegistro,sMotivo";
				$valuesEstadoLote = "'{$form['idLoteEmbosaje']}','{$_SESSION['id_user']}','3',NOW(),''";
				$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes Embosajes ::: Empleado ={$_SESSION['id_user']} ::: idLoteEmbosaje={$idLote} ::: estado=1";
				$idEstadoLoteEmbosaje=$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesEmbosajes\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"47\",\"$ToAuditoryEstadoLote\");",true);
			}
		}
		if($cantidadTarjetasRegistradas == $cantidadTarjetasLote){
		$set = "LotesEmbosajes.idTipoEstadoLoteEmbosaje = '2'";
		$conditions = "LotesEmbosajes.id = '{$form['idLoteEmbosaje']}'";
		$ToAuditory = "Update Estado Lotes de Embosajes ::: Empleado ={$_SESSION['id_user']} ::: idLoteEmbosaje={$form['idLoteEmbosaje']} ::: estado=2";		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LotesEmbosajes\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"46\",\"$ToAuditory\");",true);  
			
		$setEstadoLote = "idLoteEmbosaje,idEmpleado,idTipoEstadoLoteEmbosaje,dFechaRegistro,sMotivo";
		$valuesEstadoLote = "'{$form['idLoteEmbosaje']}','{$_SESSION['id_user']}','2',NOW(),''";
		$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes Embosajes ::: Empleado ={$_SESSION['id_user']} ::: idLoteEmbosaje={$idLote} ::: estado=2";
		$idEstadoLoteEmbosaje=$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesEmbosajes\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"47\",\"$ToAuditoryEstadoLote\");",true);
		}

		$oRespuesta->alert("La operacion se realizo correctamente");
	  	$oRespuesta->redirect("TarjetasPorLotes.php?id={$form['idLoteEmbosaje']}&optionEditar={$form['optionEditar']}"); 
		return  $oRespuesta;
	}
?>
<body style="background-color:#FFFFFF;">
	<div id='' style='width:90%;text-align:right;margin-right:10px;'>
		<a href="RecepcionEmbozo.php" style='text-decoration:none;font-weight:bold;'>
			<img src='<?=IMAGES_DIR?>/back.png' title='Volver a Listado de Lotes de Embozo' alt='Volver a Listado de Lotes de Embozo' border='0' hspace='4' align='absmiddle'> Volver</a>
	</div>

	<center>
	<h3>Recepcion y Registro de Embozado de Tarjetas</h3>
	
<form id="formTarjetas" action="TarjetasPorLotes.php" method="POST">
<input type="hidden" id="idLoteEmbosaje" name="idLoteEmbosaje" value="<? echo $idLoteEmbosaje;?>">
<input type="hidden" name="optionEditar" id="optionEditar" value="<?=$optionEditar?>"> 

<?php 
if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result){	

  $sCondicionLote = " WHERE LotesEmbosajes.id = {$idLoteEmbosaje}";	
  $sqlDatos="Call usp_getLotesEmbosajes(\"$sCondicionLote\");";
  $rsLote = $oMysql->consultaSel($sqlDatos,true);
  /*$sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;
  $sCadena .= " en la base de datos.</p>*/
  $sCadena .= "<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='0' bordercolor='#000000' width='90%'>
  				<tr><td>Numero de Lote: " . $rsLote['sNumeroPedido'] . "</td></tr>
  				<tr><td>Empresa Embosadora: " . $rsLote['sEmpresaEmbosadora'] . "</td></tr></table>";
  $sCadena .= "<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='90%' id='tablaTarjetas'>
		<tr class='filaPrincipal'>
		<!-- Lista de encabezados de columna -->";
	
	$CantEncabezados = count($arrListaEncabezados);
	for($i=0; $i<$CantEncabezados; $i++){
		$sCadena .= "<th style='height:25px'>";
		if($CampoOrden == $arrListaCampos[$i]){
			if ($TipoOrden == 'ASC') $NuevoTipoOrden = 'DESC'; else $NuevoTipoOrden = 'ASC';
		}
		else $NuevoTipoOrden = 'ASC';
		
		$sCadena .= "<a href=\"{$_SERVER['PHP_SELF']}?CampoOrden={$arrListaCampos[$i]}&TipoOrden={$NuevoTipoOrden}&id={$idLoteEmbosaje}&optionEditar={$optionEditar}\">{$arrListaEncabezados[$i]}";
		if($CampoOrden == $arrListaCampos[$i]){
			if ($TipoOrden == 'ASC') 
				$sCadena .= "<img src='../includes/images/go-up.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendente' title='Ordenado por {$arrListaEncabezados[$i]} Ascendente'/></a>"; 
			else 
				$sCadena .= "<img src='../includes/images/go-down.png' alt='Ordenado por {$arrListaEncabezados[$i]} Descendente' title='Ordenado por {$arrListaEncabezados[$i]} Descendente'/></a>";
			}
		$sCadena .= "</th>\r\n";
	}
	
	///Opciones de Mod. y Elim.
	if($_GET['optionEditar'] == 1)
		$sCadena .="<th style='cursor:pointer;width:20px'><input type='checkbox' onclick='tildar_checkboxs( this.checked )' id='check_user' /> </th></tr>";
	else 
		$sCadena .="<th style='cursor:pointer;width:20px'>&nbsp;</th>";	
    echo $sCadena;

	$CantMostrados = 0;
	foreach ($result as $rs ){
		$sBotonera = '';	
		$CantMostrados ++;
		$PK = $rs['id'];
		$sClase='';
	
		$sUsuario = $rs['sApellido'].', '.$rs['sNombre'];
		$idTipoEstadoTarjeta = $oMysql->consultaSel("SELECT LotesTarjetas.idTipoEstadoTarjeta FROM LotesTarjetas WHERE LotesTarjetas.idTarjeta={$rs['id']} AND LotesTarjetas.idLoteEmbosaje={$idLoteEmbosaje}",true);
		$optionEditar = 0;
		$bMostrarIcono = false;
		$sBoton = "";
		if($rs['sEstado'] == 'B'){
			$sBotonera='&nbsp;';
		}else{
			
			$oBtn = new aToolBar();
			$oBtn->setAnchoBotonera('auto');			
			$sBotonera='&nbsp;';
			if($idTipoEstadoTarjeta == 2){
				$bMostrarIcono = true;				
				$sBoton .= "<img src='".IMAGES_DIR."/ok.png' border='0' alt='Tarjeta Embozada' title='Tarjeta Embozada' style='cursor:pointer'/>";
			}
			if($idTipoEstadoTarjeta == 9){
				$bMostrarIcono = true;
				$sBoton .= "<img src='".IMAGES_DIR."/cancelar.gif' border='0' alt='Tarjeta No Embozada' title='Tarjeta No Embozada' style='cursor:pointer'/>";
			}
			$sBotonera = $oBtn->getBotoneraToolBar('');		
		}
		?>
		<tr id="empleado<?php echo $PK;?>">
			<!-- Valores -->
			<td width="10%" align="left">&nbsp;<?=$rs['sNumeroTarjeta'];?></td>
			<td width="15%" align="left">&nbsp;<?=$rs['dFechaRegistro'];?></td>
			<td width="25%" align="left">&nbsp;<?=convertir_especiales_html($sUsuario);?></td>
			<td width="10%" align="left">&nbsp;<?=$rs['sDocumento'];?></td>	
			<td width="20%" align="left">&nbsp;<?=convertir_especiales_html($rs['sLocalidad']);?></td>	
			<td width="20%" align="left">&nbsp;<?=convertir_especiales_html($rs['sEstado']);?></td>	
			<!-- Links para Mod. y Elim. -->
			<td align='center' width='2%'>
			<?
			if($_GET['optionEditar'] == 1){
				if($bMostrarIcono)
					echo $sBoton;
				else
					echo "<input type='checkbox' id='aTarjetas[]' name='aTarjetas[]' class='check_user' value='".$PK."' />";
				
			}else{			
				echo $sBoton;
			} 					
			?>
			</td>
		</tr>
		<?
	}
	if($_GET['optionEditar'] == 1 && $rsLote['idTipoEstadoLoteEmbosaje'] != 2)
		echo '<tr><td colspan="7" align="right"><div><button type="button" onclick="registrarEmbozoTarjetasCreditos();"> Regitrar Embozo </button> &nbsp;
				<button type="button" onclick="registrarNoEmbozoTarjetasCreditos();"> No Embozo </button>
				</div> </td></tr>';
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
</form>
<script>

function historialTarjeta(idTarjeta,sNumero){
	top.getBoxHistorialTarjeta(idTarjeta,sNumero);
}	

function registrarEmbozoTarjetasCreditos(){
	  var mensaje="Esta seguro que desea Confirmar el Embozo las Tarjetas de Creditos seleccionadas?"; 
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
	       xajax_registrarEmbozoTarjetasCreditos(xajax.getFormValues('formTarjetas'));
	  }
	  else alert('Debe Elegir al menos un Tarjeta de Credito a Registrar.');	   
}

function registrarNoEmbozoTarjetasCreditos(){
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
  		//alert(sTarjetas);
  		var id = document.getElementById("idLoteEmbosaje").value;  	
  		var optionEditar = document.getElementById("optionEditar").value;  	
		//top.getBoxRegistrarNoEmbozoTarjetasCreditos(id,sTarjetas,optionEditar);
		
		createWindows("RegistrarNoEmbozo.php?id="+id+"&sTarjetas="+sTarjetas+"&optionEditar="+optionEditar,'Tarjeta','1','1');
	  }
	  else alert('Debe Elegir al menos un Tarjeta de Credito a Registrar.');	
}


function registrarLote(idLote){
	if(confirm("Desea registrar el Lote de Embosaje?")){
		xajax_registrarLoteEmbosaje(idLote);
	}
	window.parent.frames[5].location.href = '../TarjetasCreditos/TarjetasPorLotes.php?id='+idLote;
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
	    _popup_ = dhxWins1.createWindow(idWind, 250, 50, 540, 320);
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
	var id = document.getElementById('idLoteEmbosaje').value;
	var option = document.getElementById('optionEditar').value;
	window.location ="TarjetasPorLotes.php?id="+id+"&optionEditar="+option;
}
</script>
