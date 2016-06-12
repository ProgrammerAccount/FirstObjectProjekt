<?php
class Login
{
  //właściwośći
public  $email;
public  $password;
public  $captcha;
public  $error_captcha;

  //metody
  function RecaptchaVerify($captcha,$secret_key)
  {

      $res=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
		$response=json_decode($res);

      if(!$captcha)
      {

          header("Location: index.php");
          $this->error_captcha="Pokaż że nie jestęś robotem!";
          exit;
      }
      if($response->success==false)
      {
          $this->error_captcha="Pokaż że nie jestęś robotem!";
          header("Location: index.php");
          exit;
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
        $array=$result->fetch_assoc();

        if(password_verify($password,$array['pass']))
        {
          $login=true;

          header("Location: home.php");
          return array($array['id'],$array['name'],$login,$email);
        }
        else
        {
         return "Nie ma takiego konta.";
          header("Location: index.php");
        }

      }

      else
      {
      return "Nie ma takiego konta";
      header("Location: index.php");
      }
  }
}
}



?>
