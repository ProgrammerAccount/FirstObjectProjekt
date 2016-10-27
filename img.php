<?php
session_start();
if(! isset( $_SESSION ['zalogowany']))
{
	header( "Location: index.php");
	exit();
}

?>
<html lang="pl">
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
	<div id="main">
		<a href="Upload.php"><h4 style="text-align: center">Dodaj zdjecie</h4></a>
		<br />

<?php

$id = $_SESSION ['idUser'];
/*
 * require 'showfiles.php';
 * $showfilms = new img();
 * $how_mutch_films = $showfilms->HowMutchFiles( "SELECT * FROM img WHERE id_user='" . $id . "' ORDER BY id DESC LIMIT 5");
 * $showfilms->TakeResult();
 * for($i = 0;$how_mutch_films > $i;$i++)
 * {
 * $showfilms->ShowFiles( $i,$id);
 * }
 */
require_once 'ImgShow.php';
?>
<div id="s"></div>
	</div>


	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script type="text/javascript">
	var loading=true;
	var offset=0;
	$( document ).ready(function() {
	$(window).scroll(function() { //detect page scroll
		var scroll=$(window).scrollTop()+1000;
	    if(scroll >= $(window).height()&&loading==true)  //if user 
	    	{ 
	    	
	    	loading=false;
	    	if (window.XMLHttpRequest)
	    	ConnectAjax= new XMLHttpRequest();
	    	 else 
	    		 ConnectAjax = new ActiveXObject("Microsoft.XMLHTTP");
	    	ConnectAjax.onreadystatechange = function (){
			if(this.readyState==4 && this.status==200)
			{
				
				document.getElementById("main").apped(this.responseText);
			}

		    };
		    offset=offset+5;
		    ConnectAjax.open("GET", "ImgShow.php?q="+offset, true);
		    ConnectAjax.send();

	    	}
	    if(scroll <= $(window).height())  //if user 
    	{ 
    	loading=true;

    	}
	    //document.getElementById("s").innerHTML=$(window).height()+"<br/>"+$(document).height()+"<br/>"+scroll;
				});
	});

	
</script>

</body>
</html>
