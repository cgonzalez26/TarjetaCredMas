<?php

	include_once('_global.php');	
	echo "antes";
	$oMysql = new MySQL();
	echo "despues";
	if($_GET['_ab'] == 'debug'){
		echo "entro";
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

		foreach($row as $rows){

			$ProductosId = $row['ProductosId'];
			
			if($row['ProductosImagen_GXI'] != ''){
				$NombreImagen = str_replace('gxdbfile:','',$row['ProductosImagen_GXI']);
				$NombreImagen = Trim($NombreImagen);
				$ExtensionImagen = substr($row['ProductosImagen_GXI'], -4);
				$ExtensionImagen = Trim($ExtensionImagen = );			
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
			
			$values = "'{$row['ProductosId']}',
				'{$row['ProductosDescripcion']}',
				'{$row['ProductosDescripcionCorta']}',
				'{$row['ProductosDatosTecnicos']}',
				'{$row['ProductosCodigo']}',
				'{$row['ProductosCodigoBarra']}',
				'{$row['ProductosNumeroParte']}',
				'{$row['ProductosUnidadMedida']}',
				'{$row['ProductosTipo']}',
				'{$row['MarcasId']}',
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

			/*Inserto Ahora Estos Datos*/

			//$SQL = "UPDATE Productos SET ProductosNombreImagen='$NombreImagen',ProductosExtensionImagen='$ExtensionImagen' WHERE ProductosId = '$ProductosId';";
			$SQL = "INSERT INTO productos2($set) values($values); <br />";
			vae_export($SQL);
			//$rs = $oMysql->query($SQL);
		}

		echo "se termino de ejecutar el script";
	
	}

?>