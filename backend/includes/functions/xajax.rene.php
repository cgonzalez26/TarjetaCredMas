<?php
#function k va en el main.functions.php
	function _parserCharacters_($datos){
		$a = array();
		if(is_array($datos)){

			foreach ($datos as $key => $value) { 
				
				if(is_array($value)){
					$a[$key] = _parserCharacters_($value);	
				}else{
					$a[$key] = convertir_especiales_html($value);	
				}
				
			 }
			
			return $a;
		}else{

			$datos = convertir_especiales_html( $datos );
			
			return $datos;

		}
	}
	function sendFormComercio($datos){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$op = _decode($datos['_op']);
		
		//var_export($datos);die();
		
		switch ($op) {
			case "new":
					$comercio= new comercios(0);
					
					$check_datos = comercios::_check_datos($datos,"new");
					
					if($check_datos == ""){

						$comercio->insert($datos);

						if($comercio->get_error_nro_query() == 0){
							
							$oRespuesta->alert("se registro correctamente el comercio");

							$oRespuesta->script(" resetForm();");
							
							//$oRespuesta->redirect("Comercios.php");
							
						}else{
							$oRespuesta->alert("sucedio un error interno al intentar grabar el Comercio.");
						}
					}else{
						$oRespuesta->alert("sucedieron errores en la carga de los datos: \n".$check_datos);
					}
				
				break;
			case "edit":
					$idcomercio = intval(_decode($datos['_i']));
					
					if(!is_null($idcomercio) && is_integer($idcomercio) && $idcomercio != 0){
						
						$comercio= new comercios($idcomercio);
						
						$check_datos = comercios::_check_datos($datos,"edit");
						
						if($check_datos == ""){
	
							$comercio->update($datos);
	
							//if($comercio->get_error_nro_query() == 0){
								
								$oRespuesta->alert("se actualizaron correctamente los datos del comercio");
	
								//$oRespuesta->script(" resetForm();");
								
								//$oRespuesta->redirect("Comercios.php");
								
							//}else{
								//$oRespuesta->alert("sucedio un error interno al intentar actualizar los datos del Comercio.");
							//}
						}else{
							$oRespuesta->alert("sucedieron errores en la carga de los datos: \n".$check_datos);
						}						
						
					}else{
						$oRespuesta->alert("Codigo de Comercio es incorrecto.");
					}
				
				
				break;		
			default:
				#error
				$oRespuesta->alert("Ejecuto una operacion incorrecta");
				break;
		}
		
		return $oRespuesta;
	}
	
	function eliminarComercio($idcomercio){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$idcomercio = intval(_decode($idcomercio));
		
		if(!is_null($idcomercio) && is_integer($idcomercio) && $idcomercio != 0){
			
			$comercio= new comercios($idcomercio);
			
			$check_datos = comercios::_check_erase_($idcomercio);
			
			if($check_datos == ""){
				
				$comercio->delete();
				
				if($comercio->get_error_nro_query() == 0){

					$oRespuesta->alert("se dio de baja el comercio correctamente");

				    $script=" window.location.reload();";

				    $oRespuesta->script($script);
					
				}else{
					$oRespuesta->alert("sucdio un error interno al intentar eliminar comercio.");
				}
			}
			
		}else{
			$oRespuesta->alert("Codigo de Comercio es incorrecto.");
		}

		return $oRespuesta;
	}
	
	function activarComercio($idcomercio){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$idcomercio = intval(_decode($idcomercio));
		
		if(!is_null($idcomercio) && is_integer($idcomercio) && $idcomercio != 0){
			
			$comercio= new comercios($idcomercio);

			$comercio->activar();

			if($comercio->get_error_nro_query() == 0){

				$oRespuesta->alert("se activo el comercio correctamente");

			    $script=" window.location.reload();";

			    $oRespuesta->script($script);
				
			}else{
				$oRespuesta->alert("sucdio un error interno al intentar eliminar comercio.");
			}

		}else{
			$oRespuesta->alert("Codigo de Comercio es incorrecto.");
		}

		return $oRespuesta;
	}	

	#function para convertir a mayusculas
	function _stringUpper_($datos){
		$a = array();
		if(is_array($datos)){

			foreach ($datos as $key => $value) { 
				
				if(is_array($value)){
					$a[$key] = _stringUpper_($value);	
				}else{
					$a[$key] = strtoupper($value);	
				}

			 }

			return $a;
		}else{

			$datos = strtoupper( $datos );

			return $datos;

		}
	}
	
	#funcion k valida cuit
	function _cuitCheck_( $cuit ) {
		    $esCuit=false;
		    $cuit_rearmado="";
		     //separo cualquier caracter que no tenga que ver con numeros
		    for ($i=0; $i < strlen($cuit); $i++) {   
		        if ((Ord(substr($cuit, $i, 1)) >= 48) && (Ord(substr($cuit, $i, 1)) <= 57))     {
		            $cuit_rearmado = $cuit_rearmado . substr($cuit, $i, 1);
		        }
		    }
		    $cuit=$cuit_rearmado;
		    if ( strlen($cuit_rearmado) <> 11) {  // si to estan todos los digitos
		        $esCuit=false;
		    } else {
		        $x=$i=$dv=0;
		        // Multiplico los dígitos.
		        $vec[0] = (substr($cuit, 0, 1)) * 5;
		        $vec[1] = (substr($cuit, 1, 1)) * 4;
		        $vec[2] = (substr($cuit, 2, 1)) * 3;
		        $vec[3] = (substr($cuit, 3, 1)) * 2;
		        $vec[4] = (substr($cuit, 4, 1)) * 7;
		        $vec[5] = (substr($cuit, 5, 1)) * 6;
		        $vec[6] = (substr($cuit, 6, 1)) * 5;
		        $vec[7] = (substr($cuit, 7, 1)) * 4;
		        $vec[8] = (substr($cuit, 8, 1)) * 3;
		        $vec[9] = (substr($cuit, 9, 1)) * 2;
		                    
		        // Suma cada uno de los resultado.
		        for( $i = 0;$i<=9; $i++) {
		            $x += $vec[$i];
		        }
		        $dv = (11 - ($x % 11)) % 11;
		        if ($dv == (substr($cuit, 10, 1)) ) {
		            $esCuit=true;
		        }
		    }
		    return( $esCuit );
	}

	function sendFormTiposPlanes($datos){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$op = _decode($datos['_op']);
		
		//var_export($datos);die();
		
		switch ($op) {
			case "new":
					$tiposplanes= new tiposplanes(0);
					
					$check_datos = tiposplanes::_check_datos($datos,"new");
					
					if($check_datos == ""){

						$tiposplanes->insert($datos);

						if($tiposplanes->get_error_nro_query() == 0){
							
							$oRespuesta->alert("se registro correctamente el tipos planes");

							$oRespuesta->script(" resetForm();");
							
							//$oRespuesta->redirect("Comercios.php");
							
						}else{
							$oRespuesta->alert("sucedio un error interno al intentar grabar el Comercio.");
						}
					}else{
						$oRespuesta->alert("sucedieron errores en la carga de los datos: \n".$check_datos);
					}
				
				break;
			case "edit":
					$idtiposplanes = intval(_decode($datos['_i']));
					
					if(!is_null($idtiposplanes) && is_integer($idtiposplanes) && $idtiposplanes != 0){
						
						$tiposplanes= new tiposplanes($idtiposplanes);
						
						$check_datos = tiposplanes::_check_datos($datos,"edit");
						
						if($check_datos == ""){
	
							$tiposplanes->update($datos);
	
							//if($comercio->get_error_nro_query() == 0){
								
								$oRespuesta->alert("se actualizaron correctamente los datos del tipo de plan");
	
								//$oRespuesta->script(" resetForm();");
								
								//$oRespuesta->redirect("Comercios.php");
								
							//}else{
								//$oRespuesta->alert("sucedio un error interno al intentar actualizar los datos del Comercio.");
							//}
						}else{
							$oRespuesta->alert("sucedieron errores en la carga de los datos: \n".$check_datos);
						}						
						
					}else{
						$oRespuesta->alert("Codigo de Tipo de Plan es incorrecto.");
					}
				
				
				break;		
			default:
				#error
				$oRespuesta->alert("Ejecuto una operacion incorrecta");
				break;
		}
		
		return $oRespuesta;
	}

	function eliminarTiposPlanes($idtiposplanes){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$idtiposplanes = intval(_decode($idtiposplanes));
		
		if(!is_null($idtiposplanes) && is_integer($idtiposplanes) && $idtiposplanes != 0){
			
			$tiposplanes = new tiposplanes($idtiposplanes);
			
			$check_datos = tiposplanes::_check_erase_($idcomercio);
			
			if($check_datos == ""){
				
				$tiposplanes->delete();
				
				if($tiposplanes->get_error_nro_query() == 0){

					$oRespuesta->alert("se dio de baja el tipo de plan correctamente");

				    $script=" window.location.reload();";

				    $oRespuesta->script($script);
					
				}else{
					$oRespuesta->alert("sucedio un error interno al intentar eliminar tipo de plan.");
				}
			}
			
		}else{
			$oRespuesta->alert("Codigo de Tipo Plan es incorrecto.");
		}

		return $oRespuesta;
	}

	function activarTiposPlanes($idtiposplanes){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$idtiposplanes = intval(_decode($idtiposplanes));
		
		if(!is_null($idtiposplanes) && is_integer($idtiposplanes) && $idtiposplanes != 0){
			
			$tiposplanes= new tiposplanes($idtiposplanes);

			$tiposplanes->activar();

			if($tiposplanes->get_error_nro_query() == 0){

				$oRespuesta->alert("se activo el tipo de plan");

			    $script=" window.location.reload();";

			    $oRespuesta->script($script);
				
			}else{
				$oRespuesta->alert("sucedio un error interno al intentar eliminar tipo de plan.");
			}

		}else{
			$oRespuesta->alert("Codigo de Tipo de Plan es incorrecto.");
		}

		return $oRespuesta;
	}

	function sendFormPlanes($datos){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$op = _decode($datos['_op']);
		
		$break = chr(13);
		
		switch ($op) {
			case "new":
					$planes= new planes(0);
					
					$check_datos = planes::_check_datos($datos,"new");

					if($check_datos == ""){

						$datos['idComercio'] = intval(_decode($datos['_ic']));

						$planes->insert($datos);

						if($planes->get_error_nro_query() == 0){

							$oRespuesta->alert("se registro correctamente el PLAN");

							$oRespuesta->script(" resetForm();");

							//$oRespuesta->redirect("Planes.php");
							
						}else{
							$oRespuesta->alert("sucedio un error interno al intentar grabar el PLAN.");
						}
					}else{
						$oRespuesta->alert("sucedieron errores en la carga de los datos: \n".$check_datos);
					}
				
				break;
			case "edit":
					$idplanes = intval(_decode($datos['_i']));
					
					if(!is_null($idplanes) && is_integer($idplanes) && $idplanes != 0){
						
						$planes= new planes($idplanes);
						
						$check_datos = planes::_check_datos($datos,"edit");
						
						$datos['idComercio'] = intval(_decode($datos['_ic']));
						
						if($datos['idComercio'] == 0 && !is_integer($datos['idComercio'])){
							$check_datos .= 'El codigo de Comercio es incorrecto.' . $break;
						}						
						
						if($check_datos == ""){
	
							$planes->update($datos);
	
							//if($comercio->get_error_nro_query() == 0){
								
								$oRespuesta->alert("se actualizaron correctamente los datos del PLAN");
	
								//$oRespuesta->script(" resetForm();");
								
								//$oRespuesta->redirect("Comercios.php");
								
							//}else{
								//$oRespuesta->alert("sucedio un error interno al intentar actualizar los datos del Comercio.");
							//}
						}else{
							$oRespuesta->alert("sucedieron errores en la carga de los datos: \n".$check_datos);
						}						
						
					}else{
						$oRespuesta->alert("Codigo de PLAN es incorrecto.");
					}
				
				
				break;		
			default:
				#error
				$oRespuesta->alert("Ejecuto una operacion incorrecta");
				break;
		}
		
		return $oRespuesta;
	}	

	function eliminarPlanes($idplanes){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$idplanes = intval(_decode($idplanes));
		
		if(!is_null($idplanes) && is_integer($idplanes) && $idplanes != 0){
			
			$planes = new planes($idplanes);
			
			$check_datos = planes::_check_erase_($idplanes);
			
			if($check_datos == ""){
				
				$planes->delete();
				
				if($planes->get_error_nro_query() == 0){

					$oRespuesta->alert("se dio de baja el plan correctamente");

				    $script=" window.location.reload();";

				    $oRespuesta->script($script);
					
				}else{
					$oRespuesta->alert("sucedio un error interno al intentar eliminar PLAN.");
				}
			}
			
		}else{
			$oRespuesta->alert("Codigo de Plan es incorrecto.");
		}

		return $oRespuesta;
	}

	function activarPlanes($idplanes){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$idplanes = intval(_decode($idplanes));
		
		if(!is_null($idplanes) && is_integer($idplanes) && $idplanes != 0){
			
			$planes= new planes($idplanes);

			$planes->activar();

			if($planes->get_error_nro_query() == 0){

				$oRespuesta->alert("se activo el PLAN");

			    $script=" window.location.reload();";

			    $oRespuesta->script($script);
				
			}else{
				$oRespuesta->alert("sucedio un error interno al intentar eliminar PLAN.");
			}

		}else{
			$oRespuesta->alert("Codigo de PLAN es incorrecto.");
		}

		return $oRespuesta;
	}

	function sendFormPromocionesPlanes($datos){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$op = _decode($datos['_op']);
		
		$break = chr(13);
		
		switch ($op) {
			case "new":
					$promociones = new promociones(0);
					
					$check_datos = promociones::_check_datos($datos,"new");

					if($check_datos == ""){

						$datos['idComercio'] = intval(_decode($datos['_ic']));

						$promociones->insert($datos);

						if($promociones->get_error_nro_query() == 0){

							$oRespuesta->alert("se registro correctamente el PLAN");

							$oRespuesta->script(" resetForm();");

							//$oRespuesta->redirect("Planes.php");
							
						}else{
							$oRespuesta->alert("sucedio un error interno al intentar grabar el PLAN.");
						}
					}else{
						$oRespuesta->alert("sucedieron errores en la carga de los datos: \n".$check_datos);
					}
				
				break;
			case "edit":
					$idpromocionesplanes = intval(_decode($datos['_i']));
					
					if(!is_null($idpromocionesplanes) && is_integer($idpromocionesplanes) && $idpromocionesplanes != 0){
						
						$promociones = new promociones($idpromocionesplanes);
						
						$check_datos = promociones::_check_datos($datos,"edit");
						
						$datos['idComercio'] = intval(_decode($datos['_ic']));
						
						if($datos['idComercio'] == 0 && !is_integer($datos['idComercio'])){
							$check_datos .= 'El codigo de Comercio es incorrecto.' . $break;
						}						
						
						if($check_datos == ""){
	
							$promociones->update($datos);
	
							//if($comercio->get_error_nro_query() == 0){
								
								$oRespuesta->alert("se actualizaron correctamente los datos del PLAN");
	
								//$oRespuesta->script(" resetForm();");
								
								//$oRespuesta->redirect("Comercios.php");
								
							//}else{
								//$oRespuesta->alert("sucedio un error interno al intentar actualizar los datos del Comercio.");
							//}
						}else{
							$oRespuesta->alert("sucedieron errores en la carga de los datos: \n".$check_datos);
						}						
						
					}else{
						$oRespuesta->alert("Codigo de PLAN es incorrecto.");
					}
				
				
				break;		
			default:
				#error
				$oRespuesta->alert("Ejecuto una operacion incorrecta");
				break;
		}
		
		return $oRespuesta;
	}

	function eliminarPromocionesPlanes($idpromocionesplanes){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$idpromocionesplanes = intval(_decode($idpromocionesplanes));
		
		if(!is_null($idpromocionesplanes) && is_integer($idpromocionesplanes) && $idpromocionesplanes != 0){
			
			$promociones = new promociones($idpromocionesplanes);
			
			$check_datos = promociones::_check_erase_($idpromocionesplanes);
			
			if($check_datos == ""){
				
				$promociones->delete();
				
				if($promociones->get_error_nro_query() == 0){

					$oRespuesta->alert("se dio de baja el plan correctamente");

				    $script=" window.location.reload();";

				    $oRespuesta->script($script);
					
				}else{
					$oRespuesta->alert("sucedio un error interno al intentar eliminar PLAN.");
				}
			}
			
		}else{
			$oRespuesta->alert("Codigo de Promocion es incorrecto.");
		}

		return $oRespuesta;
	}

	function activarPromocionesPlanes($idpromocionesplanes){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$idpromocionesplanes = intval(_decode($idpromocionesplanes));
		
		if(!is_null($idpromocionesplanes) && is_integer($idpromocionesplanes) && $idpromocionesplanes != 0){
			
			$promociones = new promociones($idpromocionesplanes);

			$promociones->activar();

			if($promociones->get_error_nro_query() == 0){

				$oRespuesta->alert("se activo el PLAN");

			    $script=" window.location.reload();";

			    $oRespuesta->script($script);
				
			}else{
				$oRespuesta->alert("sucedio un error interno al intentar eliminar PLAN.");
			}

		}else{
			$oRespuesta->alert("Codigo de PLAN es incorrecto.");
		}

		return $oRespuesta;
	}

	function buscarDatosUsuario($datos){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();		

		$conditions = array();	
		
		//$conditions[] = "( Tarjetas.idTipoEstadoTarjeta = 8 OR Tarjetas.idTipoEstadoTarjeta = 1 OR Tarjetas.idTipoEstadoTarjeta = 5 )";
		$conditions[] = "1=1";
		if($datos['sNombre'] != ''){
			$conditions[] = "Usuarios.sNombre LIKE '{$datos['sNombre']}%'";
		}
		
		if($datos['sApellido'] != ''){
			$conditions[] = "Usuarios.sApellido LIKE '{$datos['sApellido']}%'";
		}
		
		if($datos['idTipoDocumento'] != 0){
			$conditions[] = "Usuarios.idTipoDocumento = '{$datos['idTipoDocumento']}'";
		}
		
		if($datos['sDocumento'] != ''){
			$conditions[] = "Usuarios.sDocumento = '{$datos['sDocumento']}'";
		}
		
		if($datos['sNumeroCuenta'] != ''){
			$conditions[] = "CuentasUsuarios.sNumeroCuenta = '{$datos['sNumeroCuenta']}'";
		}
		
		if($datos['sNumeroTarjeta'] != ''){
			$conditions[] = "Tarjetas.sNumeroTarjeta = '{$datos['sNumeroTarjeta']}'";
		}
		
		$sub_query = " WHERE " . implode(" AND ",$conditions) . " ORDER BY sApellido ASC" ;
		//var_export("CALL usp_getTarjetas(\"$sub_query\");");die();
		$users = $oMysql->consultaSel("CALL usp_getTarjetas(\"$sub_query\");");
		
		$table = "<table width='600' cellspacing='0' cellpadding='0' align='center' class='table_object' id='table_object'>";
		$table .= "<tr>
					<th width='30'>&nbsp;</th>
					<th width='100'>Nro.Cuenta</th>
					<th width='100'>Nro.Tarjeta</th>
					<th width='100'>Tipo&nbsp;Tarjeta</th>
					<th width='350'>Usuario</th>
				  </tr>";
		
		if(!$users){
				$table .= "<tr>
							<td colspan='5' align='left'>-no se encontraron registros</td>
						  </tr>";				
		}else{
			foreach ($users as $user) {
				
				//$limiteCredito = $oMysql->consultaSel("SELECT fcn_getLimiteCreditoUsuario(\"{$user['id']}\");", true);
				$sCondicion = " WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$user['idCuentaUsuario']} AND DetallesCuentasUsuarios.iEmiteResumen=0";
				$sql="Call usp_getDetallesCuentasUsuarios(\"$sCondicion\");";				
				$rsDetalle= $oMysql->consultaSel($sql,true);
				$limiteCreditoDisponible = $rsDetalle['fRemanenteCredito'];

				switch ($user['idTipoTarjeta']) {
					case 1:
						$cartel_tipo_tarjeta = "TITULAR";
						break;
					case 2:
						$cartel_tipo_tarjeta = "ADICIONAL";
						break;			
					default:
						break;
				}
				
				$table .= "<tr>
							<td width='30'><input type='radio' name='user[]' id='user_{$usuario['id']}' onclick=\"parent.setDatosCuentaUsuario('"._encode($user['idCuentaUsuario'])."','{$user['sApellido']}, {$user['sNombre']}','{$user['sNumeroTarjeta']}','$cartel_tipo_tarjeta','{$user['iVersion']}','{$user['sNumeroCuenta']}','$limiteCreditoDisponible','"._encode($user['id'])."');\"></td>
							<td width='100'>{$user['sNumeroCuenta']}</td>
							<td width='100'>{$user['sNumeroTarjeta']}</td>
							<td width='100'>{$cartel_tipo_tarjeta}</td>
							<td width='350' align='left'>{$user['sApellido']}, {$user['sNombre']}</td>
						  </tr>";			
			}			
		}
		

		
		$table .= "</table>";
		//$oRespuesta->alert($table);
		$oRespuesta->assign("resultado_busqueda","innerHTML",$table);
				
		
		return $oRespuesta;	
	}
	
	function buscarDatosUsuarioPorCuenta($numero_cuenta){
		global $oMysql;
		$oRespuesta = new xajaxResponse();

		//$sub_query = " WHERE CuentasUsuarios.sNumeroCuenta = '$numero_cuenta' AND ( Tarjetas.idTipoEstadoTarjeta = 8 OR Tarjetas.idTipoEstadoTarjeta = 1 OR Tarjetas.idTipoEstadoTarjeta = 5)" ;
		$sub_query = " WHERE CuentasUsuarios.sNumeroCuenta = '$numero_cuenta'";
		//var_export("CALL usp_getTarjetas(\"$sub_query\");");die();
		$user = $oMysql->consultaSel("CALL usp_getTarjetas(\"$sub_query\");", true);

		if(!$user){

			$oRespuesta->script("setNotFoundCuenta();");

		}else{

			switch ($user['idTipoTarjeta']) {
				case 1:
					$cartel_tipo_tarjeta = "TITULAR";
					break;
				case 2:
					$cartel_tipo_tarjeta = "ADICIONAL";
					break;
				default:
					break;

			}

			$oRespuesta->script("setDatosCuentaUsuarioN2('"._encode($user['idCuentaUsuario'])."','{$user['sApellido']}, {$user['sNombre']}','{$user['sNumeroTarjeta']}','$cartel_tipo_tarjeta','{$user['iVersion']}','{$user['sNumeroCuenta']}','"._encode($user['id'])."');");
			
			//$limiteCredito = $oMysql->consultaSel("SELECT fcn_getLimiteCreditoUsuario(\"{$user['id']}\");", true);
			$sCondicion = " WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$user['idCuentaUsuario']} AND DetallesCuentasUsuarios.iEmiteResumen=0";
			$sql="Call usp_getDetallesCuentasUsuarios(\"$sCondicion\");";
			//$oRespuesta->alert($sql);				
			$rsDetalle= $oMysql->consultaSel($sql,true);
			//$oRespuesta->alert($rsDetalle['fRemanenteCredito']);
			$limiteCreditoDisponible = $rsDetalle['fRemanenteCredito'];
			$oRespuesta->script("setLimiteCredito('$limiteCreditoDisponible');");			
		}

		return $oRespuesta;

	}
	
	function buscarDatosUsuarioPorCuentaTF($numero_cuenta){
		global $oMysql;
		$oRespuesta = new xajaxResponse();

		//$sub_query = " WHERE CuentasUsuarios.sNumeroCuenta = '$numero_cuenta' AND ( Tarjetas.idTipoEstadoTarjeta = 8 OR Tarjetas.idTipoEstadoTarjeta = 1 OR Tarjetas.idTipoEstadoTarjeta = 5)" ;
		$sub_query = " WHERE CuentasUsuarios.sNumeroCuenta = '$numero_cuenta'";
		//var_export("CALL usp_getTarjetas(\"$sub_query\");");die();
		$user = $oMysql->consultaSel("CALL usp_getTarjetas(\"$sub_query\");", true);

		if(!$user){

			$oRespuesta->script("setNotFoundCuenta();");

		}else{

			switch ($user['idTipoTarjeta']) {
				case 1:
					$cartel_tipo_tarjeta = "TITULAR";
					break;
				case 2:
					$cartel_tipo_tarjeta = "ADICIONAL";
					break;
				default:
					break;

			}

			$oRespuesta->script("setDatosCuentaUsuarioN2('"._encode($user['idCuentaUsuario'])."','{$user['sApellido']}, {$user['sNombre']}','{$user['sNumeroTarjeta']}','$cartel_tipo_tarjeta','{$user['iVersion']}','{$user['sNumeroCuenta']}','"._encode($user['id'])."');");
			
			//$limiteCredito = $oMysql->consultaSel("SELECT fcn_getLimiteCreditoUsuario(\"{$user['id']}\");", true);
			$sCondicion = " WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$user['idCuentaUsuario']} AND DetallesCuentasUsuarios.iEmiteResumen=0";
			$sql="Call usp_getDetallesCuentasUsuarios(\"$sCondicion\");";
			//$oRespuesta->alert($sql);				
			$rsDetalle= $oMysql->consultaSel($sql,true);
			//$oRespuesta->alert($rsDetalle['fRemanenteCredito']);
			$limiteCreditoDisponible = $rsDetalle['fRemanenteCredito'];
			$oRespuesta->script("setLimiteCredito('$limiteCreditoDisponible');");		
			
			//Obtener listado de Pedidos si es que tiene el Cliente
			//$oRespuesta->alert($user['idCliente']);
			$tablaDatosPedidos = getDatosPedidos($user['idCliente']);
			//$oRespuesta->alert($tablaDatosPedidos);
			$oRespuesta->assign("divTitleNotasPedidos","style.display","inline");
			$oRespuesta->assign("div_datos_pedidos","innerHTML",$tablaDatosPedidos);	
		}

		return $oRespuesta;		
	}
	
	function getDatosPedidos($idCliente){
		global $oMysql;
		$tablaHtml = "";
		$aNotas = $oMysql->consultaSel("SELECT systemglobal_java.NotasPedidos.NotasPedidosId,
				systemglobal_java.NotasPedidos.NotasPedidosCantidadCuotas,
				systemglobal_java.NotasPedidos.NotasPedidosNumero,	
				systemglobal_java.NotasPedidos.NotasPedidosFechaAlta,			
				DATE_FORMAT(systemglobal_java.NotasPedidos.NotasPedidosFechaAlta,'%d/%m/%Y') as 'NotasPedidosFechaAltaFormat',
				systemglobal_java.NotasPedidos.NotasPedidosFormaPago,
				systemglobal_java.NotasPedidos.NotasPedidosImporteCuota
				FROM systemglobal_java.NotasPedidos 				
				WHERE systemglobal_java.NotasPedidos.ClientesId = {$idCliente}
				AND systemglobal_java.NotasPedidos.NotasPedidosEstado = 2"); //Solo las Notas Aprobadas
		if(count($aNotas) > 0){
			$tablaHtml .= "";
			$tablaHtml .= "<table id='tablaPedidos' class='table_object' cellspacing=0 cellpadding=0 border=0 style='border-collapse=collapse' width='100%'>";
			$tablaHtml .= "<tr><th>&nbsp;</th><th>Pedido</th><th>Fecha</th><th>Importe</th></tr>";
			foreach ($aNotas as $row){
				$total = $row['NotasPedidosCantidadCuotas'] * $row['NotasPedidosImporteCuota'];
				$tablaHtml .= "<tr>";
				$tablaHtml .= "<td width='30' align='center'><input type='radio' name='pedidos[]' id='pedido_{$row['NotasPedidosId']}' onclick=\"setDatosPedido('{$row['NotasPedidosId']}','{$row['NotasPedidosCantidadCuotas']}','{$row['NotasPedidosImporteCuota']}','{$row['NotasPedidosFormaPago']}','{$row['NotasPedidosNumero']}','{$row['NotasPedidosFechaAlta']}','{$total}');\"></td>";

				$tablaHtml .= "<td style='font-size:9px'>{$row['NotasPedidosNumero']}</td>";
				$tablaHtml .= "<td style='font-size:9px'>{$row['NotasPedidosFechaAltaFormat']}</td>";				
				$tablaHtml .= "<td style='font-size:9px'>{$total}</td>";
				$tablaHtml .= "</tr>";
			}
			$tablaHtml .= "</table>";
		}else{
			$tablaHtml .= "El Usuario no tiene Notas de Pedidos";
		}
		return $tablaHtml;
	}
	
	function getPedidos($numero_cuenta){
		global $oMysql;
		$oRespuesta = new xajaxResponse();
		
		$sub_query = " WHERE CuentasUsuarios.sNumeroCuenta = '$numero_cuenta'";
		$user = $oMysql->consultaSel("CALL usp_getTarjetas(\"$sub_query\");", true);
		
		$tablaDatosPedidos = getDatosPedidos($user['idCliente']);
		
		$oRespuesta->assign("divTitleNotasPedidos","style.display","inline");
		$oRespuesta->assign("div_datos_pedidos","innerHTML",$tablaDatosPedidos);	
		
		return $oRespuesta;		
	}
	
	function buscarDatosComercio($datos){
		global $oMysql;
		$oRespuesta = new xajaxResponse();
		
		$conditions = array();	
		
		$conditions[] = "Comercios.sEstado = 'A'";

		if($datos['sNumero'] != ''){
			$conditions[] = "Comercios.sNumero = '{$datos['sNumero']}'";
		}
		
		if($datos['sRazonSocial'] != ''){
			$conditions[] = "Comercios.sRazonSocial LIKE '{$datos['sRazonSocial']}%'";
		}
		
		if($datos['sNombreFantasia'] != ''){
			$conditions[] = "Comercios.sNombreFantasia LIKE '{$datos['sNombreFantasia']}%'";
		}		
		
		if($datos['sCUIT'] != ''){
			$conditions[] = "Comercios.sCUIT = '{$datos['sCUIT']}'";
		}

		
		$sub_query = " WHERE " . implode(" AND ",$conditions) . " ORDER BY Comercios.sNumero ASC" ;
		//var_export("CALL usp_getTarjetas(\"$sub_query\");");die();
		$comercios = $oMysql->consultaSel("CALL usp_getComercios(\"$sub_query\");");
		
		$table = "<table width='680' cellspacing='0' cellpadding='0' align='center' class='table_object' id='table_object'>";
		$table .= "<tr>
					<th width='30'>&nbsp;</th>
					<th width='180'>Responsable</th>
					<th width='180'>Razon Social</th>
					<th width='180'>Nombre Fantasia</th>
					<th width='110'>CUIT</th>
				  </tr>";
		
		if(!$comercios){
				$table .= "<tr>
							<td colspan='5' align='left'>-no se encontraron registros</td>
						  </tr>";				
		}else{
			foreach ($comercios as $comercio) {

				$table .= "<tr>
							<td width='30' align='center'><input type='radio' name='commerce[]' id='commerce_{$comercio['id']}' onclick=\"parent.setDatosComercio('"._encode($comercio['id'])."','{$comercio['sRazonSocial']}','{$comercio['sNombreFantasia']}','{$comercio['sCUIT']}','{$comercio['sNumero']}');\"></td>
							<td width='190' align='left'>{$comercio['sApellido']}, {$comercio['sNombre']}</td>
							<td width='190' align='left'>{$comercio['sRazonSocial']}</td>
							<td width='190' align='left'>{$comercio['sNombreFantasia']}</td>
							<td width='80' align='center'>{$comercio['sCUIT']}</td>
						  </tr>";
			}			
		}
		
		$table .= "</table>";
		
		$oRespuesta->assign("resultado_busqueda","innerHTML",$table);
		
		return $oRespuesta;
	}
	
	function buscarDatosComercioPorNumero($numero_comercio = ''){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();

		$sub_query = " WHERE Comercios.sNumero = '$numero_comercio' AND Comercios.sEstado = 'A' " ;
		
		$comercio = $oMysql->consultaSel("CALL usp_getComercios(\"$sub_query\");", true);
		
		if(!$comercio){

			$oRespuesta->script("setNotFoundComercio();");
			$oRespuesta->script("setNotFoundPromocionesPlanesComercio();");

		}else{
			
			$oRespuesta->script("setDatosComercioN2('"._encode($comercio['id'])."','{$comercio['sRazonSocial']}',' {$comercio['sNombreFantasia']}','{$comercio['sCUIT']}','{$comercio['sNumero']}');");
			
			#obtengo promociones vigentes, habilitadas
			$fecha_hoy = date("Y-m-d h:i:s");
			
			$sub_query = " WHERE PromocionesPlanes.idComercio = '{$comercio['id']}' AND UNIX_TIMESTAMP(PromocionesPlanes.dVigenciaDesde) <= UNIX_TIMESTAMP('$fecha_hoy') AND UNIX_TIMESTAMP(PromocionesPlanes.dVigenciaHasta) >= UNIX_TIMESTAMP('$fecha_hoy') AND PromocionesPlanes.sEstado='A'";
			//var_export("CALL usp_getPromocionesPlanes(\"$sub_query\");");die();
			$promociones = $oMysql->consultaSel("CALL usp_getPromocionesPlanes(\"$sub_query\");");
				
			$table = "<center><div class='title_planespromo'>Promociones</div></center><table width='530' cellspacing='0' cellpadding='0' align='center' class='table_object' id='table_object'>";
			$table .= "<tr>
						<th width='30'>&nbsp;</th>
						<th width='200'>Tipo Promocion</th>
						<th width='200'>Promocion</th>
						<th width='100'>Cuotas</th>
					  </tr>";
			
			if(!$promociones){
					$table .= "<tr>
								<td colspan='4' align='left'>&nbsp;no existen promociones</td>
							  </tr>";				
			}else{
				
				#campo hidden _itp en el formulario alta cupones indica si se selecciona promocion o plan
				#'promociones' | 'planes'   --> las alternativas posibles
				foreach ($promociones as $promocion) {
					
					$table .= "<tr>
								<td width='30'><input type='radio' name='rp' id='rp_{$promocion['id']}' onclick=\"setDatosCuotas('"._encode($promocion['id'])."','"._encode('promociones')."','{$promocion['iCantidadCuota']}');\"></td>
								<td width='200'>{$promocion['sNombreTipoPlan']}</td>
								<td width='200'>{$promocion['sNombre']}</td>
								<td width='100'>{$promocion['iCantidadCuota']}</td>
							  </tr>";			
				}			
			}
			
			$table .= "</table>";
			
			#obtengo planes vigentes, habilitados
			$sub_query = " WHERE Planes.idComercio = '{$comercio['id']}' AND UNIX_TIMESTAMP(Planes.dVigenciaDesde) <= UNIX_TIMESTAMP('$fecha_hoy') AND UNIX_TIMESTAMP(Planes.dVigenciaHasta) >= UNIX_TIMESTAMP('$fecha_hoy') AND Planes.sEstado='A'";
			//var_export("CALL usp_getPromocionesPlanes(\"$sub_query\");");die();
			$planes = $oMysql->consultaSel("CALL usp_getPlanes(\"$sub_query\");");
				
			$table .= "<center><br /><div class='title_planespromo'>Planes</div></center><table width='530' cellspacing='0' cellpadding='0' align='center' class='table_object' id='table_object'>";
			$table .= "<tr>
						<th width='30'>&nbsp;</th>
						<th width='200'>Tipo Plan</th>
						<th width='200'>Plan</th>
						<th width='100'>Cuotas</th>
					  </tr>";
			
			if(!$planes){
					$table .= "<tr>
								<td colspan='4' align='left'>&nbsp;no existen planes</td>
							  </tr>";				
			}else{
				
				#campo hidden _itp en el formulario alta cupones indica si se selecciona promocion o plan
				#'promociones' | 'planes'   --> las alternativas posibles
				foreach ($planes as $plan) {
					
					$table .= "<tr>
								<td width='30'><input type='radio' name='rp' id='rp_{$plan['id']}' onclick=\"setDatosCuotas('"._encode($plan['id'])."','"._encode('planes')."','{$plan['iCantidadCuota']}');\"></td>
								<td width='200'>{$plan['sNombreTipoPlan']}</td>
								<td width='200'>{$plan['sNombre']}</td>
								<td width='100'>{$plan['iCantidadCuota']}</td>
							  </tr>";			
				}			
			}
			
			$table .= "</table>";			
			
			$oRespuesta->assign("div_datos_planes","innerHTML",$table);
			

		}

		return $oRespuesta;
	}
	
	function buscarDatosPromocionesPlanesComercio($idcomercio = ''){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$idcomercio = intval(_decode($idcomercio));
		
		if(!$idcomercio){

			$oRespuesta->script("setNotFoundPromocionesPlanesComercio();");

		}else{
			
			#obtengo promociones vigentes, habilitadas
			$fecha_hoy = date("Y-m-d h:i:s");
			
			$sub_query = " WHERE PromocionesPlanes.idComercio = '{$idcomercio}' AND UNIX_TIMESTAMP(PromocionesPlanes.dVigenciaDesde) <= UNIX_TIMESTAMP('$fecha_hoy') AND UNIX_TIMESTAMP(PromocionesPlanes.dVigenciaHasta) >= UNIX_TIMESTAMP('$fecha_hoy') AND PromocionesPlanes.sEstado='A'";
			//var_export("CALL usp_getPromocionesPlanes(\"$sub_query\");");die();
			$promociones = $oMysql->consultaSel("CALL usp_getPromocionesPlanes(\"$sub_query\");");
				
			$table = "<center><br /><div class='title_planespromo'>Promociones</div></center></br /><table width='530' cellspacing='0' cellpadding='0' align='center' class='table_object' id='table_object'>";
			$table .= "<tr>
						<th width='30'>&nbsp;</th>
						<th width='200'>Tipo Promocion</th>
						<th width='200'>Promocion</th>
						<th width='100'>Cuotas</th>
					  </tr>";
			
			if(!$promociones){
					$table .= "<tr>
								<td colspan='4' align='left'>&nbsp;no existen promociones</td>
							  </tr>";				
			}else{
				
				#campo hidden _itp en el formulario alta cupones indica si se selecciona promocion o plan
				#'promociones' | 'planes'   --> las alternativas posibles
				foreach ($promociones as $promocion) {
					
					$table .= "<tr>
								<td width='30'><input type='radio' name='rp' id='rp_{$promocion['id']}' onclick=\"setDatosCuotas('"._encode($promocion['id'])."','"._encode('promociones')."','{$promocion['iCantidadCuota']}');\"></td>
								<td width='200'>{$promocion['sNombreTipoPlan']}</td>
								<td width='200'>{$promocion['sNombre']}</td>
								<td width='100'>{$promocion['iCantidadCuota']}</td>
							  </tr>";			
				}			
			}
			
			$table .= "</table>";
			
			#obtengo planes vigentes, habilitados
			$sub_query = " WHERE Planes.idComercio = '{$idcomercio}' AND UNIX_TIMESTAMP(Planes.dVigenciaDesde) <= UNIX_TIMESTAMP('$fecha_hoy') AND UNIX_TIMESTAMP(Planes.dVigenciaHasta) >= UNIX_TIMESTAMP('$fecha_hoy') AND Planes.sEstado='A'";
			//var_export("CALL usp_getPromocionesPlanes(\"$sub_query\");");die();
			$planes = $oMysql->consultaSel("CALL usp_getPlanes(\"$sub_query\");");
				
			$table .= "<center><br /><div class='title_planespromo'>Planes</div></center></br /><table width='530' cellspacing='0' cellpadding='0' align='center' class='table_object' id='table_object'>";
			$table .= "<tr>
						<th width='30'>&nbsp;</th>
						<th width='200'>Tipo Plan</th>
						<th width='200'>Plan</th>
						<th width='100'>Cuotas</th>
					  </tr>";
			
			if(!$planes){
					$table .= "<tr>
								<td colspan='4' align='left'>&nbsp;no existen planes</td>
							  </tr>";				
			}else{
				
				#campo hidden _itp en el formulario alta cupones indica si se selecciona promocion o plan
				#'promociones' | 'planes'   --> las alternativas posibles
				foreach ($planes as $plan) {
					
					$table .= "<tr>
								<td width='30'><input type='radio' name='rp' id='rp_{$plan['id']}' onclick=\"setDatosCuotas('"._encode($plan['id'])."','"._encode('planes')."','{$plan['iCantidadCuota']}');\"></td>
								<td width='200'>{$plan['sNombreTipoPlan']}</td>
								<td width='200'>{$plan['sNombre']}</td>
								<td width='100'>{$plan['iCantidadCuota']}</td>
							  </tr>";			
				}			
			}
			
			$table .= "</table>";			
			
			$oRespuesta->assign("div_datos_planes","innerHTML",$table);
			

		}

		return $oRespuesta;
	}

	function _compare_date_($fecha1,$fecha2){
		#formato de las fecha: dd/mm/YYYY |	dd-mm-YYYY
	
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
		
		      list($dia1,$mes1,$año1)=split("/",$fecha1);
		    
		
		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
		
		      list($dia1,$mes1,$año1)=split("-",$fecha1);
		      
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
		
		      list($dia2,$mes2,$año2)=split("/",$fecha2);
		    
		
		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
			
		list($dia2,$mes2,$año2)=split("-",$fecha2);
		
		
		$dif = mktime(0,0,0,$mes1,$dia1,$año1) - mktime(0,0,0, $mes2,$dia2,$año2);
		
		return ($dif);
	
	}

	function _dateTOLETTER($date = '' , $lugar = ''){
		#$date = dd/m/YYY
		
		$fecha = explode("/",$date);

		$meses = array();
		
		$meses[] = "Enero";
		$meses[] = "Febrero";
		$meses[] = "Marzo";
		$meses[] = "Abril";
		$meses[] = "Mayo";
		$meses[] = "Junio";
		$meses[] = "Julio";
		$meses[] = "Agosto";
		$meses[] = "Setiembre";
		$meses[] = "Octubre";
		$meses[] = "Noviembre";
		$meses[] = "Diciembre";
		
		$index = intval($fecha[1]) - 1;
		if($lugar != ''){
			$string_date = $lugar . ", " . $fecha[0] . " de " . $meses[$index] . " de " . $fecha[2] ;	
		}else{
			$string_date = $fecha[0] . " de " . $meses[$index] . " de " . $fecha[2] ;
		}
		
		
		return $string_date;
		
		
	}
	
	function sendFormCupones__($datos){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$op = _decode($datos['_op']);
		
		$break = chr(13);

		
		switch ($op) {
			case "new":
					$cupones = new cupons(0);
					
					$check_datos = cupons::_check_datos($datos,"new");

					if($check_datos == ""){

						$datos['idComercio']		= intval(_decode($datos['_ico']));
						$datos['idCuentaUsuario'] 	= intval(_decode($datos['_icu']));
						$datos['idTarjeta'] 		= intval(_decode($datos['_it']));

						$cupones->insert($datos);
								
						if($cupones->get_error_nro_query() == 0){
							
							$cupones->set_datos();
							
							$cupones->insertDetails($datos);
							if($cupones->get_error_nro_query() == 0){								

								$oRespuesta->alert("se registro correctamente el CUPON");

								$oRespuesta->script(" resetForm();");
								
								$html = _printCronogramaCuotas($cupones->get_id());
								
								$oRespuesta->assign("impresiones","innerHTML","$html");
								
								$boton_reimpirmir = "<img src=\"../includes/images/print.gif\" alt=\"\" title=\"\" hspace=\"4\" align=\"absmiddle\"> <a href=\"javascript:_print();\">reimprimir ultimo cupon cargado</a>";
								
								$oRespuesta->assign("div_reimprimir_cupon","innerHTML","$boton_reimpirmir");
								
								$oRespuesta->script("_print();");


							}else{
								$oRespuesta->alert("sucedio un error interno al intentar grabar DETALLES DE CUPON.");
							}

							//$oRespuesta->redirect("Planes.php");
							
						}else{
							
						}
					}else{
						$oRespuesta->alert("sucedieron errores en la carga de los datos: " . $break . $check_datos);
					}
				
				break;
			case "edit":

				
				break;		
			default:
				#error
				$oRespuesta->alert("Ejecuto una operacion INVÁLIDA");
				break;
		}
		
		return $oRespuesta;
	}

	function _reprintCupones($idcupon = ''){
		$oRespuesta = new xajaxResponse();
		
		//$idcupon = intval(_decode($idcupon));
		
		$html = convertir_especiales_html(_reprintCuponesOriginal($idcupon));
		
		$oRespuesta->assign("impresiones","innerHTML","$html");	
		
		$oRespuesta->script("_cmdPrintCupones();");	

		return $oRespuesta;	
	}
		
	function _printCronogramaCuotas($idcupones = 0){
		global $oMysql;

		$parseo = array();

		$sub_query = " WHERE Cupones.id=$idcupones";

		$cupones = $oMysql->consultaSel("CALL usp_getDatosCompletosCupones(\"$sub_query\");", true);
		
		$sub_query = " WHERE DetallesCupones.idCupon = '$idcupones'";

		$detalles = $oMysql->consultaSel("CALL usp_getDetallesCupones(\"$sub_query\");");

		$tableRowsCuotas = "";

		foreach ($detalles as $cuota) {
			
			$fecha = explode("/",$cuota['dFechaFacturacionUsuario']);
			$anyo  = $fecha[2];
			$mes   = $fecha[1];
			
			$dFechaVencimiento = $oMysql->consultaSel("SELECT fcn_getFechaVencimientoCupones(\"$idcupones\",\"$anyo\",\"$mes\");",true);
			
			if($dFechaVencimiento == ""){
				$mes = intval($mes);
				$mes = $mes + 1;
				$mktimeV = mktime(0,0,0,$mes,15,$anyo);
				$dFechaVencimiento = date("d/m/Y",$mktimeV);
			}
			//$dFechaVencimiento = "___/___/_____";
			$tableRowsCuotas .= "
								<tr>
								    <td>{$cuota['iNumeroCuota']}</td>
								    <td>{$dFechaVencimiento}</td>
								    <td>$</td>
								    <td>{$cuota['fImporte']}</td>
								</tr>
								";
		}
			
		$fecha = date("d/m/Y");
		
		$diaHoy = intval(date("d"));
		$mesHoy = intval(date("m"));
		$anyoHoy = intval(date("Y"));
		$horaHoy = intval(date("h"));
		$minHoy = intval(date("i"));
		$segHoy = intval(date("s"));
		
		$mktime4 = mktime($horaHoy,$minHoy,$segHoy,$mesHoy,$diaHoy,$anyoHoy+4);
		
		$fecha_en_letra_plazo_presentacion = date("d/m/Y",$mktime4);
		
		$parseo['fecha_en_letra_plazo_presentacion'] 			= $fecha_en_letra_plazo_presentacion;
		
		$idusuario = $cupones['idUsuario'];
		
		$parseo['date_now'] 			= date("d/m/Y");

		$parseo['hours_now'] 			= date("h:i:s");

		$parseo['idSucursal'] 			= $_SESSION['id_suc'];

		$parseo['sNumeroCuenta'] 		= $cupones['sNumeroCuenta'];
		
		$parseo['sNumeroCupon'] 		= $cupones['sNumeroCupon'];

		$parseo['importeTOTAL'] 		= $cupones['fImporte'];

		$parseo['tableRowsCuotas'] 		= $tableRowsCuotas;
		
		$g = _dateTOLETTER($fecha,"Salta");
		
		$parseo['fecha_hoy_en_letras']	= $g;
		
		$x=new EnLetras();
			
		$sCantidad = $x->ValorEnLetras($cupones['fImporte'],"").'.-';		
		
		$parseo['importe_en_letras'] 		= $sCantidad;
		
		
		#para datos del titular
		$parseo['sTitular'] 			= $cupones['sApellidoUsuario'] . ", " . $cupones['sNombreUsuario'];

		$parseo['sTipoDocumento'] 		= $cupones['sNombreTipoDocumento'];

		$parseo['sNumeroDocumento'] 	= $cupones['sDocumentoUsuario'];

		$parseo['sProvinciaTitular'] 	= $cupones['sNombreProvincia'];

		$parseo['sLocalidadTitular'] 	= $cupones['sNombreLocalidad'];
		
		$sub_query = " WHERE DomiciliosUsuarios.idUsuario = '$idusuario' ORDER BY DomiciliosUsuarios.id DESC LIMIT 0,1";
		
		$domicilio = $oMysql->consultaSel("CALL usp_getDomiciliosUsuarios(\"$sub_query\");",true);
		
		$parseo['sCalle'] 	= $cupones['sCalle'];
		
		$parseo['sCalle'] 			= $domicilio['sCalle'];
		$parseo['sNumeroCalle'] 	= $domicilio['sNumeroCalle'];
		$parseo['sBlock'] 			= $domicilio['sBlock'];
		$parseo['sPiso'] 			= $domicilio['sPiso'];
		$parseo['sDepartamento'] 	= $domicilio['sDepartamento'];
		$parseo['sEntreCalles'] 	= $domicilio['sEntreCalles'];
		$parseo['sManzana'] 		= $domicilio['sManzana'];
		$parseo['sLote'] 			= $domicilio['sLote'];
		
		$parseo['sProvinciaTitular']= $domicilio['sNombreProvincia'];
		$parseo['sLocalidadTitular']= $domicilio['sNombreLocalidad'];
		
		$parseo['sDomicilio'] = $parseo['sCalle']." ".$parseo['sNumeroCalle']; 
		if($parseo['sBlock'] != "") $parseo['sDomicilio'] .= " BLOCK:".$parseo['sBlock'];
		if($parseo['sPiso'] != "") $parseo['sDomicilio'] .= " Piso:".$parseo['sPiso'];
		if($parseo['sDepartamento'] != "") $parseo['sDomicilio'] .=" Dpto.:".$parseo['sDepartamento'];
		
		#27 = cargo administrativo
		#31 = seguro de vida sobre saldo deudor
		$sub_query = " WHERE FacturacionesCargos.idGrupoAfinidad = '{$cupones['idGrupoAfinidad']}' AND FacturacionesCargos.idTipoAjuste = 27";
		
		$cargos = array_shift($oMysql->consultaSel("CALL usp_getFacturacionDeCargos(\"$sub_query\");"));
		
		$parseo['monto_cargo_administrativo'] 			= $cargos['fValor'];
		
		
		$sub_query = " WHERE FacturacionesCargos.idGrupoAfinidad = '{$cupones['idGrupoAfinidad']}' AND FacturacionesCargos.idTipoAjuste = 31";
		
		$cargos = array_shift($oMysql->consultaSel("CALL usp_getFacturacionDeCargos(\"$sub_query\");"));
		
		$parseo['porcentaje_seguro_vida_saldo_deudor'] 	= $cargos['fValor'];
		
		if($cupones['idPlan'] != 0){

				$aplanes = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$cupones['idPlan']}\",\"planes\");",true);

				if(!$aplanes){

					$fInteresUsuario= 0;

				}else{

					$fInteresUsuario= $aplanes['fInteresUsuario'];

				}	

		}else{

				$apromociones = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$cupones['idPlanPromo']}\",\"promociones\");",true);

				if(!$apromociones){

					$fInteresUsuario= 0;


				}else{

					$fInteresUsuario= $apromociones['fInteresUsuario'];

				}

		}
		$message_interes = "";
		if($fInteresUsuario != 0){
			$message_interes = "TEA $fInteresUsuario% + IVA";
		}
		
		$parseo['datos_interes_IVA'] = $message_interes ;
		
		if($cupones['iTipoPersona'] == 2){
		  	$parseo['cartel_razon_social_cuit'] = ': ' . $cupones['sRazonSocial'] . ' - CUIT : ' . $cupones['sCUIT'];
		}

		$html = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Cupones/impresiones.tpl",$parseo);
		
		return $html;
		
		
	}
	
	function marcarCuponesFraude($idcupones = ''){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$idcupones = intval(_decode($idcupones));
		
		if(is_integer($idcupones) && $idcupones != 0){
			
			$cupones = new cupons($idcupones);
			
			$check_datos = cupons::_check_datos($idcupones,'pendiente-liquidacion-comercio');
			
			if($check_datos == ""){
				
				$check_datos = cupons::_check_datos($idcupones,'pendiente-liquidacion-usuario');
				
				if($check_datos == ""){
					
					$cupones->marcarFRAUDE();	
					
					$oRespuesta->alert("Se marco como FRAUDE el cupon seleccionado.");
					
				    $script="window.location.reload();";

				    $oRespuesta->script($script);
					
				}else{
					$oRespuesta->alert($check_datos);
				}
			}else {
				
				$oRespuesta->alert($check_datos);
			}
			
		}else{
			$oRespuesta->alert("Codigo de CUPON es incorrecto.");
		}
		
		return $oRespuesta;
	}
	
	function marcarCuponesObservado($datos){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$idcupones = intval(_decode($datos['_i']));
		
		if(is_integer($idcupones) && $idcupones != 0){
			
			$cupones = new cupons($idcupones);
			
			$check_datos = cupons::_check_datos($idcupones,'pendiente-liquidacion-comercio');
			
			if($check_datos == ""){
				
				$check_datos = cupons::_check_datos($idcupones,'pendiente-liquidacion-usuario');
				
				if($check_datos == ""){
					
					$datos['sObservaciones'] = $oMysql->escaparCadena($datos['sObservaciones']);
					
					$cupones->marcarOBSERVADO($datos['sObservaciones']);	
					
					$oRespuesta->alert("Se marco como observado el cupon seleccionado.");
					
				    //$script=" window.location.reload();";
				    $script = " parent._reloadPAGE();";

				    $oRespuesta->script($script);
					
				}else{
					$oRespuesta->alert($check_datos);
				}
			}else {
				
				$oRespuesta->alert($check_datos);
			}
			
		}else{
			$oRespuesta->alert("Codigo de CUPON es incorrecto.");
		}
		
		return $oRespuesta;
	}
	
	function marcarCuponesActivado($idcupones){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$idcupones = intval(_decode($idcupones));
		
		if(is_integer($idcupones) && $idcupones != 0){
			
			$cupones = new cupons($idcupones);
			
			$check_datos = cupons::_check_datos($idcupones,'reactivar');
			
			if($check_datos == ""){
					
					$cupones->marcarACTIVADO();	
					
					$oRespuesta->alert("Se marco como reactivo el cupon seleccionado.");
					
				    
				   $script=" window.location.reload();";

				    $oRespuesta->script($script);
					
			}else {
				
				$oRespuesta->alert($check_datos);
			}
			
		}else{
			$oRespuesta->alert("Codigo de CUPON es incorrecto.");
		}
		
		return $oRespuesta;
	}	

	function anularCupones($idcupones = ''){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$idcupones = intval(_decode($idcupones));
		
		if(is_integer($idcupones) && $idcupones != 0){
			
			$cupones = new cupons($idcupones);
			
			$check_datos = cupons::_check_datos($idcupones,'pendiente-liquidacion-comercio');
			
			if($check_datos == ""){
				
				$check_datos = cupons::_check_datos($idcupones,'pendiente-liquidacion-usuario');
				
				if($check_datos == ""){
					
					$cupones->anular();	
					
					$oRespuesta->alert("Se anulo el cupon seleccionado.");
					
				    $script=" window.location.reload();";

				    $oRespuesta->script($script);
					
				}else{
					$oRespuesta->alert($check_datos);
				}
			}else {
				
				$oRespuesta->alert($check_datos);
			}
			
		}else{
			$oRespuesta->alert("Codigo de CUPON es incorrecto.");
		}
		
		return $oRespuesta;
	}
	
	function _elementoContinuosARRAY(){
		
	}
	
	function adelantarCuotas($datos){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();

		
		
		$idcupones = intval(_decode($datos['_ic']));
		
		if(!is_integer($idcupones) || $idcupones == 0){
			
			$oRespuesta->alert("codigo de cupon es incorrecto, por favor vuelva a intentar.");
			
		}else{
			
			$idcuentausuario = intval(_decode($datos['_icu']));
			
			if(is_integer($idcuentausuario) && $idcuentausuario != 0){
			
				//$idcuentausuario = $oMysql->consultaSel("SELECT fcn_getIdCuentaUsuarioCupones(\"{$idcupones}\");",true);
				
				$planpromo = $oMysql->consultaSel("CALL usp_getDatosPlanesPromocionesAsociadosCupones(\"$idcupones\");",true);
				
				$op_planpromo = $planpromo['tipoPlanPromo'];
				$idplanpromo  = $planpromo['idPlanPromo'];
				
				switch ($op_planpromo) {
					case "promociones":
		
							$apromociones = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$idplanpromo}\",\"promociones\");",true);
		
							if(!$apromociones){
								$dia_cierre 	= 0;
								$iDiferimiento 	= 0;
								$iCredito 		= 0;
								$iCompra 		= 0;
							}else{
								$dia_cierre 	= $apromociones['iDiaCierre'];
								$iDiferimiento 	= $apromociones['iDiferimientoUsuario'];
								$iCredito 		= $apromociones['iCredito'];
								$iCompra 		= $apromociones['iCompra'];
							}
							
		
						break;
					case "planes":
		
							$aplanes = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$idplanpromo}\",\"planes\");",true);
		
							if(!$aplanes){
								$dia_cierre 	= 0;
								$iDiferimiento 	= 0;
								$iCredito 		= 0;
								$iCompra 		= 0;
							}else{
								$dia_cierre 	= $aplanes['iDiaCierre'];
								$iDiferimiento 	= 0 ;
								$iCredito 		= $aplanes['iCredito'];
								$iCompra 		= $aplanes['iCompra'];
							}
		
						break;
					default: $dia_cierre = 0;
				}					
				
				
				$fecha_base = $oMysql->consultaSel("SELECT fcn_getUltimoPeriodoDetalleCuentaUsuario(\"{$idcuentausuario}\");",true);
			
				$array_fecha_base = explode("-",$fecha_base);
				
				$mes = $array_fecha_base[1] ;
				
				$anyo = $array_fecha_base[0];
				
				//$mktime = mktime(0,0,0,intval($mes),1,intval($anyo));
				
				$anyo_real = $anyo ;//intval(date("Y",$mktime));
				
				$mes_real = $mes ;//intval(date("m",$mktime));
				
				#determino periodo de cuota
				$fecha_cierre_usuario = $oMysql->consultaSel("SELECT fcn_getFechaCierreUsuario(\"$mes_real\",\"$anyo_real\",\"{$idcuentausuario}\");",true);
				
				if($fecha_cierre_usuario == '0000-00-00' || $fecha_cierre_usuario == false || $fecha_cierre_usuario == '1899-12-29'){

					$oRespuesta->alert("Lo siento, pero la cuenta tiene conflicto, por favor contacte con el admin.");

				}else{
					
					$ultima_fecha_cierre = $fecha_cierre_usuario ;
					
					$cantidadCuotasSolicitadas = intval($datos['iCantidadCuotas']);
					
					if(is_integer($cantidadCuotasSolicitadas) && $cantidadCuotasSolicitadas != 0){

						$sub_query = " WHERE DetallesCupones.idCupon = $idcupones AND DetallesCupones.iEstadoFacturacionUsuario = 0 ORDER BY DetallesCupones.dFechaFacturacionUsuario ASC";

						$detalles = $oMysql->consultaSel("CALL usp_getDetallesCupones(\"$sub_query\");");

						$cantidadCuotasAdelantadas = 0;

						$k = 1;
						
						$iCheckCorrimiento = false;
						$includeFirstDate = false;
						$dFirstDate = "";
						
						if(!$detalles){

							$oRespuesta->alert("Lo siento pero no encontramos cuotas para adelantar");

						}else{
							
							$cantidadPosibleParaAdelantar = sizeof($detalles);
							
							if($cantidadCuotasSolicitadas <= $cantidadPosibleParaAdelantar){

								foreach ($detalles as $cuotas){
									
									if($cantidadCuotasAdelantadas < $cantidadCuotasSolicitadas){
										#actualizo periodo
										
										if(!$includeFirstDate){
											$dFirstDate = $cuotas['dFechaLiquidacionComercioMySQL'];
											$includeFirstDate = true;
										}

										$set = "DetallesCupones.dFechaFacturacionUsuario='$fecha_cierre_usuario'";

										$values = "DetallesCupones.id='{$cuotas['id']}'";

										$toauditory = "cancelacion anticipada de planes (CUPONES) ::: idDetalleCupon = {$cuotas['id']}";

										$iduser = $_SESSION['id_user'];

										$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"DetallesCupones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"58\",\"$toauditory\");",true);						

										$cantidadCuotasAdelantadas = $cantidadCuotasAdelantadas + 1;
										
									}else{
										
										$cantidadCuotasAdelantadas = $cantidadCuotasAdelantadas + 1;#solo para asegurar que ya no entre por el si del IF
										
										#ya excedi la cantidad solicitada para adelantar, por lo tanto debo realizar corrimiento de fechas para las demas cuotas
										$mes = $array_fecha_base[1] + $k + $iDiferimiento;

										$anyo = $array_fecha_base[0];

										$mktime = mktime(0,0,0,intval($mes),1,intval($anyo));

										$anyo_real = intval(date("Y",$mktime));

										$mes_real = intval(date("m",$mktime));
										
										
										#####parte para controlar k no se excede de un posible diferimiento de la fecha
										
										if(!$iCheckCorrimiento){

											$mktime_fecha_proxima = $mktime;

											$aFechaFirstDate = explode("-",$dFirstDate);

											$mesx = $aFechaFirstDate[1]  ;

											$anyox = $aFechaFirstDate[0];

											$mktime_fecha_primera_cuota = mktime(0,0,0,intval($mesx),1,intval($anyox));

											if($mktime_fecha_proxima >= $mktime_fecha_primera_cuota){

												$iDiferimiento = 0;

											}
											
											
											#esto estaria en lo correcto
											$mes = $array_fecha_base[1] + $k + $iDiferimiento;
	
											$anyo = $array_fecha_base[0];
	
											$mktime = mktime(0,0,0,intval($mes),1,intval($anyo));
	
											$anyo_real = intval(date("Y",$mktime));
	
											$mes_real = intval(date("m",$mktime));	

											$iCheckCorrimiento = true;										
										}
									
										
										
										

										#determino periodo de cuota
										$fecha_cierre_usuario = $oMysql->consultaSel("SELECT fcn_getFechaCierreUsuario(\"$mes_real\",\"$anyo_real\",\"{$idcuentausuario}\");",true);						
										
										if($fecha_cierre_usuario == '0000-00-00' || $fecha_cierre_usuario == false || $fecha_cierre_usuario == '1899-12-29'){
											
											$array_uFechaCierre = explode("-",$ultima_fecha_cierre);
											
											$ultimo_dia_mes_real = intval(strftime("%d", mktime(0, 0, 0, $mes_real+1, 0, $anyo_real)));
											
											$array_uFechaCierre[2] = intval($array_uFechaCierre[2]);
											
											if($ultimo_dia_mes_real < $array_uFechaCierre[2]){
												$dia_real = $ultimo_dia_mes_real;
											}else{
												$dia_real = $array_uFechaCierre[2];
											}
											
											$fecha_cierre_usuario = $anyo_real . "-" . $mes_real . "-" . $dia_real;	
											
											$set = "DetallesCupones.dFechaFacturacionUsuario='$fecha_cierre_usuario'";
	
											$values = "DetallesCupones.id='{$cuotas['id']}'";
	
											$toauditory = "cancelacion anticipada de planes (CUPONES) - corrimiento de cuotas restantes ::: idDetalleCupon = {$cuotas['id']}";
	
											$iduser = $_SESSION['id_user'];
	
											$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"DetallesCupones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"58\",\"$toauditory\");",true);
										
										}else{

											$ultima_fecha_cierre = $fecha_cierre_usuario ;

											//$fecha_cierre_usuario = $anyo_real . "-" . $mes_real . "-" . $dia_real;	

											$set = "DetallesCupones.dFechaFacturacionUsuario='$fecha_cierre_usuario'";

											$values = "DetallesCupones.id='{$cuotas['id']}'";

											$toauditory = "cancelacion anticipada de planes (CUPONES) - corrimiento de cuotas restantes ::: idDetalleCupon = {$cuotas['id']}";

											$iduser = $_SESSION['id_user'];

											$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"DetallesCupones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"58\",\"$toauditory\");",true);

										}
										
										$k = $k + 1;
										
									}
									
								}
								
								$oRespuesta->alert("se ejecuto su operacion.");
								
								$script=" window.location.reload();";
				
								$oRespuesta->script($script);								

							}else{
								$oRespuesta->alert("No se puede adelantar la cantidad de cuotas solicitad.");
							}
								
						}
						
					}else{
						$oRespuesta->alert("La cantidad de cuotas solicitadas en incorrecta.");
					}
				
				}
				

				
				/*foreach ($datos['dc'] as $iddetallecupones){
					
					$id = intval(_decode($iddetallecupones));
	
					$set = "DetallesCupones.dFechaFacturacionUsuario='$fecha_cierre_usuario'";
				
					$values = "DetallesCupones.id='{$id}'";
				
					$toauditory = "cancelacion anticipada de planes (CUPONES) ::: idDetalleCupon = {$id}";
				
					$iduser = $_SESSION['id_user'];

					$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"DetallesCupones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"58\",\"$toauditory\");",true);

				}*/
				

				
				

			}else{
				$oRespuesta->alert("El codigo de cupon es incorrecto, por favor verifique");
			}
			


		}
		
		return $oRespuesta;
	}
	
	function retornarEstadoCuotas(){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		
		
		return $oRespuesta;
	}
	
	function agregarAjusteDescuentoUsuario($datos){
		global $oMysql;

		$dFecha =  date("Y-m-d"); 
		
		$dFechaProceso = date("Y-m-d");//dateToMySql($form["dFechaProceso"]);

		$idAjusteUsuario = 0;	
		
		//$datos['idCuentaUsuario'] = intval(_decode($datos['idCuentaUsuario']));

		$sCodigo=$oMysql->consultaSel("select fn_getCodigoAjusteUsuario();",true);

	  	   $set ="
	  	   		idCuentaUsuario,
	  	   		idTipoAjuste,
	  	   		idEmpleado,
	  	   		idTipoMoneda,
	  	   		dFecha,
	  	   		sCodigo,
	  	   		iCuotas,
	  	   		fImporteTotal,
	  	   		fImporteTotalInteres,
	  	   		fImporteTotalIVA,
	  	   		sEstado,
	  	   		iFacturado,
	  	   		idTasaIVA,
	  	   		fTotalFinal
	  	   		";

		   $values = "
		   		'{$datos['idCuentaUsuario']}',
		   		'{$datos['idTipoAjuste']}',		   	
		   		'{$_SESSION['id_user']}',
		   		'{$datos['idTipoMoneda']}',
		   		'{$dFecha}',
		   		'{$sCodigo}',
		   		'{$datos['iCuotas']}',
		   		'{$datos['fImporteTotal']}',
		   		'{$datos['fImporteTotalInteres']}',
		   		'{$datos['fImporteTotalIVA']}',
		   		'A',
		   		'0',
		   		'{$datos['idTasaIVA']}',
		   		'{$datos['fImporteTotalFinal']}'
		   		";

		   $fimporteConInteres = $datos['fImporteTotalInteres'] + $datos['fImporteTotal'];		 

		   $ToAuditory = "Insercion Ajuste de Usuario ::: Empleado ={$_SESSION['id_user']}";

		   $idAjusteUsuario = $oMysql->consultaSel("CALL usp_InsertTable(\"AjustesUsuarios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"59\",\"$ToAuditory\");",true);     

		  #Afectar Debito Credito en cuenta de usuario segun corresponda
		 $oMysql->consultaSel("CALL usp_updateDebitoCredito(\"{$datos['idCuentaUsuario']}\",\"C\",\"{$fimporteConInteres}\",\"{$datos['fImporteTotalIVA']}\");", true);
		//$oRespuesta->alert("CALL usp_updateDebitoCredito(\"{$form['idCuentaUsuario']}\",\"{$form['sClaseAjuste']}\",\"{$form['fImporteTotal']}\",\"{$form['fImporteTotalIVA']}\");");
	    
	    //----------- Insertar el detalle (cuotas) ----------------------------	    

		  $set = "(
	   				idEmpleado,
	   				idAjusteUsuario,
	   				iNumeroCuota,
	   				fImporteCuota,
	   				fImporteInteres,
	   				fImporteIVA,
	   				dFechaFacturacionUsuario
		   			)";
		   		        
		   $fImporteCuota = $datos['fImporteTotal'] / $datos['iCuotas'];
		   $fImporteInteres = $datos['fImporteTotalInteres'] / $datos['iCuotas'];
		   $fImporteIVA = $datos['fImporteTotalIVA'] / $datos['iCuotas'];
		   
		   #obtengo la fecha base (periodo) apartir de la cual generare las fechas de facturacion
	  	   $fecha_base = $oMysql->consultaSel("SELECT fcn_getUltimoPeriodoDetalleCuentaUsuario(\"{$datos['idCuentaUsuario']}\");",true);		  
	  	   $array_fecha_base = explode("-",$fecha_base);	  	
	  	   $ultima_fecha_cierre = "";
	  	   $iDiferimiento= $datos['iDiferimientoUsuario'];
	  	   	
	  	   for($i=1; $i<= $datos['iCuotas']; $i++ )
		   {
		   		 #obtengo mees y anio para buscar fecha de cierre asociado a cuenta de usuario
				$mes = $array_fecha_base[1] + ($i - 1) + $iDiferimiento;
			
				$anyo = $array_fecha_base[0];
			
				$mktime = mktime(0,0,0,intval($mes),1,intval($anyo));
			
				$anyo_real = intval(date("Y",$mktime));
			
				$mes_real = intval(date("m",$mktime));
			
				#determino periodo de cuota				
								
				$fecha_cierre_usuario = $oMysql->consultaSel("SELECT fcn_getFechaCierreUsuario(\"$mes_real\",\"$anyo_real\",\"{$datos['idCuentaUsuario']}\");",true);
				//var_export("SELECT fcn_getFechaCierreUsuario(\"$mes_real\",\"$anyo_real\",\"{$datos['idCuentaUsuario']}\");");die();	
				
				if($fecha_cierre_usuario == '0000-00-00' || $fecha_cierre_usuario == false || $fecha_cierre_usuario == '1899-12-29')
				{
					// No existe fechaCierre
					$array_uFechaCierre = explode("-",$ultima_fecha_cierre);
				
					$ultimo_dia_mes_real = intval(strftime("%d", mktime(0, 0, 0, $mes_real+1, 0, $anyo_real)));
					
					$array_uFechaCierre[2] = intval($array_uFechaCierre[2]);
					
					if($ultimo_dia_mes_real < $array_uFechaCierre[2]){
						$dia_real = $ultimo_dia_mes_real;
					}else{
						$dia_real = $array_uFechaCierre[2];
					}
					
					$fecha_cierre_usuario = $anyo_real . "-" . $mes_real . "-" . $dia_real;
					
					$valuesCuotas .= "
		   					(
		   						'{$_SESSION['id_user']}',
								'{$idAjusteUsuario}',
								'{$i}',
								'{$fImporteCuota}',
								'{$fImporteInteres}',
   			   					'{$fImporteIVA}',
   			   					'{$fecha_cierre_usuario}'
		   					)";
		   		
		   			if($i < $datos['iCuotas'])
		   			{
						$valuesCuotas .= ",";	   			
		   			}				   		 
					
				}
				else // Existe fechaCierre
				{	
					$ultima_fecha_cierre = $fecha_cierre_usuario ;
					
		   			$valuesCuotas .= "
		   					(
		   						'{$_SESSION['id_user']}',
								'{$idAjusteUsuario}',
								'{$i}',
								'{$fImporteCuota}',
								'{$fImporteInteres}',
   			   					'{$fImporteIVA}',
   			   					'{$fecha_cierre_usuario}'
		   					)";
		   		
		   			if($i < $datos['iCuotas'])
		   			{
						$valuesCuotas .= ",";	   			
		   			}				   		 
		   		}
		   }
	    	//var_export("CALL usp_abm_General(\"DetallesAjustesUsuarios\",\"$set\",\"$valuesCuotas\",\"1\",\"{$_SESSION['id_user']}\",\"61\",\"$ToAuditory\");");die();	
		   $ToAuditory = "Insercion Detalle de Ajuste de Usuario ::: Empleado ={$_SESSION['id_user']}"; 
	       $id = $oMysql->consultaSel("CALL usp_abm_General(\"DetallesAjustesUsuarios\",\"$set\",\"$valuesCuotas\",\"1\",\"{$_SESSION['id_user']}\",\"61\",\"$ToAuditory\");",true);

	    	//--------------------- fin insertar detalle ----------------------------------------------------
			
	}	
	
	
	function proccessMorosidadUsuarios($idgrupoafinidad=0,$importe_minimo = 0){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
				
		//$tabla_resultados = _morosidadUsuarios2($idgrupoafinidad,$importe_minimo,0,4000);
		$tabla_resultados = _morosidadUsuarios2($idgrupoafinidad,$importe_minimo,0,4000);
		//$tabla_resultados = _morosidadUsuarios2($idgrupoafinidad,$importe_minimo,8000,3180);
		//$tabla_resultados = _morosidadUsuarios2($idgrupoafinidad,$importe_minimo,12000,4000);

		
		//$tabla_resultados = _morosidadUsuarios($idgrupoafinidad,$importe_minimo);
		
		$oRespuesta->assign("resultado_morosidad","innerHTML","");

		$oRespuesta->alert("se termino de ejecutar proceso de morosidad.");
		
		return $oRespuesta;
	}
	
	
	#funcion k ejecuta proceso de morosidad de usuarios, devuelve html, tabla de resultados
	function _morosidadUsuarios($idgrupoafinidad=0,$importe_minimo=0){
		global $oMysql;
		
		ini_set("memory_limit","512M");
		
		$idgrupoafinidad = intval(_decode($idgrupoafinidad));
		
		$break = "<br />";//chr(13);
		
		$estado_cuenta_normal = 1;
		$estado_cuenta_moroso_1_mes = 3;
		$estado_cuenta_moroso_2_mes = 4;
		$estado_cuenta_moroso_3_mes = 5;
		$estado_cuenta_inhabilitada = 10;
		$estado_cuenta_inhabilitada_con_cobranza = 13;
		$estado_cuenta_previsionada = 11;
		$estado_cuenta_previosionada_con_cobranza = 14;
		$estado_cuenta_prelegales = 15;
		$estado_cuenta_gestion_judicial = 16;
		
		
		$importe_minimo = floatval($importe_minimo);
		
		if($idgrupoafinidad != 0 && is_integer($idgrupoafinidad))
		{
			
			#iniciamos log de morosidad
			$idLog = _iniciarLogMorosidad('inicio de proceso de morosidad ::: GRUPO AFINIDAD ::: ' . $idgrupoafinidad);			
			
			//$o = " AND CuentasUsuarios.id IN(183)";//180,181,186,
			
			$sub_query = " WHERE CuentasUsuarios.idGrupoAfinidad = $idgrupoafinidad AND CuentasUsuarios.idTipoEstadoCuenta NOT IN (12, 10, 15,16)";
			
			$cuentasusuarios = $oMysql->consultaSel("CALL usp_getCuentasUsuarios(\"$sub_query\");");			
			
			
			if(!$cuentasusuarios)
			{
				//_terminarLogMorosidad('No se obtuvieron Cuentas de Usuarios asociado a Grupo de Afinidad :' . $idgrupoafinidad, $idLog, 'alerta');
				
			}
			else
			{				
				$cantidad_registros = sizeof($cuentasusuarios);
				
				//_updateLogMorosidad($idLog,$break . 'se encontraron ' . $cantidad_registros . ' cuentas de usuarios asociado al grupo de afinidad ' . $idgrupoafinidad );			
				
				$Contador += $limitDesde; 
				
				foreach ($cuentasusuarios as $cuentausuario)
				{
					$Contador++;
					
					#iniciamos log para proceso de cuenta usuario
					$idLogCuentaUsuario = 
					_iniciarLogMorosidad("inicio proceso morosida para cuenta usuario nro. ::: {$cuentausuario['sNumeroCuenta']} (id: {$cuentausuario['sNumeroCuenta']}) (nro. $Contador)",'iniciado',$idLog,$cuentausuario['id']);
					
					#obtengo datos, fecha Cierre, Vencimiento, Mora de periodo anterior  y actual
					$sub_query = " WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$cuentausuario['id']} ORDER BY DetallesCuentasUsuarios.id DESC LIMIT 0,2";
					$detallescuentasusuarios = $oMysql->consultaSel("CALL usp_getDetallesCuentasUsuarios(\"$sub_query\");");
					
					$detallescuentausuario0 = $detallescuentasusuarios[0];#periodo actual
					$detallescuentausuario1 = $detallescuentasusuarios[1];#periodo anterior
					
					$detallescuentausuario0['fAcumuladoCobranza'] = floatval($detallescuentausuario0['fAcumuladoCobranza']);
					$detallescuentausuario0['fSaldoAnterior'] = floatval($detallescuentausuario0['fSaldoAnterior']);
					
					#le agrego el importe minimo					
					//$dFechaVencimiento = dateToMySql($detallescuentasusuarios[0]['dFechaVencimiento']);
					//$fAcumuladoCobranza = $oMysql->consultaSel("SELECT fnc_getCobranzasAcumuladas(\"{$cuentausuario['id']}\",\"{$dFechaVencimiento}\");",true);
					
					//$detallescuentausuario0['fAcumuladoCobranza'] = $fAcumuladoCobranza + $importe_minimo;
					
					$detallescuentausuario0['fAcumuladoCobranza'] = $detallescuentausuario0['fAcumuladoCobranza'] + $importe_minimo;
					
					//var_export($detallescuentausuario1);die();
					if($detallescuentausuario0['fAcumuladoCobranza'] >= $detallescuentausuario0['fSaldoAnterior'])
					{
						
						$message = $break . "Acumulado Cobranzas({$detallescuentausuario0['fAcumuladoCobranza']}) es SUPERIOR a Saldo anterior(Importe Exigible-Saldo anterior({$detallescuentausuario0['fSaldoAnterior']})";
						
						//_updateLogMorosidad($idLogCuentaUsuario,$message);
						
						if($detallescuentausuario0['iDiasMora'] < 91)
						{
							$message = $break . "Dias de Mora {$detallescuentausuario0['iDiasMora']} < 91, iniciado cambio de estado en cuenta y cantidad de dias mora";
							
							//_updateLogMorosidad($idLogCuentaUsuario,$message);
							
							
							//_cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_normal,0);
							
							
							$message = $break . "terminado cambio de estado de cuenta y cantidad de dias mora. Iniciado proceso de registro en tabla morosidad";
							
							//_updateLogMorosidad($idLogCuentaUsuario,$message);
							
							
							//_agregarRegistroMorosidad($cuentausuario['id'],$detallescuentausuario0['iDiasMora'],0,$detallescuentausuario0['fSaldoAnterior'],$detallescuentausuario0['fImporteTotalPesos'],$detallescuentausuario0['fAcumuladoCobranzas'],$_SESSION['id_user'],$cuentausuario['idTipoEstadoCuenta'],$estado_cuenta_normal);
							
							
							$message = $break . "terminado proceso de registro en tabla morosidad";
							
							//_updateLogMorosidad($idLogCuentaUsuario,$message);
							
							
						}
						elseif($detallescuentausuario0['iDiasMora']>=91 && $detallescuentausuario0['iDiasMora']<120 )
						{

							$message = $break . "Dias de Mora {$detallescuentausuario0['iDiasMora']} >= 91 y <=120 , iniciado cambio de estado en cuenta y cantidad de dias mora";

							//_updateLogMorosidad($idLogCuentaUsuario,$message);


							_cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_normal,0);


							$message = $break . "terminado cambio de estado de cuenta y cantidad de dias mora. Iniciado proceso de registro en tabla morosidad";

							//_updateLogMorosidad($idLogCuentaUsuario,$message);


							_agregarRegistroMorosidad($cuentausuario['id'],$detallescuentausuario0['iDiasMora'],0,$detallescuentausuario0['fSaldoAnterior'],$detallescuentausuario0['fImporteTotalPesos'],$detallescuentausuario0['fAcumuladoCobranzas'],$_SESSION['id_user'],$cuentausuario['idTipoEstadoCuenta'],$estado_cuenta_normal);


							$message = $break . "terminado proceso de registro en tabla morosidad";

							//_updateLogMorosidad($idLogCuentaUsuario,$message);

							#cambiar las fechas de las cuotas
							$fecha_cierre = dateToMySql($detallescuentausuario0['dFechaCierre']);
							
							$message = $break . "generando ultimo resumen, por pasar a estado inhabilitado";
							
							//_updateLogMorosidad($idLogCuentaUsuario,$message);
							
							//_generarUltimoResumen($cuentausuario['id'],$fecha_cierre);
							
							//$message = $break . "terminado proceso de generacion de resumen";
							
							//_updateLogMorosidad($idLogCuentaUsuario,$message);								
						}
						else
						{
							if($cuentausuario['idTipoEstadoCuenta'] == $estado_cuenta_inhabilitada)
							{
								$message = $break . "Dias de Mora {$detallescuentausuario0['iDiasMora']} > 120 , iniciado cambio de estado en cuenta (->inhabilitado con concobranza) y cantidad de dias mora(permanece igual)";
								
								//_updateLogMorosidad($idLogCuentaUsuario,$message);
								
								
								_cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_inhabilitada_con_cobranza,$detallescuentausuario0['iDiasMora']);
								
								
								$message = $break . "terminado cambio de estado de cuenta y cantidad de dias mora. Iniciado proceso de registro en tabla morosidad";
								
								//_updateLogMorosidad($idLogCuentaUsuario,$message);
								
								
								_agregarRegistroMorosidad($cuentausuario['id'],$detallescuentausuario0['iDiasMora'],0,$detallescuentausuario0['fSaldoAnterior'],$detallescuentausuario0['fImporteTotalPesos'],$detallescuentausuario0['fAcumuladoCobranzas'],$_SESSION['id_user'],$cuentausuario['idTipoEstadoCuenta'],$estado_cuenta_inhabilitada_con_cobranza);
								
								
								$message = $break . "terminado proceso de registro en tabla morosidad";
								
								//_updateLogMorosidad($idLogCuentaUsuario,$message);								
							}
							
							if($cuentausuario['idTipoEstadoCuenta'] == $estado_cuenta_previsionada)
							{
								$message = $break . "Dias de Mora {$detallescuentausuario0['iDiasMora']} > 120 y estado es previsionada , iniciado cambio de estado en cuenta (->previsionada con concobranza) y cantidad de dias mora(permanece igual)";
								
								//_updateLogMorosidad($idLogCuentaUsuario,$message);
								
								
								_cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_inhabilitada_con_cobranza,$detallescuentausuario0['iDiasMora']);
								
								
								$message = $break . "terminado cambio de estado de cuenta y cantidad de dias mora. Iniciado proceso de registro en tabla morosidad";
								
								//_updateLogMorosidad($idLogCuentaUsuario,$message);
								
								
								//_agregarRegistroMorosidad($cuentausuario['id'],$detallescuentausuario0['iDiasMora'],0,$detallescuentausuario0['fSaldoAnterior'],$detallescuentausuario0['fImporteTotalPesos'],$detallescuentausuario0['fAcumuladoCobranzas'],$_SESSION['id_user'],$cuentausuario['idTipoEstadoCuenta'],$estado_cuenta_previosionada_con_cobranza);
								
								
								$message = $break . "terminado proceso de registro en tabla morosidad";
								
								//_updateLogMorosidad($idLogCuentaUsuario,$message);								
							}
						}
					}
					else
					{
						#las cobranzas son menores k importe exigible
						
						$message = $break . "Acumulado Cobranzas es INFERIOR a Saldo anterior(Importe Exigible)";
						
						//_updateLogMorosidad($idLogCuentaUsuario,$message);						
						
						if($detallescuentausuario0['iDiasMora'] == 0)
						{
								$diasMora = diasEntreFechas($detallescuentausuario0['dFechaVencimiento'],$detallescuentausuario0['dFechaMora']);
								
								//$diasMora = diasEntreFechas('15/03/2012','16/03/2012');
								
								//var_export($detallescuentausuario0['dFechaVencimiento']."---".$detallescuentausuario0['dFechaMora']);die();
								$diasMora = $detallescuentausuario0['iDiasMora'] + $diasMora;
								
								$message = $break . "Tenia Dias de Mora = 0 , iniciado cambio de estado en cuenta (->moroso 1 mes) y cantidad de dias mora(diferencia entre vto y corrida de mora -> $diasMora)";
								
								//_updateLogMorosidad($idLogCuentaUsuario,$message);
								
								
								$boolean = _cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_moroso_1_mes,$diasMora);
								

								$message = $break . "terminado cambio de estado de cuenta y cantidad de dias mora. Iniciado proceso de registro en tabla morosidad";

								//_updateLogMorosidad($idLogCuentaUsuario,$message);


								_agregarRegistroMorosidad($cuentausuario['id'],$detallescuentausuario0['iDiasMora'],$diasMora,$detallescuentausuario0['fSaldoAnterior'],$detallescuentausuario0['fImporteTotalPesos'],$detallescuentausuario0['fAcumuladoCobranzas'],$_SESSION['id_user'],$cuentausuario['idTipoEstadoCuenta'],$estado_cuenta_moroso_1_mes);


								$message = $break . "terminado proceso de registro en tabla morosidad";

								//_updateLogMorosidad($idLogCuentaUsuario,$message);
							
						}
						else
						{
								$diasMora = diasEntreFechas($detallescuentausuario1['dFechaMora'],$detallescuentausuario0['dFechaMora']);
								//$diasMora = diasEntreFechas('16/02/2012','16/03/2012');
									
								$diasMora = $detallescuentausuario0['iDiasMora'] + $diasMora;
								
								if($diasMora>=1 && $diasMora < 31){
									
									$message = $break . "Dias de Mora >= 1 y < 31, iniciado cambio de estado en cuenta (->moroso 1 mes) y cantidad de dias mora(diferencia entre corridas de mora -> $diasMora)";
									
									//_updateLogMorosidad($idLogCuentaUsuario,$message);
									
									
									$boolean = _cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_moroso_1_mes,$diasMora);
								}
								
								if($diasMora>=31 && $diasMora < 61){
									
									$message = $break . "Dias de Mora >= 31 y < 61, iniciado cambio de estado en cuenta (->moroso 2 meses) y cantidad de dias mora(diferencia entre corridas de mora -> $diasMora)";
									
									//_updateLogMorosidad($idLogCuentaUsuario,$message);

																	
									$boolean = _cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_moroso_2_mes,$diasMora);
								}
								
								if($diasMora>=61 && $diasMora < 91){
									
									$message = $break . "Dias de Mora >= 61 y < 91, iniciado cambio de estado en cuenta (->moroso 3 meses) y cantidad de dias mora(diferencia entre corridas de mora -> $diasMora)";
									
									//_updateLogMorosidad($idLogCuentaUsuario,$message);

																	
									$boolean = _cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_moroso_3_mes,$diasMora);
								}
								
								if($diasMora>=91 && $diasMora < 540){
									$message = $break . "Dias de Mora >= 91 y < 540, iniciado cambio de estado en cuenta (->inhabiliada) y cantidad de dias mora(diferencia entre corridas de mora -> $diasMora)";
									
									//_updateLogMorosidad($idLogCuentaUsuario,$message);
									
									
									$boolean = _cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_inhabilitada,$diasMora);
									
									#codigo para modificar fecha de consumos a fecha de actual periodo(marcamos todo para k salga en un unico resumen)
									$fecha_cierre = dateToMySql($detallescuentausuario0['dFechaCierre']);
									
									//$message = $break . "generando ultimo resumen, por pasar a estado inhabilitado";
									
									//_updateLogMorosidad($idLogCuentaUsuario,$message);
									
									//_generarUltimoResumen($cuentausuario['id'],$fecha_cierre);
									
									//$message = $break . "terminado proceso de generacion de resumen";
									
									//_updateLogMorosidad($idLogCuentaUsuario,$message);
									
								}
								
								if($diasMora>=541){
									$message = $break . "Dias de Mora >= 541 , iniciado cambio de estado en cuenta (->previsionado) y cantidad de dias mora(diferencia entre corridas de mora -> $diasMora)";
									
									//_updateLogMorosidad($idLogCuentaUsuario,$message);


									$boolean = _cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_previsionada,$diasMora);
								}
								
								
								$message = $break . "terminado cambio de estado de cuenta y cantidad de dias mora. Iniciado proceso de registro en tabla morosidad";

							//	_updateLogMorosidad($idLogCuentaUsuario,$message);
								
								#agrego registro en tabla morosidad
								_agregarRegistroMorosidad($cuentausuario['id'],$detallescuentausuario0['iDiasMora'],$diasMora,$detallescuentausuario0['fSaldoAnterior'],$detallescuentausuario0['fImporteTotalPesos'],$detallescuentausuario0['fAcumuladoCobranzas'],$_SESSION['id_user'],$cuentausuario['idTipoEstadoCuenta'],$estado_cuenta_moroso_1_mes);



								
						}
						
						$message = $break . "terminado proceso de registro en tabla morosidad";

						//_updateLogMorosidad($idLogCuentaUsuario,$message);						
						
					}
					
					_terminarLogMorosidad($break . 'se termino de procesar morosidad a cuenta de usuario ' . $cuentausuario['sNumeroCuenta'], $idLogCuentaUsuario,'terminado');

				}
				
				_terminarLogMorosidad($break . 'se terminno de procesar Cuentas de Usuarios asociado a Grupo de Afinidad :' . $idgrupoafinidad, $idLog, 'terminado');
			}
			
		}
		else
		{
			$idLog = _iniciarLogMorosidad('sucedio un error al intenar correr proceso de mora para Grupo de afinidad ::: ' . $idgrupoafinidad ,'alerta');
		}
	}
	
	
	
	/*------------------------- Correccion del proceso de morosidad ---------------------------------------------------------------------*/

	#funcion k ejecuta proceso de morosidad de usuarios, devuelve html, tabla de resultados
	function _morosidadUsuarios2($idgrupoafinidad=0,$importe_minimo=0, $limitDesde, $limitHasta)
	{
		global $oMysql;
		
		$idgrupoafinidad = intval(_decode($idgrupoafinidad));
		
		ini_set("memory_limit","256M");
		
		$break = "<br />";//chr(13);
		
		$estado_cuenta_normal = 1;
		$estado_cuenta_moroso_1_mes = 3;
		$estado_cuenta_moroso_2_mes = 4;
		$estado_cuenta_moroso_3_mes = 5;
		$estado_cuenta_moroso_1_mes_con_convenio = 7;
		$estado_cuenta_moroso_2_meses_con_convenio = 8;
		$estado_cuenta_moroso_3_meses_con_convenio = 9;
		$estado_cuenta_inhabilitada = 10;
		$estado_cuenta_previsionada = 11;
		$estado_cuenta_baja = 12;
		$estado_cuenta_inhabilitada_con_cobranza = 13;
		$estado_cuenta_previosionada_con_cobranza = 14;
		$estado_cuenta_prelegales = 15;
		$estado_cuenta_gestion_judicial = 16;
		
		$importe_minimo = floatval($importe_minimo);
		
		if($idgrupoafinidad != 0 && is_integer($idgrupoafinidad))
		{
			#iniciamos log de morosidad
			$idLog = _iniciarLogMorosidad('inicio de proceso de morosidad ::: GRUPO AFINIDAD ::: ' . $idgrupoafinidad);			
			
			//$o = " AND CuentasUsuarios.id IN(183)";//180,181,186,
			
			$sub_query = " 
							WHERE CuentasUsuarios.idGrupoAfinidad = $idgrupoafinidad 
							AND CuentasUsuarios.idTipoEstadoCuenta 
								in 
								(
									$estado_cuenta_normal,
									$estado_cuenta_moroso_1_mes,
									$estado_cuenta_moroso_2_mes,
									$estado_cuenta_moroso_3_mes
								)  
								LIMIT $limitDesde, $limitHasta;
							";
			
			
			$cuentasusuarios = $oMysql->consultaSel("CALL usp_getCuentasUsuarios(\"$sub_query\");");			
			
			
			if(!$cuentasusuarios)
			{
				_terminarLogMorosidad('No se obtuvieron Cuentas de Usuarios asociado a Grupo de Afinidad :' . $idgrupoafinidad, $idLog, 'alerta');
				
			}
			else
			{				
				$cantidad_registros = sizeof($cuentasusuarios);
								
				$Contador += $limitDesde; 
				
				foreach ($cuentasusuarios as $cuentausuario)
				{
					$Contador++;
					
					#iniciamos log para proceso de cuenta usuario
					$idLogCuentaUsuario = 
					_iniciarLogMorosidad("inicio proceso morosida para cuenta usuario nro. ::: {$cuentausuario['sNumeroCuenta']} (id: {$cuentausuario['id']}) (nro. $Contador)",'iniciado',$idLog,$cuentausuario['id']);
					
					#obtengo datos, fecha Cierre, Vencimiento, Mora de periodo anterior  y actual
					$sub_query = " WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$cuentausuario['id']} ORDER BY DetallesCuentasUsuarios.id DESC LIMIT 0,2";
					$detallescuentasusuarios = $oMysql->consultaSel("CALL usp_getDetallesCuentasUsuarios(\"$sub_query\");");
					
					$detallescuentausuario0 = $detallescuentasusuarios[0];#periodo actual
					$detallescuentausuario1 = $detallescuentasusuarios[1];#periodo anterior
					
					$detallescuentausuario0['fAcumuladoCobranza'] = floatval($detallescuentausuario0['fAcumuladoCobranza']);
					$detallescuentausuario0['fSaldoAnterior'] = floatval($detallescuentausuario0['fSaldoAnterior']);
					
					#le agrego el importe minimo										
					$detallescuentausuario0['fAcumuladoCobranza'] = $detallescuentausuario0['fAcumuladoCobranza'] + $importe_minimo;
					
					if($detallescuentausuario0['fAcumuladoCobranza'] >= $detallescuentausuario0['fSaldoAnterior'])
					{
												
						if($detallescuentausuario0['iDiasMora'] < 91)
						{
							_cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_normal,0);
						}
						elseif($detallescuentausuario0['iDiasMora']>=91 && $detallescuentausuario0['iDiasMora']<120 )
						{

							_cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_normal,0);

							_agregarRegistroMorosidad($cuentausuario['id'],$detallescuentausuario0['iDiasMora'],0,$detallescuentausuario0['fSaldoAnterior'],$detallescuentausuario0['fImporteTotalPesos'],$detallescuentausuario0['fAcumuladoCobranzas'],$_SESSION['id_user'],$cuentausuario['idTipoEstadoCuenta'],$estado_cuenta_normal);

							#cambiar las fechas de las cuotas
							$fecha_cierre = dateToMySql($detallescuentausuario0['dFechaCierre']);											
						}
						else
						{
							if($cuentausuario['idTipoEstadoCuenta'] == $estado_cuenta_inhabilitada)
							{
								_cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_inhabilitada_con_cobranza,$detallescuentausuario0['iDiasMora']);
								
								_agregarRegistroMorosidad($cuentausuario['id'],$detallescuentausuario0['iDiasMora'],0,$detallescuentausuario0['fSaldoAnterior'],$detallescuentausuario0['fImporteTotalPesos'],$detallescuentausuario0['fAcumuladoCobranzas'],$_SESSION['id_user'],$cuentausuario['idTipoEstadoCuenta'],$estado_cuenta_inhabilitada_con_cobranza);
														
							}
							
							if($cuentausuario['idTipoEstadoCuenta'] == $estado_cuenta_previsionada)
							{								
								_cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_inhabilitada_con_cobranza,$detallescuentausuario0['iDiasMora']);														
							}
						}
					}
					else
					{
						#las cobranzas son menores k importe exigible	
						
						if($detallescuentausuario0['iDiasMora'] == 0)
						{
								//-- 09/03/2012 18:07 (Maxi) Modificacion para que tome correctamente la fehca de Vencimiento y Mora ------------------------
								
								$dFechaVencimientoActual = dateToMySql($detallescuentausuario0['dFechaVencimiento']);									
								$dFechaVencimientoReal = 
								 	$oMysql->consultaSel("SELECT fnc_getFechaVencimientoAnterior(\"{$dFechaVencimientoActual}\",\"{$detallescuentausuario0['idCuentaUsuario']}\",\"{$idgrupoafinidad}\");",true);
									
								$dFechaMoraActual = dateToMySql($detallescuentausuario0['dFechaMora']);									
								$dFechaCorridaMoraActual =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraActual}\",\"{$detallescuentausuario0['idCuentaUsuario']}\",\"{$idgrupoafinidad}\");",true);
								
								$diasMora = diasEntreFechas($dFechaVencimientoReal, $dFechaCorridaMoraActual);	
								
								//$diasMora = diasEntreFechas($detallescuentausuario0['dFechaVencimiento'],$detallescuentausuario0['dFechaMora']);	
								//$diasMora = diasEntreFechas('15/03/2012','16/03/2012');
															
								$diasMora = $detallescuentausuario0['iDiasMora'] + $diasMora;
								
								$boolean = _cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_moroso_1_mes,$diasMora);

								_agregarRegistroMorosidad($cuentausuario['id'],$detallescuentausuario0['iDiasMora'],$diasMora,$detallescuentausuario0['fSaldoAnterior'],$detallescuentausuario0['fImporteTotalPesos'],$detallescuentausuario0['fAcumuladoCobranzas'],$_SESSION['id_user'],$cuentausuario['idTipoEstadoCuenta'],$estado_cuenta_moroso_1_mes);

						}
						else
						{		
								//---- 09/03/12 18:10 (Maxi) Modificacion para que tome correctamente las Fechas de Corridas de Mora --------------	
								
								$dFechaMoraActual = dateToMySql($detallescuentausuario0['dFechaMora']);									
								$dFechaCorridaMoraActual =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraActual}\",\"{$detallescuentausuario0['idCuentaUsuario']}\",\"{$idgrupoafinidad}\");",true);
									
								$dFechaMoraAnterior = dateToMySql($detallescuentausuario1['dFechaMora']);									
								$dFechaCorridaMoraAnterior =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraAnterior}\",\"{$detallescuentausuario1['idCuentaUsuario']}\",\"{$idgrupoafinidad}\");",true);
																																	
								$diasMora = diasEntreFechas($dFechaCorridaMoraAnterior, $dFechaCorridaMoraActual);
								
								
								//--------- 15/05/2012 (Maxi)--------------
								
								if($diasMora >= 28 && $diasMora <= 30)
									$diasMora = 30;
								
								//------------------------------------------------------------------------------------------------------------------
								
								//$diasMora = diasEntreFechas($detallescuentausuario1['dFechaMora'],$detallescuentausuario0['dFechaMora']);
								//$diasMora = diasEntreFechas('16/02/2012','16/03/2012');
									
								$diasMora = $detallescuentausuario0['iDiasMora'] + $diasMora;
								
								if($diasMora>=1 && $diasMora < 31){
									
									$message = $break . "Dias de Mora >= 1 y < 31, iniciado cambio de estado en cuenta (->moroso 1 mes) y cantidad de dias mora(diferencia entre corridas de mora -> $diasMora)";
									
									$boolean = _cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_moroso_1_mes,$diasMora);
								}
								
								if($diasMora>=31 && $diasMora < 61){									
									$boolean = _cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_moroso_2_mes,$diasMora);
								}
								
								if($diasMora>=61 && $diasMora < 91){								
									$boolean = _cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_moroso_3_mes,$diasMora);
								}
								
								if($diasMora>=91 && $diasMora < 540){
									$boolean = _cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_inhabilitada,$diasMora);
									
									#codigo para modificar fecha de consumos a fecha de actual periodo(marcamos todo para k salga en un unico resumen)
									$fecha_cierre = dateToMySql($detallescuentausuario0['dFechaCierre']);
									
								}
								
								if($diasMora>=541){				
									$boolean = _cambiarMorayEstadoCuentaUsuario($cuentausuario['id'],$detallescuentausuario0['id'],$estado_cuenta_previsionada,$diasMora);
								}
																
								#agrego registro en tabla morosidad
								_agregarRegistroMorosidad($cuentausuario['id'],$detallescuentausuario0['iDiasMora'],$diasMora,$detallescuentausuario0['fSaldoAnterior'],$detallescuentausuario0['fImporteTotalPesos'],$detallescuentausuario0['fAcumuladoCobranzas'],$_SESSION['id_user'],$cuentausuario['idTipoEstadoCuenta'],$estado_cuenta_moroso_1_mes);
		
						}			
						
					}
					
					_terminarLogMorosidad($break . 'se termino de procesar morosidad a cuenta de usuario ' . $cuentausuario['sNumeroCuenta'], $idLogCuentaUsuario,'terminado');

				}
				
				_terminarLogMorosidad($break . 'se terminno de procesar Cuentas de Usuarios asociado a Grupo de Afinidad :' . $idgrupoafinidad, $idLog, 'terminado');
			}
			
		}
		else
		{
			$idLog = _iniciarLogMorosidad('sucedio un error al intenar correr proceso de mora para Grupo de afinidad ::: ' . $idgrupoafinidad ,'alerta');
		}
	}
	/*--------------------------------------------------------------------------------------------------------------------------------------------------*/
	
	
	
	
	
	function _sumatoriaCobranzasCuentaUsuario($idcuentausuario = 0,$fecha_desde='',$fecha_hasta=''){
		global $oMysql;
		#formato $fecha_desde = YYYY-mm-dd
		#formato $fecha_hasta = YYYY-mm-dd
		
		$sumatoria = 0;
		
		$sub_query = " WHERE Cobranzas.idCuentaUsuario=$idcuentausuario AND UNIX_TIMESTAMP(Cobranzas.dFechaCobranza) > UNIX_TIMESTAMP('$fecha_desde') AND UNIX_TIMESTAMP(Cobranzas.dFechaCobranza) < UNIX_TIMESTAMP('$fecha_hasta')";
		
		$cobranzas = $oMysql->consultaSel("CALL usp_getCobranzas(\"$sub_query\");");
		
		if(!$cobranzas){
			#no hay registros
		}else{
			foreach ($cobranzas as $cobranza) {
				$sumatoria = $sumatoria + $cobranza['fImporte'];
			}
		}
		
		
		return $sumatoria ;
	}
	
	function _iniciarLogMorosidad($observaciones='',$estado='iniciado',$idLog=0,$idcuentausuario=0){
		global $oMysql;
		
		$set = "
				dFechaHoraInicio,
				dFechaHoraFin,
				sObservaciones,
				sEstado,
				idLog,
				idCuentaUsuario
			   ";

		$values = "
					NOW(),
					'',
					'$observaciones',
					'$estado',
					'$idLog',
					'$idcuentausuario'
				  ";
		
		
		$idLog = $oMysql->consultaSel("CALL usp_InsertValues(\"BackLogMorosidad\",\"$set\",\"$values\");",true);
		
		return $idLog ;

	}
	
	function _updateLogMorosidad($idLog = 0,$observaciones=''){
		global $oMysql;

		$set = "BackLogMorosidad.sObservaciones = CONCAT(BackLogMorosidad.sObservaciones,'$observaciones')";

		$values = "BackLogMorosidad.id='$idLog'";

		$toauditory = "se agrego observaciones a LOG de Proceso de Morosidad";

		$id = $oMysql->consultaSel("CALL usp_UpdateValues(\"BackLogMorosidad\",\"$set\",\"$values\");",true);
		
	}
	
	function _terminarLogMorosidad($observaciones='',$idLog = 0,$estado='terminado'){
		global $oMysql;
		
		$set = "BackLogMorosidad.dFechaHoraFin=NOW(), BackLogMorosidad.sObservaciones=CONCAT(BackLogMorosidad.sObservaciones,'$observaciones'), BackLogMorosidad.sEstado='$estado'";

		$values = "BackLogMorosidad.id='$idLog'";

		$toauditory = "se finalizo LOG de Proceso de Morosidad";
		//var_export("CALL usp_UpdateValues(\"BackLogMorosidad\",\"$set\",\"$values\");");die();
		$id = $oMysql->consultaSel("CALL usp_UpdateValues(\"BackLogMorosidad\",\"$set\",\"$values\");",true);
	}

	function _agregarRegistroMorosidad($idCuentaUsuario=0,$iDiasMoraActual=0,$iDiasMoraNueva=0,$fImportePagoMinimo=0,$fImporteTotalResumenUsuario=0,$fImporteTotalCobranzasUsuario=0,$idEmpleado=0,$idEstadoCuentaActual=0,$idEstadoCuentaNuevo=0){
		global $oMysql;
		
		$set = "
				idCuentaUsuario,
				iDiasMoraActual,
				iDiasMoraNueva,
				fImportePagoMinimo,
				fImporteTotalResumenUsuario,
				fImporteTotalCobranzasUsuario,
				dFechaRegistro,
				idEmpleado,
				idEstadoCuentaActual,
				idEstadoCuentaNuevo
			   ";

		$values = "
				'$idCuentaUsuario',
				'$iDiasMoraActual',
				'$iDiasMoraNueva',
				'$fImportePagoMinimo',
				'$fImporteTotalResumenUsuario',
				'$fImporteTotalCobranzasUsuario',
				NOW(),
				'$idEmpleado',
				'$idEstadoCuentaActual',
				'$idEstadoCuentaNuevo'
				  ";
		
		$id = $oMysql->consultaSel("CALL usp_InsertValues(\"Morosidad\",\"$set\",\"$values\");",true);
		
		return $id ;

	}

	function diasEntreFechas($date0,$date1){
		#$date0 = dd/mm/YYYY hh:ii:ss
		#$date1 = dd/mm/YYYY hh:ii:ss
		#date0 < date1
		
		$aFechaHora0= explode(" ",$date0);
		if($aFechaHora0[1] == ''){ $aFechaHora0[1] = '00:00:00'; }
		$aFecha0 	= explode("/",$aFechaHora0[0]);
		$aHora0  	= explode(":",$aFechaHora0[1]);
		$dia0 		= intval($aFecha0[0]);
		$mes0 		= intval($aFecha0[1]);
		$anyo0 		= intval($aFecha0[2]);
		$hora0 		= intval($aHora0[0]);
		$min0 		= intval($aHora0[1]);
		$seg0 		= intval($aHora0[2]);
		
		$mktime0 = mktime($hora0,$min0,$seg0,$mes0,$dia0,$anyo0);
		
		$aFechaHora1= explode(" ",$date1);		
		if($aFechaHora1[1] == ''){ $aFechaHora1[1] = '00:00:00'; }		
		$aFecha0 	= explode("/",$aFechaHora1[0]);
		$aHora0  	= explode(":",$aFechaHora1[1]);
		$dia0 		= intval($aFecha0[0]);
		$mes0 		= intval($aFecha0[1]);
		$anyo0 		= intval($aFecha0[2]);
		$hora0 		= intval($aHora0[0]);
		$min0 		= intval($aHora0[1]);
		$seg0 		= intval($aHora0[2]);
		
		$mktime1 = mktime($hora0,$min0,$seg0,$mes0,$dia0,$anyo0);
		
		$diferencia = $mktime1 - $mktime0;
		
		$dias = $diferencia / (60 * 60 * 24);
		
		//obtengo el valor absoulto de los días (quito el posible signo negativo)
		$dias = abs($dias);
		
		//quito los decimales a los días de diferencia
		$dias = floor($dias);		
		
		return intval($dias);
		
		
		 
	}
	
	function _cambiarMorayEstadoCuentaUsuario($idCuentaUsuario=0,$idDetalleCuentaUsuario=0,$idEstado=0,$iDiaMora=0){
		global $oMysql;
		
		$estado_cuenta_normal = 1;
		$estado_cuenta_moroso_1_mes = 3;
		$estado_cuenta_moroso_2_mes = 4;
		$estado_cuenta_moroso_3_mes = 5;
		$estado_cuenta_inhabilitada = 10;
		$estado_cuenta_inhabilitada_con_cobranza = 13;
		$estado_cuenta_previsionada = 11;
		$estado_cuenta_previosionada_con_cobranza = 14;		
		
		$texto_estado_cuenta = "";
		
		switch ($idEstado) {
			case $estado_cuenta_normal:
					$texto_estado_cuenta = "NORMAL";
				break;
			case $estado_cuenta_inhabilitada:
					$texto_estado_cuenta = "INHABILITADA";
				break;		
			case $estado_cuenta_inhabilitada_con_cobranza:
					$texto_estado_cuenta = "INHABILITADA C/COBRANZA";
				break;
			case $estado_cuenta_previsionada:
					$texto_estado_cuenta = "PREVISIONADA";
				break;
			case $estado_cuenta_previosionada_con_cobranza:
					$texto_estado_cuenta = "PREVISIONADA C/COBRANZA";
				break;

			case $estado_cuenta_moroso_1_mes:
					$texto_estado_cuenta = "MOROSO 1 MES";
				break;
			case $estado_cuenta_moroso_2_mes:
					$texto_estado_cuenta = "MOROSO 2 MESES";
				break;
			case $estado_cuenta_moroso_3_mes:
					$texto_estado_cuenta = "MOROSO 3 MESES";
				break;				
				
			default:
					$texto_estado_cuenta = "ERROR";
				break;	
		}
		
		
		$set = "CuentasUsuarios.idTipoEstadoCuenta=$idEstado";

		$values = "CuentasUsuarios.id='$idCuentaUsuario'";

		$rs1 = $oMysql->consultaSel("CALL usp_UpdateValues(\"CuentasUsuarios\",\"$set\",\"$values\");",true);
		
		
		$set = "DetallesCuentasUsuarios.sEstado='$texto_estado_cuenta',DetallesCuentasUsuarios.iDiasMora=$iDiaMora";

		$values = "DetallesCuentasUsuarios.id='$idDetalleCuentaUsuario'";
		//var_export("CALL usp_UpdateValues(\"DetallesCuentasUsuarios\",\"$set\",\"$values\");");die();
		$rs2 = $oMysql->consultaSel("CALL usp_UpdateValues(\"DetallesCuentasUsuarios\",\"$set\",\"$values\");",true);
		
		
		#historial de estados de cuenta
		$set = "
				idCuentaUsuario,
				idEmpleado,
				idTipoEstadoCuenta,
				dFechaRegistro
			   ";

		$values = "
					'$idCuentaUsuario',
					'{$_SESSION['id_user']}',
					'$idEstado',
					NOW()
				  ";

		$rs3 = $oMysql->consultaSel("CALL usp_InsertValues(\"EstadosCuentas\",\"$set\",\"$values\");",true);
		
		
		if($rs1 && $rs2 && $rs3){
			return true;
		}else{
			return false;
		}
		
		
	}
	
	function _generarUltimoResumen($idcuentausuario = 0,$fecha_cierre = ''){
		global $oMysql;
		
		#$fecha_cierre -> dd/mm/YYYY
		
		if($idcuentausuario == 0){
			return false;
		}else{
			#actualizamos fecha de consumos
			
			$rs_cupones = _actualizarFechaCierreCupones($idcuentausuario,$fecha_cierre);
			
			
		}		
		
	}
	
	function _actualizarFechaCierreCupones($idcuentacorriente = 0,$fecha_cierre =''){
		global $oMysql;
		
		
		#actualizamos fecha de consumos

		$detalles = $oMysql->consultaSel("CALL usp_getIdDetallesCuponesPorCuentaUsuario(\"$idcuentacorriente\");");
		
		if(!$detalles){
			return false;
		}else{
			
			foreach ($detalles as $cuotas) {

				$set = "DetallesCupones.dFechaFacturacionUsuario='$fecha_cierre_usuario'";

				$values = "DetallesCupones.id='{$cuotas['id']}'";

				$i = $oMysql->consultaSel("CALL usp_UpdateValues(\"DetallesCupones\",\"$set\",\"$values\");",true);
			}
			
			return true;

		}
		
	}
	
	

	
	function _validatePermits($object = 0,$idpermitrequested = 0){
		#$object ::: id del objeto en cuestion	
		#difinir constantes para las posibles operaciones, deberian ser especificas, generales y consisas
		#el tipo de usuario ya no cuenta, solo los permisos
		
		$datos = explode(',',$_SESSION['_PERMISOS_'][$object]['sPermisos']);
		
		if(in_array($idpermitrequested,$datos)){
			return true;
		}else{
			return false;
		}
				
	}
	
	function reporteSolicitudesEmpleados($datos){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		
		if($datos['cmd_search']){
			session_add_var('rse_search',1);
			$conditions = array();
			
			//$conditions[] = "Empleados.sEstado='A'";
			
			if($datos['idRegion']){
				$conditions[] = "Regiones.id = {$datos['idRegion']}";
				session_add_var('rse_idRegion',$datos['idRegion']);
			}else{
				session_add_var('rse_idRegion',0);
			}
			
			if($datos['idSucursal']){
				$conditions[] = "Sucursales.id = {$datos['idSucursal']}";
				session_add_var('rse_idSucursal',$datos['idSucursal']);
			}else{
				session_add_var('rse_idSucursal',0);
			}
			
			if($datos['idOficina']){
				$conditions[] = "Oficinas.id = {$datos['idOficina']}";
				session_add_var('rse_idOficina',$datos['idOficina']);
			}else{
				session_add_var('rse_idOficina',0);
			}
			
			if(sizeof($conditions) == 0){
				$conditions[] = "1=1";
			}				
			
			$sub_query = " WHERE " . implode(" AND ",$conditions) . " ORDER BY Empleados.sApellido ASC ";
			
			
			//$mysql_accesos = $mysql;
			//$mysql_accesos = new MySql();			
			//$mysql_accesos->setServer('192.168.2.6','griva','griva');
			//$mysql_accesos->setDBName('Accesos');			
			
			//$empleados = $mysql_accesos->query("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");
			$empleados = $oMysql->consultaSel("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");
			//var_export("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");die();
			//$mysql_accesos->disconnect();
			

			#seteo array para condiones de fecha de solicitud			
			$conditions = array();
			
			if($datos['dFechaDesde'] != ""){
				$conditions[] = "UNIX_TIMESTAMP(SolicitudesUsuarios.dFechaSolicitud) >= UNIX_TIMESTAMP('".dateToMySql($datos['dFechaDesde'])."')";
				session_add_var('rse_dFechaDesde',$datos['dFechaDesde']);
			}else{
				session_add_var('rse_dFechaDesde','');
			}
			
			if($datos['dFechaHasta'] != ""){
				$conditions[] = "UNIX_TIMESTAMP(SolicitudesUsuarios.dFechaSolicitud) <= UNIX_TIMESTAMP('".dateToMySql($datos['dFechaHasta'])."')";
				session_add_var('rse_dFechaHasta',$datos['dFechaHasta']);
			}else{
				session_add_var('rse_dFechaHasta','');
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
						$HTML .= "<td class='column_operations_right_data' align='right'><strong>$total_solicitudes</strong></td>";
					$HTML .= "</tr>";							
			}

			
			$HTML .= "</tbody>";
			
			$HTML .= "</table>";
			
			$HTML = _parserCharacters_($HTML);
			//$HTML = convertir_especiales_html($HTML);
			$buttons = new _buttons_('R');	
			
			$buttons->add_button('href','javascript:printReporteSolicitudEmpleado();','imprimir','print');
		
			$buttons->set_width('720px;');
			
			$botonera = $buttons->get_buttons();
			
			$oRespuesta->assign("div_result_button","innerHTML","$botonera");
			
			$oRespuesta->assign("div_result_search","innerHTML","$HTML");
			
			
		}else{
			$oRespuesta->assign("div_result_search","innerHTML","error");
			session_add_var('rse_search',0);
		}

		return $oRespuesta;
	}
	
	function buscarDatosComercioPorNumeroAC($numero_comercio = ''){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();

		$sub_query = " WHERE Comercios.sNumero = '$numero_comercio' AND Comercios.sEstado = 'A' " ;
		
		$comercio = $oMysql->consultaSel("CALL usp_getComercios(\"$sub_query\");", true);
		
		if(!$comercio){

			$oRespuesta->script("setNotFoundComercio();");

		}else{
			
			$oRespuesta->script("setDatosComercioN2('"._encode($comercio['id'])."','{$comercio['sRazonSocial']}',' {$comercio['sNombreFantasia']}','{$comercio['sCUIT']}','{$comercio['sNumero']}');");

		}

		return $oRespuesta;
	}	
	
	function _reprintCuponesOriginal($idcupones = ''){
		
		
		$idcupones = intval(_decode($idcupones));
		//global $mysql;
		global $oMysql;

		$parseo = array();

		$sub_query = " WHERE Cupones.id=$idcupones";

		$cupones = $oMysql->consultaSel("CALL usp_getDatosCompletosCupones(\"$sub_query\");", true);
		
		$sub_query = " WHERE DetallesCupones.idCupon = '$idcupones'";

		$detalles = $oMysql->consultaSel("CALL usp_getDetallesCupones(\"$sub_query\");");

		$tableRowsCuotas = "";

		foreach ($detalles as $cuota) {
			
			$fecha = explode("/",$cuota['dFechaFacturacionUsuario']);
			$anyo  = $fecha[2];
			$mes   = $fecha[1];
			
			$dFechaVencimiento = $oMysql->consultaSel("SELECT fcn_getFechaVencimientoCupones(\"$idcupones\",\"$anyo\",\"$mes\");",true);			
			if($dFechaVencimiento == ""){				
				$mes = intval($mes);
				$mes = $mes + 1;
				$mktimeV = mktime(0,0,0,$mes,15,$anyo);
				$dFechaVencimiento = date("d/m/Y",$mktimeV);
			}else{
			}
			//$dFechaVencimiento = "__/__/_____";
			$tableRowsCuotas .= "
								<tr>
								    <td>{$cuota['iNumeroCuota']}</td>
								    <td>{$dFechaVencimiento}</td>
								    <td>$</td>
								    <td>{$cuota['fImporte']}</td>
								</tr>
								";
		}
		//$mysql->setDBName("Accesos");
	    //$idSucursal = $mysql->selectRow("select Oficinas.idSucursal from Empleados left join Oficinas on  Oficinas.id = Empleados.idOficina  where Empleados.id = {$cupones['idEmpleado']};");	
		$idSucursal=$oMysql->consultaSel("select Oficinas.idSucursal from Empleados left join Oficinas on  Oficinas.id = Empleados.idOficina  where Empleados.id = {$cupones['idEmpleado']};",true);
		
		$fecha = $cupones['dFechaRegistro'];
		$aFechaRegistro=explode('-',$cupones['dFechaRegistrosYMD']);
		$aHora = split(":", $aFechaRegistro[2]);
		$aFecha_hora = split(" ", $aHora[0]);
		
		//dFechaRegistrosYMD //2011-09-02 00:00:00
		$diaHoy = intval($aFecha_hora[0]);
		$mesHoy = intval($aFechaRegistro[1]);
		$anyoHoy = intval($aFechaRegistro[0]);
		$horaHoy = intval($aFecha_hora[1]);
		$minHoy = intval($aHora[1]);
		$segHoy = intval($aHora[1]);
		
		$mktime4 = mktime($horaHoy,$minHoy,$segHoy,$mesHoy,$diaHoy,$anyoHoy+4);
		
		$fecha_en_letra_plazo_presentacion = date("d/m/Y",$mktime4);
		
		$parseo['fecha_en_letra_plazo_presentacion'] 			= $fecha_en_letra_plazo_presentacion;
		
		$idusuario = $cupones['idUsuario'];
		
		$parseo['date_now'] 			= $fecha;

		$parseo['hours_now'] 			= date("h:i:s");

		$parseo['idSucursal'] 			= $idSucursal;

		$parseo['sNumeroCuenta'] 		= $cupones['sNumeroCuenta'];
		
		$parseo['sNumeroCupon'] 		= $cupones['sNumeroCupon'];

		$parseo['importeTOTAL'] 		= $cupones['fImporte'];

		$parseo['tableRowsCuotas'] 		= $tableRowsCuotas;
		
		$parseo['fecha_hoy_en_letras']	= _dateTOLETTER($fecha,"Salta");
		
		$x=new EnLetras();
			
		$sCantidad = $x->ValorEnLetras($cupones['fImporte'],"").'.-';		
		
		$parseo['importe_en_letras'] 		= $sCantidad;
		
		
		#para datos del titular
		$parseo['sTitular'] 			= $cupones['sApellidoUsuario'] . ", " . $cupones['sNombreUsuario'];

		$parseo['sTipoDocumento'] 		= $cupones['sNombreTipoDocumento'];

		$parseo['sNumeroDocumento'] 	= $cupones['sDocumentoUsuario'];

		$parseo['sProvinciaTitular'] 	= $cupones['sNombreProvincia'];

		$parseo['sLocalidadTitular'] 	= $cupones['sNombreLocalidad'];
		
		$sub_query = " WHERE DomiciliosUsuarios.idUsuario = '$idusuario' ORDER BY DomiciliosUsuarios.id DESC LIMIT 0,1";
		
		$domicilio = $oMysql->consultaSel("CALL usp_getDomiciliosUsuarios(\"$sub_query\");",true);
		
		$parseo['sCalle'] 	= $cupones['sCalle'];
		
		$parseo['sCalle'] 			= $domicilio['sCalle'];
		$parseo['sNumeroCalle'] 	= $domicilio['sNumeroCalle'];
		$parseo['sBlock'] 			= $domicilio['sBlock'];
		$parseo['sPiso'] 			= $domicilio['sPiso'];
		$parseo['sDepartamento'] 	= $domicilio['sDepartamento'];
		$parseo['sEntreCalles'] 	= $domicilio['sEntreCalles'];
		$parseo['sManzana'] 		= $domicilio['sManzana'];
		$parseo['sLote'] 			= $domicilio['sLote'];
		$parseo['sDomicilio'] = $parseo['sCalle']." ".$parseo['sNumeroCalle'];
		if($parseo['sBlock'] != "") $parseo['sDomicilio'] .= " BLOCK:".$parseo['sBlock'];
		if($parseo['sPiso'] != "") $parseo['sDomicilio'] .= " Piso:".$parseo['sPiso'];
		if($parseo['sDepartamento'] != "") $parseo['sDomicilio'] .=" Dpto.:".$parseo['sDepartamento'];
		
		$parseo['sProvinciaTitular']= $domicilio['sNombreProvincia'];
		$parseo['sLocalidadTitular']= $domicilio['sNombreLocalidad'];

		#27 = cargo administrativo
		#31 = seguro de vida sobre saldo deudor
		$sub_query = " WHERE FacturacionesCargos.idGrupoAfinidad = '{$cupones['idGrupoAfinidad']}' AND FacturacionesCargos.idTipoAjuste = 27";
		
		$cargos = array_shift($oMysql->consultaSel("CALL usp_getFacturacionDeCargos(\"$sub_query\");"));
		
		$parseo['monto_cargo_administrativo'] 			= $cargos['fValor'];
		
		
		$sub_query = " WHERE FacturacionesCargos.idGrupoAfinidad = '{$cupones['idGrupoAfinidad']}' AND FacturacionesCargos.idTipoAjuste = 31";
		
		$cargos = array_shift($oMysql->consultaSel("CALL usp_getFacturacionDeCargos(\"$sub_query\");"));
		
		$parseo['porcentaje_seguro_vida_saldo_deudor'] 	= $cargos['fValor'];
		
		if($cupones['idPlan'] != 0){

				$aplanes = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$cupones['idPlan']}\",\"planes\");",true);

				if(!$aplanes){
					$fInteresUsuario= 0;
				}else{
					$fInteresUsuario= $aplanes['fInteresUsuario'];
				}	
		}else{
				$apromociones = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$cupones['idPlanPromo']}\",\"promociones\");",true);
				if(!$apromociones){
					$fInteresUsuario= 0;
				}else{
					$fInteresUsuario= $apromociones['fInteresUsuario'];
				}
		}
		$message_interes = "";
		if($fInteresUsuario != 0){
			$message_interes = "TEA $fInteresUsuario% + IVA";
		}
		
		if($cupones['iTipoPersona'] == 2){
		  	$parseo['cartel_razon_social_cuit'] = ': ' . $cupones['sRazonSocial'] . ' - CUIT : ' . $cupones['sCUIT'];
		}		
		
		$parseo['datos_interes_IVA'] = $message_interes ;

		$html = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Cupones/impresiones.tpl",$parseo);
		
		return $html;
	}
	
	function reporteCobranzasEmpleados($datos){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		
		if($datos['cmd_search']){
			
			$conditions = array();
			
			//$conditions[] = "Empleados.sEstado='A'";
			
			if($datos['idRegion']){
				$conditions[] = "Regiones.id = {$datos['idRegion']}";
			}
			
			if($datos['idSucursal']){
				$conditions[] = "Sucursales.id = {$datos['idSucursal']}";
			}
			
			if($datos['idOficina']){
				$conditions[] = "Oficinas.id = {$datos['idOficina']}";
			}
			
			$sub_query = " WHERE " . implode(" AND ",$conditions) . " ORDER BY Empleados.sApellido ASC ";
			
			
			//$mysql_accesos = $mysql;
			//$mysql_accesos = new MySql();
			//$mysql_accesos->setServer('192.168.2.6','griva','griva');
			//$mysql_accesos->setDBName('Accesos');			
			
			//$empleados = $mysql_accesos->query("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");
			$empleados = $oMysql->consultaSel("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");
			//var_export("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");die();
			//$mysql_accesos->disconnect();			

			#seteo array para condiones de fecha de solicitud			
			$conditions = array();
			$conditions[] = "Cobranzas.sEstado = 'A'";
			if($datos['dFechaDesde'] != ""){
				$conditions[] = "UNIX_TIMESTAMP(Cobranzas.dFechaCobranza) >= UNIX_TIMESTAMP('".dateToMySql($datos['dFechaDesde'])."')";
			}
			
			if($datos['dFechaHasta'] != ""){
				$conditions[] = "UNIX_TIMESTAMP(Cobranzas.dFechaCobranza) <= UNIX_TIMESTAMP('".dateToMySql($datos['dFechaHasta'])."')";
			}
			
			$part_sub_query = (sizeof($conditions) > 0) ? implode(" AND ",$conditions) : " 1=1 ";
			
			$HTML = "<table id='table_object' class='table_object' width='720' cellspacing='0' cellpadding='0' align='center'>";
			$HTML .= "<thead>";
			$HTML .= "<tr>";
				$HTML .= "<th>Empleado</th>";
				$HTML .= "<th>Fecha Cobro</th>";
				$HTML .= "<th>Cuenta</th>";
				$HTML .= "<th>Descripcion</th>";
				$HTML .= "<th>Importe</th>";
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
					
					$nombre_empleado = $empleado['sApellido'].', '.$empleado['sNombre'];
					
					//$conditions[] = "SolicitudesUsuarios.idCargador = '{$empleado['id']}'";
					
					$sub_query = " WHERE Cobranzas.idEmpleado = '{$empleado['id']}' AND $part_sub_query" ;
					//var_export("CALL usp_getCantidadSolicitudesEmpleados(\"$sub_query\");");die();
					
					$cobranzas = $oMysql->consultaSel("CALL usp_getCobranzas(\"$sub_query\");");
					
					if(!$cobranzas){
						
					}else{
						
						//$cantidad_cobranzas = sizeof($cobranzas);
						
						foreach ($cobranzas as $cobranza) {
							$sUsuario = $cobranza['sApellido'].', '.$cobranza['sNombre'];
							$HTML .= "<tr>";
								$HTML .= "<td align='left'>{$nombre_empleado}</td>";
								$HTML .= "<td align='center'>{$cobranza['dFechaCobranza']}</td>";
								$HTML .= "<td align='center'>{$cobranza['sNumeroCuenta']}</td>";
								$HTML .= "<td align='left'>{$cobranza['sApellido']}, {$cobranza['sNombre']}</td>";
								$HTML .= "<td class='column_operations_right' align='right'>{$cobranza['fImporte']}</td>";
							$HTML .= "</tr>";
							$total_solicitudes = $total_solicitudes + $cobranza['fImporte'] ;
						}
					}
					
				}

					$HTML .= "<tr>";
						$HTML .= "<td align='right' colspan='4'>TOTAL</td>";
						$HTML .= "<td class='column_operations_right' align='right'><strong>$total_solicitudes</strong></td>";
					$HTML .= "</tr>";
			}

			
			$HTML .= "</tbody>";
			
			$HTML .= "</table>";
			
			//$HTML = _parserCharacters_($HTML);

			//$HTML = convertir_especiales_html($HTML);

			$buttons = new _buttons_('R');	
			
			$buttons->add_button('href','javascript:printReportesCobranzasEmpleados();','imprimir','print');
		
			$buttons->set_width('720px;');
			
			$botonera = $buttons->get_buttons();
			
			$oRespuesta->assign("div_result_button","innerHTML","$botonera");
			
			$oRespuesta->assign("div_result_search","innerHTML",$HTML);
			
			
		}else{
			$oRespuesta->assign("div_result_search","innerHTML","error");
		}

		return $oRespuesta;
	}

	function reportesTarjetasCheck($datos){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		if($datos['cmd_search']){
			
			$conditions = array();
			
			//$conditions[] = "Empleados.sEstado='A'";
			
			if($datos['idRegion']){
				$conditions[] = "Regiones.id = {$datos['idRegion']}";
			}
			
			if($datos['idSucursal']){
				$conditions[] = "Sucursales.id = {$datos['idSucursal']}";
			}
			
			if($datos['idOficina']){
				$conditions[] = "Oficinas.id = {$datos['idOficina']}";
			}
			
			$sub_query = " WHERE " . implode(" AND ",$conditions) . " ORDER BY Empleados.sApellido ASC ";
			
			//$mysql_accesos = $mysql;
			//$mysql_accesos = new MySql();
			//$mysql_accesos->setServer('192.168.2.6','griva','griva');
			//$mysql_accesos->setDBName('Accesos');			
			
			//$empleados = $mysql_accesos->query("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");
			$empleados = $oMysql->consultaSel("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");
			//var_export("CALL usp_getEmpleadosReportesSolicitudesEmpleados(\"$sub_query\");");die();
			//$mysql_accesos->disconnect();
			
		
			#seteo array para condiones de fecha de solicitud			
			$conditions = array();
			
			$conditions[] = "Tarjetas.idTipoEstadoTarjeta = '5'";
			
			$conditions[] = "Cupones.sEstado <> 'A'";
			
			if($datos['dFechaDesde'] != ""){
				$conditions[] = "UNIX_TIMESTAMP(Cupones.dFechaConsumo) >= UNIX_TIMESTAMP('".dateToMySql($datos['dFechaDesde'])."')";
			}
			
			if($datos['dFechaHasta'] != ""){
				$conditions[] = "UNIX_TIMESTAMP(Cupones.dFechaConsumo) <= UNIX_TIMESTAMP('".dateToMySql($datos['dFechaHasta'])."')";
			}
			
			$part_sub_query = (sizeof($conditions) > 0) ? implode(" AND ",$conditions) : " 1=1 ";
			

			$html = "<form action='xlsTarjetasCheck.php' method='GET' name='form_table_object' id='form_table_object' style='display:inline;'>";	
			$html .= "<input type='hidden' name='idRegion' id='idRegion' value=\"{$datos['idRegion']}\">";	
			$html .= "<input type='hidden' name='idSucursal' id='idSucursal' value=\"{$datos['idSucursal']}\">";	
			$html .= "<input type='hidden' name='idOficina' id='idOficina' value=\"{$datos['idOficina']}\">";	
			$html .= "<input type='hidden' name='dFechaDesde' id='dFechaDesde' value=\"{$datos['dFechaDesde']}\">";	
			$html .= "<input type='hidden' name='dFechaHasta' id='dFechaHasta' value=\"{$datos['dFechaHasta']}\">";	
			$html .= "<table id='table_object' class='table_object' width='720' cellspacing='0' cellpadding='0' align='center'>";
			$html .= "<thead>";
			$html .= "<tr>";
				$html .= "<th>Poliza</th>";
				$html .= "<th>idEmpleado</th>";
				$html .= "<th>Empleado</th>";
				$html .= "<th>idCuenta</th>";
				$html .= "<th>Nro Cuenta</th>";
				$html .= "<th>DNI Titular</th>";
				$html .= "<th>Titular</th>";
				$html .= "<th><input type='checkbox' name='chkALL'  id='chkALL' onclick=\"checkTodos(this.id,'table_object');\" /></th>";
			$html .= "</tr>";
			$html .= "</thead>";
			
			$html .= "<tbody>";
			
			if(!$empleados){
					$html .= "<tr>";
						$html .= "<td colspan='8' align='left'> - nose encontraron resultados </td>";
					$html .= "</tr>";
			}else{			
				//var_export(sizeof($empleados));die();
				foreach ($empleados as $empleado){
					
					$sub_query = " WHERE Cupones.idEmpleado = '{$empleado['id']}' AND $part_sub_query" ;
					
					$cupones = $oMysql->consultaSel("CALL usp_getCupones(\"$sub_query\");");
					//var_export($empleados);die();
					if(!$cupones){
						
					}else{
						$i = 0;
						
						foreach ($cupones as $consumo) {
							$html .= "<tr>";
								$html .= "<td align='center'>&nbsp;{$consumo['sNumeroCupon']}</td>";
								$html .= "<td align='center'>&nbsp;{$empleado['id']}</td>";
								$html .= "<td align='left'>&nbsp;{$empleado['sApellido']},{$empleado['sNombre']}</td>";
								$html .= "<td align='center'>&nbsp;{$consumo['idCuentaUsuario']}</td>";
								$html .= "<td align='center'>&nbsp;{$consumo['sNumeroCuenta']}</td>";
								$html .= "<td align='center'>&nbsp;{$consumo['sDniUsuario']}</td>";
								$html .= "<td align='left'>&nbsp;{$consumo['sApellidoUsuario']}, {$consumo['sNombreUsuario']}</td>";
								//$html .= "<td class='column_operations_right' align='center'><input type='checkbox' name='chk[]'  id='chk[]' value='"._encode($consumo['sNumeroCupon'])."' /></td>";
								$html .= "<td class='column_operations_right' align='center'><input type='checkbox' name='chk[]'  id='chk[]' value='{$consumo['sNumeroCupon']}' /></td>";
							$html .= "</tr>";
							$i = $i +  1;

						}
					}
	
				}
		
	
			}
			
			$html .= "</tbody>";
			
			$html .= "</table>";
			
			$html .= "</form>";
			
			$html = _parserCharacters_($html);			
	
			//$HTML = convertir_especiales_html($HTML);
			
		}else{
			$html = "no result";		
		}
		
		$buttons = new _buttons_('R');	
		
		if($_SESSION['id_user'] == 296){		
			$buttons->add_button('href','javascript:procesarPolizasTACheck();','camiar estado a poliza asociada','edit');	
		}
		
		
		$buttons->add_button('href',"javascript:exportarXLS();",'exportar seleccion','excel');
		
		$buttons->add_button('href','javascript:printReportesTarjetasCheck();','imprimir resultado','print');
	
		$buttons->set_width('720px;');
		
		$botonera = $buttons->get_buttons();
		
		$oRespuesta->assign("div_result_button","innerHTML","$botonera");
		
		$oRespuesta->assign("div_result_search","innerHTML","$html");
		
		return $oRespuesta;
			
	}
	
	function procesarPolizasTACheck($datos = false){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$errores = array();
		
		if(!$datos){	

			$errores[] = "error al intentar leer archivo";
			
		}else{
				$cantidad_polizas = sizeof($datos['chk']);
				
				$values = "";
				
				$k = 0;
				
				$values = substr($values,0,-1);
				//var_export($values); die();
				
				$errores[] = "se ejecuto su operacion correctamente";
		}
		
		$message = implode(" <br /> ",$errores);
		
		$oRespuesta->assign("div_message_operations","innerHTML","$message");
		
		return $oRespuesta;
		
	}
	
	function issuance_payment_values($datos = ''){
		#esta funcion toma los idDetallesLiquidaciones seleccionado y emite el comprobante correspondiente
		#datos tiene los idDetelleLiquidacion
		
		global $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$chk = $datos['chk'];
		
		#variables por defectos
		$Emisor = "EMPRESA";
		$fecha_hora_hoy = date("Y-m-d h:i:s");
		$cheque_conciliado = 0;
		$CBUCuentaEmisora = "";
		$html = "";
		$k = 0;
		
		$comercios = new comercios(0);
		
		$numero_cheque = intval($datos['sNroCheque']);
		
		
		foreach ($chk as $idDetallesLiquidacion) {
			
			
			
			$k = $k + 1;
			
			$numero_cheque = $numero_cheque + $k;
			
			$idDetallesLiquidacion = (is_null($idDetallesLiquidacion) || $idDetallesLiquidacion == false) ? 0 : intval($idDetallesLiquidacion);
			
			$sub_query = " WHERE DetallesLiquidaciones.id=$idDetallesLiquidacion";
			
			$SQL = "CALL usp_getDetallesLiquidaciones(\"$sub_query\");";	
			
			$detalles_liquidaciones = $oMysql->consultaSel( $SQL , true);
			
			
			
			#check para ver si este detalle de liquidacion esta asociado a un plan o promocion
			switch ($detalles_liquidaciones['iPlanPromo']) {
				case 0:
					#liquidaciones a comercio asociado a planes
					$sub_query = " WHERE DetallesLiquidaciones.id = {$detalles_liquidaciones['id']}";
					
					$SQL = "CALL usp_getDatosDetallesLiquidacionesPlanes(\"$sub_query\");";
					
					$liquidaciones = $oMysql->consultaSel( $SQL , true);
					
					if(!$liquidaciones){
						
					}else{
						
						#check la forma de pago de la liquidacion
						
						switch ($liquidaciones['idFormaPago']) {
							case 2:#cheques
									$idFormaPago = 2;
									 
									$datos['idFormaPago'] = 2;
									
									$check_datos = comercios::_check_datos($datos,"payment_issue");
									
									if($check_datos == ''){
										
										$dia_cierre  = intval($liquidaciones['iDiacierre']);
										$dia_diferimiento = intval($liquidaciones['iDiaCorridoPago']);#dias de diferimiento despues del cierre del comercio
										$mes_cierre  = intval(date("m"));
										$year_cierre = intval(date("Y"));
										
										$mktime = mktime(0,0,0,$mes_cierre,$dia_cierre+$dia_diferimiento,$year_cierre);
										
										#obtengo fecha de vencimiento diferida si lo estuviera,  0-(°-°Q)
										$dia_vencimiento  = date("d",$mktime);
										$mes_vencimiento  = date("m",$mktime);
										$year_vencimiento = date("Y",$mktime);									
										
										
										$transacciones['idEmpleado'] 	= $_SESSION['id_user'];
										$transacciones['idBanco'] 		= $datos['idBanco'];
										$transacciones['iNumeroTransaccion'] = $numero_cheque;
										$transacciones['dFechaEntrega'] = '';
										$transacciones['dFechaDebito'] 	= '';
										$transacciones['dFechaEmision'] = $fecha_hora_hoy;
										$transacciones['dFechaPago'] 	= $year_vencimiento . "-" . $mes_vencimiento  . "-" . $dia_vencimiento;
										$transacciones['dFechaRegistro']= $fecha_hora_hoy;
										$transacciones['fImporte'] 		= $liquidaciones['fImporteNeto'];
										$transacciones['sObservaciones']= $datos['sObservaciones'];
										$transacciones['iConciliado'] 	= $cheque_conciliado;
										$transacciones['sEmisor'] 		= $Emisor;
										$transacciones['sReceptor'] 	= $datos['sReceptor'];
										$transacciones['sEstado'] 		= "A";
										$transacciones['sCBUCuentaDestino'] = $datos['sCBUDestino'];
										$transacciones['sCBUCuentaEmisora'] = $CBUCuentaEmisora;
										$transacciones['idLiquidacion'] = $liquidaciones['idLiquidacion'];
										$transacciones['iGlobalLiquidacion'] = 0;
										$transacciones['idFormaPago'] 	= $liquidaciones['idFormaPago'] ;
										$transacciones['idDetalleLiquidacion'] = $liquidaciones['id'];
										//var_export($transacciones);die();
										$comercios->issuance_payment_values($transacciones);
										
										#arma cadena html para posterior impresion
										$transacciones['iDiaEmision']  = date("d");
										$transacciones['iMesEmision']  = date("m");
										$transacciones['iAnioEmision'] = date("Y");
										
										$transacciones['iDiaPago']  = $dia_vencimiento;
										$transacciones['iMesPago']  = $mes_vencimiento;
										$transacciones['iAnioPago'] = $year_vencimiento;
										
										$transacciones['fImporte']  = $liquidaciones['fImporteNeto'];
										
										$transacciones['sReceptor'] = $datos['sReceptor'];
										
										$x=new EnLetras();
											
										$sImporte = $x->ValorEnLetras($liquidaciones['fImporteNeto'],"").'.-';
	
										$transacciones['sImporte'] = $sImporte ;
	
										$html .= parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Comercios/ChequesImpresos.tpl",$transacciones);										
										
										
										
									}else{

										$sms_errores .= "ERROR : Detalles de Liquidaciones : {$liquidaciones['id']}, tiene conflictos : <br />" . $check_datos;

									}									
									
								break;
							case 1:#transferencia bancaria
									$idFormaPago = 1;
									
									$datos['idFormaPago'] = 1;
									
									$check_datos = comercios::_check_datos($datos,"payment_issue");
									
									if($check_datos == ''){
										
										$dia_cierre  = intval($liquidaciones['iDiacierre']);
										$dia_diferimiento = intval($liquidaciones['iDiaCorridoPago']);#dias de diferimiento despues del cierre del comercio
										$mes_cierre  = intval(date("m"));
										$year_cierre = intval(date("Y"));
										
										$mktime = mktime(0,0,0,$mes_cierre,$dia_cierre+$dia_diferimiento,$year_cierre);
										
										#obtengo fecha de vencimiento diferida si lo estuviera,  0-(°-°Q)
										$dia_vencimiento  = date("d",$mktime);
										$mes_vencimiento  = date("m",$mktime);
										$year_vencimiento = date("Y",$mktime);
										
										$transacciones['idEmpleado'] 	= $_SESSION['id_user'];
										$transacciones['idBanco'] 		= $datos['idBanco'];
										$transacciones['iNumeroTransaccion'] = $numero_cheque;
										$transacciones['dFechaEntrega'] = '';
										$transacciones['dFechaDebito'] 	= '';
										$transacciones['dFechaEmision'] = $fecha_hora_hoy;
										$transacciones['dFechaPago'] 	= $year_vencimiento . "-" . $mes_vencimiento  . "-" . $dia_vencimiento;
										$transacciones['dFechaRegistro']= $fecha_hora_hoy;
										$transacciones['fImporte'] 		= $liquidaciones['fImporteNeto'];
										$transacciones['sObservaciones']= $datos['sObservaciones'];
										$transacciones['iConciliado'] 	= $cheque_conciliado;
										$transacciones['sEmisor'] 		= $Emisor;
										$transacciones['sReceptor'] 	= $datos['sReceptor'];//$liquidaciones['sTitularComercio'];
										$transacciones['sEstado'] 		= "A";
										$transacciones['sCBUCuentaDestino'] = $datos['sCBUDestino'];
										$transacciones['sCBUCuentaEmisora'] = $CBUCuentaEmisora;
										$transacciones['idLiquidacion'] = $liquidaciones['idLiquidacion'];
										$transacciones['iGlobalLiquidacion'] = 0;
										$transacciones['idFormaPago'] 	= $liquidaciones['idFormaPago'] ;
										$transacciones['idDetalleLiquidacion'] = $liquidaciones['id'];
										
										//comercios::issuance_payment_values($transacciones);
										
										#arma cadena html para posterior impresion
										/*$transacciones['iDiaEmision']  = date("d");
										$transacciones['iMesEmision']  = date("m");
										$transacciones['iAnioEmision'] = date("Y");
										
										$transacciones['iDiaPago']  = $dia_vencimiento;
										$transacciones['iMesPago']  = $mes_vencimiento;
										$transacciones['iAnioPago'] = $year_vencimiento;
										
										$transacciones['fImporte']  = $liquidaciones['fImporteNeto'];
										
										$transacciones['sReceptor'] = $datos['sReceptor'];
										
										$x=new EnLetras();
											
										$sImporte = $x->ValorEnLetras($liquidaciones['fImporte'],"").'.-';
	
										$transacciones['sImporte'] = $sImporte ;
	
										$html .= parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Comercios/ChequesImpresos.tpl",$transacciones);*/										
										
										
										
									}else{
										$sms_errores .= "ERROR : Detalles de Liquidaciones : {$liquidaciones['id']}, tiene conflictos : <br />" . $check_datos;
									}									
									
								break;
							default:
									$sms_errores .= "ERROR : el detalle de liquidacion : {$datos['id']} no tiene asociado una forma de pago valida.  No se Emitio comprobante de Pago";
								break;
						}
						

						
					}
					
						
					break;
				case 1:
					#liquidaciones a comercio asociado a promociones
					$sub_query = " WHERE DetallesLiquidaciones.id = {$detalles_liquidaciones['id']}";
					
					$SQL = "CALL usp_getDatosDetallesLiquidacionesPromociones(\"$sub_query\");";
					
					$liquidaciones = $oMysql->consultaSel( $SQL , true);
					
					if(!$liquidaciones){
						
					}else{
						
						#check la forma de pago de la liquidacion
						
						switch ($liquidaciones['idFormaPago']) {
							case 2:
									$idFormaPago = 2;
									
									$datos['idFormaPago'] = 2;
									
									$check_datos = comercios::_check_datos($datos,"payment_issue");
									
									if($check_datos == ''){
										
										$dia_cierre  = intval($liquidaciones['iDiacierre']);
										$dia_diferimiento = intval($liquidaciones['iDiaCorridoPago']);#dias de diferimiento despues del cierre del comercio
										$mes_cierre  = intval(date("m"));
										$year_cierre = intval(date("Y"));
										
										$mktime = mktime(0,0,0,$mes_cierre,$dia_cierre+$dia_diferimiento,$year_cierre);
										
										#obtengo fecha de vencimiento diferida si lo estuviera,  0-(°-°Q)
										$dia_vencimiento  = date("d",$mktime);
										$mes_vencimiento  = date("m",$mktime);
										$year_vencimiento = date("Y",$mktime);
										
										$transacciones['idEmpleado'] 	= $_SESSION['id_user'];
										$transacciones['idBanco'] 		= $datos['idBanco'];
										$transacciones['iNumeroTransaccion'] = $numero_cheque;
										$transacciones['dFechaEntrega'] = '';
										$transacciones['dFechaDebito'] 	= '';
										$transacciones['dFechaEmision'] = $fecha_hora_hoy;
										$transacciones['dFechaPago'] 	= $year_vencimiento . "-" . $mes_vencimiento  . "-" . $dia_vencimiento;
										$transacciones['dFechaRegistro']= $fecha_hora_hoy;
										$transacciones['fImporte'] 		= $liquidaciones['fImporteNeto'];
										$transacciones['sObservaciones']= $datos['sObservaciones'];;
										$transacciones['iConciliado'] 	= $cheque_conciliado;
										$transacciones['sEmisor'] 		= $Emisor;
										$transacciones['sReceptor'] 	= $datos['sReceptor'];//$liquidaciones['sTitularComercio'];
										$transacciones['sEstado'] 		= "A";
										$transacciones['sCBUCuentaDestino'] = $datos['sCBUDestino'];
										$transacciones['sCBUCuentaEmisora'] = $CBUCuentaEmisora;
										$transacciones['idLiquidacion'] = $liquidaciones['idLiquidacion'];
										$transacciones['iGlobalLiquidacion'] = 0;
										$transacciones['idFormaPago'] 	= $liquidaciones['idFormaPago'] ;
										$transacciones['idDetalleLiquidacion'] = $liquidaciones['id'];
										
										$comercios->issuance_payment_values($transacciones);
										
										#arma cadena html para posterior impresion
										$transacciones['iDiaEmision']  = date("d");
										$transacciones['iMesEmision']  = date("m");
										$transacciones['iAnioEmision'] = date("Y");
										
										$transacciones['iDiaPago']  = $dia_vencimiento;
										$transacciones['iMesPago']  = $mes_vencimiento;
										$transacciones['iAnioPago'] = $year_vencimiento;
										
										$transacciones['fImporte']  = $liquidaciones['fImporteNeto'];
										
										$transacciones['sReceptor'] = $datos['sReceptor'];
										
										$x=new EnLetras();
											
										$sImporte = $x->ValorEnLetras($liquidaciones['fImporte'],"").'.-';
	
										$transacciones['sImporte'] = $sImporte ;
	
										$html .= parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Comercios/ChequesImpresos.tpl",$transacciones);										
										
										
										
									}else{
										$sms_errores .= "ERROR : Detalles de Liquidaciones : {$liquidaciones['id']}, tiene conflictos : <br />" . $check_datos;
									}									
									
								break;
							case 1:#transferencia bancaria
									$idFormaPago = 1;
									
									$datos['idFormaPago'] = 1;
									
									$check_datos = comercios::_check_datos($datos,"payment_issue");
									
									if($check_datos == ''){
										
										$dia_cierre  = intval($liquidaciones['iDiacierre']);
										$dia_diferimiento = intval($liquidaciones['iDiaCorridoPago']);#dias de diferimiento despues del cierre del comercio
										$mes_cierre  = intval(date("m"));
										$year_cierre = intval(date("Y"));
										
										$mktime = mktime(0,0,0,$mes_cierre,$dia_cierre+$dia_diferimiento,$year_cierre);
										
										#obtengo fecha de vencimiento diferida si lo estuviera,  0-(°-°Q)
										$dia_vencimiento  = date("d",$mktime);
										$mes_vencimiento  = date("m",$mktime);
										$year_vencimiento = date("Y",$mktime);
										
										$transacciones['idEmpleado'] 	= $_SESSION['id_user'];
										$transacciones['idBanco'] 		= $datos['idBanco'];
										$transacciones['iNumeroTransaccion'] = $numero_cheque;
										$transacciones['dFechaEntrega'] = '';
										$transacciones['dFechaDebito'] 	= '';
										$transacciones['dFechaEmision'] = $fecha_hora_hoy;
										$transacciones['dFechaPago'] 	= $year_vencimiento . "-" . $mes_vencimiento  . "-" . $dia_vencimiento;
										$transacciones['dFechaRegistro']= $fecha_hora_hoy;
										$transacciones['fImporte'] 		= $liquidaciones['fImporteNeto'];
										$transacciones['sObservaciones']= $datos['sObservaciones'];
										$transacciones['iConciliado'] 	= $cheque_conciliado;
										$transacciones['sEmisor'] 		= $Emisor;
										$transacciones['sReceptor'] 	= $datos['sReceptor'];//$liquidaciones['sTitularComercio'];
										$transacciones['sEstado'] 		= "A";
										$transacciones['sCBUCuentaDestino'] = $datos['sCBUDestino'];
										$transacciones['sCBUCuentaEmisora'] = $CBUCuentaEmisora;
										$transacciones['idLiquidacion'] = $liquidaciones['idLiquidacion'];
										$transacciones['iGlobalLiquidacion'] = 0;
										$transacciones['idDetalleLiquidacion'] = $liquidaciones['id'];
										
										//comercios::issuance_payment_values_details($transacciones);
										
										#arma cadena html para posterior impresion
										/*$transacciones['iDiaEmision']  = date("d");
										$transacciones['iMesEmision']  = date("m");
										$transacciones['iAnioEmision'] = date("Y");
										
										$transacciones['iDiaPago']  = $dia_vencimiento;
										$transacciones['iMesPago']  = $mes_vencimiento;
										$transacciones['iAnioPago'] = $year_vencimiento;
										
										$transacciones['fImporte']  = $liquidaciones['fImporteNeto'];
										
										$transacciones['sReceptor'] = $datos['sReceptor'];
										
										$x=new EnLetras();
											
										$sImporte = $x->ValorEnLetras($liquidaciones['fImporte'],"").'.-';
	
										$transacciones['sImporte'] = $sImporte ;
	
										$html .= parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Comercios/ChequesImpresos.tpl",$transacciones);*/										
										
										
										
									}else{
										$sms_errores .= "ERROR : Detalles de Liquidaciones : {$liquidaciones['id']}, tiene conflictos : <br />" . $check_datos;
									}									
									
								break;
							default:
									$sms_errores .= "ERROR : el detalle de liquidacion : {$datos['id']} no tiene asociado una forma de pago valida.  No se Emitio comprobante de Pago";
								break;
						}
						

						
					}
										
					break;			
				default:
					break;
			}
			
			$oRespuesta->assign("impresiones","innerHTML",$html);
		
			$oRespuesta->script("_printCHEQUES();");
			
		}
		


		return $oRespuesta;

	}
	
	function _generarComprobantesPagos($datos){
		
		global $oMysql;	
		$oRespuesta = new xajaxResponse();		
		
		if(!datos){
			
		}else{
			
			foreach ($datos as $idLiquidacion) {
				
				$idLiquidacion = (is_null($idLiquidacion) || $idLiquidacion == false) ? 0 : intval($idLiquidacion);
				
				
				$SQL = "SELECT fcn_getLiquidacionesIPlanPromo(\"$idLiquidacion\");";
				
				$iPlanPromo = $oMysql->consultaSel( $SQL , true);
				
				switch ($iPlanPromo) {
					case 1:
							$sub_query = " WHERE Liquidaciones.id=$idLiquidacion";

							$SQL = "CALL usp_getDatosLiquidacionesPlanes(\"$sub_query\");";

							$liquidaciones = $oMysql->consultaSel( $SQL , true);
							
							
							
							
						break;
					case 2:
						
						break;				
					default:
						break;
				}
				

				
				
				
			}
		}

		
		$oRespuesta->assign("impresiones","innerHTML",$html);
	
		$oRespuesta->script("_printCHEQUES();");


		return $oRespuesta;		
	}
		
	
	function _proccessLiquidacionesComercios($form){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();	
		
		$bLiquidar = false;	
		
		$FechaActual = date('Y-m-d');// h:m:s');
		$dFechaTopeConsumos = dateToMySql($form['txtFechaTopeConsumos']);
		$dFechaLiquidacion = dateToMySql($form['txtFechaLiquidacion']);						
		
		list($añoActual,$mesActual,$diaActual)	=split("-",$FechaActual);
		list($añoTope,$mesTope,$diaTope)		=split("-",$dFechaTopeConsumos);
		list($AñoLiquidacion,$mesLiquidacion,$diaLiquidacion)=split("-",$dFechaLiquidacion);
		
		$dif = mktime(0,0,0,$mesActual,$diaActual,$añoActual) - mktime(0,0,0, $mesTope,$diaTope,$añoTope);
		
		/*if($dif < 0){
			
			$oRespuesta->alert("La Fecha Tope de Consumos no puede ser mayor a la Fecha Actual");
			return $oRespuesta;

		}
		
		$dif = mktime(0,0,0,$mesActual,$diaActual,$añoActual) - mktime(0,0,0, $mesLiquidacion,$diaLiquidacion,$AñoLiquidacion);
		
		if($dif > 0){
			
			$oRespuesta->alert("La Fecha de Liquidacion no puede ser menor a la Fecha Actual");
			return $oRespuesta;

		}*/
		
		$aComercios = $form['aComercios'];
		
		$sqlTasaIVA="Call usp_getTasasIVA(\" WHERE TasasIVA.id = 1\");";

		$oTasaIVA = $oMysql->consultaSel($sqlTasaIVA, true);	

		$fTasaIVA = $oTasaIVA['fTasa'];
		
		$fRetencionIVA = 0;
		$fRetencionGanancias = 0;
		$fRetencionIngresosBrutos = 0;
		$fImporteBrutoTotal = 0;		
		
		foreach ($aComercios as $idComercio){
			
			
			#Obtengo cupones agrupados por planes
			#__________________________________________________________________________________________
			
			$SQL = "CALL usp_getCuponesPlanesLiquidaciones(\"$idComercio\",\"{$dFechaTopeConsumos}\");";
			
			$cuponesPlanes = $oMysql->consultaSel($SQL);			
			
			#obtengo cupones agrupados por promociones
			
			$SQL = "Call usp_getCuponesPromocionesLiquidaciones(\"$idComercio\",\"{$dFechaTopeConsumos}\");";
			
			$cupones_agrupados_x_promociones = $oMysql->consultaSel( $SQL );

			$cupones_generales = array_merge($cuponesPlanes,$cupones_agrupados_x_promociones);
			
			$fImporteArancel 		= 0;
			$fTotalArancel 			= 0;
			$fImporteCostoFinanciero= 0;
			$fTotalCostoFinanciero 	= 0;
			$fImporteBrutoTotal 	= 0;
			$fConsumosUnPago 		= 0;
			$fConsumoCuota 			= 0;
			$fImporteTotalIVA_Arancel = 0;
			$fImporteTotalIVA_CostoFinanciero = 0;
			
			foreach($cupones_generales as $cupon){
							
				if($cupon['iCantidadCuota'] == 1){
					
					$fConsumosUnPago += $cupon['fImporteAcumulado'];	
					$importe_consumo_1_pago = $cupon['fImporteAcumulado'];
					$importe_consumo_n_pago = 0;
					
				}else{
					
					$fConsumoCuota += $cupon['fImporteAcumulado'];
					$importe_consumo_1_pago = 0;
					$importe_consumo_n_pago = $cupon['fImporteAcumulado'];
					
				}
				
				$fImporteArancel = ($cupon['fImporteAcumulado'] * $cupon['fPorcentajeArancel']) / 100;
				$fTotalArancel +=  $fImporteArancel;
			
				$fImporteCostoFinanciero = ($cupon['fImporteAcumulado'] * $cupon['fPorcentajeCostoFinanciero']) / 100;
				$fTotalCostoFinanciero +=  $fImporteCostoFinanciero;
				
				$fImporteBrutoTotal += $cupon['fImporteAcumulado'];
						
				//$fImporteIVA_Arancel = ($fTasaIVA * $fImporteArancel) / 100;
				//$fImporteTotalIVA_Arancel += $fImporteIVA_Arancel;
				
				//$fImporteIVA_CostoFinanciero = ($fTasaIVA * $fImporteCostoFinanciero) / 100;
				//$fImporteTotalIVA_CostoFinanciero += $fImporteIVA_CostoFinanciero;					
							
				//$fImporteNetoCobrar = ($cupon['fImporteAcumulado']) - ($fImporteIVA_Arancel + $fImporteArancel + $fImporteIVA_CostoFinanciero + $fImporteCostoFinanciero + $fRetenciones );

			}

			
			#determino retenciones en base al IMPORTE BRUTO
			$fImporteRetencionIVA = 0;
			$fImporteRetencionGanancias = 0;
			$fImporteRetencionIngBrutos = 0;
			
			$SQL = "Call usp_getRetencionesComercio(\"{$idComercio}\");";
			
			$retenciones = $oMysql->consultaSel($SQL , true);
			
			$fRetencionIVA 				= (is_null($retenciones['fRetencionIVA']))				? 0 : $retenciones['fRetencionIVA'];
			$fRetencionGanancias 		= (is_null($retenciones['fRetencionGanancias'])) 		? 0 : $retenciones['fRetencionGanancias'];
			$fRetencionIngresosBrutos 	= (is_null($retenciones['fRetencionIngresosBrutos'])) 	? 0 : $retenciones['fRetencionIngresosBrutos'];
			
			#para calcular retenciones debe ser mayor al importe minimo establecido por dicha retencion
			if($fImporteBrutoTotal > $retenciones['fImporteMinimoIVA']){
				$fImporteRetencionIVA = ($fImporteBrutoTotal * $retenciones['fRetencionIVA']) / 100 ;
			}
			
			if($fImporteBrutoTotal > $retenciones['fImporteMinimoGanancia']){
				$fImporteRetencionGanancias = ($fImporteBrutoTotal * $retenciones['fRetencionGanancias']) / 100 ;
			}
			
			if($fImporteBrutoTotal > $retenciones['fImporteMinimoIngBrutos']){
				$fImporteRetencionIngresosBrutos = ($fImporteBrutoTotal * $retenciones['fRetencionIngresosBrutos']) / 100 ;
			}
			
			//var_export($fImporteRetencionIngBrutos);die();	
			$fRetencionesTotales = $fImporteRetencionIVA +	$fImporteRetencionGanancias + $fImporteRetencionIngresosBrutos;
			

			#Procesar ajustes de comercio (detalles de ajustes de comercios)
			#__________________________________________________________________________________________
			
			
			#asociados a planes
			
			$sub_query 	= " WHERE idComercio = {$idComercio} AND dFechaLiquidacionComercio = '0000-00-00 00:00:00' AND AjustesComercios.iPlanPromo = 0";
			$SQL		= "Call usp_getDetallesAjustesComerios(\"$sub_query\");";
			$AjustesComerciosPlanes 	= $oMysql->consultaSel( $SQL );	
			
			#asociados a promociones
			$sub_query  = " WHERE idComercio = {$idComercio} AND dFechaLiquidacionComercio = '0000-00-00 00:00:00' AND AjustesComercios.iPlanPromo = 1";
			$SQL		= "Call usp_getDetallesAjustesComerios(\"$sub_query\");";
			$AjustesComerciosPromos = $oMysql->consultaSel($SQL);
			
			$ajustes_comercios = array_merge($AjustesComerciosPlanes , $AjustesComerciosPromos);
			
			$fAjusteDebito = 0;
			$fAjusteCredito = 0;
			$fIVA_AjusteDebito = 0;
			$fIVA_AjusteCredito = 0;
			
			foreach ($ajustes_comercios as $ajuste){

				if($ajuste["sClaseAjuste"] == "D"){
					
					$fAjusteDebito += $ajuste["fImporteCuota"];		
					  
					if($ajuste["bDiscriminaIVA"]){ $fIVA_AjusteDebito += $ajuste["fImporteIVA"]; }
							
				}else{
					
					$fAjusteCredito += $ajuste["fImporteCuota"];		
					
					if($ajuste["bDiscriminaIVA"]){ $fIVA_AjusteCredito += $ajuste["fImporteIVA"]; }
						
				}

			}
			
			
			#obtengo totales generales
			#__________________________________________________________________________________________
					
						
			$fRetenciones = $fImporteRetencionIVA +	$fImporteRetencionGanancias + $fImporteRetencionIngresosBrutos;
					
			$fImporteIVA_Arancel = ($fTasaIVA * $fTotalArancel) / 100;
			$fImporteIVA_CostoFinanciero = ($fTasaIVA * $fTotalCostoFinanciero) / 100;						
						
			$fImporteNetoCobrar = 
			($fAjusteCredito +  $fIVA_AjusteCredito + $fImporteBrutoTotal) - 
			($fImporteIVA_Arancel + $fTotalArancel + $fImporteIVA_CostoFinanciero + $fTotalCostoFinanciero + $fRetenciones + $fAjusteDebito + $fIVA_AjusteDebito);				
				
			
			#inserto liquidacion
			
			if(count($ajustes_comercios) > 0 || count($cuponesPlanes) > 0 || count($cupones_agrupados_x_promociones) > 0){

				$Fecha = date('Y-m-d h:m:s');
					
				$sNumero = $oMysql->consultaSel("select fnc_getCodigoLiquidacion();",true);
				
				
				
				$set ="
		  	   		sNumero,
		  	   		dFecha,
		  	   		idComercio,
		  	   		idEmpleado,
		  	   		fConsumosUnPago,
		  	   		fImporteNeto,
		  	   		fConsumoCuota,
		  	   		fImporteBruto,
		  	   		fImporteRetencionIVA,
		  	   		fImporteArancel,
		  	   		fIVA_Arancel,
		  	   		fImporteCostoFinanciero,
		  	   		fIVA_CostoFinanciero,
		  	   		fImporteRetencionGanancias,
		  	   		fImporteRetencionIngBrutos,			  	   		
		  	   		fImporteAjusteDebito,
		  	   		fImporteAjusteCredito,
		  	   		fIVA_AjusteCredito,
		  	   		fIVA_AjusteDebito,
		  	   		sEstado
			  	     ";
					 	   		
				 $values = "
			   		'{$sNumero}',
			   		'{$Fecha}',
			   		'{$idComercio}',
			   		'{$_SESSION['id_user']}',
			   		'{$fConsumosUnPago}',
			   		'{$fImporteNetoCobrar}',
				   	'{$fConsumoCuota}',
			   		'{$fImporteBrutoTotal}',			   		
			   		'{$fImporteRetencionIVA}',
			   		'{$fTotalArancel}',		   		
			   		'{$fImporteIVA_Arancel}',
			   		'{$fTotalCostoFinanciero}',
			   		'{$fImporteIVA_CostoFinanciero}',
			   		'{$fImporteRetencionGanancias}',
			   		'{$fImporteRetencionIngresosBrutos}',
			   		'{$fAjusteDebito}',
			   		'{$fAjusteCredito}',
			   		'{$fIVA_AjusteCredito}',
			   		'{$fIVA_AjusteDebito}',
			   		'A'			   		
				   	";
			   		 
			   		//$oRespuesta->alert($sMensaje);
			   		
				   	$ToAuditory = "Insercion de Liquidacion a Comercio $idComercio::: Empleado ={$_SESSION['id_user']}";
				   
				    $idLiquidacion = $oMysql->consultaSel("CALL usp_InsertTable(\"Liquidaciones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"74\",\"$ToAuditory\");",true);
				   	
					
					
						
					#trabajo los detalles de la liquidacion
					#______________________________________
					
					$fImporteArancel 		= 0;
					$fTotalArancel 			= 0;
					$fImporteCostoFinanciero= 0;
					$fTotalCostoFinanciero 	= 0;
					//$fImporteBrutoTotal 	= 0;
					$fConsumosUnPago 		= 0;
					$fConsumoCuota 			= 0;
					$fImporteTotalIVA_Arancel = 0;
					$fImporteTotalIVA_CostoFinanciero = 0;
					$datos = array();
					foreach($cuponesPlanes as $cupon){
									
						if($cupon['iCantidadCuota'] == 1){
							
							$importe_consumo_1_pago = $cupon['fImporteAcumulado'];
							$importe_consumo_n_pago = 0;
							
						}else{
							
							$importe_consumo_1_pago = 0;
							$importe_consumo_n_pago = $cupon['fImporteAcumulado'];
							
						}
						
						$fImporteArancel = ($cupon['fImporteAcumulado'] * $cupon['fPorcentajeArancel']) / 100;
					
						$fImporteCostoFinanciero = ($cupon['fImporteAcumulado'] * $cupon['fPorcentajeCostoFinanciero']) / 100;
						
						$fImporteBrutoParcial = $cupon['fImporteAcumulado'];
								
						$fImporteIVA_Arancel = ($fTasaIVA * $fImporteArancel) / 100;						
						
						$fImporteIVA_CostoFinanciero = ($fTasaIVA * $fImporteCostoFinanciero) / 100;
						
						#retenciones
						//$fImporteRetencionIVA = 0;
						//$fImporteRetencionGanancias = 0;
						//$fImporteRetencionIngBrutos = 0;						
						
						$porcentaje_retenciones = ($fImporteBrutoParcial * 100) / $fImporteBrutoTotal;
						//var_export($porcentaje_retenciones);die();
						$fImporteRetencionIVAParcial = ($porcentaje_retenciones * $fImporteRetencionIVA) / 100;						
						
						$fImporteRetencionGananciasParcial = ($porcentaje_retenciones * $fImporteRetencionGanancias) / 100;
						
						$fImporteRetencionIngBrutosParcial = ($porcentaje_retenciones * $fImporteRetencionIngresosBrutos) / 100;
						
						$fImporteRetencionesParciales = $fImporteRetencionIVAParcial + $fImporteRetencionGananciasParcial + $fImporteRetencionIngBrutosParcial;
						
						
						#ajustes de comercio asociado al plan i
						$ajustes_comercios = $oMysql->consultaSel("CALL usp_getImportesAjustesComerciosPlanes(\"{$cupon['idPlan']}\",\"$idComercio\");");
						
						$fAjusteDebito = 0;
						$fAjusteCredito = 0;
						$fIVA_AjusteDebito = 0;
						$fIVA_AjusteCredito = 0;
						
						foreach ($ajustes_comercios as $ajuste){
				
							if($ajuste["sClaseAjuste"] == "D"){
								
								$fAjusteDebito += $ajuste["fImporteCuota"];		
								
								//$fIVA_AjusteDebito += $ajuste["fImporteIVA"];
								  
								if($ajuste["bDiscriminaIVA"]){ $fIVA_AjusteDebito += $ajuste["fImporteIVA"]; }
										
							}else{
								
								$fAjusteCredito += $ajuste["fImporteCuota"];		
								
								//$fIVA_AjusteCredito += $ajuste["fImporteIVA"];
								
								if($ajuste["bDiscriminaIVA"]){ $fIVA_AjusteCredito += $ajuste["fImporteIVA"]; }
									
							}
				
						}						
						
						$fImporteNetoCobrar = ($fAjusteCredito +  $fIVA_AjusteCredito + $fImporteBrutoParcial) - 
											  ($fImporteIVA_Arancel + $fImporteArancel + $fImporteIVA_CostoFinanciero + $fImporteCostoFinanciero + $fAjusteDebito + $fIVA_AjusteDebito + $fImporteRetencionesParciales );
						
						$datos[] = "
					   		'{$_SESSION['id_user']}',
					   		'{$importe_consumo_1_pago}',
					   		'{$fImporteNetoCobrar}',
						   	'{$importe_consumo_n_pago}',
					   		'{$fImporteBrutoParcial}',
					   		'{$fImporteIVA_Arancel}',
					   		'{$fImporteIVA_CostoFinanciero}',
					   		'{$fImporteRetencionIVAParcial}',
					   		'{$fImporteRetencionGananciasParcial}',
					   		'{$fImporteRetencionIngBrutosParcial}',
					   		'{$fImporteArancel}',
					   		'{$fImporteCostoFinanciero}',
					   		'{$fAjusteDebito}',
					   		'{$fAjusteCredito}',
					   		'{$fIVA_AjusteDebito}',
					   		'{$fIVA_AjusteCredito}',
					   		'A',
					   		'$idLiquidacion',
					   		'0',
					   		'{$cupon['idPlan']}',
					   		'0'					   		
						   	";

						
					}
					
					
					#PROMOCIONES
					$fImporteArancel 		= 0;
					$fTotalArancel 			= 0;
					$fImporteCostoFinanciero= 0;
					$fTotalCostoFinanciero 	= 0;
					//$fImporteBrutoTotal 	= 0;
					$fConsumosUnPago 		= 0;
					$fConsumoCuota 			= 0;
					$fImporteTotalIVA_Arancel = 0;
					$fImporteTotalIVA_CostoFinanciero = 0;
					
					foreach($cupones_agrupados_x_promociones as $cupon){
									
						if($cupon['iCantidadCuota'] == 1){
							
							$importe_consumo_1_pago = $cupon['fImporteAcumulado'];
							$importe_consumo_n_pago = 0;
							
						}else{
							
							$importe_consumo_1_pago = 0;
							$importe_consumo_n_pago = $cupon['fImporteAcumulado'];
							
						}
						
						$fImporteArancel = ($cupon['fImporteAcumulado'] * $cupon['fPorcentajeArancel']) / 100;
					
						$fImporteCostoFinanciero = ($cupon['fImporteAcumulado'] * $cupon['fPorcentajeCostoFinanciero']) / 100;
						
						$fImporteBrutoParcial = $cupon['fImporteAcumulado'];
								
						$fImporteIVA_Arancel = ($fTasaIVA * $fImporteArancel) / 100;						
						
						$fImporteIVA_CostoFinanciero = ($fTasaIVA * $fImporteCostoFinanciero) / 100;
						
						#retenciones
						//$fImporteRetencionIVA = 0;
						//$fImporteRetencionGanancias = 0;
						//$fImporteRetencionIngBrutos = 0;						
						
						$porcentaje_retenciones = ($fImporteBrutoParcial * 100) / $fImporteBrutoTotal;
						//var_export($porcentaje_retenciones);die();
						$fImporteRetencionIVAParcial = ($porcentaje_retenciones * $fImporteRetencionIVA) / 100;						
						
						$fImporteRetencionGananciasParcial = ($porcentaje_retenciones * $fImporteRetencionGanancias) / 100;
						
						$fImporteRetencionIngBrutosParcial = ($porcentaje_retenciones * $fImporteRetencionIngresosBrutos) / 100;
						
						$fImporteRetencionesParciales = $fImporteRetencionIVAParcial + $fImporteRetencionGananciasParcial + $fImporteRetencionIngBrutosParcial;
						
						
						#ajustes de comercio asociado al plan i
						$ajustes_comercios = $oMysql->consultaSel("CALL usp_getImportesAjustesComerciosPromociones(\"{$cupon['idPlan']}\",\"$idComercio\");");
						
						$fAjusteDebito = 0;
						$fAjusteCredito = 0;
						$fIVA_AjusteDebito = 0;
						$fIVA_AjusteCredito = 0;
						
						foreach ($ajustes_comercios as $ajuste){
				
							if($ajuste["sClaseAjuste"] == "D"){
								
								$fAjusteDebito += $ajuste["fImporteCuota"];		
								
								//$fIVA_AjusteDebito += $ajuste["fImporteIVA"];
								  
								if($ajuste["bDiscriminaIVA"]){ $fIVA_AjusteDebito += $ajuste["fImporteIVA"]; }
										
							}else{
								
								$fAjusteCredito += $ajuste["fImporteCuota"];		
								
								//$fIVA_AjusteCredito += $ajuste["fImporteIVA"];
								
								if($ajuste["bDiscriminaIVA"]){ $fIVA_AjusteCredito += $ajuste["fImporteIVA"]; }
									
							}
				
						}						
						
						$fImporteNetoCobrar = ($fAjusteCredito +  $fIVA_AjusteCredito + $fImporteBrutoParcial) - 
											  ($fImporteIVA_Arancel + $fImporteArancel + $fImporteIVA_CostoFinanciero + $fImporteCostoFinanciero + $fAjusteDebito + $fIVA_AjusteDebito + $fImporteRetencionesParciales );
						
						$datos[] = "
					   		'{$_SESSION['id_user']}',
					   		'{$importe_consumo_1_pago}',
					   		'{$fImporteNetoCobrar}',
						   	'{$importe_consumo_n_pago}',
					   		'{$fImporteBrutoParcial}',
					   		'{$fImporteIVA_Arancel}',
					   		'{$fImporteIVA_CostoFinanciero}',
					   		'{$fImporteRetencionIVAParcial}',
					   		'{$fImporteRetencionGananciasParcial}',
					   		'{$fImporteRetencionIngBrutosParcial}',
					   		'{$fImporteArancel}',
					   		'{$fImporteCostoFinanciero}',
					   		'{$fAjusteDebito}',
					   		'{$fAjusteCredito}',
					   		'{$fIVA_AjusteDebito}',
					   		'{$fIVA_AjusteCredito}',
					   		'A',
					   		'$idLiquidacion',
					   		'0',
					   		'{$cupon['idPlan']}',
					   		'1'					   		
						   	";		
						
							
					}					
					
					$set ="
							idEmpleado,
							fConsumosUnPago,
							fImporteNeto,
							fConsumoCuota,
							fImporteBruto,
							fIVA_Arancel,
							fIVA_CostoFinanciero,
							fImporteRetencionIVA,
							fImporteRetencionGanancias,
							fImporteRetencionIngBrutos,							
							fImporteArancel,
							fImporteCostoFinanciero,
							fImporteAjusteDebito,
							fImporteAjusteCredito,
							fIVA_AjusteDebito,
							fIVA_AjusteCredito,
							sEstado,
							idLiquidacion,
							idTransaccion,
							idPlanPromo,
							iPlanPromo
				  	     ";					
					//'1: Plan  2: Promo',		
					
					foreach ($datos as $detalle) {

						$values = $detalle ;

					   	$toauditory = "Insercion de Detalle de Liquidacion a Comercio ::: Empleado ={$_SESSION['id_user']}";
						//var_export("CALL usp_InsertTable(\"DetallesLiquidaciones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"74\",\"$toauditory\");");die();				
					    $idDetalleLiquidacion = $oMysql->consultaSel("CALL usp_InsertTable(\"DetallesLiquidaciones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"74\",\"$toauditory\");",true);

					}
					
					
				
					
				
				#Actualizar Detalles de cupones con el id de liquidacion
				#_______________________________________________________
				
				$sub_query = " WHERE Cupones.idComercio = {$idComercio} AND DetallesCupones.dFechaLiquidacionComercio <= '{$dFechaTopeConsumos}'";
				
				$SQL = "Call usp_getDetallesCupones(\"$sub_query\");";
				
				$DetallesCupones = $oMysql->consultaSel($SQL);	
							
				//$oRespuesta->alert("idLiquidacion: " . $idLiquidacion);
				
				foreach ($DetallesCupones as $Detalle)
				{
					
					$set = "idLiquidacion = '{$idLiquidacion}', dFechaLiquidacionComercio = '{$dFechaLiquidacion}'";
					
			    	$sCondiciones = "DetallesCupones.id = {$Detalle["id"]}";
			    	
					$sqlDatosUpdate = "CALL usp_UpdateValues(\"DetallesCupones\",\"$set\",\"$sCondiciones\");";				
			    	
					$id = $oMysql->consultaSel($sqlDatosUpdate,true);   		
					//$oRespuesta->alert($sqlDatosUpdate);
				}
				
				
				#Actualizar Detalles de Ajustes de Comercios con el id de liquidacion
				#____________________________________________________________________
				
				$sub_query = " WHERE AjustesComercios.idComercio = {$idComercio} AND DetallesAjustesComercios.dFechaFacturacionComercio <= '{$dFechaTopeConsumos}'";

				$SQL = "Call usp_getDetallesAjustesComerios(\"$sub_query\");";

				$DetallesAjustes = $oMysql->consultaSel( $SQL );
							
				//$oRespuesta->alert($sqlDatosDetalles);			
				//$idLiquidacion = 1000;
				
				foreach ($DetallesAjustes as $Detalle){
					
					#agregar actualizacion de fecha de facturacion a comercio
					$set = "idLiquidacion = '{$idLiquidacion}'";
					
			    	$sCondiciones = "DetallesAjustesComercios.id = {$Detalle["id"]} , dFechaLiquidacionComercio = '{$dFechaLiquidacion}'";
			    	
					$SQL = "CALL usp_UpdateValues(\"DetallesAjustesComercios\",\"$set\",\"$sCondiciones\");";				
			    	
					$id = $oMysql->consultaSel($SQL,true);
					
					//$oRespuesta->alert($SQL);
					
				}
				
				//$idLiquidacion = 10;
				/*$set = "idLiquidacion = '{$idLiquidacion}'";
			    $sCondiciones = "DetallesCupones.dFechaLiquidacionComercio <= '{$dFechaTopeConsumos}' and idLiquidacion = 0";
									
				$id = $oMysql->consultaSel("CALL usp_UpdateValues(\"DetallesCupones\",\"$set\",\"$sCondiciones\");",true);   		
				
				$oRespuesta->alert("CALL usp_UpdateValues(\"DetallesCupones\",\"$set\",\"$sCondiciones\");");*/
				
				//-------------------------------------------------------------------------------------------------------------------------------------------------
			
			}#fin if(if(count($AjustesComercios) > 0 || count($CuponesAgrupadosPorPlan) > 0)
			
			# Reiniciar valores	
			$fImporteIVA_Arancel = 0;
			$fImporteIVA_CostoFinanciero = 0;			
			$fImporteRetencionIVA = 0;
			$fImporteRetencionGanancias = 0;
			$fImporteRetencionIngBrutos = 0;	

				
		} #fin foreach comercios
		
		$oRespuesta->alert("Liquidacion registrada");
				
		return $oRespuesta;
	}
	
	function _change_number_cupon($datos){
		global $oMysql;
		$oRespuesta = new xajaxResponse();	
		
		$id_cupon = intval(_decode($datos['_i']));
		
		if($id_cupon != 0){
			
			$SQL = "UPDATE Cupones SET sNumeroCupon='{$datos['sNumeroCupon']}' WHERE Cupones.id='$id_cupon'";
			
			$rs = $oMysql->consultaSel($SQL,true);
			
			$oRespuesta->alert('se modifico correctamente el numero de cupon. Por favor cierre la popup y recargue la pagina.');
			
		}else{
			$oRespuesta->alert('CUPON incorrecto, por favor reintente');
		}
		
		return $oRespuesta;
		
	}


	function habilitarCupones($form)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
			 
		$aCupones = $form['aCupones'];
		$aCuentaHabilitadas = array();
		
		foreach ($aCupones as $idCupon){
			$idCupon = _decode($idCupon);
			$sCondicionesFacturado = "WHERE Cupones.id = '{$idCupon}'";
			$oRespuesta->alert($sCondicionesFacturado);
			
	    	$oFacturado=$oMysql->consultaSel("CALL usp_getCupones(\"$sCondicionesFacturado\");",true);
	    	$idCuentaUsuario = $oFacturado["idCuentaUsuario"];
	    	$oRespuesta->alert($oFacturado['sEstado']);
	    	
	    	if($oFacturado['sEstado'] == 'A' || $oFacturado['sEstado'] == 'F'){
	    		
	    		$script = "xajax_marcarCuponesActivado({$idCupon});";
	    		$oRespuesta->alert($script);
	    		$oRespuesta->script($script);
	    	}else{
	    		$aCuentaHabilitadas[]= $idCuentaUsuario;
	    	}
		}
		if(count($aCuentaHabilitadas)>0){
			$sCuentaHabilitadas = implode(",",$aCuentaHabilitadas);
			$oRespuesta->alert("Los siguientes Cupones se encuentran habilitados: ".$sCuentaHabilitadas);
		}
	    $oRespuesta->alert("La operacion se realizo correctamente");
		
	    $oRespuesta->redirect("Cupones.php");
		return  $oRespuesta;
	}
	
	function reactivarCupones($idCupon){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$idCupon = intval(_decode($idCupon));
		
		if(is_integer($idCupon) && $idCupon != 0){
			
			$cupones = new cupons($idCupon);
			
			$cupones->habilitar();	
			
			$oRespuesta->alert("Se reactivo el cupon seleccionado.");
			
			$script=" window.location.reload();";

			$oRespuesta->script($script);
		}else{
			$oRespuesta->alert("Codigo de CUPON es incorrecto.");
		}
		
		//$oRespuesta->redirect("Cupones.php");
		return  $oRespuesta;
	}
?>