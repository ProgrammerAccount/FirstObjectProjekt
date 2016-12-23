<?php session_start();?>
<html>
<head>
<!--Style css-->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/css/fontello.css" type="text/css">
<!--Fonts-->
<link
	href='https://fonts.googleapis.com/css?family=Lobster&subset=latin,latin-ext'
	rel='stylesheet' type='text/css'>
<meta charset="utf-8" />
<meta name="viewport"
	content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />

<title>HostBook</title>
<style>
#inputContainer {
	float: left;
	width: 285px;
	border-radius: 5px;
	background-color: white;
	margin-left: 10px;
}
</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row header">
			<div id="col-xs-12 header">
				<div id="col-xs-6">
					<div id="Logo"> Witaj w swoim konciku <?php echo $_SESSION ['userName'] ?></div>


					<form class="form" action="" method="GET">
						<input type="text" style="float: left;" name="FindingUser"
							placeholder="Znajdz Znajomego!" />
						<button type="submit" style="padding: 0; margin: 0; height: 32px;">
							<i class="demo-icon icon-search-1"></i>
						</button>

					</form>


				</div>
				<ul>
					<li>Pokaż listę wyników

						<ul>
		<?php
		if((isset( $_GET ['FindingUser'])) && ($_GET ['FindingUser'] != ""))
		{
			require 'serach.php';
			$serachEngine = new serachEngine();
			$serachEngine->serachUser( $_GET ['FindingUser']);
			$serachEngine->showresult();
			unset( $_GET ['FindingUser']);
		}
		?>
						</ul>
					</li>


				</ul>
			</div>
		</div>

		<div style="clear: both"></div>
		<div class="row">
			<a href="muzyka.php"><div class="col-xs-3 TopNavigaition">Muzyka</div></a>
			<a href="filmy.php"><div class="col-xs-3 TopNavigaition">Filmy</div></a>
			<a href="img.php"><div class="col-xs-3 TopNavigaition">Zdjecia</div></a>
			<a href="wyloguj.php"><div class="col-xs-3 TopNavigaition"
					style="border: none;">Wyloguj się</div></a>

		</div>
		<h2 style="text-align: center;">Witaj, To miejsce gdzie możesz
			zgromadzić</h2>
		<div style="margin: auto; text-align: center;">

			<div class="podpis">
				Muzyke <a href="muzyka.php"><div class="zakladki">
						<i style="font-size: 48px;" class="demo-icon icon-note"> </i>
					</div></a>
			</div>
			<div class="podpis">
				Filmy <a href="filmy.php"><div class="zakladki">
						<i style="font-size: 48px;" class="demo-icon icon-video"></i>
					</div></a>
			</div>
			<div class="podpis">
				Zdjecia <a href="img.php"><div style="margin-right: 0;"
						class="zakladki">
						<i style="font-size: 48px;" class="demo-icon icon-picture"></i>
					</div></a>
			</div>
		</div>
	</div>
</body>
</html>