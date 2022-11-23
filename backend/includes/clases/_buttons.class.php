<?php
class  _buttons_{
	
	private $buttons = '';
	private $alignment = 'R';
	private $images_dir = IMAGES_DIR ;
	private $className = 'div_menu_buttons';
	private $width = '100%';
	  
	
	public function __construct($alignment) { $this->buttons = ''; $this->alignment = $alignment;}
	
	public function set_alignment($alignment) { $this->alignment = $alignment; }
	
	public function get_alignment(){ 

		switch ($this->alignment){
			case 'R': $alignment = 'right'; break;
				break;
			case 'L': $alignment = 'left'; break;
				break;
			default:  $alignment = 'right'; break;
				break;								
		}
		
		return $alignment;
	}
	
	public function set_className($className) { $this->className = $className; }
	
	public function get_className() { return $this->className; }
	
	public function set_width($width) { $this->width = $width ; }
	
	public function get_width() { return $this->width; }

	
	public function add_button($type_event,$event,$tag_button = '',$type_buton = '',$id = ''){
		
		switch ($type_buton){
			case "new"		:$image = 'add16.png'; 			break; 
			case "edit"		:$image = 'edit16.png';			break; 
			case "save"		:$image = 'save16.png';			break; 
			case "delete"	:$image = 'delete16.png';		break; 
			case "update"	:$image = 'reload16.png';		break; 
			case "print"	:$image = 'print16.png';		break; 	
			//case "back" 	:$image = 'back16.gif';			break;
			case "search" 	:$image = 'search16.png';		break;
			case "excel"	:$image = 'excel16.png';		break;
			case "pdf"		:$image = 'pdf16.png';			break;
			case "all"		:$image = 'checkbox_yes.png';	break;
			case "Ninguno"	:$image = 'checkbox_no.png';	break;
			case "reload" 	:$image = "arrow_redo.png"; 	break;
			case "generated":$image = "generate-order16.png"; 		break;
			case "back"		:$image = "go-back16.png";		break;
			case "reservate":$image = "reserve-order.png";	break;
			case "calendar":$image = "calendar24.png";	break;
			default: 		$image = ''; 					break;
			
			
			
			
		}	
		

		switch ($type_event) {
				case 'href':
						$link = "<a href='$event' alt='$tag_button' title='$tag_button' class='link_' id='$id'>$tag_button</a>";
					break;
				default:
						$link = "<a href='#' $type_event=\"$event\" alt='$tag_button' title='$tag_button' class='link_' id='$id'>$tag_button</a>";
					break;
		}	
			
		if($image != ''){
			
			$image = "<img src='$this->images_dir/icons/$image' alt='' hspace='4' border='0' align='absmiddle'>";
			
			$buton_to_add = $image . "&nbsp;" . $link . "&nbsp;";	
		}else{
			$buton_to_add = "&nbsp;" . $link . "&nbsp;";	
		}

		
		$this->buttons .= $buton_to_add;
	}
		
	
	public function get_buttons(){
			
		$div_menu_buttons = "<center><div id='' class='".$this->get_className()."' style='text-align:".$this->get_alignment()." !important;width:".$this->get_width().";'> $this->buttons </div></center>";
			
		return $div_menu_buttons;
	}
	
	public function reset_buttons(){ $this->buttons = ''; }
	
}
?>