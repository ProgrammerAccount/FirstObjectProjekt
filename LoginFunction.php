<?php
class Login
{
  //właściwośći
public  $email;
public  $password;
public  $captcha;
public  $error_captcha="";
public  $error_login="";

  //metody
  function RecaptchaVerify($captcha,$secret_key)
  {

      $res=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
		$response=json_decode($res);

      if(!$captcha)
      {

          $this->error_captcha="Pokaż że nie jestęś robotem!";

      }
      if($response->success==false)
      {
          $this->error_captcha="Pokaż że nie jestęś robotem!";

      }

  }
  function LoginPassVerifyConnect($email,$password)
  {
  	if($this->error_captcha=="")
  	{
  	$email=htmlentities($email);

    //connect
    require('ConnectSQL.php');
  $result=SQLConnect("SELECT * FROM user WHERE email='".$email."'");
      if($result->num_rows>0)
      {
        $arrayWithResult=$result->fetch_assoc();

        if(password_verify($password,$arrayWithResult['pass']))
        {
          $login=true;

          header("Location: home.php");
          return array($arrayWithResult['id'],$arrayWithResult['name'],$login,$email);
        }
        else
        {
         $this->error_login="Nie ma takiego konta.";
        }

      }

      else
      {
         $this->error_login="Nie ma takiego konta.";
      
      }
  }
}
function ShowError()
{
return array ($this->error_captcha,$this->error_login);
}
}



?>


