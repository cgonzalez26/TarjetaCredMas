select
polizas_detalles.fch_endo AS 'ENDOSO[FECHA]',
coberturas.premio AS 'PREMIO'

from 
polizas
inner join polizas_detalles on polizas_detalles.id_pol=polizas.id_pol
inner join coberturas on coberturas.id_cob= polizas_detalles.id_cob

WHERE 
{CONDICIONES}
