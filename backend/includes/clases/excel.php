<?php
class Excel {

    private $file;
    private $row;

    /*
     * Constructor
     */
    function __construct(){ 
        $this->file = $this->__BOF();
        $row = 0;
    }
    
    /*
     * Inicio del fichero
     */
    private function __BOF() {
        return pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
    }
    
    /*
     * Final del fichero
     */
    private function __EOF() {
        return pack("ss", 0x0A, 0x00);
    }
    
    /*
     * Escribe un número en una fila y columna
     */
    private function __writeNum($row, $col, $value) {
        $this->file .= pack("sssss", 0x203, 14, $row, $col, 0x0);
        $this->file .= pack("d", $value);
    }
    
    /*
     * Escribe un string en una fila y columna
     */
    private function __writeString($row, $col, $value ) {
        $L = strlen($value);
        $this->file .= pack("ssssss", 0x204, 8 + $L, $row, $col, 0x0, $L);
        $this->file .= $value;
    }
    
    /*
     * Escribe un valor en una fila y columna, este método decide si será un número o un string.
     */
    private function writeCell($value,$row,$col) {
        if(is_numeric($value)) {
            $this->__writeNum($row,$col,$value);
        }elseif(is_string($value)) {
            $this->__writeString($row,$col,$value);
        }
    }
    
    /*
     * Añadir datos de una fila
     */
    public function addRow($data,$row=null) {
        $columns = count($data);
        
        if(!isset($row)) {
            $row = $this->row;
            $this->row++;
        }
        for($i=0; $i<$columns; $i++) {
            $cell = $data[$i];
            $this->writeCell($cell,$row,$i);
        }
    }
    
    /*
     * Añadir datos de una tabla
     */
    public function addTable($data) {
        $rows = count($data);
        
        for($j=0;$j<$rows;$j++){
        
            $row = $this->row;
            $this->row++;
            
            $columns = count($data[$j]);
            
            for($i=0; $i<$columns; $i++) {
        
                $cell = $data[$j][$i];
                $this->writeCell($cell,$row,$i);
        
            }
        }
    }    
    
    /* 
     * Genera un fichero para descargar en memoria
     */
    public function download($filename) {
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=$filename");
        header("Content-Transfer-Encoding: binary");
        
        $this->write();
    }
    
    /*
     * Escribe el contenido del fichero
     */
    private function write() {
        echo $file = $this->file.$this->__EOF();
    }
    
}  
?>