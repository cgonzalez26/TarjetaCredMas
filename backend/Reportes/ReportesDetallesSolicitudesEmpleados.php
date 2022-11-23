<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
	
	include_once( CLASSES_DIR . '/_table.class.php' );
	
	include_once( CLASSES_DIR . '/_buttons.class.php' );
	
	//session_start();
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$configure = array();

	$configure = getParametrosBasicos(1);



	
	
	#botonera
	
	$buttons = new _buttons_('R');	
	
	$buttons->add_button('href','javascript:printReportesDetallesSolicitudesEmpleados();','imprimir','print');
	
	$buttons->add_button('href','ReportesSolicitudesEmpleados.php','regresar','back');

	$buttons->set_width('720px;');
	
	$botonera = $buttons->get_buttons();
	
	$configure['buttons'] = $botonera ;

	
	#$oXajax=new xajax();
		
	#$oXajax->register( XAJAX_FUNCTION ,"reporteSolicitudesEmpleados");

	#$oXajax->processRequest();
	
	#$oXajax->printJavascript("../includes/xajax/");
	
	###################################################################################################################
	#seteo datos de filtro
	#creo conexion con base de datos de Accesos de sistemas, para obtener datos del empleado
	//$mysql_accesos = $mysql;
	//$mysql_accesos = new MySql();
	//$mysql_accesos->setServer('192.168.2.6','griva','griva');
	//$mysql_accesos->setDBName('AccesosSistemas');	

	$idempleado = intval(_decode($_GET['_i']));
	
	$sub_query = " WHERE Empleados.id = {$idempleado}";
	
	$empleado = $oMysql->consultaSel("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");
	
	//$mysql_accesos->disconnect();
	
	if(!$empleado){
		
	}else{
		$empleado = array_shift($empleado);
	}	
	
	
	$conditions = array();
	
	$dFechaDesde = session_get_var('rse_dFechaDesde');
	$dFechaHasta = session_get_var('rse_dFechaHasta');
	
	if($dFechaDesde != ""){
		$conditions[] = "UNIX_TIMESTAMP(SolicitudesUsuarios.dFechaSolicitud) >= UNIX_TIMESTAMP('".dateToMySql($dFechaDesde)."')";
	}
	
	if($dFechaHasta != ""){
		$conditions[] = "UNIX_TIMESTAMP(SolicitudesUsuarios.dFechaSolicitud) <= UNIX_TIMESTAMP('".dateToMySql($dFechaHasta)."')";
	}	
	
	$conditions[] = "SolicitudesUsuarios.idCargador = '$idempleado'";
	
	
	$table = new _table_('SolicitudesUsuarios');
	
	//$table->set_table_num_field_order(2);
	
	if(isset($_GET['field_order'])){
		$table->set_table_num_field_order($_GET['field_order']);
		//session_add_var('pagging_users',0);//reset to pagging
	}
	
	if($_GET['type_order']){
		$table->set_table_type_order($_GET['type_order']);
		//session_add_var('pagging_users',0);//reset to pagging
	}else{
		$table->set_table_type_order('DESC');
	}

	$table->set_table_headers('Nro.,Presentacion,Usuario,Documento,Estado');
	
	$table->set_table_fields_orders("SolicitudesUsuarios.sNumero,SolicitudesUsuarios.dFechaSolicitud,InformesPersonales.sApellido");

	$table->set_table_number_operations(0);
	
	$table->set_table_width(720);

	$table->set_table_enable_pagging(false);
	
	$table->set_table_name_pagging('pagging_rdse');
	
	$table->set_table_store("usp_getSolicitudes");
	
	$table->set_object_to_count('SQL_count');
	
	$table->set_table_template_rows('ReportesDetallesSolicitudesEmpleados');
	
	//$table->set_add_datos_to_array('usuarios');

	if(sizeof($conditions) > 0) $table->set_table_sconditions(implode(" AND ",$conditions));

	else $table->set_table_sconditions( '1=1' );

	//$table->set_table_url_form( '' );

	//$table->set_table_comment( $table_comment );		
	
	$table->set_table_orders( 'SolicitudesUsuarios.dFechaSolicitud' );

	//$table->set_table_label("");

	//$table->set_table_view_record_found(true);
	
	//var_export($table->print_table());die();

	$tableHTML = $table->print_table();
	
	$headReporte = "
	<center>
		<div style='width:720px;'>
		  	<p style='text-align:left;'>Usuario: <strong>{$empleado['sApellido']},{$empleado['sNombre']} ({$empleado['sLogin']})</strong></p>
		  	<p style='text-align:left;'>REGION: <strong>{$empleado['sNombreRegion']}</strong></p>
		  	<p style='text-align:left;'>SUCURSAL: <strong>{$empleado['sSucursal']}</strong></p>
		  	<p style='text-align:left;'>OFICINA: <strong>{$empleado['sOficina']}</strong></p>
		</div>
	</center>
	<br />
	";
	
	$tableHTML = $headReporte . $tableHTML ;
	
	
	$configure['table'] = $tableHTML ;

	$tableHTML = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Reportes/ReportesDetallesSolicitudesEmpleados.tpl",$configure);	
	

	xhtmlHeaderPaginaGeneral($configure);
	
	echo xhtmlMainHeaderPagina($configure);
	
	echo $tableHTML;

	echo xhtmlFootPagina();

?>