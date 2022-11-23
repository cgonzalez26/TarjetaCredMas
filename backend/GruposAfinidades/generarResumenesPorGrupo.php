<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );

	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	
	
	function generarResumenesPorGrupo($idGrupoAfinidad,$dPeriodo){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$rtdo = "";
		$sql = "call usp_getResumenes1(\"{$idGrupoAfinidad}\",\"{$_SESSION['id_user']}\",\"{$dPeriodo}\")";					
		$rs = $oMysql->consultaSel($sql,true);	
		if(!$rs){
			$rtdo .= "ERROR";
			$oRespuesta->alert("Los Resumenes NO se generaron.");
		}else{
			$rtdo .= "ok";
			$oRespuesta->alert("Los Resumenes se generaron con exito.");
		}
		$oRespuesta->assign("div_result_search","innerHTML","");
		
		return  $oRespuesta;
	}
	
	function generarXML($idGrupoAfinidad,$dPeriodo){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();

		//$oMysql->consultaSel("UPDATE CalendariosFacturaciones SET iTieneResumen=1 WHERE idGrupoAfinidad ={$idGrupoAfinidad} AND dPeriodo ='{$dPeriodo}'",true);
		
		generarXmlResumen($idGrupoAfinidad,$dPeriodo);
		$oRespuesta->alert("Los Resumenes se generaron con exito.");
		$oRespuesta->assign("div_result_search","innerHTML","");
		return  $oRespuesta;
	}
	
	function generarAjustes($idGrupoAfinidad,$dPeriodo){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$sqlAjustes = "call usp_generarAjustesV2(\"{$idGrupoAfinidad}\",\"{$_SESSION['id_user']}\",\"{$dPeriodo}\")";
		$rtdoAjuste = $oMysql->consultaSel($sqlAjustes,true);
		if($rtdoAjuste == 'ok'){
			$oRespuesta->alert("Los Ajustes se generaron con exito.");
		}else{
			$oRespuesta->alert("Los Ajustes NO se generaron.");
		}
		$oRespuesta->assign("div_result_search","innerHTML","");
		
		return  $oRespuesta;
	}
	
	$oXajax=new xajax();	
	$oXajax->registerFunction("generarResumenesPorGrupo");
	$oXajax->registerFunction("generarXML");
	$oXajax->registerFunction("generarAjustes");
	
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	xhtmlHeaderPaginaGeneral($aParametros);	
	
	?>
	<style>
	.TablaGeneral{
		font-family:Tahoma;
		font-size:11px;
	}
	.TablaGeneral th{
		font-family:Tahoma;
		font-size:11px;
	}
	</style>	
<script>
	function _imageLoading_(_div_,_text_){
		document.getElementById(_div_).innerHTML = "<img src=\"../includes/images/ajax-loader.gif\" title=\"cargando\" alt=\"...\" width=\"16\" height=\"16\" align=\"absmiddle\"> <span style='font-size:11px;'>" + _text_ + "</span>";
	}	

	function generar(idGrupoAfinidad,dPeriodo){
		_imageLoading_('div_result_search','Procesando...');
		xajax_generarResumenesPorGrupo(idGrupoAfinidad,dPeriodo);	
	}

	function generarAjustes(idGrupoAfinidad,dPeriodo){
		_imageLoading_('div_result_search','Procesando...');
		xajax_generarAjustes(idGrupoAfinidad,dPeriodo);	
	}
	
	function generarXML(idGrupoAfinidad,dPeriodo){
		_imageLoading_('div_result_search','Procesando...');
		xajax_generarXML(idGrupoAfinidad,dPeriodo);	
	}

</script>	
<body style="background-color:#ffffff;">
<center>
	<!--<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div><br />-->
<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='0' bordercolor='#000000' width='98%' >
<tr>
	<td align="center" style="height:25px" colspan="2"><b>Generar Resumenes</b></td>
</tr>
<tr>
	<td id="tdContent">
		<table class='TablaGeneral' align='center' cellpadding='0' cellspacing='0' border='1' bordercolor='#000000' width='100%' >
		<?php		
		$aGrupos = explode(",",$_GET['sGrupos']);
		$sCuentas = "";
		$sBody = "";
		$sTabla = "";
		foreach ($aGrupos as $idGrupoAfinidad){
			$dPeriodo = $oMysql->consultaSel("call usp_getPeriodoACerrar(\"$idGrupoAfinidad\")",true);
			$aPeriodo = explode("-",$dPeriodo);
			$dPeriodoFormat = $aPeriodo[1].'/'.$aPeriodo[0]; 
			
			$sGrupo = $oMysql->consultaSel("SELECT sNombre FROM GruposAfinidades WHERE id={$idGrupoAfinidad}",true);
			$sBody .= "<tr><td>{$sGrupo}</td><td>{$dPeriodoFormat}</td>
			<td align='center' style='height:25px'>
			<button type='button' onclick=\"generarAjustes('{$idGrupoAfinidad}','{$dPeriodo}');\" id='btnGenerarAjustes' name='btnGenerarAjustes'> Generar Ajustes</button>
			<button type='button' onclick=\"generar('{$idGrupoAfinidad}','{$dPeriodo}');\" id='btnGenerar' name='btnGenerar'> Generar Resumenes</button>
			<button type='button' onclick=\"generarXML({$idGrupoAfinidad},'{$dPeriodo}','{$dPeriodoFormat}');\" id='btnGenerarXml' name='btnGenerarXml'> Generar XML </button>
			</td>
			</tr>";	
		}
		
		if($sBody != ""){
			$sTabla = "<tr><td align='center'>Grupo Afinidad</td><td align='center'>Periodo</td><td align='center'>Acciones</td>
			</tr>".$sBody;
		}
		echo $sTabla;
		?>
		</table>
	</td>
</tr>

</table>	
<br>
<center>
<div id="div_result_search">	
</div>
</center>
</center>
</body>
</html>