<?php
session_start();
if((!isset($_SESSION['zalogowany']))&&(!isset($_SESSION['id'])))
{
  header("Location: index.php");
    exit;
}
if(isset($_FILES['file']))
{
require("Upload_function.php");


 $tmp_name=$_FILES['file']['tmp_name'];
 $file_name=$_FILES['file']['name'];
 //Wywoływanie klasy Upload
 $upload= new UploadFile;
 $upload->LoadVariabile('file');
 $upload->CheckTypeFile($tmp_name);
 $comment_image=$upload->VerifyText($_POST['comment'],50);
 $name=$upload->VerifyText($_POST['name'],20);
 $data=$upload->VerifyText($_POST['data'],30);
 $place=$upload->VerifyText($_POST['place'],30);
 $upload->GetSize($_FILES['file']['tmp_name']);
 $upload->VerifyFile($upload->concent_type,'image');
 $upload->ElseName($file_name);
 $path_to_move_file="Upload/".$_SESSION['id']."/"."img/".$upload->file_name;
 $upload->MoveFile($tmp_name,$path_to_move_file);
 //$upload->test();
 


   if($upload->good==true)
 {

  require("connect.php");
  $connect= new mysqli($host,$user,$pass,$base);
  if($connect->connect_error)
  {
    echo "Error".$connect->connect_errno;
  }
  else
  {

    $comment=$connect->real_escape_string($comment_image);
    $name=$connect->real_escape_string($name);
    $data=$connect->real_escape_string($data);
    $place=$connect->real_escape_string($place);

    $sql="INSERT INTO img VALUES(NULL,'".$_SESSION['id']."','".$upload->file_name."','".$data."','".$place."','".$comment_image."','".$name."')";

    $connect->query($sql);
    $connect->close();
  }
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
       <?php echo $_SESSION['name']; ?>


   </div>
   <div id="menu">
     <a href="img.php"><div class="menu" style="border-left: 2px dotted blue;">Muzyka</div></a>
     <a href="img.php"><div class="menu">zdjecia</div></a>
     <a href="img.php"><div class="menu">Filmy</div></a>
     <a href="wyloguj.php"><div class="menu">Wyloguj się</div></a>
  </div>
  <main>
    <div id="containerForinput">
<form  method="post" enctype="multipart/form-data"  >
  <input type="file" value="Poszukaj pliku" name="file" accept="image/*">
  <br/>
  <input type="text"name="comment" placeholder="komentarz "  maxlength="50"><br/>
  <input type="text"name="name" placeholder="Nazwa Zdjecia" maxlength="20"><br/>
  <input type="text"name="place" placeholder="Miejsce"  maxlength="30"><br/>
  <input type="text"name="data" placeholder="Data" maxlength="30"><br/>




    <input type="submit" value="Wyslij Plik">
    </div>
</form>
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
