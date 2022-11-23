<body style="background-color:#FFFFFF">
<div id='BODY'>
<table cellpadding='0' cellspacing='0' width='100%' class='TablePermits' border="0">
	<tr>
		<td class='title' width='300'><strong>Administraci&oacute;n de Cobranzas</strong></td>
	</tr>
</table>
<form id="form" method="POST" name='form' action='ExportarCobranza.php'>
<input type="hidden" id="idCobranza" name="idCobranza" value="{ID_COBRANZA}" />
<input type="hidden" name="type" id="type" value="NEW"> 
<input type="hidden" id="hdnFechaCobro1" name="hdnFechaCobro1" value="" />
<input type="hidden" id="hdnFechaCobro2" name="hdnFechaCobro2" value="" />
<input type="hidden" id="hdnFechaCobro3" name="hdnFechaCobro3" value="" />
<input type="hidden" id="hdnCodigo" name="hdnCodigo" value="" />
<input type="hidden" id="hdnTotal" name="hdnTotal" value=0 />
<input type="hidden" id="hdnResponsable" name="hdnResponsable" value=0 />
<input type="hidden" id="hdnCobrador" name="hdnCobrador" value=0 />
<input type="hidden" id="hdnIdCobrador" name="hdnIdCobrador" value=0 />

<div id="HeaderCobranza" style="padding-top:10px">
<table width="{ANCHO_GRILLA}" align="center" style=''>
<tr>
	<td style="width:50%">
		<fieldset>
			<legend>Generar Planilla:</legend>
			<table width="100%" align="center" cellpadding="0" cellspacing="5">				
			<tr>
				<td>(*)Tipo de Plan:</td>
				<td>
				<input type="checkbox" id="chkDiarios" name="chkDiarios" checked="checked"/>Diarios
				<input type="checkbox" id="chkSemanales" name="chkSemanales" checked="checked"/>Semanales
				<input type="checkbox" id="chkMensuales" name="chkMensuales" checked="checked"/>Mensuales
				</td>
			</tr>
			<tr>
				<td>(*)Cobrador:</td>
				<td>
					<select id="idCobrador" name="idCobrador" style="width:150px">
					{OPCIONES_COBRADORES}
					</select>
				</td>
			</tr>	
			<tr>
				<td>(*)Fecha de Inicio:</td>
				<td><div style="position: relative; border: 1px solid navy; width:150px;">
					<input type="text" id="dFechaInicio" name="dFechaInicio" value="{HOY}" style="width:132px;float: left;border-width: 0px;" />
					<img src="../includes/images/calendar.gif"  title="Elegir Fecha" onclick="showCalendar();" style="cursor: pointer;" />
					<div style="position: absolute;top: 20px; display: none;" id="calendar1">
					</div>
				</div>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="checkbox" id="chkUnaFecha" name="chkUnaFecha" />Planilla de una sola fecha</td>
			</tr>
			<tr>
				<td><input type="button" id="cmd_Generar" name='cmd_Generar' value='Generar' style="width:80px" onclick="sendFormGenerar();" /></td>
			</tr>
			</table>
		</fieldset>
	</td>
	<td>
		<fieldset>
			<legend>Buscar Planillas:</legend>
			<table width="100%" align="center" cellpadding="0" cellspacing="5">						<tr>
				<td>Codigo:</td>
				<td colspan="3"><input type="text" id="sCodigo" name="sCodigo" style="width:150px"/></td>
			</tr>
			<tr>
				<td>Cobrador:</td>
				<td colspan="3">
					<select id="idCobradorSearch" name="idCobradorSearch" style="width:150px">
					{OPCIONES_COBRADORES}
					</select>
				</td>
			</tr>
			<tr>
				<td>Desde:</td>
				<td><input type="text" id="dFechaDesde" name="dFechaDesde" style="width:150px"/></td>
				<td>Hasta:</td>
				<td><input type="text" id="dFechaHasta" name="dFechaHasta" style="width:150px"/></td>
			</tr>
			<tr>
				<td><input type="button" id="cmd_Buscar" name='cmd_Buscar' value='Buscar' style="width:80px" onclick="sendFormBuscar();" /></td>
			</tr>
			</table>				
		</fieldset>	
	</td>
</tr>	
</table>
</div>

<table cellpadding='0' cellspacing='0' width='100%' class='TablePermits' border="0" style="padding-top:5px">
	<tr>
		<td class='subtitle' width='300'><strong>Listado de Cobranzas</strong></td>
	</tr>
</table>


<div id="GrillaCobranza">
<table width="{ANCHO_GRILLA}" align="center" style=''>
<tbody>
		<tr>         
			<td align="center">
			    <div id="iDivMenu"></div>
				<div id="gridbox" style="width:{ANCHO_GRILLA}; border:solid 1px #DDD; background-color:white;height:120px; font-size:20pt;"></div>
			</td>
		</tr>
</tbody>		
		
</table>
</div>


<!--<table cellpadding='0' cellspacing='0' width='100%' class='TablePermits' border="0" style="padding-top:5px">
	<tr>
		<td class='subtitle' width='300'><strong>Detalle de Cobranza</strong></td>
	</tr>
</table>-->

<div id="GrillaDetalleCobranza">
<table align="center" style='width:665px'>
<tbody>
		<tr>
			<td class='subtitle' width='300'><strong>Detalle de Cobranza</strong></td>
		</tr>
		<tr>         
			<td align="center">
				<div  style="text-align:right">
					<table align="center" style='width:650px'>	
					<tr>	
						<td style='width:550px' align="right">Codigo:</td>
						<td><div id="iDivCodigo">_ _ _ _ _ _</div></td>
					</tr>
					</table>
				
				</div>
				<div id="iDivMenuPlanillas"></div>
				<div id="gridboxPlanillas" style=" border:solid 1px #DDD; background-color:white;height:250px; font-size:20pt;"></div>
			</td>
		</tr>
		<tr>         
			<td align="center">
				<div   id="iDivMenuClientesSemanales"></div>
				<div id="gridboxClientesSemanales" style=" border:solid 1px #DDD; background-color:white;height:150px; font-size:20pt;"></div>
			</td>
		</tr>
		<tr>
			<td align="center">
				<div   id="iDivMenuClientesMensuales"></div>
				<div id="gridboxClientesMensuales" style=" border:solid 1px #DDD; background-color:white;height:150px; font-size:20pt;"></div>
			</td>
		</tr>		
		<tr>
			<td class='subtitle'>
				<table cellpadding='0' cellspacing='0' style='width:650px' border="0">	
					<tr>	
						<td style='width:80px;padding-left:20px;font-family:Tahoma;font-size:11px;font-weight:bold' align="right">Total Diarios:</td>
						<td style="padding-left:5px;"><div id="total_diarios" style="width:30px">0</div></td>
						<td style='width:100px;font-family:Tahoma;font-size:11px;font-weight:bold;' align="right">Total Semanales:</td>
						<td style="padding-left:5px;"><div id="total_sem" style="width:30px">0</div></td>
						<td style='width:100px;font-family:Tahoma;font-size:11px;font-weight:bold;' align="right">Total Mensuales:</td>
						<td style="padding-left:5px;"><div id="total_mens" style="width:30px">0</div></td>
						<td style='width:100px;font-family:Tahoma;font-size:11px;font-weight:bold;' align="right">Total Planilla:</td>
						<td style="padding-left:5px;"><div id="total_planilla" style="width:40px">0</div></td>
					</tr>
					
				</table>
			</td>
		</tr>
		<tr>	
			<td>
				<input type='button' name='cmd_Aprobar' id='cmd_Aprobar' value='Aprobar' style="display:none" onclick="aprobarCobranza();">
				<input type='button' name='cmd_AprobarDeuda' id='cmd_AprobarDeuda' value='Aprobar con Deuda' style="display:none" onclick="aprobarCobranzaConDeuda();">
				<input type='button' name='cmd_Anular' id='cmd_Anular' value='Anular' style="display:none" onclick="anularCobranza();">
				<input type='button' name='cmd_Cancelar' id='cmd_Cancelar' value='Cancelar' onclick="resetDatosForm();" >
				<input type='button' name='cmd_Cerrar' id='cmd_Cerrar' value='Cerrar Mes' onclick="cerrarMes();" style="{STYLE_CERRARMES}" >
			</td>
		</tr>
</tbody>		
		
</table>
</div>

</form>

<script>
	function imprimirPlanilla(){
		var Formu = document.forms['form'];
		var sCodigo = Formu.hdnCodigo.value;
		var idCobranza = Formu.idCobranza.value;
		if(idCobranza == 0){
			alert("Debe cargar una Cobranza para Imprimir");
		}else{
			var sFechaCobro1 = Formu.hdnFechaCobro1.value;
			var sFechaCobro2 = Formu.hdnFechaCobro2.value;
			var sFechaCobro3 = Formu.hdnFechaCobro3.value;
			xajax_imprimirPlanilla(xajax.getFormValues('form'));		
		}
	}

	function exportar( tipo ) {
		var Formu = document.forms['form'];
		var idCobranza = Formu.idCobranza.value;
		if(idCobranza == 0){
			alert("Debe cargar una Cobranza para Imprimir");
		}else{
			Formu.submit();
		}
	}
	
	var mCal,cal1;
	window.onload = function(){
    	cal1 = new dhtmlxCalendarObject('calendar1');
    	cal1.setOnClickHandler(selectDate1);
    	
	}
	
	function selectDate1(date){
		var dateformat = "%d/%m/%Y";
	    document.getElementById('dFechaInicio').value = cal1.getFormatedDate(dateformat, date);
	    document.getElementById('calendar1').style.display = 'none';
	    return true;
	}
	
	function showCalendar(){
	    document.getElementById('calendar1').style.display = 'block';
	}
	
 	mygrid = new dhtmlXGridObject('gridbox');
	mygrid.selMultiRows = false;
	mygrid.setImagePath("../includes/grillas/dhtmlxGrid/imgs/");
	var flds = "Codigo,Fecha,Cobrador,Estado";
	mygrid.setHeader(flds);
	mygrid.setInitWidths("100,100,200,100");//",195,170,150,300"
	mygrid.setColAlign("left,center,left,left,center");
	mygrid.setColTypes("ed,ed,ed,ed");
	
	{OPCIONES_ESTADOS}
	
    var sColumnas="sCodigo,dFechaRegistro,sApellido,idEstadoPedido";
	mygrid.setColumnIds(sColumnas);
	mygrid.setColSorting("str,str,str,int");
	//mygrid.attachHeader("#text_filter,#text_filter,#text_filter,,,#text_filter");
	mygrid.setColumnColor("#B5D6DF,white,#B5D6DF,white");
	mygrid.setMultiLine(false);
	mygrid.setSkin("xp");
	//mygrid.enableSmartRendering(true);
	mygrid.init();
   	mygrid.loadXML("xmlCobranzas.php");
	   	
	myDataProcessor = new dataProcessor("processCobranzas.php");
    myDataProcessor.enableDataNames('true');
    myDataProcessor.setUpdateMode("on");
    myDataProcessor.defineAction("error",myErrorHandler);
    myDataProcessor.setTransactionMode("GET");
    myDataProcessor.init(mygrid);
    
    function myErrorHandler(obj){
 		alert("Ocurrio un error durante la operacion: \n " + obj.firstChild.nodeValue);      
 		myDataProcessor.stopOnError = true;
        return false;
    }
    
    function checkIfNotZero(value,colName){
        if(value.toString()._dhx_trim()==""){
            alert("El valor de "+colName+" no debe estar vacio");
            value="---";
            return false
        }else
            return true;
    }    

	var menu = new dhtmlXMenuObject("iDivMenu",'dhx_blue');//
	menu.setImagePath("../includes/grillas/dhtmlxMenu/sources/imgs/");
	menu.setIconsPath("../includes/grillas/dhtmlxMenu/sources/images/");	
	
	menu.addNewSibling(null,"idNuevo", "", false, "");	
	menu.addNewSibling("idNuevo", "idGuardar", "Guardar",false, "save.gif");
	menu.addNewSibling("idGuardar","idBorrar", "Borrar",false, "close2.gif");
	menu.attachEvent("onClick", menuClickCobranzas);
	
    mygrid.attachEvent("onRowSelect",doOnRowSelected);
    mygrid.attachEvent("onEnter",doOnRowSelected);
    
    function menuClickCobranzas(id) {
		switch(id)
			{				
				case 'idGuardar':{saveDatos_(); break;}
				case 'idBorrar':{
					if(confirm('Realmente desea eliminar la/las Cobranzas/s seleccionadas?'))
						mygrid.deleteSelectedRows();
					break; }
			}
		
		return true;
	}

	function saveDatos_(){
		//myDataProcessor.sendData();		
		xajax_eliminarCobranza(xajax.getFormValues('form'));
	}
	
    function doOnRowSelected(id){
		xajax_CargarDatosCobranza(id);	
		//document.getElementById('iDivMessageCustomer').innerHTML = "";	
	}

	function validarFormGenerar(){
		var errores = "";
		var Formu = document.forms['form'];
		
		with (Formu){
			if(!chkDiarios.checked && !chkSemanales.checked && !chkMensuales.checked){
				errores += "Debe seleccionar al menos un Tipo de Plan.\n";
			}
			if (idCobrador.value == 0){
				errores += "El campo Cobrador es requerido.\n";
			}	
			if (dFechaInicio.value == ""){
				errores += "El campo Fecha de Inicio es requerido.";
			}	
		}
		if (errores){
			alert(errores);
			return false;
		}
		else return true;
	}
	
	function sendFormGenerar(){
		if(!validarFormGenerar())
		{
			return;
		}
		var dFechaIni = document.getElementById("dFechaInicio").value;		
		if(confirm("¿Desea generar la Cobranza con Fecha de Inicio: "+dFechaIni+"?")){
			if(document.getElementById("chkUnaFecha").checked)
				xajax_generarPanillaUnaFecha(xajax.getFormValues('form'));	
			else
				xajax_generarPanilla(xajax.getFormValues('form'));	
		}
	}
	
	/*******************   PLANILLA DE COBROS DIARIOS ********************/
	mygrid_ = new dhtmlXGridObject('gridboxPlanillas');
    
	mygrid_.selMultiRows = true;
	mygrid_.setImagePath("../includes/grillas/dhtmlxGrid/imgs/");
	var titulo = "Diarios,#cspan,#cspan,#cspan,#cspan,#rspan";
	var flds = "Clientes,Monto,_/_/_,_/_/_,_/_/_";
	
	mygrid_.setHeader(titulo);
	mygrid_.attachHeader(flds);
	mygrid_.setInitWidths("250,100,100,100,100");//",195,170,150,300"
	mygrid_.setColAlign("left,left,left,left,left");	
	mygrid_.setColTypes("ro,ro,ed,ed,ed");	
    var sColumnas_="sCliente,fMonto,fMontoPago1,fMontoPago2,fMontoPago3";
	mygrid_.setColumnIds(sColumnas_);	
	mygrid_.setColSorting("str,str,str,str,str");
	mygrid_.setColumnColor("#B5D6DF,white,#B5D6DF,white,#B5D6DF");
	mygrid_.setMultiLine(false);

	mygrid_.setSkin("light");
	mygrid_.attachFooter("Totales,#cspan,<div id='total_1'>0</div>,<div id='total_2'>0</div>,<div id='total_3'>0</div>",["text-align:left;"]);
	mygrid_.init();
	
   	//mygrid_.loadXML("xmlClientesCobranzas.php");  	
  	mygrid_.attachEvent("onEnter",calculateFooterValues);	   	
	myDataProcessor_ = new dataProcessor("processClientesCobros.php");    
    myDataProcessor_.enableDataNames('true');    
    myDataProcessor_.setUpdateMode("on");    
    myDataProcessor_.defineAction("error",myErrorHandler_);   
    myDataProcessor_.setTransactionMode("GET");
    myDataProcessor_.init(mygrid_);
    
    function myErrorHandler_(obj){
 		alert("Ocurrio un error durante la operacion: \n " + obj.firstChild.nodeValue);    
 		myDataProcessor_.stopOnError = true;
        return false;
    }
    
    function calculateFooterValues(){
        var t1 = document.getElementById("total_1");
        t1.innerHTML = sumColumn(2);
        var t2 = document.getElementById("total_2");
        t2.innerHTML = sumColumn(3);
        var t3 = document.getElementById("total_3");
        t3.innerHTML = sumColumn(4);
        var total = document.getElementById("total_planilla");

        var sumTotalDiarios = parseFloat(t1.innerHTML)+parseFloat(t2.innerHTML)+parseFloat(t3.innerHTML);        
        var total_diarios = document.getElementById("total_diarios");
        total_diarios.innerHTML = parseFloat(sumTotalDiarios);
        
        var total = document.getElementById("total_planilla");        
        var total_sem = document.getElementById("total_sem").innerHTML;
        var total_mens = document.getElementById("total_mens").innerHTML;
        total.innerHTML = parseFloat(sumTotalDiarios)+parseFloat(total_sem)+parseFloat(total_mens);
        var hTotal = document.getElementById("hdnTotal");
        hTotal.value = parseFloat(total.innerHTML);  
        myDataProcessor_.sendData();        
    }
    
    function sumColumn(ind){
        var out = 0;
        try{
        	indices_grilla = mygrid_.getAllItemIds().split(",");
			for(var k = 0; k < indices_grilla.length ; k++){						

				fValor = parseFloat(mygrid_.cells(indices_grilla[k],ind).getValue());	 						
				if(fValor == 'undefined' || isNaN(fValor) ){ fValor = 0; }	
				out+= parseFloat(fValor);
			}
		}catch(e){
			//alert('Hola');
		}       
        return out;
    }
    
    
   	var menu_ = new dhtmlXMenuObject("iDivMenuPlanillas",'dhx_blue');
	menu_.setImagePath("../includes/grillas/dhtmlxMenu/sources/imgs/");
	menu_.setIconsPath("../includes/grillas/dhtmlxMenu/sources/images/");	
	
	menu_.addNewSibling(null, "idGuardar", "",false, "");
	menu_.addNewSibling(null, "idBorrar", "",false, "");
	menu_.addNewSibling("idGuardar","idExportar", "Exportar",false, "excel.png");
	menu_.addNewSibling("idBorrar","idPrint", "Imprimir",false, "print.gif");
	menu_.attachEvent("onClick", menuClick_);
	
	function menuClick_(id){
		switch(id){
				case 'idNuevo':{			          
					agregarCliente();
					break;
				}
				case 'idExportar':{
					exportar(3);
					break;
				}
				case 'idPrint':{
					imprimirPlanilla(3);
					break;
				}
			}
		return true;
	}
	
	function agregarCliente(){
		var idCobranza = document.getElementById("idCobranza").value;
		var idCobrador = document.getElementById("hdnIdCobrador").value;
		if(idCobranza == 0){
			alert("Debe cargar una Cobranza para agregar Clientes");
			return;
		}
	
	    var win = new Window(
		    	  {className: "alphacube", 
				  title:'<b>Agregar Clientes</b>', 
				  width:680, 
				  height:380, 
				  top:50, 
				  left:60, 
				  url:'agregarCliente.php?idCobranza='+idCobranza+"&idCobrador="+idCobrador,
				  showEffect:Element.show,
				  hideEffect:Element.hide
				  }); 
	    win.toFront();	 
	    win.showCenter(); 	
	}
	
	function setDatosDetalleCobranza(idCobranza_,dFechaCobro1,dFechaCobro2,dFechaCobro3,sCodigo,idEstadoCobranza){
		//var Formu = document.forms['form'];			
		var Formu = document.getElementById('form');
		Formu.idCobranza.value = idCobranza_;		
		Formu.type.value = "EDIT";
		document.getElementById("iDivCodigo").innerHTML =sCodigo;
		Formu.hdnFechaCobro1.value = dFechaCobro1;
		if(dFechaCobro2 !="")Formu.hdnFechaCobro2.value = dFechaCobro2;
		if(dFechaCobro3 !="")Formu.hdnFechaCobro3.value = dFechaCobro3;
		Formu.hdnCodigo.value = sCodigo;
		Formu.hdnTotal.value = 0;
		document.getElementById("total_planilla").innerHTML = 0;
		
		var flds = "";
		if((dFechaCobro2 == "")&&(dFechaCobro3 == ""))
		    flds += "Clientes,Monto,"+dFechaCobro1+",,";
		else
			flds += "Clientes,Monto,"+dFechaCobro1+","+dFechaCobro2+","+dFechaCobro3;
			
		var titulo = "Diarios,#cspan,#cspan,#cspan,#cspan,#rspan";

		mygrid_.setHeader(flds);	
		mygrid_.clearAll(0);
		mygrid_.loadXML("xmlClientesCobranzas.php?tipoPlan=1&idPlanillaCobranza=" + idCobranza_,calculateFooterValues); 			
		mygrid_.init();
		mygrid_.attachFooter("Totales,#cspan,<div id='total_1'>0</div>,<div id='total_2'>0</div>,<div id='total_3'>0</div>",["text-align:left;"]);

		mygrid_sem.setHeader(flds);	
		mygrid_sem.clearAll(0);
		mygrid_sem.loadXML("xmlClientesCobranzas.php?tipoPlan=2&idPlanillaCobranza=" + idCobranza_,calculateFooterValuesSemanal); 		
		mygrid_sem.init();
		mygrid_sem.attachFooter("Totales,#cspan,<div id='total_sem_1'>0</div>,<div id='total_sem_2'>0</div>,<div id='total_sem_3'>0</div>",["text-align:left;"]);

		mygrid_mens.setHeader(flds);	
		mygrid_mens.clearAll(0);
		mygrid_mens.loadXML("xmlClientesCobranzas.php?tipoPlan=3&idPlanillaCobranza=" + idCobranza_,calculateFooterValuesMensual); 		
		mygrid_mens.init();
		mygrid_mens.attachFooter("Totales,#cspan,<div id='total_mensual_1'>0</div>,<div id='total_mensual_2'>0</div>,<div id='total_mensual_3'>0</div>",["text-align:left;"]);
		
		
		if(idEstadoCobranza == 2){
			document.getElementById("cmd_Aprobar").style.display = "inline";
			document.getElementById("cmd_AprobarDeuda").style.display = "inline";
			document.getElementById("cmd_Anular").style.display = "inline";
		}
		//calcularTotalPlanilla();	
	}
	
	function calcularTotalPlanilla(){
		document.getElementById("total_proforma").innerHTML = document.getElementById("hdnTotal").value;
	}
	
	
	/*******************   PLANILLA DE COBROS Semanales ********************/
	mygrid_sem = new dhtmlXGridObject('gridboxClientesSemanales');
    
	mygrid_sem.selMultiRows = true;
	mygrid_sem.setImagePath("../includes/grillas/dhtmlxGrid/imgs/");
	var titulo = "Semanales,#cspan,#cspan,#cspan,#cspan,#rspan";
	var flds = "Clientes,Monto,_/_/_,_/_/_,_/_/_";
	
	mygrid_sem.setHeader(titulo);
	mygrid_sem.attachHeader(flds);
	mygrid_sem.setInitWidths("250,100,100,100,100");//",195,170,150,300"
	mygrid_sem.setColAlign("left,left,left,left,left");	
	mygrid_sem.setColTypes("ro,ro,ed,ed,ed");	
    var sColumnas_="sCliente,fMonto,fMontoPago1,fMontoPago2,fMontoPago3";
	mygrid_sem.setColumnIds(sColumnas_);	
	mygrid_sem.setColSorting("str,str,str,str,str");
	mygrid_sem.setColumnColor("#B5D6DF,white,#B5D6DF,white,#B5D6DF");
	mygrid_sem.setMultiLine(false);


	mygrid_sem.setSkin("light");
	mygrid_sem.attachFooter("Totales,#cspan,<div id='total_sem_1'>0</div>,<div id='total_sem_2'>0</div>,<div id='total_sem_3'>0</div>",["text-align:left;"]);
	mygrid_sem.init();
	
	
   	//mygrid_sem.loadXML("xmlClientesCobranzas.php?idCobranza=1&tipoPlan=2",calculateFooterValuesSemanal);
   //mygrid_sem.loadXML("xmlClientesCobranzas.php",calculateFooterValuesSemanal);  	
  	mygrid_sem.attachEvent("onEnter",calculateFooterValuesSemanal);	   	
	myDataProcessor_sem = new dataProcessor("processClientesCobros.php");    
    myDataProcessor_sem.enableDataNames('true');    
    myDataProcessor_sem.setUpdateMode("on");    
    myDataProcessor_sem.defineAction("error",myErrorHandler_);   
    myDataProcessor_sem.setTransactionMode("GET");
    myDataProcessor_sem.init(mygrid_sem);
    
    function calculateFooterValuesSemanal(){
        var tS1 = document.getElementById("total_sem_1");
        tS1.innerHTML = sumColumnSemanal(2);
        var tS2 = document.getElementById("total_sem_2");
        tS2.innerHTML = sumColumnSemanal(3);
        var tS3 = document.getElementById("total_sem_3");
        tS3.innerHTML = sumColumnSemanal(4); 
        
        var sumTotalSem = parseFloat(tS1.innerHTML)+parseFloat(tS2.innerHTML)+parseFloat(tS3.innerHTML);        
        var total_sem = document.getElementById("total_sem");
        total_sem.innerHTML = parseFloat(sumTotalSem);
        
        var total = document.getElementById("total_planilla");
        
  		var total_diarios = document.getElementById("total_diarios").innerHTML;
        var total_mens = document.getElementById("total_mens").innerHTML;
        total.innerHTML = parseFloat(total_diarios)+parseFloat(sumTotalSem)+parseFloat(total_mens);         
        var hTotal = document.getElementById("hdnTotal");
        hTotal.value = parseFloat(total.innerHTML);   
        
        myDataProcessor_sem.sendData();        
    }
    
     function sumColumnSemanal(ind){
        var out = 0;
        try{
        	indices_grilla = mygrid_sem.getAllItemIds().split(",");
			for(var k = 0; k < indices_grilla.length ; k++){						

				fValor = parseFloat(mygrid_sem.cells(indices_grilla[k],ind).getValue());	 						if(fValor == 'undefined' || isNaN(fValor) ){ fValor = 0; }	
				out+= parseFloat(fValor);
			}
		}catch(e){
			//alert('Hola');
		}  
        return out;
    }
    /*******************   PLANILLA DE COBROS Mensuales ********************/
	mygrid_mens = new dhtmlXGridObject('gridboxClientesMensuales');
    
	mygrid_mens.selMultiRows = true;
	mygrid_mens.setImagePath("../includes/grillas/dhtmlxGrid/imgs/");
	var titulo = "Mensuales,#cspan,#cspan,#cspan,#cspan,#rspan";
	var flds = "Clientes,Monto,_/_/_,_/_/_,_/_/_";
	
	mygrid_mens.setHeader(titulo);
	mygrid_mens.attachHeader(flds);
	mygrid_mens.setInitWidths("250,100,100,100,100");//",195,170,150,300"
	mygrid_mens.setColAlign("left,left,left,left,left");	
	mygrid_mens.setColTypes("ro,ro,ed,ed,ed");	
    var sColumnas_="sCliente,fMonto,fMonto,fMonto,fMonto";
	mygrid_mens.setColumnIds(sColumnas_);	
	mygrid_mens.setColSorting("str,str,str,str,str");
	mygrid_mens.setColumnColor("#B5D6DF,white,#B5D6DF,white,#B5D6DF");
	mygrid_mens.setMultiLine(false);

	mygrid_mens.setSkin("light");
	mygrid_mens.attachFooter("Totales,#cspan,<div id='total_mensual_1'>0</div>,<div id='total_mensual_2'>0</div>,<div id='total_mensual_3'>0</div>",["text-align:left;"]);

	mygrid_mens.init();
	
	
   	//mygrid_mens.loadXML("xmlClientesCobranzas.php?idCobranza=1&tipoPlan=3",calculateFooterValuesMensual);
   	//mygrid_mens.loadXML("xmlClientesCobranzas.php");  	
  	mygrid_mens.attachEvent("onEnter",calculateFooterValuesMensual);	   	
	myDataProcessor_mens = new dataProcessor("processClientesCobros.php");    
    myDataProcessor_mens.enableDataNames('true');    
    myDataProcessor_mens.setUpdateMode("on");    
    myDataProcessor_mens.defineAction("error",myErrorHandler_);   
    myDataProcessor_mens.setTransactionMode("GET");
    myDataProcessor_mens.init(mygrid_mens);
    
    function calculateFooterValuesMensual(){
        var tM1 = document.getElementById("total_mensual_1");
        tM1.innerHTML = sumColumnMensual(2);
        var tM2 = document.getElementById("total_mensual_2");
        tM2.innerHTML = sumColumnMensual(3);
        var tM3 = document.getElementById("total_mensual_3");
        tM3.innerHTML = sumColumnMensual(4);
        
        var sumTotalMens = parseFloat(tM1.innerHTML)+parseFloat(tM2.innerHTML)+parseFloat(tM3.innerHTML);        
        var total_mens = document.getElementById("total_mens");
        total_mens.innerHTML = parseFloat(sumTotalMens);
        
        var total = document.getElementById("total_planilla");
        var total_diarios = document.getElementById("total_diarios").innerHTML;
        var total_sem = document.getElementById("total_sem").innerHTML;
        total.innerHTML = parseFloat(total_diarios) + parseFloat(total_sem) +parseFloat(sumTotalMens);
        
        var hTotal = document.getElementById("hdnTotal");
        hTotal.value = parseFloat(total.innerHTML);    
        myDataProcessor_mens.sendData();                 
    }
        
    function sumColumnMensual(ind){
        var out = 0;
        try{
        	indices_grilla = mygrid_mens.getAllItemIds().split(",");
			for(var k = 0; k < indices_grilla.length ; k++){						

				fValor = parseFloat(mygrid_mens.cells(indices_grilla[k],ind).getValue());	 						if(fValor == 'undefined' || isNaN(fValor) ){ fValor = 0; }	
				out+= parseFloat(fValor);
			}
		}catch(e){
			//alert('Hola');
		}  
        return out;
    }
    
    function resetDatosForm(){
    	var Formu = document.forms['form'];			
    	//Formu.reset();
		Formu.idCobranza.value = 0;		
		Formu.type.value = "NEW";
		Formu.hdnFechaCobro1.value = "";
		Formu.hdnFechaCobro2.value = "";
		Formu.hdnFechaCobro3.value = "";
		Formu.hdnCodigo.value = "";
		Formu.hdnTotal.value = 0;
		document.getElementById("iDivCodigo").innerHTML ="_ _ _ _";
		document.getElementById("total_diarios").innerHTML = 0;
		document.getElementById("total_sem").innerHTML = 0;
		document.getElementById("total_mens").innerHTML = 0;
		document.getElementById("total_planilla").innerHTML = 0;
		
		sendFormBuscar();
		
		var flds = "Clientes,Monto,_/_/_,_/_/_,_/_/_";
		mygrid_.setHeader(flds);
		mygrid_.loadXML("xmlClientesCobranzas.php");
		mygrid_.init();
		mygrid_.attachFooter("Totales,#cspan,<div id='total_1'>0</div>,<div id='total_2'>0</div>,<div id='total_3'>0</div>",["text-align:left;"]);

		
		mygrid_sem.setHeader(flds);
		mygrid_sem.loadXML("xmlClientesCobranzas.php");		
		mygrid_sem.init();
		mygrid_sem.attachFooter("Totales,#cspan,<div id='total_sem_1'>0</div>,<div id='total_sem_2'>0</div>,<div id='total_sem_3'>0</div>",["text-align:left;"]);

		mygrid_mens.setHeader(flds);
		mygrid_mens.loadXML("xmlClientesCobranzas.php");
		mygrid_mens.init();
		mygrid_mens.attachFooter("Totales,#cspan,<div id='total_mensual_1'>0</div>,<div id='total_mensual_2'>0</div>,<div id='total_mensual_3'>0</div>",["text-align:left;"]);
		
		document.getElementById("cmd_Aprobar").style.display = "none";
		document.getElementById("cmd_AprobarDeuda").style.display = "none";
		document.getElementById("cmd_Anular").style.display = "none";
    }
    
    InputMask('dFechaInicio',"99/99/9999");
    InputMask('dFechaDesde',"99/99/9999");
    InputMask('dFechaHasta',"99/99/9999");
    
    
    function validarFiltro(){
		var errores = "";
		//var formu = document.getElementById('form');
		var idCobrador = document.getElementById('idCobradorSearch');
		var sCodigo = document.getElementById('sCodigo');
		var dFechaDesde = document.getElementById('dFechaDesde');
		var dFechaHasta = document.getElementById('dFechaHasta');
		
		if ((idCobrador.value == 0)&&(sCodigo.value == "")&&(dFechaDesde.value == "")&&(dFechaHasta.value == "")){
			errores += "Debe seleccionar por lo menos un Filtro.";
		}	
		if (errores){
			alert(errores);
			return false;
		}
		else return true;
	}
	
	function sendFormBuscar(){
    	if(!validarFiltro())
		{
			return;
		}
    	var idCobrador = document.getElementById('idCobradorSearch').value;
		var sCodigo = document.getElementById('sCodigo').value;
		var dFechaDesde = document.getElementById('dFechaDesde').value;
		var dFechaHasta = document.getElementById('dFechaHasta').value;
		
		var sUrl = "idCobrador=" + idCobrador + "&sCodigo=" + sCodigo + "&dFechaDesde=" + dFechaDesde +"&dFechaHasta=" + dFechaHasta;
		
		//var flds = "Clientes,Monto,"+dFechaCobro1+","+dFechaCobro2+","+dFechaCobro3;
		//mygrid_.setHeader(flds);
		mygrid.loadXML("xmlCobranzas.php?" + sUrl); 			
		mygrid.init();	
    }
    
    function trim (myString){
		return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
	}

    function aprobarCobranza(){
    	var sCodigo = document.getElementById("iDivCodigo").innerHTML;
    	if(confirm("¿Desea Aprobar la Planilla de Cobranza - Codigo:"+sCodigo+" ?")){
    		if(trim(document.getElementById("hdnFechaCobro2").value) == ""){
    			xajax_impactarPagosUnaFecha(xajax.getFormValues('form'),3);
    		}else	{
	    		xajax_impactarPagos(xajax.getFormValues('form'),3);
    		}
    	}
    }
    
    function anularCobranza(){
    	var sCodigo = document.getElementById("iDivCodigo").innerHTML;
    	if(confirm("¿Desea Anular la Planilla de Cobranza - Codigo:"+sCodigo+" ?")){
    		xajax_updatePlanillaCobranza(xajax.getFormValues('form'),5);    		
    	}
    }
    
    function aprobarCobranzaConDeuda(){
   	    ventanaDeuda();	
    }
    
    function ventanaDeuda(){
    	  var Formu = document.forms['form'];	
    	  var id = Formu.idCobranza.value;    	
    	  var sCodigo = Formu.hdnCodigo.value;    
    	  var fTotal = Formu.hdnTotal.value;  
    	  
    	  var idCobrador = Formu.hdnIdCobrador.value;   
    	  var dFechaCobro2 = Formu.hdnFechaCobro2.value; 
    	  createWindows('CobranzaDeuda.php?idT='+id+"&sCodigo="+sCodigo+"&fTotal="+fTotal+"&idCobrador="+idCobrador+"&dFechaCobro2="+dFechaCobro2,'Tarjeta',2,'COB',420, 220);  
    	  /*var win = new Window(
			    	  {className: "alphacube", 
					  title:'<b>Deuda de la Planilla</b>', 
					  width:350, 
					  height:130, 
					  top:50, 
					  left:60, 
					  url:'CobranzaDeuda.php?idT='+id+"&sCodigo="+sCodigo+"&fTotal="+fTotal+"&idCobrador="+idCobrador+"&dFechaCobro2="+dFechaCobro2,
					  showEffect:Element.show,
					  hideEffect:Element.hide					  
					  }); 
		  win.destroyOnClose,
		  win.toFront();	 
		  win.showCenter(); 	*/	  
		  return;	
    }    
    
    var dhxWins;
	function createWindows(sUrl,sTitulo,idProyecto_,tipo_,width,height){
	    var idWind = "window_"+idProyecto_+"_"+tipo_;
     	dhxWins = new dhtmlXWindows();     	
	    dhxWins.setImagePath("../includes/grillas/dhtmlxWindows/sources/imgs/");	  
	    _popup_ = dhxWins.createWindow(idWind, 500, 350, width, height);
	    _popup_.setText(sTitulo);
	    ///_popup_.center();
	    _popup_.button("close").attachEvent("onClick", closeWindows);
		_url_ = sUrl;
	    _popup_.attachURL(_url_);
	} 
	
	function closeWindows(_popup_){
		_popup_.close();
		//resetDatosForm();
	} 


    function updateCobranza(idEstadoCobranza){
    	//alert(idEstadoCobranza);
    	xajax_updatePlanillaCobranza(xajax.getFormValues('form'),idEstadoCobranza);
    }
    
    function finalizarPlanes(){
    	xajax_finalizarPlanes(xajax.getFormValues('form'));
    }
    
    function refreshCobranza(){
    	var idCobranza_= document.getElementById("idCobranza").value;
    	var dFechaCobro1 = document.getElementById("hdnFechaCobro1").value;
    	var dFechaCobro2 = ""; 
    	var dFechaCobro3 = "";
		if(document.getElementById("hdnFechaCobro2").value != ""){
			dFechaCobro2=document.getElementById("hdnFechaCobro2").value;
		}
		if(document.getElementById("hdnFechaCobro3").value != ""){
			dFechaCobro3=document.getElementById("hdnFechaCobro3").value;
		}
		var flds = "";
		//alert(dFechaCobro2+'----'+dFechaCobro3);
		if((dFechaCobro2 == "")&&(dFechaCobro3 == ""))
		    flds += "Clientes,Monto,"+dFechaCobro1+",,";
		else
			flds += "Clientes,Monto,"+dFechaCobro1+","+dFechaCobro2+","+dFechaCobro3;
			
    	
    	mygrid_.setHeader(flds);
    	mygrid_.clearAll(0);
    	//mygrid_.setColTypes("ro,ro,edn,edn,edn");	
		mygrid_.loadXML("xmlClientesCobranzas.php?tipoPlan=1&idCobranza=" + idCobranza_,calculateFooterValues); 			
		mygrid_.init();
		
		mygrid_.attachFooter("Totales,#cspan,<div id='total_1'>0</div>,<div id='total_2'>0</div>,<div id='total_3'>0</div>",["text-align:left;"]);

		mygrid_sem.setHeader(flds);
		mygrid_sem.clearAll(0);
		mygrid_sem.loadXML("xmlClientesCobranzas.php?tipoPlan=2&idCobranza=" + idCobranza_,calculateFooterValuesSemanal); 		
		mygrid_sem.init();
		mygrid_sem.attachFooter("Totales,#cspan,<div id='total_sem_1'>0</div>,<div id='total_sem_2'>0</div>,<div id='total_sem_3'>0</div>",["text-align:left;"]);

		mygrid_mens.setHeader(flds);
		mygrid_mens.clearAll(0);
		mygrid_mens.loadXML("xmlClientesCobranzas.php?tipoPlan=3&idCobranza=" + idCobranza_,calculateFooterValuesMensual); 		
		mygrid_mens.init();
		mygrid_mens.attachFooter("Totales,#cspan,<div id='total_mensual_1'>0</div>,<div id='total_mensual_2'>0</div>,<div id='total_mensual_3'>0</div>",["text-align:left;"]);
		
    }
    
    function cerrarMes(){
    	if(confirm("¿Desea cerrar el Mes de Cobranzas?")){
    		xajax_calcularTopeDeEstregas();
    	}
    	//resetDatosForm();
    }
</script>