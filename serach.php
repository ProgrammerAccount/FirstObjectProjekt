<?php
class serachEngine
{
public $result;
private $connect_to_DB;
public $TableWithResult;
function __construct()
{
	require 'connect.php';
	$this->connect_to_DB = new mysqli( $host,$user,$pass,$base);
	if($this->connect_to_DB->connect_error)
	{
		echo "Error" . $this->connect_to_DB->connect_errno;
		exit();
	}
}
function __destruct()
{
	$this->connect_to_DB->close();
}
function serachUser($email)
{
	$this->result = $this->connect_to_DB->query( "SELECT * FROM user WHERE email LIKE'" . $email . "%' ORDER BY email ASC LIMIT 25 ");
}
function showresult() // Care!!!!!!!!!!!!!!!!!!!!!!!!!!!!! after run this Function U MUST RUN serachUSER!!!!!!!!!!!!!!!!!!!!!!!!!!
{
	if($this->result != false)
	{
		while($this->TableWithResult = $this->result->fetch_assoc())
			echo "<li>" . $this->TableWithResult ['email'] . "</li>";
	}
	unset( $this->TableWithResult);
}
}

?>