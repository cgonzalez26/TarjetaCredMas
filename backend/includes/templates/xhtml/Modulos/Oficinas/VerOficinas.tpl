<body style="background-color:#FFFFFF">
<div id="BODY">
<center>

<table cellpadding='0' cellspacing='0' style='width:60%' border='0' class="formulario">
<tr><td style="font-size:18px">Vista de Oficinas</td></tr>
</table>
<table cellpadding='0' cellspacing='0' style='width:60%' border='0'>							   	
	<tr>
   	<td style='width:220px' valign='top'>
     	
 		<img id='map' src='../includes/images/ProvinciasArgentinas.gif' width='200' height='385' border='0' usemap='#provincia' />
     	<map name='provincia' id='provincia'>				  
     	  <area shape='poly' coords='57,5,83,23,82,34,44,19' href='#'  alt='Jujuy' title='Jujuy' onclick='xajax_mostrarCoberturasporProvincia(7868,"Jujuy")' />
     	  <!--<area shape='circle' coords='62,23,12' href='#' alt='Jujuy' title='Jujuy' onclick='xajax_mostrarCoberturasporProvincia(7868,"Jujuy")' />-->
		  <area shape='rect' coords='45,34,75,51' href='#' alt='Salta' title='Salta' onclick='xajax_mostrarCoberturasporProvincia(8162,"Salta")' />				  
		  <area shape='circle' coords='61,62,10' href='#' alt='Tucuman' title='Tucuman' onclick='xajax_mostrarCoberturasporProvincia(8196,"Tucuman")' />											  
		  <area shape='poly' coords='31,40,62,80,61,92,26,64' href='#'  alt='Catamarca' title='Catamarca' onclick='xajax_mostrarCoberturasporProvincia(8018,"Catamarca")' />
		  <area shape='poly' coords='77,52,99,51,93,93,72,93,67,71' href='#' alt='Santiago del Estero' title='Santiago del Estero' onclick='xajax_mostrarCoberturasporProvincia(8039,"Stgo. del Estero")'/>
		  <area shape='poly' coords='28,75,42,78,59,97,52,113' href='#' alt='La Rioja' title='La Rioja' onclick='xajax_mostrarCoberturasporProvincia(7885,"La Rioja")' />
		  <area shape='rect' coords='65,95,92,155' href='#' alt='Cordoba' title='Cordoba' onclick='xajax_mostrarCoberturasporProvincia(7856,"Cordoba")' />
		  <area shape='circle' coords='112,172,28' href='#' alt='Bs.As.' title='Bs.As.' onclick='xajax_mostrarCoberturasporProvincia(7830,"Bs.As.")'/>																  <area shape='rect' coords='40,167,85,190' href='#' alt='La Pampa' title='La Pampa' onclick='xajax_mostrarCoberturasporProvincia(7998,"La Pampa")' />
		  <area shape='rect' coords='19,142,42,175' href='#' alt='Mendoza' title='Mendoza' onclick='xajax_mostrarCoberturasporProvincia(7894,"Mendoza")'/>
		  <area shape='rect' coords='47,121,65,174' href='#' alt='San Luis' title='San Luis' onclick='xajax_mostrarCoberturasporProvincia(8172,"San Luis")'/>
		  <area shape='rect' coords='14,100,40,126' href='#' alt='San Juan' title='San Juan' onclick='xajax_mostrarCoberturasporProvincia(8170,"San Juan")'/>
		  <area shape='rect' coords='5,233,63,283' href='#' alt='Chubut' title='Chubut' onclick='xajax_mostrarCoberturasporProvincia(8003,"Chubut")'/>
		  <area shape='rect' coords='13,284,59,353' href='#' alt='Santa Cruz' title='Santa Cruz' onclick='xajax_mostrarCoberturasporProvincia(8175,"Santa Cruz")'/>
		  <area shape='circle' coords='128,126,14' href='#' alt='Entre Rios' title='Entre Rios' onclick='xajax_mostrarCoberturasporProvincia(7847,"Entre Rios")'/>
		  <area shape='poly' coords='104,74,128,72,109,145,97,144' href='#' alt='Santa Fe' title='Santa Fe' onclick='xajax_mostrarCoberturasporProvincia(8120,"Santa Fe")'/>
		  <area shape='poly' coords='140,63,131,73,104,67,112,42' href='#' alt='Chaco' title='Chaco' onclick='xajax_mostrarCoberturasporProvincia(8025,"Chaco")' />
		  <area shape='poly' coords='101,14,151,46,143,61,99,25' href='#' alt='Formosa' title='Formosa' onclick='xajax_mostrarCoberturasporProvincia(7969,"Formosa")'/>
		  <area shape='poly' coords='139,68,166,73,149,102,127,107' href='#' alt='Corrientes' title='Corrientes' onclick='xajax_mostrarCoberturasporProvincia(7924,"Corrientes")' />											  
		  <area shape='poly' coords='186,53,192,61,180,77,172,70' href='#' alt='Misiones' title='Misiones' onclick='xajax_mostrarCoberturasporProvincia(8075,"Misiones")'/>
		  <area shape='poly' coords='11,171,33,182,30,209,7,217' href='#' alt='Neuqu&eacute;n' title='Neuqu&eacute;n' onclick='xajax_mostrarCoberturasporProvincia(7924,"Neuqu&eacute;n")' />
		  <area shape='poly' coords='39,201,82,200,79,228,9,227' href='#' alt='Rio Negro' title='Rio Negro' onclick='xajax_mostrarCoberturasporProvincia(7924,"Rio Negro")' />
		  <area shape='poly' coords='45,362,76,381,50,383,45,373' href='#' alt='Tierra del Fuego' title='Tierra del Fuego' onclick='xajax_mostrarCoberturasporProvincia(8075,"Tierra del Fuego")'/>
		</map>
      </td>
      <td valing='top' align='center'>
      	 <table cellpadding='0' cellspacing='0' style='width:100%' border='0'>
	      <tr>
	     	  <td id='tdTituloSucursales' height='30' valign='top'>
	     	  </td>
	      </tr>
	      <tr>
	      	  <td>
        	  <div id='divContentAgencias' style='height:350px;overflow:auto; overflow-x:hidden;display:block;width:100%;' valing='top'>
			  </div>		
			  </td>
		  </tr>		
          </table>		
		</td>
	</tr>
	</table>
</center>	