<?php
session_start();
if(! isset( $_SESSION ['zalogowany']))
{
	header( "Location: index.php");
	exit();
}
// ZMIEN
require_once ('connect.php');
$connect = new mysqli( $host,$user,$pass,$base);
if($connect->connect_error)
{
	echo "ERROR NUMER: " . $connect->connect_errno;
}
else
	$result = $connect->query( "SELECT * FROM img WHERE id_user='" . $_SESSION ['idUser'] . "' AND file_name='" . $_POST ['file_name'] . "' AND id='" . $_POST ['id_img'] . "'");

if($result->num_rows > 0)
{
	$arrayWithResult = $result->fetch_assoc();
	$result->free();
}

?>
<html>
<head>
<!--Style css-->
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/css/fontello.css" type="text/css">
<!--Fonts-->
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
			href="img.php"><div class="menu">Filmy</div></a> <a href="img.php"><div
				class="menu">Zdjecia</div></a> <a href="wyloguj.php"><div
				class="menu">Wyloguj się</div></a>
	</div>
	<main>
      <?php
						echo '<div style="float:left; margin-left:50px;" class="img"><img  class="img_size" src="' . $_POST ['source'] . '" /></div>';
						echo '<form action="UpdatePicture.php" method="POST">';
						echo '<input value="' . $arrayWithResult ['comment'] . '" type="text"name="comment" placeholder="komentarz "  maxlength="50"><br/>';
						echo '<input  value="' . $arrayWithResult ['Name'] . '" type="text"name="name" placeholder="Nazwa Zdjecia" maxlength="10"><br/>';
						echo '<input value="' . $arrayWithResult ['place'] . '" type="text"name="place" placeholder="Miejsce"  maxlength="30"><br/>';
						echo '<input value="' . $arrayWithResult ['date'] . '" type="text"name="data" placeholder="Data" maxlength="30"><br/>';
						echo '<input type="submit" value="Zapisz">       <input type="hidden" name="id_img" value="' . $_POST ['id_img'] . '">';
						echo ' <input type="hidden" name="file_name" value="' . $_POST ['file_name'] . '"></form>';
						?>
    </main>
</body>
</html>
