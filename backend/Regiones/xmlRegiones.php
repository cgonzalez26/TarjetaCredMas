<?php

	define( 'BASE' , dirname( __FILE__ ) . '/../..');

	include_once(  BASE . '/_global.php' );

	error_reporting(E_ALL ^ E_NOTICE);

	function get_rows_from_DB($parent_id){
		
		global $oMysql;	
		
		$sub_query = " WHERE 1=1";
		
		$areas = $oMysql->consultaSel("CALL usp_getRegiones(\"$sub_query\");");
		
		if(!$areas){

		}else{
			foreach ($areas as $area){				
				
				if($area['sEstado'] == "B"){
					$style = "background:#E3C8F4;";
				}
				
				print("<row id='".$area['id']."' style=\"$style\">");
				  print("<cell><![CDATA[".stripslashes($area['sNombre'])."]]></cell>");
				  print("<cell><![CDATA[".stripslashes($area['sNumero'])."]]></cell>");
				  print("<cell><![CDATA[".stripslashes($area['sEstado'])."]]></cell>");
				print("</row>");			
				
			}
		}
		
	}


if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
 		header("Content-type: application/xhtml+xml"); } else {
 		header("Content-type: text/xml");
}
echo("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n"); 
?>

<!-- start grid xml -->
<rows id="0">
	
<?php 
	get_rows_from_DB(0);
?>

</rows>
<!-- close grid xml -->