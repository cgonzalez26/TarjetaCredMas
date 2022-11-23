<?
//--------------------------------------------------------------------------------------------------------------
function getCuil($idValor,$sDocumento){
	$oRespuesta = new xajaxResponse(); 
	global $aDatosSeguro;  
	$sSexo='';
	$sCuilNewCompleto='';
	if ($idValor > 0){
	      if($idValor == 1) $sSexo='M';
	      elseif($idValor == 2) $sSexo='F';
	      
	      $cuit = new _Cuit($sDocumento,$sSexo);
	      
	      $sCuil=$cuit->_generateCUIL();
	      
	      if(strlen($sCuil)!=11){
      		$sCuilNewCompleto = substr($sCuil, 0, 2).'0'.substr($sCuil,2,8);
      	  }else $sCuilNewCompleto=$sCuil;
	      
	      $oRespuesta->assign('sCuit','value',$sCuilNewCompleto);
	}      
	
	return $oRespuesta;
}

function tagSelectLocalidades($idProvincia=null){
	$mysql = new MySQL();
	$oRespuesta = new xajaxResponse();			
	
	$where = (is_null($idProvincia)) ? "" : "Localidades.idProvincia = '$idProvincia'" ;	
	$options = arrayToOptions(($mysql->query("CALL usp_getSelect(\"Localidades\",\"id\",\"sNombre\",\"$where\");")));
	
	$selects = "&nbsp;<select name='idLocalidad' id='idLocalidad' style='width:150px;'><option value='0'>[-Selecccionar-]</option>".$options."</select>";		
	
	$oRespuesta->assign('tdLocalidad','innerHTML',$selects);	
	return $oRespuesta;		
}

function getTagSelectUsuarios($idOficina){
	$mysql = new MySQL();
	$oRespuesta = new xajaxResponse();

	$options = arrayToOptions($mysql->query("CALL usp_getSelect(\"Usuarios\",\"id\",\"sNombre\",\"idOficina = '$idOficina'\");"));
	
	$selects = "&nbsp;<select name='idUsuario' id='idUsuario' style='width:200px;'><option value='0'>[-Selecccionar-]</option>".$options."</select>";
		
	$oRespuesta->assign('tdUsuario','innerHTML',$selects);
	return $oRespuesta;
}

//--------------------------------------------------------------------------------------------------------------
		
	function logueo($form){	
		global $oMysql;
		$oRespuesta = new xajaxResponse();
		$errores = '';
		
		if($form['sUser'] == "") $errores = 'El Nombre de Usuario no es valido';
		else if($form['Pass'] == "") $errores = 'La contrase&ntilde;a no es válida';
		else {		
		    
			$nick = $oMysql->escaparCadena( $form['sUser'] );
			$pass = md5( $oMysql->escaparCadena( $form['Pass'] ) );	
			$datos = $oMysql->consultaSel("SELECT id,sPassword,sEstado FROM usuarios WHERE sLogin = '{$nick}'",true);		
			if(!$datos) $errores = 'La Cuenta no existe';
			
			else if( $datos['sPassword'] != $pass ) $errores = 'La contraseña es incorrecta';
				
				else if($datos['sEstado'] != 'AUTORIZADO') $errores = 'Su Cuenta tiene conflicto. Contacte con el administrador';	
			
				else{
					session_start();
					$_SESSION['LOGIN'] =$nick;									
					$_SESSION['ID_USUARIO'] = $datos['id'];								
					$oRespuesta->script('location.reload(true)');
				}		
		}
		if($errores != ''){			
			$oRespuesta->alert($errores);
		}
		return  $oRespuesta;
	}
    
   

/******************* SOLICITUDES ***************************/
	
	function updateDatosSolicitud($form,$operacion){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
	    if($_SESSION['id_user']){
					
				$salir = false;
				if(($form['hdnDocumento'] != $form['sDocumento'])||($form['hdnidTipoDocumento'] != $form['idTipoDocumento'])){
					$id = $oMysql->consultaSel("SELECT id FROM InformesPersonales WHERE idTipoDocumento={$form['idTipoDocumento']} AND sDocumento={$form['sDocumento']}",true);
					if($id>0){
						$oRespuesta->alert("El Tipo de Documento y el Numero de Documento ya existe, verifique.");	
						$salir = true;
					}
				}
				if(!$salir){
					
					$form['dFechaPresentacion'] = dateToMySql($form['dFechaPresentacion']); 
					$form['dFechaSolicitud'] = dateToMySql($form['dFechaSolicitud']); 
					$form['dFechaNacimiento'] = dateToMySql($form['dFechaNacimiento']); 
					$form['dFechaIngreso1'] = dateToMySql($form['dFechaIngreso1']); 
					$form['dFechaIngreso2'] = dateToMySql($form['dFechaIngreso2']); 
					$form['fIngresoNetoMensual1'] = str_replace(",",".",$form['fIngresoNetoMensual1']);
					$form['fIngresoNetoMensual2'] = str_replace(",",".",$form['fIngresoNetoMensual2']);
					$form['sApellido'] = convertir_especiales_html($form['sApellido']);
					$form['sNombre'] = convertir_especiales_html($form['sNombre']);
					$form['sRazonSocial'] = convertir_especiales_html($form['sRazonSocial']);
					$form['sApellidoConyuge'] = convertir_especiales_html($form['sApellidoConyuge']);
					$form['sNombreConyuge'] = convertir_especiales_html($form['sNombreConyuge']);
					$form['sCalleTitu'] = convertir_especiales_html($form['sCalleTitu']);
					$form['sEntreCalleTitu'] = convertir_especiales_html($form['sEntreCalleTitu']);
					$form['sBarrioTitu'] = convertir_especiales_html($form['sBarrioTitu']);
					$form['sManzanaTitu'] = convertir_especiales_html($form['sManzanaTitu']);
					$form['sRazonSocialLab'] = convertir_especiales_html($form['sRazonSocialLab']);
					$form['sReparticion'] = convertir_especiales_html($form['sReparticion']);
					$form['sActividad'] = convertir_especiales_html($form['sActividad']);
				 	$form['sCalleLab'] = convertir_especiales_html($form['sCalleLab']);
					$form['sOficinaLab'] = convertir_especiales_html($form['sOficinaLab']);
					$form['sBarrioLab'] = convertir_especiales_html($form['sBarrioLab']);
					$form['sManzanaLab'] = convertir_especiales_html($form['sManzanaLab']);
					$form['sCargo1'] = convertir_especiales_html($form['sCargo1']);
					$form['sCargo2'] = convertir_especiales_html($form['sCargo2']);
					$form['sCalleResumen'] = convertir_especiales_html($form['sCalleResumen']);
					$form['sEntreCalleResumen'] = convertir_especiales_html($form['sEntreCalleResumen']);
					$form['sBarrioResumen'] = convertir_especiales_html($form['sBarrioResumen']);
					
					$sTelefonoParticularFijo = $form['sTelParticularFijoPrefijo'].'-'.$form['sTelParticularFijoNumero'];
					$sTelefonoParticularMovil = $form['sTelParticularMovilPrefijo'].'-'.$form['sTelParticularMovilNumero'];
					$sTelefonoLaboral1 = $form['sTelLaboral1Prefijo'].'-'.$form['sTelLaboral1Numero'];
					$sTelefonoLaboral2 = $form['sTelLaboral2Prefijo'].'-'.$form['sTelLaboral2Numero'];
					$sTelefonoContacto = $form['sTelContactoPrefijo'].'-'.$form['sTelContactoNumero'];
					
					/*$sTelefonoParticularFijo = $form['sTelParticularFijoPrefijo'].$form['sTelParticularFijoNumero'];
					$sTelefonoParticularMovil = $form['sTelParticularMovilPrefijo'].$form['sTelParticularMovilNumero'];
					$sTelefonoLaboral1 = $form['sTelLaboral1Prefijo'].$form['sTelLaboral1Numero'];
					$sTelefonoLaboral2 = $form['sTelLaboral2Prefijo'].$form['sTelLaboral2Numero'];
					$sTelefonoContacto = $form['sTelContactoPrefijo'].$form['sTelContactoNumero'];*/
					
					$form['sTelefonoParticularFijo']=$sTelefonoParticularFijo;
					$form['sTelefonoParticularCelular']=$sTelefonoParticularMovil;
					$form['sTelefonoContacto']=$sTelefonoContacto;
					$form['sTelefonoLaboral2']=$sTelefonoLaboral2;
					$form['sTelefonoLaboral1']=$sTelefonoLaboral1;
					
					$form['sGrupoResumen'] = convertir_especiales_html($form['sGrupoResumen']);
					$form['sCasaResumen'] = convertir_especiales_html($form['sCasaResumen']);
					$form['sMedidorResumen'] = convertir_especiales_html($form['sMedidorResumen']);
					$form['sOtrosResumen'] = convertir_especiales_html($form['sOtrosResumen']);
					$form['sGrupoTitu'] = convertir_especiales_html($form['sGrupoTitu']);
					$form['sCasaTitu'] = convertir_especiales_html($form['sCasaTitu']);
					$form['sMedidorTitu'] = convertir_especiales_html($form['sMedidorTitu']);
					$form['sOtrosTitu'] = convertir_especiales_html($form['sOtrosTitu']);
					
					IF(!isset($form['idPromotor'])) $form['idPromotor']=0;
					//$oRespuesta->alert($form['idSolicitud']);
				    if($form['idSolicitud'] == 0)
				    {    
				       $form['sNumero'] = generarNumeroSolicitud($_SESSION['NUMERO_REGION']);
				  	   $form['sEstado'] = 'A'; 	
				  	   
				  	   	$set = "idTipoEstado = '1',
				  	   			dFechaPresentacion = '{$form['dFechaPresentacion']}',
				  	   			dFechaSolicitud = '{$form['dFechaSolicitud']}',
				  	   			sNumero = '{$form['sNumero']}',
				  	   			idBIN = {$form['hdnIdBIN']},
				  	   			idCanal = {$form['idCanal']},
				  	   			idPromotor = {$form['idPromotor']},
				  	   			idProvinciaResumen = {$form['idProvinciaResumen']},
				  	   			idLocalidadResumen = {$form['idLocalidadResumen']},
				  	   			sCodigoPostalResumen = {$form['sCodigoPostalResumen']},
				  	   			sCalleResumen = '{$form['sCalleResumen']}',
				  	   			sNumeroCalleResumen = '{$form['sNumeroCalleResumen']}',
				  	   			sBlockResumen = '{$form['sBlockResumen']}',
				  	   			sPisoResumen = '{$form['sPisoResumen']}',
				  	   			sDepartamentoResumen = '{$form['sDepartamentoResumen']}',
				  	   			sEntreCalleResumen = '{$form['sEntreCalleResumen']}',
				  	   			sBarrioResumen = '{$form['sBarrioResumen']}',
				  	   			sManzanaResumen = '{$form['sManzanaResumen']}',
				  	   			sLoteResumen = '{$form['sLoteResumen']}',
				  	   			idCargador = {$form['idEmpleado']},
				  	   			iTipoPersona = '{$form['rdbTipoPersona']}',
			  	   				iEnvioDomicilio = '{$form['chkEnvioDomicilio']}',
			  	   				iEnvioMail = '{$form['chkEnvioMail']}',
			  	   				idCliente = '{$form['hdnIdCliente']}',
			  	   				sGrupoResumen = '{$form['sGrupoResumen']}',
			  	   				sCasaResumen = '{$form['sCasaResumen']}',
			  	   				sMedidorResumen = '{$form['sMedidorResumen']}',
			  	   				sOtrosResumen = '{$form['sOtrosResumen']}'
			  	   				";
				  	   
				  	   if(!$form['idEmpleado']){ 
				  	       $form['idEmpleado'] = $_SESSION['id_user'];
				  	       $ToAuditory = "Insercion de una Solicitud ::: User ={$_SESSION['id_user']}";
				  	       $idTipoAuditoria = 1;
				  	   }else{
				  	   	   $sEmpleado = $oMysql->consultaSel("SELECT CONCAT(Accesos.Empleados.sApellido,', ',Accesos.Empleados.sNombre) FROM Accesos.Empleados WHERE Accesos.Empleados.id={$form['idEmpleado']}",true);
				  	   	   $ToAuditory = "El Empleado {$sEmpleado} solicito la Alta de la Solicitud ::: idEmpleado ={$form['idEmpleado']}";
				  	   	   $idTipoAuditoria = 71;
				  	   }				    

				  	   $sConsulta="CALL usp_InsertTableSet(\"SolicitudesUsuarios\",\"$set\",\"{$_SESSION['id_user']}\",\"$idTipoAuditoria\",\"$ToAuditory\");";
				  	   
					   $idSolicitud = $oMysql->consultaSel($sConsulta,true);   
					   
					   $setPersonales = "idSolicitudUsuario = {$idSolicitud},
								sApellido = '{$form['sApellido']}',
								sNombre = '{$form['sNombre']}',
								idEstadoCivil = '{$form['idEstadoCivil']}',
								idNacionalidad = '{$form['idNacionalidad']}',
								sRazonSocial = '{$form['sRazonSocial']}',
								idTipoDocumento = '{$form['idTipoDocumento']}',
								sDocumento = '{$form['sDocumento']}',
								sCUIT = '{$form['sCuit']}',
								dFechaNacimiento = '{$form['dFechaNacimiento']}',
								idSexo = '{$form['idSexo']}',
								sApellidoConyuge = '{$form['sApellidoConyuge']}',
								sNombreConyuge = '{$form['sNombreConyuge']}',
								idTipoDocumentoConyuge = '{$form['idTipoDocumentoConyuge']}',
								sDocumentoConyuge = '{$form['sDocumentoConyuge']}',
								iHijos = '{$form['iHijos']}',
								idProvincia = '{$form['idProvinciaTitu']}',
								idLocalidad = '{$form['idLocalidadTitu']}',
								sCodigoPostal = '{$form['sCodigoPostalTitu']}',
								sCalle = '{$form['sCalleTitu']}',
								sNumeroCalle = '{$form['sNumeroCalleTitu']}',
								sEntreCalle = '{$form['sEntreCalleTitu']}',
								sBlock = '{$form['sBlockTitu']}',
								sPiso = '{$form['sPisoTitu']}',
								sDepartamento = '{$form['sDepartamentoTitu']}',
								sBarrio = '{$form['sBarrioTitu']}',
								sManzana = '{$form['sManzanaTitu']}',
								sLote = '{$form['sLoteTitu']}',
								sTelefonoParticularFijo = '{$sTelefonoParticularFijo}',
								sTelefonoParticularCelular = '{$sTelefonoParticularMovil}',
								idEmpresaCelular = '{$form['idEmpresaCelularTitular']}',
								sMail = '{$form['sMail']}',
								sTelefonoContacto = '{$sTelefonoContacto}',
								sReferenciaContacto = '{$form['sReferenciaContacto']}',
								idCondicionIva = '{$form['idCondicionIva']}',
								sGrupoTitu = '{$form['sGrupoTitu']}',
								sCasaTitu = '{$form['sCasaTitu']}',
								sMedidorTitu = '{$form['sMedidorTitu']}',
								sOtrosTitu = '{$form['sOtrosTitu']}'
								";
				   
				   $ToAuditoryPersonales = "Insercion de Informes Personales ::: User ={$_SESSION['id_user']} ::: idSolicitud={$idSolicitud}";
				   $sSqlInformes="CALL usp_InsertTableSet(\"InformesPersonales\",\"$setPersonales\",\"{$_SESSION['id_user']}\",\"5\",\"$ToAuditoryPersonales\");";
				   
				   $id = $oMysql->consultaSel($sSqlInformes,true);   	    	
				   
				   $setLab = "idSolicitudUsuario = {$idSolicitud},
			   				sRazonSocial = '{$form['sRazonSocialLab']}',
			   				sCUITEmpleador = '{$form['sCuitEmpleador']}',
			   				idCondicionAFIP = '{$form['idCondicionAFIPLab']}',
			   				idCondicionLaboral = '{$form['idCondicionLaboral']}',
			   				sReparticion = '{$form['sReparticion']}',
			   				sActividad = '{$form['sActividad']}',
			   				sCalle = '{$form['sCalleLab']}',
			   				sNumeroCalle = '{$form['sNumeroCalleLab']}',
			   				sBlock = '{$form['sBlockLab']}',
			   				sPiso = '{$form['sPisoLab']}',
			   				sOficina = '{$form['sOficinaLab']}',
			   				sBarrio = '{$form['sBarrioLab']}',
			   				sManzana = '{$form['sManzanaLab']}',
			   				idProvincia = '{$form['idProvinciaLab']}',
			   				idLocalidad = '{$form['idLocalidadLab']}',
			   				sCodigoPostal = '{$form['sCodigoPostalLab']}',
			   				sTelefonoLaboral1 = '{$sTelefonoLaboral1}',
			   				sInterno1 = '{$form['sInterno1']}',
			   				dFechaIngreso1 = '{$form['dFechaIngreso1']}',
			   				sCargo1 = '{$form['sCargo1']}',
			   				fIngresoNetoMensual1 = '{$form['fIngresoNetoMensual1']}',
			   				sTelefonoLaboral2 = '{$sTelefonoLaboral2}',
			   				sInterno2 = '{$form['sInterno2']}',
			   				dFechaIngreso2 = '{$form['dFechaIngreso2']}',
			   				sCargo2 = '{$form['sCargo2']}',
			   				fIngresoNetoMensual2 = '{$form['fIngresoNetoMensual2']}', 
			   				sEmailLaboral = '{$form['sEmailLaboral']}', 
			   				idTiposDgr = '{$form['idTiposDgr']}', 
			   				idTiposImpositivas = '{$form['idTiposImpositivas']}' 
			   				";
				   				   
				   $ToAuditoryLab = "Insercion de Informes Laborales ::: User ={$_SESSION['id_user']} ::: idSolicitud={$idSolicitud}";
				   $idLab = $oMysql->consultaSel("CALL usp_InsertTableSet(\"InformesLaborales\",\"$setLab\",\"{$_SESSION['id_user']}\",\"5\",\"$ToAuditoryLab\");",true);   	    	
				   $msje= "La operacion se realizo correctamente .\n El Numero de Solicitud es: ". $form['sNumero'];
				   				   
				   $setEstado = "idSolicitud,idEmpleado,idTipoEstadoSolicitud,dFechaRegistro,sMotivo";
				   $valuesEstado = "'{$idSolicitud}','{$form['idEmpleado']}','1',NOW(),''";
				   $ToAuditoryEstado = "Insercion Historial de Estados Solicitudes ::: User ={$_SESSION['id_user']} ::: idSolicitud={$idSolicitud} ::: estado=1";
				   $idEstado= $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosSolicitudes\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"9\",\"$ToAuditoryEstado\");",true);  
				  
				}else{
					
					//-------------------------------------------------------------------------------------------------------
					#renelo
					#opciones para el caso de una solicitud con estado idTipoEstado = 2 --> DADA ALTA, estado cuando la solicitud ya esta asociada a un CuentaUsuario y Tarjeta
					$idTipoEstadoSolicitudUsuario = $oMysql->consultaSel("SELECT fcn_getTipoEstadoSolicitudUsuario(\"{$form['idSolicitud']}\");",true);
					
					$idTipoEstadoSolicitudUsuario = intval($idTipoEstadoSolicitudUsuario);
					
					$estadoSOLICITUD = 2;
					
					$form['idUsuario'] = 0;
					#determino estado de la solicitud para saber si esta asociado a tabla USUARIO, por ende en DomiciliosUsuario y DatosLaborales
					
					if($idTipoEstadoSolicitudUsuario == $estadoSOLICITUD){ //si esta dada de alta es porque ya cuenta con relacion en las tablas usuarios DomiciliosUsuario y DatosLaborales
						$idsolicitud = $form['idSolicitud'];
						
						$sub_query = " WHERE SolicitudesUsuarios.id = $idsolicitud ;";
						$solicitudes = $oMysql->consultaSel("CALL usp_getSolicitudes(\"$sub_query\");",true);
						
						$checkDatosDomicilios = _checkDatosDomicilios($solicitudes,$form);
						
						$checkDatosLaborales  = _checkDatosLaborales($solicitudes,$form);
						
						//if($checkDatosDomicilios == true || $checkDatosLaborales == true){
							$idusuario = $oMysql->consultaSel("SELECT fcn_getIdUsuarioSolicitud(\"$idsolicitud\");",true);  
							$form['idUsuario'] = $idusuario;	
							
							if($idusuario == false || is_null($idusuario)){
								$form['idUsuario'] = 0;	
							}
							
						//}
		
						if($checkDatosDomicilios){
							_insertDomiciliosUsuario($form);
						}
		
						if($checkDatosLaborales){
							_insertDatosLaborales($form);
						}				
						
						#actualizo siempre los datos de la tabla de usuarios
						_updateDataUsuarios($form);
		
						//_mandarEMAILSOLICITUDES($solicitudes,$form);				
		
					}else{
					
						$idsolicitud = $form['idSolicitud'];
						
						$sub_query = " WHERE SolicitudesUsuarios.id = $idsolicitud ;";
						$solicitudes = $oMysql->consultaSel("CALL usp_getSolicitudes(\"$sub_query\");",true);
						
						#mando EMAIL
						//_mandarEMAILSOLICITUDES($solicitudes,$form);			
					}
					
					//-------------------------------------------------------------------------------------------------------
		
					if(!$form['idEmpleado']) $form['idEmpleado'] = $_SESSION['id_user'];
					
					#EDITAR SOLICITUD
					$set = "dFechaPresentacion	='{$form['dFechaPresentacion']}',
							dFechaSolicitud		='{$form['dFechaSolicitud']}',
			  	   			idCanal				='{$form['idCanal']}',
			  	   			idPromotor			='{$form['idPromotor']}',
			  	   			idProvinciaResumen	='{$form['idProvinciaResumen']}',
			  	   			idLocalidadResumen	='{$form['idLocalidadResumen']}',
			  	   			sCodigoPostalResumen='{$form['sCodigoPostalResumen']}',
			  	   			sCalleResumen		='{$form['sCalleResumen']}',
			  	   			sNumeroCalleResumen	='{$form['sNumeroCalleResumen']}',
			  	   			sBlockResumen		='{$form['sBlockResumen']}',
			  	   			sPisoResumen		='{$form['sPisoResumen']}',
			  	   			sDepartamentoResumen='{$form['sDepartamentoResumen']}',
			  	   			sEntreCalleResumen	='{$form['sEntreCalleResumen']}',
			  	   			sBarrioResumen		='{$form['sBarrioResumen']}',
			  	   			sManzanaResumen		='{$form['sManzanaResumen']}',
			  	   			sLoteResumen		='{$form['sLoteResumen']}',
			  	   			iTipoPersona 		='{$form['rdbTipoPersona']}',
			  	   			iEnvioDomicilio     ='{$form['chkEnvioDomicilio']}',
		  	   				iEnvioMail     		='{$form['chkEnvioMail']}',
		  	   				idCargador          ='{$form['idEmpleado']}',
		  	   				iEnvioDomicilio 	='{$form['chkEnvioDomicilio']}',
		  	   				iEnvioMail			='{$form['chkEnvioMail']}',
		  	   				idCliente = '{$form['hdnIdCliente']}',
		  	   				sGrupoResumen = '{$form['sGrupoResumen']}',
		  	   				sCasaResumen = '{$form['sCasaResumen']}',
		  	   				sMedidorResumen = '{$form['sMedidorResumen']}',
		  	   				sOtrosResumen = '{$form['sOtrosResumen']}'
		  	   				";
					//$oRespuesta->alert($set);
					$conditions = "SolicitudesUsuarios.id = '{$form['idSolicitud']}'";
					$ToAuditory = "Modificacion de Solicitudes ::: User ={$_SESSION['id_user']} ::: idSolicitud={$form['idSolicitud']}";
					
					$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"SolicitudesUsuarios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"2\",\"$ToAuditory\");",true);
					
					$setPers = "sApellido='{$form['sApellido']}',
							sNombre='{$form['sNombre']}',
							idEstadoCivil='{$form['idEstadoCivil']}',
							idNacionalidad='{$form['idNacionalidad']}',
							sRazonSocial='{$form['sRazonSocial']}',
							idTipoDocumento='{$form['idTipoDocumento']}',
							sDocumento='{$form['sDocumento']}',
							sCUIT='{$form['sCuit']}',
							dFechaNacimiento='{$form['dFechaNacimiento']}',
							idSexo='{$form['idSexo']}',
							sApellidoConyuge='{$form['sApellidoConyuge']}',
							sNombreConyuge='{$form['sNombreConyuge']}',
							idTipoDocumentoConyuge='{$form['idTipoDocumentoConyuge']}',
							sDocumentoConyuge='{$form['sDocumentoConyuge']}',
							iHijos='{$form['iHijos']}',
							idProvincia='{$form['idProvinciaTitu']}',
							idLocalidad='{$form['idLocalidadTitu']}',
							sCodigoPostal='{$form['sCodigoPostalTitu']}',
							sCalle='{$form['sCalleTitu']}',
							sNumeroCalle='{$form['sNumeroCalleTitu']}',
							sEntreCalle='{$form['sEntreCalleTitu']}',
							sBlock='{$form['sBlockTitu']}',
							sPiso='{$form['sPisoTitu']}',
							sDepartamento='{$form['sDepartamentoTitu']}',
							sBarrio='{$form['sBarrioTitu']}',
							sManzana='{$form['sManzanaTitu']}',
							sLote='{$form['sLoteTitu']}',
							sTelefonoParticularFijo='{$sTelefonoParticularFijo}',
							sTelefonoParticularCelular='{$sTelefonoParticularMovil}',
							idEmpresaCelular='{$form['idEmpresaCelularTitular']}',
							sMail='{$form['sMail']}',
							sTelefonoContacto='{$sTelefonoContacto}',
							sReferenciaContacto='{$form['sReferenciaContacto']}',
							idCondicionIva = '{$form['idCondicionIva']}',
							sGrupoTitu = '{$form['sGrupoTitu']}',
							sCasaTitu = '{$form['sCasaTitu']}',
							sMedidorTitu = '{$form['sMedidorTitu']}',
							sOtrosTitu = '{$form['sOtrosTitu']}'";
					//$oRespuesta->alert($setPers);
					$conditionsPers = "InformesPersonales.idSolicitudUsuario = '{$form['idSolicitud']}'";
					$ToAuditoryPers = "Modificacion de Informes Personales ::: User ={$_SESSION['id_user']} ::: idSolicitud={$form['idSolicitud']}";
					
					$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"InformesPersonales\",\"$setPers\",\"$conditionsPers\",\"{$_SESSION['id_user']}\",\"6\",\"$ToAuditoryPers\");",true);
					
					$setLab = "sRazonSocial='{$form['sRazonSocialLab']}',
			   				sCUITEmpleador='{$form['sCuitEmpleador']}',
			   				idCondicionAFIP='{$form['idCondicionAFIPLab']}',
			   				idCondicionLaboral='{$form['idCondicionLaboral']}',
			   				sReparticion='{$form['sReparticion']}',
			   				sActividad='{$form['sActividad']}',
			   				sCalle='{$form['sCalleLab']}',
			   				sNumeroCalle='{$form['sNumeroCalleLab']}',
			   				sBlock='{$form['sBlockLab']}',
			   				sPiso='{$form['sPisoLab']}',
			   				sOficina='{$form['sOficinaLab']}',
			   				sBarrio='{$form['sBarrioLab']}',
			   				sManzana='{$form['sManzanaLab']}',
			   				idProvincia='{$form['idProvinciaLab']}',
			   				idLocalidad='{$form['idLocalidadLab']}',
			   				sCodigoPostal='{$form['sCodigoPostalLab']}',
			   				sTelefonoLaboral1='{$sTelefonoLaboral1}',
			   				sInterno1='{$form['sInterno1']}',
			   				dFechaIngreso1='{$form['dFechaIngreso1']}',
			   				sCargo1='{$form['sCargo1']}',
			   				fIngresoNetoMensual1='{$form['fIngresoNetoMensual1']}',
			   				sTelefonoLaboral2='{$sTelefonoLaboral2}',
			   				sInterno2='{$form['sInterno2']}',
			   				dFechaIngreso2='{$form['dFechaIngreso2']}',
			   				sCargo2='{$form['sCargo2']}',
			   				fIngresoNetoMensual2='{$form['fIngresoNetoMensual2']}',
			   				sEmailLaboral = '{$form['sEmailLaboral']}', 
			   				idTiposDgr = '{$form['idTiposDgr']}', 
			   				idTiposImpositivas = '{$form['idTiposImpositivas']}'";
					// $oRespuesta->alert($setLab);
					$conditionsLab = "InformesLaborales.idSolicitudUsuario = '{$form['idSolicitud']}'";
					$ToAuditoryLab = "Modificacion de Informes Laborales ::: User ={$_SESSION['id_user']} ::: idSolicitud={$form['idSolicitud']}";
					$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"InformesLaborales\",\"$setLab\",\"$conditionsLab\",\"{$_SESSION['id_user']}\",\"8\",\"$ToAuditoryLab\");",true);
					$msje= "La Solicitud se modifico correctamente .\n ";
					
					//Ultima Modificacion con Funcion 04-06-2013 Lex concidero que se debe actualizar la informacion del cliente gx asociado a fin de actualizar la informacion relevante.
				
					if($form['hdnIdCliente'] >= 0) setDatosClienteGx($form);
				}
				
				//Fecha Modificacion: 14-03-2013
				//Modificar los datos del Cliente en la otra Base de Datos
				
				if($operacion == 2){
				 	$oRespuesta->redirect("AltaSolicitud.php?id=".$form['idSolicitud']."&idBIN=".$form['hdnIdBIN']."&sNumero=".$form['sNumero']);	
				}elseif( $operacion == 100){
					    if ($form['idSolicitud'] > 0){
					    	$idSolicitud = $form['idSolicitud'];
					    	//$form['sNumero']=;
					    }
						//se indica numero de cupon  premio ETC
						
						$sCadenaCupon=base64_encode($form['fPREMIO'].'@'.$form['iCUPON'].'@'.$form['fIMPORTECUOTA'].'@'.$form['bESTAXI']);
						
					 	$oRespuesta->redirect("AltaSolicitud.php?id=".$idSolicitud."&idBIN=1&sNumero=".$form['sNumero']."&pci=".$sCadenaCupon."&sCadenaAll=".$form['sCadenaAll']);	
				}else{	
					$oRespuesta->alert($msje);
					$oRespuesta->redirect($form['hdnUrlBack']);	
				}
				
			}
	}else{
		$oRespuesta->alert("La operacion no se pudo realizar, la sesion ha expirado. Intente cargar de nuevo la solicitud, ingresando de nuevo al sistema.");
	}
	
	return  $oRespuesta;
}

	function _marcarCAMBIOS($datos,$datos_formulario){
		global $oMysql;
		
		$tagIni = "<span style='color:#F00;font-weight:bold;'>";
		$tagFin = "</span>";
		$checkCAMBIO = false;
		
		if(!$datos){
			
		}else{
		
			$datos['sTipoDocumentoConyuge'] = $oMysql->consultaSel("SELECT sNombre FROM TiposDocumentos WHERE id={$datos_formulario['idTipoDocumentoConyuge']}",true);	
			$datos['sProvinciaResumen'] 	= $oMysql->consultaSel("SELECT sNombre FROM Provincias WHERE id={$datos_formulario['idProvinciaResumen']}",true);	
			$datos['sLocalidadResumen'] 	= $oMysql->consultaSel("SELECT sNombre FROM Localidades WHERE id={$datos_formulario['idLocalidadResumen']}",true);	
			$datos['sProvinciaLaboral'] 	= $oMysql->consultaSel("SELECT sNombre FROM Provincias WHERE id={$datos_formulario['idProvinciaLab']}",true);	
			$datos['sLocalidadLaboral'] 	= $oMysql->consultaSel("SELECT sNombre FROM Localidades WHERE id={$datos_formulario['idLocalidadLab']}",true);			
		
			#check datos de solicitud
			if($datos['dFechaPresentacion'] != $datos_formulario['dFechaPresentacion']){
				$datos['dFechaPresentacion'] = $tagIni . $datos_formulario['dFechaPresentacion'] . $tagFin ;
				$checkCAMBIO = true;
			}
			
			if($datos['dFechaSolicitud'] != $datos_formulario['dFechaSolicitud']){
				$datos['dFechaSolicitud'] = $tagIni . $datos_formulario['dFechaSolicitud'] . $tagFin ;
				$checkCAMBIO = true;
			}			
			
			if($datos['sNumero'] != $datos_formulario['sNumero']){
				$datos['sNumero'] = $tagIni . $datos_formulario['sNumero'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['idBIN'] != $datos_formulario['idBIN']){
				$datos['idBIN'] = $tagIni . $datos_formulario['idBIN'] . $tagFin ;
				$checkCAMBIO = true;
			}
			
			if($datos['idCanal'] != $datos_formulario['idCanal']){
				//$datos['idCanal'] = $tagIni . $datos['idCanal'] . $tagFin ;
				$datos['sCanal'] = $tagIni . $datos_formulario['sCanal'] . $tagFin ;
				$checkCAMBIO = true;
				
			}			

			if($datos['idPromotor'] != $datos_formulario['idPromotor']){
				//$datos['idPromotor'] = $tagIni . $datos['idPromotor'] . $tagFin ;
				$datos['sPromotor'] = $tagIni . $datos_formulario['sPromotor'] . $tagFin ;
				$checkCAMBIO = true;
			}
			
			#check datos de titular
			if($datos['sApellido'] != $datos_formulario['sApellido']){
				$datos['sApellido'] = $tagIni . $datos_formulario['sApellido'] . $tagFin ;
				$checkCAMBIO = true;
			}
			
			if($datos['sNombre'] != $datos_formulario['sNombre']){
				$datos['sNombre'] = $tagIni . $datos_formulario['sNombre'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['idEstadoCivil'] != $datos_formulario['idEstadoCivil']){
				//$datos['idEstadoCivil'] = $tagIni . $datos['idEstadoCivil'] . $tagFin ;
				$datos['sEstadoCivil'] = $tagIni . $datos_formulario['sEstadoCivil'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['idNacionalidad'] != $datos_formulario['idNacionalidad']){
				//$datos['idNacionalidad'] = $tagIni . $datos['idNacionalidad'] . $tagFin ;
				$datos['sNacionalidad'] = $tagIni . $datos_formulario['sNacionalidad'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sRazonSocial'] != $datos_formulario['sRazonSocial']){
				$datos['sRazonSocial'] = $tagIni . $datos_formulario['sRazonSocial'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['idTipoDocumento'] != $datos_formulario['idTipoDocumento']){
				//$datos['idTipoDocumento'] = $tagIni . $datos['idTipoDocumento'] . $tagFin ;
				$datos['sTipoDocumento'] = $tagIni . $datos_formulario['sTipoDocumento'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sDocumento'] != $datos_formulario['sDocumento']){
				$datos['sDocumento'] = $tagIni . $datos_formulario['sDocumento'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sCUIT'] != $datos_formulario['sCuit']){
				$datos['sCUIT'] = $tagIni . $datos_formulario['sCUIT'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['dFechaNacimiento'] != $datos_formulario['dFechaNacimiento']){
				$datos['dFechaNacimiento'] = $tagIni . $datos_formulario['dFechaNacimiento'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['idSexo'] != $datos_formulario['idSexo']){
				//$datos['idSexo'] = $tagIni . $datos['idSexo'] . $tagFin ;
				$datos['sSexo'] = $tagIni . $datos_formulario['sSexo'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sApellidoConyuge'] != $datos_formulario['sApellidoConyuge']){
				$datos['sApellidoConyuge'] = $tagIni . $datos_formulario['sApellidoConyuge'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sNombreConyuge'] != $datos_formulario['sNombreConyuge']){
				$datos['sNombreConyuge'] = $tagIni . $datos_formulario['sNombreConyuge'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['idTipoDocumentoConyuge'] != $datos_formulario['idTipoDocumentoConyuge']){
				//$datos['idTipoDocumentoConyuge'] = $tagIni . $datos['idTipoDocumentoConyuge'] . $tagFin ;
				$datos['sTipoDocumentoConyuge'] = $tagIni . $datos_formulario['sTipoDocumentoConyuge'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sDocumentoConyuge'] != $datos_formulario['sDocumentoConyuge']){
				$datos['sDocumentoConyuge'] = $tagIni . $datos_formulario['sDocumentoConyuge'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['iHijos'] != $datos_formulario['iHijos']){
				$datos['iHijos'] = $tagIni . $datos_formulario['iHijos'] . $tagFin ;
				$checkCAMBIO = true;
			}			
			

			#check datos de domicilio
			if($datos['idProvincia'] != $datos_formulario['idProvinciaTitu']){
				//$datos['idProvincia'] = $tagIni . $datos['idProvincia'] . $tagFin ;
				$datos['sProvincias'] = $tagIni . $datos_formulario['sProvincias'] . $tagFin ;
				$checkCAMBIO = true;
			}
			
			if($datos['idLocalidad'] != $datos_formulario['idLocalidadTitu']){
				//$datos['idLocalidad'] = $tagIni . $datos['idLocalidad'] . $tagFin ;
				$datos['sLocalidad'] = $tagIni . $datos_formulario['sLocalidad'] . $tagFin ;
				$checkCAMBIO = true;
			}
						
			if($datos['sCodigoPostal'] != $datos_formulario['sCodigoPostalTitu']){
				$datos['sCodigoPostal'] = $tagIni . $datos_formulario['sCodigoPostal'] . $tagFin ;				
				$checkCAMBIO = true;
			}

			if($datos['sCalle'] != $datos_formulario['sCalleTitu']){
				$datos['sCalle'] = $tagIni . $datos_formulario['sCalle'] . $tagFin ;
				$checkCAMBIO = true;
			}
			
			if($datos['sNumeroCalle'] != $datos_formulario['sNumeroCalleTitu']){
				$datos['sNumeroCalle'] = $tagIni . $datos_formulario['sNumeroCalle'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sBlock'] != $datos_formulario['sBlockTitu']){
				$datos['sBlock'] = $tagIni . $datos_formulario['sBlock'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sPiso'] != $datos_formulario['sPisoTitu']){
				$datos['sPiso'] = $tagIni . $datos_formulario['sPiso'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sDepartamento'] != $datos_formulario['sDepartamentoTitu']){
				$datos['sDepartamento'] = $tagIni . $datos_formulario['sDepartamento'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sEntreCalle'] != $datos_formulario['sEntreCalleTitu']){
				$datos['sEntreCalle'] = $tagIni . $datos_formulario['sEntreCalle'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sBarrio'] != $datos_formulario['sBarrioTitu']){
				$datos['sBarrio'] = $tagIni . $datos_formulario['sBarrio'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sManzana'] != $datos_formulario['sManzanaTitu']){
				$datos['sManzana'] = $tagIni . $datos_formulario['sManzana'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sLote'] != $datos_formulario['sLoteTitu']){
				$datos['sLote'] = $tagIni . $datos_formulario['sLote'] . $tagFin ;
				$checkCAMBIO = true;
			}	
			
			#check datos Envio resumen
			if($datos['idProvinciaResumen'] != $datos_formulario['idProvinciaResumen']){
				//$datos['idProvinciaResumen'] = $tagIni . $datos['idProvinciaResumen'] . $tagFin ;
				$datos['sProvinciaResumen'] = $tagIni . $datos_formulario['sProvinciaResumen'] . $tagFin ;
				$checkCAMBIO = true;
			}
			
			if($datos['idLocalidadResumen'] != $datos_formulario['idLocalidadResumen']){
				//$datos['idLocalidadResumen'] = $tagIni . $datos['idLocalidadResumen'] . $tagFin ;
				$datos['sLocalidadResumen'] = $tagIni . $datos_formulario['sLocalidadResumen'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sCodigoPostalResumen'] != $datos_formulario['sCodigoPostalResumen']){
				$datos['sCodigoPostalResumen'] = $tagIni . $datos_formulario['sCodigoPostalResumen'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sCalleResumen'] != $datos_formulario['sCalleResumen']){
				$datos['sCalleResumen'] = $tagIni . $datos_formulario['sCalleResumen'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sNumeroCalleResumen'] != $datos_formulario['sNumeroCalleResumen']){
				$datos['sNumeroCalleResumen'] = $tagIni . $datos_formulario['sNumeroCalleResumen'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sBlockResumen'] != $datos_formulario['sBlockResumen']){
				$datos['sBlockResumen'] = $tagIni . $datos_formulario['sBlockResumen'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sPisoResumen'] != $datos_formulario['sPisoResumen']){
				$datos['sPisoResumen'] = $tagIni . $datos_formulario['sPisoResumen'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sDepartamentoResumen'] != $datos_formulario['sDepartamentoResumen']){
				$datos['sDepartamentoResumen'] = $tagIni . $datos_formulario['sDepartamentoResumen'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sEntreCalleResumen'] != $datos_formulario['sEntreCalleResumen']){
				$datos['sEntreCalleResumen'] = $tagIni . $datos_formulario['sEntreCalleResumen'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sBarrioResumen'] != $datos_formulario['sBarrioResumen']){
				$datos['sBarrioResumen'] = $tagIni . $datos_formulario['sBarrioResumen'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sManzanaResumen'] != $datos_formulario['sManzanaResumen']){
				$datos['sManzanaResumen'] = $tagIni . $datos_formulario['sManzanaResumen'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sLoteResumen'] != $datos_formulario['sLoteResumen']){
				$datos['sLoteResumen'] = $tagIni . $datos_formulario['sLoteResumen'] . $tagFin ;
				$checkCAMBIO = true;
			}

			#check datos Laborales
			$telefono_laboral1 = $datos_formularios['sTelLaboral1Prefijo'].'-'.$datos_formularios['sTelLaboral1Numero'];
			$telefono_laboral2 = $datos_formularios['sTelLaboral2Prefijo'].'-'.$datos_formularios['sTelLaboral2Numero'];

			if($datos['sRazonSocialLab'] != $datos_formulario['sRazonSocialLab']){
				$datos['sRazonSocialLab'] = $tagIni . $datos_formulario['sRazonSocialLab'] . $tagFin ;
				$checkCAMBIO = true;
			}			
			
			if($datos['sCUITEmpleador'] != $datos_formulario['sCuitEmpleador']){
				$datos['sCUITEmpleador'] = $tagIni . $datos_formulario['sCUITEmpleador'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['idCondicionAFIPLab'] != $datos_formulario['idCondicionAFIPLab']){
				//$datos['idCondicionAFIPLab'] = $tagIni . $datos['idCondicionAFIPLab'] . $tagFin ;
				$datos['sCondicionAFIP'] = $tagIni . $datos_formulario['sCondicionAFIP'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['idCondicionLaboral'] != $datos_formulario['idCondicionLaboral']){
				//$datos['idCondicionLaboral'] = $tagIni . $datos['idCondicionLaboral'] . $tagFin ;
				$datos['sCondicionLaboral'] = $tagIni . $datos_formulario['sCondicionLaboral'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sReparticion'] != $datos_formulario['sReparticion']){
				$datos['sReparticion'] = $tagIni . $datos_formulario['sReparticion'] . $tagFin ;
				$checkCAMBIO = true;
			}
								
			if($datos['sActividad'] != $datos_formulario['sActividad']){
				$datos['sActividad'] = $tagIni . $datos_formulario['sActividad'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sCalleLab'] != $datos_formulario['sCalleLab']){
				$datos['sCalleLab'] = $tagIni . $datos_formulario['sCalleLab'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sNumeroCalleLab'] != $datos_formulario['sNumeroCalleLab']){
				$datos['sNumeroCalleLab'] = $tagIni . $datos_formulario['sNumeroCalleLab'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sBlockLab'] != $datos_formulario['sBlockLab']){
				$datos['sBlockLab'] = $tagIni . $datos_formulario['sBlockLab'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sPisoLab'] != $datos_formulario['sPisoLab']){
				$datos['sPisoLab'] = $tagIni . $datos_formulario['sPisoLab'] . $tagFin ;
				$checkCAMBIO = true;
			}
			
			if($datos['sOficinaLab'] != $datos_formulario['sOficinaLab']){
				$datos['sOficinaLab'] = $tagIni . $datos_formulario['sOficinaLab'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sBarrioLab'] != $datos_formulario['sBarrioLab']){
				$datos['sBarrioLab'] = $tagIni . $datos_formulario['sBarrioLab'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sManzanaLab'] != $datos_formulario['sManzanaLab']){
				$datos['sManzanaLab'] = $tagIni . $datos_formulario['sManzanaLab'] . $tagFin ;
				$checkCAMBIO = true;
			}					
			
			if($datos['idProvinciaLab'] != $datos_formulario['idProvinciaLab']){
				//$datos['idProvinciaLab'] = $tagIni . $datos['idProvinciaLab'] . $tagFin ;
				$datos['sProvinciaLaboral'] = $tagIni . $datos_formulario['sProvinciaLaboral'] . $tagFin ;
				$checkCAMBIO = true;
			}			
			
			if($datos['idLocalidadLab'] != $datos_formulario['idLocalidadLab']){
				//$datos['idLocalidadLab'] = $tagIni . $datos['idLocalidadLab'] . $tagFin ;
				$datos['sLocalidadLaboral'] = $tagIni . $datos_formulario['sLocalidadLaboral'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sCodigoPostalLab'] != $datos_formulario['sCodigoPostalLab']){
				$datos['sCodigoPostalLab'] = $tagIni . $datos_formulario['sCodigoPostalLab'] . $tagFin ;
				$checkCAMBIO = true;
			}

			$datos['dFechaIngreso1'] = dateToMySql($datos['dFechaIngreso1']); 
			$datos['dFechaIngreso2'] = dateToMySql($datos['dFechaIngreso2']); 
			
			if($datos['sTelefonoLaboral1'] != $telefono_laboral1){
				$datos['sTelefonoLaboral1'] = $tagIni . $datos_formulario['sTelefonoLaboral1'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sInterno1'] != $datos_formulario['sInterno1']){
				$datos['sInterno1'] = $tagIni . $datos_formulario['sInterno1'] . $tagFin ;
				$checkCAMBIO = true;
			}
			//var_export($datos['dFechaIngreso1'] .'-'. $datos_formulario['dFechaIngreso1']);die();
			if($datos['dFechaIngreso1'] != $datos_formulario['dFechaIngreso1']){
				$datos['dFechaIngreso1'] = $tagIni . $datos_formulario['dFechaIngreso1'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sCargo1'] != $datos_formulario['sCargo1']){
				$datos['sCargo1'] = $tagIni . $datos_formulario['sCargo1'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['fIngresoNetoMensual1'] != $datos_formulario['fIngresoNetoMensual1']){
				$datos['fIngresoNetoMensual1'] = $tagIni . $datos_formulario['fIngresoNetoMensual1'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sTelefonoLaboral2'] != $telefono_laboral2){
				$datos['sTelefonoLaboral2'] = $tagIni . $datos_formulario['sTelefonoLaboral2'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sInterno2'] != $datos_formulario['sInterno2']){
				$datos['sInterno2'] = $tagIni . $datos_formulario['sInterno2'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['dFechaIngreso2'] != $datos_formulario['dFechaIngreso2']){
				$datos['dFechaIngreso2'] = $tagIni . $datos_formulario['dFechaIngreso2'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sCargo2'] != $datos_formulario['sCargo2']){
				$datos['sCargo2'] = $tagIni . $datos_formulario['sCargo2'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['fIngresoNetoMensual2'] != $datos_formulario['fIngresoNetoMensual2']){
				$datos['fIngresoNetoMensual2'] = $tagIni . $datos_formulario['fIngresoNetoMensual2'] . $tagFin ;
				$checkCAMBIO = true;
			}

			#check datos Otros Datos
			$telefono_particular_fijo = $datos_formularios['sTelParticularFijoPrefijo'].'-'.$datos_formularios['sTelParticularFijoNumero'];			
			$telefono_particular_celular = $datos_formularios['sTelParticularMovilPrefijo'].'-'.$datos_formularios['sTelParticularMovilNumero'];			
			$telefono_contacto = $datos_formularios['sTelContactoPrefijo'].'-'.$datos_formularios['sTelContactoNumero'];			
			
			if($datos['sTelefonoParticularFijo'] != $telefono_particular_fijo){
				$datos['sTelefonoParticularFijo'] = $tagIni . $telefono_particular_fijo . $tagFin ;
				$checkCAMBIO = true;
			}
			
			if($datos['sTelefonoParticularCelular'] != $telefono_particular_celular){
				$datos['sTelefonoParticularCelular'] = $tagIni . $telefono_particular_celular . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['idEmpresaCelular'] != $datos_formulario['idEmpresaCelularTitular']){
				//$datos['idEmpresaCelular'] = $tagIni . $datos['idEmpresaCelular'] . $tagFin ;
				$datos['sEmpresaCelular'] = $tagIni . $datos['sEmpresaCelular'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sMail'] != $datos_formulario['sMail']){
				$datos['sMail'] = $tagIni . $datos_formulario['sMail'] . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sTelefonoContacto'] != $telefono_contacto){
				$datos['sTelefonoContacto'] = $tagIni . $telefono_contacto . $tagFin ;
				$checkCAMBIO = true;
			}

			if($datos['sReferenciaContacto'] != $datos_formulario['sReferenciaContacto']){
				$datos['sReferenciaContacto'] = $tagIni . $datos_formulario['sReferenciaContacto'] . $tagFin ;
				$checkCAMBIO = true;
			}
			
		}
		
		$datos['check_status'] = $checkCAMBIO ;
		
		return $datos;
	}

	function _mandarEMAILSOLICITUDES($solicitudes,$datos_formulario){
	
		$solicitudes = _marcarCAMBIOS($solicitudes,$datos_formulario);
		$usar_clase_mail = 0;
		
		if($solicitudes['check_status'] == true){#envio email
		
			$to = "info@empresa.com";
			
			$from = "info@empresa.com";
			
			$subject = "Notificacion de Edicion en Solicitud :{$solicitudes['sNumero']}";
		
			if($usar_clase_mail == 0){
			
				$xhtml = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Solicitudes/FormatoEmail.tpl",$solicitudes);
				
				//$xhtml = html_entity_decode($xhtml);
				//var_export($xhtml);die();
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Additional headers
				$headers .= 'To: - <'.$to.'>' . "\r\n";
				$headers .= 'From: Departamento de Administracion <'.$from.'>' . "\r\n";
				
				//$send = mail($to, $subject, $body, $headers);
				$send = mail($to, $subject, $xhtml, $headers);				
			}else{
				//$aDatos['idUsuario']=$idUser;
				
				$xhtml = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Solicitudes/FormatoEmail.tpl",$solicitudes);
				
				$sMail = new email();
				
				$sMail->inicializar($to,$from,"");
				
				$sMail->setAsunto($subject);
				
				$sMail->insertarTextoHTML($xhtml);
				
				$send = $sMail->enviar();
				//if($_SESSION['id_user']==296) var_export($send);
			}

		}
		
	
	}

	function _checkDatosDomicilios($datos,$datos_formulario){
		
		$checkDatosDomicilios = false;
		
		if(!$datos){
			
		}else{
		
			if($datos['idProvincia'] != $datos_formulario['idProvinciaTitu']){
				$checkDatosDomicilios = true;	
			}
			
			if($datos['idLocalidad'] != $datos_formulario['idLocalidadTitu']){
				$checkDatosDomicilios = true;	
			}
						
			if($datos['sCodigoPostal'] != $datos_formulario['sCodigoPostalTitu']){
				$checkDatosDomicilios = true;	
			}

			if($datos['sCalle'] != $datos_formulario['sCalleTitu']){
				$checkDatosDomicilios = true;	
			}
			
		
			if($datos['sNumeroCalle'] != $datos_formulario['sNumeroCalleTitu']){
				$checkDatosDomicilios = true;	
			}

			if($datos['sBlock'] != $datos_formulario['sBlockTitu']){
				$checkDatosDomicilios = true;	
			}

			if($datos['sPiso'] != $datos_formulario['sPisoTitu']){
				$checkDatosDomicilios = true;	
			}

			if($datos['sDepartamento'] != $datos_formulario['sDepartamentoTitu']){
				$checkDatosDomicilios = true;	
			}

			if($datos['sEntreCalle'] != $datos_formulario['sEntreCalleTitu']){
				$checkDatosDomicilios = true;	
			}

			if($datos['sBarrio'] != $datos_formulario['sBarrioTitu']){
				$checkDatosDomicilios = true;	
			}

			if($datos['sManzana'] != $datos_formulario['sManzanaTitu']){
				$checkDatosDomicilios = true;	
			}

			if($datos['sLote'] != $datos_formulario['sLoteTitu']){
				$checkDatosDomicilios = true;	
			}					
			
		}
		
		return $checkDatosDomicilios;
	}

	function _insertDomiciliosUsuario($datos){
		global $oMysql;
		
		$set = "
				idUsuario,
				idTipoDomicilio,
				idProvincia,
				idLocalidad,
				sCodigoPostal,
				sCalle,
				sNumeroCalle,
				sPiso,
				sBlock,
				sDepartamento,
				sManzana,
				sLote,
				sEntreCalles,
				sOtrosDatos,
				sEstado,
				sBarrio
		";
		
		$values = "
					{$datos['idUsuario']},
					1,
					{$datos['idProvinciaTitu']},
					{$datos['idLocalidadTitu']},
					'{$datos['sCodigoPostalTitu']}',
					'{$datos['sCalleTitu']}',
					'{$datos['sNumeroCalleTitu']}',
					'{$datos['sPisoTitu']}',
					'{$datos['sBlockTitu']}',
					'{$datos['sDepartamentoTitu']}',
					'{$datos['sManzanaTitu']}',
					'{$datos['sLoteTitu']}',
					'{$datos['sEntreCalleTitu']}',
					'{$datos['sOtrosDatos']}',
					'A',
					'{$datos['sBarrioTitu']}'
				  ";
	   
	   $toauditory = "insercion en DomiciliosUsuarios ::: User ={$_SESSION['id_user']} ::: idSolicitud={$idSolicitud}";
	   $id = $oMysql->consultaSel("CALL usp_InsertTable(\"DomiciliosUsuarios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");",true);
		   
		   
	}	
	
	function _checkDatosLaborales($datos,$datos_formularios){
		
		$checkDatosLaborales = false;
		
		if(!$datos){
			
		}else{

			$telefono_laboral1 = $datos_formularios['sTelLaboral1Prefijo'].'-'.$datos_formularios['sTelLaboral1Numero'];
			$telefono_laboral2 = $datos_formularios['sTelLaboral2Prefijo'].'-'.$datos_formularios['sTelLaboral2Numero'];

			if($datos['sRazonSocialLab'] != $datos_formulario['sRazonSocialLab']){
				$checkDatosLaborales = true;	
			}			
			
			if($datos['sCUITEmpleador'] != $datos_formulario['sCuitEmpleador']){
				$checkDatosLaborales = true;	
			}

			if($datos['idCondicionAFIPLab'] != $datos_formulario['idCondicionAFIPLab']){
				$checkDatosLaborales = true;	
			}

			if($datos['idCondicionLaboral'] != $datos_formulario['idCondicionLaboral']){
				$checkDatosLaborales = true;	
			}

			if($datos['sReparticion'] != $datos_formulario['sReparticion']){
				$checkDatosLaborales = true;	
			}
								
			if($datos['sActividad'] != $datos_formulario['sActividad']){
				$checkDatosLaborales = true;	
			}

			if($datos['sCalleLab'] != $datos_formulario['sCalleLab']){
				$checkDatosLaborales = true;	
			}

			if($datos['sNumeroCalleLab'] != $datos_formulario['sNumeroCalleLab']){
				$checkDatosLaborales = true;	
			}

			if($datos['sBlockLab'] != $datos_formulario['sBlockLab']){
				$checkDatosLaborales = true;	
			}

			if($datos['sPisoLab'] != $datos_formulario['sPisoLab']){
				$checkDatosLaborales = true;	
			}
			
			if($datos['sOficinaLab'] != $datos_formulario['sOficinaLab']){
				$checkDatosLaborales = true;	
			}

			if($datos['sBarrioLab'] != $datos_formulario['sBarrioLab']){
				$checkDatosLaborales = true;	
			}

			if($datos['sManzanaLab'] != $datos_formulario['sManzanaLab']){
				$checkDatosLaborales = true;	
			}					
			
			if($datos['idProvinciaLab'] != $datos_formulario['idProvinciaLab']){
				$checkDatosLaborales = true;	
			}			
			
			if($datos['idLocalidadLab'] != $datos_formulario['idLocalidadLab']){
				$checkDatosLaborales = true;	
			}

			if($datos['sCodigoPostalLab'] != $datos_formulario['sCodigoPostalLab']){
				$checkDatosLaborales = true;	
			}

			$datos['dFechaIngreso1'] = dateToMySql($datos['dFechaIngreso1']); 
			$datos['dFechaIngreso2'] = dateToMySql($datos['dFechaIngreso2']); 
			
			if($datos['sTelefonoLaboral1'] != $telefono_laboral1){
				$checkDatosLaborales = true;	
			}

			if($datos['sInterno1'] != $datos_formulario['sInterno1']){
				$checkDatosLaborales = true;	
			}
								
			if($datos['dFechaIngreso1'] != $datos_formulario['dFechaIngreso1']){
				$checkDatosLaborales = true;	
			}

			if($datos['sCargo1'] != $datos_formulario['sCargo1']){
				$checkDatosLaborales = true;	
			}

			if($datos['fIngresoNetoMensual1'] != $datos_formulario['fIngresoNetoMensual1']){
				$checkDatosLaborales = true;	
			}

			if($datos['sTelefonoLaboral2'] != $telefono_laboral2){
				$checkDatosLaborales = true;	
			}

			if($datos['sInterno2'] != $datos_formulario['sInterno2']){
				$checkDatosLaborales = true;	
			}

			if($datos['dFechaIngreso2'] != $datos_formulario['dFechaIngreso2']){
				$checkDatosLaborales = true;	
			}

			if($datos['sCargo2'] != $datos_formulario['sCargo2']){
				$checkDatosLaborales = true;	
			}

			if($datos['fIngresoNetoMensual2'] != $datos_formulario['fIngresoNetoMensual2']){
				$checkDatosLaborales = true;	
			}			
			
		}
		
		return $checkDatosLaborales;		
	}
	
	function _insertDatosLaborales($datos){
		global $oMysql;
		
			$telefono_laboral1 = $datos['sTelLaboral1Prefijo'].'-'.$datos['sTelLaboral1Numero'];
			$telefono_laboral2 = $datos['sTelLaboral2Prefijo'].'-'.$datos['sTelLaboral2Numero'];		
		
		$set = "
				idUsuario,
				idCondicionLaboral,
				idCondicionAFIP,
				sCargo,
				sRazonSocial,
				sCuit,
				sCalle,
				sNumeroCalle,
				sActividad,
				fIngresoBrutoDGR,
				sEstado,
				
				sReparticion,
				sBlock,
				sPiso,
				sOficina,
				sBarrio,
				sManzana,
				sLote,
				idProvincia,
				idLocalidad,
				sCodigoPostal,
				sTelefonoLaboral1,
				sInterno1,
				dFehaIngreso1,
				sCargo1,
				fIngresoNetoMensual1,
				sTelefonoLaboral2,
				sInterno2,
				dFechaIngreso2,
				sCargo2,
				fIngresoNetoMensual2
			  ";
		
		$values = "
				{$datos['idUsuario']},
				{$datos['idCondicionLaboral']},
				{$datos['idCondicionAFIPLab']},
				'{$datos['sCargo1']}',
				'{$datos['sRazonSocialLab']}',
				'{$datos['sCuitEmpleador']}',
				'{$datos['sCalleLab']}',
				'{$datos['sNumeroCalleLab']}',
				'{$datos['sActividad']}',
				'{$datos['fIngresoNetoMensual1']}',
				'A',
				'{$datos['sReparticionLab']}',
				'{$datos['sBlockLab']}',
				'{$datos['sPisoLab']}',
				'{$datos['sOficinaLab']}',
				'{$datos['sBarrioLab']}',
				'{$datos['sManzanaLab']}',
				's/n',
				'{$datos['idProvinciaLab']}',
				'{$datos['idLocalidadLab']}',
				'{$datos['sCodigoPostalLab']}',
				'{$telefono_laboral1}',
				'{$datos['sInterno1']}',
				'{$datos['dFechaIngreso1']}',
				'{$datos['sCargo1']}',
				'{$datos['fIngresoNetoMensual1']}',
				'{$telefono_laboral2}',				
				'{$datos['sInterno2']}',
				'{$datos['dFechaIngreso2']}',
				'{$datos['sCargo2']}',
				'{$datos['fIngresoNetoMensual2']}'
				  ";
		
	   $toauditory = "insercion en DatosLaborales ::: User ={$_SESSION['id_user']} ::: idSolicitud={$idSolicitud}";
	   //var_export("CALL usp_InsertTable(\"DatosLaborales\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");");die();
	   $id = $oMysql->consultaSel("CALL usp_InsertTable(\"DatosLaborales\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");",true);		
	}	
	
	function _updateDataUsuarios($datos){
		global $oMysql;
				
		$set = "
				iTipoPersona='{$datos['rdbTipoPersona']}',
				sNombre='{$datos['sNombre']}',
				sApellido='{$datos['sApellido']}',
				idEstadoCivil='{$datos['idEstadoCivil']}',
				idNacionalidad='{$datos['idNacionalidad']}',
				sRazonSocial='{$datos['sRazonSocial']}',
				idTipoDocumento='{$datos['idTipoDocumento']}',
				sDocumento='{$datos['sDocumento']}',
				sCUIT='{$datos['sCuit']}',
				dFechaNacimiento='{$datos['dFechaNacimiento']}',
				idTipoSexo='{$datos['idSexo']}',
				sApellidoConyuge='{$datos['sApellidoConyuge']}',
				sNombreConyuge='{$datos['sNombreConyuge']}',
				idTipoDocumentoConyuge='{$datos['idTipoDocumentoConyuge']}',
				sDocumentoConyuge='{$datos['sDocumentoConyuge']}',
				iHijos='{$datos['iHijos']}'
			  ";
		
		$values = "Usuarios.id='{$datos['idUsuario']}'";
		
	   $toauditory = "actualizacion de Datos en Usuarios ::: User ={$_SESSION['id_user']} ::: idSolicitud={$datos['idSolicitud']}";
	   

	   
	   $id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Usuarios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"0\",\"$toauditory\");",true);		
	}		


	function updateEstadoSolicitud($form){
	    GLOBAL $oMysql;
	    $oRespuesta = new xajaxResponse();   
		$form['sMotivo'] = convertir_especiales_html($form['sMotivo']);
		
	    //$oRespuesta->alert($form['idSolicitud']. " " . " Estado " . $form['idEstado']);
	       
	    $set = "SolicitudesUsuarios.idTipoEstado = '{$form['idTipoEstado']}'";
	    $conditions = "SolicitudesUsuarios.id = '{$form['idSolicitud']}'";
		$ToAuditory = "Update Estado Solicitudes ::: User ={$_SESSION['id_user']} ::: idSolicitud={$form['idSolicitud']} ::: estado={$form['idTipoEstado']}";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"SolicitudesUsuarios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"9\",\"$ToAuditory\");",true);   
		
		$setEstado = "idSolicitud,idEmpleado,idTipoEstadoSolicitud,dFechaRegistro,sMotivo";
		$valuesEstado = "'{$form['idSolicitud']}','{$_SESSION['id_user']}','{$form['idTipoEstado']}',NOW(),'{$form['sMotivo']}'";
		$ToAuditoryEstado = "Insercion Historial de Estados Solicitudes ::: User ={$_SESSION['id_user']} ::: idSolicitud={$form['idSolicitud']} ::: estado={$form['idTipoEstado']}";
		$idEstado = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosSolicitudes\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"9\",\"$ToAuditoryEstado\");",true);   
		 
		$oRespuesta->alert("La operacion se realizo correctamente");
    	
	    $oRespuesta->script('closeMessage();');
	    $oRespuesta->script("window.parent.frames[5].location.href = '../Solicitudes/Solicitudes.php';");
		return $oRespuesta;
	}	
	
	function altaSolicitud($form){
		GLOBAL $oMysql;
		
		
	    $oRespuesta = new xajaxResponse();   
	    $set = "idGrupoAfinidad,idSolicitud,idBIN,idEmpleado,sNumeroCuenta,fTasaSobreMargen,dFechaRegistro,idTipoEstadoCuenta";	    
	    $values = "'{$form['idGrupoAfinidad']}','{$form['idSolicitud']}','{$form['hdnIdBIN']}','{$_SESSION['id_user']}','{$form['sNumero']}','{$form['hdnTasaSobreMargen']}',NOW(),1";	    
	    $ToAuditory = "Insercion de una Cuenta de Usuario ::: Empleado ={$_SESSION['id_user']} ::: idSolicitud ={$form['idSolicitud']}";
	    $idCuenta = $oMysql->consultaSel("CALL usp_InsertTable(\"CuentasUsuarios\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"22\",\"$ToAuditory\");",true); 	    
	    //$oRespuesta->alert("idCuenta = ".$idCuenta);	
	    
	    $setEstado = "idCuentaUsuario,idEmpleado,idTipoEstadoCuenta,dFechaRegistro";
	    $valuesEstado = "{$idCuenta},{$_SESSION['id_user']},1,NOW()";	    
	    $idEstadoCuenta = $oMysql->consultaSel("CALL usp_InsertValues(\"EstadosCuentas\",\"$setEstado\",\"$valuesEstado\");",true); 

	    $setLimite = "idLimiteEstandar,idEmpleado,idCuentaUsuario,dFechaRegistro";
	    $valuesLimite = "{$form['idLimite']},{$_SESSION['id_user']},{$idCuenta},NOW()";	    
	    $idCuentaLimite= $oMysql->consultaSel("CALL usp_InsertValues(\"CuentasLimites\",\"$setLimite\",\"$valuesLimite\");",true); 
		
		$form['hdnFechaVencimiento'] =  dateToMySql($form['hdnFechaVencimiento']);
		$form['hdnFechaCierre'] = dateToMySql($form['hdnFechaCierre']);
		$form['hdnPeriodo'] = dateToMySql($form['hdnPeriodo']);
		$form['hdnFechaMora'] = dateToMySql($form['hdnFechaMora']);
	
		$setDetalle = "idCuentaUsuario,idIVA,idModeloResumen,
			fAcumuladoConsumoCuota,fAcumuladoConsumoUnPago,fAcumuladoPrestamo,
			fImporteTotalPesos,fImporteTotalDolar,fImporteMinimoAnterior,fImporteMinimoActual,
			fInteresPunitorio,fInteresCompensatorio,fInteresFinanciacion,
			fLimiteCompra,fLimiteCredito,fLimiteFinanciacion,fLimiteAdelanto,fLimitePrestamo,fLimiteGlobal,
			fRemanenteGlobal,fRemanenteCompra,fRemanenteCredito,fRemanenteAdelanto,fRemanentePrestamo,
			fSaldoAnterior,
			dFechaCierre,dFechaVencimiento,
			sEstado,
			iDiasMora,
			dPeriodo,
			fTasaPunitorioPeso,fTasaFinanciacionPeso,fTasaCompensatorioPeso,fTasaFinanciacionDolar,fTasaPunitorioDolar,fTasaCompensacionDolar,
			fAcumuladoAdelanto,fAcumuladoCobranza,fAcumuladoCredito,fAcumuladoDebito,fAcumuladoAutorizacionCuota,fAcumuladoAutorizacionUnPago,fAcumuladoAutorizacionAdelanto,iEmiteResumen,dFechaRegistro,dFechaMora";
		
		$valuesDetalle = "'{$idCuenta}',1,1,
			0,0,0,
			0,0,0,0,
			0,0,0,
			'{$form['hdnLimiteCompra']}','{$form['hdnLimiteCredito']}','{$form['hdnLimiteFinanciacion']}','{$form['hdnLimiteAdelanto']}','{$form['hdnLimitePrestamo']}','{$form['hdnLimiteGlobal']}',
			'{$form['hdnLimiteGlobal']}','{$form['hdnLimiteCompra']}','{$form['hdnLimiteCredito']}','{$form['hdnLimiteAdelanto']}','{$form['hdnLimitePrestamo']}',
			0,					
			'{$form['hdnFechaCierre']}','{$form['hdnFechaVencimiento']}',
			'NORMAL',
			0,
			'{$form['hdnPeriodo']}',
			'{$form['hdnTasaPunitorioPeso']}','{$form['hdnTasaFinanciacionPeso']}','{$form['hdnTasaCompensatorioPeso']}','{$form['hdnTasaFinanciacionDolar']}','{$form['hdnTasaPunitorioDolar']}','{$form['hdnTasaCompensacionDolar']}',
			0,0,0,0,0,0,0,0,NOW(),'{$form['hdnFechaMora']}'";
		//$oRespuesta->alert("valores = ".$valuesDetalle);	
		$ToAuditoryDetalle = "Insercion de un Detalle  Cuenta de Usuario ::: Empleado ={$_SESSION['id_user']} ::: idCuentaUsuario ={$idCuenta}";
	  	$idDetalleCuenta = $oMysql->consultaSel("CALL usp_InsertTable(\"DetallesCuentasUsuarios\",\"$setDetalle\",\"$valuesDetalle\",\"{$_SESSION['id_user']}\",\"24\",\"$ToAuditoryDetalle\");",true); 
	  	//$oRespuesta->alert("idDetalleCuenta = ".$idDetalleCuenta);	
	  	
	  	$sCondiciones = " WHERE SolicitudesUsuarios.id = {$form['idSolicitud']}";
		$sqlDatos="Call usp_getSolicitudes(\"$sCondiciones\");";	
		$rs = $oMysql->consultaSel($sqlDatos,true);
		
		$rs['dFechaNacimiento'] = dateToMySql($rs['dFechaNacimiento']);
		//idTipoUsuario =1 es TITULAR
	  	$setUsuario="idTipoUsuario,idTipoDocumento,idNacionalidad,idEstadoCivil,idTipoSexo,idSolicitudCliente,sNombre,sApellido,sRazonSocial,dFechaNacimiento,sCUIT,sDocumento,sNumeroTarjeta,sMail,sEstado,iTipoPersona,sNombreConyuge,sApellidoConyuge,idTipoDocumentoConyuge,sDocumentoConyuge,iHijos";
	  	$valuesUsuario = "1,'{$rs['idTipoDocumento']}','{$rs['idNacionalidad']}','{$rs['idEstadoCivil']}','{$rs['idSexo']}','{$form['idSolicitud']}','{$rs['sNombre']}','{$rs['sApellido']}','{$rs['sRazonSocial']}','{$rs['dFechaNacimiento']}','{$rs['sCUIT']}','{$rs['sDocumento']}','{$form['sNumero']}','{$rs['sMail']}','A','{$rs['iTipoPersona']}','{$rs['sNombreConyuge']}','{$rs['sApellidoConyuge']}','{$rs['idTipoDocumentoConyuge']}','{$rs['sDocumentoConyuge']}','{$rs['iHijos']}'";
	  	$ToAuditoryUsuario = "Insercion de un Usuario de Tarjeta de Credito ::: Empleado ={$_SESSION['id_user']} ::: idCuentaUsuario ={$idCuenta} ::: idSolicitud ={$form['idSolicitud']}";
	  	$idUsuario = $oMysql->consultaSel("CALL usp_InsertTable(\"Usuarios\",\"$setUsuario\",\"$valuesUsuario\",\"{$_SESSION['id_user']}\",\"28\",\"$ToAuditoryUsuario\");",true);	  	
	  	//$oRespuesta->alert("idUsuario = ".$idUsuario);	
	  	
	  	$setLab = "idUsuario,idCondicionLaboral,idCondicionAFIP,sCargo,sRazonSocial,sCuit,sCalle,sNumeroCalle,sActividad,fIngresoBrutoDGR,sEstado";
	  	$valuesLab = "'{$idUsuario}','{$rs['idCondicionLaboral']}','{$rs['idCondicionAFIPLab']}','{$rs['sCargo1']}','{$rs['sRazonSocialLab']}','{$rs['sCUITEmpleador']}','{$rs['sCalleLab']}','{$rs['sNumeroCalleLab']}','{$rs['sActividad']}','{$rs['fIngresoNetoMensual1']}','A'";	  	
	  	$idDatosLab = $oMysql->consultaSel("CALL usp_InsertValues(\"DatosLaborales\",\"$setLab\",\"$valuesLab\");",true);
		//$oRespuesta->alert("idDatosLab = ".$idDatosLab);	
		
		$setDomicilio = "idUsuario,idTipoDomicilio,idProvincia,idLocalidad,sCodigoPostal,sCalle,sNumeroCalle,sPiso,sBlock,sDepartamento,sManzana,sLote,sEntreCalles,sOtrosDatos,sEstado";
		$valuesDomicilio = "'{$idUsuario}','1','{$rs['idProvincia']}','{$rs['idLocalidad']}','{$rs['sCodigoPostal']}','{$rs['sCalle']}','{$rs['sNumeroCalle']}','{$rs['sPiso']}','{$rs['sBlock']}','{$rs['sDepartamento']}','{$rs['sManzana']}','{$rs['sLote']}','{$rs['sEntreCalles']}','{$rs['sOtrosDatos']}','A'";
		$idDomicilio = $oMysql->consultaSel("CALL usp_InsertValues(\"DomiciliosUsuarios\",\"$setDomicilio\",\"$valuesDomicilio\");",true);
		//$oRespuesta->alert("idDom = ".$idDomicilio);	
		
		$setOtrosDatos ="idUsuario,idTipoOtroDato,sTelefono,sCelular,idEmpresaCelular,sTelefonoContacto,sReferenciaContacto,sObservacion";
		$valuesOtrosDatos ="'{$idUsuario}',1,'{$rs['sTelefonoParticularFijo']}','{$rs['sTelefonoParticularCelular']}','{$rs['idEmpresaCelular']}','{$rs['sTelefonoContacto']}','{$rs['sReferenciaContacto']}',''";
		$idOtrosDatos = $oMysql->consultaSel("CALL usp_InsertValues(\"OtrosDatos\",\"$setOtrosDatos\",\"$valuesOtrosDatos\");",true);
		//$oRespuesta->alert("idOtrosDatos = ".$idOtrosDatos);	
	  	
		$sNumeroBIN = obtenerNumeroBIN($form['hdnIdBIN']);  	
	  	$sNumeroTarjeta1 = $sNumeroBIN . $form['sNumero'] . "00";
	  	//$sNumeroTarjeta1 = $sNumeroBIN . $form['sNumero'];
	  	$sNumeroTarjeta = $sNumeroTarjeta1 .luhn($sNumeroTarjeta1);
	  	
	  	$sCodigoSeguridad = generarCodigoSeguridadTarjeta($sNumeroTarjeta); 
	  	//$oRespuesta->alert("bin = ".$sNumeroBIN);
	  	//$oRespuesta->alert("CodigoSeguridad = ".$sCodigoSeguridad);
	  	$setTarjeta = "idUsuario,idCuentaUsuario,idBIN,idTipoTarjeta,idTipoEstadoTarjeta,sNumeroTarjeta,iVersion,dVigenciaDesde,dVigenciaHasta,dFechaRegistro,sCodigoSeguridad";
	  	$valuesTarjeta = "'{$idUsuario}','{$idCuenta}','{$form['hdnIdBIN']}',1,1,'{$sNumeroTarjeta}',0,NOW(),DATE_ADD(NOW(), INTERVAL 2 YEAR),NOW(),'{$sCodigoSeguridad}'";
	  	$ToAuditoryTarjeta = "Insercion de una Tarjeta de Credito ::: Empleado ={$_SESSION['id_user']} ::: idCuentaUsuario ={$idCuenta} ::: idSolicitud ={$form['idSolicitud']}";
	  	$idTarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"Tarjetas\",\"$setTarjeta\",\"$valuesTarjeta\",\"{$_SESSION['id_user']}\",\"26\",\"$ToAuditoryTarjeta\");",true);
	  	//$oRespuesta->alert("idTarjeta = ".$idTarjeta);
	  	
	  	//idTipoEstadoTarjeta = 1 es TITULAR
	  	$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
		$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','1',NOW(),''";
		$ToAuditoryEstado = "Insercion Historial de Estados de Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=1";
		$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true);  
		//$oRespuesta->alert("idEstadotarjeta = ".$idEstadotarjeta);
		   
	  	$set = "SolicitudesUsuarios.idTipoEstado = '2'";
	    $conditions = "SolicitudesUsuarios.id = '{$form['idSolicitud']}'";
		$ToAuditory = "Modificacion de Estado de Solicitudes ::: Empleado ={$_SESSION['id_user']} ::: idSolicitud={$form['idSolicitud']} ::: estado=2";		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"SolicitudesUsuarios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"9\",\"$ToAuditory\");",true);   
		
		$setEstadoSolicitud = "idSolicitud,idEmpleado,idTipoEstadoSolicitud,dFechaRegistro,sMotivo";
		$valuesEstadoSolicitud = "'{$form['idSolicitud']}','{$_SESSION['id_user']}','2',NOW(),''";
		$ToAuditoryEstadoSolicitud = "Insercion Historial de Estados de Solicitudes ::: Empleado ={$_SESSION['id_user']} ::: idSolicitud={$form['idSolicitud']} ::: estado=2";
		$idEstadoSolicitud = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosSolicitudes\",\"$setEstadoSolicitud\",\"$valuesEstadoSolicitud\",\"{$_SESSION['id_user']}\",\"30\",\"$ToAuditoryEstadoSolicitud\");",true);   
		//$oRespuesta->alert("idEstadoSolicitud = ".$idEstadoSolicitud);
		
		//Se actualiza la informacion del cliente
		setDatosClienteGx($rs);
		
     	$oRespuesta->alert("La Solicitud se dio de Alta correctamente");
	  	$oRespuesta->redirect("Riesgos.php"); 
	  	return $oRespuesta;
	}
	
	/**************************** GRUPOS AFINIDADES ***********************************/
	function updateDatosGrupoAfinidad($form)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
	 	
		$form['dFechaVencimiento'] =  dateToMySql($form['dFechaVencimiento']);
		$form['dFechaCierre'] = dateToMySql($form['dFechaCierre']);
	    $form['sNombre'] = 	$oMysql->escaparCadena(strtoupper($form['sNombre']));
	  	     
	    //$oRespuesta->alert("Estado: " . $form['sEstado']); 
	    
	  	if($form['idGrupoAfinidad'] == 0)
	    {       
	  	   $set ="
	  	   		idBIN,
	  	   		sNombre,
	  	   		fCostoRenovacion,
	  	   		iCuotasRenovacion,
	  	   		iNumeroModeloResumen,
	  	   		fTasaSobreMargen,
	  	   		fTasaCoeficienteFinanciacion,
	  	   		sEstado";
	  	     	   		
		   $values = "
		   	'{$form['idBin']}',
		   	'{$form['sNombre']}',
		   	'{$form['fCostoRenovacion']}',
		   	'{$form['iCuotasRenovacion']}',
		   	'{$form['iNumeroModeloResumen']}',
		   	'{$form['fTasaSobreMargen']}',
		   	'{$form['fTasaCoeficienteFinanciacion']}',
		   	'A'
		   	";
		   	 
		   //$oRespuesta->alert($set. " " . $values);
		   
		   $ToAuditory = "Insercion de Grupo de Afinidad ::: User ={$_SESSION['ID_USER']}";
		   
		   $id = $oMysql->consultaSel("CALL usp_InsertTable(\"GruposAfinidades\",\"$set\",\"$values\",\"{$_SESSION['ID_USER']}\",\"3\",\"$ToAuditory\");",true);   
	
		   //$oRespuesta->alert($id);	
	    }
	    else
	    {   		
	   	 	$set = "
		   		idBin ='{$form['idBin']}',
		   		sNombre ='{$form['sNombre']}',
		   		fCostoRenovacion = '{$form['fCostoRenovacion']}',
		   		iCuotasRenovacion = '{$form['iCuotasRenovacion']}',
		   		iNumeroModeloResumen = '{$form['iNumeroModeloResumen']}',
		   		fTasaSobreMargen = '{$form['fTasaSobreMargen']}',
		   		fTasaCoeficienteFinanciacion = '{$form['fTasaCoeficienteFinanciacion']}',
		   		sEstado = '{$form['sEstado']}'
		   		";
			
			$conditions = "GruposAfinidades.id = '{$form['idGrupoAfinidad']}'";
			
			//$oRespuesta->alert($set. " " . $conditions);
			
			$ToAuditory = "Update de Grupo Afinidad ::: User ={$_SESSION['ID_USER']} ::: idGrupo={$form['idGrupoAfinidad']}";
	
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"GruposAfinidades\",\"$set\",\"$conditions\",\"{$_SESSION['ID_USER']}\",\"4\",\"$ToAuditory\");",true);   
	    }
	    
	    $oRespuesta->alert("La operacion se realizo correctamente");
	  	$oRespuesta->redirect("GruposAfinidades.php");
	  	
		return  $oRespuesta;
	}



	function updateEstadoGrupoAfinidad($idGrupoAfinidad, $sEstado)
	{
	    GLOBAL $oMysql;
	    $oRespuesta = new xajaxResponse();   
		
	    //$oRespuesta->alert("updateEstadoSucursal: " .  $idGrupoAfinidad . " " . " Estado " . $sEstado);
	       
	    $set = "sEstado = '{$sEstado}'";
	    $conditions = "GruposAfinidades.id = '{$idGrupoAfinidad}'";
		$ToAuditory = "Update Estado Grupo Afinidad ::: User ={$_SESSION['id_user']} ::: idGrupoAfinidad={$idGrupoAfinidad} ::: estado={$sEstado}";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"GruposAfinidades\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"4\",\"$ToAuditory\");",true);   
		
		$oRespuesta->alert("La operacion se realizo correctamente");
		$oRespuesta->redirect("GruposAfinidades.php");
		return $oRespuesta;
	}

	function habilitarGruposAfinidades($aform)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
			 
		$aGruposAfinidades=$aform['aGrupoAfinidad'];
		
		//$oRespuesta->alert("Cantidad: ". count($aGruposAfinidades));
		
		foreach ($aGruposAfinidades as $idGrupoAfinidad)
		{
			//$oRespuesta->alert("id: " . $idGrupoAfinidad);
			
		    $set = "sEstado = 'A'";
		    $conditions = "GruposAfinidades.id = '{$idGrupoAfinidad}'";
			$ToAuditory = "Update Estado de Grupo Afinidad ::: User ={$_SESSION['id_user']} ::: idGrupoAfinidad={$idGrupoAfinidad} ::: estado='A'";
			
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"GruposAfinidades\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"4\",\"$ToAuditory\");",true); 
		      	 
		    //$oRespuesta->alert("id: " . $idGrupoAfinidad);
		}
		
	    $oRespuesta->alert("La operacion se realizo correctamente");
	    $sScript=" window.location.reload();";
	    $oRespuesta->script($sScript);
	    
		return  $oRespuesta;
	}

	/*function  habilitarGruposAfinidades($aform)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$oRespuesta->alert("habilitarGruposAfinidades");
		
		$aSucursal=$aform['aGrupoAfinidad'];		
		
		$oRespuesta->alert(count($aSucursal));
		
		foreach ($aSucursal as $idSucursal){
		    $set = "sEstado = 'A'";
		    $conditions = "GruposAfinidades.id = '{$idSucursal}'";
			$ToAuditory = "Update Estado de Grupo ::: User ={$_SESSION['id_user']} ::: idGrupoAfinidad={$idSucursal} ::: estado='A'";
			
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Sucursales\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"4\",\"$ToAuditory\");",true);   	 
		}
	    $oRespuesta->alert("La operacion se realizo correctamente");
	    $sScript=" window.location.reload();";
	    $oRespuesta->script($sScript);
	    
		return  $oRespuesta;
	}*/
	
	function verificarDocumento($idTipoDocumento,$sDocumento){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		$cantUsuarios = $oMysql->consultaSel("SELECT count(*) as cantidad FROM InformesPersonales WHERE idTipoDocumento='{$idTipoDocumento}' AND sDocumento='{$sDocumento}'",true);
		if($cantUsuarios > 0){
			$oRespuesta->alert("El Tipo de Documento y el Numero de Documento ya existe, verifique.");		
			$oRespuesta->script("document.getElementById('sDocumento').focus();");
		}	
		return  $oRespuesta;
	}
	
	function mostrarCalendarioPorGrupoAfinidad($idGrupoAfinidad){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$sql = "CALL usp_GetCalendarioFacturacion('WHERE CalendariosFacturaciones.idGrupoAfinidad={$idGrupoAfinidad} AND CalendariosFacturaciones.dFechaCierre > DATE_FORMAT(NOW(),\'%Y-%m-%d 00:00:00\') ORDER BY CalendariosFacturaciones.dFechaCierre ASC LIMIT 0,1')";
		//$oRespuesta->alert($sql);
		$rs = $oMysql->consultaSel($sql, true);
		
		if(count($rs)>0){
			$sTabla = "<table width='650px'   class='TablaCalendario'>
			<tr class='filaPrincipal'>
				<th class='borde' style='text-align:center;height:25px'>Periodo</th>
				<th class='borde' style='text-align:center;height:25px'>Cierre</th>		
				<th class='borde' style='text-align:center;height:25px'>Vencimiento</th>
				<th class='borde' style='text-align:center;height:25px'>Tasa Punitorio Peso</th>
				<th class='borde' style='text-align:center;height:25px'>Tasa Financiacion Peso</th>
				<th class='borde' style='text-align:center;height:25px'>Tasa Compensatorio Peso</th>
				<th class='borde' style='text-align:center;height:25px'>Tasa Punitorio Dolar</th>
				<th class='borde' style='text-align:center;height:25px'>Tasa Financiacion Dolar</th>
				<th class='borde' style='text-align:center;height:25px'>Tasa Compensatorio Dolar</th>
			</tr>
			<tr>
				<td id='tdPeriodo'>
					{$rs['dPeriodo']}
					<input class='textTabla' type='hidden' name='idCalendario'  id='idCalendario' value='0'>
				</td>		
				<td >{$rs['dFechaCierre']}</td>		
				<td>{$rs['dFechaVencimiento']}</td>		
				<td >{$rs['fTasaPunitorioPeso']}</td>
				<td >{$rs['fTasaFinanciacionPeso']}</td>
				<td >{$rs['fTasaCompensatorioPeso']}</td>
				<td >{$rs['fTasaPunitorioDolar']}</td>
				<td >{$rs['fTasaFinanciacionDolar']}</td>
				<td >{$rs['fTasaCompensacionDolar']}</td>
			</tr>";
		
			$oRespuesta->assign("hdnTasaPunitorioPeso","value",$rs['fTasaPunitorioPeso']);			
			$oRespuesta->assign("hdnTasaFinanciacionPeso","value",$rs['fTasaFinanciacionPeso']);			
			$oRespuesta->assign("hdnTasaCompensatorioPeso","value",$rs['fTasaCompensatorioPeso']);			
			$oRespuesta->assign("hdnTasaFinanciacionDolar","value",$rs['fTasaFinanciacionDolar']);			
			$oRespuesta->assign("hdnTasaPunitorioDolar","value",$rs['fTasaPunitorioDolar']);			
			$oRespuesta->assign("hdnTasaCompensacionDolar","value",$rs['fTasaCompensacionDolar']);			
			$oRespuesta->assign("hdnFechaCierre","value",$rs['dFechaCierre']);			
			$oRespuesta->assign("hdnFechaVencimiento","value",$rs['dFechaVencimiento']);			
			$oRespuesta->assign("hdnPeriodo","value",$rs['dPeriodoFormat']);			
			$oRespuesta->assign("hdnFechaMora","value",$rs['dFechaMora']);
			
			$oRespuesta->assign("divCalendario","innerHTML",$sTabla);
			
		}
		$fTasaSobreMargen =  $oMysql->consultaSel("SELECT fTasaSobreMargen FROM GruposAfinidades WHERE id={$idGrupoAfinidad}", true);
		$oRespuesta->assign("hdnTasaSobreMargen","value",$fTasaSobreMargen);
		return  $oRespuesta;
	}
	
	/******************************** CALENDARIO FACTURACION *****************************************/
	
	function _buscarCalendarioFacturacion($form, $iPeriodo)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();		
		
		$idGrupoAfinidad = $form["idGrupoAfinidad"];
		$iPediodo =  $iPeriodo;		

		//$oRespuesta->alert($iPediodo);
			
		$sCondiciones = " WHERE CalendariosFacturaciones.idGrupoAfinidad = " .$idGrupoAfinidad." AND year(CalendariosFacturaciones.dPeriodo) = ".$iPediodo;	
		$sOrder = " ORDER BY dPeriodo ASC ";
					
		//$sqlDatos="Call usp_getGruposAfinidades(\"$sCondiciones\");";
		$sConsulta = "CALL usp_GetCalendarioFacturacion(\"$sCondiciones. $sOrder\");";
		
		$result = $oMysql->consultaSel($sConsulta);   
		
		//$oRespuesta->alert("CALL usp_GetCalendarioFacturacion(\"$sCondiciones\");");
		
		$i = 1;
		
		$dPeriodo = "";
		
		if(count($result)>0)
		{
			foreach ($result as $rs)
			{			
				$oRespuesta->assign('idCalendario'.$i, 'value',$rs['id']);
				$oRespuesta->assign('dFechaVencimiento'.$i, 'value',$rs['dFechaVencimiento']);
				$oRespuesta->assign('dFechaCierre'.$i, 'value',$rs['dFechaCierre']);
				$oRespuesta->assign('dFechaMora'.$i, 'value',$rs['dFechaMora']);
				$oRespuesta->assign('dPeriodo'.$i, 'value',$rs['dPeriodo']);
				$oRespuesta->assign('fTasaPunitorioPeso'.$i, 'value',$rs['fTasaPunitorioPeso']);
				$oRespuesta->assign('fTasaFinanciacionPeso'.$i, 'value',$rs['fTasaFinanciacionPeso']);
				$oRespuesta->assign('fTasaCompensatorioPeso'.$i, 'value',$rs['fTasaCompensatorioPeso']);
				$oRespuesta->assign('fTasaFinanciacionDolar'.$i, 'value',$rs['fTasaFinanciacionDolar']);
				$oRespuesta->assign('fTasaPunitorioDolar'.$i, 'value',$rs['fTasaPunitorioDolar']);
				$oRespuesta->assign('fTasaCompensacionDolar'.$i, 'value',$rs['fTasaCompensacionDolar']);
				$oRespuesta->assign('fTasaInteresAdelantos'.$i, 'value',$rs['fTasaInteresAdelantos']);
			
				$i +=1;
			}
		
			$oRespuesta->assign('sAccion', 'value', 'update');			
			$oRespuesta->assign('divPeriodo', 'style.display','none');
		}
		else 
		{
			$oRespuesta->alert("No se encontraron resultados");			
			$oRespuesta->assign('sAccion', 'value', 'new');	
			
			for($i=1;$i<=12;$i++)
	    	{
	    		$oRespuesta->assign('idCalendario'.$i, 'value','0');
				$oRespuesta->assign('dFechaVencimiento'.$i, 'value','');
				$oRespuesta->assign('dFechaCierre'.$i, 'value','');
				$oRespuesta->assign('dFechaMora'.$i, 'value','');
				$oRespuesta->assign('dPeriodo'.$i, 'value','');
				$oRespuesta->assign('fPorcentajeCompraPeso'.$i, 'value','');
				$oRespuesta->assign('fPorcentajeCreditoPeso'.$i, 'value','');
				$oRespuesta->assign('fPorcentajeFinanciacionPeso'.$i,'value', '');
				$oRespuesta->assign('fPorcentajeAdelantoPeso'.$i, 'value', '');
				$oRespuesta->assign('fPorcentajeSobreMargen'.$i, 'value','');
				$oRespuesta->assign('fTasaInteresAdelantos'.$i, 'value','');
	    	}
	    			
	    	$oRespuesta->assign('divPeriodo', 'style.display','block');	
		}
		
		return $oRespuesta;
	}
	
	
	function updateDatosCalendarioFacturacion($form)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
	 	
		//$oRespuesta->alert("updateDatosCalendarioFacturacion");
		 
	 	if($form['sAccion'] == "new")
	    {   
	    	//-------------- Validar que no exista en la base de datos un calendario con el mismo periodo
	    	    
	  	   	$idGrupoAfinidad = $form["idGrupoAfinidad"];
			$aPeriodo = split('/', $form['dPeriodo1']);
			$iPeriodo = $aPeriodo[1];
			
	    	$sCondiciones = " WHERE CalendariosFacturaciones.idGrupoAfinidad = " .$idGrupoAfinidad." AND year(CalendariosFacturaciones.dPeriodo) = ".$iPeriodo;	
			
			//$sqlDatos="Call usp_getGruposAfinidades(\"$sCondiciones\");";
			$sConsultaCantidad = "CALL usp_GetCalendarioFacturacion(\"$sCondiciones\");";
			
			$ResultCantidad =  $oMysql->consultaSel($sConsultaCantidad, true);  
				
			if(count($ResultCantidad) == 12)
			{
				   $oRespuesta->alert("Ya existe un calendario con periodo ". $iPeriodo);
				   return  $oRespuesta;				   
			}
			
		    //-------------------------------------------------------------------
	    		    	
	    	$set = "(
		  	   			idGrupoAfinidad,
		  	   			dFechaVencimiento,
		  	   			dFechaMora,
		  	   			dFechaCierre,
		  	   			dPeriodo,
		  	   			fTasaPunitorioPeso,
		  	   			fTasaFinanciacionPeso,
		  	   			fTasaCompensatorioPeso,
		  	   			fTasaFinanciacionDolar,
		  	   			fTasaPunitorioDolar,
		  	   			fTasaCompensacionDolar,
		  	   			fTasaInteresAdelantos
		  	   		)";
	    	
			for($i=1; $i<=12; $i++)
			{
				//$oRespuesta->alert($form['dPeriodo'.$i]);
				
				$form['dPeriodo'.$i] = "01/" . $form['dPeriodo'.$i];	
				
				$form['dFechaVencimiento'.$i] = dateToMySql($form['dFechaVencimiento'.$i]);	
				$form['dFechaMora'.$i] = dateToMySql($form['dFechaMora'.$i]);	
				$form['dFechaCierre'.$i] = dateToMySql($form['dFechaCierre'.$i]);	
				$form['dPeriodo'.$i] = dateToMySql($form['dPeriodo'.$i]);	
								
		  	    $form['fTasaPunitorioPeso'] = str_replace(",",".",$form['fTasaPunitorioPeso']);
		  	    $form['fTasaFinanciacionPeso'] = str_replace(",",".",$form['fTasaFinanciacionPeso']);
		  	    $form['fTasaCompensatorioPeso'] = str_replace(",",".",$form['fTasaCompensatorioPeso']);
				$form['fTasaFinanciacionDolar'] =  str_replace(",",".",$form['fTasaFinanciacionDolar']);
				$form['fTasaPunitorioDolar'] = str_replace(",",".",$form['fTasaPunitorioDolar']);
				$form['fTasaCompensacionDolar'] = str_replace(",",".",$form['fTasaCompensacionDolar']);				
				$form['fTasaInteresAdelantos'] = str_replace(",",".",$form['fTasaInteresAdelantos']);				
		  	    
			    $values .= "
			   		(
				   		{$form['idGrupoAfinidad']},
				   		'{$form['dFechaVencimiento'.$i]}',
				   		'{$form['dFechaMora'.$i]}',
				   		'{$form['dFechaCierre'.$i]}',
				   		'{$form['dPeriodo'.$i]}',
				   		'{$form['fTasaPunitorioPeso'.$i]}',
				   		'{$form['fTasaFinanciacionPeso'.$i]}',
				   		'{$form['fTasaCompensatorioPeso'.$i]}',
				   		'{$form['fTasaFinanciacionDolar'.$i]}',
				   		'{$form['fTasaPunitorioDolar'.$i]}',
				   		'{$form['fTasaCompensacionDolar'.$i]}',
				   		'{$form['fTasaInteresAdelantos'.$i]}'
			   		)";
			    
			    if($i < 12)
			    {	    
			    	$values .= ",";
				}
			}				
		   
		   $ToAuditory = "Insercion de Calendario Facturacion ::: User ={$_SESSION['ID_USER']}";
		   
		   $id = $oMysql->consultaSel("CALL usp_abm_General(\"CalendariosFacturaciones\",\"$set\",\"$values\",\"1\",\"{$_SESSION['id_user']}\",\"16\",\"$ToAuditory\");",true);   
		   
		   //$oRespuesta->alert("CALL usp_abm_General(\"CalendariosFacturaciones\",\"$set\",\"$values\",\"1\",\"{$_SESSION['id_user']}\",\"16\",\"$ToAuditory\");");
	
	    }
	    else
	    {   	
	    	//$oRespuesta->alert("entro por else");
	    	    	
	    	for($i=1;$i<=12;$i++)
	    	{
	    		$form['dPeriodo'.$i] = "01/" . $form['dPeriodo'.$i];	
	    		$form['dFechaVencimiento'.$i] = dateToMySql($form['dFechaVencimiento'.$i]);	
	    		$form['dFechaMora'.$i] = dateToMySql($form['dFechaMora'.$i]);	
				$form['dFechaCierre'.$i] = dateToMySql($form['dFechaCierre'.$i]);	
				$form['dPeriodo'.$i] = dateToMySql($form['dPeriodo'.$i]);						
								
		  	    $form['fTasaPunitorioPeso'] = str_replace(",",".",$form['fTasaPunitorioPeso']);
		  	    $form['fTasaFinanciacionPeso'] = str_replace(",",".",$form['fTasaFinanciacionPeso']);
		  	    $form['fTasaCompensatorioPeso'] = str_replace(",",".",$form['fTasaCompensatorioPeso']);
				$form['fTasaFinanciacionDolar'] =  str_replace(",",".",$form['fTasaFinanciacionDolar']);
				$form['fTasaPunitorioDolar'] = str_replace(",",".",$form['fTasaPunitorioDolar']);
				$form['fTasaCompensacionDolar'] = str_replace(",",".",$form['fTasaCompensacionDolar']);				
				$form['fTasaInteresAdelantos'] = str_replace(",",".",$form['fTasaInteresAdelantos']);				
				
	    		$set = "
			   		idGrupoAfinidad = '{$form['idGrupoAfinidad']}',
			  	   	dFechaVencimiento = '{$form['dFechaVencimiento'.$i]}',
			  	   	dFechaMora = '{$form['dFechaMora'.$i]}',
			  	   	dFechaCierre = '{$form['dFechaCierre'.$i]}',
			  	   	dPeriodo = '{$form['dPeriodo'.$i]}',
			  	   	fTasaPunitorioPeso = '{$form['fTasaPunitorioPeso'.$i]}',
			  	   	fTasaFinanciacionPeso = '{$form['fTasaFinanciacionPeso'.$i]}',
			  	   	fTasaCompensatorioPeso = '{$form['fTasaCompensatorioPeso'.$i]}',
			  	   	fTasaFinanciacionDolar = '{$form['fTasaFinanciacionDolar'.$i]}',
			  	   	fTasaPunitorioDolar = '{$form['fTasaPunitorioDolar'.$i]}',
			  	   	fTasaCompensacionDolar = '{$form['fTasaCompensacionDolar'.$i]}',
			  	   	fTasaInteresAdelantos = '{$form['fTasaInteresAdelantos'.$i]}'
			  	   	"; 	
			
				$conditions = "CalendariosFacturaciones.id = '{$form['idCalendario'.$i]}'";
				
				$ToAuditory = "Update Calendarios Facturaciones ::: User ={$_SESSION['id_user']} ::: idCalendario={$form['idCalendario'.$i]}";
		
				$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"CalendariosFacturaciones\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"17\",\"$ToAuditory\");",true);   
				
				//$oRespuesta->alert("CALL usp_UpdateTable(\"CalendariosFacturaciones\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"17\",\"$ToAuditory\");");
	    	}
	    }
	    
	    $oRespuesta->alert("La operacion se realizo correctamente");
	      
	    for($i=1;$i<=12;$i++)
	    {
	    		$oRespuesta->assign('idCalendario'.$i, 'value','0');
				$oRespuesta->assign('dFechaVencimiento'.$i, 'value','');
				$oRespuesta->assign('dFechaCierre'.$i, 'value','');
				$oRespuesta->assign('dFechaMora'.$i, 'value','');
				$oRespuesta->assign('dPeriodo'.$i, 'value','');
				$oRespuesta->assign('fTasaPunitorioPeso'.$i, 'value','');
				$oRespuesta->assign('fTasaFinanciacionPeso'.$i, 'value','');
				$oRespuesta->assign('fTasaCompensatorioPeso'.$i,'value', '');
				$oRespuesta->assign('fTasaFinanciacionDolar'.$i, 'value', '');
				$oRespuesta->assign('fTasaPunitorioDolar'.$i, 'value','');
				$oRespuesta->assign('fTasaCompensacionDolar'.$i, 'value','');
				$oRespuesta->assign('fTasaInteresAdelantos'.$i, 'value','');
	    }
	    
	    $oRespuesta->assign('iPeriodoAplicar', 'value','');
	    $oRespuesta->assign('sAccion', 'value','new');	  
	  	
		return  $oRespuesta;
	}
	
	/********************  CANALES ********************/
	function updateDatosCanales($form){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
    	$form['sNombre'] = 	convertir_especiales_html(strtoupper($form['sNombre']));
  	     
	  	if($form['idCanal'] == 0)
	    {       
	  	   $set ="sNombre,sCodigo,idRegion,sEstado";
		   $values = "'{$form['sNombre']}','{$form['sCodigo']}','{$form['idRegion']}','A'";
		   $ToAuditory = "Insercion de Canales ::: User ={$_SESSION['id_user']} ::: Canal:{$form['sNombre']}";
		   $id = $oMysql->consultaSel("CALL usp_InsertTable(\"Canales\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"10\",\"$ToAuditory\");",true);   
		   
	    }else{
	    	$set = "sNombre = '{$form['sNombre']}', idRegion = '{$form['idRegion']}'";
	    	$conditions = "Canales.id = '{$form['idCanal']}'";
	    	
	    	$ToAuditory = "Update de Canales ::: User ={$_SESSION['id_user']} ::: idCanal={$form['idCanal']}";
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Canales\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"11\",\"$ToAuditory\");",true);   
	    }
   		
	    $oRespuesta->alert("La operacion se realizo correctamente");
	  	$oRespuesta->redirect("CanalesVentas.php"); 
		return  $oRespuesta;
	}
	
	function updateEstadoCanal($idCanal, $sEstado){
	    GLOBAL $oMysql;
	    $oRespuesta = new xajaxResponse();   
		
	    //$oRespuesta->alert($form['idSolicitud']. " " . " Estado " . $form['idEstado']);
	       
	    $set = "Canales.sEstado = '{$sEstado}'";
	    $conditions = "Canales.id = '{$idCanal}'";
		$ToAuditory = "Update Estado de Canales ::: User ={$_SESSION['id_user']} ::: idCanal={$idCanal} ::: estado={$sEstado}";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Canales\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"12\",\"$ToAuditory\");",true);   
		
		 
		$oRespuesta->alert("La operacion se realizo correctamente");
		$oRespuesta->redirect("CanalesVentas.php");
    	//$oRespuesta->script('location.reload();');
    	//$oRespuesta->script("window.parent.frames[1].location = 'Canales.php';");
		return $oRespuesta;
	}
	
	function habilitarCanales($form)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
			 
		$aCanales = $form['aCanales'];
		//$oRespuesta->alert("Cantidad: ". count($aGruposAfinidades));
		
		foreach ($aCanales as $idCanal){
		    $set = "sEstado = 'A'";
		    $conditions = "Canales.id = '{$idCanal}'";
			$ToAuditory = "Update Estado de Canales ::: User ={$_SESSION['id_user']} ::: idCanal={$idCanal} ::: estado='A'";
			
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Canales\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"12\",\"$ToAuditory\");",true); 
		}
		
	    $oRespuesta->alert("La operacion se realizo correctamente");
	    $sScript=" window.location.reload();";
	    $oRespuesta->script($sScript);
	    
		return  $oRespuesta;
	}
	
	/********************  LIMITES ESTANDARES ********************/
	function updateDatosLimites($form){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
    	$form['sDescripcion'] = convertir_especiales_html(strtoupper($form['sDescripcion']));
  	     
	  	if($form['idLimite'] == 0)
	    {       
	  	   $set ="sDescripcion,sCodigo,sEstado,dFechaRegistro,iLimiteCompra,iLimiteCredito,iLimitePorcentajeFinanciacion,iLimiteFinanciacion,iLimitePorcentajeAdelanto,iLimiteAdelanto,iLimitePorcentajePrestamo,iLimitePrestamo,iLimiteGlobal";
		   $values = "'{$form['sDescripcion']}',
		   		'{$form['sCodigo']}',
		   		'A',
		   		NOW(),
		   		'{$form['iLimiteCompra']}',
		   		'{$form['iLimiteCredito']}',
		   		'{$form['iLimitePorcentajeFinanciacion']}',
		   		'{$form['iLimiteFinanciacion']}',
		   		'{$form['iLimitePorcentajeAdelanto']}',
		   		'{$form['iLimiteAdelanto']}',
		   		'{$form['iLimitePorcentajePrestamo']}',
		   		'{$form['iLimitePrestamo']}',
		   		'{$form['iLimiteGlobal']}'";
		   $ToAuditory = "Insercion de Limite Estandar ::: User ={$_SESSION['id_user']} ::: Limite:{$form['sDescripcion']}";
		   $id = $oMysql->consultaSel("CALL usp_InsertTable(\"LimitesEstandares\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"13\",\"$ToAuditory\");",true);   
		   
	    }else{
	    	$set = "sDescripcion = '{$form['sDescripcion']}',
	    		iLimiteCompra= '{$form['iLimiteCompra']}',
	    		iLimiteCredito= '{$form['iLimiteCredito']}',
	    		iLimitePorcentajeFinanciacion= '{$form['iLimitePorcentajeFinanciacion']}',
	    		iLimiteFinanciacion= '{$form['iLimiteFinanciacion']}',
	    		iLimitePorcentajeAdelanto= '{$form['iLimitePorcentajeAdelanto']}',
	    		iLimiteAdelanto= '{$form['iLimiteAdelanto']}',
	    		iLimitePorcentajePrestamo= '{$form['iLimitePorcentajePrestamo']}',
	    		iLimitePrestamo= '{$form['iLimitePrestamo']}',
	    		iLimiteGlobal= '{$form['iLimiteGlobal']}'";
	    	//$oRespuesta->alert($set);
	    	$conditions = "LimitesEstandares.id = '{$form['idLimite']}'";
	    	
	    	$ToAuditory = "Update de Limites Estandares ::: User ={$_SESSION['id_user']} ::: idLimite={$form['idLimite']}";
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LimitesEstandares\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"14\",\"$ToAuditory\");",true);   
	    }
   		
	    $oRespuesta->alert("La operacion se realizo correctamente");
	  	$oRespuesta->redirect("Limites.php"); 
		return  $oRespuesta;
	}
	
	function updateEstadoLimite($idLimite, $sEstado){
	    GLOBAL $oMysql;
	    $oRespuesta = new xajaxResponse();   
		
	    $set = "LimitesEstandares.sEstado = '{$sEstado}'";
	    $conditions = "LimitesEstandares.id = '{$idLimite}'";
		$ToAuditory = "Update Estado de Limites Estandares::: User ={$_SESSION['id_user']} ::: idLimite={$idLimite} ::: estado='{$sEstado}'";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LimitesEstandares\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"15\",\"$ToAuditory\");",true);   
		 
		$oRespuesta->alert("La operacion se realizo correctamente");
		$oRespuesta->redirect("Limites.php");
		return $oRespuesta;
	}
	
	function habilitarLimites($form)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
			 
		$aLimites = $form['aLimites'];
		//$oRespuesta->alert("Cantidad: ". count($aGruposAfinidades));
		
		foreach ($aLimites as $idLimite){
		    $set = "sEstado = 'A'";
		    $conditions = "LimitesEstandares.id = '{$idLimite}'";
			$ToAuditory = "Update Estado de Limites Estandares ::: User ={$_SESSION['id_user']} ::: idLimite={$idLimite} ::: estado='A'";			
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LimitesEstandares\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"15\",\"$ToAuditory\");",true); 
		}
		
	    $oRespuesta->alert("La operacion se realizo correctamente");
	    $sScript=" window.location.reload();";
	    $oRespuesta->script($sScript);
		return  $oRespuesta;
	}
	
	function mostrarLimite($id){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		if($id > 0){
			$sCondiciones = " WHERE LimitesEstandares.id = {$id}";
			$sqlDatos="Call usp_getLimites(\"$sCondiciones\");";
			$rs = $oMysql->consultaSel($sqlDatos,true);
		
			$oRespuesta->assign("lbliLimiteCompra","innerHTML","$ ".$rs['iLimiteCompra']);
			$oRespuesta->assign("hdnLimiteCompra","value",$rs['iLimiteCompra']);
			$oRespuesta->assign("lbliLimiteCredito","innerHTML","$ ".$rs['iLimiteCredito']);
			$oRespuesta->assign("hdnLimiteCredito","value",$rs['iLimiteCredito']);
			$oRespuesta->assign("lbliLimitePorcentajeFinanciacion","innerHTML","".$rs['iLimitePorcentajeFinanciacion']);		
			$oRespuesta->assign("lblLimiteFinanciacion","innerHTML","$ ".$rs['iLimiteFinanciacion']);
			$oRespuesta->assign("hdnLimiteFinanciacion","value",$rs['iLimiteFinanciacion']);
			$oRespuesta->assign("lbliLimitePorcentajePrestamo","innerHTML","".$rs['iLimitePorcentajePrestamo']);
			$oRespuesta->assign("lblLimitePrestamo","innerHTML","$ ".$rs['iLimitePrestamo']);
			$oRespuesta->assign("hdnLimitePrestamo","value",$rs['iLimitePrestamo']);
			$oRespuesta->assign("lbliLimitePorcentajeAdelanto","innerHTML","".$rs['iLimitePorcentajeAdelanto']);
			$oRespuesta->assign("lblLimiteAdelanto","innerHTML","$ ".$rs['iLimiteAdelanto']);
			$oRespuesta->assign("hdnLimiteAdelanto","value",$rs['iLimiteAdelanto']);
			$oRespuesta->assign("lbliLimiteGlobal","innerHTML","$ ".$rs['iLimiteGlobal']);
			$oRespuesta->assign("hdnLimiteGlobal","value",$rs['iLimiteGlobal']);
			$oRespuesta->assign("btnGuardar","style.display","inline");
		}else{
		        $oRespuesta->assign("lbliLimiteCompra","innerHTML","$ ");
			$oRespuesta->assign("hdnLimiteCompra","value",0);
			$oRespuesta->assign("lbliLimiteCredito","innerHTML","$ ");
			$oRespuesta->assign("hdnLimiteCredito","value",0);
			$oRespuesta->assign("lbliLimitePorcentajeFinanciacion","innerHTML","");		
			$oRespuesta->assign("lblLimiteFinanciacion","innerHTML","$ ");
			$oRespuesta->assign("hdnLimiteFinanciacion","value",0);
			$oRespuesta->assign("lbliLimitePorcentajePrestamo","innerHTML","");
			$oRespuesta->assign("lblLimitePrestamo","innerHTML","$ ");
			$oRespuesta->assign("hdnLimitePrestamo","value",0);
			$oRespuesta->assign("lbliLimitePorcentajeAdelanto","innerHTML","");
			$oRespuesta->assign("lblLimiteAdelanto","innerHTML","$ ");
			$oRespuesta->assign("hdnLimiteAdelanto","value",0);
			$oRespuesta->assign("lbliLimiteGlobal","innerHTML","$ ");
			$oRespuesta->assign("hdnLimiteGlobal","value",0);
			$oRespuesta->assign("btnGuardar","style.display","none");
		}
			
		
		return  $oRespuesta;
	}
	
	/********************  PROMOTORES ********************/
	function updateDatosPromotores($form){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		if($form['idGrupoPromotor'] == 0)
	    {       
	  	    $set ="idEmpleado,idCanal,idOficina,dFechaRegistro";
	  	    $values = "'{$form['idEmpleado']}','{$form['idCanal']}','{$form['idOficina']}',NOW()";
	  	    
	  	    $ToAuditory = "Insercion de Grupos Promotores ::: User ={$_SESSION['id_user']} ::: idEmpleado:{$form['idEmpleado']}";
	  	    
		    $id = $oMysql->consultaSel("CALL usp_InsertTable(\"GruposPromotores\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"18\",\"$ToAuditory\");",true); 
	  	}else{
	  		$set ="idCanal={$form['idCanal']}";
	  		$values = "GruposPromotores.id={$form['idGrupoPromotor']}";
	  		$ToAuditory = "Update de Grupos Promotores ::: User ={$_SESSION['id_user']} ::: idGrupoPromotor={$form['idGrupoPromotor']}";
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"GruposPromotores\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"19\",\"$ToAuditory\");",true); 
	  	}
	  	
	  	$oRespuesta->alert("La operacion se realizo correctamente");
	  	$oRespuesta->redirect("Promotores.php"); 
		return  $oRespuesta;
	}
	
	/********************  TARJETAS DE CREDITOS ********************/
	function nuevaVersionTarjetasCreditos($sTarjetas,$form){ //NUEVAS VERSIONES DE TARJETAS DE CREDITOS
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		$aTarjetas = explode(",",$sTarjetas);
		
		foreach ($aTarjetas as $idTarjeta){
			$aTipoEstado =$oMysql->consultaSel("SELECT Tarjetas.idTipoEstadoTarjeta,TiposEstadosTarjetas.sNombre as 'sEstado',Tarjetas.sNumeroTarjeta FROM Tarjetas LEFT JOIN TiposEstadosTarjetas ON TiposEstadosTarjetas.id=Tarjetas.idTipoEstadoTarjeta WHERE Tarjetas.id={$idTarjeta}",true);
			if($aTipoEstado['idTipoEstadoTarjeta'] ==10 || $aTipoEstado['idTipoEstadoTarjeta'] ==11 || $aTipoEstado['idTipoEstadoTarjeta'] ==12){
				$sCondiciones = " WHERE Tarjetas.id ={$idTarjeta}";
				$sqlDatos="Call usp_getTarjetas(\"$sCondiciones\");";
				$rs = $oMysql->consultaSel($sqlDatos,true);
				
				$sNumero = substr($rs['sNumeroTarjeta'],0,13);  	
			  	$sNumeroTarjeta = $sNumero . "01";
			  	$sNumeroTarjeta = $sNumeroTarjeta .luhn($sNumeroTarjeta);
			  	
			  	$setTarjeta = "idUsuario,idCuentaUsuario,idBIN,idTipoTarjeta,sNumeroTarjeta,iVersion,dVigenciaDesde,dVigenciaHasta,dFechaRegistro,sCodigoSeguridad,idTipoEstadoTarjeta";
			  	$valuesTarjeta = "'{$rs['idUsuario']}','{$rs['idCuentaUsuario']}','{$rs['idBIN']}',1,'{$sNumeroTarjeta}',1,'{$rs['dVigenciaDesde_sinFormat']}','{$rs['dVigenciaHasta_sinFormat']}',NOW(),'{$rs['sCodigoSeguridad']}',1";
			  	$ToAuditoryTarjeta = "Insercion de una Tarjeta de Credito ::: Empleado ={$_SESSION['id_user']} ::: idCuenta ={$rs['idCuentaUsuario']}";
			  	$idTarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"Tarjetas\",\"$setTarjeta\",\"$valuesTarjeta\",\"{$_SESSION['id_user']}\",\"26\",\"$ToAuditoryTarjeta\");",true);
			  	//$oRespuesta->alert("idTarjeta = ".$idTarjeta);
			  	
			  	//idTipoEstadoTarjeta = 1 es TITULAR
			  	$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
				$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','1',NOW(),''";
				$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas de Creditos ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=1";
				$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true);  
				$oRespuesta->alert("La operacion se realizo con exito");
			}else{
				$oRespuesta->alert("La Tarjeta con Nro. ".$aTipoEstado['sNumeroTarjeta']. " no se pudo generar una Nueva Version su estado es: ".$aTipoEstado['sEstado']);
			}
			//$oRespuesta->alert("idEstadotarjeta = ".$idEstadotarjeta);
		}				
		$oRespuesta->redirect($form['URL_BACK']);
		return  $oRespuesta;
	}

	function renovarTarjetasCreditos($sTarjetas,$form){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		$aTarjetas = explode(",",$sTarjetas);
		
		foreach ($aTarjetas as $idTarjeta){
			$sCondiciones = " WHERE Tarjetas.id ={$idTarjeta}";
			$sqlDatos="Call usp_getTarjetas(\"$sCondiciones\");";
			$rs = $oMysql->consultaSel($sqlDatos,true);
			
		  	$setTarjeta = "dVigenciaDesde=NOW(),dVigenciaHasta=DATE_ADD(NOW(), INTERVAL 2 YEAR),dFechaRegistro=NOW(),idTipoEstadoTarjeta=1";
		  	$conditionsTarjeta = "Tarjetas.id={$idTarjeta}";
		  	$ToAuditoryTarjeta = "Modificacion de Tarjetas de Creditos de Creditos ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta}";		
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Tarjetas\",\"$setTarjeta\",\"$conditionsTarjeta\",\"{$_SESSION['id_user']}\",\"27\",\"$ToAuditoryTarjeta\");",true);  
		  	
		  	//idTipoEstadoTarjeta = 1 es TITULAR
		  	$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
			$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','17',NOW(),''";
			$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas de Creditos ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=17";
			$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true);  
			//$oRespuesta->alert("idEstadotarjeta = ".$idEstadotarjeta);
			
		  	$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
			$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','1',NOW(),''";
			$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas de Creditos ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=1";
			$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true);  			
			//$oRespuesta->alert("idEstadotarjeta = ".$idEstadotarjeta);
		}		
		$oRespuesta->alert("La operacion se realizo con exito");
		$oRespuesta->redirect($form['URL_BACK']);
		return  $oRespuesta;
	}

	function updateEstadoTarjetaCredito($form){
	    GLOBAL $oMysql;
	    $oRespuesta = new xajaxResponse();   
		$form['sMotivo'] = convertir_especiales_html($form['sMotivo']);
		
	    //$oRespuesta->alert($form['idSolicitud']. " " . " Estado " . $form['idEstado']);
	       
	    $set = "Tarjetas.idTipoEstadoTarjeta = '{$form['idTipoEstadoTarjeta']}'";
	    $conditions = "Tarjetas.id = '{$form['idTarjeta']}'";
		$ToAuditory = "Modificacion de Estado de Tarjeta de Credito ::: User ={$_SESSION['id_user']} ::: idTarjeta={$form['idTarjeta']} ::: estado={$form['idTipoEstadoTarjeta']}";		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Tarjetas\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"27\",\"$ToAuditory\");",true);   
		
		$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
		$valuesEstado = "'{$form['idTarjeta']}','{$_SESSION['id_user']}','{$form['idTipoEstadoTarjeta']}',NOW(),'{$form['sMotivo']}'";
		$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas de Creditos ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$form['idTarjeta']} ::: estado={$form['idTipoEstadoTarjeta']}";
		$idEstado = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true);   
		 
		$sMensaje ="La operacion se realizo correctamente";
    	
	    //$oRespuesta->script('closeMessage();');
	    $oRespuesta->assign("tdContent","innerHTML",$sMensaje);
	    $oRespuesta->assign("btnConfirmar","style.display","none");
		return $oRespuesta;
	}
	/******************************** FACTURACION DE CARGOS ****************************************/
	
	function updateDatosFacturacionDeCargos($form)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		$dFechaInicio =  date("Y-m-d h:i:s");
		
	  	if($form['idFacturacionCargos'] == 0)
	    {       
	  	   $set ="
	  	   		idGrupoAfinidad,
	  	   		idTipoAjuste,
	  	   		dFechaInicio,
	  	   		sTipoFacturacion,
	  	   		sEstado,
	  	   		idVariableTipoAjuste,
	  	   		fValor,
	  	   		idEmpleado,
	  	   		idTipoEstadoCuenta
	  	   		";
	  	     	   		
		   $values = "
		   	'{$form['idGrupoAfinidad']}',
		   	'{$form['idTipoAjuste']}',
		   	'{$dFechaInicio}',
		   	'{$form['idTipoFacturacion']}',
		   	'A',
		   	'{$form['idVariableTipoAjuste']}',
		   	'{$form['fValor']}',
		   	'{$_SESSION['id_user']}',
		   	'{$form['idTipoEstadoCuenta']}'		   	
		   	";
		   	 
		   //$oRespuesta->alert($set. " " . $values);
		   
		   $ToAuditory = "Insercion de Facturacion de Cargos ::: Empleado ={$_SESSION['id_user']}";
		   
		   $id = $oMysql->consultaSel("CALL usp_InsertTable(\"FacturacionesCargos\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"53\",\"$ToAuditory\");",true);   
	
		   //$oRespuesta->alert("CALL usp_InsertTable(\"FacturacionesCargos\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"53\",\"$ToAuditory\");");	
	    }
	    else
	    {   		
	   	 	$set = "
		   		idGrupoAfinidad ='{$form['idGrupoAfinidad']}',
		   		idTipoAjuste ='{$form['idTipoAjuste']}',
		   		sTipoFacturacion = '{$form['idTipoFacturacion']}',
		   		idVariableTipoAjuste = '{$form['idVariableTipoAjuste']}',
		   		fValor = '{$form['fValor']}',
		   		idTipoEstadoCuenta = '{$form['idTipoEstadoCuenta']}'
		   		";
			
			$conditions = "FacturacionesCargos.id = '{$form['idFacturacionCargos']}'";
			
			//$oRespuesta->alert($set. " " . $conditions);
			
			$ToAuditory = "Update de Facturacion de Cargos ::: Empleado ={$_SESSION['id_user']} ::: idFacturacion ={$form['idFacturacionCargos']}";
	
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"FacturacionesCargos\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"54\",\"$ToAuditory\");",true); 
			
			//$oRespuesta->alert("CALL usp_UpdateTable(\"FacturacionesCargos\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"54\",\"$ToAuditory\");");  
	    }
	    
	    $oRespuesta->alert("La operacion se realizo correctamente");
	  	$oRespuesta->redirect("FacturacionCargos.php");
	  	
		return  $oRespuesta;
	}
	
	
	function updateEstadoFacturacionDeCargos($idFacturacionCargos, $sEstado)
	{
	    GLOBAL $oMysql;
	    $oRespuesta = new xajaxResponse();   
	       
	    $set = "sEstado = '{$sEstado}'";
	    $conditions = "FacturacionesCargos.id = '{$idFacturacionCargos}'";
		$ToAuditory = "Update Estado Facturacion de Cargos ::: Empleado ={$_SESSION['id_user']} ::: idFacturacionCargos={$idFacturacionCargos} ::: estado={$sEstado}";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"FacturacionesCargos\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"55\",\"$ToAuditory\");",true);   
		
		$oRespuesta->alert("La operacion se realizo correctamente");
		$oRespuesta->redirect("FacturacionCargos.php");
		return $oRespuesta;
	}
	
	function habilitarFacturacionDeCargos($form)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
			 
		$aHabilitar = $form['aHabilitar'];
		//$oRespuesta->alert("Cantidad: ". count($aGruposAfinidades));
		
		foreach ($aHabilitar as $idFacturacionCargos){
		    $set = "sEstado = 'A'";
		    $conditions = "FacturacionesCargos.id = '{$idFacturacionCargos}'";
			$ToAuditory = "Update Estado de Facturaciones de Cargos ::: Empleado ={$_SESSION['id_user']} ::: idFacturacionCargos={$idFacturacionCargos} ::: estado='A'";
			
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"FacturacionesCargos\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"55\",\"$ToAuditory\");",true); 
		}
		
	    $oRespuesta->alert("La operacion se realizo correctamente");
	    $sScript=" window.location.reload();";
	    $oRespuesta->script($sScript);
	    
		return  $oRespuesta;
	}
	
	
	//****************************************** AJUSTES USUARIOS **************************************
	function updateEstadoAjusteUsuario($idAjusteUsuario, $sEstado)
	{
	    GLOBAL $oMysql;
	    $oRespuesta = new xajaxResponse();   
		    
	    $sCondicionesFacturado = "WHERE AjustesUsuarios.id = '{$idAjusteUsuario}'";
	    $oFacturado=$oMysql->consultaSel("CALL usp_getAjustesUsuarios(\"$sCondicionesFacturado\");",true);
	    	
	    //$oRespuesta->alert($oFacturado["iFacturado"]);
	    	
    	if($oFacturado["iFacturado"] == 1)
    	{
    		$oRespuesta->alert("No se puede anular un ajuste que se encuentra facturado");
    		return $oRespuesta;	
    	}
	       
	    $set = "sEstado = '{$sEstado}'";
	    $conditions = "AjustesUsuarios.id = '{$idAjusteUsuario}'";
		$ToAuditory = "Update Estado Ajuste de Usuario ::: User ={$_SESSION['id_user']} ::: idAjusteUsuario={$idAjusteUsuario} ::: estado={$sEstado}";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"AjustesUsuarios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"66\",\"$ToAuditory\");",true);   
			
		$fimporteConInteres = -($oFacturado['fImporteTotalInteres'] + $oFacturado['fImporteTotal']);
		$fImporteTotalIVA = -($oFacturado['fImporteTotalIVA']);		 
		$idCuentaUsuario = $oFacturado['idCuentaUsuario']; 	
		$sClaseAjuste = $oFacturado['sClaseAjuste'];
				
		$oMysql->consultaSel("CALL usp_updateDebitoCredito(\"{$idCuentaUsuario}\",\"{$sClaseAjuste}\",\"{$fimporteConInteres}\",\"{$fImporteTotalIVA}\");", true);
		
		$oRespuesta->alert("La operacion se realizo correctamente");
		$oRespuesta->redirect("AjustesUsuarios.php");
		return $oRespuesta;
	}
	
	
	function habilitarAjustesUsuarios($form)
	{
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
			 
		$aAjustes = $form['aAjustes'];
		//$oRespuesta->alert("Cantidad: ". count($aGruposAfinidades));
		
		foreach ($aAjustes as $idAjusteUsuario)
		{
		    $set = "sEstado = 'A'";
		    $conditions = "AjustesUsuarios.id = '{$idAjusteUsuario}'";
			$ToAuditory = "Update Estado de Ajustes de Usuarios ::: Empleado ={$_SESSION['id_user']} ::: idAjusteUsuario={$idAjusteUsuario} ::: estado='A'";
			
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"AjustesUsuarios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"66\",\"$ToAuditory\");",true); 
			
			$sCondicionesFacturado = "WHERE AjustesUsuarios.id = '{$idAjusteUsuario}'";
	    	$oFacturado = $oMysql->consultaSel("CALL usp_getAjustesUsuarios(\"$sCondicionesFacturado\");",true);
	    	
			$fimporteConInteres = $oFacturado['fImporteTotalInteres'] + $oFacturado['fImporteTotal'];
			$fImporteTotalIVA = $oFacturado['fImporteTotalIVA'];		 
			$idCuentaUsuario = $oFacturado['idCuentaUsuario']; 	
			$sClaseAjuste = $oFacturado['sClaseAjuste'];
				
			$oMysql->consultaSel("CALL usp_updateDebitoCredito(\"{$idCuentaUsuario}\",\"{$sClaseAjuste}\",\"{$fimporteConInteres}\",\"{$fImporteTotalIVA}\");", true);
		}
		
	    $oRespuesta->alert("La operacion se realizo correctamente");
	    $oRespuesta->redirect("AjustesUsuarios.php");
	    
		return  $oRespuesta;
	}
	
	function reactivarAjustesUsuarios($idAjusteUsuario){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		$set = "sEstado = 'A'";
	    $conditions = "AjustesUsuarios.id = '{$idAjusteUsuario}'";
		$ToAuditory = "Update Estado de Ajustes de Usuarios ::: Empleado ={$_SESSION['id_user']} ::: idAjusteUsuario={$idAjusteUsuario} ::: estado='A'";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"AjustesUsuarios\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"66\",\"$ToAuditory\");",true); 
		
		$sCondicionesFacturado = "WHERE AjustesUsuarios.id = '{$idAjusteUsuario}'";
    	$oFacturado = $oMysql->consultaSel("CALL usp_getAjustesUsuarios(\"$sCondicionesFacturado\");",true);
    	
		$fimporteConInteres = $oFacturado['fImporteTotalInteres'] + $oFacturado['fImporteTotal'];
		$fImporteTotalIVA = $oFacturado['fImporteTotalIVA'];		 
		$idCuentaUsuario = $oFacturado['idCuentaUsuario']; 	
		$sClaseAjuste = $oFacturado['sClaseAjuste'];
			
		$oMysql->consultaSel("CALL usp_updateDebitoCredito(\"{$idCuentaUsuario}\",\"{$sClaseAjuste}\",\"{$fimporteConInteres}\",\"{$fImporteTotalIVA}\");", true);
		
		$oRespuesta->alert("La operacion se realizo correctamente");
	    $oRespuesta->redirect("AjustesUsuarios.php");
		return  $oRespuesta;
	}
	//********************************* FIN AJUSTES USUARIOS *********************************************************
		
	function darBajaCuentaUsuario($idCuentaUsuario,$iDelete){
		GLOBAL $oMysql;		
	    $oRespuesta = new xajaxResponse();  
	    
	    $aEstadoCuenta = $oMysql->consultaSel("SELECT CuentasUsuarios.idTipoEstadoCuenta,TiposEstadosCuentas.sNombre as 'sEstado' FROM CuentasUsuarios WHERE id={$idCuentaUsuario} LEFT JOIN TiposEstadosCuentas ON TiposEstadosCuentas.id=CuentasUsuarios.idTipoEstadoCuenta",true);
	    $idMorosos = array(3,4,5,7,8,9); //Estados de Cuentas Moroso segun la cantidad de meses
	    
	    if(in_array($aEstadoCuenta['idTipoEstadoCuenta'], $idMorosos)){
	    	//Mostrar Mensaje y mostrar un boton de Resumen de Cancelacion
	    	$oRespuesta->alert("La Cuenta se encuentra en Estado : ".$aEstadoCuenta['sEstado']."\n No se puede dar de Baja");
	    		    	
	    }else{
	    	
	    	$oMysql->consultaSel("CALL usp_eliminarCuentaUsuario(\"{$idCuentaUsuario}\",\"$iDelete\");",true);
	    	
	    	$oRespuesta->alert("La operacion se pudo realizar correctamente");
	    	$oRespuesta->redirect("CuentasUsuarios.php");	
	    	
	    }
	    
		return $oRespuesta;
	}
			
	function eliminarDefinitivoObjeto($idObjeto, $iTipoObjeto, $sUrl)
	{
		GLOBAL $oMysql;		
	    $oRespuesta = new xajaxResponse();  

	    switch ($iTipoObjeto)
	    {
	    	//Cobranzas
			case 1:{
				
				$sNombreObjeto = "Cobranza";
				$sCondicionesFacturado = "WHERE Cobranzas.id = '{$idObjeto}'";
		    	$oFacturado=$oMysql->consultaSel("CALL usp_getCobranzas(\"$sCondicionesFacturado\");",true);
		    	$dFechaOperacion = $oFacturado["dFechaCobranza"];
		    	
		    	$fImporte = (-1)*$oFacturado["fImporte"];
		    	$idCuentaUsuario = $oFacturado["idCuentaUsuario"];
				
				/*$iEstaEnPeriodo = $oMysql->consultaSel("SELECT fcn_checkEstaEnPeriodo(\"$idCuentaUsuario\",\"{$oFacturado['dFechaCobranza']}\") ",true);
				$oRespuesta->alert($idCuentaUsuario.'---'.$oFacturado['dFechaCobranza']);
				
				if($iEstaEnPeriodo == 1)
		    	{
		    		$oRespuesta->alert("No se puede eliminar la Cobranza que se encuentra facturada");
		    		return $oRespuesta;	
		    	}*/
		    	if($oFacturado["iEstadoFacturacionUsuario"] == 1)
		    	{
		    		$oRespuesta->alert("No se puede anular una Cobranza que se encuentra facturada");
		    		return $oRespuesta;	
		    	}
					    	
				//$oMysql->consultaSel("CALL usp_updateCobranzaCuentaUsuario(\"{$idCuentaUsuario}\",\"{$fImporte}\");",true);		
							
				
				break;
			}
			//Cupones
			case 2:
				{
				$sNombreObjeto = "Cupon";
				$sCondicionesFacturado = "WHERE Cupones.id = '{$idObjeto}'";
		    	$oFacturado = $oMysql->consultaSel("CALL usp_getCupones(\"$sCondiciones\");",true);
				
		    	$dFechaOperacion = $oFacturado["dFechaConsumo"];
		    	
		    	/*$iEstaEnPeriodo = $oMysql->consultaSel("SELECT fcn_checkEstaEnPeriodo(\"$idCuentaUsuario\",\"{$oFacturado['dFechaConsumo']}\") ",true);
		    	if($iEstaEnPeriodo == 1)
		    	{
		    		$oRespuesta->alert("No se puede eliminar el Cupon que se encuentra facturado");
		    		return $oRespuesta;	
		    	}*/
		    	
				if($oFacturado["iEstadoFacturacionUsuario"] == 1)
		    	{
		    		$oRespuesta->alert("No se puede eliminar el Cupon que se encuentra facturado");
		    		return $oRespuesta;	
		    	}
		    	
				$datos = $oMysql->consultaSel("CALL usp_getPromocionesPlanesCupones(\"{$idObjeto}\");",true);
			
				$tipoplanpromo = $datos['tipoplanpromo'];
				$importe_total = (-1) * $datos['importe_total'];			
				$importe_cuota = number_format($datos['importe_cuota'],2,'.','');
				$importe_cuota = (-1) * $importe_cuota;			
				$cantidad_cuotas_planpromo = intval($datos['sCuotas']);
				
				switch ($tipoplanpromo) {
					case "promociones":	
							$apromociones = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$datos['idPlanPromo']}\",\"promociones\");",true);
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
							$aplanes = $oMysql->consultaSel("CALL usp_getDatosCierreComercio(\"{$datos['idPlan']}\",\"planes\");",true);	
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
				
				if($iCompra == 0){ $importe_cuota = 0; }			
				if($iCredito == 0){ $importe_total = 0; }
				$r = $oMysql->consultaSel("CALL usp_UpdateRemanentesCuentaUsuario(\"{$datos['idCuentaUsuario']}\",\"$importe_total\",\"$importe_cuota\",\"$cantidad_cuotas_planpromo\");",true);		
				
				break;
			}
			//Ajustes de Usuarios
			case 3:{
				$sNombreObjeto = "Ajuste";
				$sCondiciones = "WHERE AjustesUsuarios.id = '{$idObjeto}'";
			    $oFacturado=$oMysql->consultaSel("CALL usp_getAjustesUsuarios(\"$sCondiciones\");",true);
			    
			    $dFechaOperacion = $oFacturado["dFecha"];
			    
			    /*$iEstaEnPeriodo = $oMysql->consultaSel("SELECT fcn_checkEstaEnPeriodo(\"$idCuentaUsuario\",\"{$oFacturado['dFecha']}\") ",true);
		    	if($iEstaEnPeriodo == 1)
		    	{
		    		$oRespuesta->alert("No se puede eliminar el Cupon que se encuentra facturado");
		    		return $oRespuesta;	
		    	}*/    	
		  	    if($oFacturado["iFacturado"] == 1)
			    {
		    		$oRespuesta->alert("No se puede anular un Ajuste que se encuentra facturado");
		    		return $oRespuesta;	
		    	}
			       
			    $fimporteConInteres = -($oFacturado['fImporteTotalInteres'] + $oFacturado['fImporteTotal']);
			    $fImporteTotalIVA = -($oFacturado['fImporteTotalIVA']);		 
			    $idCuentaUsuario = $oFacturado['idCuentaUsuario']; 	
			    $sClaseAjuste = $oFacturado['sClaseAjuste'];
			    $oMysql->consultaSel("CALL usp_updateDebitoCredito(\"{$idCuentaUsuario}\",\"{$sClaseAjuste}\",\"{$fimporteConInteres}\",\"{$fImporteTotalIVA}\");", true);
			    
			    break;
			}
		 }
		 
		 
		 
		//----- Maxi 22-03-2012 --------------------- 
	 	/*$dFechaActual = date("d/m/Y"); 
			
		list($diaActual,$mesActual,$añoActual)=split("/",$dFechaActual);
		list($diaOperacion,$mesOperacion,$añoOperacion)=split("/",$dFechaOperacion);
		
		//$oRespuesta->alert("operacion: $dFechaOperacion  - $mesOperacion  -  $añoOperacion ::: actual: $dFechaActual  - $mesActual  -  $añoActual");
		
		if($mesOperacion != $mesActual || $añoOperacion != $añoActual)
		{			
			$oRespuesta->alert("No se puede eliminar el $sNombreObjeto seleccionado ya que no pertenece al Periodo actual [ $mesActual-$añoActual ]");
			return $oRespuesta;
		}*/
	   //----------------------------------------------
		
		if(in_array($iTipoObjeto,array(1,2,3)))
		{ 
			  
			//-----------------Maxi 22-03-2012 En caso de eliminar una cobranza el estado de cuenta puede vuelver a un estado anterior ---------------------------------
			if($iTipoObjeto == 1)//Cobranza
			{
				//------------ Obtener el detalle de ajuste de usuario ----------------
				$sub_query = " WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$oFacturado['idCuentaUsuario']} ORDER BY DetallesCuentasUsuarios.id DESC LIMIT 0,1";
				$oDetalleCuentasUsuario = $oMysql->consultaSel("CALL usp_getDetallesCuentasUsuarios(\"$sub_query\");",true);
				//---------------------------------------------------------------------
				
				$PorcentajePagado = ($oDetalleCuentasUsuario['fAcumuladoCobranza'] * 100) / $oDetalleCuentasUsuario["fSaldoAnterior"];
				$PorcentajePagadoSinCobranza = ( ($oDetalleCuentasUsuario['fAcumuladoCobranza'] - $oFacturado['fImporte']) * 100) / $oDetalleCuentasUsuario["fSaldoAnterior"];				
				
				//$oRespuesta->alert("AcumuladoCobranza: ". $oDetalleCuentasUsuario['fAcumuladoCobranza'] . "/n SaldoAnterior: ". $oDetalleCuentasUsuario['fSaldoAnterior']);
				//$oRespuesta->alert("PorcentajePagado:   $PorcentajePagado");
				
				$oRespuesta->alert("PorcentajeSinCobranza:   $PorcentajePagadoSinCobranza");
				
				if($PorcentajePagado >= 80)
				{					
					if($PorcentajePagadoSinCobranza < 80 )
					{
						$oRespuesta->alert('volver estado de historial  <80 [Estaba en NORMAL]');
						return $oRespuesta;
					}
				}
				else if ($PorcentajePagado >= 50 && $PorcentajePagado <= 80)
				{
					if( $PorcentajePagadoSinCobranza < 50)
					{
						$oRespuesta->alert('volver estado de historial <50');
						return $oRespuesta;
					}
				}

				 //setEstadoCuentaUsuarioByCobranzaEliminada($idCuentaUsuario);			
				//RecalcularLimites($idCuentaUsuario);	
					
			}
								
		}
			//--------------------------------------------------------------------------------------------------------------------------------------------
				
		$oMysql->consultaSel("CALL usp_eliminarObjeto(\"{$idObjeto}\",\"{$iTipoObjeto}\");",true);  
		
		$oRespuesta->alert("La operacion se pudo realizar correctamente");
    	$oRespuesta->redirect($sUrl);	
	
		
		return $oRespuesta;
	}
	
	function darBajaLogicaCuentaUsuario($idCuentaUsuario){
	    GLOBAL $oMysql;		
	    $oRespuesta = new xajaxResponse();  
	    
	    //$dPeriodo = $oMysql->consultaSel("SELECT fcn_getUltimoPeriodoDetalleCuentaUsuario(\"{$idCuentaUsuario}\")",true);
	    //$oRespuesta->alert($dPeriodo);
	    //$fSaldoActual = $oMysql->consultaSel("SELECT fcn_getSaldoActual(\"{$idCuentaUsuario}\",\"{$dPeriodo}\")",true);
	    //$oRespuesta->alert($fSaldoActual);
	    /*if((float)$fSaldoActual > 0){
	    	$fSaldoActual = number_format($fSaldoActual,2,'.','');
	    	$oRespuesta->alert("La Cuenta tiene Movimientos pendientes. Saldo Actual:{$fSaldoActual} \nNo se puede dar de Baja");	    	
	    }else{	    	*/
	    	$result = $oMysql->consultaSel("CALL usp_darBajaCuentaUsuario(\"{$idCuentaUsuario}\",\"{$_SESSION['id_user']}\");",true);
	    	if($result == 'OK'){
	    		$oRespuesta->alert("La operacion se pudo realizar correctamente.");
	    	}else{
	    		$oRespuesta->alert("La operacion NO se pudo realizar.");
	    	}
	    //}
	    
	    $oRespuesta->redirect("CuentasUsuarios.php");	
		return $oRespuesta;
	}
	
	function buscarDatosClientes($datos){
		GLOBAL $oMysql;		
		//$mysql_gx = new MySql();	
		/*$mysql_gx->setServer('192.168.2.8','griva','grivasi');
		$mysql_gx->setDBName('grivasoluciones');*/			
		
		$oRespuesta = new xajaxResponse();		
       
		$conditions = array();	
		if($datos['sRazonSocial'] != ''){
			$conditions[] = "Clientes.ClientesRazonSocial LIKE '%{$datos['sRazonSocial']}%'";
		}
		if($datos['sNombreFantasia'] != ''){
			$conditions[] = "Clientes.ClientesNombreFantasia LIKE '%{$datos['sNombreFantasia']}%'";
		}
		/*if($datos['sNombre'] != ''){
			$conditions[] = "clientes.ClientesNombre LIKE '{$datos['sNombre']}%'";
		}
		if($datos['sApellido'] != ''){
			$conditions[] = "clientes.ClientesApellido LIKE '{$datos['sApellido']}%'";
		}*/
		if($datos['sDocumento'] != ''){
			$conditions[] = "Clientes.ClientesCUIT='{$datos['sDocumento']}' OR Clientes.ClientesDNI ='{$datos['sDocumento']}'";
		}
		
		$sub_query = " WHERE " . implode(" AND ",$conditions) . " ORDER BY Clientes.ClientesApellido ASC" ;
		//$users = $mysql_gx->query("SELECT * FROM Clientes " . $sub_query);
		$sConsulta="SELECT * FROM ".BASEGX.".Clientes " . $sub_query;
		
		$users = $oMysql->consultaSel($sConsulta);
		//var_export($users);
		$table = "<table width='700' cellspacing='0' cellpadding='0' align='center' class='table_object' id='table_object'>";
		if(count($users)== 0 ){
				$table .= "<tr>
							<td colspan='5' align='left'>-no se encontraron registros</td>
						  </tr>";				
		}else{
			$table .= "<tr>
					<th width='30'>&nbsp;</th>
					<th width='100'>Nro.</th>
					<th width='350'>Documento</th>
					<th width='350'>Cliente</th>
					<th width='350'>Domicilio</th>
				  </tr>";
			foreach ($users as $user) {
				if($user['ClientesDNI'] == "") $user['ClientesDNI'] = "&nbsp;";
				if($user['ClientesDomicilio'] == "") $user['ClientesDomicilio'] = "&nbsp;";
				$user['ClientesDomicilio'] = convertir_especiales_html($user['ClientesDomicilio']);
				$user['ClientesRazonSocial'] = convertir_especiales_html($user['ClientesRazonSocial']);
				$table .= "<tr>
							<td width='30'><input type='radio' name='user[]' id='user_{$user['id']}' onclick=\"parent.setDatosCliente('{$user['ClientesId']}');\"></td>
							<td width='100'>{$user['ClientesNumero']}</td>
							<td width='100'>{$user['ClientesCUIT']}</td>
							<td width='350' align='left'>{$user['ClientesRazonSocial']}</td>
							<td width='100' align='left'>{$user['ClientesDomicilio']}</td>
						  </tr>";			
			}			
		}
		
		//$mysql_gx->disconnect();
		
		$table .= "</table>";
		//$oRespuesta->alert($table);
		$oRespuesta->assign("resultado_busqueda","innerHTML",$table);
		
		return $oRespuesta;	
	}
	
	
	function setDatosCliente($idCliente){
		GLOBAL $oMysql;		
		//$mysql_gx = new MySql();	
		/*$mysql_gx->setServer('192.168.2.8','griva','grivasi');
		$mysql_gx->setDBName('grivasoluciones');		*/	
		$oRespuesta = new xajaxResponse();	
		
		$sub_query = " WHERE Clientes.ClientesId = {$idCliente}";
		//$aDatos = $mysql_gx->selectRow("SELECT Clientes.*,
		$aDatos = $oMysql->consultaSel("SELECT Clientes.*,
					DATE_FORMAT(Clientes.ClientesFechaNaciemiento, '%d/%m/%Y') as 'ClientesFechaNaciemientoFormat', 
					DATE_FORMAT(Clientes.ClientesFechaIngresoLaboral, '%d/%m/%Y') as 'ClientesFechaIngresoLaboralFormat'
					FROM ".BASEGX.".Clientes " . $sub_query,true);
		if($aDatos){
			$aDatosConyugue = array();
			$aDatosConyugue = explode(" ",$aDatos['ClientesConyugue']);
			if($aDatos['ClientesNombreFantasia'] == "") //Si no tiene nombre de Fantasia entonces es una Persona Fisica
				$sScript = "setearCampos(1)";
			else 
				$sScript = "setearCampos(2)";
			$oRespuesta->script($sScript);	
			$oRespuesta->assign("tablaSolicitud","style.display","inline");
			$oRespuesta->assign("hdnIdCliente","value",$aDatos['ClientesId']);
			$oRespuesta->assign("sApellido","value",$aDatos['ClientesApellido']);
			$oRespuesta->assign("sNombre","value",$aDatos['ClientesNombre']);
			$oRespuesta->assign("sDocumento","value",$aDatos['ClientesDNI']);
			$oRespuesta->assign("dFechaNacimiento","value",$aDatos['ClientesFechaNaciemientoFormat']);
			$oRespuesta->assign("idEstadoCivil","value",$aDatos['ClientesEstadoCivil']);
			$oRespuesta->assign("sNombreConyuge","value",$aDatosConyugue[0]);
			$oRespuesta->assign("sApellidoConyuge","value",$aDatosConyugue[1]);			
			$oRespuesta->assign("sRazonSocial","value",$aDatos['ClientesRazonSocial']);
			$oRespuesta->assign("sCuit","value",$aDatos['ClientesCUIT']);
			$oRespuesta->assign("idCondicionAFIPLab","value",$aDatos['ClientesCondicionIVA']);
			$oRespuesta->assign("sBarrioTitu","value",$aDatos['ClientesBarrio']);
			$oRespuesta->assign("sBarrioResumen","value",$aDatos['ClientesBarrio']);			
			$oRespuesta->assign("sCalleTitu","value",$aDatos['ClientesDomicilio']);
			$oRespuesta->assign("sCalleResumen","value",$aDatos['ClientesDomicilio']);
			$oRespuesta->assign("sTelParticularFijoNumero","value",$aDatos['ClientesTelefonoFijo']);
			$oRespuesta->assign("sTelParticularMovilNumero","value",$aDatos['ClientesCelular']);
			$oRespuesta->assign("sMail","value",$aDatos['ClientesEmail']);
			$oRespuesta->assign("sTelContactoNumero","value",$aDatos['ClientesNumerosContactos']);
			$oRespuesta->assign("idCondicionLaboral","value",$aDatos['ClientesTipoEmpleo']);
			$oRespuesta->assign("sActividad","value",$aDatos['ClientesRubro']);
			$oRespuesta->assign("sCargo1","value",$aDatos['ClientesCargo']);
			$oRespuesta->assign("sRazonSocialLab","value",$aDatos['ClientesNombreEmpleador']);
			$oRespuesta->assign("sRazonSocialLab","value",$aDatos['ClientesNombreEmpleador']);
			$oRespuesta->assign("dFechaIngreso1","value",$aDatos['ClientesFechaIngresoLaboralFormat']);
			$oRespuesta->assign("sCuitEmpleador","value",$aDatos['ClientesCUITEmpleador']);
			$oRespuesta->assign("fIngresoNetoMensual1","value",$aDatos['ClientesIngresMensual']);
			$oRespuesta->assign("sCalleLab","value",$aDatos['ClientesDomicilioLaboral']);			
			$oRespuesta->assign("sTelLaboral1Numero","value",$aDatos['ClientesTelefonoLaboral']);
		}
		
		//$mysql_gx->disconnect();
		return $oRespuesta;	
	}
	
	/************** Funciones de Planilla de Cobranzas **************/
	function generarPanilla($form){
		global $oMysql;
		$oRespuesta = new xajaxResponse();	
		
		$sCondicion = "";
		$iDiarios=0;
		$aCondicions = array();
		if(isset($form['chkDiarios'])){
			$iDiarios=1;
			$aCondicions[] = " Cupones.NotasPedidosFormaPago = 1 ";
		}
		$iSemanales=0;
		if(isset($form['chkSemanales'])){
			$iSemanales=1;
			$aCondicions[] = " Cupones.NotasPedidosFormaPago = 2 ";
		}
		$iMensuales=0;
		if(isset($form['chkMensuales'])){
			$iMensuales=1;
			$aCondicions[] = " Cupones.NotasPedidosFormaPago = 3 ";
		}
		$sCondicions = implode("OR", $aCondicions);
			
		$dFechaCobro = $form['dFechaInicio'];
		$sCondicion = "Cupones.idCobrador='{$form['idCobrador']}' AND Cupones.sEstado='N' AND ($sCondicions)";
		//$oRespuesta->alert($sCondicion);
		$aClientes= $oMysql->consultaSel("CALL usp_getClientesCobros(\"$sCondicion\",\"\",\"\",\"\",\"$dFechaCobro\");");
		if(count($aClientes)>0){
			$arrayFecha = explode("/",$dFechaCobro);
			$diaCobro1 = mktime(0, 0, 0, $arrayFecha[1], $arrayFecha[0],$arrayFecha[2]);
			
			$diaSemana = date("w",$diaCobro1);
			if($diaSemana == 0) //=0 es Domingo
				$diaCobro1 = mktime(0, 0, 0, $arrayFecha[1], $arrayFecha[0]+1,$arrayFecha[2]);

			$segundoDiaCobro = 	date("d",$diaCobro1)+1;
			$diaCobro2 = mktime(0,0,0,date("m",$diaCobro1),$segundoDiaCobro,date("Y",$diaCobro1));
			$diaSemana = date("w",$diaCobro2);
			if($diaSemana == 0) //=0 es Domingo
				$diaCobro2 = mktime(0,0,0,date("m",$diaCobro1),$segundoDiaCobro+1,date("Y",$diaCobro1));
			
			$tercerDiaCobro = date("d",$diaCobro2)+1;
			$diaCobro3 = mktime(0,0,0,date("m",$diaCobro2),$tercerDiaCobro,date("Y",$diaCobro2));
			$diaSemana = date("w",$diaCobro3);
			if($diaSemana == 0) //=0 es Domingo
				$diaCobro3 = mktime(0,0,0,date("m",$diaCobro2),$tercerDiaCobro+1,date("Y",$diaCobro2));	
			$diaCobro1_format = date("Y-m-d", $diaCobro1);	
			$diaCobro2_format = date("Y-m-d", $diaCobro2);
			$diaCobro3_format = date("Y-m-d", $diaCobro3);
			//$oRespuesta->alert($diaCobro1_format."   ".$diaCobro2_format."   ".$diaCobro3_format);
			
			$setCobranza = "idCobrador,iDiarios,iSemanales,iMensuales,fTotalDiarios,fTotalSemanales,fTotalMensuales,idEstadoCobranza,fDeuda,idUsuario,dFechaCobranza1,dFechaCobranza2,dFechaCobranza3,dFechaRegistro";
			$valuesCobranza = "'{$form['idCobrador']}','{$iDiarios}','{$iSemanales}','{$iMensuales}',0,0,0,1,0,'{$_SESSION['id_user']}','{$diaCobro1_format}','{$diaCobro2_format}','{$diaCobro3_format}',NOW()";
			$ToAuditry = "Insercion de Planilla de Cobranza :::ID_ USER:'{$_SESSION['id_user']}'";
			$idCobranza = $oMysql->consultaSel("CALL usp_InsertTable(\"PlanillasCobranzas\",\"$setCobranza\",\"$valuesCobranza\",\"{$_SESSION['id_user']}\",\"0\",\"$ToAuditory\");",true);					
			
			$setDetalle = "(idCupon,idPlanillaCobranza,idPlanPago,dFechaCobro,fMonto,fMontoPago1,fMontoPago2,fMontoPago3)";
			$valuesDetalle = "";
			$array=array();			
			foreach ($aClientes as $aItem ){			
				$array[] = "('{$aItem['id']}','{$idCobranza}','{$aItem['idPlanPago']}','$diaCobro1_format','{$aItem['fMonto']}',0,0,0)";
			}				
			$valuesDetalle = implode(',',$array);
			$sqlDetalle = "INSERT INTO DetallesPlanillasCobranzas {$setDetalle} VALUES {$valuesDetalle}";
			//$oRespuesta->alert($sqlDetalle);
			$oMysql->startTransaction();
			$oMysql->consultaAff($sqlDetalle);
			$oMysql->commit();
			
			$iCodigo = 1000 + $idCobranza;
			$sqlCobranza = "UPDATE PlanillasCobranzas SET PlanillasCobranzas.sCodigo='{$iCodigo}' WHERE PlanillasCobranzas.id ='{$idCobranza}'";
			$oMysql->startTransaction();
			$oMysql->consultaAff($sqlCobranza);
			$oMysql->commit();
		}
		$oRespuesta->alert("La Planilla de Cobranza se genero correctamente");
		$diaCobro1_format_html = date("d/m/Y", $diaCobro1);
		$diaCobro2_format_html = date("d/m/Y", $diaCobro2);		
		$diaCobro3_format_html = date("d/m/Y", $diaCobro3);
		
		$sCobrador = $oMysql->consultaSel("SELECT CONCAT(Empleados.sApellido,', ',Empleados.sNombre) as 'sCobrador' FROM Empleados WHERE id='{$form['idCobrador']}'",true);
		$oRespuesta->assign("hdnCobrador","value",$sCobrador);
  	    $oRespuesta->assign("hdnResponsable","value",$_SESSION['id_user']);  	  
		return $oRespuesta;
	}
	
	
	function generarPanillaUnaFecha($form){
		global $oMysql;
		$oRespuesta = new xajaxResponse();	
		
		$dFechaCobro = $form['dFechaInicio'];
		$sCondicion = "Cupones.idCobrador='{$form['idCobrador']}' and Cupones.sEstado='N'";
		$aClientes= $oMysql->consultaSel("CALL usp_getClientesCobros(\"$sCondicion\",\"\",\"\",\"\",\"$dFechaCobro\");");
		if(count($aClientes)>0){
			$iDiarios=0;
			if(isset($form['chkDiarios']))$iDiarios=1;
			$iSemanales=0;
			if(isset($form['chkSemanales']))$iSemanales=1;
			$iMensuales=0;
			if(isset($form['chkMensuales']))$iMensuales=1;
	
			$arrayFecha = explode("/",$dFechaCobro);
			$diaCobro1 = mktime(0, 0, 0, $arrayFecha[1], $arrayFecha[0],$arrayFecha[2]);
			
			$diaSemana = date("w",$diaCobro1);
			if($diaSemana == 0) //=0 es Domingo
				$diaCobro1 = mktime(0, 0, 0, $arrayFecha[1], $arrayFecha[0]+1,$arrayFecha[2]);

			$diaCobro1_format = date("Y-m-d", $diaCobro1);	
			
			$setCobranza = "idCobrador,iDiarios,iSemanales,iMensuales,fTotalDiarios,fTotalSemanales,fTotalMensuales,idEstadoCobranza,fDeuda,idUsuario,dFechaCobranza1,dFechaRegistro";
			$valuesCobranza = "'{$form['idCobrador']}','{$iDiarios}','{$iSemanales}','{$iMensuales}',0,0,0,1,0,'{$_SESSION['id_user']}','{$diaCobro1_format}',NOW()";
			$ToAuditry = "Insercion de Planilla de Cobranza :::ID_ USER:'{$_SESSION['id_user']}'";
			$idCobranza = $oMysql->consultaSel("CALL usp_InsertTable(\"PlanillasCobranzas\",\"$setCobranza\",\"$valuesCobranza\",\"{$_SESSION['id_user']}\",\"0\",\"$ToAuditory\");",true);					
			
			$setDetalle = "(idCupon,idPlanillaCobranza,idPlanPago,dFechaCobro,fMonto,fMontoPago1,fMontoPago2,fMontoPago3)";
			$valuesDetalle = "";
			$array=array();			
			foreach ($aClientes as $aItem ){			
				$array[] = "('{$aItem['id']}','{$idCobranza}','{$aItem['idPlanPago']}','$diaCobro1_format','{$aItem['fMonto']}',0,0,0)";
			}				
			$valuesDetalle = implode(',',$array);
			$sqlDetalle = "INSERT INTO DetallesPlanillasCobranzas {$setDetalle} VALUES {$valuesDetalle}";
			$oMysql->startTransaction();
			$oMysql->consultaAff($sqlDetalle);
			$oMysql->commit();
			
			$iCodigo = 1000 + $idCobranza;
			$sqlCobranza = "UPDATE PlanillasCobranzas SET PlanillasCobranzas.sCodigo='{$iCodigo}' WHERE PlanillasCobranzas.id ='{$idCobranza}'";
			$oMysql->startTransaction();
			$oMysql->consultaAff($sqlCobranza);
			$oMysql->commit();
		}
		$oRespuesta->alert("La Planilla de Cobranza se genero correctamente");
		$diaCobro1_format_html = date("d/m/Y", $diaCobro1);
		$diaCobro2_format_html = date("d/m/Y", $diaCobro2);		
		$diaCobro3_format_html = date("d/m/Y", $diaCobro3);
		
		$sCobrador = $oMysql->consultaSel("SELECT CONCAT(Empleados.sApellido,', ',Empleados.sNombre) as 'sCobrador' FROM Empleados WHERE Empleados.id='{$form['idCobrador']}'",true);
		$oRespuesta->assign("hdnCobrador","value",$sCobrador);
  	    $oRespuesta->assign("hdnResponsable","value",$_SESSION['id_user']);
  	    
		//idEstadoCobranza=1 ->pendiente
		//$oRespuesta->script("setDatosDetalleCobranza({$idCobranza},'{$diaCobro1_format_html}','','',{$iCodigo},1)");
		return $oRespuesta;
	}
		
	function CargarDatosCobranza($idCobranza){
		global $oMysql;
		$oRespuesta = new xajaxResponse();	
		
		$sConditions = "PlanillasCobranzas.id = '$idCobranza'";	   
   
  	    $aCobranza= $oMysql->consultaSel("CALL usp_getPlanillasCobranzas(\"$sConditions\",\"\",\"\",\"\");",true);
  	    $sCodigo = $aCobranza['sCodigo'];
  	    $dFechaCobranza1 = $aCobranza['dFechaCobranza1'];
  	    $dFechaCobranza2 = $aCobranza['dFechaCobranza2'];
  	    $dFechaCobranza3 = $aCobranza['dFechaCobranza3'];
  	    
  	    $oRespuesta->assign("hdnCobrador","value",$aCobranza['sCobrador']);
  	    $oRespuesta->assign("hdnIdCobrador","value",$aCobranza['idCobrador']); 
  	    $oRespuesta->assign("hdnResponsable","value",$aCobranza['idUsuario']);
  	    //$oRespuesta->alert($idCobranza);
  	    $oRespuesta->script("setDatosDetalleCobranza({$idCobranza},'{$dFechaCobranza1}','{$dFechaCobranza2}','{$dFechaCobranza3}',{$sCodigo},{$aCobranza['idEstadoCobranza']})");
		return $oRespuesta;
	}
	
	function imprimirPlanilla($form){
		global $oMysql;
		$oRespuesta = new xajaxResponse();
		$hoy = date("d/m/Y");
		$sCobrador = $form["hdnCobrador"];		
		$sResponsable = $oMysql->consultaSel("SELECT CONCAT(usuarios.sApellido,', ',usuarios.sNombre) as 'sResponsable' FROM usuarios WHERE usuarios.id = '{$form["hdnResponsable"]}'" ,true);
		
		$html = "";
		$html .="<table cellpadding='0' cellspacing='0' style='font-size:12px;font-family: Tahoma;border-collapse:collapse;border:1px solid #000000'>
				<tr>
					<td style='border-bottom:1px solid #000000'>CODIGO: ".$form['hdnCodigo']."</td>
					<td style='border-bottom:1px solid #000000;padding-left:100px'>Fecha: ".$hoy."</td>
				</tr>
				<tr>
					<td style='border-bottom:1px solid #000000'>Responsable: ".$sResponsable."</td>
					<td style='border-bottom:1px solid #000000;padding-left:100px'>Cobrador: ".$sCobrador."</td>
				</tr>";		
		/*************** DIARIOS **************/
		$arrayDiarios=array();
		$sConditions_diarios = "DetallesPlanillasCobranzas.idPlanillaCobranza='{$form['idCobranza']}' AND DetallesPlanillasCobranzas.idPlanPago='1'";
		
		$arrayDiarios=$oMysql->consultaSel("CALL usp_getDetallesPlanillasCobranzas(\"$sConditions_diarios\",\"\",\"\",\"\");");
		$htmlTabla1 = ""; $htmlTabla2 ="";
		$cantFilas = count($arrayDiarios);
		
		$html .= "<tr><td colspan='2' style='border:1px solid #000000'> &nbsp;<b>DIARIOS</b> </td></tr>";
				
		$ini = round($cantFilas/2);

		$htmlTabla1 .="<table cellpadding='0' cellspacing='0' style='font-size:10px;font-family: Tahoma;border-collapse:collapse;'>";
		$htmlTabla1 .= imprimirHeader($form['hdnFechaCobro1'],$form['hdnFechaCobro2'],$form['hdnFechaCobro3']);
		
		$imprimirSolaFecha = true;
		if(($form['hdnFechaCobro2'] !="")&&($form['hdnFechaCobro3'] !="")){
			$imprimirSolaFecha = false;
		}
		$htmlTabla1 .= imprimirClientesCobros($arrayDiarios,$ini,0,$imprimirSolaFecha);
		$htmlTabla1 .= "</table>";
		
		$htmlTabla2 .="<table cellpadding='0' cellspacing='0' style='font-size:10px;font-family: Tahoma;border-collapse:collapse;'>";
		$htmlTabla2 .= imprimirHeader($form['hdnFechaCobro1'],$form['hdnFechaCobro2'],$form['hdnFechaCobro3']);
		$htmlTabla2 .= imprimirClientesCobros($arrayDiarios,$cantFilas-1,$ini+1,$imprimirSolaFecha);
		$htmlTabla2 .= "</table>";
		
		$html .= "<tr>
					<td valign='top' align='left'>".$htmlTabla1."</td><td valign='top' align='left'>".$htmlTabla2."</td>
				 </tr>";
		
		/*************** SEMANALES **************/
		$arraySemanales=array();
		$sConditions_sem = "DetallesPlanillasCobranzas.idPlanillaCobranza='{$form['idCobranza']}' AND DetallesPlanillasCobranzas.idPlanPago='2'";
		
		$arraySemanales=$oMysql->consultaSel("CALL usp_getDetallesPlanillasCobranzas(\"$sConditions_sem\",\"\",\"\",\"\");");
		$html .= "<tr><td colspan=2 style='height:40px;border: solid 1px #000;'>&nbsp;</td></tr>";	
		$html .= "<tr><td colspan=2 style='border:1px solid #000000'> &nbsp;<b>SEMANALES</b> </td></tr>";	
		$htmlTabla1_sem = ""; $htmlTabla2_sem ="";
		$cantFilas_sem = count($arraySemanales);
		$ini_sem = round($cantFilas_sem/2);
		
		$htmlTabla1_sem .="<table cellpadding='0' cellspacing='0' style='font-size:10px;font-family: Tahoma;border-collapse:collapse;'>";
		$htmlTabla1_sem .= imprimirHeader($form['hdnFechaCobro1'],$form['hdnFechaCobro2'],$form['hdnFechaCobro3']);
		$htmlTabla1_sem .= imprimirClientesCobros($arraySemanales,$ini_sem,0,$imprimirSolaFecha);
		$htmlTabla1_sem .= "</table>";
		
		
		$htmlTabla2_sem .="<table cellpadding='0' cellspacing='0' style='font-size:10px;font-family: Tahoma;border-collapse:collapse;'>";
		$htmlTabla2_sem .= imprimirHeader($form['hdnFechaCobro1'],$form['hdnFechaCobro2'],$form['hdnFechaCobro3']);
		$htmlTabla2_sem .= imprimirClientesCobros($arraySemanales,$cantFilas_sem-1,$ini_sem+1,$imprimirSolaFecha);
		$htmlTabla2_sem .= "</table>";
		
		$html .= "<tr>
					<td valign='top' align='left'>".$htmlTabla1_sem."</td><td valign='top' align='left'>".$htmlTabla2_sem."</td>
				 </tr>";
		
		/*************** MENSUALES **************/
		$arrayAnuales=array();
		$sConditions_mens = "DetallesPlanillasCobranzas.idPlanillaCobranza='{$form['idCobranza']}' AND DetallesPlanillasCobranzas.idPlanPago='3'";
		
		$arrayAnuales=$oMysql->consultaSel("CALL usp_getDetallesPlanillasCobranzas(\"$sConditions_mens\",\"\",\"\",\"\");");
		$html .= "<tr><td colspan=2 style='height:30px;border: solid 1px #000;'>&nbsp;</td></tr>";	
		$html .= "<tr><td colspan=2 style='border:1px solid #000000'> &nbsp;<b>MENSUALES</b> </td></tr>";
		
		$cantFilas_mens = count($arrayAnuales);
		$htmlTabla_mens = "";
		$htmlTabla_mens .="<table cellpadding='0' cellspacing='0' style='font-size:10px;font-family: Tahoma;border-collapse:collapse;'>";
		$htmlTabla_mens .= imprimirHeader($form['hdnFechaCobro1'],$form['hdnFechaCobro2'],$form['hdnFechaCobro3']);
		$htmlTabla_mens .= imprimirClientesCobros($arrayAnuales,$cantFilas_mens-1,0,$imprimirSolaFecha);
		$htmlTabla_mens .= "</table>";
		
		$total_diarios=$oMysql->consultaSel("SELECT IFNULL(SUM(fMonto),0) as 'total_diarios' FROM DetallesPlanillasCobranzas WHERE DetallesPlanillasCobranzas.idPlanillaCobranza='{$form['idCobranza']}' AND DetallesPlanillasCobranzas.idPlanPago='1'",true);
		$total_sem=$oMysql->consultaSel("SELECT IFNULL(SUM(fMonto),0) as 'total_sem' FROM DetallesPlanillasCobranzas WHERE DetallesPlanillasCobranzas.idPlanillaCobranza='{$form['idCobranza']}' AND DetallesPlanillasCobranzas.idPlanPago='2'",true);
		$total_mens=$oMysql->consultaSel("SELECT IFNULL(SUM(fMonto),0) as 'total_mens' FROM DetallesPlanillasCobranzas WHERE DetallesPlanillasCobranzas.idPlanillaCobranza='{$form['idCobranza']}' AND DetallesPlanillasCobranzas.idPlanPago='3'",true);

		//$fTotal = $total_diarios + $total_sem/6 + $total_mens/22;
		$fTotal = $total_diarios + $total_sem + $total_mens;
		$fTotal45 = (45*$fTotal)/100;
		$htmlTabla_totales = "";
		$htmlTabla_totales .="<table cellpadding='0' cellspacing='0' style='font-size:10px;font-family: Tahoma;border-collapse:collapse;'>";
		$htmlTabla_totales .= "<tr><td>Total Cobranza:</td><td>$&nbsp;".formatMoney($fTotal,0,'.','')."</td></tr>";
		$htmlTabla_totales .= "<tr><td>Total Cobranza(45%):</td><td>$&nbsp;".formatMoney($fTotal45,0,'.','')."</td></tr>";
		$htmlTabla_totales .= "</table>";		
		
		$html .= "<tr>
					<td valign='top' align='left'>".$htmlTabla_mens."</td><td align='center' style='padding-top:10px'>".$htmlTabla_totales."</td>
				 </tr>";
		
		$html .= "</table>";
		//$oRespuesta->alert($html);
		$oRespuesta->assign("impresiones","innerHTML",$html);
		$oRespuesta->script("window.print();");
		return $oRespuesta;
	}
	
	function CargarCobranzaActual($idPlanillaCobranza){
		global $oMysql;
		$oRespuesta = new xajaxResponse();
		//$dFechaCobranza_format = "11/09/2010";
		$dFechaCobranza_format = date("d/m/Y");
		$dFechaCobranza = dateFormatMysql($dFechaCobranza_format);
		/*
		$sConditions = "DATE(cobranzas.dFechaCobranza1) = DATE('{$dFechaCobranza}') 
						OR DATE(cobranzas.dFechaCobranza2) = DATE('{$dFechaCobranza}') 
						OR DATE(cobranzas.dFechaCobranza3) = DATE('{$dFechaCobranza}')";	
		*/
		$sOrder = "PlanillasCobranzas.dFechaRegistro";
		$sOffset = 0;   
		$sNum = 1;   
		$sConditions = "PlanillasCobranzas.id={$idPlanillaCobranza}";	   
   
  	    $aCobranza= $oMysql->consultaSel("CALL usp_getPlanillasCobranzas(\"$sConditions\",\"$sOrder\",\"$sOffset\",\"$sNum\");",true);
  	    //$oRespuesta->alert($sConditions);  	  
  	    $sCodigo = $aCobranza['sCodigo'];
  	    $dFechaCobranza1 = $aCobranza['dFechaCobranza1'];
  	    $dFechaCobranza2 = $aCobranza['dFechaCobranza2'];
  	    $dFechaCobranza3 = $aCobranza['dFechaCobranza3'];  	    
  	    
  	    $oRespuesta->assign("divFechaActual","innerHTML",$dFechaCobranza_format);
  	    $oRespuesta->script("setDatosDetalleCobranza({$idPlanillaCobranza},'{$dFechaCobranza1}','{$dFechaCobranza2}','{$dFechaCobranza3}',{$sCodigo})");
		return $oRespuesta;
	}
	
	function updatePlanillaCobranza($form,$idEstadoCobranza){
		global $oMysql;
		$oRespuesta = new xajaxResponse();	
		$msje = "";
		
		switch ($idEstadoCobranza){
			case 2:
				$msje = "Se ha Confirmado la Planilla ".$form['hdnCodigo']." correctamente";
				$set= "idEstadoCobranza = '{$idEstadoCobranza}',dFechaRendicion=NOW()";	
				break;
			case 3:
				$msje = "Se Aprobo la Planilla ".$form['hdnCodigo']." correctamente";
				$set= "idEstadoCobranza = '{$idEstadoCobranza}',fTotalCobranza = '{$form['hdnTotal']}'";	
				break;
			case 4:
				$msje = "Se Aprobo la Planilla ".$form['hdnCodigo']." con Deuda $ {$form['deuda']}";
				$set= "idEstadoCobranza = '{$idEstadoCobranza}',fDeuda='{$form['deuda']}',fTotalCobranza = '{$form['hdnTotal']}'";
								
				break;	
			case 5:
				$msje = "Se Anuló la Planilla ".$form['hdnCodigo']." correctamente";
				$set= "idEstadoCobranza = '{$idEstadoCobranza}',fTotalCobranza = '{$form['hdnTotal']}'";
				break;	
		}
			
		$conditions = "PlanillasCobranzas.id = '{$form['idCobranza']}'";		
		$ToAuditry = "Uptate de Planillas de Cobranzas ::: '{$form['idCobranza']}'-USUARIO:'{$_SESSION['id_user']}'";
		$newIdPedido = $oMysql->consultaSel("CALL usp_UpdateTable(\"PlanillasCobranzas\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"0\",\"$ToAuditry\");",true);	
		
		/*if(($idEstadoCobranza == 3)||($idEstadoCobranza == 4)){
			$oMysql->consultaSel("CALL usp_finalizarPlanes();",true);			
		}
		if($idEstadoCobranza == 4){
			//Impactamos en la CtaCte del Cobrador como Debe
			$fHaber = 0;		
			$fDebe =  str_replace(",",".", $form['deuda']);		
			if($fDebe != 0){
				$dFecha = dateFormatMysql(date("d/m/Y"));
				$set= "sDescripcion,dFecha,fDebe,fHaber,sObservacion,dFechaRegistro,idUsuario,idUsuarioCtaCte,idTipoMovimiento,sEstado,idCobranza";
				$values = "'Deuda de Cobranza - Nº Cobranza:{$form['hdnCodigo']}','{$dFecha}','$fDebe}','0','',NOW(),'{$_SESSION['ID_USER']}','{$form['hdnIdCobrador']}',2,'A','{$form['idCobranza']}'";
							
				$ToAuditory = "Se agrego movimiento de Cuenta Corriente al Cobrador id ::: {$form['hdnIdCobrador']}. Importe agregado  Haber:$fHaber-Debe:$fDebe";
				$newId = $oMysql->consultaSel("CALL usp_InsertTable(\"cuentascorrientes\",\"$set\",\"$values\",\"{$_SESSION['ID_USER']}\",\"0\",\"$ToAuditory\");",true);
			}	
		}
		if($idEstadoCobranza == 3){
			//Impactamos en la CtaCte del Cobrador como Haber
			$fDebe =  0;
			$fPorcentaje = $oMysql->consultaSel("SELECT fPorcentajeGanancia FROM usuarios WHERE id={$form['hdnIdCobrador']}",true);
			if($fPorcentaje != 0){
				$fHaber = ($fPorcentaje*$form['hdnTotal'])/100;	
			
				$dFecha = dateFormatMysql(date("d/m/Y"));
				$set= "sDescripcion,dFecha,fDebe,fHaber,sObservacion,dFechaRegistro,idUsuario,idUsuarioCtaCte,idTipoMovimiento,sEstado,idCobranza";
				$values = "'Comision de Cobranza - Nº Cobranza:{$form['hdnCodigo']}','{$dFecha}',{$fDebe},{$fHaber},'',NOW(),'{$_SESSION['ID_USER']}','{$form['hdnIdCobrador']}',4,'A','{$form['idCobranza']}'";							
				$ToAuditory = "Se agrego movimiento de Cuenta Corriente al Cobrador id ::: {$form['hdnIdCobrador']}. Importe agregado  Haber:$fHaber-Debe:$fDebe";
				$newId = $oMysql->consultaSel("CALL usp_InsertTable(\"cuentascorrientes\",\"$set\",\"$values\",\"{$_SESSION['ID_USER']}\",\"0\",\"$ToAuditory\");",true);
			}								
		}*/
		$oRespuesta->alert($msje);
		$oRespuesta->script("resetDatosForm()");
		return $oRespuesta;
	}
	
	function impactarPagos($form,$idEstadoCobranza){
		global $oMysql;
		$oRespuesta = new xajaxResponse();	
		
		$conditions = "PlanillasCobranzas.id = '{$form['idCobranza']}'";
		$aCobranza = $oMysql->consultaSel("CALL usp_getPlanillasCobranzas(\"$conditions\",\"\",\"\",\"\");",true);
		if(count($aCobranza)>0){
						
			$sConditions = "DetallesPlanillasCobranzas.idPlanillaCobranza='{$form['idCobranza']}'";
			$array=$oMysql->consultaSel("CALL usp_getDetallesPlanillasCobranzas(\"$sConditions\",\"\",\"\",\"\");");			
			if(count($array)>0)
			{				
				$dFechaCobranza1 = dateFormatMysql($aCobranza['dFechaCobranza1']);
				if(trim($aCobranza['dFechaCobranza2']) !="")$dFechaCobranza2 = dateFormatMysql($aCobranza['dFechaCobranza2']);
				if(trim($aCobranza['dFechaCobranza3']) !="")$dFechaCobranza3 = dateFormatMysql($aCobranza['dFechaCobranza3']);
				
				foreach ($array as $row){
					$impactarPago1= true;$impactarPago2= true;$impactarPago3= true;								
					//los semanales(2) y mensuales no debe impactar los pagos CEROS
					if(($row['idPlanPago'] == "2")||($row['idPlanPago'] == "3")){
						if(($row['fMontoPago1'] == "")||($row['fMontoPago1'] == "0"))
							$impactarPago1= false;
						if(($row['fMontoPago2'] == "")||($row['fMontoPago2'] == "0")||($aCobranza['dFechaCobranza2'] ==""))
							$impactarPago2= false;
						if(($row['fMontoPago3'] == "")||($row['fMontoPago3'] == "0")||($aCobranza['dFechaCobranza3'] ==""))
							$impactarPago3= false;							
					}
					$fecha = getdate();
					//$iNumCuota = $oMysql->consultaSel("SELECT IFNULL(MAX(cuotas.iNumCuota),0) AS 'iNumCuota' FROM cuotas WHERE idProforma = '{$row['idProforma']}'",true);
					
					if(($impactarPago1)||($impactarPago2)||($impactarPago3)){
						$fMontoTotal = 0;	
						$sNumeroRecibo =$oMysql->consultaSel("select fnc_getNroReciboCobranza(\"{$_SESSION['ID_OFICINA']}\");",true);
						$aNumero = explode('-', $sNumeroRecibo);	
						$sCodigoBarra = $aNumero[0]. $aNumero[1].number_pad($fecha['mday'],2).number_pad($fecha['mon'],2).$fecha['year'].number_pad($fecha['hours'],2).number_pad($fecha['minutes'],2).number_pad($fecha['seconds'],2);
				
						if($impactarPago1){
							$fMontoPago = $row['fMontoPago1'];
						}						
						if($impactarPago2){
							$fMontoPago = $row['fMontoPago2'];
						}
						if($impactarPago3){		
							$fMontoPago = $row['fMontoPago3'];				
						}
						$setCuotas1 = "idCuentaUsuario,idEmpleado,dFechaCobranza,dFechaPresentacion,dFechaRegistro,fImporte,sEstado,iEstadoFacturacionUsuario,idTipoMoneda,sNroRecibo,sCodigoBarra,idOficina";
						$valuesCuotas1 = "'{$row['idCuentaUsuario']}','{$_SESSION['id_user']}',NOW(),NOW(),NOW(),'{$fMontoPago}','A',0,1,'{$sNumeroRecibo}','{$sCodigoBarra}',{$_SESSION['ID_OFICINA']}";
						$sqlCuotas1 = "INSERT INTO Cobranzas({$setCuotas1}) VALUES ({$valuesCuotas1})";
						$oMysql->startTransaction();
						$oMysql->consultaAff($sqlCuotas1);
						$oMysql->commit();	
						$fMontoTotal = $fMontoTotal+$fMontoPago;						
					}
				}
			}			
			$oRespuesta->script("updateCobranza({$idEstadoCobranza})");			
		}
		//$oRespuesta->script("updateCobranza({$idEstadoCobranza})");
		return $oRespuesta;
	}
	
	function impactarPagosUnaFecha($form,$idEstadoCobranza){
		global $oMysql;
		$oRespuesta = new xajaxResponse();	
		
		$conditions = "PlanillasCobranzas.id = '{$form['idCobranza']}'";
		$aCobranza = $oMysql->consultaSel("CALL usp_getPlanillasCobranzas(\"$conditions\",\"\",\"\",\"\");",true);
		if(count($aCobranza)>0){
						
			$sConditions = "DetallesPlanillasCobranzas.idCobranza='{$form['idCobranza']}'";
			$array=$oMysql->consultaSel("CALL usp_getDetallesPlanillasCobranzas(\"$sConditions\",\"\",\"\",\"\");");			
			if(count($array)>0)
			{
				$dFechaCobranza1 = dateFormatMysql($aCobranza['dFechaCobranza1']);
				foreach ($array as $row){
					$impactarPago1= true;			
					
					if(($row['idPlanPago'] == "2")||($row['idPlanPago'] == "3")){
						if(($row['fMontoPago1'] == "")||($row['fMontoPago1'] == "0"))
							$impactarPago1= false;
					}
					//$iNumCuota = $oMysql->consultaSel("SELECT IFNULL(MAX(cuotas.iNumCuota),0) AS 'iNumCuota' FROM cuotas WHERE idProforma = '{$row['idProforma']}'",true);	
					
					if($impactarPago1){
						$fecha = getdate();
						//$iNumCuota=$iNumCuota+1;
						//$setCuotas1 = "iNumCuota,dFechaCobro,fMontoPago,idProforma,idCobranza";
						//$valuesCuotas1 = "'{$iNumCuota}','{$dFechaCobranza1}','{$row['fMontoPago1']}','{$row['idProforma']}','{$form['idCobranza']}'";
						//$sqlCuotas1 = "INSERT INTO cuotas({$setCuotas1}) VALUES ({$valuesCuotas1})";
						$sNumeroRecibo =$oMysql->consultaSel("select fnc_getNroReciboCobranza(\"{$_SESSION['ID_OFICINA']}\");",true);
						$aNumero = explode('-', $sNumeroRecibo);	
						$sCodigoBarra = $aNumero[0]. $aNumero[1].number_pad($fecha['mday'],2).number_pad($fecha['mon'],2).$fecha['year'].number_pad($fecha['hours'],2).number_pad($fecha['minutes'],2).number_pad($fecha['seconds'],2);

						$fMontoPago = $row['fMontoPago1'];
						$setCuotas1 = "idCuentaUsuario,idEmpleado,dFechaCobranza,dFechaPresentacion,dFechaRegistro,fImporte,sEstado,iEstadoFacturacionUsuario,idTipoMoneda,sNroRecibo,sCodigoBarra,idOficina";
						$valuesCuotas1 = "'{$row['idCuentaUsuario']}','{$_SESSION['id_user']}',NOW(),NOW(),NOW(),'{$fMontoPago}','A',0,1,'{$sNumeroRecibo}','{$sCodigoBarra}',{$_SESSION['ID_OFICINA']}";						
						$sqlCuotas1 = "INSERT INTO Cobranzas({$setCuotas1}) VALUES ({$valuesCuotas1})";
						$oMysql->startTransaction();
						$oMysql->consultaAff($sqlCuotas1);
						$oMysql->commit();							
					}
					
					/************* Modificacion:11-02-2011  **************/
					/*$aMargenCredito=$oMysql->consultaSel("SELECT clientes.id,clientes.fMargenCredito FROM pedidos 
							LEFT JOIN clientes ON clientes.id=pedidos.idCliente
							WHERE pedidos.id={$row['idProforma']}",true);
					$fMargenCredito = $aMargenCredito['fMargenCredito'] + $row['fMontoPago1'];
					$sqlCredito = "UPDATE clientes SET fMargenCredito={$fMargenCredito} WHERE id={$afMargenCredito['id']}";
					$oMysql->startTransaction();
					$oMysql->consultaAff($sqlCredito);
					$oMysql->commit();*/	
				}
			}			
			$oRespuesta->script("updateCobranza({$idEstadoCobranza})");			
		}
		return $oRespuesta;
	}
	
	function eliminarCobranza($form){
		global $oMysql;
		$oRespuesta = new xajaxResponse();
		
		$sConditions = "PlanillasCobranzas.id = {$form['idCobranza']}";
		$ToAuditry = "Baja de Planillas de Cobranzas::: {$form['idCobranza']}";
		$set = "PlanillasCobranzas.sEstado='B'";
		$newId = $oMysql->consultaSel("CALL usp_UpdateTable(\"PlanillasCobranzas\",\"$set\",\"$sConditions\",\"{$_SESSION['id_user']}\",\"0\",\"$ToAuditry\");");
		
		$oRespuesta->script("resetDatosForm()");
		return $oRespuesta;		
	}
?>