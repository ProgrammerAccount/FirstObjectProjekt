<?php
session_start();
if((!isset($_SESSION['zalogowany']))&&(!isset($_POST['name'])))
{
  header("Location: index.php");
    exit;
}
require("connect.php");
$connect= new mysqli($host,$user,$pass,$base);
if($connect->connect_error)
{
  echo "Error".$connect->connect_errno;
}
else
{
$connect->query("UPDATE img SET date='".$_POST['data']."', comment='".$_POST['comment']."',name='".$_POST['name']."',place='".$_POST['place']."' WHERE id_user='".$_SESSION['id']."' AND file_name='".$_POST['file_name']."' AND id='".$_POST['id_img']."'");
echo "UPDATE img SET date='".$_POST['data']."', comment='".$_POST['comment']."',name='".$_POST['name']."',place='".$_POST['place']."' WHERE id_user='".$_SESSION['id']."' AND file_name='".$_POST['file_name']."' AND id='".$_POST['id_img']."'";
$connect->close();
//header("Location:img.php");
}
?>
