<?

	function numProducts($idTipoProducto){
		global $oMysql;
		
		$count = $oMysql->consultaSel("SELECT IFNULL(COUNT(id),0) FROM Productos WHERE idTipoProducto = '$idTipoProducto'",true);
		
		if($count == false) $count = 0;
		
		return $count;		
	}
	
	function numFacturas($idProducto){
		global $oMysql;
		
		$count = $oMysql->consultaSel("SELECT IFNULL(COUNT(id),0) FROM DetallesFacturas WHERE idProducto = '$idProducto'",true);
		
		if($count == false) $count = 0;
		
		return $count;		
	}
	
	function numTypesProducts($idRubro){
		global $oMysql;
		
		$count = $oMysql->consultaSel("SELECT IFNULL(COUNT(id),0) FROM TiposProductos WHERE idRubro = '$idRubro'",true);
		
		if($count == false) $count = 0;
		
		return $count;		
	}
	
	function numFacturasByCustomer($idCustomer){
		global $oMysql;
		
		$count = $oMysql->consultaSel("SELECT IFNULL(COUNT(id),0) FROM Facturas WHERE idCliente = '$idCustomer'",true);
		
		if($count == false) $count = 0;
		
		return $count;		
	}	
	
	function numRepuestos($idRepuesto){
		global $oMysql;
		
		$count = $oMysql->consultaSel("SELECT IFNULL(COUNT(id),0) FROM RepuestosServicios WHERE idRepuesto = '$idRepuesto'",true);
		
		if($count == false) $count = 0;
		
		return $count;		
	}
	function numZonas($idZona){
		global $oMysql;
		
		$count = $oMysql->consultaSel("SELECT IFNULL(COUNT(id),0) FROM Vehiculos WHERE idZona = '$idZona'",true);
		
		if($count == false) $count = 0;
		
		return $count;		
	}
	
	function numCuentas($idCuenta){
		
		global $oMysql;
		
		$count = $oMysql->consultaSel("SELECT IFNULL(COUNT(id),0) FROM CuentasSubCuentasTesoreria WHERE idCuenta = '$idCuenta'",true);
		
		if($count == false) $count = 0;
		
		return $count;		
	}
	
	function numSubCuentas($idSubCuenta){
		
		global $oMysql;
		
		$count = $oMysql->consultaSel("SELECT IFNULL(COUNT(id),0) FROM CuentasSubCuentasTesoreria WHERE idSubCuenta = '$idSubCuenta'",true);
		
		if($count == false) $count = 0;
		
		return $count;		
	}
?>