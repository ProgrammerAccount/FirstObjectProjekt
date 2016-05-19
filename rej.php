<?php
session_start();
if((!isset($_POST['login']))&&(!isset($_POST['pass'])))
{
header("Location: index.php");
}
require("rejFunction.php");
$rej= new Rejstracja;
$rej->email=$_POST['login'];
$rej->password=$_POST['pass'];
$rej->repeat_password=$_POST['passv2'];
$rej->name=$_POST['name'];

$rej->VerifyEmial();
$rej->VerifyOther();
list($id,$email,$name)=$rej->ConnectInsert();
$rej->CreateDir($id);
if($rej->good==true)
{
  $_SESSION['zalogowany']=true;
  $_SESSION['id']=$id;
  $_SESSION['email']=$email;
  $_SESSION['name']=$name;
  header("Location:home.php");
}
else {
  header("Location:index.php");
}

?>
