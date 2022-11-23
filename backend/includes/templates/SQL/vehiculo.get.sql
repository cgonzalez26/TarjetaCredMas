SELECT 
    
    vehiculos.id_tvehi AS  'VEHICULO[TIPO]', 
    vehiculos.anio AS 'VEHICULO[ANIO]',
	vehiculos.motor AS 'VEHICULO[MOTOR]',
	vehiculos.chasis AS 'VEHICULO[CHASIS]',
	vehiculos.dominio AS 'VEHICULO[DOMINIO]',
	marcas.id_mar AS 'VEHICULO[MARCA]',
	vehiculos.id_marmod AS 'VEHICULO[MARMOD]',
	vehiculos.id_col  AS 'VEHICULO[COLOR]',
	FORMAT(vehiculos.valor,0) AS 'VEHICULO[VALOR]',
	vehiculos.danio AS 'VEHICULO[DANIO]',
	vehiculos.id_vehicar AS 'VEHICULO[VEHICAR]',
	vehiculos.num_flota AS 'VEHICULO[NUM_FLOTA]',
	vehiculos.id_vehiuso AS 'VEHICULO[VEHIUSO]',
	vehiculos.id_tcombu AS 'VEHICULO[COMBUSTIBLE]',
	vehiculos.hab_mun AS 'VEHICULO[HAB_MUN]',
	vehiculos.anio AS 'VEHICULO[ANIO]'

FROM vehiculos
	
	LEFT JOIN marcas_modelos ON marcas_modelos.id_marmod = vehiculos.id_marmod
	LEFT JOIN marcas ON marcas_modelos.id_mar = marcas.id_mar
	LEFT JOIN modelos ON marcas_modelos.id_mod = modelos.id_mod

WHERE {CONDICIONES}

{OTROS}