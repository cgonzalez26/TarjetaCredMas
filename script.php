<?php
include_once('_global.php');
	
	
function leerExcell(){

	global $oMysql;
	
	$sArchivo="usuariosUp.xls";
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($sArchivo);
	$iNumFila=2;
	$aErrores=array();
	
	for ($i = $iNumFila; $i <= $data->sheets[0]['numRows']; $i++) {		
			$Cells_1=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][1]);
			$Cells_6=$oMysql->escaparCadena($data->sheets[0]['cells'][$i][6]);
			$oUser=new Usuario($Cells_1); 
			$oUser->setPermisosOperador('15,26');
			$aTabla[]=" <tr>
							<td>{$Cells_1}</td>
							<td>{$oUser->getNombre()}</td>
							<td>15,26</td>
						<tr/> ";		
	}
	
	if(count($aTabla) > 0){
		$sTabla="
		         <h4 style='font-family:'sans-serif';'>DATOS IMPORTADOS</h4> 
		         <table class='formulario' width='100%' rules=all>
		         <thead>
		         <th>id_user</th>
		         <th>usuario</th>
		         <th>Permisos</th>
				 </thead>
		         <tbody id='CuerpoTabla'>  ";
	
		$sTabla.=implode('',$aTabla);
		$sTabla.="</tbody></table>";
	}
	echo $sTabla;
} 

//leerExcell();
?>