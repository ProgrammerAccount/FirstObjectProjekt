<?php
session_start();
if(! isset( $_SESSION ['zalogowany']))
{
	header( "Location: index.php");
	exit();
}
elseif((isset( $_GET ['id'])) && ($_GET ['id'] != ""))
{
	$_SESSION ['visitator'] = $_GET ['id'];
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
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/css/fontello.css" type="text/css">
<!--Fonts-->
<link
	ouhref='https://fonts.googleapis.com/css?family=Lobster&subset=latin,latin-ext'
	rel='stylesheet' type='text/css'>
<meta charset="utf-8" />
<meta name="viewport"
	content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />

<title>HostBook</title>
</head>
<body>
	<div class="container-fluid">
		<div class="row header col-centered">
			<div class="col-xs-12 Logo">
     Witaj w swoim konciku
       <?php echo $_SESSION['userName']; ?>


   </div>
			<div style="clear: both"></div>
		</div>
		<div class="row">
			<a href="muzyka.php">
				<div class="col-xs-3 TopNavigaition">Muzyka</div>
			</a> <a href="filmy.php">
				<div class="col-xs-3 TopNavigaition">Filmy</div>
			</a> <a href="img.php">
				<div class="col-xs-3 TopNavigaition">Zdjecia</div>
			</a> <a href="wyloguj.php"><div class="col-xs-3 TopNavigaition"
					style="border: none;">>Wyloguj się</div></a>
		</div>
		<main>
		<h4 style="text-align: center;">
			<a href="UploadMusic.php">Dodaj muzyke</a>
		</h4>
	    <?php
					$id = $_SESSION ['idUser'];
					require 'showfiles.php';
					$showfilms = new audio();
					if(isset( $_SESSION ['visitator']))
					{
						$showfilms->CallToDB( "SELECT * FROM Music WHERE id_user='" . $_SESSION ['visitator'] . "' AND private='1' ORDER BY id DESC");
					}
					else
					{
						$showfilms->CallToDB( "SELECT * FROM Music WHERE id_user='" . $id . "' ORDER BY id DESC");
					}
					$showfilms->TakeResult();
					for($i = 0;$showfilms->result->num_rows > $i;$i++)
					{
						$showfilms->ShowFiles( $i,$id);
					}

					?>
		<div style="clear: both;"></div>

		</main>
	</div>
</body>
</html>
