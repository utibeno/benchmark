
<?php

$name_error = $email_error = $subject_error = $message_error = "";
$name = $email = $subject = $message = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $name_error = "Name is required";
  }else{
    $name = test_input($_POST["name"]) ;
    if (!preg_match('/^[a-z0-9 .\-]+$/i', $name)) {
      $name_error = "Only letters and whitespaces allowed";
    }
  }

  if (empty($_POST["email"])) {
    $email_error = "Email is required";
  }else{
    $email = test_input($_POST["email"]);
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $email_error = "Invalid email format";
    }
  }

  if (empty($_POST["subject"])) {
    $subject_error = "Subject is required";
  }else {
    $subject = test_input($_POST["subject"]);
  }

  if (empty($_POST["message"])) {
    $message_error = "Message required";
  }else {
    $message = test_input($_POST["message"]);
  }

  if ($name_error == "" and $email_error == "" and $subject_error == "" and $message_error == "") {
    $email_body = "";
    unset($_POST["submit"]);
    foreach ($_POST as $key => $value) {
      $email_body .= "$key: $value\n";
    }
    $email_from = "info@benchmarkhomecare.com";
    $to = "info@benchmarkhomecare.org.test-google-a.com";
    $email_subject = "New BenchMark HomeCare Form Submission";
    $headers = "From: $email_subject \r\n".
                "Reply-To: $email \r\n";
    if (mail($to,$email_subject,$email_body,$headers)) {
      $success = "Message sent, thank you for contacting us!";
      $name = $email = $subject = $message = "";
    }
  }
}
// header("Location: index.html");
function test_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

 ?>
