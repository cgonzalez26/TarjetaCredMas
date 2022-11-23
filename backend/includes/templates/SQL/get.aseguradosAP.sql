SELECT 
	asegurados_ap.id_aseap, 
	asegurados_ap.nom, 
	asegurados_ap.ape, 
	asegurados_ap.cargo, 
	asegurados_ap.dni, 
	asegurados_ap.dir, 
	asegurados_ap.fch_nac, 
	asegurados_ap.estado_civil, 
	asegurados_ap.sufrio_accidente, 
	asegurados_ap.defecto_fisico,
	asegurados_ap.zurdo,
	tipos_dni.nom as tipo,
	provincias.nom as provincia, 
	localidades.nom as localidad, 
	profesiones.profesion, 
	coberturas_ap.premio, 
	tipos_coberturas.cod,
	categorias.nom as categoria 
FROM
polizas_ap
inner join  asegurados_ap  on asegurados_ap.id_aseap=polizas_ap.id_aseap
inner join coberturas_ap on  coberturas_ap.id_cobap=asegurados_ap.id_cobap
inner join tipos_dni on tipos_dni.id_tdni=asegurados_ap.id_tdni
inner join profesiones on profesiones.id_prof=asegurados_ap.id_prof
inner join tipos_coberturas on tipos_coberturas.id_tcob=coberturas_ap.id_tcob
inner join  localidades on asegurados_ap.id_loc = localidades.id_loc
inner join  provincias on  localidades.id_provi = provincias.id_provi
inner join categorias on categorias.id_cat=coberturas_ap.id_cat
where {CONDICIONES}