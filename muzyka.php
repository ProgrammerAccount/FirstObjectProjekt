<?php
session_start();
if(! isset( $_SESSION ['zalogowany']))
{
	header( "Location: index.php");
	exit();
}

?>
<html>
<head>
<style>
.info {
	width: 300px;
	position: realative;
	float: left;
}

.film {
	width: 300px;
	position: realative;
	float: left;
}

.music {
	margin-left: auto;
	margin-right: auto;
	width: 800px;
	height: 180px;
	margin-top: 50px;
	border-top: 20px solid gray;
}
</style>
<!--Style css-->
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/css/fontello.css" type="text/css">
<!--Fonts-->
<link
	ouhref='https://fonts.googleapis.com/css?family=Lobster&subset=latin,latin-ext'
	rel='stylesheet' type='text/css'>
<meta charset="utf-8" />
<title>HostBook</title>
</head>
<body>

	<div id="header">
     Witaj w swoim konciku
       <?php echo $_SESSION['userName']; ?>


   </div>
	<div id="menu">
		<a href="muzyka.php"><div class="menu"
				style="border-left: 2px dotted blue;">Muzyka</div></a> <a
			href="filmy.php"><div class="menu">Filmy</div></a> <a href="img.php"><div
				class="menu">Zdjecia</div></a> <a href="wyloguj.php"><div
				class="menu">Wyloguj się</div></a>
	</div>
	<main>
	<h4 style="text-align: center;">
		<a href="UploadMusic.php">Dodaj muzyke</a>
	</h4>
	    <?php
					$id = $_SESSION ['idUser'];
					require 'showfiles.php';
					$showfilms = new audio();
					$how_mutch_films = $showfilms->HowMutchFiles( "SELECT * FROM Music WHERE id_user='" . $id . "' ORDER BY id DESC");
					$showfilms->TakeResult();
					for($i = 0;$how_mutch_films > $i;$i++)
					{
						$showfilms->ShowFiles( $i,$id);
					}
					
					?>
		<div style="clear: both;"></div>

	</main>
</body>
</html>
