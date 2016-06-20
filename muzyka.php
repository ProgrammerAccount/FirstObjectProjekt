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
	$result=$connect->query("SELECT * FROM Music WHERE id_user='".$_SESSION['id']."' ");
	$connect->close();
	$how_mutch=$result->num_rows;
	for($i=0;$i<$how_mutch;$i++)
	{
		$arrayWithResult=$result->fetch_assoc();
		
		echo '<div class="music">';
		echo '<div class="info">';
		echo "<br/>Wykonawca: ".$arrayWithResult['artist'];
		echo "<br/>Album: ".$arrayWithResult['album'];
		echo "<br/>Gatunek: ".$arrayWithResult['genre'];
		echo "<br/>Tytuł: ".$arrayWithResult['title'];
		echo '<br/>Link: <a target="_blank" href="'.$arrayWithResult['href'].'">Link do utworu</a>';
		
		echo '</div>';
			if(strstr($arrayWithResult['href'], 'youtube'))
		{
		$href=str_replace("watch?v=", 'embed/', $arrayWithResult['href']);
		echo '<div class="film" ><iframe width="280" height="155"  src="'.$href.'" frameborder="0" allowfullscreen></iframe></div>';
		}
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
       <?php echo $_SESSION['name']; ?>


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
		ShowMusic($_SESSION['id']);
		?>
		<div style="clear: both;"></div>
		
  	</main>
</body>
</html>
