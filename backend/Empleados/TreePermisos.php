<?php 
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$idUser = $_SESSION['id_user'];
$TypeUser = $_SESSION['id_tuser'];
$aParametros = array();
$aParametros = getParametrosBasicos(1);

$oXajax=new xajax();
$oXajax->registerFunction("updatePermisosUser");
$oXajax->processRequest();
$oXajax->printJavascript( "../includes/xajax/");

$aParametros['DHTMLX_TREE']=1;

$idUsuario=$_GET['id'];
//$sPermisos=stringPermitsUser($idUsuario,1);
//$sPermisosAccesos=stringPermitsUser($idUsuario,4);
//$sPermisosLogistica=stringPermitsUser($idUsuario,5);

xhtmlHeaderPaginaGeneral($aParametros);	
?>
	<script type="text/javascript">
	$(document).ready(function() {
		//When page loads...
		$(".tab_content").hide(); //Hide all content
		$("ul.tabs li.first").addClass("active").show(); //Activate first tab
		$(".tab_content:first").show(); //Show first tab content
	
		//On Click Event
		$("ul.tabs li").click(function() {
	
			$("ul.tabs li").removeClass("active"); //Remove any "active" class
			$(this).addClass("active"); //Add "active" class to selected tab
			$(".tab_content").hide(); //Hide all tab content
	
			var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
			//$(activeTab).fadeIn(); //Fade in the active ID content
			$(activeTab).show();
			return false;
		});
	});
	</script>
<body style="background-color:#ffffff;">
<div id="BodyTree" style="padding-left:20px;width:660px">
<center>
<form  method='POST' name='form' id='form'>
    <div style="width:450px;height:30px;font-family:Tahoma;font-weight:bold;font-size:8pt;text-align:left;" id="divMessageUser"></div>
	
	<input type="hidden" name="id" id="id" value="<?=$idUsuario?>"> 
	<input type="hidden" name="permitUser" id="permitUser" value=""> 
	<input type="hidden" name="permitUserAccesos" id="permitUserAccesos" value=""> 
	<input type="hidden" name="permitUserTarjeta" id="permitUserTarjeta" value=""> 
	<input type="hidden" name="permitUserLogistica" id="permitUserLogistica" value=""> 

	<ul class="tabs">
        <li class="active"><a href="#tab2">Tarjeta</a></li>
        <li><a href="#tab3">Accesos Sistemas</a></li>               
     </ul>
       
    <div class="tab_container">
        <div id="tab2" class="tab_content">  
        	<div id="treeboxbox_Tarjeta" style="width:450px;height:320px;border:1px solid #CCC;"></div>        
	    </div>
        <div id="tab3" class="tab_content">  
        	<div id="treeboxbox_AccesosSistemas" style="width:450px;height:320px;border:1px solid #CCC;"></div>
	    </div>
    </div>
    <div style="width:350px;text-align:center;"><button  type="button" onclick="sendFormUser();"> Guardar </button> </div>
</form>	
</center>
<script>

	function sendFormUser(){
		var Formu = document.forms['form'];					
		//Formu['permitUser'].value = tree.getAllChecked();
		Formu['permitUserAccesos'].value = treeAccesos.getAllChecked();
		Formu['permitUserTarjeta'].value = treeTarjeta.getAllChecked();
		//Formu['permitUserLogistica'].value = treeLogistica.getAllChecked();
		
		viewMessageLoad('divMessageUser');
		xajax_updatePermisosUser(xajax.getFormValues('form'));
	}
   
  
	/********** Permisos Accesos Sistemas **********/	  
	treeAccesos = new dhtmlXTreeObject("treeboxbox_AccesosSistemas","100%","100%",0);
	treeAccesos.setImagePath("../includes/grillas/dhtmlxTree/codebase/imgs/csh_bluebooks/");
	treeAccesos.enableCheckBoxes(1);
	treeAccesos.enableThreeStateCheckboxes(true);
	/*treeAccesos.loadXML("xmlPermitsAccesosSistemas.php?id="+<?=$idUsuario?>,closeAllRootsAccesos);*/		
	treeAccesos.loadXML("xmlPermitsAccesosSistemas.php?id="+<?=$idUsuario?>);		
	treeAccesos.enableTreeImages(false); 
	
	/********** Permisos Tarjeta **********/
	treeTarjeta = new dhtmlXTreeObject("treeboxbox_Tarjeta","100%","100%",0);
	treeTarjeta.setImagePath("../includes/grillas/dhtmlxTree/codebase/imgs/csh_bluebooks/");
	treeTarjeta.enableCheckBoxes(1);
	treeTarjeta.enableThreeStateCheckboxes(true);
	treeTarjeta.loadXML("xmlPermitsTarjeta.php?id="+<?=$idUsuario?>,closeAllRootsTarjeta);		
	treeTarjeta.enableTreeImages(false); 

    function DatosUserBasic(idUser,sPermits,sPermitsAccesos,sPermisosTarjeta,sPermisosLogistica){
    	alert("setear permisos");
    }	
	
	
    function checkPermitsUser(sPermits){
	   	var arrayPermits = sPermits.split(",");
	   	var sIdPermit = ''; 
	   	tree.setCheck(0,false);
	   	for(var i=0; i <= (arrayPermits.length -1); i++){
	   		id = arrayPermits[i];
	   		tree.setCheck(id,true);
	   	}
    } 

    function checkPermitsUserAccesos(sPermitsAccesos){
	   	var arrayPermits = sPermitsAccesos.split(",");
	   	var sIdPermit = ''; 
	   	treeAccesos.setCheck(0,false);
	   	for(var i=0; i <= (arrayPermits.length -1); i++){
	   		id = arrayPermits[i];
	   		treeAccesos.setCheck(id,true);
	   	}
    } 

    function checkPermitsUserTarjeta(sPermitsTarjeta){
	   	var arrayPermits = sPermitsTarjeta.split(",");
	   	var sIdPermit = ''; 
	   	treeTarjeta.setCheck(0,false);
	   	for(var i=0; i <= (arrayPermits.length -1); i++){
	   		id = arrayPermits[i];
	   		treeTarjeta.setCheck(id,true);
	   	}
    } 
   
    function checkPermitsUserLogistica(sPermitsLogistica){
	   	var arrayPermits = sPermitsLogistica.split(",");
	   	var sIdPermit = ''; 
	   	treeLogistica.setCheck(0,false);
	   	for(var i=0; i <= (arrayPermits.length -1); i++){
	   		id = arrayPermits[i];
	   		treeLogistica.setCheck(id,true);
	   	}
    } 
    
    function closeAllRoots() {
    	var rootsAr = tree.getSubItems('userMenuLink_Modulos').split(",");
	    for (var i = 0; i < rootsAr.length; i++) {
	        tree.closeAllItems(rootsAr[i]);
	    }
    }
	
	function closeAllRootsAccesos(){
		var rootsAr = treeAccesos.getSubItems('userMenuLink_Modulos').split(",");
	    for (var i = 0; i < rootsAr.length; i++) {
	        treeAccesos.closeAllItems(rootsAr[i]);
	    }
	}
     
	function closeAllRootsTarjeta(){
		var rootsAr = treeTarjeta.getSubItems('userMenuLink_Modulos').split(",");
	    for (var i = 0; i < rootsAr.length; i++) {
	        treeTarjeta.closeAllItems(rootsAr[i]);
	    }		
	}
	
	function closeAllRootsLogistica(){
		var rootsAr = treeLogistica.getSubItems('userMenuLink_Modulos').split(",");
	    for (var i = 0; i < rootsAr.length; i++) {
	        treeLogistica.closeAllItems(rootsAr[i]);
	    }		
	}
</script>


<?php echo xhtmlFootPagina();?>