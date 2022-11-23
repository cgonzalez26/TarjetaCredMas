<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
	
	include_once( CLASSES_DIR . '/_table.class.php' );
	
	include_once( CLASSES_DIR . '/_buttons.class.php' );
	
	//session_start();
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$configure = array();
	$conditions = array();

	$configure = getParametrosBasicos(1);


	###
	if(!session_get_var('pagging_ac')){ session_add_var('pagging_ac',0); }	
	
	$pagging = (isset($_GET['p'])) ? $_GET['p'] : session_get_var('pagging_ac') ;
	
	session_add_var('pagging_ac',$pagging);

	//$conditions[] = "usuarios.iEstado <> $estado_eliminado";
	
	//$datos = $_POST;
	
	$idTipoAjuste = 0;
	
	if($_POST['cmd_search']){
		
		if($_POST['sNumeroComercio'] != ""){
			$conditions[] = "Comercios.sNumero = '{$_POST['sNumeroComercio']}'";	
		}
		
		if($_POST['sNombreFantasia'] != ""){
			$conditions[] = "Comercios.sNombreFantasia LIKE '%{$_POST['sNombreFantasia']}%'";	
		}
		
		if($_POST['sRazonSocial'] != ""){
			$conditions[] = "Comercios.sRazonSocial LIKE '%{$_POST['sRazonSocial']}'%";	
		}
		
		
		if($_POST['idTipoAjuste'] != 0 && $_POST['idTipoAjuste'] != ""){
			$conditions[] = "TiposAjustes.idTipoUsuario = '{$_POST['idTipoAjuste']}'";
		}
		
		if($_POST['dFechaDesde'] != "" && $datos['dFechaDesde'] != "__/__/____"){			
			$conditions[] = "AjustesComercios.dFecha >= '".dateToMySql($_POST['dFechaDesde'])."'";
		}
		
		if($_POST['dFechaHasta'] != "" && $_POST['dFechaDesde'] != "__/__/____"){
			$conditions[] = "AjustesComercios.dFecha <= '".dateToMySql($_POST['dFechaHasta'])."'";
		}		

		session_add_var('ac_numero',$_POST['sNumeroComercio']);
		session_add_var('ac_nombre_fantasia',$_POST['sNombreFantasia']);
		session_add_var('ac_razon_social',$_POST['sRazonSocial']);
		session_add_var('ac_tipo_ajuste',$_POST['idTipoAjuste']);
		session_add_var('ac_fecha_desde',$_POST['dFechaDesde']);
		session_add_var('ac_fecha_hasta',$_POST['dFechaHasta']);
		
		session_add_var('pagging_ac',0);//reset to pagging
		
		$configure['sNumeroComercio'] 	= $_POST['sNumeroComercio'];
		$configure['sNombreFantasia'] 	= $_POST['sNombreFantasia'];
		$configure['sRazonSocial'] 		= $_POST['sRazonSocial'];
		$idtipoajuste  					= $_POST['idTipoUsuario'];
		$configure['dFechaDesde'] 		= $_POST['dFechaDesde'];
		$configure['dFechaHasta'] 		= $_POST['dFechaHasta'];
		
		//var_export($conditions);die();
		
	}else{

		$sNumero 		 = session_get_var('ac_numero');
		$sNombreFantasia = session_get_var('ac_nombre_fantasia');
		$sRazonSocial    = session_get_var('ac_razon_social');
		$idtipoajuste	 = session_get_var('ac_tipo_ajuste');
		$fecha_desde	 = session_get_var('ac_fecha_desde');
		$fecha_hasta	 = session_get_var('ac_fecha_hasta');
		
		if($sNumero != ""){
			$conditions[] = "Comercios.sNumero = '$sNumero'";	
		}
		
		if($sNombreFantasia != ""){
			$conditions[] = "Comercios.sNombreFantasia LIKE '%$sNombreFantasia%'";	
		}
		
		if($sRazonSocial != ""){
			$conditions[] = "Comercios.sRazonSocial LIKE '%$sRazonSocial%'";	
		}
		
		
		if($idtipoajuste != 0 && $idtipoajuste != ""){
			$conditions[] = "TiposAjustes.idTipoUsuario = '$idtipoajuste'";
		}
		
		if($fecha_desde != "" && $fecha_desde != "__/__/____"){			
			$conditions[] = "AjustesComercios.dFecha >= '".dateToMySql($fecha_desde)."'";
		}
		
		if($fecha_hasta != "" && $fecha_hasta != "__/__/____"){
			$conditions[] = "AjustesComercios.dFecha <= '".dateToMySql($fecha_hasta)."'";
		}
		
		$configure['sNumeroComercio'] 	= $sNumero;
		$configure['sNombreFantasia'] 	= $sNombreFantasia;
		$configure['sRazonSocial'] 		= $sRazonSocial;
		
		$configure['dFechaDesde'] 		= $fecha_desde;
		$configure['dFechaHasta'] 		= $fecha_hasta;		
	}
	
	
	//$sCondiciones= " WHERE ".implode(' AND ',$conditions)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	//$sCondiciones_sLim=" WHERE ".implode(' AND ',$conditions)."  ORDER BY $CampoOrden $TipoOrden";
	
	//$sqlDatos="Call usp_getAjustesComercios(\"$sCondiciones\");";
	//$sqlDatos_sLim="Call usp_getAjustesUsuarios(\"$sCondiciones_sLim\");";
	
	$configure['options_tipos_ajustes'] = $oMysql->getListaOpciones( 'TiposAjustes', 'id', 'sNombre',$idtipoajuste,"TiposAjustes.sDestino='CO' AND TiposAjustes.sEstadoAjuste='A'");
	
	
	$table = new _table_('AjustesComercios');
	
	if(isset($_GET['field_order'])){
		$table->set_table_num_field_order(intval($_GET['field_order']));
		//session_add_var('pagging_users',0);//reset to pagging
	}
	
	if(isset($_GET['type_order'])){
		$table->set_table_type_order($_GET['type_order']);
		//session_add_var('pagging_users',0);//reset to pagging
	}

	$table->set_table_headers('Nro. ,Comercio,Ajuste,Fecha,Importe,Cuotas');
	
	$table->set_table_fields_orders("Comercios.sNumero,Comercios.sNombreFantasia,TiposAjustes.sNombre,AjustesComercios.fTotalFinal,AjustesComercios.iCuotas");

	$table->set_table_number_operations(3);
	
	$table->set_table_width(800);

	$table->set_table_enable_pagging(true);
	
	$table->set_table_name_pagging('pagging_ac');
	
	$table->set_object_to_count('store_count_ajustescomercios');
	
	//$table->set_table_template_rows('');
	
	//$table->set_add_datos_to_array('');
	
	if(sizeof($conditions) > 0) $table->set_table_sconditions(implode(" AND ",$conditions));

	else $table->set_table_sconditions( '1=-1' );

	//$table->set_table_url_form( '' );

	//$table->set_table_comment( $table_comment );	

	$table->set_table_orders( 'Comercios.sNombreFantasia' );

	//$table->set_table_label("");

	//$table->set_table_view_record_found(true);

	$tableHTML = $table->print_table();	
	
	
	#botonera
	
	$buttons = new _buttons_('R');	
	
	$buttons->add_button('href','AdminAjustesComercios.php','agregar ajuste comercio','new');
	
	//$buttons->add_button('href','javascript:void(0);','imprimir','print');

	$buttons->set_width('800px;');

	

	xhtmlHeaderPaginaGeneral($configure);
	
	echo xhtmlMainHeaderPagina($configure);
	
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorAjustesComercios.tpl",$configure);	
	
	echo  $buttons->get_buttons();

	echo $tableHTML;

	echo xhtmlFootPagina();

?>