<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	$idUser = $_SESSION['ID_USER'];
	$TypeUser = $_SESSION['TYPE_USER'];	

	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
	
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
	
	$oXajax = new xajax();
	$oXajax->setCharEncoding('ISO-8859-1');
	$oXajax->configure('decodeUTF8Input',true);
	$oXajax->register( XAJAX_FUNCTION , 'updatePlanillaCobranza');	
	$oXajax->register( XAJAX_FUNCTION , 'impactarPagosUnaFecha');	
	$oXajax->register( XAJAX_FUNCTION , 'impactarPagos');
	$oXajax->processRequest();					
	$oXajax->printJavascript( "../includes/xajax/");
	
	//xhtmlHeaderPagina($aOpciones);
	xhtmlHeaderPaginaGeneral($aParametros);	
	
	$idCobranza = $_GET['idT'];
	$sCodigo = $_GET['sCodigo'];
	$fTotal = $_GET['fCodigo'];
	$idCobrador = $_GET['idCobrador'];
	$dFechaCobro2 = $_GET['dFechaCobro2'];
?>
	<!--<body style="background-color:#FFFFFF;">-->
	<div>
	<form action="CobranzaDeuda.php" enctype="multipart/form-data" name="formDeuda" id="formDeuda" method="POST">
	<fieldset>
	<legend>Registrar Aprobacion de Planilla con Deuda:</legend>
	<input type="hidden" name="idCobranza" id="idCobranza" value="<?php echo $idCobranza;?>" />
	<input type="hidden" name="hdnCodigo" id="hdnCodigo" value="<?php echo $sCodigo;?>" />	<input type="hidden" name="hdnTotal" id="hdnTotal" value="<?php echo $fTotal;?>" />	
	<input type="hidden" value="1" name="ok">
    <input type="hidden" name="hdnIdCobrador" id="hdnIdCobrador" value="<?php echo $idCobrador;?>" />		
	<input type="hidden" id="hdnFechaCobro2" name="hdnFechaCobro2" value="<?php echo $dFechaCobro2;?>" />

	<table class="formulario" style="font-family:Tahoma;font-size:10pt;">
		<tr><th style="width:80px">(*)Deuda:</th><td><input type="text" name="deuda" id="deuda" ></td></tr>
	</table>	
	<button type="button" onclick="enviar(this.form.id)" style="margin-top:5px;">Aceptar</button>
	<!--<button type="button" onclick="cerrarVentana()" style="margin-top:5px;">Cancelar</button>-->
	</fieldset>

	</form>
	<script language="javascript">
		function enviar(id)
		{
			var formu=document.forms[id];
			var mensaje='';
		    if(formu.deuda.value=='') mensaje +='Debe Indicar la Deuda Gracias.\n';
			if (mensaje=='') 
				if(document.getElementById("hdnFechaCobro2").value == "")
	    			xajax_impactarPagosUnaFecha(xajax.getFormValues('formDeuda'),4);
	    		else	
		    		xajax_impactarPagos(xajax.getFormValues('formDeuda'),4);						
		    else alert(mensaje);
		}
		
		function cerrarVentana(){
			//parent.Windows.close(parent.Windows.focusedWindow.getId());			
			parent.resetDatosForm();			
		}
		
		function resetDatosForm(){
			cerrarVentana();			
		}
		
		function updateCobranza(idEstadoCobranza){
	    	xajax_updatePlanillaCobranza(xajax.getFormValues('formDeuda'),idEstadoCobranza);
	    }
	</script>
<?php
	echo xhtmlFootPagina();
?>	