<?php
session_start();

function returnHome($message) {
  $_SESSION['message'] = $message;
  header('location: ./');
}

function IsNullOrEmptyString($question){
    return (!isset($question) || trim($question)==='');
}

if(isset($_POST['g-recaptcha-response'])) {
  require_once './recaptcha/autoload.php';
  $recaptcha = new \ReCaptcha\ReCaptcha('6Lcj4wkTAAAAAM1DLFAzfyBxE7vT_8PVPnZ-88dQ');
  
  $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
  
  if ($resp->isSuccess()) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    if ((!IsNullOrEmptyString($name)) and (!IsNullOrEmptyString($email)) and (!IsNullOrEmptyString($message))) {
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