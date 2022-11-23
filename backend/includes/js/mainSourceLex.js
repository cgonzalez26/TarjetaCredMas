function inhabilitar(){ 
   	//alert ("Esta función está inhabilitada.\n\nPerdonen las molestias.") 
   	var iLex=1;
   	return false 
} 

document.oncontextmenu=inhabilitar 

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
shortcut.add("F5",function (){
						return true;
				},{
					'type':'keydown',
					'propagate':false,
					'target':document
				});