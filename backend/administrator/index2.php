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

  <link href="../includes/js/windows_js_1.3/themes/default.css" rel="stylesheet" type="text/css"/>	
  <link href="../includes/js/windows_js_1.3/themes/lighting.css" rel="stylesheet" type="text/css"/>
  <link href="../includes/js/windows_js_1.3/themes/mac_os_x.css" rel="stylesheet" type="text/css"/>
  <link href="../includes/css/pwc-os.css" rel="stylesheet" type="text/css"/>

  <script type="text/javascript" src="../includes/js/windows_js_1.3/javascripts/prototype.js"> </script>
  <script type="text/javascript" src="../includes/js/windows_js_1.3/javascripts/effects.js"> </script>
  <script type="text/javascript" src="../includes/js/windows_js_1.3/javascripts/window.js"> </script>
  <script type="text/javascript" src="../includes/js/windows_js_1.3/javascripts/window_effects.js"> </script>
  <script type="text/javascript" src="../includes/js/windows_js_1.3/javascripts/debug.js"> </script>
  <script type="text/javascript" src="../includes/js/pwc-os.js"> </script>
  
  
  <!-- datos para el menu-->

   <link rel="stylesheet" type="text/css" href="../includes/grillas/dhtmlxMenu/sources/skins/dhtmlxmenu_dhx_blue.css">
	<link rel="stylesheet" type="text/css" href="../includes/grillas/dhtmlxMenu/sources/skins/dhtmlxmenu_dhx_black.css">
	<script  src="../includes/grillas/dhtmlxMenu/sources/dhtmlxcommon.js"></script>
	<script  src="../includes/grillas/dhtmlxMenu/sources/dhtmlxmenu.js"></script>
  
	<title>TuboNor</title>
	
</head>

<body>

<center>
<div id="dock"> 
 <!-- <div id="theme"> 
    Estilos:
    <select>
      <option>Mac OS X</option>
      <option>Blue lighting</option>
      <option>Green lighting</option>
    </select>
  </div>    

  <div id="theme"> 
    Inicio:
    <select  onchange="abrirVentana(this);">
      <option value="0">Seleccionar</option>
      <option value="1">Articulos</option>
      <option value="2">Proveedores</option>
      <option value="3">Clientes</option>
    </select>
  </div>  -->
 
 <div id="theme"> 

 </div>
</div> 
</center>         


</body>
</html>

<script language="javascript">

function abrirVentana(Mensaje){
	
  
  
  if(Mensaje!='Salir'){
		  
  	
  	
  	if(Mensaje=='Listados'){
  	
  		
  		var win = new Window({className: "mac_os_x", 
		  blurClassName: "blur_os_x", 
		  title:'Listados', 
		  width:250, 
		  height:150, 
		  top: 150, left:150, 
		  url:'../Listados/ConfigurarListado.php',
		  showEffect:Element.show,hideEffect:Element.hide
		  }); 
		 // win.getContent().update("<h1> "+Mensaje+" </h1>");
		  win.setConstraint(true, {left:0, right:0, top: 30, bottom:0})
			  win.toFront();
		  win.show();  
  		
  			
  	} else{
  		  var win = new Window({className: "mac_os_x", 
		  blurClassName: "blur_os_x", 
		  title:Mensaje, 
		  width:250, 
		  height:150, 
		  top: 150, left:150, 
		  url:'../'+Mensaje+'/'+Mensaje+'.php',
		  showEffect:Element.show,hideEffect:Element.hide
		  }); 
		 // win.getContent().update("<h1> "+Mensaje+" </h1>");
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
	menu.addNewChild("Inicio", 1, "Listados", "Listados",false, "select_all.gif");
	menu.addNewChild("Inicio", 2, "Proveedores", "Proveedores",false, "per.ico");
	menu.addNewChild("Inicio", 3, "Clientes", "Clientes",false, "per.ico");
	menu.addNewChild("Inicio", 4, "Salir", "Salir",false, "close2.gif");
	
	
	//menu.addNewChild("Inicio", 5, "aSalir", "aSalir",false, "close2.gif");
	
	
	
	//menu.addNewSibling("Inicio", "edit", "Comparativa", false);
	
	menu.attachEvent("onClick", menuClick);
	
	function menuClick(id) {
		
     	abrirVentana(id);
		
		return true;
	}
	
   /*
	menu.addNewSibling(null, "file", "File", false);
		menu.addNewChild("file", 0, "file_new", "New", false, "new.gif");
		menu.setHotKey("file_new", "Ctrl+N");
		menu.addNewSeparator("file_new", "s1");
		menu.addNewChild("file", 2, "file_open", "Open", false);
		menu.setHotKey("file_open", "Ctrl+O");
		menu.addNewChild("file", 3, "file_save", "Save", false, "save.gif");
		menu.setHotKey("file_save", "Ctrl+S");
		menu.addNewChild("file", 4, "file_saveas", "Save As...", true);
		menu.addNewSeparator("file_saveas");
		menu.addNewChild("file", 6, "file_print", "Print", false, "print.gif");
		menu.setHotKey("file_print", "Ctrl+P");
		menu.addNewChild("file", 7, "file_page_setup", "Page Setup", true, null, "page_setup_dis.gif");
		menu.addNewSeparator("file_page_setup");
		menu.addNewChild("file", 9, "file_eol", "End Of Line", false);
			menu.addRadioButton("child", "file_eol", 0, "eol_unix", "Unix (\\n)", "eol", true, false);
			menu.addRadioButton("sibling", "eol_unix", null, "eol_doswin", "DOS/Windows (\\r\\n)", "eol", false, false);
			menu.addRadioButton("sibling", "eol_doswin", null, "eol_macos", "MacOS (\\r)", "eol", false, false);
		menu.addNewChild("file", 10, "file_syntax", "Syntax", false);
			menu.addRadioButton("child", "file_syntax", 0, "syntax_ignore", "Ignore", "syntax", true, true);
			menu.addNewSeparator("syntax_ignore");
			menu.addRadioButton("child", "file_syntax", 2, "syntax_htmljs", "HTML/JS", "syntax", false, false);
			menu.addRadioButton("child", "file_syntax", 3, "syntax_phpaspjsp", "PHP/ASP/JSP", "syntax", false, false);
			menu.addRadioButton("child", "file_syntax", 4, "syntax_java", "Java", "syntax", false, false);
		menu.addNewSeparator("file_syntax");
		menu.addNewChild("file", 12, "file_close", "Close", true);
		menu.setHotKey("file_close", "Ctrl+Q");
	menu.addNewSibling("file", "edit", "Edit", false);
		menu.addNewChild("edit", 0, "edit_undo", "Undo", false, "undo.gif");
		menu.setHotKey("edit_undo", "Ctrl+Z");
		menu.addNewSibling("edit_undo", "edit_redo", "Redo", false, "redo.gif");
		menu.setHotKey("edit_redo", "Ctrl+Y");
		menu.addNewSeparator("edit_redo", "sep_1");
		menu.addNewSibling("sep_1", "edit_select_all", "Select All", false, "select_all.gif");
		menu.setHotKey("edit_select_all", "Ctrl+A");
		menu.addNewSeparator("edit_select_all", "sep_2");
		menu.addNewSibling("sep_2", "edit_cut", "Cut", false, "cut.gif");
		menu.setHotKey("edit_cut", "Ctrl+X");
		menu.addNewSibling("edit_cut", "edit_copy", "Copy", false, "copy.gif");
		menu.setHotKey("edit_copy", "Ctrl+C");
		menu.addNewSibling("edit_copy", "edit_paste", "Paste", false, "paste.gif");
		menu.setHotKey("edit_paste", "Ctrl+V");
		menu.addNewSeparator("edit_paste", "sep_3");
		menu.addNewSibling("sep_3", "edit_features", "Features", false);
			menu.addCheckbox("child", "edit_features", 0, "ignore_case", "Ignore Case", true, false);
			menu.addCheckbox("sibling", "ignore_case", null, "multiselect", "Multiselect Support", false, false);
	menu.addNewSibling("edit", "help", "Help", false);
		menu.addNewChild("help", 0, "about", "About...");
		menu.setHotKey("about", "Ctrl+I");
		menu.addNewChild("help", 1, "help2", "Help");
		menu.setHotKey("help2", "F1");
		menu.addNewChild("help", 2, "bugrep", "Bug Reporting");
		menu.addNewSeparator("bugrep", "sep_help");
		menu.addCheckbox("sibling", "sep_help", null, "tip_of_the_day", "Tip of the Day", true, true);*/
</script>