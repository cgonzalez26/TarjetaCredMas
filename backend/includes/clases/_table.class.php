<?

final class _table_ {	
	
	public $table_object = ''; 				### nombre del objecto o tabla que se quiere mostrar
	public $table_class = 'table_object'; 	### clase de la tabla a mostrar	
	public $table_headers = ''; 			### encabezado de la tabla
	public $table_foot = ''; 				### pie de la tabla
	public $table_width = '700'; 			### ancho de la tabla
	public $table_align = 'center'; 		### align de la tabla
	public $table_comment = ''; 			### comentario, va debajo de la tabla
	public $table_style_colums = ''; 		### 		
	public $table_number_operations = 0; 	### cantidad de operaciones, las operaciones se establecen en el template
	public $table_sconditions = ''; 		### condiciones para filtrar lo que se muestra
	public $table_orders = ''; 				### orden en el que se van a mostrar los resultados
	public $table_fields_orders = '';		### son los campos por lo cual se pueden ordenar la tabla
	public $table_type_order = 'ASC';		### ASC o DESC
	public $table_num_field_order = -1;		### indica por cual columna se esta ordenando numericamente, es para manejar parametros vis url y no se muestre nombre de campo en BD
	public $table_enable_pagging = true; 	### propiedad que permite habilitar la paginacion o no. o sea si se muestra o no
	private $table_name_pagging = ''; 		### nombre de la paginacion, se una una variable de sesion
	public $table_offset = 0;	 			### desplazamiento
	public $table_number_of_record_by_pag = 25;//PAGGING_NUM; ### cantidad de registros que se muestran por pagina
	public $table_total_of_record = 0;	 	### cantidad total de registro, sin los limit
	public $table_number_of_records_obtained = 0; ### cantidad de registros que se obtuvieron 
	
	private $table_include_form = false;
	public $table_url_form = ''; 
	private $table_image_firts_column = "";
	public $table_store = ''; 				### store que se utiliza para recuperar los datos
	public $table_number_of_columns = 0; 	### 
	private $table_template_rows = ''; 		### template para parsear las filasw
	private $object_to_count = '';
	
	private $table_label = '';				### es un titulo en la tabla
	private $table_view_record_found = true;### determina si se muestra el cartel de registros encontrados
	private $table_empty = true ;
	
	private $enable_special_operations = false;
	private $type_special_operations = '';
	private $totales = 0.00;
	public $add_datos_to_array = '';#vacio = false, la utilizo para agregar datos al array en el proceso de muestreo, por ej. auditorias, solo tengo el idTipoAuditoria, para mostrar el texto, necesito cruzarlo cn la varialbe global
	
	private $table_enable_checkbox = false;	
	
	
	
	public function __construct($object){
		
		if(!is_string($object)) return;
		
		$this->table_object = $object;		

	}
	
	public function get_object(){ return $this->table_object ; }
	
	public function set_table_class($class = 'table_object'){
		
		if($class != "" && is_string($class)){$this->table_class = $class ;}
		
	}
	
	public function get_table_class(){ return $this->table_class ; }	
	
	
	public function set_table_fields_orders($table_fields_orders = ''){
		
		if($table_fields_orders != "" && is_string($table_fields_orders)){$this->table_fields_orders = $table_fields_orders ;}
		
	}
	
	public function get_table_fields_orders(){ return $this->table_fields_orders ; }


	public function set_table_type_order($table_type_order = 'ASC'){
		
		if($table_type_order != "" && is_string($table_type_order)){$this->table_type_order = $table_type_order ;}
		
	}
	
	public function get_table_type_order(){ return $this->table_type_order ; }
	
	
	
	public function set_table_num_field_order($table_num_field_order = 0){
		
		$this->table_num_field_order = intval($table_num_field_order);
		
	}
	
	public function get_table_num_field_order(){ return $this->table_num_field_order ; }	
	
		
	
	
	public function set_table_align($align = 'center'){

		if($align != "" && is_string($align)){ $this->table_align = $align ; }

	}
	
	public function get_table_align(){ return $this->table_align ; }	
	
	public function set_add_datos_to_array($type = ''){
		$this->add_datos_to_array = $type ;
	}
	
	public function get_add_datos_to_array(){
		return $this->add_datos_to_array ;
	}
	
	public function set_enable_special_operations($boolean = false){
		
		 $this->enable_special_operations = $boolean; 
		
	}	
	
	public function get_enable_special_operations(){ return $this->enable_special_operations ; }	
	
	public function set_type_special_operations($type_special_operations = ''){
		
		if(is_string($type_special_operations)){ $this->type_special_operations = $type_special_operations; }
		
	}	
	
	public function get_type_special_operations(){ return $this->type_special_operations ; }
		
	public function set_table_width($width = '700'){ $this->table_width = $width; }	
	
	public function get_table_width(){ return $this->table_width ; }	
		
	public function set_table_empty($boolean = ''){
		
		 $this->table_empty = $boolean; 
		
	}	
	
	public function get_table_empty(){ return $this->table_empty ; }	
	
	public function set_table_label($table_label = ''){
		
		if(is_string($table_label)){ $this->table_label = $table_label; }
		
	}	
	
	public function get_table_label(){ return $this->table_label ; }
	
	public function set_table_view_record_found($boolean = true){
		
		$this->table_view_record_found = $boolean;
		
	}	
	
	public function get_table_view_record_found(){ return $this->table_view_record_found ; }	

	public function set_table_headers($table_headers = ''){
		
		if(is_string($table_headers)){ $this->table_headers = $table_headers; }
		
	}
	
	public function get_table_headers(){ return $this->table_headers ; }

	public function set_table_foot($table_foot = ''){
		
		if(is_string($table_foot)){ $this->table_foot = $table_foot; }
		
	}
	
	public function get_table_foot(){ return $this->table_foot ; }

	public function set_table_comment($table_comment = ''){
		
		if(is_string($table_comment)){ $this->table_comment = $table_comment; }
		
	}

	public function get_table_comment(){ return $this->table_comment ; }

	public function set_table_style_colums($table_style_colums = ''){
		
		if(is_string($table_style_colums)){ $this->table_style_colums = $table_style_colums; }
		
	}
	
	public function get_table_style_colums(){ return $this->table_style_colums ; }	
	
	
	public function set_table_operations($table_operations = ''){
		
		if(is_string($table_operations)){ $this->table_operations = $table_operations; }
				
	}
	
	public function get_table_operations(){ return $this->table_operations ; }	
	
	
	public function set_table_sconditions($table_sconditions = ''){
		
		if(is_string($table_sconditions)){ $this->table_sconditions = $table_sconditions; }
				
	}
	
	public function get_table_sconditions(){ return $this->table_sconditions ; }	
	

	public function set_table_orders($table_orders	 = ''){
		
		if(is_string($table_orders)){ $this->table_orders	= $table_orders	; }
				
	}
	
	public function get_table_orders(){ return $this->table_orders ; }
	

	public function set_table_enable_pagging($table_enable_pagging = true){
		
		if(is_bool($table_enable_pagging)){ $this->table_enable_pagging	= $table_enable_pagging	; }
				
	}

	public function get_table_enable_pagging(){ return $this->table_enable_pagging ; }
	
	
	public function set_table_name_pagging($table_name_pagging = ''){
		
		if(is_string($table_name_pagging)){ $this->table_name_pagging = $table_name_pagging	; }
				
	}
	
	public function get_table_name_pagging(){ return $this->table_name_pagging ; }
	
	
	public function set_table_offset($table_offset = 0){
		
		if(is_integer($table_offset)){ $this->table_offset = $table_offset	; }
				
	}
	
	public function get_table_offset(){ return $this->table_offset ; }
	
	
	public function set_table_number_of_record_by_pag($table_number_of_record_by_pag = 0){
		
		if(is_string($table_number_of_record_by_pag)){ $this->table_number_of_record_by_pag = $table_number_of_record_by_pag	; }
				
	}

	public function get_table_number_of_record_by_pag(){ return $this->table_number_of_record_by_pag ; }
	
	
	public function set_table_total_of_record($table_total_of_record = 0){

		$this->table_total_of_record = (integer) $table_total_of_record; 

	}
	
	public function get_table_total_of_record(){ return $this->table_total_of_record ; }
	
	
	public function set_table_include_form($table_include_form = false){ if(is_bool($table_include_form)){ $this->table_include_form = $table_include_form; } }

	public function get_table_include_form(){ return $this->table_include_form ; }
		
	
	public function set_table_url_form($table_url_form = ''){

		if(is_string($table_url_form)){ $this->table_url_form = $table_url_form; }

	}

	public function get_table_url_form(){ return $this->table_url_form ; }

	public function set_table_image_firts_column($table_image_firts_column = ''){

		if(is_string($table_image_firts_column)){ $this->table_image_firts_column = $table_image_firts_column; }

	}

	public function get_table_image_firts_column(){ 
		
		if($this->table_image_firts_column != ''){
			return "<img src='".IMAGES_DIR."/$this->table_image_firts_column' width='32' height='32'>";
		}else{
			return "";
		}		
		
	}

	public function set_table_store($table_store = ''){
		
		if(is_string($table_store)){ $this->table_store = $table_store; }
				
	}

	public function get_table_store(){ return $this->table_store ; }	
	
	
	public function set_table_template_rows($table_template_rows = ''){
		
		if(is_string($table_template_rows)){ $this->table_template_rows = $table_template_rows; }
		
	}
	
	public function get_table_template_rows(){ return $this->table_template_rows ; }
	

	public function set_table_number_of_columns($table_number_of_columns = 0){

		$this->table_number_of_columns = $table_number_of_columns;

	}

	public function get_table_number_of_columns(){ return $this->table_number_of_columns ; }
		
	
	public function set_table_number_operations($table_number_operations = 0){
		
		if(is_integer($table_number_operations)){ $this->table_number_operations = $table_number_operations; }
		
	}
	
	public function get_table_number_operations(){ return $this->table_number_operations ; }	
	
	public function set_table_number_of_records_obtained($table_number_of_records_obtained = 0){
		
		if(is_integer($table_number_of_records_obtained)){ $this->table_number_of_records_obtained = $table_number_of_records_obtained; }
		
	}
	
	public function get_table_number_of_records_obtained(){ return $this->table_number_of_records_obtained ; }	
	
	public function set_object_to_count($object_to_count = ''){
		
		if(is_string($object_to_count)){ $this->object_to_count = $object_to_count; }
		
	}
	
	public function get_object_to_count(){ return $this->object_to_count ; }
	
	
	public function set_table_enable_checkbox($table_enable_checkbox = false){ $this->table_enable_checkbox = $table_enable_checkbox;  }
	
	public function get_table_enable_checkbox(){ return $this->table_enable_checkbox ; }
		
	
	private function print_table_header(){
		# @La idea es ir pintando a medida que se va obteniendo resultados
		
		$table_head = "";
		
		$table_head .= "<div id='div_table_object'>";
		$table_head .= "<center>";
		
		if($this->get_table_include_form()){
			$table_head .= "<form action='".$this->get_table_url_form()."' method='POST' name='form_table_object' id='form_table_object' style='display:inline;'>";	
		}
		
		$table_head .= "<table id='table_object' class='".$this->get_table_class()."' cellpadding='0' cellspacing='0' align='".$this->get_table_align()."' width='".$this->get_table_width()."'>";
		$table_head .= "<thead>";
		$table_head .= "<tr>";
		
		$number_column = 0;
		
		if($this->get_table_headers() != ''){
			
			$headers = explode(",",$this->get_table_headers());
			
			$column_orders = explode(",",$this->get_table_fields_orders());
			
			$num_column_order = $this->get_table_num_field_order();
			//var_export($num_column_order);
			$type_order_now = $this->get_table_type_order();
			
			if($type_order_now == 'ASC'){
				$img = "<span><img src=\"".IMAGES_DIR."/asc16.png\" alt=\"ASC\" title=\"ASC\" align=\"absmiddle\" width=\"12\" height=\"12\"></span>";
			}else{
				$img = "<span><img src=\"".IMAGES_DIR."/desc16.png\" alt=\"DESC\" title=\"DESC\" align=\"absmiddle\" width=\"12\" height=\"12\"></span>";
			}
			
			$url = array_shift( array_filter( explode( '?', $_SERVER['REQUEST_URI']) ) );
			
			$arrayHREF = $_GET;
			
			foreach ($headers as $header) {
				
				$image_order = "";
				
				if($column_orders[$number_column] != ""){
					
					if($num_column_order == $number_column){
						
						if($type_order_now == 'ASC'){
							$arrayHREF['field_order'] = $number_column;
							$arrayHREF['type_order']  = 'DESC';
							$arrayHREF['p']  = 0;
							$href = $url . '?' . http_build_query( $arrayHREF );
							
							$header = "<a href='$href'>$header</a>";
						}else{
							$arrayHREF['field_order'] = $number_column;
							$arrayHREF['type_order']  = 'ASC';
							$arrayHREF['p']  = 0;
							$href = $url . '?' . http_build_query( $arrayHREF );
							
							$header = "<a href='$href'>$header</a>";
						}
						$image_order = $img;
					}else{
						$arrayHREF['field_order'] = $number_column;
						$arrayHREF['type_order']  = 'ASC';
						$arrayHREF['p']  = 0;
						$href = $url . '?' . http_build_query( $arrayHREF );						
						$header = "<a href='$href'>$header</a>";
					}						
					
				}else{
					//$header .= "<th>{$header}&nbsp;$img</th>";	
				}
								

				$table_head .= "<th>{$header}&nbsp;$image_order</th>";	
				
				
				$number_column = $number_column + 1;
				
			}

		}else{

			$table_head .= "<th>- sin cabecera</th>";

		}

		$colspan = $this->get_table_number_operations();

		$this->set_table_number_of_columns( $number_column + $colspan);

		if($colspan != 0){

			$table_head .= "<th colspan='$colspan' class=''>&nbsp;</th>";

		}

		if($this->get_table_enable_checkbox()){

			$table_head .= "<th><input type='checkbox' name='chkALL'  id='chkALL' /></th>";

		}		

		$table_head .= "</tr>";

		$table_head .= "</thead>";

		return $table_head;

	}

	private function print_table_foot(){
		 $table_foot = "";

		 if($this->get_table_foot() != ''){
		 	
		 	$table_foot .= "<tfoot>";
		 	
			$table_foot .= "<tr><td>".$this->get_table_foot()."</td></tr>";
			
		 	$table_foot .= "</tfoot>";	
		 	
		 }


		 $table_foot .= "</table>";


		if($this->get_table_include_form()){ 

			 $table_foot .= "<input type='hidden' name='_op' id='_op' value=''>";

			 $table_foot .= "<input type='hidden' name='_i' id='_i' value=''>";

			 $table_foot .= "</form>";

		}
		 
		 $table_foot .= "</center>";
		 
		 $table_foot .= "</div>";
		 
		 if($this->get_table_include_form()){ 
			 $table_foot .= "<script languaje='JavaScript'>
			 
								function send_form(_i,_op){
									var form = document.forms['form_table_object'];
		
									form._op.value = _op ;
		
									form._i.value = _i ;
		
									form.submit();
								}
	
							
				   			</script>
				  		  ";
		 }
		 
		 return $table_foot;
		 
	}
	
	public function print_table(){
		global $oMysql;

		$sub_query = '';
		
		$table_object = '';
		
		$sub_query .= ' WHERE ' . $this->get_table_sconditions();
		
		if($this->get_table_num_field_order() != -1){

			$field = explode(",",$this->get_table_fields_orders());

			$index = $this->get_table_num_field_order();

			$field_order = $field[$index];

			$sub_query .= ' ORDER BY ' . $field_order . ' ' . $this->get_table_type_order();
			
		}else{
			if($this->get_table_orders() != ''){ $sub_query .= ' ORDER BY ' . $this->get_table_orders() . ' ' . $this->get_table_type_order(); }	
		}

		//var_export($this->get_table_num_field_order());die();

		if($this->get_table_enable_pagging()){

			$this->set_table_offset( intval((session_get_var($this->get_table_name_pagging()) * $this->get_table_number_of_record_by_pag())) );	

			$sub_query .= ' LIMIT ' . $this->get_table_offset() . ',' . $this->get_table_number_of_record_by_pag();

		}
		
		$this->set_table_total_of_record( $this->get_count_object() ); //-> este es para obtener la cantidad total de resultado, independiente de la pag.
		
		#:::Ahora Realizo la consulta con los parametros
		if($this->get_table_store() != ''){
			
			$result = $oMysql->_query("CALL ".$this->get_table_store()."(\"".$sub_query."\");"); 
			//var_export("CALL  ".$this->get_table_store()."(\"".$sub_query."\");");
		}else{

			$result = $oMysql->_query("CALL usp_get".$this->get_object()."(\"".$sub_query."\");");
			//var_export("CALL usp_get".$this->get_object()."(\"".$sub_query."\");");die();
		}
		
		$cantidad_registros = $oMysql->getNumRows($result);
		
		$cantidad_registros = (!$cantidad_registros) ? 0 : $cantidad_registros ;
		
		$this->set_table_number_of_records_obtained( $cantidad_registros );
		
		$number_record_of_view = $this->get_table_offset() + $this->get_table_number_of_records_obtained();
		
		if($this->get_table_view_record_found()){
			
			$table_object .= "<center><div class='div_table_record_founded' style='width:".$this->get_table_width()."px;'>- registros encontrados <span>".$this->get_table_total_of_record()."</span> - mostrando del <span>".$this->get_table_offset()."</span> al <span>$number_record_of_view</span></div></center>";	
		}
		
		$label = $this->get_table_label();
		
		if($label != ''){

			$table_object .= "<center><div class='div_table_record_founded' style='width:".$this->get_table_width()."px;'> {$this->get_table_label()} </div></center>";	

		}
		
		
		$table_object .= $this->print_table_header();
		
		$table_object .= "<tbody>";
		
		if($this->get_table_number_of_records_obtained() == 0){

			$table_object .= "<tr><td colspan='".$this->get_table_number_of_columns()."' align='left' style='border-right:1px solid #CCC;'>- no se encotraron registros</td></tr>";

		}else{
			
			if($this->get_table_template_rows() != ''){

				$template = $this->get_table_template_rows();

			}else{

				$template = $this->get_object();

			}

			$agregar_datos_extras = $this->get_add_datos_to_array();
			
			while ($datos = mysqli_fetch_array($result, MYSQL_ASSOC)) {
					//var_export($datos);
					//if($this->get_table_image_firts_column() != '') $datos['table_image_firts_column'] = $this->get_table_image_firts_column();
					
					$datos['IMAGES_DIR'] = IMAGES_DIR;
					
					//if($this->get_enable_special_operations() == true){ $this->work_special_operations($datos); }					
					
					if( $agregar_datos_extras != '' ){
	
						$datos = $this->attach_data($datos);
	
					}
					
					
					$table_object .= "<tr>";
					$table_object .= parserTemplate( TEMPLATES_XHTML_DIR . "/tableRows/".$template.".tpl", $datos);
					$table_object .= "</tr>";			
			}
			
			//if( $this->get_enable_special_operations() ){ $table_object .= $this->xhtml_special_operations(); }
			
			$this->set_table_empty(false);
		}
		
		$table_object .= "</tbody>";
		
		$table_object .= $this->print_table_foot();
		
		if($this->get_table_enable_pagging()){
			$table_object .= $this->get_xhtml_pagging();
		}
		
		//$table_object .= $this->print_table_comment();
		
		$oMysql->memoryFREE($result);
		
		return $table_object;
	}
	
	public function print_table_comment(){
		
		if($this->get_table_comment() != ''){
			
			$table_comment .= "<table class='table_comment' cellpadding='0' cellspacing='0' align='".$this->get_table_align()."' width='".$this->get_table_width()."'>";
			$table_comment .= "<tr>";
			$table_comment .= "<td>";
			$table_comment .= $this->get_table_comment();
			$table_comment .= "</td>";
			$table_comment .= "</tr>";
			$table_comment .= "</table>";
			
		}
		
		return $table_comment;
		
	}
	
	public function get_xhtml_pagging(){
		//$actualPage = (integer) $_SESSION[$this->get_table_name_pagging()];
		$actualPage = (integer) session_get_var($this->get_table_name_pagging());
		
		$limitOffset = $actualPage * $this->get_table_number_of_record_by_pag();			
		
		$pagging = array();			
		
		if($this->get_table_enable_pagging() && $this->get_table_number_of_record_by_pag() < $this->get_table_total_of_record()) {			
				
			$arrayHREF = $_GET;
			
			$url = array_shift( array_filter( explode( '?', $_SERVER['REQUEST_URI']) ) );
			
			$num_pages = ceil( $this->get_table_total_of_record() / $this->get_table_number_of_record_by_pag() );

			$table_pagging .= "<center><div id='pagging_Down' class='pagging' style='width:".$this->get_table_width().";'>";
			
			if($actualPage > 0) {

				$arrayHREF['p'] = $actualPage - 1;

				$href = $url . '?' . http_build_query( $arrayHREF );

				$table_pagging .= "<a href='$href' class='anterior'>« Anterior</a>";
			}

			for($i = 0; $i < $num_pages; $i++) {
				
				$page = $i + 1;
				
				if($i == $actualPage) {
					
					$table_pagging .= "<a class='selected'>$page</a>";
					
				} else {
				
					$arrayHREF['p'] = $i;
					
					$href = $url . '?' . http_build_query( $arrayHREF );
				
					$table_pagging .= "<a href='$href'>$page</a>";
					
				}
			}
			

			
			if($actualPage < $num_pages - 1) {
			
				$arrayHREF['p'] = $actualPage + 1;
				
				$href = $url . '?' . http_build_query( $arrayHREF );
			
				$table_pagging .= "<a href='$href' class='siguiente'>Siguiente »</a>";
			}
			
			$table_pagging .= "</div></center>";
		}
		
		
		return $table_pagging ;
	}
	
	private function get_count_object(){
		global $oMysql;
		
		if($this->get_object_to_count() == 'SQL_count'){

			$object_to_count = "SELECT count(*) FROM " . $this->get_object() ;
			
			$count_record = $oMysql->consultaSel( $object_to_count . " WHERE " . $this->get_table_sconditions() . ";",true);
			//var_export($object_to_count . " WHERE " . $this->get_table_sconditions());die();
		}else{
			
			$object_to_count = ($this->get_object_to_count() != '') ? $this->get_object_to_count() : 'store_count_' . strtolower($this->get_object()) ;	
			
			$count_record = $oMysql->consultaSel( "CALL " . $object_to_count . "(\"WHERE " . $this->get_table_sconditions() . "\")",true);
			
		}
		
		if(!$count_record){
			$count = 0;
		}else{
			$count = intval($count_record);
		}
		
		/*$count = (is_array($k)) ? array_shift($k) : 0;

		if($count == false || is_null($count)){
			$count = 0;
		}*/
		
		return $count;
	}
	
	
	private function work_special_operations($datos){
		
		switch ($this->get_type_special_operations()) {
			case 'monto-responsable':
					$totales = $totales + $datos['fMonto'];
				break;
		
			default:
				break;
		}
	}
	
	private function xhtml_special_operations(){		
		$row = '';
		
		switch ($this->get_type_special_operations()) {
			case '':
					
					$row = "";

				break;

			default:
					
				break;

		}

		return $row ;
	}
	
	private function attach_data($datos = false){
		//global $array_tipos_auditorias;
		
		if($datos == false){
			return $datos;
		}
		
		switch ($this->get_add_datos_to_array()) {
			case 'circulares':
					//$key = array_shift(array_keys($array_tipos_auditorias,$datos['idTipoAuditoria']));
					
					//$datos['sTipoAuditoria'] = $key ;
					
					$datos['_i'] = _encode($datos['id']);
					$datos['_rv'] = _encode('reenviar');
					$datos['_rc'] = _encode('reporte-circulares');
					
					
				break;
			case 'ejemplos':
					switch ($datos['iEstado']) {
						case 100:
							$datos['sEstado'] = 'registrado' ;
							break;
						case 200:
							$datos['sEstado'] = 'bloqueado' ;
							break;
						case 300:
							$datos['sEstado'] = 'eliminado' ;
							break;
						default:
							break;
					}

					//$datos['_view'] = _encode('subrubros-admin');
					//$datos['_edit'] = _encode('edit-rubro');
					//$datos['_delete'] = _encode('delete');
					$datos['_i'] = _encode($datos['id']);

				break;
			default:

				break;
				
				
		}
		
		return $datos ;
	}
	

}

?>