<?php
function getCuentaUsuario($sNroCuenta = "", $bObtenerDetalleCuenta = true)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		//$oRespuesta->alert("$sNroCuenta");
		
		$sCondiciones = "WHERE CuentasUsuarios.sNumeroCuenta = '" . trim($sNroCuenta) . "' AND ( Tarjetas.idTipoEstadoTarjeta = 8 OR Tarjetas.idTipoEstadoTarjeta = 1 OR Tarjetas.idTipoEstadoTarjeta = 5 OR Tarjetas.idTipoEstadoTarjeta = 3 )";
		
		$sqlDatos = "Call usp_getTarjetas (\"$sCondiciones\");";

		$result = $oMysql->consultaSel($sqlDatos,true);
		
		$sUsuario = "NO EXISTE CUENTA";       
		$apellidoUsuario 	= "";
		$nombreUsuarios 	= "";
		$idCuentaUsuario 	= 0;
		$numeroTarjeta 		= "";
		$versionTarjeta 	= "";
		$numeroCuenta 		= "";
		$idUsuario 			= "";
		$limiteCredito 		= 0;
		
		if(!$result){			
			
			$string = "<span style='color:#F00;font-size:11px;'>- ingrese numero de cuenta de usuario o identifiquelo desde busqueda avanzada</span>";
			$oRespuesta->assign("datos_cuenta", "innerHTML", $string);                         
			
		}else{
			
			$sUsuario = $result["sApellido"] .", ". $result["sNombre"];
			
			$apellidoUsuario 	= $result["sApellido"];
			$nombreUsuarios 	= $result["sNombre"];
			$idCuentaUsuario 	= $result["idCuentaUsuario"];
			$numeroTarjeta 		= $result["sNumeroTarjeta"];
			$versionTarjeta 	= $result["iVersion"];
			$numeroCuenta 		= $result['sNumeroCuenta'];
			$idUsuario 			= $result['id'];
			$fechaCierre 		= "-";
			$saldoAnterior 		= "-";
					
			switch ($result['idTipoTarjeta'])
			{
				case 1:
					$cartel_tipo_tarjeta = "TITULAR";
					break;
				case 2:
					$cartel_tipo_tarjeta = "ADICIONAL";
					break;
				default:
					break;
			}
			
		
			$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left;\'>Usuario: </label><label>' . $sUsuario. '</label></div>';
			$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tarjeta: </label><label>' . $result["sNumeroTarjeta"] . '</label></div>';
			$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tipo Tarjeta: </label><label>' .$cartel_tipo_tarjeta . '</label></div>';
			$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>version: </label><label>' .  $result["iVersion"] . '</label></div>';
						
			if($bObtenerDetalleCuenta)
			{
				$sCondiciones = " where idCuentaUsuario = {$idCuentaUsuario} and iEmiteResumen = 1 order by DetallesCuentasUsuarios.id DESC LIMIT 0,1 ";
				$sqlDatos = "CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");";	
				$result = $oMysql->consultaSel($sqlDatos,true);
		
				if(!$result)
				{
					/*$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'></label><label>______________</label></div>';
					$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Ultimo Resumen: </label><label>' .  $result["dFechaCierre"] . '</label></div>';
					$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Importe: </label><label>' .  $result["fSaldoAnterior"] . '</label></div>';*/

				}else{
					$fechaCierre = $result["dFechaCierre"];
					$saldoAnterior = $result["fSaldoAnterior"];					
				}
				
				//$oRespuesta->assign("dFechaUltimoResumen", "innerHTML", $dFechaResumen);
				//$oRespuesta->assign("fImporteTotal", "innerHTML", $fSaldoAnterior);                            
			}
			
            $script = "setDatosCuentaUsuario2(
			'"._encode($idCuentaUsuario)."',
			'{$apellidoUsuario}, {$nombreUsuarios}',
			'{$numeroTarjeta}',
			'$cartel_tipo_tarjeta',
			'{$versionTarjeta}',
			'{$numeroCuenta}',
			'$limiteCredito',
			'"._encode($user['id'])."',
			'".$fechaCierre."',
			'".$saldoAnterior."'
			);";
			$oRespuesta->script("$script");
			
			//$oRespuesta->assign("idCuentaUsuario", "value", _encode($idCuentaUsuario));
			//$oRespuesta->assign("datos_cuenta", "innerHTML", $sString);   			
			
			
		}
		
		return $oRespuesta; 
	}
	
	//------------------------- PROVEEDORES ------------------------------------------------
	function updateDatosProveedores_($form)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		//$oRespuesta->alert("updateDatosProveedores");
		
		$dFecha =  date("Y-m-d h:i:s");			
				
		$form['idProveedor'] = $form['idProveedor'];		
		$sCodigo=$oMysql->consultaSel("select fnc_getCodigoProveedor();",true);
		
		//$oRespuesta->alert("idProveedor: " . $form['idProveedor']);
		
	  	if($form['idProveedor'] == 0)
	    {       
	  	   $set ="
	  	   		idEmpleado,
	  	   		dFechaRegistro,
	  	   		sCodigo,
	  	   		sRazonSocial,
	  	   		sApellido,
	  	   		sNombre,
	  	   		sCuit,
	  	   		sDni,
	  	   		sTelefono,
	  	   		sDireccion,
	  	   		sEstado,
	  	   		sEmail,
	  	   		idProvincia,
	  	   		idLocalidad  	   		
	  	   		";
	  	     	   		
		   $values = "
		   		'{$_SESSION['id_user']}',
		   		'{$dFecha}',
		   		'{$sCodigo}',	
		   		'{$form['sRazonSocial']}',
		   		'{$form['sApellido']}',
		   		'{$form['sNombre']}',		   		
		   		'{$form['sCuit']}',
		   		'{$form['sDni']}',
		   		'{$form['sDireccion']}',
		   		'{$form['sTelefono']}',
		   		'A',
		   		'{$form['sEmail']}',
		   		'{$form['idProvincia']}',
		   		'{$form['idLocalidad']}'
		   		";
		   	 	 
		   	   
		   $ToAuditory = "Insercion de Proveedor ::: Empleado ={$_SESSION['id_user']}";		   
		   $idProveedor = $oMysql->consultaSel("CALL usp_InsertTable(\"Proveedores\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"1\",\"$ToAuditory\");",true);     		   
		   
		  // $oRespuesta->alert("CALL usp_InsertTable(\"Proveedores\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"1\",\"$ToAuditory\");");
	    }
	    else
    	{   		
   	 			$set = 
   	 				"sRazonSocial = '{$form['sRazonSocial']}',			 
			 		 sApellido = '{$form['sApellido']}',
 			 		 sNombre = '{$form['sNombre']}',
			 		 sCuit = '{$form['sCuit']}',
			 		 sDni = '{$form['sDni']}',
			 		 sDireccion = '{$form['sDireccion']}',
			 		 sTelefono = '{$form['sTelefono']}',
   	 				 sEmail = '{$form['sEmail']}',
   	 				 idProvincia = '{$form['idProvincia']}',
   	 				 idLocalidad = '{$form['idLocalidad']}'";
   	 				
		
			$conditions = "Proveedores.id = '{$form['idProveedor']}'";
			$ToAuditory = "Actualizacion de Datos de Proveedores ::: User ={$_SESSION['id_user']} ::: idProveedor={$form['idProveedor']}";	
		
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Proveedores\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"2\",\"$ToAuditory\");",true);   
			//$oRespuesta->alert("CALL usp_UpdateTable(\"Proveedores\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"2\",\"$ToAuditory\");");
    	}
    	
    	
    	$oRespuesta->alert("La operacion se realizo correctamente");
  		$oRespuesta->redirect("Proveedores.php");
  	
		return  $oRespuesta;	
	}
	
	function updateEstadoProveedor($idProveedor, $sEstado)
	{
	    GLOBAL $oMysql;
	    $oRespuesta = new xajaxResponse();   
		
	    //$oRespuesta->alert("updateEstadoProveedor");
	       
	    $set = "sEstado = '{$sEstado}'";
	    $conditions = "Proveedores.id = '{$idProveedor}'";
		$ToAuditory = "Actualizacion de Estado de Proveedor ::: User ={$_SESSION['id_user']} ::: idProveedor={$idProveedor} ::: estado={$sEstado}";
		
		//$oRespuesta->alert("CALL usp_UpdateTable(\"Proveedores\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"10\",\"$ToAuditory\");");
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Proveedores\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"10\",\"$ToAuditory\");",true);   
		
		$oRespuesta->alert("La operacion se realizo correctamente");
		$oRespuesta->redirect("Proveedores.php");
		return $oRespuesta;
	}
	
	
	//------------------------------------------ Devolucion Materiales --------------------------------------------------------------------------------
	function buscarDatosMateriales($datos)
	{
		global $oMysql;	
		$oRespuesta = new xajaxResponse();		

		$conditions = array();	

		if($datos['sCodigo'] != ''){
			$conditions[] = "Productos.sCodigo = '{$datos['sCodigo']}'";
		}
		
		if($datos['sDescripcion'] != ''){
			$conditions[] = "Productos.sNombre LIKE '{$datos['sDescripcion']}%'";
		}
		
		$sub_query = " WHERE " . implode(" AND ",$conditions) . " ORDER BY sCodigo ASC" ;
		//var_export("CALL usp_getTarjetas(\"$sub_query\");");die();
		$Materiales = $oMysql->consultaSel("CALL usp_getProductos(\"$sub_query\");");
		
		//$oRespuesta->alert("CALL usp_getProductos(\"$sub_query\");");
		
		$table = "<table width='600' cellspacing='0' cellpadding='0' align='center' class='table_object' id='table_object'>";
		$table .= "<tr>
					<th width='30'>&nbsp;</th>
					<th width='100'>Codigo</th>
					<th width='100'>Descripcion</th>					
				  </tr>";
		
		if(!$Materiales)
		{
				$table .= 
				"<tr>
					<td colspan='5' align='left'>-no se encontraron registros</td>
				 </tr>";				
		}
		else
		{
			foreach ($Materiales as $Mat) 
			{														
				$table .= "<tr>
							<td width='30'><input type='radio' name='materiales[]' id='materiales_{$Mat['id']}' 
							onclick=\"parent.setDatosMateriales({$Mat['id']},'{$Mat['sCodigo']}', '{$Mat['sNombre']}', '{$Mat['sNombreUnidadMedida']}','{$Mat['idUnidadMedida']}');\"></td>
							<td width='100'>{$Mat['sCodigo']}</td>
							<td width='100'>{$Mat['sNombre']}</td>							
						  </tr>";			
			}			
		}
		

		$table .= "</table>";
		//$oRespuesta->alert($table);
		$oRespuesta->assign("resultado_busqueda","innerHTML",$table);
		
		return $oRespuesta;	
	}	
	

	//------------------------------ Asignar Materiales ----------------------------------------------------------
	function buscarDatosMateriales2($datos, $idProveedor)
	{
		global $oMysql;	
		$oRespuesta = new xajaxResponse();		

		//$oRespuesta->alert($idProveedor);
		
		$conditions = array();	

		
		if($datos['idFamiliaProducto'] != ''){
			$conditions[] = "Productos.idFamilia = '{$datos['idFamiliaProducto']}'";
		}
		
		if($datos['sCodigo'] != ''){
			$conditions[] = "Productos.sCodigo = '{$datos['sCodigo']}'";
		}
		
		if($datos['sDescripcion'] != ''){
			$conditions[] = "Productos.sNombre LIKE '{$datos['sDescripcion']}%'";
		}
		
		$sub_query = " WHERE " . implode(" AND ",$conditions) . " ORDER BY sCodigo ASC" ;
		//var_export("CALL usp_getTarjetas(\"$sub_query\");");die();
		$Materiales = $oMysql->consultaSel("CALL usp_getProductos(\"$sub_query\");");
		
		//$oRespuesta->alert("CALL usp_getProductos(\"$sub_query\");");
		
		$table = "<table width='600' cellspacing='0' cellpadding='0' align='center' class='table_object' id='TableProveedores'>";
		$table .= "<tr>
					<th width='30'>&nbsp;</th>
					<th width='100'>Codigo</th>
					<th width='100'>Descripcion</th>
					<th width='100'>Familia</th>
				  </tr>";
		
		if(!$Materiales)
		{
				$table .= 
				"<tr>
					<td colspan='5' align='left'>-no se encontraron registros</td>
				 </tr>";				
		}
		else
		{
			foreach ($Materiales as $Mat) 
			{	
				$sSql = "SELECT COUNT(ProveedoresProductos.id) FROM ProveedoresProductos WHERE ProveedoresProductos.idProveedor = {$idProveedor} AND ProveedoresProductos.idProducto = {$Mat['id']}";
				
				//$oRespuesta->alert($sSql);
				$iCantidad = $oMysql->consultaSel($sSql, true);

				if($iCantidad > 0)
				{
					$std = "&nbsp;";
					$sStyle = "style='color:#00bf5f'";
				}
				else 
				{
					$std = "<input type='checkbox' name='aMateriales[]' id='aMateriales_{$Mat['id']}' className='aMateriales' value='{$Mat['id']}' >";
					$sStyle = "";
				}
							
				$table .= "<tr>
							<td width='30'>
								$std
							</td>
							<td width='100' $sStyle>{$Mat['sCodigo']}</td>
							<td width='100' $sStyle>{$Mat['sNombre']}</td>	
							<td width='100' $sStyle>{$Mat['sNombreFamilia']}</td>						
						  </tr>";			
			}

			$table .="
					<tr>						
						<td colspan='4' width='30' align='right'>
							<input name='btnAsignar' type='button' id='btnAsignar' value='Asignar' 
							onclick=\"agregarMateriales()\"\">			
						</td>
				  	</tr>
				  	";
		}
		

		$table .= "</table>";
				
		
		$oRespuesta->assign("resultado_busqueda","innerHTML",$table);
		$oRespuesta->assign("lblReferencia", "style.display","block");
		
		return $oRespuesta;	
	}

	
	
	function quitarMateriales_($idProveedor, $idProducto)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();		
			
		/*$set ="idProveedor = $idProveedor AND idProducto = $idProducto";	*/	   
		   
		$sSQL = "DELETE FROM ProveedoresProductos WHERE ProveedoresProductos.idProveedor = {$idProveedor} AND ProveedoresProductos.idProducto = $idProducto";

		//$oRespuesta->alert($sSQL);
		$oMysql->consultaSel($sSQL,true); 	

		$oRespuesta->redirect("ProveedoresProductos.php?idProveedor=$idProveedor");

		return $oRespuesta;
	}
	

	
	function asignarMateriales_($form, $sMateriales, $idProveedor)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		//$oRespuesta->alert($idProveedor);
		//$oRespuesta->alert($sMateriales);
		$dFecha =  date("Y-m-d h:i:s");			
			
		$aMateriales = explode(',', $sMateriales);		
		
		if(!$aMateriales || $sMateriales == "")
		{
			$oRespuesta->alert("Seleccione al menos un material");
			return  $oRespuesta;
		}
		
		foreach ($aMateriales as $idMaterial)
		{
			$b = true;		
			
			$set ="
	  	   		idProveedor,
	  	   		idProducto,
	  	   		idEmpleado,
	  	   		fPrecioUnidad,
	  	   		iPlazoEntrega,
	  	   		iPlazoPago,
	  	   		iCantidadMinima,	  	   		
	  	   		dFechaRegistro
	  	   		";
	  	     	   		
		   $values = "
			   	'$idProveedor',
		   		'$idMaterial',
		   		'{$_SESSION['id_user']}',
		   		'0',
		   		'0',
		   		'0',
		   		'0',		   			
		   		'{$dFecha}'
		   		";
		   	 	 
		   $ToAuditory = "Asignacion de Materiales a Proveedor ::: Empleado ={$_SESSION['id_user']}";		   
		   
		   $sSQL = "CALL usp_InsertTable(\"ProveedoresProductos\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$ToAuditory\");";
		   
		   //$oRespuesta->alert($sSQL);
		   $idDevolucion = $oMysql->consultaSel($sSQL,true); 
		}
		
		$oRespuesta->alert("Materiales asignados correctamente");			
		
		
		$table = "<table width='600' cellspacing='0' cellpadding='0' align='center' class='table_object' id='TableProveedores'>
					<tr>
					<th width='30'>&nbsp;</th>
					<th width='100'>Codigo</th>
					<th width='100'>Descripcion</th>
					<th width='100'>Familia</th>
				  </tr>
				</table>";
		
		$oRespuesta->assign("resultado_busqueda","innerHTML",$table);
		
		//$oRespuesta->redirect("ProveedoresProductos.php?idProveedor=$idProveedor");
			
		return $oRespuesta;
	}
	//-------------------------------------------------------------------------------------------------------------------------
	
	
	function updateDatosDevolucion($form)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		//$oRespuesta->redirect("VistaPreviaDevolucion.php?idDevolucionMaterial=5");//{$idDevolucion}");
		//return $oRespuesta;	
		
		$dFechaRegistro =  date("Y-m-d h:i:s");			
		$dFechaSolicitud = 	date("Y-m-d");			
			
		$sNumeroDevolucion = "D".$form["sNumeroSolicitud"];
		
		
		if($form['idDevolucion'] == 0)
	    {       
	  	   $set ="
	  	   		idSolicitud,
	  	   		idEmpleado,
	  	   		dFechaRegistro,
	  	   		dFechaDevolucion,
	  	   		idUnidadOrigen,
	  	   		idUnidadDestino,
	  	   		sAsunto,
	  	   		sNumeroDevolucion,
	  	   		iTotalItems,
	  	   		sObservaciones,
	  	   		sEstado,
	  	   		idTipoEstado
	  	   		";
	  	     	   		
		   $values = "
			   	'{$form['idSolicitud']}',
		   		'{$_SESSION['id_user']}',
		   		'{$dFechaRegistro}',
		   		'{$dFechaSolicitud}',
		   		'{$form['idUnidadOrigen']}',
		   		'{$form['idUnidadDestino']}',
		   		'{$form['sAsunto']}',		   		
		   		'{$sNumeroDevolucion}',
		   		'{$form['iTotalItems']}',
		   		'{$form['sObservaciones']}',
		   		'A',		
		   		'1'	   		
		   		";
		   	 	 
		   $ToAuditory = "Insercion de Solicitud de Devolucion ::: Empleado ={$_SESSION['id_user']}";		   
		   $idDevolucion = $oMysql->consultaSel("CALL galogistica.usp_InsertTable(\"DevolucionesMateriales\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"11\",\"$ToAuditory\");",true);     		   		   
		   
		   //$oRespuesta->alert("CALL usp_InsertTable(\"DevolucionesMateriales\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"11\",\"$ToAuditory\");");
	    } 
	    
	    
	    $i = 1;
		     
	   foreach($form as $key => $value)
	   {
			
			$a = strpos($key,"Productos_") ;
			$b = strpos($key,"Productos_rowsadded");
			$c = strpos($key,"Productos_rowsdeleted");
						
			if($a !== false && $b === false && $c === false)
			{				
				if($i % 7 == 0 && $i != 0)
				{					
					$array = explode("_",$key);
					
					if(!in_array($array[1],$aRowsDeletes))
					{						
						$idProducto = $form[ "Productos_" . $array[1] . "_0" ];
						$sCodigo = $form[ "Productos_" . $array[1] . "_1" ];
						$sNombre = $form[ "Productos_" . $array[1] . "_2" ];
						$sUnidadMedida = $form[ "Productos_" . $array[1] . "_3" ];
						$iCantidad = $form[ "Productos_" . $array[1] . "_4" ];
						$bNoSolicitado = $form[ "Productos_" . $array[1] . "_5" ];
						$bDaniado = $form[ "Productos_" . $array[1] . "_6" ];
						$idUnidadMedida = $form[ "Productos_" . $array[1] . "_7" ];
												
						if($bDaniado == 1 || $bNoSolicitado == 1)
						{		
							$aDetalles[] = 
							array
								(
									'idProducto'=>$idProducto,
									'sCodigo'=>$sCodigo,
									'sNombre'=>$sNombre,
									'sUnidadMedida'=>$sUnidadMedida,
									'iCantidad'=>$iCantidad,
									'bNoSolicitado'=>$bNoSolicitado,
									'bDaniado'=>$bDaniado,
									'idUnidadMedida'=>$idUnidadMedida
								);						
						}
					}							
				}
				
				$i++;
			}	
		}
		
		
	    $id = insertProductos($aDetalles,$idDevolucion);		
	    
	    //------------------- Actualizar el stock de los productos ------------------------------
	     $id = $oMysql->consultaSel("CALL galogistica.usp_actualizarStockProductosDevolucion(\"{$idDevolucion}\");",true); 	
		 //$oRespuesta->alert("CALL usp_actualizarStockProductosDevolucion(\"{$idDevolucion}\");");
	      
	    //------------------- Actualizar el estado de la Solicitud a DEVUELTO -------------------
	    $set = "idTipoEstado = '6'"; // 6:Devuelto
	    $conditions = "SolicitudesMateriales.id = '{$form['idSolicitud']}'";
		$ToAuditory = "Update Estado Solicitud de Material ::: User ={$_SESSION['id_user']} ::: idSolicitud={$form['idSolicitud']} ::: estado=6";
		
		$id = $oMysql->consultaSel("CALL galogistica.usp_UpdateTable(\"SolicitudesMateriales\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"15\",\"$ToAuditory\");",true);   
    	
		//---------------------------------------------------------------------------------------
    	

    	//-------------- Insertar datos de devolucion para Historial --------------------------------------
    	
		$setEstadoSolicitud = "idSolicitud,idEmpleado,idTipoEstadoSolicitud,dFechaRegistro,sMotivo";
		$valuesEstadoSolicitud = "'{$form['idSolicitud']}','{$_SESSION['id_user']}','6',NOW(),''";
		$ToAuditoryEstadoSolicitud = "Insercion Historial de Estados de Solicitudes de Materiales::: Empleado ={$_SESSION['id_user']} ::: idSolicitud={$form['idSolicitud']} ::: estado=6";
		$idEstadoSolicitud = 
			$oMysql->consultaSel("CALL galogistica.usp_InsertTable(\"EstadosSolicitudesMateriales\",\"$setEstadoSolicitud\",\"$valuesEstadoSolicitud\",\"{$_SESSION['id_user']}\",\"16\",\"$ToAuditoryEstadoSolicitud\");",true);       	
			
    	//-------------------------------------------------------------------------------------------------
    	
    	$oRespuesta->alert("La operacion se realizo correctamente");
    	$oRespuesta->redirect("VistaPreviaDevolucion.php?idDevolucionMaterial={$idDevolucion}");
  		//$oRespuesta->redirect("../SolicitudesMateriales/AdminSolicitudesMateriales.php?idSolicitud={$form['idSolicitud']}&url_back=../SolicitudesMateriales/SolicitudesMateriales.php");
  	
		return  $oRespuesta;	
	}
	
	
	function insertProductos($aDatos, $idDevolucion)
	{
		global $oMysql;
		$setProductos =
			"(
			 	idDevolucionMaterial,
			 	idProducto,
			 	iCantidad,
			 	sCodigoProducto,
			 	sNombreProducto,
			 	sUnidadMedidaProducto,
			 	bNoSolicitado,
			 	bDaniado,
			 	idUnidadMedida
			 )";
			
		$valuesProductos = "";
		$array=array();
		
		foreach ($aDatos as $aItem )
		{			
			$array[] = 
			"(
				'{$idDevolucion}',
				'{$aItem['idProducto']}',
				'{$aItem['iCantidad']}',
				'{$aItem['sCodigo']}',
				'{$aItem['sNombre']}',
				'{$aItem['sUnidadMedida']}',
				'{$aItem['bNoSolicitado']}',
				'{$aItem['bDaniado']}',
				'{$aItem['idUnidadMedida']}'
			)";
		}				
		
		$valuesProductos = implode(',',$array);
		
		//$ToAuditory = "Alta de Productos ::: Pedido :::'{$idPedido}'";	
		$sqlProducto = "INSERT INTO galogistica.DetallesDevolucionesMateriales {$setProductos} VALUES {$valuesProductos}";
		
		//var_export("INSERT INTO galogistica.DetallesDevolucionesMateriales {$setProductos} VALUES {$valuesProductos}");
		
		$oMysql->startTransaction();
		$oMysql->consultaAff($sqlProducto);
		$oMysql->commit();
		
		$id = "1";
		/*$id = array_shift($oMysql->consultaSel("CALL usp_abm_General(\"det_pedidos\",\"$set\",\"$values\",\"1\",\"{$_SESSION['ID_USER']}\",\"0\",\"$ToAuditory\");"));*/
		
		return $id;
	}
	
	//****************************** COBRANZAS *******************************************************************
	function buscarDatosUsuarioCobranzas($datos)
	{
		global $oMysql;	
		$oRespuesta = new xajaxResponse();		

		$conditions = array();	
		
		//$conditions[] = "Tarjetas.idTipoEstadoTarjeta = 8";
		$conditions[] = "( Tarjetas.idTipoEstadoTarjeta = 8 OR Tarjetas.idTipoEstadoTarjeta = 1 OR Tarjetas.idTipoEstadoTarjeta = 5 )";

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
				$limiteCredito = 0;
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
				
				
				//----------------- Obtener detalle cuenta usuario -----------------------------------------
					$sCondiciones = "where idCuentaUsuario = {$user['idCuentaUsuario']} AND iEmiteResumen = 1 order by DetallesCuentasUsuarios.id DESC LIMIT 0,1 ";
					$sqlDatos = "CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");";	
					$detalle = $oMysql->consultaSel($sqlDatos,true);
					
					$detalle['dFechaCierre'] = (!$detalle['dFechaCierre']) ? "-" : $detalle['dFechaCierre'];
					$detalle['fSaldoAnterior'] = (!$detalle['fSaldoAnterior']) ? "-" : $detalle['fSaldoAnterior'];
				//------------------------------------------------------------------------------------------
				
				$table .= "<tr>
							<td width='30'><input type='radio' name='user[]' id='user_{$usuario['id']}' onclick=\"parent.setDatosCuentaUsuario('"._encode($user['idCuentaUsuario'])."','{$user['sApellido']}, {$user['sNombre']}','{$user['sNumeroTarjeta']}','$cartel_tipo_tarjeta','{$user['iVersion']}','{$user['sNumeroCuenta']}','$limiteCredito','"._encode($user['id'])."','".$detalle['dFechaCierre']."','".$detalle['fSaldoAnterior']."');\"></td>
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
		
	function updateDatosCobranzas($form)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();		
			
		$oRespuesta->assign( 'sMensaje','innerHTML','');
		//$oRespuesta->redirect("VistaPreviaCobranza.php?idCobranza=1");	    
		//return  $oRespuesta;  
	    
		$idCuentaUsuario = _decode($form['idCuentaUsuario']);	
		
		$dFechaRegistro =  date("Y-m-d h:i:s"); //date("Y-m-d h:i:s"); 
		$dFechaPresentacion = $dFechaRegistro;				
		$dFechaCobranza = dateToMySql($form['dFechaCobranza']);  
			
		$fecha = getdate();
				
		$sNumeroRecibo =$oMysql->consultaSel("select fnc_getNroReciboCobranza(\"{$_SESSION['ID_OFICINA']}\");",true);
		$aNumero = explode('-', $sNumeroRecibo);		
		$sCodigoBarra = $aNumero[0]. $aNumero[1].number_pad($fecha['mday'],2).number_pad($fecha['mon'],2).$fecha['year'].number_pad($fecha['hours'],2).number_pad($fecha['minutes'],2).number_pad($fecha['seconds'],2);

		if($form['idEmpleado'])
			$idEmpleado = $form['idEmpleado']; 
		else 
			$idEmpleado = $_SESSION['id_user'];
		
	  	   $set ="
	  	   		idCuentaUsuario,
	  	   		idListadoCobranza,
	  	   		idEmpleado,
	  	   		idTipoMoneda,
	  	   		dFechaCobranza,
	  	   		dFechaPresentacion,
	  	   		dFechaRegistro,
	  	   		fImporte,
	  	   		sEstado,
	  	   		iEstadoFacturacionUsuario,
	  	   		idOficina,
	  	   		sNroRecibo,
	  	   		sCodigoBarra
	  	   		";
	  	     	   		
		   $values = "
		   		'{$idCuentaUsuario}',
		   		'0',
		   		'{$idEmpleado}',
		   		'{$form['idTipoMoneda']}',
		   		'{$dFechaCobranza}',
			   	'{$dFechaPresentacion}',
		   		'{$dFechaRegistro}',
		   		'{$form['fImporte']}',
		   		'A',
		   		'0',
 			   	'{$_SESSION['ID_OFICINA']}',
 			   	'{$sNumeroRecibo}', 			   	
 			   	'{$sCodigoBarra}'
		   	";
		   	 
		  //$oRespuesta->alert($set. " " . $values);
		   
		  $ToAuditory = "Insercion de Cobranzas ::: Empleado ={$_SESSION['id_user']}, Solicita Empleado = {$idEmpleado}";
		  
		  $id = $oMysql->consultaSel("CALL usp_InsertTable(\"Cobranzas\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"67\",\"$ToAuditory\");",true);   

		  #Actualizar Acumulado de Cobranza en la cuenta de usuario		   
		  $oMysql->consultaSel("CALL usp_updateCobranzaCuentaUsuario(\"{$idCuentaUsuario}\",\"{$form['fImporte']}\");",true);
	      //$oRespuesta->alert("CALL usp_updateCobranzaCuentaUsuario(\"{$idCuentaUsuario}\",\"{$form['fImporte']}\");");	 
		  
	    setEstadoCuentaUsuarioByCobranza($idCuentaUsuario);
	    RecalcularLimites($idCuentaUsuario);   
	    
	    $oRespuesta->alert("La operacion se realizo correctamente");
	  	
	    $oRespuesta->redirect("VistaPreviaCobranza.php?idCobranza={$id}");
	    
		return  $oRespuesta;
	}
			
	function getDias($dFechaMayor, $dFechaMenor)
	{	
		list($dia1,$mes1,$año1)=split("/",$dFechaMayor);
		list($dia2,$mes2,$año2)=split("/",$dFechaMenor);
		 
		//calculo timestam de las dos fechas
		$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
		$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2);
		
		//resto a una fecha la otra
		$segundos_diferencia = $timestamp1 - $timestamp2;
		//echo $segundos_diferencia;
		
		//convierto segundos en días
		$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
		
		//obtengo el valor absoulto de los días (quito el posible signo negativo)
		$dias_diferencia = abs($dias_diferencia);
		
		//quito los decimales a los días de diferencia
		$dias_diferencia = floor($dias_diferencia);
		
		return $dias_diferencia;
	}
		
	function RecalcularLimites($idCuentaUsuario)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$sCondiciones = "WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$idCuentaUsuario}	ORDER BY DetallesCuentasUsuarios.id DESC LIMIT 0,1 ;";		
		$datosDetalle = $oMysql->consultaSel("CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");", true);
		
		if(!$datosDetalle)
		{
			$oRespuesta->alert("No se encontro un detalle de cuenta de usuario");
			return $oRespuesta;			
		}
		
		$fSaldoAnterior = $datosDetalle['fSaldoAnterior'];
		$fAcumuladoCobranza = $datosDetalle['fAcumuladoCobranza'];
		$fAcumuladoConsumoCuota = $datosDetalle['fAcumuladoConsumoCuota'];
		$fAcumuladoConsumoUnPago = $datosDetalle['fAcumuladoConsumoUnPago'];
		$fAcumuladoAdelanto = $datosDetalle['fAcumuladoAdelanto'];
		$fAcumuladoPrestamo = $datosDetalle['fAcumuladoAdelanto'];
		
		$fRemanenteGlobal = $datosDetalle['fRemanenteGlobal'];		
		$fRemanenteCompra = $datosDetalle['fRemanenteCompra'];
		$fRemanenteCredito = $datosDetalle['fRemanenteCredito'];
		$fRemanenteAdelanto = $datosDetalle['fRemanenteAdelanto'];
		$fRemanentePrestamo = $datosDetalle['fRemanentePrestamo'];
		
		$fLimiteGlobal = $datosDetalle['fLimiteGlobal'];
		$fLimiteCompra = $datosDetalle['fLimiteCompra'];
		$fLimiteCredito = $datosDetalle['fLimiteCredito'];
		$fLimiteAdelanto = $datosDetalle['fLimiteAdelanto'];
		$fLimitePrestamo = $datosDetalle['fLimitePrestamo'];
		
		$fRemanenteGlobal = ($fLimiteGlobal - $fSaldoAnterior - $fAcumuladoConsumoCuota - $fAcumuladoConsumoUnPago - $fAcumuladoAdelanto) + $fAcumuladoCobranza;
		$fRemanenteCompra = $fLimiteCompra - $fAcumuladoConsumoUnPago;
		$fRemanenteCredito = $fLimiteCredito - $fAcumuladoConsumoCuota;
		$fRemanenteAdelanto = $fLimiteAdelanto - $fAcumuladoAdelanto;
		$fRemanentePrestamo = $fLimitePrestamo - $fAcumuladoPrestamo;
			
		if($fRemanenteGlobal <= $fRemanenteCompra){$fRemanenteCompra = $fRemanenteGlobal;}		
		if($fRemanenteGlobal <= $fRemanenteCredito){$fRemanenteCredito = $fRemanenteGlobal;}
		if($fRemanenteGlobal <= $fRemanenteAdelanto){$fRemanenteAdelanto = $fRemanenteGlobal;}
		if($fRemanenteGlobal <= $fRemanentePrestamo){$fRemanentePrestamo = $fRemanenteGlobal;}
		if($fRemanenteGlobal <= $fRemanenteSMS){$fRemanentePrestamo = $fRemanenteSMS;} 	
		
		$set ="
	  	   		fRemanenteGlobal = '{$fRemanenteGlobal}',
	  	   		fRemanenteCompra = '{$fRemanenteCompra}',
	  	   		fRemanenteCredito = '{$fRemanenteCredito}',
	  	   		fRemanenteAdelanto = '{$fRemanenteAdelanto}',
	  	   		fRemanentePrestamo = '{$fRemanentePrestamo}'	  	   		
	  	   	  ";
	  	     	  
     	//$conditions = "Cobranzas.id = '{$idCobranza}'"; 		
		$conditions = "DetallesCuentasUsuarios.id = '{$datosDetalle['id']}'";
		   
		$ToAuditory = "Actualizacion de Remanentes ::: Empleado ={$_SESSION['id_user']}";

		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"DetallesCuentasUsuarios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"69\",\"$ToAuditory\");",true);   
		  
		return $oRespuesta;
	}
		
	function reasignarFechasDeFacturacion($dFechaCierre, $idCuentaUsuario)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();		
		
		$sCondiciones = "WHERE dFechaFacturacionUsuario  = '{$dFechaCierre}'  AND iEstadoFacturacionUsuario = 0 AND Tarjetas.idCuentaUsuario = {$idCuentaUsuario}";		
		
		$datosDetalleCupones = $oMysql->consultaSel("CALL usp_getFechasDetallesCupones(\"$sCondiciones\");");	
					
		if(!$datosDetalleCupones)
		{
			$oRespuesta->alert("No se encontraron resultados");
			return $oRespuesta;
		}
		
		$dFechaFacturacion = $dFechaCierre;
		$arrayFecha = explode("/",$dFechaFacturacion);
		$iMes = $arrayFecha[1];	
		
		$anio = $arrayFecha[0];			
		
		//$oRespuesta->alert("mes antes: " .$iMes);
		
		foreach ($datosDetalleCupones as $Detalle)//($i = 1; $i <= count($datosDetalleCupones)-1; $i++)		
		{
			$iDias = $arrayFecha[2];	
			//$mktime = mktime(0,0,0,intval($mes),1,intval($anio));
			
			//$oRespuesta->alert("mes: " .$iMes);									
			
			if($iDias ==31)
			{
				$iDias = 30;
			}	
					
			if($iMes == 12)
			{
				$iMes = 1;
				$anio +=1; 
			}
			else  
			{
				$iMes += 1;				
			}		
			
			if($iMes == 2 && $iDias >=29)
			{
				//$oRespuesta->alert("entro. ". $iMes);
				$iDias = 25;
			}
			
			$fecha_nueva = mktime(0,0,0,$iMes,$iDias,intval($anio));
			
			$dFechaFacturacionNueva = date("d/m/Y", $fecha_nueva);
       		
        	#Actualizar en la tabla DetallesCupones la fecha de facturacion			
			
			$dFechaFacturacionNueva = dateToMySql($dFechaFacturacionNueva);
			
			$id = $Detalle["id"]; 
			//$oRespuesta->alert($Detalle["id"]);
			
			$set = "dFechaFacturacionUsuario = '{$dFechaFacturacionNueva}'";
	    	$conditions = "DetallesCupones.id = '{$id}'";
			$ToAuditory = "Update Estado Cobranza ::: Empleado ={$_SESSION['id_user']} ::: idCobranza={$idFacturacionCargos} ::: estado={$sEstado}";
		
			$id = $oMysql->consultaSel("CALL usp_UpdateValues(\"DetalleCupones\",\"$set\",\"$conditions\");",true);   
			
			if($id != 1)
			{
				$oRespuesta->alert("No se pudo reasignar la fecha de facturacion");
			}
			
			$oRespuesta->alert("CALL usp_UpdateValues(\"DetallesCupones\",\"$set\",\"$conditions\");");
		}
		
		return $oRespuesta;
	}
		
	function setEstadoCuentaUsuarioByCobranza($idCuentaUsuario)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$estado_NORMAL = 1;
		$estado_MOROSO_1_MES = 3;
		$estado_MOROSO_2_MESES = 4;
		$estado_MOROSO_3_MESES = 5;
		$estado_INHABILITADA = 10;
		$estado_INHABILITADA_CON_COBRANZAS = 13;
		$estado_PREVISIONADA = 11;
		$estado_PREVISIONADA_CON_COBRANZAS = 14;
		$estado_PRELEGALES = 15;
		$estado_GESTION_JUDICIAL = 16;
		
		$bModificarEstado = false;		
		$idTipoEstadoCuenta = 0;
		$idNuevoEstadoCuenta = 0;
		$iDiasMoraNuevo = 0;
		$bEstadoModificado = false;
		
		
		//-------------- Obtener cuenta usuario -------------------------------------
		$sCondicionCuentaUsuario = "WHERE CuentasUsuarios.id = {$idCuentaUsuario};";		
		$CuentaUsuario = $oMysql->consultaSel("CALL usp_getCuentasUsuarios(\"$sCondicionCuentaUsuario\");",true);			
		
		
		if($CuentaUsuario['idTipoEstadoCuenta'] == $estado_INHABILITADA || $CuentaUsuario['idTipoEstadoCuenta'] == $estado_PRELEGALES || $CuentaUsuario['idTipoEstadoCuenta'] == $estado_GESTION_JUDICIAL)
		{
			//$oRespuesta->alert("entro");
			//var_export("entro");
			return $oRespuesta;
		}
		
		
		//--------------- Obtener detalle cuenta usuario ----------------------------
		$sCondiciones = "WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$idCuentaUsuario}	ORDER BY DetallesCuentasUsuarios.id DESC LIMIT 0,2 ;";		
		$datosDetalle = $oMysql->consultaSel("CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");");
		
		//$oRespuesta->alert("CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");");
		
		if(!$datosDetalle)
		{
			$oRespuesta->alert("No se encontro ningun detalle para esta Cuenta de Usuario");
			return $oRespuesta;			
		}
		
		
		if($CuentaUsuario)	
		{			
			//$diferencia = $datosDetalle[0]["fSaldoAnterior"] - $datosDetalle[0]['fAcumuladoCobranza'];
			//$idTipoEstadoCuenta = $CuentaUsuario['idTipoEstadoCuenta'];
			
			$PorcentajePagado = ($datosDetalle[0]['fAcumuladoCobranza'] * 100) / $datosDetalle[0]["fSaldoAnterior"];
				
			//CONSIDERAR DESPUES DE HACER LA COBRANZA SI EL % DE ACUMULADO DE COBRANZAS 
			//SE ENCUENTRA ENTRE EL 50% Y EL 80%, VOLVER AL ESTADO ANTERIOR
			//SI PAGO MAS DEL 80% VOLVER A NORMAL
			//EN CASO DE ESTAR EN ESTADO: INHABILITADO, PRELEGALES O GESTION JUDICIAL NOOO REALIZAR ESTA VALIDACION			
			
			$idEstadoCuentaActual = $CuentaUsuario['idTipoEstadoCuenta'];
			$idNuevoEstadoCuenta = 0;
			
			if($PorcentajePagado >= 50 && $PorcentajePagado <= 80 && $idEstadoCuentaActual != $estado_MOROSO_1_MES)
			{
				//VOLVER LA CUENTA AL ESTADO ANTERIOR
				//$idNuevoEstadoCuenta = 3; //MOROSO 1 MES
				
				$dFechaVencimiento = dateToMySql($datosDetalle[0]['dFechaVencimiento']);									
				$dFechaVencimientoActual =  $oMysql->consultaSel("SELECT fnc_getFechaVencimientoAnterior(\"{$dFechaVencimiento}\",\"{$datosDetalle[0]['idCuentaUsuario']}\",\"{$CuentaUsuario['idGrupoAfinidad']}\");",true);
									
				$dFechaMoraActual = dateToMySql($datosDetalle[0]['dFechaMora']);									
				$dFechaCorridaMoraActual =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraActual}\",\"{$datosDetalle[0]['idCuentaUsuario']}\",\"{$CuentaUsuario['idGrupoAfinidad']}\");",true);
				
				$dFechaMoraAnterior = dateToMySql($datosDetalle[1]['dFechaMora']);									
				$dFechaCorridaMoraAnterior =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraAnterior}\",\"{$datosDetalle[1]['idCuentaUsuario']}\",\"{$CuentaUsuario['idGrupoAfinidad']}\");",true);
												
				
				if($idEstadoCuentaActual == $estado_MOROSO_1_MES)
				{
					$idNuevoEstadoCuenta = $estado_NORMAL; 
					$iDiasMoraNuevo = 0;	
					$bModificarEstado = true;
				}
				elseif ($idEstadoCuentaActual == $estado_MOROSO_2_MESES)
				{
					$idNuevoEstadoCuenta = $estado_MOROSO_1_MES;
					$iDiasMoraNuevo = 1;//$datosDetalle[0]['iDiasMora'] - getDias($dFechaCorridaMoraActual, $dFechaCorridaMoraAnterior);	
					$bModificarEstado = true;
				} 
				elseif($idEstadoCuentaActual == $estado_MOROSO_3_MESES)
				{
					$idNuevoEstadoCuenta = $estado_MOROSO_2_MESES;
					$iDiasMoraNuevo = 31;//$datosDetalle[0]['iDiasMora'] - getDias($dFechaCorridaMoraActual, $dFechaCorridaMoraAnterior);	
					$bModificarEstado = true;
				}		
			}
			else if($PorcentajePagado >= 80) //Si el porcentaje que pago supera el 80% de la deuda se cambia el estado a NORMAL Independientemente del estado anterior en el que se encontraba
			{
				$idNuevoEstadoCuenta = $estado_NORMAL; 
				$iDiasMoraNuevo = 0;	
				$bModificarEstado = true;
			}
			
		}
		
					
		if($bModificarEstado)
		{
				//$oRespuesta->alert("entro a modificar cuenta de usuario");
				//var_export("entro a modificar cuenta de usuario");
				
			#--------------------- Actualizar los dias de mora y estado del usuario ----------------------------
				$set = "iDiasMora = '{$iDiasMoraNuevo}', idTipoEstadoCuenta = '{$idNuevoEstadoCuenta}'";
			    $conditions = "DetallesCuentasUsuarios.id = '{$datosDetalle[0]['id']}'";
			    	
				$ToAuditory = "Actualizacion Cuenta Usuario ::: Empleado ={$_SESSION['id_user']} - Dias de Mora: {$iDiasMoraNuevo} - Estado: {$idNuevoEstadoCuenta}";
				   
				$id = $oMysql->consultaSel("CALL usp_updateEstadoCuentaUsuario(\"$iDiasMoraNuevo\",\"$idNuevoEstadoCuenta\",\"$idCuentaUsuario\",\"{$datosDetalle[0]['id']}\",\"{$_SESSION['id_user']}\");",true);			
								 				
				#-------------------- Insertar en la tabla Morosidad ------------------------------- 
				$dFechaRegistro = date("Y-m-d h:i:s"); 
				
				 $set ="
			  	   		idCuentaUsuario,
			  	   		iDiasMoraActual,
			  	   		iDiasMoraNueva,
			  	   		fImportePagoMinimo,
			  	   		fImporteTotalResumenUsuario,
			  	   		fImporteTotalCobranzasUsuario,
			  	   		dFechaRegistro,
			  	   		idEmpleado,
			  	   		idEstadoCuentaActual,
			  	   		idEstadoCuentaNuevo";
			  	     	   		
				   $values = "
				   		'{$idCuentaUsuario}',
				   		'{$datosDetalle[0]['iDiasMora']}',
				   		'{$iDiasMoraNuevo}',
				   		'0',
				   		'{$datosDetalle[0]['fImporteTotalPesos']}',
					   	'{$datosDetalle[0]['fAcumuladoCobranza']}',
				   		'{$dFechaRegistro}',
				   		'{$_SESSION['id_user']}',
				   		'{$idEstadoCuentaActual}',
				   		'{$idNuevoEstadoCuenta}'		   		
				   	";
				   	 
				   
			   		$ToAuditory = "Insercion de Morosidad ::: Empleado ={$_SESSION['id_user']}";
			   
			   		$id = $oMysql->consultaSel("CALL usp_InsertTable(\"Morosidad\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"70\",\"$ToAuditory\");",true);   	
		}
		
		return $oRespuesta;
	}
		
	function setEstadoCuentaUsuarioByCobranzaEliminada($idCuentaUsuario)
	{
		GLOBAL $oMysql;	
		
		$estado_NORMAL = 1;
		$estado_MOROSO_1_MES = 3;
		$estado_MOROSO_2_MESES = 4;
		$estado_MOROSO_3_MESES = 5;
		$estado_INHABILITADA = 10;
		$estado_INHABILITADA_CON_COBRANZAS = 13;
		$estado_PREVISIONADA = 11;
		$estado_PREVISIONADA_CON_COBRANZAS = 14;
		$estado_PRELEGALES = 15;
		$estado_GESTION_JUDICIAL = 16;
		
		$bModificarEstado = false;		
		$idTipoEstadoCuenta = 0;
		$idNuevoEstadoCuenta = 0;
		$iDiasMoraNuevo = 0;
		$bEstadoModificado = false;
		
		
		//-------------- Obtener cuenta usuario -------------------------------------
		$sCondicionCuentaUsuario = "WHERE CuentasUsuarios.id = {$idCuentaUsuario};";		
		$CuentaUsuario = $oMysql->consultaSel("CALL usp_getCuentasUsuarios(\"$sCondicionCuentaUsuario\");",true);			
		
		//--------------- Obtener detalle cuenta usuario ----------------------------
		$sCondiciones = "WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$idCuentaUsuario}	ORDER BY DetallesCuentasUsuarios.id DESC LIMIT 0,2 ;";		
		$datosDetalle = $oMysql->consultaSel("CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");");
		
		//$oRespuesta->alert("CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");");
		
		if(!$datosDetalle)
		{
			$mensaje = "No se encontro ningun detalle para esta Cuenta de Usuario";
			return 0;
		}
		
		
		if($CuentaUsuario)	
		{						
			$PorcentajePagado = ($datosDetalle[0]['fAcumuladoCobranza'] * 100) / $datosDetalle[0]["fSaldoAnterior"];
				
			//CONSIDERAR DESPUES DE HACER LA COBRANZA SI EL % DE ACUMULADO DE COBRANZAS 
			//SE ENCUENTRA ENTRE EL 50% Y EL 80%, VOLVER AL ESTADO ANTERIOR
			//SI PAGO MAS DEL 80% VOLVER A NORMAL
			//EN CASO DE ESTAR EN ESTADO: INHABILITADO, PRELEGALES O GESTION JUDICIAL NOOO REALIZAR ESTA VALIDACION			
			
			$idEstadoCuentaActual = $CuentaUsuario['idTipoEstadoCuenta'];
			$idNuevoEstadoCuenta = 0;
			
			
			if($PorcentajePagado < 50)
			{
				//VOLVER LA CUENTA AL ESTADO ANTERIOR
				//$idNuevoEstadoCuenta = 3; //MOROSO 1 MES
				
				$dFechaVencimiento = dateToMySql($datosDetalle[0]['dFechaVencimiento']);									
				$dFechaVencimientoActual =  $oMysql->consultaSel("SELECT fnc_getFechaVencimientoAnterior(\"{$dFechaVencimiento}\",\"{$datosDetalle[0]['idCuentaUsuario']}\",\"{$CuentaUsuario['idGrupoAfinidad']}\");",true);
									
				$dFechaMoraActual = dateToMySql($datosDetalle[0]['dFechaMora']);									
				$dFechaCorridaMoraActual =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraActual}\",\"{$datosDetalle[0]['idCuentaUsuario']}\",\"{$CuentaUsuario['idGrupoAfinidad']}\");",true);
				
				$dFechaMoraAnterior = dateToMySql($datosDetalle[1]['dFechaMora']);									
				$dFechaCorridaMoraAnterior =  $oMysql->consultaSel("SELECT fnc_getFechaMoraAnterior(\"{$dFechaMoraAnterior}\",\"{$datosDetalle[1]['idCuentaUsuario']}\",\"{$CuentaUsuario['idGrupoAfinidad']}\");",true);
												
				if($idEstadoCuentaActual == $estado_NORMAL && count($datosDetalle) > 1)
				{
					$idNuevoEstadoCuenta = $estado_MOROSO_1_MES; 
					$iDiasMoraNuevo = 1;	
					$bModificarEstado = true;
				}
				else if($idEstadoCuentaActual == $estado_MOROSO_1_MES)
				{
					$idNuevoEstadoCuenta = $estado_MOROSO_2_MESES; 
					$iDiasMoraNuevo = $datosDetalle[0]['iDiasMora'] + getDias($dFechaCorridaMoraActual, $dFechaCorridaMoraAnterior);	
					$bModificarEstado = true;
				}
				elseif ($idEstadoCuentaActual == $estado_MOROSO_2_MESES)
				{
					$idNuevoEstadoCuenta = $estado_MOROSO_3_MESES;
					$iDiasMoraNuevo = $datosDetalle[0]['iDiasMora'] + getDias($dFechaCorridaMoraActual, $dFechaCorridaMoraAnterior);	
					$bModificarEstado = true;
				} 
				elseif($idEstadoCuentaActual == $estado_MOROSO_3_MESES)
				{
					$idNuevoEstadoCuenta = $estado_INHABILITADA;
					$iDiasMoraNuevo = $datosDetalle[0]['iDiasMora'] + getDias($dFechaCorridaMoraActual, $dFechaCorridaMoraAnterior);	
					$bModificarEstado = true;
				}		
			}
			else if($PorcentajePagado >= 80) //Si el porcentaje que pago supera el 80% de la deuda se cambia el estado a NORMAL Independientemente del estado anterior en el que se encontraba
			{
				$idNuevoEstadoCuenta = $estado_NORMAL; 
				$iDiasMoraNuevo = 0;	
				$bModificarEstado = true;
			}
		}
		
					
		if($bModificarEstado)
		{
				//$oRespuesta->alert("entro a modificar cuenta de usuario");
				//var_export("entro a modificar cuenta de usuario");
				
			#--------------------- Actualizar los dias de mora y estado del usuario ----------------------------
				$set = "iDiasMora = '{$iDiasMoraNuevo}', idTipoEstadoCuenta = '{$idNuevoEstadoCuenta}'";
			    $conditions = "DetallesCuentasUsuarios.id = '{$datosDetalle[0]['id']}'";
			    	
				$ToAuditory = "Actualizacion Cuenta Usuario ::: Empleado ={$_SESSION['id_user']} - Dias de Mora: {$iDiasMoraNuevo} - Estado: {$idNuevoEstadoCuenta}";
				   
				$id = $oMysql->consultaSel("CALL usp_updateEstadoCuentaUsuario(\"$iDiasMoraNuevo\",\"$idNuevoEstadoCuenta\",\"$idCuentaUsuario\",\"{$datosDetalle[0]['id']}\",\"{$_SESSION['id_user']}\");",true);			
								 				
				#-------------------- Insertar en la tabla Morosidad ------------------------------- 
				$dFechaRegistro = date("Y-m-d h:i:s"); 
				
				 $set ="
			  	   		idCuentaUsuario,
			  	   		iDiasMoraActual,
			  	   		iDiasMoraNueva,
			  	   		fImportePagoMinimo,
			  	   		fImporteTotalResumenUsuario,
			  	   		fImporteTotalCobranzasUsuario,
			  	   		dFechaRegistro,
			  	   		idEmpleado,
			  	   		idEstadoCuentaActual,
			  	   		idEstadoCuentaNuevo";
			  	     	   		
				   $values = "
				   		'{$idCuentaUsuario}',
				   		'{$datosDetalle[0]['iDiasMora']}',
				   		'{$iDiasMoraNuevo}',
				   		'0',
				   		'{$datosDetalle[0]['fImporteTotalPesos']}',
					   	'{$datosDetalle[0]['fAcumuladoCobranza']}',
				   		'{$dFechaRegistro}',
				   		'{$_SESSION['id_user']}',
				   		'{$idEstadoCuentaActual}',
				   		'{$idNuevoEstadoCuenta}'		   		
				   	";
				   	 
				   
			   		$ToAuditory = "Insercion de Morosidad ::: Empleado ={$_SESSION['id_user']}";
			   
			   		$id = $oMysql->consultaSel("CALL usp_InsertTable(\"Morosidad\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"70\",\"$ToAuditory\");",true);   	
		}
		
		return 1;
	}
	
	function reactivarCobranza($idCobranza){
		GLOBAL $oMysql;		
	    $oRespuesta = new xajaxResponse();  
	    
	    $sCondicionesFacturado = "WHERE Cobranzas.id = '{$idCobranza}'";
    	$oFacturado=$oMysql->consultaSel("CALL usp_getCobranzas(\"$sCondicionesFacturado\");",true);
    	$idCuentaUsuario = $oFacturado["idCuentaUsuario"];
    	
    	if($oFacturado['sEstado'] == 'B'){
    		$fImporte = $oFacturado["fImporte"];
    		
    		//Actualiza el Estado de la Cobranza
		    $set = "sEstado = 'A'";
		    $conditions = "Cobranzas.id = '{$idCobranza}'";
			$ToAuditory = "Update Estado de Cobranza ::: Empleado ={$_SESSION['id_user']} ::: idCobranza={$idCobranza} ::: estado='A'";
			
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Cobranzas\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"68\",\"$ToAuditory\");",true); 
			
			//Actualiza Acumulado en Detalle de Cuenta
			$oMysql->consultaSel("CALL usp_updateCobranzaCuentaUsuario(\"{$idCuentaUsuario}\",\"{$fImporte}\");",true);
    	}
    	
	    $oRespuesta->alert("La operacion se realizo correctamente");
		$oRespuesta->redirect("Cobranzas.php");
	    return $oRespuesta;
	}
	
	function updateEstadoCobranza($idCobranza, $sEstado)
	{
	    GLOBAL $oMysql;
	    $oRespuesta = new xajaxResponse();   
	     
	    $sCondicionesFacturado = "WHERE Cobranzas.id = '{$idCobranza}'";
	    $oFacturado=$oMysql->consultaSel("CALL usp_getCobranzas(\"$sCondicionesFacturado\");",true);
	    
	    $fImporte = $oFacturado["fImporte"];
	    $idCuentaUsuario = $oFacturado["idCuentaUsuario"];
	    
	    if($sEstado == 'B'){
	    	$fImporte = -$oFacturado["fImporte"];
	    	if($oFacturado["iEstadoFacturacionUsuario"] == 1)
	    	{
	    		$oRespuesta->alert("No se puede anular una Cobranza que se encuentra facturada");
	    		return $oRespuesta;	
	    	}
	    }
	      
	    $set = "sEstado = '{$sEstado}'";
	    $conditions = "Cobranzas.id = '{$idCobranza}'";
		$ToAuditory = "Update Estado Cobranza ::: Empleado ={$_SESSION['id_user']} ::: idCobranza={$idFacturacionCargos} ::: estado={$sEstado}";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Cobranzas\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"68\",\"$ToAuditory\");",true);   
		
		//$oRespuesta->alert($idCuentaUsuario ."  ".$fImporte);
		
		$oMysql->consultaSel("CALL usp_updateCobranzaCuentaUsuario(\"{$idCuentaUsuario}\",\"{$fImporte}\");",true);
		
		$oRespuesta->alert("La operacion se realizo correctamente");
		$oRespuesta->redirect("Cobranzas.php");
		return $oRespuesta;
	}
		
	function habilitarCobranzas($form)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
			 
		$aCobranzas = $form['aCobranzas'];
		$aCuentaHabilitadas = array();
		
		foreach ($aCobranzas as $idCobranza){
			$sCondicionesFacturado = "WHERE Cobranzas.id = '{$idCobranza}'";
	    	$oFacturado=$oMysql->consultaSel("CALL usp_getCobranzas(\"$sCondicionesFacturado\");",true);
	    	$idCuentaUsuario = $oFacturado["idCuentaUsuario"];
	    	
	    	if($oFacturado['sEstado'] == 'B'){
	    		$fImporte = $oFacturado["fImporte"];
	    		
	    		
			    $set = "sEstado = 'A'";
			    $conditions = "Cobranzas.id = '{$idCobranza}'";
				$ToAuditory = "Update Estado de Cobranza ::: Empleado ={$_SESSION['id_user']} ::: idCobranza={$idCobranza} ::: estado='A'";
				
				$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Cobranzas\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"68\",\"$ToAuditory\");",true); 
				
				$oMysql->consultaSel("CALL usp_updateCobranzaCuentaUsuario(\"{$idCuentaUsuario}\",\"{$fImporte}\");",true);
	    	}else{
	    		$aCuentaHabilitadas[]= $idCuentaUsuario;
	    	}
		}
		if(count($aCuentaHabilitadas)>0){
			$sCuentaHabilitadas = implode(",",$aCuentaHabilitadas);
			$oRespuesta->alert("Las siguientes Cobranzas se encuentran habilitadas: ".$sCuentaHabilitadas);
		}
	    $oRespuesta->alert("La operacion se realizo correctamente");
		
	    $oRespuesta->redirect("Cobranzas.php");
	    
		return  $oRespuesta;
	}
	
	function buscarDatosUsuarioAU($datos){
		global $oMysql;	
		$oRespuesta = new xajaxResponse();		

		$conditions = array();	
		
		//$conditions[] = "( Tarjetas.idTipoEstadoTarjeta = 8 OR Tarjetas.idTipoEstadoTarjeta = 1 OR Tarjetas.idTipoEstadoTarjeta = 5 )";

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
		
		//$oRespuesta->alert("CALL usp_getTarjetas(\"$sub_query\");");
		
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
				
				$limiteCredito = $oMysql->consultaSel("SELECT fcn_getLimiteCreditoUsuario(\"{$user['id']}\");", true);
				
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
							<td width='30'><input type='radio' name='user[]' id='user_{$usuario['id']}' onclick=\"parent.setDatosCuentaUsuario('"._encode($user['idCuentaUsuario'])."','{$user['sApellido']}, {$user['sNombre']}','{$user['sNumeroTarjeta']}','$cartel_tipo_tarjeta','{$user['iVersion']}','{$user['sNumeroCuenta']}','$limiteCredito','"._encode($user['id'])."');\"></td>
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
	
	function buscarDatosUsuarioPorCuentaAU($sNroCuenta){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		//$oRespuesta->alert("$sNroCuenta");
		$bObtenerDetalleCuenta = false;
		
		$sCondiciones = "WHERE CuentasUsuarios.sNumeroCuenta = '" . trim($sNroCuenta) . "'";
		
		$sqlDatos = "Call usp_getTarjetas (\"$sCondiciones\");";

		$result = $oMysql->consultaSel($sqlDatos,true);
		
		$sUsuario = "NO EXISTE CUENTA";       
		$apellidoUsuario 	= "";
		$nombreUsuarios 	= "";
		$idCuentaUsuario 	= 0;
		$numeroTarjeta 		= "";
		$versionTarjeta 	= "";
		$numeroCuenta 		= "";
		$idUsuario 			= "";
		$limiteCredito 		= 0;
		if(!$result){			
			
			$string = "<span style='color:#F00;font-size:11px;'>- ingrese numero de cuenta de usuario o identifiquelo desde busqueda avanzada</span>";
			$oRespuesta->assign("datos_cuenta", "innerHTML", $string);                         
			
		}else{
			
			$sUsuario = $result["sApellido"] .", ". $result["sNombre"];
			
			$apellidoUsuario 	= $result["sApellido"];
			$nombreUsuarios 	= $result["sNombre"];
			$idCuentaUsuario 	= $result["idCuentaUsuario"];
			$numeroTarjeta 		= $result["sNumeroTarjeta"];
			$versionTarjeta 	= $result["iVersion"];
			$numeroCuenta 		= $result['sNumeroCuenta'];
			$idUsuario 			= $result['id'];
			$fechaCierre 		= "-";
			$saldoAnterior 		= "-";
					
			switch ($result['idTipoTarjeta'])
			{
				case 1:
					$cartel_tipo_tarjeta = "TITULAR";
					break;
				case 2:
					$cartel_tipo_tarjeta = "ADICIONAL";
					break;
				default:
					break;
			}
			
		
			$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left;\'>Usuario: </label><label>' . $sUsuario. '</label></div>';
			$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tarjeta: </label><label>' . $result["sNumeroTarjeta"] . '</label></div>';
			$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tipo Tarjeta: </label><label>' .$cartel_tipo_tarjeta . '</label></div>';
			$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>version: </label><label>' .  $result["iVersion"] . '</label></div>';
						
			if($bObtenerDetalleCuenta)
			{
				$sCondiciones = " where idCuentaUsuario = {$idCuentaUsuario} and iEmiteResumen = 1 order by DetallesCuentasUsuarios.id DESC LIMIT 0,1 ";
				$sqlDatos = "CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");";	
				$result = $oMysql->consultaSel($sqlDatos,true);
		
				if(!$result)
				{
					/*$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'></label><label>______________</label></div>';
					$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Ultimo Resumen: </label><label>' .  $result["dFechaCierre"] . '</label></div>';
					$sString .= '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Importe: </label><label>' .  $result["fSaldoAnterior"] . '</label></div>';*/

				}else{
					$fechaCierre = $result["dFechaCierre"];
					$saldoAnterior = $result["fSaldoAnterior"];					
				}
				
				//$oRespuesta->assign("dFechaUltimoResumen", "innerHTML", $dFechaResumen);
				//$oRespuesta->assign("fImporteTotal", "innerHTML", $fSaldoAnterior);                            
			}
			
			$script = "setDatosCuentaUsuario2(
			'"._encode($idCuentaUsuario)."',
			'{$apellidoUsuario}, {$nombreUsuarios}',
			'{$numeroTarjeta}',
			'$cartel_tipo_tarjeta',
			'{$versionTarjeta}',
			'{$numeroCuenta}',
			'$limiteCredito',
			'"._encode($user['id'])."',
			'".$fechaCierre."',
			'".$saldoAnterior."'
			);";
			$oRespuesta->script("$script");
			
			//$oRespuesta->assign("idCuentaUsuario", "value", _encode($idCuentaUsuario));
			//$oRespuesta->assign("datos_cuenta", "innerHTML", $sString);   			
			
			
		}
		
		return $oRespuesta; 

	}	
		
	function getDatosAjustes($idAjuste)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$sCondiciones = "WHERE TiposAjustes.id = ". $idAjuste; 
		
		$sqlDatos="Call usp_getTiposAjustes(\"$sCondiciones\");";
		
		$result = $oMysql->consultaSel($sqlDatos,true);
		
		$fInteresAjuste = 0;
		
		if($result)
		{
			$fInteresAjuste = $result["fTasaInteresAjuste"];
			$sClaseAjuste = $result["sClaseAjuste"];
			$bDiscriminaIVA = $result["bDiscriminaIVA"];
			
			//$oRespuesta->alert($bDiscriminaIVA);
			
			$oRespuesta->assign("fInteres", "value", $fInteresAjuste);
			$oRespuesta->assign("lblInteres", "innerHTML", $fInteresAjuste);
			$oRespuesta->assign("sClaseAjuste", "value", $sClaseAjuste);
			$oRespuesta->assign("bDiscriminaIVA", "value", $bDiscriminaIVA);
		
			//$oRespuesta->alert("xajax_getDatosAjuste")
		}
		
		return $oRespuesta;
	}	
	
	function getImporteRetencion($fImporteBruto, $fImporteBrutoDetalle, $fImporteRetencion)
	{
		$fPorcentajeRetencionDetalle = ($fImporteBrutoDetalle * 100) / $fImporteBruto;
		$fImporteRetencionDetalle = $fPorcentajeRetencionDetalle * $fImporteRetencion;
		
		return  $fImporteRetencionDetalle;
	}
	
	
	//************************* AJUSTES USUARIOS *********************************************
	
	function getTasaIVA($idTasaIVA)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
			
		$sConsulta = "SELECT fTasa FROM TasasIVA WHERE id = ". $idTasaIVA; 
		
				
		$fTasaIVA = $oMysql->consultaSel($sConsulta, true);
		
		$oRespuesta->assign("fTasaIVA", "value", $fTasaIVA);
		
		return $oRespuesta;
	}
	
	
	function updateDatosAjustesUsuarios($form)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
			
		$iCantidadCuotas = $form["iCantidadCuotas"];
		
		//$oRespuesta->alert("CantidadCuotas " . $iCantidadCuotas); return $oRespuesta;
		
		$dFecha =  date("Y-m-d h:i:s");
		$dFechaProceso = dateToMySql($form["dFechaProceso"]);
		$idAjusteUsuario = 0;	
		
		$form['idCuentaUsuario'] = _decode($form['idCuentaUsuario']);
		
		$sCodigo=$oMysql->consultaSel("select fn_getCodigoAjusteUsuario();",true);
		
		if($form['idEmpleado'])
			$idEmpleado = $form['idEmpleado']; 
		else 
			$idEmpleado = $_SESSION['id_user'];
		
	  	if($form['idAjusteUsuario'] == 0)
	    {       
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
		   		'{$form['idCuentaUsuario']}',
		   		'{$form['idTipoAjuste']}',		   	
		   		'{$idEmpleado}',
		   		'{$form['idTipoMoneda']}',
		   		'{$dFecha}',
		   		'{$sCodigo}',
		   		'{$form['iCuotas']}',
		   		'{$form['fImporteTotal']}',
		   		'{$form['fImporteTotalInteres']}',
		   		'{$form['fImporteTotalIVA']}',
		   		'A',
		   		'0',
		   		'{$form['idTasaIVA']}',
		   		'{$form['fImporteTotalFinal']}'
		   		";
		   	 
		   
		   $fimporteConInteres = $form['fImporteTotalInteres'] + $form['fImporteTotal'];		 
		   	   
		   $ToAuditory = "Insercion Ajuste de Usuario ::: Empleado ={$_SESSION['id_user']}, Solicita IdEmpleado={$idEmpleado}";
		   
		   $idAjusteUsuario = $oMysql->consultaSel("CALL usp_InsertTable(\"AjustesUsuarios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"59\",\"$ToAuditory\");",true);     
		   
		   #Afectar Debito Credito en cuenta de usuario segun corresponda
		   $oMysql->consultaSel("CALL usp_updateDebitoCredito(\"{$form['idCuentaUsuario']}\",\"{$form['sClaseAjuste']}\",\"{$fimporteConInteres}\",\"{$form['fImporteTotalIVA']}\");", true);
			//$oRespuesta->alert("CALL usp_updateDebitoCredito(\"{$form['idCuentaUsuario']}\",\"{$form['sClaseAjuste']}\",\"{$form['fImporteTotal']}\",\"{$form['fImporteTotalIVA']}\");");
	    }
	  	    
	     //----------- Insertar el detalle (cuotas) ----------------------------	    

		  $set = "
		   			(
		   				idEmpleado,
		   				idAjusteUsuario,
		   				iNumeroCuota,
		   				fImporteCuota,
		   				fImporteInteres,
		   				fImporteIVA,
		   				dFechaFacturacionUsuario		
		   			)";
		   		        
		   $fImporteCuota = $form['fImporteTotal'] / $form['iCuotas'];
		   $fImporteInteres = $form['fImporteTotalInteres'] / $form['iCuotas'];
		   $fImporteIVA = $form['fImporteTotalIVA'] / $form['iCuotas'];
		   
		   #obtengo la fecha base (periodo) apartir de la cual generare las fechas de facturacion
	  	   $fecha_base = $oMysql->consultaSel("SELECT fcn_getUltimoPeriodoDetalleCuentaUsuario(\"{$form['idCuentaUsuario']}\");",true);		  
	  	   
	  	   //$oRespuesta->alert($fecha_base);
	  	   
	  	   $array_fecha_base = explode("-",$fecha_base);	  	
	  	   $ultima_fecha_cierre = "";
	  	   
	  	   for($i=1; $i<= $form['iCuotas']; $i++ )
		   {
		   		 #obtengo mees y anio para buscar fecha de cierre asociado a cuenta de usuario
				
		   		 //Si iCantidad de cuotas viene vacio -> le pongo 2 ccotas por defecto 
		   		/*if(!$iCantidadCuotas) 
		   		{
		   			$iCantidadCuotas = 2;	
		   		} */
		   		if(!$iCantidadCuotas) 
		   		{
		   			$iCantidadCuotas = 1;	
		   		}		   		 
		   		 
		   		 if($i <= $iCantidadCuotas)
		   		 {
		   		 	$mes = $array_fecha_base[1];
		   		 }
		   		 else 
		   		 {
		   		 	$mes = $array_fecha_base[1] + ($i - ($iCantidadCuotas));	
		   		 }
		   		 
			
				//$oRespuesta->alert("mes:" . $mes);	
				
				$anyo = $array_fecha_base[0];
			
				$mktime = mktime(0,0,0,intval($mes),1,intval($anyo));
			
				$anyo_real = intval(date("Y",$mktime));
			
				$mes_real = intval(date("m",$mktime));
				
				if($i==1)
					$mesCuota1 = $mes_real;
				
				if($i <= $iCantidadCuotas)
				{
					$mes_real = $mesCuota1;
				}
				
				#determino periodo de cuota				
								
				$fecha_cierre_usuario = $oMysql->consultaSel("SELECT fcn_getFechaCierreUsuario(\"$mes_real\",\"$anyo_real\",\"{$form['idCuentaUsuario']}\");",true);
				
				//$oRespuesta->alert("SELECT fcn_getFechaCierreUsuario(\"$mes_real\",\"$anyo_real\",\"{$form['idCuentaUsuario']}\");");
				//$oRespuesta->alert("fecha cierre: " . $fecha_cierre_usuario);
				

				if($fecha_cierre_usuario == '0000-00-00' || $fecha_cierre_usuario == false || $fecha_cierre_usuario == '1899-12-29')
				{
					// No existe fechaCierre
					$array_uFechaCierre = explode("-",$ultima_fecha_cierre);
				
					$ultimo_dia_mes_real = intval(strftime("%d", mktime(0, 0, 0, $mes_real+1, 0, $anyo_real)));
					
					$array_uFechaCierre[2] = intval($array_uFechaCierre[2]);
					
					if($ultimo_dia_mes_real < $array_uFechaCierre[2])
					{
						$dia_real = $ultimo_dia_mes_real;
					}
					else
					{
						$dia_real = $array_uFechaCierre[2];
					}
					
					$fecha_cierre_usuario = $anyo_real . "-" . $mes_real . "-" . $dia_real;
					
					if($i <= $iCantidadCuotas)
					{
						$fecha_cierre_cuota_1 = $fecha_cierre_usuario;
					}
					else
					{
								
							//if($i > $iCantidadCuotas)
							//{
								$aDateCloseFechaHora = explode(" ",$fecha_cierre_usuario);
								$aDateClose = explode("-",$aDateCloseFechaHora[0]);
	
								$xd = intval($aDateClose[2]);
								$xm = intval($aDateClose[1]);
								//$xm = $xm - 1;
								$xy = intval($aDateClose[0]);
	
								$xmktime = mktime(0,0,0,$xm,$xd,$xy);
	
								$xdate = date("Y-m-d",$xmktime);
							
								$fecha_cierre_usuario = $xdate;
							
							//}
					}
					
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
		   		
		   			if($i < $form['iCuotas'])
		   			{
						$valuesCuotas .= ",";	   			
		   			}				   		 
					
				}
				else // Existe fechaCierre
				{						
					$ultima_fecha_cierre = $fecha_cierre_usuario;
					//$oRespuesta->alert("FechaCierreUsuarios: $fecha_cierre_usuario");

					/*if($i==1)
					{
						$fecha_cierre_cuota_1 = $fecha_cierre_usuario;	
					}					
					
					if($i <= $iCantidadCuotas)
					{						
						$fecha_cierre_usuario = $fecha_cierre_cuota_1;
						$oRespuesta->alert("$i <= $iCantidadCuotas ------ $fecha_cierre_cuota_1");
					}
					else 
					{*/
						$aDateCloseFechaHora = explode(" ",$fecha_cierre_usuario);
						$aDateClose = explode("-",$aDateCloseFechaHora[0]);
						
						$xm = intval($aDateClose[1]);
						//$xm = $xm - 1;
						
						$fecha_cierre_usuario = $oMysql->consultaSel("SELECT fcn_getFechaCierreUsuario(\"$xm\",\"$anyo_real\",\"{$form['idCuentaUsuario']}\");",true);
					//}
					
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
		   		
		   			if($i < $form['iCuotas'])
		   			{
						$valuesCuotas .= ",";	   			
		   			}				   		 
		   		}
		   }
	    	
		   $ToAuditory = "Insercion Detalle de Ajuste de Usuario ::: Empleado ={$_SESSION['id_user']}"; 
	       $id = $oMysql->consultaSel("CALL usp_abm_General(\"DetallesAjustesUsuarios\",\"$set\",\"$valuesCuotas\",\"1\",\"{$_SESSION['id_user']}\",\"61\",\"$ToAuditory\");",true);   
	       //$oRespuesta->alert("CALL usp_abm_General(\"DetallesAjustesUsuarios\",\"$set\",\"$valuesCuotas\",\"1\",\"{$_SESSION['id_user']}\",\"61\",\"$ToAuditory\");");

	    	//--------------------	- fin insertar detalle ----------------------------------------------------		 

	    	
	    #Si el estado del USUARIO = MOROSO y el tipo de AJUSTE = CREDITO
	    #debo verificar si los acumulados CREDITO y COBRANZA  superan el importe que debe el usuario
	    #y si su estado es moroso -> lo vuelvo a NORMAL	
	    	
    	if( $iEstadoCuentaUsuario = 3 || $iEstadoCuentaUsuario = 4 || 
		$iEstadoCuentaUsuario = 5 || $iEstadoCuentaUsuario = 7 ||
		$iEstadoCuentaUsuario = 8 || $iEstadoCuentaUsuario = 9 
		)
		{
			$sCondiciones = " where idCuentaUsuario = {$form['idCuentaUsuario']} order by DetallesCuentasUsuarios.id DESC LIMIT 0,1 ";
			$sqlDatosDetalleCuennta = "CALL usp_getDetallesCuentasUsuarios(\"$sCondiciones\");";	
			$DetalleCuenta = $oMysql->consultaSel($sqlDatosDetalleCuennta,true);
			
			$fAcumuladoCreditoCobranza = $DetalleCuenta["fAcumuladoCredito"] + $DetalleCuenta["fAcumuladoCobranza"];
			
			//$oRespuesta->alert("fAcumuladoCreditoCobranza: " . $fAcumuladoCreditoCobranza);
			
			if($fAcumuladoCreditoCobranza >= $DetalleCuenta["fSaldoAnterior"])
			{
				#Actualizar Cuenta estado cuenta usuario
				
				$idNuevoEstadoCuenta = 1; //NORMAL
				$iDiasMoraNuevo = 0;
				#Aca se deben desmarcar todas las cuotas futuras de consumos, adelantos etc..
				reasignarFechasDeFacturacion($DetalleCuenta['dFechaCierre'], $DetalleCuenta['idCuentaUsuario']);
				
				
				#--------------------- Actualizar los dias de mora y estado del usuario ----------------------------
				$set = "iDiasMora = '{$iDiasMoraNuevo}', idTipoEstadoCuenta = '{$idNuevoEstadoCuenta}'";
			    $conditions = "DetallesCuentasUsuarios.id = '{$DetalleCuenta['id']}'";
			    	
				$ToAuditory = "Actualizacion Cuenta Usuario ::: Empleado ={$_SESSION['id_user']} - Dias de Mora: {$iDiasMoraNuevo} - Estado: {$idNuevoEstadoCuenta}";
				   
				$id = $oMysql->consultaSel("CALL usp_updateEstadoCuentaUsuario(\"$iDiasMoraNuevo\",\"$idNuevoEstadoCuenta\",\"{$form['idCuentaUsuario']}\",\"{$DetalleCuenta['id']}\",\"{$_SESSION['id_user']}\");",true);	
				
				//$oRespuesta->alert("CALL usp_updateEstadoCuentaUsuario(\"$iDiasMoraNuevo\",\"$idNuevoEstadoCuenta\",\"$idCuentaUsuario\",\"{$DetalleCuenta['id']}\",\"{$_SESSION['id_user']}\");");	
			} 
 		}

    	$oRespuesta->alert("La operacion se realizo correctamente");
  		$oRespuesta->redirect("AjustesUsuarios.php");
  	
		return  $oRespuesta;	
	}
		
	#--------------------------------------------------------- Liquidacion comercios ---------------------------------------------------------------
		
	function liquidarComercios_($form)
	{
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
		
		if($dif < 0){
			
			$oRespuesta->alert("La Fecha Tope de Consumos no puede ser mayor a la Fecha Actual");
			return $oRespuesta;

		}
		
		$dif = mktime(0,0,0,$mesActual,$diaActual,$añoActual) - mktime(0,0,0, $mesLiquidacion,$diaLiquidacion,$AñoLiquidacion);
		
		if($dif > 0){
			
			$oRespuesta->alert("La Fecha de Liquidacion no puede ser menor a la Fecha Actual");
			return $oRespuesta;

		}
		
		$aComercios = $form['aComercios'];
			
		$sqlTasaIVA="Call usp_getTasasIVA(\" WHERE TasasIVA.id = 1\");";

		$oTasaIVA = $oMysql->consultaSel($sqlTasaIVA, true);	

		$fTasaIVA = $oTasaIVA['fTasa'];
		
		$fRetencionIVA = 0;
		$fRetencionGanancias = 0;
		$fRetencionIngresosBrutos = 0;
		$fImporteBrutoTotal = 0;		
		
		foreach ($aComercios as $idComercio){
			
			#Obtener retenciones a comercios
			
			$sqlDatosComercio="Call usp_getRetencionesComercio(\"{$idComercio}\");";
			
			$ComercioRetenciones = $oMysql->consultaSel($sqlDatosComercio, true);	
			
			$fRetencionIVA 				= (is_null($ComercioRetenciones['fRetencionIVA']))				? 0 : $ComercioRetenciones['fRetencionIVA'];
			$fRetencionGanancias 		= (is_null($ComercioRetenciones['fRetencionGanancias'])) 		? 0 : $ComercioRetenciones['fRetencionGanancias'];
			$fRetencionIngresosBrutos 	= (is_null($ComercioRetenciones['fRetencionIngresosBrutos'])) 	? 0 : $ComercioRetenciones['fRetencionIngresosBrutos'];		
			
			
			#las retenciones se calculan sobre el bruto, pero se debe considerar que debe superar el importe minimo
			
			

			#---------------------------------------------------------------------------------------------------------
			

			#Procesar ajustes de comercio (detalles de ajustes de comercios)

			#Obtengo Detalles de Ajustes de Comercios 
			
			#Asociados a planes
			$sCondicionesAjustesPlanes = " WHERE idComercio = {$idComercio} AND dFechaLiquidacionComercio = '0000-00-00 00:00:00' AND AjustesComercios.iPlanPromo = 0";
			$sqlDatosAjustesPlanes= "Call usp_getDetallesAjustesComerios(\"$sCondicionesAjustesPlanes\");";
			$AjustesComerciosPlanes = $oMysql->consultaSel($sqlDatosAjustesPlanes);	

			#Asociados a promociones
			$sCondicionesAjustesPromos = " WHERE idComercio = {$idComercio} AND dFechaLiquidacionComercio = '0000-00-00 00:00:00' AND AjustesComercios.iPlanPromo = 1";
			$sqlDatosAjustesPromos="Call usp_getDetallesAjustesComerios(\"$sCondicionesAjustesPromos\");";
			$AjustesComerciosPromos = $oMysql->consultaSel($sqlDatosAjustesPromos);	
			
			//$oRespuesta->alert($sqlDatosAjustesPromos);
			//$oRespuesta->alert("Cantidad AjustesComerciosPromos: " . count($AjustesComerciosPromos));
			
			$AjustesComercios = array_merge($AjustesComerciosPlanes , $AjustesComerciosPromos);
			
			
			$fAjusteDebito = 0;
			$fAjusteCredito = 0;
			$fIVA_AjusteDebito = 0;
			$fIVA_AjusteCredito = 0;
			
			foreach ($AjustesComercios as $Ajuste)
			{

				if($Ajuste["sClaseAjuste"] == "D"){

					$oRespuesta->alert("fAjusteDebito: " . $fAjusteDebito);
					$fAjusteDebito += $Ajuste["fImporteCuota"];		
					
					if($Ajuste["bDiscriminaIVA"])
						$fIVA_AjusteDebito += $Ajuste["fImporteIVA"];
							
				}else{
					
					$fAjusteCredito += $Ajuste["fImporteCuota"];		
					
					if($Ajuste["bDiscriminaIVA"])
						$fIVA_AjusteCredito += $Ajuste["fImporteIVA"];			
				}

			}
			//---------------------------------------------------------------------
			
			
			#-------------------Procesar cupones agrupados por plan ---------------	 	
			
			#Obtengo cupones agrupados por tipo de plan
			$sqlDatosCupones="Call usp_getCuponesPlanesLiquidaciones(\"$idComercio\",\"{$dFechaTopeConsumos}\");";
			
			$CuponesAgrupadosPorPlan = $oMysql->consultaSel($sqlDatosCupones);			
			
			$fImporteArancel = 0;
			$fTotalArancel =  0;	
			$fImporteCostoFinanciero = 0;
			$fTotalCostoFinanciero =  0;
			$fImporteBrutoTotal = 0;

			$fConsumosUnPago = 0;
			$fConsumoCuota = 0;
			
			//$oRespuesta->alert("CuponesAgrupadosPorPlan: " . count($CuponesAgrupadosPorPlan));
			
			foreach ($CuponesAgrupadosPorPlan as $cupon)
			{
				//$oRespuesta->alert("entro pues");
							
				if($cupon['iCantidadCuota'] == 1)
				{
					$fConsumosUnPago += $cupon['fImporteAcumulado'];	
					$importe_consumo_1_pago = $cupon['fImporteAcumulado'];
					$importe_consumo_n_pago = 0;
				}
				else 
				{
					$fConsumoCuota += $cupon['fImporteAcumulado'];
					
					$importe_consumo_1_pago = 0;
					$importe_consumo_n_pago = $cupon['fImporteAcumulado'];
				}
				
				$fImporteArancel = ($cupon['fImporteAcumulado'] * $cupon['fPorcentajeArancel']) / 100;
				$fTotalArancel +=  $fImporteArancel;
			
				$fImporteCostoFinanciero = ($cupon['fImporteAcumulado'] * $cupon['fPorcentajeCostoFinanciero']) / 100;
				$fTotalCostoFinanciero +=  $fImporteCostoFinanciero;	

				
				$fImporteBrutoTotal += $cupon['fImporteAcumulado'];
				
				
				#creo array de los datos a almacenar, datos parciales asociados a planes
				#_______________________________________________________________________
				
				$fImporteRetencionIVA = 0;
				$fImporteRetencionGanancias = 0;
				$fImporteRetencionIngBrutos = 0;	
							
				$fRetenciones = $fImporteRetencionIVA +	$fImporteRetencionGanancias + $fImporteRetencionIngBrutos;
						
				$fImporteIVA_Arancel = ($fTasaIVA * $fImporteArancel) / 100;
				$fImporteIVA_CostoFinanciero = ($fTasaIVA * $fImporteCostoFinanciero) / 100;						
							
				$fImporteNetoCobrar = ($cupon['fImporteAcumulado']) - ($fImporteIVA_Arancel + $fImporteArancel + $fImporteIVA_CostoFinanciero + $fImporteCostoFinanciero + $fRetenciones );
				
				$datos[] = "
			   		{$_SESSION['id_user']},
			   		{$importe_consumo_1_pago},
			   		{$fImporteNetoCobrar},
				   	{$importe_consumo_n_pago},
			   		{$cupon['fImporteAcumulado']},			   		
			   		{$fImporteRetencionIVA},
			   		{$fImporteArancel},		   		
			   		{$fImporteIVA_Arancel},
			   		{$fImporteCostoFinanciero},
			   		{$fImporteIVA_CostoFinanciero},
			   		{$fImporteRetencionGanancias},
			   		{$fImporteRetencionIngBrutos},			   		
			   		'A',
			   		'0',
			   		'{$cupon['idPlan']}',
			   		'1'
				   	";

			}
			
			
			#obtengo cupones agrupados por promociones
			#________________________________________________________________________________________________
			
			$SQL = "Call usp_getCuponesPromocionesLiquidaciones(\"$idComercio\",\"{$dFechaTopeConsumos}\");";
			
			$cupones_agrupados_x_promociones = $oMysql->consultaSel( $SQL );
						
			foreach ($cupones_agrupados_x_promociones as $cupon)
			{			
				if($cupon['iCantidadCuota'] == 1)
				{
					$fConsumosUnPago += $cupon['fImporteAcumulado'];	
					$importe_consumo_1_pago = $cupon['fImporteAcumulado'];
					$importe_consumo_n_pago = 0;
				}
				else 
				{
					$fConsumoCuota += $cupon['fImporteAcumulado'];
					
					$importe_consumo_1_pago = 0;
					$importe_consumo_n_pago = $cupon['fImporteAcumulado'];
				}
				
				$fImporteArancel = ($cupon['fImporteAcumulado'] * $cupon['fPorcentajeArancel']) / 100;
				$fTotalArancel +=  $fImporteArancel;
			
				$fImporteCostoFinanciero = ($cupon['fImporteAcumulado'] * $cupon['fPorcentajeCostoFinanciero']) / 100;
				$fTotalCostoFinanciero +=  $fImporteCostoFinanciero;	
		
				//$oRespuesta->alert("fImporteCostoFinanciero: " . $fImporteCostoFinanciero);
				//$oRespuesta->alert($cupon['fImporteAcumulado'] ." * " .$cupon['fPorcentajeCostoFinanciero']);
				
				$fImporteBrutoTotal += $cupon['fImporteAcumulado'];
				
				
				#creo array de los datos a almacenar, datos parciales asociados a planes
				#_______________________________________________________________________
				
				$fImporteRetencionIVA = 0;
				$fImporteRetencionGanancias = 0;
				$fImporteRetencionIngBrutos = 0;	
							
				$fRetenciones = $fImporteRetencionIVA +	$fImporteRetencionGanancias + $fImporteRetencionIngBrutos;
						
				$fImporteIVA_Arancel = ($fTasaIVA * $fImporteArancel) / 100;
				$fImporteIVA_CostoFinanciero = ($fTasaIVA * $fImporteCostoFinanciero) / 100;						
							
				$fImporteNetoCobrar = ($cupon['fImporteAcumulado']) - ($fImporteIVA_Arancel + $fImporteArancel + $fImporteIVA_CostoFinanciero + $fImporteCostoFinanciero + $fRetenciones );
				
				$fImporteRetIVADetalle = getImporteRetencion($fImporteBrutoTotal, $cupon['fImporteAcumulado'], $fImporteRetencionIVA);
				$fImporteRetGananciasDetalle = getImporteRetencion($fImporteBrutoTotal, $cupon['fImporteAcumulado'], $fImporteRetencionGanancias);
				$fImporteRetIngBrutosDetalle = getImporteRetencion($fImporteBrutoTotal, $cupon['fImporteAcumulado'], $fImporteRetencionIngBrutos);
				
				$datos[] = "
			   		{$_SESSION['id_user']},
			   		{$importe_consumo_1_pago},
			   		{$fImporteNetoCobrar},
				   	{$importe_consumo_n_pago},
			   		{$cupon['fImporteAcumulado']},			   		
			   		{$fImporteRetIVADetalle},
			   		{$fImporteArancel},		   		
			   		{$fImporteIVA_Arancel},
			   		{$fImporteCostoFinanciero},
			   		{$fImporteIVA_CostoFinanciero},
			   		{$fImporteRetGananciasDetalle},
			   		{$fImporteRetIngBrutosDetalle},			   		
			   		'A',
			   		'0',
			   		'{$cupon['idPlan']}',
			   		'1'
				   	";
			}
			
			
			//---------------------------------------------------------------------------------
			
			#obtengo totales generales
			#________________________
				
			$fImporteRetencionIVA = 0;
			$fImporteRetencionGanancias = 0;
			$fImporteRetencionIngBrutos = 0;	
						
			$fRetenciones = $fImporteRetencionIVA +	$fImporteRetencionGanancias + $fImporteRetencionIngBrutos;
					
			$fImporteIVA_Arancel = ($fTasaIVA * $fTotalArancel) / 100;
			$fImporteIVA_CostoFinanciero = ($fTasaIVA * $fTotalCostoFinanciero) / 100;						
						
			$fImporteNetoCobrar = 
			($fAjusteCredito +  $fIVA_AjusteCredito + $fImporteBrutoTotal) - 
			($fImporteIVA_Arancel + $fTotalArancel + $fImporteIVA_CostoFinanciero + $fTotalCostoFinanciero + $fRetenciones + $fAjusteDebito + $fIVA_AjusteDebito);				
				
			
			if(count($AjustesComercios) > 0 || count($CuponesAgrupadosPorPlan) > 0)
			{
			
				#-------------------------------- Insertar Liquidacion -----------------------------------------------------
				$Fecha = date('Y-m-d h:m:s');
					
				$sNumero =$oMysql->consultaSel("select fnc_getCodigoLiquidacion();",true);
				
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
			   		{$idComercio},
			   		{$_SESSION['id_user']},
			   		{$fConsumosUnPago},
			   		{$fImporteNetoCobrar},
				   	{$fConsumoCuota},
			   		{$fImporteBrutoTotal},			   		
			   		{$fImporteRetencionIVA},
			   		{$fTotalArancel},		   		
			   		{$fImporteIVA_Arancel},
			   		{$fTotalCostoFinanciero},
			   		{$fImporteIVA_CostoFinanciero},
			   		{$fImporteRetencionGanancias},
			   		{$fImporteRetencionIngBrutos},
			   		{$fAjusteDebito},
			   		{$fAjusteCredito},
			   		{$fIVA_AjusteCredito},
			   		{$fIVA_AjusteDebito},
			   		'A'			   		
				   	";
					   	  
				 	$sMensaje =" 
				 	-- RESUMEN DE LIQUIDACION --
				 	Numero: $sNumero
			   		Fecha: $Fecha 
			   		id Comercio: $idComercio
				 	------------------------------------------			 	
			   		Importe Bruto Total: $fImporteBrutoTotal 
			   			+ 
			   		Ajuste Credito: $fAjusteCredito 
			   			+ 		
			   		IVA Ajuste Credito: $fIVA_AjusteCredito)	 		
			   			-				
				 	Importe Arancel: $fTotalArancel
				 		- 
				 	Importe IVA Arancel: $fImporteIVA_Arancel 
				 		- 
				 	Total Costo Financiero: $fTotalCostoFinanciero 
				 		-
			   		Importe IVA CostoFinanciero: $fImporteIVA_CostoFinanciero 
			   			- 
			   		Retenciones: $fRetenciones 
			   			- 
			   		Ajuste Debito: $fAjusteDebito
				 	 	-		
			   		fIVA AjusteDebito: $fIVA_AjusteDebito) 
			   		______________________________________ 
				 	
			   		Importe Neto Cobrar: $fImporteNetoCobrar";
			   		 
			   		$oRespuesta->alert($sMensaje);
			   		
				   	$ToAuditory = "Insercion de Liquidacion a Comercio ::: Empleado ={$_SESSION['id_user']}";
				   
				    $idLiquidacion = $oMysql->consultaSel("CALL usp_InsertTable(\"Liquidaciones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"74\",\"$ToAuditory\");",true);   				   	
									 
				   	//$oRespuesta->alert("CALL usp_InsertTable(\"Liquidaciones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"74\",\"$ToAuditory\");");
					$oRespuesta->alert("Liquidacion registrada");
					
						
					#agrego los detalles de Liquidacion
					#__________________________________
					
					$set ="
						idLiquidacion,
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
			  	   		sEstado,
						idTransaccion,
						idPlanPromo,
						iPlanPromo
				  	     ";					
					
					foreach ($datos as $detalle) {

						$values = "'$idLiquidacion'," . $detalle ;

					   	$toauditory = "Insercion de Detalle de Liquidacion a Comercio ::: Empleado ={$_SESSION['id_user']}";

					    $idDetalleLiquidacion = $oMysql->consultaSel("CALL usp_InsertTable(\"DetallesLiquidaciones\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"74\",\"$toauditory\");",true);

					}
					
					
				//-------------------------------------------------------------------------------------------------------------------------------------------------
					
				
				//-------------------- Actualizar Detalles de cupones con el id de liquidacion --------------------------------------------------------------------
				
				$sCondicionesDetalles = " WHERE Cupones.idComercio = {$idComercio} AND DetallesCupones.dFechaLiquidacionComercio <= '{$dFechaTopeConsumos}'";
				$sqlDatosDetalles="Call usp_getDetallesCupones(\"$sCondicionesDetalles\");";
				$DetallesCupones = $oMysql->consultaSel($sqlDatosDetalles);	
							
				//$oRespuesta->alert("idLiquidacion: " . $idLiquidacion);
				
				foreach ($DetallesCupones as $Detalle)
				{
					$set = "idLiquidacion = '{$idLiquidacion}'";
			    	$sCondiciones = "DetallesCupones.id = {$Detalle["id"]}";
					$sqlDatosUpdate = "CALL usp_UpdateValues(\"DetallesCupones\",\"$set\",\"$sCondiciones\");";				
			    	
					$id = $oMysql->consultaSel($sqlDatosUpdate,true);   		
					//$oRespuesta->alert($sqlDatosUpdate);
				}
				
				
				//------------------- Actualizar Detalles de Ajustes de Comercios con el id de liquidacion -----------------------------------------------------------
				
				$sCondicionesDetalles = " WHERE AjustesComercios.idComercio = {$idComercio} AND DetallesAjustesComercios.dFechaFacturacionComercio <= '{$dFechaTopeConsumos}'";
				$sqlDatosDetalles="Call usp_getDetallesAjustesComerios(\"$sCondicionesDetalles\");";
				$DetallesAjustes = $oMysql->consultaSel($sqlDatosDetalles);	
							
				//$oRespuesta->alert($sqlDatosDetalles);			
				//$idLiquidacion = 1000;
				
				foreach ($DetallesAjustes as $Detalle)
				{
					$set = "idLiquidacion = '{$idLiquidacion}'";
			    	$sCondiciones = "DetallesAjustesComercios.id = {$Detalle["id"]}";
					$sqlDatosUpdate = "CALL usp_UpdateValues(\"DetallesAjustesComercios\",\"$set\",\"$sCondiciones\");";				
			    	
					$id = $oMysql->consultaSel($sqlDatosUpdate,true);   		
					$oRespuesta->alert($sqlDatosUpdate);
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
			
			$fImporteRetencionIVA = 0;
			$fImporteRetencionGanancias = 0;
			$fImporteRetencionIngBrutos = 0;
				
		} #fin foreach comercios
				
		return $oRespuesta;
	}	
	
	function updateEstadoLiquidacion($idLiquidacion, $sEstado)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();	
		
		$oRespuesta->alert("updateEstadoLiquidacion");
		
		$set = "sEstado = '{$sEstado}'";
	    $conditions = "Liquidaciones.id = '{$idLiquidacion}'";
		$ToAuditory = "Update Estado Liquidacion ::: Empleado ={$_SESSION['id_user']} ::: idLiquidacion={$idLiquidacion} ::: estado={$sEstado}";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Liquidaciones\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"75\",\"$ToAuditory\");",true);   
		

		$set = " idLiquidacion = 0 ";
	    $conditions = " DetallesCupones.idLiquidacion = '{$idLiquidacion}'";
	    	
		$oMysql->consultaSel("CALL usp_UpdateValues(\"Liquidaciones\",\"$set\",\"$conditions\");",true);   
		$oRespuesta->alert("CALL usp_UpdateValues(\"DetalleCupones\",\"$set\",\"$conditions\");");		
		
		return  $oRespuesta;
	}
	
	
	//------------------------- AJUSTES COMERCIOS ------------------------------------------------
	function buscarDatosComercioPorNumeroAC_Maxi($numero_comercio = '')//MAXI
	{
		global $oMysql;	
		$oRespuesta = new xajaxResponse();

		$sub_query = " WHERE Comercios.sNumero = '$numero_comercio' AND Comercios.sEstado = 'A' " ;
		
		$comercio = $oMysql->consultaSel("CALL usp_getComercios(\"$sub_query\");", true);
		
		if(!$comercio)
		{
			$oRespuesta->script("setNotFoundComercio();");
		}
		else
		{			
			$PomocionesPlanes = $oMysql->getListaOpciones('PromocionesPlanes','id','sNombre', 0, "idComercio = {$comercio['id']}");			
			$Planes = $oMysql->getListaOpciones('Planes','id','sNombre', 0, "sEstado = 'A' AND idComercio = {$comercio['id']}");			
			
			$oRespuesta->script("setDatosComercioN2('"._encode($comercio['id'])."','{$comercio['sRazonSocial']}',' {$comercio['sNombreFantasia']}','{$comercio['sCUIT']}','{$comercio['sNumero']}');");
			
			$oRespuesta->assign("idPlanPromocion","innerHTML","$PomocionesPlanes");
			$oRespuesta->assign("idPlan","innerHTML","$Planes");
		}

		return $oRespuesta;
	}	
	
	
	function updateDatosAjustesComercios($form)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		//$oRespuesta->alert("updateDatosAjustesComercios");
		
		$dFecha =  date("Y-m-d h:i:s");		
		$idAjusteComercio = 0;	
		
		$idPlan = $form['idPlan'];
		$idPlanPromo = $form['idPlanPromocion'];
		$iTipoPlanPromo = 0;
		
		//$oRespuesta->alert("idPlan: ". $idPlan ."-  idPlanPromo: " . $idPlanPromo);
		
		if($idPlan != 0)
		{
			$iTipoPlanPromo = 0;
			$idPlanInsert = $idPlan;
		}
		else if($idPlanPromo !=0)
		{
			$iTipoPlanPromo = 1;
			$idPlanInsert = $idPlanPromo;
		}
		
		
		//$oRespuesta->alert("iTipoPlanPromo:" . $iTipoPlanPromo);		
		
		$form['idCuentaUsuario'] = _decode($form['idCuentaUsuario']);
		$form['_ico'] = _decode($form['_ico']);
		
		$sCodigo=$oMysql->consultaSel("select fnc_getCodigoAjusteComercio();",true);
		
	  	if($form['idAjusteComercio'] == 0)
	    {       
	  	   $set ="
	  	   		idComercio,
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
	  	   		fTotalFinal,
	  	   		idPlan,
	  	   		iPlanPromo
	  	   		";
	  	     	   		
		   $values = "
		   		'{$form['_ico']}',
		   		'{$form['idTipoAjuste']}',		   	
		   		'{$_SESSION['id_user']}',
		   		'{$form['idTipoMoneda']}',
		   		'{$dFecha}',
		   		'{$sCodigo}',
		   		'{$form['iCuotas']}',
		   		'{$form['fImporteTotal']}',
		   		'{$form['fImporteTotalInteres']}',
		   		'{$form['fImporteTotalIVA']}',
		   		'A',
		   		'0',
		   		'{$form['idTasaIVA']}',
		   		'{$form['fImporteTotalFinal']}',
		   		'{$idPlanInsert}',
		   		'{$iTipoPlanPromo}'
		   		";
		   	 
		   
		   $fimporteConInteres = $form['fImporteTotalInteres'] + $form['fImporteTotal'];		 
		   	   
		   $ToAuditory = "Insercion Ajuste de Comercio ::: Empleado ={$_SESSION['id_user']}";
		   
		   $idAjusteUsuario = $oMysql->consultaSel("CALL usp_InsertTable(\"AjustesComercios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"71\",\"$ToAuditory\");",true);     
		   		   
		//$oRespuesta->alert("CALL usp_InsertTable(\"AjustesComercios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"71\",\"$ToAuditory\");");
	    }
	      
	     //----------- Insertar el detalle (cuotas) ----------------------------	    

		  $set = "
		   			(
		   				idEmpleado,
		   				idAjusteComercio,
		   				iNumeroCuota,
		   				fImporteCuota,
		   				fImporteInteres,
		   				fImporteIVA,
		   				dFechaFacturacionComercio,
   						dFechaLiquidacionComercio
		   			)";
		   		        
		   $fImporteCuota = $form['fImporteTotal'] / $form['iCuotas'];
		   $fImporteInteres = $form['fImporteTotalInteres'] / $form['iCuotas'];
		   $fImporteIVA = $form['fImporteTotalIVA'] / $form['iCuotas'];
		     	   
	  	   for($i=1; $i<= $form['iCuotas']; $i++ )
		   {
				$fecha_Liquidacion = '0000-00-00';						
				
				$valuesCuotas .= "
	   					(
	   						'{$_SESSION['id_user']}',
							'{$idAjusteUsuario}',
							'{$i}',
							'{$fImporteCuota}',
							'{$fImporteInteres}',
			   				'{$fImporteIVA}',
			   				'{$fecha_Liquidacion}',
			   				'{$fecha_Liquidacion}'
	   					)";
	   		
	   			if($i < $form['iCuotas'])
	   			{
					$valuesCuotas .= ",";	   			
	   			}				   		 
		   }
	    	
		   $ToAuditory = "Insercion Detalle de Ajuste de Comercio ::: Empleado ={$_SESSION['id_user']}"; 
	       $id = $oMysql->consultaSel("CALL usp_abm_General(\"DetallesAjustesComercios\",\"$set\",\"$valuesCuotas\",\"1\",\"{$_SESSION['id_user']}\",\"61\",\"$ToAuditory\");",true);   
	       
	       //$oRespuesta->alert("CALL usp_abm_General(\"DetallesAjustesComercios\",\"$set\",\"$valuesCuotas\",\"1\",\"{$_SESSION['id_user']}\",\"61\",\"$ToAuditory\");");

	    	//--------------------- fin insertar detalle ----------------------------------------------------		 


	    	$oRespuesta->alert("La operacion se realizo correctamente");
	  		$oRespuesta->redirect("AjustesComercios.php");
	  	
			return  $oRespuesta;	
	}
	

	function updateEstadoAjusteComercio($idAjusteComercio, $sEstado)
	{
	    GLOBAL $oMysql;
	    $oRespuesta = new xajaxResponse();   
		    
	    $sCondiciones = "WHERE AjustesComercios.id = '{$idAjusteComercio}'";
	    $oFacturado=$oMysql->consultaSel("CALL usp_getAjustesComercios(\"$sCondiciones\");",true);
	    	
	    //$oRespuesta->alert($oFacturado["iFacturado"]);
	    	
    	if($oFacturado["iFacturado"] == 1)
    	{
    		$oRespuesta->alert("No se puede anular un ajuste que se encuentra facturado");
    		return $oRespuesta;	
    	}
	       
	    $set = "sEstado = '{$sEstado}'";
	    $conditions = "AjustesComercios.id = '{$idAjusteComercio}'";
		$ToAuditory = "Update Estado Ajuste de Comercio ::: User ={$_SESSION['id_user']} ::: idAjusteComercio={$idAjusteComercio} ::: estado={$sEstado}";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"AjustesComercios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"73\",\"$ToAuditory\");",true);   
			
		/*
		$fimporteConInteres = -($oFacturado['fImporteTotalInteres'] + $oFacturado['fImporteTotal']);
		$fImporteTotalIVA = -($oFacturado['fImporteTotalIVA']);		 
		$idCuentaUsuario = $oFacturado['idCuentaUsuario']; 	
		$sClaseAjuste = $oFacturado['sClaseAjuste'];
				
		$oMysql->consultaSel("CALL usp_updateDebitoCredito(\"{$idCuentaUsuario}\",\"{$sClaseAjuste}\",\"{$fimporteConInteres}\",\"{$fImporteTotalIVA}\");", true);
		*/
		
		$oRespuesta->alert("La operacion se realizo correctamente");
		$oRespuesta->redirect("AjustesComercios.php");
		return $oRespuesta;
	}
	
	
	
	function updateTransLiquidaciones($idTransLiquidacion, $sEstado, $sObservaciones)
	{
		GLOBAL $oMysql;
	    $oRespuesta = new xajaxResponse();   

	    # Verificar que el valor de pago no se haya efectivizado para el comercio, caso contrario retornar sin anular
	      
	    //$oRespuesta->alert("UpdateTransLiquidaciones ". $idTransLiquidacion);	
	    
	    $set = "sEstado = '{$sEstado}', idLiquidacion = 0, sObservaciones = CONCAT(sObservaciones,' - Motivo de baja: ', '{$sObservaciones}')";
	    $conditions = "TransaccionesLiquidacionesComercios.id = '{$idTransLiquidacion}'";
		$ToAuditory = "Update Estado Valores de Pago ::: User ={$_SESSION['id_user']} ::: idAjusteComercio={$idTransLiquidacion} ::: estado={$sEstado}";
		
		$oRespuesta->alert("CALL usp_UpdateTable(\"TransaccionesLiquidacionesComercios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"76\",\"$ToAuditory\");");
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"TransaccionesLiquidacionesComercios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"76\",\"$ToAuditory\");",true);   
		
		$oRespuesta->alert("La operacion se realizo correctamente");
		
		return $oRespuesta;
	}
	
	//---------------------- CUENTA USUARIO ------------------------------------------
	function updateEstadoCuentaUsuario($form)
	{
	    GLOBAL $oMysql;
	    $oRespuesta = new xajaxResponse();   
		$form['sMotivo'] = convertir_especiales_html($form['sMotivo']);
  
	    $set = "CuentasUsuarios.idTipoEstadoCuenta = '{$form['idTipoEstadoCuenta']}'";
	    $conditions = "CuentasUsuarios.id = '{$form['idCuentaUsuario']}'";
		$ToAuditory = "Update Estado Cuenta Usuario ::: User ={$_SESSION['id_user']} ::: idCuentaUsuario={$form['idCuentaUsuario']} ::: estado={$form['idTipoEstadoCuenta']}";
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"CuentasUsuarios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"78\",\"$ToAuditory\");",true);   
				
		$setEstado = "idCuentaUsuario,idEmpleado,idTipoEstadoCuenta,dFechaRegistro,sMotivo";
		$valuesEstado = "'{$form['idCuentaUsuario']}','{$_SESSION['id_user']}','{$form['idTipoEstadoCuenta']}',NOW(),'{$form['sMotivo']}'";
		$ToAuditoryEstado = "Insercion Historial de Estados Cuentas Usuarios ::: User ={$_SESSION['id_user']} ::: idCuentaUsuario={$form['idCuentaUsuario']} ::: estado={$form['idTipoEstadoCuenta']}";
		$idEstado = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosCuentas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"23\",\"$ToAuditoryEstado\");",true);   
		 
		//$oRespuesta->alert("CALL usp_InsertTable(\"EstadosCuentas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"23\",\"$ToAuditoryEstado\");");
		$dUltimoPeriodo = $oMysql->consultaSel("SELECT fcn_getUltimoPeriodoDetalleCuentaUsuario(\"{$form['idCuentaUsuario']}\")",true);
		$sEstado = $oMysql->consultaSel("SELECT TiposEstadosCuentas.sNombre FROM TiposEstadosCuentas WHERE TiposEstadosCuentas.id={$form['idTipoEstadoCuenta']}",true);
		
		$sql = "UPDATE DetallesCuentasUsuarios SET DetallesCuentasUsuarios.sEstado = '{$sEstado}'
    		WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$form['idCuentaUsuario']}
    		AND DetallesCuentasUsuarios.dPeriodo ='{$dUltimoPeriodo}'";
    	
		$oMysql->startTransaction();
		$oMysql->consultaAff($sql);
		$oMysql->commit();
    	$sMensaje ="La operacion se realizo correctamente";
    	
	    $oRespuesta->assign("tdContent","innerHTML",$sMensaje);
	    $oRespuesta->assign("btnConfirmar","style.display","none");
		return $oRespuesta;
	}	
?>