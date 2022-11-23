<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');

	include_once(  BASE . '/_global.php' );

	error_reporting(E_ALL ^ E_NOTICE);

	function get_rows_from_DB($parent_id){
		
		global $oMysql;	
		
		$sub_query = " WHERE 1=1";
		
		$TasasIVA = $oMysql->consultaSel("CALL usp_getTasasIVA(\"$sub_query\");");
		
		if(!$TasasIVA){

		}else{
			foreach ($TasasIVA as $Tasa){				
				
				
				if($Tasa['sEstado'] == "B"){
					$style = "background:#E3C8F4;";
				}
				
				print("<row id='".$Tasa['id']."' style='$style'>");
					print("<cell><![CDATA[".stripslashes($Tasa['sNombre'])."]]></cell>");
					print("<cell><![CDATA[".stripslashes($Tasa['fTasa'])."]]></cell>");
					print("<cell><![CDATA[".stripslashes($Tasa['sDescripcion'])."]]></cell>");					
					print("<cell><![CDATA[".stripslashes($Tasa['sEstado'])."]]></cell>");
				print("</row>");
				//die();			
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