

<?php
class addMusic
{
public $id_user;
public $description;
public $title;
protected $connect;
// metod
function __construct()
{
	require ("connect.php");
	$this->connect = new mysqli( $host,$user,$pass,$base);
	if($this->connect->connect_error)
	{
		echo "Error :" . $this->connect->connect_error;
		exit();
	}
}
function __destruct()
{
	$this->connect->close();
}
function sanitization($variable)
{
	$variable = htmlentities( $variable);
	$variable = filter_var( $variable,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
	$variable = $this->connect->real_escape_string( $variable);
	return $variable;
}
function SendAllToDB($sqlQuery)
{
	$this->connect->query( $sqlQuery);
}
}
?>