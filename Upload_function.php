<?php


class UploadFile 
{
//atrybuty
public $concent_type;
public $file_type;
public $tmp_file_name;
public $file_name;
public $file_size;
public $error_verify;
public $error_move_to_folder;
public $good=true;
//metody

public function size($sizeInBytes)
{
	if(filesize($this->tmp_file_name)>=$sizeInBytes)
	{
		$this->good;
		return "Ten plik za dużo waży!";		
	}
}
 public function LoadVariabile($name_array)
 {
   $this->tmp_file_name=$_FILES[$name_array]['tmp_name'];
   $this->file_name=$_FILES[$name_array]['name'];
   $this->file_size=$_FILES[$name_array]['size'];

 }
 //---------------
 public function CheckTypeFile($tmp_name)//and size
 {
    $info=new finfo(FILEINFO_MIME);
 	$this->concent_type=$info->buffer(file_get_contents($tmp_name));
 	$pathinfo=pathinfo($this->file_name,PATHINFO_EXTENSION);
   $this->file_type=$pathinfo;
   $this->file_size=filesize($tmp_name);


 }
 //---------------
 public function VerifyFile($type)
 {
 	
$obj= new Strategy();
$obj->setType($type);
if($obj->getType()->CheckFile($this->file_type,$this->concent_type)==false)
{
if($type=="audio")$this->error_verify="Tu możesz dodać tylko pliki mp3!";
else if(type=="image")$this->error_verify="Tu możesz dodać tylko pliki jpg jpeg png gif!";
else $this->error_verify="To nie jest plik wideo";
		
$this->good=false;
}
 }
 //---------------
 public function MoveFile($tmp_path,$path)
 {
 	if($this->good==true)
 	{
 		
	chmod($tmp_path,0777);
	move_uploaded_file($tmp_path,$path);
 	}
 }
 //---------------
 public function ElseNameNIW($name,$id,$where)
 {
 	$i=0;
	$this->file_name=md5($name).".".$this->file_type;
	require_once ("ConnectSQL.php");
	$return=SQLConnect("SELECT * FROM $where WHERE file_name='".$this->file_name."' AND '".$id."'");
	if ($return != false) 
	{
            if ($return->num_rows > 0) 
            {
                while ($return->num_rows > 0) 
                {

                    $i++;
                    $this->file_name = $i . $this->file_name;
                    $return = SQLConnect("SELECT * FROM img WHERE file_name='" . $this->file_name . "' AND '" . $id . "'");
                }
            }
            $return->free();
            
        }
	
 }

 public function VerifyText($text_to_verify,$how_much_characters)
 {
   $save_text=htmlentities($text_to_verify);

   if(($save_text!=$text_to_verify)&&(strlen($save_text)<=$how_much_characters))
   {
   	return array ($save_text,true);
   }
   else{


   	return $save_text;
   }
 }
 //---------------
 function GetSize($name_file)
 {
 	$size=getimagesize($name_file);
 	if(!$size)
 	{
 	return "to nie jest zdjecie";
 	$this->good=false;
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
		if(strlen($date)==10)
		{
		 	if((preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date))||(preg_match("/^[0-9]{4}.(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)))
		 	{
		 		str_replace('%.%', "-",$date);	
		 	}
		}
		else		{
			$this->good=false;
			return 'Zle wpisaleś date sprobuj tak np. "2016.05.12"';
		}
 	}
 		
 	
 	
 }
}



interface file
{
	public function CheckFile($type,$mime);
}
		

class image implements file 
{
	function CheckFile($type,$mime)
	{
		$good=true;
		
            if (($type != "png") && ($type != "gif") && ($type != "jpg") && ($type != "jpeg"))
            	$good=false;
                      
        	if(!strstr($mime, "image"))  
        		$good=false;
        	return $good;
   
	}
    
}
class film implements file
{
	function CheckFile($type, $mime)
	{
		$good=true;
		if ($type!="mp4")
			$good=false;
		if(!strstr($mime, "video"))
			$good=false;
			return $good;
			
	}
}

class audio implements file 
{	
	function CheckFile($type,$mime)
	{
	$good=true;
	
	if ($type != "mp3")  
    	$good=false;
	
    if(!strstr($mime, "audio"))
        $good=false;
        
        return $good;
      
 	}
}
class Strategy 
{
private $strategy;
 
    public function setType($type) {
   
    	 
        switch ($type) {
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
    public function getType() {
        return $this->strategy;
  }
}	


