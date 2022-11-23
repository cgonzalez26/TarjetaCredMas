<?php 
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$idUser = $_SESSION['id_user'];
$TypeUser = $_SESSION['id_tuser'];
$aParametros = array();
$aParametros = getParametrosBasicos(1);
$aOpciones['OPCIONES_SUCURSALES']=$oMysql->getListaOpciones( 'Sucursales', 'id', 'sNombre',$_SESSION['id_suc']);
$aOpciones['SCRIPT_DEPENDIENTE']=$oMysql->getListaOpcionesCondicionado( 'id_sucursal', 'id_dependiente', 'Oficinas', 'id', 'sApodo', 'idSucursal','Oficinas.sEstado = \'A\'', '','');
$aOpciones['SCRIPT_USUARIOS']=$oMysql->getListaOpcionesCondicionado( 'id_dependiente', 'id_usuario','Empleados', 'id','sLogin','idOficina','Empleados.sEstado = \'A\'', '','');
$aOpciones['TITULO']="<b>Seleccione al usuario solicitante</b>";
$aOpciones['ETIQUETA']="Acceder";
$aOpciones['ID_POL']=$_GET['idPol'];
$aOpciones['ID_CUOTA']=$_GET['idCuota'];
$aOpciones['ID_PAGO']=$_GET['idPago'];

$aOpciones['ACCION']=$_GET['Do']."(xajax.getFormValues('formAdminUsu'));";

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BlockUsuario.tpl", $aOpciones);
?>