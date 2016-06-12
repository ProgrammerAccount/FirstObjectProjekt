<?php
session_start();
if(!isset($_SESSION['zalogowany']))
{
  header("Location: index.php");
    exit;
}

require_once('ConnectSQL.php');
    $id_img=$_POST['id_img'];
    $id_user=$_SESSION['id'];
	SQLConnect("DELETE FROM img WHERE id='".$id_img."' AND id_user='".$id_user."' AND file_name='".$_POST['file_name']."'");
    header("Location:img.php");
 ?>

