<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
		
	
	
	$nomExcel = 'xlsDirecciones_'. date('d-m-Y') ;
	
	header("Content-Type: application/vnd.ms-excel"); 
	header( 'Content-Disposition: attachment; filename="'.$nomExcel.'.xls"' );
	header('Cache-Control: private, must-revalidate'); 
	header('Pragma: private'); // allow private caching 
	
	$excel=new ExcelWriter();
	
	echo $excel->GetHeader();
		
	$aParametros = array();
		
	$idGrupoAfinidadImpresion = 0;
	$dPeriodoImpresion = '';
	$idRegionImpresion = 0;
	$idSucursalImpresion = 0;
	
	$idGrupoAfinidadImpresion = $_SESSION['idGrupoAfinidadImpresion'];
	$dPeriodoImpresion = $_SESSION['dPeriodoImpresion'];	
	$idRegionImpresion = $_SESSION['idRegionImpresion'];	
	$idSucursalImpresion = $_SESSION['idSucursalImpresion'];	
	
	
	$sWhere = "";
	$aCond=Array();
	
	
	$CampoOrdenPre = 'CuentasUsuarios.dFechaRegistro'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	
	if($idGrupoAfinidadImpresion){$aCond[]=" CuentasUsuarios.idGrupoAfinidad= '".$idGrupoAfinidadImpresion."' ";}
	
	if($dPeriodoImpresion)
	{	
		$CuentasDelPeriodo = $oMysql->consultaSel("SELECT CuentasUsuarios.id FROM CuentasUsuarios LEFT JOIN DetallesCuentasUsuarios ON DetallesCuentasUsuarios.idCuentaUsuario=CuentasUsuarios.id 
				WHERE DetallesCuentasUsuarios.dPeriodo ='{$dPeriodoImpresion}' AND DetallesCuentasUsuarios.iEmiteResumen=1");		
		
		$sCuentas = implode(",",$CuentasDelPeriodo);
		$aCond[]=" CuentasUsuarios.id IN ({$sCuentas})";
	}
	
	if($idRegionImpresion)
	{
		$aEmpleados = $oMysql->consultaSel("SELECT Empleados.id FROM Empleados 
			LEFT JOIN Oficinas ON Oficinas.id= Empleados.idOficina LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal LEFT JOIN Regiones ON Regiones.id=Sucursales.idRegion
			WHERE Regiones.id = {$idRegionImpresion} ORDER BY Empleados.id DESC");
		$sEmpleadosRegion = implode(",",$aEmpleados);
		$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosRegion})";
	}
	
	if($idSucursalImpresion)
	{
		$aEmpleados = $oMysql->consultaSel("SELECT Empleados.id FROM Empleados 
			LEFT JOIN Oficinas ON Oficinas.id= Empleados.idOficina LEFT JOIN Sucursales ON Sucursales.id = Oficinas.idSucursal 
			WHERE Sucursales.id = {$idSucursalImpresion} ORDER BY Empleados.id DESC");
		$sEmpleadosSucursal = implode(",",$aEmpleados);
		$aCond[]=" CuentasUsuarios.idEmpleado IN ({$sEmpleadosSucursal})";
	}
	
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrdenPre $TipoOrdenPre";
	$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondiciones\");";

	//echo $sqlDatos;
	
	$result = $oMysql->consultaSel($sqlDatos);

	
	echo "<tr>";
	echo "<td width=120><b>Nro. de Cuenta</b></td>";
	echo "<td width=180><b>Apellido y Nombre</b></td>";
	echo "<td width=110><b>DNI</b></td>";
	echo "<td width=80><b>Domicilio</b></td>";	
	echo "</tr>";
		
	foreach ($result as $rs)
	{			
		//echo "entro";
		//$sNumeroCuenta = $oMysql->consultaSel("SELECT sNumeroCuenta FROM CuentasUsuarios WHERE id={$idCuentaUsuario}",true);
		
		$aPeriodo = explode("-",$dPeriodoImpresion);
		$dPeriodoFormat = $aPeriodo[1]."-".$aPeriodo[0];
		//$archivo = "../includes/Files/Datos/DR_".$idGrupoAfinidad."_".$idCuentaUsuario."_".$dPeriodoFormat.".xml"; 
		$archivo = "../includes/Files/Datos/DR_2_10_09-2011.xml";
		
		$sTitular = $rs['sApellido'].', '.$rs['sNombre'];
		
		$sDomicilio = "Calle:".$rs['sCalle'].", Nro:".$rs['sNumeroCalle'];
			
			if(($rs['sBlock'] != "") && ($rs['sBlock'] != "0")) 
				$sDomicilio .= ", Block: ".$rs['sBlock'];
			
			if(($rs['sPiso'] != "") && ($rs['sPiso'] != "0"))
				 $sDomicilio .= ", Piso:".$rs['sPiso'];
			
			if(($rs['sDepartamento'] != "") && ($rs['sDepartamento'] != "0"))
				 $sDomicilio .= ", Dpto:".$rs['sDepartamento'];			
			
			if($rs['sBarrio'] != "") 
				$sDomicilio .= ", Barrio:".$rs['sBarrio'];	

			if($rs['sManzana'] != "") 
				$sDomicilio .= ", Mza: ".$rs['sManzana'];
			
			if($rs['sLote'] != "") 
				$sDomicilio .= ", Lote: ".$rs['sLote'];
			
			$sDomicilio .= "<br>".$rs['sProvincia'].", ".$rs['sLocalidad'].", ".$rs['sCodigoPostal'];
			$sDomicilio = convertir_especiales_html($sDomicilio);

		
		echo "<tr>";				
		echo "<td class=xl24 style='border: solid 1px #000; '> {$rs['sNumeroCuenta']}</td>";
		echo "<td class=xl24 style='border: solid 1px #000; '> {$sTitular} </td>";
		echo "<td class=xl24 style='border: solid 1px #000; '> {$rs['sDocumento']} </td>";
		echo "<td class=xl24 style='border: solid 1px #000; '> {$sDomicilio} </td>";
	}
	
	echo $excel->GetFooter();

	exit();	

?>