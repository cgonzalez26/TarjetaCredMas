<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');

	include_once(  BASE . '/_global.php' );

	error_reporting(E_ALL ^ E_NOTICE);

	function get_rows_from_DB($idGrupoAfinidad,$dPeriodo){
		
		global $oMysql;	
		
		$sqlDatos=" SELECT CuentasUsuarios.id,CuentasUsuarios.idTipoEstadoCuenta
 					FROM CuentasUsuarios 
 					WHERE CuentasUsuarios.idGrupoAfinidad = {$idGrupoAfinidad}
 					AND CuentasUsuarios.id=5";		
		$rs = $oMysql->consultaSel($sqlDatos);
		
		if(!$rs){

		}else{
			foreach ($rs as $row){				
				$sCondicion=" WHERE CuentasUsuarios.id = {$row['id']}";
				$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondicion\");";		
				$rowDatos = $oMysql->consultaSel($sqlDatos,true);
				
				$sCondicionDetalle=" WHERE DetallesCuentasUsuarios.idCuentaUsuario={$row['id']} AND DetallesCuentasUsuarios.dPeriodo={$dPeriodo}";
				$sqlDetalle="Call usp_getDetallesCuentasUsuarios(\"$sCondicionDetalle\");";
				$rowDetalle = $oMysql->consultaSel($sqlDetalle,true);
				
				$dPeriodoSiguiente="";
				$sCondicionCalendario = " WHERE CalendariosFacturaciones.idGrupoAfinidad={$idGrupoAfinidad} AND CalendariosFacturaciones.dPeriodo=DATE_ADD({$dPeriodoSiguiente},interval 1 MONTH)";
				$sqlCalendario = "Call usp_getCalendarioFacturacion(\"$sCondicionCalendario\");";
				$rsCalendario = $oMysql->consultaSel($sqlCalendario,true);
				
				$sTitular = $rowDatos['sNombre']." ".$rowDatos['sApellido'];				
				print("<idGrupoAfinidad>{$idGrupoAfinidad}</idGrupoAfinidad>");
				print("<idCuentaUsuario>{$row['id']}</idCuentaUsuario>");
				print("<idModeloResumen>{$rowDetalle['idModeloResumen']}</idModeloResumen>");
				print("<sNumeroCuentaUsuario>{$rowDatos['sNumeroCuenta']}</ sNumeroCuentaUsuario >");
				print("<dPeriodo>{$dPeriodo}</dPeriodo>");
				print("<dFechaCierre>{$rowDetalle['dFechaCierre']}</dFechaCierre>");
				print("<dFechaVencimiento>{$rowDetalle['dFechaVencimiento']}</dFechaVencimiento>");
				print("<dFechaCierreSiguiente>{$rsCalendario['dFechaCierre']}</dFechaCierreSiguiente>");
				print("<dFechaVencimientoSiguiente>{$rsCalendario['dFechaVencimientos']}</dFechaVencimientoSiguiente>");
				print("<dFechaInicio>{$$rowDatos['dFechaRegistro']}</dFechaInicio>");
				print("<fSaldoAnterior>{$rowDetalle['fSaldoAnterior']}</fSaldoAnterior>");
				print("<sTitular<![CDATA[".stripslashes($sTitular)."]]></sTitular>");
				print("<sEstado>{$rowDatos['sEstado']}</sEstado>");
				print("<fTotalResumen>{$rowDetalle['fImporteTotalPesos']}</fTotalResumen>");
				print("<fLimiteCredito>{$rowDetalle['fLimiteCredito']}</fLimiteCredito>");
				print("<fRemaneteCredito>{$rowDetalle['fRemanenteCredito']}</fRemaneteCredito>");
				print("<fLimiteCompra>{$rowDetalle['fLimiteCompra']}</fLimiteCompra>");
				print("<fRemaneteCompra>{$rowDetalle['fRemanenteCompra']}</fRemaneteCompra>");
				print("<detalleResumen></detalleResumen>");
				/*print("<row id='".$TipoAjuste['id']."' style='$style'>");
					print("<cell><![CDATA[".stripslashes($TipoAjuste['sCodigo'])."]]></cell>");
					print("<cell><![CDATA[".stripslashes($TipoAjuste['sDescripcion'])."]]></cell>");
					print("<cell><![CDATA[".stripslashes($TipoAjuste['fPorcentajeRetencion'])."]]></cell>");
					print("<cell><![CDATA[".stripslashes($TipoAjuste['fImporteMinimoRetencion'])."]]></cell>");					
					print("<cell><![CDATA[".stripslashes($TipoAjuste['sEstadoRetencion'])."]]></cell>");
				print("</row>");
				*/
				//die();			
			}
		}
		
	}


if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
 		header("Content-type: application/xhtml+xml"); } else {
 		header("Content-type: text/xml");
}
echo("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n");
?>

<!-- start grid xml -->
<rows id="0">
	
<?php 
	get_rows_from_DB(0);
?>

</rows>
<!-- close grid xml -->