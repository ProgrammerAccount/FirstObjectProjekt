<?php
session_start();
if(!isset($_SESSION['zalogowany']))
{
  header("Location: index.php");
    exit;
}
if(!isset($_POST['nr_id']))
$idFile=0;
else $idFile=($_POST['nr_id']-1)*5;

?>
<html>
<head>


  <!--Style css-->
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/css/fontello.css" type="text/css">
    <!--Fonts-->
  <link href='https://fonts.googleapis.com/css?family=Lato:700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lobster&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<meta charset="utf-8"/>
<title>HostBook</title>
<style>
.video{
  object-fit: initial;
  width: 640px;
  height: 400px;
  margin-top:50px;

}
</style>
</head>
<body>

    <div id="header">
     Witaj w swoim konciku
       <?php echo $_SESSION['userName']; ?>


   </div>
   <div id="menu">
     <a href="muzyka.php"><div class="menu" style="border-left: 2px dotted blue;">Muzyka</div></a>
     <a href="filmy.php"><div class="menu">Filmy</div></a>

     <a href="img.php"><div class="menu">Zdjecia</div></a>
     
     <a href="wyloguj.php"><div class="menu">Wyloguj się</div></a>
  </div>
  <main>
    <a href="UploadFilm.php"><h4 style="text-align:center">Dodaj film</h4></a>
<br/>

    <?php
    $id=$_SESSION['idUser'];
    
   require 'showfiles.php';
    $showfilms= new audio();
  	$showfilms->ConnectToDB();
    $showfilms->HowMutchFiles("SELECT * FROM film WHERE id_user='".$id."' ORDER BY id DESC");
    $showfilms->TakeResult();
    for($i=$idFile;$showfilms->how_mutch_films>$i;$i++)
    {
    	echo $i.'<br/>';
    $showfilms->ShowFiles($i, $id);
    if($i%5==4) break;

    }
    $id_button=$showfilms->how_mutch_films/5;
    if($id_button%5>0)$id_button=$id_button+1;
 	for ($i=1;$id_button>=$i;$i++)
 	{
 		echo '<form method="POST"><input type="submit" name="nr_id" value="'.$i.'"></form><br/>';
 	}
      ?>
  </main>
</body>
</html>
