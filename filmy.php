<?php
session_start();
if(! isset( $_SESSION ['zalogowany']))
{
	header( "Location: index.php");
	exit();
}
if(! isset( $_POST ['nr_id']))
	$idFile = 0;
else $idFile = ($_POST ['nr_id'] - 1) * 5;

?>
<html>
<head>

<!--Style css-->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/css/fontello.css" type="text/css">
<link rel="stylesheet" href="css/styleMobile.css" type="text/css">

<!--Fonts-->
<link
	href='https://fonts.googleapis.com/css?family=Lato:700&subset=latin,latin-ext'
	rel='stylesheet' type='text/css'>
<link
	href='https://fonts.googleapis.com/css?family=Lobster&subset=latin,latin-ext'
	rel='stylesheet' type='text/css'>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />

<title>HostBook</title>
<style>
.video {
	object-fit: initial;
}

.numer_list {
	display: inline;
}
</style>
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
			<a href="muzyka.php"><div class="col-xs-3 TopNavigaition" style="border-left: 2px solid gray;">Muzyka</div>
			</a> <a href="filmy.php"><div class="col-xs-3 TopNavigaition">Filmy</div></a>
            <a href="img.php"><div class="col-xs-3 TopNavigaition">Zdjecia</div></a>
            <a href="wyloguj.php"><div class="col-xs-3 TopNavigaition">Wyloguj	się</div></a>
		</div>
		<div style="clear: both"></div>
		<a href="UploadFilm.php"><h4 style="text-align: center">Dodaj Film</h4></a>

		</br>
		<div class="row" style="text-align: center;">
     
       <?php
							require_once 'showfiles.php';
							$showFilms = new film();
							$showFilms->CallToDB( "SELECT * FROM film WHERE id_user='" . $_SESSION ['idUser'] . "'");
							$showFilms->TakeResult();
							$i = 0;
							for($i = 0;$showFilms->result->num_rows > $i;$i++)
							{
								
								$showFilms->ShowFiles( $i,$_SESSION ['idUser']);
							}
							// print_r( $showFilms->array_witch_result);
							?>
							  
							    </div>
		<script type="text/javascript">
    window.onload = function()
        {
        var uchwyt = document.getElementsByTagName('video');
        var width=uchwyt[0].offsetWidth;
        var height=parseInt(width*0.5);
        var heightString=String(height)+"px";
            for(var i=0;i<uchwyt.length;i++)
                {
               
                uchwyt[i].style.height=heightString;   
                }
        }
  
    </script>
</div>
</body>
</html>
