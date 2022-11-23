<?php
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$idUser = $_SESSION['id_user'];
$TypeUser = $_SESSION['id_tuser'];


//SetupFilesTipos('Empleados','id','CONCAT(sApellido,\', \', sNombre) as sEmpleado','sEmpleado');
SetupFilesTipos('TiposEmpleados','id','sNombre','sNombre');

SetupFilesRelacionTipos('Empleados LEFT JOIN TiposEmpleados ON TiposEmpleados.id = Empleados.idTipoEmpleado ','Empleados','Empleados.id','Empleados.idTipoEmpleado','Empleados.sNombre','Empleados.sApellido');
?>