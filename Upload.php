<?php
session_start();

if ((! isset($_SESSION['zalogowany'])) && (! isset($_SESSION['idUser'])))
{
    header("Location: index.php");
  
}

require ("connect.php");
$connect_to_DB = new mysqli($host, $user, $pass, $base);
if ($connect_to_DB->connect_error)
{
    echo "Error:" . $connect_to_DB->connect_errno;

}
else 
{

    if ((isset($_FILES['file'])))
    {


        require ("Upload_function.php");

        print_r( $_FILES["file"]);
      	$tmp_name=$file_name = $_FILES['file']['tmp_name'];
        $file_name = $_FILES['file']['name'];
        $data = $_POST['data'];

        // Wywoływanie klasy Upload
        $upload = new ReadyFileToUpload($file_name, $tmp_name);
        $comment = $upload->SanitizationText($_POST['comment'], 50);
        $name = $upload->SanitizationText($_POST['name'], 20);
        $place = $upload->SanitizationText($_POST['place'], 30);

       // $upload->GetSize();
        $upload->VerifyTypeFile('image');
        $upload->VerifyName("img");
        $upload->ValideDate($data);

        $upload->MoveFile($_SESSION['idUser'],"img");
        

        if ($upload->good == true)
        {
            if (!isset($_POST['private']))
            {
                $checkbox = false;
            } 
            else
            {
                $checkbox = true;
           }

            $sql_query = "INSERT INTO img VALUES(NULL,'" . $_SESSION['idUser'] ."','" . $upload->file_name . "','" . DATE($data) . "','" .$place . "','" . $comment . "','". $checkbox . "')";
            echo $sql_query;

            $connect_to_DB->query($sql_query);
        }

   }
}

?>
<html>
<head>
<!--Style css-->

<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/css/fontello.css" type="text/css">
<link rel="stylesheet" href="css/UploadInput.css" type="text/css">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!--Fonts-->
<link
	href='https://fonts.googleapis.com/css?family=Lobster&subset=latin,latin-ext'
	rel='stylesheet' type='text/css'>
<meta charset="utf-8" />
<title>HostBook</title>
<meta name="viewport"
	content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />

</head>
<body>
	<div class="container-fluid">
		<div class="row header col-centered">
     Witaj w swoim konciku
       <?php

    echo $_SESSION['userName'];
    ?>



   </div>
		<div class="row">
			<a href="muzyka.php"><div class="col-xs-3 TopNavigaition">Muzyka</div></a>
			<a href="filmy.php"><div class="col-xs-3 TopNavigaition">Filmy</div></a>
			<a href="img.php"><div class="col-xs-3 TopNavigaition">Zdjecia</div></a>
			<a href="wyloguj.php"><div class="col-xs-3 TopNavigaition"
					style="border: none;">Wyloguj się</div></a>
		</div>
		<main style="text-align:center;">
		<div class="form-group">
			<form method="post" class="form-group" name="UploadImg" action="" 
				enctype="multipart/form-data">
				<div class="col-xs-4 col-centered">
					<input type="file" value="Poszukaj pliku" name="file"
						accept="image/*">
				</div>
				<br />
				<div class="col-xs-4 col-centered">
					<input type="text" class="form-control" name="comment"
						placeholder="komentarz " maxlength="50">
				</div>
				<br />
				<div class="col-xs-4 col-centered">
					<input type="text" class="form-control" name="name"
						placeholder="Nazwa Zdjecia" maxlength="20">
				</div>
				<br />
				<div class="col-xs-4 col-centered">
					<input class="form-control" type="text" name="place"
						placeholder="Miejsce" maxlength="30">
				</div>
				<br />
				<div class="col-xs-4 col-centered">
					<input type="data" class="form-control" name="data"
						pattern="[0-9]{4}.[0-9]{2}.[0-9]{2}" placeholder="Data yyyy.mm.dd"
						maxlength="30">
				</div>
				<br />
				<div class="col-xs-4 col-centered">
					Public <input type="checkbox" class="form-control" name="private"
						maxlength="30">
				</div>
				<br />

		</div>

		<div id="errors">
<?php
if (isset($upload->error_verify)) {
    echo $upload->error_verify;
    unset($upload->error_verify);
}
if (isset($sizeError)) {
    echo $sizeError;
    unset($sizeError);
}
?>
</div>



		<input type="submit" value="Wyslij Plik">



		</form>
		</main>

	</div>


</body>
</html>

