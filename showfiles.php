<?php
abstract class File
{
private $type_file;
public $result;
protected $connect;
public $array_witch_result;
public $numrows;
function __construct()
{
	require ("connect.php");
	$this->connect = new mysqli( $host,$user,$pass,$base);
	
	if($this->connect->connect_error)
	{
		echo "Error :" . $this->connect->connect_error;
		exit();
	}
}
public function CheckNumRows()
{
	if($this->result!=false)
		$this->numrows = $this->result->num_rows;
	else $this->numrows=0;
}
function CallToDB($query)
{

	if($this->result=$this->connect->query( $query))
		return true;
}
function TakeResult()
{	
	for($i = 0;$this->numrows > $i;$i++)
	{
		$this->array_witch_result [$i] = $this->result->fetch_assoc();
	}

}
function __destruct()
{
	$this->connect->close();
	if(($this->result!=false)&&($this->result!=NULL))
	$this->result->free();
}
public abstract function ShowFiles($id_file, $id_user);
}
class film extends File
{
public function ShowFiles($id_file, $id_user)
{
	$src = "Upload/" . $id_user . "/filmy" . "/" . $this->array_witch_result [$id_file] ['file_name'];
	echo '
    <div align="center" class="col-xs-9 col-centered" style="width:75%;">
    <video src="' . $src . '" type="video/mp4" class="video" controls></video>
    
    </div><br/>';
}
}
class audio extends File
{
public function ShowFiles($id_file, $id_user)
{
	echo '<div class="music">';
	echo '<form action="delete.php" method="POST">';
	echo '<input type="hidden" name="file_name" value="' . $this->array_witch_result [$id_file] ['file_name'] . '">';
	echo '<input type="hidden" name="id_user" value="' . $id_user . '">';
	echo '<input type="hidden" name="id_file" value="' . $this->array_witch_result [$id_file] ['id'] . '">';
	echo '<input type="hidden" name="whereIsFileToDelete" value="Music">'; // img or Music
	echo '<input type="submit"  value="Usuń">';
	echo "</form>";
	echo '<div class="info">';
	
	if($this->array_witch_result [$id_file] ['title'])
	{
		echo "<br/>Tytuł: " . $this->array_witch_result [$id_file] ['title'];
	}
	
	if($this->array_witch_result [$id_file] ['description'])
	{
		echo "<br/>Opis " . $this->array_witch_result [$id_file] ['description'];
	}
	
	echo '<audio controls>';
	echo '<source src="Upload/' . $id_user . '/muzyka/' . $this->array_witch_result [$id_file] ['file_name'] . '" type="audio/mpeg">';
	echo '</audio>';
	echo '</div>';
}
}
class img extends File
{
public function ShowFiles($id_file, $id_user)
{
	$source = "Upload/" . $id_user . "/img" . "/" . $this->array_witch_result [$id_file] ['file_name'];
	
	echo '<div class="img col-xs-9 col-centered">';
	echo '<img class="img_size"  src="' . $source . '" /> ';  // TEN EFEKT POWIEKSZENIA ZDJECIA TO CSS NIE JS
	echo "</div>";
	echo "<br/>";
}
}

?>