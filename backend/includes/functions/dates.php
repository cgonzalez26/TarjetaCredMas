<?php //------------------------------------------


$GLOBALS['_EXTACT_DATE_CACHE_'] = array();

$GLOBALS['DATE_MONTHS_NAMES'] = array(
	'01' => 'Enero',
	'02' => 'Febrero',
	'03' => 'Marzo',
	'04' => 'Abril',
	'05' => 'Mayo',
	'06' => 'Junio',
	'07' => 'Julio',
	'08' => 'Agosto',
	'09' => 'Septiembre',
	'10' => 'Octubre',
	'11' => 'Noviembre',
	'12' => 'Diciembre' );
	
	
$GLOBALS['DATE_DAYS_OF_WEEK_NAMES'] = array(
	'01' => 'Lunes',
	'02' => 'Martes',
	'03' => 'Miércoles',
	'04' => 'Jueves',
	'05' => 'Viernes',
	'06' => 'Sábado',
	'07' => 'Domingo' );


define('DATE_YEAR', 'year');
define('DATE_MONTH', 'month');
define('DATE_MONTH_NAME', 'month_name');
define('DATE_DAY', 'day');
define('DATE_DAY_OF_WEEK', 'day_week');
define('DATE_DAY_NAME', 'day_name');

define('DATE_HOUR', 'hour');
define('DATE_MINUTE', 'minute');
define('DATE_SECOND', 'second');

define('DATE_HOUR_12', 'hour_12');
define('DATE_HOUR_24', DATE_HOUR );

define('DATE_HOUR_AMPM', 'AM_PM');

define('DATE_AM', 'AM');
define('DATE_PM', 'PM');





function extractDate( $dateString, $datePart = null ) { 

	
	if(is_array($GLOBALS['_EXTACT_DATE_CACHE_'][ $dateString ])) 
				
		$date = $GLOBALS['_EXTACT_DATE_CACHE_'][ $dateString ];
		
	else {
	
		$array = explode( ' ', $dateString, 2 );
		$dateString = preg_replace( '#([^0-9]+)#', '', $array[0]);
		$hourString = preg_replace( '#([^0-9]+)#', '', $array[1]);
		
		$date = array();
		
		$date[DATE_YEAR] = str_pad( substr( $dateString, 0, 4 ), 4, '0', STR_PAD_LEFT );
		$date[DATE_MONTH] = str_pad( substr( $dateString, 4, 2 ), 2, '0', STR_PAD_LEFT );
		$date[DATE_MONTH_NAME] = $GLOBALS['DATE_MONTHS_NAMES'][ $date[DATE_MONTH] ];
		$date[DATE_DAY] = str_pad( substr( $dateString, 6, 2 ), 2, '0', STR_PAD_LEFT );
				
		$date[DATE_HOUR] = str_pad( substr( $hourString, 0, 2 ), 2, '0', STR_PAD_LEFT );
		$date[DATE_MINUTE] = str_pad( substr( $hourString, 2, 2 ), 2, '0', STR_PAD_LEFT );
		$date[DATE_SECOND] = str_pad( substr( $hourString, 4, 2 ), 2, '0', STR_PAD_LEFT );
		
		
		if((integer) $date[DATE_YEAR] > 1970) {
			
			$time = mktime(null, null, null, $date[DATE_MONTH], $date[DATE_DAY], $date[DATE_YEAR]);
			$dayWeekNumber = (integer) date('w', $time);
			
			if($dayWeekNumber == 0) $dayWeekNumber = 7;
						
			$date[DATE_DAY_OF_WEEK] = str_pad( $dayWeekNumber, 2, '0', STR_PAD_LEFT );
			$date[DATE_DAY_NAME] = $GLOBALS['DATE_DAYS_OF_WEEK_NAMES'][ $date[DATE_DAY_OF_WEEK] ];
			
		}
		
					
		$hour = (integer) $date['hour'];
				
		if($hour == 0) {
			
			$date[DATE_HOUR_AMPM] = DATE_AM;
			$date[DATE_HOUR_12] = '12';
			
		} else if($hour >= 12) {
			
			$date[DATE_HOUR_AMPM] = DATE_PM;
			$date[DATE_HOUR_12] = str_pad( $hour - 12, 2, '0', STR_PAD_LEFT );
			
		} else {
			
			$date[DATE_HOUR_AMPM] = DATE_AM;
			$date[DATE_HOUR_12] = $date[DATE_HOUR];
		}
		
		$GLOBALS['_EXTACT_DATE_CACHE_'][ $dateString ] = $date;
		
	}
	
	if($datePart) return $date[ $datePart ];
	else return $date;
	
}




function convertDate2Time( $dateString ) {
	
	
	$date = extractDate( $dateString );
	
	if($date[DATE_YEAR] < 1971) return 0;
	
	else return mktime( $date[DATE_HOUR_24], $date[DATE_MINUTE], $date[DATE_SECOND], $date[DATE_MONTH], $date[DATE_DAY], $date[DATE_YEAR] );
	
}


function convertTime2Date( $time) {
		
	$format = 'Ymd H:i:s';
	return date( $format, $time);
}


function extractTime( $time, $timePart = null ) {
	
	$date = convertTime2Date( $time );
	return extractDate( $date, $timePart );
}


//------------------------------------------ ?>