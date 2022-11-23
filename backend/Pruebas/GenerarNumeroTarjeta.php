<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	//session_start();
		
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);

	$sNumeroSolicitud = generarNumeroSolicitud('01');
	$sNumeroBIN = obtenerNumeroBIN(1);  	
	
	$sNumeroTarjeta1 = $sNumeroBIN . $sNumeroSolicitud . "00";
	$sNumeroTarjeta = $sNumeroTarjeta1 .luhn($sNumeroTarjeta1);
	
	echo $sNumeroSolicitud ."<br>";
	echo $sNumeroTarjeta . "<br>";
	
	

				
	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);	
?>