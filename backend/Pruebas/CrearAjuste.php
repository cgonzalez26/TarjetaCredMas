<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();
		
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);

	$idCuenta = 13865;

	$fImporteAjuste = 1765 * 33.4/ 100;
	$aDatosPlanesComercio[1] = 12;
	if(setAjusteCuentaUsuario($idCuenta,$fImporteAjuste,$aDatosPlanesComercio[1],28,1))
	{
		echo "Se registro correctamente el AJUSTE";
	}
	else
	{
		echo "Sucedio un error interno al intentar grabar el AJUSTE.";
	}

	
	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);	
?> 