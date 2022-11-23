
/*---------------------------------------------*/
/*--Variables globales--*/
var onlyString = /[a-zA-Z]/;
var stringWithNumber = "";
var eMail = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
var codigoPostal = /^\d{4}$/;
var numeroIdentidad = /^\d{8,9}$/;

var ERROR = 'Han sucedido los siguientes errores: \n';

/*---------------------------------------------*/

function verificaDatosProvincia(){
	var Formu = document.forms['form'];	
	var smsError = '';	
	
	if(!onlyString.test(Formu.sNombre.value)){
		smsError += '- Nombre de Provincia Invalido \n';		
	}
	
	if(Formu.sHora.value == ''){
		smsError += '- Zona Horaria Invalida \n';		
	}
	
	if(smsError != ""){
		alert(ERROR + smsError);
		return false;
	}
}

function confirmaBajaProvincia(Message,id){
	var Title = '';
	var ok = confirm(Title + Message);
	if( ok == true ){
		window.location.href = 'Provincias.php?type=delete&id=' + id;
	}else{
		return false;
	}
}


/*---------------------------------------------*/

function verificaDatosLocalidad(){
	var Formu = document.forms['form'];	
	var smsError = '';
	
	if(!onlyString.test(Formu.sNombre.value)){
		smsError += '- Nombre de Localidad Invalido \n';		
	}
	
	if(Formu.idProvincia.value == '0'){
		smsError += '- Provincia No valida \n';		
	}
	
	if(smsError != ""){
		alert(ERROR + smsError);
		return false;
	}	
}


/*---------------------------------------------*/

function verificaDatosTipoIva(){
	var Formu = document.forms['form'];	
	var smsError = '';
	
	if(!onlyString.test(Formu.sNombre.value)){
		smsError += '- Nombre de Tipo Iva Invalido \n';		
	}
	
	if(smsError != ""){
		alert(ERROR + smsError);
		return false;
	}
}

function checkDelete(Message,id){
	var Title = '';
	var ok = confirm(Title + Message);
	if( ok ){				
		return true;
	}else{
		return false;
	}
}

/*---------------------------------------------*/

function checkDatosUser(){
	var Formu = document.forms['form'];
	var TypeOperations = Formu.Operation.value;
	var smsError = '';	
	var checkPermisos = document.forms['form']['key[]'];
	var sizeChekPermisos = checkPermisos.length - 1;
	var countPermisos = 0;
	
	
	if(TypeOperations == "New"){
		if(!LoginPermitido || Formu.sLogin.value == ''){ smsError += '- Nombre de Login Invalido \n'; }
		if(Formu.sPassword.value == '' || Formu.sPassword.value != Formu.sPasswordTwo.value){ smsError += '- Password Invalido \n'; }
	}else{
		if( Formu.sPassword.value != Formu.sPasswordTwo.value && Formu.sPassword.value != '' ){ smsError += '- Password Invalido \n'; }
	}
	
	if(!onlyString.test(Formu.sNombre.value)){
		smsError += '- Nombre de Usuario Invalido \n';		
	}	

	if(!onlyString.test(Formu.sApellido.value)){
		smsError += '- Apellido de Usuario Invalido \n';		
	}

	if(Formu.sDireccion.value == ''){
		smsError += '- Direccion de Usuario Invalido \n';
	}
		
	if(!eMail.test(Formu.sMail.value)){
		smsError += '- Email  Invalido \n';		
	}
	
	
	for(i=0;i <= sizeChekPermisos; i++){
		if(checkPermisos[i].checked){ countPermisos++; }
	}
	
	if(countPermisos == 0){ smsError += '- No asigno Privilegios al Usuario \n'; }
	
	if(smsError != ''){
		alert(ERROR + smsError);
		return false;
	}else{
		return true;		
	}

}

/*---------------------------------------------*/

function checkDatosSucursales(){
	var Formu = document.forms['form'];	
	var smsError = '';		
	
	if(Formu.idProvincia.value == 0 ){
		smsError += '- Provincia Invalida \n';
	}

	if(Formu.idLocalidad.value == 0 ){
		smsError += '- Localidad Invalida \n';
	}	
	
	if(!onlyString.test(Formu.sNombre.value)){
		smsError += '- Nombre de Sucursal Invalido \n';		
	}
	
	if(Formu.sDireccion.value == ""){
		smsError += '- Direccion Invalida \n';		
	}	
	
	if(!codigoPostal.test(Formu.sCodigoPostal.value)){
		smsError += '- Codigo Postal Invalido \n';
	}
	
	if(smsError != ''){
		alert(ERROR + smsError);
		return false;
	}else{
		return true;		
	}	
	
}

/*---------------------------------------------*/

function checkDatosTypeUser(){
	var Formu = document.forms['searchTypeUser'];	
	var smsError = '';	
	
	if(Formu.sNombreUsuario.value == ""){
		smsError += '- Nombre de Tipo de Usuario Invalido \n';
	}
	
	if(smsError != ''){
		alert(ERROR + smsError);
		return false;
	}else{
		return true;		
	}		
}

/*---------------------------------------------*/

function checkDatosRule(){
	var Formu = document.forms['searchRule'];	
	var smsError = '';	
	
	if(Formu.sNombreRegla.value == ""){
		smsError += '- Nombre de Regla Invalida \n';
	}
	
	if(smsError != ''){
		alert(ERROR + smsError);
		return false;
	}else{
		return true;		
	}		
}

/*---------------------------------------------*/

function checkDatosOffice(){
	var Formu = document.forms['form'];	
	var smsError = '';
	
	if(Formu.idSucursal.value == 0){
		smsError += '- Sucursal Invalida \n'; 
	}

	if(Formu.sApodo.value == ""){
		smsError += '- Nombre de Oficina Invalido \n';
	}	
	
	if(Formu.sNombre.value == "" || !onlyString.test(Formu.sNombre.value)){
		smsError += '- Nombre de Responsable Invalido \n';
	}
	
	if(Formu.sApellido.value == "" || !onlyString.test(Formu.sApellido.value)){
		smsError += '- Apellido de Responsable Invalido \n';
	}

	if(!numeroIdentidad.test(Formu.sDocumento.value)){
		smsError += '- Numero Documento de Responsable Invalido \n';
	}
	
	if(smsError != ''){
		alert(ERROR + smsError);
		return false;
	}else{
		return true;		
	}	
}


function checkDatosCaja(){
	var Formu = document.forms['form'];	
	var smsError = '';
	
	if(Formu.sNombre.value == ""){
		smsError += '- Fecha Invalida \n';		
	}
	
	if(smsError != ""){
		alert(ERROR + smsError);
		return false;
	}else{
		return true;
	}
}


function checkDatosAgregarMovimiento(){
	var Formu = document.forms['form'];	
	var smsError = '';
	
	if(Formu.idTipoMovimiento.value == 0 ){
		smsError += '- Tipo de Movimiento Invalido \n ';
	}

	if(Formu.Concepto.value == 0 ){
		smsError += '- Concepto Invalido \n ';
	}
	
	if(Formu.fImporte.value == "" || Formu.fImporte.value <= 0){
		smsError += '- Importe Invalido \n ';
	}

	if(Formu.sComprobante.value == "" ){
		smsError += '- Numero de Comprobante Invalido \n ';
	}	
	
	if(Formu.sDetalle.value == "" ){
		smsError += '- Detalle Invalido \n ';
	}	
	
	if(smsError != ""){
		alert(ERROR + smsError);
		return false;
	}else{
		return true;
	}	
}

//------------------------------------------------------------------

function checkDeletePagos(){
	var Formu = document.forms['FormPagos'];	
	var smsError = '';	
	var checkPagos = document.forms['FormPagos']['key[]'];
	var sizeChekPagos = checkPagos.length - 1;
	var countDelete = 0;
	
	for(i=0;i <= sizeChekPagos; i++){
		if(checkPagos[i].checked){ countDelete++; }
	}
	
	if(countDelete == 0){ smsError += '- No Hay Elementos seleccionados \n'; }
	
	if(smsError != ''){
		alert(ERROR + smsError);
		return false;
	}else{
		var ok = confirm('Esta seguro de realizar esta Operacion?');
		
		if(ok){
			Formu.Operations.value = 'Delete';
			Formu.submit();		
			//return true;
		}else return false;
	}	
	
}


//------------------------------------------------------------------

function checkDatosTiposAnulaciones(){
	var Formu = document.forms['form'];	
	var smsError = '';
	
	if(!onlyString.test(Formu.sNombre.value)){
		smsError += '- Nombre de Tipo Anulacion Invalido \n';		
	}
	
	if(smsError != ""){
		alert(ERROR + smsError);
		return false;
	}
}