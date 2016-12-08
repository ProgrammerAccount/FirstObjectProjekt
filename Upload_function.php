<?php
require 'LoginFunction.php';
class UploadFile extends Login
{
// atrybuty
public $concent_type;
public $file_type;
public $tmp_file_name;
public $file_name;
public $file_size;
public $error_verify;
public $error_move_to_folder;
public $good = true;
// metody
public function __construct()
{
	parent::__construct();
}
public function __destruct()
{
	parent::__destruct();
}
public function size($sizeInBytes)
{
	if(filesize( $this->tmp_file_name) >= $sizeInBytes)
	{
		$this->good = false;
		return "Ten plik za dużo waży!";
	}
}
public function LoadVariabile($name_array)
{
	$this->tmp_file_name = $_FILES [$name_array] ['tmp_name'];
	$this->file_name = $_FILES [$name_array] ['name'];
	$this->file_size = $_FILES [$name_array] ['size'];
}
// ---------------
public function CheckTypeFile($tmp_name) // and size
{
	$info = new finfo( FILEINFO_MIME);
	$this->concent_type = $info->buffer( file_get_contents( $tmp_name));
	$pathinfo = pathinfo( $this->file_name,PATHINFO_EXTENSION);
	$this->file_type = $pathinfo;
	$this->file_size = filesize( $tmp_name);
}
// ---------------
public function VerifyTypeFile($type)
{
	$obj = new Strategy();
	$obj->setType( $type);
	if($obj->getType()->CheckFile( $this->file_type,$this->concent_type) == false)
	{
		$this->error_verify = $obj->getType()->ReturnError();
		$this->good = false;
	}
}
// ---------------
public function MoveFile($tmp_path, $path)
{
	if($this->good == true)
	{
		
		chmod( $tmp_path,0777);
		move_uploaded_file( $tmp_path,$path);
	}
}
// ---------------
public function ElseNameNIW($name, $where)
{
	$i = 0;
	$this->file_name = md5( $name) . "." . $this->file_type;
	require_once ("connect.php");
	$return = $this->connect_to_DB->query( "SELECT * FROM $where WHERE file_name='" . $this->file_name . "'");
	
	if($return != false)
	{
		if($return->num_rows > 0)
		{
			while(@$return->num_rows > 0)
			{
				
				$i++;
				$this->file_name = $i . $this->file_name;
				$return = $this->connect_to_DB->query( "SELECT * FROM $where WHERE file_name='" . $this->file_name . "'");
			}
		}
	}
}
public function SanitizationText($text_to_verify, $how_much_characters)
{
	$save_text = htmlentities( $text_to_verify);
	
	if(($save_text != $text_to_verify) && (strlen( $save_text) <= $how_much_characters))
	{
		return array (
				$save_text,
				true 
		);
	}
	else
	{
		
		return $save_text;
	}
}
// ---------------
function GetSize($name_file)
{
	$size = getimagesize( $name_file);
	if(! $size)
	{
		return "to nie jest zdjecie";
		$this->good = false;
	}
	else
	{
		
		return true;
	}
}
function ValideDate($date)
{
	if($date)
	{
		if(strlen( $date) == 10)
		{
			if((preg_match( "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) || (preg_match( "/^[0-9]{4}.(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)))
			{
				str_replace( '%.%',"-",$date);
			}
		}
		else
		{
			$this->good = false;
			return 'Zle wpisaleś date sprobuj tak np. "2016.05.12"';
		}
	}
}
}
interface file
{
public function CheckFile($type, $mime);
public function ReturnError();
}
class image implements file
{
public $good;
function CheckFile($type, $mime)
{
	$this->good = true;
	
	if(($type != "png") && ($type != "gif") && ($type != "jpg") && ($type != "jpeg")) $this->good = false;
	
	if(! strstr( $mime,"image")) $this->good = false;
	return $this->good;
}
// ---------------
function ReturnError()
{
	if($this->good == false)
	{return "Tu możesz dodać tylko pliki jpg jpeg png gif!";}
}
}
class film implements file
{
public $good;
function CheckFile($type, $mime)
{
	$this->good = true;
	if($type != "mp4") $this->good = false;
	if(! strstr( $mime,"video")) $this->good = false;
	return $this->good;
}
// ---------------
function ReturnError()
{
	if($this->good == false)
	{return "Tu możesz dodać tylko pliki jpg jpeg png gif!";}
}
}
class audio implements file
{
public $good;
function CheckFile($type, $mime)
{
	$this->good = true;
	
	if($type != "mp3") $this->good = false;
	
	if(! strstr( $mime,"audio")) $this->good = false;
	
	return $this->good;
}
// ---------------
function ReturnError()
{
	if($this->good == false)
	{return "Tu możesz dodać tylko pliki jpg jpeg png gif!";}
}
}
class Strategy
{
private $strategy;
public function setType($type)
{
	switch($type)
	{
		case "audio":
			$this->strategy = new audio();
			break;
		case "image":
			$this->strategy = new image();
			break;
		case "video":
			$this->strategy = new film();
			break;
	}
}
public function getType()
{
	return $this->strategy;
}
}	


