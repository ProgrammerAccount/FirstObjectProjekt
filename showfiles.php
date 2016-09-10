<?php
abstract class File
{
public $type_file;
protected $result;
protected $connect;
public $how_mutch_films;
protected $array_witch_result;
function ConnectToDB()
{
	require("connect.php");
	$this->connect=new mysqli($host,$user,$pass,$base);
	if($this->connect->connect_error)
	{
		echo "Error :".$this->connect->connect_error;
		exit;
	}
	
}
function HowMutchFiles($query)
{
	$this->result=$this->connect->query($query);
	$this->how_mutch_films=$this->result->num_rows;
	
}
 function  TakeResult()
	{
		$i=0;
	while ($row = $this->result->fetch_assoc())
	{
		$this->array_witch_result[$i]=$row;
		$i++;
	}
}
	public abstract function ShowFiles($id_file,$id_user);
	public abstract function LimitShwoFiles($limitshwofiles);
	
	
	
	
}
 
class audio extends File
{
	public function ShowFiles($id_file,$id_user)
	{
		$src="Upload/".$id_user."/filmy"."/".$this->array_witch_result[$id_file]['file_name'];
		echo '<div style="width:640px;height:400px;margin-left:auto;margin-right:auto;"><video src="'.$src.'" type="video/mp4" class="video" controls></video></div><br/>';
	}
	public function LimitShwoFiles($id_user)
	{
		
	}
}

?>