<link media="all" type="text/css" href="backend/includes/css/login.css?ver=20100601" id="login-css" rel="stylesheet">

	<center>
	<div id="login">
		<center><img src="../TarjetaCredMas/backend/includes/images/tenelo-header.jpg"></center>
		<div class="message" id='idMessage'>{ERRORES}</div>
		
		<form method="post" action="index.php" id="loginform" name="loginform">
		<input type='hidden' id='Confirmar' name='Confirmar' value='1' />
			<p>
				<label>Usuario<br>
				<input type="text" tabindex="10" size="20" value="" class="input" id="Nick" name="Nick"></label>
			</p>
			<p>
				<label>Password<br>
				<input type="password" tabindex="20" size="20" value="" class="input" id="Pass" name="Pass"></label>
			</p>
			<p class="forgetmenot"><label><input type="checkbox" tabindex="90" value="forever" id="rememberme" name="rememberme"> Remember Me</label></p>
			<p class="submit">
				<input type="submit" tabindex="100" value="Log In" class="button-primary" id="wp-submit" name="wp-submit">
				<input type="hidden" value="1" name="testcookie">
			</p>
		</form>
		
		<p id="nav">
		<a title="Olvide mi Contrase&ntilde;a" href='requestPass.php'>Olvide mi Contrase&ntilde;a</a>
		</p>
	</div>


<div id='pieLogin'>&nbsp;</div>
<center>
<div id='pieLogin'>
	Copyright � Griva Soluciones
</div>
</center>

