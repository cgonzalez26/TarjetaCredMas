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
	
	$cmd_search 	= session_get_var('rse_search');
	$idRegion 		= session_get_var('rse_idRegion');
	$idSucursal 	= session_get_var('rse_idSucursal');
	$idOficina 		= session_get_var('rse_idOficina');
	$dFechaDesde 	= session_get_var('rse_dFechaDesde');
	$dFechaHasta 	= session_get_var('rse_dFechaHasta');

		if($cmd_search){
			
			$conditions = array();
			
			//$conditions[] = "Empleados.sEstado='A'";
			
			if($idRegion){
				$conditions[] = "Regiones.id = {$idRegion}";				
			}
			
			if($idSucursal){
				$conditions[] = "Sucursales.id = {$idSucursal}";				
			}
			
			if($idOficina){
				$conditions[] = "Oficinas.id = {$idOficina}";
			}
			
			//var_export($conditions);die();
			if(sizeof($conditions) == 0){
				$conditions[] = "1=1";
			}
			
			$sub_query = " WHERE " . implode(" AND ",$conditions) . " ORDER BY Empleados.sApellido ASC ";
						
			$empleados = $oMysql->consultaSel("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");
			//$empleados = $mysql_accesos->query("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");
			//var_export("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");die();
			//$mysql_accesos->disconnect();
			
			#seteo array para condiones de fecha de solicitud			
			$conditions = array();
			
			if($dFechaDesde != ""){
				$conditions[] = "UNIX_TIMESTAMP(SolicitudesUsuarios.dFechaSolicitud) >= UNIX_TIMESTAMP('".dateToMySql($dFechaDesde)."')";
				$configure['dFechaDesde'] = $dFechaDesde;
			}
			
			if($dFechaHasta != ""){
				$conditions[] = "UNIX_TIMESTAMP(SolicitudesUsuarios.dFechaSolicitud) <= UNIX_TIMESTAMP('".dateToMySql($dFechaHasta)."')";
				$configure['dFechaHasta'] = $dFechaHasta;
			}
			
			$part_sub_query = (sizeof($conditions) > 0) ? implode(" AND ",$conditions) : " 1=1 ";
			
			$HTML = "<table id='table_object' class='table_object' width='720' cellspacing='0' cellpadding='0' align='center'>";
			$HTML .= "<thead>";
			$HTML .= "<tr>";
				$HTML .= "<th>Region</th>";
				$HTML .= "<th>Sucursal</th>";
				$HTML .= "<th>Oficina</th>";
				$HTML .= "<th>Empleado</th>";
				$HTML .= "<th>Solicitudes</th>";
			$HTML .= "</tr>";
			$HTML .= "</thead>";
			
			$HTML .= "<tbody>";			
			//var_export($empleados);die();
			if(!$empleados){
					$HTML .= "<tr>";
						$HTML .= "<td colspan='5' align='left'> - nose encontraron resultados </td>";
					$HTML .= "</tr>";
			}else{
				$total_solicitudes = 0;
				foreach ($empleados as $empleado){
					
					
					
					//$conditions[] = "SolicitudesUsuarios.idCargador = '{$empleado['id']}'";
					
					$sub_query = " WHERE SolicitudesUsuarios.idCargador = '{$empleado['id']}' AND $part_sub_query" ;
					//var_export("CALL usp_getCantidadSolicitudesEmpleados(\"$sub_query\");");die();
					$cantidad_solicitudes = $oMysql->consultaSel("CALL usp_getCantidadSolicitudesEmpleados(\"$sub_query\");",true);
					
					if($cantidad_solicitudes > 0){
						$HTML .= "<tr>";
							$HTML .= "<td align='center'>{$empleado['sNombreRegion']}</td>";
							$HTML .= "<td align='left'>{$empleado['sSucursal']}</td>";
							$HTML .= "<td align='left'>{$empleado['sOficina']}</td>";
							$HTML .= "<td align='left'>{$empleado['sApellido']}, {$empleado['sNombre']}</td>";
							$HTML .= "<td class='column_operations_right_data'><a href='ReportesDetallesSolicitudesEmpleados.php?_i="._encode($empleado['id'])."'>$cantidad_solicitudes</a></td>";
						$HTML .= "</tr>";						
					}

					$total_solicitudes = $total_solicitudes + $cantidad_solicitudes;
				}

					$HTML .= "<tr>";
						$HTML .= "<td align='right' colspan='4'>TOTAL</td>";
						$HTML .= "<td class='column_operations_right' align='right'><strong>$total_solicitudes</strong></td>";
					$HTML .= "</tr>";							
			}

			
			$HTML .= "</tbody>";
			
			$HTML .= "</table>";
			
			//$HTML = _parserCharacters_($HTML);
			$HTML = convertir_especiales_html($HTML);
			
			$buttons = new _buttons_('R');	
			
			$buttons->add_button('href','javascript:printReporteSolicitudEmpleado();','imprimir','print');
		
			$buttons->set_width('720px;');
			
			$botonera = $buttons->get_buttons();
			
			$configure['table'] = $HTML;
			
			$configure['buttons'] = $botonera;
			

			
			
		}else{
			$configure['table'] = '';
			$configure['buttons'] = '';
			session_add_var('rse_search',0);
		}

	
	
	#botonera
	
	$buttons = new _buttons_('R');	
	
	$buttons->add_button('href','javascript:void(0);','imprimir','new');

	$buttons->set_width('800px;');
	
	
	
	//$searchHTML = parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorReportesSolicitudesEmpleados.tpl",$configure);	
	
	//$configure['search_form'] = $searchHTML;
	
	$oXajax=new xajax();
	$oXajax->setCharEncoding('ISO-8859-1');
	$oXajax->configure('decodeUTF8Input',true);	
	$oXajax->register( XAJAX_FUNCTION ,"reporteSolicitudesEmpleados");

	$oXajax->processRequest();
	
	$oXajax->printJavascript("../includes/xajax/");	
	
	###################################################################################################################
	#seteo datos de filtro
	#creo conexion con base de datos de Accesos de sistemas, para obtener datos del empleado
	/*$mysql_accesos = new MySql();
	$mysql_accesos->setServer('192.168.2.6','griva','griva');
	$mysql_accesos->setDBName('AccesosSistemas');*/

	
	$configure['options_regiones']		=	$oMysql->getListaOpciones( 'Regiones', 'id', 'sNombre',$idRegion);
	$configure['options_sucursales']	=	$oMysql->getListaOpcionesCondicionado( 'idRegion', 'idSucursal', 'Sucursales', 'Sucursales.id', 'Sucursales.sNombre', 'idRegion','Sucursales.sEstado = \'A\'', '',$idSucursal);
	$configure['options_oficinas']		=	$oMysql->getListaOpcionesCondicionado( 'idSucursal', 'idOficina','Oficinas', 'Oficinas.id','Oficinas.sApodo','idSucursal','Oficinas.sEstado = \'A\'', '',$idOficina);
	
	/*$sub_query = " WHERE Empleados.id = {$_SESSION['id_user']}";
	//$sub_query = " WHERE Empleados.id = 606";
	$user_online = $mysql_accesos->query("CALL usp_getEmpleados(\"$sub_query\");");*/
	
	//$mysql_accesos->disconnect();

	$tableHTML = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Reportes/ReportesSolicitudesEmpleados.tpl",$configure);	
	
	$configure['IMAGES_DIR'] = IMAGES_DIR;
	

	xhtmlHeaderPaginaGeneral($configure);
	
	echo xhtmlMainHeaderPagina($configure);
	
	echo $tableHTML;

	echo xhtmlFootPagina();

?>