<style>

#body_principal
{

widht:AUTO;
height:{ALTURA};
Overflow-y:scroll;
Overflow-x:hidden;

}

#body_principal tr.filaAncha{
height:150px !important;
}
table.suavizar3 {
		border-spacing: 1;
		border: solid 0px #CCC;
		background-color: #AA9FAA;		
		font-size: 7pt;

	}

table.suavizar3 th {
		background-color: #EFF7FF;
		
	}
	
table.suavizar3 th.blanco,td.blanco {
		background-color:#FFFFFF;
		/*border-top:solid 1px #000000 ;*/
		border:solid 1px #CCC;
		height:20px;
	}



</style>
<!--<hr style='width: 400px'>-->
<span style='color:AD1400;font-weight:bold; font-style:italic;'>{CONTADOR}</span>		
<div style="background-color:#EFF7FF;width:{ANCHO_TABLA};height:30px;border:solid 1px #CCC;" >{BOTONERAS}</div>
<table id='tabla_polizas' class='suavizar3' width="{ANCHO_TABLA}">
<thead>
	<tr class='segunda_fila' >
	{CABESERA}
    </tr>
</thead>
<tbody id="body_principal">
{FILAS}
</tbody>
</table>
<div style="background-color:#EFF7FF;width:{ANCHO_TABLA};height:30px;border:solid 1px #CCC;" >{BOTONERAS}</div>
<span class='espacio'></span>
<div style="width:400px;border:solid 1px #CCCCCC;">{PAGINACION}</div>
<span class='espacio'></span>
{EXTRAS}