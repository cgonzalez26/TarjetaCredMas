<?php //---------------------------------
include_once( dirname(__FILE__) . '/constants.inc.php' );

include_once( GLOBAL_FUNCTIONS_DIR . '/main.funciones.inc.php' );


include_once( FUNCTIONS_DIR . '/xajax.rene.php' );
include_once( FUNCTIONS_DIR . '/xajax.Maci.php' );
include_once( FUNCTIONS_DIR . '/xajax.Accesos.php' );
include_once( FUNCTIONS_DIR . '/xajax.php' );
//include_once( FUNCTIONS_DIR . '/xajax.Cobranzas.php' );
include_once( FUNCTIONS_DIR . '/template.php' );
include_once( FUNCTIONS_DIR . '/navigation.php' );
include_once( FUNCTIONS_DIR . '/filtros.php' );
include_once( FUNCTIONS_DIR . '/deletes.php' );
include_once( FUNCTIONS_DIR . '/arrays.php' );

include_once( CLASSES_DIR . '/class.session.php' );

include_once(FUNCTIONS_DIR.'/misc.php');


include_once( CLASSES_DIR . '/ListObject.class.php' );
include_once( CLASSES_DIR . '/Menu.class.php' );
include_once( CLASSES_DIR . '/Message.class.php' );
include_once( CLASSES_DIR . '/MySQL.class.php' );
include_once( CLASSES_DIR . '/mysqli.clase.php' );
include_once( CLASSES_DIR . '/class.upload.php' );
include_once( CLASSES_DIR . '/excel.php' );
include_once( CLASSES_DIR . '/Botonera/ToolBar.clase.php' );
include_once( CLASSES_DIR . '/usuarios/Usuario.clase.php' );	
include_once( CLASSES_DIR . '/usuarios/Empleado.clase.php' );	
include_once( CLASSES_DIR . '/Objeto.clase.php' );
include_once( CLASSES_DIR . '/comercios.clase.php' );
include_once( CLASSES_DIR . '/planes.clase.php' );
include_once( CLASSES_DIR . '/cupones.clase.php' );
include_once( CLASSES_DIR . '/promocionesplanes.clase.php' );
include_once( CLASSES_DIR . '/tiposplanes.clase.php' );
include_once( CLASSES_DIR . '/CNumeroLetra.php' );
include_once( CLASSES_DIR . '/class.getCuil.php' );

include( CLASSES_DIR . '/ExcelWriter.clase.php' );
include( CLASSES_DIR . '/ExcelReader/reader.php' );
include( CLASSES_DIR . '/email.clase.php' );


include_once( XAJAX_DIR . '/xajax_core/xajax.inc.php' );

function mathDivision( $num1, $num2 ) { return $num1 / $num2; }

function mathModule( $num1, $num2 ) { return $num1 % $num2; }

function mathParity( $num ) { return $num % 2 == 0 ? 'PAR' : 'IMPAR'; }

include(INCLUDES_DIR.'/FileTipos/File_marcas_modelos.php');
include(INCLUDES_DIR.'/FileTipos/File_tipos_combustibles.php');
include(INCLUDES_DIR.'/FileTipos/File_tipos_dni.php');
include(INCLUDES_DIR.'/FileTipos/File_tipos_iva.php');
include(INCLUDES_DIR.'/FileTipos/File_tipos_polizas.php');
include(INCLUDES_DIR.'/FileTipos/File_tipos_usos.php');
include(INCLUDES_DIR.'/FileTipos/File_tipos_vehiculos.php');
include(INCLUDES_DIR.'/FileTipos/File_vehiculos_carrocerias.php');
include(INCLUDES_DIR.'/FileTipos/File_vehiculos_usos.php');
include(INCLUDES_DIR.'/FileTipos/File_tipos_coberturas.php');

//session_start(); #Inicializo Sesion
//var_export($_SESSION);
//$mysql = new MySql();
//$oMysql_Seguros =new mysql2();
$oMysql = new mysql2();

//$aConexionSeguros = $oMysql->consultaSel("SELECT sHost FROM UnidadesNegocios WHERE id=1",true);

setlocale (LC_TIME, "es_ES.utf-8"); 

If( !$_POST['xajax'] ) header( "Content-type: text/html; charset=\"ISO-8859-1\"" );

//---------------------------------- ?>