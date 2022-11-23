<?
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );
session_start();
#Control de Acceso al archivo
//if(!isLogin()){go_url("/index.php");}

function mysql_XML($resultado, $nombreDoc='resultados', $nombreItem='item') { 
   $campo = array(); 
    
   // llenamos el array de nombres de campos 
   for ($i=0; $i<mysql_num_fields($resultado); $i++) 
      $campo[$i] = mysql_field_name($resultado, $i); 
    
   // creamos el documento XML    
   $dom = new DOMDocument('1.0', 'UTF-8'); 
   $doc = $dom->appendChild($dom->createElement($nombreDoc)); 
    
   // recorremos el resultado 
   for ($i=0; $i<mysql_num_rows($resultado); $i++) { 
       
      // creamos el item 
      $nodo = $doc->appendChild($dom->createElement($nombreItem)); 
       
      // agregamos los campos que corresponden 
      for ($b=0; $b<count($campo); $b++) { 
         $campoTexto = $nodo->appendChild($dom->createElement($campo[$b])); 
         $campoTexto->appendChild($dom->createTextNode(mysql_result($resultado, $i, $b))); 
      } 
   } 
    
   // retornamos el archivo XML como cadena de texto 
   $dom->formatOutput = true;  
   return $dom->saveXML();     
} 


// forma simplificada 
$sql = "SELECT * FROM Empleados";
$resultado = $oMysql->consultaSel($sql,true); 

 
header ('Content-type: text/xml'); 
echo mysql_XML($resultado,'Empleados','empleado'); 
 
// se puede personalizar el nombre del documento y de cada item asi: 
//echo mysql_XML($resultado, 'nombre del documento', 'nombre de cada item'); 


?>
