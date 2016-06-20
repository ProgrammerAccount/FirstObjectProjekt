<?php
session_start();
if(!isset($_SESSION['zalogowany']))
{
  header("Location: index.php");
    exit;
}
?>
<html>
<head>
  <!--Style css-->
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/css/fontello.css" type="text/css">
    <!--Fonts-->
    <link href='https://fonts.googleapis.com/css?family=Lobster&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
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
<h2 style="text-align:center;">Witaj, To miejsce gdzie możesz zgromadzić<p>    </p></h2>
<div style="margin: auto; text-align:center; ">

<div class="podpis">
Muzyke
<a href="muzyka.php"><div class="zakladki"><i style="font-size:48px;" class="demo-icon icon-note"> </i></div></a></div>
<div class="podpis">
Filmy
<a href="filmy.php"><div class="zakladki"><i style="font-size:48px;" class="demo-icon icon-video"></i></div></a></div>
<div class="podpis">
Zdjecia
<a href="img.php"><div style="margin-right:0;" class="zakladki"><i style="font-size:48px;" class="demo-icon icon-picture"></i></div></a></div>
</div>
  </main>
</body>
</html>
