<?php //------------------------------------------


function file_create_temp( $contents = null, $prefix = 'temp' ) { 

	$file = tempnam( sys_get_temp_dir(), $prefix ); 
	
	if($contents != null) file_put_contents( $file, (string) $contents );
	
	return $file; 
}


function file_show( $file_content, $filename = null, $type = null, $attachment = false, $cache = true ) {
		
	if( !( $isFile = is_file($file_content) ) ) $file = file_create_temp( $file_content );
	else $file = $file_content;
	
	@ $string = file_get_contents( $file );
	
	if( $filename == null ) @ $filename = basename( $file );
	
	$contentDisposition = $attachment ? 'attachment' : 'inline';
			
	
	if( $type != null ) header("Content-Type: $type");
	header("Content-Disposition: $contentDisposition; filename=\"$filename\"");
	if(!$cache) header('Cache-Control: no-cache, must-revalidate');
	
	echo $string;
	
	if(!$isFile) @ unlink( $file );
}




function folder_get_folders( $folder, $appendPath = false, $realPath = false, $pregMatch = null ) {
	
	@ include_once( dirname(__FILE__) . '/strings.php' );
	
	$folder = str_remove_sufix( $folder, array('\\', '/') );
	
	$dirResource = opendir( $folder );
	$folders = array();
	$absolutePath = realpath( $folder );
	
	if( $appendPath ) {
		
		if( !$realPath ) $prefixString = "$folder/";
		else $prefixString = realpath( $folder ) . '/';
						
	} else $prefixString = '';
	
	
	while( $element = readdir( $dirResource ) )
	
		if( $element != '.' && $element != '..' && is_dir( "$absolutePath/$element" ) && ( $pregMatch == null || preg_match( $pregMatch, $element ) ) ) 
		
			$folders[] = $prefixString . $element;
			
			
			
		
	return $folders;
}


function folder_get_files( $folder, $appendPath = false, $realPath = false, $extensions = null, $pregMatch = null ) {
	
	
	@ include_once( dirname(__FILE__) . '/strings.php' );
	
	$folder = str_remove_sufix( $folder, array('\\', '/') );
	
	$dirResource = opendir( $folder );
	$files = array();
	$absolutePath = realpath( $folder );
	
	if( $appendPath ) {
		
		if( !$realPath ) $prefixString = "$folder/";
		else $prefixString = realpath( $folder ) . '/';
						
	} else $prefixString = '';
	
	
	if( $extensions != null ) {
		
		if( !is_array( $extensions ) ) $extensions = explode( ',', $extensions );
		
		foreach( $extensions as $i => $extension )
		
			$extensions[i] = str_put_prefix( $extension, '.' );
	}
		
	
	
	while( $element = readdir( $dirResource ) )
	
		if( $element != '.' && $element != '..' && is_file( "$absolutePath/$element" ) && ( $extensions == null || str_ends_with( $element, $extensions, false ) !== false ) && ( $pregMatch == null || preg_match( $pregMatch, $element ) ) ) 
		
			$files[] = $prefixString . $element;
			
			
			
		
	return $files;
}


//------------------------------------------ ?>