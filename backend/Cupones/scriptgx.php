<?php

	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	
	$oMysql = new MySQL();
	
	if($_GET['_ab'] == 'debug'){
		echo "inicio de proceso de copiado de tabla de productos <br />";
		$SQL = "
			SELECT
				ProductosId,
				ProductosDescripcion,
				ProductosDescripcionCorta,
				ProductosDatosTecnicos,
				ProductosCodigo,
				ProductosCodigoBarra,
				ProductosNumeroParte,
				ProductosUnidadMedida,
				ProductosTipo,
				MarcasId,
				SubRubrosId,
				SeccionesId,
				ProductosSerializable,
				ProductosCantidadPorBulto,
				IvasId,
				ProductosStockMinimo,
				ProductosStockMaximo,
				ProductosGastosExtras,
				ProductosUtilidad,
				ProductosDescuento,
				ProductosEstado,
				ProductosCritico,
				ProductosGarantia,
				ProductosObservaciones,
				ProductosFechaRegistro,
				STProdUsuariosSessionesId,
				ProductosPrecioCosto,
				ProductosStockInicial,
				ProductosStock,
				ProductosCatalogoTenelo,
				ProductosCotizacionDolar,
				ProductosImagen_GXI
			FROM
				Productos ;
		
		";
	

		//&SQL = "SELECT ProductosId, ProductosImagen_GXI FROM productos WHERE ProductosImagen_GXI <> '' AND ProductosImagen_GXI IS NOT NULL;";	

		$rows = $oMysql->query($SQL);
		$i = 0;
		foreach($rows as $row){
			//var_export($row);die();
			$i = $i + 1;
			$ProductosId = $row['ProductosId'];
			$NombreImagen = "";
            $ExtensionImagen = "";			
			if($row['ProductosImagen_GXI'] != '' OR !is_null($row['ProductosImagen_GXI'])){
				$NombreImagen = str_replace('gxdbfile:','',$row['ProductosImagen_GXI']);
				$NombreImagen = Trim($NombreImagen);
				$ExtensionImagen = substr($row['ProductosImagen_GXI'], -4);
				$ExtensionImagen = Trim($ExtensionImagen);			
			}			

			
			if($row['ProductosStockInicial'] != '' OR is_null($row['ProductosStockInicial'])){
				$row['ProductosStockInicial'] = 0;
			}			
			
			$set = "ProductosId,
				ProductosDescripcion,
				ProductosDescripcionCorta,
				ProductosDatosTecnicos,
				ProductosCodigo,
				ProductosCodigoBarra,
				ProductosNumeroParte,
				ProductosUnidadMedida,
				ProductosTipo,
				MarcasId,
				SubRubrosId,
				SeccionesId,
				ProductosSerializable,
				ProductosCantidadPorBulto,
				IvasId,
				ProductosStockMinimo,
				ProductosStockMaximo,
				ProductosGastosExtras,
				ProductosUtilidad,
				ProductosDescuento,
				ProductosEstado,
				ProductosCritico,
				ProductosGarantia,
				ProductosObservaciones,
				ProductosFechaRegistro,
				STProdUsuariosSessionesId,
				ProductosPrecioCosto,
				ProductosStockInicial,
				ProductosStock,
				ProductosCatalogoTenelo,
				ProductosCotizacionDolar,
				ProductosNombreImagen,
				ProductosExtensionImagen,
				ProductosFechaUltimoMovimiento";
			if($row['MarcasId'] == '' OR is_null($row['MarcasId'])){
			$values = "'{$row['ProductosId']}',
				'{$row['ProductosDescripcion']}',
				'{$row['ProductosDescripcionCorta']}',
				'{$row['ProductosDatosTecnicos']}',
				'{$row['ProductosCodigo']}',
				'{$row['ProductosCodigoBarra']}',
				'{$row['ProductosNumeroParte']}',
				'{$row['ProductosUnidadMedida']}',
				'{$row['ProductosTipo']}',
				null,
				'{$row['SubRubrosId']}',
				'{$row['SeccionesId']}',
				'{$row['ProductosSerializable']}',
				'{$row['ProductosCantidadPorBulto']}',
				'{$row['IvasId']}',
				'{$row['ProductosStockMinimo']}',
				'{$row['ProductosStockMaximo']}',
				'{$row['ProductosGastosExtras']}',
				'{$row['ProductosUtilidad']}',
				'{$row['ProductosDescuento']}',
				'{$row['ProductosEstado']}',
				'{$row['ProductosCritico']}',
				'{$row['ProductosGarantia']}',
				'{$row['ProductosObservaciones']}',
				'{$row['ProductosFechaRegistro']}',
				'{$row['STProdUsuariosSessionesId']}',
				'{$row['ProductosPrecioCosto']}',
				'{$row['ProductosStockInicial']}',
				'{$row['ProductosStock']}',
				'{$row['ProductosCatalogoTenelo']}',
				'{$row['ProductosCotizacionDolar']}',
				'{$NombreImagen}',
				'{$ExtensionImagen}',
				'2013-11-01'";				
			}else{
			$values = "'{$row['ProductosId']}',
				'{$row['ProductosDescripcion']}',
				'{$row['ProductosDescripcionCorta']}',
				'{$row['ProductosDatosTecnicos']}',
				'{$row['ProductosCodigo']}',
				'{$row['ProductosCodigoBarra']}',
				'{$row['ProductosNumeroParte']}',
				'{$row['ProductosUnidadMedida']}',
				'{$row['ProductosTipo']}',
				{$row['MarcasId']},
				'{$row['SubRubrosId']}',
				'{$row['SeccionesId']}',
				'{$row['ProductosSerializable']}',
				'{$row['ProductosCantidadPorBulto']}',
				'{$row['IvasId']}',
				'{$row['ProductosStockMinimo']}',
				'{$row['ProductosStockMaximo']}',
				'{$row['ProductosGastosExtras']}',
				'{$row['ProductosUtilidad']}',
				'{$row['ProductosDescuento']}',
				'{$row['ProductosEstado']}',
				'{$row['ProductosCritico']}',
				'{$row['ProductosGarantia']}',
				'{$row['ProductosObservaciones']}',
				'{$row['ProductosFechaRegistro']}',
				'{$row['STProdUsuariosSessionesId']}',
				'{$row['ProductosPrecioCosto']}',
				'{$row['ProductosStockInicial']}',
				'{$row['ProductosStock']}',
				'{$row['ProductosCatalogoTenelo']}',
				'{$row['ProductosCotizacionDolar']}',
				'{$NombreImagen}',
				'{$ExtensionImagen}',
				'2013-11-01'";			
			}
			
			//$values = $oMysql->escapeString($values);

			/*Inserto Ahora Estos Datos*/

			//$SQL = "UPDATE Productos SET ProductosNombreImagen='$NombreImagen',ProductosExtensionImagen='$ExtensionImagen' WHERE ProductosId = '$ProductosId';";
			$SQL = "INSERT INTO productos2($set) values($values);";
			
			$rs = $oMysql->query($SQL);
		}

		echo "se termino de ejecutar el script, Productos : ".$i." encontrados";
	
	}

?>