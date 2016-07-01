<?php
class addMusic 
{
public $artist;
public $album;
public $id_user;	
public $genre;
public $title;
public $hrefToMusic;
//metod
function sanitization($variable)
{
	$variable=htmlentities($variable);
	$variable=filter_var($variable,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	return $variable;
}
function SendAllToDB($file_name)
{
	require_once 'ConnectSQL.php';
	
	SQLConnect("INSERT INTO Music VALUES(NULL,'".$this->id_user."','".$this->artist."','".$this->album."','".$this->genre."','".$this->title."','".$this->hrefToMusic."','".$file_name."')");
}
}
?>