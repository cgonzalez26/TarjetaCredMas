<?php
function xhtmlHeaderPaginaGeneral($aDatos){
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head> 
		<title> <?=$aDatos['XHTML_TITLE'];?></title> 		
		<meta http-equiv='Content-Type' content='text/html; charset="iso-8859-1"'/>
		
		<link rel='stylesheet' href='<?=$aDatos['CSS_DIR'];?>/css/css.css' type='text/css'/>
		<link rel='stylesheet' href='<?=$aDatos['CSS_DIR'];?>/css/formularios.css' type='text/css'/>	
		<link rel='stylesheet' href='<?=$aDatos['CSS_DIR'];?>/css/ventanas.css' type='text/css'/>	
		<link rel='stylesheet' href='<?=$aDatos['CSS_DIR'];?>/css/fichas.css' type='text/css'/>	
		<link rel='stylesheet' href='<?=$aDatos['CSS_DIR'];?>/css/busqueda.css' type='text/css'/>	
		<link rel='stylesheet' href='<?=$aDatos['CSS_DIR'];?>/css/cuotas.css' type='text/css'/>	
		<link rel='stylesheet' href='<?=$aDatos['CSS_DIR'];?>/css/tablas.css' type='text/css'/>		
		<link rel='stylesheet' href='<?=$aDatos['CSS_DIR'];?>/css/drilldownmenu.css' type='text/css'/>	
		
		<!--window prototypeclass CSS-->
		<?php if($aDatos['WINDOW_PROTO']>0){ ?>
		<link href="<?=$aDatos['JS_DIR'];?>/js/windows_js_1.3/themes/default.css" rel="stylesheet" type="text/css" ></link>
		<link href="<?=$aDatos['JS_DIR'];?>/js/windows_js_1.3/themes/spread.css" rel="stylesheet" type="text/css" ></link>
		<link href="<?=$aDatos['JS_DIR'];?>/js/windows_js_1.3/themes/alert.css" rel="stylesheet" type="text/css" ></link>
		<link href="<?=$aDatos['JS_DIR'];?>/js/windows_js_1.3/themes/alert_lite.css" rel="stylesheet" type="text/css" ></link>		
		<link href="<?=$aDatos['JS_DIR'];?>/js/windows_js_1.3/themes/alphacube.css" rel="stylesheet" type="text/css" ></link>
		<link href="<?=$aDatos['JS_DIR'];?>/js/windows_js_1.3/themes/debug.css" rel="stylesheet" type="text/css" ></link>
		<link href="<?=$aDatos['JS_DIR'];?>/js/windows_js_1.3/themes/darkX.css" rel="stylesheet" type="text/css" ></link>
		<link href="<?=$aDatos['JS_DIR'];?>/js/windows_js_1.3/themes/lighting.css" rel="stylesheet" type="text/css" ></link>
		<link href="<?=$aDatos['JS_DIR'];?>/js/windows_js_1.3/themes/nuncio.css" rel="stylesheet" type="text/css" ></link>
		<?php } ?>
		<?php if($aDatos['DHTMLX_GRID']>0){ ?>
		<!--estilo de libreria dhtmlx 1.5-->
		<link rel="STYLESHEET" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/dhtmlxgrid.css">
		<link rel="STYLESHEET" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/skins/dhtmlxgrid_dhx_blue.css">
		
		<?php }?>
		
		<?php if($aDatos['DHTMLX_TREE']>0){ ?>
		<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxTree/codebase/dhtmlxtree.css">
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxTree/codebase/dhtmlxcommon.js"></script>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxTree/codebase/dhtmlxtree.js"></script>
		<?php } ?>
		
		<?php if($aDatos['DHTMLX_MENU']>0){ ?>
		<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxMenu/sources/skins/dhtmlxmenu_dhx_blue.css">
		<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxMenu/sources/skins/dhtmlxmenu_dhx_black.css">
		<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxMenu/sources/skins/dhtmlxmenu_clear_silver.css">
		<?php }?>
		<?php if($aDatos['DHTMLX_COMBO']>0){ ?>
		<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxCombo/sources/dhtmlxcombo.css" />
		<?php } ?>
		<?php if($aDatos['DHTMLX_TABBAR']>0){ ?>
		<!-- datos para pestañas-->
		<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxTabbar/sources/dhtmlxtabbar.css">
		<?php } ?>
		<?php if($aDatos['DHTMLX_ACORDEON']>0){ ?>
		<!--datos acordion y layaut-->
		<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxAccordion/sources/skins/dhtmlxaccordion_dhx_blue.css">
		<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxAccordion/sources/skins/dhtmlxaccordion_dhx_black.css">
		<?php }?>
		<?php if($aDatos['DHTMLX_LAYOUT']>0){ ?>
		<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxLayout/sources/skins/dhtmlxlayout_dhx_black.css">
		<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxLayout/sources/skins/dhtmlxlayout_dhx_blue.css">
		<?php } ?>
		<?php if($aDatos['DHTMLX_WINDOW']>0){ ?>
		<!-- ventanas-->
		<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxWindows/sources/dhtmlxwindows.css">
		<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxWindows/sources/skins/dhtmlxwindows_dhx_black.css">
		<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxWindows/sources/skins/dhtmlxwindows_dhx_blue.css">
		<?php }?>
		<?php if($aDatos['DHTMLX_CALENDAR']>0){ ?>
		<!--Para el Calendario-->
		<link rel="STYLESHEET" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxCalendar/codebase/dhtmlxcalendar.css">
		<link rel="STYLESHEET" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxCalendar/codebase/skins/dhtmlxcalendar_dhx_black.css">
		<link rel="STYLESHEET" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxCalendar/codebase/skins/dhtmlxcalendar_dhx_blue.css">
		<?php } ?>	
		<?php if($aDatos['WINDOW_PROTO']>0){ ?>
		<script type="text/javascript" src="<?=$aDatos['JS_DIR'];?>/js/windows_js_1.3/javascripts/prototype.js"> </script> 
		<script type="text/javascript" src="<?=$aDatos['JS_DIR'];?>/js/windows_js_1.3/javascripts/effects.js"> </script>
		<script type="text/javascript" src="<?=$aDatos['JS_DIR'];?>/js/windows_js_1.3/javascripts/window.js"> </script>
		<script type="text/javascript" src="<?=$aDatos['JS_DIR'];?>/js/windows_js_1.3/javascripts/window_effects.js"> </script>
		<script type="text/javascript" src="<?=$aDatos['JS_DIR'];?>/js/windows_js_1.3/javascripts/debug.js"> </script>
		<?php } ?>	
		<!--comienza codigo javascript-->	
		
		<script type='text/javascript' src='<?=$aDatos['JS_DIR'];?>/js/controles.js'></script>
		<script type='text/javascript' src='<?=$aDatos['JS_DIR'];?>/js/functions.js'></script>

		<?php if($aDatos['JSGRAFIC']>0){ ?>
		<script type="text/javascript" src="<?=$aDatos['JS_DIR'];?>/js/jsGrafic/highcharts.js"></script>
		<?php } ?>
		<?php if($aDatos['JSTAB']>0){ ?>
		<script type="text/javascript" src="<?=$aDatos['JS_DIR'];?>/js/tabs/jquery.tabs.min.js"></script>
		<?php } ?>
		
		<!--Para modal Message-->
		<script src="<?=$aDatos['JS_DIR'];?>/modalMessage/modal-message.js"></script>
		<script src="<?=$aDatos['JS_DIR'];?>/modalMessage/modal-message-ajax.js"></script>
		<script src="<?=$aDatos['JS_DIR'];?>/modalMessage/modal-message-ajax-dynamic-content.js"></script>
		
		<script type='text/javascript' src='<?=$aDatos['JS_DIR'];?>/js/MenuContextual.js'></script>
		<script type='text/javascript' src='<?=$aDatos['JS_DIR'];?>/js/drilldownmenu.js'></script>		
		<!--Para Teclado-->	
		<script type='text/javascript' src='<?=$aDatos['JS_DIR'];?>/js/teclado.js'></script>	
						
		<?php if($aDatos['DHTMLX_GRID']>0){ ?>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/dhtmlxcommon.js"></script>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/dhtmlxgrid.js"></script>	
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/dhtmlxgridcell.js"></script>	
		<?php } ?>
		
		<?php if($aDatos['DHTMLX_GRID_MATH']>0){ ?>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/ext/dhtmlxgrid_math.js"></script>
		<?php }?>
		
		<?php if($aDatos['DHTMLX_GRID_FILTER']>0){?>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/ext/dhtmlxgrid_filter.js"></script>
	    <?php }?>
	    <?php if($aDatos['DHTMLX_GRID_SRND']>0){?>
		<script src='<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/ext/dhtmlxgrid_srnd.js'></script>	
		<?php }?>
		<?php if($aDatos['DHTMLX_GRID_FORM']>0){?>	
		<script src='<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/ext/dhtmlxgrid_form.js'></script>
		<?php }?>
		<?php if($aDatos['DHTMLX_GRID_LINK']>0){?>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/excells/dhtmlxgrid_excell_link.js"></script>	
		<?php }?>
		<?php if($aDatos['DHTMLX_GRID_FAST']>0){?>
		<script src='<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/ext/dhtmlxgrid_fast.js'></script>	
		<?php }?>
		<?php if($aDatos['DHTMLX_GRID_DRAG']>0){?>		
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/ext/dhtmlxgrid_drag.js"></script>	
		<?php }?>
		<?php if($aDatos['DHTMLX_GRID_PROCESOR']>0){?>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxDataProcessor/sources/dhtmlxdataprocessor.js"></script>		
		<?php }?>
		<?php if($aDatos['DHTMLX_GRID_COMBO']>0){?>	
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/excells/dhtmlxgrid_excell_combo.js"></script>	
		<?php }?>
		
		<?php if($aDatos['DHTMLX_SUB_ROW']>0){?>	
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/excells/dhtmlxgrid_excell_sub_row.js"></script>	
		<?php }?>
		
		<?php if($aDatos['DHTMLX_HMENU']>0){?>	
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/ext/dhtmlxgrid_hmenu.js"></script>
		<?php }?>
		<?php if($aDatos['DHTMLX_PRINT']>0){?>	
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/ext/dhtmlxgrid_nxml.js"></script>	
		<?php }?>
		<?php if($aDatos['DHTMLX_TREE']>0){ ?>		
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxTree/codebase/dhtmlxcommon.js"></script>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxTree/codebase/dhtmlxtree.js"></script>
		<?php } ?>
		<?php if($aDatos['DHTMLX_COMBO']>0){ ?>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxCombo/sources/dhtmlxcombo.js"></script>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxCombo/dhtmlxcombo_extra.js"></script>
		<?php } ?>
		<?php if($aDatos['DHTMLX_MENU']>0){ ?>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxMenu/sources/dhtmlxcommon.js"></script>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxMenu/sources/dhtmlxmenu.js"></script>
		<?php }?>
		<?php if($aDatos['DHTMLX_TABBAR']>0){ ?>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxTabbar/sources/dhtmlxcommon.js"></script>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxTabbar/sources/dhtmlxtabbar.js"></script>
		<!--<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxTabbar/sources/dhtmlxtabbar_start.js"></script>-->
		<?php } ?>
		<?php if($aDatos['DHTMLX_ACORDEON']>0){ ?>	
		<script src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxAccordion/sources/dhtmlxaccordion.js"></script>
		<?php }?>
		<?php if($aDatos['DHTMLX_LAYOUT']>0){ ?>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxLayout/sources/dhtmlxcommon.js"></script>
		<script src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxLayout/sources/dhtmlxlayout.js"></script>
		<?php } ?>
		<?php if($aDatos['DHTMLX_WINDOW']>0){ ?>
		<script src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxWindows/sources/dhtmlxcommon.js"></script>
		<script src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxWindows/sources/dhtmlxwindows.js"></script>
		<script src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxWindows/sources/ext/dhtmlxwindows_wmn.js"></script>
		<?php } ?>
		<?php if($aDatos['DHTMLX_CALENDAR']>0){ ?>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxCalendar/codebase/dhtmlxcommon.js"></script>
		<script  src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxCalendar/codebase/dhtmlxcalendar.js"></script>
		<script src='<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxGrid/excells/dhtmlxgrid_excell_dhxcalendar.js'></script>
		<?php } ?>
		<?php if($aDatos['DHTMLX_TOOLBAR']>0){ ?>
		<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxToolbar/sources/skins/dhtmlxtoolbar_dhx_blue.css">
		<script src="<?=$aDatos['JS_DIR'];?>/grillas/dhtmlxToolbar/sources/dhtmlxtoolbar.js"></script>
		<?php } ?>
		
		<?php if($aDatos['dropdownchecklist']>0){ 
			/*<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/dropdown-check/src/ui.dropdownchecklist.themeroller.css">*/
		?>
			
			<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/dropdown-check/doc/smoothness/jquery-ui-1.8.4.custom.css">
			<link rel="stylesheet" type="text/css" href="<?=$aDatos['JS_DIR'];?>/dropdown-check/src/ui.dropdownchecklist.standalone.css">
			
			<script src="<?=$aDatos['JS_DIR'];?>/dropdown-check/doc/jquery-1.6.1.min.js"></script>
			<script src="<?=$aDatos['JS_DIR'];?>/dropdown-check/doc/jquery-ui-1.8.13.custom.min.js"></script>
			<script src="<?=$aDatos['JS_DIR'];?>/dropdown-check/doc/ui.dropdownchecklist-1.4-min.js"></script>
			
		<?php } ?>
				
		<?php //if(!in_array($_SESSION['id_user'],array(296))){ 
			/*<script type="text/javascript" src="<?=$aDatos['JS_DIR'];?>/js/mainSourceLex.js"></script>*/
		 //} 
		 ?>
	</head>
<?php	
}

function xhtmlHeaderPagina($aVariables){
	return parserTemplate( TEMPLATES_XHTML_DIR . "/struct/xhtml.header.tpl", $aVariables);
}

//-------------------------------------------
function xhtmlHeaderGrillas($aVariables=False){
	
	$sCadena = "";
	$sCadena = parserTemplate( TEMPLATES_XHTML_DIR . "/struct/xhtml.header.grillas.tpl", $aVariables);
	
	echo $sCadena;	
}

function xhtmlHeaderXGrid($aVariables=False){
	
	$sCadena='';
	$sCadena=parserTemplate( TEMPLATES_XHTML_DIR . "/struct/xhtml.header.xgrid.tpl", $aVariables);
	
	echo $sCadena;
	
}

function xhtmlTablaABM($aVariables=false,$sNombre=false){
	
	$sCadena='';

	if($sNombre){
		$sCadena=parserTemplate( TEMPLATES_XHTML_DIR . "/verForms/$sNombre.tpl", $aVariables);
	}else {
		$sCadena=parserTemplate( TEMPLATES_XHTML_DIR . "/struct/xhtml.tabla.abm.tpl", $aVariables);
	}
	
	echo $sCadena;	
}

function xhtmlFootPagina($aVaribales = array()){	
	
	if(sizeof($aVaribales) > 0){
		return parserTemplate( TEMPLATES_XHTML_DIR . "/struct/xhtml.foot.tpl", $aVaribales);
	}else{
		return parserTemplate( TEMPLATES_XHTML_DIR . "/struct/xhtml.foot.tpl", false);
	}
		
}

//-------------------------------------------

function  xhtmlFormRequestPassword($aVariables){
	return parserTemplate( TEMPLATES_XHTML_DIR . "/Pages/RecordarContraseña.tpl", $aVariables);
}

//-------------------------------------------

function xhtmlMainHeaderPagina($datos){
	//return parserTemplate( TEMPLATES_XHTML_DIR . "/blocks/mainHeader.tpl", $aVariables);
	return parserTemplate( TEMPLATES_XHTML_DIR . "/struct/mainHeader.tpl", $datos);
}

//-------------------------------------------

function xhtmlUserMenuPagina($aVariables){
	return parserTemplate( TEMPLATES_XHTML_DIR . "/blocks/userMenu.tpl", $aVariables);
}

//-------------------------------------------
/*
function __autoload( $className ) {		
	@ include_once( CLASSES_DIR . "/{$className}.class.php" );	
}
*/
//-------------------------------------------

function exitMessagge( $messagge, $link = null, $linkText = null ) {
		
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/exitMessage.tpl", false);
	
}

//-------------------------------------------

function getParametrosBasicos($Level){
	
	$arrayVariables = array();
	switch ($Level) {
		case 0:
			$BaseUrl = "backend/includes";		
			break;
		case 1:
			$BaseUrl = "../includes";		
			break;			
	}	
	
	$Browser = ObtenerNavegador($_SERVER['HTTP_USER_AGENT']);
	if( $Browser == 'Internet Explorer'){ $archiveStyle = 'styleIE.css';}else{$archiveStyle = 'styleMozilla.css';}
	
	$arrayVariables['ARCHIVE_CSS'] = $archiveStyle;
	$arrayVariables['CSS_DIR'] = $BaseUrl;
	$arrayVariables['JS_DIR'] = $BaseUrl;
	$arrayVariables['TEMPLATE_DIR'] = TEMPLATE_DIR;
	$arrayVariables['TEMPLATES_XHTML_DIR'] = TEMPLATES_XHTML_DIR;
	$arrayVariables['XHTML_TITLE'] = "Sistema de Tarjeta";
	
	return $arrayVariables;
}

//-------------------------------------------

function anyElementInArray($arrayElements, $arrayToSearch){
	global $mysql;
	$boolean = false;
	$TamarrayElements = sizeof($arrayElements) - 1;
	$i = 0;
	while(!$boolean && $i <= $TamarrayElements){
		$boolean = (in_array($arrayElements[$i],$arrayToSearch)) ? true : false;
		$i++;
	}
	
	return $boolean;
	
}

//-------------------------------------------

function xhtmlTituloSector($class,$seccion){
									
		return parserTemplate( TEMPLATES_XHTML_DIR . "/blocks/headerSector.tpl",array('CLASS' => $class,'SECCION' => $seccion));					
}

//-------------------------------------------

function arrayToOptions( $array ,$selected = null ){

	$sOptions = "";
	
	foreach($array as $option){		
		
		$select = ($option['CODE'] == $selected) ? "selected" : "";
		$sOptions .= "<option value='{$option['CODE']}' $select>{$option['TEXT']}</option>";
	}
	
	return $sOptions;
}

function arrayToOptionsPeriodos( $array ,$selected = null ){

	$sOptions = "";
	
	foreach($array as $option){		
		
		$select = ($option['CODE'] == $selected)? "selected" : "";
		$sOptions .= "<option value='{$option['CODE']}' $select>{$option['TEXT']}</option>";
	}
	
	return $sOptions;
}

function array_2_options( $array, $seleccionado = '' ) {
	
	
	If( !is_array( $array ) ) return;
	
	// Iteramos sobre el array
	Foreach( $array as $valor => $texto )
	
		// Si es un array el elemento actual, entonces
		// debemos crear un grupo de opciones <optgroup...,
		// y pasamos a la misma función el array para
		// obtener las opciones <options.. del subarray
		
		If( is_array( $texto ) )
			
		$cadena.=	"<optgroup label='$valor'>".
					array_2_options( $texto, $seleccionado ).
					"</optgroup>";
							
			
							
		Else 
		
		$cadena.=	"<option value='$valor' title='$texto'".
					( ( $seleccionado == $valor )? " selected='selected'":'').	
					"> $texto </option>";
		
		
	return $cadena;
}
function array_2_javascript_array( $array, $nombre = 'array_nuevo', $numerico = false ) {
	
	$cadena = "var $nombre = new Array();\n";
	
	Foreach( $array as $clave => $valor )  
	
	If( !is_array( $valor ) ) {
		
		If( !$numerico ) $clave = "'$clave'";
		$cadena.= "{$nombre}[$clave] = \"$valor\";\n";
	}
		
	Else Foreach( $valor as $clave_valor => $valor_valor ) {
		
		$clave = "{$clave}[{$clave_valor}]";
		
		If( !$numerico ) $clave = "'$clave'";
		$cadena.= "{$nombre}[$clave] = \"$valor_valor\";\n";
	}
	
	return $cadena;
}
//-------------------------------------------

function buttonNuevo($url,$text){
	return "<div class='botonNuevo'><a href='$url'>$text</a></div><div class='espacio'></div>";
}

function buttonExtras($url,$text,$images){
	$existImages = false;
	
	if(!is_array($url)){
		return "NO-VALIDO";
	}
	
	if(sizeof($images) == sizeof($url)){ $existImages = true;}
	
	$tamUrl = sizeof($url) - 1;
	for( $i=0; $i<=$tamUrl; $i++ ){
		$xhtmlImage = "";
		
		if($existImages) $xhtmlImage = "<img src='".IMAGES_DIR."/$images[$i]' border='0' hspace='4' title='{$text[$i]}'>";
		
		$xhtmlLinks .= $xhtmlImage . "<a href=\"$url[$i]\">[ $text[$i] ]</a> |";
	}
	return "<div style='text-align:right;margin-right:15px;'>$xhtmlLinks</div><div class='espacio'></div>";
}


//-------------------------------------------

function dateToMySql($date){
	if(ereg (  "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})" ,  $date ,  $dateMySql )){
		$Fecha = $dateMySql [ 3 ]. "-" . $dateMySql [ 2 ]. "-" . $dateMySql [ 1 ];  	
	}else{
		$Fecha = "";
	}
	
	
	return $Fecha;
}

//-------------------------------------------

function FormLocalidades($idProvincia){
	global $mysql;		
	
	$array = array();
	
	
	$OptionsProvincias = $mysql->query("CALL usp_getSelect('Provincias','id','sNombre','')");
	
	$array['OptionsProvincias'] = arrayToOptions($OptionsProvincias);
	
	$array['idProvincia'] = (!is_null($idProvincia)) ? $idProvincia : 0 ;	
	
	$array['JAVASCRIPT_ADICIONAL'] = "document.forms['form'].idProvincia.value= '{$array['idProvincia']}';";
	
	return parserTemplate( TEMPLATES_XHTML_DIR . "/formsParts/Localidades.tpl",$array);
}

//-------------------------------------------

function securityAcces($Object = '',$Permit = ''){
	global $oMysql;
	
	$arrayExceptions = array('');
	
	$idUser = $_SESSION['ID_USER'];
	
	if(is_null($idUser) || $idUser == 0){ return 0;}
	#Debo::: determinar controlar el acceso del usuario a un determinado sector	
	
	//$id = $oMysql->consultaSel("SELECT fcn_isPermit(\"$Permit\",\"$Object\",\"$idUser\");",true);
	
	$id = 1;
	
	if($id == 0 && in_array($Object,$arrayExceptions)){ $id = 1; }
	
	return $numRules;
	
}

//-------------------------------------------

function isLogin(){
	if(isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])){
		return true;		
	}else{
		return false;
	}
}

//-------------------------------------------

function ObtenerNavegador($user_agent) {
     $navegadores = array(
          'Opera' => 'Opera',
          'Mozilla Firefox'=> '(Firebird)|(Firefox)',
          'Galeon' => 'Galeon',
          'Mozilla'=>'Gecko',
          'MyIE'=>'MyIE',
          'Lynx' => 'Lynx',
          'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',
          'Konqueror'=>'Konqueror',
          'Internet Explorer' => 'MSIE',
);
	foreach($navegadores as $navegador=>$pattern){
	       if (eregi($pattern, $user_agent))
	       return $navegador;
	    }
	return 'Desconocido';
}


function addZero($string){
	if(!is_string($string)) settype($string,"string");
	
	$tamString = strlen($string) - 1;
	$CantCeros = 7;
	$sCadena = "";
	for($i = 0; $i < $CantCeros; $i++){
		$sCadena .= ( isset($string[$i])) ? $string[$i] : "0";
	}
	
	return strrev($sCadena);
}


function checkBoxOpener(){
		global $mysql;		 
		 
		list($idSucursal,$idOficina) = getSucursalyOficina($_SESSION['ID_USER']);	 
		$hoy = date("d/m/Y");
		
		$idCaja = Caja::getCaja($idOficina,$hoy);
		$idUser = $_SESSION['ID_USER'];		
		if($idCaja == 0){
			
			$SQL = "SELECT MAX(id) FROM Cajas WHERE idOficina = '$idOficina' AND sEstadoOficina = 'A' AND sEstadoUsuario = 'A';";
			$idCaja = $mysql->selectValue($SQL);
			//var_export($idOficina);die();
			$mysql->query("CALL usp_AbrirCerrarCajaGeneral(\"$idOficina\",\"$idCaja\",\"$idUser\");");
		}
		
		return true;
		
	}

function stringToUpper($array){
		$Up = array();
		
		foreach ($array as $key => $value) {
			
			if(!is_array($value)){
				$Up[$key] = strtoupper($value);	
			}else{
				$Up[$key] =stringToUpper($value);	
			}
			
		}
		
		return $Up;		
	}
	
function FechaYMD($Fecha,$Y=false){
	$aFecha = explode('/', $Fecha );
	
	$aHora=explode(':',$aFecha[2]);
	if($Y){
		
		if($Y=='Y'){
			$sHora=substr($aFecha[2],5);
			$aFecha[2]=substr($aFecha[2],0,4);
		}elseif($Y=='y'){
			$sHora=substr($aFecha[2],3);
			$aFecha[2]=substr($aFecha[2],0,2);
		}
		$Fecha = "{$aFecha[2]}-{$aFecha[1]}-{$aFecha[0]} {$sHora}";
		
	}else $Fecha = "{$aFecha[2]}-{$aFecha[1]}-{$aFecha[0]}";
	return $Fecha;
}



	function stringPermitsUser($idUsuario,$idUnidaNegocio){
		global $oMysql;
		$body = "";
			
		
		$permits = $oMysql->consultaSel("CALL usp_getPermitUser(\"$idUsuario\",\"$idUnidaNegocio\");");				
		$idItem = "";
			
		foreach ($permits as $permit){

			$idItem .= "idPermitObject_".$permit['ID_PERMIT_OBJECT'].",";

		}
		
		$idItem = substr_replace($idItem,"",-1);
		
		return $idItem;
	}
	
	function MesesDespues($dFecha,$iMes,$iTipo=false){
	
		$ex=explode('/',$dFecha);
		
		if ($ex[1]!="12" and $ex[1]!="11" ) { $newMes=$ex[1] + $iMes; $newAno="{$ex[2]}"; }
		elseif ($ex[1]=="11") { $newMes="01"; $newAno=$ex[2]+1; }
		elseif ($ex[1]=="12") { $newMes="02"; $newAno=$ex[2]+1; }
					
		if (!$iTipo) {
			$mesDespues="{$ex[0]}/$newMes/$newAno";
		}else{
			$mesDespues="$newAno-$newMes-{$ex[0]}";
		}	
		return $mesDespues;
	}
	
	function insertarTemplate($sNombre=false, $aVariables = false ,$bModulo=false) {
		
		$sCadena='';
		if($bModulo){
			$sCadena=parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/$sNombre/$sNombre.tpl", $aVariables);
		}else {
			$sCadena=parserTemplate( TEMPLATES_XHTML_DIR . "/VerForms/$sNombre.tpl", $aVariables);
		}
		
		echo $sCadena;
	}

	function viewTemplate($sUrl, $aVariables = false) {
		
		$sCadena='';
		
		$sCadena=parserTemplate( TEMPLATES_XHTML_DIR .$sUrl, $aVariables);
		return $sCadena;
	}
	 
	function getOpcionesAnios( $iDefecto = -1, $bSeleccionar = true,$sInicio=false) {
	
		if(!$sInicio) $sInicio='1950';
		$aArray = range( date('Y') + 1, $sInicio, -1 );
		
		If( $bSeleccionar ) $sOpciones.= "<option value='0'>Seleccionar...</option><option value='0'></option>";
		$sOpciones.= array_2_options( array_combine($aArray, $aArray), $iDefecto );
		
		return $sOpciones;
		
	}
	function validarCC($irecibo){
		GLOBAL $oMysql;
		
		$sConsulta = "call usp_validarCartaCobertura('$irecibo')";
		return $oMysql->consultaSel( $sConsulta, true	 );
		
	}
	
	function calcularPremio( $idCobVal, $idCobCoe, $idVehiUso, $idLocalidad, $fValor,$dominio=false) {
	
		GLOBAL $oMysql;
		if($dominio)
		{
			$iAnio=$dominio;
		    $query="select max_antiguedad from tipos_coberturas where id_tcob={$idCobVal}";
			$anio=$oMysql->consultaSel($query,true);
			if ( $iAnio < $anio) $idCobVal=6;
		}	
		$idSucursal = getIDSucursal( $idLocalidad );
		
		$sConsulta = "SELECT id_tvehi, id_tuso FROM vehiculos_usos WHERE id_vehiuso = $idVehiUso";
		$aVehiUso = $oMysql->consultaSel( $sConsulta, true );
			
		$sConsulta = "CALL usp_premio('$idCobCoe', '$idCobVal', '{$aVehiUso['id_tvehi']}', '{$aVehiUso['id_tuso']}', '$idLocalidad', '$fValor', '$idSucursal')";
		
		$aFila = $oMysql->consultaSel( $sConsulta, true );	
		
		return $aFila['premio'];
	}
	
	function getIDSucursal( $idLocalidad ) {	
		GLOBAL $oMysql;
		session_start();
		
		$sConsulta = "SELECT id_suc FROM sucursales WHERE id_loc = '$idLocalidad'";
		$idSucursal = $oMysql->consultaSel( $sConsulta, true );
		
		If( !$idSucursal ) {
					
			$sConsulta = "SELECT id_suc FROM sucursales WHERE id_loc IN (SELECT id_loc FROM localidades WHERE id_provi IN (SELECT id_provi FROM localidades WHERE id_loc = '$idLocalidad') )";
			$idSucursal = $oMysql->consultaSel( $sConsulta, true );
			
			If( !$idSucursal ) {
				
				$sConsulta = "SELECT id_suc FROM sucursales WHERE id_suc = '{$_SESSION['id_suc']}'";
				$idSucursal = $oMysql->consultaSel( $sConsulta, true );
			}
		}
		
		return $idSucursal;
	}
	
	function calcularImporteCuota($iNum,$idPol,$iTipo,$fPremio,$iDuracion){
		GLOBAL $oMysql;
		
		
		$dVeinte=0.2*$fPremio;
		if($iTipo==2)
		{	
		  if($iDuracion!=12){
				if(($iNum==1) and ($idPol==0)){ 
					
					$fImporte=$dVeinte;	
					
				}elseif($idPol==0){
					
					$fImporte=($fPremio-$dVeinte)/($iDuracion-1);		
					
				} elseif($idPol > 0) $fImporte=$fPremio/$iDuracion;	 
		  }elseif ($iDuracion==12) $fImporte=$fPremio/$iDuracion;	 
	    }
		else $fImporte=$fPremio/$iDuracion;
		
		return $fImporte;
	}
	function datosAseguradosAP($idPoliza){
		GLOBAL $oMysql;
		
		$sqlDatos="CALL usp_get_aseguradosAP(\"polizas_ap.id_pol= $idPoliza\");";
			
		
		$aAsegurados = $oMysql->consultaSel($sqlDatos);
		
		
		return $aAsegurados;
	}


	function datosBeneficiariosAP($idAseap){
		GLOBAL $oMysql;
		$sqlDatos = "CALL usp_get_beneficiarioAP({$idAseap});";
				
	    $aBeneficiario = $oMysql->consultaSel($sqlDatos);
		
	    return $aBeneficiario;
	}
	function sectorName($sector){
		
		$table = "<center><table width='100%' align='center' style='font-family:Times New Roman;font-size:18px;font-weight:bold;background:#FFF;' cellpadding='0' cellspacing='0'>		
				<tr>
					<td align='left' style='font-style:italic;border-bottom:2px solid #B5D6DF;border-top:2px solid #B5D6DF;' height='60'>&nbsp;&nbsp;::: Sector: [ $sector ]</td>
				</tr>
			  </table></center>";
		
		return $table;
	}
	 function _dateToMySql($fecha){
	
		$hora = '';	
		$aFecha = explode(" ",$fecha);
		$hora = $aFecha[1];
		$date = $aFecha[0];
		
		if(ereg (  "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})" ,  $date ,  $dateMySql )){
			$Fecha = $dateMySql [ 3 ]. "-" . $dateMySql [ 2 ]. "-" . $dateMySql [ 1 ];
			$Fecha .= ($hora != '') ? " ".$hora : "";
		}else{
			$Fecha = "";
		}
		
		
		return $Fecha;
	}
	
	function getMesXX($iNum){
		
		$meses=array();
		$meses['01'] = "Enero";
		$meses['02'] = "Febrero";
		$meses['03'] = "Marzo";
		$meses['04'] = "Abril";
		$meses['05'] = "Mayo";
		$meses['06'] = "Junio";
		$meses['07'] = "Julio";
		$meses['08'] = "Agosto";
		$meses['09'] = "Septiembre";
		$meses['10'] = "Octubre";
		$meses['11'] = "Noviembre";
		$meses['12'] = "Diciembre";
		
		return $meses[$iNum];
	}
	
function SetupFilesTipos($sTablaTipos,$sKey,$sCampo,$sCampoAlias){
	global $oMysql;
	$sConsulta = " call usp_getSelect(\"$sTablaTipos\",\"\",\" $sKey, $sCampo \") ";
	$aDatos = $oMysql->consultaSel($sConsulta);
	foreach ($aDatos as $ele){
		
		$aContenido[]= "{$ele[$sKey]} => '{$ele[$sCampoAlias]}'";
		/*$aCampos = implode($sCampos,', ');
		if(count($aCampos) ==1){
			$aContenido[]= "{$ele[$sKey]} => '{$ele[$sCampo]}'";
		}else{
			$aContenido[]= "{$ele[$sKey]} => 'array{$ele[$sCampo]}'";
		} */			
	}
	
	$sContenido_array = implode(',',$aContenido);
	
	$contenido = "";
	$contenido .= '<?php ' . chr(13) . chr(10);
	$contenido .= chr(9) .'$aArray_'.$sTablaTipos." = array($sContenido_array);". chr(13) . chr(10);
	$contenido .= '?>';	
	
	$file = fopen("../includes/FileTipos/File_$sTablaTipos.php", "w+" );
	fwrite($file,$contenido);			
	fclose($file);
}

function SetupFilesRelacionTipos($sTablaTipos,$sNombre,$sKey,$sForanea1,$sCampo1,$sCampo2){
	global $oMysql;
	
	$sConsulta = " call usp_getSelect(\"$sTablaTipos\",\"\",\" $sKey,$sForanea1,$sCampo1,$sCampo2 \") ";
	
	$aAux1=explode('.',$sForanea1);
	$sForanea1=$aAux1[1];
	
	/*$aAux1=explode('.',$sForanea2);
	$sForanea2=$aAux1[1];*/
	
	$aAux1=explode('.',$sCampo1);
	$sCampo1=$aAux1[1];
	
	$aAux1=explode('.',$sCampo2);
	$sCampo2=$aAux1[1];
	
	$aDatos = $oMysql->consultaSel($sConsulta);
	foreach ($aDatos as $ele){
		$ele[$sCampo1] = $oMysql->escapeString($ele[$sCampo1]);
		$ele[$sCampo2] = $oMysql->escapeString($ele[$sCampo2]);
		$aContenido[]= "{$ele['id']} => array('$sForanea1'=>{$ele[$sForanea1]},'$sCampo1'=>'{$ele[$sCampo1]}','$sCampo2'=>'{$ele[$sCampo2]}')";	
	}
	
	$sContenido_array = implode(',',$aContenido);
	
	$contenido = "";
	$contenido .= '<?php ' . chr(13) . chr(10);
	$contenido .= chr(9) .'$aArray_'.$sNombre." = array($sContenido_array);". chr(13) . chr(10);
	$contenido .= '?>';	
	
	$file = fopen("../includes/FileTipos/File_$sNombre.php", "w+" );
	fwrite($file,$contenido);			
	fclose($file);
}

function SetupFilesRelacionTiposMarcasModelos($sTablaTipos,$sNombre,$sKey,$sForanea1,$sForanea2,$sMarca,$sModelo){
	global $oMysql;
	
	$sConsulta = " call usp_getSelect(\"$sTablaTipos\",\"\",\" $sKey,$sForanea1,$sForanea2,$sMarca,$sModelo \") ";
		
	$aAux1=explode('.',$sForanea1);
	$sForanea1=$aAux1[1];
	
	$aAux1=explode('.',$sForanea2);
	$sForanea2=$aAux1[1];
	
	$aAux1=explode('AS',$sMarca);
	$sMarca=trim($aAux1[1]);
	//$sMarca=$oMysql->escaparCadena(trim($aAux1[1]));
	
	$aAux1=explode('AS',$sModelo);
	$sModelo=trim($aAux1[1]);
	//$sModelo=$oMysql->escaparCadena(trim($aAux1[1]));
	
	$aDatos = $oMysql->consultaSel($sConsulta);
	foreach ($aDatos as $ele){
		if(!$ele[$sForanea1]) $ele[$sForanea1]=0;
		if(!$ele[$sForanea2]) $ele[$sForanea2]=0;
		$aContenido[]= "{$ele[$sKey]} => array('$sForanea1'=>{$ele[$sForanea1]},'$sForanea2'=>{$ele[$sForanea2]},'$sMarca'=>'{$ele[$sMarca]}','$sModelo'=>'{$ele[$sModelo]}')";
	}
	
	$sContenido_array = implode(',',$aContenido);
	
	$contenido = "";
	$contenido .= '<?php ' . chr(13) . chr(10);
	$contenido .= chr(9) .'$aArray_'.$sNombre." = array($sContenido_array);". chr(13) . chr(10);
	$contenido .= '?>';	
	
	$file = fopen("../includes/FileTipos/File_$sNombre.php", "w+" );
	fwrite($file,$contenido);			
	fclose($file);
}

function SetupFileTiposCobertura(){
	global $oMysql;
	
	$sConsulta=" SELECT id_tcob,cod,tipo,CONCAT(cod, ' - ', descri) as Descripcion FROM tipos_coberturas; ";
	
	$aDatos = $oMysql->consultaSel($sConsulta);
	
	foreach ($aDatos as $ele){
		$aContenido[]= "{$ele['id_tcob']} => array('cod'=>'{$ele['cod']}','tipo'=>'{$ele['tipo']}','Descripcion'=>\"{$ele['Descripcion']}\")";	
	}
	
	$sContenido_array = implode(',',$aContenido);
	
	$contenido = "";
	$contenido .= '<?php ' . chr(13) . chr(10);
	$contenido .= chr(9) .'$aArray_tipos_coberturas'." = array($sContenido_array);". chr(13) . chr(10);
	$contenido .= '?>';	
	
	$file = fopen("../includes/FileTipos/File_tipos_coberturas.php", "w+" );
	fwrite($file,$contenido);			
	fclose($file);
}


function login($user, $pass)
{
  GLOBAL $oMysql;	
    
  $sConsulta="SELECT pass FROM user WHERE login='$user'";
  $result=$oMysql->consultaSel($sConsulta,true);
    
  if($result){
  	$passVerdadero=$result;
 
  	if( strlen( $passVerdadero ) == 32 ) return md5( $pass ) == $passVerdadero;
  		
  	else {
  		
  		$correcto = crypt($pass,'ketoolsistemacomercialparametrizablecontomadedecisiones') == $passVerdadero;
  		
  		if($correcto) {
  			
  			$sConsulta="UPDATE user SET pass = MD5('$pass') WHERE login='$user'"; 
  			$oMysql->startTransaction();
  			$oMysql->consultaAff($sConsulta);
	        $oMysql->commit();
  		}	
  		return $correcto;
  	}
  }else return false;
}

function DifComparaFechas($fecha1,$fecha2)
{
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
               list($dia1,$mes1,$año1)=split("/",$fecha1);
    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$año1)=split("-",$fecha1);
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
              list($dia2,$mes2,$año2)=split("/",$fecha2);
    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
             list($dia2,$mes2,$año2)=split("-",$fecha2);
    $dif = mktime(0,0,0,$mes1,$dia1,$año1) - mktime(0,0,0, $mes2,$dia2,$año2);
    return ($dif);                         
}


function cd_paramGlobal($parametro){
	global $_GET;
	global $_POST;
	if (isset($_GET[$parametro])) return $_GET[$parametro];
	elseif(isset($_POST[$parametro])) return $_POST[$parametro];
	else return false;
}

function insertarTemplateV1($sUrl, $aVariables = false) {
		
		$sCadena='';
		
		$sCadena=parserTemplate( TEMPLATES_XHTML_DIR .$sUrl.'.tpl', $aVariables);
		echo  $sCadena;
}

function definirAsignacion($id_tardetap){
	GLOBAL $oMysql;
	$sConsulta = "SELECT amf, indice FROM tarifas_detallesap WHERE id_tardetap= '$id_tardetap' ";
    $aFilas = $oMysql->consultaSel( $sConsulta,true);
    
    return $aFilas;
}


	/********* Permisos para el Sistema de Acsesos *******/

	function stringPermitsUser_AccesosSistemas($idUsuario){
		global $oMysql;
		$body = "";
		$permits = $oMysql->consultaSel("CALL usp_getPermitUser(\"$idUsuario\");");				
		$idItem = "";
		foreach ($permits as $permit){
			$idItem .= "idPermitObject_".$permit['ID_PERMIT_OBJECT'].",";
		}
		$idItem = substr_replace($idItem,"",-1);
		return $idItem;
	}
	
function setXMLPermitsUser($aPermisos){
	$sObjetos="";
	foreach ($aPermisos as $key => $aPermiso){
		$sObjetos.=chr(9)."<Objeto id=$key sPermisos ='{$aPermiso['sPermisos']}' > {$aPermiso['sObjeto']} </Objeto>".chr(13) . chr(10);
	}
	
	//$sObjetos
	
	$sXML="
	<?xml version='1.0' standalone='yes' ?>
	<Objetos>
	</Objetos>
	";
	
	
   return $sXML;	
}
function stringPermitsObject($idObjeto){
		global $oMysql;
		$body = "";
			
		
		$permits = $oMysql->consultaSel("CALL usp_getObjectsPermit(\"WHERE Objetos.id = {$idObjeto}\");");				
		$idItem = "";
			
		foreach ($permits as $permit){

			$idItem .= $permit['idTipoPermiso'].",";

		}
		
		$idItem = substr_replace($idItem,"",-1);
		
		return $idItem;
}

	###Funciones para el manejo de variables de session
	function session_add_var( $name, $value = false ) { 

			@ $_SESSION[ $name ] =  base64_encode( serialize( $value ) ) ;

	}	
	
	function session_remove_var( $name ) { 

			unset( $_SESSION[ $name ] );

	}
	
	function session_get_var( $name, $delete = false ) {

		$var = unserialize( base64_decode( $_SESSION[ $name ] ) ) ;

		if( $delete ) session_remove_var( $name );

		return $var;
	}
	
	function _encode( $value = '' ) {

		return base64_encode( serialize( $value ) ) ;

	}
	
	function _decode( $value = '' ){

		return unserialize( base64_decode( $value ) ) ;

	}

		
	
	function _addslashes_($datos){
		$a = array();
		if(is_array($datos)){

			foreach ($datos as $key => $value) { 
				
				if(is_array($value)){
					$a[$key] = _addslashes_($value);	
				}else{
					$a[$key] = addslashes($value);	
				}
				
			 }
			
			return $a;
		}else{

			$datos = addslashes( $datos );
			
			return $datos;

		}

		
	}	
	
	function generarNumeroSolicitud($sRegionUsuario){
		global $oMysql;
		$aNumeros = $oMysql->consultaSel(" SELECT sNumero FROM SolicitudesUsuarios ORDER BY sNumero DESC");
		
		$sNuevoNumeroSolicitud = "";
		$bEncontrado = false;
		$sNumSolicitud = "";
		$sPrefijoSolicitud = "";
		foreach ($aNumeros as $sNumero){
			$sPrefijo = substr($sNumero,0,2);
			
			if($sRegionUsuario == $sPrefijo){
				$sNumSolicitud = substr($sNumero,2,strlen($sNumero));	
			
				$sNumSolicitud = (int)$sNumSolicitud +1;
				$sPrefijoSolicitud = $sPrefijo;
				$bEncontrado = true;
				break;
			}
		}
		if($bEncontrado){
			$sNuevoNumeroSolicitud .= $sPrefijoSolicitud . number_pad($sNumSolicitud,5);
		}else{
			$sNuevoNumeroSolicitud .= $sRegionUsuario . '00001';
		}
		/*if($bEncontrado){
			$sNuevoNumeroSolicitud .= $sPrefijoSolicitud . number_pad($sNumSolicitud,4);
		}else{
			$sNuevoNumeroSolicitud .= $sRegionUsuario . '0001';
		}*/
		return $sNuevoNumeroSolicitud;
	}
	
	function allhtmlentities($string) { 
	    if ( strlen($string) == 0 ) 
	        return $string; 
	    $result = ''; 
	    $string = htmlentities($string, HTML_ENTITIES); 
	    $string = preg_split("//", $string, -1, PREG_SPLIT_NO_EMPTY); 
	    $ord = 0; 
	    for ( $i = 0; $i < count($string); $i++ ) { 
	        $ord = ord($string[$i]); 
	        if ( $ord > 127 ) { 
	            $string[$i] = '&#' . $ord . ';'; 
	        } 
	    } 
	    return implode('',$string); 
	} 
	
	/************* FUNCIONES TARJETA **************/
		function luhn($numero){	
	 	$suma = 0;
	  	for($x = 0; $x < 15; $x++){
			if(!($x % 2)){//$x es impar
				$y = $numero[$x]*2;
				if($y >= 10)
					$y = $y-9; //como sumar sus dos digitos
			
			}else{
				$y = $numero[$x];
			}
			$suma = $suma + $y;
		  }
		$suma = 10 - ($suma % 10);
		if($suma == 10)
			$suma = 0;
		
		$ultimoDigito = $suma;
		return $ultimoDigito;
	}
	
	function generarCodigoSeguridadTarjeta($sNumero){  
		// Visa, MasterCard o Discovery
		$sDigito1 = $sNumero[5];  //sexto digito de la Numero
		$sDigito2 = $sNumero[12]; //onceavo
		$sDigito3 = $sNumero[14]; //quinceavo
		$sDigito4 ="";
		if($sNumero[2] == "9") //si el tercer digito es 9
			$sDigito4 .= "1";
		else{
			$sDigito4 .= (int)$sNumero[2] + 1;
		}
		$codigo = $sDigito1 . $sDigito2 . $sDigito3 . $sDigito4; 
		return $codigo;
	}
	
	function obtenerNumeroBIN($idBIN){
		global $oMysql;
		$sNumeroBIN = $oMysql->consultaSel("SELECT sBIN FROM MultiBin WHERE id={$idBIN}",true);
		return $sNumeroBIN;
	}
	
	function generarNumeroPedidoDeLotes(){
		global $oMysql;
		$sNumPedido = $oMysql->consultaSel("SELECT sNumeroPedido FROM LotesEmbosajes ORDER BY sNumeroPedido DESC LIMIT 0,1",true);
		if(!$sNumPedido) $sNumPedido = "1000";
		$sNumPedido = (int)$sNumPedido +1;
		
		return $sNumPedido;
	}
	
	function generarNumeroPedidoDeLotesCorreo(){
		global $oMysql;
		$sNumPedido = $oMysql->consultaSel("SELECT sNumeroPedido FROM LotesCorreos ORDER BY sNumeroPedido DESC LIMIT 0,1",true);
		if(!$sNumPedido) $sNumPedido = "10000";
		$sNumPedido = (int)$sNumPedido +1;
		
		return $sNumPedido;
	}
	
	function generarXmlResumen($idGrupoAfinidad,$dPeriodo){
		GLOBAL $oMysql;
		ini_set("memory_limit","2048M");
		
		//$mysql->setDBName("Accesos");
		$aPeriodo = explode("-",$dPeriodo);
		$dPeriodoFormat = $aPeriodo[1].'-'.$aPeriodo[0];
		
		/*$sqlDatos=" SELECT CuentasUsuarios.id,CuentasUsuarios.idTipoEstadoCuenta
 					FROM CuentasUsuarios 
 					WHERE CuentasUsuarios.idGrupoAfinidad = {$idGrupoAfinidad}";		
		$rs = $oMysql->consultaSel($sqlDatos);*/		
		//$sCondicion=" WHERE CuentasUsuarios.id = {$row['id']}";
		
		$sCondicion=" WHERE CuentasUsuarios.idGrupoAfinidad = {$idGrupoAfinidad} AND DetallesCuentasUsuarios.dPeriodo='{$dPeriodo}' AND CuentasUsuarios.idTipoEstadoCuenta<>12 LIMIT 0,3000";
		//$sCondicion=" WHERE CuentasUsuarios.idGrupoAfinidad = {$idGrupoAfinidad} AND DetallesCuentasUsuarios.dPeriodo='{$dPeriodo}'  AND CuentasUsuarios.id IN (89,165,193,205,208,264,279,282,296,298,303,320,362,367,380,388,389,484,524,551,587,596,615,626,658,659,691,764,768,835) ";
	
		$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondicion\");";
		
		
		$rs = $oMysql->consultaSel($sqlDatos);
			
		$path = "../includes/Files/Datos/".$dPeriodoFormat;	
		//var_export($path);
		if (!is_dir($path)) {
			if(!mkdir($path,0777))
			{
		    	die('Fallo al crear Directorio...');
			}	
		}
		//	var_export($path);die();
		foreach ($rs as $row){			
			
			$rsCuenta   = $row;
			//var_export($rsCuenta);die();
			$sCondicionDetalle=" WHERE DetallesCuentasUsuarios.idCuentaUsuario={$row['id']} AND DetallesCuentasUsuarios.dPeriodo='{$dPeriodo}'";
			$sqlDetalle="Call usp_getDetallesCuentasUsuarios(\"$sCondicionDetalle\");";
			$rsDetalleCuenta = $oMysql->consultaSel($sqlDetalle,true);
						
			$sCondicionCalendario = " WHERE CalendariosFacturaciones.idGrupoAfinidad={$idGrupoAfinidad} AND CalendariosFacturaciones.dPeriodo=DATE_ADD('{$dPeriodo}',interval 1 MONTH)";
			$sqlCalendario = "Call usp_getCalendarioFacturacion(\"$sCondicionCalendario\");";
			$rsCalendario = $oMysql->consultaSel($sqlCalendario,true);
			
			$sqlResumen = "call usp_getResumenPorCuenta(\"{$row['id']}\",\"{$dPeriodo}\");";
			$rsResumen = $oMysql->consultaSel($sqlResumen);
			
			$sTitular = "";
			if($rsCuenta['iTipoPersona'] == 2)					
				$sTitular .= $rsCuenta['sRazonSocial'];				
			else
				$sTitular .= $rsCuenta['sNombre'].' '.$rsCuenta['sApellido'];				
			
			/*$sDomicilio = "Calle:".$rsCuenta['sCalle'].", Nro:".$rsCuenta['sNumeroCalle'];
			
			if(($rsCuenta['sBlock'] != "") && ($rsCuenta['sBlock'] != "0")) $sDomicilio .=', Block: '.$rsCuenta['sBlock'];
			
			if(($rsCuenta['sPiso'] != "") && ($rsCuenta['sPiso'] != "0")) $sDomicilio .= ', Piso:'.$rsCuenta['sPiso'];
			
			if(($rsCuenta['sDepartamento'] != "") && ($rsCuenta['sDepartamento'] != "0")) $sDomicilio .= ', Dpto:'.$rsCuenta['sDepartamento'];			
			
			if($rsCuenta['sBarrio'] != "") $sDomicilio .= ', Barrio:'.$rsCuenta['sBarrio'];	

			if($rsCuenta['sManzana'] != "") $sDomicilio .= ', Mza: '.$rsCuenta['sManzana'];
			if($rsCuenta['sLote'] != "") $sDomicilio .= ', Lote: '.$rsCuenta['sLote'];
			
			$sDomicilio .= '<br>'.$rsCuenta['sProvincia'].', '.$rsCuenta['sLocalidad'].', '.$rsCuenta['sCodigoPostal'];
			$sDomicilio = convertir_especiales_html($sDomicilio);*/
			
			$sCondicionEnvio = " WHERE SolicitudesUsuarios.id ={$row['idSolicitud']}";
            $sqlEnvio="Call usp_getDatosEnvioResumen(\"$sCondicionEnvio\");";
			$rsEnvio = $oMysql->consultaSel($sqlEnvio,true);
			
			$sDomicilio = "Calle:".$rsEnvio['sCalleResumen'].", Nro:".$rsEnvio['sNumeroCalleResumen'];
			
			if(($rsEnvio['sBlockResumen'] != "") && ($rsEnvio['sBlockResumen'] != "0")) $sDomicilio .=', Block: '.$rsEnvio['sBlockResumen'];
			
			if(($rsEnvio['sPisoResumen'] != "") && ($rsEnvio['sPisoResumen'] != "0")) $sDomicilio .= ', Piso:'.$rsEnvio['sPisoResumen'];
			
			if(($rsEnvio['sDepartamentoResumen'] != "") && ($rsEnvio['sDepartamentoResumen'] != "0")) $sDomicilio .= ', Dpto:'.$rsEnvio['sDepartamentoResumen'];			
			
			if($rsEnvio['sBarrioResumen'] != "") $sDomicilio .= ', Barrio:'.$rsEnvio['sBarrioResumen'];	

			if($rsEnvio['sManzanaResumen'] != "") $sDomicilio .= ', Mza: '.$rsEnvio['sManzanaResumen'];
			if($rsEnvio['sLoteResumen'] != "") $sDomicilio .= ', Lote: '.$rsEnvio['sLoteResumen'];
			
			if($rsEnvio['sEntreCalleResumen'] != "") $sDomicilio .= '<br>Entre Calles:'.$rsEnvio['sEntreCalleResumen'];
			
			$sDomicilio .= '<br>'.$rsEnvio['sProvinciaResumen'].', '.$rsEnvio['sLocalidadResumen'].', '.$rsEnvio['sCodigoPostalResumen'];
			$sDomicilio = convertir_especiales_html($sDomicilio);
			
			$buffer = '<?xml version="1.0" encoding="utf-8"?>
	          <!--Este  es un ejemplo para crear un archivo xml con php-->
	           <resumen>
	       			<idGrupoAfinidad>'.$idGrupoAfinidad.'</idGrupoAfinidad>
					<idCuentaUsuario>'.$row['id'].'</idCuentaUsuario>
					<idModeloResumen>'.$rsDetalleCuenta['idModeloResumen'].'</idModeloResumen>
					<sNumeroCuentaUsuario>'.$rsCuenta['sNumeroCuenta'].'</sNumeroCuentaUsuario>
					<dPeriodo>'.$dPeriodo.'</dPeriodo>
					<dFechaCierre>'.$rsDetalleCuenta['dFechaCierre'].'</dFechaCierre>
					<dFechaVencimiento>'.$rsDetalleCuenta['dFechaVencimiento'].'</dFechaVencimiento>
					<dFechaCierreSiguiente>'.$rsCalendario['dFechaCierre'].'</dFechaCierreSiguiente>
					<dFechaVencimientoSiguiente>'.$rsCalendario['dFechaVencimiento'].'</dFechaVencimientoSiguiente>
					<dFechaInicio>'.$rsCuenta['dFechaRegistro'].'</dFechaInicio>
					<fSaldoAnterior>'.$rsDetalleCuenta['fSaldoAnterior'].'</fSaldoAnterior>
					<sTitular><![CDATA['.stripslashes($sTitular).']]></sTitular>
					<sEstado>'.$rsCuenta['sEstado'].'</sEstado>
					<sDomicilio><![CDATA['.$sDomicilio.']]></sDomicilio>
					<fTotalResumen>'.$rsDetalleCuenta['fImporteTotalPesos'].'</fTotalResumen>
					<fLimiteCredito>'.$rsDetalleCuenta['fLimiteCredito'].'</fLimiteCredito>
					<fLimiteCompra>'.$rsDetalleCuenta['fLimiteCompra'].'</fLimiteCompra>
					<fLimiteAdelanto>'.$rsDetalleCuenta['fLimiteAdelanto'].'</fLimiteAdelanto>
					<fRemanenteCredito>'.$rsDetalleCuenta['fRemanenteCredito'].'</fRemanenteCredito>					
					<fRemanenteCompra>'.$rsDetalleCuenta['fRemanenteCompra'].'</fRemanenteCompra>					
		    		<fRemanenteAdelanto>'.$rsDetalleCuenta['fRemanenteAdelanto'].'</fRemanenteAdelanto>';			
			  		   
		   if(count($rsResumen)>0){
		   	   $fIvaTotal = 0;
		   	   foreach($rsResumen as $rowResumen){
		   	   	   $sCondiciones = " WHERE Empleados.id={$rowResumen['idEmpleado']}";
				   $sqlDatos = "Call Accesos.usp_getEmpleados(\"$sCondiciones\");";
				   //$rsEmpleado = $mysql->selectRow($sqlDatos,true);
				   $rsEmpleado = $oMysql->consultaSel($sqlDatos,true);
				   if($rowResumen['sCuotas'] == 0) $rowResumen['sCuotas'] = 1;
				   
				   if($rowResumen['tipoOperacion'] == 2 || $rowResumen['tipoOperacion'] == 3){
				   	   if($rowResumen['tipoOperacion'] == 2) 
				   		   $fIvaTotal -= $rowResumen['fImporteIVA'];	   	
				   	   if($rowResumen['tipoOperacion'] == 3) 
				   		   $fIvaTotal += $rowResumen['fImporteIVA'];	   					   	   
				   }
		   		   $buffer .= '
		   		   	<detalle>
		   		   		<idDetalle>'.$rowResumen['id'].'</idDetalle>
		   		   		<tipoOperacion>'.$rowResumen['tipoOperacion'].'</tipoOperacion>
		   		   		<sDescripcion><![CDATA['.stripslashes($rowResumen['Concepto']).']]></sDescripcion>
		   		   		<idComercio>'.$rowResumen['idComercio'].'</idComercio>
		   		   		<idPlan>'.$rowResumen['idPlan'].'</idPlan>
		   		   		<sSucursal>'.$rsEmpleado['sSucursal'].'</sSucursal>
		   		   		<dFechaOperacion>'.$rowResumen['Fecha'].'</dFechaOperacion>
		   		   		<sNumeroCuota>'.$rowResumen['iNumeroCuota'].'</sNumeroCuota>
		   		   		<sCantidadCuota>'.$rowResumen['sCuotas'].'</sCantidadCuota>
		   		   		<sNumeroCupon>'.$rowResumen['sNumeroCupon'].'</sNumeroCupon>
		   		   		<fImporte>'.$rowResumen['Importe'].'</fImporte>
		   		   	</detalle>
		   		   	';
		   	   }
		   	   if($fIvaTotal != 0){
		   	   		$sConcepto = "IVA Total";
		   	   	 	$buffer .= '
		   		   	<detalle>
		   		   		<idDetalle>0</idDetalle>
		   		   		<tipoOperacion>5</tipoOperacion>
		   		   		<sDescripcion><![CDATA['.$sConcepto.']]></sDescripcion>
		   		   		<idComercio>0</idComercio>
		   		   		<idPlan>0</idPlan>
		   		   		<sSucursal></sSucursal>
		   		   		<dFechaOperacion></dFechaOperacion>
		   		   		<sNumeroCuota>1</sNumeroCuota>
		   		   		<sCantidadCuota>1</sCantidadCuota>
		   		   		<sNumeroCupon></sNumeroCupon>
		   		   		<fImporte>'.number_format((double)$fIvaTotal,2,'.','').'</fImporte>
		   		   	</detalle>
		   		   	';		   	   	 	
		   	   }
		   }
		  
		    						
	       $buffer .= '</resumen>';
	       $name_file= $path."/DR_".$idGrupoAfinidad."_".$row['id']."_".$dPeriodoFormat.".xml";
	       $file=fopen($name_file,"w+");
	       if(!fwrite ($file,$buffer)){
	       	   $sConsulta='insert into log (idCuentaUsuario) Values ('.$row['id'].');';
	       	   $oMysql->startTransaction();
	       	   $oMysql->consultaAff($sConsulta);
	       	   $oMysql->commit();
	       }
	       fclose($file);
		}
	}
	
	function generarXmlResumen1($idGrupoAfinidad,$dPeriodo,$dPeriodoFormat){
		GLOBAL $oMysql;
		GLOBAL $mysql;
		
		$mysql->setDBName("Accesos");
		
		$sqlDatos=" SELECT CuentasUsuarios.id,CuentasUsuarios.idTipoEstadoCuenta
 					FROM CuentasUsuarios 
 					WHERE CuentasUsuarios.idGrupoAfinidad = {$idGrupoAfinidad}";		
		$rs = $oMysql->consultaSel($sqlDatos);
		
		foreach ($rs as $row){			
			$sCondicion=" WHERE CuentasUsuarios.id = {$row['id']}";
			$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondicion\");";		
			$rsCuenta = $oMysql->consultaSel($sqlDatos,true);
			
			$sCondicionDetalle=" WHERE DetallesCuentasUsuarios.idCuentaUsuario={$row['id']} AND DetallesCuentasUsuarios.dPeriodo='{$dPeriodo}'";
			$sqlDetalle="Call usp_getDetallesCuentasUsuarios(\"$sCondicionDetalle\");";
			$rsDetalleCuenta = $oMysql->consultaSel($sqlDetalle,true);
						
			$sCondicionCalendario = " WHERE CalendariosFacturaciones.idGrupoAfinidad={$idGrupoAfinidad} AND CalendariosFacturaciones.dPeriodo=DATE_ADD('{$dPeriodo}',interval 1 MONTH)";
			$sqlCalendario = "Call usp_getCalendarioFacturacion(\"$sCondicionCalendario\");";
			$rsCalendario = $oMysql->consultaSel($sqlCalendario,true);
			
			$sqlResumen = "call usp_getResumenPorCuenta(\"{$row['id']}\",\"{$dPeriodo}\");";
			$rsResumen = $oMysql->consultaSel($sqlResumen);
								
			$sTitular = $rsCuenta['sNombre']." ".$rsCuenta['sApellido'];				
			
			$sDomicilio = "Calle:".$rsCuenta['sCalle'].", Nro:".$rsCuenta['sNumeroCalle'];
			
			if(($rsCuenta['sBlock'] != "") && ($rsCuenta['sBlock'] != "0")) $sDomicilio .= ", Block: ".$rsCuenta['sBlock'];
			
			if(($rsCuenta['sPiso'] != "") && ($rsCuenta['sPiso'] != "0")) $sDomicilio .= ", Piso:".$rsCuenta['sPiso'];
			
			if(($rsCuenta['sDepartamento'] != "") && ($rsCuenta['sDepartamento'] != "0")) $sDomicilio .= ", Dpto:".$rsCuenta['sDepartamento'];			
			
			if($rsCuenta['sBarrio'] != "") $sDomicilio .= ", Barrio:".$rsCuenta['sBarrio'];	

			if($rsCuenta['sManzana'] != "") $sDomicilio .= ", Mza: ".$rsCuenta['sManzana'];
			if($rsCuenta['sLote'] != "") $sDomicilio .= ", Lote: ".$rsCuenta['sLote'];
			
			$sDomicilio .= "<br>".$rsCuenta['sProvincia'].", ".$rsCuenta['sLocalidad'].", ".$rsCuenta['sCodigoPostal'];			
			$sDomicilio=convertir_especiales_html($sDomicilio, 'ISO-8859-1', 'UTF-8');
			 
			$buffer = "<?xml version='1.0' encoding='utf-8'?>
	          <!--Este  es un ejemplo para crear un archivo xml con php-->
	           <resumen>
	       			<idGrupoAfinidad>{$idGrupoAfinidad}</idGrupoAfinidad>
					<idCuentaUsuario>{$row['id']}</idCuentaUsuario>
					<idModeloResumen>{$rsDetalleCuenta['idModeloResumen']}</idModeloResumen>
					<sNumeroCuentaUsuario>{$rsCuenta['sNumeroCuenta']}</sNumeroCuentaUsuario>
					<dPeriodo>{$dPeriodo}</dPeriodo>
					<dFechaCierre>{$rsDetalleCuenta['dFechaCierre']}</dFechaCierre>
					<dFechaVencimiento>{$rsDetalleCuenta['dFechaVencimiento']}</dFechaVencimiento>
					<dFechaCierreSiguiente>{$rsCalendario['dFechaCierre']}</dFechaCierreSiguiente>
					<dFechaVencimientoSiguiente>{$rsCalendario['dFechaVencimiento']}</dFechaVencimientoSiguiente>
					<dFechaInicio>{$rsCuenta['dFechaRegistro']}</dFechaInicio>
					<fSaldoAnterior>{$rsDetalleCuenta['fSaldoAnterior']}</fSaldoAnterior>
					<sTitular><![CDATA[".stripslashes($sTitular)."]]></sTitular>
					<sEstado>{$rsCuenta['sEstado']}</sEstado>
					<sDomicilio><![CDATA[".$sDomicilio."]]></sDomicilio>
					<fTotalResumen>{$rsDetalleCuenta['fImporteTotalPesos']}</fTotalResumen>
					<fLimiteCredito>{$rsDetalleCuenta['fLimiteCredito']}</fLimiteCredito>
					<fLimiteCompra>{$rsDetalleCuenta['fLimiteCompra']}</fLimiteCompra>
					<fLimiteAdelanto>{$rsDetalleCuenta['fLimiteAdelanto']}</fLimiteAdelanto>
					<fRemanenteCredito>{$rsDetalleCuenta['fRemanenteCredito']}</fRemanenteCredito>					
					<fRemanenteCompra>{$rsDetalleCuenta['fRemanenteCompra']}</fRemanenteCompra>					
		    		<fRemanenteAdelanto>{$rsDetalleCuenta['fRemanenteAdelanto']}</fRemanenteAdelanto>";
			 		   
		   if(count($rsResumen)>0){
		   	   $fIvaTotal = 0;
		   	   foreach($rsResumen as $rowResumen){
		   	   	   $sCondiciones = " WHERE Empleados.id={$rowResumen['idEmpleado']}";
				   $sqlDatos = "Call usp_getEmpleados(\"$sCondiciones\");";
				   $rsEmpleado = $mysql->selectRow($sqlDatos,true);
				   if($rowResumen['sCuotas'] == 0) $rowResumen['sCuotas'] = 1;
				   
				   if($rowResumen['tipoOperacion'] == 2 || $rowResumen['tipoOperacion'] == 3){
				   	   if($rowResumen['tipoOperacion'] == 2) 
				   		   $fIvaTotal -= $rowResumen['fImporteIVA'];	   	
				   	   if($rowResumen['tipoOperacion'] == 3) 
				   		   $fIvaTotal += $rowResumen['fImporteIVA'];	   					   	   
				   }
		   		   $buffer .= "
		   		   	<detalle>
		   		   		<idDetalle>{$rowResumen['id']}</idDetalle>
		   		   		<tipoOperacion>{$rowResumen['tipoOperacion']}</tipoOperacion>
		   		   		<sDescripcion><![CDATA[".stripslashes($rowResumen['Concepto'])."]]></sDescripcion>
		   		   		<idComercio>{$rowResumen['idComercio']}</idComercio>
		   		   		<idPlan>{$rowResumen['idPlan']}</idPlan>
		   		   		<sSucursal>{$rsEmpleado['sSucursal']}</sSucursal>
		   		   		<dFechaOperacion>{$rowResumen['Fecha']}</dFechaOperacion>
		   		   		<sNumeroCuota>{$rowResumen['iNumeroCuota']}</sNumeroCuota>
		   		   		<sCantidadCuota>{$rowResumen['sCuotas']}</sCantidadCuota>
		   		   		<sNumeroCupon>{$rowResumen['sNumeroCupon']}</sNumeroCupon>
		   		   		<fImporte>{$rowResumen['Importe']}</fImporte>
		   		   	</detalle>
		   		   	";
		   	   }
		   	   if($fIvaTotal != 0){
		   	   		$sConcepto = "IVA Total";
		   	   	 	$buffer .= "
		   		   	<detalle>
		   		   		<idDetalle>0</idDetalle>
		   		   		<tipoOperacion>5</tipoOperacion>
		   		   		<sDescripcion><![CDATA[".$sConcepto."]]></sDescripcion>
		   		   		<idComercio>0</idComercio>
		   		   		<idPlan>0</idPlan>
		   		   		<sSucursal></sSucursal>
		   		   		<dFechaOperacion></dFechaOperacion>
		   		   		<sNumeroCuota>1</sNumeroCuota>
		   		   		<sCantidadCuota>1</sCantidadCuota>
		   		   		<sNumeroCupon></sNumeroCupon>
		   		   		<fImporte>".number_format((double)$fIvaTotal,2,'.','')."</fImporte>
		   		   	</detalle>
		   		   	";		   	   	 	
		   	   }
		   }
		  
		    						
	       $buffer .= "</resumen>";
	       $name_file="../includes/Files/Datos/DR_".$idGrupoAfinidad."_".$row['id']."_".$dPeriodoFormat.".xml";
	       $file=fopen($name_file,"w+");
	       fwrite ($file,$buffer);
	       fclose($file);
	       
	       //$sCodigo = generarCodigoBarra($rsCuenta['sNumeroCuenta'],$rsDetalleCuenta['fImporteTotalPesos'],$rsDetalleCuenta['dFechaVencimiento']);
	       //<img src="../includes/barcodegen/html/image.php?code=i25&o=2&t=40&r=1&text={CODIGO_BARRA}&f=2&a1=&a2=&rot=0&dpi=72&f1=Arial.ttf&f2=10" alt="ERROR" align="absmiddle" style="width:280px;"/>
		}
	}
	
	function diferenciaDias($dFecha1,$dFecha2){
		//defino fecha 1 
		$aFecha1 = explode("/",$dFecha1);
		$ano1 = (int)$aFecha1[2]; 
		$mes1 = (int)$aFecha1[1]; 
		$dia1 = (int)$aFecha1[0]; 
		
		//defino fecha 2
		$aFecha2 = explode("/",$dFecha2); 
		$ano2 = (int)$aFecha2[2]; 
		$mes2 = (int)$aFecha2[1];
		$dia2 = (int)$aFecha2[0];
		
		//calculo timestam de las dos fechas 
		$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1); 
		$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2); 
		
		//resto a una fecha la otra 
		$segundos_diferencia = $timestamp1 - $timestamp2; 
		//echo $segundos_diferencia; 
		
		//convierto segundos en días 
		$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 
		
		//obtengo el valor absoulto de los días (quito el posible signo negativo) 
		$dias_diferencia = abs($dias_diferencia); 
		
		//quito los decimales a los días de diferencia 
		$dias_diferencia = floor($dias_diferencia); 
		
		return $dias_diferencia;
	}
	
	function getDigitoVerificador($sCadena){
		$sPaso1 = "13579";
		while(strlen($sPaso1)<=strlen($sCadena)){
			$sPaso1 .= "3579";
		}
		$sPaso1 = substr($sPaso1,0,strlen($sCadena));
		$suma = 0;
		for($i=0; $i<=41; $i++){
			$producto=(int)$sCadena[$i]*(int)$sPaso1[$i];
			$suma = $suma+$producto;
		}
		$fResultado = intval($suma/2);
		$resto = $fResultado % 10;
		
		return $resto;
	}
	
	function generarCodigoBarra($sNumeroCuenta,$fImporte,$dFechaVencimiento){
		$sEmpresa = "7969"; //Identificador de la Empresa - longitud=4
		
		$sImporte = str_replace(".","",(string)$fImporte);
		$sImportePrimVenc = str_pad($sImporte,8,"0",STR_PAD_LEFT);//Importe del Primer Vencimiento
		$dFecha = explode("/",$dFechaVencimiento);
		
		$dFechaInicio = "00/01/".$dFecha[2];
		//$dFechaVencimiento = "01/01/".$dFecha[2];
		$dias = diferenciaDias($dFechaVencimiento,$dFechaInicio);
		
		$dPrimerVencimiento = substr($dFecha[2],2,2).str_pad((string)$dias,3,"0",STR_PAD_LEFT); //Fecha del Primer Vencimiento
		
		$sCliente = str_pad($sNumeroCuenta,14,"0",STR_PAD_LEFT); //Ident. del Cliente
		
		$sMoneda = "0";
		
		$sRecargoSegVenc = "000000";
		
		$dSegundoVencimiento = "07";
		
		$sCadenaSinVerif = $sEmpresa.$sImportePrimVenc.$dPrimerVencimiento.$sCliente.$sMoneda.$sRecargoSegVenc.$dSegundoVencimiento;
		
		//$sCadenaSinVerif1 = $sEmpresa."-".$sImportePrimVenc."-".$dPrimerVencimiento."-".$sCliente."-".$sMoneda."-".$sRecargoSegVenc."-".$dSegundoVencimiento;
		
		$digito1 = getDigitoVerificador($sCadenaSinVerif);
		$digito2 = getDigitoVerificador($sCadenaSinVerif.$digito1);
		
		$sCadenaConVerif = $sCadenaSinVerif.$digito1.$digito2;
 	    return $sCadenaConVerif;
	}
	
	function suma_fechas($fecha,$ndias)            
	{            
	    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))	            
	        list($dia,$mes,$anio)=split("/", $fecha);
	            
	    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))	            
	        list($dia,$mes,$anio)=split("-",$fecha);
	              
	    $nueva = mktime(0,0,0, $mes,$dia,$anio) + $ndias * 24 * 60 * 60;
	    $nuevafecha=date("d/m/Y",$nueva);
	            
	    return ($nuevafecha);             
	}

	function generarCodigoBarraBSE($sNumeroCuenta,$fImporte,$dFechaVencimiento)
	{
		$sEmpresa = "7969"; //Identificador de la Empresa - longitud=4
		
		$sCliente = substr($sNumeroCuenta,1); //Ident. del Cliente
		
		$aFecha1 = explode("/",$dFechaVencimiento);
		$dPrimerVencimiento = substr($aFecha1[2],2,2).$aFecha1[1].$aFecha1[0];
		
		$sImporte = str_replace(".","",(string)$fImporte);
		$sImportePrimerVencimiento = str_pad($sImporte,6,"0",STR_PAD_LEFT);//Importe del Primer Vencimiento
		
		$dSegundoVencimiento = suma_fechas($dFechaVencimiento,7);
		$aFecha2 = explode("/",$dSegundoVencimiento);
		$dSegundoVencimiento = substr($aFecha2[2],2,2).$aFecha2[1].$aFecha2[0];
		
		$sImporteSegVencimiento = "000000";
		
		$sCadenaSinVerificar = $sEmpresa.$sCliente.$dPrimerVencimiento.$sImportePrimerVencimiento.$dSegundoVencimiento.$sImporteSegVencimiento;
		
		$digitoVerificador = luhn($sCadenaSinVerificar);
		
		$sCadenaConVerif = $sCadenaSinVerificar.$digitoVerificador;
 	    return $sCadenaConVerif;
	}
	
	function ifSessionLex($aDatos){
		session_start();
		//session_decode(mysql_session_read(base64_decode($aDatos['oIa_'])));
		if(!isLogin()){
			    session_destroy();	
				go_url("/Restringido.html");
		}/*else{
			if($_SESSION['id_user']!=$aDatos['id']){
				session_destroy();	
				go_url("/Restringido.html");
			}
		}*/
		/*
		$array = array('NombreTipoConexion' => 'MYSQL',
		               'sHost' => 'localhost',
		               'sUsuario' => 'dbgrupo',
		               'sPassword' => '0tr3b0r',
		               'sNombreDB' => 'Accesos',
		               'sPort' => 3306);	

		#aqui va la instruccion SQL		
		$oMysql_Accesos=new mysql2();
		$oMysql_Accesos->setServer($array['sHost'],$array['sUsuario'],$array['sPassword'],$array['sPort']);
		$oMysql_Accesos->setDBName($array['sNombreDB']);
		
		if( !$_SESSION['id_user'] ){
		
			$sConsulta=" select id_user,idOficina,idSucursal,idTipoEmpleado,idRegion,sLogin,sNumeroRegion  
						 from Sessiones where id_user = {$aDatos['id']}; ";
			
			$aArray=$oMysql_Accesos->consultaSel($sConsulta,true);
			$iNum=sizeof($aArray);
			
			if($aArray){
				
				session_decode(mysql_session_read(base64_decode($aDatos['oIa_'])));
				$sGuardar=session_id();
				
				$sConsulta="UPDATE Sessiones SET sOtrasSesionesSistemas = CONCAT (sOtrasSesionesSistemas,'@',\"$sGuardar\") WHERE id_user = {$aDatos['id']} ;";
				$oMysql_Accesos->startTransaction();
				$oMysql_Accesos->consultaAff($sConsulta);
				$oMysql_Accesos->commit();
				$oMysql_Accesos->desconectar();
			    //$oMysql_Accesos->__destruct();
			}else{		
				go_url("/Restringido.html");
			}
		}else{ 
		      $sConsulta=" select id_user,idOficina,idSucursal,idTipoEmpleado,idRegion,sLogin,sNumeroRegion  
						 from Sessiones where id_user = {$_SESSION['id_user']}; ";
		      
		      $aArray=$oMysql_Accesos->consultaSel($sConsulta,true);
			  $iNum=sizeof($aArray);
			  $oMysql_Accesos->desconectar();
			 // $oMysql_Accesos->__destruct();
			  
			 if(!$aArray){
			 	session_destroy();	
				go_url("/Restringido.html");
			 } 
		}
		/*GLOBAL $mysql;
		session_start();
		
		$mysql->setServer( '192.168.1.104', "grivalex","gr1valex", '3306' );
		$mysql->setDBName("Accesos");
		
		if( !$_SESSION['id_user'] ){
		
			$sConsulta=" select id_user,idOficina,idSucursal,idTipoEmpleado,idRegion,sLogin,sNumeroRegion  
						 from Sessiones where id_user = {$aDatos['id']}; ";
			
			$aArray=$mysql->selectRow($sConsulta);
			$iNum=count($aArray);
			
			if($iNum > 0){
				
				session_decode(mysql_session_read(base64_decode($aDatos['oIa_'])));
				$sGuardar=session_id();
				$sConsulta="UPDATE Sessiones SET sOtrasSesionesSistemas = CONCAT (sOtrasSesionesSistemas,'@',\"$sGuardar\") WHERE id_user = {$aDatos['id']} ;";
				echo $sConulta;
				$mysql->query($sConsulta);
				
			}else{		
				go_url("/Restringido.html");
			}
		}*/
	}
	
	function round_up ( $value, $precision ) { 

	    $pow = pow ( 10, $precision ); 
	
	    return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 
	
	}
	
	function generarXmlResumenPorCuenta($idCuentaUsuario,$dPeriodo,$dPeriodoFormat){
		GLOBAL $oMysql;
       
		$sCondicion=" WHERE CuentasUsuarios.id = {$idCuentaUsuario}";
		$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondicion\");";		
		$rsCuenta = $oMysql->consultaSel($sqlDatos,true);
		//var_export($sqlDatos);
		
		$sCondicionDetalle=" WHERE DetallesCuentasUsuarios.idCuentaUsuario={$idCuentaUsuario} AND DetallesCuentasUsuarios.dPeriodo='{$dPeriodo}'";
		$sqlDetalle="Call usp_getDetallesCuentasUsuarios(\"$sCondicionDetalle\");";
		$rsDetalleCuenta = $oMysql->consultaSel($sqlDetalle,true);
		//var_export($sqlDetalle);			
		
		$sCondicionCalendario = " WHERE CalendariosFacturaciones.idGrupoAfinidad={$rsCuenta['idGrupoAfinidad']} AND CalendariosFacturaciones.dPeriodo=DATE_ADD('{$dPeriodo}',interval 1 MONTH)";
		$sqlCalendario = "Call usp_getCalendarioFacturacion(\"$sCondicionCalendario\");";
		$rsCalendario = $oMysql->consultaSel($sqlCalendario,true);
		//var_export($sqlCalendario);
		
		$sqlResumen = "call usp_getResumenPorCuenta(\"{$idCuentaUsuario}\",\"{$dPeriodo}\");";
		$rsResumen = $oMysql->consultaSel($sqlResumen);
		//var_export($sqlResumen);
		
		$sTitular = "";
		if($rsCuenta['iTipoPersona'] == 2){					
			$sTitular .= $rsCuenta['sRazonSocial'];				
		}else{
			$sTitular .= $rsCuenta['sNombre']." ".$rsCuenta['sApellido'];
		}
				
		$sTitular = convertir_especiales_html($sTitular);
		
		$sCondicionEnvio = " WHERE SolicitudesUsuarios.id ={$rsCuenta['idSolicitud']}";
        $sqlEnvio="Call usp_getDatosEnvioResumen(\"$sCondicionEnvio\");";
		$rsEnvio = $oMysql->consultaSel($sqlEnvio,true);
		
		$sDomicilio = "Calle:".$rsEnvio['sCalleResumen'].", Nro:".$rsEnvio['sNumeroCalleResumen'];
		
		if(($rsEnvio['sBlockResumen'] != "") && ($rsEnvio['sBlockResumen'] != "0")) $sDomicilio .=', Block: '.$rsEnvio['sBlockResumen'];
		
		if(($rsEnvio['sPisoResumen'] != "") && ($rsEnvio['sPisoResumen'] != "0")) $sDomicilio .= ', Piso:'.$rsEnvio['sPisoResumen'];
		
		if(($rsEnvio['sDepartamentoResumen'] != "") && ($rsEnvio['sDepartamentoResumen'] != "0")) $sDomicilio .= ', Dpto:'.$rsEnvio['sDepartamentoResumen'];			
		
		if($rsEnvio['sBarrioResumen'] != "") $sDomicilio .= ', Barrio:'.$rsEnvio['sBarrioResumen'];	

		if($rsEnvio['sManzanaResumen'] != "") $sDomicilio .= ', Mza: '.$rsEnvio['sManzanaResumen'];
		if($rsEnvio['sLoteResumen'] != "") $sDomicilio .= ', Lote: '.$rsEnvio['sLoteResumen'];
		
		$sDomicilio .= '<br>'.$rsEnvio['sProvinciaResumen'].', '.$rsEnvio['sLocalidadResumen'].', '.$rsEnvio['sCodigoPostalResumen'];
		$sDomicilio = convertir_especiales_html($sDomicilio);
		
		 $buffer = "<?xml version='1.0' encoding='utf-8'?>
          <!--Este  es un ejemplo para crear un archivo xml con php-->
           <resumen>
       			<idGrupoAfinidad>{$rsCuenta['idGrupoAfinidad']}</idGrupoAfinidad>
				<idCuentaUsuario>{$idCuentaUsuario}</idCuentaUsuario>
				<idModeloResumen>{$rsDetalleCuenta['idModeloResumen']}</idModeloResumen>
				<sNumeroCuentaUsuario>{$rsCuenta['sNumeroCuenta']}</sNumeroCuentaUsuario>
				<dPeriodo>{$dPeriodo}</dPeriodo>
				<dFechaCierre>{$rsDetalleCuenta['dFechaCierre']}</dFechaCierre>
				<dFechaVencimiento>{$rsDetalleCuenta['dFechaVencimiento']}</dFechaVencimiento>
				<dFechaCierreSiguiente>{$rsCalendario['dFechaCierre']}</dFechaCierreSiguiente>
				<dFechaVencimientoSiguiente>{$rsCalendario['dFechaVencimiento']}</dFechaVencimientoSiguiente>
				<dFechaInicio>{$rsCuenta['dFechaRegistro']}</dFechaInicio>
				<fSaldoAnterior>{$rsDetalleCuenta['fSaldoAnterior']}</fSaldoAnterior>
				<sTitular><![CDATA[".stripslashes($sTitular)."]]></sTitular>
				<sEstado>{$rsCuenta['sEstado']}</sEstado>
				<sDomicilio><![CDATA[".$sDomicilio."]]></sDomicilio>
				<fTotalResumen>{$rsDetalleCuenta['fImporteTotalPesos']}</fTotalResumen>
				<fLimiteCredito>{$rsDetalleCuenta['fLimiteCredito']}</fLimiteCredito>
				<fLimiteCompra>{$rsDetalleCuenta['fLimiteCompra']}</fLimiteCompra>
				<fLimiteAdelanto>{$rsDetalleCuenta['fLimiteAdelanto']}</fLimiteAdelanto>
				<fRemanenteCredito>{$rsDetalleCuenta['fRemanenteCredito']}</fRemanenteCredito>					
				<fRemanenteCompra>{$rsDetalleCuenta['fRemanenteCompra']}</fRemanenteCompra>					
	    		<fRemanenteAdelanto>{$rsDetalleCuenta['fRemanenteAdelanto']}</fRemanenteAdelanto>";
		 		   
	   if(count($rsResumen)>0){
	   	   $fIvaTotal = 0;
	   	   foreach($rsResumen as $rowResumen){
	   	   	   $sCondiciones = " WHERE Empleados.id={$rowResumen['idEmpleado']}";
			   $sqlDatos = "Call usp_getEmpleados(\"$sCondiciones\");";
			   $rsEmpleado = $oMysql->consultaSel($sqlDatos,true);
			   if($rowResumen['sCuotas'] == 0) $rowResumen['sCuotas'] = 1;
			   
			   if($rowResumen['tipoOperacion'] == 2 || $rowResumen['tipoOperacion'] == 3){
			   	   if($rowResumen['tipoOperacion'] == 2) 
			   		   $fIvaTotal -= $rowResumen['fImporteIVA'];	   	
			   	   if($rowResumen['tipoOperacion'] == 3) 
			   		   $fIvaTotal += $rowResumen['fImporteIVA'];	   					   	   
			   }
	   		   $buffer .= "
	   		   	<detalle>
	   		   		<idDetalle>{$rowResumen['id']}</idDetalle>
	   		   		<tipoOperacion>{$rowResumen['tipoOperacion']}</tipoOperacion>
	   		   		<sDescripcion><![CDATA[".stripslashes($rowResumen['Concepto'])."]]></sDescripcion>
	   		   		<idComercio>{$rowResumen['idComercio']}</idComercio>
	   		   		<idPlan>{$rowResumen['idPlan']}</idPlan>
	   		   		<sSucursal>{$rsEmpleado['sSucursal']}</sSucursal>
	   		   		<dFechaOperacion>{$rowResumen['Fecha']}</dFechaOperacion>
	   		   		<sNumeroCuota>{$rowResumen['iNumeroCuota']}</sNumeroCuota>
	   		   		<sCantidadCuota>{$rowResumen['sCuotas']}</sCantidadCuota>
	   		   		<sNumeroCupon>{$rowResumen['sNumeroCupon']}</sNumeroCupon>
	   		   		<fImporte>{$rowResumen['Importe']}</fImporte>
	   		   	</detalle>
	   		   	";
	   	   }
	   	   $fIvaTotal = 0;
	   	   if($fIvaTotal != 0){
	   	   		$sConcepto = "IVA Total";
	   	   	 	$buffer .= "
	   		   	<detalle>
	   		   		<idDetalle>0</idDetalle>
	   		   		<tipoOperacion>5</tipoOperacion>
	   		   		<sDescripcion><![CDATA[".$sConcepto."]]></sDescripcion>
	   		   		<idComercio>0</idComercio>
	   		   		<idPlan>0</idPlan>
	   		   		<sSucursal></sSucursal>
	   		   		<dFechaOperacion></dFechaOperacion>
	   		   		<sNumeroCuota>1</sNumeroCuota>
	   		   		<sCantidadCuota>1</sCantidadCuota>
	   		   		<sNumeroCupon></sNumeroCupon>
	   		   		<fImporte>".number_format((double)$fIvaTotal,2,'.','')."</fImporte>
	   		   	</detalle>
	   		   	";		   	   	 	
	   	   }
	   }	  
	    						
       $buffer .= "</resumen>";
       $path = "../includes/Files/Datos/".$dPeriodoFormat;	
	   if (!is_dir($path)) {
			if(!mkdir($path,0777))
			{
		    	die('Fallo al crear Directorio...');
			}	
		}
       //$name_file="../includes/Files/Datos/DR_".$rsCuenta['idGrupoAfinidad']."_".$idCuentaUsuario."_".$dPeriodoFormat.".xml";
       $name_file= $path."/DR_".$rsCuenta['idGrupoAfinidad']."_".$idCuentaUsuario."_".$dPeriodoFormat.".xml";
       $file=fopen($name_file,"w+");
       fwrite ($file,$buffer);
       fclose($file);
	}
	
	function setAjusteCuentaUsuario($idCuentaUsuario,$fImporteAjuste,$iCuotas,$idTipoAjuste,$idTasaIva){
		global $oMysql;
		//----------- Encabezado de Ajuste ----------------------------	
		 $fImporteTotal = $fImporteAjuste; //10% o 25% del Premio
		 $sCodigo = $oMysql->consultaSel("select fn_getCodigoAjusteUsuario();",true);
		 
		 /*$sCondicionesAjuste = " WHERE TiposAjustes.id = {$idTipoAjuste}"; 
		 $sqlAjuste="Call usp_getTiposAjustes(\"$sCondiciones\");";		
		 $rsAjuste = $oMysql->consultaSel($sqlAjuste,true);*/

		 $sCondicionesAjuste = " WHERE TiposAjustes.id = {$idTipoAjuste}"; 
		 $sqlAjuste="Call usp_getTiposAjustes(\"$sCondicionesAjuste\");";		
		 $rsAjuste = $oMysql->consultaSel($sqlAjuste,true);
		 
		 $fIntereses = ($fImporteTotal * ($rsAjuste['fTasaInteresAjuste']/100));			 
		 //$fImporteTotalIntereses = $fImporteTotal + $fIntereses;
		 $fImporteIntereses = $fImporteTotal + $fIntereses;
		 
		 $fTasaIVA = 0;
		 if($rsAjuste['bDiscriminaIVA'] == 1){
	 	 	 $sConsulta = "SELECT fTasa FROM TasasIVA WHERE id = {$idTasaIva}"; 				
			 $fTasaIVA = $oMysql->consultaSel($sConsulta, true);		
		 }
    
		 $fImporteTotalIVA = ($fImporteIntereses * ($fTasaIVA/100));
		 $fImporteTotalFinal = ($fImporteTotal + $fImporteTotalIVA + $fIntereses);
		 //$iCuotas = $aDatosPlanesComercio[1];
		 $set ="
  	   		idCuentaUsuario,
  	   		idTipoAjuste,
  	   		idEmpleado,
  	   		idTipoMoneda,
  	   		dFecha,
  	   		sCodigo,
  	   		iCuotas,
  	   		fImporteTotal,
  	   		fImporteTotalInteres,
  	   		fImporteTotalIVA,
  	   		sEstado,
  	   		iFacturado,
  	   		idTasaIVA,
  	   		fTotalFinal
  	   		";
  	     	   		
	   $values = "
	   		'{$idCuentaUsuario}',
	   		'{$idTipoAjuste}',		   	
	   		'{$_SESSION['id_user']}',
	   		'1',
	   		NOW(),
	   		'{$sCodigo}',
	   		'{$iCuotas}',
	   		'{$fImporteTotal}',
	   		'{$fIntereses}',
	   		'{$fImporteTotalIVA}',
	   		'A',
	   		'0',
	   		'{$idTasaIva}',
	   		'{$fImporteTotalFinal}'
	   		";
	   
	   $fimporteConInteres = $fImporteTotalIntereses + $fImporteTotal;		 		   	   
	   $ToAuditory = "Insercion Ajuste de Usuario ::: Empleado ={$_SESSION['id_user']}";		   
	   $idAjusteUsuario = $oMysql->consultaSel("CALL usp_InsertTable(\"AjustesUsuarios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"59\",\"$ToAuditory\");",true);     		   
	   	
	   #Afectar Debito Credito en cuenta de usuario segun corresponda
	   $result = true;
	   
	   if(!$idAjusteUsuario){
	   	   $result = false;	
	   }else{
	   		//var_export($rsAjuste['sClaseAjuste']);
		   //$oMysql->consultaSel("CALL usp_updateDebitoCredito(\"{$idCuentaUsuario}\",\"{$rsAjuste['sClaseAjuste']}\",\"{$fimporteConInteres}\",\"{$fImporteTotalFinal}\");", true);
		   $oMysql->consultaSel("CALL usp_updateDebitoCredito(\"{$idCuentaUsuario}\",\"{$rsAjuste['sClaseAjuste']}\",\"{$fimporteConInteres}\",\"{$fImporteTotalIVA}\");", true);
		   	
	 	   //----------- Insertar el detalle (cuotas) ----------------------------	    		
		   $set = "(idEmpleado,
   				idAjusteUsuario,
   				iNumeroCuota,
   				fImporteCuota,
   				fImporteInteres,
   				fImporteIVA,
   				dFechaFacturacionUsuario)";
		   		        
		   $fImporteCuota = $fImporteTotal / $iCuotas;
		   $fImporteInteres = $fImporteTotalIntereses / $iCuotas;
		   $fImporteIVA = $fImporteTotalIVA / $iCuotas;
		   
		   #obtengo la fecha base (periodo) apartir de la cual generare las fechas de facturacion
	  	   $fecha_base = $oMysql->consultaSel("SELECT fcn_getUltimoPeriodoDetalleCuentaUsuario(\"{$idCuentaUsuario}\");",true);		  
	  	   //$oRespuesta->alert($fecha_base);
	  	   $array_fecha_base = explode("-",$fecha_base);	  	
	  	   $ultima_fecha_cierre = "";
	  	   
	  	   for($i=1; $i<= $iCuotas; $i++)
		   {
		   		 #obtengo mees y anio para buscar fecha de cierre asociado a cuenta de usuario
				$mes = $array_fecha_base[1] + ($i - 1);
				$anyo = $array_fecha_base[0];
				$mktime = mktime(0,0,0,intval($mes),1,intval($anyo));
				$anyo_real = intval(date("Y",$mktime));
				$mes_real = intval(date("m",$mktime));
				#determino periodo de cuota				
				$fecha_cierre_usuario = $oMysql->consultaSel("SELECT fcn_getFechaCierreUsuario(\"$mes_real\",\"$anyo_real\",\"{$idCuentaUsuario}\");",true);
				
				//$oRespuesta->alert("fecha cierre: " . $fecha_cierre_usuario);
				if($fecha_cierre_usuario == '0000-00-00' || $fecha_cierre_usuario == false || $fecha_cierre_usuario == '1899-12-29')
				{
					// No existe fechaCierre
					$array_uFechaCierre = explode("-",$ultima_fecha_cierre);				
					$ultimo_dia_mes_real = intval(strftime("%d", mktime(0, 0, 0, $mes_real+1, 0, $anyo_real)));					
					$array_uFechaCierre[2] = intval($array_uFechaCierre[2]);
					
					if($ultimo_dia_mes_real < $array_uFechaCierre[2])
					{
						$dia_real = $ultimo_dia_mes_real;
					}
					else
					{
						$dia_real = $array_uFechaCierre[2];
					}
					
					$fecha_cierre_usuario = $anyo_real . "-" . $mes_real . "-" . $dia_real;
					
					if($i == 1)
					{
						$fecha_cierre_cuota_1 = $fecha_cierre_usuario;
					}
					else
					{
						if($i == 2)
						{
							$fecha_cierre_usuario = $fecha_cierre_cuota_1;
						}
						else
						{
							
							if($i > 2)
							{
								/*$aDateCloseFechaHora = explode(" ",$fecha_cierre_usuario);
								$aDateClose = explode("-",$aDateCloseFechaHora[0]);
								
								$xm = intval($aDateClose[1]);
								$xm = $xm - 1;
								
								$fecha_cierre_usuario = $oMysql->consultaSel("SELECT fcn_getFechaCierreUsuario(\"$xm\",\"$anyo_real\",\"{$form['idCuentaUsuario']}\");",true);	*/							
								
								//$xm = $xm - 1;
								$aDateCloseFechaHora = explode(" ",$fecha_cierre_usuario);
								$aDateClose = explode("-",$aDateCloseFechaHora[0]);
	
								$xd = intval($aDateClose[2]);
								$xm = intval($aDateClose[1]);
								$xm = $xm - 1;
								$xy = intval($aDateClose[0]);
	
								$xmktime = mktime(0,0,0,$xm,$xd,$xy);
	
								$xdate = date("Y-m-d",$xmktime);
							
								$fecha_cierre_usuario = $xdate;
							}
						}
					}
					
					$valuesCuotas .= "
		   					(
		   						'{$_SESSION['id_user']}',
								'{$idAjusteUsuario}',
								'{$i}',
								'{$fImporteCuota}',
								'{$fImporteInteres}',
   			   					'{$fImporteIVA}',
   			   					'{$fecha_cierre_usuario}'
		   					)";
		   		
		   			if($i < $iCuotas)
		   			{
						$valuesCuotas .= ",";	   			
		   			}				   		 
				}
				else // Existe fechaCierre
				{	
					$ultima_fecha_cierre = $fecha_cierre_usuario;
					
					if($i == 1)
					{
						$fecha_cierre_cuota_1 = $fecha_cierre_usuario;
					}
					else
					{
						if($i == 2)
						{
							$fecha_cierre_usuario = $fecha_cierre_cuota_1;
						}
						else
						{							
							if($i > 2)
							{
								$aDateCloseFechaHora = explode(" ",$fecha_cierre_usuario);
								$aDateClose = explode("-",$aDateCloseFechaHora[0]);
								
								$xm = intval($aDateClose[1]);
								$xm = $xm - 1;
								
								if($xm==0){ $xm=12; $anyo_real=$anyo_real-1;}
								$sConsulta="SELECT fcn_getFechaCierreUsuario(\"$xm\",\"$anyo_real\",\"{$idCuentaUsuario}\");";
								$fecha_cierre_usuario = $oMysql->consultaSel($sConsulta,true);

								/*if($_SESSION['id_user']==296){
							
									echo $aDateCloseFechaHora[0].' -> '.$xm.' - '.$fecha_cierre_usuario.'  ----  '.$sConsulta;die();
								}*/
									
								
								/*$aDateCloseFechaHora = explode(" ",$fecha_cierre_usuario);
								$aDateClose = explode("-",$aDateCloseFechaHora[0]);
	
								$xd = intval($aDateClose[2]);
								$xm = intval($aDateClose[1]);
								$xm = $xm - 1;
								$xy = intval($aDateClose[0]);
	
								$xmktime = mktime(0,0,0,$xm,$xd,$xy);
	
								$xdate = date("Y-m-d",$xmktime);
							
								$fecha_cierre_usuario = $xdate;*/
							}
						}
					}
					
		   			$valuesCuotas .= "
		   					(
		   						'{$_SESSION['id_user']}',
								'{$idAjusteUsuario}',
								'{$i}',
								'{$fImporteCuota}',
								'{$fImporteInteres}',
   			   					'{$fImporteIVA}',
   			   					'{$fecha_cierre_usuario}'
		   					)";
		   		
		   			if($i < $iCuotas)
		   			{
						$valuesCuotas .= ",";	   			
		   			}				   		 
		   		}
		   }
		   
		   $ToAuditory = "Insercion Detalle de Ajuste de Usuario ::: Empleado ={$_SESSION['id_user']}"; 
	       $idDetalleAjuste = $oMysql->consultaSel("CALL usp_abm_General(\"DetallesAjustesUsuarios\",\"$set\",\"$valuesCuotas\",\"1\",\"{$_SESSION['id_user']}\",\"61\",\"$ToAuditory\");",true); 	     
	   }
	   return $result;		
	}
	
	
	function _debugSITE($debug = ''){
		
		$id_user = intval($_SESSION['id_user']) ;
		
		if($id_user == 296){
			var_export($debug);die();
		}
	}
	
	function RecalcularLimites_CA($idCuentaUsuario)
	{	
		GLOBAL $oMysql;	
			
		$sCondiciones = "WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$idCuentaUsuario}	ORDER BY DetallesCuentasUsuarios.id DESC LIMIT 0,1 ;";		
		$datosDetalle = $oMysql->consultaSel("CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");", true);
		
		$iRespuesta  = 0;
		
		//if(!$datosDetalle)
		//{
			$iRespuesta = -1;
		//}
		//else 
		//{
			$fSaldoAnterior = $datosDetalle['fSaldoAnterior'];
			$fAcumuladoCobranza = $datosDetalle['fAcumuladoCobranza'];
			$fAcumuladoConsumoCuota = $datosDetalle['fAcumuladoConsumoCuota'];
			$fAcumuladoConsumoUnPago = $datosDetalle['fAcumuladoConsumoUnPago'];
			$fAcumuladoAdelanto = $datosDetalle['fAcumuladoAdelanto'];
			$fAcumuladoPrestamo = $datosDetalle['fAcumuladoAdelanto'];
			
			$fRemanenteGlobal = $datosDetalle['fRemanenteGlobal'];		
			$fRemanenteCompra = $datosDetalle['fRemanenteCompra'];
			$fRemanenteCredito = $datosDetalle['fRemanenteCredito'];
			$fRemanenteAdelanto = $datosDetalle['fRemanenteAdelanto'];
			$fRemanentePrestamo = $datosDetalle['fRemanentePrestamo'];
			
			$fLimiteGlobal = $datosDetalle['fLimiteGlobal'];
			$fLimiteCompra = $datosDetalle['fLimiteCompra'];
			$fLimiteCredito = $datosDetalle['fLimiteCredito'];
			$fLimiteAdelanto = $datosDetalle['fLimiteAdelanto'];
			$fLimitePrestamo = $datosDetalle['fLimitePrestamo'];
			
			/*$oRespuesta->alert("Remanente global: " . $fRemanenteGlobal.
			" Remanente credito: " . $fRemanenteCredito.
			" Remanente adelanto: " . $fRemanenteAdelanto. 
			" Remanente prestamo: " . $fRemanentePrestamo. 
			*/
			
			$fRemanenteGlobal = ($fLimiteGlobal - $fSaldoAnterior - $fAcumuladoConsumoCuota - $fAcumuladoConsumoUnPago - $fAcumuladoAdelanto) + $fAcumuladoCobranza;
			$fRemanenteCompra = $fLimiteCompra - $fAcumuladoConsumoUnPago;
			$fRemanenteCredito = $fLimiteCredito - $fAcumuladoConsumoCuota;
			$fRemanenteAdelanto = $fLimiteAdelanto - $fAcumuladoAdelanto;
			$fRemanentePrestamo = $fLimitePrestamo - $fAcumuladoPrestamo;
			
			/*$oRespuesta->alert("Remanente global: " . $fRemanenteGlobal.
			" Remanente credito: " . $fRemanenteCredito.
			" Remanente adelanto: " . $fRemanenteAdelanto. 
			" Remanente prestamo: " . $fRemanentePrestamo. 
			*/
			
			if($fRemanenteGlobal <= $fRemanenteCompra){$fRemanenteCompra = $fRemanenteGlobal;}		
			if($fRemanenteGlobal <= $fRemanenteCredito){$fRemanenteCredito = $fRemanenteGlobal;}
			if($fRemanenteGlobal <= $fRemanenteAdelanto){$fRemanenteAdelanto = $fRemanenteGlobal;}
			if($fRemanenteGlobal <= $fRemanentePrestamo){$fRemanentePrestamo = $fRemanenteGlobal;}
			
			/*$oRespuesta->alert("Remanente global: " . $fRemanenteGlobal.
			" Remanente credito: " . $fRemanenteCredito.
			" Remanente adelanto: " . $fRemanenteAdelanto. 
			" Remanente prestamo: " . $fRemanentePrestamo);*/ 
			
			$set ="
		  	   		fRemanenteGlobal = '{$fRemanenteGlobal}',
		  	   		fRemanenteCompra = '{$fRemanenteCompra}',
		  	   		fRemanenteCredito = '{$fRemanenteCredito}',
		  	   		fRemanenteAdelanto = '{$fRemanenteAdelanto}',
		  	   		fRemanentePrestamo = '{$fRemanentePrestamo}'
		  	   	  ";
		  	     	  
	     	//$conditions = "Cobranzas.id = '{$idCobranza}'"; 		
			$conditions = "DetallesCuentasUsuarios.id = '{$datosDetalle['id']}'";
			   
			$ToAuditory = "Actualizacion de Remanentes ::: Empleado ={$_SESSION['id_user']}";
	
			//$oRespuesta->alert("CALL usp_UpdateTable(\"DetallesCuentasUsuarios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"69\",\"$ToAuditory\");");
			//return $oRespuesta;
			
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"DetallesCuentasUsuarios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"69\",\"$ToAuditory\");",true);   
			
			//$iRespuesta = 1;
		//}
						  
		//return $iRespuesta;
	}
	
	
	function setEstadoCuentaUsuarioByCobranza_CA($idCuentaUsuario)
	{
		GLOBAL $oMysql;	
		
		$estado_NORMAL = 1;
		$estado_MOROSO_1_MES = 3;
		$estado_MOROSO_2_MESES = 4;
		$estado_MOROSO_3_MESES = 5;
		$estado_INHABILITADA = 10;
		$estado_INHABILITADA_CON_COBRANZAS = 13;
		$estado_PREVISIONADA = 11;
		$estado_PREVISIONADA_CON_COBRANZAS = 14;
		$estado_PRELEGALES = 15;
		$estado_GESTION_JUDICIAL = 16;
		
		$bModificarEstado = false;		
		$idTipoEstadoCuenta = 0;
		$idNuevoEstadoCuenta = 0;
		$iDiasMoraNuevo = 0;
		$bEstadoModificado = false;
		
		
		//-------------- Obtener cuenta usuario -------------------------------------
		$sCondicionCuentaUsuario = "WHERE CuentasUsuarios.id = {$idCuentaUsuario};";		
		$CuentaUsuario = $oMysql->consultaSel("CALL usp_getCuentasUsuarios(\"$sCondicionCuentaUsuario\");",true);			
		
		
		if($CuentaUsuario['idTipoEstadoCuenta'] == $estado_INHABILITADA || $CuentaUsuario['idTipoEstadoCuenta'] == $estado_PRELEGALES || $CuentaUsuario['idTipoEstadoCuenta'] == $estado_GESTION_JUDICIAL)
		{
			return;
		}
		
		
		//--------------- Obtener detalle cuenta usuario ----------------------------
		$sCondiciones = "WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$idCuentaUsuario}	ORDER BY DetallesCuentasUsuarios.id DESC LIMIT 0,2 ;";		
		$datosDetalle = $oMysql->consultaSel("CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");");
		
		
		if(!$datosDetalle)
		{
			return;			
		}
		
		
		if($CuentaUsuario)	
		{			
			//$diferencia = $datosDetalle[0]["fSaldoAnterior"] - $datosDetalle[0]['fAcumuladoCobranza'];
			//$idTipoEstadoCuenta = $CuentaUsuario['idTipoEstadoCuenta'];
			
			$PorcentajePagado = ($datosDetalle[0]['fAcumuladoCobranza'] * 100) / $datosDetalle[0]["fSaldoAnterior"];
				
			//CONSIDERAR DESPUES DE HACER LA COBRANZA SI EL % DE ACUMULADO DE COBRANZAS 
			//SE ENCUENTRA ENTRE EL 50% Y EL 80%, VOLVER AL ESTADO ANTERIOR
			//SI PAGO MAS DEL 80% VOLVER A NORMAL
			//EN CASO DE ESTAR EN ESTADO: INHABILITADO, PRELEGALES O GESTION JUDICIAL NOOO REALIZAR ESTA VALIDACION			
			
			
			if($PorcentajePagado >= 50 && $PorcentajePagado <= 80)
			{
				//VOLVER LA CUENTA AL ESTADO ANTERIOR
				//$idNuevoEstadoCuenta = 3; //MOROSO 1 MES
				
				$dFechaVencimiento = dateToMySql($datosDetalle[0]['dFechaVencimiento']);									
				$dFechaVencimientoActual =  $oMysql->consultaSel("SELECT fnc_getFechaVencimientoAnterior(\"{$dFechaVencimiento}\",\"{$datosDetalle[0]['idCuentaUsuario']}\",\"{$CuentaUsuario['idGrupoAfinidad']}\");",true);
									
				$dFechaMoraActual = dateToMySql($datosDetalle[0]['dFechaMora']);									
				$dFechaCorridaMoraActual =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraActual}\",\"{$datosDetalle[0]['idCuentaUsuario']}\",\"{$CuentaUsuario['idGrupoAfinidad']}\");",true);
				
				$dFechaMoraAnterior = dateToMySql($datosDetalle[1]['dFechaMora']);									
				$dFechaCorridaMoraAnterior =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraAnterior}\",\"{$datosDetalle[1]['idCuentaUsuario']}\",\"{$CuentaUsuario['idGrupoAfinidad']}\");",true);
									
				$idEstadoCuentaActual = $CuentaUsuario['idTipoEstadoCuenta'];
				$idNuevoEstadoCuenta = 0;
				
				
				if($idEstadoCuentaActual == $estado_MOROSO_1_MES)
				{
					$idNuevoEstadoCuenta = $estado_NORMAL; 
					$iDiasMoraNuevo = 0;	
					$bModificarEstado = true;
				}
				elseif ($idEstadoCuentaActual == $estado_MOROSO_2_MESES)
				{
					$idNuevoEstadoCuenta = $estado_MOROSO_1_MES;
					$iDiasMoraNuevo = $datosDetalle[0]['iDiasMora'] - getDias($dFechaCorridaMoraActual, $dFechaCorridaMoraAnterior);	
					$bModificarEstado = true;
				} 
				elseif($idEstadoCuentaActual == $estado_MOROSO_3_MESES)
				{
					$idNuevoEstadoCuenta = $estado_MOROSO_2_MESES;
					$iDiasMoraNuevo = $datosDetalle[0]['iDiasMora'] - getDias($dFechaCorridaMoraActual, $dFechaCorridaMoraAnterior);	
					$bModificarEstado = true;
				}		
			}
			else if($PorcentajePagado >= 80) //Si el porcentaje que pago supera el 80% de la deuda se cambia el estado a NORMAL Independientemente del estado anterior en el que se encontraba
			{
				$idNuevoEstadoCuenta = $estado_NORMAL; 
				$iDiasMoraNuevo = 0;	
				$bModificarEstado = true;
			}
			
		}
		
					
		if($bModificarEstado)
		{
				
			#--------------------- Actualizar los dias de mora y estado del usuario ----------------------------
				$set = "iDiasMora = '{$iDiasMoraNuevo}', idTipoEstadoCuenta = '{$idNuevoEstadoCuenta}'";
			    $conditions = "DetallesCuentasUsuarios.id = '{$datosDetalle[0]['id']}'";
			    	
				$ToAuditory = "Actualizacion Cuenta Usuario ::: Empleado ={$_SESSION['id_user']} - Dias de Mora: {$iDiasMoraNuevo} - Estado: {$idNuevoEstadoCuenta}";
				   
				$id = $oMysql->consultaSel("CALL usp_updateEstadoCuentaUsuario(\"$iDiasMoraNuevo\",\"$idNuevoEstadoCuenta\",\"$idCuentaUsuario\",\"{$datosDetalle[0]['id']}\",\"{$_SESSION['id_user']}\");",true);			
				 				
				#-------------------- Insertar en la tabla Morosidad ------------------------------- 
				$dFechaRegistro = date("Y-m-d h:i:s"); 
				
				 $set ="
			  	   		idCuentaUsuario,
			  	   		iDiasMoraActual,
			  	   		iDiasMoraNueva,
			  	   		fImportePagoMinimo,
			  	   		fImporteTotalResumenUsuario,
			  	   		fImporteTotalCobranzasUsuario,
			  	   		dFechaRegistro,
			  	   		idEmpleado,
			  	   		idEstadoCuentaActual,
			  	   		idEstadoCuentaNuevo";
			  	     	   		
				   $values = "
				   		'{$idCuentaUsuario}',
				   		'{$datosDetalle[0]['iDiasMora']}',
				   		'{$iDiasMoraNuevo}',
				   		'0',
				   		'{$datosDetalle[0]['fImporteTotalPesos']}',
					   	'{$datosDetalle[0]['fAcumuladoCobranza']}',
				   		'{$dFechaRegistro}',
				   		'{$_SESSION['id_user']}',
				   		'{$idEstadoCuentaActual}',
				   		'{$idNuevoEstadoCuenta}'		   		
				   	";
				   	 
				   
			   		$ToAuditory = "Insercion de Morosidad ::: Empleado ={$_SESSION['id_user']}";
			   
			   		$id = $oMysql->consultaSel("CALL usp_InsertTable(\"Morosidad\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"70\",\"$ToAuditory\");",true);   	
		}
		
		return;
	}
	
	
	function reasignarFechasDeFacturacion_CA($dFechaCierre, $idCuentaUsuario)
	{
		GLOBAL $oMysql;	
		
		$sCondiciones = "WHERE dFechaFacturacionUsuario  = '{$dFechaCierre}'  AND iEstadoFacturacionUsuario = 0 AND Tarjetas.idCuentaUsuario = {$idCuentaUsuario}";		
		
		$datosDetalleCupones = $oMysql->consultaSel("CALL usp_getFechasDetallesCupones(\"$sCondiciones\");");	
					
		if(!$datosDetalleCupones)
		{
			echo("No se encontraron resultados");	
			return;		
		}
		
		$dFechaFacturacion = $dFechaCierre;
		$arrayFecha = explode("/",$dFechaFacturacion);
		$iMes = $arrayFecha[1];	
		
		$anio = $arrayFecha[0];			
		
		//$oRespuesta->alert("mes antes: " .$iMes);
		
		foreach ($datosDetalleCupones as $Detalle)//($i = 1; $i <= count($datosDetalleCupones)-1; $i++)		
		{
			$iDias = $arrayFecha[2];	
			//$mktime = mktime(0,0,0,intval($mes),1,intval($anio));
			
			//$oRespuesta->alert("mes: " .$iMes);									
			
			if($iDias ==31)
			{
				$iDias = 30;
			}	
					
			if($iMes == 12)
			{
				$iMes = 1;
				$anio +=1; 
			}
			else  
			{
				$iMes += 1;				
			}		
			
			if($iMes == 2 && $iDias >=29)
			{
				//$oRespuesta->alert("entro. ". $iMes);
				$iDias = 25;
			}
			
			$fecha_nueva = mktime(0,0,0,$iMes,$iDias,intval($anio));
			
			$dFechaFacturacionNueva = date("d/m/Y", $fecha_nueva);
       		
        	#Actualizar en la tabla DetallesCupones la fecha de facturacion			
			
			$dFechaFacturacionNueva = dateToMySql($dFechaFacturacionNueva);
			
			$id = $Detalle["id"]; 
			//$oRespuesta->alert($Detalle["id"]);
			
			$set = "dFechaFacturacionUsuario = '{$dFechaFacturacionNueva}'";
	    	$conditions = "DetallesCupones.id = '{$id}'";
			$ToAuditory = "Update Estado Cobranza ::: Empleado ={$_SESSION['id_user']} ::: idCobranza={$idFacturacionCargos} ::: estado={$sEstado}";
		
			$id = $oMysql->consultaSel("CALL usp_UpdateValues(\"DetalleCupones\",\"$set\",\"$conditions\");",true);   
			
			if($id != 1)
			{
				$oRespuesta->alert("No se pudo reasignar la fecha de facturacion");
			}
			
			$oRespuesta->alert("CALL usp_UpdateValues(\"DetallesCupones\",\"$set\",\"$conditions\");");
		}
	}
	
	function validarNumeroTarjeta($sNumeroTarjeta){  //Retorna 0=Si es el numero es correcto, 1=falso
		GLOBAL $oMysql;
		
		//primero verifico que exista en numero de tarjeta en la BD
		$existeTarjeta = $oMysql->consultaSel("select fcn_validarNumeroTarjeta(\"$sNumeroTarjeta\")",true);
		
		$bTarjetaCorrecta = 0;
		
		if($existeTarjeta == 1){			
			
			//segundo verifico que el digito luhn sea valido
			$sNumeroTarjetaSinLuhn = substr($sNumeroTarjeta,0,strlen($sNumeroTarjeta)-1);
			$sDigitoVerificador = luhn($sNumeroTarjetaSinLuhn);
			
			if($sDigitoVerificador == $sNumeroTarjeta[strlen($sNumeroTarjeta)-1]){
				$bTarjetaCorrecta = 0;
			}else{
				$bTarjetaCorrecta = 1;
			}
			
		}else{
			$bTarjetaCorrecta = 1;
		}	
		return $bTarjetaCorrecta;		
	}
	
	
	function subirCobranzas($form)
	{
		GLOBAL $oMysql;
	    $imag=new upload($_FILES['archivo'],'es_ES');
	    
		if ($imag->uploaded)
		{	
		        $imag->Process('./Archivos/');
		        
		        if ($imag->processed) 
		        { 		        			        	
		        	$sArchivo="./Archivos/$imag->file_dst_name";
		        	$data = new Spreadsheet_Excel_Reader();
				
					$data->setOutputEncoding('CP1251');
					$data->read($sArchivo);
					$iNumFila=2;
					$aErrores=array();
					
					for ($i = $iNumFila; $i <= $data->sheets[0]['numRows']; $i++) 
					{	
							$data->sheets[0]['cells'][$i][1]=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][1]);
							$data->sheets[0]['cells'][$i][2]=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][2]);
							$data->sheets[0]['cells'][$i][3]=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][3]);
							$data->sheets[0]['cells'][$i][4]=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][4]);
							$data->sheets[0]['cells'][$i][5]=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][5]);
							$data->sheets[0]['cells'][$i][6]=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][6]);
							$data->sheets[0]['cells'][$i][7]=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][7]);
							$data->sheets[0]['cells'][$i][8]=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][8]);
							$data->sheets[0]['cells'][$i][9]=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][9]);
							$data->sheets[0]['cells'][$i][10]=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][10]);
							$data->sheets[0]['cells'][$i][11]=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][11]);
							$data->sheets[0]['cells'][$i][12]=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][12]);
							$data->sheets[0]['cells'][$i][13]=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][13]);
							$data->sheets[0]['cells'][$i][14]=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][14]);
							
							$idSucursal = $data->sheets[0]['cells'][$i][1]; 
							$sSucursal = $data->sheets[0]['cells'][$i][2];       
							$sMoneda = $data->sheets[0]['cells'][$i][3];       
              				$sComprobante = $data->sheets[0]['cells'][$i][4];       
							$sTipoMov = $data->sheets[0]['cells'][$i][5];       
              				$sImporte = $data->sheets[0]['cells'][$i][6];       
							$sFechaProceso = $data->sheets[0]['cells'][$i][7]; 
							$sCuil = $data->sheets[0]['cells'][$i][8]; 
              				$sUsuario = $data->sheets[0]['cells'][$i][9];
              				$sHora = $data->sheets[0]['cells'][$i][10];
              				$sCodBarra = $data->sheets[0]['cells'][$i][11];
							$sGrupoTerminal = $data->sheets[0]['cells'][$i][12];
							$sNroRendicion = $data->sheets[0]['cells'][$i][13];
							$sFechaCobro = $data->sheets[0]['cells'][$i][14];
														
							$aTabla[]=" <tr>
											<td>{$idSucursal}</td>
											<td>{$sSucursal}</td>
											<td>{$sMoneda}</td>
											<td>{$sComprobante}</td>
											<td>{$sTipoMov}</td>
											<td>{$sImporte}</td>
											<td>{$sFechaProceso}</td>
											<td>{$sCuil}</td>
											<td>{$sUsuario}</td>
											<td>{$sHora}</td>
											<td>{$sCodBarra}</td>
											<td>{$sGrupoTerminal}</td>
											<td>{$sNroRendicion}</td>
											<td>{$sFechaCobro}</td>
										<tr/> ";
							
						//--------------- Obtener idCuentaUsuario ------------------
						
						$sCuentaUsuario = substr($sComprobante,7,7);  
						
						$sCondicionesUsuarios = " WHERE CuentasUsuarios.sNumeroCuenta = {$sCuentaUsuario}"; 	
						$sqlDatosUsuarios = "Call usp_getCuentasUsuarios(\"$sCondicionesUsuarios\");";		
						$rsUsuario = $oMysql->consultaSel($sqlDatosUsuarios,true);		
						
						$idCuentaUsuario = $rsUsuario["id"];
						
						
						$form['idCuentaUsuario'] = $idCuentaUsuario;
						$form['dFechaCobranza'] = $sFechaCobro; 
						$form['idEmpleado'] = 805;
						$form['idTipoMoneda'] = 1;
						$form['fImporte'] = $sImporte;
						
						updateDatosCobranzasImportadas($form);
						
						//----------------------------------------------------------			
					}
					
					if(count($aTabla) > 0)
					{
						$sTabla="
						         <center>
						         	<br>								 	
								    <table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='30%' height='10%'>
								    	<tr class='filaPrincipal'>
								    		<td colspan='2' align='center' style='height:10px'>
								    			<b>DATOS IMPORTADOS<b>
								    		</td>
								    	</tr>
								    	<tr>
								    		<th>
								    			<h3>&nbsp;{$imag->file_dst_name}&nbsp;</h3>			
								    		</th>
								    	</tr>
								    </table>								 	
						         <br>
						         <br>
								 <table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='90%'>
						         <tr class='filaPrincipal'>
							         <th style='height:25px'>ID SUC</th>
							         <th style='height:25px'>SUCURSAL</th>
							         <th style='height:25px'>MONEDA</th>
							         <th style='height:25px'>COMPROBANTE</th>
							         <th style='height:25px'>TIPO. MOV.</th>
							         <th style='height:25px'>IMPORTE</th> 
					 				 <th style='height:25px'>FECHA PROCESO</th>
					 				 <th style='height:25px'>CUIL</th>
							         <th style='height:25px'>USUARIO</th>
							         <th style='height:25px'>HORA</th>
							         <th style='height:25px'>COD. BARRA</th>
							         <th style='height:25px'>GRUPO TERMINAL</th>
							         <th style='height:25px'>NRO. RENDICION</th> 
					 				 <th style='height:25px'>FECHA COBRO</th>
						         </tr>";
						
						$sTabla.=implode('',$aTabla);
						
									
					}
					
					if(count($aErrores) > 0)
					{	
						$sTabla.="
						     <br/>  
					         <h4 style='font-family:'sans-serif';'>DATOS IMPORTADOS</h4> 
						         <table class='TablaGeneral' width='100%'>
						         <tr class='filaPrincipal'>
							         <th style='height:25px'>ID SUCURSAL</th>
							         <th style='height:25px'>SUCURSAL</th>
							         <th style='height:25px'>MONEDA</th>
							         <th style='height:25px'>COMPROBANTE</th>
							         <th style='height:25px'>TIPO. MOV.</th>
							         <th style='height:25px'>IMPORTE</th> 
					 				 <th style='height:25px'>FECHA PROCESO</th>
					 				 <th style='height:25px'>CUIL</th>
							         <th style='height:25px'>USUARIO</th>
							         <th style='height:25px'>HORA</th>
							         <th style='height:25px'>COD. BARRA</th>
							         <th style='height:25px'>GRUPO TERMINAL</th>
							         <th style='height:25px'>NRO. RENDICION</th> 
					 				 <th style='height:25px'>FECHA COBRO</th>
						         </tr> ";
						
							$sTabla.=implode('',$aErrores);
							$sTabla.="</table></center>";	
					}
					
					echo $sTabla;
					
					//var_export($aValores);
						           
		        } else echo"<p style=\"color:red;\">Error Problemas en la Direccion : ".$imag->error."</p><br><a class='link' href='javascript:history.back(1)'  style='cursor:pointer;'>Volver</a><br/>";  
		        
		        $imag-> Clean();          
			}
			else 
			{
			  echo "Error Subiendo Archivo";	
			}
	}
		
	//-------------------- COBRANZAS --------------------------------------------------------------
	function updateDatosCobranzasImportadas($form)
	{
		 GLOBAL $oMysql;			
				
		 
		 
		 $idCuentaUsuario = $form['idCuentaUsuario'];	
		
		 $dFechaRegistro =  date("Y-m-d h:i:s");
		 $dFechaPresentacion = $dFechaRegistro;				
		 $dFechaCobranza = $form['dFechaCobranza'];  
			
		 $fecha = getdate();
				
		 $sNumeroRecibo =$oMysql->consultaSel("select fnc_getNroReciboCobranza(\"{$_SESSION['ID_OFICINA']}\");",true);
		 $aNumero = explode('-', $sNumeroRecibo);		
		 $sCodigoBarra = $aNumero[0]. $aNumero[1].number_pad($fecha['mday'],2).number_pad($fecha['mon'],2).$fecha['year'].number_pad($fecha['hours'],2).number_pad($fecha['minutes'],2).number_pad($fecha['seconds'],2);

		
		 $idEmpleado = $form['idEmpleado'];
		
	  	 $set ="
	  	   		idCuentaUsuario,
	  	   		idListadoCobranza,
	  	   		idEmpleado,
	  	   		idTipoMoneda,
	  	   		dFechaCobranza,
	  	   		dFechaPresentacion,
	  	   		dFechaRegistro,
	  	   		fImporte,
	  	   		sEstado,
	  	   		iEstadoFacturacionUsuario,
	  	   		idOficina,
	  	   		sNroRecibo,
	  	   		sCodigoBarra
	  	   		";
	  	     	   		
		 $values = "
		   		'{$idCuentaUsuario}',
		   		'0',
		   		'{$idEmpleado}',
		   		'{$form['idTipoMoneda']}',
		   		'{$dFechaCobranza}',
			   	'{$dFechaPresentacion}',
		   		'{$dFechaRegistro}',
		   		'{$form['fImporte']}',
		   		'A',
		   		'0',
 			   	'{$_SESSION['ID_OFICINA']}',
 			   	'{$sNumeroRecibo}', 			   	
 			   	'{$sCodigoBarra}'
		   	";
		   	 	   
		 $ToAuditory = "Insercion de Cobranzas ::: Empleado ={$_SESSION['id_user']}, Solicita Empleado = {$idEmpleado}";
		  
		 $id = $oMysql->consultaSel("CALL usp_InsertTable(\"Cobranzas\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"67\",\"$ToAuditory\");",true);   

		 #Actualizar Acumulado de Cobranza en la cuenta de usuario		   
		 $oMysql->consultaSel("CALL usp_updateCobranzaCuentaUsuario(\"{$idCuentaUsuario}\",\"{$form['fImporte']}\");",true);
	      //$oRespuesta->alert("CALL usp_updateCobranzaCuentaUsuario(\"{$idCuentaUsuario}\",\"{$form['fImporte']}\");");	 
		  
	   	 setEstadoCuentaUsuarioByCobranza_CA($idCuentaUsuario);
	   	 RecalcularLimites_CA($idCuentaUsuario);   
	    	  
		 return;
	}
	
	function setDatosClienteGx($form){
				GLOBAL $oMysql;	
				//$mysql_gx = new MySql();
				
			    if(isset($form['sBarrioTitu'])) $form['sBarrio'] = $form['sBarrioTitu'];
			    if(isset($form['sCalleTitu'] )) $form['sCalle']= $form['sCalleTitu'];
				if(isset($form['sNumeroCalleTitu'] )) $form['sNumeroCalle'] = $form['sNumeroCalleTitu'];
				if(isset($form['sEntreCalleTitu'] )) $form['sEntreCalle'] = $form['sEntreCalleTitu'];
				if(isset($form['sBlockTitu'] )) $form['sBlock'] = $form['sBlockTitu'];
				if(isset($form['sPisoTitu'] )) $form['sPiso'] = $form['sPisoTitu'];
				if(isset($form['sDepartamentoTitu'] )) $form['sDepartamento'] = $form['sDepartamentoTitu'];
				if(isset($form['sManzanaTitu'] )) $form['sManzana'] = $form['sManzanaTitu'];
				if(isset($form['sLoteTitu'] )) $form['sLote'] = $form['sLoteTitu'];
				//if($form['hdnIdCliente']>0) $form['idCliente'] = $form['hdnIdCliente'];
				$form['idCliente'] = $form['hdnIdCliente'];
				
				$aValues = array();
				if($form['idCliente'] == 0){
					$sNumeroCliente = $oMysql->consultaSel("SELECT Clientes.ClientesNumero FROM ".BASEGX.".Clientes ORDER BY ClientesId DESC LIMIT 0,1",true);
					$sNumeroCliente++;
					$aValues[] = "Clientes.ClientesNumero='{$sNumeroCliente}'";
					$aValues[] = "Clientes.ClientesFechaRegistro=NOW()";
					$aValues[] = "Clientes.ClientesFechaAlta=NOW()";
					$aValues[] = "Clientes.STUsuariosSessionesId=20";
					$aValues[] = "Clientes.STUsuariosAdjuntosId=20";					
				}
				
				if($form['sApellido'] !="") $aValues[] = "Clientes.ClientesApellido='{$form['sApellido']}'";
				if($form['sNombre'] !="") $aValues[] = "Clientes.ClientesNombre='{$form['sNombre']}'";
				if($form['sDocumento'] !="") $aValues[] = "Clientes.ClientesDNI={$form['sDocumento']}";
				if($form['dFechaNacimiento'] !="") $aValues[] = "Clientes.ClientesFechaNaciemiento='{$form['dFechaNacimiento']}'";
				if($form['idEstadoCivil'] !="0") $aValues[] = "Clientes.ClientesEstadoCivil='{$form['idEstadoCivil']}'";
								
				$sConyuge = $form['sNombreConyuge']." ".$form['sApellidoConyuge'];
				if($sConyuge !="") $aValues[] = "Clientes.ClientesConyugue='{$sConyuge}'";
				if($form['iTipoPersona'] == 2)					
					$sRazonSocial .= $form['sRazonSocial'];				
				else
					$sRazonSocial .= $form['sNombre'].' '.$form['sApellido'];
				$aValues[] = "Clientes.ClientesRazonSocial='{$sRazonSocial}'";	
					
				if($form['sCuit'] !="") $aValues[] = "Clientes.ClientesCUIT='{$form['sCuit']}'";
				
				if($form['idCondicionIva'] !="0") $aValues[] = "Clientes.ClientesCondicionIVA='{$form['idCondicionIva']}'";
				
				if($form['sBarrio'] !="") $aValues[] = "Clientes.ClientesBarrio='{$form['sBarrio']}'";
				
				$sDomicilio = "";
				if($form['sCalle'] != ""){
					$sDomicilio .= $form['sCalle'];
					$aValues[] = "Clientes.ClientesCalle='{$form['sCalle']}'";
				}
				if($form['sNumeroCalle'] != ""){
					$sDomicilio .= " ".$form['sNumeroCalle'];
					$aValues[] = "Clientes.ClientesCalleNro='{$form['sNumeroCalle']}'";
				}
				if($form['sEntreCalle'] != ""){
					$sDomicilio .= " ENTRE CALLES ".$form['sEntreCalle'];
					$aValues[] = "Clientes.ClientesEntreCalles='{$form['sEntreCalle']}'";
				}
				if($form['sBlock'] != ""){
					$sDomicilio .= " BLOCK ".$form['sBlock'];
					 $aValues[] = "Clientes.ClientesBlock='{$form['sBlock']}'";
				}
				if($form['sPiso'] != ""){
					$sDomicilio .= " PISO ".$form['sPiso'];
					$aValues[] = "Clientes.ClientesPiso='{$form['sPiso']}'";
				}
				if($form['sDepartamento'] != ""){
					$sDomicilio .= " DPTO ".$form['sDepartamento'];
					$aValues[] = "Clientes.ClientesDepartamento='{$form['sDepartamento']}'";
				}
				if($form['sManzana'] != ""){
					$sDomicilio .= " MZA ".$form['sManzana'];
					$aValues[] = "Clientes.ClientesManzana='{$form['sManzana']}'";
				}
				if($form['sLote'] != ""){
					$sDomicilio .= " LOTE ".$form['sLote'];
					$aValues[] = "Clientes.ClientesLote='{$form['sLote']}'";
				}
				if($form['sCodigoPostalTitu'] !="") $aValues[] = "Clientes.ClientesCodigoPostal='{$form['sCodigoPostalTitu']}'";

				/*FALTAN AGREGAR EN GENEXUS*/
				if($form['sGrupoTitu'] != "") $sDomicilio .= " GRUPO ".$form['sGrupoTitu'];
				if($form['sCasaTitu'] != "") $sDomicilio .= " CASA ".$form['sCasaTitu'];
				if($form['sMedidorTitu'] != "") $sDomicilio .= " MEDIDOR ".$form['sMedidorTitu'];
				if($form['sOtrosTitu'] != "") $sDomicilio .= " OTROS ".$form['sOtrosTitu'];
				if($sDomicilio !="") $aValues[] = "Clientes.ClientesDomicilio='{$sDomicilio}'";
				
				if($form['idEmpresaCelularTitular'] !="")$aValues[] = "Clientes.ClientesEmpresaCelular='{$form['idEmpresaCelularTitular']}'";
				/*
				$sTelefonoParticularFijo = str_replace("-","",$sTelefonoParticularFijo);
				$sTelefonoParticularMovil = str_replace("-","",$sTelefonoParticularMovil);
				if($sTelefonoParticularFijo !="" && $sTelefonoParticularFijo !="-") $aValues[] = "Clientes.ClientesTelefonoFijo='{$sTelefonoParticularFijo}'";				
				if($sTelefonoParticularMovil !="" && $sTelefonoParticularMovil !="-") $aValues[] = "Clientes.ClientesCelular='{$sTelefonoParticularMovil}'";
				*/
				
				$form['sTelefonoParticularFijo']=str_replace('-','',$form['sTelefonoParticularFijo']);
				$form['sTelefonoParticularCelular']=str_replace('-','',$form['sTelefonoParticularCelular']);
				$form['sTelefonoLaboral1']=str_replace('-','',$form['sTelefonoLaboral1']);
				$form['sTelefonoLaboral2']=str_replace('-','',$form['sTelefonoLaboral2']);
				
				if($form['sTelefonoParticularFijo']!='') $aValues[] = "Clientes.ClientesTelefonoFijo='{$form['sTelefonoParticularFijo']}'";				
				if($form['sTelefonoParticularCelular']!='') $aValues[] = "Clientes.ClientesCelular='{$form['sTelefonoParticularCelular']}'";				
				if($form['sMail'] !="") $aValues[] = "Clientes.ClientesEmail='{$form['sMail']}'";
				if($form['sTelefonoContacto'] !="") $aValues[] = "Clientes.ClientesNumerosContactos='{$form['sTelefonoContacto']}'";
				if($form['idCondicionLaboral'] !="0") $aValues[] = "Clientes.ClientesTipoEmpleo='{$form['idCondicionLaboral']}'";
				if($form['sActividad'] !="") $aValues[] = "Clientes.ClientesRubro='{$form['sActividad']}'";
				if($form['sCargo1'] !="") $aValues[] = "Clientes.ClientesCargo='{$form['sCargo1']}'";
				if($form['sRazonSocialLab'] !="") $aValues[] = "Clientes.ClientesNombreEmpleador='{$form['sRazonSocialLab']}'";
				if($form['dFechaIngreso1'] !="") $aValues[] = "Clientes.ClientesFechaIngresoLaboral='{$form['dFechaIngreso1']}'";
				if($form['sCuitEmpleador'] !="") $aValues[] = "Clientes.ClientesCUITEmpleador='{$form['sCuitEmpleador']}'";
				if($form['fIngresoNetoMensual1']!="" && $form['fIngresoNetoMensual1']!="0") $aValues[] = "Clientes.ClientesIngresoMensual='{$form['fIngresoNetoMensual1']}'";
				
				$sDomicilioLaboral = "";
				if($form['sCalleLab'] != "") $sDomicilioLaboral .= $form['sCalleLab'];
				if($form['sNumeroCalleLab'] != "") $sDomicilioLaboral .= " ".$form['sNumeroCalleLab'];
				if($form['sBlockLab'] != "") $sDomicilioLaboral .= " BLOCK ".$form['sBlockLab'];
				if($form['sPisoLab'] != "") $sDomicilioLaboral .= " PISO ".$form['sPisoLab'];
				if($form['sOficinaLab'] != "") $sDomicilioLaboral .= " OFI ".$form['sOficinaLab'];		
				if($form['sManzanaLab'] != "") $sDomicilioLaboral .= " MZA ".$form['sManzanaLab'];
				if($form['sBarrioLab'] != "") $sDomicilioLaboral .= " BARRIO ".$form['sBarrioLab'];
				if($sDomicilioLaboral !="") $aValues[] = "Clientes.ClientesDomicilioLaboral='{$sDomicilioLaboral}'";
				/*
				$sTelefonoLaboral1 = str_replace("-","",$sTelefonoLaboral1);
				if($sTelefonoLaboral1 !="" && $sTelefonoLaboral1!="-") $aValues[] = "Clientes.ClientesTelefonoLaboral='{$sTelefonoLaboral1}'";
				*/
				if($form['sTelefonoLaboral1'] !="") $aValues[] = "Clientes.ClientesTelefonoLaboral='{$form['sTelefonoLaboral1']}'";
				if($form['sInterno1'] !="") $aValues[] = "Clientes.ClientesTelefonoInterno='{$form['sInterno1']}'";
				
				$iGenero ="";
				if($form['idSexo'] == "1") $iGenero = "M";
				if($form['idSexo'] == "2") $iGenero = "F";
				if($iGenero !="") $aValues[] = "Clientes.ClientesGenero='{$iGenero}'";				
				
				if($form['idTipoDocumento'] !="") $aValues[] = "Clientes.ClientesTipoDocumento='{$form['idTipoDocumento']}'";
				if($form['idNacionalidad'] !="") $aValues[] = "Clientes.PaisesId='{$form['idNacionalidad']}'";
				if($form['sApellidoConyuge'] !="") $aValues[] = "Clientes.ClientesApellidoConyuge='{$form['sApellidoConyuge']}'";
				if($form['sNombreConyuge'] !="") $aValues[] = "Clientes.ClientesNombreConyuge='{$form['sNombreConyuge']}'";
				if($form['idTipoDocumentoConyuge'] !="") $aValues[] = "Clientes.ClientesTipoDocumentoConyuge='{$form['idTipoDocumentoConyuge']}'";
				if($form['sDocumentoConyuge'] !="") $aValues[] = "Clientes.ClientesNroDocumentoConyuge='{$form['sDocumentoConyuge']}'";
				if($form['iHijos'] !="") $aValues[] = "Clientes.ClientesHijos='{$form['iHijos']}'";
				
				if($form['idLocalidadTitu'] !="") $aValues[] = "Clientes.ClientesLocalidadesId='{$form['idLocalidadTitu']}'";
				
				if($form['idLocalidadResumen'] !="0") $aValues[] = "Clientes.ClientesRLocalidadesId='{$form['idLocalidadResumen']}'";
				if($form['sCodigoPostalResumen'] !="") $aValues[] = "Clientes.ClientesRCodigoPostal='{$form['sCodigoPostalResumen']}'";
				if($form['sCalleResumen'] !="") $aValues[] = "Clientes.ClientesRCalle='{$form['sCalleResumen']}'";
				if($form['sNumeroCalleResumen'] !="") $aValues[] = "Clientes.ClientesRCalleNro='{$form['sNumeroCalleResumen']}'";
				if($form['sBlockResumen'] !="") $aValues[] = "Clientes.ClientesRBlock='{$form['sBlockResumen']}'";
				if($form['sPisoResumen'] !="") $aValues[] = "Clientes.ClientesRPiso='{$form['sPisoResumen']}'";
				if($form['sDepartamentoResumen'] !="") $aValues[] = "Clientes.ClientesRDepartamento='{$form['sDepartamentoResumen']}'";
				if($form['sEntreCalleResumen'] !="") $aValues[] = "Clientes.ClientesREntreCalles='{$form['sEntreCalleResumen']}'";
				if($form['sBarrioResumen'] !="") $aValues[] = "Clientes.ClientesRBarrio='{$form['sBarrioResumen']}'";
				if($form['sManzanaResumen'] !="") $aValues[] = "Clientes.ClientesRManzana='{$form['sManzanaResumen']}'";
				if($form['sLoteResumen'] !="") $aValues[] = "Clientes.ClientesRLote='{$form['sLoteResumen']}'";
				
				if($form['sRazonSocialLab'] !="") $aValues[] = "Clientes.ClientesRazonSocialEmpleador='{$form['sRazonSocialLab']}'";
				if($form['idCondicionAFIPLab'] !="0") $aValues[] = "Clientes.ClientesCondicionIvaEmpleador='{$form['idCondicionAFIPLab']}'";
				if($form['idCondicionLaboral'] !="0") $aValues[] = "Clientes.ClientesCondicionEmpelador='{$form['idCondicionLaboral']}'";
				if($form['sReparticion'] !="") $aValues[] = "Clientes.ClientesReparticionEmpleador='{$form['sReparticion']}'";
				if($form['sActividad'] !="") $aValues[] = "Clientes.ClientesActividadEmpleador='{$form['sActividad']}'";
				if($form['sCalleLab'] !="") $aValues[] = "Clientes.ClientesECalle='{$form['sCalleLab']}'";
				if($form['sNumeroCalleLab'] !="") $aValues[] = "Clientes.ClientesECalleNro='{$form['sNumeroCalleLab']}'";
				if($form['sBlockLab'] !="") $aValues[] = "Clientes.ClientesEBlock='{$form['sBlockLab']}'";
				if($form['sPisoLab'] !="") $aValues[] = "Clientes.ClientesEPiso='{$form['sPisoLab']}'";
				if($form['sOficinaLab'] !="") $aValues[] = "Clientes.ClientesEOficina='{$form['sOficinaLab']}'";
				if($form['sBarrioLab'] !="") $aValues[] = "Clientes.ClientesEBarrio='{$form['sBarrioLab']}'";
				if($form['sManzanaLab'] !="") $aValues[] = "Clientes.ClientesEManzana='{$form['sManzanaLab']}'";
				if($form['idLocalidadLab'] !="") $aValues[] = "Clientes.ClientesELocalidadesId='{$form['idLocalidadLab']}'";
				if($form['fIngresoNetoMensual2'] !="") $aValues[] = "Clientes.ClientesIngresoMensual2='{$form['fIngresoNetoMensual2']}'";
				if($form['sCargo2'] !="") $aValues[] = "Clientes.ClientesECargo2='{$form['sCargo2']}'";
				if($form['dFechaIngreso2'] !="") $aValues[] = "Clientes.ClientesFechaIngresoLaboral2='{$form['dFechaIngreso2']}'";
				if($form['sInterno2'] !="") $aValues[] = "Clientes.ClientesTelefonoInterno2='{$form['sInterno2']}'";
				if($form['sTelefonoLaboral2'] !="") $aValues[] = "Clientes.ClientesTelefonoLaboral2='{$form['sTelefonoLaboral2']}'";
				if($form['sCargo1'] !="") $aValues[] = "Clientes.ClientesECargo='{$form['sCargo1']}'";
				if($form['sCodigoPostalLab'] !="") $aValues[] = "Clientes.ClientesECodigoPostal='{$form['sCodigoPostalLab']}'";
				if($form['iEnvioMail'] !="") $aValues[] = "Clientes.ClientesEnvioResumenEmail='{$form['iEnvioMail']}'";
				if($form['iEnvioDomicilio'] !="") $aValues[] = "Clientes.ClientesEnvioResumenDomicilio='{$form['iEnvioDomicilio']}'";
				if($form['sReferenciaContacto'] !="") $aValues[] = "Clientes.ClientesReferenciaContacto='{$form['sReferenciaContacto']}'";
				if($form['sTelefonoContacto'] !="") $aValues[] = "Clientes.ClientesReferenciaTelefono='{$form['sTelefonoContacto']}'";
				if($form['idEmpresaCelular'] !="") $aValues[] = "Clientes.ClientesEmpresaCelular='{$form['idEmpresaCelular']}'";
				
				/*FALTAN AGREGAR EN GENEXUS*/
				/*if($form['sEmailLaboral'] !="") $aValues[] = "Clientes.XXX='{$form['sEmailLaboral']}'";
				if($form['idTiposDgr'] !="") $aValues[] = "Clientes.XXX='{$form['idTiposDgr']}'";
				if($form['idTiposImpositivas'] !="") $aValues[] = "Clientes.XXX='{$form['idTiposImpositivas']}'";*/
				
				$set = implode(",",$aValues);
				
				$sConsulta='';
				
				if($form['idCliente']>0){
					$conditions="Clientes.ClientesId={$form['idCliente']}";
					$ToAuditory="ClienteGX={$form['idCliente']}";
					$sConsulta="CALL usp_UpdateTable(\"".BASEGX.".Clientes\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"71\",\"$ToAuditory\");";
					//echo $sConsulta; die();
					
				}else{
					$ToAuditory="Alta ClienteGX :: {$form['sDocumento']}";
					$sConsulta="CALL usp_InsertTableSet(\"".BASEGX.".Clientes\",\"$set\",\"{$_SESSION['id_user']}\",\"72\",\"$ToAuditory\");";
				}
				//var_export($sConsulta);
				$oMysql->consultaSel($sConsulta);
				/*if(count($aValues)>0){
					$sValues = implode(",",$aValues);
					$sSql = "UPDATE Clientes SET {$sValues} WHERE Clientes.ClientesId={$form['hdnIdCliente']}";
					//$oRespuesta->alert($sSql);
					$mysql_gx->query($sSql);					
				}
				$mysql_gx->disconnect();*/
	}
	
	function addClienteGx($form){
		GLOBAL $oMysql;	
		
		$ToAuditory="Alta ClienteGX :: {$form['sDocumento']}";
		$sConsulta="CALL usp_InsertTableSet(\"".BASEGX.".Clientes\",\"$set\",\"{$_SESSION['id_user']}\",\"72\",\"$ToAuditory\");";
	}
	
	function dateFormatMysql($Fecha){
		#$Fecha -> formato dd/mm/YYYY hh:mm:ss
		$array = explode(" ",$Fecha);
		$parts = explode("/",$array[0]);
		
		$Date = $parts[2]."-".$parts[1]."-".$parts[0];
		if($array[1] != "" && $array[1] != "00:00:00") $Date .= " ".$array[1];
		
		return $Date;
	}
	
	function formatMoney($number, $cents = 1) { // cents: 0=never, 1=if needed, 2=always
	  if (is_numeric($number)) { // a number
	    if (!$number) { // zero
	      $money = ($cents == 2 ? '0.00' : '0'); // output zero
	    } else { // value
	      if (floor($number) == $number) { // whole number
	        $money = number_format($number, ($cents == 2 ? 2 : 0),',', '.'); // format
	      } else { // cents
	        $money = number_format(round($number, 2), ($cents == 0 ? 0 : 2),',', '.'); // format
	      } // integer or decimal
	    } // value
	    //return '$'.$money;
	    return $money;
	  } // numeric
	} // formatMoney
	
	function imprimirHeader($dFechaCobro1,$dFechaCobro2,$dFechaCobro3){
		$fecha1 = explode("/",$dFechaCobro1);
		$fecha1[2] = substr($fecha1[2],2,2);
		$dFechaCobro1 = $fecha1[0]."/".$fecha1[1]."/".$fecha1[2];
		
		$htmlFecha2 ="";
		if($dFechaCobro2 != ""){	
			$fecha2 = explode("/",$dFechaCobro2);
			$fecha2[2] = substr($fecha2[2],2,2);
			$dFechaCobro2 = $fecha2[0]."/".$fecha2[1]."/".$fecha2[2];
			$htmlFecha2.="<td style='border:1px solid #000000;height:18px'> {$dFechaCobro2}</td>";
		}else{
			$dFechaCobro2 ="&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		$htmlFecha3 ="";
		if($dFechaCobro3 != ""){
			$fecha3 = explode("/",$dFechaCobro3);
			$fecha3[2] = substr($fecha3[2],2,2);
			$dFechaCobro3 = $fecha3[0]."/".$fecha3[1]."/".$fecha3[2];
			$htmlFecha3.="<td style='border:1px solid #000000;height:18px'> {$dFechaCobro3}</td>";
		}else{
			$dFechaCobro3 ="&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		$htmlHeader = "";
		$signo = "$";
		$htmlHeader .= "<tr>
			<td style='border:1px solid #000000;width:350px;height:18px'> &nbsp;<b>CLIENTES</b> </td>
			<td style='border:1px solid #000000;width:35px;height:18px' align='center'> <b>$</b> </td>
			<td style='border:1px solid #000000;height:18px'> {$dFechaCobro1}</td>
			$htmlFecha2
			$htmlFecha3
			<td style='border:1px solid #000000;height:18px'> <b>".$signo."Total</b> </td>
			</tr>";	
		return $htmlHeader;
	}

	function imprimirClientesCobros($array,$cantidadFilas,$inicio,$imprimirSolaFecha){
		global $oMysql;
		$htmlCobros = "";
		if(count($array)>0)
		{
			//foreach ($array as $row){
			for($i=$inicio; $i <= $cantidadFilas; $i++){
				$row = $array[$i];			
				$fMontoPago1 = "&nbsp;";
				if($row['fMontoPago1'] != 0) 
					if((int)$row['fMontoPago1'] == $row['fMontoPago1'])
						$fMontoPago1 = number_format($row['fMontoPago1'], 0, '.', '');
					else
						$fMontoPago1 = number_format($row['fMontoPago1'], 2, '.', '');
				
				$htmlPago2="";$htmlPago3="";
				if(!$imprimirSolaFecha){		
					$fMontoPago2 = "&nbsp;";
					if($row['fMontoPago2'] != 0) 
						if((int)$row['fMontoPago2'] == $row['fMontoPago2'])
							$fMontoPago2 = number_format($row['fMontoPago2'], 0, '.', '');
						else
							$fMontoPago2 = number_format($row['fMontoPago2'], 2, '.', '');
					$htmlPago2="<td style='border:1px solid #000;height:16px' align='center'>".$fMontoPago2."</td>";		
					$fMontoPago3 = "&nbsp;";
					if($row['fMontoPago3'] != 0) 
						if((int)$row['fMontoPago3'] == $row['fMontoPago3'])
							$fMontoPago3 = number_format($row['fMontoPago3'], 0, '.', '');
						else
							$fMontoPago3 = number_format($row['fMontoPago3'], 2, '.', '');
					$htmlPago3="<td style='border:1px solid #000;height:16px' align='center'>".$fMontoPago3."</td>";		
				}		
				if((int)$row['fMonto'] == $row['fMonto'])
					$row['fMonto'] = number_format($row['fMonto'], 0, '.', '');
				else
					$row['fMonto'] = number_format($row['fMonto'], 2, '.', '');		
				
				$fTotalPagado = $oMysql->consultaSel("SELECT SUM(fMontoPago) as 'fMontoPago' FROM Cobranzas WHERE Cobranzas.idCupon = ".$row['idCupon'] ,true);
				/*if($fTotalPagado == 0) 
					$fTotalPagado = "";	
				else */
				$fTotalPagado = $fTotalPagado+$row['fAdelanto'];
						
				$fTotalPagado = formatMoney($fTotalPagado,0);
				$row['fMonto'] = formatMoney($row['fMonto']);
				
				//$sDescripcion = $oMysql->consultaSel("SELECT SUBSTRING(sDescripcion,1,20) as 'sDescripcion' FROM DetallesPlanillasCobranzas WHERE det_pedidos.idPedido = '{$row['idProforma']}' LIMIT 0,1",true);
				
				$nombreCompleto = explode(", ",$row['sCliente']);
				$nombre = explode(" ",$nombreCompleto[1]);
				$inicialSegundo = substr($nombre[1],0,1);
				$sCliente = $nombreCompleto[0]. ", ".$nombre[0]." ".$inicialSegundo;
				
				$htmlCobros .= "<tr>		
				<td style='border:1px solid #000;height:16px'>&nbsp;".stripslashes($sCliente)."&nbsp;&nbsp;(".$sDescripcion.")</td>
				<td style='border:1px solid #000;height:16px' align='center'>".stripslashes($row['fMonto'])."</td>
				<td style='border:1px solid #000;height:16px' align='center'>".$fMontoPago1."</td>			
				$htmlPago2
				$htmlPago3
				<td style='border:1px solid #000;height:16px' align='center'>".$fTotalPagado."</td>
				</tr>";
				
			}
		}
		return $htmlCobros;
	}
?>