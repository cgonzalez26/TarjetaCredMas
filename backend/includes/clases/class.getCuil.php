<?php

final class _Cuit
{
	private $dniStc = '';
	private $xyStc = '';#digitos en base al sexo de la persona o empresa si lo fuera 20 || 27 || 30
	private $xyStcCHAR = '';#F || M
	private $digitoStc;

	public function __construct($dniStc = '',$xyChar = ''){ 

		$this->dniStc = trim($dniStc);
		
		$this->xyStcCHAR = strtoupper($xyChar) ;
		
	}


	
	public function _generateCUIL(){
		$digits = array();
		$suma = 0;
		
		
		if ($this->xyStcCHAR == 'F' || $this->xyStcCHAR == 'f')
			$this->xyStc = '27';
		else
			if ($this->xyStcCHAR == 'M' || $this->xyStcCHAR == 'm')
				$this->xyStc = '20';
			else
				$this->xyStc = '30';		
		
		
		for ($i = 0;$i <= 1;$i++){
			$digits[] = intval($this->xyStc[$i]);
		}
		
		$lenghtDNI = intval(strlen($this->dniStc)) - 1;
		
		for ($i = 0;$i <= $lenghtDNI;$i++){
			$digits[] = intval($this->dniStc[$i]);
		}
		
		$suma = $suma + ($digits[0] * 5);		
		$suma = $suma + ($digits[1] * 4);
		
		$suma = $suma + ($digits[2] * 3);
		$suma = $suma + ($digits[3] * 2);
		$suma = $suma + ($digits[4] * 7);
		$suma = $suma + ($digits[5] * 6);
		$suma = $suma + ($digits[6] * 5);
		$suma = $suma + ($digits[7] * 4);
		$suma = $suma + ($digits[8] * 3);
		$suma = $suma + ($digits[9] * 2);
		
		$cociente = floor($suma/11);
		
		$resto = $suma % 11;//$suma - ($cociente * 11) ;
		
		if($resto == 0){

			$this->digitoStc = 0;

		}else{

			if($resto == 1){

				if($this->xyStcCHAR == 'M'){
					$this->digitoStc = 9;
					$this->xyStc = 23;
				}else{
					if($this->xyStcCHAR == 'F'){
						$this->digitoStc = 4;
						$this->xyStc = 23;						
					}else{
						$this->digitoStc = 11 - $resto;
					}
				}

			}else{
				$this->digitoStc = 11 - $resto;
			}
		}
		
		return $this->xyStc . $this->dniStc . $this->digitoStc ;
		
	}

}

	//$cuit = new _Cuit('28105434','M');
	
	//echo $cuit->_generateCUIL();
?>