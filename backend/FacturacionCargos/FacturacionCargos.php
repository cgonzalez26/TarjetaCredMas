<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();
	

	#Control de Acceso al archivo
	//if(!isLogin())
	//{
		//go_url("/index.php");
	//}
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	
	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
		
	if ($Pagina <= 0) $Pagina = 1;

	$NombreMod = 'FacturacionCargos'; // Nombre del modulo
	$NombreTipoRegistro = 'FacturacionCargos';	// Nombre tipo de registro
	$NombreTipoRegistroPlu = 'FacturacionCargos'; // Nombre tipo de registros en Plural
	$Masculino = false;	// Genero del tipo de registro (true: masculino - false: femenino)
	$arrListaCampos = array('FacturacionesCargos.sGrupoAfinidad', 'FacturacionesCargos.sTipoAjuste', 'FacturacionesCargos.sTipoFacturacion', 'FacturacionesCargos.fValor');
	$arrListaEncabezados = array('Grupo Afinidad', 'Tipo de Ajuste', 'Tipo de Facturacion', 'Valor');
	$Tabla = 'FacturacionesCargos'; // Tabla sobre la cual trabajaremos
	$PK = 'id';	// Nombre del campo Clave Principal
	$CampoOrdenPre = 'GruposAfinidades.sNombre'; // Campo de orden predeterminado
	$TipoOrdenPre = 'ASC';	// Tipo de orden predeterminado
	$RegPorPag = 15; // Cantidad de registros por página

	if(!$CampoOrden) $CampoOrden = $CampoOrdenPre;
	if(!$TipoOrden) $TipoOrden = $TipoOrdenPre;
	$PrimReg = ($Pagina - 1) * $RegPorPag;

	$sqlCuenta = "SELECT COUNT(id) FROM $Tabla";
	
		
	if(isset($_POST['buscar']))
	{	
		$nombre_u = $_POST['nombre_buscar'];
		$condic = $_POST['condic']; // variable para manejar las condiciones
		$condic1 = $_POST['condic']; //variable que se usa en la paginacion 

		//echo "Nombre ". $_POST['nombre_u'];
	
		if(!session_is_registered('snombre_u'))
		{
			session_register('snombre_u');
			session_register('scondic');
		}
	
		$_SESSION['snombre_u'] = $_POST['nombre_buscar'];	
		$_SESSION['scondic'] = $_POST['condic'];
		unset($_SESSION['volver']);
	}
	else
	{
		$nombre_u = $_SESSION['snombre_u'];
		$condic = $_SESSION['scondic'];	
		$condic1 = $_SESSION['scondic'];	
	}

	
	$sWhere = "";
	
	$aCond=Array();
	
	if($nombre_u)
	{
		$aCond[]=" $condic LIKE '%$nombre_u%' ";		
	}	
	
	echo $sCondiciones;
	$sCondiciones= " WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden LIMIT $PrimReg, $RegPorPag ";
	$sCondiciones_sLim=" WHERE ".implode(' AND ',$aCond)."  ORDER BY $CampoOrden $TipoOrden";
		
	//echo $sCondiciones;
	
	session_register('nombre_u');
	session_register('condic');
	
	$nombre_u = $_GET['nombre_u'];
	$condic = $_GET['condic'];
	
	//echo $sCondiciones;
	
	$sqlDatos="Call usp_getFacturacionDeCargos(\"$sCondiciones\");";
	$sqlDatos_sLim="Call usp_getFacturacionDeCargos(\"$sCondiciones_sLim\");";
	
	// Cuento la cantidad de registros sin LIMIT
	$CantReg = $oMysql->consultaSel($sqlCuenta,true); 
	// Ejecuto la consulta
	$result = $oMysql->consultaSel($sqlDatos);
	$result_sLim = $oMysql->consultaSel($sqlDatos_sLim);
		
	//var_export($result); 
	$CantRegFiltro = sizeof($result_sLim);

	$oXajax=new xajax();
	
	$oXajax->registerFunction("updateEstadoFacturacionDeCargos");
	$oXajax->registerFunction("habilitarFacturacionDeCargos");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	//$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);	
	
?>

<body style="background-color:#FFFFFF;">
<div id="BodyUser">

<?php 		
		echo parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorFacturacionCargos.tpl");
?>

<center>
<p>
	<img src="../includes/images/Formularios/icoNuevo.gif" align="absmiddle" alt="Nuevo">
		 <a href="AdminFacturacionCargos.php?action=new"> Nuevo</a>
</p>



<?
	if (count($result)==0)
	{
		echo "Ningun registro encontrado";
	}
	
	$sCadena = "";
	
	if ($result)
	{	
	
	  $sCadena .= "<p>Hay ".$CantReg." ";
	  
	  if ($CantReg>1) $sCadena .= $NombreTipoRegistroPlu; 
	  else $sCadena .= $NombreTipoRegistro;
	
	  $sCadena .= " en la base de datos.</p>
		<form id='formFacturacionCargos' action='' method='POST' >
		<center>
		<table class='TablaGeneral' align='center' style='width:80% !important;' cellpadding='3' cellspacing='0' border='1' bordercolor='#000000' width='98%' id='tablaOficinas'>
			<tr class='filaPrincipal'>
			<!-- Lista de encabezados de columna -->";
		
		$CantEncabezados = count($arrListaEncabezados);
		
		for($i=0; $i<$CantEncabezados; $i++)
		{
			$sCadena .= "<th style='height:25px'>";
			
			if($CampoOrden == $arrListaCampos[$i])
			{
				if ($TipoOrden == 'ASC') $NuevoTipoOrden = 'DESC'; else $NuevoTipoOrden = 'ASC';
			}
			else $NuevoTipoOrden = 'ASC';
			
			$sCadena .= "<a href=\"{$_SERVER['PHP_SELF']}?CampoOrden={$arrListaCampos[$i]}&TipoOrden={$NuevoTipoOrden}\">{$arrListaEncabezados[$i]}";
			
			if($CampoOrden == $arrListaCampos[$i])
			{
				if ($TipoOrden == 'ASC') 
					$sCadena .= "<img src='../includes/images/go-up.png' alt='Ordenado por {$arrListaEncabezados[$i]} Ascendenrte' title='Ordenado por {$arrListaEncabezados[$i]} Ascendenrte'/></a>"; 
				else 
					$sCadena .= "<img src='../includes/images/go-down.png' alt='Ordenado por {$arrListaEncabezados[$i]} Descendente' title='Ordenado por {$arrListaEncabezados[$i]} Descendente'/></a>";
			}
			
			//$sCadena .= "</th>\r\n";
		}
		///Opciones de Mod. y Elim.
		$sCadena .="<th colspan='2'>Acciones</th>
			<th style='cursor:pointer;'><input type='checkbox' onchange='tildar_checkboxs( this.checked )' id='checkbox_principal' /> </th>
			</tr>";
	    echo $sCadena;
	
		$CantMostrados = 0;
		
		//var_export($result);
		
		foreach ($result as $rs )
		{
			//echo ($rs['sNombre']);	
			$sBotonera = '';	
			$CantMostrados ++;
			$PK = $rs['id'];
			$sClase='';
			
			$rs['sNombre'] = htmlspecialchars_decode($rs['sNombre']);
			
			//$sBotonera='&nbsp;';
				
			if($rs['sEstado'] == 'B')
			{
				$sClase="class='rojo'"; 
				$sBotonera='&nbsp;';
			}
			else
			{
				$oBtn = new aToolBar();
				$oBtn->setAnchoBotonera('auto');
				
				$oBtn->addBoton("Modificar{$rs['id']}","onclick","editar({$rs['id']})",'Editar','Modificar',true,true);	
				$oBtn->addBoton("Eliminar{$rs['id']}","onclick","eliminar({$rs['id']})",'Eliminar','Eliminar',true,true);
				
				$sBotonera = $oBtn->getBotoneraToolBar('');		
				//$sBotonera = "<input name='btn' type='button' value='Modificar' onClick='editarGrupoAfinidad({$rs['id']})' />
				//<input name='btn' type='button' value='Eliminar' onClick='eliminarGrupoAfinidad({$rs['id']})' />";
			}
?>

		<tr id="FacturacionDeCargos	<?php echo $PK;?>">
			<!-- Valores -->
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sGrupoAfinidad']?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sTipoAjuste']?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['sTipoFacturacion']?></td>
			<td align="left" <?php echo $sClase;?>>&nbsp;<?=$rs['fValor']?></td>
			
			<!-- Links para Mod. y Elim. -->
			<td colspan="2" align="center">
			<?=$sBotonera;?>
			</td>
			<td align="center"><input type='checkbox' id='aHabilitar[]' name='aHabilitar[]' class="check_user" value='<?php echo $PK;?>'/> </td>
		</tr>
	
<?
		}
?>
</tr>
	<tr>
	   <td colspan="7" align="right">
	   	   <div> 
	   	    	<button type="button" onclick="Habilitar();"> Habilitar </button> &nbsp;
	   	   </div>
	   </td>
	</tr> 
</table>
	<div style='font-size:10px;text-align:left;width:80%'>
		<span class='rojo'>Rojo-Grupos de Baja. <span><br>
</div>	
</center>
</form>

<?
		if (ceil($CantRegFiltro/$RegPorPag) > 1)
		{
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
	} // if(result)
?>
	
	
<script>
	function editar(idFacturacionCargos){
		window.location ="AdminFacturacionCargos.php?idFacturacionCargos="+ idFacturacionCargos;
	}
	
	function eliminar(idFacturacionCargos){
		if(confirm("¿Desea eliminar el elemento seleccionado?"))
		{
			xajax_updateEstadoFacturacionDeCargos(idFacturacionCargos,'B');
		}
	}
	
	function Habilitar()
	{
		  var mensaje="¿Esta seguro de Habilitar los elementos seleccionados?"; 
		  var el = document.getElementById('tablaOficinas');
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
		       xajax_habilitarFacturacionDeCargos(xajax.getFormValues('formFacturacionCargos'));
		  }
		  else alert('Debe Elegir al menos un elemento a habilitar.');	   
	}

</script>
<?php echo xhtmlFootPagina();?>
