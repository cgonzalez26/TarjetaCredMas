<?
	function getTagSelectOficinas($idSucursal = null){
		$mysql = new MySql();
		$oRespuesta = new xajaxResponse();		
	
		$where = (is_null($idSucursal)) ? "" : "Oficinas.idSucursal = '$idSucursal'" ;	
		$options = arrayToOptions($mysql->query("CALL usp_getSelect(\"Oficinas\",\"id\",\"sApodo\",\"$where\");"));
		
		$selects = "<select name='idOficina' id='idOficina' style='width:150px;'><option value='0'>[-Selecccionar-]</option>".$options."</select>";		
		
		$oRespuesta->assign('tdOficina','innerHTML',$selects); 
		
		return $oRespuesta;	
		
	}
	#Extra porque no me funciona el js de onchange cuando depentro otro select de este
	function selectOficinas($idSucursal=null){
		$mysql = new MySql();
		$oRespuesta = new xajaxResponse();		
	
		$where = (is_null($idSucursal)) ? "" : "Oficinas.idSucursal = '$idSucursal'" ;	
		$options = arrayToOptions($mysql->query("CALL usp_getSelect(\"Oficinas\",\"id\",\"sApodo\",\"$where\");"));
		
		$selects = "<select name='idOficina' id='idOficina' onchange=\"xajax_getTagSelectUsuarios(this.value)\" style='width:150px;'><option value='0'>[-Selecccionar-]</option>".$options."</select>";		
		$oRespuesta->assign('tdOficina','innerHTML',$selects); 
		
		return $oRespuesta;	
	}

//--------------------------------------------------------------------------------------------------------------

	function Validate($sLogin){
		$mysql = new MySql();
		$oRespuesta = new xajaxResponse();		
		
		$SQL = "SELECT sLogin FROM Usuarios WHERE Usuarios.sLogin = '$sLogin'";
		$estaLogin = (boolean) $mysql->selectValue($SQL);
		if($estaLogin){
			$sms = "<span style='font-weight:bold;color:#990000;'>Login Invalido</span>";
			$oRespuesta->call('estaLogin(1)');
		}else{
			$sms = "<span style='font-weight:bold;color:#336699;'>Login Valido</span>";
			$oRespuesta->call('estaLogin(0)');
		}
		$oRespuesta->assign("LoginValid","innerHTML",$sms);
		
		return $oRespuesta;
	}


	
	
	
function IniciarSession($aDatos){
	GLOBAL $oMysql;
	$oRespuesta = new xajaxResponse();
	
	$aDatos['user']=strtoupper($aDatos['user']);
	if (login($aDatos['user'],$aDatos['pass']))
	{
		$aUsuario=$oMysql->consultaSel("call usp_devolver_session('{$aDatos['user']}')",true);
		$_SESSION['AANTERIOR']=1;
		$_SESSION['id_provi'] = $aUsuario['id_provi'];
		$_SESSION['id_zona'] = $aUsuario['id_zona'];
		$_SESSION['id_suc'] = $aUsuario['id_suc'];
		$_SESSION['id_dep'] = $aUsuario['id_dep'];
		$_SESSION['id_tuser'] = $_SESSION['val_id'] = $aUsuario['id_tuser'];
		$_SESSION['nom_tuser'] = $aUsuario['nom_tuser'];			
		$_SESSION['id_user'] = $aUsuario['id_user'];
		$_SESSION['cod'] = $aUsuario['cod'];
		$_SESSION['nom_suc'] = $aUsuario['nom_suc'];
		$_SESSION['clave'] = $aUsuario['clave'];
		$_SESSION['apodo'] = $aUsuario['apodo'];
		$_SESSION['matricula'] = $aUsuario['matricula'];
		$_SESSION['estado'] = $aUsuario['estado'];					
		$_SESSION['fch'] = $aUsuario['fch'];	
		$_SESSION['login'] = $aUsuario['login'];
		$_SESSION['valid_user'] = $aDatos['user'];	
	    $_SESSION['estado'] = $aUsuario['estado'];
	    $oRespuesta->alert('Se inicio session correctamente. Gracias');
	    if($aDatos['iTipo']==1){
	    	$oRespuesta->script('Buscar();');	
	    } 
	    if($aDatos['iTipo']==2){
	    	$oRespuesta->script('window.location.reload();');
	    }
	    $oRespuesta->script('closeMessage();');
	    
	}else{
		$oRespuesta->alert('No se pudo iniciar session probablemente escribio mal su nombre de usuario o contraseña.\n Intente nuevamente. Gracias');
	} 
	
	//$oRespuesta->addRedirect('../Backend.php');
	
	return  $oRespuesta;
}


function DatosUser($id){
   GLOBAL $oMysql;
   $oRespuesta = new xajaxResponse();
   
   $sConditions = "Usuarios.id = '$id'";
   
   $aUser = $oMysql->consultaSel("CALL usp_getUsuarios(\"$sConditions\",\"\",\"\",\"\");",true); 
   
   $sPermits = stringPermitsUser($id);	   
   //var_export($sPermits);die();
   $oRespuesta->assign('sLogin_','value',$aUser['sLogin']);
   
   if($aUser['sLogin'] != '' && $aUser['sLogin'] != 'NO_NAME'){
   		$oRespuesta->assign('sLogin_','disabled',true);	
   		$oRespuesta->assign('saveUser','value','0');
   }else{
   	$oRespuesta->assign('saveUser','value','1');
   }
   
   $oRespuesta->script("DatosUserBasic('$id','$sPermits')");
   $oRespuesta->assign('sEstado','value',$aUser['sEstado']);
   $oRespuesta->assign('id','value',$aUser['id']);
   
   $Name = $aUser['sNombre'].", ".$aUser['sApellido'];
   $oRespuesta->assign('divNameUser','innerHTML',$Name);
   return $oRespuesta;	
}

function updatePermisosUser($form){
   GLOBAL $oMysql;
   $oRespuesta = new xajaxResponse();   
   
   //$permitUser = $form['permitUser'];
   $permitUserAccesos = $form['permitUserAccesos'];
   $permitUserTarjeta = $form['permitUserTarjeta'];
	
   /*if(trim($permitUser) != ""){
   		$idEmpleadoUnidadNegocio1=$oMysql->consultaSel("SELECT id as 'idEmpleadoUnidadNegocio' FROM EmpleadosUnidadesNegocios WHERE EmpleadosUnidadesNegocios.idEmpleado={$form['id']} AND EmpleadosUnidadesNegocios.idUnidadNegocio=1",true);
   		if(!$idEmpleadoUnidadNegocio1){
	   	 	$sql = "INSERT INTO EmpleadosUnidadesNegocios(idUnidadNegocio,idEmpleado) VALUES(1,{$form['id']})";
	 	  	$oMysql->startTransaction();
			$oMysql->consultaAff($sql);
			$oMysql->commit();
   		}
		$oEmpleado = new Empleado($form['id'],1);
	    $oEmpleado->setPermisosOperador($permitUser,1);	 
   }else{   		
   		$oMysql->consultaSel("DELETE FROM EmpleadosUnidadesNegocios WHERE EmpleadosUnidadesNegocios.idEmpleado={$form['id']} AND EmpleadosUnidadesNegocios.idUnidadNegocio=1",true);
   }*/
   
   if(trim($permitUserTarjeta) != ""){
   		$idEmpleadoUnidadNegocio2=$oMysql->consultaSel("SELECT id as 'idEmpleadoUnidadNegocio' FROM EmpleadosUnidadesNegocios WHERE EmpleadosUnidadesNegocios.idEmpleado={$form['id']} AND EmpleadosUnidadesNegocios.idUnidadNegocio=2",true);
	    if(!$idEmpleadoUnidadNegocio2){
	   	 	$sql = "INSERT INTO EmpleadosUnidadesNegocios(idUnidadNegocio,idEmpleado) VALUES(2,{$form['id']})";
	 	  	$oMysql->startTransaction();
			$oMysql->consultaAff($sql);
			$oMysql->commit();
	    }
  		$oEmpleadoTarjeta = new Empleado($form['id'],2);
	    $oEmpleadoTarjeta->setPermisosOperador($permitUserTarjeta,2);
	}
   else{
   		$oMysql->consultaSel("DELETE FROM EmpleadosUnidadesNegocios WHERE EmpleadosUnidadesNegocios.idEmpleado={$form['id']} AND EmpleadosUnidadesNegocios.idUnidadNegocio=2",true);
   }
   
   if(trim($permitUserAccesos) != ""){
   		$idEmpleadoUnidadNegocio4=$oMysql->consultaSel("SELECT id as 'idEmpleadoUnidadNegocio' FROM EmpleadosUnidadesNegocios WHERE EmpleadosUnidadesNegocios.idEmpleado={$form['id']} AND EmpleadosUnidadesNegocios.idUnidadNegocio=4",true);
   		if(!$idEmpleadoUnidadNegocio4){
	   	 	$sql = "INSERT INTO EmpleadosUnidadesNegocios(idUnidadNegocio,idEmpleado) VALUES(4,{$form['id']})";
	 	  	$oMysql->startTransaction();
			$oMysql->consultaAff($sql);
			$oMysql->commit();
   		}	
		$oEmpleadoAccesos = new Empleado($form['id'],4);
   		$oEmpleadoAccesos->setPermisosOperador($permitUserAccesos,4);
   }else{
   		$oMysql->consultaSel("DELETE FROM EmpleadosUnidadesNegocios WHERE EmpleadosUnidadesNegocios.idEmpleado={$form['id']} AND EmpleadosUnidadesNegocios.idUnidadNegocio=4",true);
   }
   
   $smsMessage = "<span style='font-family:Tahoma;font-size:11px;color:#336699;font-weight:bold;'>- Se registro su operacion</span>";
   $oRespuesta->assign('divMessageUser','innerHTML',$smsMessage);
	   
   return $oRespuesta;		
}

/******************** EMPLEADOS  *********************/
function updateEmpleado($form){
    GLOBAL $oMysql;
    $oRespuesta = new xajaxResponse();   
   
    $form['sNombre'] = strtoupper($form['sNombre']);
    $form['sApellido'] = strtoupper($form['sApellido']);
    $form['sDireccion'] = strtoupper($form['sDireccion']);
    $form['sLogin'] = $form['sLogin'];
    $form['sNombre'] = convertir_especiales_html($form['sNombre']);
    $form['sApellido'] = convertir_especiales_html($form['sApellido']);
    $form['sDireccion'] = convertir_especiales_html($form['sDireccion']);
    $salir = false;    
    if(($form['sLogin'] != $form['hdnLogin'])&&($form['sLogin'] != "")){
    
		$id = $oMysql->consultaSel("SELECT id FROM Empleados WHERE sLogin='{$form['sLogin']}'; ",true);
		//$oRespuesta->alert($id);
		if($id){
			$oRespuesta->alert("El Login del Empleado ya existe, verifique.");	
			$salir = true;
		}
    }
    if(!$salir){
	    if($form['idEmpleado'] == 0){
		    $form['sPassword'] = md5($form['sPassword']);
	  	    $form['sEstado'] = 'A'; 	
	  	    $set = "sNombre,sApellido,sDireccion,sMail,sMovil,sLogin,sPassword,idOficina,idArea,sEstado";
		    $values = "'{$form['sNombre']}','{$form['sApellido']}','{$form['sDireccion']}','{$form['sMail']}','{$form['sMovil']}','{$form['sLogin']}','{$form['sPassword']}','{$form['idOficina']}','{$form['idArea']}','{$form['sEstado']}'";
		    $ToAuditory = "Insercion de Empleado ::: {$form['sApellido']}, {$form['sNombre']}";
		   
		    $idEmpleado = $oMysql->consultaSel("CALL usp_InsertTable(\"Empleados\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"1\",\"$ToAuditory\");",true);   
	
	    }else{
	   		$modificoPassword = false;
	   		if($form['sPassword'] != '' && $form['sPassword'] == $form['sRepeatPassword'] && $form['sPassword'] != '**********'){ 
	   			$modificoPassword = true;
	   			$form['sPassword'] = md5($form['sPassword']); 
	   		}
	   	 	$set = "sNombre = '{$form['sNombre']}',
	        	 sApellido = '{$form['sApellido']}',			 
				 sDireccion = '{$form['sDireccion']}',
				 sMovil = '{$form['sMovil']}',
				 sMail = '{$form['sMail']}',
				 sLogin = '{$form['sLogin']}',
				 idOficina = '{$form['idOficina']}',
				 idTipoEmpleado = '{$form['idTipoEmpleado']}',
				 idArea = '{$form['idArea']}'";
			if($modificoPassword)   	 
				$set .=	", sPassword = '{$form['sPassword']}'";
			$conditions = "Empleados.id = '{$form['idEmpleado']}'";
			$ToAuditory = "Update de Empleados ::: User ={$_SESSION['id_user']} ::: idEmpleado={$form['idEmpleado']}";
	
			$oMysql->consultaSel("CALL usp_UpdateTable(\"Empleados\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"2\",\"$ToAuditory\");",true);   
			$idEmpleado = $form['idEmpleado'];
	    }
	    
	    for($i = 1; $i<=3; $i++){
	    	$idUnidadNegocio = 0;
	    	switch ($i){
	    		case 2: //Tarjeta
	    			$idUnidadNegocio =2;break;		
	    		case 4: //Accesos 
	    			$idUnidadNegocio =4;break;		
	    	}
	    
		    //if($form['idTipoEmpleado'.$i] != 0){
		    	//$oRespuesta->alert($form['idTipoEmpleado'.$i].'----'.$idUnidadNegocio);
		    	
		    	$idEmpleadoUnidadNegocio=$oMysql->consultaSel("SELECT id FROM EmpleadosUnidadesNegocios WHERE EmpleadosUnidadesNegocios.idEmpleado={$idEmpleado} AND EmpleadosUnidadesNegocios.idUnidadNegocio={$idUnidadNegocio}",true);
		    	$sql = "";
				if(!$idEmpleadoUnidadNegocio){
					if($form['idTipoEmpleado'.$i] !=0)/*Insertamos si selecciono un Tipo de Empleado para la Unidad de Negocio*/
			   	 		$sql .= "INSERT INTO EmpleadosUnidadesNegocios(idUnidadNegocio,idEmpleado,idTipoEmpleadoUnidadNegocio) VALUES({$idUnidadNegocio},{$idEmpleado},{$form['idTipoEmpleado'.$i]})";	 	  	
		   		}else{   	
			   	 	$sql .= "UPDATE EmpleadosUnidadesNegocios SET idTipoEmpleadoUnidadNegocio={$form['idTipoEmpleado'.$i]} WHERE idUnidadNegocio={$idUnidadNegocio} AND idEmpleado={$idEmpleado}";
		   		}
		   		if($sql != ""){
			   		//$oRespuesta->alert($sql);
			   		$oMysql->startTransaction();
					$oMysql->consultaAff($sql);
					$oMysql->commit();
		   		}
		    //}
	    }
	    
	    $oRespuesta->alert("La operacion se realizo correctamente");
	    //$oRespuesta->script("resetDatosForm()");
	    $oRespuesta->redirect("Empleados.php");
    }
    return $oRespuesta;			
}


function updateEstadoEmpleado($idEmpleado, $sEstado){
    GLOBAL $oMysql;
    $oRespuesta = new xajaxResponse();   
	
    $set = "sEstado = '{$sEstado}'";
    $conditions = "Empleados.id = '{$idEmpleado}'";
	$ToAuditory = "Update Estado de Empleados ::: User ={$_SESSION['id_user']} ::: idEmpleado={$idEmpleado} ::: estado={$sEstado}";
	
	$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Empleados\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"7\",\"$ToAuditory\");",true);   
	
	$oRespuesta->alert("La operacion se realizo correctamente");
	$oRespuesta->redirect("Empleados.php");
	return $oRespuesta;
}

function  habilitarEmpleados($aform){
	GLOBAL $oMysql;
	
	$oRespuesta = new xajaxResponse();
	$aUsers=$aform['aEmpleado'];
	foreach ($aUsers as $idUser){
	    $set = "sEstado = 'A'";
	    $conditions = "Empleados.id = '{$idUser}'";
		$ToAuditory = "Update Estado de Empleados ::: User ={$_SESSION['id_user']} ::: idEmpleado={$idUser} ::: estado='A'";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Empleados\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"7\",\"$ToAuditory\");",true);   	 		
	}
    $oRespuesta->alert("La operacion se realizo correctamente");
    $sScript=" window.location.reload();";
    $oRespuesta->script($sScript);
	return  $oRespuesta;
}

/******************** FIN-EMPLEADOS  *********************/

/******************** OFICINAS  *********************/

function updateOficina($form)
{
    GLOBAL $oMysql;
    $oRespuesta = new xajaxResponse();  
        
    $form['sDireccion'] = strtoupper($form['sDireccion']);    
    $form['sApodo'] = strtoupper($form['sApodo']);   
    $form['sDireccion'] = $oMysql->escaparCadena($form['sDireccion']);
    $form['sApodo'] = $oMysql->escaparCadena($form['sApodo']);    
    $form['dFechaInicio'] = dateToMySql($form['dFechaInicio']);
    
    $form = _parserCharacters_($form);
    if($form['idOficina'] == 0)
    {    
  	   $form['sEstado'] = 'A'; 	
  	   $set = "
  	   			sDireccion,
  	   			sApodo,
  	   			dFechaInicio,
  	   			idSucursal,
  	   			sEstado,
  	   			iNumeroDependiente,
  	   			idProductor,
  	   			sTelefono,
  	   			iProduccion,
  	   			sCodigoPostal,
  	   			idProvincia,
  	   			idLocalidad,
  	   			sCelular1,
  	   			sCelular2
  	   			";
	   $values = "
	   			'{$form['sDireccion']}',
	   			'{$form['sApodo']}',
	   			'{$form['dFechaInicio']}',
	   			'{$form['idSucursal']}',
	   			'{$form['sEstado']}',
	   			'{$form['iNumeroDependiente']}',
	   			'{$form['idProductor']}',
	   			'{$form['sTelefono']}',
	   			'{$form['iProduccion']}',
	   			'{$form['sCodigoPostal']}',
	   			'{$form['idProvincia']}',
	   			'{$form['idLocalidad']}',
	   			'{$form['sCelular1']}',
	   			'{$form['sCelular2']}'
	   			";
	   $ToAuditory = "Insercion de Oficina ::: {$form['sApodo']}";
	   
	   $id = $oMysql->consultaSel("CALL usp_InsertTable(\"Oficinas\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"3\",\"$ToAuditory\");",true);   
			
    }else{   		
   	 	$set = "
   	 		 sDireccion = '{$form['sDireccion']}',
			 sApodo = '{$form['sApodo']}',
			 dFechaInicio = '{$form['dFechaInicio']}',			 
			 idSucursal = '{$form['idSucursal']}',
			 iNumeroDependiente = '{$form['iNumeroDependiente']}',
			 idProductor = '{$form['idProductor']}',
			 sTelefono = '{$form['sTelefono']}',
			 iProduccion = '{$form['iProduccion']}',
			 sCodigoPostal = '{$form['sCodigoPostal']}',
			 idProvincia = '{$form['idProvincia']}',
			 idLocalidad = '{$form['idLocalidad']}',
			 sCelular1 = '{$form['sCelular1']}',
			 sCelular2 = '{$form['sCelular2']}',
			 iTrabaja = '{$form['iTrabaja']}'
			 ";
		//$oRespuesta->alert($set);
		$conditions = "Oficinas.id = '{$form['idOficina']}'";
		$ToAuditory = "Update de Oficinas ::: User ={$_SESSION['id_user']} ::: idOficina={$form['idOficina']}";
        $sConsulta="CALL usp_UpdateTable(\"Oficinas\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"4\",\"$ToAuditory\");";
		$id = $oMysql->consultaSel($sConsulta,true);   
		
    }
    $oRespuesta->alert("La operacion se realizo correctamente");
    //$oRespuesta->script("resetDatosForm()");
    $oRespuesta->redirect("Oficinas.php");
    return $oRespuesta;			
}

function updateEstadoOficina($idOficina, $sEstado)
{
    GLOBAL $oMysql;
    $oRespuesta = new xajaxResponse();   
    
    $set = "sEstado = '{$sEstado}'";
    $conditions = "Oficinas.id = '{$idOficina}'";
	$ToAuditory = "Update Estado de Oficinas ::: User ={$_SESSION['id_user']} ::: idOficina={$idOficina} ::: estado={$sEstado}";	
	$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Oficinas\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"9\",\"$ToAuditory\");",true);   
	
	$oRespuesta->alert("La operacion se realizo correctamente");
	$oRespuesta->redirect("Oficinas.php");
	return $oRespuesta;
}

function  habilitarOficinas($aform){
	GLOBAL $oMysql;	
	$oRespuesta = new xajaxResponse();
	
	$aSucursal=$aform['aOficina'];
	foreach ($aSucursal as $idOficina){
	    $set = "sEstado = 'A'";
	    $conditions = "Oficinas.id = '{$idOficina}'";
		$ToAuditory = "Update Estado de Oficina ::: User ={$_SESSION['id_user']} ::: idOficina={$idOficina} ::: estado='A'";		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Oficinas\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"9\",\"$ToAuditory\");",true);   	 
		
	}
    $oRespuesta->alert("La operacion se realizo correctamente");
    $sScript=" window.location.reload();";
    $oRespuesta->script($sScript);
    
	return  $oRespuesta;
}
/******************* FIN OFICINAS ***************************/


/******************* SUCURSALES ***************************/

function updateSucursal($form)
{
    GLOBAL $oMysql;
    $oRespuesta = new xajaxResponse();  
        
    $form['sNombre'] = strtoupper($form['sNombre']);
    $form['dFechaInicio'] = dateToMySql($form['dFechaInicio']); 
    $form['sNombre'] = convertir_especiales_html($form['sNombre']);
    $form['iProductor'] = 0;
    if($form['iOtrosDatos'] == 0)
    {
    	$form['idLocalidad'] = 0;
    	$form['fComisionVieja'] = 0;
    	$form['fComisionNueva'] = 0;
    }

    if($form['idSucursal'] == 0)
    {
       $bExiste=$oMysql->comprobarExistencia('Sucursales','sNumeroSucursal',$form['sNumeroSucursal']);		
       	
	   if(!$bExiste)
	   {
	  	   $form['sEstado'] = 'A'; 	
	  	   $set = "sNombre,
	  	   		  dFechaInicio,
	  	   		  idRegion,
	  	   		  sNumeroSucursal,
	  	   		  sEstado,idProvincia,
	  	   		  idLocalidad,
	  	   		  fComisionVieja,
	  	   		  fComisionNueva,
	  	   		  iProductorInterno";
	  	   
		   $values = 
		   		"'{$form['sNombre']}',
		   		'{$form['dFechaInicio']}',
		   		'{$form['idRegion']}',
		   		'{$form['sNumeroSucursal']}',
		   		'{$form['sEstado']}',
		   		'{$form['idProvincia']}',
		   		'{$form['idLocalidad']}',
		   		'{$form['fComisionVieja']}',
		   		'{$form['fComisionNueva']}',
		   		'{$form['iProductor']}'";
		  
		   $ToAuditory = "Insercion de Sucursal ::: Usuario={{$_SESSION['id_user']}} :::sucursal {$form['sNombre']}";
		   $id = $oMysql->consultaSel("CALL usp_InsertTable(\"Sucursales\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"5\",\"$ToAuditory\");",true);   
	
	   }
	   else
	   {
	   		$oRespuesta->alert("- El Numero de Sucursal ya esta asignado. Intente nuevamente");
	   }
		
    }else{   		
    	if($form['num_suc'] != $form['num_suc_old']) $bExiste=$oMysql->comprobarExistencia('Sucursales','sNumeroSucursal',$form['sNumeroSucursal']," id_suc <> {$form['num_suc_old']} ");			
		else $bExiste=false;
		
		if(!$bExiste)
		{
	   	 	$set = "sNombre = '{$form['sNombre']}',			 
	 			 	sNumeroSucursal = '{$form['sNumeroSucursal']}',
				 	dFechaInicio = '{$form['dFechaInicio']}',
				 	idRegion = '{$form['idRegion']}',
				 	idProvincia = '{$form['idProvincia']}',
				 	idLocalidad = '{$form['idLocalidad']}',
				 	iProductorInterno = '{$form['iProductor']}',
				 	fComisionVieja = '{$form['fComisionVieja']}',
				 	fComisionNueva = '{$form['fComisionNueva']}'";
	   	 	
			$conditions = "Sucursales.id = '{$form['idSucursal']}'";
			$ToAuditory = "Update de Sucursales ::: User ={$_SESSION['id_user']} ::: idSucursal={$form['idSucursal']}";	
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Sucursales\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"6\",\"$ToAuditory\");",true);   
		
		}
		else $oRespuesta->alert("- El numero de Sucursal ya esta asignado a otra. Intente nuevamente");
    }
	
    $oRespuesta->alert("La operacion se realizo correctamente");
    $oRespuesta->redirect("Sucursales.php");
    return $oRespuesta;			
}


function updateEstadoSucursal($idSucursal, $sEstado){
    GLOBAL $oMysql;
    $oRespuesta = new xajaxResponse();   
       
    $set = "sEstado = '{$sEstado}'";
    $conditions = "Sucursales.id = '{$idSucursal}'";
	$ToAuditory = "Update Estado de Sucursal ::: User ={$_SESSION['id_user']} ::: idSucursal={$idSucursal} ::: estado={$sEstado}";
	
	$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Sucursales\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"8\",\"$ToAuditory\");",true);   
	
	$oRespuesta->alert("La operacion se realizo correctamente");
	$oRespuesta->redirect("Sucursales.php");
	return $oRespuesta;
}


function  habilitarSucursales($aform){
	GLOBAL $oMysql;	
	$oRespuesta = new xajaxResponse();
	
	$aSucursal=$aform['aSucursal'];
	
	foreach ($aSucursal as $idSucursal){
	    $set = "sEstado = 'A'";
	    $conditions = "Sucursales.id = '{$idSucursal}'";
		$ToAuditory = "Update Estado de Sucursal ::: User ={$_SESSION['id_user']} ::: idSucursal={$idSucursal} ::: estado='A'";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Sucursales\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"8\",\"$ToAuditory\");",true);   	 		
	}

    $oRespuesta->alert("La operacion se realizo correctamente");
    $sScript=" window.location.reload();";
    $oRespuesta->script($sScript);
    
	return  $oRespuesta;
}


function guardarLeyendaSucursales($aform)
{
	GLOBAL $oMysql;	
	$oRespuesta = new xajaxResponse();
		
	$aSucursal=$aform['aSucursal'];
	
	foreach ($aSucursal as $idSucursal)
	{
		//$oRespuesta->alert($idSucursal);
		
	    $set = "sLeyenda = '{$aform['sLeyenda']}'";
	    $conditions = "Sucursales.id = '{$idSucursal}'";
		$ToAuditory = "Update Leyenda de Sucursal ::: User ={$_SESSION['id_user']} ::: idSucursal={$idSucursal} ::: Leyenda='{$aform['sLeyenda']}'";
		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Sucursales\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"0\",\"$ToAuditory\");",true);   	 
	}

    $oRespuesta->alert("La operacion se realizo correctamente");
   	$oRespuesta->redirect("SucursalesLeyenda.php");
    
	return  $oRespuesta;
}


/******************* FIN SUCURSALES ***************************/

/******************* OBJETOS DE SISTEMA ***************************/

function updateObjeto($form)
{
    GLOBAL $oMysql;
    $oRespuesta = new xajaxResponse();  
        
    $form['sUrl'] = convertir_especiales_html($form['sUrl']);
    $form['iOrder'] = $form['iOrder'];
    $form['sClass'] = convertir_especiales_html($form['sClass']);
    $form['sImage'] = convertir_especiales_html($form['sImage']);
    $idObjeto = 0;
    
    if(!$form['bItemVisible']) $form['bItemVisible'] = 0;
    
    if($form['idObjeto'] == 0)
    {
  	   $form['sEstado'] = 'A'; 	
  	   $set = "idTipoObjeto, idUnidadNegocio, sNombre, sCodigoObjeto, sUrl, sClass, sImage, iOrder, bItemVisible";
	   $values = "'{$form['idTipoObjeto']}','{$form['idUnidadNegocio']}','{$form['sNombre']}','{$form['sCodigoObjeto']}','{$form['sUrl']}', '{$form['sClass']}', '{$form['sImage']}', '{$form['iOrder']}','{$form['bItemVisible']}'";
	   $ToAuditory = "Insercion de un Objeto de Sistema ::: Usuario={{$_SESSION['id_user']}}";
	   
	   $idObjeto = $oMysql->consultaSel("CALL usp_InsertTable(\"Objetos\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"10\",\"$ToAuditory\");",true);   
	  	    		
    }else{   		
    	$idObjeto = $form['idObjeto'];
   	 	$set = "idTipoObjeto = '{$form['idTipoObjeto']}',
   	 			idUnidadNegocio = '{$form['idUnidadNegocio']}',	
   	 			sNombre = '{$form['sNombre']}',			 
			 	sCodigoObjeto = '{$form['sCodigoObjeto']}',
 			 	sUrl = '{$form['sUrl']}',
			 	sClass = '{$form['sClass']}',
			 	sImage = '{$form['sImage']}',
			 	iOrder = '{$form['iOrder']}',
			 	bItemVisible = '{$form['bItemVisible']}'";   	 	
		$conditions = "Objetos.id = '{$form['idObjeto']}'";
		$ToAuditory = "Update de Objeto de Sistema  ::: Usuario ={$_SESSION['id_user']}";			
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Objetos\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"11\",\"$ToAuditory\");",true);   
    }
    
    $permits = $form['permitObject'];
    $oObjeto = new Objeto($idObjeto);
	$oObjeto->savePermit($permits);
	
    $oRespuesta->alert("La operacion se realizo correctamente");
    $oRespuesta->redirect("Objetos.php");
    return $oRespuesta;			
}

function updateEstadoObjeto($idObjeto, $iEstado){
    GLOBAL $oMysql;
    $oRespuesta = new xajaxResponse();   
	
    //$oRespuesta->alert("entro updateEstadoSucursal");
       
    $set = "bItemVisible = '{$iEstado}'";
    $conditions = "Objetos.id = '{$idObjeto}'";
	$ToAuditory = "Update Estado de Objeto de Sistema ::: User ={$_SESSION['id_user']} ::: estado={$iEstado}";
	
	$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Objetos\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"12\",\"$ToAuditory\");",true);   
	
	$oRespuesta->alert("La operacion se realizo correctamente");
	$oRespuesta->redirect("Objetos.php");
	return $oRespuesta;
}


function AccederUsuario($aForm){
	 GLOBAL $oMysql;
    $oRespuesta = new xajaxResponse();   
    session_start();
    $datos = $oMysql->consultaSel("SELECT id,idOficina,sPassword,sEstado,sLogin,idTipoEmpleado,idArea FROM Empleados WHERE id = '{$aForm['usuario']}'",true);	
    
	
	$_SESSION['id_user'] = $datos['id'];
	$_SESSION['ID_OFICINA'] = $datos['idOficina'];
	$array = $oMysql->consultaSel("SELECT Regiones.id,Regiones.sNumero,Oficinas.idSucursal,Sucursales.sNombre as sSucursal,Oficinas.sApodo as sOficina  
	                               FROM Regiones 
	                               LEFT JOIN Sucursales ON Sucursales.idRegion=Regiones.id 
	                               LEFT JOIN Oficinas ON Oficinas.idSucursal=Sucursales.id 
	                               LEFT JOIN Empleados ON Empleados.idOficina=Oficinas.id WHERE Empleados.id={$datos['id']}",true);
	
	$_SESSION['ID_REGION'] = $array['id'];
	$_SESSION['NUMERO_REGION'] = $array['sNumero'];
	$_SESSION['ID_TIPOEMPLEADO'] = $datos['idTipoEmpleado'];
	$_SESSION['login'] = $datos['sLogin'];
	$_SESSION['id_suc'] = $array['idSucursal'];
	$_SESSION['sSucursal'] = $array['sSucursal'];
	$_SESSION['sOficina'] = $array['sOficina'];
	$_SESSION['sEmpleado'] = $datos['sEmpleado'];
	$_SESSION['AANTERIOR'] = 1;
	
	$sConsulta = "call usp_getAllPermitsUser({$datos['id']})";
	
	$aPermisos = $oMysql->consultaSel($sConsulta,false,'idObjeto');
	
	$_SESSION['_PERMISOS_'] = $aPermisos;
	
							
	$oMysql->consultaSel(" CALL usp_SessionEmpleado('{$datos['id']}','{$datos['idOficina']}','0','{$datos['idTipoEmpleado']}','{$array['id']}','{$datos['sLogin']}','{$array['sNumero']}','0'); ");	
	
	$oRespuesta->redirect("../administrator/");
	return $oRespuesta;
}

?>