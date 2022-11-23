select
 
 polizas.id_pol AS 'ID_POL',
 cuotas.num_cuota AS 'NUM_CUOTA', 
 cuotas.id_cuota AS 'ID_CUOTA', 
 SUM( IF( formas_pagos.signo > 0, 1, 0 ) * cuotas_detalles.importe ) AS 'IMPORTE_COBRADO' 
from 
pagos_polizas
	left join user on pagos_polizas.id_user=user.id_user
	left join dependientes on user.id_dep=dependientes.id_dep
	left join sucursales on dependientes.id_suc=sucursales.id_suc
	
	left join polizas on pagos_polizas.id_pol=polizas.id_pol
	
	left join pagos on pagos_polizas.id_pago=pagos.id_pago
	left join cuotas on pagos.id_pago=cuotas.id_pago
	left join cuotas_detalles on cuotas_detalles.id_cuota=cuotas.id_cuota
	left join formas_pagos on cuotas_detalles.id_forpag=formas_pagos.id_forpag

where 
   {CONDICIONES}
  
GROUP BY cuotas_detalles.id_cuota   

