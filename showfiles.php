<?php
abstract class File
{
private $type_file;
protected $result;
protected $connect;
protected $array_witch_result;
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
function HowMutchFiles($query)
{
	$this->result = $this->connect->query( $query);
	return $this->result->num_rows;
}
function TakeResult()
{
	$i = 0;
	
	while($row = $this->result->fetch_assoc())
	{
		$this->array_witch_result [$i] = $row;
		$i++;
	}
}
function __destruct()
{
	$this->result->free();
	$this->connect->close();
}
public abstract function ShowFiles($id_file, $id_user);
}
class film extends File
{
public function ShowFiles($id_file, $id_user)
{
	$src = "Upload/" . $id_user . "/filmy" . "/" . $this->array_witch_result [$id_file] ['file_name'];
	echo '<div style="width:640px;height:400px;margin-left:auto;margin-right:auto;"><video src="' . $src . '" type="video/mp4" class="video" controls></video></div><br/>';
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
	echo '<div class="formContainer">';
	echo '<form action="delete.php" method="POST">';
	echo '<input type="hidden" name="id_img" value="' . $this->array_witch_result [$id_file] ['id'] . '">';
	$source = "Upload/" . $id_user . "/img" . "/" . $this->array_witch_result [$id_file] ['file_name'];
	echo '<input type="hidden" name="opis" value="' . $this->array_witch_result [$id_file] ['comment'] . '">';
	echo '<input type="hidden" name="source" value="' . $source . '">';
	echo '<input type="hidden" name="file_name" value="' . $this->array_witch_result [$id_file] ['file_name'] . '">';
	
	echo '<div class="img"><div class="TestName">';
	if($this->array_witch_result [$id_file] ['place'] != "")
	{
		echo "Miejsce:&nbsp" . str_replace( " ","&nbsp",$this->array_witch_result [$id_file] ['place']) . "<br/>";
	}
	
	if($this->array_witch_result [$id_file] ['comment'] != "")
	{
		echo "Opis:&nbsp" . str_replace( " ","&nbsp",$this->array_witch_result [$id_file] ['comment']) . "<br/>";
	}
	
	if($this->array_witch_result [$id_file] ['Name'] != "")
	{
		echo "Miejsce:&nbsp" . str_replace( " ","&nbsp",$this->array_witch_result [$id_file] ['Name']) . "<br/>";
	}
	
	if($this->array_witch_result [$id_file] ['date'] != "0000-00-00")
	{
		echo "Data:&nbsp" . str_replace( " ","&nbsp",$this->array_witch_result [$id_file] ['date']) . "<br/>";
	}
	
	echo '<form action="delete.php" onclick=' . 'confirm("Czy naperno chcesz usunąć to zdjecie")' . ' method="POST">
        		<button type="submit">
          		<i style="font-size:48px;" class="demo-icon icon-trash-empty" > </i>
        		</button>';
	echo '<input type="hidden" name="id_file" value="' . $this->array_witch_result [$id_file] ['id'] . ' ?>">';
	echo '<input type="hidden" name="file_name" value="' . $this->array_witch_result [$id_file] ['file_name'] . '?>">';
	echo '<input type="hidden" name="whereIsFileToDelete" value="img"></form>';
	echo "</div>";
	echo '<img class="img_size"  src="' . $source . '" />  </div>';
	echo "</form>";
	echo "</div>";
}
}

?>