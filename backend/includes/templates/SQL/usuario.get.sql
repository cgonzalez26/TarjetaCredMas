SELECT
	CONCAT(user.apellido, ', ', user.nombre) as usuario,
	user.login as login,
	user.nombre,
	user.apellido,
	user.movil,
	user.email,
	user.dir,
	user.id_tuser,
	user.id_user,
	dependientes.num_dep as dep_num,
	dependientes.apodo as dep_apodo,
	dependientes.dir as dep_dir,
	sucursales.id_suc as suc_id,
	sucursales.nombre as suc_nombre,
	sucursales.clave as suc_clave,
	sucursales.num_suc as suc_num,
	dependientes.id_dep as id_dep
	
FROM user

	LEFT JOIN dependientes USING (id_dep)
	LEFT JOIN sucursales USING (id_suc)
	
WHERE {CONDICIONES}

{OTRAS}