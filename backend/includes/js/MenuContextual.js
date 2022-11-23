/*jQuery.noConflict()
jQuery(document).ready(function($){
	
	//$('.openPopUp').click(function(){
		//var id=$('.openPopUp').text();
		//parent.top.alert('abrir pop up para ');		
		//Windows.close(Windows.focusedWindow.getId());
	//});
   //$(document).click(function() {
           //$('.classBtnExtras').fadeOut("fast");
		   //$('.classBtnExtras').css({'vivibility': 'hidden'});
		   //$('.classBtnExtras  div#ContBotonaera').mouseout(function (){   
		   //     $('.classBtnExtras').fadeOut("fast");             	
		  // });
        		
	//});

	//$('#CartasCoberturas').click(function() {
      //     $('.classBtnExtras').fadeOut("fast");
		//   $('.classBtnExtras').css({'vivibility': 'hidden'});
	//}); 
});	*/
	

function verExtras(idPol){
	var id="#divBtnExtras"+idPol+"";
	
	jQuery('.classBtnExtras').fadeOut("fast");
    jQuery('.classBtnExtras').css({'vivibility': 'hidden'});
    
	if(jQuery(id).is(':hidden')){ 
		jQuery(id).fadeIn("fast"); 	
		 //$("#capa").addClass("clasecss");
			
	}
	else if (jQuery(id).is(':visible')) { 
    	jQuery(id).fadeOut("fast"); 
    	//$("#capa").addClass("clasecss");
    	
	}
}

function FloatingWindow(sUrl,sTitulo,alto,ancho){
    	  //className: "bluelighting,darkX", 
    	  //width:700, 
		  //height:250, 
    	  var win = new Window(
    	  {className: "alphacube", 
		  title:"<b>"+ sTitulo +"</b>", 
		  width:ancho, 
		  height:alto, 
		  top:50, 
		  left:60, 
		  url:sUrl,
		  showEffect:Element.show,
		  hideEffect:Element.hide
		  }); 
		  win.toFront();	 
		  win.showCenter();  
}
function PopUpWindow(sUrl, sTitulo){
	
	      try{
	      	parent.Windows.close(parent.Windows.focusedWindow.getId());
	      	var ancho = 700; 
			var alto =600;
			
			var top = Math.ceil( ( screen.availHeight - alto ) / 2 );
			var left = Math.ceil( ( screen.availWidth - ancho ) / 2 );	
			
			var propiedades='width='+ancho+',height='+alto;
			propiedades+= ',top='+top+',left=' + left + ',toolbars=true,scrollbars=yes';
	
	        var ventana = window.open( sUrl, sTitulo, propiedades );
	      }catch(e){
	        var ancho = 700; 
			var alto =600;
			
			var top = Math.ceil( ( screen.availHeight - alto ) / 2 );
			var left = Math.ceil( ( screen.availWidth - ancho ) / 2 );	
			
			var propiedades='width='+ancho+',height='+alto;
			propiedades+= ',top='+top+',left=' + left + ',toolbars=true,scrollbars=yes';
	
	        var ventana = window.open(sUrl,sTitulo,propiedades);
        };
}

//WINDOW MESSAGE	
messageObj = new DHTML_modalMessage();
messageObj.setShadowOffset(5);	

function displayMessage(url_,ancho,alto) {
	messageObj.setSource(url_);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(ancho,alto);
	messageObj.setShadowDivVisible(true);	//Enable shadow for these boxes
	messageObj.display();
}

function closeMessage() { 
	resetJsCache();
	messageObj.close();	
}

function getBoxInicioSession(iTipo){
	sUrl="../Empleados/BlockInicioSession.php";
	displayMessage(sUrl,300,160);
}

function getBoxCambiarEstadoSolicitud(id,idEstado){
	sUrl="../Solicitudes/CambiarEstadoSolicitud.php?id="+id+"&idEstado="+idEstado;
	displayMessage(sUrl,450,260);
}

function getBoxHistorialSolicitud(id,sNumero){
	sUrl="../Solicitudes/HistorialSolicitud.php?id="+id+"&sNumero="+sNumero;
	displayMessage(sUrl,800,450);
}

function getBoxHistorialCuenta(id,sNumero){
	sUrl="../CuentasUsuarios/HistorialCuenta.php?id="+id+"&sNumero="+sNumero;
	displayMessage(sUrl,800,450);
}

function getBoxHistorialTarjeta(id,sNumero){
	sUrl="../TarjetasCreditos/HistorialTarjetaCredito.php?id="+id+"&sNumero="+sNumero;
	displayMessage(sUrl,800,450);
}

function getBoxHistorialLoteEmbosaje(id,sNumero){
	sUrl="../TarjetasCreditos/HistorialLoteEmbosaje.php?id="+id+"&sNumero="+sNumero;
	displayMessage(sUrl,800,450);
}

function getBoxHistorialLoteCorreo(id,sNumero){
	sUrl="../TarjetasCreditos/HistorialLoteCorreo.php?id="+id+"&sNumero="+sNumero;
	displayMessage(sUrl,800,450);
}

function getBoxEmbozarTarjetasCreditos(sTarjetas,operacion){
	sUrl="../TarjetasCreditos/EnviarAEmbozar.php?sTarjetas="+sTarjetas+"&operacion="+operacion;
	displayMessage(sUrl,450,260);
}

function getBoxEnviarACorreoTarjetasCreditos(sTarjetas){
	sUrl="../TarjetasCreditos/EnviarLoteACorreo.php?sTarjetas="+sTarjetas;
	displayMessage(sUrl,450,260);
}

function getBoxRegistrarNoEmbozoTarjetasCreditos(id,sTarjetas,optionEditar){
	sUrl="../TarjetasCreditos/RegistrarNoEmbozo.php?id="+id+"&sTarjetas="+sTarjetas+"&optionEditar="+optionEditar;
	displayMessage(sUrl,450,260);
}

function getBoxRegistrarDevolucionTarjetasCreditos(id,sTarjetas,optionEditar){
	sUrl="../TarjetasCreditos/RegistrarDevolucion.php?id="+id+"&sTarjetas="+sTarjetas+"&optionEditar="+optionEditar;
	displayMessage(sUrl,450,260);
}

function getBoxDarBajaTarjetaCredito(id,sNumero,idTipoEstado){
	sUrl="../TarjetasCreditos/CambiarEstadoTarjeta.php?id="+id+"&idTipoEstado="+idTipoEstado+"&sNumero="+sNumero+"&operacion=0";
	displayMessage(sUrl,480,260);
}

function getBoxCuotasAjusteUsuario(idAjuste){
	sUrl="../AjustesUsuarios/Cuotas.php?idAjuste=".idAjuste;
	displayMessage(sUrl,450,500);
}

function getBoxCambiarEstadoTarjetaCredito(id,sNumero){
	sUrl="../TarjetasCreditos/CambiarEstadoTarjeta.php?id="+id+"&operacion=1&sNumero="+sNumero;
	displayMessage(sUrl,480,260);
}

function win_cuotas(URL, whi, he, scro) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=" + scro + ",location=0,statusbar=0,menubar=0,resizable=0,width=" + whi + ",height=" + he + "');");
}