<?php
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$idUser = $_SESSION['id_user'];
$TypeUser = $_SESSION['id_tuser'];
$aParametros = array();
$aParametros = getParametrosBasicos(1);

global $oMysql;

$result = $oMysql->consultaSel("SELECT EstadosTarjetas.idEmpleado,EstadosTarjetas.idTipoEstadoTarjeta,TiposEstadosTarjetas.sNombre as 'sEstado', IFNULL(DATE_FORMAT(EstadosTarjetas.dFechaRegistro,'%d/%m/%Y  %H:%i'),'') as 'dFechaRegistro',EstadosTarjetas.sMotivo 
						FROM EstadosTarjetas
						LEFT JOIN TiposEstadosTarjetas ON TiposEstadosTarjetas.id = EstadosTarjetas.idTipoEstadoTarjeta
						WHERE EstadosTarjetas.idTarjeta={$_GET['id']} ORDER BY EstadosTarjetas.dFechaRegistro ASC");

$aEmpleado = array();
$sEmpleado = "";

$sCadena .= "<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='1' bordercolor='#000000' width='100%' >
	<tr class='filaPrincipal'>
		<th style='height:25px'>Estado</th>
		<th style='height:25px'>Fecha de Registro</th>
		<th style='height:25px'>Empleado</th>
		<th style='height:25px'>Motivos</th>
	</tr>";

	$sEmpleado = " - ";
	foreach ($result as $rs ){
		$sEmpleado = $oMysql->consultaSel("SELECT CONCAT(Empleados.sApellido,', ', Empleados.sNombre) as 'sEmpleado' FROM Empleados WHERE id={$rs['idEmpleado']}",true);
		$sCadena .= "
		<tr>
			<td width='25%' align='left'>&nbsp;{$rs['sEstado']}</td>
			<td width='20%' align='left'>&nbsp;{$rs['dFechaRegistro']}</td>
			<td width='25%' align='left'>&nbsp;{$sEmpleado}</td>
			<td width='30%' align='left'>&nbsp;{$rs['sMotivo']}</td>
		</tr>	
		";				
	}
$sCadena .="</tr></table>";
xhtmlHeaderPaginaGeneral($aParametros);
?>

<body style="background-color:#ffffff;">
<center>
	<!--<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div><br />-->
	<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='0' bordercolor='#000000' width='98%' >
	<tr>
		<td align="center" style="height:25px"><b>Historial de Estado de la Tarjeta</b></td>
	</tr>
	<tr>
		<td align="left" style="height:25px"><span style="">Nro. de Tarjeta :&nbsp;<? echo $_GET['sNumero']; ?></span></td>
	</tr>
	</table>
	<div style="overflow-y:auto;width:98%">
	<?
	echo $sCadena;
	?>
	</div>
</center>
</body>
</html>