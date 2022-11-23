SELECT 

	localidades.id_provi AS 'FORM_POLIZA[PROVINCIA]',
	titulares.id_tiva AS 'FORM_POLIZA[CONDICION_IVA]',
	titulares.id_tdni AS 'FORM_POLIZA[TIPO_DOC]',
	titulares.id_gru AS 'FORM_POLIZA[GRUPO]',
	(SELECT id_provi FROM localidades WHERE id_loc = titulares.id_loc ) AS 'FORM_POLIZA[PROVINCIA]',
	titulares.id_loc AS 'FORM_POLIZA[LOCALIDAD]',
	titulares.nom AS 'FORM_POLIZA[NOMBRE]',
	titulares.ape AS 'FORM_POLIZA[APELLIDO]',
	titulares.num_tar AS 'FORM_POLIZA[NUM_TARJETA]',
	titulares.num_cli AS 'FORM_POLIZA[NUM_CLIENTE]',
	titulares.dir_per AS 'FORM_POLIZA[DIR_PERSONAL]',
	titulares.dir_lab AS 'FORM_POLIZA[DIR_LABORAL]',
	titulares.tel_per AS 'FORM_POLIZA[TEL_PERSONAL]',
	titulares.tel_lab AS 'FORM_POLIZA[TEL_LABORAL]',
	titulares.movil AS 'FORM_POLIZA[MOVIL]',
	titulares.cp AS 'FORM_POLIZA[CP]',
	titulares.cuit AS 'FORM_POLIZA[CUIT]',
	titulares.dni AS 'FORM_POLIZA[DOC]',
	if(titulares.sMail='','sin@mail.com',titulares.sMail) AS 'FORM_POLIZA[MAIL]',
	DATE_FORMAT(titulares.fch_nac,'%d/%m/%Y') AS 'FORM_POLIZA[FCH_NAC]'
		
FROM titulares

	LEFT JOIN localidades ON localidades.id_loc = titulares.id_loc
	LEFT JOIN provincias ON provincias.id_provi = localidades.id_provi

WHERE {CONDICIONES}

{OTROS}