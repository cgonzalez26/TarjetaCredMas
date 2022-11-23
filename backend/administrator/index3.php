<?

	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
	
	#Control de Acceso al archivo
	#if(!isLogin()){go_url("../index.php");}
	
	$idUser = $_SESSION['ID_USER'];
	
	$boolean = securityAcces('home');
	
	if( $boolean <= 0 || !isLogin()){ go_url(BASE_URL);	}
		
	$aParametros = array();
	
	//--------------Datos de Configuracion de la lista de usuarios---------------------//
	$aParametros = getParametrosBasicos(1);
	

	$Menu = new Menu($idUser);
	$Menu->setSector('home');

# ::: a partir de aqui se muestra el html de la PAG
/*
echo xhtmlHeaderPagina($aParametros);

echo xhtmlMainHeaderPagina($aParametros);

echo $Menu->xhtmlMenu();

echo xhtmlTituloSector("iconoUsuarios","Principal");

echo "<div style='height:150px;'>&nbsp;</div>";

echo xhtmlFootPagina();*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" version="-//W3C//DTD XHTML 1.1//EN" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />

  <link href="../includes/js/windows_js_1.3/themes/default.css" rel="stylesheet" type="text/css"></link>
  <link href="../includes/js/windows_js_1.3/themes/lighting.css" rel="stylesheet" type="text/css"></link>
  <link href="../includes/js/windows_js_1.3/themes/mac_os_x.css" rel="stylesheet" type="text/css"></link>
  <link href="../includes/js/windows_js_1.3/themes/alphacube.css" rel="stylesheet" type="text/css" >	 </link>
  <link href="../includes/js/windows_js_1.3/themes/debug.css" rel="stylesheet" type="text/css" >	 </link>
  <link href="../includes/js/windows_js_1.3/themes/darkX.css" rel="stylesheet" type="text/css" >	 </link>
  
  
  <link href="../includes/css/pwc-os.css" rel="stylesheet" type="text/css"></link>
  <link rel="stylesheet" type="text/css" href="../includes/grillas/dhtmlxMenu/sources/skins/dhtmlxmenu_dhx_blue.css"></link>
  <link rel="stylesheet" type="text/css" href="../includes/grillas/dhtmlxMenu/sources/skins/dhtmlxmenu_dhx_black.css"></link>
  <link rel="stylesheet" href="../includes/css/formularios.css" type="text/css"></link>
  <script type="text/javascript" src="../includes/js/windows_js_1.3/javascripts/prototype.js"> </script>
  <script type="text/javascript" src="../includes/js/windows_js_1.3/javascripts/effects.js"> </script>
  <script type="text/javascript" src="../includes/js/windows_js_1.3/javascripts/window.js"> </script>
  <script type="text/javascript" src="../includes/js/windows_js_1.3/javascripts/window_effects.js"> </script>
  <script type="text/javascript" src="../includes/js/windows_js_1.3/javascripts/debug.js"> </script>
  <script type="text/javascript" src="../includes/js/pwc-os.js"> </script>
  
  
  <!-- datos para el menu-->

	<script  src="../includes/grillas/dhtmlxMenu/sources/dhtmlxcommon.js"></script>
	<script  src="../includes/grillas/dhtmlxMenu/sources/dhtmlxmenu.js"></script>
  	
	<title>TuboNor</title>
	
</head>

<body>
<div id="dock"> <div id="theme"> </div></div>          
<center>
<div style=" z-index:16 !important; width:750px; height:280px;margin-top:210px;" align="center"> 
	<center>
	<table class="formulario" style="font-family:Tahoma;float:left;font-size:10pt;" align="center">
	<tr><th style="padding:50px;" >
	       <img src="../includes/images/Articulos.png" style="cursor:pointer;" onclick="abrirVentana('Articulos')">&nbsp;Articulos</th>
	    <th style="padding:50px; " >
	       <img src="../includes/images/Listado.png" style="cursor:pointer;" onclick="abrirVentana('Listados')">&nbsp;Listados</th><tr>
	
	
	<tr><th style="padding:50px;cursor:pointer;" >
	       <img src="../includes/images/Proveedores.png" style="cursor:pointer;" onclick="abrirVentana('Proveedores')">&nbsp;Proveedores </th>
	     <th style="padding:50px;cursor:pointer;">
	     <!--   <img src="../includes/images/Clientes.png" style="cursor:pointer;" >&nbsp;Clientes</th><tr>-->
	
	
	
	</table>
	</center>
</div> 
</center> 

</body>
</html>

<script language="javascript">

function abrirVentana(Mensaje){
	
  var Dire='';
  var Archivo='';
  
  if(Mensaje!='Salir'){
		  
  	
  	
  	if(Mensaje=='Listados'){
  	
  		
  		var win = new Window({className: "alphacube", 
		  //blurClassName: "blur_os_x", 
		  title:'<b>Listados</b>', 
		  width:750, 
		  height:420, 
		  top: 130, left:150, 
		  url:'../Listados/ConfigurarListado.php',
		  showEffect:Element.show,hideEffect:Element.hide
		  }); 
		 // win.getContent().update("<h1> "+Mensaje+" </h1>");
		  win.setConstraint(true, {left:0, right:0, top: 30, bottom:0})
			  win.toFront();
		  win.show();  
  		
  			
  	} else{
  		   
  		   switch(Mensaje)
		    {
		    	case 'Articulos':{
		    		              Dire='Articulos';
		    		              Archivo=Dire;
		    		              iAncho=950;
		    		              iAlto=400;
		    		              iTop=150;
		    		              iLeft=100;
		    	                  break;} 
		    	case 'Proveedores':{
		    		               Dire='Proveedores';
		    		               Archivo=Dire;
		    		               iAncho=745;
		    		               iAlto=400;
		    		               iTop=150;
		    		               iLeft=150;
		    	                  break;}
		    	case 'Clientes':{
		    		               Dire='Clientes';
		    		               Archivo=Dire; 
		    		               iAncho=250;
		    		               iAlto=150;
		    		               iTop=150;
		    		               iLeft=150;
		    	                  break;}
		    	case 'Administrar':{
		    		               Dire='Articulos';
		    		               Archivo=Dire; 
		    		               iAncho=500;
		    		               iAlto=400;
		    		               iTop=150;
		    		               iLeft=150;
		    	                  break;}         
		    	case 'Importar':{
		    		               Dire='Importar';
		    		               Archivo=Dire; 
		    		               iAncho=500;
		    		               iAlto=400;
		    		               iTop=150;
		    		               iLeft=150;
		    	                  break;}        
		    	case 'Exportar':{
		    		               Dire='Exportar';
		    		               Archivo=Dire; 
		    		               iAncho=500;
		    		               iAlto=400;
		    		               iTop=150;
		    		               iLeft=150;
		    	                  break;}                   
		    	                  
		    	
		    }
  		
  		   
  		  var win = new Window({className: "alphacube", 
		  //blurClassName: "blur_os_x", 
		  title:'<b>'+Mensaje+'</b>', 
		  width:iAncho, 
		  height:iAlto, 
		  top:iTop, left:iLeft, 
		  url:'../'+Dire+'/'+Archivo+'.php',
		  showEffect:Element.show,hideEffect:Element.hide
		  }); 
		 
		  win.setConstraint(true, {left:0, right:0, top: 30, bottom:0})
			  win.toFront();
		  win.show();  
		  
		  
  	}	  
		  
		  
  }else
  {
  	
  	window.location.href="<?php echo BASE_URL?>/logout.php";
  	
  } 
  
  
}


//se define el menu 

    var menu = new dhtmlXMenuObject("theme");//,'dhx_black'
	menu.setImagePath("../includes/grillas/dhtmlxMenu/sources/imgs/");
	menu.setIconsPath("../includes/grillas/dhtmlxMenu/sources/images/");
	
	menu.addNewSibling(null, "Inicio", "Inicio", false,"system.gif");
	
	
	menu.addNewChild("Inicio", 0, "Articulos", "Articulos", false, "new.gif");
	menu.addNewSeparator("Articulos", "s1");
	menu.addNewChild("Articulos", 0, "Administrar", "Administrar", false, "new.gif");
	menu.addNewChild("Articulos", 1, "Importar", "Importar", false);
	menu.addNewChild("Articulos", 2, "Exportar", "Exportar", false);
	//	menu.addNewChild("Exportar", 1, "aa", "aa", false);
	menu.addNewChild("Inicio", 1, "Listados", "Listados",false, "select_all.gif");
	menu.addNewChild("Inicio", 2, "Proveedores", "Proveedores",false, "per.ico");
	//menu.addNewChild("Inicio", 3, "Clientes", "Clientes",false, "per.ico");
	menu.addNewChild("Inicio", 4, "Salir", "Salir",false, "close2.gif");
	
	
	//menu.addNewChild("Inicio", 5, "aSalir", "aSalir",false, "close2.gif");
	
	
	
	//menu.addNewSibling("Inicio", "edit", "Comparativa", false);
	
	menu.attachEvent("onClick", menuClick);
	
	function menuClick(id) {
		
     	abrirVentana(id);
		
		return true;
	}
	
  
</script>