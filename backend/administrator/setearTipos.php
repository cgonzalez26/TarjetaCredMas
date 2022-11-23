<?php
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$idUser = $_SESSION['id_user'];
$TypeUser = $_SESSION['id_tuser'];


SetupFilesTipos('tipos_polizas','id_tpol','nom');
SetupFilesTipos('tipos_dni','id_tdni','nom');
SetupFilesTipos('tipos_iva','id_tiva','nom');
SetupFilesTipos('tipos_vehiculos','id_tvehi','nom');
SetupFilesTipos('tipos_usos','id_tuso','nom');
SetupFilesTipos('tipos_combustibles','id_tcombu','nom');

SetupFilesRelacionTipos('vehiculos_usos LEFT JOIN tipos_usos ON tipos_usos.id_tuso = vehiculos_usos.id_tuso ','vehiculos_usos','id_vehiuso','vehiculos_usos.id_tvehi','vehiculos_usos.id_tuso','tipos_usos.nom');
SetupFilesRelacionTipos('vehiculos_carrocerias LEFT JOIN tipos_carrocerias ON tipos_carrocerias.id_tcar = vehiculos_carrocerias.id_tcar ','vehiculos_carrocerias','id_vehicar','vehiculos_carrocerias.id_tvehi','vehiculos_carrocerias.id_tcar','tipos_carrocerias.nom');

SetupFilesRelacionTiposMarcasModelos('marcas_modelos LEFT JOIN marcas ON marcas_modelos.id_mar = marcas.id_mar LEFT JOIN modelos ON marcas_modelos.id_mod = modelos.id_mod ','marcas_modelos','id_marmod','marcas.id_mar','modelos.id_mod','marcas.nom AS sMarca','modelos.nom AS sModelo');

SetupFileTiposCobertura();

?>