<?php

final class Menu{
	
	private $idUser = 0;
	private $idTipoUser = 0;
	private $aMenu = array();	
	
	
	public function __construct($idUsuario,$idTipoUser){
		if($idUsuario <= 0 || is_null($idUsuario)) return ;
		//if($idTipoUser <= 0 || is_null($idTipoUser)) return ;
		
		$this->idUser = $idUsuario;		
		$this->idTipoUser = $idTipoUser;		
	}
	
	public function ButtonHeaderMenu(){
		
		$oBtnHeader = new aToolBar();
		$oBtnHeader->setAnchoBotonera('auto');
		$oBtnHeader->addBoton("idBtnExit","onclick","alert('hola mundo');","Salir",false,false,false,false,"#FFFFFF");		
		$oBtnHeader->addBoton("idBtnExit","onclick","exitSesion();","Salir",false,false,false,false,"#FFFFFF");		
		
		return $oBtnHeader->getBotoneraToolBar('L');
		
	}	
	
	
	public function printMenu(){
		global $oMysql;
		
				
		//var_export($array); die();
		$scriptToTopMenu = "";
		$MenuToOpen = "";
		$sDiv = "";
		$optionTocase = "";
		
		$arrayUnidades = $this->getUnidadesNegociosUser();
		$i = 0;		
		$scriptMenu2 = "";
		$scriptMenu = false;
		$scriptMenu5 = "";
		//var_export($arrayUnidades);die();
		foreach ($arrayUnidades as $key => $elements){
			
			$i = $i + 1;
			$scriptToTopMenu .= "
					dhxAccord.addItem(\"b$i\", \"$key\");
					dhxAccord.cells(\"b$i\").attachObject(\"div_$key\");
				   ";
			if($i == 1)
				$MenuToOpen .= " dhxAccord.cells(\"b$i\").open(); ";
			
			$sCadenaMenu = "<ul>";
			$sCadenaMenu .= "<li><a href='#' >Menu</a></ul>";
			
			$sHost = $elements[0]['sHost'];
			
			$sUrl = "";
			
			switch ($elements[0]['CODE']){
				case 1:{
					$sUrl .= "../../../SEAL/backend/";
					break;
				}
				case 2:{
					//$sUrl .= "../../../Tarjeta/backend/";
					$sUrl .= "../";
					break;
				}
				case 4:{
					$sUrl .= "../";
					break;
				}
				case 5:{
					$sUrl .= "../../../GaLogistica/backend/";
					break;					
				}
			}
			
			
			$array = $this->getObjectUser(false, $elements[0]['CODE']);
			$sCadenaMenu='';
			switch ($elements[0]['CODE']) {
				case 1:
					$sCadenaMenu="<div id='drillcrumb' style='width:250px;' ></div> <div id='drillmenu1' class='drillmenu' style='overflow-y: auto;'> <ul>";
					break;			
				case 2:{
					$sCadenaMenu="<div id='drillcrumb2' style='width:250px;' ></div> <div id='drillmenu2' class='drillmenu' style='overflow-y: scroll;'> <ul>";
					$scriptMenu2 .= " var mymenu=new drilldownmenu({
						menuid: 'drillmenu2',
						menuheight: '380',
						breadcrumbid: 'drillcrumb2',
						persist: {enable: true, overrideselectedul: true}
				   });";
				}
					break;
				case 3:
					$sCadenaMenu="<div id='drillcrumb' style='width:250px;' ></div> <div id='drillmenu1' class='drillmenu' style='overflow-y: auto;'> <ul>";
					break;			
				case 4:
					$sCadenaMenu="<div id='drillcrumb' style='width:250px;' ></div> <div id='drillmenu1' class='drillmenu' style='overflow-y: auto;'> <ul>";
					break;		
				case 5:{
					$sCadenaMenu="<div id='drillcrumb3' style='width:250px;' ></div> <div id='drillmenu3' class='drillmenu' style='overflow-y: auto;'> <ul>";
					$scriptMenu2 .= " var mymenu=new drilldownmenu({
						menuid: 'drillmenu3',
						menuheight: '380',
						menuheight: '380',
						breadcrumbid: 'drillcrumb3',
						persist: {enable: true, overrideselectedul: true}
				   });";
				   break;
				}		
			}
			
			if($elements[0]['CODE'] != 2 && $elements[0]['CODE'] != 5){
				$scriptMenu	= true;
			}
			
			foreach ($array as  $aDatos){
				
				
				$sIdSesion=session_id();//serialize(base64_encode(session_id()));
				$sIdSesion=base64_encode(session_id());
				$aDatos['URL'] = $sUrl.$aDatos['URL']."?oIa_=".$sIdSesion."&id=".$_SESSION['id_user'];	
				
				
				$aNivel1=$this->getObjectUser($aDatos['CODE'], $elements[0]['CODE']);
				$iLenght=count($aNivel1);
				if($iLenght == 0){
					$sCadenaMenu.="<li><a href='#' onClick='includeFile({$aDatos['CODE']});' >{$aDatos['TEXT']}</a></li>";	
					$optionTocase .= $this->JavascriptToFile($aDatos['CODE'],"{$aDatos['URL']}");
				}else{
					//$aNivel1
					$sCadenaMenu.="<li><a href='#' >{$aDatos['TEXT']}</a><ul>";
				    foreach ($aNivel1 as $aEle){ 
				    	$aNivel2=$this->getObjectUser($aEle['CODE'], $elements[0]['CODE']);
				    	$iLenght2=count($aNivel2);
						$aEle['URL'] =  $sUrl.$aEle['URL']."?oIa_=".$sIdSesion."&id=".$_SESSION['id_user'];						    	
						if($iLenght2 == 0){
					    	$sCadenaMenu.="<li><a href='#' onClick='includeFile({$aEle['CODE']});' >{$aEle['TEXT']}</a>";
					        $optionTocase .= $this->JavascriptToFile($aEle['CODE'],"{$aEle['URL']}");	
						}else{
							$sCadenaMenu.="<li><a href='#' >{$aEle['TEXT']}</a><ul>";
				    		foreach ($aNivel2 as $aEle2){ 
				    			$aEle2['URL'] =  $sUrl.$aEle2['URL']."?oIa_=".$sIdSesion."&id=".$_SESSION['id_user'];	
				    			$sCadenaMenu.="<li><a href='#' onClick='includeFile({$aEle2['CODE']});' >".html_entity_decode($aEle2['TEXT'])."</a>";
					        	$optionTocase .= $this->JavascriptToFile($aEle2['CODE'],"{$aEle2['URL']}");
				    		}		
				    		 $sCadenaMenu.="</ul></li>";		    		
						}
						
				    }               
				    $sCadenaMenu.="</ul></li>";	
				}
			}
			$sCadenaMenu.="</ul><br style='clear: left' /></div>";
			
			$sDiv .= "<div id=\"div_$key\" style=\"overflow-x:hidden;overflow-y:scroll;height:100%;font-weight:bold;background-color:#EDF7F9;\">"; /* blue #EDF7F9*/
			$sDiv .= $sCadenaMenu."<div class=\"salto\"></div>";	
			$sDiv .= "</div>";	
			
		}
		//var_export($sDiv); die();
		
		/*$sDiv .= "<div id=\"div_seguro\" style='overflow-x: hidden;overflow-y: scroll;height:100%;font-weight:bold;'>";
		$sDiv .= $sCadenaMenu;
		$sDiv .= "</div>";	*/
		
		//var_export($sDiv);die();
		//$buttonHeader = $this->ButtonHeaderMenu();
		$sLogin=strtoupper($_SESSION['login']);
		//$buttonHeader = "<a href='javascript:irHome();' style='color:#055A78;'><img src='".IMAGES_DIR."\/home.png' alt='' title='Salir' align='absmiddle'>$sLogin</a>&nbsp;<a href='javascript:exitSesion();' style='color:#055A78;'><img src='".IMAGES_DIR."\/close2.gif' alt='' title='Salir' align='absmiddle'>Salir</a>";
		$buttonHeader = "<a href='javascript:irHome();' style='color:#055A78;'><img src='".IMAGES_DIR."\/home.png' alt='' title='Salir' align='absmiddle'>$sLogin</a>&nbsp;<a href='javascript:exitSesion();' style='color:#055A78;;'><img src='".IMAGES_DIR."\/close2.gif' alt='' title='Salir' align='absmiddle'>Salir</a>";
		
		
		$sIdSesion=session_id();
		$sIdSesion=base64_encode(session_id());
		$aParametro['_SESSION_CADENA_']=$sIdSesion;
		$aParametro['_SESSION_ID_']=$_SESSION['id_user'];
		
		
		
		$aParametro['_OPCIONES_BUSQUEDA_']="
				        <option value='1'> Nº Poliza</option>
						<option value='2' > Documento </option>
						<option value='3' selected> Dominio </option>
						<option value='4'> Apellido </option>
						<option value='5'> Nombre </option>
						<option value='6'> Carta Cobertura </option>
						<option value='8'> Nº Cuenta </option>
		";
		
		if(in_array($_SESSION['id_user'],array(296,1))){
			$aParametro['_OPCIONES_BUSQUEDA_'].="<option value='7'> id poliza </option>";
		}

		$sBuscador='';//parserTemplate(TEMPLATES_XHTML_DIR.'/Modulos/BuscadorCall/BuscadorCall.tpl',$aParametro);
		//$sBuscador=parserTemplate('../../../CPanelT/backend/includes/templates/xhtml/Modulos/BuscadorCall/BuscadorCall.tpl');
		
		$sBotoneraSuperior="";
	
			//$oBtnBusqueda=new aToolBar();
			/*$iResponsableRegion = $oMysql->consultaSel("SELECT count(galogistica.Responsables.id) FROM galogistica.Responsables WHERE galogistica.Responsables.idResponsable={$_SESSION['id_user']}",true);			
			if($iResponsableRegion > 0){			
				$oBtnBusqueda->addBoton("Document","onclick","_popinREQUERIMIENTOS();",'Document','Requerimientos',true,false,false,"#fff;");				
			}else{*/
				//if($_SESSION['ID_OFICINA']==1)
			//$oBtnBusqueda->addBoton("Document","onclick","_popinREQUERIMIENTOS();",'Document','Requerimientos',true,false,false,"#fff;");			
			//}
			
			//if(in_array($_SESSION['id_user'],array(296,326))){
				//$oBtnBusqueda->addBoton("AccesoGeneral","onclick","AccesoGral()",'GrupoUsuarios','Acceso General',true,false,false,"#fff;");	
				//$iGriva=1;
			//}
			/*elseif($_SESSION['AANTERIOR']==1) { 
		    	  $oBtnBusqueda->addBoton("AccesoGeneral","onclick","AccesoGral()",'GrupoUsuarios','Acceso General',true,false,false,"#fff;");	
		    	  $iGriva=1;
			}*/
			
			//if(in_array($_SESSION['id_user'],array(296,326,1))) 
			//$oBtnBusqueda->addBoton("Circulares","onclick","_popinCIRCULARES();",'Circular','Circulares',true,false,false,"#fff;");	
			
			//$oBtnBusqueda->addBoton("Mail","onclick","top.$sFuncionMail",'Email','Mail',true,false,false,"#fff;");	
			
			//$oBtnBusqueda->addBoton("Descargar","onclick","_verDescargas();",'Descargar','Descargar',true,false,false,"#fff;");	
			
			
			
			//$sBotoneraSuperior=$oBtnBusqueda->getBotoneraToolBar('R');
			$sBotoneraSuperior='';
		
		
		$string = "
				$sDiv
				<div id=\"idOculto\">
                         $sBuscador
				</div>
				<div id=\"idBanner\">
                    <div id=\"idLogo\"></div> <div id=\"idMenuSuperior\">$sBotoneraSuperior</div>
				</div>
				<script type=\"text/javascript\"> "; 
		if($scriptMenu)		  
			$string .= " var mymenu=new drilldownmenu({
						menuid: 'drillmenu1',
						menuheight: '300',
						breadcrumbid: 'drillcrumb',
						persist: {enable: true, overrideselectedul: true}
				   })";
		$string .= "	
				   $scriptMenu2
				 
				   var idFrameCarga=''; 	
			       var dhxLayout = new dhtmlXLayoutObject(document.body,\"3T\",\"dhx_blue\");      
                   dhxLayout.cells(\"a\").setText(\"\");
				   dhxLayout.cells(\"a\").hideHeader();
			       dhxLayout.cells(\"a\").setHeight(85);
			       dhxLayout.cells(\"a\").fixSize(true,true);
			       dhxLayout.cells(\"a\").attachObject(\"idBanner\");
			       
				   dhxLayout.cells(\"b\").setWidth(270);
				   dhxLayout.cells(\"b\").setText(\"$buttonHeader\");
				  
				   dhxLayout.cells(\"c\").setText(\"\");
				   dhxLayout.cells(\"c\").hideHeader();


				   var cIzquierda = new dhtmlXLayoutObject(dhxLayout.cells(\"b\"),\"2E\",\"dhx_blue\");
				   cIzquierda.cells(\"a\").hideHeader();
				   cIzquierda.cells(\"a\").setHeight(480);
				   cIzquierda.cells(\"a\").fixSize(true,true);/*new*/
				   cIzquierda.cells(\"b\").hideHeader();
				   cIzquierda.cells(\"b\").setHeight(400);/*new*/

				   var dhxAccord = cIzquierda.cells(\"a\").attachAccordion();
					   
				

				   $scriptToTopMenu

				   $MenuToOpen
	
				
					
				    function includeFile(iNum){
				    	switch(iNum){
							$optionTocase
						}
				    }
				    
					//includeFile(26);
					
				    function exitSesion(){
				    	window.location.href=\"".BASE_URL."/logout.php\";
				    }
				    
				    function irHome(){
				    	includeFile(26);
				    }		

				    $sSetBridgeLink
		
				    
				    $sSetBridgeLink2
				     	
				    
				    function AccesoGral(){
				       sUrl='BlockUsuario.php?Do=xajax_AccederUsuario';
					   displayMessage(sUrl,300,160);
				    }
				    
				    function _popinCIRCULARES(){
				       url = '../Circulares/WindowCirculares.php';
					   displayMessage(url,900,450);
				    }
				    
				    function _verDescargas(){
				      idFrameCarga = dhxLayout.cells(\"c\").attachURL(\"../../../SEAL/backend/Descargas/Descargas.php\");
				    }
				    
					function solicitarRequerimiento(){
				    	
					    createWindows('../SolicitudesMateriales/AdminSolicitudesMateriales.php','Requerimientos',920, 620);
				    }		
				    									    
					var dhxWinsAccesos;
					function createWindows(sUrl,sTitulo,width,height){
					    var idWind = 'window_solicitud';
						//if(!dhxWins.window(idWind)){
					     	dhxWinsAccesos = new dhtmlXWindows();     	
						    dhxWinsAccesos.setImagePath('../includes/grillas/dhtmlxWindows/sources/imgs/');	  
						    _popup_ = dhxWinsAccesos.createWindow(idWind, 250, 50, width, height);
						    _popup_.setText(sTitulo);
						    ///_popup_.center();
						    _popup_.button('close').attachEvent('onClick', closeWindows);
							_url_ = sUrl;
						    _popup_.attachURL(_url_);
						//}
					} 
					
					function closeWindows(_popup_){
						_popup_.close();
					} 	
					
					function __closeWindows()
					{
						var isWin = dhxWinsAccesos.isWindow('window_solicitud');
		  
						if(isWin){
						 	dhxWinsAccesos.window('window_solicitud').close(); 	
						}	
					}	
					
					function _popinREQUERIMIENTOS(){
					    //displayMessage(url,900,450);
				  		url = '../SolicitudesMateriales/WindowRequerimientos.php'; 	
				  		top.getVentanaPop(url,'Requerimientos',640,940,'Requerimientos');					  		
					    //createWindows(url,'Requerimientos',940, 640);
					}	
					
					function _popinREQUERIMIENTOS_COMPRRAS(){
						url = '../SolicitudesCompras/SolicitudesCompras.php';
						createWindows(url,'Requerimientos',940, 640);
					}				
				</script>
			 ";			
		return $string;
	}
	
	private function getUnidadesNegociosUser($id=false){
		global $oMysql;
		
		if(!$id) $id=0;
		$sCond=" Empleados.id= {$this->idUser}";
		$sConsulta="CALL usp_getPermisosUnidadesNegocios(\"$sCond\");";
		//var_export($sConsulta);die();
		$array = $oMysql->consultaSel($sConsulta);	
		if(!is_array($array)) $array = array();
		
		$newRows = array();
		$key = 'UNIT_NAME';
		
		foreach( $array as $row ) {			
				
			$keyData = $row[ $key ];
			unset( $row[ $key ] );
			if($keyData != '' && !is_null($keyData)){
				$newRows[ $keyData ][] =  $row ;	
			}							
		}
		
		//var_export($newRows); die();
		return $newRows;	
					
	}
	
	private function getObjectUser($id=false, $idUnidadNegocio=false){
		global $oMysql;
		
		if(!$id) $id=0;
		
		$sCond=" EmpleadosUnidadesNegocios.idEmpleado= {$this->idUser} AND Objetos.iOrder= {$id} AND PermisosObjetosEmpleados.idUnidadNegocio={$idUnidadNegocio} AND Objetos.bItemVisible = 1";
		
		$sConsulta="CALL usp_getObjectUser(\"$sCond\");";
		//var_export($sConsulta);die();
		$array = $oMysql->consultaSel($sConsulta);
	
		if(!is_array($array)) $array = array();
		
		/*
		$newRows = array();
		
		$key = 'TYPE_OBJECT';
		
		foreach( $array as $row ) {			
				
			$keyData = $row[ $key ];
			unset( $row[ $key ] );
			
			if($keyData != '' && !is_null($keyData)){
				$newRows[ $keyData ][] =  $row ;	
			}			
		}*/
		
		$newRows=$array;
		
		return $newRows;		
		
	}

	public function JavascriptToFile($option,$url){

		
		$js = " case $option:{idFrameCarga = dhxLayout.cells(\"c\").attachURL(\"$url\");break;} ";
		//$js = " case $option:{idFrameCarga = dhxLayout.cells(\"c\").attachURL(\"../$url\");break;} ";
		
		return $js;
		
	}	

	
}
?>