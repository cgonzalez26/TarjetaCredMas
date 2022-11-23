<?

#Clase que se encarga de Dar Formato a los mensaje de Salida tras la ejecucion de una operacion: ya sean alertas, fallos, cualqui


final class Message {
	
	private $message = '';
	private $textMessage = '';
	public $type = '';
	public $issetMessage = false;
	
	public function __construct($array){
		if(!is_array($array)) return;
		
		$this->type = $array['type'];
		$this->textMessage = $array['textMessage'];
		$this->issetMessage=true;
		
	}
	
	public function reloadMessage($array){
		$this->type = $array['type'];
		$this->textMessage = $array['textMessage'];
		$this->issetMessage=true;		
	}
	
	private function setMessage(){
		switch ($this->type) {
			case "fuente":
					$operations = "Se registro su operacion";
				break;
			case "info":
					$operations = "Operacion abortada";
				
				break;
			case "importante":
					$operations = "ERROR";
				break;						

		}
		
		$this->message = "<p id='MessageOperation' class='$this->type'>$operations : [ $this->textMessage ]</p>";
	}
	
	public function getMessage(){
		$this->setMessage();	
		return $this->message;
	}
	
	public static function issetMessage(){
		return $this->issetMessage;
	}
	
}


?>