

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
	return $variable;
}
function SendAllToDB($file_name, $where)
{
	$query = sprintf( "INSERT INTO %s VALUES(NULL,'%d','%s','%s','%s')",$this->connect->real_escape_string( $where),$this->connect->real_escape_string( $this->id_user),$this->connect->real_escape_string( $this->title),$this->connect->real_escape_string( $file_name),$this->connect->real_escape_string( $this->description));
	$this->connect->query( $query);
}
}
?>