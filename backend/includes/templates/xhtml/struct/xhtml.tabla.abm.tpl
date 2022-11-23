<body style="background-color:#FFFFFF">
<div id="GrillaGeneral">
<table width="{ANCHO_GRILLA}" align="center">
<tbody>
		<tr>
         
			<td align="center">
			    <div style="width:{ANCHO_GRILLA};"  id="iDivMenu"></div>
				<div id="gridbox" style="width:{ANCHO_GRILLA}; border:solid 1px #000000; background-color:white;height:250px; font-size:20pt;"></div>
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
	
	menu.addNewSibling(null,"idNuevo", "Nuevo", false, "new.gif");
	//menu.addNewSeparator("idRegistro", "s1");
	menu.addNewSibling("idNuevo", "idGuardar", "Guardar",false, "save.gif");
	menu.addNewSibling("idGuardar","idBorrar", "Borrar",false, "close2.gif");
	
	menu.addNewSibling("idBorrar", "idPrint", "Imprimir", false,"print.gif");
	//menu.addNewSibling("idPrint", "idActualizar", "Actualizar", false,"");
	
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
					              
					             mygrid.addRow((new Date()).valueOf(),['','','0','1'],idCell);
				                              //mygrid.showRow(mygrid.getSelectedId());
				                              
				                              break;} 
				case 'idGuardar':{EnviarDatos(); break;}
				case 'idBorrar':{mygrid.deleteSelectedRows();break;}
				case 'idPrint':{alert('En Construccion');break;}
				//case 'idActualizar':{mygrid.updateFromXMl('get.php');break;}
				
			}
		
		return true;
	}

	function EnviarDatos(){
		myDataProcessor.sendData();
		/*myDataProcessor.setUpdated(3,true);
		myDataProcessor.setUpdated(4,true);
		myDataProcessor.setUpdated(5,true);
		myDataProcessor.setUpdated(9,true);
		myDataProcessor.setUpdated(10,true);
		
		{SAVEDATA}*/
	}
</script>
