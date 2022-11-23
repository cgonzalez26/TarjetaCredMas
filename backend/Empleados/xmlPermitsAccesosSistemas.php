<?php

	define( 'BASE' , dirname( __FILE__ ) . '/../..');

	include_once(  BASE . '/_global.php' );

	$idUser = $_SESSION['id_user'];
	
	
	function arrayPermits(){
		global $oMysql;
		$idUnidaNegocio = 4;
		$array = $oMysql->consultaSel("CALL usp_getObject(\"$idUnidaNegocio\");");
				
		if(!is_array($array)) $array = array();				
		
		$newRows = array();
		$keyTypeObject = 'sCodigoTipoObjeto';
		$keyObject = 'sCodigoObjeto';
		
		foreach ($array as $object) {			
			$LastTypeObject = $object[ $keyTypeObject ];
			$LastObject = $object[ $keyObject ];
			$newRows[ $LastTypeObject ][ $LastObject ][] =  $object ;					
		}
		return $newRows;	
		
	}
	
	function paint_xml($array,$id){
		global $oMysql;
		$body = "";
		
		$sPermisos=stringPermitsUser($id,4); //4- UnidadNegocio->Accesos Sistemas
		//var_export($sPermisos); die();
		$aPermisosActuales=explode(',',$sPermisos);
		$sCheck='';
		foreach ($array as $keyTypeObjetc => $object){
			print("<item id=\"userMenuLink_$keyTypeObjetc\" text=\"{$keyTypeObjetc}\" im0=\"\" im1=\"\" im2=\"\" open=\"1\" call=\"1\" select=\"1\">");		
			
			$i = 0;	
			foreach ($object as $keyObject => $values){
				$i++;
				$idItem = "userMenuLink_".$keyTypeObjetc."_".$keyObject;
				
				print("<item id=\"$idItem\" text=\"{$keyObject}\" im0=\"\" im1=\"\" im2=\"\" open=\"1\" call=\"1\" select=\"0\">");

				foreach ($values as $permit){
                     
					$idItem = "idPermitObject_".$permit['idPermisoObjeto'];
					//var_export($aPermisosActuales); die();
					//$sItem="'".$idItem."'";
                    if(in_array($idItem,$aPermisosActuales)) $sCheck='checked="1"';
                    else $sCheck='';
					print("<item id=\"$idItem\" text=\"{$permit['sNombreTipoPermiso']}\" im0=\"\" im1=\"\" im2=\"\" $sCheck/>");
				}


				print("</item>");
			}

			print("</item>");
		}		

	}	

	

if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
 		header("Content-type: application/xhtml+xml"); 
} else {
 		header("Content-type: text/xml");
}

echo("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n"); 
?>

<tree id="0">	
<?php 
	$array = arrayPermits();
	paint_xml($array,$_GET['id']);
?>
</tree>
<!-- close grid xml -->