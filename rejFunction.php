<?php
 class Rejstracja extends Login
 {
	 //wlasciwosci
	public $email;
	public $password;
	public $repeat_password;
	public $name;
	public $good=true;
	public $save_email;
	public $error_email="";
	public $error_password="";
	 //metody
	function VerifyEmial()
	 {
		$save_email=htmlentities($this->email);
		$save_email=filter_var($this->email,FILTER_SANITIZE_EMAIL);
		if($save_email!=$this->email)
		{
			$this->good=false;
			$this->error_email="Ten adres e-mail nie jest poprawny!";
		}
		require("ConnectSQL.php");
		$result=SQLConnect("SELECT * FROM user WHERE email='".$save_email."'");

		if($result->num_rows>0)
		{
			$this->good=false;
			
			$this->error_email="Już jest konto o taki adresie e-mail!";
		}
		else $result->free();
			

	 }
	function VerifyOther()
	 {
		 if(strlen($this->password)<8)
		 {
			 	$this->good=false;
				$this->error_password="Hasło jest za powino zawierać minimalnnie 8 znaków!";
		 }
     else return true;

		  if($this->password!=$this->repeat_password)
		 {
			 	$this->good=false;
				return '<div class="bad">Hasło jest za powino zawierać minimalnnie 8 znaków!</div>';
		 }
     else return true;



	 }
	function ConnectInsert()
	 {
		 if($this->good==true)
		 {
		require("connect.php");
		$connect=new mysqli($host,$user,$pass,$base);
		if($connect->connect_error)
		{
			echo "ERROR :".$connect->connect_errno; exit;
		}
		else
		{
			$this->save_email=$connect->real_escape_string($this->email);
			$this->name=$connect->real_escape_string($this->name);
			$this->name=htmlentities($this->name);

			if($result=$connect->query("INSERT INTO user VALUES(NULL,'".$this->email."','".password_hash($this->password,PASSWORD_DEFAULT)."','".$this->name."','0','0','0',false)"))
			{
        $rezultat=$connect->query("SELECT * FROM user WHERE email='".$this->email."'");
        $array=$rezultat->fetch_assoc();
				$connect->close();
				$rezultat->free();
        return array ($array['id'],$this->email,$this->name);
			}


	 }
	 }
	}
  	function CreateDir($id)
	  {
	    if($this->good==true)
	    {
	    mkdir("Upload/".$id,0777);
	    mkdir("Upload/".$id."/img",0777);
	    mkdir("Upload/".$id."/muzyka",0777);
	    mkdir("Upload/".$id."/filmy",0777);
	
	    fopen("Upload/".$id."/index.php","w+");
	    fopen("Upload/".$id."/img/index.php","w+");
	    fopen("Upload/".$id."/filmy/index.php","w+");
	    fopen("Upload/".$id."/muzyka/index.php","w+");
	    return "true";
	    }
	  }
	  function ReturnErrorPass_Email()
	  {
		  return array ($this->error_password,$this->error_email);
	  }
	
 }
?>
