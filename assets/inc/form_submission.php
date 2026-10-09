<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $action = $_POST['action'] ?? '';

  if ($action === 'subscribe') {
    $email = $_POST["email"] ?? '';
    $subject = "Subject Subscribe Email";
    $to = "recipient@example.com";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-type: text/html\r\n";
    $message = "Subscribe Email " . $email;
    $messageBody = "Email: $email<br>Message: $message";

    echo mail($to, $subject, $messageBody, $headers) ? 'success' : 'error';
  } else {
    $name = $_POST['name'] ?? '';
    $email = $_POST["email"] ?? '';
    $message = $_POST["message"] ?? '';
    $phone = $_POST["phone"] ?? '';
    $subject = "Subject Email";
    $to = "recipient@example.com";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-type: text/html\r\n";
    $messageBody = "Name: $name<br>Email: $email<br>Phone: $phone<br>Message: $message";

    echo mail($to, $subject, $messageBody, $headers) ? 'success' : 'error';
  }
}
