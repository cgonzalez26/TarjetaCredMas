<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	
	session_start();
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	
	
	xhtmlHeaderPaginaGeneral($aParametros);		
	$sNumeroCuenta = generarNumeroSolicitud($_GET['NumeroRegion']);
	$sNumeroCuenta = '0100522';
	
	$sNumeroBIN = '646377';  	
  	$sNumeroTarjeta1 = $sNumeroBIN.$sNumeroCuenta."00";
  	$sNumeroTarjeta = $sNumeroTarjeta1.luhn($sNumeroTarjeta1);
  	
  	$sCodigoSeguridad = generarCodigoSeguridadTarjeta($sNumeroTarjeta);
  	
  	echo "Nuevo Numero Solicitud : ".$sNumeroCuenta;
  	echo "<br>Nuevo Numero Cuenta : ".$sNumeroCuenta;
  	echo "<br> Nuevo Numero de Tarjeta :" .$sNumeroTarjeta;
  	echo "<br> Nuevo Codigo de Seguridad :" .$sCodigoSeguridad;
  	
	echo xhtmlFootPagina();
?>