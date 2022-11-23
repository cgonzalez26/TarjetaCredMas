<?php //-----------------------------------------------

function string2date( $sCadena, $sumar_meses = 0, $sumar_dias = 0, $sumar_anios = 0 ) {
	
	$aValores = explode( '/', $sCadena );
	
	$sDia = (integer) $aValores[0];
	$sMes = (integer) $aValores[1];
	$sAnio = (integer) $aValores[2];
	
	$dFecha = mktime( null, null, null, $sMes + $sumar_meses, $sDia + $sumar_dias, $sAnio + $sumar_anios );

	return $dFecha;
}


function exportarVar( $mVariable ) {
	
	echo "<pre style='width: 500px; height: 400px; font-size: 8pt; border: solid 1px #000; margin: 35px auto; text-align: left; overflow:scroll;>";
	var_export($mVariable);
	echo "</pre>";

	
}


function getNumeroRecibo() {

	return getNumeroAutoControl( 2 );
}


function getNumeroTarjeta() {

	return getNumeroAutoControl(3);

}

function getNumCC() {

	return getNumeroAutoControl( 1 );
}

function getNumReciboPendiente() {

	return getNumeroAutoControl( 4 );
}


function getNumeroAutoControl( $iTipoNumero ) {

	GLOBAL $oMysql;
		
	$sConsulta = "call usp_numero_autocontrol($iTipoNumero)";
	return $oMysql->consultaSel( $sConsulta, true	 );
}

function validarRecibo($irecibo){
	GLOBAL $oMysql;
	
	$sConsulta = "call usp_validar_recibo('$irecibo')";
	return $oMysql->consultaSel( $sConsulta, true	 );
	
}
//---------------------------------------------------- ?>