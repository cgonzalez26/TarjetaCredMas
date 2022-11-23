<?php
class  aToolBar{
	
	  private  $sColumnas;
	  private $sDirectorioTemplate;
	  private  $sAnchoTabla;
	  private $sFilas;
	
	public function __construct() {
			$this->sColumnas='';
			$this->sAnchoTabla='';
			$this->sDirectorioTemplate=TEMPLATES_XHTML_DIR.'/others/';   
			$this->sFilas='';
		}
	public function setAnchoBotonera($sAncho){
			$this->sAnchoTabla=$sAncho;
		}	
		
	
	public function parserStringCadena( $cadena, $vars = false) {
		If( !is_array( $vars ) ) $vars = array();
		$vars += get_defined_constants();
		if( !array_key_exists( 'BASE_URL', $vars ) ) 
			$vars['BASE_URL'] = 'http://' . $_SERVER['HTTP_HOST'] . '/';
		preg_match_all( '#(\{)([a-zA-Z0-9\_\.]+)(\})#', $cadena, $coincidencias );
		For( $i = 0; $i < count( $coincidencias[0] ); $i++ ) {
	
			$coincidencia = $coincidencias[2][$i];
			$reemplazo = $vars[ $coincidencia ];
			$cadena=str_replace($coincidencias[0][$i],trim( $reemplazo ),$cadena );
		}
		return $cadena;		
	}
	public function parserBotonera( $archivo, $vars = false ) {
		If( file_exists( $archivo ) )
		return $this->parserStringCadena( file_get_contents( $archivo ), $vars );
		
	}
	
	
		
	public function addBoton($sId,$sEvento,$sFuncion,$sTipo = false,$sEtiqueta = false,$sIcono = false,$bSolo = false,$bSize=false,$sStyle=false){	
		
		if(!$bSize) $bSize=8;
		if($sTipo){
			if(!$sEtiqueta) $sEtiqueta=$sTipo;
			switch ($sTipo){
				case "Nuevo": $sIcono='new.gif'; break; 
				/*case "Editar":$sIcono='page.gif';break; */
				case "Editar":$sIcono='edit.png';break; 
				case "Guardar":$sIcono='save.gif';break; 
				case "Eliminar":$sIcono='cancelar.gif';break; 
				case "Actualizar":$sIcono='reload.gif';break; 
				case "Imprimir":$sIcono='print.gif';break; 	
				case "Salir":$sIcono='close2.gif';break;
				case "Perfil":$sIcono='user.ico';break;
				case "Ayuda":$sIcono='help.gif';break;
				case "Descargar":$sIcono='downloads.gif';break;
				case "Separador":$sIcono='linea.gif';break;
				case "Titulo":$sIcono='titulo.gif';break;
				case "Grilla":$sIcono='grid.gif';break;
				case "Dolar":$sIcono='dolar24.png';break;
				case "Contextual":$sIcono='kmenuedit22.png';break;
				case "Down":$sIcono='down.png';break;
				case "Up":$sIcono='up.png';break;
				case "Document":$sIcono='Documents.png';break;
				case "Undo":$sIcono='Undo.png';break;
				case "Redo":$sIcono='Redo.png';break;
				case "Lista":$sIcono='lista.png';break;
				case "PageNumber":$sIcono='PageNumber.png';break;
				case "Reiniciar":$sIcono='shutdown.png';break;
				case "Doc":$sIcono='Doc.png';break;
				case "PopUp":$sIcono='PopUp.png';break;
				case "Duplicado":$sIcono='ClassDuplicate.png';break;//ClassDuplicate
				case "Baja":$sIcono='Baja.png';break;//ClassDuplicate
				case "Buscar16":$sIcono='buscar16.png';break;//ClassDuplicate
				case "Buscar24":$sIcono='buscar24.png';break;//ClassDuplicate
				case "Excel":$sIcono='Excel.png';break;//ClassDuplicate
				case "Excel16":$sIcono='Excel16.png';break;//ClassDuplicate
				case "Dinero16":$sIcono='Dinero16.png';break;//ClassDuplicate
				case "Dinero24":$sIcono='Dinero24.png';break;//ClassDuplicate
				case "checke16":$sIcono='checke16.png';break;//ClassDuplicate
				case "checke24":$sIcono='checke24.png';break;//ClassDuplicate
				case "Configurar":$sIcono='Configurar.png';break;//ClassDuplicate
				case "Email":$sIcono='Email.png';break;//ClassDuplicate
				case "Circular":$sIcono='Circular.png';break;//ClassDuplicate
				case "GrupoUsuarios":$sIcono='GrupoUsuarios.png';break;//ClassDuplicate
				case "Historial":$sIcono='History.png';break;//ClassDuplicate
			}	
		}	
		if (!$sStyle) $sFont='#000000';
		else $sFont=$sStyle; 	
		
		
		
		if ($bSolo) $sCuerpo="<img src=\"../includes/templates/xhtml/others/Botonera/imgPag/$sIcono\">";
		else  $sCuerpo= "<table><tr><td><img src=\"../includes/templates/xhtml/others/Botonera/imgPag/$sIcono\"></td><th style=\"font-family:Tahoma;font-size:{$bSize}pt;color:$sFont;\" >$sEtiqueta</th></tr></table> ";
		
		$this->sColumnas.="<td id=\"$sId\"  alt=\"$sEtiqueta\" title=\"$sEtiqueta\" style=\"cursor:pointer;border:0px !important;width:auto !important;\" $sEvento=\"$sFuncion\"  >$sCuerpo</td>";
		$this->sFilas.="<tr><td id=\"$sId\"  alt=\"$sEtiqueta\" title=\"$sEtiqueta\" style=\"cursor:pointer;border:0px !important;width:auto !important;\" $sEvento=\"$sFuncion\" >$sCuerpo</td></tr>";
	}
		
	
	public function setRowsColumns(){ $this->sColumnas = "";$this->sFilas = ""; }
	
	public function getBotoneraToolBar($sFloat,$bOrden=false){
		$aVariables['ANCHO_TABLA']=$this->sAnchoTabla;
		$aVariables['COLUMNAS']=$this->sColumnas;
		$aVariables['FILAS']=$this->sFilas;
	    switch ($sFloat){
				case 'L':$aVariables['FLOAT']='left';break;
				case 'R':$aVariables['FLOAT']='right';break;
				default:$aVariables['FLOAT']='center';
			}
			
		if (!$bOrden){	
		 $sBotonera=$this->parserBotonera($this->sDirectorioTemplate.'/Botonera/BotoneraGeneral.tpl',$aVariables);
		}else {
			$sBotonera=$this->parserBotonera($this->sDirectorioTemplate.'/Botonera/BotoneraVertical.tpl',$aVariables);
		}
		
		return $sBotonera;
	}
	
	public function addSelect($sId,$sEvento,$sFuncion,$sOption,$sEtiqueta=false,$bSolo=false){
		$sCuerpo=" <select style='border:0px !important;' name='$sId' id='$sId' $sEvento=\"$sFuncion\" title='$sEtiqueta' >$sOption</select>";
		
		if(!$bSolo){
		    $this->sColumnas.="<th style='border:0px !important;'>$sEtiqueta</th><td style='border:0px !important;'>$sCuerpo</td>";
		     $this->sFilas.="<tr><th style='border:0px !important;'>$sEtiqueta</th><td style='border:0px !important;'>$sCuerpo</td></tr>";
		}else{
			$this->sColumnas.="<td style='border:0px !important;'>$sCuerpo</td>";
		     $this->sFilas.="<tr><td style='border:0px !important;'>$sCuerpo</td></tr>";
		}
	}
	
}
?>