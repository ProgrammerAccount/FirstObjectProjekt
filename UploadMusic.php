<?php
session_start();
if((!isset($_SESSION['zalogowany']))&&(!isset($_SESSION['id'])))
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

 $upload->GetSize($_FILES['file']['tmp_name']);
 $upload->VerifyFile($upload->concent_type,'audio');
 $upload->ElseName($file_name,$_SESSION['id']);
 $path_to_move_file="Upload/".$_SESSION['id']."/"."muzyka/".$upload->file_name;
 $upload->MoveFile($tmp_name,$path_to_move_file);
}
	if((isset($_POST['artist']))&&($_POST['artist']!="")&&(isset($_POST['title']))&&($_POST['title']!=""))
	{
		require_once 'addMusic.php';

  	$musicUpload= new addMusic();
  	$musicUpload->id_user=$_SESSION['id'];
		$musicUpload->artist=$musicUpload->sanitization($_POST['artist']);
		$musicUpload->album=$musicUpload->sanitization($_POST['album']);
		$musicUpload->genre=$musicUpload->sanitization($_POST['genre']);
		$musicUpload->title=$musicUpload->sanitization($_POST['title']);
		$musicUpload->hrefToMusic=$musicUpload->sanitization($_POST['href']);
		$musicUpload->SendAllToDB($upload->file_name);



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
       <?php echo $_SESSION['name']; ?>


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
  <input type="file" value="Poszukaj pliku" name="file" accept="audio/*">
  <br/>
<input type="text"name="artist" placeholder="Wykonawca "  maxlength="30"><br/>
  <input type="text"name="album" placeholder="Album" maxlength="30"><br/>
  <input type="text"name="genre" placeholder="Gatunek"  maxlength="30"><br/>
   <input type="text"name="title" placeholder="Tytół" maxlength="30"><br/>
   <input type="text"name="href" placeholder="Link do muzyki" maxlength="60"><br/>
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

