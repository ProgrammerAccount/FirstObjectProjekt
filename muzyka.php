<?php

session_start();
if(!isset($_SESSION['zalogowany']))
{
  header("Location: index.php");
    exit;
}

function ShowMusic($id)
{
	require_once 'connect.php';
	$connect= new mysqli($host,$user,$pass,$base);
	if($connect->connect_error)
	{
		echo "ERROR:".$connect->connect_errno;
	}
	else 
	{
	$result=$connect->query("SELECT * FROM Music WHERE id_user='".$_SESSION['idUser']."' ORDER BY id DESC ");
	$connect->close();
	$how_mutch=$result->num_rows;
	for($i=0;$i<$how_mutch;$i++)
	{
		$arrayWithResult=$result->fetch_assoc();
		
		echo '<div class="music">';
		echo '<form action="delete.php" method="POST">';
		echo '<input type="hidden" name="file_name" value="'.$arrayWithResult['file_name'].'">';
		echo '<input type="hidden" name="id_user" value="'.$_SESSION['idUser'].'">';
		echo '<input type="hidden" name="id_file" value="'.$arrayWithResult['id'].'">';
		echo '<input type="hidden" name="whereIsFileToDelete" value="Music">';//img or Music
		echo '<input type="submit"  value="Usuń">';
		
		echo "</form>";
		echo '<div class="info">';
		if($arrayWithResult['title'])
		echo "<br/>Tytuł: ".$arrayWithResult['title'];
		if($arrayWithResult['description'])
		echo "<br/>Opis ".$arrayWithResult['description'];

	
	
		echo '<audio controls>';
		echo '<source src="Upload/'.$_SESSION['idUser'].'/muzyka/'.$arrayWithResult['file_name'].'" type="audio/mpeg">';
		echo '</audio>'; 
		
		echo '</div>';
	
		
	}
	$result->free();
	}


}
?>
<html>
<head>
<style>
.info
{
width:300px;
position:realative;
float:left;
}
.film
{
width:300px;
position:realative;
float:left;
}
.music
{
margin-left:auto;
margin-right:auto;
width:800px;
height:180px;
margin-top:50px;
border-top: 20px solid gray;
}
</style>
  <!--Style css-->
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/css/fontello.css" type="text/css">
    <!--Fonts-->
    <link ouhref='https://fonts.googleapis.com/css?family=Lobster&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
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
     <a href="img.php"><div class="menu">Filmy</div></a>
     <a href="img.php"><div class="menu">Zdjecia</div></a>
     <a href="wyloguj.php"><div class="menu">Wyloguj się</div></a>
  </div>
    <main>
		<h4 style="text-align:center;"><a href="UploadMusic.php">Dodaj muzyke</a></h4>
		<?php 
		ShowMusic($_SESSION['idUser']);
		?>
		<div style="clear: both;"></div>
		
  	</main>
</body>
</html>
