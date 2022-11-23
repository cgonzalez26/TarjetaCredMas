<?php //-------------------------------------------------------------



function array_compact_keys( $array, $keySeparator = '/' ) {
		
	$newArray = array();
	
	
	foreach( $array as $key => $value ) {

		if( is_array( $value ) ) {
			
			
			$value = array_compact_keys( $value, $keySeparator );
			$value = array_transform_keys( $value, 'return "' . $key . $keySeparator . '" . $key;' );
			
			$newArray += $value;
		
		} else $newArray[ $key ] = $value;
		
	}
	
	return $newArray;
}


function array_extend_keys( $array, $keySeparator = '/' ) {
	
	$extendedArray = array();
	
	foreach($array as $clave => $valor) {
		
		$claves = array_filter(explode( $keySeparator, $clave ));
		$valor = var_export( $valor, true );
		
		if(count($claves)>0) eval( $codigo = '$extendedArray[\'' . implode( "']['" ,$claves ) . "'] = $valor; " );
	}
	
	return $extendedArray;
}





function array_compact_keys_html( $array ) {
		
	$argSeparator = '&';
	
	$queryString = http_build_query( $array, null, $argSeparator );
	$arrayClavesValores = explode( $argSeparator, $queryString );
	$compactArray = array();
			
	
	Foreach( $arrayClavesValores as $claveValor ) {
		
		list($clave, $valor) = explode('=', $claveValor);
		
		$compactArray[ urldecode( $clave ) ] = urldecode( $valor );
	}
	
	return $compactArray;
}


function array_extend_keys_html( $array ) {
	
	 $keySeparator = '/';
	
	$replaceFunction = '$key = str_replace("][", "' . $keySeparator . '", $key); ';
	$replaceFunction.= '$key = str_replace("[", "' . $keySeparator . '", $key); ';
	$replaceFunction.= 'return str_replace("]", "' . $keySeparator . '", $key); ';
	
	$array = array_transform_keys( $array, $replaceFunction );
	
	return array_extend_keys( $array, $keySeparator );
}


//---------------------------------------------------------------------



function array_get_subarray( $array, $subarrayKey ) {
	
	if(!is_array($array)) $array = array();
	$subarray = array();
		
	foreach($array as $key => $value )
	
		if(is_array($value))
		
			$subarray[$key] = $value[ $subarrayKey ];
			
	return $subarray;
}



function array_group( $array, $groupKey ) {
	
	if(!is_array($array)) $array = array();
	$newArray = array();
	
	
	foreach( $array as $key => $value ) 
		
		if(is_array($value) && $value[ $groupKey ] != null) {

			
			$keyValue = $value[ $groupKey ];
			
			if(!is_array($newArray[$keyValue])) $newArray[$keyValue] = array(); 
	
			$newArray[$keyValue][ $key ] = $value;
			unset( $newArray[$keyValue][ $key ][ $groupKey ] );
			
		}

	return $newArray;
}



function array_transform_values( $array, $func ) {
	
	if(!is_array($array)) $array = array();
	
	$newArray = array();
	
	if( !function_exists( $func ) ) $func = create_function( '$value, $key', $func );
	
	foreach($array as $key => $value) @ $newArray[ $key ] = $func( $value, $key );
	
	return $newArray;
}



function array_transform_keys( $array, $func ) {
	
	if(!is_array($array)) $array = array();
	
	$newArray = array();
	
	if( !function_exists( $func ) ) $func = create_function( '$value, $key', $func );
	
	foreach($array as $key => $value) @ $newArray[ $func( $value, $key ) ] = $value;
	
	return $newArray;
}



function array_split( $array, $parts_count, $preserveKeys = true ) {
	
	if(!is_array($array)) $array = array();
	
	$newArray = array();
	
	if(!$parts_count || $parts_count <= 0) 
		$parts_count = 1;
	
		
	$parts_length = ceil( count($array) / $parts_count );
		
	for($i=0; $i < $parts_count; $i++) 
		$newArray[] = array_slice( $array, $i * $parts_length, $parts_length, $preserveKeys );
	
	return $newArray;
}



function array_filter_extended( $array, $func = null, $recursive = true ) {
	
	if(!is_array($array)) $array = array();
	
	$newArray = array();
	
	if(	$func == null) $func = create_function( '$value, $key', 'return (boolean) $value;' );
	else if( !function_exists( $func ) ) $func = create_function( '$value, $key', $func );
	
	foreach($array as $key => $value) {
		
		if($recursive && is_array( $value )) 
			
			$value = array_filter_extended( $value, $func, $recursive );
		
		
		@ $valid = $func( $value, $key );
		
		if( $valid ) $newArray[ $key ] = $value;
	}
		
	return $newArray;
}


//----------------------------------------------------


function array_insert_arrays( $arrays, $insertArray ) {
	
	if(!is_array($arrays)) $arrays = array();
	if(!is_array($insertArray)) $insertArray = array();
	
		
	foreach($arrays as $index=> $array)
		
		if(!is_array($array)) continue;
		
		else $arrays[$index] = array_merge( $arrays[$index], $insertArray );
			
		
		
	return $arrays;
	
}


function array_get_values( $array, $keys ) {
	
	if(!is_array($array)) $array = array();
	if(!is_array($keys)) $keys = array();
	
	$newArray = array();
	
	foreach($array as $key => $value)
	
		if(in_array($key, $keys)) $newArray[$key] = $value;
		
	return $newArray;
	
}

//----------------------------------------------------

function array2string( $array, $func = null, $separator = null ) {
	
	if(!is_array($array)) $array = array();
	
	if( $separator == null ) $separator = $func == null ? ',' : "\n";
	
		
	if( $func == null ) $func = create_function( '$value, $key', 'return $value;' );
	else if( !function_exists( $func ) ) $func = create_function( '$value, $key', $func );
	
	$stringArray = array();
	foreach($array as $key => $value) @ $stringArray[] = $func( $value, $key );
	
	return implode($separator, $stringArray );
}


//----------------------------------------------------


function array_sort( $array, $compareFunction = null, $reverse = false ) {
	
	if(!is_array($array)) $array = array();
	if(count($array) <= 1) return $array;
	
	if($compareFunction == null) $compareFunction = 'return $value';
	
	$compareArray = array_transform_values( $array, $compareFunction );
	
	$newArray = array();
	
	while( count($compareArray) > 0 ) {
		
		$minValue = null;
		$minKey = null;
		
		$first = true;
		
		foreach( $compareArray as $key => $value ) {
		
			if($first || $value < $minValue) {
				
				$minValue = $value;
				$minKey = $key;
											
				$first = false;
			}
		}
		
		$newArray[ $minKey ] = $array[ $minKey ];
		unset($compareArray[ $minKey ]);
	}
	
	if($reverse) $newArray = array_reverse( $newArray, true );
	
	return $newArray;
	
}


function array_2_hiddens( $array ) {
	// Si no es un array, salimos
	If( !is_array( $array ) ) return;

	// Transformamos el array en una cadena (como una cadena de consulta GET),
	// Para luego dividirla por medio del caracter '&', y posteriormente
	// dividir cada elemento por el caracter '=', donde obtendremos
	// el par nombre=>valor. Esto se hace para que el proceso sea también
	// válido para arrays multidimensionales (por los nombres de las claves)

	$query_string = http_build_query( $array );
	$claves_valores = explode( '&', $query_string );
			
	
	Foreach( $claves_valores as $clave_valor ) {
		
		$clave_valor = explode( '=', $clave_valor, 2 );
		
		$nombre = urldecode( array_shift( $clave_valor ) );
		$valor = urldecode( array_shift( $clave_valor ) );
				
		$cadena.= "<input type='hidden' name='$nombre' value='$valor' />\n";
	}

	
	return $cadena;
}
//------------------------------------------ ?>