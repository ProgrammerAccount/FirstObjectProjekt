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
<html lang="pl">
<head>


<!--Style css-->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/css/fontello.css" type="text/css">
<!--<link rel="stylesheet" type="text/css" href="css/styleMobile.css" />
<!--Fonts-->
<link
	href='https://fonts.googleapis.com/css?family=Lato:700&subset=latin,latin-ext'
	rel='stylesheet' type='text/css'>
<link
	href='https://fonts.googleapis.com/css?family=Lobster&subset=latin,latin-ext'
	rel='stylesheet' type='text/css'>
<meta charset="utf-8" />
<meta name="viewport"
	content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<title>HostBook</title>

</head>
<body>
	<div class="container-fluid">
		<div class="row header">
			<div class="col-xs-12 Logo col-centered">
     Witaj w swoim konciku
       <?php echo $_SESSION['userName']; ?>


   </div>
			<div style="clear: both"></div>
		</div>

		<div class="row  col-centered">
			<a href="muzyka.php"><div class="col-xs-3 TopNavigaition">Muzyka</div>
			</a> <a href="filmy.php"><div class="col-xs-3 TopNavigaition">Filmy</div></a>
			<a href="img.php"><div class="col-xs-3 TopNavigaition">Zdjecia</div></a>
			<a href="wyloguj.php"><div class="col-xs-3 TopNavigaition"
					style="border: none;">Wyloguj się</div></a>
		</div>
		<main> <a href="Upload.php"><h4 style="text-align: center">Dodaj
				zdjecie</h4></a> <br />

<?php

$id = $_SESSION ['idUser'];
require_once 'ImgShow.php';
?>
    </main>

		<div class="row">

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

				$("main").append(this.responseText);
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

		</div>
	</div>
</body>
</html>
<?php
if(! isset( $_GET ['id'])) unset( $_SESSION ['visitator']);
?>
