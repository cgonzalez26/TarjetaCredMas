<div id="Titulo" style="display:block;">
<table width="600px">
	<th class="cabecera">
		&nbsp;&nbsp;&nbsp; Retenciones Ingresos Brutos
	</th>
</table>	

<div id="my_grid_general" style="display:block;">
		<div style="width:100%;"  id="div_menu1"></div>		
		<div id="gridbox1" style="width:100%;height:80%;"></div>
</div>

<script>

    _mygrid = new dhtmlXGridObject('gridbox1');
    
	/*_mygrid.selMultiRows = true;*/
	
	_mygrid.setImagePath("../includes/grillas/dhtmlxGrid/imgs/");
	
	var flds = "Codigo,Descripcion,Porcentaje Retencion,Importe Minimo ,Estado";
	
	_mygrid.setHeader(flds);
	
	/*_mygrid.attachHeader("#text_filter,#text_filter");*/
	
	_mygrid.setInitWidths("100,200,100,100,100");
	
	_mygrid.setColAlign("left,left,left,left,left");
	
	_mygrid.setColTypes("ro,txt,ed,ed,coro");
    
	_mygrid.setColumnIds("sCodigo,sDescripcion,fPorcentajeRetencion,fImporteMinimoRetencion,sEstadoRetencion");
	
	//_mygrid.setColSorting("str");
	
	/*_mygrid.setMultiLine(false);*/

	_mygrid.setSkin("dhx_blue");
	
	//_mygrid.enableColSpan(true);

	combo = _mygrid.getCombo(4);
	combo.put("A","A");
	combo.put("B","B");

	_mygrid.init();

   	_mygrid.loadXML("xmlRetencionesIngresosBrutos.php");
   	

	myDataProcessor = new dataProcessor("processRetencionesIngresosBrutos.php");
    
    myDataProcessor.enableDataNames('true');
  
    myDataProcessor.setUpdateMode("on");
    
    myDataProcessor.defineAction("error",myErrorHandler);
   
    myDataProcessor.defineAction("insert",fun_insert);
        
    myDataProcessor.setTransactionMode("GET");

    myDataProcessor.init(_mygrid);

   
    
    function myErrorHandler(objeto){
        alert("Ha ocurrido un error: .\n " + objeto.firstChild.nodeValue);
        myDataProcessor.stopOnError = true;
        return false;
    }

    function fun_insert(obj)
    {
    	//alert("fun_insert");
        var sId=obj.getAttribute("sid");      
        var sCodigo=obj.getAttribute("sCodigo");        
        
        _mygrid.cells(sId,0).setValue(sCodigo);
	    return true;        
    }

       
 	var menu = new dhtmlXMenuObject("div_menu1",'dhx_blue');
 	
	menu.setImagePath("../includes/grillas/dhtmlxMenu/sources/imgs/");
	
	menu.setIconsPath("../includes/grillas/dhtmlxMenu/sources/images/");	
	
	menu.addNewSibling(null,"idNuevo", "Nuevo", false, "add16.png");	
	menu.addNewSibling("idNuevo", "idGuardar", "Guardar",false, "save.gif");
	
	//menu.addNewSibling("idNuevo","idBorrar", "Borrar",false, "delete-general.png");	
	//menu.addNewSibling("idBorrar", "idPrint", "Imprimir", false,"print.gif");
	//menu.addNewSibling("idPrint", "idActualizar", "Actualizar", false,"");
	
	menu.attachEvent("onClick", _menu_onclick_);
	
	
	var _row_ = (new Date()).valueOf();
	
	function _menu_onclick_(_i) 
	{

		switch(_i)
			{
				case 'idNuevo':{	
					
					             _mygrid.clearSelection();
					             
					             _row_++; 						             
					             
					             try{
					             	//var idCell=_mygrid.getRowIndex(_mygrid.getSelectedId());
					             	var idCell = _mygrid.getRowsNum();
					             	
					             }catch(e){

					             	var idCell=1;

					             }
					             
								//("iCodigo,sNombre,sDescripcion,sClaseAjuste,sDestino,bDiscriminaIva,bFinanciable, bEstadoAjuste");
					             _mygrid.addRow(_row_,['','','','','','A'],idCell);

				      break;}

				case 'idGuardar':{	_send_form_(); break;}

				case 'idBorrar':{						
						
						//idrow = _mygrid.getSelectedId();
						
						_mygrid.deleteSelectedRows();

					break;}

				case 'idPrint':{alert('En Construccion');break;}
			}
		
		return true;
	}

	function _send_form_(){ myDataProcessor.sendData();	}  
   	
	
	
</script>

