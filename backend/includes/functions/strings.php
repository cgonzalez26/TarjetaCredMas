<?php //------------------------------------------



function str_starts_with( $string, $prefixs, $caseSensitive = true ) {
	
	if( !is_array( $prefixs ) ) $prefixs = array( $prefixs );
	
	$function = $caseSensitive ? 'strpos' : 'stripos';
	
	foreach( $prefixs as $prefix )
	
		if( $function( $string, $prefix ) === 0 ) return $prefix;
		
	return false;
	
}


function str_ends_with( $string, $sufixs, $caseSensitive = true  ) {
	
	if( !is_array( $sufixs ) ) $sufixs = array( $sufixs );
	
	$stringLength = strlen( $string );
	$function = $caseSensitive ? 'strrpos' : 'strripos';
	
	
	foreach( $sufixs as $sufix )
	
		if( $function( $string, $sufix ) === $stringLength - strlen($sufix) ) return $sufix;
		
	return false;
	
}




function str_remove_prefix( $string, $prefixs, $caseSensitive = true ) {

	
	if( ( $prefix = str_starts_with( $string, $prefixs, $caseSensitive ) ) !== false ) return substr( $string, strlen( $prefix ) );
	else return $string;
}


function str_remove_sufix( $string, $sufixs, $caseSensitive = true ) {
	
	
	if( ( $sufix = str_ends_with( $string, $sufixs, $caseSensitive ) ) !== false ) return substr( $string, 0, strlen( $string ) - strlen( $sufix ) );
	else return $string;
}




function str_put_prefix( $string, $prefix, $caseSensitive = true ) {
	
	
	if( str_starts_with( $string, $prefix, $caseSensitive ) === false ) return "{$prefix}{$string}";
	else return $string;
}


function str_put_sufix( $string, $sufix, $caseSensitive = true ) {
	
	
	if( str_ends_with( $string, $sufix, $caseSensitive ) === false ) return "{$string}{$sufix}";
	else return $string;
}


//------------------------------------------

function str_escape_javascript( $string ) {
	
	
	if(is_array($string)) {
		
		
		$array = array();
		
		foreach($string as $key => $value) {
			
			$key = str_escape_javascript( $key );
			$value = str_escape_javascript( $value );
			
			$array[ $key ] = $value;
			
		}
		
		
		return $array;
		
	} else {
	
		$string = str_replace( "\r\n", "\n", $string );
		$string = str_replace( "\n", "\\n", $string );
		$string = str_replace( "'", "\'", $string );
		$string = str_replace( '"', '\"', $string );
	
		return $string;
		
	}
}

//------------------------------------------

function str_trim( $string ) {
	
	if( is_array($string) ) {
		
		$array = array();
		
		foreach($string as $key => $value)
			$array[ $key ] = str_trim($value);
			
		return $array;
		
	} else return trim($string);
	
}

function number_pad($number,$n) {
	return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
}
//------------------------------------------ ?>