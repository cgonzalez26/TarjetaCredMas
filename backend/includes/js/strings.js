function stringTrim(cadena) {
		
	for(i=0; i<cadena.length; ) {
	
		if(cadena.charAt(i)==" ") cadena=cadena.substring(i+1, cadena.length);
		else break;
	}

	for(i=cadena.length-1; i>=0; i=cadena.length-1) {
	
		if(cadena.charAt(i)==" ") 	cadena=cadena.substring(0,i);
		else break;
	}
	
	return cadena;
}	



function stringStartsWith( string, prefix ) { return string.indexOf(prefix) == 0; }

function stringEndsWith( string, sufix ) { return string.lastIndexOf(sufix) == string.length - sufix.length; }


function stringRemoveSufix( string, sufix ) {
	
	if(stringEndsWith(string, sufix)) return string.substring( 0, string.length - sufix.length );
	else return string;
	
}


function stringRemovePrefix( string, prefix ) {
	
	if(stringStartsWith(string, prefix)) return string.substring( prefix.length );
	else return string;
	
}



function stringReplace( sCadena, sBuscar, sReemplazo )  {
	
	sCadena = String( sCadena );
	
	var aCadena = sCadena.split( sBuscar );
	
	return aCadena.join( sReemplazo );
}



function stringReplaceRegex( sCadena, sBuscar, sReemplazo )  {
	
	
	if(sReemplazo == null) sReemplazo = '';
	
	sCadena = String(sCadena);
	
	while( sCadena.match(sBuscar) )  sCadena = sCadena.replace( sBuscar, sReemplazo );
		
	return sCadena;
}




function stringParseNumber( number, negative, decimal ) {
	
	var negativeBool = negative == null ? false : negative; 
	var decimalBool = decimal == null ? false : decimal; 
	number = stringReplace( stringTrim( String( number ) ), ',', '.' );
	
	var posDecimalSeparator = number.indexOf('.');
	
	var intPart;
	var decimalPart;
	
	
	if(posDecimalSeparator >= 0 && posDecimalSeparator < number.length) {
		
		var parts = number.split('.', 2);
		
		intPart = stringReplaceRegex( parts[0],/([^0-9])/, '');
		decimalPart = stringReplaceRegex( parts[1],/([^0-9])/, '');
		
		
		
	} else {
		
		intPart =  stringReplaceRegex( number,/([^0-9])/, '');
		decimalPart = '0';
	}
	
	
	var stringNumber = '';
	
	if(negativeBool && number.indexOf('-') == 0) stringNumber += '-';
	
	stringNumber += intPart;
	
	if(decimalBool)	 stringNumber += '.' + decimalPart;
	
	return Number(stringNumber);
		
	
}



function stringFormatNumber( number, decimalPlaces, thousandsSeparator, decimalSeparator ) {
	
	number = String( stringParseNumber( number, true, true ) );
	decimalPlaces = stringParseNumber( decimalPlaces, false, false );
	
	thousandsSeparator = thousandsSeparator == null ? ',' : thousandsSeparator;
	decimalSeparator = decimalSeparator == null ? '.' : decimalSeparator;
	
	
	var i;
	var posDecimalSeparator = number.indexOf('.');
	
	var intPart;
	var decimalPart;
	
	
	var string = '';
	
	
	
	if(posDecimalSeparator >= 0 && posDecimalSeparator < number.length) {
		
		var parts = number.split('.', 2);
		
		intPart = String( parts[0] );
		decimalPart = String( parts[1] );
		
	} else {
		
		intPart = String( number );
		decimalPart = '0';
	}
	

	var intArray = new Array();
	var numberThousands = Math.floor( intPart.length / 3 );
	var thousandsOffset = intPart.length - ( numberThousands * 3 );
	
	if(thousandsOffset > 0)
		intArray.push( intPart.substr( 0, thousandsOffset ) );
	
	for(i=0; i < numberThousands; i++)
		intArray.push( intPart.substr( thousandsOffset + ( i * 3 ), 3 ) );
		
	
	string += intArray.join( thousandsSeparator );
	
	if(decimalPlaces > 0) {
		
		string += decimalSeparator;
		
		if( decimalPlaces <= decimalPart.length ) string += decimalPart.substr( 0, decimalPlaces );
		else {
			
			while( decimalPlaces > decimalPart.length )
				decimalPart += '0';
							
			string += decimalPart;
			
		}
	}
	
	
	return string;
}

