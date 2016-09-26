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


<!--Style css-->
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/css/fontello.css" type="text/css">
<!--Fonts-->
<link
	href='https://fonts.googleapis.com/css?family=Lato:700&subset=latin,latin-ext'
	rel='stylesheet' type='text/css'>
<link
	href='https://fonts.googleapis.com/css?family=Lobster&subset=latin,latin-ext'
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
	<main> <a href="Upload.php"><h4 style="text-align: center">Dodaj
			zdjecie</h4></a> <br />

<?php
$id = $_SESSION ['idUser'];
require 'showfiles.php';
$showfilms = new img();
$how_mutch_films = $showfilms->HowMutchFiles( "SELECT * FROM img WHERE id_user='" . $id . "' ORDER BY id DESC");
$showfilms->TakeResult();
for($i = 0;$how_mutch_films > $i;$i++)
{
	$showfilms->ShowFiles( $i,$id);
}
?>
</main>
</body>
</html>
