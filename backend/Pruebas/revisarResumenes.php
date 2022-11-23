<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();
		
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);

	$oCuentas = $oMysql->consultaSel("select DetallesCuentasUsuarios.idCuentaUsuario
from DetallesCuentasUsuarios
inner join CuentasUsuarios on DetallesCuentasUsuarios.idCuentaUsuario = CuentasUsuarios.id
where DetallesCuentasUsuarios.dPeriodo='2012-06-01 00:00:00'
and DetallesCuentasUsuarios.iEmiteResumen=1
and CuentasUsuarios.idGrupoAfinidad=2");
	
	foreach ($oCuentas as $idCuentaUsuario){
		//$idCuentaUsuario = $rs[''];
		$name_file="../includes/Files/Datos/06-2012/DR_2_".$idCuentaUsuario."_06-2012.xml";
		
		if(!file_exists($name_file)){
			$contenido.= $idCuentaUsuario . chr(13) . chr(10);
		}		
	}
	
	$file = fopen("setSql_2.txt", "w+" );
    fwrite($file,$contenido);
    fclose($file);
    echo "ok";
	xhtmlHeaderPaginaGeneral($aParametros);	
?>

