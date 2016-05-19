<?php
session_start();
if(!isset($_SESSION['zalogowany']))
{
  header("Location: index.php");
    exit;
}

require_once('connect.php');
$connect=new mysqli($host,$user,$pass,$base);
if($connect->connect_error)
{
  echo "Error ".$connect->connect_errno;
}
else
  {
    $id_img=$_POST['id_img'];
    $id_user=$_SESSION['id'];
    $return=$connect->query("DELETE FROM img WHERE id='".$id_img."' AND id_user='".$id_user."' AND file_name='".$_POST['file_name']."'");
    $connect->close();
    header("Location:img.php");
}
 ?>

