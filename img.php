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
  <link href='https://fonts.googleapis.com/css?family=Lato:700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lobster&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<meta charset="utf-8"/>
<title>HostBook</title>

</head>
<body>

    <div id="header">
     Witaj w swoim konciku
       <?php echo $_SESSION['userName']; ?>


   </div>
   <div id="menu">
     <a href="muzyka.php"><div class="menu" style="border-left: 2px dotted blue;">Muzyka</div></a>
     <a href="img.php"><div class="menu">zdjecia</div></a>
     <a href="img.php"><div class="menu">Filmy</div></a>
     <a href="wyloguj.php"><div class="menu">Wyloguj się</div></a>
  </div>
  <main>
    <a href="Upload.php"><h4 style="text-align:center">Dodaj zdjecie</h4></a>
<br/>

    <?php
    $id=$_SESSION['idUser'];
    require_once('connect.php');
    $connect=new mysqli($host,$user,$pass,$base);
    if($connect->connect_error)
    {
      echo "Error ".$connect->connect_errno;
    }
    else
      {
        $id=$_SESSION['idUser'];
        $ret=$connect->query("SELECT * FROM user WHERE id='".$id."' AND email='".$_SESSION['email']."' AND name='".$_SESSION['userName']."' ");
        
        if($ret->num_rows>0)
        {
        $result=$connect->query("SELECT * FROM img WHERE id_user='".$id."' ORDER BY id DESC ");
        $ile=$result->num_rows;
        if($ile>0)
        {

            while ($ile--)
            {
              $arrayWithResult=$result->fetch_assoc();
              echo '<div class="formContainer">';
              echo '<form action="manager.php" method="POST">';
              echo '<input type="hidden" name="id_img" value="'.$arrayWithResult['id'].'">';
              $source="Upload/".$id."/img"."/".$arrayWithResult['file_name'];
              echo '<input type="hidden" name="opis" value="'.$arrayWithResult['comment'].'">';
              echo '<input type="hidden" name="source" value="'.$source.'">';
              echo '<input type="hidden" name="file_name" value="'.$arrayWithResult['file_name'].'">';
              
              echo '<div class="img"><div class="TestName">';
      			if($arrayWithResult['place']!="")
      			echo "Miejsce:&nbsp".str_replace(" ","&nbsp",$arrayWithResult['place'])."<br/>";
        		if($arrayWithResult['comment']!="")
      			echo "Opis:&nbsp".str_replace(" ","&nbsp",$arrayWithResult['comment'])."<br/>";
      			if($arrayWithResult['Name']!="")
      			echo "Miejsce:&nbsp".str_replace(" ","&nbsp",$arrayWithResult['Name'])."<br/>";
      			if($arrayWithResult['date']!="0000-00-00")
      			echo "Data:&nbsp".str_replace(" ","&nbsp",$arrayWithResult['date'])."<br/>";
      			echo"</div>";
        		echo '<input  alt="Nie znalazłem zdjecia!"  class="img_size" type="image" src="'.$source.'" alt="Submit Form" /> </div>';
              	echo "</form>";
              	echo "</div>";
            }

        }
        $result->free();
        $ret->free();
      }
      }
      ?>
  </main>
</body>
</html>
