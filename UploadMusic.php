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
	$upload->VerifyFile( 'audio');
	$upload->ElseNameNIW( $file_name,$_SESSION ['idUser'],"Music");
	$path_to_move_file = "Upload/" . $_SESSION ['idUser'] . "/" . "muzyka/" . $upload->file_name;
	$upload->MoveFile( $tmp_name,$path_to_move_file);
	$file_name = $upload->file_name;
	if($upload->good != false)
	{
		require_once 'addMusic.php';
		$musicUpload = new addMusic();
		$musicUpload->id_user = $_SESSION ['idUser'];
		$musicUpload->title = $musicUpload->sanitization( $_POST ['title']);
		$musicUpload->description = $musicUpload->sanitization( $_POST ['description']);
		$musicUpload->SendAllToDB( $file_name,"Music");
	}
}
?>
<html>
<head>
<!--Style css-->

<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/css/fontello.css" type="text/css">
<link rel="stylesheet" href="css/UploadInput.css" type="text/css">


<!--Fonts-->
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
			href="filmy.php">
			<div class="menu">Filmy</div>
		</a> <a href="img.php"><div class="menu">Zdjecia</div></a> <a
			href="wyloguj.php"><div class="menu">Wyloguj się</div></a>

	</div>
	<main>
	<div id="containerForinput">
		<form method="post" name="Uploadflm" enctype="multipart/form-data">
			<input type="file" value="Poszukaj pliku" name="file"
				accept="audio/*"> <br /> <input type="text" name="title"
				placeholder="Tytół" maxlength="30"><br /> <input type="text"
				name="description" placeholder="opis" maxlength="60"><br /> <input
				type="submit" value="Wyslij Plik">
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

