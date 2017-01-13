<?php
    require'./showfiles.php';

            

class showfilesTest extends PHPUnit_Framework_TestCase {
    public function testCallToDB() {
    	$obj = new img;
    	$obj->CheckNumRows();
    	$this->assertTrue($obj->CallToDB( "SELECT * FROM img WHERE idUser='1' ORDER BY id DESC LIMIT 5 " ));
    	$this->assertTrue(is_numeric($obj->numrows));
    }

}
?>