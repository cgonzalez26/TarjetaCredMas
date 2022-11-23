<body style="background-color:#FFFFFF">
<center>
	<div id='' style='width:75%;text-align:right;margin-right:10px;'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Empleado' border='0' hspace='4' align='absmiddle'> 
		<a href='javascript:sendFormUser();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>[F9] Guardar </a>
		&nbsp;&nbsp;			
		<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo Empleado' alt='Nuevo Empleado' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>Nuevo</a>
			&nbsp;&nbsp;			
		</div>
		<img src='{IMAGES_DIR}/back.png' title='Buscar Empleado' alt='Buscar Empleado' border='0' hspace='4' align='absmiddle'> 
		<a href="Empleados.php" style='text-decoration:none;font-weight:bold;'>Volver</a>
	</div>
<form  method='POST' name='formEmpleado' id='formEmpleado'>
	<input type="hidden" name="idEmpleado" id="idEmpleado" value="{ID_EMPLEADO}"> 
	<input type="hidden" name="hdnLogin" id="hdnLogin" value="{LOGIN}"> 
	<input type="hidden" name="permitUser" id="permitUser" value=""> 
	<input type="hidden" name="permitUserAccesos" id="permitUserAccesos" value=""> 
	<input type="hidden" name="permitUserTarjeta" id="permitUserTarjeta" value=""> 
	<input type="hidden" name="type" id="type" value="{sType}"> 

	<div id="divEmpleados"  style="width:990px">
		<ul class="tabs" style="width:990px">
	        <li class="active"><a href="#tab1">Datos Personales</a></li>
	        <li><a href="#tab2">Datos Laborales</a></li>
	        <li><a href="#tab3">Observaciones</a></li>               
	     </ul>
	       
	    <div class="tab_container"  style="height:260px;width:990px">
	        <div id="tab1" class="tab_content" style="width:990px">
		  		<div id="treeboxbox_tree1" style="width:95%;height:240px;border:1px solid #CCC;">
		  			<table id='TableCustomer' cellpadding="0" cellspacing="5" class="TableCustomer">
					<tr>
						<th class='borde'> Apellido: </th>
						<td> <input id="sApellido" name="sApellido" value='{APELLIDO}' type='text' style='width:150px;' tabindex="1" onKeyUp="aMayusculas_SinEspeciales(this.value,this.id);"/> <sup>*</sup></td>				    
						<th> Nombre: </th>
						<td class='borde'> <input id="sNombre" name="sNombre" value='{NOMBRE}' type='text' style='width:150px;' tabindex="2" style='width:150px' onKeyUp="aMayusculas_SinEspeciales(this.value,this.id);"/> <sup>*</sup> </td>
						<th> Fecha de Nacimiento:</th>			   
						<td><input type="text"id="dFechaNacimiento" name='dFechaNacimiento' value='{FECHA_NACIMIENTO}' size="11" maxlength="11" tabindex="3" style='width:150px'/></td>
					</tr>
					<tr>
						<th class="celda_form"><b>(*)Tipo documento:</b></th>
						<td><select id="idTipoDocumento" name="idTipoDocumento" style="width:150px" tabindex="4">
				      			{OPTIONS_TIPO_DOC}
				          	</select>	 
				        </td>
						<th><b>(*)Nro. documento:</b></th>
						<td><input type="text" id="sNumeroDocumento" name="sNumeroDocumento" maxlength="50" size="25" value="{NUMERO_DOCUMENTO}" tabindex="5" style="width:150px"/></td>
						<th><b>CUIL:</b></th>
						<td><input type="text" id="sCuil" name="sCuil" maxlength="50" size="25" value="{CUIL}" tabindex="6" style="width:150px"/></td>					
					</tr>
					<tr>
						<th><b>Estado Civil:</b></th>	
						<td><select id="idEstadoCivil" name="idEstadoCivil" style="width:150px" tabindex="7">
							{OPTIONS_ESTADO_CIVIL}
		          			</select>	 
						</td>
						<th><b>Direcci&oacute;n:</b></th>	
				    	<td><input type='text' id="sDireccion" name='sDireccion' value='{DIRECCION}' style='width:150px;' tabindex="8" onKeyUp="aMayusculas(this.value,this.id);"/></td>	    
				    	<td colspan="2"></td>
						<!--<th><b>Tipo de Usuario:</b></th>
						<td>
							<select id="idTipoEmpleado" name="idTipoEmpleado" style="width:150;">		
								{TIPOS_USUARIOS}
				          	</select>	 
						</td>-->
					</tr>
					<tr>
						<th class="celda_form"><b>(*)Provincia:</b></th>
						<td class="celda_form">
							<select style="width: 150px;" id="idProvincia" name="idProvincia" tabindex="9">
							{OPTIONS_PROVINCIAS}
							</select>
						</td>			
						<th class="celda_form"><b>(*)Localidad:</b></th>
						<td class="celda_form">
							<select style="width: 150px;" id="idLocalidad" name="idLocalidad" tabindex="10">
								<option value='0'>Seleccione una Provincia ... </option>
							</select>{SCRIPT_LOCALIDADES}
						</td>
						<th class="celda_form"><b>C.P.:</b></th>	
						<td class="celda_form"><input type="text" id="iCodigoPostal" name="iCodigoPostal" maxlength="50" size="25" value="{CODIGO_POSTAL}" tabindex="11" style="width:150px"/></td>		
					</tr>
					<tr>
				    	<th>Telefono Particular:</th>
				    	<td class='borde'><input type='text' id="sTelefonoParticular" name='sTelefonoParticular' value='{TELEFONO_PARTICULAR}' style='width:150px;' tabindex="12"/></td>
				    	<th>Celular:</th>
				    	<td class='borde'><input type='text' id="sMovil" name='sMovil' value='{MOVIL}' style='width:150px;' tabindex="13"/>
					    	<br/><span style="font-style:italic;font-size:7pt; " >Ejemplo: 387-4222222<span>
					    	<span style="font-style:italic;font-size:7pt;color: red;" >SIN "0" NI "15"<span>
				    	</td>  
				    	<th class='borde'>Email:</th>
				    	<td><input type='text' id="sMail" name='sMail' value='{MAIL}' style='width:150px;' tabindex="14"/></td>
					</tr>		
					<tr>
				        <th class='borde'>Login:</th>
				    	<td><input type='text' id="sLogin" name='sLogin' value='{LOGIN}' style='width:150px;' tabindex="15"/> <sup>*</sup></td> 			    	
				    	<th class='borde'>Password:</th>
				    	<td><input type='password' id="sPassword" name='sPassword' value='{MASKPASSWORD}' style='width:150px;' tabindex="16"/> <sup>*</sup></td>
				        <th class='borde'>Repetir Password:</th>
				    	<td><input type='password' id="sRepeatPassword" name='sRepeatPassword' value='{MASKPASSWORD}' style='width:150px;' tabindex="17"/> <sup>*</sup></td> 
					</tr>
					
					</table>
		  		</div>
	  	 	</div>
	        <div id="tab2" class="tab_content">  
	        	<div id="treeboxbox_tree2" style="width:98%;height:240px;border:1px solid #CCC;">
	        	<table id='TableCustomer' cellpadding="0" cellspacing="5" class="TableCustomer">
	        	<tr>
					<th class='borde' style='width:150px;'> Sucursal: </th>
					<td>
						<select name='idSucursal' id='idSucursal' style='width:150px;'>
						{OPTIONS_SUCURSALES}
						</select>
					</td>
					<th class='borde' style='width:150px;'> Oficina: </th>
					<td>
						<select name='idOficina' id='idOficina' style='width:150px;'>
						{OPTIONS_OFICINAS}
						</select>
					</td>				
				 	<th class='borde' style='width:150px;'> Area: </th>
					<td>
						<select name='idArea' id='idArea' style='width:150px;'>
						{OPTIONS_AREAS}
						</select>
					</td>
				</tr>
				<tr>		
					<th class="celda_form"><b>Tel&eacute;fono Corporativo:</b></th>		
					<td><input type="text" id="sTelefonoCorporativo" name="sTelefonoCorporativo" maxlength="50" value="{TELEFONO_CORPORATIVO}" style="width:150px"/></td>
					<th class="celda_form"><b>E-Mail Corporativo:</b></th>	
					<td><input type="text" id="sMailCorporativo" name="sMailCorporativo" maxlength="50" value="{MAIL_CORPORATIVO}" style="width:150px"/></td>	
					<td colspan="2"></td>
				</tr>	
				<tr><td colspan="6">&nbsp;</td></tr>
					<tr>
						<th colspan="6" style="text-align: left">Asignaci&oacute;n de Tipos de Empleados</th>
					</tr>
					<tr>
						<td colspan="6">
							<table id='TableCustomer' cellpadding="5" cellspacing="0" class="TableCustomer" style="border:1px solid;margin:5px">
							<tr>
								<th style='width:200px;text-align: center;border-bottom :1px solid; height:20px' align="center"> Unidad de Negocio </th>
								<th style="text-align: center;border-bottom:1px solid"> Tipo de Empleado </th>
							</tr>
							<tr>
								<th class='borde' style="text-align: center; height:25px"> {UNIDAD_NEGOCIO2} </th>
								<td>
									<select name='idTipoEmpleado2' id='idTipoEmpleado2' style='width:200px;'>
									{OPTIONS_TIPOSEMPLEADOS2}
									</select>
								</td>
							</tr>
							<tr>
								<th class='borde' style="text-align: center; height:25px"> {UNIDAD_NEGOCIO4} </th>
								<td>
									<select name='idTipoEmpleado4' id='idTipoEmpleado4' style='width:200px;'>
									{OPTIONS_TIPOSEMPLEADOS4}
									</select>
								</td>
							</tr>
							</table>
						</td>	
					</tr>
				</table>	
	        	</div>        
		    </div>
	        <div id="tab3" class="tab_content">  
	        	<div id="my_grid_general" style="display:block">
						<div style="width:100%;"  id="div_menu"></div>		
						<div id="gridbox" style="width:100%;height:80%;"></div>
				</div>
	        	</div>
		    </div>
		    
	    </div>
	    <!--<div style="width:850px;text-align:center;"><button  type="button" onclick="sendFormUser();"> Guardar </button> </div>-->
	</div>    
</form>		
	

<script type='text/javascript'>	

	$(document).ready(function() {
		//When page loads...
		$(".tab_content").hide(); //Hide all content
		$("ul.tabs li.first").addClass("active").show(); //Activate first tab
		$(".tab_content:first").show(); //Show first tab content
	
		//On Click Event
		$("ul.tabs li").click(function() {
	
			$("ul.tabs li").removeClass("active"); //Remove any "active" class
			$(this).addClass("active"); //Add "active" class to selected tab
			$(".tab_content").hide(); //Hide all tab content
	
			var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
			//$(activeTab).fadeIn(); //Fade in the active ID content
			$(activeTab).show();
			return false;
		});
	});
	
InputMask('dFechaNacimiento','99/99/9999');			
	
	function validarDatosForm() {
		var Formu = document.forms['formEmpleado'];
		var errores = '';
		with (Formu){
			if( !trim(sApellido.value) )
			errores += "- El campo Apellido es requerido.\n";
		
			if( !trim(sNombre.value) )
			errores += "- El campo Nombre es requerido.\n";
			
			if(!validarFecha(dFechaNacimiento.value))
			errores += "- El campo Fecha de Nacimiento es invalido.\n";
			
			if( idTipoDocumento.value == 0 )	
			errores += "- El campo Tipo Documento es requerido.\n";
				
			if( !trim(sNumeroDocumento.value) )
			errores += "- El campo Numero Documento es requerido.\n";
			
			if( idProvincia.value == 0 )
			errores += "- El campo Provincia es requerido.\n";
			
			if( idLocalidad.value == 0 )
			errores += "- El campo Localidad es requerido.\n";
			
			if( !trim(sLogin.value) )	
			errores += "- El campo Login es requerido.\n";
	
			if( !trim(sPassword.value))	
			errores += "- El campo Password es requerido.\n";
	
			if (!trim(sRepeatPassword.value))
			errores += "- El campo Repetir Password  es requerido.";
				
			if((sPassword.value != "")||(sRepeatPassword.value!= ""))
				if(sPassword.value != sRepeatPassword.value){
					errores += "- El campo Contraseña y Repetir Contraseña deben ser iguales.";
			}
		}
		if( errores ) { alert(errores); return false; } 
		else return true;
	}
	
	
	function resetDatosForm() {
		window.location="EdicionEmpleados.php?type=new";
	}

	
	mygrid = new dhtmlXGridObject('gridbox');    
	mygrid.selMultiRows = true;	
	mygrid.setImagePath("../includes/grillas/dhtmlxGrid/imgs/");	
	var flds = "Fecha Registro,Fecha Evento,Descripcion";	
	mygrid.setHeader(flds);	
	mygrid.attachHeader(",#text_filter,#text_filter");
	mygrid.setInitWidths("110,110,300,50");	
	mygrid.setColAlign("left,left,left");
	mygrid.setColTypes("ro,dhxCalendar,ed");    
	mygrid.setColumnIds("dFechaRegistro,dFechaEvento,sDescripcion");	
	
	mygrid.setDateFormat("%d/%m/%Y"); 
	mygrid.setMultiLine(false);
	//mygrid.setSkin("dhx_blue");
	mygrid.setSkin("dhx_blue");
	mygrid.init();
	 
   	mygrid.loadXML("xmlObservaciones.php?idEmpleadoEdicion={ID_EMPLEADO}");
	myDataProcessor = new dataProcessor("proccessObservaciones.php");    
    myDataProcessor.enableDataNames('true');  
    myDataProcessor.setUpdateMode("on");    
    myDataProcessor.defineAction("error",myErrorHandler); 
    myDataProcessor.defineAction("insert",fun_insert);  
    myDataProcessor.setTransactionMode("GET");
    myDataProcessor.init(mygrid);   
    
    function myErrorHandler(objeto){
        alert("Ha ocurrido un error: .\n " + objeto.firstChild.nodeValue);
        myDataProcessor.stopOnError = true;
        return false;
    }
   	
    function fun_insert(obj){
        var sId=obj.getAttribute("sid");
        var sTid=obj.getAttribute("tid");
        var sHoy=obj.getAttribute("hoy");
        mygrid.cells(sId,0).setValue(sHoy);
	    return true;        
    }
    
 	var menu = new dhtmlXMenuObject("div_menu",'dhx_blue'); 	
	menu.setImagePath("../includes/grillas/dhtmlxMenu/sources/imgs/");	
	menu.setIconsPath("../includes/grillas/dhtmlxMenu/sources/images/");		
	menu.addNewSibling(null,"idNuevo", "Nuevo", false, "add16.png");	
	if('{sType}' == 'EDIT'){
		menu.addNewSibling("idNuevo", "idGuardar", "Guardar",false, "save.gif");
	}
	
	menu.addNewSibling("idNuevo","idBorrar", "Borrar",false, "delete-general.png");	
	menu.attachEvent("onClick", _menu_onclick_);
	
 	var _row_ = (new Date()).valueOf();
	
	function _menu_onclick_(_i) {
		//var idEmpleado = document.getElementById('idEmpleado').value;
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

	function _send_form_(){ 
		myDataProcessor.sendData();	
	}    	

	function sendFormUser(){
		if(validarDatosForm()){
			if(confirm('Esta seguro de realizar esta operacion?')){	
				var formu=document.forms['formEmpleado']; 
				switch(formu.type.value){
					case "NEW":
			   		 	mygrid.parentFormOnSubmit();				   		 	
						break;
					case "EDIT":
					    myDataProcessor.sendData();
						break;			  				
				}
				//alert('paso');
				xajax_updateEmpleadoAccesos(xajax.getFormValues('formEmpleado'));
			}	
		}
	}	
</script>