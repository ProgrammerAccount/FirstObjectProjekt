<?php
session_start();
if(!isset($_SESSION['zalogowany']))
{
  header("Location: index.php");
    exit;
}
require_once('ConnectSQL.php');
$result=SQLConnect("SELECT * FROM img WHERE id_user='".$_SESSION['id']."' AND file_name='".$_POST['file_name']."' AND id='".$_POST['id_img']."'");
  
  
    
      if($result->num_rows>0)
      {
        $tab=$result->fetch_assoc();

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
     <a href="img.php"><div class="menu" style="border-left: 2px dotted blue;">Muzyka</div></a>
     <a href="img.php"><div class="menu">Filmy</div></a>
     <a href="img.php"><div class="menu">Zdjecia</div></a>
     <a href="wyloguj.php"><div class="menu">Wyloguj się</div></a>
  </div>
    <main>
      <?php
      echo '<div style="float:left; margin-left:50px;" class="img"><img  class="img_size" src="'.$_POST['source'].'" /></div>';
      echo   '<form action="UpdatePicture.php" method="POST">';
      echo '<input value="'.$tab['comment'].'" type="text"name="comment" placeholder="komentarz "  maxlength="50"><br/>';
      echo '<input  value="'.$tab['Name'].'" type="text"name="name" placeholder="Nazwa Zdjecia" maxlength="10"><br/>';
      echo '<input value="'.$tab['place'].'" type="text"name="place" placeholder="Miejsce"  maxlength="30"><br/>';
      echo '<input value="'.$tab['date'].'" type="text"name="data" placeholder="Data" maxlength="30"><br/>';
      echo '<input type="submit" value="Zapisz">       <input type="hidden" name="id_img" value="'.$_POST['id_img'].'">';
      echo' <input type="hidden" name="file_name" value="'.$_POST['file_name'] .'"></form>';
      ?>
    </main>
</body>
</html>
