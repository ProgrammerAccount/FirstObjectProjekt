<?php
session_start();
if((! isset( $_SESSION ['zalogowany'])) && (! isset( $_SESSION ['idUser'])))
{
	header( "Location: index.php");
	exit();
}

if((isset( $_FILES ['file'])) && ($_FILES ['file'] ['tmp_name']))
{
	require ("Upload_function.php");
	
	$tmp_name = $_FILES ['file'] ['tmp_name'];
	$file_name = $_FILES ['file'] ['name'];
	// Wywoływanie klasy Upload
	$upload = new UploadFile();
	$upload->LoadVariabile( 'file');
	$upload->CheckTypeFile( $tmp_name);
	$sizeError = $upload->size( 10000000);
	$upload->VerifyTypeFile( 'video');
	$upload->ElseNameNIW( $file_name,"film");
	$path_to_move_file = "Upload/" . $_SESSION ['idUser'] . "/" . "filmy/" . $upload->file_name;
	$upload->MoveFile( $tmp_name,$path_to_move_file);
	$file_name = $upload->file_name;
	if($upload->good != false)
	{
		require_once 'addMusic.php';
		$musicUpload = new addMusic();
		$musicUpload->id_user = $_SESSION ['idUser'];
		$musicUpload->title = $musicUpload->sanitization( $_POST ['title']);
		$musicUpload->description = $musicUpload->sanitization( $_POST ['description']);
		$musicUpload->SendAllToDB( $file_name,"film");
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
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />

</head>
<body>
<div class="container-fluid">
		<div class="row header col-centered">
     Witaj w swoim konciku
       <?php echo $_SESSION['userName']; ?>


   </div>
	<div class="row">
		<a href="muzyka.php"><div class="col-xs-3 TopNavigaition"
				>Muzyka</div></a><a
			href="filmy.php"><div class="col-xs-3 TopNavigaition">Filmy</div></a> <a href="img.php"><div
				class="col-xs-3 TopNavigaition">Zdjecia</div></a> <a href="wyloguj.php"><div
				class="col-xs-3 TopNavigaition" style="border:none;">Wyloguj się</div></a>
	</div>
	<main style="text-align:center;">
       <div class="form-group">
		<form method="post" class="form-group" name="UploadImg" enctype="multipart/form-data">
            <div class="col-xs-4 col-centered">
			<input  type="file" value="Poszukaj pliku" name="file"	accept="video/*"> 
            </div><br/>
            <div class="col-xs-4 col-centered">
            <input type="text"  class="form-control" name="title" placeholder="Tytół" maxlength="30">
            </div><br/>
            <div class="col-xs-4 col-centered">
            <input type="text"   class="form-control" name="description" placeholder="opis" maxlength="60">
            </div><br/>
            <div class="col-xs-4 col-centered">
			<input type="submit" value="Wyslij Plik">
            </div><br/>
 
                


			<div id="errors">
<?php
if(isset( $upload->error_verify))
{
	echo $upload->error_verify;
	unset( $upload->error_verify);
}
if(isset( $sizeError))
{
	echo $sizeError;
	unset( $sizeError);
}
?>

</div>
	
	</div>
	</form>



	</main>

    </body>
</html>



