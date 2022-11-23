<?php 
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	
	session_start();
	
	#Control de Acceso al archivo
	if(!isLogin()){go_url("/index.php");}
	
	$idUser = $_SESSION['id_user'];
	$idTipoUser = $_SESSION['ID_TIPOEMPLEADO'];	
	//$oUsuario = new  Usuario($idUser);
	
	//var_export($oUsuario);die();
	
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
	
	
	$oXajax = new xajax();
		
	$oXajax->setCharEncoding('ISO-8859-1');
	$oXajax->configure('decodeUTF8Input',true);
	$oXajax->registerFunction("IniciarSession");
	$oXajax->registerFunction("AccederUsuario");
	$oXajax->processRequest();					
	
	$oXajax->printJavascript( "../includes/xajax/");
	//var_export($idUser.'-------'.$idTipoUser.'-------');
	$Menu = new Menu($idUser,$idTipoUser);

	
	//echo xhtmlHeaderPagina($aParametros);
	//xhtmlHeaderGrillas($aOpciones);	
	
	//Habilita las librerias del htmlx a usar
	$aParametros['DHTMLX_LAYOUT']=1;
	$aParametros['DHTMLX_WINDOW']=1;
	$aParametros['DHTMLX_MENU']=1;
	$aParametros['DHTMLX_ACORDEON']=1;
	
	
	#verifico que no tenga circulares
	/*$cantidad_circulares_no_leidas = $oMysql->consultaSel("SELECT fcn_getCantidadCircularesNOLeidas(\"{$_SESSION['id_user']}\");",true);
	
	$iResponsableContable = $oMysql->consultaSel("SELECT count(galogistica.SucursalesResponsables.id) FROM galogistica.SucursalesResponsables 
					WHERE galogistica.SucursalesResponsables.idResponsableContable={$_SESSION['id_user']}",true);	
	$script  = "";
	if($iResponsableContable > 0){
		$sql = "SELECT count(*) FROM galogistica.SolicitudesCompras WHERE galogistica.SolicitudesCompras.idTipoEstado=1";
		$iCantidadPendientes = $oMysql->consultaSel($sql,true);
		if($iCantidadPendientes > 0){
			$script .= "_popinREQUERIMIENTOS_COMPRRAS();";		
		}
	}else{
		
		$iResponsable = $oMysql->consultaSel("SELECT count(galogistica.SucursalesResponsables.id) FROM galogistica.SucursalesResponsables 
					WHERE galogistica.SucursalesResponsables.idResponsable={$_SESSION['id_user']}",true);			
		if($iResponsable > 0){
			$sql = "SELECT count(*) FROM galogistica.SolicitudesMateriales WHERE galogistica.SolicitudesMateriales.idTipoEstado=1";
			$iCantidadPendientes = $oMysql->consultaSel($sql,true);
			if($iCantidadPendientes > 0){
				$script .= "_popinREQUERIMIENTOS();";
			}
			
		}elseif($cantidad_circulares_no_leidas != 0){
			$script .= "_popinCIRCULARES();";
		}
	}*/	
	

	xhtmlHeaderPaginaGeneral($aParametros);	
	
	//$compressor = new compressor('css,javascript');
	//xhtmlHeaderPaginaGeneral($aParametros);	
?>
	<body id="idBodyP">
	<script src='../includes/js/setPopin.js' ></script>
		<?php echo $Menu->printMenu();	?>
		
	<div id="impresiones">{ToPrint}</div>
	<script language="javascript">
	shortcut.add("Backspace",function (){
			/*var t = event.srcElement.type;
			if( t == 'text') alert('estas en un input text');
			if( t == 'textarea' ) alert('estas en un  textarea');*/
			return true;
		},{
		'type':'keydown',
		'disable_in_input':true,
		'propagate':false,
		'target':document
		});	
		
	shortcut.add("F5",function (){
			return true;
	},{
		'type':'keydown',
		'propagate':false,
		'target':document
	});	
		
	<? echo $script; ?>	
	</script>	
	</body>
	
	</html>
<?php //$compressor->finish(); ?>