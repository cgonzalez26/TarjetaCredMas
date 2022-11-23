<?php 
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$mensaje='';
/*if($_GET['iTipo']==2){
	$mensaje="-Su sesión a Terminado y el pago no se Registro . \n";
	$mensaje.="-Por favor ingrese al Sistema Nuevamente.\n Y efectue Nuevamente el pago."; 	
}else $mensaje='';*/

$aOpciones['TITULO']='<b style="font-family:Tahoma;">Iniciar Session</b>';
$aOpciones['ETIQUETA']="Iniciar";
$aOpciones['ACCION']="xajax_IniciarSession(xajax.getFormValues('formAdminUsu'));";
//$aOpciones['TIPO']=$_GET['iTipo'];
$aOpciones['MENSAJE']=$mensaje;




echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BlockInicioSession.tpl", $aOpciones);
?>