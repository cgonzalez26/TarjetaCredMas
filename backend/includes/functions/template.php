<?php //--------------------------------------------------------------------

//--------------------------------------------------------------------------
// Librería para funciones de Parseo
//--------------------------------------------------------------------------

// Estas funciones son usadas para parsear cadenas
// En estas cadenas, se sustituye cada aparición de un nombre de variable
// encerrado por llaves por su respectivo valor, dando un array de
// variables $vars. Por ejemplo, si se encuentra una expresión
// {VAR} en la cadena, y en el array $vars se encuentra un elemento
// con clave 'VAR', {VAR} será sustiuído con el valor de esa clave

// Función para parsear una cadena

function parserCadena( $cadena, $vars = false ) {
		
	// Si $vars no es array, lo convertimos en un array vacío para evitar
	// errores cuando se quiera acceder a éste
	If( !is_array( $vars ) ) $vars = array();
	
	
	// Redefinimos el array $vars de tal forma que contenga, además
	// de las variables definidas en él, todas las constantes definidas
	$vars += get_defined_constants();
		
	// Guardamos en $coincidencias todas las apariciones de alguna
	// expresión {...}, donde ... es un nombre de variable
	preg_match_all( '#(\{)([a-zA-Z0-9\_\.]+)(\})#', $cadena, $coincidencias );
		
	
	// Para cada coincidencia, la reemplazamos con el valor del elemento
	// en $vars que tenga esa clave
	
	For( $i = 0; $i < count( $coincidencias[0] ); $i++ ) {

		$coincidencia = $coincidencias[2][$i];
		$reemplazo = $vars[ $coincidencia ];
		$cadena=str_replace($coincidencias[0][$i],trim( $reemplazo ),$cadena );
	}
	
	// Devolvemos la cadena parseada
	return $cadena;		
}


// Función para parsear un archivo .tpl, y devolver la cadena de resultado.
// Esta hace uso de la función anterior. La diferencia está en que,
// en lugar de parsear una cadena, ésta función parsea un archivo y 
// devuelve el resultado.

function parserTemplate( $template, $vars = false ) {	
	// Si el archivo existe, entonces obtenemos el contenido,
	// y lo parseamos haciendo uso de la función anterior	
	if( file_exists( $template ) ) return parserCadena( file_get_contents( $template ), $vars );
	else return "No_Existe-> $template";
	
}

function convertir_especiales_html($str){
   if (!isset($GLOBALS["carateres_latinos"])){
      $todas = get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES);
      $etiquetas = get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES);
      $noTags = array_diff($todas, $etiquetas);
   }
   $str = strtr($str, $noTags);
   return $str;
}


//--------------------------------------------------------------------------
// Fin librería de Parseo ----------------------------------------------- ?>