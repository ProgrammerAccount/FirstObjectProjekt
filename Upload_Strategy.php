<?php
interface file
{
	public function CheckFile ();
}




class image extends UploadFile implements file 
{
	function __construct()
	{
	
   if (($this->file_type=="png")||($this->file_type=="gif")||($this->file_type=="jpg")||($this->file_type=="jpeg"))
   {

      if(strstr($this->concent_type,"image"))
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
}



class audio extends UploadFile implements file 
{
	function __construct()
	{
	
   if ($this->file_type=="mp3")
   {

      if(strstr($this->concent_type,"audio"))
      {
      	return true;
      }
      else
      {
      	$this->good=false;

      	return $this->error_verify='<div class="bad">Nasz serwis obsłoguje tylko rozszezenia mp3</div>';
      }
	}
	}
}

class Strategy
{
private $strategy;
 
    public function setType($type) {
        switch ($country) {
            case "audio":
                $this->strategy = new audio();
                break;
            case "image":
                $this->strategy = new image();
                break;
            
        }
    }
    public function getType() {
        return $this->strategy;
  }	
	
	
}
?>