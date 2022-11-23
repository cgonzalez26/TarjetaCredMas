

	<link media="all" type="text/css" href="backend/includes/css/login.css?ver=20100601" id="login-css" rel="stylesheet">
	<link media="all" type="text/css" href="backend/includes/css/colors-fresh.css?ver=20100610" id="colors-fresh-css" rel="stylesheet">

	<script type='text/javascript' src='jscript/forms.js'></script> 
	
	<div id="login">
		<h1>Tarjeta Axion</h1>
		<p class="message" id='idMessage'>{ERRORES}<br>
		</p>
  
		<form action='' id='form' name='form' method='post' enctype='multipart/form-data'>			
	
		<input type='hidden' name='Confirmar' value='1' />
			<p>
				<label>Usuario(*)<br>
				<input type="text" tabindex="10" size="20" value='{sLogin}' class="input" id="sLogin" name="sLogin"></label>
			</p>
			<p>
				<label> E-mail(*)<br>
				<input type='text' tabindex="20" size="20" value='{sMail}' class="input" id="sMail" name="sMail"></label>
			</p>
			<p class="forgetmenot"><label>(*) Campos Obligatorios</label></p>
			<p class="submit">
				<input type="submit" tabindex="100" value="Aceptar" class="button-primary" id="wp-submit" name="wp-submit" onclick="javascript: return checkFormRequest();">
				<input type="hidden" value="1" name="testcookie">
			</p>
		</form>
	</div>
  
	<div class="espacio"></div>


<div id='pieLogin'>&nbsp;</div>
<center>
<div id='pieLogin'>
	Copyright © Griva Soluciones
</div>
</center>

<script type='text/javascript'>

	function checkFormRequest(){
		var Formu = document.forms['form'];
		var ERROR = 'Han ocurrido los siguientes errores: \n';
		var smsError = '';
		var ExpRegEMail = new RegExp ('(^[0-9a-zA-Z]+(?:[._][0-9a-zA-Z]+)*)@([0-9a-zA-Z]+(?:[._-][0-9a-zA-Z]+)*\.[0-9a-zA-Z]{2,3})$');
		
		if(Formu.sLogin.value == ''){
			smsError += "<li>- Nombre de Usuario Invalido</li>";
		}		
		
		if(!ExpRegEMail.test(Formu.sMail.value)){
			smsError += "<li>- E-Mail Invalido </li>";
		}		
		
		if(smsError != ''){
			//alert(ERROR + smsError);
			document.getElementById('idMessage').innerHTML = "<div style='color:#FF0000;'>" + smsError + "</div>";
			return false;
		}else{
			imageLoaderWithText('idMessage','ejecuntado operacion');
			return true;
		}
	}

</script>

