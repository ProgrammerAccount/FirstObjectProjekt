<?php
class Login
{
// właściwośći
private $email;
private $password;
private $captcha;
private $error_captcha = "";
private $error_login = "";
protected $connect_to_DB;

// metody
function __construct()
{
	require ("connect.php");
	$this->connect_to_DB = new mysqli( $host,$user,$pass,$base);
	if($this->connect_to_DB->connect_error)
	{
		echo "Error:" . $this->connect_to_DB->connect_errno;
		exit();
	}
}
// --------------------------------------------------------------------------------------------------------------------------------------------------------
function __destruct()
{
	if(isset( $this->connect_to_DB)) $this->connect_to_DB->close();
}
// --------------------------------------------------------------------------------------------------------------------------------------------------------
function RecaptchaVerify($captcha, $secret_key)
{
	$res = file_get_contents( "https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=" . $captcha . "&remoteip=" . $_SERVER ['REMOTE_ADDR']);
	$response = json_decode( $res);
	// errory
	if(! $captcha) $this->error_captcha = "Pokaż że nie jestęś robotem!";
	if($response->success == false) $this->error_captcha = "Pokaż że nie jestęś robotem!";
}
// --------------------------------------------------------------------------------------------------------------------------------------------------------
function LoginPassVerifyAndConnect($email, $password)
{
	if($this->error_captcha == "")
	{
		$email = htmlentities( $email);
		$email = $this->connect_to_DB->real_escape_string( $email);
		$result = $this->connect_to_DB->query( "SELECT * FROM user WHERE email='" . $email . "'");
		
		if($result != false)
		{
			$arrayWithResult = $result->fetch_assoc();
			
			if(password_verify( $password,$arrayWithResult ['pass']))
			{
				$login = true;
				header( "Location: home.php");
				return array (
						$arrayWithResult ['id'],
						$arrayWithResult ['name'],
						$login,
						$email 
				);
			}
			else
			{
				$this->error_login = "Nie ma takiego konta.";
			}
		}
		
		else
		{
			$this->error_login = "Nie ma takiego konta.";
		}
		$result->free();
	}
}
// --------------------------------------------------------------------------------------------------------------------------------------------------------
function ShowError()
{
	return array (
			$this->error_captcha,
			$this->error_login 
	);
}
}

?>


