
SELECT  
  id_gesend AS 'ID_GESEND',
  DATE_FORMAT(fch_pedido,'%d/%m/%y') AS 'FCH_PEDIDO',
  IF (fch_endoso !='0000-00-00 00:00:00',DATE_FORMAT(fch_endoso ,'%d/%m/%Y'),' --- ' )AS 'FCH_ENDOSO',
  num_endoso AS 'NUM_ENDOSO',
  IF(num_endoso > 0 ,'T','ET') AS 'ESTADO',
  motivo AS 'MOTIVO',
  tipos_endosos.tipo AS 'TIPO_ENDOSO',
  if(tipos_endosos.id_tendo = 2,'VEHICULO',IF(tipos_endosos.id_tendo =3,'TITULAR','0') ) AS 'ENDOSO',
  tipos_endosos.id_tendo AS 'ID_TENDO'
  
FROM     
gestiones_endosos
LEFT JOIN tipos_endosos USING(id_tendo)
where {CONDICIONES}