<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	
	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
		
	if ($Pagina <= 0) $Pagina = 1;

	$NombreMod = 'GruposAfinidades'; // Nombre del modulo
	$NombreTipoRegistro = 'Grupo';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Grupos'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('GruposAfinidades.sNombre','MultiBin.sBin', 'GruposAfinidades.iNumeroModeloResumen');
	$arrListaEncabezados = array('Nombre', 'Bin', 'Numero Modelo');
	$Tabla = 'GruposAfinidades'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'GruposAfinidades.sNombre'; // Campo de orden predeterminado
	$TipoOrdenPre = 'ASC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
		
	if(isset($_POST['buscar']))
	{	
		$nombre_u = $_POST['nombre_u'];
		$condic = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; //variable que se usa en la paginacion 

		//echo "Nombre ". $_POST['nombre_u'];
	
		if(!session_is_registered('snombre_u'))
		{
			session_register('snombre_u');
			session_register('scondic');
		}
	
		$_SESSION['snombre_u'] = $_POST['nombre_u'];	
		$_SESSION['scondic'] = $_POST['condic'];
		unset($_SESSION['volver']);
	}
	else
	{
		$nombre_u = $_SESSION['snombre_u'];
		$condic = $_SESSION['scondic'];	
		$condic1 = $_SESSION['scondic'];	
	}

	
	$sWhere = "";
	
	$aCond=Array();
	
	if($nombre_u)
	{
		$aCond[]=" $condic LIKE '%$nombre_u%' ";		
	}	
	
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
	//echo $sCondiciones;
	
	session_register('nombre_u');
	session_register('condic');
	
	$nombre_u = $_GET['nombre_u'];
	$condic = $_GET['condic'];
	
	//echo $sCondiciones;
	
	$sqlDatos="Call usp_getGruposAfinidades(\"$sCondiciones\");";
	$sqlDatos_sLim="Call usp_getGruposAfinidades(\"$sCondiciones_sLim\");";
	
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);

	$oXajax=new xajax();
	
	$oXajax->registerFunction("updateEstadoGrupoAfinidad");
	$oXajax->registerFunction("updateDatosGrupoAfinidad");
	$oXajax->registerFunction("habilitarGruposAfinidades");
	$oXajax->registerFunction("generarResumenes");
	$oXajax->registerFunction("generarResumenSoloXml");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);	
	
	function generarResumenes($sGrupos){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		$aGrupos = explode(",",$sGrupos);
		
		
		$dPeriodo = date("Y-10-01 00:00:00");
		$dPeriodoFormat = date("10-Y");
		$iTieneresumen = 0;
		//$oRespuesta->alert($dPeriodo);
		$rtdo = ""; $msje = "";
		$grupoOk = Array(); $grupoNoOk = Array(); $periodos = Array();
		$msjeError = "";
		foreach ($aGrupos as $idgrupo){
			//$iTieneresumen= $oMysql->consultaSel("SELECT iTieneResumen FROM CalendariosFacturaciones WHERE idGrupoAfinidad ={$idgrupo} AND dPeriodo='{$dPeriodo}'",true);
			$dPeriodo = $oMysql->consultaSel("call usp_getPeriodoACerrar(\"$idgrupo\")",true);
			$aPeriodo = explode("-",$dPeriodo);
			$dPeriodoFormat = $aPeriodo[1].'-'.$aPeriodo[0];
			 
			$sGrupo = $oMysql->consultaSel("SELECT GruposAfinidades.sNombre FROM GruposAfinidades WHERE GruposAfinidades.id ={$idgrupo}",true);
			/*if($iTieneresumen == 0){*/
				$sqlAjustes = "call usp_generarAjustesV2(\"{$idgrupo}\",\"{$_SESSION['id_user']}\",\"{$dPeriodo}\")";
				$rtdoAjuste .= $oMysql->consultaSel($sqlAjustes,true);
				//$rtdoAjuste = 'ok';
				//$oRespuesta->alert($rtdoAjuste);
				if($rtdoAjuste == 'ok'){
					$sql = "call usp_getResumenes1(\"{$idgrupo}\",\"{$_SESSION['id_user']}\",\"{$dPeriodo}\")";					
					$rs = $oMysql->consultaSel($sql,true);	

					//$oRespuesta->alert($rs);
					/*if($oMysql->getErrorNo() != 0)*/
					if(!$rs){
						$rtdo .= "ERROR";
					}else{
						$rtdo .= "ok";
					}
				}else{
					$rtdo .= "ERROR";
				}
				
			/*}else{
				$rtdo .= "ERROR";
			}*/
			
			if($rtdo == 'ok'){
			 	$oMysql->consultaSel("UPDATE CalendariosFacturaciones SET iTieneResumen=1 WHERE idGrupoAfinidad ={$idgrupo} AND dPeriodo ='{$dPeriodo}'",true);
				generarXmlResumen($idgrupo,$dPeriodo,$dPeriodoFormat);
				$grupoOk[] = $sGrupo;
				$msjeError .= "Se genero correctamente el Resumen";
				
			}else{
				$grupoNoOk[] = $sGrupo;
				$msjeError .= "NO se pudo generar el Resumen";
			}			
			$msje .= "Periodo Calendario: ".$dPeriodoFormat."\n";
			$msje .= "Grupos Afinidad : ".$sGrupo."\n";				
			$msje .= $msjeError."\n\n";
		}
		
		
		/*
		if($rtdo == 'ok')
			$msje = "Se generaron correctamente los Resumenes";
		else
			$msje = "NO se puideron generar los Resumenes";
		*/
		$oRespuesta->assign("div_result_search","innerHTML","");
		$oRespuesta->alert($msje);
		return  $oRespuesta;
	}
	
	function generarResumenSoloXml($sGrupos){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		$aGrupos = explode(",",$sGrupos);
		
		$dPeriodo = date("Y-10-01 00:00:00");
		$dPeriodoFormat = date("10-Y");
		$iTieneresumen = 0;
		//$oRespuesta->alert($dPeriodo);
		$rtdo = "";
		$grupoOk = Array(); $grupoNoOk = Array();
		foreach ($aGrupos as $idgrupo){
			$sGrupo = $oMysql->consultaSel("SELECT GruposAfinidades.sNombre FROM GruposAfinidades WHERE GruposAfinidades.id ={$idgrupo}",true);
			$rtdo = 'ok';
			if($rtdo == 'ok'){
				generarXmlResumen($idgrupo,$dPeriodo,$dPeriodoFormat);
				$grupoOk[] = $sGrupo;
			}else{
				$grupoNoOk[] = $sGrupo;
			}
		}
		$msje .= "";
		if(count($grupoOk)>0){
			$msje .= "Grupos Afinidad : ".implode(",",$grupoOk)."\n";
			$msje .= "Se generaron correctamente los Resumenes";
		}
		if(count($grupoNoOk)>0){
			$msje .= "Grupos Afinidad : ".implode(",",$grupoNoOk)."\n";
			$msje .= "NO se pudieron generar los Resumenes";
		}
		
		$oRespuesta->alert($msje);
		return  $oRespuesta;
	}
	if(in_array($_SESSION['id_user'],array(296))) $sBotonXml = "<button type='button' onclick='generarResumenSoloXml();'> Generar Resumen Solo Xml</button> &nbsp";
?>

<body style="background-color:#FFFFFF;">
<div id="BodyUser">

<?php 		
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorGruposAfinidades.tpl");
?>

<center>
<p>
	<img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo">
		 <a href="AdminGruposAfinidades.php?action=new"> Nuevo Grupo</a>
</p>



<?
	if (count($result)==0)
	{
		echo "Ningun registro encontrado";
	}
	
	$sCadena = "";
	
	if ($result)
	{	
	
	  $sCadena .= "<p>Hay ".$CantReg." ";
	  
	  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
	  else $sCadena .= $NombreTipoRegistro;
	
	  $sCadena .= " en la base de datos.</p>
		<form id='formGrupos' action='' method='POST' >
		<center>
		<table class='TablaGeneral' align='center' style='width:80% !important;' cellpadding='3' cellspacing='0' border='1' bordercolor='#000000' width='98%' id='tablaGrupoAfinidad'>
			<tr class='filaPrincipal'>
			<!-- Lista de encabezados de columna -->";
		
		$CantEncabezados = count($arrListaEncabezados);
		
		for($i=0; $i<$CantEncabezados; $i++)
		{
			$sCadena .= "<th style='height:25px'>";
			
			if($CampoOrden == $arrListaCampos[$i])
			{
				if ($TipoOrden == 'ASC') $NuevoTipoOrden = 'DESC'; else $NuevoTipoOrden = 'ASC';
			}
			else $NuevoTipoOrden = 'ASC';
			
			$sCadena .= "<a href=\"{$_SERVER['PHP_SELF']}?CampoOrden={$arrListaCampos[$i]}&TipoOrden={$NuevoTipoOrden}\">{$arrListaEncabezados[$i]}";
			
			if($CampoOrden == $arrListaCampos[$i])
			{
				if ($TipoOrden == 'ASC') 
					$sCadena .= "<img src='../includes/images/go-up.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendenrte' title='Ordenado por {$arrListaEncabezados[$i]} Ascendenrte'/></a>"; 
				else 
					$sCadena .= "<img src='../includes/images/go-down.png' alt='Ordenado por {$arrListaEncabezados[$i]} Descendente' title='Ordenado por {$arrListaEncabezados[$i]} Descendente'/></a>";
			}
			
			//$sCadena .= "</th>\r\n";
		}
		///Opciones de Mod. y Elim.
		$sCadena .="<th colspan='2'>Acciones</th>
			<th style='cursor:pointer;'><input type='checkbox' onchange='tildar_checkboxs( this.checked )' id='checkbox_principal' /> </th>
			</tr>";
	    echo $sCadena;
	
		$CantMostrados = 0;
		
		//var_export($result);
		
		foreach ($result as $rs )
		{
			//echo ($rs['sNombre']);	
			$sBotonera = '';	
			$CantMostrados ++;
			$PK = $rs['id'];
			$sClase='';
			
			$rs['sNombre'] = htmlspecialchars_decode($rs['sNombre']);
			
			//$sBotonera='&nbsp;';
				
			if($rs['sEstado'] == 'B')
			{
				$sClase="class='rojo'"; 
				$sBotonera='&nbsp;';
			}
			else
			{
				$oBtn = new aToolBar();
				$oBtn->setAnchoBotonera('auto');
				
				$oBtn->addBoton("Modificar{$rs['id']}","onclick","editarGrupoAfinidad({$rs['id']})",'Editar','Modificar',true,true);	
				$oBtn->addBoton("Eliminar{$rs['id']}","onclick","eliminarGrupoAfinidad({$rs['id']})",'Eliminar','Eliminar',true,true);
				
				$sBotonera = $oBtn->getBotoneraToolBar('');		
				//$sBotonera = "<input name='btn' type='button' value='Modificar' onClick='editarGrupoAfinidad({$rs['id']})' />
				//<input name='btn' type='button' value='Eliminar' onClick='eliminarGrupoAfinidad({$rs['id']})' />";
			}
?>

		<tr id="GrupoAfinidad<?php echo $PK;?>">
			<!-- Valores -->
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNombre']?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sBin']?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['iNumeroModeloResumen']?></td>	
			
			<!-- Links para Mod. y Elim. -->
			<td colspan="2" align="center">
			<?=$sBotonera;?>
			</td>
			<td align="center"><input type='checkbox' id='aGrupoAfinidad[]' name='aGrupoAfinidad[]' class="check_user" value='<?php echo $PK;?>'/> </td>
		</tr>
	
<?
		}
?>
</tr>
	<tr>
	   <td colspan="7" align="right">
	   	   <div> 
	   	    	<button type="button" onclick="Habilitar();"> Habilitar </button> &nbsp;
	   	    	<? if($_SESSION['id_user']==296){ ?>
	   	    	<button type="button" onclick="generarResumen();"> Generar Resumen </button> &nbsp;
	   	    	<? } ?>
	   	    	<?=$sBotonXml?>
	   	   </div>
	   </td>
	</tr> 
</table>
	<div style='font-size:10px;text-align:left;width:80%'>
		<span class='rojo'>Rojo-Grupos de Baja. <span><br>
</div>	
</center>
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
	} // if(result)
?>
	
	
<script>
	function editarGrupoAfinidad(idGrupoAfinidad){
		window.location ="AdminGruposAfinidades.php?idGrupoAfinidad="+ idGrupoAfinidad;
	}
	
	function eliminarGrupoAfinidad(idGrupoAfinidad){
		if(confirm("¿Desea eliminar el grupo?"))
		{
			xajax_updateEstadoGrupoAfinidad(idGrupoAfinidad,'B');
		}
	}
	
	function Habilitar()
	{
	  var mensaje="¿Esta seguro de Habilitar los Grupos seleccionados?"; 
	  var el = document.getElementById('tablaGrupoAfinidad');
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
	  	 if(confirm(mensaje))
	       xajax_habilitarGruposAfinidades(xajax.getFormValues('formGrupos'));
	  }
	  else alert('Debe Elegir al menos un Grupo a habilitar.');	   
	}
	
	function obtenerGruposSeleccionados(){
		var el = document.getElementById('tablaGrupoAfinidad');
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

	function generarResumen(){
	  var mensaje="Esta seguro de Generar Resumen de los Grupos seleccionados?"; 
	  var el = document.getElementById('tablaGrupoAfinidad');
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
	  	 //if(confirm(mensaje)){
	  	 	var sGrupos = obtenerGruposSeleccionados();
	  	 	//xajax_generarResumenes(sGrupos);
		  	createWindows('generarResumenesPorGrupo.php?sGrupos='+sGrupos,'Tarjeta','1','1',580, 250);
	  	 //}
	  }		
   	  else alert('Debe Elegir al menos un Grupo para Generar Resumen.');	   
	}
	
	function generarResumenSoloXml(){
	  var mensaje="Esta seguro de Generar Resumen de los Grupos seleccionados?"; 
	  var el = document.getElementById('tablaGrupoAfinidad');
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
	  	 if(confirm(mensaje)){
	  	 	var sGrupos = obtenerGruposSeleccionados();
	  	 	xajax_generarResumenSoloXml(sGrupos);
	  	 }
	  }		
   	  else alert('Debe Elegir al menos un Grupo para Generar Resumen.');	   
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
</script>
<?php echo xhtmlFootPagina();?>
