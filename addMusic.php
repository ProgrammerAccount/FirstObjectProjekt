

<?php
class addMusic 
{
public $id_user;	
public $description;
public $title;
//metod
function sanitization($variable)
{
	$variable=htmlentities($variable);
	$variable=filter_var($variable,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	return $variable;
}
function SendAllToDB($file_name,$where)
{
	require_once 'ConnectSQL.php';
	
	SQLConnect("INSERT INTO $where VALUES(NULL,'".$this->id_user."','".$this->title."','".$file_name."','".$this->description."')");
}
}
?>