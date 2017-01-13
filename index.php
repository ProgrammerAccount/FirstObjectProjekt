<?php
session_start();
if(isset( $_SESSION ['zalogowany']))
{
	header( "Location: home.php");
}
if((isset( $_POST ['login'])) && (isset( $_POST ['pass'])))
{
	
	require ('LoginFunction.php');
	$login = new Login();
	
	$login->RecaptchaVerify( $_POST ['g-recaptcha-response'],'6Ld6fygTAAAAAOE45YJjt5HOHiyjofoy46Qe8U0S');
	list ( $_SESSION ['idUser'], $_SESSION ['userName'], $_SESSION ['zalogowany'], $_SESSION ['email'] ) = $login->LoginPassVerify( $_POST ['login'],$_POST ['pass']);
	list ( $_SESSION ['captcha'], $_SESSION ['login'] ) = $login->ShowError();
}
?>


<!DOCTYPE html>
<html>
<head>
<title>Witaj na stronie HostBook</title>
<link href="css/login.css" rel="stylesheet" type="text/css" />
<script src='https://www.google.com/recaptcha/api.js'></script>
<meta charset="utf-8" />
</head>
<body>

	<main>
	<form autocomplete="on" method="POST">
		<div id="logowanie">
			<!--Logowanie-->
			<input type="email" name="login" placeholder="E-mail" /> <input
				type="password" name="pass" placeholder="Hasło" />
			<div style="margin-left: 85px">
				<div class="g-recaptcha"
					data-sitekey="6Ld6fygTAAAAACQXe_vFFu2rdCYq--oqUQYKHthf"></div>
			</div>

			<input type="submit" value="Zaloguj się" />


		</div>
	</form>
	<div class="error">
				<?php
				if(isset( $_SESSION ['login']))
				{
					echo $_SESSION ['login'];
					unset( $_SESSION ['login']);
				}
				if(isset( $_SESSION ['captcha']))
				{
					echo $_SESSION ['captcha'];
					unset( $_SESSION ['captcha']);
				}
				?>
			</div>
	<h3 style="text-align: center;">Nie masz konta? Stwórz je teraz!</h3>
	<!--Rejstracja-->
	<form action="rej.php" method="POST">
		<div id="rejstracja">
			<input type="email" name="login" placeholder="E-mail" /> <input
				type="password" name="pass" placeholder="Hasło" /> <input
				type="password" name="passv2" placeholder="Powtórz hasło" /> <input
				type="text" name="name" placeholder="Imie" /> <input type="submit"
				value="Zarejstruj się" />

			<div class="error">
				<?php
				if(isset( $_SESSION ['error_pass']))
				{
					echo $_SESSION ['error_pass'];
					unset( $_SESSION ['error_pass']);
				}
				if(isset( $_SESSION ['error_email']))
				{
					echo $_SESSION ['error_email'];
					unset( $_SESSION ['error_email']);
				}
				?>
			</div>
		</div>


	</form>



	</main>

</body>
</html>
