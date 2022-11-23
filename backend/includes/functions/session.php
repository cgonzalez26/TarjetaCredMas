<?php //----------------------------------------------------------------------


define('SESSION_FUNCTIONS_VARNAME_GLOBALS', '_SESSION_VARS');
define('SESSION_FUNCTIONS_VARNAME_COOKIE', '_SESSION_VARS');
define('SESSION_FUNCTIONS_VARNAME_SESSION', '_SESSION_VARS');



function session_init( $session_id = null, $destroy = false ){
	
	
	if( $destroy ) $GLOBALS[ SESSION_FUNCTIONS_VARNAME_GLOBALS ] = null;
	
				
	If( session_is_initialized() ) return false;

	if( !is_array( $GLOBALS[ SESSION_FUNCTIONS_VARNAME_GLOBALS ] ) )
		$GLOBALS[ SESSION_FUNCTIONS_VARNAME_GLOBALS ] = array();
				
	if( !isset( $_COOKIE[ SESSION_FUNCTIONS_VARNAME_COOKIE ] ) || $destroy ) {
		
		$GLOBALS[ SESSION_FUNCTIONS_VARNAME_GLOBALS ][ 'FIRST_TIME' ] = true;
		setcookie( SESSION_FUNCTIONS_VARNAME_COOKIE, true, 0 );
		
	
	} else $GLOBALS[ SESSION_FUNCTIONS_VARNAME_GLOBALS ][ 'FIRST_TIME' ] = false;
	
	If( $session_id != null ) session_id( $session_id );
	
	session_start();
	
	if( $destroy ) session_unset();
	
	$_SESSION[ SESSION_FUNCTIONS_VARNAME_SESSION ][ 'LAST_TIME' ] = time();
	
	if(!$_SESSION[ SESSION_FUNCTIONS_VARNAME_SESSION ]['IS_FIRST_TIME'])
		$_SESSION[ SESSION_FUNCTIONS_VARNAME_SESSION ]['IS_FIRST_TIME'] = true;
		
	else $_SESSION[ SESSION_FUNCTIONS_VARNAME_SESSION ]['IS_FIRST_TIME'] = false;
	
	if( $GLOBALS[ SESSION_FUNCTIONS_VARNAME_GLOBALS ][ 'FIRST_TIME' ] ) 
		$_SESSION[ SESSION_FUNCTIONS_VARNAME_SESSION ][ 'FIRST_TIME' ] = time();

	$GLOBALS[ SESSION_FUNCTIONS_VARNAME_GLOBALS ][ 'INITIALIZED' ] = true;
}


function session_get_id() { return session_id(); }


function session_is_initialized() {
	
	return isset( $GLOBALS[ SESSION_FUNCTIONS_VARNAME_GLOBALS ] ) && is_array( $GLOBALS[ SESSION_FUNCTIONS_VARNAME_GLOBALS ] ) && $GLOBALS[ SESSION_FUNCTIONS_VARNAME_GLOBALS ][ 'INITIALIZED' ];
}



function session_is_firsttime() {
	
	
	return (boolean) $_SESSION[ SESSION_FUNCTIONS_VARNAME_SESSION ]['IS_FIRST_TIME'];
}
 


function session_get_firsttime() { return $_SESSION[ SESSION_FUNCTIONS_VARNAME_SESSION ][ 'FIRST_TIME' ]; }
	
	
function session_get_lasttime() { return $_SESSION[ SESSION_FUNCTIONS_VARNAME_SESSION ][ 'LAST_TIME' ]; }
	
//----------------------------------------------------------------
	

function session_add_var( $name, $value = false ) { 

	if( $name != SESSION_FUNCTIONS_VARNAME_SESSION )
		@ $_SESSION[ $name ] = serialize( $value );
}
	
function session_remove_var( $name ) { 
	
	if( $name != SESSION_FUNCTIONS_VARNAME_SESSION )
		unset( $_SESSION[ $name ] ); 
}


function session_get_var( $name, $delete = false ) {
	
	if( $name == SESSION_FUNCTIONS_VARNAME_SESSION ) return false;
	
	$var = unserialize( $_SESSION[ $name ] );
	
	If( $delete ) session_remove_var( $name );
	
	return $var;
}


//-------------------------------------------------------------------------- ?>