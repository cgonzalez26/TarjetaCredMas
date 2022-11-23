<?php //-------------------------------


function go_url( $url, $relative = true, $vars = null, $appendVars = true ) {
	
	if($relative && stripos( $url, 'http://' ) === 0) 
		$relative = false;
		
	if($relative)	
		$url = BASE_URL . $url;
		
	if(is_array($vars)) {
		
		$pos = strpos($url, '?');
		
		if($pos === false) $queryString = '';
		else {
			
			$queryString = substr( $url, $pos + 1 );
			$url = substr($url, 0, $pos);	
		}
		
		if($appendVars) {
			
			parse_str( $queryString, $aditionalVars );
			$vars = array_merge( $vars, $aditionalVars );
		}
		
		$url.= '?' . http_build_query($vars);
		
	}
	
	header('Location: ' . $url);
	exit();
}



function getURLVars( $url ) {
	
	$pos = strpos($url, '?');
		
	if($pos === false) $queryString = '';
	else $queryString = substr( $url, $pos + 1 );
		
	parse_str( $queryString, $vars );
	
	return $vars;
}

function getVarsURL($url){
	$pos = strpos($url, '?');
		
	if($pos === false) $queryString = '';
	else $queryString = substr( $url, $pos + 1 );
	
	return $queryString;
}


function removeURLVars( $url ) {
	
	$pos = strpos($url, '?');
		
	if($pos === false) return $url;
	else return substr($url, $pos);
		
	
}


function getURLPathArray( $removeExtensions = false ) {
	
	$path_info = $_SERVER['PATH_INFO'];
	
	If( $removeExtensions )
		$path_info = preg_replace( '#(\.)([a-zA-Z0-9]+)#', '', $path_info );
	
	return array_filter( explode( '/', $path_info ) );
}


function getURI( $absolute = true ) {
	
	$uri = $_SERVER['REQUEST_URI'];
	
	if($absolute) $uri = 'http://' . $_SERVER['HTTP_HOST'] . $uri;
	
	
		
	return $uri;
}

//------------------------------------ ?>