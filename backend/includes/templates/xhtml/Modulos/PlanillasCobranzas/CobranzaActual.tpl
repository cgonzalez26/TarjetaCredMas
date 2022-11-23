<body style="background-color:#FFFFFF">

<form id="form" method="POST" name='form' action='ExportarCobranza.php'>
<input type="hidden" id="idCobranza" name="idCobranza" value="{ID_COBRANZA}" />
<input type="hidden" name="type" id="type" value="NEW"> 
<input type="hidden" id="hdnFechaCobro1" name="hdnFechaCobro1" value="" />
<input type="hidden" id="hdnFechaCobro2" name="hdnFechaCobro2" value="" />
<input type="hidden" id="hdnFechaCobro3" name="hdnFechaCobro3" value="" />
<input type="hidden" id="hdnCodigo" name="hdnCodigo" value="" />

<div id="GrillaDetalleCobranza">
<table align="center" style='width:750px'>
<tbody>
	<tr>
		<td><table cellpadding='0' cellspacing='0' width='100%' class='TablePermits' border="0">
			<tr>
				<td class='title' width='300'><strong>Cobranza Actual</strong></td>
			</tr>
		</table>
		</td>
	</tr>
		<tr>         
			<td align="center">
				<div  style="text-align:right">
					<table align="center" style='width:750px'>	
					<tr>
						<td style='width:140px'>Planilla de Cobranza:</td>	
						<td>
							<select id="idPlanillaCobranza" name="idPlanillaCobranza" style="width:200px" onchange="cargarPlanillaCobranza(this.value);">
							{optionsPlanillasCobranzas}
							</select>
						</td>
						<td style='width:200px' align="right">Codigo:</td>
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
				<div id="gridboxClientesSemanales" style=" border:solid 1px #DDD; background-color:white;height:200px; font-size:20pt;"></div>
			</td>
		</tr>
		<tr>
			<td align="center">
				<div   id="iDivMenuClientesMensuales"></div>
				<div id="gridboxClientesMensuales" style=" border:solid 1px #DDD; background-color:white;height:200px; font-size:20pt;"></div>
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
				<input type='button' name='cmd_Aceptar' id='cmd_Aceptar' value='Guardar' onclick="guardarPlanillaCobranza();" style="display:none">
				<input type='button' name='cmd_Confirmar' id='cmd_Confirmar' value='Confirmar' onclick="confirmarCobranza();" style="display:none">
				<!--<input type='button' name='cmd_Cancelar' id='cmd_Cancelar' value='Cancelar' onclick="resetDatosForm();" >-->
			</td>
		</tr>
</tbody>		
		
</table>
</div>

</form>
<script>
	function cargarPlanillaCobranza(idPlanilla){
		if(idPlanilla == 0){
			document.getElementById("cmd_Aceptar").style.display = "none";
			document.getElementById("cmd_Confirmar").style.display = "none";
			
			resetDatosForm();	
		}else{
			document.getElementById("cmd_Aceptar").style.display = "inline";
			document.getElementById("cmd_Confirmar").style.display = "inline";
		}		
		xajax_CargarCobranzaActual(idPlanilla);	
	}
	
	function exportar(tipo){		
		var formulario = document.forms['form'];		
		formulario.submit();
	}
	
	/*******************   PLANILLA DE COBROS DIARIOS ********************/
	mygrid_ = new dhtmlXGridObject('gridboxPlanillas');
    
	mygrid_.selMultiRows = true;
	mygrid_.setImagePath("../includes/grillas/dhtmlxGrid/imgs/");
	var flds = "Clientes Diarios,Productos,Monto,_/_/_,_/_/_,_/_/_";
	
	mygrid_.setHeader(flds);
	mygrid_.setInitWidths("200,200,70,90,90,90");
	mygrid_.setColAlign("left,left,left,left,left,left");	
	mygrid_.setColTypes("ro,ro,ro,edn,edn,edn");	
    var sColumnas_="sCliente,sProducto,fMonto,fMontoPago1,fMontoPago2,fMontoPago3";
	mygrid_.setColumnIds(sColumnas_);	
	mygrid_.setColSorting("str,str,str,str,str,str");
	mygrid_.attachHeader("#text_filter,#text_filter,#text_filter,,,,");
	mygrid_.setColumnColor("#B5D6DF,white,#B5D6DF,white,#B5D6DF,white");
	mygrid_.setMultiLine(false);

	mygrid_.setNumberFormat("0.00",2);
	mygrid_.setSkin("light");
	//mygrid_.enableSmartRendering(true);
	mygrid_.setSkin("light");
	mygrid_.attachFooter("Totales,#cspan,#cspan,<div id='total_1'>0</div>,<div id='total_2'>0</div>,<div id='total_3'>0</div>",["text-align:left;"]);
	mygrid_.init();
	
   	mygrid_.loadXML("xmlClientesCobros.php");  	
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
        t1.innerHTML = sumColumn(3);
        var t2 = document.getElementById("total_2");
        t2.innerHTML = sumColumn(4);
        var t3 = document.getElementById("total_3");
        t3.innerHTML = sumColumn(5);
        
        var sumTotalDiarios = parseFloat(t1.innerHTML)+parseFloat(t2.innerHTML)+parseFloat(t3.innerHTML);        
        var total_diarios = document.getElementById("total_diarios");
        total_diarios.innerHTML = parseFloat(sumTotalDiarios);
        
        var total = document.getElementById("total_planilla");        
        var total_sem = document.getElementById("total_sem").innerHTML;
        var total_mens = document.getElementById("total_mens").innerHTML;
        total.innerHTML = parseFloat(sumTotalDiarios)+parseFloat(total_sem)+parseFloat(total_mens);
        
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
	
	menu_.addNewSibling(null,"idNuevo", "", false, "");	
	menu_.addNewSibling(null, "idGuardar", "",false, "");
	menu_.addNewSibling("idGuardar","idPrint", "Exportar",false, "excel.png");
	menu_.attachEvent("onClick", menuClick_);
	
	function menuClick_(id) {
		switch(id)
			{
				case 'idPrint':{
					//var exportardata = true;
					//guardarCobranza(exportardata);
					exportar(3);
					break;
				}
			}
		return true;
	}
	
	function guardarPlanillaCobranza(){
		guardarCobranza();
		alert("La Planilla de Cobranza se guardo correctamente.")		
	}
	
	function guardarCobranza(){
		myDataProcessor_.sendData();
		myDataProcessor_sem.sendData();
		myDataProcessor_mens.sendData();		
	}
	
	function setDatosDetalleCobranza(idCobranza_,dFechaCobro1,dFechaCobro2,dFechaCobro3,sCodigo){
		var Formu = document.forms['form'];			
		Formu.idCobranza.value = idCobranza_;		
		Formu.type.value = "EDIT";
		document.getElementById("iDivCodigo").innerHTML =sCodigo;
		Formu.hdnFechaCobro1.value = dFechaCobro1;
		Formu.hdnFechaCobro2.value = dFechaCobro2;
		Formu.hdnFechaCobro3.value = dFechaCobro3;
		Formu.hdnCodigo.value = sCodigo;
		
		var flds = "Clientes Diarios,Pedido,Monto,"+dFechaCobro1+","+dFechaCobro2+","+dFechaCobro3;
		mygrid_.setHeader(flds);	
		mygrid_.loadXML("xmlClientesCobros.php?tipoPlan=1&idPlanillaCobranza=" + idCobranza_,calculateFooterValues); 				
		mygrid_.init();		
		mygrid_.attachHeader("#text_filter,#text_filter,,,,");
		mygrid_.attachFooter("Totales,#cspan,#cspan,<div id='total_1'>0</div>,<div id='total_2'>0</div>,<div id='total_3'>0</div>",["text-align:left;"]);
		mygrid_.attachEvent("onEnter",calculateFooterValues);

		
		flds = "Clientes Semanales,Pedido,Monto,"+dFechaCobro1+","+dFechaCobro2+","+dFechaCobro3;
		mygrid_sem.setHeader(flds);	
   		mygrid_sem.loadXML("xmlClientesCobros.php?tipoPlan=2&idPlanillaCobranza=" + idCobranza_,calculateFooterValuesSemanal); 	
		mygrid_sem.init();
		mygrid_sem.attachHeader("#text_filter,#text_filter,,,,");
		mygrid_sem.attachFooter("Totales,#cspan,#cspan,<div id='total_sem_1'>0</div>,<div id='total_sem_2'>0</div>,<div id='total_sem_3'>0</div>",["text-align:left;"]);
		mygrid_sem.attachEvent("onEnter",calculateFooterValuesSemanal);

		
		flds = "Clientes Mensuales,Pedido,Monto,"+dFechaCobro1+","+dFechaCobro2+","+dFechaCobro3;
		mygrid_mens.setHeader(flds);		
		mygrid_mens.loadXML("xmlClientesCobros.php?tipoPlan=3&idPlanillaCobranza=" + idCobranza_,calculateFooterValuesMensual);
		mygrid_mens.init();
		mygrid_mens.attachHeader("#text_filter,#text_filter,,,,");
		mygrid_mens.attachFooter("Totales,#cspan,#cspan,<div id='total_mensual_1'>0</div>,<div id='total_mensual_2'>0</div>,<div id='total_mensual_3'>0</div>",["text-align:left;"]);
		mygrid_mens.attachEvent("onEnter",calculateFooterValuesMensual);
	}
	
	
	/*******************   PLANILLA DE COBROS Semanales ********************/
	mygrid_sem = new dhtmlXGridObject('gridboxClientesSemanales');
    
	mygrid_sem.selMultiRows = true;
	mygrid_sem.setImagePath("../includes/grillas/dhtmlxGrid/imgs/");
	var flds_sem = "Clientes Semanales,Productos,Monto,_/_/_,_/_/_,_/_/_";
	
	mygrid_sem.setHeader(flds_sem);
	mygrid_sem.setInitWidths("200,200,70,90,90,90");//",195,170,150,300"
	mygrid_sem.setColAlign("left,left,left,left,left,left");	
	mygrid_sem.setColTypes("ro,ro,ro,edn,edn,edn");	
    var sColumnas_="sCliente,sProductos,fMonto,fMontoPago1,fMontoPago2,fMontoPago3";
	mygrid_sem.setColumnIds(sColumnas_);	
	mygrid_sem.setColSorting("str,str,str,str,str,str");
	mygrid_sem.attachHeader("#text_filter,#text_filter,#text_filter,,,,");
	mygrid_sem.setColumnColor("#B5D6DF,white,#B5D6DF,white,#B5D6DF,white");
	mygrid_sem.setMultiLine(false);

	//mygrid.setMathRound(2);
    //mygrid.enableMathEditing(true);
	mygrid_sem.setSkin("light");
	//mygrid_sem.enableSmartRendering(true);
	mygrid_sem.setSkin("light");
	mygrid_sem.attachFooter("Totales,#cspan,#cspan,<div id='total_sem_1'>0</div>,<div id='total_sem_2'>0</div>,<div id='total_sem_3'>0</div>",["text-align:left;"]);
	mygrid_sem.init();
	
	
   	//mygrid_sem.loadXML("xmlClientesCobros.php?idCobranza=1&tipoPlan=2",calculateFooterValuesSemanal);
   	mygrid_sem.loadXML("xmlClientesCobros.php");  	
  	mygrid_sem.attachEvent("onEnter",calculateFooterValuesSemanal);	   	
	myDataProcessor_sem = new dataProcessor("processClientesCobros.php");    
    myDataProcessor_sem.enableDataNames('true');    
    myDataProcessor_sem.setUpdateMode("on");    
    myDataProcessor_sem.defineAction("error",myErrorHandler_);   
    myDataProcessor_sem.setTransactionMode("GET");
    myDataProcessor_sem.init(mygrid_sem);
    
     function calculateFooterValuesSemanal(){
        var tS1 = document.getElementById("total_sem_1");
        tS1.innerHTML = sumColumnSemanal(3);
        var tS2 = document.getElementById("total_sem_2");
        tS2.innerHTML = sumColumnSemanal(4);
        var tS3 = document.getElementById("total_sem_3");
        tS3.innerHTML = sumColumnSemanal(5);
        
        var sumTotalSem = parseFloat(tS1.innerHTML)+parseFloat(tS2.innerHTML)+parseFloat(tS3.innerHTML);        
        var total_sem = document.getElementById("total_sem");
        total_sem.innerHTML = parseFloat(sumTotalSem);
        
        var total = document.getElementById("total_planilla");
        
        var total_diarios = document.getElementById("total_diarios").innerHTML;
        var total_mens = document.getElementById("total_mens").innerHTML;
        total.innerHTML = parseFloat(total_diarios)+sumTotalSem+parseFloat(total_mens);   
        
        myDataProcessor_sem.sendData();
    }
    
    function sumColumnSemanal(ind){
        var out = 0;
        try{
        	indices_grilla = mygrid_sem.getAllItemIds().split(",");
			for(var k = 0; k < indices_grilla.length ; k++){						

				fValor = parseFloat(mygrid_sem.cells(indices_grilla[k],ind).getValue());	 						
				if(fValor == 'undefined' || isNaN(fValor) ){ fValor = 0; }	
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
	var flds_mens = "Clientes Mensuales,Productos,Monto,_/_/_,_/_/_,_/_/_";
	
	mygrid_mens.setHeader(flds_mens);
	mygrid_mens.setInitWidths("200,200,70,90,90,90");//",195,170,150,300"
	mygrid_mens.setColAlign("left,left,left,left,left,,left");	
	mygrid_mens.setColTypes("ro,ro,ro,edn,edn,edn");	
    var sColumnas_="sCliente,sProductos,fMonto,fMontoPago1,fMontoPago2,fMontoPago3";
	mygrid_mens.setColumnIds(sColumnas_);	
	mygrid_mens.setColSorting("str,str,str,str,str,str");
	mygrid_mens.attachHeader("#text_filter,#text_filter,#text_filter,,,,");
	mygrid_mens.setColumnColor("#B5D6DF,white,#B5D6DF,white,#B5D6DF,white");
	mygrid_mens.setMultiLine(false);

	//mygrid.setMathRound(2);
    //mygrid.enableMathEditing(true);
	mygrid_mens.setSkin("light");
	//mygrid_mens.enableSmartRendering(true);
	mygrid_mens.setSkin("light");
	mygrid_mens.attachFooter("Totales,#cspan,#cspan,<div id='total_mensual_1'>0</div>,<div id='total_mensual_2'>0</div>,<div id='total_mensual_3'>0</div>",["text-align:left;"]);
	mygrid_mens.init();
	
	
   	//mygrid_mens.loadXML("xmlClientesCobros.php?idCobranza=1&tipoPlan=3",calculateFooterValuesMensual);
   	mygrid_mens.loadXML("xmlClientesCobros.php");  	
  	mygrid_mens.attachEvent("onEnter",calculateFooterValuesMensual);	   	
	myDataProcessor_mens = new dataProcessor("processClientesCobros.php");    
    myDataProcessor_mens.enableDataNames('true');    
    myDataProcessor_mens.setUpdateMode("on");    
    myDataProcessor_mens.defineAction("error",myErrorHandler_);   
    myDataProcessor_mens.setTransactionMode("GET");
    myDataProcessor_mens.init(mygrid_mens);
    
     function calculateFooterValuesMensual(){
        var tM1 = document.getElementById("total_mensual_1");
        tM1.innerHTML = sumColumnMensual(3);
        var tM2 = document.getElementById("total_mensual_2");
        tM2.innerHTML = sumColumnMensual(4);
        var tM3 = document.getElementById("total_mensual_3");
        tM3.innerHTML = sumColumnMensual(5);
        
        var sumTotalMens = parseFloat(tM1.innerHTML)+parseFloat(tM2.innerHTML)+parseFloat(tM3.innerHTML);        
        var total_mens = document.getElementById("total_mens");
        total_mens.innerHTML = parseFloat(sumTotalMens);
        
        var total = document.getElementById("total_planilla");
        var total_diarios = document.getElementById("total_diarios").innerHTML;
        var total_sem = document.getElementById("total_sem").innerHTML;
        total.innerHTML = parseFloat(total_diarios) + parseFloat(total_sem) +sumTotalMens;
        
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
		Formu.idCobranza.value = 0;		
		Formu.type.value = "NEW";
		document.getElementById("total_diarios").innerHTML = 0;
		document.getElementById("total_sem").innerHTML = 0;
		document.getElementById("total_mens").innerHTML = 0;
		document.getElementById("total_planilla").innerHTML = 0;
		
		document.getElementById("iDivCodigo").innerHTML ="_ _ _ _";
		var flds = "Clientes Diarios,Productos,Monto,_/_/_,_/_/_,_/_/_";
		mygrid_.setHeader(flds);
		mygrid_.loadXML("xmlClientesCobros.php");
		mygrid_.init();
		mygrid_.attachFooter("Totales,#cspan,#cspan,<div id='total_1'>0</div>,<div id='total_2'>0</div>,<div id='total_3'>0</div>",["text-align:left;"]);

		
		flds = "Clientes Semanales,Productos,Monto,_/_/_,_/_/_,_/_/_";
		mygrid_sem.setHeader(flds);
		mygrid_sem.loadXML("xmlClientesCobros.php");		
		mygrid_sem.init();
		mygrid_sem.attachFooter("Totales,#cspan,#cspan,<div id='total_sem_1'>0</div>,<div id='total_sem_2'>0</div>,<div id='total_sem_3'>0</div>",["text-align:left;"]);

		flds = "Clientes Mensuales,Productos,Monto,_/_/_,_/_/_,_/_/_";
		mygrid_mens.setHeader(flds);
		mygrid_mens.loadXML("xmlClientesCobros.php");
		mygrid_mens.init();
		mygrid_mens.attachFooter("Totales,#cspan,#cspan,<div id='total_mensual_1'>0</div>,<div id='total_mensual_2'>0</div>,<div id='total_mensual_3'>0</div>",["text-align:left;"]);
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
		mygrid.updateFromXMl("xmlCobranzas.php?" + sUrl); 			
		mygrid.init();	
    }
    
    function validarPlanilla(){
    	var errores = "";
    	try{    		
    		indices_grilla_diarios = mygrid_.getAllItemIds().split(",");
    		var value1=""; var value2=""; var value3="";
			for(var k = 0; k < indices_grilla_diarios.length ; k++){
				value1 = mygrid_.cells(indices_grilla_diarios[k],2).getValue();
				value2 = mygrid_.cells(indices_grilla_diarios[k],3).getValue();
				value3 = mygrid_.cells(indices_grilla_diarios[k],4).getValue();

				if((value1 == "")||(value2 == "")||(value3 == "")){
					errores = "Debe completar los Pagos";
					break;
				}
			}
			if(errores == ""){
	    		indices_grilla_sem = mygrid_sem.getAllItemIds().split(",");
	    		value1=""; value2=""; value3="";
				for(var k = 0; k < indices_grilla_sem.length ; k++){
					value1 = mygrid_sem.cells(indices_grilla_sem[k],2).getValue();
					value2 = mygrid_sem.cells(indices_grilla_sem[k],3).getValue();
					value3 = mygrid_sem.cells(indices_grilla_sem[k],4).getValue();
	
					if((value1 == "")||(value2 == "")||(value3 == "")){
						errores = "Debe completar los Pagos";
						break;
					}
				}
			}
			if(errores == ""){
	    		indices_grilla_mens = mygrid_mens.getAllItemIds().split(",");
	    		value1=""; value2=""; value3="";
				for(var k = 0; k < indices_grilla_mens.length ; k++){
					value1 = mygrid_mens.cells(indices_grilla_mens[k],2).getValue();
					value2 = mygrid_mens.cells(indices_grilla_mens[k],3).getValue();
					value3 = mygrid_mens.cells(indices_grilla_mens[k],4).getValue();
	
					if((value1 == "")||(value2 == "")||(value3 == "")){
						errores = "Debe completar los Pagos";
						break;
					}
				}
			}
			
		}catch(e){
			//alert('Hola');
		}
		if (errores){
			alert(errores);
			return false;
		}
		else return true;
    }
    
    function confirmarCobranza(){
    	
    	/*if(!validarPlanilla()){
    		return;
    	}*/
    	var sCodigo = document.getElementById("iDivCodigo").innerHTML;
    	if(confirm("¿Desea Confirmar la Planilla de Cobranza - Codigo:"+sCodigo+" ?")){
	    	guardarCobranza();
	    	xajax_updatePlanillaCobranza(xajax.getFormValues('form'),2);    			
    	}
    }
</script>