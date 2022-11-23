<!--	<div class='cabecera' id='cabecera'>
			&nbsp;&nbsp;&nbsp;&nbsp;{title_sector}
		</div>
<br />-->
<div id="my_grid_general" style="display:block;">
		<div style="width:100%;"  id="div_menu"></div>		
		<div id="gridbox" style="width:100%;height:80%;"></div>
</div>

<script>

    mygrid = new dhtmlXGridObject('gridbox');
    
	mygrid.selMultiRows = true;
	
	mygrid.setImagePath("../includes/dhtmlx/dhtmlxGrid/imgs/");
	
	var flds = "Area,Numero,Estado";
	
	mygrid.setHeader(flds);
	
	//mygrid.attachHeader("#text_filter,#text_filter");

	mygrid.setInitWidths("300,150,100");
	
	mygrid.setColAlign("left,left,left");
	
	mygrid.setColTypes("ed,ed,co");
    
	mygrid.setColumnIds("sNombre,sNumero,sEstado");
	
	//mygrid.setColSorting("str");
	
	mygrid.setMultiLine(false);

	mygrid.setSkin("dhx_blue");
	
	//mygrid.enableColSpan(true);
	combo = mygrid.getCombo(2);
	combo.put("A","A");
	combo.put("B","B");
	
	mygrid.init();
	
   	mygrid.loadXML("xmlAreas.php");


	myDataProcessor = new dataProcessor("proccessAreas.php");
    
    myDataProcessor.enableDataNames('true');
  
    myDataProcessor.setUpdateMode("on");
    
    myDataProcessor.defineAction("error",myErrorHandler);
   
    myDataProcessor.setTransactionMode("GET");

    myDataProcessor.init(mygrid);

   
    
    function myErrorHandler(objeto){
        alert("Ha ocurrido un error: .\n " + objeto.firstChild.nodeValue);
        myDataProcessor.stopOnError = true;
        return false;
    }
   	
    
 	var menu = new dhtmlXMenuObject("div_menu",'dhx_blue');
 	
	menu.setImagePath("../includes/grillas/dhtmlxMenu/sources/imgs/");
	
	menu.setIconsPath("../includes/grillas/dhtmlxMenu/sources/images/");	
	
	menu.addNewSibling(null,"idNuevo", "Nuevo", false, "add16.png");	
	menu.addNewSibling("idNuevo", "idGuardar", "Guardar",false, "save.gif");
	//menu.addNewSibling("idNuevo","idBorrar", "Borrar",false, "delete-general.png");	
	//menu.addNewSibling("idBorrar", "idPrint", "Imprimir", false,"print.gif");
	//menu.addNewSibling("idPrint", "idActualizar", "Actualizar", false,"");
	
	menu.attachEvent("onClick", _menu_onclick_);
	
	
	 var _row_ = (new Date()).valueOf();
	
	function _menu_onclick_(_i) {
		
		switch(_i)
			{
				case 'idNuevo':{	
					
					             mygrid.clearSelection();
					             
					             _row_++; 						             
					             
					             try{
					             	//var idCell=mygrid.getRowIndex(mygrid.getSelectedId());
					             	var idCell = mygrid.getRowsNum();
					             	
					             }catch(e){

					             	var idCell=1;

					             }

					             mygrid.addRow(_row_,[''],idCell);

				      break;}

				case 'idGuardar':{	_send_form_(); break;}

				case 'idBorrar':{						
						
						//idrow = mygrid.getSelectedId();
						
						mygrid.deleteSelectedRows();

					break;}

				case 'idPrint':{alert('En Construccion');break;}
				
				
			}
		
		return true;
	}

	function _send_form_(){ myDataProcessor.sendData();	}    
   	
	
	
</script>

