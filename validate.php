<?php
session_start();

function returnHome($message) {
  $_SESSION['message'] = $message;
  header('location: ./');
}

if(isset($_POST['g-recaptcha-response'])) {
  require_once './recaptcha/autoload.php';
  $recaptcha = new \ReCaptcha\ReCaptcha('6Lcj4wkTAAAAAM1DLFAzfyBxE7vT_8PVPnZ-88dQ');
  
  $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
  
  if ($resp->isSuccess()) {
    
    if ((isset($_POST['name'])) and (isset($_POST['email'])) and (isset($_POST['message']))) {
        mail("ismael.kix2902@gmail.com","Web contact","Name: ".$_POST['name']."\r\nE-mail: ".$_POST['email']."\r\nMessage: ".$_POST['message']);
        
        returnHome("Message sent successfully.");
        
    }else{
        returnHome("Error sending message. All fields are mandatory.");
    }
    
  }else{
    returnHome("Error verifying captcha. Try again later.");
  }
}
?>