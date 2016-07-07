<?php
session_start();
if(!isset($_SESSION['zalogowany']))
{
  header("Location: index.php");
    exit;
}

require_once('ConnectSQL.php');
    $id_img=$_POST['id_file'];
    $id_user=$_SESSION['idUser'];
	SQLConnect("DELETE FROM ".$_POST['whereIsFileToDelete']." WHERE id='".$id_img."' AND id_user='".$id_user."' AND file_name='".$_POST['file_name']."'");
    switch ($_POST['whereIsFileToDelete'])
    {
    	case "img": header("Location:img.php");
    	break;
    	case "Music": header("Location:muzyka.php");
    	break;
    		
    }
 ?>

