<?php
session_start();
if((! isset( $_POST ['login'])) && (! isset( $_POST ['pass'])))
{
	header( "Location: index.php");
}
require ("rejFunction.php");
$rej = new Rejstracja();

$rej->name = $_POST ['name'];
$rej->SanitizationEmail( $_POST ['login']);

$rej->EmailIsAlready();
$rej->VerifyLengthPassword( $_POST ['pass']);
$rej->SamePassword( $_POST ['passv2']);
list ( $id, $email, $name ) = $rej->ConnectInsert();
$rej->CreateDir( $id);
list ( $_SESSION ['error_pass'], $_SESSION ['error_email'] ) = $rej->ReturnError();
if($rej->good == true)
{
	$_SESSION ['zalogowany'] = true;
	$_SESSION ['idUser'] = $id;
	$_SESSION ['email'] = $email;
	$_SESSION ['userName'] = $name;
	header( "Location:home.php");
}
else
{
	header( "Location:index.php");
}

?>
