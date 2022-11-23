<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	
        $idObjeto = 61;
        $arrayPermit = explode(',',$_SESSION['_PERMISOS_'][$idObjeto]['sPermisos']);
        
 
	
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	

	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
		
	if ($Pagina <= 0) $Pagina = 1;

	$NombreMod = 'Pedidos'; // Nombre del modulo
	$NombreTipoRegistro = 'Pedido';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Pedidos'; // Nombre tipo de registros en Plural
	$Masculino = true;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('Comercios.sRazonSocial','Tarjetas.sNumeroTarjeta','CuentasUsuarios.sNumero','Usuarios.Apellido','','Cupones.fImporte','Cupones.sCuotas','Cupones.sEstado');
	$arrListaEncabezados = array('Nro.','Comercio','Nro. Tarjeta','Cuenta Usuario','Usuario','Plan/Promo','Fecha consumo','Importe','Cuotas','Estado');
	$Tabla = 'Cupones'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'Cupones.dFechaConsumo'; // Campo de orden predeterminado
	$TipoOrdenPre = 'DESC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
		
	if(isset($_POST['buscar'])){

		$sNumeroComercio	 = $_POST['sNumeroComercio'];
		$sRazonSocial 		 = $_POST['sRazonSocial'];
		$sNombreFantasia	 = $_POST['sNombreFantasia'];

		$sNumeroCuentaUsuario= $_POST['sNumeroCuentaUsuario'];
		$sNumeroTarjeta 	 = $_POST['sNumeroTarjeta'];

		$dFechaConsumoDesde  = dateToMySql($_POST['dFechaConsumoDesde']);
		$dFechaConsumoHasta  = dateToMySql($_POST['dFechaConsumoHasta']);
		
		$nombretitular = $_POST['sNombreTitular'];
		$apellidotitular = $_POST['sApellidoTitular'];

		$condic  = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; //variable que se usa en la paginacion 

		if(!session_is_registered('sNumeroCuentaUsuario')){

			session_register('sNumeroCuentaUsuario');
			session_register('sRazonSocial');
			session_register('sNombreFantasia');

			session_register('scondic');
		}

		$_SESSION['sNumeroComercio']		= $_POST['sNumeroComercio'];
		$_SESSION['sRazonSocial'] 			= $_POST['sRazonSocial'];		
		$_SESSION['sNombreFantasia'] 		= $_POST['sNombreFantasia'];
		
		$_SESSION['sNumeroCuentaUsuario'] 	= $_POST['sNumeroCuentaUsuario'];
		$_SESSION['sNumeroTarjeta'] 		= $_POST['sNumeroTarjeta'];
		
		$_SESSION['sNombreTitular'] 		= $_POST['sNombreTitular'];
		$_SESSION['sApellidoTitular'] 		= $_POST['sApellidoTitular'];
		
		$_SESSION['dFechaConsumoDesde']  = dateToMySql($_POST['dFechaConsumoDesde']);
		$_SESSION['dFechaConsumoHasta']  = dateToMySql($_POST['dFechaConsumoHasta']);

		$_SESSION['scondic'] 				= $_POST['condic'];

		unset($_SESSION['volver']);
	}
	else
	{
		$sNumeroComercio	 = $_SESSION['sNumeroComercio'];
		$sRazonSocial 		 = $_SESSION['sRazonSocial'];
		$sNombreFantasia	 = $_SESSION['sNombreFantasia'];

		$sNumeroCuentaUsuario= $_SESSION['sNumeroCuentaUsuario'];
		$sNumeroTarjeta 	 = $_SESSION['sNumeroTarjeta'];

		$dFechaConsumoDesde  = $_SESSION['dFechaConsumoDesde'];
		$dFechaConsumoHasta  = $_SESSION['dFechaConsumoHasta'];
		
		$nombretitular 		= $_SESSION['sNombreTitular'];
		$apellidotitular 	= $_SESSION['sApellidoTitular'];		
		
		$condic 			 = $_SESSION['scondic'];	
		$condic1 			 = $_SESSION['scondic'];	
	}

	$sWhere = "";
	$aCond=Array();
	
	if($sNumeroComercio){
		$aCond[]=" Comercios.sNumero = '$sNumeroComercio' ";
	}
	
	if($sRazonSocial){
		$aCond[]=" Comercios.sRazonSocial LIKE '$sRazonSocial%' ";
	}
	
	if($sNombreFantasia){
		$aCond[]=" Comercios.sNombreFantasia LIKE '$sNombreFantasia%' ";
	}
	
	if($nombretitular){
		$aCond[]=" Usuarios.sNombre LIKE '$nombretitular%' ";
	}
	
	if($apellidotitular){
		$aCond[]=" Usuarios.sApellido LIKE '$apellidotitular%' ";
	}
	
	if($sNumeroCuentaUsuario){
		$aCond[]=" CuentasUsuarios.sNumeroCuenta = '$sNumeroCuentaUsuario' ";
	}
	
	if($sNumeroTarjeta){
		$aCond[]=" Tarjetas.sNumeroTarjeta = '$sNumeroTarjeta' ";
	}
	
	if($dFechaConsumoDesde){
		$aCond[]=" UNIX_TIMESTAMP(Cupones.dFechaConsumo) >= UNIX_TIMESTAMP('$dFechaConsumoDesde') ";
	}
	
	if($dFechaConsumoHasta){
		$aCond[]=" UNIX_TIMESTAMP(Cupones.dFechaConsumo) <= UNIX_TIMESTAMP('$dFechaConsumoHasta') ";
	}

	 
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
	
	$sqlDatos="Call usp_getCupones(\"$sCondiciones\");";
	
	$sqlDatos_sLim="Call usp_getCupones(\"$sCondiciones_sLim\");";
	//var_export($sqlDatos_sLim);die();
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);
	
	$aParametros['DHTMLX_WINDOW'] = 1;
	
	$oXajax=new xajax();
	
	//$oXajax->configure('debug',true);
	
	$oXajax->register( XAJAX_FUNCTION ,"eliminarCupones");
	
	$oXajax->register( XAJAX_FUNCTION ,"marcarCuponesFraude");
	
	$oXajax->register( XAJAX_FUNCTION ,"marcarCuponesObservado");
	
	$oXajax->register( XAJAX_FUNCTION ,"anularCupones");
	
	$oXajax->register( XAJAX_FUNCTION ,"marcarCuponesActivado");
	
	$oXajax->register( XAJAX_FUNCTION ,"_reprintCupones");
	
	$oXajax->register( XAJAX_FUNCTION ,"habilitarCupones");	
	
	$oXajax->register( XAJAX_FUNCTION ,"reactivarCupones");	

	$oXajax->registerFunction("eliminarDefinitivoObjeto");
	
	$oXajax->processRequest();
	
	$oXajax->printJavascript("../includes/xajax/");
	
	//$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
	$aParametros['FORM'] = "Pedidos.php";
	$aParametros['TituloBuscador'] = "Pedidos";
	$aParametros['options_comercios'] = $oMysql->getListaOpciones( 'Comercios', 'Comercios.sNumero', 'Comercios.sRazonSocial',$sNumeroComercio);
?>
<body style="background-color:#FFFFFF;">
<div id="BODY">

<?php 

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorPedidos.tpl",$aParametros);

//if(in_array(AGREGAR,$arrayPermit)){
	?>
	<center>
	<div align="center"><img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo"> <a href="AdminPedidos.php?_op=<? echo _encode('new'); ?>"><? if($Masculino) echo 'Nuevo '; else echo 'Nueva '; echo $NombreTipoRegistro;?></a></div>
	<?
//}
if (count($result)==0){echo "Ningun registro encontrado";}
$sCadena = "";
if ($result){	

  $sCadena .= "<center><p><div style='width:80%' align='center'>Hay ".$CantReg." ";
  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
  else $sCadena .= $NombreTipoRegistro;

  $sCadena .= " en la base de datos.</div></p></center>
  <form id='formCupones' action='' method='POST' >
	<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='80%' id='tableCupones'>
		<tr class='filaPrincipal'>
		<!-- Lista de encabezados de columna -->";
	
  	$CantEncabezados = count($arrListaEncabezados);
	for($i=0; $i<$CantEncabezados; $i++){
		$sCadena .= "<th style='height:25px'>";
		if($CampoOrden == $arrListaCampos[$i]){
		
			if ($TipoOrden == 'ASC') $NuevoTipoOrden = 'DESC'; else $NuevoTipoOrden = 'ASC';
		}
		else $NuevoTipoOrden = 'ASC';
		
		$sCadena .= "<a href=\"{$_SERVER['PHP_SELF']}?CampoOrden={$arrListaCampos[$i]}&TipoOrden={$NuevoTipoOrden}\">{$arrListaEncabezados[$i]}";
		if($CampoOrden == $arrListaCampos[$i]){
			if ($TipoOrden == 'ASC') 
				$sCadena .= "<img src='../includes/images/go-up.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendenrte' title='Ordenado por {$arrListaEncabezados[$i]} Ascendenrte'/></a>"; 
			else 
				$sCadena .= "<img src='../includes/images/go-down.png' alt='Ordenado por {$arrListaEncabezados[$i]} Descendente' title='Ordenado por {$arrListaEncabezados[$i]} Descendente'/></a>";
		}
		$sCadena .= "</th>\r\n";
	}
  
	///Opciones de Mod. y Elim.
	$sCadena .="<th colspan='2'>Acciones</th>
		<th style='cursor:pointer;'><input type='checkbox' onchange='tildar_checkboxs( this.checked )' id='checkbox_principal' /> </th>
		</tr>";
    echo $sCadena;

	$CantMostrados = 0;
	foreach ($result as $rs ){
		$sBotonera = '';	
		$CantMostrados ++;
		$PK = _encode($rs['id']);
		$sClase='';
		switch ($rs['sEstado']){
			case 'A': $sClase="class='rojo'"; break;//estado Suspendido
			case 'B': $sClase="class='rojo'"; break;//estado Baja
			case 'U': $sClase="class='azul'"; break;//estado cambio de Clave
		}
		
		$idcupon = _encode($rs['id']);
			
		$oBtn = new aToolBar();

		$oBtn->setAnchoBotonera('auto');
		
		//$oBtn->setIdBotonera($idcomercio);
		
		if($rs['sEstado'] == "F" || $rs['sEstado'] == "O"){
			$oBtn->addBoton("cupones_wiew_{$idcupon}","onclick","fichaCupon('$idcupon')",'search24','Mostrar',true,true);		
			
			$oBtn->addBoton("cupones_activar_{$idcupon}","onclick","activarCupon('$idcupon','{$rs['sNumeroCupon']}')",'Reactivar','ACTIVAR',true,true);
			
			$oBtn->addBoton("cupones_detalles_{$idcupon}","onclick","mostrarCuotas('$idcupon')",'page24','CUOTAS',true,true);
			
			//$oBtn->addBoton("comercio_act_{$idcomercio}","onclick","activarComercio('$idcomercio','{$rs['sNombreFantasia']}')",'Actualizar','Activar',true,true);		
		}elseif($rs['sEstado'] == "N"){
			
			$oBtn->addBoton("cupones_wiew_{$idcupon}","onclick","fichaCupon('$idcupon')",'search24','Mostrar',true,true);		
			
			$oBtn->addBoton("cupones_anular_{$idcupon}","onclick","anularCupones('$idcupon','{$rs['sNumeroCupon']}')",'delete24','ANULAR',true,true);
			
			if(in_array(acceder_como_admin,$arrayPermit)){
				$oBtn->addBoton("cupones_fraude_{$idcupon}","onclick","marcarCuponesFraude('$idcupon','{$rs['sNumeroCupon']}')",'warning24','FRAUDE',true,true);			
				$oBtn->addBoton("cupones_observado_{$idcupon}","onclick","marcarCuponesObservado('$idcupon','{$rs['sNumeroCupon']}')",'watch24','OBSERVADO',true,true);
			}
			$oBtn->addBoton("cupones_detalles_{$idcupon}","onclick","mostrarDetalles('$idcupon')",'page24','DETALLES',true,true);
			
			//$oBtn->addBoton("comercio_edi_{$idcomercio}","onclick","editarComercio('$idcomercio')",'editar24','Editar',true,true);		
			
			//$oBtn->addBoton("comercio_del_{$idcomercio}","onclick","eliminarComercio('$idcomercio','{$rs['sNombreFantasia']}')",'delete24','Eliminar',true,true);
			
		}elseif ($rs['sEstado'] == "B" || $rs['sEstado'] == "A"){
			$oBtn->addBoton("cupones_wiew_{$idcupon}","onclick","fichaCupon('$idcupon')",'search24','Mostrar',true,true);
			
			$oBtn->addBoton("cupones_activar_{$idcupon}","onclick","activarCupon('$idcupon','{$rs['sNumeroCupon']}')",'Reactivar','ACTIVAR',true,true);
		}
		
		$oBtn->addBoton("cupones_print_{$idcupon}","onclick","_printCupon('$idcupon')",'print24','REIMPRIMIR',true,true);

	if( in_array(ELIMINAR,$arrayPermit)) $oBtn->addBoton("EliminarDefinitivo{$rs['id']}","onclick","eliminarDefinitivo({$rs['id']})",'EliminarDefinitivo','Eliminar Definitivo',true,true);
		
		$sBotonera = $oBtn->getBotoneraToolBar('');		
		
		if($rs['idPlanPromo']){
			$PLANPROMO = $rs['sNombrePromocion'];
		}else{
			$PLANPROMO = $rs['sNombrePlan'];
		}

		?>
		<tr id="row_cupones_<?php echo $PK;?>" class="">
			<!-- row -->
			<td width="5%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumeroCupon'];?></td>
			<td width="15%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sRazonSocial'];?></td>
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumeroTarjeta'];?></td>
			<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNumeroCuenta'];?></td>
			<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sApellidoUsuario'];?>, <?=$rs['sNombreUsuario'];?></td>
			<td width="10%" align="center" <?php echo $sClase;?>>&nbsp;<?=$PLANPROMO;?></td>	
			<td width="5%" align="center" <?php echo $sClase;?>>&nbsp;<?=$rs['dFechaConsumo'];?></td>	
			<td width="5%" align="center" <?php echo $sClase;?>>&nbsp;<?=$rs['fImporte'];?></td>	
			<td width="5%" align="center" <?php echo $sClase;?>>&nbsp;<?=$rs['sCuotas'];?></td>	
			<td width="5%" align="center" <?php echo $sClase;?>>&nbsp;<?=$rs['sEstado'];?></td>	
			<!-- Links para Mod. y Elim. -->
			<td colspan="2" align="left" width="5%">
				<?=$sBotonera;?>
			</td>
			<td align="center" width="5%"><input type='checkbox' id='aCupones[]' name='aCupones[]' class="check_cupon" value='<?php echo $PK;?>'/> </td>
						
		</tr>
		<?
	}
	?>
	</table>

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
<script>

	function editarComercio(_i){
		//window.location ="AdminComercios.php?_i="+ _i +"&_op=<?php echo _encode('edit');?>";
	}

	function eliminarComercio(_i,_comercio_){
		if(confirm("Esta seguro de eliminar el comercio: '"+ _comercio_ +"' ?")){
			//xajax_eliminarComercio(_i);
		}
	}
	
	function fichaCupon(_i){
		window.location ="AdminPedidos.php?_i="+ _i +"&_op=<?php echo _encode('wiew');?>";
	}
	
	function marcarCuponesFraude(_i,_cupon_){
		if(confirm("Esta seguro de marcar como fraude el cupon: '"+ _cupon_ +"' ?")){
			xajax_marcarCuponesFraude(_i);
		}
	}
	
	function marcarCuponesObservado(_i,_cupon_){
		
		_createWindows('../Cupones/MarcarCuponesObservado.php?_i=' + _i + '&_n=' + _cupon_);
		
		
		/*if(confirm("Esta seguro de marcar como observado el cupon: '"+ _cupon_ +"' ?")){
			xajax_marcarCuponesObservado(_i);
		}*/
	}
	
	function activarCupon(_i,_cupon_){
		if(confirm("Esta seguro de activar el cupon: '"+ _cupon_ +"' ?")){
			//xajax_marcarCuponesActivado(_i);
			xajax_reactivarCupones(_i);
		}
	}
	
	function anularCupones(_i,_cupon_){
		if(confirm("Esta seguro de anular el cupon: '"+ _cupon_ +"' ?")){
			xajax_anularCupones(_i);
		}
	}
	
	function mostrarDetalles(_i){
		window.location ="AdminPedidos.php?_i="+ _i +"&_op=<?php echo _encode('wiew-details');?>";
	}
	
	function mostrarCuotas(_i){
		window.location ="AdminPedidos.php?_i="+ _i +"&_op=<?php echo _encode('wiew-only-cuotas');?>";
	}	
	
	var dhxWins1;
	function _createWindows(sUrl){
		
	    var idWind = "window_status";
		
	     	dhxWins1 = new dhtmlXWindows();     	
		    dhxWins1.setImagePath("../includes/grillas/dhtmlxWindows/sources/imgs/");	  
		    _popup_ = dhxWins1.createWindow(idWind, 0, 0, 600, 260);
		    _popup_.setText('Marcar Cupon Como Observado');
		    _popup_.center();
		    _popup_.setModal(true);
		    //_popup_.button("close").attachEvent("onClick", __closeWindows);
			_url_ = sUrl;
		    _popup_.attachURL(_url_);
		
	} 
	
	function __closeWindows(){
		 var idWind = "window_status";
		 dhxWins1.window(idWind).close();
		//recargar();
		//parent.dhxWins.close(); // close a window
	}
	
	function _reloadPAGE(){
		
		__closeWindows();
		
		window.location.reload();
	}
	
	function _printCupon(_i){
		//alert('test');
		xajax__reprintCupones(_i);
	}
	
	function _cmdPrintCupones(){
		window.print();
	}

	function eliminarDefinitivo(idCupon){
		var msje = "Esta seguro que desea Eliminar el Cupon?";
		var sUrl = "Pedidos.php";
		if(confirm(msje)){
			xajax_eliminarDefinitivoObjeto(idCupon,2,sUrl);
		}
	}
	
	function Habilitar()
	{
		  var mensaje="¿Esta seguro de Habilitar los elementos seleccionados?"; 
		  var el = document.getElementById('tableCupones');
		  var imputs= el.getElementsByTagName('input');
		  var band=0;
		  		  
		  for (var i=0; i<imputs.length; i++) 
		  {			
		    if (imputs[i].type=='checkbox')	
		    { 		    	
		    	if(!imputs[i].checked) 
		     	{
		         	band=0; 
		     	}
		     	else
		     	{ 
		     		band=1; break;
		     	}
		    }	
		  }
		  	
		  if(band==1)
		  {
		  	 if(confirm(mensaje))
		       xajax_habilitarCupones(xajax.getFormValues('formCupones'));
		  }
		  else alert('Debe Elegir al menos un elemento a habilitar.');	   
	}
</script>

</div>	
<div id="impresiones"></div>
</body>
</html>