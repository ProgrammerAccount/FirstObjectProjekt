<?php

if(! isset( $_SESSION ['idUser'])) session_start();
$id = $_SESSION ['idUser'];
if(isset( $_GET ['q']))
	$offset = $_GET ['q'];
else $offset = 0;
require_once'showfiles.php';
$showfilms = new img();
if(isset( $_SESSION ['visitator']))
{
	$id = htmlentities( $_SESSION ['visitator']);

	$showfilms->CallToDB( "SELECT * FROM img WHERE id_user='" . $id . "' AND private='1' ORDER BY id DESC LIMIT 5 OFFSET " . $offset);
}
else
{
	$showfilms->CallToDB( "SELECT * FROM img WHERE idUser='" . $id . "' ORDER BY id DESC LIMIT 5 OFFSET " . $offset);

}
$showfilms->TakeResult();

for($i = 0;$showfilms->numrows > $i;$i++)
{
	$showfilms->ShowFiles( $i,$id);
}
?>


