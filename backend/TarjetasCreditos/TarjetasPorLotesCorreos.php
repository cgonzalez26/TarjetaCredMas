<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	//session_start();
	#Control de Acceso al archivo
	//if(!isLogin())
	//{
		//go_url("/index.php");
	//}
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	
	$idLoteCorreo = $_GET['id'];
	$optionEditar = $_GET['optionEditar'];
	
	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
		
	if ($Pagina <= 0) $Pagina = 1;

	$NombreMod = 'Tarjetas'; // Nombre del modulo
	$NombreTipoRegistro = 'Tarjeta';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Tarjetas'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('Tarjetas.sNumeroTarjeta','Tarjetas.dVigenciaDesde', 'Usuarios.sApellido','Usuarios.sDocumento','Localidades.sNombre','TiposEstadosTarjetas.sNombre');
	$arrListaEncabezados = array('Nro. Tarjeta','Fecha Alta','Titular','Documento','Localidad','Estado');
	$Tabla = 'Tarjetas'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'Usuarios.sApellido'; // Campo de orden predeterminado
	$TipoOrdenPre = 'ASC';	// Tipo de orden predeterminado
	$RegPorPag = 500; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
		
	$aCond[]=" LEFT JOIN LotesCorreosTarjetas ON LotesCorreosTarjetas.idTarjeta = Tarjetas.id WHERE LotesCorreosTarjetas.idLoteCorreo = {$idLoteCorreo}";
	 
	$sCondiciones= implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim = implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
	//echo $sCondiciones;
	
	$sqlDatos="Call usp_getTarjetas(\"$sCondiciones\");";
	$sqlDatos_sLim="Call usp_getTarjetas(\"$sCondiciones_sLim\");";
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);

	$aParametros['optionsTipoDoc'] = $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre');
	
	$oXajax=new xajax();
	
	$oXajax->registerFunction("registrarRendicionTarjetasCreditos");
	$oXajax->registerFunction("registrarPerdidaTarjetasCreditos");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
	
	function registrarRendicionTarjetasCreditos($form){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		$aTarjetas = $form['aTarjetas'];
		
		$set = "LotesCorreos.idTipoEstadoLoteCorreo = '2'";
    	$conditions = "LotesCorreos.id = '{$form['idLoteCorreo']}'";
		$ToAuditory = "Update Estado Lotes de Correos ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$form['idLoteCorreo']} ::: estado=2";		
		$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LotesCorreos\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"51\",\"$ToAuditory\");",true);  
			
		$setEstadoLote = "idLoteCorreo,idEmpleado,idTipoEstadoLoteCorreo,dFechaRegistro,sMotivo";
		$valuesEstadoLote = "'{$form['idLoteCorreo']}','{$_SESSION['id_user']}','2',NOW(),''";
		$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes Correos ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$form['idLoteCorreo']} ::: estado=2";
		$idEstadoLoteCorreo =$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesCorreos\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"52\",\"$ToAuditoryEstadoLote\");",true); 
		//$oRespuesta->alert($idEstadoLoteCorreo);
		
		foreach ($aTarjetas as $idTarjeta){
			 
			$setTarjeta = "Tarjetas.idTipoEstadoTarjeta = '5'";
	    	$conditionsTarjeta = "Tarjetas.id = '{$idTarjeta}'";
			$ToAuditoryTarjeta = "Update Estado Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=5";
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Tarjetas\",\"$setTarjeta\",\"$conditionsTarjeta\",\"{$_SESSION['id_user']}\",\"42\",\"$ToAuditoryTarjeta\");",true);
			
			$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
			$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','4',NOW(),''";
			$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=4";
			$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true); 

			$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
			$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','5',NOW(),''";
			$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=5";
			$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true);
			
			$sql="UPDATE LotesCorreosTarjetas SET idTipoEstadoTarjeta=5 WHERE idTarjeta={$idTarjeta} AND idLoteCorreo={$form['idLoteCorreo']}";
			$id = $oMysql->consultaSel($sql,true);
			
			$aCupones = $oMysql->consultaSel("call usp_getCuponesUltimoPeriodo(\"{$idTarjeta}\");");
			
			foreach ($aCupones as $sNumeroCupon){
				//$sConsulta="call sis_RegistrarVerificacion('{$sNumeroCupon}');";
				
				$setCupon = " Cupones.iVerificado = 1 ";
				$conditionsCupon = " Cupones.sNumeroCupon = '{$sNumeroCupon}' ";
			    $ToAuditoryCupon = "CUPON VERIFICADO ::: Empleado ={$_SESSION['id_user']} ::: cupon={$sNumeroCupon} ::: verificado";
			    $oMysql->consultaSel("CALL usp_UpdateTable(\"Cupones\",\"$setCupon\",\"$conditionsCupon\",\"{$_SESSION['id_user']}\",\"57\",\"$ToAuditoryCupon\");",true);
			}
		}
		
		$cantidadTarjetasRegistradas = $oMysql->consultaSel("SELECT count(*) FROM LotesCorreosTarjetas WHERE idLoteCorreo={$form['idLoteCorreo']} AND idTipoEstadoTarjeta IN (5,6,7)",true);
		$cantidadTarjetasLote = $oMysql->consultaSel("SELECT count(*) FROM LotesCorreosTarjetas WHERE idLoteCorreo={$form['idLoteCorreo']}",true);
		
		if($cantidadTarjetasRegistradas<$cantidadTarjetasLote){//Registrar Lote Incompleto
			$aLote = $oMysql->consultaSel("SELECT * FROM LotesCorreos WHERE LotesCorreos.id={$form['idLoteCorreo']} AND LotesCorreos.idTipoEstadoLoteCorreo = 3");
			if(!$aLote){
				$set = "LotesCorreos.idTipoEstadoLoteCorreo = '3'";
				$conditions = "LotesCorreos.id = '{$form['idLoteCorreo']}'";
				$ToAuditory = "Modificacion Estado Lotes de Correos Postales ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$form['idLoteCorreo']} ::: estado=3";		
				$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LotesCorreos\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"51\",\"$ToAuditory\");",true);  
					
				$setEstadoLote = "idLoteCorreo,idEmpleado,idTipoEstadoLoteCorreo,dFechaRegistro,sMotivo";
				$valuesEstadoLote = "'{$form['idLoteCorreo']}','{$_SESSION['id_user']}','3',NOW(),''";
				$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes Correos Postales ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$form['idLoteCorreo']} ::: estado=1";
				$idEstadoLote=$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesCorreos\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"52\",\"$ToAuditoryEstadoLote\");",true);
			}
		}
		if($cantidadTarjetasRegistradas == $cantidadTarjetasLote){ //Registrar Lote Completo
			$set = "LotesCorreos.idTipoEstadoLoteCorreo = '2'";
			$conditions = "LotesCorreos.id = '{$form['idLoteCorreo']}'";
			$ToAuditory = "Modificacion Estado Lotes de Correos Postales ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$form['idLoteCorreo']} ::: estado=2";		
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LotesCorreos\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"51\",\"$ToAuditory\");",true);  
			
			$setEstadoLote = "idLoteCorreo,idEmpleado,idTipoEstadoLoteCorreo,dFechaRegistro,sMotivo";
			$valuesEstadoLote = "'{$form['idLoteCorreo']}','{$_SESSION['id_user']}','2',NOW(),''";
			$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes de Correos Postales ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$form['idLoteCorreo']} ::: estado=2";
			$idEstadoLote=$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesCorreos\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"52\",\"$ToAuditoryEstadoLote\");",true);
		}

		$oRespuesta->alert("La operacion se realizo correctamente");
	  	$oRespuesta->redirect("TarjetasPorLotesCorreos.php?id={$form['idLoteCorreo']}&optionEditar={$form['optionEditar']}"); 
		return  $oRespuesta;
	}
	
	function registrarPerdidaTarjetasCreditos($form){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		$aTarjetas = $form['aTarjetas'];
		
		foreach ($aTarjetas as $idTarjeta){
			$setTarjeta = "Tarjetas.idTipoEstadoTarjeta = '7'";
	    	$conditionsTarjeta = "Tarjetas.id = '{$idTarjeta}'";
			$ToAuditoryTarjeta = "Update Estado Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=5";		
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Tarjetas\",\"$setTarjeta\",\"$conditionsTarjeta\",\"{$_SESSION['id_user']}\",\"42\",\"$ToAuditoryTarjeta\");",true);    		
			
			$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
			$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','7',NOW(),''";
			$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=7";
			$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true); 
			//$oRespuesta->alert($idEstadotarjeta);
			$sql="UPDATE LotesCorreosTarjetas SET idTipoEstadoTarjeta=7 WHERE idTarjeta={$idTarjeta} AND idLoteCorreo={$form['idLoteCorreo']}";
			$id = $oMysql->consultaSel($sql,true);
		}
		
		$cantidadTarjetasRegistradas = $oMysql->consultaSel("SELECT count(*) FROM LotesCorreosTarjetas WHERE idLoteCorreo={$form['idLoteCorreo']} AND idTipoEstadoTarjeta IN (5,6,7)",true);
		$cantidadTarjetasLote = $oMysql->consultaSel("SELECT count(*) FROM LotesCorreosTarjetas WHERE idLoteCorreo={$form['idLoteCorreo']}",true);
		
		if($cantidadTarjetasRegistradas<$cantidadTarjetasLote){//Registrar Lote Incompleto
			$aLote = $oMysql->consultaSel("SELECT * FROM LotesCorreos WHERE LotesCorreos.id={$form['idLoteCorreo']} AND LotesCorreos.idTipoEstadoLoteCorreo = 3");
			if(!$aLote){
				$set = "LotesCorreos.idTipoEstadoLoteCorreo = '3'";
				$conditions = "LotesCorreos.id = '{$form['idLoteCorreo']}'";
				$ToAuditory = "Modificacion Estado Lotes de Correos Postales ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$form['idLoteCorreo']} ::: estado=3";		
				$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LotesCorreos\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"51\",\"$ToAuditory\");",true);  
					
				$setEstadoLote = "idLoteCorreo,idEmpleado,idTipoEstadoLoteCorreo,dFechaRegistro,sMotivo";
				$valuesEstadoLote = "'{$form['idLoteCorreo']}','{$_SESSION['id_user']}','3',NOW(),''";
				$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes Correos Postales ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$form['idLoteCorreo']} ::: estado=1";
				$idEstadoLote=$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesCorreos\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"52\",\"$ToAuditoryEstadoLote\");",true);
			}
		}
		if($cantidadTarjetasRegistradas == $cantidadTarjetasLote){ //Registrar Lote Completo
			$set = "LotesCorreos.idTipoEstadoLoteCorreo = '2'";
			$conditions = "LotesCorreos.id = '{$form['idLoteCorreo']}'";
			$ToAuditory = "Modificacion Estado Lotes de Correos Postales ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$form['idLoteCorreo']} ::: estado=2";		
			$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"LotesCorreos\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"51\",\"$ToAuditory\");",true);  
			
			$setEstadoLote = "idLoteCorreo,idEmpleado,idTipoEstadoLoteCorreo,dFechaRegistro,sMotivo";
			$valuesEstadoLote = "'{$form['idLoteCorreo']}','{$_SESSION['id_user']}','2',NOW(),''";
			$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes de Correos Postales ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$form['idLoteCorreo']} ::: estado=2";
			$idEstadoLote=$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesCorreos\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"52\",\"$ToAuditoryEstadoLote\");",true);
		}

		$oRespuesta->alert("La operacion se realizo correctamente");
	  	$oRespuesta->redirect("TarjetasPorLotesCorreos.php?id={$form['idLoteCorreo']}&optionEditar={$form['optionEditar']}"); 
		return  $oRespuesta;
	}
?>
<body style="background-color:#FFFFFF;">
	<div id='' style='width:90%;text-align:right;margin-right:10px;'>
		<a href="RecepcionDeCorreo.php" style='text-decoration:none;font-weight:bold;'>
			<img src='<?=IMAGES_DIR?>/back.png' title='Volver a Listado de Lotes de Correos' alt='Volver a Listado de Lotes de Correos' border='0' hspace='4' align='absmiddle'> Volver</a>
	</div>
	<center>
	<h3>Registro de Rendiciones de Tarjetas enviadas a Correos Postales</h3>
	
<form id="formTarjetas" action="TarjetasPorLotesCorreos.php" method="POST">
<input type="hidden" id="idLoteCorreo" name="idLoteCorreo" value="<? echo $idLoteCorreo;?>">
<input type="hidden" name="optionEditar" id="optionEditar" value="<?=$optionEditar?>"> 

<?php 
if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result){	

  $sCondicionLote = " WHERE LotesCorreos.id = {$idLoteCorreo}";	
  $sqlDatos="Call usp_getLotesCorreos(\"$sCondicionLote\");";
  $rsLote = $oMysql->consultaSel($sqlDatos,true);
  /*$sCadena .= "<p>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;
  $sCadena .= " en la base de datos.</p>*/
  $sCadena .= "<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='0' bordercolor='#000000' width='90%'>
  				<tr><td>Numero de Lote: " . $rsLote['sNumeroPedido'] . "</td></tr>
  				<tr><td>Correo Postal: " . $rsLote['sCorreo'] . "</td></tr></table>";
  $sCadena .= "<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='90%' id='tablaTarjetas'>
		<tr class='filaPrincipal'>
		<!-- Lista de encabezados de columna -->";
	
  	$CantEncabezados = count($arrListaEncabezados);
	for($i=0; $i<$CantEncabezados; $i++){
		$sCadena .= "<th style='height:25px'>";
		if($CampoOrden == $arrListaCampos[$i]){
			//var_export('entro');
			if ($TipoOrden == 'ASC') $NuevoTipoOrden = 'DESC'; else $NuevoTipoOrden = 'ASC';
		}
		else $NuevoTipoOrden = 'ASC';
		//var_export($TipoOrden.'----'.$NuevoTipoOrden);
		$sCadena .= "<a href=\"{$_SERVER['PHP_SELF']}?CampoOrden={$arrListaCampos[$i]}&TipoOrden={$NuevoTipoOrden}&id={$idLoteCorreo}&optionEditar={$optionEditar}\">{$arrListaEncabezados[$i]}";
		if($CampoOrden == $arrListaCampos[$i]){
			if ($TipoOrden == 'ASC') 
				$sCadena .= "<img src='../includes/images/go-up.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendente' title='Ordenado por {$arrListaEncabezados[$i]} Ascendente'/></a>"; 
			else 
				$sCadena .= "<img src='../includes/images/go-down.png' alt='Ordenado por {$arrListaEncabezados[$i]} Descendente' title='Ordenado por {$arrListaEncabezados[$i]} Descendente'/></a>";
		}
		$sCadena .= "</th>\r\n";
	}
  
	///Opciones de Mod. y Elim.
	if($_GET['optionEditar'] == 1)
		$sCadena .="<th style='cursor:pointer;width:20px'><input type='checkbox' onclick='tildar_checkboxs( this.checked )' id='check_user' /> </th></tr>";
	else 
		$sCadena .="<th style='cursor:pointer;width:20px'>&nbsp;</th>";	
    echo $sCadena;

	$CantMostrados = 0;
	foreach ($result as $rs ){
		$sBotonera = '';	
		$CantMostrados ++;
		$PK = $rs['id'];
	
		$sUsuario = $rs['sApellido'].', '.$rs['sNombre'];
		$optionEditar = 0;
		$idTipoEstadoTarjeta = $oMysql->consultaSel("SELECT LotesCorreosTarjetas.idTipoEstadoTarjeta FROM LotesCorreosTarjetas WHERE LotesCorreosTarjetas.idTarjeta={$rs['id']} AND LotesCorreosTarjetas.idLoteCorreo={$idLoteCorreo}",true);
		$bMostrarIcono = false;
		$sBoton = "";
		if($rs['sEstado'] == 'B'){
			$sBotonera='&nbsp;';
		}else{
			
			$oBtn = new aToolBar();
			$oBtn->setAnchoBotonera('auto');			
			$sBotonera='&nbsp;';
			//$oBtn->addBoton("Historial{$rs['id']}","onclick","historialTarjeta({$rs['id']},'{$rs['sNumeroTarjeta']}')",'Historial','Historial de la Tarjeta',true,true);					
			if($idTipoEstadoTarjeta == 5){
				$bMostrarIcono = true;
				$sBoton .= "<img src='".IMAGES_DIR."/ok.png' border='0' alt='Tarjeta Registrada' title='Tarjeta Registrada' style='cursor:pointer'/>";
			}
			if($idTipoEstadoTarjeta == 6){
				$bMostrarIcono = true;
				$sBoton .= "<img src='".IMAGES_DIR."/cancelar.gif' border='0' alt='Tarjeta Devuelta por Correo' title='Tarjeta Devuelta por Correo' style='cursor:pointer'/>";
			}			
			if($idTipoEstadoTarjeta == 7){
				$bMostrarIcono = true;
				$sBoton .= "<img src='".IMAGES_DIR."/cancelar.gif' border='0' alt='Tarjeta Perdida por Correo' title='Tarjeta Perdida por Correo' style='cursor:pointer'/>";
			}			
			$sBotonera = $oBtn->getBotoneraToolBar('');		
		}
		?>
		<tr id="empleado<?php echo $PK;?>">
			<!-- Valores -->
			<td width="10%" align="left">&nbsp;<?=$rs['sNumeroTarjeta'];?></td>
			<td width="15%" align="left">&nbsp;<?=$rs['dFechaRegistro'];?></td>
			<td width="25%" align="left">&nbsp;<?=convertir_especiales_html($sUsuario);?></td>
			<td width="10%" align="left">&nbsp;<?=$rs['sDocumento'];?></td>	
			<td width="20%" align="left">&nbsp;<?=convertir_especiales_html($rs['sLocalidad']);?></td>	
			<td width="20%" align="left">&nbsp;<?=convertir_especiales_html($rs['sEstado']);?></td>	
			<!-- Links para Mod. y Elim. -->
			<td align='center' width='2%'>
			<?
			if($_GET['optionEditar'] == 1){
				if($bMostrarIcono)
					echo $sBoton;
				else
					echo "<input type='checkbox' id='aTarjetas[]' name='aTarjetas[]' class='check_user' value='".$PK."' />";
				
			}else{			
				echo $sBoton;
			} 		
			?>
			</td>
		</tr>
		<?
	}
	if($_GET['optionEditar'] == 1 && $rsLote['idTipoEstadoLoteEmbosaje'] != 2)
		echo '<tr><td colspan="7" align="right"><div><button type="button" onclick="registrarRendicionTarjetasCreditos();"> Registrar Rendicion </button> &nbsp;
		<button type="button" onclick="registrarDevolucionTarjetasCreditos();"> Devuelta por Correo </button>&nbsp;
		<button type="button" onclick="registrarPerdidaTarjetasCreditos();"> Perdida por Correo </button></div> </td></tr>';
	?>
	
	</table>
	<!--<div style='font-size:10px;text-align:left;width:80%'>
		<span class='rojo'>Rojo-Solicitudes Rechazas. <span><br><span class='naranja'>Naranja-Solicitudes Anuladas <span><br><span class='azul'>Azul-Solicitudes de Alta<span>
	</div>-->
	</center>
	</form>
	<!-- Paginacion -->
	<?
	if (ceil($CantRegFiltro/$RegPorPag) > 1){
		echo "<p>P&aacute;gina $Pagina. Mostrando $CantMostrados de $CantRegFiltro $NombreTipoRegistroPlu.</p>\r\n";
	
		echo "<p>";
		if ($Pagina > 1) echo "<a href=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}&Pagina=". ($Pagina-1) ."\">Anterior</a>";
		if ($Pagina > 1 && $Pagina<ceil($CantRegFiltro/$RegPorPag)) echo " - ";
	
		if ($Pagina<ceil($CantRegFiltro/$RegPorPag)) echo "<a href=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}&Pagina=". ($Pagina+1) ."\">Siguiente</a>";
	
		echo " | P&aacute;ginas: ";
		$strPaginas = '';
		
		for($i=1;$i<=ceil($CantRegFiltro/$RegPorPag);$i++){
			if ($i == $Pagina) $strPaginas .= "<b>";
			else $strPaginas .= "<a href=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}&Pagina=". $i ."&nombre_u=".$nombre_u."&condic=".$condic1."\">";
			$strPaginas .= $i;
			if ($i == $Pagina) $strPaginas .= "</b> - ";
			else $strPaginas .= "</a> - ";
		}
		echo substr($strPaginas, 0, strlen($strPaginas) - 3);
	}
}


?>
</form>
<script>
function registrarRendicionTarjetasCreditos(){
	  var mensaje="Esta seguro que desea Registrar la Rendicion de las Tarjetas de Creditos seleccionadas?"; 
	  var el = document.getElementById('tablaTarjetas');
	  var imputs= el.getElementsByTagName('input');
	  var band=0;
	  		  
	  for (var i=0; i<imputs.length; i++){			
	    if (imputs[i].type=='checkbox'){ 		    	
	    	if(!imputs[i].checked){
	         	band=0; 
	     	}else{ 
	     		band=1; break;
	     	}
	    }	
	  }
	  	
	  if(band==1)
	  {
	  	 if(confirm(mensaje))
	       xajax_registrarRendicionTarjetasCreditos(xajax.getFormValues('formTarjetas'));
	  }
	  else alert('Debe Elegir al menos un Tarjeta de Credito a registrar la Rendicion.');	   
}

function registrarDevolucionTarjetasCreditos(){
	if(!validarLista()){
		 alert('Debe Elegir al menos un Tarjeta de Credito a registrar la Devolucion.');
		 return;
	} 
	var el = document.getElementById('tablaTarjetas');
	var imputs= el.getElementsByTagName('input');
	var sTarjetas = "";
	for (var i=0; i<imputs.length; i++){
	 	 if (imputs[i].type=='checkbox') 		    	
		if(imputs[i].checked && imputs[i].className =="check_user"){ 
			sTarjetas += imputs[i].value+',';
		}
  	} 
	sTarjetas =  sTarjetas.substring(0,sTarjetas.length-1); 
	//alert(sTarjetas);
	var id = document.getElementById("idLoteCorreo").value;
	var optionEditar = document.getElementById("optionEditar").value;  	
	//top.getBoxRegistrarDevolucionTarjetasCreditos(id,sTarjetas,optionEditar);  		
	createWindows('RegistrarDevolucion.php?id='+ id +'&sTarjetas='+sTarjetas+'&operacion='+optionEditar,'Tarjeta','1','1');
}

function registrarPerdidaTarjetasCreditos(){
	if(!validarLista()){
		 alert('Debe Elegir al menos un Tarjeta de Credito a registrar la Perdida.');
		 return;
	} 
	 var mensaje="Esta seguro que desea Registrar la Perdida de las Tarjetas de Creditos seleccionadas?"; 
	 if(confirm(mensaje))
		xajax_registrarPerdidaTarjetasCreditos(xajax.getFormValues('formTarjetas'));
}

function validarLista(){
	var el = document.getElementById('tablaTarjetas');
	var imputs= el.getElementsByTagName('input');
	var band=0;
	  		  
    for (var i=0; i<imputs.length; i++){			
      if (imputs[i].type=='checkbox'){ 		    	
    	if(imputs[i].checked){
     		return true; break;
     	}
      }	
    }
    return false;	
}

function doOnLoad() {
    dhxWins1 = new dhtmlXWindows();
    dhxWins1.enableAutoViewport(false);
    dhxWins1.attachViewportTo("dhtmlx_wins_body_content");
    dhxWins1.setImagePath("../../codebase/imgs/");
}
var dhxWins1;
function createWindows(sUrl,sTitulo,idProyecto_,tipo_){
    var idWind = "window_"+idProyecto_+"_"+tipo_;
	//if(!dhxWins.window(idWind)){
     	dhxWins1 = new dhtmlXWindows();     	
	    dhxWins1.setImagePath("../includes/grillas/dhtmlxWindows/sources/imgs/");	  
	    _popup_ = dhxWins1.createWindow(idWind, 250, 50, 520, 270);
	    _popup_.setText(sTitulo);
	    ///_popup_.center();
	    _popup_.button("close").attachEvent("onClick", closeWindows);
		_url_ = sUrl;
	    _popup_.attachURL(_url_);
	//}
} 

function closeWindows(_popup_){
	_popup_.close();
	recargar();
	//parent.dhxWins.close(); // close a window
}  	

function recargar(){
	var id = document.getElementById('idLoteCorreo').value;
	var optionEditar = document.getElementById('optionEditar').value;	
	window.location ="TarjetasPorLotesCorreos.php?id="+id+"&optionEditar="+optionEditar;
}	/**/
</script>
