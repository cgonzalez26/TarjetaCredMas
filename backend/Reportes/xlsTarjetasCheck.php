<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
	
	//var_export("dsdssd");die();
	
	global $oMysql;
	
	$nomExcel = 'xlsTarjetasCheck_'. date('d-m-Y') ;
	
	header("Content-Type: application/vnd.ms-excel"); 
	header( 'Content-Disposition: attachment; filename="'.$nomExcel.'.xls"' );
	header('Cache-Control: private, must-revalidate'); 
	header('Pragma: private'); // allow private caching 
	
	$excel=new ExcelWriter();
	
	echo $excel->GetHeader();


	//if($_GET['cmd_search']){
		
		$conditions = array();
		
		$conditions[] = "Empleados.sEstado='A'";
		
		if($_GET['idRegion'] != 0){
			$conditions[] = "Regiones.id = {$_GET['idRegion']}";
		}
		
		if($_GET['idSucursal'] != 0){
			$conditions[] = "Sucursales.id = {$_GET['idSucursal']}";
		}
		
		if($_GET['idOficina'] != 0){
			$conditions[] = "Oficinas.id = {$_GET['idOficina']}";
		}
		
		$sub_query = " WHERE " . implode(" AND ",$conditions) . " ORDER BY Empleados.sApellido ASC ";
		
		$empleados = $oMysql->consultaSel("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");
		//var_export("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");die();
	
		#seteo array para condiones de fecha de solicitud			
		$conditions = array();
		
		//$conditions[] = "Tarjetas.idTipoEstadoTarjeta = '5'";
		
		$conditions[] = "Cupones.sEstado <> 'A'";
		//var_export($_GET);die();
		if($_GET['dFechaDesde'] != ""){
			$conditions[] = "UNIX_TIMESTAMP(Cupones.dFechaConsumo) >= UNIX_TIMESTAMP('".dateToMySql($_GET['dFechaDesde'])."')";
		}
		
		if($_GET['dFechaHasta'] != ""){
			$conditions[] = "UNIX_TIMESTAMP(Cupones.dFechaConsumo) <= UNIX_TIMESTAMP('".dateToMySql($_GET['dFechaHasta'])."')";
		}
		
		$part_sub_query = (sizeof($conditions) > 0) ? implode(" AND ",$conditions) : " 1=1 ";
		
		
		echo "<tr>";
		echo "<td width=120><b>NroCupon</b></td>";
		echo "<td width=180><b>idEmpleado</b></td>";
		echo "<td width=150><b>idCuenta</b></td>";
		echo "<td width=110><b>NroCuenta</b></td>";
		echo "<td width=80><b>DNI Titular</b></td>";
		echo "<td width=80><b>Titular</b></td>";
		echo "<td width=150><b>Empleado</b></td>";
		echo "</tr>";
		
		$consumos_seleccionados = $_GET['chk'];
		
		
		if(!$empleados){
				echo "<tr>";
				echo "<td class=xl24 style='border: solid 1px #000;' colspan='5'> - no registros </td>";
				echo "</tr>";
		}else{			
			//var_export(sizeof($empleados));die();
			foreach ($empleados as $empleado){
				
				$sub_query = " WHERE Cupones.idEmpleado = '{$empleado['id']}' AND $part_sub_query" ;
				
				$cupones = $oMysql->consultaSel("CALL usp_getCupones(\"$sub_query\");");
				//var_export($empleados);die();
				if(!$cupones){
					
				}else{
					foreach ($cupones as $consumo) {
						
						if(in_array($consumo['sNumeroCupon'],$consumos_seleccionados)){
							echo "<tr>";
							echo "<td class=xl24 style='border: solid 1px #000; '> {$consumo['sNumeroCupon']}</td>";
							echo "<td class=xl24 style='border: solid 1px #000; '> {$empleado['id']} </td>";
							echo "<td class=xl24 style='border: solid 1px #000; '> {$consumo['idCuentaUsuario']} </td>";
							echo "<td class=xl24 style='border: solid 1px #000; '> {$consumo['sNumeroCuenta']} </td>";
							echo "<td class=xl24 style='border: solid 1px #000; '> {$consumo['sDniUsuario']} </td>";
							echo "<td class=xl24 style='border: solid 1px #000; '> {$consumo['sApellidoUsuario']}, {$consumo['sNombreUsuario']} </td>";
							echo "<td class=xl24 style='border: solid 1px #000; '> {$empleado['sApellido']},{$empleado['sNombre']} </td>";
							echo "</tr>";													
						}
						

					}
				}

			}
	

		}

		//$HTML = convertir_especiales_html($HTML);
		
	/*}else{
		echo "<tr>";
		echo "<td><b>ERROR AL EXPORTAR</b></td>";
		echo "</tr>";		
	}*/

	echo $excel->GetFooter();

	exit();	
?>				