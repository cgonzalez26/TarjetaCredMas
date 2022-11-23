var dhxWins,idWinFocus;
var sizeDim = {};
var minimizedCount = 0;
//SETEO GLOBAL DE VENTANAS
dhxWins = new dhtmlXWindows();
dhxWins.enableAutoViewport(false);
dhxWins.attachViewportTo('idBodyP');
dhxWins.setImagePath("../includes/grillas/dhtmlxWindows/sources/imgs/");
dhxWins.setSkin("dhx_black");
//dhxWins.attachEvent("onfocus", doOnFocus);
dhxWins.attachEvent("onParkUp", doOnMinimize);
dhxWins.attachEvent("onParkDown", doOnMaximize);
dhxWins.attachEvent("onContentLoaded", function(win){
    win.progressOff(); 
});


function getVentanaPop(sUrl,sTitulo,alto,ancho,iTypo){
	
	var idWin='win_'+(new Date()).valueOf();
    var winx=dhxWins.createWindow(idWin,150, 60, ancho, alto);
    winx.setText(sTitulo);
    winx.progressOn();
    winx.attachURL(sUrl);
    //winx.attachEvent("onFocus", doOnFocus);
    //w1.button("close").disable();*/
    var menu = dhxWins.window(idWin).attachMenu();
    menu.setImagePath("../includes/grillas/dhtmlxMenu/sources/imgs/");
	menu.setIconsPath("../includes/grillas/dhtmlxMenu/sources/images/");	
	menu.setSkin('clear_silver');
	
	var aGet=getDatosCadenaUrl(sUrl);	
	switch(iTypo){
		case 'Ficha':{	
			 menu.loadXML('/SEAL/backend/Clientes/getMenuFicha.php?idPoliza='+aGet['id']+'&idWin='+idWin);
			break;}
		case 'Cuotas':{
			break;}
		case 'PagueRap':{
			break;}
		case 'Requerimientos':{
			menu.loadXML('../SolicitudesMateriales/dhxmenu.xml');
			break;
		}	
	}
	var sUrl_ ='';
	var sTitulo_ ='';
	
	var idParent=0;
	menu.attachEvent("onClick",function (id){
		
				idParent = menu.getItemIdWinParent(id);
				sUrl_ = menu.getItemUrl(id);
		        if(!idParent){
		        	
				    dhxWins.window(idWin).attachURL(sUrl_);
		        }else{
					sTitulo_ = menu.getItemTitulo(id);
					//idParent = menu.getItemIdWinParent(id);
					dhxWins.window(idParent).close();  
		            getVentanaPop(sUrl_,'<span class=openPopUp >'+sTitulo_+'</span>',alto,ancho,'Ficha'); 
		        }
		        
				/*switch(id)
				{
					case 'PopUpClose':{ 
									  sUrl_ = menu.getItemUrl(id);
									  sTitulo_ = menu.getItemTitulo(id);
									  idParent = menu.getItemIdWinParent(id);
									  dhxWins.window(idParent).close();  
						              getVentanaPop(sUrl_,'<span class=openPopUp >'+sTitulo_+'</span>',alto,ancho,'Ficha');       
						          break;}						          
					default:{ 
							  sUrl_ = menu.getItemUrl(id);
						      dhxWins.window(idWin).attachURL(sUrl_); 
					}        	          
				}*/
				
			return true;
			}
	);
}

function doOnMinimize(win) {
	var id = win.getId();

	var pos = win.getPosition();
	var dim = win.getDimension();

	var sizeObj = sizeDim[id];
	if(sizeObj == null)
	{
		sizeObj = new Object();
	}
	sizeObj["pos"] = pos;
	sizeObj["dim"] = dim;

	sizeDim[id] = sizeObj;
    
	//alert(minimizedCount)
	 
	win.setPosition(minimizedCount*100,minimizedCount*15);
	win.setDimension(50,32);
	//win.denyMove();
	minimizedCount++;
}


function doOnMaximize(win) {
	var id = win.getId();
	//alert(id);
	var sizeObj = sizeDim[id];
	if(sizeObj != null)
	{
		var pos = sizeObj["pos"];
		var dim = sizeObj["dim"];

		win.setPosition(pos[0], pos[1]);
		win.setDimension(dim[0], dim[1] + 30);
	}
	//win.allowMove();
	rearrange();
}


function rearrange()
{
	var count = 0;
	dhxWins.forEachWindow(function(win) {

			var isParked = win.isParked();
			if(isParked)
			{
				win.setPosition(count*200, 0);
				count++;
			}
		});
	minimizedCount = count;
}



function doOnFocus(win) {
   //alert('hola');	
   //idWinFocus = win.getId();
   dhxWins.window(idWinFocus).close();
}

function verWinFocus(){
	alert(idWinFocus);
	dhxWins.window(idWinFocus).close();
}