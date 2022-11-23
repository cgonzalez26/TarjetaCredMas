<?
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );
  
	   //phpinfo();
//die(); 
	
	$idObjeto = 28;
	$arrayPermit = explode(',',$_SESSION['_PERMISOS_'][$idObjeto]['sPermisos']);

	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	

	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
		
	if ($Pagina <= 0) $Pagina = 1;

	$NombreMod = 'Objetos'; // Nombre del modulo
	$NombreTipoRegistro = 'Objeto';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'Objetos'; // Nombre tipo de registros en Plural
	$Masculino = true;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('Objetos.idUnidadNegocio','Objetos.sNombre', 'Objetos.sUrl','Objetos.iOrder');
	$arrListaEncabezados = array('Unidad de Negocio','Nombre','Url','Objeto Padre');
	$Tabla = 'Objetos'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'Objetos.iOrder'; // Campo de orden predeterminado
	$TipoOrdenPre = 'ASC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
	$idUnidadNegocio = 0;
	if(isset($_POST['buscar'])){	
		
		$sNombreObjeto = $_POST['sNombreObjeto'];
		$idUnidadNegocioObjeto = $_POST['idUnidadNegocioObjeto']; // variable para manejar las condiciones
		
		if(!session_is_registered('sNombreObjeto'))
		{
			session_register('sNombreObjeto');
			session_register('idUnidadNegocioObjeto');
		}
		$_SESSION['sNombreObjeto'] = $_POST['sNombreObjeto'];
		$_SESSION['idUnidadNegocioObjeto'] = $_POST['idUnidadNegocioObjeto'];	
		
	}else{
		$sNombreObjeto = $_SESSION['sNombreObjeto'];
		$idUnidadNegocioObjeto = $_SESSION['idUnidadNegocioObjeto'];
	}
	
	if($sNombreObjeto){$aCond[]=" Objetos.sNombre LIKE '%".trim($sNombreObjeto)."%' ";}
	if($idUnidadNegocioObjeto){$aCond[]=" Objetos.idUnidadNegocio = '".trim($idUnidadNegocioObjeto)."' ";}
	
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
	
	$sqlDatos="Call usp_getObjects(\"$sCondiciones\");";
	$sqlDatos_sLim="Call usp_getObjects(\"$sCondiciones_sLim\");";
	//echo $sqlDatos;
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);
	
	$aParametros['optionsUnidadesNegocios'] = $oMysql->getListaOpciones( 'UnidadesNegocios', 'id', 'sNombre', $idUnidadNegocio);

	$oXajax=new xajax();	
	$oXajax->registerFunction("updateEstadoObjeto");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	?>
	<body style="background-color:#FFFFFF;">
	<center>
	<?php 
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorObjetos.tpl",$aParametros);
	?>
	<p><img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo">
		 <a href="AdminObjetos.php?action=new"><? if($Masculino) echo 'Nuevo '; else echo 'Nuevo '; echo $NombreTipoRegistro;?>
		 </a>
	</p><br>	
	<?
	if (count($result)==0){echo "Ningun registro encontrado";}
	$sCadena = "";
	if ($result){	
		/*$sCadena .= "<p>Hay ".$CantReg." ";
		if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
		else $sCadena .= $NombreTipoRegistro;
		
		$sCadena .= " en la base de datos.</p>*/
		$sCadena .= "<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='90%' id='tablaObjetos'>
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
			$sCadena .= "<a href=\"{$_SERVER['PHP_SELF']}?CampoOrden={$arrListaCampos[$i]}&TipoOrden={$NuevoTipoOrden}\">{$arrListaEncabezados[$i]}";
			if($CampoOrden == $arrListaCampos[$i]){
				if ($TipoOrden == 'ASC') 
					$sCadena .= "<img src='../includes/images/go-up.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendente' title='Ordenado por {$arrListaEncabezados[$i]} Ascendente'/></a>"; 
				else 
					$sCadena .= "<img src='../includes/images/go-down.png' alt='Ordenado por {$arrListaEncabezados[$i]} Descendente' title='Ordenado por {$arrListaEncabezados[$i]} Descendente'/></a>";
			}
			$sCadena .= "</th>\r\n";
		}
		///Opciones de Mod. y Elim.
		$sCadena .="<th colspan='2'>Acciones</th></tr>";
		 echo $sCadena;

		$CantMostrados = 0;
		foreach ($result as $rs ){
			$sBotonera = '';	
			$CantMostrados++;
			$PK = $rs['id'];
			$sClase='';
			switch ($rs['bItemVisible'])
			{
				case 0: $sClase="class='rojo'"; break;//estado Baja
			}
			$oBtn = new aToolBar();
			$oBtn->setAnchoBotonera('auto');
			$oBtn->addBoton("Modificar{$rs['id']}","onclick","editar({$rs['id']})",'Editar','Modificar',true,true);		
			$oBtn->addBoton("DarBaja{$rs['id']}","onclick","darbaja({$rs['id']},'{$rs['sNombre']}')",'Eliminar','Dar Baja',true,true);
			//$oBtn->addBoton("EliminarDefinitivo{$rs['id']}","onclick","eliminarDefinitivo({$rs['id']})",'EliminarDefinitivo','Eliminar Definitivo',true,true);		
			
			$sPadre = $oMysql->consultaSel("SELECT sNombre FROM Objetos WHERE id='{$rs['iOrder']}'",true);
			$sBotonera = $oBtn->getBotoneraToolBar('');		
			?>
			<tr id="empleado<?php echo $PK;?>">
				<!-- Valores -->
				<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sUnidadesNegocios'];?></td>
				<td width="15%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sNombre'];?></td>
				<td width="10%" align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sUrl'];?></td>	
				<td width="20%" align="left" <?php echo $sClase;?>>&nbsp;<?=$sPadre;?></td>	
				<!-- Links para Mod. y Elim. -->
				<td colspan="2" align="center" width="5%">
					<?=$sBotonera;?>
				</td>
			</tr>
			<?
		}
		?>
		</tr> 
		</table>
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


function editar(idObjeto){
	window.location ="AdminObjetos.php?oIa_=<?=$_GET['oIa_']?>&idO="+ idObjeto;	
}

function darbaja(idObjeto,sObjeto){
	if(confirm("Esta seguro que desea Dar de Baja el Objeto '"+sObjeto+ "'?"))
	{
		xajax_updateEstadoObjeto(idObjeto,0);
	}
}

/*function Habilitar(){
	  var mensaje="¿Esta seguro de Habilitar a el/las Oficina/s seleccionada/s?"; 
	  var el = document.getElementById('tablaOficinas');
	  var imputs= el.getElementsByTagName('input');
	  var band=0;
	  for (var i=0; i<imputs.length; i++) 
	  {
	    if (imputs[i].type=='checkbox')	
	     if(!imputs[i].checked) 
	     {
	         band=0;
	     }
	     else{ band=1; break;}
	  }	
	  if(band==1)
	  {
	  	 if(confirm(mensaje))
	       xajax_habilitarOficinas(xajax.getFormValues('formOficinas'));
	  }
	  else alert('Debe Elegir al menos una Oficina a habilitar.');	   
}*/

</script>
<?php echo xhtmlFootPagina();?>