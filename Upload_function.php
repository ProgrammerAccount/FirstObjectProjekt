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

 public function LoadVariabile($name_array)
 {
   $this->tmp_file_name=$_FILES[$name_array]['tmp_name'];
   $this->file_name=$_FILES[$name_array]['name'];
   $this->file_size=$_FILES[$name_array]['size'];

 }
 //---------------
 public function CheckTypeFile($tmp_name)//and size
 {
   $this->concent_type=mime_content_type($tmp_name);
   $pathinfo=pathinfo($this->file_name,PATHINFO_EXTENSION);
   $this->file_type=$pathinfo;
   $this->file_size=filesize($tmp_name);


 }
 //---------------
 public function VerifyFile($concent_type,$type)
 {


   if (($this->file_type=="png")||($this->file_type=="gif")||($this->file_type=="jpg")||($this->file_type=="jpeg"))
   {

      if(strstr($concent_type,$type))
      {
      	return true;
      }
      else
      {
      	$this->good=false;

      	return $this->error_verify='<div class="bad">Nasz serwis obsłoguje tylko rozszezenia png,jpeg,jpg,gif</div>';
      }

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
 public function ElseName($name)
 {

    $this->file_name=md5($name).".".$this->file_type;
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
 function test()
 {
 	if($this->good==true) echo "true";
 	if($this->good==false) echo "false";
 	
 	
 }
}



?>
