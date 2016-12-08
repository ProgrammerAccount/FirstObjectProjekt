<?php
if(! isset( $_SESSION ['idUser'])) session_start();
$id = $_SESSION ['idUser'];
if(isset( $_GET ['q']))
	$offset = $_GET ['q'];
else $offset = 0;
require 'showfiles.php';
$showfilms = new img();
$showfilms->CallToDB( "SELECT * FROM img WHERE id_user='" . $id . "' ORDER BY id DESC LIMIT 5 OFFSET " . $offset);
$how_mutch_films = $showfilms->result->num_rows;
$showfilms->TakeResult();

for($i = 0;$how_mutch_films > $i;$i++)
{
	$showfilms->ShowFiles( $i,$id);
}
?>


