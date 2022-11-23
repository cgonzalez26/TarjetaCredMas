SELECT 

	
	/* CARTA DE COBERTURA --------------------------------- */	
	
	@CC_ID_POLIZA := (SELECT MAX(id_pol) FROM polizas WHERE id_cc = cartas_coberturas.id_cc),
	
	cartas_coberturas.num_cc AS 'CC[NUM_CC]',
	cartas_coberturas.id_cc AS 'CC[ID_CC]',
	UNIX_TIMESTAMP(cartas_coberturas.fch_alta) AS 'CC[FECHA]',
	cartas_coberturas.estado AS 'CC[ESTADO]',
	@CC_ID_POLIZA AS 'CC[ID_POLIZA]',
	vehiculos.num_flota AS 'CC[NUM_FLOTA]',
	IFNULL(cartas_coberturas.num_ccprovi, '') AS 'CC[NUM_PROVI]',
	IF( polizas.estado IN ('T', 'ET','PE') AND  (tipos_endosos.tipo IS NULL) AND polizas.renovacion=0, 1, 0 ) AS 'ACTIVA',
	
	
	/* POLIZA ---------------------------------------------- */	
	IFNULL(polizas.emision,0) AS 'EMISION',
	polizas.preactualizada AS 'PA',
    polizas.acreedor AS 'ACREEDOR', 
	polizas.duracion AS 'DURACION',
	polizas.num_poliza AS 'NUM_POLIZA',
	polizas.num_vida AS 'NUM_VIDA',
	tipos_polizas.nom AS 'TIPO_POLIZA',
	polizas.renovacion AS 'RENOVACION',
	UNIX_TIMESTAMP( polizas.fch_desde ) AS 'FECHA_DESDE',
	UNIX_TIMESTAMP( polizas.fch_hasta ) AS 'FECHA_HASTA',
	UNIX_TIMESTAMP( polizas.fch_desde_pol ) AS 'FECHA_DESDE_POL',
	UNIX_TIMESTAMP( polizas.fch_hasta_pol ) AS 'FECHA_HASTA_POL',
	polizas.estado AS 'ESTADO',
	polizas.id_pol AS 'ID_POL',
	polizas.id_tpol AS 'ID_TPOL',
	polizas.id_tanu AS 'ID_TANU',
	polizas.reclamo AS 'RECLAMO',
	polizas.id_tdev AS 'ID_TDEV',
	
	UNIX_TIMESTAMP(polizas.fch_anu) AS 'FECHA_ANU',
	
	
	IF( polizas.id_tpol = 1,
		coberturas.premio,
		IF( polizas.id_tpol = 3,
		   (SELECT seguros_tecnicos.premio FROM seguros_tecnicos WHERE seguros_tecnicos.id_pol=polizas.id_pol )
		,
		(SELECT SUM(coberturas_ap.premio) FROM polizas_ap, asegurados_ap, coberturas_ap	WHERE polizas_ap.id_aseap= asegurados_ap.id_aseap AND 
		asegurados_ap.id_cobap= coberturas_ap.id_cobap AND	polizas_ap.id_pol= polizas.id_pol )
		)
		
		) AS 'PREMIO' , 
	
	IF( polizas.id_tpol = 2,
		(SELECT COUNT(polizas_ap.id_polap) FROM polizas_ap 
		WHERE polizas_ap.id_pol= polizas.id_pol ), -1  )  AS 'NRO_ASEGURADOS',
		
	polizas_detalles.id_poldet AS 'ID_POLDET',
	
	localidades.id_tar AS 'ID_TAR',
	
	CONCAT( productores.ape, ', ', productores.nom ) AS 'PRODUCTOR',
	
	CONCAT(
			IF( polizas.estado = 'ET', 'En Trámite', 
			    IF( polizas.estado = 'T', 'Tramitada', 
			                                          IF (polizas.estado='RC',CONCAT('Rechazada el : ',DATE_FORMAT(polizas.fch_recha,'%d / %m / %Y')), CONCAT('Anulada el: ',DATE_FORMAT(polizas.fch_anu,'%d / %m / %Y'))) )),
			
			IF( polizas.renovacion=1, ' - Renovada', '' ),
			IF( polizas.fch_hasta < NOW() AND NOT polizas.renovacion, ' - Vencida', '' ) ) AS 'ESTADO',
			
	polizas.estado AS 'ESTADO_CHAR',
	
	IF( polizas.fch_hasta < NOW() AND NOT polizas.renovacion, 1,0 ) AS 'VENCIDA',
	
	IF( vehiculos.num_flota > 0, 1, 0 ) AS 'FLOTA',
	
	polizas.entregada as 'ENTREGADA',
		
	IF( polizas.estado = 'T' && NOT polizas.renovacion , 1, 0 ) AS 'PUEDE_ENTREGAR',
	polizas.obs AS 'OBSERVACIONES',
	polizas.obsCall AS 'OBSERVACIONES_CALL',
	polizas.obs_impu AS 'OBS_IMPU',
	companias.nom AS 'COMPANIA',
	polizas.id_produ AS 'ID_PRODU',
	polizas.id_date AS 'ID_DATE',
	polizas.id_cobra AS 'ID_COBRA',
	polizas.id_cia AS 'ID_CIA',
	coberturas.id_coe AS 'ID_COB_COE',
	coberturas.id_val AS 'ID_COB_VAL',
	vehiculos.id_tvehi AS 'ID_TVEHI',
	vehiculos_carrocerias.id_tcar AS 'ID_TCAR',
	vehiculos_usos.id_tuso AS 'ID_TUSO',
	marcas_modelos.id_mar AS 'ID_MAR',
	marcas_modelos.id_mod AS 'ID_MOD',
	vehiculos.id_tcombu AS 'ID_TCOMBU',
	vehiculos.id_vehiuso AS 'ID_VEHIUSO',
	titulares.id_loc AS 'ID_LOC',
	coberturas.id_cob  AS 'ID_COB',
	vehiculos.id_vehi AS 'ID_VEHI',
	vehiculos.id_vehicar AS 'ID_VEHICAR',
	marcas_modelos.id_marmod AS 'ID_MARMOD',
	colores.id_col AS 'ID_COL',
	tipos_dni.id_tdni AS 'ID_TDNI',
	tipos_iva.id_tiva AS 'ID_TIVA',
	titulares.id_titu AS 'ID_TITU',
	polizas.id_user AS 'ID_USER',
	marcas.id_mar AS 'ID_MARCA',
	modelos.id_mod AS 'ID_MODELO',
	
	IF( 
		IF(polizas.estado = 'T' AND IFNULL(polizas.cuota,0) >= polizas.duracion,1,IF(polizas.estado = 'A',1,0))
		AND polizas.num_poliza > 0 AND
		(SELECT IFNULL(MAX(id_pol),0) FROM polizas WHERE id_cc = cartas_coberturas.id_cc ) = polizas.id_pol	
		, 1, 0 ) AS 'PARA_RENOVAR',
		
    if (vehiculos.bloqueado = 1,0,1) AS 'PARA_INHIBIR',		
	If( IFNULL(polizas.id_tdev,0) AND  (polizas.id_tdev>0),0, 1 ) AS 'PARA_DEVOLUCION',
	If( polizas.estado = 'RC', 0, 1 ) AS 'PARA_RECHAZAR',
	If( polizas.estado = 'PE', 0, 1 ) AS 'PARA_PENDIENTE',
	If( polizas.estado = 'A', 0, 1 ) AS 'PARA_ANULAR',
	
	if( IFNULL(polizas.emision,0) = 0,1,0) 'PARA_ENVIAR_EMISION', 
	
	
	(SELECT CONCAT(cod, ' - ', descri) FROM tipos_coberturas WHERE id_tcob = coberturas.id_val ) AS 'COBERTURA[VAL]',
	(SELECT CONCAT(cod, ' - ', descri) FROM tipos_coberturas WHERE id_tcob = coberturas.id_coe ) AS 'COBERTURA[COE]',
	
	
	(SELECT cod FROM tipos_coberturas WHERE id_tcob = coberturas.id_val ) AS 'SIGLAS[VAL]',
	(SELECT cod FROM tipos_coberturas WHERE id_tcob = coberturas.id_coe ) AS 'SIGLAS[COE]',
	
	/* CUOTAS -----------------------------------------------*/
	IFNULL(polizas.cuota,0) AS 'CUOTAS[PAGADAS]',
	
	polizas.duracion  +  round((datediff(polizas.fch_hasta_pol,polizas.fch_hasta)/30)) AS 'DIF_DURACION',
	
	IF(round((datediff(polizas.fch_hasta_pol,polizas.fch_hasta)/30)) >= 1
	,((polizas.duracion + round((datediff(polizas.fch_hasta_pol,polizas.fch_hasta)/30))) - IFNULL(polizas.cuota,0))
	,(polizas.duracion - IFNULL(polizas.cuota,0))) AS 'CUOTAS[RESTANTES]',
	
	/*(polizas.duracion - IFNULL(polizas.cuota,0)) AS 'CUOTAS[RESTANTES]',*/
	polizas.cuota AS 'CUOTA',
	
	(select 
        IFNULL(MIN(cuotas.num_cuota),0) 
     from 
		cuotas
		left join pagos using(id_pago)
		left join pagos_polizas using (id_pago) 
		where 
		pagos_polizas.id_pol=polizas.id_pol	
		and pagos.estado is null) AS 'CUOTAS[INICIAL]',
	
	
	/* TITULAR -------------------------------------------- */	
	
	titulares.id_titu AS 'TITULAR[ID_TITU]',
	titulares.ape AS 'TITULAR[APELLIDO]',
	titulares.nom AS 'TITULAR[NOMBRE]',
	titulares.dir_per AS 'TITULAR[DIRECCION]',
	titulares.dir_lab AS 'TITULAR[DIR_LAB]',
	localidades.nom AS 'TITULAR[LOCALIDAD]',
	provincias.nom AS 'TITULAR[PROVINCIA]',
	tipos_dni.nom AS 'TITULAR[TIPO_DOCUMENTO]',
	titulares.dni AS 'TITULAR[DOCUMENTO]',
	titulares.cp AS 'TITULAR[CP]',
	tipos_iva.condicion AS 'TITULAR[CONDICION_IVA]',
	titulares.cuit AS 'TITULAR[CUIT]',
	titulares.tel_per AS 'TITULAR[TEL_PERSONAL]',
	titulares.tel_lab AS 'TITULAR[TEL_LAB]',
	titulares.movil AS 'TITULAR[MOVIL]',
	titulares.num_cli AS 'TITULAR[NUM_CLI]',
	titulares.num_tar AS 'TITULAR[NUM_TAR]',
	provincias.id_provi AS 'TITULAR[ID_PROVI]',
	titulares.id_gru AS 'TITULAR[ID_GRU]',
	DATE_FORMAT(titulares.fch_nac,'%d/%m/%Y') AS 'TITULAR[FCH_NAC]',
	
	/* ENDOSO ---------------------------------------------- */	
	
	tipos_endosos.tipo AS 'ENDOSO[TIPO]',
	UNIX_TIMESTAMP( polizas_detalles.fch_endo ) AS 'ENDOSO[FECHA]',
	polizas.cuota_endoso AS 'ENDOSO[CUOTA]',
	polizas_detalles.obs AS 'ENDOSO[MOTIVO]',
	polizas.origen AS 'ORIGEN',
	
	
	/* VEHICULO ---------------------------------------------------*/
	
	vehiculos.anio AS 'VEHICULO[ANIO]',
	vehiculos.motor AS 'VEHICULO[MOTOR]',
	vehiculos.chasis AS 'VEHICULO[CHASIS]',
	vehiculos.dominio AS 'VEHICULO[DOMINIO]',
	tipos_vehiculos.nom AS 'VEHICULO[TIPO]',
	IFNULL(tipos_carrocerias.nom, 'No Espeficicado') AS 'VEHICULO[CARROCERIA]',
	tipos_usos.nom AS 'VEHICULO[USO]',
	marcas.nom AS 'VEHICULO[MARCA]',
	modelos.nom AS 'VEHICULO[MODELO]',
	tipos_combustibles.nom AS 'VEHICULO[COMBUSTIBLE]',
	vehiculos.num_flota AS 'VEHICULO[NUM_FLOTA]',
	tipos_vehiculos.nom AS 'VEHICULO[TIPO]',
	ifnull(vehiculos.valor,0.00) AS 'VEHICULO[VALOR]',
	vehiculos.danio AS 'VEHICULO[DANIO]',
	vehiculos.hab_mun AS 'VEHICULO[HAB_MUN]',
	colores.nom  AS 'VEHICULO[COLOR]',
	
	IF( vehiculos.hab_mun = 'S', 'Sí', 'No' ) AS 'VEHICULO[HAB_MUNICIPAL]',
		
	/* OTROS DATOS --------------------------------------------------*/
	dependientes.id_dep AS 'ID_DEP',
	polizas.id_dep AS 'ID_DEP_ORIGEN',
	(SELECT apodo FROM dependientes WHERE id_dep = polizas.id_dep) AS 'DEPENDIENTE[APODO_ORIGEN]',
	(SELECT nombre FROM sucursales WHERE id_suc IN (SELECT id_suc FROM dependientes WHERE id_dep = polizas.id_dep)) AS 'SUCURSALES[NOMBRE_ORIGEN]',
	
	/*----------------------------------------------------------------*/
	dependientes.num_dep AS 'DEPENDIENTE[NUM]',
	dependientes.apodo AS 'DEPENDIENTE[APODO]',
	dependientes.productor AS 'DEPENDIENTE[PRODUCTOR]',
	user.login AS 'USUARIO[LOGIN]',
	sucursales.nombre AS 'SUCURSALES[NOMBRE]',
	
	mercosur.id_mercosur AS 'ID_MERCOSUR',
	
	DATE_FORMAT(mercosur.fch_desde,'%d/%m/%Y')  AS 'MERCOSUR[FCH_DESDE]',
	DATE_FORMAT(mercosur.fch_hasta,'%d/%m/%Y') AS 'MERCOSUR[FCH_HASTA]',
	polizas.id_produ_int AS 'ID_PRODU_INT',
	productores_internos.num_produ AS 'PRODUCTORES_INTERNOS[NUM_PRODU]',
	productores_internos.nom  AS 'PRODUCTORES_INTERNOS[NOM]'

FROM polizas

	LEFT JOIN cartas_coberturas ON cartas_coberturas.id_cc = polizas.id_cc
	LEFT JOIN tipos_polizas ON tipos_polizas.id_tpol = polizas.id_tpol  
	LEFT JOIN titulares ON polizas.id_titu = titulares.id_titu
	LEFT JOIN localidades ON titulares.id_loc = localidades.id_loc
	LEFT JOIN provincias ON localidades.id_provi = provincias.id_provi
	LEFT JOIN tipos_dni ON titulares.id_tdni = tipos_dni.id_tdni
	LEFT JOIN tipos_iva ON tipos_iva.id_tiva = titulares.id_tiva
	
	LEFT JOIN mercosur ON mercosur.id_pol = polizas.id_pol 
	
	LEFT JOIN polizas_detalles ON polizas.id_pol = polizas_detalles.id_pol
	LEFT JOIN tipos_endosos ON polizas_detalles.id_tendo = tipos_endosos.id_tendo 
	LEFT JOIN companias ON companias.id_cia = polizas.id_cia
	
	LEFT JOIN vehiculos ON polizas_detalles.id_vehi = vehiculos.id_vehi
	LEFT JOIN tipos_vehiculos ON vehiculos.id_tvehi = tipos_vehiculos.id_tvehi
	LEFT JOIN vehiculos_carrocerias ON vehiculos_carrocerias.id_vehicar = vehiculos.id_vehicar
	LEFT JOIN tipos_carrocerias ON tipos_carrocerias.id_tcar = vehiculos_carrocerias.id_tcar
	
	LEFT JOIN vehiculos_usos ON vehiculos.id_vehiuso = vehiculos_usos.id_vehiuso
	LEFT JOIN tipos_usos ON tipos_usos.id_tuso = vehiculos_usos.id_tuso
	
	LEFT JOIN marcas_modelos ON marcas_modelos.id_marmod = vehiculos.id_marmod
	LEFT JOIN marcas ON marcas_modelos.id_mar = marcas.id_mar
	LEFT JOIN modelos ON marcas_modelos.id_mod = modelos.id_mod
	
	LEFT JOIN coberturas ON polizas_detalles.id_cob = coberturas.id_cob  
	
	LEFT JOIN tipos_combustibles ON vehiculos.id_tcombu = tipos_combustibles.id_tcombu 
	
	LEFT JOIN colores ON colores.id_col = vehiculos.id_col
	
	LEFT JOIN productores ON productores.id_produ = polizas.id_produ
	LEFT JOIN user ON polizas.id_user = user.id_user
	LEFT JOIN dependientes ON user.id_dep = dependientes.id_dep
	LEFT JOIN sucursales ON sucursales.id_suc = dependientes.id_suc
	LEFT JOIN productores_internos ON productores_internos.id_produ_int = polizas.id_produ_int
	
WHERE {CONDICIONES}

{OTROS}