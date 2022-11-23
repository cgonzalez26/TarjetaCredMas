<body style="background-color:#FFFFFF;">
<div id="GrillaGeneral">
<table width="100%" align="center">
<tbody>
		<tr>
         
			<td align="center">
			    <div style="width:{ANCHO_GRILLA};"  id="iDivMenu"></div>
				<div id="gridbox" style="width:{ANCHO_GRILLA}; border:solid 1px #000000; background-color:white;height:490px; font-size:16pt;"></div>
			</td>
		</tr>
		<tr>
		 <td id="recinfoArea" >&nbsp;</td>
		</tr>
</tbody>		
		
</table>
</div>
<script>
    var menu = new dhtmlXMenuObject("iDivMenu",'dhx_black');//
	menu.setImagePath("../includes/grillas/dhtmlxMenu/sources/imgs/");
	menu.setIconsPath("../includes/grillas/dhtmlxMenu/sources/images/");	
	
	/*menu.addNewSibling(null,"idNuevo", "Nuevo", false, "new.gif");*/
	//menu.addNewSeparator("idRegistro", "s1");
	menu.addNewSibling(null, "idGuardar", "Guardar Todos",false, "save.gif");
	menu.addNewSibling("idGuardar","idActualizar", "Guardar",false, "save.gif");
	/*
	menu.addNewSibling("idBorrar", "idPrint", "Imprimir", false,"print.gif");
	//menu.addNewSibling("idPrint", "idActualizar", "Actualizar", false,"");
	*/
	menu.attachEvent("onClick", menuClick);
	//var id=mygrid.uid(); mygrid.addRow(id,'',0); mygrid.showRow(id);
	function menuClick(id) {
		switch(id)
			{
				case 'idNuevo':{			          
					             try{
					             	var idCell=mygrid.getRowIndex(mygrid.getSelectedId());
					             	
					             }catch(e){
					             	
					             	var idCell=1;
					             }
					              
					             mygrid.addRow((new Date()).valueOf(),['---','---','---','0','---'],idCell);
				                              //mygrid.showRow(mygrid.getSelectedId());
				                              
				                              break;} 
				case 'idGuardar':{EnviarDatos(); break;}
				case 'idBorrar':{mygrid.deleteSelectedRows();break;}
				case 'idPrint':{alert('En Construccion');break;}
				case 'idActualizar':{myDataProcessor.sendData();break;}
				
			}
		
		return true;
	}

	function EnviarDatos(){
		{SAVEDATA}
	}
</script>
