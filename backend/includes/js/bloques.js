function funciones_bloques( id_lista, bloque_inicial ) {

	var bloques = new Object();
	bloques.lista = document.getElementById( id_lista );	

	bloques.titulos = new Array();
	bloques.bloques = new Array();
	
	bloques.activo = bloque_inicial ? bloque_inicial : 0 ;
	
	bloques.tiempoMovimiento = 5;
	bloques.distanciaMovimiento = 40;
	
	var i;
	
	var elementos_dt = bloques.lista.getElementsByTagName('dt');
	var elementos_dd = bloques.lista.getElementsByTagName('dd');
	
	for(i=0; i< elementos_dt.length; i++)
	
	if( elementos_dt[i].parentNode.id == id_lista ) {
	
		bloques.titulos[ bloques.titulos.length ] = elementos_dt[i];  
		bloques.bloques[ bloques.bloques.length ] = elementos_dd[i];
		
		elementos_dd[i].movimientoOcultar = function ( mostrar_proximo ) {
			
			var nuevo_alto = Number( this.offsetHeight - bloques.distanciaMovimiento );
			
			if( nuevo_alto > 1 ) 
			this.style.height = nuevo_alto + 'px';
			
			else { 
				clearInterval( this.ocultarVar );
				this.ocultarVar = false;
				this.style.height = '1px';
				
				if ( mostrar_proximo == 1 || mostrar_proximo == -1 ) {
				
					bloques.titulos[ bloques.activo ].className = '';
					bloques.activo += mostrar_proximo;
					
					var bloque = bloques.bloques[ bloques.activo];
							
					bloque.style.display = 'block';
					bloque.style.visibility = 'hidden';
					bloque.style.height = 'auto';
					bloque.style.position = 'absolute';
					bloque.style.width = bloques.bloques[bloques.activo-mostrar_proximo].offsetWidth + 'px';
					 
					bloque.alturaMaxima = bloque.offsetHeight							
												
					bloque.style.width = 'auto';
					bloque.style.position = 'static';
					bloque.style.visibility = 'visible';
					bloque.style.height = '1px';
					
					bloque.alturaMaxima = 'auto'; ///450!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
					
					bloques.titulos[ bloques.activo ].className = 'seleccionado';
															
					bloque.mostrarVar = setInterval( 'bloques.bloques[' + bloques.activo + ' ].movimientoMostrar()', bloques.tiempoMovimiento );
				}
				
				this.style.display = 'none';
			}			
		}
		
		
		elementos_dd[i].movimientoMostrar = function () {
			
			var nuevo_alto = Number( this.style.height.replace(/([^0-9]+)/,'') ) + bloques.distanciaMovimiento;
			
			if( nuevo_alto < this.alturaMaxima )
			this.style.height = nuevo_alto + 'px';
			
			else { 
				clearInterval( this.mostrarVar );
				this.style.height = this.alturaMaxima;
												
				bloques.lista.style.cursor = 'default';
			}			
		}
		
	
	}
		
	bloques.siguiente = function () {
		
		if( this.activo >= bloques.bloques.length - 1 ) {
			
			return;
		}
	
		this.lista.style.cursor = 'wait';
	
		var funcion = 'bloques.bloques[' + this.activo + ' ].movimientoOcultar(1)';
		this.bloques[this.activo].ocultarVar = setInterval( funcion, this.tiempoMovimiento );
	}
	
	bloques.anterior = function () {
		
		if( 0 == this.activo ) return;
	
		var funcion = 'bloques.bloques[' + this.activo + ' ].movimientoOcultar(-1)';
		this.bloques[this.activo].ocultarVar = setInterval( funcion, this.tiempoMovimiento );
	}
	
	
	return bloques;
}
