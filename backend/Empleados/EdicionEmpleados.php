<?
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );


#Control de Acceso al archivo
//if(!isLogin()){go_url("/index.php");}

$aParametros = array();
$aParametros = getParametrosBasicos(1);

$idTipoDocumento = 0;
$idEstadoCivil = 0;
$idOficina = '0';
$idTipoEmpleado = '0';
$idUnidadNegocio = '0';
$idSucursal = '0';
$idProvincia = 0;
$idLocalidad = 0;
$idArea = '0';
$aParametros['ID_EMPLEADO'] = 0;
$aParametros['LOGIN'] = "";
$aParametros['MASKPASSWORD'] = "";
$aParametros['sType'] = "NEW";

if($_GET['idEmpleado']){
	$sCondiciones = " WHERE Empleados.id = {$_GET['idEmpleado']}";
	$sqlDatos="Call usp_getEmpleados(\"$sCondiciones\");";
	$rs = $oMysql->consultaSel($sqlDatos,true);	
	
	//var_export($rs);
	$aParametros['ID_EMPLEADO'] = $_GET['idEmpleado'];	
	$aParametros['APELLIDO'] = html_entity_decode($rs['sApellido']);
	$aParametros['NOMBRE'] = html_entity_decode($rs['sNombre']);
	$aParametros['FECHA_NACIMIENTO'] = $rs['dFechaNacimiento'];
	$idTipoDocumento = $rs['idTipoDocumento'];
	$aParametros['NUMERO_DOCUMENTO'] = $rs['sNumeroDocumento'];
	$aParametros['CUIL'] = $rs['sCuil'];
	$idEstadoCivil = $rs['idEstadoCivil'];
	$aParametros['DIRECCION'] = html_entity_decode($rs['sDireccion']);//htmlspecialchars_decode($rs['sDireccion']);
	$idProvincia = $rs['idProvincia'];
	$idLocalidad = $rs['idLocalidad'];
	$aParametros['CODIGO_POSTAL'] = $rs['iCodigoPostal'];	
	$aParametros['TELEFONO_PARTICULAR'] = $rs['sTelefonoParticular'];	
	$aParametros['MOVIL'] = $rs['sMovil'];	
	$aParametros['MAIL'] = $rs['sMail'];	
	$aParametros['LOGIN'] = $rs['sLogin'];
	
	$idOficina = $rs['idOficina'];
	$idTipoEmpleado = $rs['idTipoEmpleado'];
	$idSucursal = $rs['idSucursal'];
	$idArea = $rs['idArea'];
	
	$aParametros['TELEFONO_CORPORATIVO'] = $rs['sTelefonoCorporativo'];
	$aParametros['MAIL_CORPORATIVO'] = $rs['sMailCorporativo'];
	
	$aParametros['MASKPASSWORD'] = "**********";
	$aParametros['sType'] = "EDIT";
	
	/*$idTipoEmpleadoUnidadNegocio1 = $oMysql->consultaSel("SELECT EmpleadosUnidadesNegocios.idTipoEmpleadoUnidadNegocio FROM EmpleadosUnidadesNegocios WHERE EmpleadosUnidadesNegocios.idEmpleado={$_GET['idEmpleado']} AND EmpleadosUnidadesNegocios.idUnidadNegocio=1",true);*/
	$idTipoEmpleadoUnidadNegocio2 = $oMysql->consultaSel("SELECT EmpleadosUnidadesNegocios.idTipoEmpleadoUnidadNegocio FROM EmpleadosUnidadesNegocios WHERE EmpleadosUnidadesNegocios.idEmpleado={$_GET['idEmpleado']} AND EmpleadosUnidadesNegocios.idUnidadNegocio=2",true);
	$idTipoEmpleadoUnidadNegocio4 = $oMysql->consultaSel("SELECT EmpleadosUnidadesNegocios.idTipoEmpleadoUnidadNegocio FROM EmpleadosUnidadesNegocios WHERE EmpleadosUnidadesNegocios.idEmpleado={$_GET['idEmpleado']} AND EmpleadosUnidadesNegocios.idUnidadNegocio=4",true);
	//var_export($idTipoEmpleadoUnidadNegocio1.'---'.$idTipoEmpleadoUnidadNegocio2.'---'.$idTipoEmpleadoUnidadNegocio3);
}
	
if($_GET['action'] == 'new'){
	$aParametros['DISPLAY_NUEVO'] = "display:none";
}else{	
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
}

$aParametros['OPTIONS_AREAS'] = $oMysql->getListaOpciones('Areas','id','sNombre',$idArea);
$aParametros['OPTIONS_SUCURSALES'] = $oMysql->getListaOpciones('Sucursales','id','sNombre',$idSucursal);
$aParametros['OPTIONS_OFICINAS'] = $oMysql->getListaOpcionesCondicionado('idSucursal','idOficina','Oficinas','Oficinas.id','Oficinas.sApodo','Oficinas.idSucursal','','',$idOficina);
$aParametros['OPTIONS_TIPO_DOC'] =  $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre', $idTipoDocumento);
$aParametros['OPTIONS_ESTADO_CIVIL'] =  $oMysql->getListaOpciones( 'EstadosCiviles', 'id', 'sNombre', $idEstadoCivil );

$aParametros['OPTIONS_PROVINCIAS'] = $oMysql->getListaOpciones( 'Provincias', 'id', 'sNombre', $idProvincia, '', 'No seleccionar...' );
$aParametros['SCRIPT_LOCALIDADES'] = $oMysql->getListaOpcionesCondicionado( 'idProvincia', 'idLocalidad', 'Localidades', 'id', 'sNombre', 'idProvincia', '', '', $idLocalidad );	


//$aParametros['OPTIONS_UNIDADESNEGOCIOS'] = $oMysql->getListaOpciones('UnidadesNegocios','id','sNombre',$idUnidadNegocio);

/*$aParametros['OPTIONS_TIPOSEMPLEADOS1'] = $oMysql->getListaOpciones('TiposEmpleados LEFT JOIN TiposEmpleadosUnidadesNegocios ON TiposEmpleadosUnidadesNegocios.idTipoEmpleado=TiposEmpleados.id','TiposEmpleadosUnidadesNegocios.id','TiposEmpleados.sNombre',$idTipoEmpleadoUnidadNegocio1,'TiposEmpleadosUnidadesNegocios.idUnidadNegocio=1');*/
$aParametros['OPTIONS_TIPOSEMPLEADOS2'] = $oMysql->getListaOpciones('TiposEmpleados LEFT JOIN TiposEmpleadosUnidadesNegocios ON TiposEmpleadosUnidadesNegocios.idTipoEmpleado=TiposEmpleados.id','TiposEmpleadosUnidadesNegocios.id','TiposEmpleados.sNombre',$idTipoEmpleadoUnidadNegocio2,'TiposEmpleadosUnidadesNegocios.idUnidadNegocio=2');
$aParametros['OPTIONS_TIPOSEMPLEADOS4'] = $oMysql->getListaOpciones('TiposEmpleados LEFT JOIN TiposEmpleadosUnidadesNegocios ON TiposEmpleadosUnidadesNegocios.idTipoEmpleado=TiposEmpleados.id','TiposEmpleadosUnidadesNegocios.id','TiposEmpleados.sNombre',$idTipoEmpleadoUnidadNegocio4,'TiposEmpleadosUnidadesNegocios.idUnidadNegocio=4');

$aParametros['UNIDAD_NEGOCIO2'] = "Tarjeta";
$aParametros['UNIDAD_NEGOCIO4'] = "AccesosSistemas";
$aParametros['DHTMLX_GRID'] = 1;
$aParametros['DHTMLX_GRID_PROCESOR'] = 1;
$aParametros['DHTMLX_MENU'] = 1;
$aParametros['DHTMLX_GRID_FILTER'] = 1;
$aParametros['DHTMLX_CALENDAR'] = 1;
$aParametros['DHTMLX_GRID_FORM'] = 1;

/******************** EMPLEADOS  *********************/
function updateEmpleadoAccesos($form){
    GLOBAL $oMysql;
    $oRespuesta = new xajaxResponse();   
    
    $form['sNombre'] = strtoupper($form['sNombre']);
    $form['sApellido'] = strtoupper($form['sApellido']);
    $form['sDireccion'] = strtoupper($form['sDireccion']);

    $form['sLogin'] = $form['sLogin'];
    $form['sNombre'] = convertir_especiales_html($form['sNombre']);
    $form['sApellido'] = convertir_especiales_html($form['sApellido']);
    $form['sDireccion'] = convertir_especiales_html($form['sDireccion']);    
    $form['dFechaNacimiento'] = dateToMySql($form['dFechaNacimiento']);
    
    $form['sNombre'] = $oMysql->escapeString($form['sNombre']);
    $form['sApellido'] = $oMysql->escapeString($form['sApellido']);
    $form['sDireccion'] = $oMysql->escapeString($form['sDireccion']);
    
    $salir = false;    
    if(($form['sLogin'] != $form['hdnLogin'])&&($form['sLogin'] != "")){
		$id = $oMysql->consultaSel("SELECT id FROM Empleados WHERE sLogin='{$form['sLogin']}'; ",true);
		if($id){
			$oRespuesta->alert("El Login del Empleado ya existe, verifique.");	
			$salir = true;
		}
    }    
    if(!$salir){
    	$idTipoEmpleado = $oMysql->consultaSel("SELECT idTipoEmpleado FROM TiposEmpleadosUnidadesNegocios WHERE id={$form['idTipoEmpleado1']} AND idUnidadNegocio=1",true);
    	
	    if($form['idEmpleado'] == 0){
		    $form['sPassword'] = md5($form['sPassword']);
	  	    $form['sEstado'] = 'A'; 	
	  	    $set = "sNombre,
	  	    		sApellido,
	  	    		dFechaNacimiento,
	  	    		idTipoDocumento,
	  	    		sNumeroDocumento,
	  	    		sCuil,
	  	    		idEstadoCivil,
	  	    		sDireccion,
	  	    		idProvincia,
	  	    		idLocalidad,
	  	    		iCodigoPostal,
	  	    		sTelefonoParticular,
	  	    		sMovil,
	  	    		sMail,
	  	    		sLogin,
	  	    		sPassword,
	  	    		idSucursal,
	  	    		idOficina,
	  	    		idArea,
	  	    		sEstado,
	  	    		sTelefonoCorporativo,
	  	    		sMailCorporativo";
		    $values = "'{$form['sNombre']}',
		    		'{$form['sApellido']}',
		    		'{$form['dFechaNacimiento']}',
		    		'{$form['idTipoDocumento']}',
		    		'{$form['sNumeroDocumento']}',
		    		'{$form['sCuil']}',
		    		'{$form['idEstadoCivil']}',
		    		'{$form['sDireccion']}',
		    		'{$form['idProvincia']}',
		    		'{$form['idLocalidad']}',
		    		'{$form['iCodigoPostal']}',
		    		'{$form['sTelefonoParticular']}',
		    		'{$form['sMovil']}',
		    		'{$form['sMail']}',
		    		'{$form['sLogin']}',
		    		'{$form['sPassword']}',
		    		'{$form['idSucursal']}',
		    		'{$form['idOficina']}',
		    		'{$form['idArea']}',
		    		'{$form['sEstado']}',
		    		'{$form['sTelefonoCorporativo']}',
		    		'{$form['sMailCorporativo']}'";
		    $ToAuditory = "Insercion de Empleado ::: {$form['sApellido']}, {$form['sNombre']}";
		   
		    $idEmpleado = $oMysql->consultaSel("CALL usp_InsertTable(\"Empleados\",\"$set\",\"$values\",\"{$_SESSION['id_user']}\",\"1\",\"$ToAuditory\");",true);  
	    	//$idEmpleado = 99;
	    	
	    	$aRows = explode(',',$form['gridbox_rowsadded']);
			$aRowsDeletes = explode(',',$form['gridbox_rowsdeleted']);		
			//var_export($aForm['gridParentesco_rowsadded']);die();
			foreach ($aRows AS $key => $value){
				if(!in_array($value,$aRowsDeletes ) ){
					$form["gridbox_{$value}_1"] = dateToMySql($form["gridbox_{$value}_1"]);
					$aDetalles_des[] = "(NOW(),'{$form["gridbox_{$value}_1"]}','{$form["gridbox_{$value}_2"]}','A','{$idEmpleado}')";
				}
			}		
			$sCampos = "(dFechaRegistro,dFechaEvento,sDescripcion,sEstado,idEmpleado)";
			$sValores = "";
			if(count($aDetalles_des)>0){
				$sValores = implode(",", $aDetalles_des);
			} 

			if($sValores != ""){
				$oMysql->consultaSel("INSERT INTO EmpleadosObservaciones {$sCampos} VALUES {$sValores}");
			}
			 	  
	    }else{
	   		$modificoPassword = false;
	   		if($form['sPassword'] != '' && $form['sPassword'] == $form['sRepeatPassword'] && $form['sPassword'] != '**********'){ 
	   			$modificoPassword = true;
	   			$form['sPassword'] = md5($form['sPassword']); 
	   		}
	   	 	$set = "sNombre = '{$form['sNombre']}',
	        	 sApellido = '{$form['sApellido']}',	
	        	 dFechaNacimiento = '{$form['dFechaNacimiento']}',		 
	        	 idTipoDocumento = '{$form['idTipoDocumento']}',		 
	        	 sNumeroDocumento = '{$form['sNumeroDocumento']}',		 
	        	 sCuil = '{$form['sCuil']}',		 
	        	 idEstadoCivil = '{$form['idEstadoCivil']}',		 
				 sDireccion = '{$form['sDireccion']}',				 
				 idProvincia = '{$form['idProvincia']}',
				 idLocalidad = '{$form['idLocalidad']}',
				 iCodigoPostal = '{$form['iCodigoPostal']}',
				 sTelefonoParticular = '{$form['sTelefonoParticular']}',
				 sMovil = '{$form['sMovil']}',				 
				 sMail = '{$form['sMail']}',
				 sLogin = '{$form['sLogin']}',
				 idSucursal = '{$form['idSucursal']}',
				 idOficina = '{$form['idOficina']}',
				 idArea = '{$form['idArea']}',
				 sTelefonoCorporativo = '{$form['sTelefonoCorporativo']}',
				 sMailCorporativo = '{$form['sMailCorporativo']}'";
	   	 	
			if($modificoPassword){   	 
				$set .=	", sPassword = '{$form['sPassword']}'";
			}	
			//$oRespuesta->alert($set);	
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
	    			$idUnidadNegocio =3;break;		
	    	}
	    
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
		    }
	    }
	    
    $oRespuesta->alert("La operacion se realizo correctamente");
    $oRespuesta->redirect("Empleados.php");
    
    return $oRespuesta;			
}


function updateEstadoEmpleadoAccesos($idEmpleado, $sEstado){
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

function  habilitarUsuarioAccesos($aform){
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

$oXajax=new xajax();

$oXajax->setCharEncoding('ISO-8859-1');
$oXajax->configure('decodeUTF8Input',true);

$oXajax->registerFunction("updateEmpleadoAccesos");
$oXajax->registerFunction("habilitarUsuarioAccesos");
$oXajax->registerFunction("suspenderUsuarioAccesos");
$oXajax->registerFunction("solicitarCambioPassUsuarioAccesos");
$oXajax->processRequest();
$oXajax->printJavascript("../includes/xajax/");


$aParametros['DHTMLX_WINDOW']=1;
xhtmlHeaderPaginaGeneral($aParametros);	

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Empleados/EdicionEmpleados.tpl",$aParametros);

?>