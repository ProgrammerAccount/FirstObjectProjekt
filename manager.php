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
       <?php echo $_SESSION['userName']; ?>


   </div>
   <div id="menu">
     <a href="muzyka.php"><div class="menu" style="border-left: 2px dotted blue;">Muzyka</div></a>
     <a href="filmy.php"><div class="menu">Filmy</div></a>
     <a href="img.php"><div class="menu">Zdjecia</div></a>
     <a href="wyloguj.php"><div class="menu">Wyloguj się</div></a>
  </div>
    <main>
      
<div id="ContainserForImage">
        <form action="edit.php" method="POST">
          <button  type="submit" >
            <i style="font-size:48px;" class="demo-icon icon-pencil" > </i>
          </button>
        <input type="hidden" name="id_img" value="<?php echo $_POST['id_img'] ?>">
        <input type="hidden" name="file_name" value="<?php echo $_POST['file_name'] ?>">
        <input type="hidden" name="source" value="<?php echo $_POST['source'] ?>">

      </form>
      <?php
     
        echo '<div style="float:left;" class="img"><img style="float:left;" class="img_size" src="'.$_POST['source'].'" /></div>';



      ?>

      <form action="delete.php" onclick='confirm("Czy naperno chcesz usunąć to zdjecie")' method="POST">
        <button type="submit">
          <i style="font-size:48px;" class="demo-icon icon-trash-empty" > </i>
        </button>
      <input type="hidden" name="id_file" value="<?php echo $_POST['id_img'] ?>">
      <input type="hidden" name="file_name" value="<?php echo $_POST['file_name'] ?>">
      <input type="hidden" name="whereIsFileToDelete" value="img"><!--img or Music-->

    </form>
   </div>

    </main>
</body>
</html>
