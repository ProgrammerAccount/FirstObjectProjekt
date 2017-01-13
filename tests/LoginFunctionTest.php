<?php
require "./LoginFunction.php";
class LoginFunctionTest extends PHPUnit_Framework_TestCase
{
	public function testLoginPassVerifyAndConnect()
	{	$good=false;
		$obj = new Login();
		if($obj->LoginPassVerifyAndConnect("tymek.janiak@wp.pl","Tymoteuszasddassda0220"))
			$good=true;
		$this->assertTrue($var);


	}
}




?>