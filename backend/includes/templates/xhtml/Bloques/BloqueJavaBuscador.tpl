<script language="javascript">
function Buscar()
{
	var formu=document.forms['filtros'];
    formu.submit();   
	/*
	var mensaje='';
	if(typeof (formu['todos']) != "undefined"){
	   if(formu['todos'].checked)
	   if ((formu['dominio'].value!='' || formu['apellido'].value != '' || formu['num_poliza'].value != '')) 
	           formu.submit();
	   else
	           alert('Debe indicar un Dominio, Apellido o Numero de Poliza.');
      else	  
       formu.submit();          	
	}else formu.submit();    */
	
}

function EliminarPoliza(id){
	var formu=document.forms[id];
    var mensaje='';
    var filter=/^([0-9])*$/;
    if(formu['idPoliza'].value=='') mensaje+="-El campo id de Poliza es requerido .\n";
    else 
       if(!filter.test(formu['idPoliza'].value)) mensaje+="-El campo id de Poliza debe ser un valor numerico.\n";
    /*
    if(formu['sucursal'].value == 0 ) mensaje+="-El campo sucursal es requerido .\n"; 	
    if(formu['dependiente'].value == 0 ) mensaje+="-El campo dependiente es requerido .\n"; 	
    if(formu['usuario'].value == 0 ) mensaje+="-El campo usuario es requerido .\n"; 	   
       */
    if(mensaje==''){
    	if(confirm('Esta aPunto de Eliminar todo registro de esta poliza. ¿Esta Seguro?')){
    		xajax_EliminarPoliza(formu['idPoliza'].value);	
    	}
    }else alert(mensaje);
    
}

function GenerarNumCC(id,idCC){
	
    var mensaje='';
     /*var filter=/^([0-9])*$/;
	    if(formu['idPoliza'].value=='') mensaje+="-El campo id de Poliza es requerido .\n";
	    else 
	       if(!filter.test(formu['idPoliza'].value)) mensaje+="-El campo id de Poliza debe ser un valor numerico.\n";
	   
	    if(formu['sucursal'].value == 0 ) mensaje+="-El campo sucursal es requerido .\n"; 	
	    if(formu['dependiente'].value == 0 ) mensaje+="-El campo dependiente es requerido .\n"; 	
	    if(formu['usuario'].value == 0 ) mensaje+="-El campo usuario es requerido .\n"; 	   
     */

	if(confirm('Esta aPunto de Generar un nuevo numero de CC . ¿Esta Seguro?')){
		
		xajax_GenerarNumCC(id,idCC);	
	}
    
    
}

function DesanularPoliza(id){
	
	if(confirm('Esta a Punto de Desanular una Poliza. ¿Esta Seguro?')){
		
		xajax_DesanularPoliza(id);	
	}
  
    
}

function NuevoTitular(idForm)
{
   var formu=document.forms[idForm];
   var mensaje='';
   var filter=/^([0-9])*$/; 
   
   if(formu['idPoliza'].value=='') mensaje+="-El campo id de Poliza es requerido .\n";
   else 
      if(!filter.test(formu['idPoliza'].value)) mensaje+="-El campo id de Poliza debe ser un valor numerico.\n";
    	
   if(formu['sucursal'].value == 0 ) mensaje+="-El campo sucursal es requerido .\n"; 	
   if(formu['dependiente'].value == 0 ) mensaje+="-El campo dependiente es requerido .\n"; 	
   if(formu['usuario'].value == 0 ) mensaje+="-El campo usuario es requerido .\n"; 	
   
   if(mensaje==''){
   	
   	   
   	var idPoliza=formu['idPoliza'].value;
   	var idUser=formu['usuario'].value;
   	var ancho = 800; 
	var alto = 600;
	
	var top = Math.ceil( ( screen.availHeight - alto ) / 2 );
	var left = Math.ceil( ( screen.availWidth - ancho ) / 2 );	
	
	var propiedades='width='+ancho+',height='+alto;
	propiedades+= ',top='+top+',left=' + left + ',toolbars=true,scrollbars=yes';
	var ventana = window.open( 'popUpGuardarTitular.php?idPoliza='+idPoliza+'&idUser='+idUser, 'Ficha Póliza', propiedades );
   	
   }else alert(mensaje);
   
	
}

function DesinhibirPoliza(id){
	
    	if(confirm('Esta a Punto de Desinhibir una Poliza. ¿Esta Seguro?')){   		
    		xajax_DesinhibirPoliza(id);	
    	}
    
    
}




shortcut.add("Backspace",function (){
		/*var t = event.srcElement.type;
		if( t == 'text') alert('estas en un input text');
		if( t == 'textarea' ) alert('estas en un  textarea');*/
		return true;
	},{
	'type':'keydown',
	'disable_in_input':true,
	'propagate':false,
	'target':document
	});	
</script>
