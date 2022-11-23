<?php

define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );

#Control de Acceso al archivo
//if(!isLogin()){go_url("/index.php");}

$aParametros = array();
$aParametros = getParametrosBasicos(1);

$idSexo = 0;
$idCanal = 0;
$idPromotor = 0;
$idEstadoCivil = 0;
$idNacionalidad = 14;
$idTipoDocumento = 1;
$idBIN = 1;
$idCondicionLaboral = 0;
$idProvincia = 8162; //salta
$idProvinciaResumen = 8162;
$idProvinciaLab = 8162;
$idLocalidad = 8163;
$idLocalidadResumen = 8163; //salta
$idLocalidadLab = 8163;
$idEmpresaCelularTitular = 0;
$idCondicionAFIPLab = 0;
$idSucursal = 0;
$idOficina = 0;
$idEmpleado = 0;

$aParametros['FECHA_PRESENTACION'] = date("d/m/Y");
$aParametros['FECHA_SOLICITUD'] = date("d/m/Y");

$aParametros['ID_SOLICITUD'] = 0;
$aParametros['URL_PRINCIPAL'] = "Solicitudes.php";
$aParametros['MOSTRAR_DAR_ALTA'] = "style='display:none'";	
$aParametros['DOCUMENTO'] = "";
$aParametros['URL_BACK'] = $_GET['url_back'];
$aParametros['VALIDACION_PRESENTACION_SOLICITUD']="if(!validaFechaPresentacion(dFechaPresentacion.value)){
			dFechaSolicitud.focus(); 
		    return false;
		}
		if(!validaFechaSolicitud(dFechaSolicitud.value)){
			dFechaSolicitud.focus(); 
		    return false;
		}";
$aParametros['CODIGO_POSTAL'] = "4400";
$aParametros['CP_RESUMEN'] = "4400"; 
$aParametros['CP_LAB'] = "4400";
$aParametros['SELECTED_PERSONA_FISICA'] = "checked='checked'";
$aParametros['DISABLED_CAMPO'] = "disabled='disabled'";
//$aParametros['MOSTRAR_GUARDAR'] = "style='display:none'";	// se usaba cuando se buscaba el usuario en gx

if($_GET['id']){	
	$aParametros['VALIDACION_PRESENTACION_SOLICITUD']= "";
	
	$sCondiciones = " WHERE SolicitudesUsuarios.id = {$_GET['id']}";
	$sqlDatos="Call usp_getSolicitudes(\"$sCondiciones\");";		
	$rs = $oMysql->consultaSel($sqlDatos,true);
	
	if($rs['iTipoPersona'] == 1){
		$aParametros['SELECTED_PERSONA_FISICA'] = "checked='checked'";
		$aParametros['DISABLED_RAZONSOCIAL'] = "disabled='disabled'";
	}else{
		$aParametros['SELECTED_PERSONA_JURIDICA'] = "checked='checked'";
		$aParametros['DISABLED_RAZONSOCIAL'] = "";
	}
	
	$aParametros['ID_SOLICITUD'] = $_GET['id'];
	$aParametros['FECHA_PRESENTACION'] = $rs['dFechaPresentacion'];
	$aParametros['FECHA_SOLICITUD'] = $rs['dFechaSolicitud'];
	$aParametros['NUMERO_SOLICITUD'] = $rs['sNumero'];
	$aParametros['ID_BIN'] = $rs['idBIN'];
	$idCanal = $rs['idCanal'];
	$idPromotor = $rs['idPromotor'];
	$aParametros['APELLIDO'] = utf8_decode($rs['sApellido']);
	$aParametros['NOMBRE'] = utf8_decode($rs['sNombre']);
	$idEstadoCivil = $rs['idEstadoCivil'];
	$idNacionalidad = $rs['idNacionalidad'];
	$aParametros['RAZON_SOCIAL'] = utf8_decode($rs['sRazonSocial']);
	$aParametros['ID_TIPODOC'] = $rs['idTipoDocumento'];
	$aParametros['DOCUMENTO'] = $rs['sDocumento'];
	$aParametros['CUIT'] = $rs['sCUIT'];
	$aParametros['FECHA_NACIMIENTO'] = $rs['dFechaNacimiento'];
	$idSexo = $rs['idSexo'];
	$aParametros['APELLIDO_CONYUGE'] = utf8_decode($rs['sApellidoConyuge']);
	$aParametros['NOMBRE_CONYUGE'] = utf8_decode($rs['sNombreConyuge']);
	$aParametros['ID_TIPODOC_CONYUGE'] = $rs['idTipoDocumentoConyuge'];
	$aParametros['DOCUMENTO_CONYUGE'] = $rs['sDocumentoConyuge'];
	$aParametros['HIJOS'] = $rs['iHijos'];
	
	$idProvincia = $rs['idProvincia'];
	$idLocalidad = $rs['idLocalidad'];
	$idCondicionIva = $rs['idCondicionIva'];
	$aParametros['CODIGO_POSTAL'] = $rs['sCodigoPostal'];
	$aParametros['EMAIL_LABORAL'] = $rs['sEmailLaboral'];
	$idTipoDgr=$rs['idTiposDgr'];;
	$idTipoImpositivas=$rs['idTiposImpositivas'];	
	
	if($_GET['optionEditar']==2){//PARA LA VISUALIZACION E IMPRESSION
		//ver
		
		$aParametros['CALLE'] = utf8_decode($rs['sCalle']);
		$aParametros['ENTRE_CALLE'] = utf8_decode($rs['sEntreCalle']);
	    $aParametros['BARRIO'] = utf8_decode($rs['sBarrio']);
	    
	    $aParametros['CALLE_RESUMEN'] = utf8_decode($rs['sCalleResumen']);
	    $aParametros['ENTRE_CALLE_RESUMEN'] = utf8_decode($rs['sEntreCalleResumen']);
		$aParametros['BARRIO_RESUMEN'] = utf8_decode($rs['sBarrioResumen']);
	    $aParametros['RAZON_SOCIAL_LAB'] = utf8_decode($rs['sRazonSocialLab']);
	    $aParametros['REPARTICION_LAB'] = utf8_decode($rs['sReparticion']);
		$aParametros['ACTIVIDAD_LAB'] = utf8_decode($rs['sActividad']);
		$aParametros['CALLE_LAB'] = utf8_decode($rs['sCalleLab']);
		$aParametros['BARRIO_LAB'] = utf8_decode($rs['sBarrioLab']);
		$aParametros['CARGO2'] = utf8_decode($rs['sCargo2']);
		$aParametros['REF_CONTACTO'] = utf8_decode($rs['sReferenciaContacto']);
		$aParametros['CARGO1'] =  utf8_decode($rs['sCargo1']);
	}else{
		//editar
		$aParametros['CALLE'] = $rs['sCalle'];
		$aParametros['ENTRE_CALLE'] = $rs['sEntreCalle'];
	    $aParametros['BARRIO'] = $rs['sBarrio'];
	    $aParametros['CALLE_RESUMEN'] = $rs['sCalleResumen'];
	    $aParametros['ENTRE_CALLE_RESUMEN'] = $rs['sEntreCalleResumen'];
		$aParametros['BARRIO_RESUMEN'] = $rs['sBarrioResumen'];
	    $aParametros['RAZON_SOCIAL_LAB'] = $rs['sRazonSocialLab'];
	    $aParametros['REPARTICION_LAB'] = $rs['sReparticion'];
		$aParametros['ACTIVIDAD_LAB'] = $rs['sActividad'];
		$aParametros['CALLE_LAB'] = $rs['sCalleLab'];
		$aParametros['BARRIO_LAB'] = $rs['sBarrioLab'];
		$aParametros['CARGO2'] = $rs['sCargo2'];
		$aParametros['REF_CONTACTO'] = $rs['sReferenciaContacto'];
		$aParametros['CARGO1'] = $rs['sCargo1'];
	}
	
	$aParametros['NUMERO_CALLE'] = $rs['sNumeroCalle'];
	$aParametros['BLOCK'] = $rs['sBlock'];
	$aParametros['PISO'] = $rs['sPiso'];	
	$aParametros['DEPARTAMENTO'] = $rs['sDepartamento'];
	$aParametros['MANZANA'] = $rs['sManzana'];
	$aParametros['LOTE'] = $rs['sLote'];
	$aParametros['GRUPO'] = $rs['sGrupoTitu'];
	$aParametros['CASA'] = $rs['sGrupoTitu'];
	$aParametros['MEDIDOR'] = $rs['sMedidorTitu'];
	$aParametros['OTROS'] = $rs['sOtrosTitu'];
	
	
	$idProvinciaResumen = $rs['idProvinciaResumen'];
	$idLocalidadResumen = $rs['idLocalidadResumen'];
	$aParametros['CP_RESUMEN'] = $rs['sCodigoPostalResumen'];
	
	$aParametros['NUMERO_CALLE_RESUMEN'] = $rs['sNumeroCalleResumen'];
	$aParametros['BLOCK_RESUMEN'] = $rs['sBlockResumen'];
	$aParametros['PISO_RESUMEN'] = $rs['sPisoResumen'];
	$aParametros['DPTO_RESUMEN'] = $rs['sDepartamentoResumen'];
	$aParametros['MANZANA_RESUMEN'] = $rs['sManzanaResumen'];
	$aParametros['LOTE_RESUMEN'] = $rs['sLoteResumen'];
	$aParametros['GRUPO_RESUMEN'] = $rs['sGrupoResumen'];
	$aParametros['CASA_RESUMEN'] = $rs['sCasaResumen'];
	$aParametros['MEDIDOR_RESUMEN'] = $rs['sMedidorResumen'];
	$aParametros['OTROS_RESUMEN'] = $rs['sOtrosResumen'];
	
	
	
	
	$aParametros['CUIT_EMPLEADOR'] = $rs['sCUITEmpleador'];
	$idCondicionAFIPLab = $rs['idCondicionAFIPLab'];
	$idCondicionLaboral = $rs['idCondicionLaboral'];
	
	$aParametros['NUMERO_CALLE_LAB'] = $rs['sNumeroCalleLab'];
	$aParametros['BLOCK_LAB'] = $rs['sBlockLab'];
	$aParametros['PISO_LAB'] = $rs['sPisoLab'];
	$aParametros['OFICINA_LAB'] = $rs['sOficinaLab'];
	
	$aParametros['MANZANA_LAB'] = $rs['sManzanaLab'];
	$idProvinciaLab = $rs['idProvinciaLab'];
	$idLocalidadLab = $rs['idLocalidadLab'];
	$aParametros['CP_LAB'] = $rs['sCodigoPostalLab'];
	
	$aTelefonoLaboral1 = explode("-",$rs['sTelefonoLaboral1']);
	$aParametros['TEL1_PREFIJO'] = $aTelefonoLaboral1[0];
	$aParametros['TEL1_NUMERO'] = $aTelefonoLaboral1[1];
	$aParametros['INTERNO1'] = $rs['sInterno1'];
	$dFechaIngreso1 = "";
	if(($rs['dFechaIngreso1'] != "")&&($rs['dFechaIngreso1'] != "00/00/0000"))
		 $dFechaIngreso1 = $rs['dFechaIngreso1'];
	$aParametros['FECHA_INGRESO1'] = $dFechaIngreso1;
	
	$aParametros['ING_MESUAL1'] = $rs['fIngresoNetoMensual1'];
	$aTelefonoLaboral2 = explode("-",$rs['sTelefonoLaboral2']);
	$aParametros['TEL2_PREFIJO'] = $aTelefonoLaboral2[0];
	$aParametros['TEL2_NUMERO'] = $aTelefonoLaboral2[1];
	$aParametros['INTERNO2'] = $rs['sInterno2'];
	$dFechaIngreso2 = "";
	if(($rs['dFechaIngreso2'] != "")&&($rs['dFechaIngreso2'] != "00/00/0000"))
		 $dFechaIngreso2 = $rs['dFechaIngreso2'];
	$aParametros['FECHA_INGRESO2'] = $dFechaIngreso2;
	
	$aParametros['ING_MESUAL2'] = $rs['fIngresoNetoMensual2'];
	
	$aTelefonoParticularFijo = explode("-",$rs['sTelefonoParticularFijo']);
	$aTelefonoParticularCelular = explode("-",$rs['sTelefonoParticularCelular']);
	
	$aParametros['TEL_PART_FIJO_PREFIJO'] = $aTelefonoParticularFijo[0];
	$aParametros['TEL_PART_FIJO_NUMERO'] = $aTelefonoParticularFijo[1];
	$aParametros['TEL_PART_MOVIL_PREFIJO'] = $aTelefonoParticularCelular[0];
	$aParametros['TEL_PART_MOVIL_NUMERO'] = $aTelefonoParticularCelular[1];
	$idEmpresaCelularTitular = $rs['idEmpresaCelular'];
	
	$aTelefonoContacto = explode("-",$rs['sTelefonoContacto']);
	$aParametros['TEL_CONTACTO_PREFIJO'] = $aTelefonoContacto[0];
	$aParametros['TEL_CONTACTO_NUMERO'] = $aTelefonoContacto[1];
	$aParametros['MAIL'] = $rs['sMail'];
	$aParametros['ID_CLIENTE'] = $rs['idCliente'];
	
	$aParametros['MOSTRAR_BORRAR'] = "style='display:inline'";
	
	if($_GET['optionEditar'] == 3){//editar una solcitud pendiente de aprobacion
		$aParametros['MOSTRAR_DAR_ALTA'] = "style='display:inline'";	
		$aParametros['MOSTRAR_BORRAR'] = "style='display:none'";
		$aParametros['URL_PRINCIPAL'] = "Riesgos.php";
	}	
	if($_GET['optionEditar'] == 4){//editar una solicitud dada de alta
		$aParametros['MOSTRAR_GUARDAR'] = "style='display:inline'";
		$aParametros['MOSTRAR_DAR_ALTA'] = "style='display:none'";	
		$aParametros['MOSTRAR_BORRAR'] = "style='display:inline'";
		$aParametros['URL_PRINCIPAL'] = "Solicitudes.php";
	}	
	
	if($_GET['optionEditar'] ==2){ //Visualizar Solicitud
		$aEmpleado = $oMysql->consultaSel("call usp_getEmpleados(' WHERE Empleados.id={$rs['idCargador']}');",true);
		
		$aParametros['SUCURSAL'] = $aEmpleado['sSucursal'];
		$aParametros['OFICINA'] = $aEmpleado['sOficina'];
		$aParametros['EMPLEADO'] = $aEmpleado['sApellido'].", ".$aEmpleado['sNombre'];
		
		$aParametros['ESTADO_CIVIL'] = $rs['sEstadoCivil'];
		$aParametros['NACIONALIDAD'] = $rs['sNacionalidad'];
		$aParametros['CANAL'] = $rs['sCanal'];
		$aParametros['PROVINCIA'] = $rs['sProvincias'];
		$aParametros['LOCALIDAD'] = $rs['sLocalidad'];
		$aParametros['TIPO_DOCUMENTO'] = $rs['sTipoDocumento'];		
		$aParametros['TIPO_DOCUMENTO_CONYUGE'] = $oMysql->consultaSel("SELECT sNombre FROM TiposDocumentos WHERE id={$rs['idTipoDocumentoConyuge']}",true);	
		$aParametros['PROVINCIA_RESUMEN'] = $oMysql->consultaSel("SELECT sNombre FROM Provincias WHERE id={$rs['idProvinciaResumen']}",true);	
		$aParametros['LOCALIDAD_RESUMEN'] = $oMysql->consultaSel("SELECT sNombre FROM Localidades WHERE id={$rs['idLocalidadResumen']}",true);	
		$aParametros['PROVINCIA_LAB'] = $oMysql->consultaSel("SELECT sNombre FROM Provincias WHERE id={$rs['idProvinciaLab']}",true);	
		$aParametros['LOCALIDAD_LAB'] = $oMysql->consultaSel("SELECT sNombre FROM Localidades WHERE id={$rs['idLocalidadLab']}",true);	
		$aParametros['EMPRESA_CELULAR'] = $rs['sEmpresaCelular'];
		$aParametros['CONDICION_AFIP_LAB'] = $rs['sCondicionAFIP'];
		$aParametros['CONDICION_LAB'] = $rs['sCondicionLaboral'];
		$aParametros['SEXO'] = $rs['sSexo'];
		$aParametros['BIN'] = $rs['sBIN'];
		$aParametros['TEL1'] = $rs['sTelefonoLaboral1'];
		$aParametros['TEL2'] = $rs['sTelefonoLaboral2'];
		$aParametros['TEL_PART_FIJO'] = $rs['sTelefonoParticularFijo'];
		$aParametros['TEL_PART_MOVIL'] = $rs['sTelefonoParticularCelular'];
		$aParametros['TEL_CONTACTO'] = $rs['sTelefonoContacto'];
		$aParametros['MOSTRAR_DAR_ALTA'] = "style='display:none'";
		$aParametros['MOSTRAR_BORRAR'] = "style='display:none'";
		$aParametros['MOSTRAR_GUARDAR'] = "style='display:none'";
		$aParametros['DISPLAY_IMPRIMIR'] = "style='display:inline'";
		
		//$aParametros['TEXTO_CONTRATO'] = 'ESPACIO RESERVADO PARA TERMINOS DE ENTIDAD Y LEGALES';
		$aParametros['TEXTO_CONTRATO'] = parserTemplate( "../includes/Files/Modelos/Contrato.tpl");
		$aParametros['MOSTRAR_ENVIO_DOMICILIO'] = "style='display:none'";
		$aParametros['MOSTRAR_ENVIO_MAIL'] = "style='display:none'";
		if($rs['iEnvioDomicilio'] == 1){
			$aParametros['MOSTRAR_ENVIO_DOMICILIO'] = "style='display:inline'";
		}
		if($rs['iEnvioMail'] == 1){	
			$aParametros['MOSTRAR_ENVIO_MAIL'] = "style='display:inline'";
		}
		$aParametros['MOSTRAR_RAZON_SOCIAL'] = "style='display:none'";
		if(trim($rs['sRazonSocial']) != ""){			
			$aParametros['RAZON_SOCIAL'] = html_entity_decode($rs['sRazonSocial']);
			$aParametros['MOSTRAR_RAZON_SOCIAL'] = "style='display:inline'";
		}
		
		$sProvincia = $oMysql->consultaSel("SELECT Provincias.sNombre FROM Provincias LEFT JOIN Empleados ON Provincias.id=Empleados.idProvincia 
		WHERE Empleados.id={$_SESSION['id_user']}",true);	
	
		$sFecha = strtoupper($sProvincia.", ".strftime("%d DE %B DE %Y"));	
		$aParametros['LUGAR_FECHA_EMPLEADO'] = $sFecha;
	}else{
		//echo $rs['idCargador'];
		$aEmpleado = $oMysql->consultaSel("call usp_getEmpleados(' WHERE Empleados.id={$rs['idCargador']}');",true);		
		$idSucursal = $aEmpleado['idSucursal'];
		//echo $idSucursal;
		$idOficina = $aEmpleado['idOficina'];
		$idEmpleado = $rs['idCargador'];	
	}
	$aParametros['CHECKED_ENVIO_DOMICILIO'] = "";
	$aParametros['CHECKED_ENVIO_MAIL'] = "";
	$aParametros['MOSTRAR_ENVIO_DOMICILIO'] = "style='display:none'";
	$aParametros['MOSTRAR_ENVIO_MAIL'] = "style='display:none'";
	
	if($rs['iEnvioDomicilio'] == 1){
		$aParametros['CHECKED_ENVIO_DOMICILIO'] = "checked='checked'";
		$aParametros['MOSTRAR_ENVIO_DOMICILIO'] = "style='display:inline'";
	}
	if($rs['iEnvioMail'] == 1){		
		$aParametros['CHECKED_ENVIO_MAIL'] = "checked='checked'";
		$aParametros['MOSTRAR_ENVIO_MAIL'] = "style='display:inline'";
	}	
	
	//$aParametros['TEXTO_CONTRATO'] = 'ESPACIO RESERVADO PARA TERMINOS DE ENTIDAD Y LEGALES';
	$aParametros['TEXTO_CONTRATO'] = parserTemplate( "../includes/Files/Modelos/Contrato.tpl");
	$html = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/SegurosSE/VerSolicitud.tpl",$aParametros);
	//$html = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Solicitudes/VerSolicitud.tpl",$aParametros);
	$aParametros['SOLICITUD_CONTRATO'] = $html;
	
}else{
	$aParametros['NUMERO_SOLICITUD'] = "";
	$aParametros['FECHA_PRESENTACION'] = date("d/m/Y");
	$aParametros['FECHA_SOLICITUD'] = date("d/m/Y");
	$aParametros['ID_BIN'] = $idBIN;
	
	$sql  = "SELECT idCanal FROM GruposPromotores WHERE idEmpleado={$_SESSION['id_user']}";
	$idCanal = $oMysql->consultaSel($sql,true);	
	if($idCanal){
		$idPromotor = $_SESSION['id_user'];
	}
}

$aParametros['optionsSucursales'] = $oMysql->getListaOpciones( 'Sucursales', 'Sucursales.id', 'Sucursales.sNombre',$idSucursal,'Sucursales.sEstado = \'A\'', 'Seleccionar..','');
$aParametros['optionsOficinas'] = $oMysql->getListaOpcionesCondicionado( 'idSucursal', 'idOficina','Oficinas', 'Oficinas.id','Oficinas.sApodo','idSucursal','Oficinas.sEstado = \'A\'', '', $idOficina);
$aParametros['optionsEmpleados'] = $oMysql->getListaOpcionesCondicionado('idOficina','idEmpleado','Empleados', 'Empleados.id',"CONCAT(Empleados.sApellido,', ',Empleados.sNombre)",'idOficina','Empleados.sEstado = \'A\'', '', $idEmpleado);

$aParametros['optionsSexos'] = $oMysql->getListaOpciones( 'TiposSexo', 'id', 'sNombre',$idSexo);
$aParametros['optionsNacionalidad'] = $oMysql->getListaOpciones( 'Nacionalidades', 'id', 'sNombre',$idNacionalidad);
$aParametros['optionsTiposIva'] = $oMysql->getListaOpciones( 'CondicionesAFIP', 'id', 'sNombre',$idCondicionAFIPLab);
$aParametros['optionsEstadoCivil'] = $oMysql->getListaOpciones( 'EstadosCiviles', 'id', 'sNombre',$idEstadoCivil);
$aParametros['optionsTipoDoc'] = $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre',$idTipoDocumento);
$aParametros['optionsEmpresasCelulares'] = $oMysql->getListaOpciones( 'EmpresasCelulares', 'id', 'sNombre', $idEmpresaCelularTitular);
$aParametros['optionsProviTitu'] = $oMysql->getListaOpciones('Provincias','id','sNombre',$idProvincia);
$aParametros['optionsProviResumen'] = $oMysql->getListaOpciones('Provincias','id','sNombre',$idProvinciaResumen);
$aParametros['optionsProviLab'] = $oMysql->getListaOpciones('Provincias','id','sNombre',$idProvinciaLab);
$aParametros['optionsBin'] = $oMysql->getListaOpciones('MultiBin','id','sBIN',$idBIN);
$sCondicionesCanal = " Canales.sEstado<>'B' AND Canales.idRegion={$_SESSION['ID_REGION']}";
$aParametros['optionsCanales'] = $oMysql->getListaOpciones('Canales','id','sNombre', $idCanal,$sCondicionesCanal);
$aParametros['optionsCondicionesLab'] = $oMysql->getListaOpciones('CondicionesLaborales','id','sNombre', $idCondicionLaboral);


$aParametros['optionsLocalidades'] = $oMysql->getListaOpcionesCondicionado( 'idProvinciaTitu', 'idLocalidadTitu', 'Localidades', 'id', 'sNombre', 'idProvincia','','',$idLocalidad);
$aParametros['optionsLocalidadesResumen'] = $oMysql->getListaOpcionesCondicionado( 'idProvinciaResumen', 'idLocalidadResumen', 'Localidades', 'id', 'sNombre', 'idProvincia','','',$idLocalidadResumen);
$aParametros['optionsLocalidadesLab'] = $oMysql->getListaOpcionesCondicionado( 'idProvinciaLab', 'idLocalidadLab', 'Localidades', 'id', 'sNombre', 'idProvincia','','',$idLocalidadLab);	

$sCondiciones = " Empleados.sEstado='A'";
$aParametros['optionsEmpleados'] = $oMysql->getListaOpciones('Empleados','id','sNombre','',$sCondiciones);

$aParametros['optionsTiposDgr'] = $oMysql->getListaOpciones('TiposDgr','id','sNombre',$idTipoDgr);
$aParametros['optionsTiposRetencionesImpositivas'] = $oMysql->getListaOpciones('TiposRetencionesImpositivas','id','sNombre',$idTipoImpositivas);
$aParametros['optionsCondiIva'] = $oMysql->getListaOpciones('CondicionesAFIP','id','sNombre',$idCondicionIva);

$aParametros['READONLY_CAMPO'] = "readonly='readonly'";
$aParametros['DISABLED_CAMPO'] = "disabled='disabled'";

$aEmpleado = array();
$sEmpleado = "";
/*foreach ($aArray_Empleados as $indice => $value){
	if($_GET['optionEditar'] ==2){ //Visualizar Solicitud
		if( $indice == $idPromotor)
			$sEmpleado .= $aArray_Empleados[$indice]['sApellido'].', '.$aArray_Empleados[$indice]['sNombre'];
		
	}else{
		if($aArray_Empleados[$indice]['idTipoEmpleado'] == 20){
			$sEmpleado = $aArray_Empleados[$indice]['sApellido'].', '.$aArray_Empleados[$indice]['sNombre'];
			$aEmpleado[$indice] = $sEmpleado;
		}
	}
}
$sOpciones = array_2_options($aEmpleado, $idPromotor);
$sOptionsPromotores = "<option value='0'> " . 'Seleccionar...' . " </option> <option value='0'></option>" . $sOpciones;
$aParametros['optionsPromotores'] = $sOptionsPromotores;
$aParametros['PROMOTOR'] = $sEmpleado;
*/

if($_GET['optionEditar']==2){ //Visualizar Solicitud
	if($idPromotor!=0){ 
	    $sEmpleado = $oMysql->consultaSel("SELECT CONCAT(Empleados.sApellido,', ', Empleados.sNombre) as 'sEmpleado' FROM Empleados WHERE id={$idPromotor}",true);	
	}else $sEmpleado='';
	$aParametros['PROMOTOR'] = $sEmpleado;
}else{

	$sOptions = "";
	$aCanales = $oMysql->consultaSel("SELECT id FROM Canales WHERE sEstado='A'");
	if($aCanales){
		foreach ($aCanales as $idCanal){
			$aEmpleados = $oMysql->consultaSel("SELECT idEmpleado FROM GruposPromotores WHERE idCanal={$idCanal}");
			if(count($aEmpleados)>0){
				$aOptions = array();
				foreach ($aEmpleados as $idEmpleado){
					$aEmpleado = $oMysql->consultaSel("SELECT CONCAT(Empleados.sApellido,', ', Empleados.sNombre) as 'sEmpleado' FROM Empleados WHERE id={$idEmpleado}",true);	
					$select ="";					
					if($idPromotor == $idEmpleado)
						$select .="selected";
					$aOptions[] = "new Option('{$aEmpleado}', '{$idEmpleado}','','{$select}')";
				}
				$sOptions .= "idCanal_idPromotor_CondicionadoMultiple['{$idCanal}'] = new Array(";
				$sOptions .= implode(",",$aOptions);
				$sOptions .= ");";
			}
		}
	}
	
	$sOptionsPromotores = "var idCanal_idPromotor_CondicionadoMultiple = new Array();";
	$sOptionsPromotores .= $sOptions;
	$sOptionsPromotores .= "var idCanal_idPromotor_CondicionadoMultiple_IDS_PADRES = new Array();
		idCanal_idPromotor_CondicionadoMultiple_IDS_PADRES['0'] = 'idCanal'; 
		selectOpcionesCondicionado( idCanal_idPromotor_CondicionadoMultiple_IDS_PADRES, 'idPromotor', idCanal_idPromotor_CondicionadoMultiple, 'Seleccionar...', 'Seleccionar...', 'Seleccionar...', 0, 0);";
	$aParametros['SCRIPT'] = $sOptionsPromotores;
	
	$aParametros['DISPLAY_FORMULARIO_SOLICITUD'] = "";
	if($_GET['optionEditar'] == 1){ //Para cuando se realiza una Nueva Solicitud
		$aParametros['SCRIPT'] .= "buscarCliente();"; //Abre la Ventana para buscar un Cliente
		//$aParametros['DISPLAY_FORMULARIO_SOLICITUD'] = "style='display:none'";
	}
}


$oXajax=new xajax();
$oXajax->setCharEncoding('ISO-8859-1');
$oXajax->configure('decodeUTF8Input',true);
$oXajax->registerFunction("updateDatosSolicitud");
$oXajax->registerFunction("verificarDocumento");
$oXajax->registerFunction("setDatosCliente");
$oXajax->registerFunction("getCuil");

$oXajax->processRequest();
$oXajax->printJavascript("../includes/xajax/");

$aParametros['DHTMLX_WINDOW']=1;
xhtmlHeaderPaginaGeneral($aParametros);	


if($_GET['optionEditar'] == 2) //Edicion de Solicitud
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Solicitudes/VerSolicitud.tpl",$aParametros);	
else
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Solicitudes/Solicitud.tpl",$aParametros);	

echo xhtmlFootPagina();
?>