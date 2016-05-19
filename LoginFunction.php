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

      if(!$captcha)
      {

          header("Location: index.php");
          return $_SESSION['recaptcha']='<div class="bad">Pokaż że nie jestęś robotem!</div>';
          exit;
      }
      if($res.success==false)
      {
          $_SESSION['recaptcha']='<div class="bad">Pokaż że nie jestęś robotem!</div>';
          header("Location: index.php");
          exit;
      }

  }
  function LoginPassVerifyConnect($email,$password)
  {
    $email=htmlentities($email);

    //connect
    require('connect.php');
    $connect=new mysqli($host,$user,$pass,$base);
    $email=$connect->real_escape_string($email);
    if($connect->connect_error)
    {
      echo "ERROR :".$connect->connect_errno;
    }
    else
    {

    if($result=$connect->query("SELECT * FROM user WHERE email='".$email."'"))
    {
      $connect->close();
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
          $_SESSION['b_email']='<div class="bad">Nie ma takiego konta.</div>';
          header("Location: index.php");
        }

      }
      else
      {
      $_SESSION['b_email']='<div class="bad">Nie ma takiego konta.</div>';
      header("Location: index.php");
      }
  }
}
}
}

?>
