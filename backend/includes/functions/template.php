<?php //--------------------------------------------------------------------

//--------------------------------------------------------------------------
// Librer�a para funciones de Parseo
//--------------------------------------------------------------------------

// Estas funciones son usadas para parsear cadenas
// En estas cadenas, se sustituye cada aparici�n de un nombre de variable
// encerrado por llaves por su respectivo valor, dando un array de
// variables $vars. Por ejemplo, si se encuentra una expresi�n
// {VAR} en la cadena, y en el array $vars se encuentra un elemento
// con clave 'VAR', {VAR} ser� sustiu�do con el valor de esa clave

// Funci�n para parsear una cadena

function parserCadena( $cadena, $vars = false ) {
		
	// Si $vars no es array, lo convertimos en un array vac�o para evitar
	// errores cuando se quiera acceder a �ste
	If( !is_array( $vars ) ) $vars = array();
	
	
	// Redefinimos el array $vars de tal forma que contenga, adem�s
	// de las variables definidas en �l, todas las constantes definidas
	$vars += get_defined_constants();
		
	// Guardamos en $coincidencias todas las apariciones de alguna
	// expresi�n {...}, donde ... es un nombre de variable
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


// Funci�n para parsear un archivo .tpl, y devolver la cadena de resultado.
// Esta hace uso de la funci�n anterior. La diferencia est� en que,
// en lugar de parsear una cadena, �sta funci�n parsea un archivo y 
// devuelve el resultado.

function parserTemplate( $template, $vars = false ) {	
	// Si el archivo existe, entonces obtenemos el contenido,
	// y lo parseamos haciendo uso de la funci�n anterior	
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
// Fin librer�a de Parseo ----------------------------------------------- ?>