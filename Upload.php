<?php
session_start();
if((!isset($_SESSION['zalogowany']))&&(!isset($_SESSION['idUser'])))
{
  header("Location: index.php");     exit;
}



if((isset($_FILES['file']))&&($_FILES['file']['tmp_name']))
{
require("Upload_function.php");


 $tmp_name=$_FILES['file']['tmp_name'];
 $file_name=$_FILES['file']['name'];
 //Wywoływanie klasy Upload
 $upload= new UploadFile;
 $upload->LoadVariabile('file');
 $upload->CheckTypeFile($tmp_name);
 $comment=$upload->VerifyText($_POST['comment'],50);
 $name=$upload->VerifyText($_POST['name'],20);
 $data=$_POST['data'];

 $place=$upload->VerifyText($_POST['place'],30);
 $upload->GetSize($_FILES['file']['tmp_name']);
 $upload->VerifyFile($upload->concent_type,'image');
 $upload->ElseName($file_name,$_SESSION['idUser']);
 $path_to_move_file="Upload/".$_SESSION['idUser']."/"."img/".$upload->file_name;
 $upload->MoveFile($tmp_name,$path_to_move_file);
 echo $upload->ValideDate($data);

 


   if($upload->good==true)
 {


$sql_query="INSERT INTO img VALUES(NULL,'".$_SESSION['idUser']."','".$upload->file_name."','".DATE($data)."','".$place."','".$comment."','".$name."')";
require_once('ConnectSQL.php');
SQLConnect($sql_query);
  }
 }
 

?>
<html>
<head>
  <!--Style css-->

  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/css/fontello.css" type="text/css">
  <link rel="stylesheet" href="css/UploadInput.css" type="text/css">
 

    <!--Fonts-->
    <link href='https://fonts.googleapis.com/css?family=Lobster&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<meta charset="utf-8"/>
<title>HostBook</title>
</head>
<body>

    <div id="header">
     Witaj w swoim konciku
       <?php echo $_SESSION['userName']; ?>


   </div>
   <div id="menu">
     <a href="muzyka.php"><div class="menu" style="border-left: 2px dotted blue;">Muzyka</div></a>
     <a href="img.php"><div class="menu">zdjecia</div></a>
     <a href="img.php"><div class="menu">Filmy</div></a>
     <a href="wyloguj.php"><div class="menu">Wyloguj się</div></a>
  </div>
  <main>
    <div id="containerForinput">
<form  method="post" name="UploadImg" enctype="multipart/form-data"  > 
  <input type="file" value="Poszukaj pliku" name="file" accept="image/*">
  <br/>
  <input type="text"name="comment" placeholder="komentarz "  maxlength="50"><br/>
  <input type="text"name="name" placeholder="Nazwa Zdjecia" maxlength="20"><br/>
  <input type="text"name="place" placeholder="Miejsce"  maxlength="30"><br/>
  <input type="data"name="data"   pattern="[0-9]{4}.[0-9]{2}.[0-9]{2}" placeholder="Data yyyy.mm.dd" maxlength="30"><br/>
<div id="errors"></div>



    <input type="submit" value="Wyslij Plik">
    </div>
 </form>
 <script>
  function CheckDate()
  {
	var date=document.getElementsByName('data').value;
	var test= new RegExp("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/");
	document.getElementById("errors").innerHTML=date.length;
	if(!test.test(date))
	{
	var DateToday=new Date();
	var year=	DateToday.getFullYear();
	var month=	DateToday.getMonth();
	month++;
	if(month<10) month="0"+month;
	var day=	DateToday.getDate();
	if(day<10) day="0"+day;
	document.getElementById("errors").innerHTML="Data w naszym serwisie musi być zapisywana w nastepujacy sposób np. "+year+"."+month+"."+day;	
 	}
	else
	{
		document.forms['UploadImg'].action = 'Upload.php';
		document.forms['UploadImg'].submit();
		}
}
  
  </script>
<?php
if(isset($upload->error_verify))
{
  echo $upload->error_verify;
  unset($upload);
}

?>

  </main>
  
</body>
</html>
