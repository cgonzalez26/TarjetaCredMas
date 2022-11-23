SELECT 
	pagos.id_pago AS 'ID_PAGO',			
	pagos.num_recibo AS 'NUM_RECIBO',
	IFNULL(pagos.num_recibo_viejo, ' - ') AS 'NUM_RECIBO_VIEJO',
	DATE_FORMAT(pagos.fch_cobro,'%d/%m/%Y') AS 'FECHA',
	cuotas.id_cuota AS 'ID_CUOTA',
	SUM( cuotas_detalles.importe ) AS 'IMPORTE',
	SUM( IF( formas_pagos.signo > 0, 1, 0 ) * cuotas_detalles.importe ) AS 'IMPORTE_COBRADO',
	IF( polizas.num_poliza > 0, polizas.num_poliza, '') as 'NUM_POLIZA', 
	CONCAT( titulares.ape, ', ', titulares.nom ) as 'ASEGURADO',
	'{ID_CAJ_OPE}' AS 'ID_CAJ_OPE',
	IFNULL(vehiculos.dominio,'---') AS 'DOMINIO'
				
	
FROM pagos_polizas
			
	LEFT JOIN pagos ON pagos.id_pago = pagos_polizas.id_pago
	LEFT JOIN cuotas ON cuotas.id_pago = pagos.id_pago
	LEFT JOIN cuotas_detalles ON cuotas_detalles.id_cuota = cuotas.id_cuota
	LEFT JOIN formas_pagos ON formas_pagos.id_forpag = cuotas_detalles.id_forpag	
	LEFT JOIN polizas ON pagos_polizas.id_pol = polizas.id_pol
	LEFT JOIN titulares ON polizas.id_titu = titulares.id_titu
	LEFT JOIN polizas_detalles ON polizas.id_pol = polizas_detalles.id_pol
	LEFT JOIN vehiculos ON vehiculos.id_vehi = polizas_detalles.id_vehi
			
WHERE 

	pagos_polizas.id_caj_ope = '{ID_CAJ_OPE}'
	AND pagos.estado is null
	
GROUP BY cuotas_detalles.id_cuota 
ORDER BY pagos.fch_cobro DESC/*cuotas.num_cuota*/