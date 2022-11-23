<?

	function xhtmlFilterReportCar($aDatos){
		global $oMysql;
		
		$array = $aDatos;
		
		$concat = "CONCAT(sCodigo,\":::\", sMarca,\" - \", sModelo)";
		
		$options = $oMysql->consultaSel("CALL usp_getSelect('Vehiculos','id','$concat','')");	
		$array['options'] = arrayToOptions($options,$array['idVehiculo']);
		
		$array['ImgBuscar'] = "<img src='".IMAGES_DIR."/search.png' align='middle' title='Filtrar' hspace='4' border='0'>";
		
		return parserTemplate( TEMPLATES_XHTML_DIR . "/searchForms/ReportesMoviles.tpl", ($array == null) ? false : $array );		
	}


	function xhtmlFilterReportExitWithMobile($aDatos){
		global $oMysql;
		
		$array = $aDatos;
		
		$concat = "CONCAT(sCodigo,\" ::: \", sMarca,\" - \",sModelo)";
		
		$options = $oMysql->consultaSel("CALL usp_getSelect('Vehiculos','id','$concat','')");	
		$array['options'] = arrayToOptions($options,$array['idVehiculo']);
		
		$array['ImgBuscar'] = "<img src='".IMAGES_DIR."/search.png' align='middle' title='Filtrar' hspace='4' border='0'>";
		
		return parserTemplate( TEMPLATES_XHTML_DIR . "/searchForms/ReportesEgresosPorMovil.tpl", ($array == null) ? false : $array );		
	}
	
	function xhtmlFilterReportIncomeByMobile($aDatos){
		global $oMysql;
		
		$array = $aDatos;
		
		$concat = "CONCAT(sCodigo,\" ::: \", sMarca,\" - \",sModelo)";
		
		$options = $oMysql->consultaSel("CALL usp_getSelect('Vehiculos','id','$concat','')");	
		$array['options'] = arrayToOptions($options,$array['idVehiculo']);
		
		$array['ImgBuscar'] = "<img src='".IMAGES_DIR."/search.png' align='middle' title='Filtrar' hspace='4' border='0'>";
		
		return parserTemplate( TEMPLATES_XHTML_DIR . "/searchForms/ReportesGananciasPorMoviles.tpl", ($array == null) ? false : $array );				
	}
	
	function xhtmlFilterReportIncomeAllMobile($aDatos){
		global $oMysql;
		
		$array = $aDatos;
		
		$concat = "CONCAT(sCodigo,\" ::: \", sMarca,\" - \",sModelo)";
		
		//$options = $oMysql->consultaSel("CALL usp_getSelect('Vehiculos','id','$concat','')");	
		//$array['options'] = arrayToOptions($options,$array['idVehiculo']);
		
		$array['ImgBuscar'] = "<img src='".IMAGES_DIR."/search.png' align='middle' title='Filtrar' hspace='4' border='0'>";
		
		return parserTemplate( TEMPLATES_XHTML_DIR . "/searchForms/ReportesGananciasTotalesMoviles.tpl", ($array == null) ? false : $array );
	}

	
	function xhtmlFilterIncomeByMobileByMonth($aDatos){
		global $oMysql;
		
		$array = $aDatos;		
		$options = $oMysql->consultaSel("CALL usp_getSelect('Zonas','id','sNombre','')");	
		$array['zonas'] = arrayToOptions($options,$array['idZona']);
				
		$array['ImgBuscar'] = "<img src='".IMAGES_DIR."/search.png' align='middle' title='Filtrar' hspace='4' border='0'>";
		
		return parserTemplate( TEMPLATES_XHTML_DIR . "/searchForms/ReportesGananciasPorMovilesMensuales.tpl", ($array == null) ? false : $array );				
	}	
?>
