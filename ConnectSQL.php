<?php
function SQLConnect($query)
{
	require("connect.php");
	$connect=new mysqli($host,$user,$pass,$base);
	if($connect->connect_error)
	{
		echo "Error:".$connect->connect_errno; exit;
	}
	else
	{
		
	$connect->real_escape_string($query);
	if($result=$connect->query($query))
	{
	$connect->close();
	return $result;	
	$result->free();
	}
	}
	
}
?>