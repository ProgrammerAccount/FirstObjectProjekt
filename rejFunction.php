<?php
require "LoginFunction.php";
class Rejstracja extends Login
{
// wlasciwosci
public $password;
public $repeat_password;
public $name;
public $good = true;
public $save_email;
public $error_email = "";
public $error_password = "";
// metody
function __construct()
{
	parent::__construct();
}
function __destruct()
{
	parent::__destruct();
}
function SanitizationEmail($email)
{
	$save_email = htmlentities( $email);
	$save_email = filter_var( $email,FILTER_SANITIZE_EMAIL);
	if($save_email != $email)
	{
		$this->good = false;
		$this->error_email = "Ten adres e-mail nie jest poprawny!";
	}
	else
		$this->save_email = $email;
}
function EmailIsAlready()
{
	require ("connect.php");
	$result = $this->connect_to_DB->query( "SELECT * FROM user WHERE email='" . $this->save_email . "'");
	
	if($result->num_rows > 0)
	{
		$this->good = false;
		$this->error_email = "Już jest konto o taki adresie e-mail!";
	}
	else
		$result->free();
}
function VerifyLengthPassword($password) // RUN BEFORE FUNCTION SamePassword()
{
	$this->password = $password;
	if(strlen( $this->password) < 8)
	{
		$this->good = false;
		$this->error_password = "Hasło jest za powino zawierać minimalnnie 8 znaków!";
	}
}
function SamePassword($repeat_password) // RUN ONLY AFTER function VerifyPassword()
{
	if($this->password != $repeat_password)
	{
		$this->good = false;
		$this->error_password = '<div class="bad">Hasła nie są takie same!</div>';
	}
}
function ConnectInsert()
{
	if($this->good == true)
	{
		$this->save_email = $this->connect_to_DB->real_escape_string( $this->save_email);
		$this->name = $this->connect_to_DB->real_escape_string( $this->name);
		$this->name = htmlentities( $this->name);
		
		if($result = $this->connect_to_DB->query( "INSERT INTO user VALUES(NULL,'" . $this->save_email . "','" . password_hash( $this->password,PASSWORD_DEFAULT) . "','" . $this->name . "','0','0','0',false)"))
		{
			$rezultat = $this->connect_to_DB->query( "SELECT * FROM user WHERE email='" . $this->save_email . "'");
			$array = $rezultat->fetch_assoc();
			$rezultat->free();
			return array (
					$array ['id'],
					$this->email,
					$this->name 
			);
		}
	}
}
function CreateDir($id)
{
	if($this->good == true)
	{
		mkdir( "Upload/" . $id,0777);
		mkdir( "Upload/" . $id . "/img",0777);
		mkdir( "Upload/" . $id . "/muzyka",0777);
		mkdir( "Upload/" . $id . "/filmy",0777);
		
		fopen( "Upload/" . $id . "/index.php","w+");
		fopen( "Upload/" . $id . "/img/index.php","w+");
		fopen( "Upload/" . $id . "/filmy/index.php","w+");
		fopen( "Upload/" . $id . "/muzyka/index.php","w+");
		return "true";
	}
}
function ReturnError()
{
	return array (
			$this->error_password,
			$this->error_email 
	);
}
}
?>
