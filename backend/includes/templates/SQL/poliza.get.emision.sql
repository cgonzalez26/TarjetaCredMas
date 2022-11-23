SELECT 
 
IF( polizas.estado IN ('T', 'ET') AND  (tipos_endosos.tipo IS NULL), 1, 0 ) AS 'ACTIVA',
  polizas.origen AS 'ORIGEN',
  polizas.id_pol AS 'ID_POL',
  polizas.estado AS 'ESTADO',
  polizas.reclamo AS 'RECLAMO',
  polizas.num_poliza AS 'NUM_POLIZA',
  polizas.cuota AS 'CUOTA',
  polizas_detalles.fch_endo AS 'FCH_ENDO',
  coberturas.id_coe AS 'ID_COE',
  coberturas.id_val AS 'ID_VAL',
  UNIX_TIMESTAMP( polizas.fch_desde ) AS 'FECHA_DESDE',
  UNIX_TIMESTAMP( polizas.fch_hasta ) AS 'FECHA_HASTA',
 
  (polizas.duracion - IFNULL(polizas.cuota,0)) AS 'restantes',		
  polizas.duracion,
  
  titulares.ape  AS 'TITULAR[APELLIDO]',
  titulares.nom  AS 'TITULAR[NOMBRE]',
  titulares.dni AS  'TITULAR[DOCUMENTO]',
  provincias.nom AS 'TITULAR[PROVINCIA]',
  
  /*************** PEDIDOS *********************************/
  pedidos.id_tped AS 'PEDIDO[TIPO]',
  pedidos.id_ped  AS 'PEDIDO[ID_PED]',
  pedidos.num  AS 'PEDIDO[NUM]',
  pedidos.fch  AS 'PEDIDO[FCH]',
  /*********************************************************/
  vehiculos.dominio AS 'VEHICULO[DOMINIO]',
  vehiculos.anio AS 'VEHICULO[ANIO]',
  marcas.nom AS 'VEHICULO[MARCA]',
  modelos.nom AS 'VEHICULO[MODELO]'
  /*,
  DATE_FORMAT(mercosur.fch_desde,'%d/%m/%Y')  AS 'MERCOSUR[FCH_DESDE]',
  DATE_FORMAT(mercosur.fch_hasta,'%d/%m/%Y') AS 'MERCOSUR[FCH_HASTA]',
  mercosur.id_mercosur AS 'MERCOSUR[ID_MERCOSUR]'*/
FROM
  polizas
  inner join polizas_detalles USING(id_pol) 
  inner join vehiculos using (id_vehi)
  left join tipos_vehiculos on tipos_vehiculos.id_tvehi = vehiculos.id_tvehi
  
  inner join coberturas using (id_cob)
  left join tipos_endosos on tipos_endosos.id_tendo = polizas_detalles.id_tendo
  LEFT JOIN titulares ON polizas.id_titu = titulares.id_titu
  LEFT JOIN localidades ON titulares.id_loc = localidades.id_loc
  LEFT JOIN provincias ON localidades.id_provi = provincias.id_provi
  
  
  left join marcas_modelos ON marcas_modelos.id_marmod = vehiculos.id_marmod
  left join  marcas ON marcas_modelos.id_mar = marcas.id_mar
  left join modelos ON marcas_modelos.id_mod = modelos.id_mod

 /* LEFT JOIN mercosur ON mercosur.id_pol = polizas.id_pol */
  LEFT JOIN user ON polizas.id_user = user.id_user
  LEFT JOIN dependientes ON user.id_dep = dependientes.id_dep
  LEFT JOIN sucursales ON sucursales.id_suc = dependientes.id_suc
  left join pedidos_polizas on  polizas.id_pol=pedidos_polizas.id_pol
  left join pedidos on pedidos_polizas.id_ped=pedidos.id_ped
WHERE

{CONDICIONES}

{OTROS}