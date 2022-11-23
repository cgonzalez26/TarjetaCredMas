SELECT
	DATE_FORMAT( pagos.fch_cobro, '%d/%m/%y %H:%i:%s' ) AS FCH_EMISION,
	DATE_FORMAT( cuotas.fch_vto, '%d/%m/%y ' ) AS FCH_VTO,
	cuotas.num_cuota AS NUM_CUOTA,
	pagos.num_recibo AS NUM_RECIBO,
	
	(SELECT IFNULL(SUM(importe),0)
	FROM cuotas_detalles 
	WHERE cuotas_detalles.id_cuota = cuotas.id_cuota ) AS IMPORTE_REAL,
	
	(SELECT IFNULL(SUM(importe),0)
	FROM cuotas_detalles
	WHERE cuotas_detalles.id_cuota = cuotas.id_cuota AND
	id_forpag IN (SELECT id_forpag FROM formas_pagos WHERE signo = '1')) AS IMPORTE_COBRADO
	
FROM pagos 

	LEFT JOIN cuotas ON pagos.id_pago = cuotas.id_pago
	
WHERE pagos.num_recibo = '{NUM_RECIBO}'
{OTRAS_CONDICIONES}