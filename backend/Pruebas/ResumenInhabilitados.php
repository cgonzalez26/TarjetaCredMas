<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();
		
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
			
	
	//Este procesomas genera un resumen con todas las cuotas futuras para cada cuenta es estado inhabilitado
	
	function generarResumenInhabilitados($idGrupoAfinidad)
	{
				global $oMysql;	
				
				$FechaActual =date('Y-m-d');
				list($añoActual,$mesActual,$diaActual)	=split("-",$FechaActual);
										
				$iEstadoInhabilitado = 10;	
	
				//--------------- Traer Cuentas de Usuarios en estado inhabilitado -------------------------
				
				$sub_query = " WHERE CuentasUsuarios.idTipoEstadoCuenta = {$iEstadoInhabilitado} AND CuentasUsuarios.idGrupoAfinidad = {$idGrupoAfinidad} ";
				//AND CuentasUsuarios.id in (89,165,193,205,208,264,279,282,296,298,303,320,362,367,380,388,389,484,524,551,587,596,615,626,658,659,691,764,768,835
//);";
				$cuentasusuarios = $oMysql->consultaSel("CALL usp_getCuentasUsuarios(\"$sub_query\");");						
				
				foreach ($cuentasusuarios as $cuentausuario)
				{					
					$dFechaCierre = $oMysql->consultaSel("SELECT fcn_getFechaCierreUsuario(\"{$mesActual}\", \"{$añoActual}\",\"{$cuentausuario['id']}\");", true);
					
					//$cuentausuario['id'] = 808;
					
					//------------ Traer ultimo detalle de cuenta de usuario para verificar si tiene periodo actual -------------
										
					/*$sub_query = " WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$cuentausuario['id']} ORDER BY DetallesCuentasUsuarios.id DESC LIMIT 0,1";
					$detallescuentasusuarios = $oMysql->consultaSel("CALL usp_getDetallesCuentasUsuarios(\"$sub_query\");");
					*/
					
					
					//---------- Actualizar detalles de cupones -------------------------------------------------------
					
					#obtengo idDetallesCupones para actualizar con nueva fecha de facturacion
					$detalles = $oMysql->consultaSel("CALL usp_getIdDetallesCuponesPorCuentaUsuario(\"{$cuentausuario['id']}\", \"{$dFechaCierre}\");");
					
					foreach ($detalles as $cuotas) 
					{
						$set = "DetallesCupones.dFechaFacturacionUsuario='$dFechaCierre'";
						$values = "DetallesCupones.id='{$cuotas['id']}'";
						$i = $oMysql->consultaSel("CALL usp_UpdateValues(\"DetallesCupones\",\"$set\",\"$values\");",true);
						//echo "CALL usp_UpdateValues(\"DetallesCupones\",\"$set\",\"$values\");";
					}
					
					//------- Acutalizar detalles de ajustes -----------------------------------------------------------
					
					
					#obtengo idDetallesCupones para actualizar con nueva fecha de facturacion
					$detallesAjustes = $oMysql->consultaSel("CALL usp_getIdDetallesAjustes(\"{$cuentausuario['id']}\", \"{$dFechaCierre}\");");					
					
					foreach ($detallesAjustes as $Ajuste) 
					{
						$set = "DetallesAjustesUsuarios.dFechaFacturacionUsuario='$dFechaCierre'";
						$values = "DetallesAjustesUsuarios.id='{$Ajuste['id']}'";
						$i = $oMysql->consultaSel("CALL usp_UpdateValues(\"DetallesAjustesUsuarios\",\"$set\",\"$values\");",true);
						//echo " -CALL usp_UpdateValues(\"DetallesAjustesUsuarios\",\"$set\",\"$values\");- ";
					}
				}
				
				echo "La operacion se realizo correctamente";

	}
	
	generarResumenInhabilitados('3');
	
	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);	
?>