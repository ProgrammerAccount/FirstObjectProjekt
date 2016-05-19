<?php
session_start();
if(isset($_SESSION['zalogowany']))
{
	header("Location: home.php");
}
if((isset($_POST['login']))&&(isset($_POST['pass'])))
{




require('LoginFunction.php');
$login= new Login;

$login->RecaptchaVerify($_POST['g-recaptcha-response'],'6LcT2B0TAAAAAKj9Wgab_UfuF-sWJcKqtUeYMfmo');
list($_SESSION['id'],$_SESSION['name'],$_SESSION['zalogowany'],$_SESSION['email'])=$login->LoginPassVerifyConnect($_POST['login'],$_POST['pass']);

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Witaj na stronie HostBook</title>
	<link href="css/login.css" rel="stylesheet" type="text/css"/>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<meta charset="utf-8" />
</head>
<body>

<main>
	<form method="POST">
	<div id="logowanie">
	<!--Logowanie-->
<input type="email" 	  name="login" 	placeholder="E-mail"/>
<input type="password" name="pass" 	placeholder="Hasło"/>
	<div style=" margin-left:85px"><div class="g-recaptcha" data-sitekey="6LcT2B0TAAAAAMZGMEWRRSSldJFFNSWvVAzXNYwy"></div></div>
<input type="submit"   value="Zaloguj się"/>

	<?php
	if (isset($_SESSION['b_email']))
	{
		echo $_SESSION['b_email'];
		unset($_SESSION['b_email']);
	}
	if (isset($_SESSION['recaptcha']))
	{
		echo $_SESSION['recaptcha'];
		unset($_SESSION['recaptcha']);
	}
	?>
	</div>
	</form>
	<h3 style="text-align: center;">Nie masz konta? Stwórz je teraz!</h3>
	<!--Rejstracja-->
	<form action="rej.php" method="POST">
	<div id="rejstracja">
<input type="email" 	  name="login" 	placeholder="E-mail"/>
<input type="password" name="pass" 	placeholder="Hasło"/>
<input type="password" name="passv2" 	placeholder="Powtórz hasło"/>

<input type="text" 	  name="name" 	placeholder="Imie"/>
<div class="g-recaptcha" data-sitekey="6LdY9h0TAAAAANTTXTfkwIASvV4IYWJNVKZvbjQz"></div>
<input type="submit"   value="Zarejstruj się"/>
</div>
	<?php
	if (isset($_SESSION['b_email']))
	{
		echo $_SESSION['b_email'];
		unset($_SESSION['b_email']);
	}
	?>
	<?php
	if (isset($_SESSION['b_pass']))
	{
		echo $_SESSION['b_pass'];
		unset($_SESSION['b_pass']);
	}
	?>
	
	</form>



</main>

</body>
</html>
