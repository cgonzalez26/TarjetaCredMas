<?php
	include_once("_global.php");
	session_start();
	/*
	$sSession=session_id();
	
	$sConsulta2= " CALL usp_SessionEmpleado('{$_SESSION['id_user']}','0','0','0','0','0','0','2'); ";
	$oMysql->consultaSel($sConsulta2);	
	
	$sConsulta = " CALL usp_SessionEmpleado('{$_SESSION['id_user']}','0','0','0','0','0','0','1'); ";
	$oMysql->consultaSel($sConsulta);	*/
	
	
	
	unset($_SESSION);
	
	
	$_SESSION = array();
	session_destroy();	
	//mysql_session_destroy(session_id());
	
	
	go_url();

?>